<?

class LobTestBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.7';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lobTestId;
	var $lobRepoEntryId;
	var $numRetry;
	var $isPractice;

	var $__attributes = array( 
	'lobTestId'=>'integer',
	'lobRepoEntryId'=>'integer',
	'numRetry'=>'integer',
	'isPractice'=>'tinyint');

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

	/**
	 * Retrieves an array of lob_test_qst objects via the foreign key lob_test_id.
	 * 
	 * @param String $dsn the name of the data source to use for the sql query.
	 * @return Array related objects.
	 */
	function getLobTestQstsByLobTestId($dsn='default') {
		if ( $this->lobTestId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = LobTestQstPeer::doSelect('lob_test_id = \''.$this->lobTestId.'\'',$dsn);
		return $array;
	}



	function getPrimaryKey() {
		return $this->lobTestId;
	}


	function setPrimaryKey($val) {
		$this->lobTestId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LobTestPeer::doInsert($this,$dsn));
		} else {
			LobTestPeer::doUpdate($this,$dsn);
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
			$where = "lob_test_id='".$key."'";
		}
		$array = LobTestPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LobTestPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LobTestPeer::doDelete($this,$deep,$dsn);
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


class LobTestPeerBase {

	var $tableName = 'lob_test';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lob_test",$where);
		$st->fields['lob_test_id'] = 'lob_test_id';
		$st->fields['lob_repo_entry_id'] = 'lob_repo_entry_id';
//		$st->fields['num_retry'] = 'num_retry';
//		$st->fields['is_practice'] = 'is_practice';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LobTestPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lob_test");
		$st->fields['lob_test_id'] = $obj->lobTestId;
		$st->fields['lob_repo_entry_id'] = $obj->lobRepoEntryId;
//		$st->fields['num_retry'] = $obj->numRetry;
//		$st->fields['is_practice'] = $obj->isPractice;


		$st->key = 'lob_test_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lob_test");
		$st->fields['lob_test_id'] = $obj->lobTestId;
		$st->fields['lob_repo_entry_id'] = $obj->lobRepoEntryId;
//		$st->fields['num_retry'] = $obj->numRetry;
//		$st->fields['is_practice'] = $obj->isPractice;


		$st->key = 'lob_test_id';
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
		$st = new PBDO_DeleteStatement("lob_test","lob_test_id = '".$obj->getPrimaryKey()."'");

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
		$x = new LobTest();
		$x->lobTestId = $row['lob_test_id'];
		$x->lobRepoEntryId = $row['lob_repo_entry_id'];
//		$x->numRetry = $row['num_retry'];
//		$x->isPractice = $row['is_practice'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LobTest extends LobTestBase {



}



class LobTestPeer extends LobTestPeerBase {

}

?>
