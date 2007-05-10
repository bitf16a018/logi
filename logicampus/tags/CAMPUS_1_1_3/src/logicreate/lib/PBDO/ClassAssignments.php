<?

class ClassAssignmentsBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.4';	//PBDO version number
	var $_entityVersion = '0.0';	//Source version number
	var $idClassAssignments;
	var $title;
	var $instructions;
	var $dueDate;
	var $noDueDate;
	var $activeDate;
	var $responseType;
	var $idClasses;
	var $dateNoAccept;
	var $idForum;
	var $idForumThread;

	var $__attributes = array(
	'idClassAssignments'=>'int',
	'title'=>'varchar',
	'instructions'=>'text',
	'dueDate'=>'int',
	'noDueDate'=>'tinyint',
	'activeDate'=>'int',
	'responseType'=>'tinyint',
	'idClasses'=>'int',
	'dateNoAccept'=>'datetime',
	'idForum'=>'int',
	'idForumThread'=>'int');



	function getPrimaryKey() {
		return $this->idClassAssignments;
	}

	function setPrimaryKey($val) {
		$this->idClassAssignments = $val;
	}
	
	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassAssignmentsPeer::doInsert($this,$dsn));
		} else {
			ClassAssignmentsPeer::doUpdate($this,$dsn);
		}
	}

	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_assignments='".$key."'";
		}
		$array = ClassAssignmentsPeer::doSelect($where,$dsn);
		return $array[0];
	}

	function delete($deep=false,$dsn="default") {
		ClassAssignmentsPeer::doDelete($this,$deep,$dsn);
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
		if ($array['title'])
			$this->title = $array['title'];
		if ($array['instructions'])
			$this->instructions = $array['instructions'];
		if ($array['dueDate'])
			$this->dueDate = $array['dueDate'];
		if ($array['noDueDate'])
			$this->noDueDate = $array['noDueDate'];
		if ($array['activeDate'])
			$this->activeDate = $array['activeDate'];
		if ($array['responseType'])
			$this->responseType = $array['responseType'];
		if ($array['idClasses'])
			$this->idClasses = $array['idClasses'];
		if ($array['dateNoAccept'])
			$this->dateNoAccept = $array['dateNoAccept'];
		if ($array['idForum'])
			$this->idForum = $array['idForum'];
		if ($array['idForumThread'])
			$this->idForumThread = $array['idForumThread'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class ClassAssignmentsPeerBase {

	var $tableName = 'class_assignments';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_SelectStatement("class_assignments",$where);
		$st->fields['id_class_assignments'] = 'id_class_assignments';
		$st->fields['title'] = 'title';
		$st->fields['instructions'] = 'instructions';
		$st->fields['dueDate'] = 'dueDate';
		$st->fields['noDueDate'] = 'noDueDate';
		$st->fields['activeDate'] = 'activeDate';
		$st->fields['responseType'] = 'responseType';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['dateNoAccept'] = 'dateNoAccept';
		$st->fields['id_forum'] = 'id_forum';
		$st->fields['id_forum_thread'] = 'id_forum_thread';

		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassAssignmentsPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_InsertStatement("class_assignments");
		$st->fields['id_class_assignments'] = $this->idClassAssignments;
		$st->fields['title'] = $this->title;
		$st->fields['instructions'] = $this->instructions;
		$st->fields['dueDate'] = $this->dueDate;
		$st->fields['noDueDate'] = $this->noDueDate;
		$st->fields['activeDate'] = $this->activeDate;
		$st->fields['responseType'] = $this->responseType;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['dateNoAccept'] = $this->dateNoAccept;
		$st->fields['id_forum'] = $this->idForum;
		$st->fields['id_forum_thread'] = $this->idForumThread;

		$st->key = 'id_class_assignments';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_UpdateStatement("class_assignments");
		$st->fields['id_class_assignments'] = $obj->idClassAssignments;
		$st->fields['title'] = $obj->title;
		$st->fields['instructions'] = $obj->instructions;
		$st->fields['dueDate'] = $obj->dueDate;
		$st->fields['noDueDate'] = $obj->noDueDate;
		$st->fields['activeDate'] = $obj->activeDate;
		$st->fields['responseType'] = $obj->responseType;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['dateNoAccept'] = $obj->dateNoAccept;
		$st->fields['id_forum'] = $obj->idForum;
		$st->fields['id_forum_thread'] = $obj->idForumThread;

		$st->key = 'id_class_assignments';
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
		$st = new LC_DeleteStatement("class_assignments","id_class_assignments = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( $deep ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new ClassAssignments();
		$x->idClassAssignments = $row['id_class_assignments'];
		$x->title = $row['title'];
		$x->instructions = $row['instructions'];
		$x->dueDate = $row['dueDate'];
		$x->noDueDate = $row['noDueDate'];
		$x->activeDate = $row['activeDate'];
		$x->responseType = $row['responseType'];
		$x->idClasses = $row['id_classes'];
		$x->dateNoAccept = $row['dateNoAccept'];
		$x->idForum = $row['id_forum'];
		$x->idForumThread = $row['id_forum_thread'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassAssignments extends ClassAssignmentsBase {



}



class ClassAssignmentsPeer extends ClassAssignmentsPeerBase {

}

?>