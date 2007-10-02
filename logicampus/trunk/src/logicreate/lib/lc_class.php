<?php

include_once(LIB_PATH.'PBDO/Classes.php');
include_once(LIB_PATH.'semesterObj.php');
include_once(LIB_PATH.'lc_lesson.php');

class lcClass {

	var $lessons = array();
	var $classId = -1;
	var $classDo = null;
	var $startDate = 0;
	var $endDate = 0;

	/**
	 * Load up a Classes data object
	 */
	function lcClass ($classId=0) {
		if ($classId > 0 ) {
			$this->classDo = Classes::load($classId);
		} else {
			$this->classDo = new Classes();
		}
		$this->classId = $classId;
		//load up the start and end dates for this class
		if ($this->classDo->idSemesters > 0) {
			$semester = semesterObj::_getFromDB($this->classDo->idSemesters,'id_semesters');
			$this->startDate = strtotime($semester->dateStart);
			$this->endDate = strtotime($semester->dateStart);
		} else {
		//load up the start and end dates of this student's enrollment
		}
	}

	/**
	 * Load a LC_Lesson object
	 *
	 * @return boolean true if the class was loaded with no problems
	 */
	function loadLesson($lessonId) {
		$this->lessons[$lessonId] = new LC_Lesson($lessonId);
		if ($this->lessons[$lessonId]->lessonDo->idClasses != $this->classId) {
			unset($this->lessons[$lessonId]);
			return false;
		}
		return true;
	}

	/**
	 * returns an array of classes 
	 * In simple mode this will return all classes regardless of semester.
	 * In full mode this will return all classes for the current semester.
	 * If passed a semseter, it will return classes only for that semester.
	 *
	 * @static
	 */
	function getAvailableClasses($semesterId=0) {

		$db = DB::getHandle();

		$sql = "SELECT
		cs.*, semesters.semesterID, courses.courseName 

		FROM classes as cs
		LEFT JOIN courses ON cs.id_courses = courses.id_courses
		LEFT JOIN semesters ON cs.id_semesters = semesters.id_semesters
		";


		if(LcSettings::isModuleOff('LOGICAMPUS_SIMPLE_MODE')){
			$sql .="
			and semesters.dateAccountActivation < ".DB::getFuncName('NOW()')."
			and semesters.dateDeactivation > ".DB::getFuncName('NOW()')."
			";
		}

		$sql .= "
		ORDER BY courses.courseFamily, courses.courseNumber, courseName";

		$db->query($sql);
		while ($db->nextRecord() ) {

			$temp = PersistantObject::createFromArray('classObj',$db->record);
			$temp->_dsn = $dsn;
			$temp->__loaded = true; 
			$ret[] = $temp;
		}
		return $ret;
	}


	/**
	 * returns an array of classes that this teacher has access to
	 * In simple mode this will return all classes regardless of semester.
	 * In full mode this will return all classes for the current semester.
	 *
	 * @static
	 */
	function getActiveClassesForFaculty($facultyUsername) {
		$db = DB::getHandle();


		$sql = "SELECT
		cs.*, semesters.semesterID, courses.courseName 

		FROM classes as cs
		LEFT JOIN courses ON cs.id_courses = courses.id_courses
		LEFT JOIN semesters ON cs.id_semesters = semesters.id_semesters
		LEFT JOIN profile on cs.facultyId=profile.username
		LEFT JOIN profile_faculty on profile_faculty.username=profile.username

		WHERE cs.facultyId = '$facultyUsername'
		";


		if(LcSettings::isModuleOff('LOGICAMPUS_SIMPLE_MODE')){
			$sql .="
			and semesters.dateAccountActivation < ".DB::getFuncName('NOW()')."
			and semesters.dateDeactivation > ".DB::getFuncName('NOW()')."
			";
		}

		$db->query($sql);
		while ($db->nextRecord() ) {

			$temp = PersistantObject::createFromArray('classObj',$db->record);
			$temp->_dsn = $dsn;
			$temp->__loaded = true; 
			$ret[] = $temp;
		}
		return $ret;
	}


	/**
	 * Used to populate classesTaken array
	 */
	function getActiveClassesForStudent($studentUsername) {
		$db = DB::getHandle();

		$sql = "SELECT classes.*, semesters.semesterID,courses.courseName, 
		profile_faculty.title, profile.firstname, profile.lastname

		FROM class_enrollment as E
		LEFT JOIN class_sections ON E.section_number = class_sections.sectionNumber
		LEFT JOIN classes ON E.class_id = classes.id_classes
		LEFT JOIN courses ON classes.id_courses = courses.id_courses
		LEFT JOIN semesters ON classes.id_semesters = semesters.id_semesters
		LEFT JOIN profile ON classes.facultyId=profile.username
		LEFT JOIN profile_faculty ON profile_faculty.username=profile.username
		LEFT JOIN lcUsers AS U ON U.pkey = E.student_id

		WHERE U.username = '$studentUsername'
		AND E.active = 1
		AND class_sections.id_classes = E.class_id";


		if(LcSettings::isModuleOff('LOGICAMPUS_SIMPLE_MODE')){
			$sql .="
			AND semesters.dateAccountActivation < ".DB::getFuncName('NOW()')."
			AND semesters.dateDeactivation > ".DB::getFuncName('NOW()')."
			";
		}

		$db->query($sql);
		$ret = array();
		while ($db->nextRecord() ) {
			$temp = PersistantObject::createFromArray('classObj',$db->record);
			$temp->_dsn = $dsn;
			$temp->__loaded = true; 
			$ret[] = $temp;
		}
		return $ret;
	}

	/**
	 * get a count of currently running classes
	 * @static
	 */
	function getClassCount() {
		$db = DB::getHandle();
		$db->query("SELECT count(*) as total
			FROM classes AS A
			LEFT JOIN semesters AS B ON A.id_semesters = B.id_semesters
			WHERE 1=1
			AND B.dateEnd >= NOW()");
		$db->nextRecord();
		$db->freeResult();
		return $db->record['total'];
	}


	/**
	 * get a count of courses 
	 * @static
	 */
	function getCourseCount() {
		$db = DB::getHandle();
		$db->query("SELECT count(*) as total
			FROM courses");
		$db->nextRecord();
		$db->freeResult();
		return $db->record['total'];
	}


	function makeUniqueCode($lessonObj) {
		return   $lessonObj->courseFamilyNumber 
			. '_'. $lessonObj->id_classes
			. '_'. $lessonObj->id_courses;
			
	}

	/**
	 * Determine the amount of time this student
	 * has been in this class.
	 *
	 * Use either the class' semester start date, or the students enrollment
	 * date.
	 *
	 * @static
	 */
	function calcOffsetForStudent($studentRecord, $classId, $semesterId=-1) {
		if ($semesterId == -1) {
			//use student's enrollment date
		} else {
			//use the semester's start date
			$db = DB::getHandle();
			$db->query("SELECT dateStart, dateEnd
				FROM semesters 
				WHERE semesterID = '".$semesterId."'");
			$db->nextRecord();
			$db->freeResult();
			$ut = time();

			$startTs = strtotime($db->record['dateStart']);
			$endTs   = strtotime($db->record['dateEnd']);
			return array ('start'=> ($ut - $startTs), 'end'=>($ut-$endTs));
			debug( strtotime($db->record['dateStart']),1);
		}

	}
}

?>
