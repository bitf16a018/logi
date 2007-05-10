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
   if($db->next_record()) {
      $temp = new classAnnouncements();
      $temp->_dsn = $dsn;
      $temp->__loaded = true; 
      $temp->id_class_announcements = $db->Record['id_class_announcements'];
      $temp->id_classes = $db->Record['id_classes'];
      $temp->dt_display = $db->Record['dt_display'];
      $temp->tx_title = $db->Record['tx_title'];
      $temp->tx_description = $db->Record['tx_description'];
      $temp->id_faculty_createdby = $db->Record['id_faculty_createdby'];
      $temp->dt_created = $db->Record['dt_created'];
   }
if ( !$temp ) { trigger_error('empty persistant object'); }
return $temp;

}


function _getAllFromDB($key,$prop='',$where='', $orderBy='',$dsn='default') {
   $db = DB::getHandle($dsn);
   if ($orderBy) { $orderBy = " order by $orderBy"; }
   if ($where) { $where = " and $where"; }
   $db->query("select id_class_announcements,id_classes,dt_display,tx_title,tx_description,id_faculty_createdby,dt_created from class_announcements where $prop='$key' $where $orderBy");
   while ($db->next_record()) {
      $temp = new classAnnouncements();
      $temp->_dsn = $dsn;
      $temp->__loaded = true; 
      $temp->id_class_announcements = $db->Record['id_class_announcements'];
      $temp->id_classes = $db->Record['id_classes'];
      $temp->dt_display = $db->Record['dt_display'];
      $temp->tx_title = $db->Record['tx_title'];
      $temp->tx_description = $db->Record['tx_description'];
      $temp->id_faculty_createdby = $db->Record['id_faculty_createdby'];
      $temp->dt_created = $db->Record['dt_created'];
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
$sql = "update class_announcements set id_class_announcements='{$this->id_class_announcements}',id_classes='{$this->id_classes}',dt_display='{$this->dt_display}',tx_title='{$this->tx_title}',tx_description='{$this->tx_description}',id_faculty_createdby='{$this->id_faculty_createdby}',dt_created='{$this->dt_created}' where id_class_announcements = '{$this->{$this->_pkey}}'";
$db->query($sql);
} else {
$sql = "insert into class_announcements   (id_classes,dt_display,tx_title,tx_description,id_faculty_createdby,dt_created) values ('{$this->id_classes}','{$this->dt_display}','{$this->tx_title}','{$this->tx_description}','{$this->id_faculty_createdby}','{$this->dt_created}')";
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
