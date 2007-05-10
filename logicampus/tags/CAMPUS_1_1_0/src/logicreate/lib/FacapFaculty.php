<?

class FacapFacultyBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $idFacapFaculty;
	var $idCourse;
	var $username;
	var $semesterTerm;
	var $semesterYear;
	var $instructionType;
	var $currentFacultyId;
	var $newFacultyName;
	var $newFacultyPhone;
	var $changeType;
	var $changeDuration;
	var $changeReason;
	var $facultyNotified;
	var $facultyCompletedTraining;
	var $createdOn;
	var $status;

	var $__attributes = array(
	'idFacapFaculty'=>'int',
	'idCourse'=>'int',
	'username'=>'varchar',
	'semesterTerm'=>'varchar',
	'semesterYear'=>'varchar',
	'instructionType'=>'varchar',
	'currentFacultyId'=>'varchar',
	'newFacultyName'=>'varchar',
	'newFacultyPhone'=>'char',
	'changeType'=>'varchar',
	'changeDuration'=>'varchar',
	'changeReason'=>'text',
	'facultyNotified'=>'char',
	'facultyCompletedTraining'=>'char',
	'createdOn'=>'datetime',
	'status'=>'varchar');

	function getFacapFacultyActions() {
		$array = FacapFacultyActionPeer::doSelect('id_facap_faculty = \''.$this->getPrimaryKey().'\'');
		return $array;
	}



	function getPrimaryKey() {
		return $this->idFacapFaculty;
	}

	function setPrimaryKey($val) {
		$this->idFacapFaculty = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(FacapFacultyPeer::doInsert($this));
		} else {
			FacapFacultyPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_facap_faculty='".$key."'";
		}
		$array = FacapFacultyPeer::doSelect($where);
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
		if ($array['idCourse'])
			$this->idCourse = $array['idCourse'];
		if ($array['username'])
			$this->username = $array['username'];
		if ($array['semesterTerm'])
			$this->semesterTerm = $array['semesterTerm'];
		if ($array['semesterYear'])
			$this->semesterYear = $array['semesterYear'];
		if ($array['instructionType'])
			$this->instructionType = $array['instructionType'];
		if ($array['currentFacultyId'])
			$this->currentFacultyId = $array['currentFacultyId'];
		if ($array['newFacultyName'])
			$this->newFacultyName = $array['newFacultyName'];
		if ($array['newFacultyPhone'])
			$this->newFacultyPhone = $array['newFacultyPhone'];
		if ($array['changeType'])
			$this->changeType = $array['changeType'];
		if ($array['changeDuration'])
			$this->changeDuration = $array['changeDuration'];
		if ($array['changeReason'])
			$this->changeReason = $array['changeReason'];
		if ($array['facultyNotified'])
			$this->facultyNotified = $array['facultyNotified'];
		if ($array['facultyCompletedTraining'])
			$this->facultyCompletedTraining = $array['facultyCompletedTraining'];
		if ($array['createdOn'])
			$this->createdOn = $array['createdOn'];
		if ($array['status'])
			$this->status = $array['status'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class FacapFacultyPeerBase {

	var $tableName = 'facap_faculty';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("facap_faculty",$where);
		$st->fields['id_facap_faculty'] = 'id_facap_faculty';
		$st->fields['id_course'] = 'id_course';
		$st->fields['username'] = 'username';
		$st->fields['semester_term'] = 'semester_term';
		$st->fields['semester_year'] = 'semester_year';
		$st->fields['instruction_type'] = 'instruction_type';
		$st->fields['current_faculty_id'] = 'current_faculty_id';
		$st->fields['new_faculty_name'] = 'new_faculty_name';
		$st->fields['new_faculty_phone'] = 'new_faculty_phone';
		$st->fields['change_type'] = 'change_type';
		$st->fields['change_duration'] = 'change_duration';
		$st->fields['change_reason'] = 'change_reason';
		$st->fields['faculty_notified'] = 'faculty_notified';
		$st->fields['faculty_completed_training'] = 'faculty_completed_training';
		$st->fields['created_on'] = 'created_on';
		$st->fields['status'] = 'status';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = FacapFacultyPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("facap_faculty");
		$st->fields['id_facap_faculty'] = $this->idFacapFaculty;
		$st->fields['id_course'] = $this->idCourse;
		$st->fields['username'] = $this->username;
		$st->fields['semester_term'] = $this->semesterTerm;
		$st->fields['semester_year'] = $this->semesterYear;
		$st->fields['instruction_type'] = $this->instructionType;
		$st->fields['current_faculty_id'] = $this->currentFacultyId;
		$st->fields['new_faculty_name'] = $this->newFacultyName;
		$st->fields['new_faculty_phone'] = $this->newFacultyPhone;
		$st->fields['change_type'] = $this->changeType;
		$st->fields['change_duration'] = $this->changeDuration;
		$st->fields['change_reason'] = $this->changeReason;
		$st->fields['faculty_notified'] = $this->facultyNotified;
		$st->fields['faculty_completed_training'] = $this->facultyCompletedTraining;
		$st->fields['created_on'] = $this->createdOn;
		$st->fields['status'] = $this->status;

		$st->key = 'id_facap_faculty';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("facap_faculty");
		$st->fields['id_facap_faculty'] = $obj->idFacapFaculty;
		$st->fields['id_course'] = $obj->idCourse;
		$st->fields['username'] = $obj->username;
		$st->fields['semester_term'] = $obj->semesterTerm;
		$st->fields['semester_year'] = $obj->semesterYear;
		$st->fields['instruction_type'] = $obj->instructionType;
		$st->fields['current_faculty_id'] = $obj->currentFacultyId;
		$st->fields['new_faculty_name'] = $obj->newFacultyName;
		$st->fields['new_faculty_phone'] = $obj->newFacultyPhone;
		$st->fields['change_type'] = $obj->changeType;
		$st->fields['change_duration'] = $obj->changeDuration;
		$st->fields['change_reason'] = $obj->changeReason;
		$st->fields['faculty_notified'] = $obj->facultyNotified;
		$st->fields['faculty_completed_training'] = $obj->facultyCompletedTraining;
		$st->fields['created_on'] = $obj->createdOn;
		$st->fields['status'] = $obj->status;

		$st->key = 'id_facap_faculty';
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
		$st = new LC_DeleteStatement("facap_faculty","id_facap_faculty = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

			$st = new LC_DeleteStatement("facap_faculty_action","id_facap_faculty = '".$obj->getPrimaryKey()."'");
			$db->executeQuery($st);
		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new FacapFaculty();
		$x->idFacapFaculty = $row['id_facap_faculty'];
		$x->idCourse = $row['id_course'];
		$x->username = $row['username'];
		$x->semesterTerm = $row['semester_term'];
		$x->semesterYear = $row['semester_year'];
		$x->instructionType = $row['instruction_type'];
		$x->currentFacultyId = $row['current_faculty_id'];
		$x->newFacultyName = $row['new_faculty_name'];
		$x->newFacultyPhone = $row['new_faculty_phone'];
		$x->changeType = $row['change_type'];
		$x->changeDuration = $row['change_duration'];
		$x->changeReason = $row['change_reason'];
		$x->facultyNotified = $row['faculty_notified'];
		$x->facultyCompletedTraining = $row['faculty_completed_training'];
		$x->createdOn = $row['created_on'];
		$x->status = $row['status'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class FacapFaculty extends FacapFacultyBase {



}



class FacapFacultyPeer extends FacapFacultyPeerBase {

}

?>