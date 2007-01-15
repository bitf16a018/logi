<?

class HelpdeskIncidentBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $helpdeskId;
	var $timedateOpen;
	var $timedateClose;
	var $timedateReply;
	var $timedateUpdate;
	var $status;
	var $summary;
	var $userid;
	var $category;
	var $assignedTo;

	var $__attributes = array( 
	'helpdeskId'=>'integer',
	'timedateOpen'=>'integer',
	'timedateClose'=>'integer',
	'timedateReply'=>'integer',
	'timedateUpdate'=>'integer',
	'status'=>'integer',
	'summary'=>'longvarchar',
	'userid'=>'varchar',
	'category'=>'integer',
	'assignedTo'=>'varchar');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->helpdeskId;
	}


	function setPrimaryKey($val) {
		$this->helpdeskId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(HelpdeskIncidentPeer::doInsert($this,$dsn));
		} else {
			HelpdeskIncidentPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "helpdesk_id='".$key."'";
		}
		$array = HelpdeskIncidentPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = HelpdeskIncidentPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		HelpdeskIncidentPeer::doDelete($this,$deep,$dsn);
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


class HelpdeskIncidentPeerBase {

	var $tableName = 'helpdesk_incident';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("helpdesk_incident",$where);
		$st->fields['helpdesk_id'] = 'helpdesk_id';
		$st->fields['timedate_open'] = 'timedate_open';
		$st->fields['timedate_close'] = 'timedate_close';
		$st->fields['timedate_reply'] = 'timedate_reply';
		$st->fields['timedate_update'] = 'timedate_update';
		$st->fields['status'] = 'status';
		$st->fields['summary'] = 'summary';
		$st->fields['userid'] = 'userid';
		$st->fields['category'] = 'category';
		$st->fields['assigned_to'] = 'assigned_to';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = HelpdeskIncidentPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("helpdesk_incident");
		$st->fields['helpdesk_id'] = $this->helpdeskId;
		$st->fields['timedate_open'] = $this->timedateOpen;
		$st->fields['timedate_close'] = $this->timedateClose;
		$st->fields['timedate_reply'] = $this->timedateReply;
		$st->fields['timedate_update'] = $this->timedateUpdate;
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

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("helpdesk_incident");
		$st->fields['helpdesk_id'] = $obj->helpdeskId;
		$st->fields['timedate_open'] = $obj->timedateOpen;
		$st->fields['timedate_close'] = $obj->timedateClose;
		$st->fields['timedate_reply'] = $obj->timedateReply;
		$st->fields['timedate_update'] = $obj->timedateUpdate;
		$st->fields['status'] = $obj->status;
		$st->fields['summary'] = $obj->summary;
		$st->fields['userid'] = $obj->userid;
		$st->fields['category'] = $obj->category;
		$st->fields['assigned_to'] = $obj->assignedTo;


		$st->key = 'helpdesk_id';
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
		$st = new PBDO_DeleteStatement("helpdesk_incident","helpdesk_id = '".$obj->getPrimaryKey()."'");

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
		$x = new HelpdeskIncident();
		$x->helpdeskId = $row['helpdesk_id'];
		$x->timedateOpen = $row['timedate_open'];
		$x->timedateClose = $row['timedate_close'];
		$x->timedateReply = $row['timedate_reply'];
		$x->timedateUpdate = $row['timedate_update'];
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



}



class HelpdeskIncidentPeer extends HelpdeskIncidentPeerBase {

}

?>