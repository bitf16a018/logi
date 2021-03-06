<?
include_once(LIB_PATH.'Assessment.php');
include_once(LIB_PATH.'ClassGradebookVal.php');
include_once(LIB_PATH.'ClassGradebookEntries.php');
include_once(LIB_PATH.'ClassGradebookCategories.php');

class ClassGradebookBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idClassGradebook;
	var $idClasses;
	var $aUpper;
	var $aLower;
	var $bLower;
	var $cLower;
	var $dLower;
	var $calculationType;
	var $colorMissingGrade;
	var $roundScoresUp;
	var $totalPoints;

	var $__attributes = array( 
	'idClassGradebook'=>'integer',
	'idClasses'=>'integer',
	'aUpper'=>'float',
	'aLower'=>'float',
	'bLower'=>'float',
	'cLower'=>'float',
	'dLower'=>'float',
	'calculationType'=>'integer',
	'colorMissingGrade'=>'char',
	'roundScoresUp'=>'tinyint',
	'totalPoints'=>'integer');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->idClassGradebook;
	}


	function setPrimaryKey($val) {
		$this->idClassGradebook = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassGradebookPeer::doInsert($this,$dsn));
		} else {
			ClassGradebookPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_gradebook='".$key."'";
		}
		$array = ClassGradebookPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassGradebookPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassGradebookPeer::doDelete($this,$deep,$dsn);
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


	/**
	 * only sets if the new value is !== the current value
	 * returns true if the value was updated
	 * also, sets _modified to true on success
	 */
	function set($key,$val) {
		if ($this->{$key} !== $val) {
			$this->_modified = true;
			$this->{$key} = $val;
			return true;
		}
		return false;
	}

}


class ClassGradebookPeerBase {

	var $tableName = 'class_gradebook';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_gradebook",$where);
		$st->fields['id_class_gradebook'] = 'id_class_gradebook';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['a_upper'] = 'a_upper';
		$st->fields['a_lower'] = 'a_lower';
		$st->fields['b_lower'] = 'b_lower';
		$st->fields['c_lower'] = 'c_lower';
		$st->fields['d_lower'] = 'd_lower';
		$st->fields['calculation_type'] = 'calculation_type';
		$st->fields['color_missing_grade'] = 'color_missing_grade';
		$st->fields['roundScoresUp'] = 'roundScoresUp';
		$st->fields['total_points'] = 'total_points';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassGradebookPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_gradebook");
		$st->fields['id_class_gradebook'] = $this->idClassGradebook;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['a_upper'] = $this->aUpper;
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

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_gradebook");
		$st->fields['id_class_gradebook'] = $obj->idClassGradebook;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['a_upper'] = $obj->aUpper;
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

	function doReplace($obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		if ($this->isNew() ) {
			$db->executeQuery(new PBDO_InsertStatement($criteria));
		} else {
			$db->executeQuery(new PBDO_UpdateStatement($criteria));
		}
	}


