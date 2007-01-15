<?php

include_once(LIB_PATH.'PBDO/ClassEnrollment.php');
include_once(LIB_PATH.'PBDO/ClassEnrollment.php');

/**
 * Userland wrapper for PBOD/ClassEnrollment
 */
class lcClassEnrollment {

	var $classId = -1;
	var $semesterId = -1;
	var $classEnrollmentDos= array();

	function lcClassEnrollment($classId=0, $semesterId=0) {
		$this->classId = (int)$classId;
		$this->semesterId = (int)$semesterId;
		if ($this->semesterId > 0 ){
			$this->classEnrollmentDos = ClassEnrollmentPeer::doSelect(' class_id = '.$this->classId. ' AND semester_id = '.$this->semesterId);
		} else {
			$this->classEnrollmentDos = ClassEnrollmentPeer::doSelect(' class_id = '.$this->classId);
		}
	}

	function save() {
		foreach ($this->classEnrollmentDos as $do) {
			if ($do->isNew()) {
				$do->save();
			}
		}
	}

	function addStudent($studentId) {
		$studentId = (int)$studentId;
		foreach ($this->classEnrollmentDos as $do) {
			if ($do->get('studentId') ==  $studentId) {
				return false;
			}
		}
		$enrollmentDo = new ClassEnrollment();
		$enrollmentDo->set('studentId', $studentId);
		$enrollmentDo->set('classId', $this->classId);
		$enrollmentDo->set('enrolledOn', time());
		$enrollmentDo->set('active',true);
		if ($this->semesterId >0 ) {
			$enrollmentDo->set('semesterId', $this->semesterId);
		}
		$this->classEnrollmentDos[] = $enrollmentDo;
		return true;
	}
}

?>
