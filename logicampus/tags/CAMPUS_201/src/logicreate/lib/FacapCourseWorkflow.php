<?

class FacapCourseWorkflowBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = 1.2;	//PBDO version number
	var $idFacapCourseWorkflow;
	var $processOrder;
	var $title;

	var $__attributes = array(
	'idFacapCourseWorkflow'=>'int',
	'processOrder'=>'int',
	'title'=>'varchar');

	function getFacapCourseActions() {
		$array = FacapCourseActionPeer::doSelect('id_facap_course_workflow = \''.$this->getPrimaryKey().'\'');
		return $array;
	}



	function getPrimaryKey() {
		return $this->idFacapCourseWorkflow;
	}

	function setPrimaryKey($val) {
		$this->idFacapCourseWorkflow = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(FacapCourseWorkflowPeer::doInsert($this));
		} else {
			FacapCourseWorkflowPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_facap_course_workflow='".$key."'";
		}
		$array = FacapCourseWorkflowPeer::doSelect($where);
		return $array[0];
	}

	function delete($deep=false) {
		FacapCourseWorkflowPeer::doDelete($this,$deep);
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
		if ($array['processOrder'])
			$this->processOrder = $array['processOrder'];
		if ($array['title'])
			$this->title = $array['title'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class FacapCourseWorkflowPeerBase {

	var $tableName = 'facap_course_workflow';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("facap_course_workflow",$where);
		$st->fields['id_facap_course_workflow'] = 'id_facap_course_workflow';
		$st->fields['process_order'] = 'process_order';
		$st->fields['title'] = 'title';

		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = FacapCourseWorkflowPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("facap_course_workflow");
		$st->fields['id_facap_course_workflow'] = $this->idFacapCourseWorkflow;
		$st->fields['process_order'] = $this->processOrder;
		$st->fields['title'] = $this->title;

		$st->key = 'id_facap_course_workflow';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("facap_course_workflow");
		$st->fields['id_facap_course_workflow'] = $obj->idFacapCourseWorkflow;
		$st->fields['process_order'] = $obj->processOrder;
		$st->fields['title'] = $obj->title;

		$st->key = 'id_facap_course_workflow';
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
		$st = new LC_DeleteStatement("facap_course_workflow","id_facap_course_workflow = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( $deep ) {

			$st = new LC_DeleteStatement("facap_course_action","id_facap_course_workflow = '".$obj->getPrimaryKey()."'");
			$db->executeQuery($st);
		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new FacapCourseWorkflow();
		$x->idFacapCourseWorkflow = $row['id_facap_course_workflow'];
		$x->processOrder = $row['process_order'];
		$x->title = $row['title'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class FacapCourseWorkflow extends FacapCourseWorkflowBase {



}



class FacapCourseWorkflowPeer extends FacapCourseWorkflowPeerBase {

}

?>