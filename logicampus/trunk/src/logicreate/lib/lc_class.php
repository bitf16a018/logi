<?php


class LC_Class {


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
		AND E.active = 1";


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
}

?>
