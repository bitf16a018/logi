<?
// NOTE: this file has been modified from the originally generated one (by Adam)

// primarily mapped against database table 
class classLessonObjectiveObj {
	var $id_class_objectives;		// (number) - 
	var $id_classes;		// (number) - 
	var $f_hide;
	var $i_sort;
	var $objective;		// (number) - 
	var $_dsn = 'default';
	var $_pkey = 'id_class_objectives';
function _getFromDB($pkey,$prop='',$where='', $orderBy='', $dsn='default') {
if ($orderBy) { $orderBy = ' order by $orderBy '; }
if ($where) { $where = ' and $where'; }
$db = DB::getHandle($dsn);
 if ($prop=='') { $prop=$this->_pkey; }
$db->query("select i_sort,f_hide,id_class_objectives,id_classes,objective from class_objectives where $prop='$pkey' $where $orderBy");
while ($db->next_record()) {
 $temp = new classLessonObjectiveObj();
$temp->_dsn = $dsn;
$temp->__loaded = true; 
$temp->i_sort = $db->Record['i_sort'];
$temp->f_hide = $db->Record['f_hide'];
$temp->id_class_objectives = $db->Record['id_class_objectives'];
$temp->id_class_lessons = $db->Record['id_class_lessons'];
$temp->id_classes = $db->Record['id_classes'];
$temp->objective = $db->Record['objective'];
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
$db->query("select i_sort,f_hide,id_class_objectives,id_class_lessons,id_classes,objective from class_objectives $where $orderBy");
while ($db->next_record()) {
 $temp = new classLessonObjectiveObj();
$temp->_dsn = $dsn;
$temp->__loaded = true; 
$temp->i_sort = $db->Record['i_sort'];
$temp->f_hide = $db->Record['f_hide'];
$temp->id_class_objectives = $db->Record['id_class_objectives'];
$temp->id_class_lessons = $db->Record['id_class_lessons'];
$temp->id_classes = $db->Record['id_classes'];
$temp->objective = $db->Record['objective'];
$objects[] = $temp;
}
 return $objects;

}

function _loadArray($array, $pkeyFlag=false) {
	$this->id_class_objectives = $array['id_class_objectives'];
	$this->id_class_lessons = $array['id_class_lessons'];
	$this->id_classes = $array['id_classes'];
	$this->f_hide = $array['f_hide'];
	$this->i_sort = (int)$array['i_sort']; // i'm forcing int
	$this->objective = $array['objective'];
}

function _genPkey($len=50) {
return str_replace(".","",uniqid(str_replace(" ","",microtime()), $len));
}

function _saveToDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_class_objectives =='') {$this->id_class_objectives=$this->_genPkey(); }
if ($this->__loaded) { // was the object loaded from DB already?
// Adam modified this next line
$sql = "update class_objectives set 
i_sort='".addslashes($this->i_sort)."',
f_hide='".addslashes($this->f_hide)."', 
id_class_objectives='".addslashes($this->id_class_objectives)."',
id_classes='".addslashes($this->id_classes)."',
objective='".addslashes($this->objective)."' where 
id_class_objectives = '{$this->{$this->_pkey}}'";
} else {
// Adam modified this next line
$sql = "insert into class_objectives   (i_sort,f_hide,id_classes,objective) values (
	'{$this->i_sort}',
	'{$this->f_hide}',
	'{$this->id_classes}',
	'{$this->objective}')";
}
$db->query($sql);

}

function _deleteToDB() { return $this->_deleteFromDB(); } 

function _deleteFromDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_class_objectives =='') { trigger_error('deleteFromDB call with empty key'); return false; }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "delete from class_objectives  where id_class_objectives = '{$this->{$this->_pkey}}'";
$db->query($sql);

}

}
}

?>
