<?
// primarily mapped against database table 
class semesterObj {
	var $id_semesters;		// (number) - 
	var $semesterId;		// (number) - 
	var $semesterTerm;		// (number) - 
	var $dateCensus;		// (number) - 
	var $dateFinalDrop;		// (number) - 
	var $dateDeactivation;		// (number) - 
	var $dateStart;		// (number) - 
	var $dateEnd;		// (number) - 
	var $dateRegistrationStart;		// (number) - 
	var $dateRegistrationEnd;		// (number) - 
	var $dateAccountActivation;		// (number) - 
	var $dateStudentActivation;		// (number) - 
	var $semesterYear;		// (number) - 
	var $dateEndITVseminar;
	var $dateStartITVseminar;
	
	var $dateStartOrientation;
	var $dateEndOrientation; 
	
	var $dateEndTextbook;
	var $dateStartTextbook;
	
	var $dateEndExam;
	var $dateStartExam;
	
	var $_dsn = 'default';
	var $_pkey = 'id_semesters';


function getCurrentID()
{
	$id_semesters = 0;
	
	$sql = '
	SELECT id_semesters from semesters
	WHERE dateEnd > '.DB::getFuncName('NOW()').'
	ORDER BY dateEnd ASC limit 1';

	$db = DB::getHandle();

	$db->queryOne($sql);

	if ($db->Record['id_semesters'])
	{
		$id_semesters = $db->Record['id_semesters'];
	}
	
return $id_semesters;	
}


function _getFromDB($pkey,$prop='',$where='', $orderBy='', $dsn='default') {
   if ($orderBy) { $orderBy = " order by $orderBy"; }
   if ($where) { $where = " and $where"; }
   $db = DB::getHandle($dsn);
   if ($prop=='') { $prop=$this->_pkey; }
   $db->query("select * from semesters where $prop='$pkey' $where $orderBy");
   if($db->next_record()) {
      $temp = new semesterObj();
      $temp->_dsn = $dsn;
      $temp->__loaded = true; 
      
      $temp->dateStartExam = $db->Record['dateStartExam'];
      $temp->dateEndExam = $db->Record['dateEndExam'];
      $temp->dateStartTextbook = $db->Record['dateStartTextbook'];
      $temp->dateEndTextbook = $db->Record['dateEndTextbook'];
      
      $temp->dateStartOrientation = $db->Record['dateStartOrientation'];
      $temp->dateEndOrientation = $db->Record['dateEndOrientation'];
      $temp->dateEndITVseminar = $db->Record['dateEndITVseminar'];
      $temp->dateStartITVseminar = $db->Record['dateStartITVseminar'];
      $temp->id_semesters = $db->Record['id_semesters'];
      $temp->semesterId = $db->Record['semesterId'];
      $temp->semesterTerm = $db->Record['semesterTerm'];
      $temp->dateCensus = $db->Record['dateCensus'];
      $temp->dateFinalDrop = $db->Record['dateFinalDrop'];
      $temp->dateDeactivation = $db->Record['dateDeactivation'];
      $temp->dateStart = $db->Record['dateStart'];
      $temp->dateEnd = $db->Record['dateEnd'];
      $temp->dateRegistrationStart = $db->Record['dateRegistrationStart'];
      $temp->dateRegistrationEnd = $db->Record['dateRegistrationEnd'];
      $temp->dateAccountActivation = $db->Record['dateAccountActivation'];
      $temp->dateStudentActivation = $db->Record['dateStudentActivation'];
      $temp->semesterYear = $db->Record['semesterYear'];
   }
if ( !$temp ) { trigger_error("empty persistant object\n".$sql); }
return $temp;

}


function _getAllFromDB($key,$prop='',$where='', $orderBy='',$dsn='default') {
   $db = DB::getHandle($dsn);
   if ($orderBy) { $orderBy = " order by $orderBy"; }
   if ($where) { $where = " and $where"; }
   $db->query("select * from semesters where $prop='$key' $where $orderBy");
   while ($db->next_record()) {
      $temp = new semesterObj();
      $temp->_dsn = $dsn;
      $temp->__loaded = true; 
      $temp->id_semesters = $db->Record['id_semesters'];
      $temp->semesterId = $db->Record['semesterId'];
      $temp->semesterTerm = $db->Record['semesterTerm'];
      $temp->dateCensus = $db->Record['dateCensus'];
      $temp->dateFinalDrop = $db->Record['dateFinalDrop'];
      $temp->dateDeactivation = $db->Record['dateDeactivation'];
      $temp->dateStart = $db->Record['dateStart'];
      $temp->dateEnd = $db->Record['dateEnd'];
      $temp->dateRegistrationStart = $db->Record['dateRegistrationStart'];
      $temp->dateRegistrationEnd = $db->Record['dateRegistrationEnd'];
      $temp->dateAccountActivation = $db->Record['dateAccountActivation'];
      $temp->dateStudentActivation = $db->Record['dateStudentActivation'];
      $temp->semesterYear = $db->Record['semesterYear'];
      
      $temp->dateEndITVseminar = $db->Record['dateEndITVseminar'];
      $temp->dateStartITVseminar = $db->Record['dateStartITVseminar'];
      $temp->dateStartOrientation = $db->Record['dateStartOrientation'];
      $temp->dateEndOrientation = $db->Record['dateEndOrientation'];
      
      $temp->dateStartExam = $db->Record['dateStartExam'];
      $temp->dateEndExam = $db->Record['dateEndExam'];
      $temp->dateStartTextbook = $db->Record['dateStartTextbook'];
      $temp->dateEndTextbook = $db->Record['dateEndTextbook'];
      
      $objects[] = $temp;
}
return $objects;

}


function _loadArray($array, $pkeyFlag=false) {
 if ($pkeyFlag) { 
	$this->id_semesters = $array['id_semesters'];
 }
	$this->semesterId = $array['semesterId'];
	$this->semesterTerm = $array['semesterTerm'];
	$this->dateCensus = $array['dateCensus'];
	$this->dateFinalDrop = $array['dateFinalDrop'];
	$this->dateDeactivation = $array['dateDeactivation'];
	$this->dateStart = $array['dateStart'];
	$this->dateEnd = $array['dateEnd'];
	$this->dateRegistrationStart = $array['dateRegistrationStart'];
	$this->dateRegistrationEnd = $array['dateRegistrationEnd'];
	$this->dateAccountActivation = $array['dateAccountActivation'];
	$this->dateStudentActivation = $array['dateStudentActivation'];
	$this->semesterYear = $array['semesterYear'];
	
	$this->dateStartOrientation = $array['dateStartOrientation'];
    $this->dateEndOrientation = $array['dateEndOrientation'];
      
	$this->dateEndITVseminar = $array['dateEndITVseminar'];
	$this->dateStartITVseminar = $array['dateStartITVseminar'];
	
	$this->dateStartExam = $array['dateStartExam'];
	$this->dateEndExam = $array['dateEndExam'];
	$this->dateStartTextbook = $array['dateStartTextbook'];
	$this->dateEndTextbook = $array['dateEndTextbook'];

	
}

function _genPkey($len=50) {
return str_replace(".","",uniqid(str_replace(" ","",microtime()), $len));
}

function _saveToDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_semesters =='') {$this->id_semesters=$this->_genPkey(); }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "UPDATE semesters 
		SET
		dateStartTextbook='".addslashes($this->dateStartTextbook)."',
		dateEndTextbook='".addslashes($this->dateEndTextbook)."',
		dateStartExam='".addslashes($this->dateStartExam)."',
		dateEndExam='".addslashes($this->dateEndExam)."',
		dateStartOrientation='".addslashes($this->dateStartOrientation)."',
		dateEndOrientation='".addslashes($this->dateEndOrientation)."',
		dateEndITVseminar='".addslashes($this->dateEndITVseminar)."',
		dateStartITVseminar='".addslashes($this->dateStartITVseminar)."',
		id_semesters='".addslashes($this->id_semesters)."',
		semesterId='".addslashes($this->semesterId)."',
		semesterTerm='".addslashes($this->semesterTerm)."',
		dateCensus='".addslashes($this->dateCensus)."',
		dateFinalDrop='".addslashes($this->dateFinalDrop)."',
		dateDeactivation='".addslashes($this->dateDeactivation)."',
		dateStart='".addslashes($this->dateStart)."',
		dateEnd='".addslashes($this->dateEnd)."',
		dateRegistrationStart='".addslashes($this->dateRegistrationStart)."',
		dateRegistrationEnd='".addslashes($this->dateRegistrationEnd)."',
		dateAccountActivation='".addslashes($this->dateAccountActivation)."',
		dateStudentActivation='".addslashes($this->dateStudentActivation)."',
		semesterYear='".addslashes($this->semesterYear)."' 
		WHERE 
		id_semesters = '{$this->{$this->_pkey}}'";
