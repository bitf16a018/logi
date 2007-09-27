<?

class LobUserLinkBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lobUserLinkId;
	var $lobRepoEntryId;
	var $userId;
	var $isOwner;

	var $__attributes = array( 
	'lobUserLinkId'=>'integer',
	'lobRepoEntryId'=>'integer',
	'userId'=>'integer',
	'isOwner'=>'integer');

	var $__nulls = array( 
	'isOwner'=>'isOwner');



	function getPrimaryKey() {
		return $this->lobUserLinkId;
	}


	function setPrimaryKey($val) {
		$this->lobUserLinkId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LobUserLinkPeer::doInsert($this,$dsn));
		} else {
			LobUserLinkPeer::doUpdate($this,$dsn);
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
			$where = "lob_user_link_id='".$key."'";
		}
		$array = LobUserLinkPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LobUserLinkPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LobUserLinkPeer::doDelete($this,$deep,$dsn);
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


class LobUserLinkPeerBase {

	var $tableName = 'lob_user_link';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lob_user_link",$where);
		$st->fields['lob_user_link_id'] = 'lob_user_link_id';
		$st->fields['lob_repo_entry_id'] = 'lob_repo_entry_id';
		$st->fields['user_id'] = 'user_id';
		$st->fields['is_owner'] = 'is_owner';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LobUserLinkPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lob_user_link");
		$st->fields['lob_user_link_id'] = $this->lobUserLinkId;
		$st->fields['lob_repo_entry_id'] = $this->lobRepoEntryId;
		$st->fields['user_id'] = $this->userId;
		$st->fields['is_owner'] = $this->isOwner;

		$st->nulls['is_owner'] = 'is_owner';

		$st->key = 'lob_user_link_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lob_user_link");
		$st->fields['lob_user_link_id'] = $obj->lobUserLinkId;
		$st->fields['lob_repo_entry_id'] = $obj->lobRepoEntryId;
		$st->fields['user_id'] = $obj->userId;
		$st->fields['is_owner'] = $obj->isOwner;

		$st->nulls['is_owner'] = 'is_owner';

		$st->key = 'lob_user_link_id';
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
		$st = new PBDO_DeleteStatement("lob_user_link","lob_user_link_id = '".$obj->getPrimaryKey()."'");

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
		$x = new LobUserLink();
		$x->lobUserLinkId = $row['lob_user_link_id'];
		$x->lobRepoEntryId = $row['lob_repo_entry_id'];
		$x->userId = $row['user_id'];
		$x->isOwner = $row['is_owner'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LobUserLink extends LobUserLinkBase {



}



class LobUserLinkPeer extends LobUserLinkPeerBase {

}

?>