<?

class EvaluationFormBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.7';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $serialNo;
	var $question;
	var $visible;
	var $excellent;
	var $veryGood;
	var $good;
	var $satisfactory;
	var $unsatisfactory;
	var $dateCreated;
	var $weightage;

	var $__attributes = array( 
	'serialNo'=>'integer',
	'question'=>'varchar',
	'visible'=>'tinyint',
	'excellent'=>'tinyint',
	'veryGood'=>'tinyint',
	'good'=>'tinyint',
	'satisfactory'=>'tinyint',
	'unsatisfactory'=>'tinyint',
	'dateCreated'=>'datetime',
	'weightage'=>'integer');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->serialNo;
	}


	function setPrimaryKey($val) {
		$this->serialNo = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(EvaluationFormPeer::doInsert($this,$dsn));
		} else {
			EvaluationFormPeer::doUpdate($this,$dsn);
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
			$where = "serial_no='".$key."'";
		}
		$array = EvaluationFormPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = EvaluationFormPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		EvaluationFormPeer::doDelete($this,$deep,$dsn);
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


class EvaluationFormPeerBase {

	var $tableName = 'evaluation_form';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("evaluation_form",$where);
		$st->fields['serial_no'] = 'serial_no';
		$st->fields['question'] = 'question';
		$st->fields['visible'] = 'visible';
		$st->fields['excellent'] = 'excellent';
		$st->fields['very_good'] = 'very_good';
		$st->fields['good'] = 'good';
		$st->fields['satisfactory'] = 'satisfactory';
		$st->fields['unsatisfactory'] = 'unsatisfactory';
		$st->fields['date_created'] = 'date_created';
		$st->fields['weightage'] = 'weightage';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = EvaluationFormPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("evaluation_form");
		$st->fields['serial_no'] = $obj->serialNo;
		$st->fields['question'] = $obj->question;
		$st->fields['visible'] = $obj->visible;
		$st->fields['excellent'] = $obj->excellent;
		$st->fields['very_good'] = $obj->veryGood;
		$st->fields['good'] = $obj->good;
		$st->fields['satisfactory'] = $obj->satisfactory;
		$st->fields['unsatisfactory'] = $obj->unsatisfactory;
		$st->fields['date_created'] = $obj->dateCreated;
		$st->fields['weightage'] = $obj->weightage;


		$st->key = 'serial_no';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("evaluation_form");
		$st->fields['serial_no'] = $obj->serialNo;
		$st->fields['question'] = $obj->question;
		$st->fields['visible'] = $obj->visible;
		$st->fields['excellent'] = $obj->excellent;
		$st->fields['very_good'] = $obj->veryGood;
		$st->fields['good'] = $obj->good;
		$st->fields['satisfactory'] = $obj->satisfactory;
		$st->fields['unsatisfactory'] = $obj->unsatisfactory;
		$st->fields['date_created'] = $obj->dateCreated;
		$st->fields['weightage'] = $obj->weightage;


		$st->key = 'serial_no';
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
		$st = new PBDO_DeleteStatement("evaluation_form","serial_no = '".$obj->getPrimaryKey()."'");

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
		$x = new EvaluationForm();
		$x->serialNo = $row['serial_no'];
		$x->question = $row['question'];
		$x->visible = $row['visible'];
		$x->excellent = $row['excellent'];
		$x->veryGood = $row['very_good'];
		$x->good = $row['good'];
		$x->satisfactory = $row['satisfactory'];
		$x->unsatisfactory = $row['unsatisfactory'];
		$x->dateCreated = $row['date_created'];
		$x->weightage = $row['weightage'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class EvaluationForm extends EvaluationFormBase {



}



class EvaluationFormPeer extends EvaluationFormPeerBase {

}

?>