<?
// mgk 10/30/03 - added another column to the DB - HAVE NOT ADDED IT HERE
// noexam is a 1/0 flag indicating if no exams are required for a class.
/* NOTE: This file has been modified from the original wireframe-generated object
 *       to include the courseName from the courses table.
 */
// primarily mapped against database table 
include_once(LIB_PATH.'lc_class.php');

class classObj {
	var $id_classes;		// (number) - 
	var $id_courses;		// (number) - 
	var $id_semesters;		// (number) - 
	var $sectionNumbers;		// (number) - 
	var $classType;		// (number) - 
	var $stylesheet;
	var $id_class_resource; // used to display a peice of content in the classroom
	var $facultyId;		// (number) - 
	var $courseFamily;		// (number) - 
	var $courseNumber;		// (number) - 
	var $courseFamilyNumber;		// (number) - 
	var $courseName;	// ADDED (text)
	var $_dsn = 'default';
	var $_pkey = 'id_classes';

function _getFromDB($pkey,$prop='',$where='', $orderBy='', $dsn='default') {
	if ($orderBy) { $orderBy = ' order by $orderBy '; }
	if ($where) { $where = ' and $where'; }
	$db = DB::getHandle($dsn);

	if ($prop=='') { $prop=$this->_pkey; }
	//$db->query("select id_classes,id_courses,id_semesters,stylesheet,sectionNumbers,classType,facultyId,courseFamily,courseNumber,courseFamilyNumber,id_class_resource from classes where $prop='$pkey' $where $orderBy");
	@$db->query("select l.id_classes,l.id_courses,l.id_semesters,l.stylesheet,l.id_class_resource,l.sectionNumbers,l.classType,l.facultyId,l.courseFamily,l.courseNumber,l.courseFamilyNumber,o.courseName from classes as l,courses as o where $prop='$pkey' and l.id_courses=o.id_courses");
	@$db->next_record();
		$temp = new classObj();
		$temp->_dsn = $dsn;
		$temp->__loaded = true; 
		$temp->stylesheet = $db->Record['stylesheet'];
		$temp->id_class_resource = $db->Record['id_class_resource'];
		$temp->id_classes = $db->Record['id_classes'];
		$temp->id_courses = $db->Record['id_courses'];
		$temp->id_semesters = $db->Record['id_semesters'];
		$temp->sectionNumbers = $db->Record['sectionNumbers'];
		$temp->classType = $db->Record['classType'];
		$temp->facultyId = $db->Record['facultyId'];
		$temp->courseFamily = $db->Record['courseFamily'];
		$temp->courseNumber = $db->Record['courseNumber'];
		$temp->courseFamilyNumber = $db->Record['courseFamilyNumber'];
		$temp->courseName = $db->Record['courseName']; // added
	return $temp;
}


function _getAllFromDB($pkey, $prop='',$where='', $orderBy='',$dsn='default') {
	$db = DB::getHandle($dsn);
	if ($orderBy) { $orderBy = ' order by $orderBy '; }
	if ($where) { $where = ' and $where'; }
	if ($prop=='') { $prop=$this->_pkey; }
	//$db->query("select id_classes,id_courses,id_semesters,sectionNumbers,classType,facultyId,courseFamily,courseNumber,courseFamilyNumber from classes $where $orderBy");


	$db->query("select l.id_classes,l.id_courses,l.stylesheet,l.id_class_resource,l.id_semesters,l.sectionNumbers,l.classType,l.facultyId,l.courseFamily,l.courseNumber,l.courseFamilyNumber,o.courseName from classes as l,courses as o where $prop='$pkey' and l.id_courses=o.id_courses");

//	$db->query("select l.id_classes,l.id_courses,l.id_semesters,l.sectionNumbers,l.classType,l.facultyId,l.courseFamily,l.courseNumber,l.courseFamilyNumber,courses.courseName from classes as l,courses $where $orderby"); //added
	while ($db->next_record()) {
	$temp = new classObj();
	$temp->_dsn = $dsn;
	$temp->__loaded = true; 
	$temp->stylesheet = $db->Record['stylesheet'];
	$temp->id_class_resource = $db->Record['id_class_resource'];
	$temp->id_classes = $db->Record['id_classes'];
	$temp->id_courses = $db->Record['id_courses'];
	$temp->id_semesters = $db->Record['id_semesters'];
	$temp->sectionNumbers = $db->Record['sectionNumbers'];
	$temp->classType = $db->Record['classType'];
	$temp->facultyId = $db->Record['facultyId'];
	$temp->courseFamily = $db->Record['courseFamily'];
	$temp->courseNumber = $db->Record['courseNumber'];
	$temp->courseFamilyNumber = $db->Record['courseFamilyNumber'];
	$temp->courseName = $db->Record['courseName']; //added
	$objects[] = $temp;
	}
 return $objects;

}

function _loadArray($array, $pkeyFlag=false) {
 if ($pkeyFlag) { 
	$this->id_classes = $array['id_classes'];
 }
	$this->stylesheet = $array['stylesheet'];
	$this->id_class_resource = $array['id_class_resource'];
	$this->id_courses = $array['id_courses'];
	$this->id_semesters = $array['id_semesters'];
	$this->sectionNumbers = $array['sectionNumbers'];
	$this->classType = $array['classType'];
	$this->facultyId = $array['facultyId'];
	$this->courseFamily = $array['courseFamily'];
	$this->courseNumber = $array['courseNumber'];
	$this->courseFamilyNumber = $array['courseFamilyNumber'];
}

function _genPkey($len=50) {
return str_replace(".","",uniqid(str_replace(" ","",microtime()), $len));
}

function _saveToDB() {
$db = DB::GetHandle($this->_dsn);
if ($this->id_classes =='') {$this->id_classes=$this->_genPkey(); }
if ($this->__loaded) { // was the object loaded from DB already?
$sql = "update classes set 
stylesheet='".addslashes($this->stylesheet)."', 
id_class_resource='".addslashes($this->id_class_resource)."',
id_classes='".addslashes($this->id_classes)."',
id_courses='".addslashes($this->id_courses)."',
id_semesters='".addslashes($this->id_semesters)."',
sectionNumbers='".addslashes($this->sectionNumbers)."',
classType='".addslashes($this->classType)."',
facultyId='".addslashes($this->facultyId)."',
courseFamily='".addslashes($this->courseFamily)."',
courseNumber='".addslashes($this->courseNumber)."',
courseFamilyNumber='".addslashes($this->courseFamilyNumber)."' where 
id_classes = '{$this->{$this->_pkey}}'";
$db->query($sql);
} else {
$sql = "insert into classes  (stylesheet, id_class_resource, id_courses,id_semesters,sectionNumbers,classType,facultyId,courseFamily,courseNumber,courseFamilyNumber) values (
	'".addslashes($this->stylesheet)."', 
	'".addslashes($this->id_class_resource)."', 
	'".addslashes($this->id_courses)."',
	'".addslashes($this->id_semesters)."',
	'".addslashes($this->sectionNumbers)."',
	'".addslashes($this->classType)."',
	'".addslashes($this->facultyId)."',
	'".addslashes($this->courseFamily)."',
	'".addslashes($this->courseNumber)."',
	'".addslashes($this->courseFamilyNumber)."')";
$db->query($sql);
}

}

