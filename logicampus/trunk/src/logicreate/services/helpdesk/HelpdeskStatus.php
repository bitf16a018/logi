<?

class HelpdeskStatusBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $helpdeskStatusId;
	var $helpdeskStatusLabel;
	var $helpdeskStatusSort;

	var $__attributes = array( 
	'helpdeskStatusId'=>'integer',
	'helpdeskStatusLabel'=>'varchar',
	'helpdeskStatusSort'=>'integer');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->helpdeskStatusId;
	}


	function setPrimaryKey($val) {
		$this->helpdeskStatusId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(HelpdeskStatusPeer::doInsert($this,$dsn));
		} else {
			HelpdeskStatusPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "helpdesk_status_id='".$key."'";
		}
		$array = HelpdeskStatusPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = HelpdeskStatusPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		HelpdeskStatusPeer::doDelete($this,$deep,$dsn);
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


class HelpdeskStatusPeerBase {

	var $tableName = 'helpdesk_status';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("helpdesk_status",$where);
		$st->fields['helpdesk_status_id'] = 'helpdesk_status_id';
		$st->fields['helpdesk_status_label'] = 'helpdesk_status_label';
		$st->fields['helpdesk_status_sort'] = 'helpdesk_status_sort';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = HelpdeskStatusPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("helpdesk_status");
		$st->fields['helpdesk_status_id'] = $this->helpdeskStatusId;
		$st->fields['helpdesk_status_label'] = $this->helpdeskStatusLabel;
		$st->fields['helpdesk_status_sort'] = $this->helpdeskStatusSort;


		$st->key = 'helpdesk_status_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("helpdesk_status");
		$st->fields['helpdesk_status_id'] = $obj->helpdeskStatusId;
		$st->fields['helpdesk_status_label'] = $obj->helpdeskStatusLabel;
		$st->fields['helpdesk_status_sort'] = $obj->helpdeskStatusSort;


		$st->key = 'helpdesk_status_id';
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
		$st = new PBDO_DeleteStatement("helpdesk_status","helpdesk_status_id = '".$obj->getPrimaryKey()."'");

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
		$x = new HelpdeskStatus();
		$x->helpdeskStatusId = $row['helpdesk_status_id'];
		$x->helpdeskStatusLabel = $row['helpdesk_status_label'];
		$x->helpdeskStatusSort = $row['helpdesk_status_sort'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class HelpdeskStatus extends HelpdeskStatusBase {



}



class HelpdeskStatusPeer extends HelpdeskStatusPeerBase {

}

?>