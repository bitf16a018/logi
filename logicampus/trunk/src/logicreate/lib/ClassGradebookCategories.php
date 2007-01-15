<?

class ClassGradebookCategoriesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idClassGradebookCategories;
	var $idClasses;
	var $label;
	var $weight;
	var $dropCount;

	var $__attributes = array( 
	'idClassGradebookCategories'=>'integer',
	'idClasses'=>'integer',
	'label'=>'varchar',
	'weight'=>'float',
	'dropCount'=>'tinyint');

	var $__nulls = array( 
	'weight'=>'weight');



	function getPrimaryKey() {
		return $this->idClassGradebookCategories;
	}


	function setPrimaryKey($val) {
		$this->idClassGradebookCategories = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassGradebookCategoriesPeer::doInsert($this,$dsn));
		} else {
			ClassGradebookCategoriesPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_gradebook_categories='".$key."'";
		}
		$array = ClassGradebookCategoriesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassGradebookCategoriesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassGradebookCategoriesPeer::doDelete($this,$deep,$dsn);
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


class ClassGradebookCategoriesPeerBase {

	var $tableName = 'class_gradebook_categories';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_gradebook_categories",$where);
		$st->fields['id_class_gradebook_categories'] = 'id_class_gradebook_categories';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['label'] = 'label';
		$st->fields['weight'] = 'weight';
		$st->fields['drop_count'] = 'drop_count';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassGradebookCategoriesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_gradebook_categories");
		$st->fields['id_class_gradebook_categories'] = $this->idClassGradebookCategories;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['label'] = $this->label;
		$st->fields['weight'] = $this->weight;
		$st->fields['drop_count'] = $this->dropCount;

		$st->nulls['weight'] = 'weight';

		$st->key = 'id_class_gradebook_categories';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_gradebook_categories");
		$st->fields['id_class_gradebook_categories'] = $obj->idClassGradebookCategories;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['label'] = $obj->label;
		$st->fields['weight'] = $obj->weight;
		$st->fields['drop_count'] = $obj->dropCount;

		$st->nulls['weight'] = 'weight';

		$st->key = 'id_class_gradebook_categories';
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
		$st = new PBDO_DeleteStatement("class_gradebook_categories","id_class_gradebook_categories = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassGradebookCategories();
		$x->idClassGradebookCategories = $row['id_class_gradebook_categories'];
		$x->idClasses = $row['id_classes'];
		$x->label = $row['label'];
		$x->weight = $row['weight'];
		$x->dropCount = $row['drop_count'];

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