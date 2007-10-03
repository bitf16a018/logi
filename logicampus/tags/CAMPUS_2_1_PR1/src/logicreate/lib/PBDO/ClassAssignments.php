<?

class ClassAssignmentsBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
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
	'idClassAssignments'=>'integer',
	'title'=>'varchar',
	'instructions'=>'longvarchar',
	'dueDate'=>'integer',
	'noDueDate'=>'tinyint',
	'activeDate'=>'integer',
	'responseType'=>'tinyint',
	'idClasses'=>'integer',
	'dateNoAccept'=>'datetime',
	'idForum'=>'integer',
	'idForumThread'=>'integer');

	var $__nulls = array();



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


	function loadAll($dsn="default") {
		$array = ClassAssignmentsPeer::doSelect('',$dsn);
		return $array;
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


class ClassAssignmentsPeerBase {

	var $tableName = 'class_assignments';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_assignments",$where);
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


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassAssignmentsPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_assignments");
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
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_assignments");
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
		$st = new PBDO_DeleteStatement("class_assignments","id_class_assignments = '".$obj->getPrimaryKey()."'");

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