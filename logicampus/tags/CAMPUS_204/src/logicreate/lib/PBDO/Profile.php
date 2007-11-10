<?

class ProfileBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $username;
	var $firstname;
	var $lastname;
	var $emailAlternate;
	var $homePhone;
	var $workPhone;
	var $faxPhone;
	var $cellPhone;
	var $pagerPhone;
	var $address;
	var $address2;
	var $city;
	var $state;
	var $zip;
	var $showaddinfo;
	var $url;
	var $icq;
	var $aim;
	var $yim;
	var $msn;
	var $showonlineinfo;
	var $occupation;
	var $gender;
	var $sig;
	var $bio;
	var $showbioinfo;
	var $counter;
	var $emailNotify;
	var $photo;

	var $__attributes = array( 
	'username'=>'varchar',
	'firstname'=>'varchar',
	'lastname'=>'varchar',
	'emailAlternate'=>'varchar',
	'homePhone'=>'varchar',
	'workPhone'=>'varchar',
	'faxPhone'=>'varchar',
	'cellPhone'=>'varchar',
	'pagerPhone'=>'varchar',
	'address'=>'varchar',
	'address2'=>'varchar',
	'city'=>'varchar',
	'state'=>'char',
	'zip'=>'varchar',
	'showaddinfo'=>'char',
	'url'=>'varchar',
	'icq'=>'varchar',
	'aim'=>'varchar',
	'yim'=>'varchar',
	'msn'=>'varchar',
	'showonlineinfo'=>'char',
	'occupation'=>'varchar',
	'gender'=>'varchar',
	'sig'=>'longvarchar',
	'bio'=>'longvarchar',
	'showbioinfo'=>'char',
	'counter'=>'integer',
	'emailNotify'=>'char',
	'photo'=>'varchar');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->username;
	}


	function setPrimaryKey($val) {
		$this->username = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ProfilePeer::doInsert($this,$dsn));
		} else {
			ProfilePeer::doUpdate($this,$dsn);
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
		$array = ProfilePeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ProfilePeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ProfilePeer::doDelete($this,$deep,$dsn);
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


class ProfilePeerBase {

	var $tableName = 'profile';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("profile",$where);
		$st->fields['username'] = 'username';
		$st->fields['firstname'] = 'firstname';
		$st->fields['lastname'] = 'lastname';
		$st->fields['emailAlternate'] = 'emailAlternate';
		$st->fields['homePhone'] = 'homePhone';
		$st->fields['workPhone'] = 'workPhone';
		$st->fields['faxPhone'] = 'faxPhone';
		$st->fields['cellPhone'] = 'cellPhone';
		$st->fields['pagerPhone'] = 'pagerPhone';
		$st->fields['address'] = 'address';
		$st->fields['address2'] = 'address2';
		$st->fields['city'] = 'city';
		$st->fields['state'] = 'state';
		$st->fields['zip'] = 'zip';
		$st->fields['showaddinfo'] = 'showaddinfo';
		$st->fields['url'] = 'url';
		$st->fields['icq'] = 'icq';
		$st->fields['aim'] = 'aim';
		$st->fields['yim'] = 'yim';
		$st->fields['msn'] = 'msn';
		$st->fields['showonlineinfo'] = 'showonlineinfo';
		$st->fields['occupation'] = 'occupation';
		$st->fields['gender'] = 'gender';
		$st->fields['sig'] = 'sig';
		$st->fields['bio'] = 'bio';
		$st->fields['showbioinfo'] = 'showbioinfo';
		$st->fields['counter'] = 'counter';
		$st->fields['emailNotify'] = 'emailNotify';
		$st->fields['photo'] = 'photo';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ProfilePeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("profile");
		$st->fields['username'] = $this->username;
		$st->fields['firstname'] = $this->firstname;
		$st->fields['lastname'] = $this->lastname;
		$st->fields['emailAlternate'] = $this->emailAlternate;
		$st->fields['homePhone'] = $this->homePhone;
		$st->fields['workPhone'] = $this->workPhone;
		$st->fields['faxPhone'] = $this->faxPhone;
		$st->fields['cellPhone'] = $this->cellPhone;
		$st->fields['pagerPhone'] = $this->pagerPhone;
		$st->fields['address'] = $this->address;
		$st->fields['address2'] = $this->address2;
		$st->fields['city'] = $this->city;
		$st->fields['state'] = $this->state;
		$st->fields['zip'] = $this->zip;
		$st->fields['showaddinfo'] = $this->showaddinfo;
		$st->fields['url'] = $this->url;
		$st->fields['icq'] = $this->icq;
		$st->fields['aim'] = $this->aim;
		$st->fields['yim'] = $this->yim;
		$st->fields['msn'] = $this->msn;
		$st->fields['showonlineinfo'] = $this->showonlineinfo;
		$st->fields['occupation'] = $this->occupation;
		$st->fields['gender'] = $this->gender;
		$st->fields['sig'] = $this->sig;
		$st->fields['bio'] = $this->bio;
		$st->fields['showbioinfo'] = $this->showbioinfo;
		$st->fields['counter'] = $this->counter;
		$st->fields['emailNotify'] = $this->emailNotify;
		$st->fields['photo'] = $this->photo;


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
		$st = new PBDO_UpdateStatement("profile");
		$st->fields['username'] = $obj->username;
		$st->fields['firstname'] = $obj->firstname;
		$st->fields['lastname'] = $obj->lastname;
		$st->fields['emailAlternate'] = $obj->emailAlternate;
		$st->fields['homePhone'] = $obj->homePhone;
		$st->fields['workPhone'] = $obj->workPhone;
		$st->fields['faxPhone'] = $obj->faxPhone;
		$st->fields['cellPhone'] = $obj->cellPhone;
		$st->fields['pagerPhone'] = $obj->pagerPhone;
		$st->fields['address'] = $obj->address;
		$st->fields['address2'] = $obj->address2;
		$st->fields['city'] = $obj->city;
		$st->fields['state'] = $obj->state;
		$st->fields['zip'] = $obj->zip;
		$st->fields['showaddinfo'] = $obj->showaddinfo;
		$st->fields['url'] = $obj->url;
		$st->fields['icq'] = $obj->icq;
		$st->fields['aim'] = $obj->aim;
		$st->fields['yim'] = $obj->yim;
		$st->fields['msn'] = $obj->msn;
		$st->fields['showonlineinfo'] = $obj->showonlineinfo;
		$st->fields['occupation'] = $obj->occupation;
		$st->fields['gender'] = $obj->gender;
		$st->fields['sig'] = $obj->sig;
		$st->fields['bio'] = $obj->bio;
		$st->fields['showbioinfo'] = $obj->showbioinfo;
		$st->fields['counter'] = $obj->counter;
		$st->fields['emailNotify'] = $obj->emailNotify;
		$st->fields['photo'] = $obj->photo;


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
		$st = new PBDO_DeleteStatement("profile","username = '".$obj->getPrimaryKey()."'");

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
		$x = new Profile();
		$x->username = $row['username'];
		$x->firstname = $row['firstname'];
		$x->lastname = $row['lastname'];
		$x->emailAlternate = $row['emailAlternate'];
		$x->homePhone = $row['homePhone'];
		$x->workPhone = $row['workPhone'];
		$x->faxPhone = $row['faxPhone'];
		$x->cellPhone = $row['cellPhone'];
		$x->pagerPhone = $row['pagerPhone'];
		$x->address = $row['address'];
		$x->address2 = $row['address2'];
		$x->city = $row['city'];
		$x->state = $row['state'];
		$x->zip = $row['zip'];
		$x->showaddinfo = $row['showaddinfo'];
		$x->url = $row['url'];
		$x->icq = $row['icq'];
		$x->aim = $row['aim'];
		$x->yim = $row['yim'];
		$x->msn = $row['msn'];
		$x->showonlineinfo = $row['showonlineinfo'];
		$x->occupation = $row['occupation'];
		$x->gender = $row['gender'];
		$x->sig = $row['sig'];
		$x->bio = $row['bio'];
		$x->showbioinfo = $row['showbioinfo'];
		$x->counter = $row['counter'];
		$x->emailNotify = $row['emailNotify'];
		$x->photo = $row['photo'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class Profile extends ProfileBase {



}



class ProfilePeer extends ProfilePeerBase {

}

?>