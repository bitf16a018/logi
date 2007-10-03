<?

class LcUsersLastLoginBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $username;
	var $lastLogin;

	var $__attributes = array( 
	'username'=>'varchar',
	'lastLogin'=>'integer');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->username;
	}


	function setPrimaryKey($val) {
		$this->username = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LcUsersLastLoginPeer::doInsert($this,$dsn));
		} else {
			LcUsersLastLoginPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "username='".$key."'";
		}
		$array = LcUsersLastLoginPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LcUsersLastLoginPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LcUsersLastLoginPeer::doDelete($this,$deep,$dsn);
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


class LcUsersLastLoginPeerBase {

	var $tableName = 'lc_users_last_login';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lc_users_last_login",$where);
		$st->fields['username'] = 'username';
		$st->fields['last_login'] = 'last_login';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LcUsersLastLoginPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lc_users_last_login");
		$st->fields['username'] = $this->username;
		$st->fields['last_login'] = $this->lastLogin;


		$st->key = 'username';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lc_users_last_login");
		$st->fields['username'] = $obj->username;
		$st->fields['last_login'] = $obj->lastLogin;


		$st->key = 'username';
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
		$st = new PBDO_DeleteStatement("lc_users_last_login","username = '".$obj->getPrimaryKey()."'");

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
		$x = new LcUsersLastLogin();
		$x->username = $row['username'];
		$x->lastLogin = $row['last_login'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LcUsersLastLogin extends LcUsersLastLoginBase {



}



class LcUsersLastLoginPeer extends LcUsersLastLoginPeerBase {

}

?>