<?
// primarily mapped against database table 
class presentationObj {
	var $id_presentations;		// (number) - 
	var $id_classes;		// (number) - 
	var $title;		// (number) - 
	var $status;		// (number) - 
	var $author;		// (number) - 
	var $createdOn;		// (number) - 
	var $approvedOn;	// (number) - 
	var $content;		// (number) - 
	var $_dsn = 'default';
	var $_pkey = 'id_presentations';
function _getFromDB($pkey,$prop='',$where='', $orderBy='', $dsn='default') {
if ($orderBy) { $orderBy = " order by $orderBy "; }
if ($where) { $where = " and $where"; }
$db = DB::getHandle($dsn);
 if ($prop=='') { $prop=$this->_pkey; }
$db->query("select id_presentations,id_classes,title,status,author,createdOn,approvedOn,content from class_presentations where $prop='$pkey' $where $orderBy");
while ($db->nextRecord()) {
 $temp = new presentationObj();
$temp->_dsn = $dsn;
$temp->__loaded = true; 
$temp->id_presentations = $db->record['id_presentations'];
$temp->id_classes = $db->record['id_classes'];
$temp->title = $db->record['title'];
$temp->status = $db->record['status'];
$temp->author = $db->record['author'];
$temp->createdOn = $db->record['createdOn'];
$temp->approvedOn = $db->record['approvedOn'];
$temp->content = $db->record['content'];
$objects[] = $temp;
}
if (count($objects)>1) {
 return $objects;
 } else {
 return $objects[0]; 
}
}
function _getAllFromDB($dsn='default', $where='', $orderBy='') {
$db = DB::getHandle($dsn);
if ($orderBy) { $orderBy = ' order by $orderBy '; }
if ($where) { $where = ' and $where'; }
$db->query("select id_presentations,id_classes,title,status,author,createdOn,approvedOn,content from class_presentations $where $orderBy");
while ($db->nextRecord()) {
 $temp = new presentationObj();
$temp->_dsn = $dsn;
$temp->__loaded = true; 
$temp->id_presentations = $db->record['id_presentations'];
$temp->id_classes = $db->record['id_classes'];
$temp->title = $db->record['title'];
$temp->status = $db->record['status'];
$temp->author = $db->record['author'];
$temp->createdOn = $db->record['createdOn'];
$temp->approvedOn = $db->record['approvedOn'];
$temp->content = $db->record['content'];
$objects[] = $temp;
}
 return $objects;

}

function _loadArray($array, $pkeyFlag=false) {
 if ($pkeyFlag) { 
	$this->id_presentations = $array['id_presentations'];
 }
	$this->id_classes = $array['id_classes'];
	$this->title = $array['title'];
	$this->status = $array['status'];
	$this->author = $array['author'];
	$this->createdOn = $array['createdOn'];
	$this->approvedOn = $array['approvedOn'];
	$this->content = $array['content'];
}

function _genPkey($len=50) {
return str_replace(".","",uniqid(str_replace(" ","",microtime()), $len));
}

function _saveToDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_presentations =='') {$this->id_presentations=$this->_genPkey(); }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "update class_presentations set 
id_classes='".addslashes($this->id_classes)."',
title='".addslashes($this->title)."',
status='".addslashes($this->status)."',
author='".addslashes($this->author)."',
createdOn='".addslashes($this->createdOn)."',
approvedOn='".addslashes($this->approvedOn)."',
content='".addslashes($this->content)."' where id_presentations = '{$this->{$this->_pkey}}'";
$db->query($sql);
} else {
$sql = "insert into class_presentations (id_classes,title,status,author,createdOn,approvedOn,content) values (
	'".addslashes($this->id_classes)."',
	'".addslashes($this->title)."',
	'".addslashes($this->status)."',
	'".addslashes($this->author)."',
	'".addslashes($this->createdOn)."',
	'".addslashes($this->approvedOn)."',
	'".addslashes($this->content)."')";
$db->query($sql);
}

}

function _deleteToDB() { return $this->_deleteFromDB(); } 

function _deleteFromDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_presentations =='') { trigger_error('deleteFromDB call with empty key'); return false; }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "delete from class_presentations  where id_presentations = '{$this->{$this->_pkey}}'";
$db->query($sql);

}

}
}

?>
