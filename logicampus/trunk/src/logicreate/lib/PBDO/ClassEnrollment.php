<?

class ClassEnrollmentBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $classEnrollmentId;
	var $studentId;
	var $semesterId;
	var $classId;
	var $sectionNumber;
	var $enrolledOn;
	var $active;
	var $withdrewOn;

	var $__attributes = array( 
	'classEnrollmentId'=>'int',
	'studentId'=>'int',
	'semesterId'=>'int',
	'classId'=>'int',
	'sectionNumber'=>'int',
	'enrolledOn'=>'int',
	'active'=>'int',
	'withdrewOn'=>'int');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->withdrewOn;
	}


	function setPrimaryKey($val) {
		$this->withdrewOn = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassEnrollmentPeer::doInsert($this,$dsn));
		} else {
			ClassEnrollmentPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "withdrew_on='".$key."'";
		}
		$array = ClassEnrollmentPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassEnrollmentPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassEnrollmentPeer::doDelete($this,$deep,$dsn);
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


class ClassEnrollmentPeerBase {

	var $tableName = 'class_enrollment';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_enrollment",$where);
		$st->fields['class_enrollment_id'] = 'class_enrollment_id';
		$st->fields['student_id'] = 'student_id';
		$st->fields['semester_id'] = 'semester_id';
		$st->fields['class_id'] = 'class_id';
		$st->fields['section_number'] = 'section_number';
		$st->fields['enrolled_on'] = 'enrolled_on';
		$st->fields['active'] = 'active';
		$st->fields['withdrew_on'] = 'withdrew_on';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassEnrollmentPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_enrollment");
		$st->fields['class_enrollment_id'] = $this->classEnrollmentId;
		$st->fields['student_id'] = $this->studentId;
		$st->fields['semester_id'] = $this->semesterId;
		$st->fields['class_id'] = $this->classId;
		$st->fields['section_number'] = $this->sectionNumber;
		$st->fields['enrolled_on'] = $this->enrolledOn;
		$st->fields['active'] = $this->active;
		$st->fields['withdrew_on'] = $this->withdrewOn;


		$st->key = 'withdrew_on';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_enrollment");
		$st->fields['class_enrollment_id'] = $obj->classEnrollmentId;
		$st->fields['student_id'] = $obj->studentId;
		$st->fields['semester_id'] = $obj->semesterId;
		$st->fields['class_id'] = $obj->classId;
		$st->fields['section_number'] = $obj->sectionNumber;
		$st->fields['enrolled_on'] = $obj->enrolledOn;
		$st->fields['active'] = $obj->active;
		$st->fields['withdrew_on'] = $obj->withdrewOn;


		$st->key = 'withdrew_on';
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
		$st = new PBDO_DeleteStatement("class_enrollment","withdrew_on = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassEnrollment();
		$x->classEnrollmentId = $row['class_enrollment_id'];
		$x->studentId = $row['student_id'];
		$x->semesterId = $row['semester_id'];
		$x->classId = $row['class_id'];
		$x->sectionNumber = $row['section_number'];
		$x->enrolledOn = $row['enrolled_on'];
		$x->active = $row['active'];
		$x->withdrewOn = $row['withdrew_on'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassEnrollment extends ClassEnrollmentBase {



}



class ClassEnrollmentPeer extends ClassEnrollmentPeerBase {

}

?>