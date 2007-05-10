<?

class ClassLinksCategoriesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.4';	//PBDO version number
	var $_entityVersion = '0.0';	//Source version number
	var $idClassLinksCategories;
	var $idClassLinksCategoriesParent;
	var $idClasses;
	var $txTitle;
	var $sortOrder;

	var $__attributes = array(
	'idClassLinksCategories'=>'int',
	'idClassLinksCategoriesParent'=>'int',
	'idClasses'=>'int',
	'txTitle'=>'varchar',
	'sortOrder'=>'int');



	function getPrimaryKey() {
		return $this->idClassLinksCategories;
	}

	function setPrimaryKey($val) {
		$this->idClassLinksCategories = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassLinksCategoriesPeer::doInsert($this));
		} else {
			ClassLinksCategoriesPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_links_categories='".$key."'";
		}
		$array = ClassLinksCategoriesPeer::doSelect($where);
		return $array[0];
	}

	function delete($deep=false) {
		ClassLinksCategoriesPeer::doDelete($this,$deep);
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
		if ( !empty($array['idClassLinksCategoriesParent']) || strlen($array['idClassLinksCategoriesParent']) != 0 )
			$this->idClassLinksCategoriesParent = $array['idClassLinksCategoriesParent'];
		if ( !empty($array['idClasses']) || strlen($array['idClasses']) != 0 )
			$this->idClasses = $array['idClasses'];
		if ( !empty($array['txTitle']) || strlen($array['txTitle']) != 0 )
			$this->txTitle = $array['txTitle'];
		if ( !empty($array['sortOrder']) || strlen($array['sortOrder']) != 0 )
			$this->sortOrder = $array['sortOrder'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class ClassLinksCategoriesPeerBase {

	var $tableName = 'class_links_categories';

	function doSelect($where) {
		//use this tableName
//		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("class_links_categories",$where);
		$st->fields['id_class_links_categories'] = 'id_class_links_categories';
		$st->fields['id_class_links_categories_parent'] = 'id_class_links_categories_parent';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['txTitle'] = 'txTitle';
		$st->fields['sortOrder'] = 'sortOrder';

		$st->key = $this->key;

		$array = array();
//		$db->executeQuery($st);
/*
		while($db->nextRecord() ) {
			$array[] = ClassLinksCategoriesPeer::row2Obj($db->record);
		}
		*/

		$res = mysql_query($st->toString());
		while ($row = mysql_fetch_array($res)) {
			$array[] = ClassLinksCategoriesPeer::row2Obj($row);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
//		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("class_links_categories");
		$st->fields['id_class_links_categories'] = $this->idClassLinksCategories;
		$st->fields['id_class_links_categories_parent'] = $this->idClassLinksCategoriesParent;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['txTitle'] = $this->txTitle;
		$st->fields['sortOrder'] = $this->sortOrder;

		$st->key = 'id_class_links_categories';
//		$db->executeQuery($st);

		mysql_query($st->toString());
		$obj->_new = false;
		$obj->_modified = false;
//		$id =  $db->getInsertID();
		$id = mysql_insert_id();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
//		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("class_links_categories");
		$st->fields['id_class_links_categories'] = $obj->idClassLinksCategories;
		$st->fields['id_class_links_categories_parent'] = $obj->idClassLinksCategoriesParent;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['txTitle'] = $obj->txTitle;
		$st->fields['sortOrder'] = $obj->sortOrder;

		$st->key = 'id_class_links_categories';
//		$db->executeQuery($st);
		mysql_query($st->toString());

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
//		$db = lcDB::getHandle();
		$st = new LC_DeleteStatement("class_links_categories","id_class_links_categories = '".$obj->getPrimaryKey()."'");

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
	function doQuery($sql,$dsn="default") {
		//use this tableName
//		$db = lcDB::getHandle($dsn);

		mysql_query($sql);

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