<?php


class LC_Class {


	/**
	 * returns an array of classes that this teacher has access to
	 * In simple mode this will return all classes regardless of semester.
	 * In full mode this will return all classes for the current semester.
	 *
	 * @static
	 */
	function getActiveClassesForFaculty($facultyId) {
		$db = DB::getHandle();


		$sql = "SELECT
		cs.*, semesters.semesterID, courses.courseName 

		FROM classes as cs
		LEFT JOIN courses ON cs.id_courses = courses.id_courses
		LEFT JOIN semesters ON cs.id_semesters = semesters.id_semesters
		LEFT JOIN profile on cs.facultyId=profile.username
		LEFT JOIN profile_faculty on profile_faculty.username=profile.username

		WHERE cs.facultyId = '$facultyId'
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
}

?>
