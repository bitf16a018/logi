<?
// primarily mapped against database table 
class classLinksCategories {
	var $id_class_links_categories;		// (number) - 
	var $id_class_links_categories_parent;		// (number) - 
	var $id_classes;		// (number) - 
	var $txTitle;		// (number) - 
	var $sortOrder;		// (number) - 
	var $_dsn = 'default';
	var $_pkey = 'id_class_links_categories';
function _getFromDB($pkey,$prop='',$where='', $orderBy='', $dsn='default') {
if ($orderBy) { $orderBy = ' order by $orderBy '; }
if ($where) { $where = " and $where"; }
$db = DB::getHandle($dsn);
 if ($prop=='') { $prop=$this->_pkey; }
$db->query("select id_class_links_categories,id_class_links_categories_parent,id_classes,txTitle,sortOrder from class_links_categories where $prop='$pkey' $where $orderBy");
while ($db->next_record()) {
 $temp = new classLinksCategories();
$temp->_dsn = $dsn;
$temp->__loaded = true; 
$temp->id_class_links_categories = $db->Record['id_class_links_categories'];
$temp->id_class_links_categories_parent = $db->Record['id_class_links_categories_parent'];
$temp->id_classes = $db->Record['id_classes'];
$temp->txTitle = $db->Record['txTitle'];
$temp->sortOrder = $db->Record['sortOrder'];
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
$db->query("select id_class_links_categories,id_class_links_categories_parent,id_classes,txTitle,sortOrder from class_links_categories $where $orderBy");
while ($db->next_record()) {
 $temp = new classLinksCategories();
$temp->_dsn = $dsn;
$temp->__loaded = true; 
$temp->id_class_links_categories = $db->Record['id_class_links_categories'];
$temp->id_class_links_categories_parent = $db->Record['id_class_links_categories_parent'];
$temp->id_classes = $db->Record['id_classes'];
$temp->txTitle = $db->Record['txTitle'];
$temp->sortOrder = $db->Record['sortOrder'];
$objects[] = $temp;
}
 return $objects;

}

function _loadArray($array, $pkeyFlag=false) {
 if ($pkeyFlag) { 
	$this->id_class_links_categories = $array['id_class_links_categories'];
 }
	$this->id_class_links_categories_parent = $array['id_class_links_categories_parent'];
	$this->id_classes = $array['id_classes'];
	$this->txTitle = $array['txTitle'];
	$this->sortOrder = $array['sortOrder'];
}

function _genPkey($len=50) {
return str_replace(".","",uniqid(str_replace(" ","",microtime()), $len));
}

function _saveToDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_class_links_categories =='') {$this->id_class_links_categories=$this->_genPkey(); }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "update class_links_categories set id_class_links_categories='{$this->id_class_links_categories}',id_class_links_categories_parent='{$this->id_class_links_categories_parent}',id_classes='{$this->id_classes}',txTitle='{$this->txTitle}',sortOrder='{$this->sortOrder}' where id_class_links_categories = '{$this->{$this->_pkey}}'";
$db->query($sql);
} else {
$sql = "insert into class_links_categories   (id_class_links_categories_parent,id_classes,txTitle,sortOrder) values ('{$this->id_class_links_categories_parent}','{$this->id_classes}','{$this->txTitle}','{$this->sortOrder}')";
$db->query($sql);
}

}

function _deleteToDB() { return $this->_deleteFromDB(); } 

function _deleteFromDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_class_links_categories =='') { trigger_error('deleteFromDB call with empty key'); return false; }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "delete from class_links_categories  where id_class_links_categories = '{$this->{$this->_pkey}}'";
$db->query($sql);

}

}
}

?>
