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


	function addStudent($studentId, $sectionNumber=0) {
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

		if ($sectionNumber > 0 ) {
			$enrollmentDo->set('sectionNumber',$sectionNumber);
		}

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


	function withdrawStudent($studentId,$sectionNumber=0) {
		$studentId = (int)$studentId;
		foreach ($this->classEnrollmentDos as $idx => $do) {
			if ($do->get('studentId') ==  $studentId) {
				if ($sectionNumber > 0) { 
					if ($do->get('sectionNumber') == $sectionNumber ) {
						$do->set('active',0);
						$do->set('withdrewOn',time());
						$this->classEnrollmentDos[$idx] = $do;
						return true;
					}
				} else {
					$do->set('active',0);
					$do->set('withdrewOn',time());
					$this->classEnrollmentDos[$idx] = $do;
					return true;
				}
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


	/**
	 * get a count of currently enrolled students
	 * @static
	 */
	function getEnrollmentCount() {
		$db = DB::getHandle();
		$db->query("SELECT count(*) as total
			FROM class_enrollment AS A
			LEFT JOIN semesters AS B ON A.semester_id = B.semesterId
			WHERE active=1
			AND B.dateEnd >= NOW()");
		$db->nextRecord();
		$db->freeResult();
		return $db->record['total'];
	}


	/**
	 * get a count of students
	 * @static
	 */
	function getStudentCount() {
		$db = DB::getHandle();
		$db->query("SELECT count(*) as total
			FROM lcUsers AS A
			WHERE userType=".USERTYPE_STUDENT);
		$db->nextRecord();
		$db->freeResult();
		return $db->record['total'];
	}


	function getEnrollmentHistoryForStudent($studentId, $semesterId=-1) {
		if ($this->semesterId > -1 ){
			$this->classEnrollmentDos = ClassEnrollmentPeer::doSelect(' student_id = '.$studentId. ' AND semester_id = '.$semesterId);
		} else {
			$this->classEnrollmentDos = ClassEnrollmentPeer::doSelect(' student_id = '.$studentId);
		}
	}

}

?>
