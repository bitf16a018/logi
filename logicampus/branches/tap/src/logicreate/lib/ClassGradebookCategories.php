<?

class ClassGradebookCategoriesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $idClassGradebookCategories;
	var $idClasses;
	var $label;
	var $weight;

	var $__attributes = array(
	'idClassGradebookCategories'=>'int',
	'idClasses'=>'Classes',
	'label'=>'varchar',
	'weight'=>'float');

	function getClassGradebookEntries() {
		$array = ClassGradebookEntriesPeer::doSelect('id_class_gradebook_categories = \''.$this->getPrimaryKey().'\'');
		return $array;
	}

	function getClasses() {
		if ( $this->idClasses == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = ClassesPeer::doSelect('id_classes = \''.$this->idClasses.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->idClassGradebookCategories;
	}

	function setPrimaryKey($val) {
		$this->idClassGradebookCategories = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassGradebookCategoriesPeer::doInsert($this));
		} else {
			ClassGradebookCategoriesPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_gradebook_categories='".$key."'";
		}
		$array = ClassGradebookCategoriesPeer::doSelect($where);
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
		if ($array['label'])
			$this->label = $array['label'];
		if ($array['weight'])
			$this->weight = $array['weight'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class ClassGradebookCategoriesPeerBase {

	var $tableName = 'class_gradebook_categories';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("class_gradebook_categories",$where);
		$st->fields['id_class_gradebook_categories'] = 'id_class_gradebook_categories';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['label'] = 'label';
		$st->fields['weight'] = 'weight';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassGradebookCategoriesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("class_gradebook_categories");
		$st->fields['id_class_gradebook_categories'] = $this->idClassGradebookCategories;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['label'] = $this->label;
		$st->fields['weight'] = $this->weight;

		$st->key = 'id_class_gradebook_categories';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("class_gradebook_categories");
		$st->fields['id_class_gradebook_categories'] = $obj->idClassGradebookCategories;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['label'] = $obj->label;
		$st->fields['weight'] = $obj->weight;

		$st->key = 'id_class_gradebook_categories';
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
		$st = new LC_DeleteStatement("class_gradebook_categories","id_class_gradebook_categories = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

			$st = new LC_DeleteStatement("class_gradebook_entries","id_class_gradebook_categories = '".$obj->getPrimaryKey()."'");
			$db->executeQuery($st);
		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new ClassGradebookCategories();
		$x->idClassGradebookCategories = $row['id_class_gradebook_categories'];
		$x->idClasses = $row['id_classes'];
		$x->label = $row['label'];
		$x->weight = $row['weight'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class ClassGradebookCategories extends ClassGradebookCategoriesBase {



}


class ClassGradebookCategoriesPeer extends ClassGradebookCategoriesPeerBase {

}
?>
