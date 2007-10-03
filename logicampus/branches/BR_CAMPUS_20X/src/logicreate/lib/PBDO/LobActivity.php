<?

class LobActivityBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lobActivityId;
	var $lobRepoEntryId;
	var $responseTypeId;

	var $__attributes = array( 
	'lobActivityId'=>'integer',
	'lobRepoEntryId'=>'integer',
	'responseTypeId'=>'tinyint');

	var $__nulls = array();

	/**
	 * Retrieves one lob_repo_entry object via the foreign key lob_repo_entry_id.
	 * 
	 * @param String $dsn the name of the data source to use for the sql query.
	 * @return Object the related object.
	 */
	function getLobRepoEntryByLobRepoEntryId($dsn='default') {
		if ( $this->lobRepoEntryId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = LobRepoEntryPeer::doSelect('lob_repo_entry_id = \''.$this->lobRepoEntryId.'\'',$dsn);
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->lobActivityId;
	}


	function setPrimaryKey($val) {
		$this->lobActivityId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LobActivityPeer::doInsert($this,$dsn));
		} else {
			LobActivityPeer::doUpdate($this,$dsn);
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
			$where = "lob_activity_id='".$key."'";
		}
		$array = LobActivityPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LobActivityPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LobActivityPeer::doDelete($this,$deep,$dsn);
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


class LobActivityPeerBase {

	var $tableName = 'lob_activity';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lob_activity",$where);
		$st->fields['lob_activity_id'] = 'lob_activity_id';
		$st->fields['lob_repo_entry_id'] = 'lob_repo_entry_id';
		$st->fields['response_type_id'] = 'response_type_id';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LobActivityPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lob_activity");
		$st->fields['lob_activity_id'] = $this->lobActivityId;
		$st->fields['lob_repo_entry_id'] = $this->lobRepoEntryId;
		$st->fields['response_type_id'] = $this->responseTypeId;


		$st->key = 'lob_activity_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lob_activity");
		$st->fields['lob_activity_id'] = $obj->lobActivityId;
		$st->fields['lob_repo_entry_id'] = $obj->lobRepoEntryId;
		$st->fields['response_type_id'] = $obj->responseTypeId;


		$st->key = 'lob_activity_id';
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
		$st = new PBDO_DeleteStatement("lob_activity","lob_activity_id = '".$obj->getPrimaryKey()."'");

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
		$x = new LobActivity();
		$x->lobActivityId = $row['lob_activity_id'];
		$x->lobRepoEntryId = $row['lob_repo_entry_id'];
		$x->responseTypeId = $row['response_type_id'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LobActivity extends LobActivityBase {



}



class LobActivityPeer extends LobActivityPeerBase {

}

?>