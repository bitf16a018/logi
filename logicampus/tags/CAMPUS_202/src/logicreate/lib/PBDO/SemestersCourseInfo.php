<?

class SemestersCourseInfoBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idSemesters;
	var $campusClosings;
	var $lateGuidelines;
	var $noChildren;
	var $withdrawalPolicy;
	var $gradeVerify;
	var $examInfo;
	var $gradeChallenge;
	var $leaseKit;
	var $campusViewing;
	var $testingLocations;
	var $itvGrades;
	var $cable;
	var $textbooks;
	var $helpdesk;
	var $syllabusDisclaimer;
	var $specialInfo;
	var $testHours;
	var $accessClassSite;
	var $emailGuidelines;
	var $studentConduct;

	var $__attributes = array( 
	'idSemesters'=>'integer',
	'campusClosings'=>'longvarchar',
	'lateGuidelines'=>'longvarchar',
	'noChildren'=>'longvarchar',
	'withdrawalPolicy'=>'longvarchar',
	'gradeVerify'=>'longvarchar',
	'examInfo'=>'longvarchar',
	'gradeChallenge'=>'longvarchar',
	'leaseKit'=>'longvarchar',
	'campusViewing'=>'longvarchar',
	'testingLocations'=>'longvarchar',
	'itvGrades'=>'longvarchar',
	'cable'=>'longvarchar',
	'textbooks'=>'longvarchar',
	'helpdesk'=>'longvarchar',
	'syllabusDisclaimer'=>'longvarchar',
	'specialInfo'=>'longvarchar',
	'testHours'=>'longvarchar',
	'accessClassSite'=>'longvarchar',
	'emailGuidelines'=>'longvarchar',
	'studentConduct'=>'longvarchar');

	var $__nulls = array( 
	'campusClosings'=>'campusClosings',
	'lateGuidelines'=>'lateGuidelines',
	'noChildren'=>'noChildren',
	'withdrawalPolicy'=>'withdrawalPolicy',
	'gradeVerify'=>'gradeVerify',
	'examInfo'=>'examInfo',
	'gradeChallenge'=>'gradeChallenge',
	'leaseKit'=>'leaseKit',
	'campusViewing'=>'campusViewing',
	'testingLocations'=>'testingLocations',
	'itvGrades'=>'itvGrades',
	'cable'=>'cable',
	'textbooks'=>'textbooks',
	'helpdesk'=>'helpdesk',
	'syllabusDisclaimer'=>'syllabusDisclaimer',
	'specialInfo'=>'specialInfo',
	'testHours'=>'testHours',
	'accessClassSite'=>'accessClassSite',
	'emailGuidelines'=>'emailGuidelines',
	'studentConduct'=>'studentConduct');



	function getPrimaryKey() {
		return $this->idSemesters;
	}


	function setPrimaryKey($val) {
		$this->idSemesters = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(SemestersCourseInfoPeer::doInsert($this,$dsn));
		} else {
			SemestersCourseInfoPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_semesters='".$key."'";
		}
		$array = SemestersCourseInfoPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = SemestersCourseInfoPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		SemestersCourseInfoPeer::doDelete($this,$deep,$dsn);
	}


	function isNew() {
		return $this->_new;
	}


	function isModified() {
		return $this->_modified;

	}


	function get($key) {
		return $this->{$key};
	}


	/**
	 * only sets if the new value is !== the current value
	 * returns true if the value was updated
	 * also, sets _modified to true on success
	 */
	function set($key,$val) {
		if ($this->{$key} !== $val) {
			$this->_modified = true;
			$this->{$key} = $val;
			return true;
		}
		return false;
	}

}


class SemestersCourseInfoPeerBase {

