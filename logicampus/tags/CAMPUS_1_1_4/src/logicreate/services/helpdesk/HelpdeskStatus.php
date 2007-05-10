<?

class HelpdeskStatusBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $helpdeskStatusId;
	var $helpdeskStatusLabel;

	var $__attributes = array(
	'helpdeskStatusId'=>'integer',
	'helpdeskStatusLabel'=>'varchar');



	function getPrimaryKey() {
		return $this->helpdeskStatusId;
	}

	function setPrimaryKey($val) {
		$this->helpdeskStatusId = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(HelpdeskStatusPeer::doInsert($this));
		} else {
			HelpdeskStatusPeer::doUpdate($this);
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
			$where = "helpdesk_status_id='".$key."'";
		}
		$array = HelpdeskStatusPeer::doSelect($where);
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
		if ($array['helpdeskStatusLabel'])
			$this->helpdeskStatusLabel = $array['helpdeskStatusLabel'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class HelpdeskStatusPeer {

	var $tableName = 'helpdesk_status';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("helpdesk_status",$where);
		$st->fields['helpdesk_status_id'] = 'helpdesk_status_id';
		$st->fields['helpdesk_status_label'] = 'helpdesk_status_label';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = HelpdeskStatusPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("helpdesk_status");
		$st->fields['helpdesk_status_id'] = $this->helpdeskStatusId;
		$st->fields['helpdesk_status_label'] = $this->helpdeskStatusLabel;

		$st->key = 'helpdesk_status_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("helpdesk_status");
		$st->fields['helpdesk_status_id'] = $obj->helpdeskStatusId;
		$st->fields['helpdesk_status_label'] = $obj->helpdeskStatusLabel;

		$st->key = 'helpdesk_status_id';
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
		$st = new LC_DeleteStatement("helpdesk_status","helpdesk_status_id = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new HelpdeskStatus();
		$x->helpdeskStatusId = $row['helpdesk_status_id'];
		$x->helpdeskStatusLabel = $row['helpdesk_status_label'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class HelpdeskStatus extends HelpdeskStatusBase {



}

?>
