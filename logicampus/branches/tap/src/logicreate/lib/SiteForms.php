<?

	/******
	 * The following class was written to hold various specific 
	 * form fields for the Distance Learning Site.
	 * Sample forms include courseFamily, courseNumber, courseFamilyNumber
	 * and others. 
	 *
	 * Example:
	 * include(LIB_PATH.'LC_form.php');
	 * $f = new SiteForm();
	 * $f->getForm(1000038);
	 ******/
	 	
	if (!class_exists('form'))
	{
		include_once('LC_form.php');
	}
	 
	class SiteForm extends Form 
	{
		# Define properties for various tables
		# in case they change later on
		var $courses_table = 'courses';
		var $courseFamily = 'courseFamily';
		var $courseNumber = 'courseNumber';
		var $groups_table = 'lcGroups';
		var $semester_table = 'semesters';
		var $faculty_table = 'semesters';
		
		# Table for class faqs
		var $faq_table = 'class_faqs';
		var $faqCat = 'category';
		var $fieldPermissions = false;		
		var $db; # DATABASE HANDLE

		function SiteForm($groups='')
		{
			$db = DB::getHandle();
			$this->db =& $db;
			parent::form($groups);			
		}
		
		# Main Function called for courses
		# This function calls the appropiate helper
		# function which renders the drop down
		
		function customFieldToHTML($v)
		{
			#echo 'im here';
			if ($v['extra'] != '')
			{
				$func = $v['extra'].'ToHTML';
				$HTML = $this->$func($v);
				return $HTML;
			} else {
				die("I don't know which course form field to build.  Please contact the webmaster that you received this error and which page 
				you received it on.");
			}
			
		}
		
		/*
		 * Returns a select box of distinct course Families
		 */
		function courseFamilyToHTML($v)
		{
			$sql = "select distinct({$this->courseFamily}) from {$this->courses_table}";
			$this->db->query($sql);
			while($this->db->next_record() )
			{
				$arr[$this->db->Record["{$this->courseFamily}"]] = $this->db->Record["{$this->courseFamily}"].'='.$this->db->Record["{$this->courseFamily}"];
			}
			#debug($arr, 1);
			$v['selectOptions'] = @implode($arr, ",");
			#debug($v, 1);
			$HTML = $this->selectToHTML($v);			
			return $HTML;
		}

		/*
		 * Returns a select box of distinct course numbers
		 */
		function courseNumberToHTML($v)
		{
			$sql = "select distinct({$this->courseNumber}) from {$this->courses_table}";
			$this->db->query($sql);
			while($this->db->next_record() )
			{
				$arr[$this->db->Record["{$this->courseNumber}"]] = $this->db->Record["{$this->courseNumber}"].'='.$this->db->Record["{$this->courseNumber}"];
			}
			
			$v['selectOptions'] = @implode($arr, ",");
			#debug($v, 1);
			$HTML = $this->selectToHTML($v);						
			return $HTML;
		}
		
		function courseFamilyNumberToHTML($v)
		{
			$sql = "select id_courses, {$this->courseNumber}, {$this->courseFamily} from {$this->courses_table}";
			$this->db->query($sql);
			while($this->db->next_record() )
			{
				$arr[$this->db->Record['id_courses']] = $this->db->Record['id_courses'].'='.$this->db->Record["{$this->courseFamily}"].$this->db->Record["{$this->courseNumber}"];
			}
			
			$v['selectOptions'] = @implode($arr, ",");
			#debug($v, 1);
			$HTML = $this->selectToHTML($v);						
			return $HTML;		
		}		
		
		# Displays all courses in Drop down
		function allCoursesToHTML($v)
		{
			$sql = "select id_courses, courseName, courseDescription, {$this->courseNumber}, {$this->courseFamily} from {$this->courses_table} ORDER BY courseFamily ASC";
			$this->db->query($sql);
			while($this->db->next_record() )
			{
				$arr[$this->db->Record['id_courses']] = $this->db->Record['id_courses'].'='. $this->db->Record["{$this->courseFamily}"].$this->db->Record["{$this->courseNumber}"].' ('.$this->db->Record['courseName'].')';
			}
			
			$v['selectOptions'] = @implode($arr, ",");
			#debug($v, 1);
			$HTML = $this->selectToHTML($v);						
			return $HTML;				
		}
		
		# Displays all courses in Drop down
		function coursesToHTML($v)
		{
			$sql = "select id_courses, courseDescription, {$this->courseNumber}, {$this->courseFamily} from {$this->courses_table}";
			$this->db->query($sql);
			while($this->db->next_record() )
			{
				$arr[$this->db->Record['id_courses']] = $this->db->Record['id_courses'].'='.$this->db->Record['courseDescription'].' ('.$this->db->Record["{$this->courseFamily}"].$this->db->Record["{$this->courseNumber}"].')';
			}
			
			$v['selectOptions'] = @implode($arr, ",");
			#debug($v, 1);
			$HTML = $this->selectToHTML($v);						
			return $HTML;				
		}

		
		# Displays all courses in Drop down
		function linkCategoriesToHTML($v)
		{
			global $lcUser;
			include_once(LIB_PATH. 'Tree.php');
			
			$sql = 'select id_class_links_categories, id_class_links_categories_parent, txTitle as name from class_links_categories where id_classes="'.$lcUser->activeClassTaught->id_classes.'" order by id_class_links_categories_parent ASC';
			$this->db->query($sql);
			$this->db->RESULT_TYPE = MYSQL_ASSOC;
			$arr = array();
			while($this->db->next_record() )
			{
				$arr[] = $this->db->Record;
			}
			
			if ($v['message'] != '')
			{	$msg = '<div style="font-size=80%;">'.$v['message'].'</div>';
			} 
			if ($v['multiple'] == 'Y') 
			{	$x = '[]';
				$multiple = 'multiple';
			}
			
			$HTML = '<tr><td valign="'.$this->lvalign.'" class="'.$this->cssLeft.'">'.$ast.$v['displayName'].'</td><td valign="'.$this->rvalign.'" class="'.$this->cssRight.'">';
			$HTML .= '<select id="'.$v['fieldName'].''.$x.'" name="'.$v['fieldName'].''.$x.'" '.$multiple.' size="'.$v['size'].'">';
			
			reset($arr);
			$tree = new TreeList();
			$tree->keyName = 'id_class_links_categories';
			$tree->keyParentName = 'id_class_links_categories_parent';
		
			$tree->loadData($arr);
			$view = new ListView($tree);
			$HTML .= $view->renderAsOptions($v['defaultValue']);
			
			
			$HTML .= '</select>';
			$HTML .= $msg.'</td></tr>';

			//debug($v);
			$v['selectOptions'] = @implode($arr, ",");
			#debug($v, 1);
			//$HTML = $this->selectToHTML($v);
			
			return $HTML;				
		}
		
		# Displays all courses in Drop down
		function linkCategoriesWithTopToHTML($v)
		{
			global $lcUser;
			include_once(LIB_PATH. 'Tree.php');
			
			$sql = 'select id_class_links_categories, id_class_links_categories_parent, txTitle as name from class_links_categories where id_classes="'.$lcUser->activeClassTaught->id_classes.'" order by id_class_links_categories_parent ASC';
			$this->db->query($sql);
			$this->db->RESULT_TYPE = MYSQL_ASSOC;
			$arr = array();
			while($this->db->next_record() )
			{
				$arr[] = $this->db->Record;
			}
			
			if ($v['message'] != '')
			{	$msg = '<div style="font-size=80%;">'.$v['message'].'</div>';
			} 
			if ($v['multiple'] == 'Y') 
			{	$x = '[]';
				$multiple = 'multiple';
			}
			
			$HTML = '<tr><td valign="'.$this->lvalign.'" class="'.$this->cssLeft.'">'.$ast.$v['displayName'].'</td><td valign="'.$this->rvalign.'" class="'.$this->cssRight.'">';
			$HTML .= '<select id="'.$v['fieldName'].''.$x.'" name="'.$v['fieldName'].''.$x.'" '.$multiple.' size="'.$v['size'].'">';
			$HTML .= '<option value="0" SELECTED>[Top Level Category] (no parent)</option>';			
			reset($arr);
			$tree = new TreeList();
			$tree->keyName = 'id_class_links_categories';
			$tree->keyParentName = 'id_class_links_categories_parent';
		
			$tree->loadData($arr);
			$view = new ListView($tree);
			$HTML .= $view->renderAsOptions($v['defaultValue']);
			
			
			$HTML .= '</select>';
			$HTML .= $msg.'</td></tr>';

			//debug($v);
			$v['selectOptions'] = @implode($arr, ",");
			#debug($v, 1);
			//$HTML = $this->selectToHTML($v);
			
			return $HTML;				
		}
			
		# id is the key and the value
		# is "Spring 2000"
		function semesterToHTML($v)
		{
			// I don't think this is right..
			$a_semester = array('Fall'=>'Fall', 'Winter'=>'Winter', 'Spring'=>'Spring', 'Summer'=>'Summer', 'Summer Mini'=>'Summer Mini', 'Summer I'=>'Summer I', 'Summer II'=>'Summer II', 'Spring Mini'=>'Spring Mini', 'Fall Mini'=>'Fall Mini', 'Winter Mini'=>'Winter Mini');
			$sql = "select id_semesters, semesterTerm, semesterId, semesterYear from semesters order by semesterYear DESC";
			$this->db->query($sql);
			while($this->db->next_record() )
			{
				$arr[$this->db->Record['id_semesters']] = $this->db->Record['id_semesters'].'='.$a_semester[$this->db->Record['semesterTerm']].' '.$this->db->Record['semesterYear'];
			}
			
			$v['selectOptions'] = @implode($arr, ",");
			#debug($v, 1);
			$HTML = $this->selectToHTML($v);						
			return $HTML;							
		}
		
		/**
		 *	Show semesters that the faculty have classes to manage
		 *	along with the number of classes they have available in each semester
		 *
		 */
		# id is the key and the value
		# is "Spring 2000"
		function semesterFacultyToHTML($v)
		{
			global $lcUser;
			
			$arr = array();
			$a_semester = array('Fall'=>'Fall', 'Winter'=>'Winter', 'Spring'=>'Spring', 'Summer'=>'Summer', 'Summer Mini'=>'Summer Mini', 'Summer I'=>'Summer I', 'Summer II'=>'Summer II', 'Spring Mini'=>'Spring Mini', 'Fall Mini'=>'Fall Mini', 'Winter Mini'=>'Winter Mini');
			
			$sql = 'SELECT COUNT( B.id_classes ) AS count_classes, A.id_semesters, A.semesterTerm, A.semesterId, A.semesterYear
					FROM semesters AS A
					INNER JOIN classes AS B ON A.id_semesters = B.id_semesters
					WHERE B.facultyId = \''. $lcUser->username. '\' AND A.dateAccountActivation <=NOW()
					GROUP BY B.id_semesters
					ORDER BY A.semesterYear';
			
			// @@@ Now i need to know if we are to show semesters that have been deactivated?
			$this->db->query($sql);
			while($this->db->next_record() )
			{
				$arr[$this->db->Record['id_semesters']] = $this->db->Record['id_semesters'].'='.'[ '. $this->db->Record['count_classes']. ' ] '. $a_semester[$this->db->Record['semesterTerm']].' '.$this->db->Record['semesterYear'];
			}
			
			if (count($arr) == 0)
			{	// nothing found
				$arr[0]='0=No Semesters Available';
			}
			$v['selectOptions'] = @implode($arr, ",");
			#debug($v, 1);
			$HTML = $this->selectToHTML($v);						
			return $HTML;							
		}


		# Returns the html for a select widget containing the class objectives (adam)
		function selectClassObjectivesToHTML($v)
		{
			global $lcUser;

			if ( LESSON_ID ) {

				// Get all objectives for the active class and the active lesson. These will
				// be selected by default in the list.
				$sql = "SELECT class_lesson_objectives.id_class_objectives 
					FROM class_objectives
					INNER JOIN class_lesson_objectives 
					ON class_lesson_objectives.id_class_objectives=
						class_objectives.id_class_objectives
					WHERE (class_objectives.id_classes='{$lcUser->activeClassTaught->id_classes}'
					AND class_lesson_objectives.id_class_lesson='".LESSON_ID."')";

				$this->db->query($sql);
				while ($this->db->next_record()) {
					$selected[] = $this->db->Record['id_class_objectives'];
				}
			
			}

			// Get all objectives for the active class that are currently linked to a lesson
			// that is not the current one. These will be prepended with a '*' in the list.
			$sql = "select class_objectives.id_class_objectives from class_objectives
				LEFT JOIN class_lesson_objectives as b 
					ON class_objectives.id_class_objectives=b.id_class_objectives
				where (id_classes='{$lcUser->activeClassTaught->id_classes}'
				and b.id_class_lesson != '".LESSON_ID."'
				and b.id_class_lesson is not null)";
				//echo $sql;

			$this->db->query($sql);
			$starred = array();
			while ($this->db->next_record()) {
				$starred[] = $this->db->Record['id_class_objectives'];
			}

			// Get ALL objectives for the active class
			$sql = "select id_class_objectives, objective from class_objectives
				where id_classes='{$lcUser->activeClassTaught->id_classes}'";
			$this->db->query($sql);
			while ($this->db->next_record()) {
				if (strlen($this->db->Record['objective']) > 75) {
					$this->db->Record['objective'] = htmlentities(substr($this->db->Record['objective'],0,75), ENT_QUOTES) . '...';
					$this->db->Record[1] = htmlentities(substr($this->db->Record[1],0,75), ENT_QUOTES);
				}
				$arr[$this->db->Record['id_class_objectives']] =
					 $this->db->Record['id_class_objectives'].'='
					.(@in_array($this->db->Record['id_class_objectives'], $starred) ? '**' : '')
					.str_replace(',', '&#44;', $this->db->Record['objective']);
			}
			
			$v['selectOptions'] = @implode($arr, ',');
			$v['defaultValue'] = $selected;
			return $this->selectToHTML($v);
		}


		# Returns the html for a select widget containing the class assignments (adam)
		function selectClassAssignmentsToHTML($v)
		{
			global $lcUser;

			if ( LESSON_ID ) {

				// Get all assignments for the active class and the active lesson. These will
				// be selected by default in the list.
				$sql = "select a.id_class_assignments from class_assignments_link as l
					left join class_assignments as a on a.id_class_assignments=l.id_class_assignments
					where l.id_class_lessons='".LESSON_ID."'
					and a.id_classes='{$lcUser->activeClassTaught->id_classes}'";
				$this->db->query($sql);
				while ($this->db->next_record()) {
					$selected[] = $this->db->Record['id_class_assignments'];
				}

			}

			// Get ALL assignments for the active class
			$sql = "select id_class_assignments, title
				from class_assignments
				where id_classes='{$lcUser->activeClassTaught->id_classes}'";
			$this->db->query($sql);
			$arr[0] = '0=None';
			while ($this->db->next_record())
			{
				$arr[$this->db->Record['id_class_assignments']] =
					$this->db->Record['id_class_assignments']
					.'='.$this->db->Record['title'];
			}

			// If there aren't any selected options, make 'None' selected
			if (count($selected) == 0) $selected[] = 0;

			$v['selectOptions'] = @implode($arr, ',');
			$v['defaultValue'] = $selected;
			return $this->selectToHTML($v);
		}

		# Returns the html for a select widget containing the available content (adam)
		function selectClassContentToHTML($v)
		{
			global $lcUser;

			$sql = "select id_class_lesson_content, txTitle from class_lesson_content
				where id_classes='{$lcUser->activeClassTaught->id_classes}'
				and (id_class_lessons is null or id_class_lessons='".LESSON_ID."')";
			$this->db->query($sql);
			while ($this->db->next_record()) {
				$arr[$this->db->Record['id_class_lesson_content']] =
					$this->db->Record['id_class_lesson_content'].'='.$this->db->Record['txTitle'];
			}
			$v['selectOptions'] = @implode($arr, ',');
			return $this->selectToHTML($v);
		}

		# Returns the html for a select widget containing ALL of the webliography
		# link items for the active class.
		function selectClassLinksToHTML($v)
		{
			global $lcUser;
			$sql = "select title, id_class_links from class_links
				where id_classes='{$lcUser->activeClassTaught->id_classes}'";
			$this->db->query($sql);
			$arr = array();
			while ($this->db->next_record()) {
				$arr[$this->db->Record['id_class_links']]
					= $this->db->Record['id_class_links'].'='.$this->db->Record['title'];
			}
			$v['selectOptions'] = @implode($arr, ',');
			return $this->selectToHTML($v);
		}



		# Generates a facutly Dropdown
		function facultyToHTML($v)
		{
			// this is a  MAJOR friggin hack
			if (substr($v['defaultValue'], 0, 12) == 'CHANGEFAMILY')
			{	
				$sql = 'SELECT courseFamily FROM courses WHERE id_courses='. substr($v['defaultValue'], 12);
				$this->db->queryOne($sql);
				
				$CFAM = $this->db->Record['courseFamily'];
				
				if ($CFAM == '')
				{	// back to the old sql statement.. this got messed up somehow.. lets show all faculty
					$sql = "select lcUsers.username, profile.firstname, profile.lastname from lcUsers INNER JOIN profile ON lcUsers.username=profile.username WHERE lcUsers.userType=".USERTYPE_FACULTY.' order by profile.lastname';
				} else
				{	// ok we found the family, lets find the faculty to be shown (via family)
					$sql = 'select lcUsers.username, profile.firstname, profile.lastname from lcUsers INNER JOIN profile ON lcUsers.username=profile.username INNER JOIN profile_faculty_coursefamily on profile_faculty_coursefamily.username=profile.username WHERE profile_faculty_coursefamily.id_profile_faculty_coursefamily=\''.strtoupper($CFAM).'\' AND (lcUsers.userType='.USERTYPE_FACULTY.') order by profile.lastname';
				}
				
			} else
			{	$sql = "select lcUsers.username, profile.firstname, profile.lastname from lcUsers INNER JOIN profile ON lcUsers.username=profile.username WHERE lcUsers.userType=".USERTYPE_FACULTY.' order by lastname';
				
			}
			$this->db->query($sql);
			if ((int)@$this->db->getNumRows()== 0)
			{	$arr[0] = '0=No Teachers Available';
			}
			while($this->db->next_record() )
			{
				$arr[$this->db->Record['username']] = $this->db->Record['username']. '='.$this->db->Record['lastname']. '&#44; '.$this->db->Record['firstname'] ;
			}

			$v['selectOptions'] = @implode($arr, ",");
			
			$HTML = $this->selectToHTML($v);						
			return $HTML;							
			
		}
			
		# Displays LC groups		
		function groupsToHTML($v)
		{
					//groups
			$this->db->query("select * from lcGroups");
			while ($this->db->next_record() ) {
				$arr .= $this->db->Record[gid].'='.$this->db->Record[groupName].',';
			}
			$v['selectOptions'] = substr($arr, 0, -1);
			$HTML = $this->selectToHTML($v);			
			return $HTML;
		}
		
		function faqCategoriesToHTML($v)
		{
			global $lcUser;
			
			$sql = "select distinct(category) from class_faqs WHERE id_classes=". $lcUser->activeClassTaught->id_classes;
			$this->db->query($sql);
			$arr = "General=General,";
			while($this->db->next_record() )
			{
				$arr .= $this->db->Record['category'].'='.$this->db->Record['category'].',';
			}
			$v['selectOptions'] = substr($arr, 0, -1);
			$HTML = $this->selectToHTML($v);			
			return $HTML;
		}
	

		function helpdeskCategoriesToHTML($v)
		{
			$this->db->query("select * from helpdesk_categories ORDER BY helpdesk_category_label");
			while($this->db->next_record()) {
				$arr .= $this->db->Record[0]."=".$this->db->Record['helpdesk_category_label'].',';
			}
			
			$v['selectOptions'] = substr($arr, 0, -1);
			$HTML = $this->selectToHTML($v);
			
		return $HTML;
		}
		function hdCategoriesToHTML($v)
		{
			$this->db->query("select * from hd_categories ORDER BY helpdesk_category_label");
			while($this->db->next_record()) {
				$arr .= $this->db->Record[0]."=".$this->db->Record['helpdesk_category_label'].',';
			}
			
			$v['selectOptions'] = substr($arr, 0, -1);
			$HTML = $this->selectToHTML($v);
			
		return $HTML;
		}
	
		
		function orientationStatusToHTML($v)
		{	
			//$v['selectOptions'] = '1=New,2=Pending,3=Approved,4=Denied,5=Waiting on instructor for approval';
			$v['selectOptions'] = '1=New,2=Pending,5=Waiting on instructor for approval';
			
			// if this element is seeded with an approved status, we show it, but it's not selectable from another status
			if ($v['defaultValue'] == 3)
			{	$v['selectOptions'] .= ',3=Approved';
			}	
			
			$HTML = $this->selectToHTML($v);
		
		return $HTML;
		}
		
		
		function orientationDatesToHTML($v)
		{
			global $lcUser;

			$sql = 'select * from orientation_dates WHERE id_semesters='. $lcUser->sessionvars['semester']. ' order by date DESC';
			$this->db->query($sql);
			
			while($this->db->next_record() )
			{
				$arr .= $this->db->Record['id_orientation_dates'].'='.date('F j Y', strtotime($this->db->Record['date'])).' ('.date('g:i A', strtotime('2003-02-03 '.$this->db->Record['time_start'])).' - '.date('g:i A', strtotime('2003-02-03 '.$this->db->Record['time_end'])).'),';
			}
			
			$v['selectOptions'] = substr($arr, 0, -1);
			$HTML = $this->selectToHTML($v);
						
		return $HTML;
		}
		

		/*
		 * Makes a select box of objectives for the lesson manager page.
		 * We only select the ones for which there is no associated lesson.
		 */
		function selectObjectivesToHTML($v)
		{
		}
		
		/*
		 * Builds a US phone field with 3 fields:
		 * area code - prefix - number
		 * Takes a phone number in the format of
		 * 123-123-1234 and populates the correct field
		 * When posted this fields returns an array as follows:
		 * $fieldname['area'], $fieldname['pre'], $fieldname['num']
		 */
		function phoneNumberToHTML($v)
		{
			
			$x = split('-', $v['defaultValue']);
			$area = $x[0];
			$pre = $x[1];
			$num = $x[2];
			if ($v['req'] == 'Y') { $ast = '*'; };
			$HTML = '<tr><td valign="'.$this->lvalign.'" class="'.$this->cssLeft.'">'.$ast.$v['displayName'].'</td>';
			$HTML .= '<td valign="'.$this->rvalign.'" class="'.$this->cssRight.'">';
			$HTML .= '<input type="text" id="'.$v['fieldName'].'[area]" name="'.$v['fieldName'].'[area]" value="'.$area.'" size="3" maxlength="3"> - ' ;
			$HTML .= '<input type="text" id="'.$v['fieldName'].'[pre]" name="'.$v['fieldName'].'[pre]" value="'.$pre.'" size="3" maxlength="3"> - ' ;
			$HTML .= '<input type="text" id="'.$v['fieldName'].'[num]" name="'.$v['fieldName'].'[num]" value="'.$num.'" size="4" maxlength="4">';
			$HTML .= $msg.'</td></tr>';
			return $HTML;			
		}

		// make sure the ***-***-**** are all numbers, and are the right
		// lengths.
		function validatePhoneNumber($key, $val, $v)
		{
			list($area,$pre,$num)
				= array($val['area'],$val['pre'],$val['num']);

			if ( strlen($area) != 3
				|| strlen($pre) != 3
				|| strlen($num) !=4 ) $error .= "<li>".$v['displayName']."&nbsp; is not in the form xxx-xxx-xxxx.</li>";

			$ar = array($area,$pre,$num);
			while ( list(,$it) = @each($val)) {
				if (!@eregi("^[0-9]*$", $it)) {
					$error .= "<li>".$v['displayName'] ."&nbsp;must contain only numeric characters. Please check your input.</li>";
				}
			}
			if ($error)
			{
				return $error;
			} else {
			return;
			}
		}
	

		/**
		 *	Provides a listing of estimation lists
		 *	for textbooks (textbook manager)
		 */
		function customTextEstListsToHTML($v)
		{
			$sql = '
			SELECT * 
			FROM textbook_estimates';
			$this->db->query($sql);
			while ($this->db->next_record())
			{
				$arr .= $this->db->Record['textbook_estimates_key'].'='.
					$this->db->Record['textbook_estimates_name'].',';

			}

			$v['selectOptions'] = substr($arr, 0, -1);
			$HTML = $this->selectToHTML($v);			
		return $HTML;
		}


		function gbCategoriesToHTML($v)
		{
			global $lcUser;	
			$sql = "SELECT label, id_class_gradebook_categories FROM 
					class_gradebook_categories where
					id_classes='".$lcUser->activeClassTaught->id_classes."'";
			$this->db->query($sql);
			$arr = '=Select Category,';
			while($this->db->next_record() )
			{
				$arr .= $this->db->Record['id_class_gradebook_categories'].'='.$this->db->Record['label'].',';
			}
			$v['selectOptions'] = substr($arr, 0, -1);
			$HTML = $this->selectToHTML($v);			
			return $HTML;

		}

		// Exam Manager custom form field
		// returns blocks for each entry in exam_schedule_classes_dates
		function emClassDatesToHTML($v) {

			include_once(LIB_PATH.'ExamScheduleDates.php');

			global $lcUser;
			$EM = in_array('exammgr', $lcUser->groups) || in_array('admin', $lcUser->groups);
			$db = DB::getHandle();
			$db->RESULT_TYPE = MYSQL_ASSOC;
			$HTML = '';

			$javascript = array();

			while ( list($esdID,$escd) = @each($v['defaultValue']) ) {
				$escd = object2array($escd);
				$disabled = '';

// mgk 10/29/03 - 
// commented this out because examschedule info wasn't showing for any future 
// semesters (sp2004, etc) - only FA2003.  
// I have NO idea what this is doing, where ONLYFILLEDOUT is defined
// or where _new was being set.  a debug() on the object wasn't showing
// _new anywhere.
// forget it - I'm uncommenting this out again
				if ( ONLYFILLEDOUT && $escd['_new'] ) continue;
				if ( !$EM && DIMAPPROVED && $escd['status'] == 3 ) $disabled = ' disabled ';
				
				$id = $esdID;
				/* ORIGINAL David wanted the hours stripped off (10/30/03 RS)
				$HTML .= '<div style="border:1px solid silver;padding:5px;margin:5px;">'
					.'<b>'.date('M j, Y @ g:i A', strtotime($escd['dateStart'])).' - '
					.date('M j, Y @ g:i A', strtotime($escd['dateEnd'])).'</b><br/>'
					.'<table width="100%" border=0 cellpadding=2 cellspacing=0>';
				*/	
				$HTML .= '<div style="border:1px solid silver;padding:5px;margin:5px;">'
					.'<b>'.date('M j, Y', strtotime($escd['dateStart'])).' - '
					.date('M j, Y', strtotime($escd['dateEnd'])).'</b><br/>'
					.'<table width="100%" border=0 cellpadding=2 cellspacing=0>';


				if ( $EM ) {
			
					$HTML .= '<tr><td>Status:&nbsp;&nbsp;'
						.'<select name="emClassDates['.$id.'][dateStatus]">'
							.'<option value="1"'.($escd['status'] == 1 ? ' SELECTED' : '').'>Not Approved</option>'
							.'<option value="2"'.($escd['status'] == 2 ? ' SELECTED' : '').'>Pending</option>'
							.'<option value="3"'.($escd['status'] == 3 ? ' SELECTED' : '').'>Approved</option>'
						.'</select></td></tr>';
				} else {
					switch ($escd->status) {
						case 1: $str = 'Not Approved'; break;
						case 2: $str = 'Pending'; break;
						case 3: $str = 'Approved'; break;
						default: $str = '<i>N/A</i>';
					}
					$HTML .= '<tr><td>Status:&nbsp;&nbsp;'.$str.'</td></tr>';
				}

				$HTML .= '<tr><td valign="top">';
				
				if ($EM)
				{	$HTML .= 'New exam?&nbsp;&nbsp;'
					.'Yes <input type="radio" name="emClassDates['.$id.'][newExam]" value="yes"'.($escd['newExam'] ? ' CHECKED' : '').$disabled.' />&nbsp;&nbsp;'
					.'No <input type="radio" name="emClassDates['.$id.'][newExam]" value="no"'.(!$escd['newExam'] ? ' CHECKED' : '').$disabled.' /><br/>';
				}
				
				$HTML .= 'Title:<br/>'
					.'<input type="text" name="emClassDates['.$id.'][title]" value="'.$escd['title'].'" maxlength=255'.$disabled.' /><br/>'
					.'Subject Material:<br/><textarea name="emClassDates['.$id.'][instructions]" rows=4 cols=30 '.$disabled.'>'.$escd['instructions'].'</textarea>
					</td>
					';
				/*	
				$HTML .= '<tr><td valign="top">New exam?&nbsp;&nbsp;'
					.'Yes <input type="radio" name="emClassDates['.$id.'][newExam]" value="yes"'.($escd['newExam'] ? ' CHECKED' : '').$disabled.' />&nbsp;&nbsp;'
					.'No <input type="radio" name="emClassDates['.$id.'][newExam]" value="no"'.(!$escd['newExam'] ? ' CHECKED' : '').$disabled.' /><br/>'
				.'Title:<br/>'
				.'<input type="text" name="emClassDates['.$id.'][title]" value="'.$escd['title'].'" maxlength=255'.$disabled.' /><br/>'
				.'Subject Material:<br/><textarea name="emClassDates['.$id.'][instructions]" rows=4 cols=30 '.$disabled.'>'.$escd['instructions'].'</textarea></td>';
				*/
				
				if ( $EM ) {
					$HTML .= '<td valign="top">'
							.'<table border=0 cellpadding=2 cellspacing=0>'
							.'<tr>'
								.'<td align="right">South copies:</td>'
								.'<td><input type="text" id="'.$id.'_s" name="emClassDates['.$id.'][southCopies]" value="'.$escd['southCopies'].'" size=4 /></td>'
							.'</tr>'
							.'<tr>'
								.'<td align="right">Southeast copies:</td>'
								.'<td><input type="text" id="'.$id.'_se" name="emClassDates['.$id.'][southeastCopies]" value="'.$escd['southeastCopies'].'" size=4 /></td>'
							.'</tr>'
							.'<tr>'
								.'<td align="right">Northeast copies:</td>'
								.'<td><input type="text" id="'.$id.'_ne" name="emClassDates['.$id.'][northeastCopies]" value="'.$escd['northeastCopies'].'" size=4 /></td>'
							.'</tr>'
							.'<tr>'
								.'<td align="right">Northwest copies:</td>'
								.'<td><input type="text" id="'.$id.'_nw" name="emClassDates['.$id.'][northwestCopies]" value="'.$escd['northwestCopies'].'" size=4 /></td>'
							.'</tr>'
							.'</table>'
						.'</td>';

					$javascript[$id.'_s'] = false; // default not checked
					$javascript[$id.'_se'] = false; // default not checked
					$javascript[$id.'_ne'] = false; // default not checked
					$javascript[$id.'_nw'] = false; // default not checked
	
					$HTML .= '<td valign="top">'
							.'<b>Notes:</b><br/>'
							.'<textarea name="emClassDates['.$id.'][note]" cols=30 rows=5>'.$escd['note'].'</textarea>'
						.'</td>';
				} else {
					$HTML .= '<td width=30>&nbsp;</td>'
						.'<td valign="top">'
							.'<b>Note from Exam Manager:</b><br/>'.($escd['note'] ? $escd['note'] : '<i>None</i>')
						.'</td>';
				}

				$HTML .= '</tr></table>'
					.'</div>';
			}
			$javascript_string = '
			<script>
			
			var cizampus_south = new Object();
			var cizampus_southeast = new Object();
			var cizampus_northeast = new Object();
			var cizampus_northwest = new Object();
			';
	
			foreach($javascript as $jv=>$jj)
			{
				$sc = array_pop(explode('_', $jv));
				switch ($sc)
				{
					case 's':
						$javascript_string .= '	
	cizampus_south["'.$jv.'"] = false;';
						break;
					case 'se':
						$javascript_string .= '	
	cizampus_southeast["'.$jv.'"] = false;';
						break;						
					case 'ne':
						$javascript_string .= '	
	cizampus_northeast["'.$jv.'"] = false;';
						break;					
					case 'nw':
						$javascript_string .= '	
	cizampus_northwest["'.$jv.'"] = false;';
						break;					
				}
				

			}
			$javascript_string .= '
			</script>
			';
	
			return '<tr><td colspan=2>'.$javascript_string. $HTML.'</td></tr>';
		}

		function validateemClassDates($key, $val, $v) {

			$errors = '';

			while ( list($dateID,$data) = @each($val) ) {

				if ( $data['title'] || $data['instructions'] ) {

					// They were trying to submit this date field. Let's validate it.
					if ( !$data['title'] )
						$errors .= '<li> You\'re missing a title for a partially filled out date.</li>';
					if ( !$data['instructions'] )
						$errors .= '<li> You\'re missing instructions for a partially filled out date.</li>';
				}

				if ( $errors ) break;  // don't give them the same error again
			}

			return $errors;

		}
	}
?>
