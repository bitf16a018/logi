<?

class LobTestQstBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.7';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lobTestQstId;
	var $lobTestId;
	var $qstText;
	var $qstChoices;
	var $questionTypeId;
	var $qstPoints;

	var $__attributes = array( 
	'lobTestQstId'=>'integer',
	'lobTestId'=>'integer',
	'qstText'=>'text',
	'qstChoices'=>'text',
	'questionTypeId'=>'tinyint',
	'qstPoints'=>'tinyint');

	var $__nulls = array();

	/**
	 * Retrieves one lob_test object via the foreign key lob_test_id.
	 * 
	 * @param String $dsn the name of the data source to use for the sql query.
	 * @return Object the related object.
	 */
	function getLobTestByLobTestId($dsn='default') {
		if ( $this->lobTestId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = LobTestPeer::doSelect('lob_test_id = \''.$this->lobTestId.'\'',$dsn);
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->lobTestQstId;
	}


	function setPrimaryKey($val) {
		$this->lobTestQstId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LobTestQstPeer::doInsert($this,$dsn));
		} else {
			LobTestQstPeer::doUpdate($this,$dsn);
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
			$where = "lob_test_qst_id='".$key."'";
		}
		$array = LobTestQstPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LobTestQstPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LobTestQstPeer::doDelete($this,$deep,$dsn);
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


class LobTestQstPeerBase {

	var $tableName = 'lob_test_qst';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lob_test_qst",$where);
		$st->fields['lob_test_qst_id'] = 'lob_test_qst_id';
		$st->fields['lob_test_id'] = 'lob_test_id';
		$st->fields['qst_text'] = 'qst_text';
		$st->fields['qst_choices'] = 'qst_choices';
		$st->fields['question_type_id'] = 'question_type_id';
		$st->fields['qst_points'] = 'qst_points';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LobTestQstPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lob_test_qst");
		$st->fields['lob_test_qst_id'] = $obj->lobTestQstId;
		$st->fields['lob_test_id'] = $obj->lobTestId;
		$st->fields['qst_text'] = $obj->qstText;
		$st->fields['qst_choices'] = $obj->qstChoices;
		$st->fields['question_type_id'] = $obj->questionTypeId;
		$st->fields['qst_points'] = $obj->qstPoints;


		$st->key = 'lob_test_qst_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lob_test_qst");
		$st->fields['lob_test_qst_id'] = $obj->lobTestQstId;
		$st->fields['lob_test_id'] = $obj->lobTestId;
		$st->fields['qst_text'] = $obj->qstText;
		$st->fields['qst_choices'] = $obj->qstChoices;
		$st->fields['question_type_id'] = $obj->questionTypeId;
		$st->fields['qst_points'] = $obj->qstPoints;


		$st->key = 'lob_test_qst_id';
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
		$st = new PBDO_DeleteStatement("lob_test_qst","lob_test_qst_id = '".$obj->getPrimaryKey()."'");

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
	function doQuery($sql,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);

		$db->query($sql);

	  	return;
	}



	function row2Obj($row) {
		$x = new LobTestQst();
		$x->lobTestQstId = $row['lob_test_qst_id'];
		$x->lobTestId = $row['lob_test_id'];
		$x->qstText = $row['qst_text'];
		$x->qstChoices = $row['qst_choices'];
		$x->questionTypeId = $row['question_type_id'];
		$x->qstPoints = $row['qst_points'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LobTestQst extends LobTestQstBase {



}



class LobTestQstPeer extends LobTestQstPeerBase {

}

?>
