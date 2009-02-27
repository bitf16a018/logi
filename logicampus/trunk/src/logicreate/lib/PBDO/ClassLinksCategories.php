<?

class ClassLinksCategoriesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idClassLinksCategories;
	var $idClassLinksCategoriesParent;
	var $idClasses;
	var $txTitle;
	var $sortOrder;

	var $__attributes = array( 
	'idClassLinksCategories'=>'integer',
	'idClassLinksCategoriesParent'=>'integer',
	'idClasses'=>'integer',
	'txTitle'=>'varchar',
	'sortOrder'=>'integer');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->idClassLinksCategories;
	}


	function setPrimaryKey($val) {
		$this->idClassLinksCategories = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassLinksCategoriesPeer::doInsert($this,$dsn));
		} else {
			ClassLinksCategoriesPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_links_categories='".$key."'";
		}
		$array = ClassLinksCategoriesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassLinksCategoriesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassLinksCategoriesPeer::doDelete($this,$deep,$dsn);
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


class ClassLinksCategoriesPeerBase {

	var $tableName = 'class_links_categories';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_links_categories",$where);
		$st->fields['id_class_links_categories'] = 'id_class_links_categories';
		$st->fields['id_class_links_categories_parent'] = 'id_class_links_categories_parent';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['txTitle'] = 'txTitle';
		$st->fields['sortOrder'] = 'sortOrder';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassLinksCategoriesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_links_categories");
		$st->fields['id_class_links_categories'] = $this->idClassLinksCategories;
		$st->fields['id_class_links_categories_parent'] = $this->idClassLinksCategoriesParent;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['txTitle'] = $this->txTitle;
		$st->fields['sortOrder'] = $this->sortOrder;


		$st->key = 'id_class_links_categories';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_links_categories");
		$st->fields['id_class_links_categories'] = $obj->idClassLinksCategories;
		$st->fields['id_class_links_categories_parent'] = $obj->idClassLinksCategoriesParent;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['txTitle'] = $obj->txTitle;
		$st->fields['sortOrder'] = $obj->sortOrder;


		$st->key = 'id_class_links_categories';
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
		$st = new PBDO_DeleteStatement("class_links_categories","id_class_links_categories = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassLinksCategories();
		$x->idClassLinksCategories = $row['id_class_links_categories'];
		$x->idClassLinksCategoriesParent = $row['id_class_links_categories_parent'];
		$x->idClasses = $row['id_classes'];
		$x->txTitle = $row['txTitle'];
		$x->sortOrder = $row['sortOrder'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassLinksCategories extends ClassLinksCategoriesBase {



}



class ClassLinksCategoriesPeer extends ClassLinksCategoriesPeerBase {

}

?>