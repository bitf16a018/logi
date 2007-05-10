<?

class FacapFacultyActionBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $idFacapFacultyAction;
	var $idFacapFaculty;
	var $idFacapFacultyWorkflow;
	var $username;
	var $actionType;
	var $actionComment;

	var $__attributes = array(
	'idFacapFacultyAction'=>'int',
	'idFacapFaculty'=>'FacapFaculty',
	'idFacapFacultyWorkflow'=>'FacapFacultyWorkflow',
	'username'=>'varchar',
	'actionType'=>'varchar',
	'actionComment'=>'text');

	function getFacapFaculty() {
		if ( $this->idFacapFaculty == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = FacapFacultyPeer::doSelect('id_facap_faculty = \''.$this->idFacapFaculty.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}

	function getFacapFacultyWorkflow() {
		if ( $this->idFacapFacultyWorkflow == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = FacapFacultyWorkflowPeer::doSelect('id_facap_faculty_workflow = \''.$this->idFacapFacultyWorkflow.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->idFacapFacultyAction;
	}

	function setPrimaryKey($val) {
		$this->idFacapFacultyAction = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(FacapFacultyActionPeer::doInsert($this));
		} else {
			FacapFacultyActionPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_facap_faculty_action='".$key."'";
		}
		$array = FacapFacultyActionPeer::doSelect($where);
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
		if ($array['username'])
			$this->username = $array['username'];
		if ($array['actionType'])
			$this->actionType = $array['actionType'];
		if ($array['actionComment'])
			$this->actionComment = $array['actionComment'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class FacapFacultyActionPeerBase {

	var $tableName = 'facap_faculty_action';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("facap_faculty_action",$where);
		$st->fields['id_facap_faculty_action'] = 'id_facap_faculty_action';
		$st->fields['id_facap_faculty'] = 'id_facap_faculty';
		$st->fields['id_facap_faculty_workflow'] = 'id_facap_faculty_workflow';
		$st->fields['username'] = 'username';
		$st->fields['action_type'] = 'action_type';
		$st->fields['action_comment'] = 'action_comment';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = FacapFacultyActionPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("facap_faculty_action");
		$st->fields['id_facap_faculty_action'] = $this->idFacapFacultyAction;
		$st->fields['id_facap_faculty'] = $this->idFacapFaculty;
		$st->fields['id_facap_faculty_workflow'] = $this->idFacapFacultyWorkflow;
		$st->fields['username'] = $this->username;
		$st->fields['action_type'] = $this->actionType;
		$st->fields['action_comment'] = $this->actionComment;

		$st->key = 'id_facap_faculty_action';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("facap_faculty_action");
		$st->fields['id_facap_faculty_action'] = $obj->idFacapFacultyAction;
		$st->fields['id_facap_faculty'] = $obj->idFacapFaculty;
		$st->fields['id_facap_faculty_workflow'] = $obj->idFacapFacultyWorkflow;
		$st->fields['username'] = $obj->username;
		$st->fields['action_type'] = $obj->actionType;
		$st->fields['action_comment'] = $obj->actionComment;

		$st->key = 'id_facap_faculty_action';
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
		$st = new LC_DeleteStatement("facap_faculty_action","id_facap_faculty_action = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new FacapFacultyAction();
		$x->idFacapFacultyAction = $row['id_facap_faculty_action'];
		$x->idFacapFaculty = $row['id_facap_faculty'];
		$x->idFacapFacultyWorkflow = $row['id_facap_faculty_workflow'];
		$x->username = $row['username'];
		$x->actionType = $row['action_type'];
		$x->actionComment = $row['action_comment'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class FacapFacultyAction extends FacapFacultyActionBase {



}



class FacapFacultyActionPeer extends FacapFacultyActionPeerBase {

}

?>