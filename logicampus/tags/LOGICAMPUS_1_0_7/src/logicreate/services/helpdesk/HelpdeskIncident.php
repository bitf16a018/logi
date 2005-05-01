<?

class HelpdeskIncidentBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $helpdeskId;
	var $timedateOpen;
	var $timedateClose;
	var $status;
	var $summary;
	var $userid;
	var $category;
	var $assignedTo;

	var $__attributes = array(
	'helpdeskId'=>'integer',
	'timedateOpen'=>'integer',
	'timedateClose'=>'integer',
	'status'=>'integer',
	'summary'=>'text',
	'userid'=>'varchar',
	'category'=>'integer',
	'assignedTo'=>'varchar');

	function getHelpdeskIncidentLogs() {
		$array = HelpdeskIncidentLogPeer::doSelect('helpdesk_id = \''.$this->getPrimaryKey().'\'');
		return $array;
	}



	function getPrimaryKey() {
		return $this->helpdeskId;
	}

	function setPrimaryKey($val) {
		$this->helpdeskId = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(HelpdeskIncidentPeer::doInsert($this));
		} else {
			HelpdeskIncidentPeer::doUpdate($this);
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
			$where = "helpdesk_id='".$key."'";
		}
		$array = HelpdeskIncidentPeer::doSelect($where);
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
		if ($array['timedateOpen'])
			$this->timedateOpen = $array['timedateOpen'];
		if ($array['timedateClose'])
			$this->timedateClose = $array['timedateClose'];
		if ($array['status'])
			$this->status = $array['status'];
		if ($array['summary'])
			$this->summary = $array['summary'];
		if ($array['userid'])
			$this->userid = $array['userid'];
		if ($array['category'])
			$this->category = $array['category'];
		if ($array['assignedTo'])
			$this->assignedTo = $array['assignedTo'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class HelpdeskIncidentPeer {

	var $tableName = 'helpdesk_incident';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("helpdesk_incident",$where);
		$st->fields['helpdesk_id'] = 'helpdesk_id';
		$st->fields['timedate_open'] = 'timedate_open';
		$st->fields['timedate_close'] = 'timedate_close';
		$st->fields['status'] = 'status';
		$st->fields['summary'] = 'summary';
		$st->fields['userid'] = 'userid';
		$st->fields['category'] = 'category';
		$st->fields['assigned_to'] = 'assigned_to';
#		$st->fields[''] = '';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = HelpdeskIncidentPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("helpdesk_incident");
		$st->fields['helpdesk_id'] = $this->helpdeskId;
		$st->fields['timedate_open'] = $this->timedateOpen;
		$st->fields['timedate_close'] = $this->timedateClose;
		$st->fields['status'] = $this->status;
		$st->fields['summary'] = $this->summary;
		$st->fields['userid'] = $this->userid;
		$st->fields['category'] = $this->category;
		$st->fields['assigned_to'] = $this->assignedTo;

		$st->key = 'helpdesk_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("helpdesk_incident");
		$st->fields['helpdesk_id'] = $obj->helpdeskId;
		$st->fields['timedate_open'] = $obj->timedateOpen;
		$st->fields['timedate_close'] = $obj->timedateClose;
		$st->fields['status'] = $obj->status;
		$st->fields['summary'] = $obj->summary;
		$st->fields['userid'] = $obj->userid;
		$st->fields['category'] = $obj->category;
		$st->fields['assigned_to'] = $obj->assignedTo;

		$st->key = 'helpdesk_id';
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
		$st = new LC_DeleteStatement("helpdesk_incident","helpdesk_id = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

			$st = new LC_DeleteStatement("helpdesk_incident_log","helpdesk_id = '".$obj->getPrimaryKey()."'");
			$db->executeQuery($st);
		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new HelpdeskIncident();
		$x->helpdeskId = $row['helpdesk_id'];
		$x->timedateOpen = $row['timedate_open'];
		$x->timedateClose = $row['timedate_close'];
		$x->status = $row['status'];
		$x->summary = $row['summary'];
		$x->userid = $row['userid'];
		$x->category = $row['category'];
		$x->assignedTo = $row['assigned_to'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class HelpdeskIncident extends HelpdeskIncidentBase {


	function loadHistoryForUsername($name) {
		$name = (string)trim($name);


		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("helpdesk_incident","userid = '$name'");
		$st->fields['helpdesk_id'] = 'helpdesk_id';
		$st->fields['timedate_open'] = 'timedate_open';
		$st->fields['timedate_close'] = 'timedate_close';
		$st->fields['status'] = 'status';
		$st->fields['summary'] = 'summary';
		$st->fields['userid'] = 'userid';
		$st->fields['category'] = 'category';
		$st->fields['assigned_to'] = 'assigned_to';
		$st->fields['helpdesk_status.helpdesk_status_label'] = 'helpdesk_status.helpdesk_status_label';
		$st->join = 'left join helpdesk_status on helpdesk_status.helpdesk_status_id = helpdesk_incident.status ';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$x = HelpdeskIncidentPeer::row2Obj($db->record);
			$x->helpdeskStatusLabel = $db->record['helpdesk_status_label'];
			$array[] = $x;
		}
		return $array;
	}

}

?>
