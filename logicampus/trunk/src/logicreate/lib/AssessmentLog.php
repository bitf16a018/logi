<?

class AssessmentLogBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idAssessmentLog;
	var $assessmentId;
	var $idStudent;
	var $startDate;
	var $endDate;
	var $idClasses;

	var $__attributes = array( 
	'idAssessmentLog'=>'integer',
	'assessmentId'=>'integer',
	'idStudent'=>'varchar',
	'startDate'=>'integer',
	'endDate'=>'integer',
	'idClasses'=>'integer');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->idAssessmentLog;
	}


	function setPrimaryKey($val) {
		$this->idAssessmentLog = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(AssessmentLogPeer::doInsert($this,$dsn));
		} else {
			AssessmentLogPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_assessment_log='".$key."'";
		}
		$array = AssessmentLogPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = AssessmentLogPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		AssessmentLogPeer::doDelete($this,$deep,$dsn);
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


class AssessmentLogPeerBase {

	var $tableName = 'assessment_log';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("assessment_log",$where);
		$st->fields['id_assessment_log'] = 'id_assessment_log';
		$st->fields['assessment_id'] = 'assessment_id';
		$st->fields['id_student'] = 'id_student';
		$st->fields['start_date'] = 'start_date';
		$st->fields['end_date'] = 'end_date';
		$st->fields['id_classes'] = 'id_classes';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = AssessmentLogPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("assessment_log");
		$st->fields['id_assessment_log'] = $this->idAssessmentLog;
		$st->fields['assessment_id'] = $this->assessmentId;
		$st->fields['id_student'] = $this->idStudent;
		$st->fields['start_date'] = $this->startDate;
		$st->fields['end_date'] = $this->endDate;
		$st->fields['id_classes'] = $this->idClasses;


		$st->key = 'id_assessment_log';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("assessment_log");
		$st->fields['id_assessment_log'] = $obj->idAssessmentLog;
		$st->fields['assessment_id'] = $obj->assessmentId;
		$st->fields['id_student'] = $obj->idStudent;
		$st->fields['start_date'] = $obj->startDate;
		$st->fields['end_date'] = $obj->endDate;
		$st->fields['id_classes'] = $obj->idClasses;


		$st->key = 'id_assessment_log';
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
		$st = new PBDO_DeleteStatement("assessment_log","id_assessment_log = '".$obj->getPrimaryKey()."'");

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
		$x = new AssessmentLog();
		$x->idAssessmentLog = $row['id_assessment_log'];
		$x->assessmentId = $row['assessment_id'];
		$x->idStudent = $row['id_student'];
		$x->startDate = $row['start_date'];
		$x->endDate = $row['end_date'];
		$x->idClasses = $row['id_classes'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class AssessmentLog extends AssessmentLogBase {

	# Total number of log entries the user has for the assessment
	var $logCount = '';

	function AssessmentLog() {

		$this->startDate = time();
		$this->endDate = time()+3600;

	}


	function loadAll($assessmentId, $username, $id_classes)
	{
		$logs = AssessmentLogPeer::doSelect("id_student='".$username."' AND assessment_id='$assessmentId' AND id_classes='$id_classes'");
		return $logs;
	}

	function updateTotalCount()
	{
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		 $sql = "select count(*) as count from assessment_log where id_student='".$this->idStudent."' AND assessment_id='".$this->assessmentId."' AND id_classes='".$this->idClasses."'";
		$db->queryOne($sql);
		$this->logCount = $db->record['count'];
	}

}



class AssessmentLogPeer extends AssessmentLogPeerBase {

}

?>
