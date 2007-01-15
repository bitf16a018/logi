<?

class ClassLessonContentBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idClassLessonContent;
	var $idClasses;
	var $idClassLessons;
	var $txTitle;
	var $txText;
	var $dateCreated;

	var $__attributes = array( 
	'idClassLessonContent'=>'integer',
	'idClasses'=>'integer',
	'idClassLessons'=>'integer',
	'txTitle'=>'varchar',
	'txText'=>'longtext',
	'dateCreated'=>'date');

	var $__nulls = array( 
	'idClassLessons'=>'idClassLessons');



	function getPrimaryKey() {
		return $this->idClassLessonContent;
	}


	function setPrimaryKey($val) {
		$this->idClassLessonContent = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassLessonContentPeer::doInsert($this,$dsn));
		} else {
			ClassLessonContentPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_lesson_content='".$key."'";
		}
		$array = ClassLessonContentPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassLessonContentPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassLessonContentPeer::doDelete($this,$deep,$dsn);
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


class ClassLessonContentPeerBase {

	var $tableName = 'class_lesson_content';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_lesson_content",$where);
		$st->fields['id_class_lesson_content'] = 'id_class_lesson_content';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['id_class_lessons'] = 'id_class_lessons';
		$st->fields['txTitle'] = 'txTitle';
		$st->fields['txText'] = 'txText';
		$st->fields['dateCreated'] = 'dateCreated';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassLessonContentPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_lesson_content");
		$st->fields['id_class_lesson_content'] = $this->idClassLessonContent;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['id_class_lessons'] = $this->idClassLessons;
		$st->fields['txTitle'] = $this->txTitle;
		$st->fields['txText'] = $this->txText;
		$st->fields['dateCreated'] = $this->dateCreated;

		$st->nulls['id_class_lessons'] = 'id_class_lessons';

		$st->key = 'id_class_lesson_content';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_lesson_content");
		$st->fields['id_class_lesson_content'] = $obj->idClassLessonContent;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['id_class_lessons'] = $obj->idClassLessons;
		$st->fields['txTitle'] = $obj->txTitle;
		$st->fields['txText'] = $obj->txText;
		$st->fields['dateCreated'] = $obj->dateCreated;

		$st->nulls['id_class_lessons'] = 'id_class_lessons';

		$st->key = 'id_class_lesson_content';
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
		$st = new PBDO_DeleteStatement("class_lesson_content","id_class_lesson_content = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassLessonContent();
		$x->idClassLessonContent = $row['id_class_lesson_content'];
		$x->idClasses = $row['id_classes'];
		$x->idClassLessons = $row['id_class_lessons'];
		$x->txTitle = $row['txTitle'];
		$x->txText = $row['txText'];
		$x->dateCreated = $row['dateCreated'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassLessonContent extends ClassLessonContentBase {



}



class ClassLessonContentPeer extends ClassLessonContentPeerBase {

}

?>