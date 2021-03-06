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
   if($db->next_record()) {
      $temp = new classLessonObj();
      $temp->_dsn = $dsn;
      $temp->__loaded = true; 
      $temp->id_class_lessons = $db->Record['id_class_lessons'];
      $temp->checkList = $db->Record['checkList'];
      $temp->createdOn = $db->Record['createdOn'];
      $temp->title = $db->Record['title'];
      $temp->description = $db->Record['description'];
   }
if ( !$temp ) { trigger_error('empty persistant object'); }
return $temp;

}


function _getAllFromDB($key,$prop='',$where='', $orderBy='',$dsn='default') {
   $db = DB::getHandle($dsn);
   if ($orderBy) { $orderBy = " order by $orderBy"; }
   if ($where) { $where = " and $where"; }
   $db->query("select checkList,id_class_lessons,createdOn,title,description from class_lessons where $prop='$key' $where $orderBy");
   while ($db->next_record()) {
      $temp = new classLessonObj();
      $temp->_dsn = $dsn;
      $temp->__loaded = true; 
      $temp->id_class_lessons = $db->Record['id_class_lessons'];
      $temp->createdOn = $db->Record['createdOn'];
      $temp->checkList = $db->Record['checkList'];
      $temp->title = $db->Record['title'];
      $temp->description = $db->Record['description'];
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
$sql = "update class_lessons set checkList='{$this->checkList}', id_class_lessons='{$this->id_class_lessons}',createdOn='{$this->createdOn}',title='{$this->title}',description='{$this->description}' where id_class_lessons = '{$this->{$this->_pkey}}'";
$db->query($sql);
} else {
$sql = "insert into class_lessons   (checkList,id_class_lessons,createdOn,title,description) values ('{$this->checkList}','{$this->id_class_lessons}','{$this->createdOn}','{$this->title}','{$this->description}')";
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