function _deleteToDB() { return $this->_deleteFromDB(); } 

	function _deleteFromDB() {
		$db = DB::GetHandle($this->_dsn);
		if ($this->id_classes =='') { trigger_error('deleteFromDB call with empty key'); return false; }
		if ($this->__loaded) { // was the object loaded from DB already?
		$sql = "delete from classes  where id_classes = '{$this->{$this->_pkey}}'";
		$db->query($sql);

	}

}


	/**
	 * get all classes someone is taking
	 */
	function getClassesTaken($uname) {
		$ret = array();
		$db = DB::getHandle();
$sql = "SELECT classes.*, semesters.semesterID,courses.courseName, 
profile_faculty.title, profile.firstname, profile.lastname
/**
CONCAT(IF(ISNULL(profile_faculty.title), '', profile_faculty.title), ' ', profile.firstname, ' ', profile.lastname) as facultyName

Removed this, if profile_faculty.title was null CONCAT just nulls it all out.. the one above checks for null
CONCAT(profile_faculty.title, ' ', profile.firstname, ' ', profile.lastname) as facultyName
**/
FROM class_student_sections as css
LEFT JOIN class_sections ON css.sectionNumber = class_sections.sectionNumber
LEFT JOIN classes ON class_sections.id_classes = classes.id_classes
LEFT JOIN courses ON classes.id_courses = courses.id_courses
LEFT JOIN semesters ON classes.id_semesters = semesters.id_semesters
LEFT JOIN profile on classes.facultyId=profile.username
LEFT JOIN profile_faculty on profile_faculty.username=profile.username

WHERE css.id_student = '$uname'
AND css.active = 1
AND semesters.dateStudentActivation < ".DB::getFuncName('NOW()')."
AND semesters.dateDeactivation > ".DB::getFuncName('NOW()')."
";		

		$db->query($sql);
		$db->RESULT_TYPE=MYSQL_ASSOC;
#		ob_start();
		while ($db->next_record() ) {
			$db->Record['facultyName'] = $db->Record['profile_faculty.title'] . $db->Record['profile.firstname'] . $db->Record['profile.lastname'];
			$temp = PersistantObject::createFromArray('classObj',$db->Record);
			$temp->_dsn = $dsn;
			$temp->__loaded = true; 
			$ret[] = $temp;
#			debug($temp);
		}
#		$x = ob_get_contents();
#		ob_end_clean();
#		mail("michael@tapinternet.com","Classes for $uname",$x,"From: ".WEBMASTER_EMAIL);
	return $ret;
	}

	/**
	 * get all classes someone is taking, regardless of active/not
	 * or semester dates
	 */
	function getAllClassesTaken($uname, $semesterId) {
		$ret = array();
		$db = DB::getHandle();
		$sql = "SELECT
			classes.*, class_sections.*, semesters.semesterID,courses.courseName, 
			profile_faculty.title, profile.firstname, profile.lastname
                        FROM class_enrollment as css
                        LEFT JOIN classes ON css.class_id = classes.id_classes
                        LEFT JOIN class_sections ON css.section_number = class_sections.sectionNumber
                        LEFT JOIN courses ON classes.id_courses = courses.id_courses
			LEFT JOIN semesters ON classes.id_semesters = semesters.id_semesters
			LEFT JOIN profile on classes.facultyId=profile.username
			LEFT JOIN profile_faculty on profile_faculty.username=profile.username
			LEFT JOIN lcUsers on css.student_id=lcUsers.pkey

                        WHERE lcUsers.username = '$uname'
			and (css.semester_id = $semesterId OR css.semester_id = 0)
			and classes.id_semesters = $semesterId
		";		
		$db->query($sql);
		$db->RESULT_TYPE=MYSQL_ASSOC;
		while ($db->next_record() ) {
			$db->Record['facultyName'] = $db->Record['profile_faculty.title'] . $db->Record['profile.firstname'] . $db->Record['profile.lastname'];
			$temp = PersistantObject::createFromArray('classObj',$db->Record);
			$temp->_dsn = $dsn;
			$temp->__loaded = true; 
			$ret[] = $temp;
		}
	return $ret;
	}

