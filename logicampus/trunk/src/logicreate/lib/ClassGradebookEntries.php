<?

class ClassGradebookEntriesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $idClassGradebookEntries;
	var $idClasses;
	var $idClassGradebookCategories;
	var $assessmentId = 0;
	var $title;
	var $gradebookCode;
	var $assignmentId = 0;
	var $dateDue = 0;
	var $totalPoints = 0;
	var $publishFlag = 0;
	var $notes;

	var $__attributes = array(
	'idClassGradebookEntries'=>'int',
	'idClasses'=>'Classes',
	'idClassGradebookCategories'=>'ClassGradebookCategories',
	'assessmentId'=>'int',
	'title'=>'varchar',
	'gradebookCode'=>'varchar',
	'assignmentId'=>'ClassAssignments',
	'dateDue'=>'int',
	'totalPoints'=>'float',
	'publishFlag'=>'tinyint',
	'notes'=>'text');

	function getClassGradebookVals() {
		$array = ClassGradebookValPeer::doSelect('id_class_gradebook_entries = \''.$this->getPrimaryKey().'\'');
		return $array;
	}

	function getClassGradebookCategories() {
		if ( $this->idClassGradebookCategories == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = ClassGradebookCategoriesPeer::doSelect('id_class_gradebook_categories = \''.$this->idClassGradebookCategories.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}

	function getClasses() {
		if ( $this->idClasses == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = ClassesPeer::doSelect('id_classes = \''.$this->idClasses.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}

	function getClassAssignments() {
		if ( $this->idClassAssignments == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = ClassAssignmentsPeer::doSelect('id_class_assignments = \''.$this->assignmentId.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->idClassGradebookEntries;
	}

	function setPrimaryKey($val) {
		$this->idClassGradebookEntries = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassGradebookEntriesPeer::doInsert($this));
		} else {
			ClassGradebookEntriesPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_gradebook_entries='".$key."'";
		}
		$array = ClassGradebookEntriesPeer::doSelect($where);
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
		if ($array['assessmentId'])
			$this->assessmentId = $array['assessmentId'];
		if ($array['title'])
			$this->title = $array['title'];
		if ($array['gradebookCode'])
			$this->gradebookCode = $array['gradebookCode'];
		if ($array['assignmentId'])
			$this->assignmentId = $array['assignmentId'];
		if ($array['dateDue'])
			$this->dateDue = $array['dateDue'];
		if ($array['totalPoints'])
			$this->totalPoints = $array['totalPoints'];
		if ($array['publishFlag'])
			$this->publishFlag = $array['publishFlag'];
		if ($array['notes'])
			$this->notes = $array['notes'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class ClassGradebookEntriesPeerBase {

	var $tableName = 'class_gradebook_entries';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("class_gradebook_entries",$where);
		$st->fields['id_class_gradebook_entries'] = 'id_class_gradebook_entries';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['id_class_gradebook_categories'] = 'id_class_gradebook_categories';
		$st->fields['assessment_id'] = 'assessment_id';
		$st->fields['title'] = 'title';
		$st->fields['gradebook_code'] = 'gradebook_code';
		$st->fields['assignment_id'] = 'assignment_id';
		$st->fields['date_due'] = 'date_due';
		$st->fields['total_points'] = 'total_points';
		$st->fields['publish_flag'] = 'publish_flag';
		$st->fields['notes'] = 'notes';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassGradebookEntriesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("class_gradebook_entries");
		$st->fields['id_class_gradebook_entries'] = $this->idClassGradebookEntries;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['id_class_gradebook_categories'] = $this->idClassGradebookCategories;
		$st->fields['assessment_id'] = $this->assessmentId;
		$st->fields['title'] = $this->title;
		$st->fields['gradebook_code'] = $this->gradebookCode;
		$st->fields['assignment_id'] = $this->assignmentId;
		$st->fields['date_due'] = $this->dateDue;
		$st->fields['total_points'] = $this->totalPoints;
		$st->fields['publish_flag'] = $this->publishFlag;
		$st->fields['notes'] = $this->notes;

		$st->key = 'id_class_gradebook_entries';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("class_gradebook_entries");
		$st->fields['id_class_gradebook_entries'] = $obj->idClassGradebookEntries;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['id_class_gradebook_categories'] = $obj->idClassGradebookCategories;
		$st->fields['assessment_id'] = $obj->assessmentId;
		$st->fields['title'] = $obj->title;
		$st->fields['gradebook_code'] = $obj->gradebookCode;
		$st->fields['assignment_id'] = $obj->assignmentId;
		$st->fields['date_due'] = $obj->dateDue;
		$st->fields['total_points'] = $obj->totalPoints;
		$st->fields['publish_flag'] = $obj->publishFlag;
		$st->fields['notes'] = $obj->notes;

		$st->key = 'id_class_gradebook_entries';
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
		$st = new LC_DeleteStatement("class_gradebook_entries","id_class_gradebook_entries = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

			$st = new LC_DeleteStatement("class_gradebook_val","id_class_gradebook_entries = '".$obj->getPrimaryKey()."'");
			$db->executeQuery($st);
		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new ClassGradebookEntries();
		$x->idClassGradebookEntries = $row['id_class_gradebook_entries'];
		$x->idClasses = $row['id_classes'];
		$x->idClassGradebookCategories = $row['id_class_gradebook_categories'];
		$x->assessmentId = $row['assessment_id'];
		$x->title = $row['title'];
		$x->gradebookCode = $row['gradebook_code'];
		$x->assignmentId = $row['assignment_id'];
		$x->dateDue = $row['date_due'];
		$x->totalPoints = $row['total_points'];
		$x->publishFlag = $row['publish_flag'];
		$x->notes = $row['notes'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class ClassGradebookEntries extends ClassGradebookEntriesBase {



}

class ClassGradebookEntriesPeer extends ClassGradebookEntriesPeerBase {

}

?>
