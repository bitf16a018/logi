<?

class AssessmentActivityLogBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $assessmentActivityLogId;

	var $__attributes = array(
	'assessmentActivityLogId'=>'int');



	function getPrimaryKey() {
		return $this->assessmentActivityLogId;
	}

	function setPrimaryKey($val) {
		$this->assessmentActivityLogId = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(AssessmentActivityLogPeer::doInsert($this));
		} else {
			AssessmentActivityLogPeer::doUpdate($this);
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
			$where = "assessment_activity_log_id='".$key."'";
		}
		$array = AssessmentActivityLogPeer::doSelect($where);
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

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class AssessmentActivityLogPeer {

	var $tableName = 'assessment_activity_log';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("assessment_activity_log",$where);
		$st->fields['assessment_activity_log_id'] = 'assessment_activity_log_id';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = AssessmentActivityLogPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("assessment_activity_log");
		$st->fields['assessment_activity_log_id'] = $this->assessmentActivityLogId;

		$st->key = 'assessment_activity_log_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("assessment_activity_log");
		$st->fields['assessment_activity_log_id'] = $obj->assessmentActivityLogId;

		$st->key = 'assessment_activity_log_id';
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
		$st = new LC_DeleteStatement("assessment_activity_log","assessment_activity_log_id = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new AssessmentActivityLog();
		$x->assessmentActivityLogId = $row['assessment_activity_log_id'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class AssessmentActivityLog extends AssessmentActivityLogBase {



}

?>