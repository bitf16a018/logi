<?

class AssessmentLogBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $idAssessmentLog;
	var $assessmentId;
	var $idStudent;
	var $startDate;
	var $endDate;
	var $idClasses;

	var $__attributes = array(
	'idAssessmentLog'=>'int',
	'assessmentId'=>'int',
	'idStudent'=>'varchar',
	'startDate'=>'int',
	'endDate'=>'int',
	'idClasses'=>'int');



	function getPrimaryKey() {
		return $this->idAssessmentLog;
	}

	function setPrimaryKey($val) {
		$this->idAssessmentLog = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(AssessmentLogPeer::doInsert($this));
		} else {
			AssessmentLogPeer::doUpdate($this);
		}
	}

	function load($key) {
		$this->_new = false;
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_assessment_log='".$key."'";
		}
		$array = AssessmentLogPeer::doSelect($where);
		return $array[0];
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

	function set($key,$val) {
		$this->_modified = true;
		$this->{$key} = $val;

	}

	/**
	 * set all properties of an object that aren't
	 * keys.  Relation attributes must be set manually
	 * by the programmer to ensure security
	 */
	function setArray($array) {
		if ($array['assessmentId'])
			$this->assessmentId = $array['assessmentId'];
		if ($array['idStudent'])
			$this->idStudent = $array['idStudent'];
		if ($array['startDate'])
			$this->startDate = $array['startDate'];
		if ($array['endDate'])
			$this->endDate = $array['endDate'];
		if ($array['idClasses'])
			$this->idClasses = $array['idClasses'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class AssessmentLogPeer {

	var $tableName = 'assessment_log';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("assessment_log",$where);
		$st->fields['id_assessment_log'] = 'id_assessment_log';
		$st->fields['assessment_id'] = 'assessment_id';
		$st->fields['id_student'] = 'id_student';
		$st->fields['start_date'] = 'start_date';
		$st->fields['end_date'] = 'end_date';
		$st->fields['id_classes'] = 'id_classes';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = AssessmentLogPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("assessment_log");
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

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("assessment_log");
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

	function doReplace($obj) {
		//use this tableName
		if ($this->isNew() ) {
			$db->executeQuery(new LC_InsertStatement($criteria));
		} else {
			$db->executeQuery(new LC_UpdateStatement($criteria));
		}
	}



	function doDelete(&$obj,$shallow=false) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_DeleteStatement("assessment_log","id_assessment_log = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

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
		$this->logCount = $db->Record['count'];
	}

}

?>
