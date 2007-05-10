<?

class ClassLessonLinksBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.4';	//PBDO version number
	var $_entityVersion = '0.0';	//Source version number
	var $idClassLessons;
	var $idClassLinks;

	var $__attributes = array(
	'idClassLessons'=>'int',
	'idClassLinks'=>'int');



	function getPrimaryKey() {
		return $this->;
	}

	function setPrimaryKey($val) {
		$this-> = $val;
	}
	
	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassLessonLinksPeer::doInsert($this,$dsn));
		} else {
			ClassLessonLinksPeer::doUpdate($this,$dsn);
		}
	}

	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "='".$key."'";
		}
		$array = ClassLessonLinksPeer::doSelect($where,$dsn);
		return $array[0];
	}

	function delete($deep=false,$dsn="default") {
		ClassLessonLinksPeer::doDelete($this,$deep,$dsn);
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
		if ($array['idClassLessons'])
			$this->idClassLessons = $array['idClassLessons'];
		if ($array['idClassLinks'])
			$this->idClassLinks = $array['idClassLinks'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class ClassLessonLinksPeerBase {

	var $tableName = 'class_lesson_links';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_SelectStatement("class_lesson_links",$where);
		$st->fields['id_class_lessons'] = 'id_class_lessons';
		$st->fields['id_class_links'] = 'id_class_links';

		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassLessonLinksPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_InsertStatement("class_lesson_links");
		$st->fields['id_class_lessons'] = $this->idClassLessons;
		$st->fields['id_class_links'] = $this->idClassLinks;

		$st->key = '';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_UpdateStatement("class_lesson_links");
		$st->fields['id_class_lessons'] = $obj->idClassLessons;
		$st->fields['id_class_links'] = $obj->idClassLinks;

		$st->key = '';
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
		$st = new LC_DeleteStatement("class_lesson_links"," = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( $deep ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new ClassLessonLinks();
		$x->idClassLessons = $row['id_class_lessons'];
		$x->idClassLinks = $row['id_class_links'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassLessonLinks extends ClassLessonLinksBase {



}



class ClassLessonLinksPeer extends ClassLessonLinksPeerBase {

}

?>