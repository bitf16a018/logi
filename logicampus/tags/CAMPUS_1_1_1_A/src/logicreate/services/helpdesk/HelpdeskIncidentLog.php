<?

class HelpdeskIncidentLogBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $helpdeskIncidentLogId;
	var $helpdeskId;
	var $action;
	var $timedate;
	var $comment;
	var $userid;

	var $__attributes = array(
	'helpdeskIncidentLogId'=>'INTEGER',
	'helpdeskId'=>'HelpdeskIncident',
	'action'=>'varchar',
	'timedate'=>'integer',
	'comment'=>'text',
	'userid'=>'varchar');

	function getHelpdeskIncident() {
		if ( $this->helpdeskId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = HelpdeskIncidentPeer::doSelect('helpdesk_id = \''.$this->helpdeskId.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->helpdeskIncidentLogId;
	}

	function setPrimaryKey($val) {
		$this->helpdeskIncidentLogId = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(HelpdeskIncidentLogPeer::doInsert($this));
		} else {
			HelpdeskIncidentLogPeer::doUpdate($this);
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
			$where = "helpdesk_incident_log_id='".$key."'";
		}
		$array = HelpdeskIncidentLogPeer::doSelect($where);
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
		if ($array['action'])
			$this->action = $array['action'];
		if ($array['timedate'])
			$this->timedate = $array['timedate'];
		if ($array['comment'])
			$this->comment = $array['comment'];
		if ($array['userid'])
			$this->userid = $array['userid'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class HelpdeskIncidentLogPeer {

	var $tableName = 'helpdesk_incident_log';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("helpdesk_incident_log",$where);
		$st->fields['helpdesk_incident_log_id'] = 'helpdesk_incident_log_id';
		$st->fields['helpdesk_id'] = 'helpdesk_id';
		$st->fields['action'] = 'action';
		$st->fields['timedate'] = 'timedate';
		$st->fields['comment'] = 'comment';
		$st->fields['userid'] = 'userid';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = HelpdeskIncidentLogPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("helpdesk_incident_log");
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

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("helpdesk_incident_log");
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
		$st = new LC_DeleteStatement("helpdesk_incident_log","helpdesk_incident_log_id = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

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

?>