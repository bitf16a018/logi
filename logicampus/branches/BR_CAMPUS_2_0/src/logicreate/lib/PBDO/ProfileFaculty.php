<?

class ProfileFacultyBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $username;
	var $emergencyContact;
	var $emergencyPhone;
	var $title;
	var $degree;
	var $jobtitle;
	var $officeLocation;
	var $campusLocation;
	var $relevantExp;
	var $officePhone;
	var $offHrsMonday;
	var $offHrsTuesday;
	var $offHrsWednesday;
	var $offHrsThursday;
	var $offHrsFriday;

	var $__attributes = array( 
	'username'=>'varchar',
	'emergencyContact'=>'varchar',
	'emergencyPhone'=>'varchar',
	'title'=>'varchar',
	'degree'=>'longvarchar',
	'jobtitle'=>'varchar',
	'officeLocation'=>'varchar',
	'campusLocation'=>'varchar',
	'relevantExp'=>'longvarchar',
	'officePhone'=>'varchar',
	'offHrsMonday'=>'varchar',
	'offHrsTuesday'=>'varchar',
	'offHrsWednesday'=>'varchar',
	'offHrsThursday'=>'varchar',
	'offHrsFriday'=>'varchar');

	var $__nulls = array( 
	'emergencyContact'=>'emergencyContact',
	'emergencyPhone'=>'emergencyPhone',
	'title'=>'title',
	'degree'=>'degree',
	'jobtitle'=>'jobtitle',
	'officeLocation'=>'officeLocation',
	'campusLocation'=>'campusLocation',
	'relevantExp'=>'relevantExp',
	'officePhone'=>'officePhone',
	'offHrsMonday'=>'offHrsMonday',
	'offHrsTuesday'=>'offHrsTuesday',
	'offHrsWednesday'=>'offHrsWednesday',
	'offHrsThursday'=>'offHrsThursday',
	'offHrsFriday'=>'offHrsFriday');



	function getPrimaryKey() {
		return $this->username;
	}


	function setPrimaryKey($val) {
		$this->username = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ProfileFacultyPeer::doInsert($this,$dsn));
		} else {
			ProfileFacultyPeer::doUpdate($this,$dsn);
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
		$array = ProfileFacultyPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ProfileFacultyPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ProfileFacultyPeer::doDelete($this,$deep,$dsn);
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


class ProfileFacultyPeerBase {

	var $tableName = 'profile_faculty';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("profile_faculty",$where);
		$st->fields['username'] = 'username';
		$st->fields['emergencyContact'] = 'emergencyContact';
		$st->fields['emergencyPhone'] = 'emergencyPhone';
		$st->fields['title'] = 'title';
		$st->fields['degree'] = 'degree';
		$st->fields['jobtitle'] = 'jobtitle';
		$st->fields['officeLocation'] = 'officeLocation';
		$st->fields['campusLocation'] = 'campusLocation';
		$st->fields['relevantExp'] = 'relevantExp';
		$st->fields['officePhone'] = 'officePhone';
		$st->fields['offHrsMonday'] = 'offHrsMonday';
		$st->fields['offHrsTuesday'] = 'offHrsTuesday';
		$st->fields['offHrsWednesday'] = 'offHrsWednesday';
		$st->fields['offHrsThursday'] = 'offHrsThursday';
		$st->fields['offHrsFriday'] = 'offHrsFriday';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ProfileFacultyPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("profile_faculty");
		$st->fields['username'] = $this->username;
		$st->fields['emergencyContact'] = $this->emergencyContact;
		$st->fields['emergencyPhone'] = $this->emergencyPhone;
		$st->fields['title'] = $this->title;
		$st->fields['degree'] = $this->degree;
		$st->fields['jobtitle'] = $this->jobtitle;
		$st->fields['officeLocation'] = $this->officeLocation;
		$st->fields['campusLocation'] = $this->campusLocation;
		$st->fields['relevantExp'] = $this->relevantExp;
		$st->fields['officePhone'] = $this->officePhone;
		$st->fields['offHrsMonday'] = $this->offHrsMonday;
		$st->fields['offHrsTuesday'] = $this->offHrsTuesday;
		$st->fields['offHrsWednesday'] = $this->offHrsWednesday;
		$st->fields['offHrsThursday'] = $this->offHrsThursday;
		$st->fields['offHrsFriday'] = $this->offHrsFriday;

		$st->nulls['emergencyContact'] = 'emergencyContact';
		$st->nulls['emergencyPhone'] = 'emergencyPhone';
		$st->nulls['title'] = 'title';
		$st->nulls['degree'] = 'degree';
		$st->nulls['jobtitle'] = 'jobtitle';
		$st->nulls['officeLocation'] = 'officeLocation';
		$st->nulls['campusLocation'] = 'campusLocation';
		$st->nulls['relevantExp'] = 'relevantExp';
		$st->nulls['officePhone'] = 'officePhone';
		$st->nulls['offHrsMonday'] = 'offHrsMonday';
		$st->nulls['offHrsTuesday'] = 'offHrsTuesday';
		$st->nulls['offHrsWednesday'] = 'offHrsWednesday';
		$st->nulls['offHrsThursday'] = 'offHrsThursday';
		$st->nulls['offHrsFriday'] = 'offHrsFriday';

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
		$st = new PBDO_UpdateStatement("profile_faculty");
		$st->fields['username'] = $obj->username;
		$st->fields['emergencyContact'] = $obj->emergencyContact;
		$st->fields['emergencyPhone'] = $obj->emergencyPhone;
		$st->fields['title'] = $obj->title;
		$st->fields['degree'] = $obj->degree;
		$st->fields['jobtitle'] = $obj->jobtitle;
		$st->fields['officeLocation'] = $obj->officeLocation;
		$st->fields['campusLocation'] = $obj->campusLocation;
		$st->fields['relevantExp'] = $obj->relevantExp;
		$st->fields['officePhone'] = $obj->officePhone;
		$st->fields['offHrsMonday'] = $obj->offHrsMonday;
		$st->fields['offHrsTuesday'] = $obj->offHrsTuesday;
		$st->fields['offHrsWednesday'] = $obj->offHrsWednesday;
		$st->fields['offHrsThursday'] = $obj->offHrsThursday;
		$st->fields['offHrsFriday'] = $obj->offHrsFriday;

		$st->nulls['emergencyContact'] = 'emergencyContact';
		$st->nulls['emergencyPhone'] = 'emergencyPhone';
		$st->nulls['title'] = 'title';
		$st->nulls['degree'] = 'degree';
		$st->nulls['jobtitle'] = 'jobtitle';
		$st->nulls['officeLocation'] = 'officeLocation';
		$st->nulls['campusLocation'] = 'campusLocation';
		$st->nulls['relevantExp'] = 'relevantExp';
		$st->nulls['officePhone'] = 'officePhone';
		$st->nulls['offHrsMonday'] = 'offHrsMonday';
		$st->nulls['offHrsTuesday'] = 'offHrsTuesday';
		$st->nulls['offHrsWednesday'] = 'offHrsWednesday';
		$st->nulls['offHrsThursday'] = 'offHrsThursday';
		$st->nulls['offHrsFriday'] = 'offHrsFriday';

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
		$st = new PBDO_DeleteStatement("profile_faculty","username = '".$obj->getPrimaryKey()."'");

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
		$x = new ProfileFaculty();
		$x->username = $row['username'];
		$x->emergencyContact = $row['emergencyContact'];
		$x->emergencyPhone = $row['emergencyPhone'];
		$x->title = $row['title'];
		$x->degree = $row['degree'];
		$x->jobtitle = $row['jobtitle'];
		$x->officeLocation = $row['officeLocation'];
		$x->campusLocation = $row['campusLocation'];
		$x->relevantExp = $row['relevantExp'];
		$x->officePhone = $row['officePhone'];
		$x->offHrsMonday = $row['offHrsMonday'];
		$x->offHrsTuesday = $row['offHrsTuesday'];
		$x->offHrsWednesday = $row['offHrsWednesday'];
		$x->offHrsThursday = $row['offHrsThursday'];
		$x->offHrsFriday = $row['offHrsFriday'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ProfileFaculty extends ProfileFacultyBase {



}



class ProfileFacultyPeer extends ProfileFacultyPeerBase {

}

?>