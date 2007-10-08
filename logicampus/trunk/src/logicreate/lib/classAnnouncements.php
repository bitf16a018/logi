<?
// primarily mapped against database table 
class classAnnouncements {
	var $id_class_announcements;		// (number) - 
	var $id_classes;		// (number) - 
	var $dt_display;		// (number) - 
	var $tx_title;		// (number) - 
	var $tx_description;		// (number) - 
	var $id_faculty_createdby;		// (number) - 
	var $dt_created;		// (number) - 
	var $_dsn = 'default';
	var $_pkey = 'id_class_announcements';


function _getFromDB($pkey,$prop='',$where='', $orderBy='', $dsn='default') {
   if ($orderBy) { $orderBy = " order by $orderBy"; }
   if ($where) { $where = " and $where"; }
   $db = DB::getHandle($dsn);
   if ($prop=='') { $prop=$this->_pkey;  }
   $db->query("select id_class_announcements,id_classes,dt_display,tx_title,tx_description,id_faculty_createdby,dt_created from class_announcements where $pkey='$prop' $where $orderBy");
   if($db->nextRecord()) {
      $temp = new classAnnouncements();
      $temp->_dsn = $dsn;
      $temp->__loaded = true; 
      $temp->id_class_announcements = $db->record['id_class_announcements'];
      $temp->id_classes = $db->record['id_classes'];
      $temp->dt_display = $db->record['dt_display'];
      $temp->tx_title = $db->record['tx_title'];
      $temp->tx_description = $db->record['tx_description'];
      $temp->id_faculty_createdby = $db->record['id_faculty_createdby'];
      $temp->dt_created = $db->record['dt_created'];
   }
if ( !$temp ) { trigger_error('empty persistant object'); }
return $temp;

}


function _getAllFromDB($key,$prop='',$where='', $orderBy='',$dsn='default') {
   $db = DB::getHandle($dsn);
   if ($orderBy) { $orderBy = " order by $orderBy"; }
   if ($where) { $where = " and $where"; }
   $db->query("select id_class_announcements,id_classes,dt_display,tx_title,tx_description,id_faculty_createdby,dt_created from class_announcements where $prop='$key' $where $orderBy");
   while ($db->nextRecord()) {
      $temp = new classAnnouncements();
      $temp->_dsn = $dsn;
      $temp->__loaded = true; 
      $temp->id_class_announcements = $db->record['id_class_announcements'];
      $temp->id_classes = $db->record['id_classes'];
      $temp->dt_display = $db->record['dt_display'];
      $temp->tx_title = $db->record['tx_title'];
      $temp->tx_description = $db->record['tx_description'];
      $temp->id_faculty_createdby = $db->record['id_faculty_createdby'];
      $temp->dt_created = $db->record['dt_created'];
      $objects[] = $temp;
}
return $objects;

}


function _loadArray($array, $pkeyFlag=false) {
 if ($pkeyFlag) { 
	$this->id_class_announcements = $array['id_class_announcements'];
 }
	$this->id_classes = $array['id_classes'];
	$this->dt_display = $array['dt_display'];
	$this->tx_title = $array['tx_title'];
	$this->tx_description = $array['tx_description'];
	$this->id_faculty_createdby = $array['id_faculty_createdby'];
	$this->dt_created = $array['dt_created'];
}

function _genPkey($len=50) {
return str_replace(".","",uniqid(str_replace(" ","",microtime()), $len));
}

function _saveToDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_class_announcements =='') {$this->id_class_announcements=$this->_genPkey(); }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "update class_announcements set 
	id_class_announcements='".addslashes($this->id_class_announcements)."',
	id_classes='".addslashes($this->id_classes)."',
	dt_display='".addslashes($this->dt_display)."',
	tx_title='".addslashes($this->tx_title)."',
	tx_description='".addslashes($this->tx_description)."',
	id_faculty_createdby='".addslashes($this->id_faculty_createdby)."',
	dt_created='".addslashes($this->dt_created)."' 
	where id_class_announcements = '".addslashes($this->{$this->_pkey})."'";
$db->query($sql);
} else {
$sql = "insert into class_announcements   (id_classes,dt_display,tx_title,tx_description,id_faculty_createdby,dt_created) values (
	'".addslashes($this->id_classes)."',
	'".addslashes($this->dt_display)."',
	'".addslashes($this->tx_title)."',
	'".addslashes($this->tx_description)."',
	'".addslashes($this->id_faculty_createdby)."',
	'".addslashes($this->dt_created)."')";
$db->query($sql);
}

}

function _deleteToDB() { return $this->_deleteFromDB(); } 

function _deleteFromDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_class_announcements =='') {  trigger_error('deleteFromDB call with empty key'); return false; }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "delete from class_announcements  where id_class_announcements = '{$this->{$this->_pkey}}'";
$db->query($sql);

}

}
}

?>