$db->query($sql);
} else {
$sql = "insert into semesters   (
	dateStartTextbook,
	dateEndTextbook, 
	dateStartExam,
	dateEndExam,
	dateEndOrientation,dateStartOrientation,dateStartITVseminar,dateEndITVseminar,semesterId,semesterTerm,dateCensus,dateFinalDrop,dateDeactivation,dateStart,dateEnd,dateRegistrationStart,dateRegistrationEnd,dateAccountActivation,dateStudentActivation,semesterYear) 

	values 
	
	(
	'".addslashes($this->dateStartTextbook)."',
	'".addslashes($this->dateEndTextbook)."',
	'".addslashes($this->dateStartExam)."',
	'".addslashes($this->dateEndExam)."',
	'".addslashes($this->dateEndOrientation)."',
	'".addslashes($this->dateStartOrientation)."',
	'".addslashes($this->dateStartITVseminar)."',
	'".addslashes($this->dateEndITVseminar)."',
	'".addslashes($this->semesterId)."',
	'".addslashes($this->semesterTerm)."',
	'".addslashes($this->dateCensus)."',
	'".addslashes($this->dateFinalDrop)."',
	'".addslashes($this->dateDeactivation)."',
	'".addslashes($this->dateStart)."',
	'".addslashes($this->dateEnd)."',
	'".addslashes($this->dateRegistrationStart)."',
	'".addslashes($this->dateRegistrationEnd)."',
	'".addslashes($this->dateAccountActivation)."',
	'".addslashes($this->dateStudentActivation)."',
	'".addslashes($this->semesterYear)."')";
$db->query($sql);
}

}

function _deleteToDB() { return $this->_deleteFromDB(); } 

function _deleteFromDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_semesters =='') { trigger_error('deleteFromDB call with empty key'); return false; }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "delete from semesters  where id_semesters = '{$this->{$this->_pkey}}'";
$db->query($sql);

}

}
}

?>
