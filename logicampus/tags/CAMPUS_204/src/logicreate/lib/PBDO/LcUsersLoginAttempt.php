<?

class LcUsersLoginAttemptBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $username;
	var $loginAttempt;
	var $loginStatus;
	var $os;
	var $browser;
	var $version;

	var $__attributes = array( 
	'username'=>'varchar',
	'loginAttempt'=>'integer',
	'loginStatus'=>'tinyint',
	'os'=>'varchar',
	'browser'=>'varchar',
	'version'=>'varchar');

	var $__nulls = array( 
	'username'=>'username',
	'loginAttempt'=>'loginAttempt',
	'loginStatus'=>'loginStatus',
	'os'=>'os',
	'browser'=>'browser',
	'version'=>'version');



	function getPrimaryKey() {
		return $this->;
	}


	function setPrimaryKey($val) {
		$this-> = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LcUsersLoginAttemptPeer::doInsert($this,$dsn));
		} else {
			LcUsersLoginAttemptPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "='".$key."'";
		}
		$array = LcUsersLoginAttemptPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LcUsersLoginAttemptPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LcUsersLoginAttemptPeer::doDelete($this,$deep,$dsn);
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


class LcUsersLoginAttemptPeerBase {

	var $tableName = 'lc_users_login_attempt';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lc_users_login_attempt",$where);
		$st->fields['username'] = 'username';
		$st->fields['login_attempt'] = 'login_attempt';
		$st->fields['login_status'] = 'login_status';
		$st->fields['os'] = 'os';
		$st->fields['browser'] = 'browser';
		$st->fields['version'] = 'version';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LcUsersLoginAttemptPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lc_users_login_attempt");
		$st->fields['username'] = $this->username;
		$st->fields['login_attempt'] = $this->loginAttempt;
		$st->fields['login_status'] = $this->loginStatus;
		$st->fields['os'] = $this->os;
		$st->fields['browser'] = $this->browser;
		$st->fields['version'] = $this->version;

		$st->nulls['username'] = 'username';
		$st->nulls['login_attempt'] = 'login_attempt';
		$st->nulls['login_status'] = 'login_status';
		$st->nulls['os'] = 'os';
		$st->nulls['browser'] = 'browser';
		$st->nulls['version'] = 'version';

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
		$st = new PBDO_UpdateStatement("lc_users_login_attempt");
		$st->fields['username'] = $obj->username;
		$st->fields['login_attempt'] = $obj->loginAttempt;
		$st->fields['login_status'] = $obj->loginStatus;
		$st->fields['os'] = $obj->os;
		$st->fields['browser'] = $obj->browser;
		$st->fields['version'] = $obj->version;

		$st->nulls['username'] = 'username';
		$st->nulls['login_attempt'] = 'login_attempt';
		$st->nulls['login_status'] = 'login_status';
		$st->nulls['os'] = 'os';
		$st->nulls['browser'] = 'browser';
		$st->nulls['version'] = 'version';

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
		$st = new PBDO_DeleteStatement("lc_users_login_attempt"," = '".$obj->getPrimaryKey()."'");

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
		$x = new LcUsersLoginAttempt();
		$x->username = $row['username'];
		$x->loginAttempt = $row['login_attempt'];
		$x->loginStatus = $row['login_status'];
		$x->os = $row['os'];
		$x->browser = $row['browser'];
		$x->version = $row['version'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LcUsersLoginAttempt extends LcUsersLoginAttemptBase {



}



class LcUsersLoginAttemptPeer extends LcUsersLoginAttemptPeerBase {

}

?>