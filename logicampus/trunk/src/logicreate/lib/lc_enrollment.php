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


	function lcClassEnrollment($classId=0, $semesterId=-1) {
		$this->classId = (int)$classId;
		$this->semesterId = (int)$semesterId;
		if ($this->semesterId > -1 ){
			$this->classEnrollmentDos = ClassEnrollmentPeer::doSelect(' class_id = '.$this->classId. ' AND semester_id = '.$this->semesterId);
		} else {
			$this->classEnrollmentDos = ClassEnrollmentPeer::doSelect(' class_id = '.$this->classId);
		}
	}


	function save() {
		foreach ($this->classEnrollmentDos as $do) {
			if ($do->isNew() || $do->isModified()) {
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


	function removeStudent($studentId) {
		$studentId = (int)$studentId;
		foreach ($this->classEnrollmentDos as $do) {
			if ($do->get('studentId') ==  $studentId) {
				$do->delete();
				return true;
			}
		}
		return false;
	}


	/**
	 * returns 0 or 1
	 */
	function isStudentActive($studentId) {
		$studentId = (int)$studentId;
		foreach ($this->classEnrollmentDos as $do) {
			if ($do->get('studentId') ==  $studentId) {
				return $do->get('active');
			}
		}
		return 0;
	}


	/**
	 * set student active
	 */
	function activateStudent($studentId, $active=1) {
		$studentId = (int)$studentId;
		foreach ($this->classEnrollmentDos as $k=> $do) {
			if ($do->get('studentId') ==  $studentId) {
				if ($active) {
					$do->set('active',1);
					$do->set('enrolledOn',time());
				} else {
					$do->set('active',0);
					$do->set('withdrewOn',time());
				}
				$this->classEnrollmentDos[$k] = $do;
			}
		}
	}


	function deActivateStudent($studentId) {
		$this->activateStudent($studentId,0);
	}
}

?>
