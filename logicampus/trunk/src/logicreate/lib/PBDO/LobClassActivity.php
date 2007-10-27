<?

class LobClassActivityBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lobClassActivityId;
	var $lobClassRepoId;
	var $responseTypeId;

	var $__attributes = array( 
	'lobClassActivityId'=>'integer',
	'lobClassRepoId'=>'integer',
	'responseTypeId'=>'tinyint');

	var $__nulls = array();

	/**
	 * Retrieves one lob_class_repo object via the foreign key lob_class_repo_id.
	 * 
	 * @param String $dsn the name of the data source to use for the sql query.
	 * @return Object the related object.
	 */
	function getLobClassRepoByLobClassRepoId($dsn='default') {
		if ( $this->lobClassRepoId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = LobClassRepoPeer::doSelect('lob_class_repo_id = \''.$this->lobClassRepoId.'\'',$dsn);
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->lobClassActivityId;
	}


	function setPrimaryKey($val) {
		$this->lobClassActivityId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LobClassActivityPeer::doInsert($this,$dsn));
		} else {
			LobClassActivityPeer::doUpdate($this,$dsn);
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
			$where = "lob_class_activity_id='".$key."'";
		}
		$array = LobClassActivityPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LobClassActivityPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LobClassActivityPeer::doDelete($this,$deep,$dsn);
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


class LobClassActivityPeerBase {

	var $tableName = 'lob_class_activity';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lob_class_activity",$where);
		$st->fields['lob_class_activity_id'] = 'lob_class_activity_id';
		$st->fields['lob_class_repo_id'] = 'lob_class_repo_id';
		$st->fields['response_type_id'] = 'response_type_id';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LobClassActivityPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lob_class_activity");
		$st->fields['lob_class_activity_id'] = $this->lobClassActivityId;
		$st->fields['lob_class_repo_id'] = $this->lobClassRepoId;
		$st->fields['response_type_id'] = $this->responseTypeId;


		$st->key = 'lob_class_activity_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lob_class_activity");
		$st->fields['lob_class_activity_id'] = $obj->lobClassActivityId;
		$st->fields['lob_class_repo_id'] = $obj->lobClassRepoId;
		$st->fields['response_type_id'] = $obj->responseTypeId;


		$st->key = 'lob_class_activity_id';
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
		$st = new PBDO_DeleteStatement("lob_class_activity","lob_class_activity_id = '".$obj->getPrimaryKey()."'");

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
		$x = new LobClassActivity();
		$x->lobClassActivityId = $row['lob_class_activity_id'];
		$x->lobClassRepoId = $row['lob_class_repo_id'];
		$x->responseTypeId = $row['response_type_id'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LobClassActivity extends LobClassActivityBase {



}



class LobClassActivityPeer extends LobClassActivityPeerBase {

}

?>