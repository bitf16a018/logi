<?

class FacapCourseActionBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = 1.2;	//PBDO version number
	var $idFacapCourseAction;
	var $idFacapCourse;
	var $idFacapCourseWorkflow;
	var $username;
	var $actionType;
	var $actionComment;

	var $__attributes = array(
	'idFacapCourseAction'=>'int',
	'idFacapCourse'=>'FacapCourse',
	'idFacapCourseWorkflow'=>'FacapCourseWorkflow',
	'username'=>'varchar',
	'actionType'=>'varchar',
	'actionComment'=>'text');

	function getFacapCourse() {
		if ( $this->idFacapCourse == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = FacapCoursePeer::doSelect('id_facap_course = \''.$this->idFacapCourse.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}

	function getFacapCourseWorkflow() {
		if ( $this->idFacapCourseWorkflow == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = FacapCourseWorkflowPeer::doSelect('id_facap_course_workflow = \''.$this->idFacapCourseWorkflow.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->idFacapCourseAction;
	}

	function setPrimaryKey($val) {
		$this->idFacapCourseAction = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(FacapCourseActionPeer::doInsert($this));
		} else {
			FacapCourseActionPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_facap_course_action='".$key."'";
		}
		$array = FacapCourseActionPeer::doSelect($where);
		return $array[0];
	}

	function delete($deep=false) {
		FacapCourseActionPeer::doDelete($this,$deep);
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


class FacapCourseActionPeerBase {

	var $tableName = 'facap_course_action';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("facap_course_action",$where);
		$st->fields['id_facap_course_action'] = 'id_facap_course_action';
		$st->fields['id_facap_course'] = 'id_facap_course';
		$st->fields['id_facap_course_workflow'] = 'id_facap_course_workflow';
		$st->fields['username'] = 'username';
		$st->fields['action_type'] = 'action_type';
		$st->fields['action_comment'] = 'action_comment';

		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = FacapCourseActionPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("facap_course_action");
		$st->fields['id_facap_course_action'] = $this->idFacapCourseAction;
		$st->fields['id_facap_course'] = $this->idFacapCourse;
		$st->fields['id_facap_course_workflow'] = $this->idFacapCourseWorkflow;
		$st->fields['username'] = $this->username;
		$st->fields['action_type'] = $this->actionType;
		$st->fields['action_comment'] = $this->actionComment;

		$st->key = 'id_facap_course_action';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("facap_course_action");
		$st->fields['id_facap_course_action'] = $obj->idFacapCourseAction;
		$st->fields['id_facap_course'] = $obj->idFacapCourse;
		$st->fields['id_facap_course_workflow'] = $obj->idFacapCourseWorkflow;
		$st->fields['username'] = $obj->username;
		$st->fields['action_type'] = $obj->actionType;
		$st->fields['action_comment'] = $obj->actionComment;

		$st->key = 'id_facap_course_action';
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



	function doDelete(&$obj,$deep=false) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_DeleteStatement("facap_course_action","id_facap_course_action = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( $deep ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new FacapCourseAction();
		$x->idFacapCourseAction = $row['id_facap_course_action'];
		$x->idFacapCourse = $row['id_facap_course'];
		$x->idFacapCourseWorkflow = $row['id_facap_course_workflow'];
		$x->username = $row['username'];
		$x->actionType = $row['action_type'];
		$x->actionComment = $row['action_comment'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class FacapCourseAction extends FacapCourseActionBase {



}



class FacapCourseActionPeer extends FacapCourseActionPeerBase {

}

?>