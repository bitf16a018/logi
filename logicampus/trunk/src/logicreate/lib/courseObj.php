<?
// primarily mapped against database table 
class courseObj {
	var $id_courses;		// (number) - 
	var $courseFamily;		// (number) - 
	var $courseNumber;		// (number) - 
	var $courseName;		// (number) - 
	var $courseDescription;		// (number) - 
	var $preReq1;		// (number) - 
	var $preReq2;		// (number) - 
	var $preReq3;		// (number) - 
	var $preReq4;		// (number) - 
	var $coReq1;		// (number) - 
	var $coReq2;		// (number) - 
	var $coReq3;		// (number) - 
	var $coReq4;		// (number) - 
	var $_dsn = 'default';
	var $_pkey = 'id_courses';
function _getFromDB($pkey,$prop='',$where='', $orderBy='', $dsn='default') {
if ($orderBy) { $orderBy = ' order by $orderBy '; }
if ($where) { $where = ' and $where'; }
$db = DB::getHandle($dsn);
 if ($prop=='') { $prop=$this->_pkey; }
$db->query("select id_courses,courseFamily,courseNumber,courseName,courseDescription,preReq1,preReq2,preReq3,preReq4,coReq1,coReq2,coReq3,coReq4 from courses where $prop='$pkey' $where $orderBy");
while ($db->next_record()) {
 $temp = new courseObj();
$temp->_dsn = $dsn;
$temp->__loaded = true; 
$temp->id_courses = $db->Record['id_courses'];
$temp->courseFamily = $db->Record['courseFamily'];
$temp->courseNumber = $db->Record['courseNumber'];
$temp->courseName = $db->Record['courseName'];
$temp->courseDescription = $db->Record['courseDescription'];
$temp->preReq1 = $db->Record['preReq1'];
$temp->preReq2 = $db->Record['preReq2'];
$temp->preReq3 = $db->Record['preReq3'];
$temp->preReq4 = $db->Record['preReq4'];
$temp->coReq1 = $db->Record['coReq1'];
$temp->coReq2 = $db->Record['coReq2'];
$temp->coReq3 = $db->Record['coReq3'];
$temp->coReq4 = $db->Record['coReq4'];
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
$db->query("select id_courses,courseFamily,courseNumber,courseName,courseDescription,preReq1,preReq2,preReq3,preReq4,coReq1,coReq2,coReq3,coReq4 from courses $where $orderBy");
while ($db->next_record()) {
 $temp = new courseObj();
$temp->_dsn = $dsn;
$temp->__loaded = true; 
$temp->id_courses = $db->Record['id_courses'];
$temp->courseFamily = $db->Record['courseFamily'];
$temp->courseNumber = $db->Record['courseNumber'];
$temp->courseName = $db->Record['courseName'];
$temp->courseDescription = $db->Record['courseDescription'];
$temp->preReq1 = $db->Record['preReq1'];
$temp->preReq2 = $db->Record['preReq2'];
$temp->preReq3 = $db->Record['preReq3'];
$temp->preReq4 = $db->Record['preReq4'];
$temp->coReq1 = $db->Record['coReq1'];
$temp->coReq2 = $db->Record['coReq2'];
$temp->coReq3 = $db->Record['coReq3'];
$temp->coReq4 = $db->Record['coReq4'];
$objects[] = $temp;
}
 return $objects;

}

function _loadArray($array, $pkeyFlag=false) {
 if ($pkeyFlag) { 
	$this->id_courses = $array['id_courses'];
 }
	$this->courseFamily = $array['courseFamily'];
	$this->courseNumber = $array['courseNumber'];
	$this->courseName = $array['courseName'];
	$this->courseDescription = $array['courseDescription'];
	$this->preReq1 = $array['preReq1'];
	$this->preReq2 = $array['preReq2'];
	$this->preReq3 = $array['preReq3'];
	$this->preReq4 = $array['preReq4'];
	$this->coReq1 = $array['coReq1'];
	$this->coReq2 = $array['coReq2'];
	$this->coReq3 = $array['coReq3'];
	$this->coReq4 = $array['coReq4'];
}

function _genPkey($len=50) {
return str_replace(".","",uniqid(str_replace(" ","",microtime()), $len));
}

function _saveToDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_courses =='') {$this->id_courses=$this->_genPkey(); }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "update courses set id_courses='{$this->id_courses}',courseFamily='{$this->courseFamily}',courseNumber='{$this->courseNumber}',courseName='{$this->courseName}',courseDescription='{$this->courseDescription}',preReq1='{$this->preReq1}',preReq2='{$this->preReq2}',preReq3='{$this->preReq3}',preReq4='{$this->preReq4}',coReq1='{$this->coReq1}',coReq2='{$this->coReq2}',coReq3='{$this->coReq3}',coReq4='{$this->coReq4}' where id_courses = '{$this->{$this->_pkey}}'";
$db->query($sql);
} else {
$sql = "insert into courses   (courseFamily,courseNumber,courseName,courseDescription,preReq1,preReq2,preReq3,preReq4,coReq1,coReq2,coReq3,coReq4) values ('{$this->courseFamily}','{$this->courseNumber}','{$this->courseName}','{$this->courseDescription}','{$this->preReq1}','{$this->preReq2}','{$this->preReq3}','{$this->preReq4}','{$this->coReq1}','{$this->coReq2}','{$this->coReq3}','{$this->coReq4}')";
$db->query($sql);
}

}

function _deleteToDB() { return $this->_deleteFromDB(); } 

function _deleteFromDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_courses =='') { trigger_error('deleteFromDB call with empty key'); return false; }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "delete from courses  where id_courses = '{$this->{$this->_pkey}}'";
$db->query($sql);

}

}
}

?>
