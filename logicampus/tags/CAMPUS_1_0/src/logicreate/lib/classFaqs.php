<?
// primarily mapped against database table 
class classFaqs {
	var $id_class_faqs;		// (number) - 
	var $id_classes;		// (number) - 
	var $category;		// (number) - 
	var $question;		// (number) - 
	var $answer;		// (number) - 
	var $clicks;		// (number) - 
	var $groups;		// (number) - 
	var $_dsn = 'default';
	var $_pkey = 'id_class_faqs';


function _getFromDB($pkey,$prop='',$where='', $orderBy='', $dsn='default') {
   if ($orderBy) { $orderBy = " order by $orderBy"; }
   if ($where) { $where = " and $where"; }
   $db = DB::getHandle($dsn);
   if ($prop=='') { $prop=$this->_pkey; }
   $db->query("select id_class_faqs,id_classes,category,question,answer,clicks,groups from class_faqs where $prop='$pkey' $where $orderBy");
   if($db->next_record()) {
      $temp = new classFaqs();
      $temp->_dsn = $dsn;
      $temp->__loaded = true; 
      $temp->id_class_faqs = $db->Record['id_class_faqs'];
      $temp->id_classes = $db->Record['id_classes'];
      $temp->category = $db->Record['category'];
      $temp->question = $db->Record['question'];
      $temp->answer = $db->Record['answer'];
      $temp->clicks = $db->Record['clicks'];
      $temp->groups = $db->Record['groups'];
      
   }
if ( !$temp ) { trigger_error('empty persistant object'); }
return $temp;

}


function _getAllFromDB($key,$prop='',$where='', $orderBy='',$dsn='default') {
   $db = DB::getHandle($dsn);
   if ($orderBy) { $orderBy = " order by $orderBy"; }
   if ($where) { $where = " and $where"; }
   $db->query("select id_class_faqs,id_classes,category,question,answer,clicks,groups from class_faqs where $prop='$key' $where $orderBy");
   while ($db->next_record()) {
      $temp = new classFaqs();
      $temp->_dsn = $dsn;
      $temp->__loaded = true; 
      $temp->id_class_faqs = $db->Record['id_class_faqs'];
      $temp->id_classes = $db->Record['id_classes'];
      $temp->category = $db->Record['category'];
      $temp->question = $db->Record['question'];
      $temp->answer = $db->Record['answer'];
      $temp->clicks = $db->Record['clicks'];
      $temp->groups = $db->Record['groups'];
      $objects[] = $temp;
}
return $objects;

}


function _loadArray($array, $pkeyFlag=false) {
 if ($pkeyFlag) { 
	$this->id_class_faqs = $array['id_class_faqs'];
 }
	$this->id_classes = $array['id_classes'];
	$this->category = $array['category'];
	$this->question = $array['question'];
	$this->answer = $array['answer'];
	$this->clicks = $array['clicks'];
	$this->groups = $array['groups'];
	
}

function _genPkey($len=50) {
return str_replace(".","",uniqid(str_replace(" ","",microtime()), $len));
}

function _saveToDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_class_faqs =='') {$this->id_class_faqs=$this->_genPkey(); }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "update class_faqs set id_class_faqs='{$this->id_class_faqs}',id_classes='{$this->id_classes}',category='{$this->category}',question='{$this->question}',answer='{$this->answer}',clicks='{$this->clicks}',groups='{$this->groups}' where id_class_faqs = '{$this->{$this->_pkey}}'";
$db->query($sql);
} else {
$sql = "insert into class_faqs   (id_classes,category,question,answer,clicks,groups) values ('{$this->id_classes}','{$this->category}','{$this->question}','{$this->answer}','{$this->clicks}','{$this->groups}')";
$db->query($sql);
}

}

function _deleteToDB() { return $this->_deleteFromDB(); } 

function _deleteFromDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_class_faqs =='') {  trigger_error('deleteFromDB call with empty key'); return false; }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "delete from class_faqs  where id_class_faqs = '{$this->{$this->_pkey}}'";
$db->query($sql);

}

}
}

?>