	var $tableName = 'semesters_course_info';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("semesters_course_info",$where);
		$st->fields['id_semesters'] = 'id_semesters';
		$st->fields['campusClosings'] = 'campusClosings';
		$st->fields['lateGuidelines'] = 'lateGuidelines';
		$st->fields['noChildren'] = 'noChildren';
		$st->fields['withdrawalPolicy'] = 'withdrawalPolicy';
		$st->fields['gradeVerify'] = 'gradeVerify';
		$st->fields['examInfo'] = 'examInfo';
		$st->fields['gradeChallenge'] = 'gradeChallenge';
		$st->fields['leaseKit'] = 'leaseKit';
		$st->fields['campusViewing'] = 'campusViewing';
		$st->fields['testingLocations'] = 'testingLocations';
		$st->fields['itvGrades'] = 'itvGrades';
		$st->fields['cable'] = 'cable';
		$st->fields['textbooks'] = 'textbooks';
		$st->fields['helpdesk'] = 'helpdesk';
		$st->fields['syllabusDisclaimer'] = 'syllabusDisclaimer';
		$st->fields['specialInfo'] = 'specialInfo';
		$st->fields['testHours'] = 'testHours';
		$st->fields['accessClassSite'] = 'accessClassSite';
		$st->fields['emailGuidelines'] = 'emailGuidelines';
		$st->fields['studentConduct'] = 'studentConduct';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = SemestersCourseInfoPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("semesters_course_info");
		$st->fields['id_semesters'] = $this->idSemesters;
		$st->fields['campusClosings'] = $this->campusClosings;
		$st->fields['lateGuidelines'] = $this->lateGuidelines;
		$st->fields['noChildren'] = $this->noChildren;
		$st->fields['withdrawalPolicy'] = $this->withdrawalPolicy;
		$st->fields['gradeVerify'] = $this->gradeVerify;
		$st->fields['examInfo'] = $this->examInfo;
		$st->fields['gradeChallenge'] = $this->gradeChallenge;
		$st->fields['leaseKit'] = $this->leaseKit;
		$st->fields['campusViewing'] = $this->campusViewing;
		$st->fields['testingLocations'] = $this->testingLocations;
		$st->fields['itvGrades'] = $this->itvGrades;
		$st->fields['cable'] = $this->cable;
		$st->fields['textbooks'] = $this->textbooks;
		$st->fields['helpdesk'] = $this->helpdesk;
		$st->fields['syllabusDisclaimer'] = $this->syllabusDisclaimer;
		$st->fields['specialInfo'] = $this->specialInfo;
		$st->fields['testHours'] = $this->testHours;
		$st->fields['accessClassSite'] = $this->accessClassSite;
		$st->fields['emailGuidelines'] = $this->emailGuidelines;
		$st->fields['studentConduct'] = $this->studentConduct;

		$st->nulls['campusClosings'] = 'campusClosings';
		$st->nulls['lateGuidelines'] = 'lateGuidelines';
		$st->nulls['noChildren'] = 'noChildren';
		$st->nulls['withdrawalPolicy'] = 'withdrawalPolicy';
		$st->nulls['gradeVerify'] = 'gradeVerify';
		$st->nulls['examInfo'] = 'examInfo';
		$st->nulls['gradeChallenge'] = 'gradeChallenge';
		$st->nulls['leaseKit'] = 'leaseKit';
		$st->nulls['campusViewing'] = 'campusViewing';
		$st->nulls['testingLocations'] = 'testingLocations';
		$st->nulls['itvGrades'] = 'itvGrades';
		$st->nulls['cable'] = 'cable';
		$st->nulls['textbooks'] = 'textbooks';
		$st->nulls['helpdesk'] = 'helpdesk';
		$st->nulls['syllabusDisclaimer'] = 'syllabusDisclaimer';
		$st->nulls['specialInfo'] = 'specialInfo';
		$st->nulls['testHours'] = 'testHours';
		$st->nulls['accessClassSite'] = 'accessClassSite';
		$st->nulls['emailGuidelines'] = 'emailGuidelines';
		$st->nulls['studentConduct'] = 'studentConduct';

