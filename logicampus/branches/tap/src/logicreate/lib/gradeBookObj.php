<?
	class GradeBookObj {
		

		# Key in database
		var $id_class_gradebook;

		# Class ID of Gradebook you wish to view
		var $id_classes;

		# Set to Either Weighted or Points
		# 1 = Weighted
		# 2 = Points
		var $calculation_type = 1;

		# Grading scale information
		var $a_upper;
		var $a_lower;
		var $b_upper;
		var $b_lower;
		var $c_upper;
		var $c_lower;
		var $d_upper;
		var $d_lower;
		var $f_upper;

		# Array of objects of categories
		var $categories = array();

		# Load a gradebook 
		# Constructor
		# Pass it the active class ID
		function GradeBookObj($id_classes)
		{
			$db = DB::getHandle();
			$sql = "SELECT * from class_gradebook where id_classes = '$id_classes'";
			$db->RESULT_TYPE = MYSQL_ASSOC;
			$db->queryOne($sql);
			while(list ($k, $v) = @each($db->Record))
			{
				$this->$k = $v;
			}
			
			# Load up the categories for the gradebok
			$this->categories = $this->getAllCategories($id_classes);
		}

		function getAllCategories($id_classes)
		{
			$sql = "SELECT id_class_gradebook_categories as id, label, weight, id_classes from class_gradebook_categories where
			id_classes ='$id_classes'";	
			$db = DB::getHandle();
			$db->RESULT_TYPE = MYSQL_ASSOC;
			$db->query($sql);
			while($db->next_record() ) 
			{
				 $cats[$db->Record['id']] = GBCategory::loadFromArray($db->Record);
			}
			return $cats;

		}
		
		# Returns a value of a category
		# object that is passed to it based
		# on the id passed.
		function getCategoryInfo($id, $field)
		{
			return $this->categories[$id][$field];
		}


		# Pass an array of GBVal objects
		function getCurrentAverage($entries)
		{
			debug($entries);
			# How many possible points we do have?
			$total_points = $this->getTotalPossiblePoints();
			if ($this->calculation_type == 1)
			{
				# calculate based on weight (%)
					
				return $avg;
			}  else 
			{
				# calculate based on points
				return $avg;
			}
		}

		# Loop through the categoriee and
		# return the total number of possible
		# points (or weigths).
		function getTotalPossiblePoints()
		{
			while(list($k, $v) = @each($this->categories) )	
			{
				$x += $v->weight;
			}
			return $x;

		}
	}


	

	class GBCategory {
	
		# Either the percent or the total number of points for this category
		var $weight;

		# Pkey for database
		var $id;

		# The name of the category
		var $label;

		# main class ID
		var $id_classes;

		# Returns object
		# Passed it the database pkey 
		# and the current active class
		# Returns false if user doesn't have access
		function getByPkey($id, $id_classes)
		{
			# We have to have this for security purposes
			# if we don't get one for some reason we don't do 
			# anything.
			if (!$id_classes)
			{
				return false;
			}
			$db = DB::getHandle();
			$db->RESULT_TYPE = MYSQL_ASSOC;
			$sql = "SELECT class_gradebook.calculation_type, class_gradebook_categories.* from class_gradebook_categories INNER JOIN class_gradebook ON class_gradebook.id_classes=class_gradebook_categories.id_classes where class_gradebook_categories.id_class_gradebook_categories='$id'"; 
			
			$db->queryOne($sql);
			$x = GBCategory::loadFromArray($db->Record);
			if ($x->id_classes == $id_classes)
			{	
				return $x;
			} else {
				return false;
			}
		}

		function loadFromArray($category)
		{
			$x = new GBCategory();
			$x->weight = $category['weight'];
			$x->id = $category['id_class_gradebook_categories'];
			$x->label = $category['label'];
			$x->id_classes = $category['id_classes'];
			return $x;
		}

		# Returns True or False
		# Depending if the save worked
		# Will return a fatal error if missing data
		function save()
		{
			if (!$this->id_classes)
			{
				die("A fatal error occured.  We cannot save the request.  
					There was no class ID given to us. ");	
			}
			$db = DB::getHandle();


			# Check if the category weight is going to be over 100% 
			# if they are using weighted grading
		
			$this->getCalculationType();
			if ($this->calculation_type == '')
			{
				$this->error = "You do not have an active class ID.
				Please return to the main page of your Classroom
				Manager and try again.  If you continue to receive
				this error, please contact the help desk.";
				return false;
			}

			if ($this->calculation_type == 1) # one is weighted
			{
					$sql = "SELECT SUM(weight) FROM class_gradebook_categories
					WHERE id_classes='".$this->id_classes."' AND 
					id_class_gradebook_categories !='".$this->id."'";
					$db->queryOne($sql);
					$sum = $db->Record[0];
					if ( ($sum + $this->weight) > 100)
					{
						$this->error = "Your current total of percentages is
						<b>$sum%</b>.  If we add another <b>".$this->weight."%</b> as you requested, the total of these weights will be greater than 100%.  Please double check your calculation, or adjust another category."; 
						return false;
					}
			}

			if ($this->id)
			{
				$addid = ", id_class_gradebook_categories ='".$this->id."'";
			} 
			$sql = "replace into class_gradebook_categories set
				label='".$this->label."', weight='".$this->weight."',  
				id_classes='".$this->id_classes."' $addid"; 
			$db->query($sql);
			if (!$db->errorMessage)
			{
				return true;
			} else {
				return false;
			}
		}

		function getCalculationType()
		{
			if ($this->id_classes)
			{
				$db = DB::getHandle();
				$sql = "SELECT calculation_type FROM class_gradebook WHERE
				id_classes='$this->id_classes'";
				$db->queryOne($sql);
				$this->calculation_type =
				$db->Record['calculation_type'];
			}

		}

		# Static function to return an array
		# of categories based on an id_classes
		function getAllCategories ($id_classes)
		{
			$sql = "SELECT id_class_gradebook_categories, label FROM
			class_gradebook_categories where
			id_classes='$id_classes' ORDER BY label ASC";

			$db = DB::getHandle();
			$db->query($sql);
			while ($db->next_record() )
			{
				$tmp[$db->Record['id_class_gradebook_categories']] =
				$db->Record['label'];	
			}
			return $tmp;
		}

	}

	class GBEntry {
		
		var $total_points;
		var $title;
		var $gradebook_code;
		var $id;
		var $id_classes;
		var $category;
		# Total number of entries;
		var $sum;

		function loadAllEntries($id_classes)
		{
			if ($id_classes == '')
			{
				die("A fatal error occured.  We cannot save the request.  
					There was no class ID given to us. ");	
			}
		
			$db = DB::getHandle();
			$db->RESULT_TYPE = MYSQL_ASSOC;
			$sql = "select * from class_gradebook_entries where
			id_classes='$id_classes'";

			$db->query($sql);
			while($db->next_record() )
			{
				$x = new GBEntry();
				$x->id = $db->Record['id_class_gradebook_entries'];
				$x->title = $db->Record['title'];
				$x->gradebook_code = $db->Record['gradebook_code'];
				$x->total_points = $db->Record['total_points'];
				$x->id_classes = $db->Record['id_classes'];
				$temp[$db->Record['id_class_gradebook_entries']] = $x;

			}
			return $temp;
		}
		
		function loadFromArray($entry)
		{
			$x = new GBEntry();
			$x->title= $entry['title'];
			$x->id = $entry['id_class_gradebook_entries'];
			$x->label = $entry['gradebook_code'];
			$x->id_classes = $entry['id_classes'];
			$x->total_points = $entry['total_points'];
			$x->category = $entry['category'];
			$x->gradebook_code = $entry['gradebook_code'];
			$x->comments = $entry['comments'];
			return $x;
		}

		# Returns True or False
		# Depending if the save worked
		# Will return a fatal error if missing data
		function save()
		{
			if ($this->id_classes =='')
			{
				die("A fatal error occured.  We cannot save the request.  
					There was no class ID given to us. ");	
			}
			$db = DB::getHandle();
		
			if ($this->checkPermission() )
			{

					if ($this->id)
					{
						$addid = ", id_class_gradebook_entries='".$this->id."'";
					} 
					$sql = "replace into class_gradebook_entries set
						id_class_gradebook_categories='".$this->category."', gradebook_code='".$this->gradebook_code."',  id_classes='".$this->id_classes."',
						total_points='".$this->total_points."' $addid"; 
					$db->query($sql);
					if (!$db->errorMessage)
					{
						return true;
					} else {
						return false;
					}
			} else {
				$this->error = "You do not have permission to update
				this record.";
				return false;
			}
		}

		# Returns object
		# Passed it the database pkey 
		# and the current active class
		# Returns false if user doesn't have access
		function getByPkey($id, $id_classes)
		{
			# We have to have this for security purposes
			# if we don't get one for some reason we don't do 
			# anything.
			if (!$id_classes)
			{
				return false;
			}
			$db = DB::getHandle();
			$db->RESULT_TYPE = MYSQL_ASSOC;
			$sql = "SELECT * FROM class_gradebook_entries where id_class_gradebook_entries='$id' AND id_classes='$id_classes'"; 
			$db->queryOne($sql);
			$x = GBEntry::loadFromArray($db->Record);
			if ($x->id_classes == $id_classes)
			{	
				return $x;
			} else {
				return false;
			}
		}
	
		# Checks to see if the user actually owns 
		# The record or not.
		function checkPermission()
		{
			$db = DB::getHandle();
			$sql = "SELECT count(*) as count from
			class_gradebook_entries WHERE
			id_class_gradebook_entries='".$this->id."'
			AND id_classes='".$this->id_classes."'";
			$db->queryOne($sql);

			if ($db->Record['count'] == 1)
			{
				return true;
			}
			return false;
		}


	}


	class GBVal {

		# Date record was created
		var $dateCreated;

		# Comments associated with this value
		var $comments;
		
		# category object this grade is in
		var $category;

		# the students score
		var $score;

		# the studuents username
		var $username;

		# the id of the class the student is taking
		var $id_classes;

		# entry id
		var $id_entry;

		# the record id
		var $id;

		# Loads up an object of grades for a student
		function getAllByUsername($username, $id_classes)
		{
			$db = DB::getHandle();
			$sql = '
			SELECT A.*, B.*, C.*
			FROM class_gradebook_val as A
			INNER JOIN class_gradebook_entries AS B
            	ON
				A.id_class_gradebook_entries=B.id_class_gradebook_entries
			INNER JOIN class_gradebook_categories AS C
			    ON
				B.id_class_gradebook_entries=C.id_class_gradebook_categories
			WHERE A.username=\''.$username.'\'
			AND A.id_classes=\''.$id_classes.'\'
			ORDER BY A.dateCreated ASC
			';
echo $sql;			
			$db->query($sql);
			while($db->next_record() )
			{
				$gbVal[$db->Record['id_class_gradebook_val']] = GBVal::loadFromArray($db->Record);
				$gbVal[$db->Record['id_class_gradebook_val']]->entry = GBEntry::loadFromArray($db->Record);
				$gbVal[$db->Record['id_class_gradebook_val']]->category
				= GBCategory::loadFromArray($db->Record);
			}
			return $gbVal;
		}

		function loadFromArray($entry)
		{
			$x = new GBVal();
			$x->id = $entry['id_class_gradebook_val'];
			$x->id_classes = $entry['id_classes'];
			$x->username = $entry['username'];
			$x->score = $entry['score'];
			$x->id_entry= $entry['id_class_gradebook_entries'];
			$x->comments = $entry['comments'];
			$x->dateCreated = $entry['dateCreated'];
			return $x;
		}

	}

?>
