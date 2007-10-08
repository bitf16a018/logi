<?
// primarily mapped against database table 
class classLinks {
	var $id_class_links;		// (number) - 
	var $id_classes;		// (number) - 
	var $id_class_links_categories;		// (number) - 
	var $title;		// (number) - 
	var $url;		// (number) - 
	var $description;		// (number) - 
	var $dateCreated;		// (number) - 
	var $createdby;		// (number) - 
	var $hits;		// (number) - 
	var $_dsn = 'default';
	var $_pkey = 'id_class_links';
function _getFromDB($pkey,$prop='',$where='', $orderBy='', $dsn='default') {
if ($orderBy) { $orderBy = ' order by $orderBy '; }
if ($where) { $where = " and $where"; }
$db = DB::getHandle($dsn);
 if ($prop=='') { $prop=$this->_pkey; }
$db->query("select id_class_links,id_classes,id_class_links_categories,title,url,description,dateCreated,createdby,hits from class_links where $prop='$pkey' $where $orderBy");
while ($db->nextRecord()) {
 $temp = new classLinks();
$temp->_dsn = $dsn;
$temp->__loaded = true; 
$temp->id_class_links = $db->record['id_class_links'];
$temp->id_classes = $db->record['id_classes'];
$temp->id_class_links_categories = $db->record['id_class_links_categories'];
$temp->title = $db->record['title'];
$temp->url = $db->record['url'];
$temp->description = $db->record['description'];
$temp->dateCreated = $db->record['dateCreated'];
$temp->createdby = $db->record['createdby'];
$temp->hits = $db->record['hits'];
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
$db->query("select id_class_links,id_classes,id_class_links_categories,title,url,description,dateCreated,createdby,hits from class_links $where $orderBy");
while ($db->nextRecord()) {
 $temp = new classLinks();
$temp->_dsn = $dsn;
$temp->__loaded = true; 
$temp->id_class_links = $db->record['id_class_links'];
$temp->id_classes = $db->record['id_classes'];
$temp->id_class_links_categories = $db->record['id_class_links_categories'];
$temp->title = $db->record['title'];
$temp->url = $db->record['url'];
$temp->description = $db->record['description'];
$temp->dateCreated = $db->record['dateCreated'];
$temp->createdby = $db->record['createdby'];
$temp->hits = $db->record['hits'];
$objects[] = $temp;
}
 return $objects;

}

function _loadArray($array, $pkeyFlag=false) {
 if ($pkeyFlag) { 
	$this->id_class_links = $array['id_class_links'];
 }
	$this->id_classes = $array['id_classes'];
	$this->id_class_links_categories = $array['id_class_links_categories'];
	$this->title = $array['title'];
	$this->url = $array['url'];
	$this->description = $array['description'];
	$this->dateCreated = $array['dateCreated'];
	$this->createdby = $array['createdby'];
	$this->hits = $array['hits'];
}

function _genPkey($len=50) {
return str_replace(".","",uniqid(str_replace(" ","",microtime()), $len));
}

function _saveToDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_class_links =='') {$this->id_class_links=$this->_genPkey(); }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "update class_links set 
id_class_links='".addslashes($this->id_class_links)."',
id_classes='".addslashes($this->id_classes)."',
id_class_links_categories='".addslashes($this->id_class_links_categories)."',
title='".addslashes($this->title)."',
url='".addslashes($this->url)."',
description='".addslashes($this->description)."',
dateCreated='".addslashes($this->dateCreated)."',
createdby='".addslashes($this->createdby)."',
hits='".addslashes($this->hits)."' where 
id_class_links = '{$this->{$this->_pkey}}'";
$db->query($sql);
} else {
$sql = "insert into class_links   (id_classes,id_class_links_categories,title,url,description,dateCreated,createdby,hits) values (
	'".addslashes($this->id_classes)."',
	'".addslashes($this->id_class_links_categories)."',
	'".addslashes($this->title)."',
	'".addslashes($this->url)."',
	'".addslashes($this->description)."',
	'".addslashes($this->dateCreated)."',
	'".addslashes($this->createdby)."',
	'".addslashes($this->hits)."')";
$db->query($sql);
}

}

function _deleteToDB() { return $this->_deleteFromDB(); } 

function _deleteFromDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_class_links =='') { trigger_error('deleteFromDB call with empty key'); return false; }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "delete from class_links  where id_class_links = '{$this->{$this->_pkey}}'";
$db->query($sql);

}

}
}

?>