	/**
	 * remove an object
	 */
	function doDelete(&$obj,$deep=false,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_DeleteStatement("class_gradebook","id_class_gradebook = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( $deep ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}



	/**
	 * send a raw query
	 */
	function doQuery(&$sql,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);

		$db->query($sql);

	  	return;
	}



	function row2Obj($row) {
		$x = new ClassGradebook();
		$x->idClassGradebook = $row['id_class_gradebook'];
		$x->idClasses = $row['id_classes'];
		$x->aUpper = $row['a_upper'];
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
	var $filterSection;

	var $categories = array();
	var $vals = array();

	# stores all or one entry
	var $entries = array();


	function getStudents()
	{
		$user = lcUser::getCurrentUser();

		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$sql = 'select p.firstname,p.lastname,p.username,ss.active,ss.withdrew_on, u.pkey
			FROM class_enrollment as ss
			left join lcUsers as u on ss.student_id = u.pkey
			left join profile as p on u.username=p.username
			left join class_sections as s on s.sectionNumber=ss.section_number
			left join classes as cls on cls.id_classes=ss.class_id
			where ss.class_id="'.$this->idClasses.'" ';

		if (strlen($this->filterSection)>0) { 
			$sql .= " and ss.sectionNumber=".$this->filterSection." ";
		}

		if ($this->filterLastname)
			$sql .= ' and lastname like "'.$this->filterLastname.'%"';
		if ($this->filterActive===0 or $this->filterActive===1) // 0 or 1
			$sql .= ' and ss.active="'.$this->filterActive.'"';

		$sql .= ' order by p.lastname, p.firstname';

		$db->query($sql);
		while ($db->nextRecord()) {
			$db->record['username'] = strtolower($db->record['username']);
			$this->students[$db->record['pkey']] = ClassGradebookStudent::load($db->record);
		}
	}

	// This was added for classroom/gradebook to load up a SINGLE student
	function getStudent( $username ) {
		//__FIXME__ make sure this uses proper constraints against class/semester/section
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;

		$sql = 'select p.firstname,p.lastname,p.username,ss.active,ss.withdrew_on, u.pkey
			FROM class_enrollment as ss
			left join lcUsers as u on ss.student_id = u.pkey
			left join profile as p on u.username=p.username
			left join class_sections as s on s.sectionNumber=ss.section_number
			left join classes as cls on cls.id_classes=ss.class_id
			where s.id_classes="'.$this->idClasses.'"
			and p.username="'.$username.'" ';

		$db->queryOne($sql);
		if ( $db->record['username'] == '' ) return false;
		$this->students[$db->record['pkey']] = ClassGradebookStudent::load($db->record);
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



	/**
	 * A B C D F for a percentage.
	 * takes a number (0-100) and the total possible points.
	 * returns the letter grade based on the upper / lower's of the object
	 * or E/C for extra credit
	 */
	function getLetterGrade($points,$possible)
	{
		if ($possible === 0 ) {
			return 'E/C';
		}

		if ($this->calculationType == 1 ) {
			$score = $points;
		} else {
			$score = $points / $possible * 100;
		}

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
// removed per David Wissore email on feb 23, 2004
		//$inc = ($max - $min) / 3;
		#if ( $score >= $max-$inc ) return "$letter+";
		#if ( $score <  $min+$inc ) return "$letter-";

		return $letter;
	}



	/**
	 * Loads GB Categories and weights.
	 * Loops through all categories and calculates
	 * how many entries are in each category
	 * Then it divides the total by the weight for the
	 * category to get the % points for the entry
	 */
	function loadCategories()
	{
		# categories are where?
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$sql = '
			SELECT count(B.id_class_gradebook_categories) as category_count,
			A.id_class_gradebook_categories, A.weight, A.drop_count, A.label,A.id_classes
			
			FROM class_gradebook_categories as A
			INNER JOIN class_gradebook_entries as B ON
				A.id_class_gradebook_categories = B.id_class_gradebook_categories
			WHERE B.id_classes='.$this->idClasses.' AND A.id_classes='.$this->idClasses.'
			GROUP BY B.id_class_gradebook_categories';

		$db->query($sql);
		while($db->nextRecord() )
		{
			$this->categoryWeights[$db->record['id_class_gradebook_categories']] = $db->record;
			$this->categories[$db->record['id_class_gradebook_categories']] = ClassGradebookCategoriesPeer::row2Obj($db->record);
			$totalWeights += $db->record['weight'];
			$this->hasDropCount |= ($db->record['drop_count'] > 0);
		}
		//we don't need this for the other type of calculations anymore
		// kevin said we shouldn't adjust each cat wieght based on the total weights
		$this->categoryWeightRatio = 100/$totalWeights;
		reset($this->categoryWeights);
	}

	/**
	 * Load simple list of categories.
	 * load a list of just names w/o the more complex
	 * calculations of loadCategories
	 * Usefull for dropdowns
	 *
	 * @static
	 */
	function loadCategoryList($id_classes)
	{
		$sql = "SELECT id_class_gradebook_categories as id, label
		from class_gradebook_categories
		where id_classes='$id_classes'";        
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$db->query($sql);

		$cats = array();
		while($db->nextRecord() ) {
			$cats[$db->record['id']] = $db->record['label'];
		}
		return $cats;
	}


	/**
	 * Merges the loaded vals and the loaded students based on
	 * a number of criteria.
	 *
	 * Due date, dateWithdrawn, etc... affect whether or not a student
	 * is responsible for a certain grade.  This function will apply
	 * appropriate vals to each student.
	 */
	function setStudentVals() {
		$now = time();

//print "<!-- SET STUDENT VALS START -->\n";
//print "<!-- SET STUDENT VALS: VALOBJ ".get_class($valObj)."  -->\n";
//print "<!-- \n";
#print_r($this->vals);
//print "--> \n";



		foreach($this->vals as $valId=>$valObj) {

			$entry = $this->entries[$valObj->idClassGradebookEntries];
			$j = $valObj->studentId;
			$student = $this->students[$j];
			if ( strtolower(get_class($student)) != 'classgradebookstudent' ){
				continue;
			}


			if ( $entry->publishFlag == 0 ) {
				#$this->students[$valObj->username]->vals[$entry->idClassGradebookEntries] = $valObj;
				$this->students[$j]->vals[$entry->idClassGradebookEntries] = $valObj;
				continue;
			}
			if (($entry->dateDue > 0 && $entry->dateDue < $now) || strlen($valObj->score) > 0 ) {
				//date due is passed, assign points or 0 to student
				// fixed - mgk 12/9/03
#				if ($student->dateWithdrawn > 0 && $student->dateWithdrawn < $entry->dateDue ) {
#					continue;
#				}
// per kevin's AIM
// wants any recorded grade to be shown, regardless of drop date.
				if (isset($valObj->score)) { 
					if ( $valObj->score == 0 ) { $valObj->score = 0; }
				}
				#$this->students[$valObj->username]->vals[$entry->idClassGradebookEntries] = $valObj;
				$this->students[$j]->vals[$entry->idClassGradebookEntries] = $valObj;
				#$this->students[$valObj->username]->possiblePoints += $entry->totalPoints;
				$this->students[$j]->possiblePoints += $entry->totalPoints;
				#$this->students[$valObj->username]->totalPointsEarned += $valObj->score;
				$this->students[$j]->totalPointsEarned += $valObj->score;
			}
		}


		/*
		//this feature works, kevin does not want it in just yet
		// wants teacher to be explicit with their grading

		//initialize empty student vals with blanks
		foreach($this->entries as $entId=>$entObj) {
			if ( $entObj->dateDue > $now || $entObj->dateDue < 1 ) continue;
			foreach($this->students as $username=>$stuObj) {
				if ( is_object($this->students[$username]->vals[$entId]) ) { continue; }
				$v = new ClassGradebookVal();
				$v->score = 0;
				$v->idClassGradebookEntries = $entId;
				$v->idClassGradebookVal = rand(9999,1000000);
				$v->username = $username;
				$this->vals[$v->idClassGradebookVal] = $v;
				$this->students[$username]->vals[$entId] = $v;
			}
		}
		*/


		$this->dropGrades();
	}


	/**
	 * Load all val objects for this class id
	 */
	function loadVals() {
		$array = array();
		$ret = array();
		$array = ClassGradebookValPeer::doSelect( 'id_classes='.$this->idClasses );
		foreach($array as $blank=>$valObj) {
			if ( $this->filterCategory 
				&& $this->entries[$valObj->idClassGradebookEntries]->idClassGradebookCategories 
				!= $this->filterCategory) {
		#		continue;
			}
			// mgk 2/8/04
			// karen richardson student (and others) had data not showing up
			// due to this bug.
			$valObj->username = strtolower($valObj->username);
			$this->vals[$valObj->idClassGradebookVal] = $valObj;
		}
	}



	/**
	 * Drop some of the grades from a student's vals array
	 * based on the category attribut dropCount
	 */
	function dropGrades() {
		if (!$this->requiresDrop()) {
			return;
		}


		//create a structure that represents empty slots
		// for the lowest grade in each category.
		$dropList = array();
		foreach($this->categories as $catId=>$catObj) {
			for ($x=0; $x < ($catObj->dropCount); $x++) {
				$dropList[$catId][$x] = 0;
			}
		}

		//examine each student's val objects,
		// compare the category of each val (via the entry)
		// to the dropList structure.  Replace val Ids that 
		// have lower score's that what is already in the $dropList
		foreach($this->students as $username=>$stuObj) {

			foreach($stuObj->vals as $entId=>$valObj) {
			$catId = $this->entries[$entId]->idClassGradebookCategories;
			$entObj = $this->entries[$entId];
			if ( is_array($dropList[$catId]) ) {
				//definately drop some grades for this category

			reset($dropList[$catId]);
				while ( list($blank,$compareId) = @each($dropList[$catId]) ) {
					unset($tmp);
					$compareVal = $this->vals[$compareId];
					//compare scores from percentage based classes properly
					//points based
					$scoreA = $valObj->score;
					$scoreB = $compareVal->score;

					//percentage based
					if ( $this->isPercentageBased() ) {
						$compareEnt = $this->entries[$compareVal->idClassGradebookEntries];
						$scoreA = $valObj->score / $entObj->totalPoints  * 100;
						$scoreB = $compareVal->score / $compareEnt->totalPoints * 100;
					}

					if ( ($scoreA <= $scoreB ) ) {
						//slide remainder of scores up the stack
						$current = $valObj->idClassGradebookVal;
						$catSize = count($dropList[$catId]);
						for ($x=$blank;$x < $catSize; ++$x) {
							$tmp = $dropList[$catId][$x];
							$dropList[$catId][$x] = $current;
							$current = $tmp;
						}
						break;
//might not need these lines
//						$dropList[$catId][$blank] = $valObj->idClassGradebookVal;
//						$dropList[$catId][$blank+1] = $tmp;
					} else if ( !is_object($compareVal) ) {
						$dropList[$catId][$blank] = $valObj->idClassGradebookVal;
						break;
					}
				}
			}

			}

			//done finding lowest grades, now remove the IDs from the
			// vals array
			reset($dropList);
			while ( list ($catId,$ranks) = @each($dropList) ) {
				$rankSize = count($ranks);
				for ($y=0;$y < $rankSize; ++$y) {
					$entid = $this->vals[ $ranks[$y] ]->idClassGradebookEntries;
					$this->students[$username]->vals[ $entid ]->disqualified = true;

					//erase points
					$this->students[$username]->possiblePoints -= 
						$this->entries[$entid]->totalPoints;

					$this->students[$username]->totalPointsEarned -= 
						$this->students[$username]->vals[ $entid ]->score;
	
					$dropList[$catId][$y] = 0;
				}


				$this->students[$username]->possiblePoints = 
					($this->students[$username]->possiblePoints < 0) ?
					0 : $this->students[$username]->possiblePoints;

				$this->students[$username]->totalPointsEarned = 
					($this->students[$username]->totalPointsEarned < 0) ?
					0 : $this->students[$username]->totalPointsEarned;
			}
			reset($dropList);
		}
	}


	/**
	 * Does this gradebook have any categories that
	 * have a non-zero drop_count field ?
	 *
	 * @return boolean
	 */
	function requiresDrop() {
	// might  be working now 2-24-04
	//	return false;
		return $this->hasDropCount;
	}


	# Takes the categoryWeights array and goes
	# through it and updates each entry object
	function calculateEntryWeights()
	{
		foreach($this->entries AS $entryId => $entryObj)
		{
			$weight = $this->categoryWeights[$entryObj->idClassGradebookCategories]['weight'];
			$count = $this->categoryWeights[$entryObj->idClassGradebookCategories]['category_count'];
			# formula is $weight / $count
//echo "<!--weight=$weight / count=$count-->\n";
			// example
			// category is weight 12% for the total grade, and there are 3 entries
			// each entry counts as 4%
			@$entryObj->weightedPercent = sprintf("%0.2f", $weight / $count);
			$this->entries[$entryId] = $entryObj;
		}
		reset($this->entries);
	}



	/**
	 * Calculates averages for students if the gradebook is set to weighted percents
	 *
	 * Average the category weights so that whichever entries are present 
	 * are averaged to have the weight of their entire category.
	 */
	/* 
	function calculateWeightedAverages()
	{
		$stamp = time();
		# 1 = weighted
		if ($this->calculationType == 1)
		{

			$categoryPercentSums = array();
			reset($this->entries);
			while ( list($k,$v) = @each($this->entries) ) {
				$categoryPercentSums[ $v->idClassGradebookCategories ]['count'] ++;
			}
			foreach($this->students AS $username=>$stuObj)
			{
				//loop through the GB's definition of  how many entires there are
				// to get proper weights for the students

				foreach ($stuObj->vals AS $valId=>$valObj)
				{
					//don't count dropped grades
					if ($valObj->isDisqualified() ) {
						continue;
					}

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
					}

				}
				//once the vals are sorted by category, find the average
				foreach ($categoryPercentSums as $catid => $percentArray ) {
					if (!isset($percentArray['total']) ) { 
					continue;
				       	}

					$stuObj->weightedAverage += $percentArray['total'];
					$stuObj->catWeightTotals += sprintf('%.2f',$this->categoryWeights[$catid]['weight'] / $percentArray['count']) /100 
						* $stuObj->percentCount[$catid];
						
					//zero out values for next student
					$categoryPercentSums[$catid]['total'] = 0;

				}
//print "<!-- / "   .$stuObj->weightedAverage ." " . $stuObj->catWeightTotals ."-->\n\n";
				$stuObj->weightedAverage = $stuObj->weightedAverage / $stuObj->catWeightTotals;
				$stuObj->weightedAverage = sprintf('%.3f',$stuObj->weightedAverage);
				$this->students[$username] = $stuObj;
			}
		}
	}
//	*/



	/**
	 * Calculates averages for students if the gradebook is set to weighted percents
	 *
	 * Average the category weights so that whichever entries are present 
	 * are averaged to have the weight of their entire category.
	 */

        function calculateWeightedAverages()
        {
                $stamp = time();
                # 1 = weighted
                if ($this->calculationType != 1)
                {
			return;
		}
		reset($this->students);
		#debug($this->students);
		while(list($username,$stuObj) = each($this->students)) { 
#		foreach($this->students AS $username=>$stuObj) {
			if ( $stuObj->isWithdrawn() ) { continue; }
			$categoryPercentSums = array();
			$totalWeight =0;	// mgk 12/05/03
//print "<!-- calculateWeightedAverages \n";
		#print_r($stuObj->vals);
		#print " FOREACH1 -->\n";
			reset($stuObj->vals);
			foreach ($stuObj->vals as $valId=>$valObj) {
			// emmanual.aguas =- 3/1/04 -
			// he had a blank valId  - not sure how/how
			// put this check in - mgk - to make the system work again.
			if ($valId==0) { continue; }
				$entryObj = $this->entries[$valObj->idClassGradebookEntries];
//echo "<!--".$valObj->idClassGradebookEntries. " -- ".$valObj->score." - ".$entryObj->weightedPercent." class= ".get_class($valObj)." -->\n";
//print "<!-- calculateWeightedAverages FOREACH1 -->\n";
				if ( $valObj->isDisqualified() )  {
		#		echo "is dis<BR>";
					continue;
				}
//print "<!-- calculateWeightedAverages FOREACH2 -->\n";
				if ( $entryObj->publishFlag == 0 ) { 
		#		echo "is <BR>";
					continue; 
				}


				// don't count due dates that haven't passed yet, and have no score
				//if ( $entryObj->dateDue > $stamp && $valObj->score == 0 && $entryObj->dateDue > 0) { print "<!-- skipped grade -->\n"; continue; }
				//gone, we don't want this rule anymore.  Val Obj cleanliness is handled elsewhere

				//don't count extra credit
				if ( $entryObj->totalPoints > 0 ) {
				//store the sum of all value percentages for a particular category in an array
				//this algorithm was made by mike and mark


				// if a score is null, don't count it.
				$categoryPercentSums[ $entryObj->idClassGradebookCategories ]['total'] += $valObj->score / $entryObj->totalPoints * 100;
#				$categoryPercentSums[ $entryObj->idClassGradebookCategories ]['total'] += ($valObj->score / $entryObj->totalPoints) ;
				$categoryPercentSums[ $entryObj->idClassGradebookCategories ]['count'] ++;
				$categoryPercentSums[ $entryObj->idClassGradebookCategories ]['weight'] += $entryObj->weightedPercent;
				} else {
//print "<!-- one E/C grade -->\n"; 
				}

			}
			//once the vals are sorted by category, find the average
#			echo "<!--"; debug($categoryPercentSums); echo "-->\n\n";
// mgk 12/06/03 
// $totalWeight is what we divide by, not necessarily 100, because
// we might not have added to 100 yet (earlier in semester)???
	$totalPct=0;
			foreach ($categoryPercentSums as $catid => $percentArray ) {
				$totalPct += $this->categoryWeights[$catid]['weight'];
			}
			$tempAvg = 0;
			foreach ($categoryPercentSums as $catid => $percentArray ) {
				$divideby = $totalPct;
//print "<!-- ".$this->categoryWeights[$catid]['weight'] . " * (". $percentArray['total'] . " / ". $percentArray['count'].")/$divideby -->\n";

				$avg = ($this->categoryWeights[$catid]['weight']/100) * ($percentArray['total']/$percentArray['count']);
		#		$tempAvg += $this->categoryWeights[$catid]['weight'] *( $percentArray['total'] / $percentArray['count']);
				$tempAvg += $avg;
			}
			$tempAvg = ($tempAvg/$totalPct) * 100;
			$stuObj->weightedAverage = sprintf('%.3f',$tempAvg);
//print "<!-- ".$stuObj->weightedAverage ." -->\n";
			$this->students[$username] = $stuObj;
		}

//print "<!-- calculateWeightedAverages DONE -->\n";
        }
//*/






	# Calculates the 0-100 percent score for each student's
	# vals if they're grading absed on points
	function calculatePercentScores()
	{
		if ($this->calculationType != 1)
		{
			foreach ( $this->students as $username => $stuObj )
			{
				if ( $stuObj->isWithdrawn() ) { continue; }

				$score = $this->students[$username]->totalPointsEarned;
				$poss = $this->students[$username]->possiblePoints;
//print "<!-- ".$score. " / ". $poss. " -->\n";
				$this->students[$username]->percentAverage =
					sprintf('%0.2f', ($score/$poss)*100);
			}
		}
	}


	/**
	 * Percentage based gradebooks need to compare percentage
	 * of values done in them
	 */
	function isPercentageBased() {
		return $this->calculationType == 1;
	}

}



/**
 * wrapper for user objects so 
 * that the GB can work with them easier
 */
class ClassGradebookStudent {
	
	var $firstname ='';
	var $lastname = '';
	var $username = '';
	var $classRank = '';
	var $totalPointsEarned;
	var $totalPossiblePoints;
	var $active;
	var $dateWithdrawn;

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
		$x->userId = $array['pkey'];
		$x->dateWithdrawn = $array['dateWithdrawn'];
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

	/**
	 * return true if the student has a withdrawn date
	 */
	function isWithdrawn() {
		if ($this->active==0) { return false; }
		return $this->dateWithdrawn > 0;
	}


	//only count vals that have grades, if a grade is 0, then check the entry's due date.
	function getAllVals($idClasses, &$entries)
	{
		
		// create an array of empty val objects

		$val = ClassGradebookValPeer::doSelect(" id_classes=$idClasses and username = '".$this->username."'");
		foreach  ($val as $key => $gb_val_obj) {

// mgk 11/21/03
//
// have to determine if the student was withdrawn from the particular section
// after the dateDue of the entry
			$dateDue = $entries[$gb_val_obj->idClassGradebookEntries]->dateDue;
			if (intval($dateDue)>0) { 
				$db = db::GetHandle();
				$db->queryOne("select id_semesters, sectionNumbers from classes where id_classes=$idClasses");
				$j = $db->record[1];
				$temp = explode("\n",$j);
				$x = "sectionNumber=".implode(" or sectionNumber=", $temp);
				$sql = "select dateWithdrawn from class_student_sections where id_student='".$this->username."' and semester_id='".$db->record['id_semesters']."' and ($x)";
				$db->queryOne($sql);
				$date = '';
				$dateWithdrawn = $db->record[0];
// FIXME - not done yet
			#	echo $this->username." withdrew on $dateWithdrawn<BR>";


			}



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
