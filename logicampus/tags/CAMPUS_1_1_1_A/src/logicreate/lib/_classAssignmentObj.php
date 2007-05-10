<?
// primarily mapped against database table 
class _classAssignmentObj {
	var $id_class_assignments;		// (number) - 
	var $title;		// (number) - 
	var $instructions;		// (number) - 
	var $dueDate;		// (number) - 
	var $noDueDate;		// (number) - 
	var $activeDate;		// (number) - 
	var $responseType;		// (number) - 
	var $id_classes;		// (number) - 
	var $dateNoAccept;		// (number) -
	var $id_forum;
	var $id_forum_thread;
	 
	var $_dsn = 'default';
	var $_pkey = 'id_class_assignments';


function _getFromDB($pkey,$prop='',$where='', $orderBy='', $dsn='default') {
   if ($orderBy) { $orderBy = " order by $orderBy"; }
   if ($where) { $where = " and $where"; }
   $db = DB::getHandle($dsn);
   if ($prop=='') { $prop=$this->_pkey; }

   // Adam added this stuff here
   $thewhere = '';
   if ( is_array($pkey) ) {
   		while (list($k,$v) = @each($pkey)) {
			if ($thewhere) $thewhere .= ' and ';
			$thewhere .= "$k='$v'";
		}
   } else {
   		$thewhere = "$prop='$pkey'";
   }

   $db->query("select * from class_assignments where $thewhere $where $orderBy");
   if($db->next_record()) {
      $temp = new classAssignmentObj();
      $temp->_dsn = $dsn;
      $temp->__loaded = true; 
      $temp->id_class_assignments = $db->Record['id_class_assignments'];
      $temp->title = $db->Record['title'];
      $temp->instructions = $db->Record['instructions'];
      $temp->dueDate = $db->Record['dueDate'];
      $temp->noDueDate = $db->Record['noDueDate'];
      $temp->activeDate = $db->Record['activeDate'];
      $temp->responseType = $db->Record['responseType'];
      $temp->id_classes = $db->Record['id_classes'];
      $temp->dateNoAccept = $db->Record['dateNoAccept'];
      $temp->id_forum = $db->Record['id_forum'];
      $temp->id_forum_thread = $db->Record['id_forum_thread'];
      
   }
return $temp;

}


function _getAllFromDB($key, $prop, $where='', $orderBy='',$dsn='default') {
   $db = DB::getHandle($dsn);
   if ($orderBy) { $orderBy = " order by $orderBy"; }
   if ($where) { $where = " and $where"; }
   $db->query("select * from class_assignments where $prop='$key' $where $orderBy");
   while ($db->next_record()) {
      $temp = new classAssignmentObj();
      $temp->_dsn = $dsn;
      $temp->__loaded = true; 
      $temp->id_class_assignments = $db->Record['id_class_assignments'];
      $temp->title = $db->Record['title'];
      $temp->instructions = $db->Record['instructions'];
      $temp->dueDate = $db->Record['dueDate'];
      $temp->noDueDate = $db->Record['noDueDate'];
      $temp->activeDate = $db->Record['activeDate'];
      $temp->responseType = $db->Record['responseType'];
      $temp->id_classes = $db->Record['id_classes'];
      $temp->dateNoAccept = $db->Record['dateNoAccept'];
      $temp->id_forum = $db->Record['id_forum'];
      $temp->id_forum_thread = $db->Record['id_forum_thread'];
      
      $objects[] = $temp;
}
return $objects;

}


function _loadArray($array, $pkeyFlag=false) {
 if ($pkeyFlag) { 
	$this->id_class_assignments = $array['id_class_assignments'];
 }
	$this->title = $array['title'];
	$this->instructions = $array['instructions'];
	$this->dueDate = $array['dueDate'];
	$this->noDueDate = $array['noDueDate'];
	$this->activeDate = $array['activeDate'];
	$this->responseType = $array['responseType'];
	$this->id_classes = $array['id_classes'];
	$this->dateNoAccept = $array['dateNoAccept'];
	$this->id_forum = $array['id_forum'];
	$this->id_forum_thread = $array['id_forum_thread'];
}

function _genPkey($len=50) {
return str_replace(".","",uniqid(str_replace(" ","",microtime()), $len));
}

function _saveToDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "update class_assignments set id_forum='{$this->id_forum}', id_forum_thread='{$this->id_forum_thread}', id_class_assignments='{$this->id_class_assignments}',title='{$this->title}',instructions='{$this->instructions}',dueDate='{$this->dueDate}',noDueDate='{$this->noDueDate}',activeDate='{$this->activeDate}',responseType='{$this->responseType}',id_classes='{$this->id_classes}',dateNoAccept='{$this->dateNoAccept}' where id_class_assignments = '{$this->{$this->_pkey}}'";
$db->query($sql);
} else {
$sql = "replace into class_assignments   (id_forum, id_forum_thread, title,instructions,dueDate,noDueDate,activeDate,responseType,id_classes,dateNoAccept) values ('{$this->id_forum}','{$this->id_forum_thread}','{$this->title}','{$this->instructions}','{$this->dueDate}','{$this->noDueDate}','{$this->activeDate}','{$this->responseType}','{$this->id_classes}','{$this->dateNoAccept}')";
$db->query($sql);
$this->__id = $db->getInsertID();
}

}

function _deleteToDB() { return $this->_deleteFromDB(); } 

function _deleteFromDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "delete from class_assignments  where id_class_assignments = '{$this->{$this->_pkey}}'";
$db->query($sql);

}

}
}

?>
