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
while ($db->next_record()) {
 $temp = new classLinks();
$temp->_dsn = $dsn;
$temp->__loaded = true; 
$temp->id_class_links = $db->Record['id_class_links'];
$temp->id_classes = $db->Record['id_classes'];
$temp->id_class_links_categories = $db->Record['id_class_links_categories'];
$temp->title = $db->Record['title'];
$temp->url = $db->Record['url'];
$temp->description = $db->Record['description'];
$temp->dateCreated = $db->Record['dateCreated'];
$temp->createdby = $db->Record['createdby'];
$temp->hits = $db->Record['hits'];
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
while ($db->next_record()) {
 $temp = new classLinks();
$temp->_dsn = $dsn;
$temp->__loaded = true; 
$temp->id_class_links = $db->Record['id_class_links'];
$temp->id_classes = $db->Record['id_classes'];
$temp->id_class_links_categories = $db->Record['id_class_links_categories'];
$temp->title = $db->Record['title'];
$temp->url = $db->Record['url'];
$temp->description = $db->Record['description'];
$temp->dateCreated = $db->Record['dateCreated'];
$temp->createdby = $db->Record['createdby'];
$temp->hits = $db->Record['hits'];
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
$sql = "update class_links set id_class_links='{$this->id_class_links}',id_classes='{$this->id_classes}',id_class_links_categories='{$this->id_class_links_categories}',title='{$this->title}',url='{$this->url}',description='{$this->description}',dateCreated='{$this->dateCreated}',createdby='{$this->createdby}',hits='{$this->hits}' where id_class_links = '{$this->{$this->_pkey}}'";
$db->query($sql);
} else {
$sql = "insert into class_links   (id_classes,id_class_links_categories,title,url,description,dateCreated,createdby,hits) values ('{$this->id_classes}','{$this->id_class_links_categories}','{$this->title}','{$this->url}','{$this->description}','{$this->dateCreated}','{$this->createdby}','{$this->hits}')";
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
