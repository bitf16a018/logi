<?
// primarily mapped against database table 
class classLessonContentObj {
	var $id_class_lesson_content;		// (number) - 
	var $id_classes;		// (number) - 
	var $txTitle;		// (number) - 
	var $txText;		// (number) - 
	var $dateCreated;		// (number) - 
	var $_dsn = 'default';
	var $_pkey = 'id_class_lesson_content';
function _getFromDB($pkey,$prop='',$where='', $orderBy='', $dsn='default') {
if ($orderBy) { $orderBy = ' order by $orderBy '; }
if ($where) { $where = " and $where"; }
$db = DB::getHandle($dsn);
 if ($prop=='') { $prop=$this->_pkey; }
$db->query("select id_class_lesson_content,id_classes,txTitle,txText,dateCreated from class_lesson_content where $prop='$pkey' $where $orderBy");
while ($db->next_record()) {
 $temp = new classLessonContentObj();
$temp->_dsn = $dsn;
$temp->__loaded = true; 
$temp->id_class_lesson_content = $db->Record['id_class_lesson_content'];
$temp->id_classes = $db->Record['id_classes'];
$temp->txTitle = $db->Record['txTitle'];
$temp->txText = $db->Record['txText'];
$temp->dateCreated = $db->Record['dateCreated'];
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
$db->query("select id_class_lesson_content,id_classes,txTitle,txText,dateCreated from class_lesson_content $where $orderBy");
while ($db->next_record()) {
 $temp = new classLessonContentObj();
$temp->_dsn = $dsn;
$temp->__loaded = true; 
$temp->id_class_lesson_content = $db->Record['id_class_lesson_content'];
$temp->id_classes = $db->Record['id_classes'];
$temp->txTitle = $db->Record['txTitle'];
$temp->txText = $db->Record['txText'];
$temp->dateCreated = $db->Record['dateCreated'];
$objects[] = $temp;
}
 return $objects;

}

function _loadArray($array, $pkeyFlag=false) {
 if ($pkeyFlag) { 
	$this->id_class_lesson_content = $array['id_class_lesson_content'];
 }
	$this->id_classes = $array['id_classes'];
	$this->txTitle = $array['txTitle'];
	$this->txText = $array['txText'];
	$this->dateCreated = $array['dateCreated'];
}

function _genPkey($len=50) {
return str_replace(".","",uniqid(str_replace(" ","",microtime()), $len));
}

function _saveToDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_class_lesson_content =='') {$this->id_class_lesson_content=$this->_genPkey(); }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "update class_lesson_content set 
id_class_lesson_content='".addslashes($this->id_class_lesson_content)."',
id_classes='".addslashes($this->id_classes)."',
txTitle='".addslashes($this->txTitle)."',
txText='".addslashes($this->txText)."',
dateCreated='".addslashes($this->dateCreated)."' where 
id_class_lesson_content = '{$this->{$this->_pkey}}'";
$db->query($sql);
} else {
$sql = "insert into class_lesson_content   (id_classes,txTitle,txText,dateCreated) values (
'{$this->id_classes}',
'{$this->txTitle}',
'{$this->txText}',
'{$this->dateCreated}')";
$db->query($sql);
}

}

function _deleteToDB() { return $this->_deleteFromDB(); } 

function _deleteFromDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_class_lesson_content =='') {  trigger_error('deleteFromDB call with empty key'); return false; }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "delete from class_lesson_content  where id_class_lesson_content = '{$this->{$this->_pkey}}'";
$db->query($sql);

}

}
}

?>
