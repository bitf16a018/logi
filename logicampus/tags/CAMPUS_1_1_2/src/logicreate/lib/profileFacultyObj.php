<?
// primarily mapped against database table 
class profileFacultyObj {
	var $username;		// (number) - 
	var $emergencyContact;		// (number) - 
	var $emergencyPhone;		// (number) - 
	var $title;		// (number) - 
	var $degree;		// (number) - 
	var $jobtitle;		// (number) - 
	var $officeLocation;		// (number) - 
	var $relevantExp;		// (number) - 
	var $photo;		// (number) - 
	var $faxPhone;		// (number) - 
	var $officePhone;		// (number) - 
	var $homepage;		// (number) - 
	var $offHrsMonday;		// (number) - 
	var $offHrsTuesday;		// (number) - 
	var $offHrsWednesday;		// (number) - 
	var $offHrsThursday;		// (number) - 
	var $offHrsFriday;		// (number) - 
	var $_dsn = 'default';
	var $_pkey = 'username';


function _getFromDB($pkey,$prop='',$where='', $orderBy='', $dsn='default') {
   if ($orderBy) { $orderBy = " order by $orderBy"; }
   if ($where) { $where = " and $where"; }
   $db = DB::getHandle($dsn);
   if ($prop=='') { $prop=$this->_pkey; }
   $db->query("select username,emergencyContact,emergencyPhone,title,degree,jobtitle,officeLocation,relevantExp,photo,faxPhone,officePhone,homepage,offHrsMonday,offHrsTuesday,offHrsWednesday,offHrsThursday,offHrsFriday from profile_faculty where $prop='$pkey' $where $orderBy");
   if($db->next_record()) {
      $temp = new profileFacultyObj();
      $temp->_dsn = $dsn;
      $temp->__loaded = true; 
      $temp->username = $db->Record['username'];
      $temp->emergencyContact = $db->Record['emergencyContact'];
      $temp->emergencyPhone = $db->Record['emergencyPhone'];
      $temp->title = $db->Record['title'];
      $temp->degree = $db->Record['degree'];
      $temp->jobtitle = $db->Record['jobtitle'];
      $temp->officeLocation = $db->Record['officeLocation'];
      $temp->relevantExp = $db->Record['relevantExp'];
      $temp->photo = $db->Record['photo'];
      $temp->faxPhone = $db->Record['faxPhone'];
      $temp->officePhone = $db->Record['officePhone'];
      $temp->homepage = $db->Record['homepage'];
      $temp->offHrsMonday = $db->Record['offHrsMonday'];
      $temp->offHrsTuesday = $db->Record['offHrsTuesday'];
      $temp->offHrsWednesday = $db->Record['offHrsWednesday'];
      $temp->offHrsThursday = $db->Record['offHrsThursday'];
      $temp->offHrsFriday = $db->Record['offHrsFriday'];
   }
if ( !$temp ) { trigger_error('empty persistant object'); }
return $temp;

}


function _getAllFromDB($key,$prop='',$where='', $orderBy='',$dsn='default') {
   $db = DB::getHandle($dsn);
   if ($orderBy) { $orderBy = " order by $orderBy"; }
   if ($where) { $where = " and $where"; }
   $db->query("select username,emergencyContact,emergencyPhone,title,degree,jobtitle,officeLocation,relevantExp,photo,faxPhone,officePhone,homepage,offHrsMonday,offHrsTuesday,offHrsWednesday,offHrsThursday,offHrsFriday from profile_faculty where $prop='$key' $where $orderBy");
   while ($db->next_record()) {
      $temp = new profileFacultyObj();
      $temp->_dsn = $dsn;
      $temp->__loaded = true; 
      $temp->username = $db->Record['username'];
      $temp->emergencyContact = $db->Record['emergencyContact'];
      $temp->emergencyPhone = $db->Record['emergencyPhone'];
      $temp->title = $db->Record['title'];
      $temp->degree = $db->Record['degree'];
      $temp->jobtitle = $db->Record['jobtitle'];
      $temp->officeLocation = $db->Record['officeLocation'];
      $temp->relevantExp = $db->Record['relevantExp'];
      $temp->photo = $db->Record['photo'];
      $temp->faxPhone = $db->Record['faxPhone'];
      $temp->officePhone = $db->Record['officePhone'];
      $temp->homepage = $db->Record['homepage'];
      $temp->offHrsMonday = $db->Record['offHrsMonday'];
      $temp->offHrsTuesday = $db->Record['offHrsTuesday'];
      $temp->offHrsWednesday = $db->Record['offHrsWednesday'];
      $temp->offHrsThursday = $db->Record['offHrsThursday'];
      $temp->offHrsFriday = $db->Record['offHrsFriday'];
      $objects[] = $temp;
}
return $objects;

}


function _loadArray($array, $pkeyFlag=false) {
 if ($pkeyFlag) { 
	$this->username = $array['username'];
 }
	$this->emergencyContact = $array['emergencyContact'];
	$this->emergencyPhone = $array['emergencyPhone'];
	$this->title = $array['title'];
	$this->degree = $array['degree'];
	$this->jobtitle = $array['jobtitle'];
	$this->officeLocation = $array['officeLocation'];
	$this->relevantExp = $array['relevantExp'];
	$this->photo = $array['photo'];
	$this->faxPhone = $array['faxPhone'];
	$this->officePhone = $array['officePhone'];
	$this->homepage = $array['homepage'];
	$this->offHrsMonday = $array['offHrsMonday'];
	$this->offHrsTuesday = $array['offHrsTuesday'];
	$this->offHrsWednesday = $array['offHrsWednesday'];
	$this->offHrsThursday = $array['offHrsThursday'];
	$this->offHrsFriday = $array['offHrsFriday'];
}

function _genPkey($len=50) {
return str_replace(".","",uniqid(str_replace(" ","",microtime()), $len));
}

function _saveToDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->username =='') {$this->username=$this->_genPkey(); }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "update profile_faculty set 
username='".addslashes($this->username)."',
emergencyContact='".addslashes($this->emergencyContact)."',
emergencyPhone='".addslashes($this->emergencyPhone)."',
title='".addslashes($this->title)."',
degree='".addslashes($this->degree)."',
jobtitle='".addslashes($this->jobtitle)."',
officeLocation='".addslashes($this->officeLocation)."',
relevantExp='".addslashes($this->relevantExp)."',
photo='".addslashes($this->photo)."',
faxPhone='".addslashes($this->faxPhone)."',
officePhone='".addslashes($this->officePhone)."',
homepage='".addslashes($this->homepage)."',
offHrsMonday='".addslashes($this->offHrsMonday)."',
offHrsTuesday='".addslashes($this->offHrsTuesday)."',
offHrsWednesday='".addslashes($this->offHrsWednesday)."',
offHrsThursday='".addslashes($this->offHrsThursday)."',
offHrsFriday='".addslashes($this->offHrsFriday)."' where username = '{$this->{$this->_pkey}}'";
$db->query($sql);
} else {
$sql = "insert into profile_faculty   (username,emergencyContact,emergencyPhone,title,degree,jobtitle,officeLocation,relevantExp,photo,faxPhone,officePhone,homepage,offHrsMonday,offHrsTuesday,offHrsWednesday,offHrsThursday,offHrsFriday) values (
	'".addslashes($this->username)."',
	'".addslashes($this->emergencyContact)."',
	'".addslashes($this->emergencyPhone)."',
	'".addslashes($this->title)."',
	'".addslashes($this->degree)."',
	'".addslashes($this->jobtitle)."',
	'".addslashes($this->officeLocation)."',
	'".addslashes($this->relevantExp)."',
	'".addslashes($this->photo)."',
	'".addslashes($this->faxPhone)."',
	'".addslashes($this->officePhone)."',
	'".addslashes($this->homepage)."',
	'".addslashes($this->offHrsMonday)."',
	'".addslashes($this->offHrsTuesday)."',
	'".addslashes($this->offHrsWednesday)."',
	'".addslashes($this->offHrsThursday)."',
	'".addslashes($this->offHrsFriday)."')";
$db->query($sql);
}

}

function _deleteToDB() { return $this->_deleteFromDB(); } 

function _deleteFromDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->username =='') { trigger_error('deleteFromDB call with empty key'); return false; }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "delete from profile_faculty  where username = '{$this->{$this->_pkey}}'";
$db->query($sql);

}

}
}

?>
