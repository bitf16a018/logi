<?
include_once(LIB_PATH.'Assessment.php');
include_once(LIB_PATH.'ClassGradebookVal.php');
include_once(LIB_PATH.'ClassGradebookEntries.php');
include_once(LIB_PATH.'ClassGradebookCategories.php');

class ClassGradebookBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $idClassGradebook;
	var $idClasses;
	var $aLower;
	var $bLower;
	var $cLower;
	var $dLower;
	var $calculationType;
	var $colorMissingGrade;
	var $roundScoresUp;
	var $totalPoints;

	var $__attributes = array(
	'idClassGradebook'=>'int',
	'idClasses'=>'Classes',
	'aLower'=>'float',
	'bLower'=>'float',
	'cLower'=>'float',
	'dLower'=>'float',
	'calculationType'=>'int',
	'colorMissingGrade'=>'char',
	'roundScoresUp'=>'tinyint',
	'totalPoints'=>'int');

	function getClasses() {
		if ( $this->idClasses == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = ClassesPeer::doSelect('id_classes = \''.$this->idClasses.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->idClassGradebook;
	}

	function setPrimaryKey($val) {
		$this->idClassGradebook = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassGradebookPeer::doInsert($this));
		} else {
			ClassGradebookPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_gradebook='".$key."'";
		}
		$array = ClassGradebookPeer::doSelect($where);
		return $array[0];
	}

	function isNew() {
		return $this->_new;
	}

	function isModified() {
		return $this->_modified;

	}

	function get($key) {
		return $this->{$key};
	}

	function set($key,$val) {
		$this->_modified = true;
		$this->{$key} = $val;

	}

	/**
	 * set all properties of an object that aren't
	 * keys.  Relation attributes must be set manually
	 * by the programmer to ensure security
	 */
	function setArray($array) {
		if ($array['aLower'])
			$this->aLower = $array['aLower'];
		if ($array['bLower'])
			$this->bLower = $array['bLower'];
		if ($array['cLower'])
			$this->cLower = $array['cLower'];
		if ($array['dLower'])
			$this->dLower = $array['dLower'];
		if ($array['calculationType'])
			$this->calculationType = $array['calculationType'];
		if ($array['colorMissingGrade'])
			$this->colorMissingGrade = $array['colorMissingGrade'];
		if ($array['roundScoresUp'])
			$this->roundScoresUp = $array['roundScoresUp'];
		if ($array['totalPoints'])
			$this->totalPoints = $array['totalPoints'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class ClassGradebookPeerBase {

	var $tableName = 'class_gradebook';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("class_gradebook",$where);
		$st->fields['id_class_gradebook'] = 'id_class_gradebook';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['a_lower'] = 'a_lower';
		$st->fields['b_lower'] = 'b_lower';
		$st->fields['c_lower'] = 'c_lower';
		$st->fields['d_lower'] = 'd_lower';
		$st->fields['calculation_type'] = 'calculation_type';
		$st->fields['color_missing_grade'] = 'color_missing_grade';
		$st->fields['roundScoresUp'] = 'roundScoresUp';
		$st->fields['total_points'] = 'total_points';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassGradebookPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("class_gradebook");
		$st->fields['id_class_gradebook'] = $this->idClassGradebook;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['a_lower'] = $this->aLower;
		$st->fields['b_lower'] = $this->bLower;
		$st->fields['c_lower'] = $this->cLower;
		$st->fields['d_lower'] = $this->dLower;
		$st->fields['calculation_type'] = $this->calculationType;
		$st->fields['color_missing_grade'] = $this->colorMissingGrade;
		$st->fields['roundScoresUp'] = $this->roundScoresUp;
		$st->fields['total_points'] = $this->totalPoints;

		$st->key = 'id_class_gradebook';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("class_gradebook");
		$st->fields['id_class_gradebook'] = $obj->idClassGradebook;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['a_lower'] = $obj->aLower;
		$st->fields['b_lower'] = $obj->bLower;
		$st->fields['c_lower'] = $obj->cLower;
		$st->fields['d_lower'] = $obj->dLower;
		$st->fields['calculation_type'] = $obj->calculationType;
		$st->fields['color_missing_grade'] = $obj->colorMissingGrade;
		$st->fields['roundScoresUp'] = $obj->roundScoresUp;
		$st->fields['total_points'] = $obj->totalPoints;

		$st->key = 'id_class_gradebook';
		$db->executeQuery($st);
		$obj->_modified = false;

	}

	function doReplace($obj) {
		//use this tableName
		if ($this->isNew() ) {
			$db->executeQuery(new LC_InsertStatement($criteria));
		} else {
			$db->executeQuery(new LC_UpdateStatement($criteria));
		}
	}



	function doDelete(&$obj,$shallow=false) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_DeleteStatement("class_gradebook","id_class_gradebook = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new ClassGradebook();
		$x->idClassGradebook = $row['id_class_gradebook'];
		$x->idClasses = $row['id_classes'];
		$x->aLower = $row['a_lower'];
		$x->bLower = $row['b_lower'];
		$x->cLower = $row['c_lower'];
		$x->dLower = $row['d_lower'];
		$x->calculationType = $row['calculation_type'];
		$x->colorMissingGrade = $row['color_missing_grade'];
		$x->roundScoresUp = $row['roundScoresUp'];
		$x->totalPoints = $row['total_points'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class ClassGradebook extends ClassGradebookBase {
	
	# Holds an array of students for this gradeobook
	var $students = array();
	var $filterLastname;
	var $filterActive;
	var $filterCategory;

	# Called from calculateWeights()
	# and stores the number number of entries per cate.
	var $categoryWeights = array();

	# stores all or one entry
	var $entries = array();

	# total number of points for all entries
	var $possiblePoints = 0;

	function getStudents()
	{
		$user = lcUser::getCurrentUser();

		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$sql = 'select p.firstname,p.lastname,p.username,ss.active from profile as p
			left join class_student_sections as ss on ss.id_student=p.username
			left join class_sections as s on s.sectionNumber=ss.sectionNumber
			left join classes as cls on cls.id_semesters=ss.semester_id
			where s.id_classes="'.$this->idClasses.'"
			and cls.id_classes="'.$this->idClasses.'" ';
#			and ss.active=\'1\'';

		if ($this->filterLastname)
			$sql .= ' and lastname like "'.$this->filterLastname.'%"';
		if ($this->filterActive===0 or $this->filterActive===1) // 0 or 1
			$sql .= ' and ss.active="'.$this->filterActive.'"';

		$sql .= ' order by p.lastname, p.firstname';
		$db->query($sql);
		while ($db->next_record())
			$this->students[$db->Record['username']] = ClassGradeBookStudent::load($db->Record);
	}

	// This was added for classroom/gradebook to load up a SINGLE student
	function getStudent( $username )
	{
		//__FIXME__ make sure this uses proper constraints against class/semester/section
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$sql = "select firstname, lastname, username from profile
			where username='$username'";
		$db->queryOne($sql);
		if ( $db->Record['username'] == '' ) return false;
		$this->students[$db->Record['username']] = ClassGradebookStudent::load($db->Record);
		return true;
	}


	function getEntries($getUnpublished = true)
	{
		// load up all entries for the class, and store the array of
		// them into $entries
		unset($this->entries);

		$where = 'id_classes="'.$this->idClasses.'"';
		if ( $this->filterCategory )
			$where .= ' and id_class_gradebook_categories="'.$this->filterCategory.'"';
		if ( !$getUnpublished )
			$where .= ' and publish_flag=1';

		$entries = ClassGradebookEntriesPeer::doSelect( $where );

		//natural sort the names
		$cnt = count($entries);
		for ( $i=0; $i<$cnt; $i++ ) {
			$sortTheEntries[$i] = $entries[$i]->gradebookCode;
		}
		natsort($sortTheEntries);
		while ( list($ordinal,$id) = @each($sortTheEntries) ) {
			$this->entries[$entries[$ordinal]->idClassGradebookEntries] = $entries[$ordinal];
		}
	}

	function getEntry($entryid)
	{
		unset($this->entries);
		$this->entries[0] = ClassGradebookEntries::load( array(
			'id_classes'=>$this->idClasses,
			'id_class_gradebook_entries'=>$entryid,
			'publish_flag'=>1
		) );
	}

	function getValsForStudents()
	{
		// now we have $this->idClasses
		// drawbacks ?
		// loop through all students and grab their vals
		while ( list($username, $stuObj) = @each($this->students) )
		{
			$stuObj->getAllVals($this->idClasses, $this->entries);
			$this->students[$username] = $stuObj;
		}
	}
	
	// get all possible points for a particular student view
	function calcPossiblePointsForStudent($studentId)
	{

		if ($this->calculationType == 1)
		{
			 if ( !count($this->categoryWeights) ) $this->calculateWeights();

			 foreach ($this->categoryWeights AS $id=>$data)
			 {
			 	$this->possiblePoints += $data['weight'];
			 }
			 reset($this->categoryWeights);
		} else {

			foreach ($this->entries AS $entryid=>$obj)
			{
				if ($obj->assessmentId>0) { // we have an assessment/test, not an assigment
								// so we'll look up the points and the availble date
					$test = $this->students[$studentId]->vals[$entryid];
					if ( $obj->dateDue > time() || $test->score > 0) { 
//						if ($test->_new!=1) { 
							$this->possiblePoints += $obj->totalPoints;
//						}
					}
				} else {
					$test = $this->students[$studentId]->vals[$entryid];
					if ( $obj->dateDue > time() || $test->score > 0) { 
//						if ($test->_new!=1) { 
							$this->possiblePoints += $obj->totalPoints;
//						}
					}
	
						#$this->possiblePoints += $obj->totalPoints;
				}
			}
			reset($this->entries);
		}
	}



	// calculate all points for all entries
	function calcPossiblePoints()
	{

		if ($this->calculationType == 1)
		{
			 if ( !count($this->categoryWeights) ) $this->calculateWeights();

			 foreach ($this->categoryWeights AS $id=>$data)
			 {
			 	$this->possiblePoints += $data['weight'];
			 }
			 reset($this->categoryWeights);
		} else {

			foreach ($this->entries AS $entryid=>$obj)
			{
				$this->possiblePoints += $obj->totalPoints;
			}
			reset($this->entries);
		}
	}


	# takes a number (0-100) passed to it and returns the
	# letter grade based on the upper / lower's of the object
	function getLetterGrade($score)
	{
		if ($score === '') {
			return 'N/A';
		}
		if ( $this->roundScoresUp ) $score = ceil($score);
		
		if ( $score >= $this->aLower ) {
			$letter = 'A';
			$min = $this->aLower;
			$max = 100;
		} else if ( $score >= $this->bLower ) {
			$letter = 'B';
			$min = $this->bLower;
			$max = $this->aLower;
		} else if ( $score >= $this->cLower ) {
			$letter = 'C';
			$min = $this->cLower;
			$max = $this->bLower;
		} else if ( $score >= $this->dLower ) {
			$letter = 'D';
			$min = $this->dLower;
			$max = $this->cLower;
		} else {
			return 'F';
		}

		$inc = ($max - $min) / 3;

		if ( $score >= $max-$inc ) return "$letter+";
		if ( $score <  $min+$inc ) return "$letter-";

		return $letter;
	}


	# takes a score and total possible points and returns the
	# letter grade based on the upper / lower's of the object
	function getLetterGradeNew($points,$possible)
	{
		if ($possible == 0 ) {
			return 'E/C';
		}
		$score = $points / $possible * 100;

		if ($score === '') {
			return 'N/A';
		}
		if ( $this->roundScoresUp ) $score = ceil($score);
		
		if ( $score >= $this->aLower ) {
			$letter = 'A';
			$min = $this->aLower;
			$max = 100;
		} else if ( $score >= $this->bLower ) {
			$letter = 'B';
			$min = $this->bLower;
			$max = $this->aLower;
		} else if ( $score >= $this->cLower ) {
			$letter = 'C';
			$min = $this->cLower;
			$max = $this->bLower;
		} else if ( $score >= $this->dLower ) {
			$letter = 'D';
			$min = $this->dLower;
			$max = $this->cLower;
		} else {
			return 'F';
		}

		$inc = ($max - $min) / 3;

		if ( $score >= $max-$inc ) return "$letter+";
		if ( $score <  $min+$inc ) return "$letter-";

		return $letter;
	}



	# Loops through all categories and calculates
	# how many entries are in each category
	# Then it divides the total by the weight for the
	# category to get the % points for the entry
	function calculateWeights()
	{
		# categories are where?
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$sql = '
			SELECT count(B.id_class_gradebook_categories) as category_count,
			A.id_class_gradebook_categories, A.weight
			
			FROM class_gradebook_categories as A
			INNER JOIN class_gradebook_entries as B ON
				A.id_class_gradebook_categories = B.id_class_gradebook_categories
			WHERE B.id_classes='.$this->idClasses.' AND A.id_classes='.$this->idClasses.'
			GROUP BY B.id_class_gradebook_categories';

		$db->query($sql);
		while($db->next_record() )
		{
			$this->categoryWeights[$db->Record['id_class_gradebook_categories']] = $db->Record;
			$totalWeights += $db->Record['weight'];
		}
		$this->categoryWeightRatio = 100/$totalWeights;
		reset($this->categoryWeights);

	}

	function calculateStudentPointsEarned()
	{
		foreach ($this->students AS $username=>$stuObj)
		{
			$stuObj->calculateTotalPointsEarned();
			$this->students[$username] = $stuObj;
		}
	}

	# Takes the categoryWeights array and goes
	# through it and updates each entry object
	function updateEntryWeights()
	{
		foreach($this->entries AS $entryId => $entryObj)
		{
			$weight = $this->categoryWeights[$entryObj->idClassGradebookCategories]['weight'];
			$count = $this->categoryWeights[$entryObj->idClassGradebookCategories]['category_count'];
			# formula is $weight / $count
			@$entryObj->weightedPercent = sprintf("%0.2f", $weight / $count).'%';
			$this->entries[$entryId] = $entryObj;
		}
		reset($this->entries);
	}


	function getAllCategories($id_classes)
	{
		$sql = "SELECT id_class_gradebook_categories as id, label
			from class_gradebook_categories
			where id_classes='$id_classes'";	
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$db->query($sql);

		$cats = array();
		while($db->next_record() ) {
			 $cats[$db->Record['id']] = $db->Record['label'];
		}
		return $cats;

	}

	# Calculates averages for students if the gradebook is set to weighted percents
	function calculateWeightedAverages()
	{
		$stamp = time();
		# 1 = weighted
		if ($this->calculationType == 1)
		{

			foreach($this->students AS $username=>$stuObj)
			{
				$categoryPercentSums = array();
				//loop through the GB's definition of  how many entires there are
				// to get proper weights for the students
				reset($this->entries);
				while ( list($k,$v) = @each($this->entries) ) {
					$categoryPercentSums[ $v->idClassGradebookCategories ]['count'] ++;
//					print "<!-- catid ".$v->idClassGradebookCategories ."-->\n";
				}
				reset($this->entries);
				foreach ($stuObj->vals AS $valId=>$valObj)
				{

					$catid = $this->entries[$valObj->idClassGradebookEntries]->idClassGradebookCategories;
//testing new 0 handling
					if ( $this->entries[$valObj->idClassGradebookEntries]->dateDue > $stamp && $valObj->score == 0 ) { continue; }
					if ( $this->entries[$valObj->idClassGradebookEntries]->totalPoints > 0 ) {
					//store the sum of all value percentages for a particular category in an array
					//this algorithm was made by mike and mark
						if ($valObj->_new) continue;
						$categoryPercentSums[ $catid ]['total'] += 
							sprintf('%.2f',$valObj->score / $this->entries[ $valObj->idClassGradebookEntries ]->totalPoints) 
							* sprintf('%.2f',$this->categoryWeights[$catid]['weight']/$categoryPercentSums[$catid]['count']);

						$stuObj->percentCount[$this->entries[$valObj->idClassGradebookEntries]->idClassGradebookCategories]++;
//						print "<!-- avg so far ".$categoryPercentSums[$catid]['total'] ."-->\n";
					}
//					$stuObj->weightedAverage += $this->entries[$valObj->idClassGradebookEntries]->weightedPercent * ($valObj->score / $this->entries[$valObj->idClassGradebookEntries]->totalPoints );	

				}
				//once the vals are sorted by category, find the average
				foreach ($categoryPercentSums as $catid => $percentArray ) {
					if (!isset($percentArray['total']) ) { //print "<!--nothing completed in this category $catid-->\n\n";
					continue; }
					//print "\n\n<!--new category $catid-->\n";

					$stuObj->weightedAverage += $percentArray['total'];
					$stuObj->catWeightTotals += sprintf('%.2f',$this->categoryWeights[$catid]['weight'] / $percentArray['count']) /100 
						* $stuObj->percentCount[$catid];


					/*
					print "<!-- ".$stuObj->username." has ".$stuObj->percentCount[$catid] ." grades in this category weighing ".$this->categoryWeights[$catid]['weight'] ."% with  ". $percentArray['count'] ." entries -->\n";
					print "<!-- " . $this->categoryWeights[$catid]['weight']." / ".$percentArray['count']." * ".( $percentArray['total'] )." /100 -->\n";
					print "<!-- weight total so far ".$stuObj->catWeightTotals ."-->\n";
					print "<!-- avg so far ".$stuObj->weightedAverage ."-->\n";
					*/
				}
					print "<!-- / "   .$stuObj->weightedAverage ." " . $stuObj->catWeightTotals ."-->\n\n";
				$stuObj->weightedAverage = $stuObj->weightedAverage / $stuObj->catWeightTotals;
				$stuObj->weightedAverage = sprintf('%.3f',$stuObj->weightedAverage);
				$this->students[$username] = $stuObj;
			}
		}
	}

	# Calculates the 0-100 percent score for each student's
	# vals if they're grading absed on points
	function calculatePercentScores()
	{
			foreach ( $this->students as $username => $stuObj )
			{
				$totalPercent = 0;
				
				foreach ( $stuObj->vals as $valid => $valObj )
				{
					$percentScore =
						( $valObj->score / $this->entries[$valObj->idClassGradebookEntries]->totalPoints )
						* 100;

					$this->students[$username]->vals[$valid]->percentScore = $percentScore;
					$totalPercent += $percentScore;
				}
				#$this->students[$username]->percentAverage =
				#	sprintf('%0.2f', $totalPercent / count($this->entries));
				$score = $this->students[$username]->totalPointsEarned;
				$poss = $this->students[$username]->totalPossiblePoints;
				$this->students[$username]->percentAverage =
					sprintf('%0.2f', ($score/$poss)*100);
			}

	}

}

class ClassGradebookStudent {
	
	var $firstname ='';
	var $lastname = '';
	var $username = '';
	var $classRank = '';
	var $totalPointsEarned;
	var $totalPossiblePoints;
	var $active;

	// calculated by calling gradebook->calculateWeightedAverages
	var $weightedAverage = 0;

	# Holds the scores for the student
	var $vals = array();

	# Static call, pass in array
	# Normally called from 	ClassGradebook::getStudents()
	function load($array)
	{
		$x = new ClassGradebookStudent();
		$x->firstname = $array['firstname'];
		$x->lastname = $array['lastname'];
		$x->username = $array['username'];
		$x->active = $array['active'];
		return $x;
	}

	# Takes the array of vals (which are objects)
	# loops through them, and updates the totalPointsEarned propery
	# of this object
	function calculateTotalPointsEarned()
	{
		foreach ($this->vals AS $valid=>$valObj)
		{
			$this->totalPointsEarned += $valObj->score;
		}
	}


	//only count vals that have grades, if a grade is 0, then check the entry's due date.
	function getAllVals($idClasses, &$entries)
	{
		
		// create an array of empty val objects

		$val = ClassGradebookValPeer::doSelect(" id_classes=$idClasses and username = '".$this->username."'");
		foreach  ($val as $key => $gb_val_obj) {
			if ( $gb_val_obj->score > 0 ) {
				$this->vals[$gb_val_obj->idClassGradebookEntries] = $gb_val_obj;
			}

			//if past due date, count a 0 as a 0
//			if ( $gb_val_obj->score < 1 && $entries[$gb_val_obj->idClassGradebookEntries]->dateDue < time() &&  $entries[$gb_val_obj->idClassGradebookEntries]->dateDue > 0 ) {
			if ( $gb_val_obj->score < 1  && $gb_val_obj->score != null) {
				$gb_val_obj->score = 0;
				$this->vals[$gb_val_obj->idClassGradebookEntries] = $gb_val_obj;
			}


			//then get the points only for this val, add it to student's totalPossiblePoints
			// we cannot use the total points for a gradebook for this

			if ( isset($gb_val_obj->score) ) {
				$this->totalPossiblePoints += $entries[$gb_val_obj->idClassGradebookEntries]->totalPoints;
			}
		}

	}


}

class ClassGradebookPeer extends ClassGradebookPeerBase {

}
?>

