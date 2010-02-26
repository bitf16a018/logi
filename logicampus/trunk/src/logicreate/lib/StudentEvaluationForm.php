<?

class StudentEvaluationFormBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.7';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $id;
	var $studentId;
	var $idClasses;
	var $serialNo;
	var $rank;

	var $__attributes = array( 
	'id'=>'integer',
	'studentId'=>'integer',
	'idClasses'=>'integer',
	'serialNo'=>'integer',
	'rank'=>'integer');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->;
	}


	function setPrimaryKey($val) {
		$this-> = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(StudentEvaluationFormPeer::doInsert($this,$dsn));
		} else {
			StudentEvaluationFormPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		$where = '';
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "='".$key."'";
		}
		$array = StudentEvaluationFormPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = StudentEvaluationFormPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		StudentEvaluationFormPeer::doDelete($this,$deep,$dsn);
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


class StudentEvaluationFormPeerBase {

	var $tableName = 'student_evaluation_form';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("student_evaluation_form",$where);
		$st->fields['id'] = 'id';
		$st->fields['student_id'] = 'student_id';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['serial_no'] = 'serial_no';
		$st->fields['rank'] = 'rank';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = StudentEvaluationFormPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("student_evaluation_form");
		$st->fields['id'] = $obj->id;
		$st->fields['student_id'] = $obj->studentId;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['serial_no'] = $obj->serialNo;
		$st->fields['rank'] = $obj->rank;


		$st->key = '';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("student_evaluation_form");
		$st->fields['id'] = $obj->id;
		$st->fields['student_id'] = $obj->studentId;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['serial_no'] = $obj->serialNo;
		$st->fields['rank'] = $obj->rank;


		$st->key = '';
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
		$st = new PBDO_DeleteStatement("student_evaluation_form"," = '".$obj->getPrimaryKey()."'");

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
		$x = new StudentEvaluationForm();
		$x->id = $row['id'];
		$x->studentId = $row['student_id'];
		$x->idClasses = $row['id_classes'];
		$x->serialNo = $row['serial_no'];
		$x->rank = $row['rank'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class StudentEvaluationForm extends StudentEvaluationFormBase {



}



class StudentEvaluationFormPeer extends StudentEvaluationFormPeerBase {

}

?>