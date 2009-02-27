<?

class ProfileStudentBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $username;
	var $operatingSystem;
	var $connectType;
	var $isp;

	var $__attributes = array( 
	'username'=>'varchar',
	'operatingSystem'=>'varchar',
	'connectType'=>'varchar',
	'isp'=>'varchar');

	var $__nulls = array( 
	'operatingSystem'=>'operatingSystem',
	'connectType'=>'connectType',
	'isp'=>'isp');



	function getPrimaryKey() {
		return $this->username;
	}


	function setPrimaryKey($val) {
		$this->username = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ProfileStudentPeer::doInsert($this,$dsn));
		} else {
			ProfileStudentPeer::doUpdate($this,$dsn);
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
		$array = ProfileStudentPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ProfileStudentPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ProfileStudentPeer::doDelete($this,$deep,$dsn);
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


class ProfileStudentPeerBase {

	var $tableName = 'profile_student';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("profile_student",$where);
		$st->fields['username'] = 'username';
		$st->fields['operatingSystem'] = 'operatingSystem';
		$st->fields['connectType'] = 'connectType';
		$st->fields['isp'] = 'isp';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ProfileStudentPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("profile_student");
		$st->fields['username'] = $this->username;
		$st->fields['operatingSystem'] = $this->operatingSystem;
		$st->fields['connectType'] = $this->connectType;
		$st->fields['isp'] = $this->isp;

		$st->nulls['operatingSystem'] = 'operatingSystem';
		$st->nulls['connectType'] = 'connectType';
		$st->nulls['isp'] = 'isp';

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
		$st = new PBDO_UpdateStatement("profile_student");
		$st->fields['username'] = $obj->username;
		$st->fields['operatingSystem'] = $obj->operatingSystem;
		$st->fields['connectType'] = $obj->connectType;
		$st->fields['isp'] = $obj->isp;

		$st->nulls['operatingSystem'] = 'operatingSystem';
		$st->nulls['connectType'] = 'connectType';
		$st->nulls['isp'] = 'isp';

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
		$st = new PBDO_DeleteStatement("profile_student","username = '".$obj->getPrimaryKey()."'");

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
		$x = new ProfileStudent();
		$x->username = $row['username'];
		$x->operatingSystem = $row['operatingSystem'];
		$x->connectType = $row['connectType'];
		$x->isp = $row['isp'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ProfileStudent extends ProfileStudentBase {



}



class ProfileStudentPeer extends ProfileStudentPeerBase {

}

?>