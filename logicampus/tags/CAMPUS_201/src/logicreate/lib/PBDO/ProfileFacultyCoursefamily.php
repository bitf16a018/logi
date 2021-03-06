<?

class ProfileFacultyCoursefamilyBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $username;
	var $idProfileFacultyCoursefamily;

	var $__attributes = array( 
	'username'=>'varchar',
	'idProfileFacultyCoursefamily'=>'varchar');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->;
	}


	function setPrimaryKey($val) {
		$this-> = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ProfileFacultyCoursefamilyPeer::doInsert($this,$dsn));
		} else {
			ProfileFacultyCoursefamilyPeer::doUpdate($this,$dsn);
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
		$array = ProfileFacultyCoursefamilyPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ProfileFacultyCoursefamilyPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ProfileFacultyCoursefamilyPeer::doDelete($this,$deep,$dsn);
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


class ProfileFacultyCoursefamilyPeerBase {

	var $tableName = 'profile_faculty_coursefamily';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("profile_faculty_coursefamily",$where);
		$st->fields['username'] = 'username';
		$st->fields['id_profile_faculty_coursefamily'] = 'id_profile_faculty_coursefamily';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ProfileFacultyCoursefamilyPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("profile_faculty_coursefamily");
		$st->fields['username'] = $this->username;
		$st->fields['id_profile_faculty_coursefamily'] = $this->idProfileFacultyCoursefamily;


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
		$st = new PBDO_UpdateStatement("profile_faculty_coursefamily");
		$st->fields['username'] = $obj->username;
		$st->fields['id_profile_faculty_coursefamily'] = $obj->idProfileFacultyCoursefamily;


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
		$st = new PBDO_DeleteStatement("profile_faculty_coursefamily"," = '".$obj->getPrimaryKey()."'");

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
		$x = new ProfileFacultyCoursefamily();
		$x->username = $row['username'];
		$x->idProfileFacultyCoursefamily = $row['id_profile_faculty_coursefamily'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ProfileFacultyCoursefamily extends ProfileFacultyCoursefamilyBase {



}



class ProfileFacultyCoursefamilyPeer extends ProfileFacultyCoursefamilyPeerBase {

}

?>