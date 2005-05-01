<?

class ClassLessonsBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.4';	//PBDO version number
	var $_entityVersion = '0.0';	//Source version number
	var $idClassLessons;
	var $idClasses;
	var $createdOn;
	var $title;
	var $description;
	var $activeOn;
	var $inactiveOn;
	var $checkList;

	var $__attributes = array(
	'idClassLessons'=>'int',
	'idClasses'=>'int',
	'createdOn'=>'int',
	'title'=>'varchar',
	'description'=>'text',
	'activeOn'=>'int',
	'inactiveOn'=>'int',
	'checkList'=>'text');



	function getPrimaryKey() {
		return $this->idClassLessons;
	}

	function setPrimaryKey($val) {
		$this->idClassLessons = $val;
	}
	
	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassLessonsPeer::doInsert($this,$dsn));
		} else {
			ClassLessonsPeer::doUpdate($this,$dsn);
		}
	}

	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_lessons='".$key."'";
		}
		$array = ClassLessonsPeer::doSelect($where,$dsn);
		return $array[0];
	}

	function delete($deep=false,$dsn="default") {
		ClassLessonsPeer::doDelete($this,$deep,$dsn);
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
		if ($array['createdOn'])
			$this->createdOn = $array['createdOn'];
		if ($array['title'])
			$this->title = $array['title'];
		if ($array['description'])
			$this->description = $array['description'];
		if ($array['activeOn'])
			$this->activeOn = $array['activeOn'];
		if ($array['inactiveOn'])
			$this->inactiveOn = $array['inactiveOn'];
		if ($array['checkList'])
			$this->checkList = $array['checkList'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class ClassLessonsPeerBase {

	var $tableName = 'class_lessons';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_SelectStatement("class_lessons",$where);
		$st->fields['id_class_lessons'] = 'id_class_lessons';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['createdOn'] = 'createdOn';
		$st->fields['title'] = 'title';
		$st->fields['description'] = 'description';
		$st->fields['activeOn'] = 'activeOn';
		$st->fields['inactiveOn'] = 'inactiveOn';
		$st->fields['checkList'] = 'checkList';

		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassLessonsPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_InsertStatement("class_lessons");
		$st->fields['id_class_lessons'] = $this->idClassLessons;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['createdOn'] = $this->createdOn;
		$st->fields['title'] = $this->title;
		$st->fields['description'] = $this->description;
		$st->fields['activeOn'] = $this->activeOn;
		$st->fields['inactiveOn'] = $this->inactiveOn;
		$st->fields['checkList'] = $this->checkList;

		$st->key = 'id_class_lessons';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_UpdateStatement("class_lessons");
		$st->fields['id_class_lessons'] = $obj->idClassLessons;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['createdOn'] = $obj->createdOn;
		$st->fields['title'] = $obj->title;
		$st->fields['description'] = $obj->description;
		$st->fields['activeOn'] = $obj->activeOn;
		$st->fields['inactiveOn'] = $obj->inactiveOn;
		$st->fields['checkList'] = $obj->checkList;

		$st->key = 'id_class_lessons';
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
		$st = new LC_DeleteStatement("class_lessons","id_class_lessons = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( $deep ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new ClassLessons();
		$x->idClassLessons = $row['id_class_lessons'];
		$x->idClasses = $row['id_classes'];
		$x->createdOn = $row['createdOn'];
		$x->title = $row['title'];
		$x->description = $row['description'];
		$x->activeOn = $row['activeOn'];
		$x->inactiveOn = $row['inactiveOn'];
		$x->checkList = $row['checkList'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassLessons extends ClassLessonsBase {



}



class ClassLessonsPeer extends ClassLessonsPeerBase {

}

?>