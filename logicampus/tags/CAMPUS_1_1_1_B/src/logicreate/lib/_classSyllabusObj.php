<?
// primarily mapped against database table 
class _classSyllabusObj {
	var $id_class_syllabuses;		// (number) - 
	var $id_classes;		// (number) - 
	var $other;		// (number) - 
	var $courseObjectives;		// (number) - 
	var $courseReqs;		// (number) - 
	var $gradingScale;		// (number) - 
	var $instructionMethods;		// (number) - 
	var $emailPolicy;		// (number) - 
	var $_dsn = 'default';
	var $_pkey = 'id_class_syllabuses';


function _getFromDB($pkey,$prop='',$where='', $orderBy='', $dsn='default') {
   if ($orderBy) { $orderBy = " order by $orderBy"; }
   if ($where) { $where = " and $where"; }
   $db = DB::getHandle($dsn);
   if ($prop=='') { $prop=$this->_pkey; }
   $db->query("select id_class_syllabuses,id_classes,other,courseObjectives,courseReqs,gradingScale,instructionMethods,emailPolicy from class_syllabuses where $prop='$pkey' $where $orderBy");
   if($db->next_record()) {
      $temp = new classSyllabusObj();
      $temp->_dsn = $dsn;
      $temp->__loaded = true; 

      $temp->id_class_syllabuses = $db->Record['id_class_syllabuses'];
      $temp->id_classes = $db->Record['id_classes'];
      $temp->other = $db->Record['other'];
      $temp->courseObjectives = $db->Record['courseObjectives'];
      $temp->courseReqs = $db->Record['courseReqs'];
      $temp->gradingScale = $db->Record['gradingScale'];
      $temp->instructionMethods = $db->Record['instructionMethods'];
      $temp->emailPolicy = $db->Record['emailPolicy'];
   }
return $temp;

}


function _getAllFromDB($key, $prop, $where='', $orderBy='',$dsn='default') {
   $db = DB::getHandle($dsn);
   if ($orderBy) { $orderBy = " order by $orderBy"; }
   if ($where) { $where = " and $where"; }
   $db->query("select id_class_syllabuses,id_classes,other,courseObjectives,courseReqs,gradingScale,instructionMethods,emailPolicy from class_syllabuses where $prop='$key' $where $orderBy");
   while ($db->next_record()) {
      $temp = new classSyllabusObj();
      $temp->_dsn = $dsn;
      $temp->__loaded = true; 
      $temp->id_class_syllabuses = $db->Record['id_class_syllabuses'];
      $temp->id_classes = $db->Record['id_classes'];
      $temp->other = $db->Record['other'];
      $temp->courseObjectives = $db->Record['courseObjectives'];
      $temp->courseReqs = $db->Record['courseReqs'];
      $temp->gradingScale = $db->Record['gradingScale'];
      $temp->instructionMethods = $db->Record['instructionMethods'];
      $temp->emailPolicy = $db->Record['emailPolicy'];
      $objects[] = $temp;
}
return $objects;

}


function _loadArray($array, $pkeyFlag=false) {
 if ($pkeyFlag) { 
	$this->id_class_syllabuses = $array['id_class_syllabuses'];
 }
	$this->id_classes = $array['id_classes'];
	$this->other = $array['other'];
	$this->courseObjectives = $array['courseObjectives'];
	$this->courseReqs = $array['courseReqs'];
	$this->gradingScale = $array['gradingScale'];
	$this->instructionMethods = $array['instructionMethods'];
	$this->emailPolicy = $array['emailPolicy'];
}

function _genPkey($len=50) {
return str_replace(".","",uniqid(str_replace(" ","",microtime()), $len));
}

function _saveToDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_class_syllabuses =='') {$this->id_class_syllabuses=$this->_genPkey(); }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "update class_syllabuses set id_classes='{$this->id_classes}',other='{$this->other}',courseObjectives='{$this->courseObjectives}',courseReqs='{$this->courseReqs}',gradingScale='{$this->gradingScale}',instructionMethods='{$this->instructionMethods}',emailPolicy='{$this->emailPolicy}' where id_class_syllabuses = '{$this->{$this->_pkey}}'";
} else {
$sql = "replace into class_syllabuses   (id_classes,other,courseObjectives,courseReqs,gradingScale,instructionMethods,emailPolicy) values ('{$this->id_classes}','{$this->other}','{$this->courseObjectives}','{$this->courseReqs}','{$this->gradingScale}','{$this->instructionMethods}','{$this->emailPolicy}')";
}
$db->query($sql);

}

function _deleteToDB() { return $this->_deleteFromDB(); } 

function _deleteFromDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_class_syllabuses =='') { trigger_error('deleteFromDB call with empty key'); return false; }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "delete from class_syllabuses  where id_class_syllabuses = '{$this->{$this->_pkey}}'";
$db->query($sql);

}

}
}

?>
