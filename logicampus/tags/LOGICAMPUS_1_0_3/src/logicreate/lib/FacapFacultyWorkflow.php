<?

class FacapFacultyWorkflowBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $idFacapFacultyWorkflow;
	var $processOrder;
	var $title;

	var $__attributes = array(
	'idFacapFacultyWorkflow'=>'int',
	'processOrder'=>'int',
	'title'=>'varchar');

	function getFacapFacultyActions() {
		$array = FacapFacultyActionPeer::doSelect('id_facap_faculty_workflow = \''.$this->getPrimaryKey().'\'');
		return $array;
	}



	function getPrimaryKey() {
		return $this->idFacapFacultyWorkflow;
	}

	function setPrimaryKey($val) {
		$this->idFacapFacultyWorkflow = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(FacapFacultyWorkflowPeer::doInsert($this));
		} else {
			FacapFacultyWorkflowPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_facap_faculty_workflow='".$key."'";
		}
		$array = FacapFacultyWorkflowPeer::doSelect($where);
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


class FacapFacultyWorkflowPeerBase {

	var $tableName = 'facap_faculty_workflow';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("facap_faculty_workflow",$where);
		$st->fields['id_facap_faculty_workflow'] = 'id_facap_faculty_workflow';
		$st->fields['process_order'] = 'process_order';
		$st->fields['title'] = 'title';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = FacapFacultyWorkflowPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("facap_faculty_workflow");
		$st->fields['id_facap_faculty_workflow'] = $this->idFacapFacultyWorkflow;
		$st->fields['process_order'] = $this->processOrder;
		$st->fields['title'] = $this->title;

		$st->key = 'id_facap_faculty_workflow';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("facap_faculty_workflow");
		$st->fields['id_facap_faculty_workflow'] = $obj->idFacapFacultyWorkflow;
		$st->fields['process_order'] = $obj->processOrder;
		$st->fields['title'] = $obj->title;

		$st->key = 'id_facap_faculty_workflow';
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
		$st = new LC_DeleteStatement("facap_faculty_workflow","id_facap_faculty_workflow = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

			$st = new LC_DeleteStatement("facap_faculty_action","id_facap_faculty_workflow = '".$obj->getPrimaryKey()."'");
			$db->executeQuery($st);
		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new FacapFacultyWorkflow();
		$x->idFacapFacultyWorkflow = $row['id_facap_faculty_workflow'];
		$x->processOrder = $row['process_order'];
		$x->title = $row['title'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class FacapFacultyWorkflow extends FacapFacultyWorkflowBase {



}



class FacapFacultyWorkflowPeer extends FacapFacultyWorkflowPeerBase {

}

?>