		$st->key = 'id_semesters';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("semesters_course_info");
		$st->fields['id_semesters'] = $obj->idSemesters;
		$st->fields['campusClosings'] = $obj->campusClosings;
		$st->fields['lateGuidelines'] = $obj->lateGuidelines;
		$st->fields['noChildren'] = $obj->noChildren;
		$st->fields['withdrawalPolicy'] = $obj->withdrawalPolicy;
		$st->fields['gradeVerify'] = $obj->gradeVerify;
		$st->fields['examInfo'] = $obj->examInfo;
		$st->fields['gradeChallenge'] = $obj->gradeChallenge;
		$st->fields['leaseKit'] = $obj->leaseKit;
		$st->fields['campusViewing'] = $obj->campusViewing;
		$st->fields['testingLocations'] = $obj->testingLocations;
		$st->fields['itvGrades'] = $obj->itvGrades;
		$st->fields['cable'] = $obj->cable;
		$st->fields['textbooks'] = $obj->textbooks;
		$st->fields['helpdesk'] = $obj->helpdesk;
		$st->fields['syllabusDisclaimer'] = $obj->syllabusDisclaimer;
		$st->fields['specialInfo'] = $obj->specialInfo;
		$st->fields['testHours'] = $obj->testHours;
		$st->fields['accessClassSite'] = $obj->accessClassSite;
		$st->fields['emailGuidelines'] = $obj->emailGuidelines;
		$st->fields['studentConduct'] = $obj->studentConduct;

		$st->nulls['campusClosings'] = 'campusClosings';
		$st->nulls['lateGuidelines'] = 'lateGuidelines';
		$st->nulls['noChildren'] = 'noChildren';
		$st->nulls['withdrawalPolicy'] = 'withdrawalPolicy';
		$st->nulls['gradeVerify'] = 'gradeVerify';
		$st->nulls['examInfo'] = 'examInfo';
		$st->nulls['gradeChallenge'] = 'gradeChallenge';
		$st->nulls['leaseKit'] = 'leaseKit';
		$st->nulls['campusViewing'] = 'campusViewing';
		$st->nulls['testingLocations'] = 'testingLocations';
		$st->nulls['itvGrades'] = 'itvGrades';
		$st->nulls['cable'] = 'cable';
		$st->nulls['textbooks'] = 'textbooks';
		$st->nulls['helpdesk'] = 'helpdesk';
		$st->nulls['syllabusDisclaimer'] = 'syllabusDisclaimer';
		$st->nulls['specialInfo'] = 'specialInfo';
		$st->nulls['testHours'] = 'testHours';
		$st->nulls['accessClassSite'] = 'accessClassSite';
		$st->nulls['emailGuidelines'] = 'emailGuidelines';
		$st->nulls['studentConduct'] = 'studentConduct';

		$st->key = 'id_semesters';
		$db->executeQuery($st);
		$obj->_modified = false;

	}

	function doReplace($obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		if ($this->isNew() ) {
			$db->executeQuery(new PBDO_InsertStatement($criteria));
		} else {
			$db->executeQuery(new PBDO_UpdateStatement($criteria));
		}
	}


	/**
	 * remove an object
	 */
	function doDelete(&$obj,$deep=false,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_DeleteStatement("semesters_course_info","id_semesters = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( $deep ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}



	/**
	 * send a raw query
	 */
	function doQuery(&$sql,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);

		$db->query($sql);

	  	return;
	}



	function row2Obj($row) {
		$x = new SemestersCourseInfo();
		$x->idSemesters = $row['id_semesters'];
		$x->campusClosings = $row['campusClosings'];
		$x->lateGuidelines = $row['lateGuidelines'];
		$x->noChildren = $row['noChildren'];
		$x->withdrawalPolicy = $row['withdrawalPolicy'];
		$x->gradeVerify = $row['gradeVerify'];
		$x->examInfo = $row['examInfo'];
		$x->gradeChallenge = $row['gradeChallenge'];
		$x->leaseKit = $row['leaseKit'];
		$x->campusViewing = $row['campusViewing'];
		$x->testingLocations = $row['testingLocations'];
		$x->itvGrades = $row['itvGrades'];
		$x->cable = $row['cable'];
		$x->textbooks = $row['textbooks'];
		$x->helpdesk = $row['helpdesk'];
		$x->syllabusDisclaimer = $row['syllabusDisclaimer'];
		$x->specialInfo = $row['specialInfo'];
		$x->testHours = $row['testHours'];
		$x->accessClassSite = $row['accessClassSite'];
		$x->emailGuidelines = $row['emailGuidelines'];
		$x->studentConduct = $row['studentConduct'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class SemestersCourseInfo extends SemestersCourseInfoBase {



}



class SemestersCourseInfoPeer extends SemestersCourseInfoPeerBase {

}

?>