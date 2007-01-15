<?

class AssessmentBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $assessmentId;
	var $displayName;
	var $classId;
	var $dateAvailable;
	var $dateUnavailable;
	var $mailResponses;
	var $autoPublish;
	var $numRetries;
	var $minuteLimit;
	var $description;
	var $instructions;
	var $showResultType;
	var $possiblePoints;

	var $__attributes = array( 
	'assessmentId'=>'integer',
	'displayName'=>'varchar',
	'classId'=>'integer',
	'dateAvailable'=>'integer',
	'dateUnavailable'=>'integer',
	'mailResponses'=>'tinyint',
	'autoPublish'=>'tinyint',
	'numRetries'=>'tinyint',
	'minuteLimit'=>'integer',
	'description'=>'longvarchar',
	'instructions'=>'longvarchar',
	'showResultType'=>'tinyint',
	'possiblePoints'=>'float');

	var $__nulls = array( 
	'displayName'=>'displayName',
	'classId'=>'classId',
	'dateAvailable'=>'dateAvailable',
	'dateUnavailable'=>'dateUnavailable',
	'mailResponses'=>'mailResponses',
	'autoPublish'=>'autoPublish',
	'numRetries'=>'numRetries',
	'minuteLimit'=>'minuteLimit',
	'description'=>'description',
	'instructions'=>'instructions');



	function getPrimaryKey() {
		return $this->assessmentId;
	}


	function setPrimaryKey($val) {
		$this->assessmentId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(AssessmentPeer::doInsert($this,$dsn));
		} else {
			AssessmentPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "assessment_id='".$key."'";
		}
		$array = AssessmentPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = AssessmentPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		AssessmentPeer::doDelete($this,$deep,$dsn);
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


class AssessmentPeerBase {

	var $tableName = 'assessment';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("assessment",$where);
		$st->fields['assessment_id'] = 'assessment_id';
		$st->fields['display_name'] = 'display_name';
		$st->fields['class_id'] = 'class_id';
		$st->fields['date_available'] = 'date_available';
		$st->fields['date_unavailable'] = 'date_unavailable';
		$st->fields['mail_responses'] = 'mail_responses';
		$st->fields['auto_publish'] = 'auto_publish';
		$st->fields['num_retries'] = 'num_retries';
		$st->fields['minute_limit'] = 'minute_limit';
		$st->fields['description'] = 'description';
		$st->fields['instructions'] = 'instructions';
		$st->fields['show_result_type'] = 'show_result_type';
		$st->fields['possible_points'] = 'possible_points';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = AssessmentPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("assessment");
		$st->fields['assessment_id'] = $this->assessmentId;
		$st->fields['display_name'] = $this->displayName;
		$st->fields['class_id'] = $this->classId;
		$st->fields['date_available'] = $this->dateAvailable;
		$st->fields['date_unavailable'] = $this->dateUnavailable;
		$st->fields['mail_responses'] = $this->mailResponses;
		$st->fields['auto_publish'] = $this->autoPublish;
		$st->fields['num_retries'] = $this->numRetries;
		$st->fields['minute_limit'] = $this->minuteLimit;
		$st->fields['description'] = $this->description;
		$st->fields['instructions'] = $this->instructions;
		$st->fields['show_result_type'] = $this->showResultType;
		$st->fields['possible_points'] = $this->possiblePoints;

		$st->nulls['display_name'] = 'display_name';
		$st->nulls['class_id'] = 'class_id';
		$st->nulls['date_available'] = 'date_available';
		$st->nulls['date_unavailable'] = 'date_unavailable';
		$st->nulls['mail_responses'] = 'mail_responses';
		$st->nulls['auto_publish'] = 'auto_publish';
		$st->nulls['num_retries'] = 'num_retries';
		$st->nulls['minute_limit'] = 'minute_limit';
		$st->nulls['description'] = 'description';
		$st->nulls['instructions'] = 'instructions';

		$st->key = 'assessment_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("assessment");
		$st->fields['assessment_id'] = $obj->assessmentId;
		$st->fields['display_name'] = $obj->displayName;
		$st->fields['class_id'] = $obj->classId;
		$st->fields['date_available'] = $obj->dateAvailable;
		$st->fields['date_unavailable'] = $obj->dateUnavailable;
		$st->fields['mail_responses'] = $obj->mailResponses;
		$st->fields['auto_publish'] = $obj->autoPublish;
		$st->fields['num_retries'] = $obj->numRetries;
		$st->fields['minute_limit'] = $obj->minuteLimit;
		$st->fields['description'] = $obj->description;
		$st->fields['instructions'] = $obj->instructions;
		$st->fields['show_result_type'] = $obj->showResultType;
		$st->fields['possible_points'] = $obj->possiblePoints;

		$st->nulls['display_name'] = 'display_name';
		$st->nulls['class_id'] = 'class_id';
		$st->nulls['date_available'] = 'date_available';
		$st->nulls['date_unavailable'] = 'date_unavailable';
		$st->nulls['mail_responses'] = 'mail_responses';
		$st->nulls['auto_publish'] = 'auto_publish';
		$st->nulls['num_retries'] = 'num_retries';
		$st->nulls['minute_limit'] = 'minute_limit';
		$st->nulls['description'] = 'description';
		$st->nulls['instructions'] = 'instructions';

		$st->key = 'assessment_id';
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
		$st = new PBDO_DeleteStatement("assessment","assessment_id = '".$obj->getPrimaryKey()."'");

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
		$x = new Assessment();
		$x->assessmentId = $row['assessment_id'];
		$x->displayName = $row['display_name'];
		$x->classId = $row['class_id'];
		$x->dateAvailable = $row['date_available'];
		$x->dateUnavailable = $row['date_unavailable'];
		$x->mailResponses = $row['mail_responses'];
		$x->autoPublish = $row['auto_publish'];
		$x->numRetries = $row['num_retries'];
		$x->minuteLimit = $row['minute_limit'];
		$x->description = $row['description'];
		$x->instructions = $row['instructions'];
		$x->showResultType = $row['show_result_type'];
		$x->possiblePoints = $row['possible_points'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class Assessment extends AssessmentBase {



}



class AssessmentPeer extends AssessmentPeerBase {

}

?>