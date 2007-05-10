<?

class ClassLinksBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.4';	//PBDO version number
	var $_entityVersion = '0.0';	//Source version number
	var $idClassLinks;
	var $idClasses;
	var $idClassLinksCategories;
	var $title;
	var $url;
	var $description;
	var $dateCreated;
	var $createdby;
	var $hits;

	var $__attributes = array(
	'idClassLinks'=>'int',
	'idClasses'=>'int',
	'idClassLinksCategories'=>'int',
	'title'=>'varchar',
	'url'=>'varchar',
	'description'=>'text',
	'dateCreated'=>'datetime',
	'createdby'=>'varchar',
	'hits'=>'int');



	function getPrimaryKey() {
		return $this->idClassLinks;
	}

	function setPrimaryKey($val) {
		$this->idClassLinks = $val;
	}
	
	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassLinksPeer::doInsert($this,$dsn));
		} else {
			ClassLinksPeer::doUpdate($this,$dsn);
		}
	}

	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_links='".$key."'";
		}
		$array = ClassLinksPeer::doSelect($where,$dsn);
		return $array[0];
	}

	function delete($deep=false,$dsn="default") {
		ClassLinksPeer::doDelete($this,$deep,$dsn);
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
		if ($array['idClasses'])
			$this->idClasses = $array['idClasses'];
		if ($array['idClassLinksCategories'])
			$this->idClassLinksCategories = $array['idClassLinksCategories'];
		if ($array['title'])
			$this->title = $array['title'];
		if ($array['url'])
			$this->url = $array['url'];
		if ($array['description'])
			$this->description = $array['description'];
		if ($array['dateCreated'])
			$this->dateCreated = $array['dateCreated'];
		if ($array['createdby'])
			$this->createdby = $array['createdby'];
		if ($array['hits'])
			$this->hits = $array['hits'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class ClassLinksPeerBase {

	var $tableName = 'class_links';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_SelectStatement("class_links",$where);
		$st->fields['id_class_links'] = 'id_class_links';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['id_class_links_categories'] = 'id_class_links_categories';
		$st->fields['title'] = 'title';
		$st->fields['url'] = 'url';
		$st->fields['description'] = 'description';
		$st->fields['dateCreated'] = 'dateCreated';
		$st->fields['createdby'] = 'createdby';
		$st->fields['hits'] = 'hits';

		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassLinksPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_InsertStatement("class_links");
		$st->fields['id_class_links'] = $this->idClassLinks;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['id_class_links_categories'] = $this->idClassLinksCategories;
		$st->fields['title'] = $this->title;
		$st->fields['url'] = $this->url;
		$st->fields['description'] = $this->description;
		$st->fields['dateCreated'] = $this->dateCreated;
		$st->fields['createdby'] = $this->createdby;
		$st->fields['hits'] = $this->hits;

		$st->key = 'id_class_links';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_UpdateStatement("class_links");
		$st->fields['id_class_links'] = $obj->idClassLinks;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['id_class_links_categories'] = $obj->idClassLinksCategories;
		$st->fields['title'] = $obj->title;
		$st->fields['url'] = $obj->url;
		$st->fields['description'] = $obj->description;
		$st->fields['dateCreated'] = $obj->dateCreated;
		$st->fields['createdby'] = $obj->createdby;
		$st->fields['hits'] = $obj->hits;

		$st->key = 'id_class_links';
		$db->executeQuery($st);
		$obj->_modified = false;

	}

	function doReplace($obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		if ($this->isNew() ) {
			$db->executeQuery(new LC_InsertStatement($criteria));
		} else {
			$db->executeQuery(new LC_UpdateStatement($criteria));
		}
	}



	function doDelete(&$obj,$deep=false,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_DeleteStatement("class_links","id_class_links = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( $deep ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new ClassLinks();
		$x->idClassLinks = $row['id_class_links'];
		$x->idClasses = $row['id_classes'];
		$x->idClassLinksCategories = $row['id_class_links_categories'];
		$x->title = $row['title'];
		$x->url = $row['url'];
		$x->description = $row['description'];
		$x->dateCreated = $row['dateCreated'];
		$x->createdby = $row['createdby'];
		$x->hits = $row['hits'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassLinks extends ClassLinksBase {



}



class ClassLinksPeer extends ClassLinksPeerBase {

}

?>