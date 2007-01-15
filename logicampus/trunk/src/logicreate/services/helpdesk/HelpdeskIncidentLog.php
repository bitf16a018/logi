<?

class HelpdeskIncidentLogBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $helpdeskIncidentLogId;
	var $helpdeskId;
	var $action;
	var $timedate;
	var $comment;
	var $userid;

	var $__attributes = array( 
	'helpdeskIncidentLogId'=>'integer',
	'helpdeskId'=>'integer',
	'action'=>'varchar',
	'timedate'=>'integer',
	'comment'=>'longvarchar',
	'userid'=>'varchar');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->helpdeskIncidentLogId;
	}


	function setPrimaryKey($val) {
		$this->helpdeskIncidentLogId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(HelpdeskIncidentLogPeer::doInsert($this,$dsn));
		} else {
			HelpdeskIncidentLogPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "helpdesk_incident_log_id='".$key."'";
		}
		$array = HelpdeskIncidentLogPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = HelpdeskIncidentLogPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		HelpdeskIncidentLogPeer::doDelete($this,$deep,$dsn);
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


class HelpdeskIncidentLogPeerBase {

	var $tableName = 'helpdesk_incident_log';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("helpdesk_incident_log",$where);
		$st->fields['helpdesk_incident_log_id'] = 'helpdesk_incident_log_id';
		$st->fields['helpdesk_id'] = 'helpdesk_id';
		$st->fields['action'] = 'action';
		$st->fields['timedate'] = 'timedate';
		$st->fields['comment'] = 'comment';
		$st->fields['userid'] = 'userid';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = HelpdeskIncidentLogPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("helpdesk_incident_log");
		$st->fields['helpdesk_incident_log_id'] = $this->helpdeskIncidentLogId;
		$st->fields['helpdesk_id'] = $this->helpdeskId;
		$st->fields['action'] = $this->action;
		$st->fields['timedate'] = $this->timedate;
		$st->fields['comment'] = $this->comment;
		$st->fields['userid'] = $this->userid;


		$st->key = 'helpdesk_incident_log_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("helpdesk_incident_log");
		$st->fields['helpdesk_incident_log_id'] = $obj->helpdeskIncidentLogId;
		$st->fields['helpdesk_id'] = $obj->helpdeskId;
		$st->fields['action'] = $obj->action;
		$st->fields['timedate'] = $obj->timedate;
		$st->fields['comment'] = $obj->comment;
		$st->fields['userid'] = $obj->userid;


		$st->key = 'helpdesk_incident_log_id';
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
		$st = new PBDO_DeleteStatement("helpdesk_incident_log","helpdesk_incident_log_id = '".$obj->getPrimaryKey()."'");

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
		$x = new HelpdeskIncidentLog();
		$x->helpdeskIncidentLogId = $row['helpdesk_incident_log_id'];
		$x->helpdeskId = $row['helpdesk_id'];
		$x->action = $row['action'];
		$x->timedate = $row['timedate'];
		$x->comment = $row['comment'];
		$x->userid = $row['userid'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class HelpdeskIncidentLog extends HelpdeskIncidentLogBase {



}



class HelpdeskIncidentLogPeer extends HelpdeskIncidentLogPeerBase {

}

?>