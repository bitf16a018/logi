<?
// primarily mapped against database table 
class classLessonObj {
	var $id_class_lessons;		// (number) - 
	var $createdOn;		// (number) - 
	var $title;		// (number) - 
	var $description;		// (number) - 
	var $checkList;
	var $_dsn = 'default';
	var $_pkey = 'id_class_lessons';


function _getFromDB($pkey,$prop='',$where='', $orderBy='', $dsn='default') {
   if ($orderBy) { $orderBy = " order by $orderBy"; }
   if ($where) { $where = " and $where"; }
   $db = DB::getHandle($dsn);
   if ($prop=='') { $prop=$this->_pkey; }
   $db->query("select checkList,id_class_lessons,createdOn,title,description from class_lessons where $prop='$pkey' $where $orderBy");
   if($db->nextRecord()) {
      $temp = new classLessonObj();
      $temp->_dsn = $dsn;
      $temp->__loaded = true; 
      $temp->id_class_lessons = $db->record['id_class_lessons'];
      $temp->checkList = $db->record['checkList'];
      $temp->createdOn = $db->record['createdOn'];
      $temp->title = $db->record['title'];
      $temp->description = $db->record['description'];
   }
if ( !$temp ) { trigger_error('empty persistant object'); }
return $temp;

}


function _getAllFromDB($key,$prop='',$where='', $orderBy='',$dsn='default') {
   $db = DB::getHandle($dsn);
   if ($orderBy) { $orderBy = " order by $orderBy"; }
   if ($where) { $where = " and $where"; }
   $db->query("select checkList,id_class_lessons,createdOn,title,description from class_lessons where $prop='$key' $where $orderBy");
   while ($db->nextRecord()) {
      $temp = new classLessonObj();
      $temp->_dsn = $dsn;
      $temp->__loaded = true; 
      $temp->id_class_lessons = $db->record['id_class_lessons'];
      $temp->createdOn = $db->record['createdOn'];
      $temp->checkList = $db->record['checkList'];
      $temp->title = $db->record['title'];
      $temp->description = $db->record['description'];
      $objects[] = $temp;
}
return $objects;

}


function _loadArray($array, $pkeyFlag=false) {
 if ($pkeyFlag) { 
	$this->id_class_lessons = $array['id_class_lessons'];
 }
	$this->createdOn = $array['createdOn'];
	$this->title = $array['title'];
	$this->checkList = $array['checkList'];
	$this->description = $array['description'];
}

function _genPkey($len=50) {
return str_replace(".","",uniqid(str_replace(" ","",microtime()), $len));
}

function _saveToDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_class_lessons =='') {$this->id_class_lessons=$this->_genPkey(); }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "update class_lessons set 
checkList='".addslashes($this->checkList)."', 
id_class_lessons='".addslashes($this->id_class_lessons)."',
createdOn='".addslashes($this->createdOn)."',
title='".addslashes($this->title)."',
description='".addslashes($this->description)."' where 
id_class_lessons = '{$this->{$this->_pkey}}'";
$db->query($sql);
} else {
$sql = "insert into class_lessons   (checkList,id_class_lessons,createdOn,title,description) values (
	'".addslashes($this->checkList)."',
	'".addslashes($this->id_class_lessons)."',
	'".addslashes($this->createdOn)."',
	'".addslashes($this->title)."',
	'".addslashes($this->description)."')";
$db->query($sql);
}

}

function _deleteToDB() { return $this->_deleteFromDB(); } 

function _deleteFromDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_class_lessons =='') { trigger_error('deleteFromDB call with empty key'); return false; }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "delete from class_lessons  where id_class_lessons = '{$this->{$this->_pkey}}'";
$db->query($sql);

}

}
}

?>