/**
	 * get all classes someone is taking, regardless of active/not
	 * or semester dates: Geleli added to accomodate gradebookall
	 */
	function getOverAllClassesTaken($uname) {
		$ret = array();
		$db = DB::getHandle();
$sql = "SELECT classes.*, semesters.semesterID,courses.courseName, 
profile_faculty.title, profile.firstname, profile.lastname

/**
CONCAT(IF(ISNULL(profile_faculto.tstle), '', profile_faculty.title), ' ', profile.firstme, profile.lastnameuname, ' ', profile.lastname) as facultyName

Removed this, if profile_faculty.title was null CONCAT just nulls it all out.. the one above checks for null
CONCAT(profile_faculty.title, ' ', profile.firstname, ' ', profile.lastname) as facultyName
**/

FROM class_student_sections as css
LEFT JOIN class_sections ON css.sectionNumber = class_sections.sectionNumber
LEFT JOIN classes ON class_sections.id_classes = classes.id_classes
LEFT JOIN courses ON classes.id_courses = courses.id_courses
LEFT JOIN semesters ON classes.id_semesters = semesters.id_semesters
LEFT JOIN profile on classes.facultyId=profile.username
LEFT JOIN profile_faculty on profile_faculty.username=profile.username

WHERE css.id_student = '$uname'
";		

		$db->query($sql);
		$db->RESULT_TYPE=MYSQL_ASSOC;
#		ob_start();
		while ($db->next_record() ) {
			$temp = PersistantObject::createFromArray('classObj',$db->Record);
			$temp->_dsn = $dsn;
			$temp->__loaded = true; 
			$ret[] = $temp;
#			debug($temp);
		}
#		$x = ob_get_contents();
#		ob_end_clean();
#		mail("michael@tapinternet.com","Classes for $uname",$x,"From: ".WEBMASTER_EMAIL);
	return $ret;
	}
	/**
	 * get all classes someone is teaching
	 */
	function getClassesTaught($uname) {

		$ret = array();
		$db = DB::getHandle();

/**, CONCAT(IF(ISNULL(profile_faculty.title), '', profile_faculty.title), ' ', profile.firstname, ' ', profile.lastname) as facultyName
**/
/**
Removed this, if profile_faculty.title was null CONCAT just nulls it all out.. the one above checks for null
CONCAT(profile_faculty.title, ' ', profile.firstname, ' ', profile.lastname) as facultyName
**/
		$ret = LC_Class::getActiveClassesForFaculty($uname);

		// extra faculty
		
		$sql = "SELECT
                        ce.*,cs.*, semesters.semesterID, courses.courseName, profile_faculty.title, profile.firstname, profile.lastname
			FROM classes AS cs
                        LEFT JOIN courses ON cs.id_courses = courses.id_courses
                        LEFT JOIN semesters ON cs.id_semesters = semesters.id_semesters
			LEFT JOIN profile on cs.facultyId=profile.username
			,
			class_extra_faculty AS ce 
			,
			profile AS pr
			LEFT JOIN profile_faculty on profile_faculty.username=pr.username


                        WHERE ce.facultyId = '$uname'
			and ce.id_classes = cs.id_classes 
						and semesters.dateAccountActivation < ".DB::getFuncName('NOW()')."
						and semesters.dateDeactivation > ".DB::getFuncName('NOW()')."
		";
		$db->query($sql);
		$db->RESULT_TYPE=MYSQL_ASSOC;
		while ($db->next_record() ) {
			$db->Record['facultyName'] = $db->Record['profile_faculty.title'] . $db->Record['profile.firstname'] . $db->Record['profile.lastname'];
			$temp = PersistantObject::createFromArray('classObj',$db->Record);
			$temp->_dsn = $dsn;
			$temp->__loaded = true; 
			$ret[] = $temp;
		}

	return $ret;
	}

}

?>
