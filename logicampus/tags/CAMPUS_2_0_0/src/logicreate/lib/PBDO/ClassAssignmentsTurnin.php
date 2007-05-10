<?

class ClassAssignmentsTurninBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idClassAssignmentsTurnin;
	var $idClassAssignments;
	var $idStudent;
	var $dateTurnin;
	var $assignType;
	var $assignText;
	var $assignFileMime;
	var $assignFileName;
	var $assignFileSize;
	var $assignFileBlob;

	var $__attributes = array( 
	'idClassAssignmentsTurnin'=>'integer',
	'idClassAssignments'=>'integer',
	'idStudent'=>'varchar',
	'dateTurnin'=>'datetime',
	'assignType'=>'integer',
	'assignText'=>'longtext',
	'assignFileMime'=>'varchar',
	'assignFileName'=>'varchar',
	'assignFileSize'=>'integer',
	'assignFileBlob'=>'longblob');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->idClassAssignmentsTurnin;
	}


	function setPrimaryKey($val) {
		$this->idClassAssignmentsTurnin = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassAssignmentsTurninPeer::doInsert($this,$dsn));
		} else {
			ClassAssignmentsTurninPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_assignments_turnin='".$key."'";
		}
		$array = ClassAssignmentsTurninPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassAssignmentsTurninPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassAssignmentsTurninPeer::doDelete($this,$deep,$dsn);
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


class ClassAssignmentsTurninPeerBase {

	var $tableName = 'class_assignments_turnin';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_assignments_turnin",$where);
		$st->fields['id_class_assignments_turnin'] = 'id_class_assignments_turnin';
		$st->fields['id_class_assignments'] = 'id_class_assignments';
		$st->fields['id_student'] = 'id_student';
		$st->fields['dateTurnin'] = 'dateTurnin';
		$st->fields['assign_type'] = 'assign_type';
		$st->fields['assign_text'] = 'assign_text';
		$st->fields['assign_file_mime'] = 'assign_file_mime';
		$st->fields['assign_file_name'] = 'assign_file_name';
		$st->fields['assign_file_size'] = 'assign_file_size';
		$st->fields['assign_file_blob'] = 'assign_file_blob';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassAssignmentsTurninPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_assignments_turnin");
		$st->fields['id_class_assignments_turnin'] = $this->idClassAssignmentsTurnin;
		$st->fields['id_class_assignments'] = $this->idClassAssignments;
		$st->fields['id_student'] = $this->idStudent;
		$st->fields['dateTurnin'] = $this->dateTurnin;
		$st->fields['assign_type'] = $this->assignType;
		$st->fields['assign_text'] = $this->assignText;
		$st->fields['assign_file_mime'] = $this->assignFileMime;
		$st->fields['assign_file_name'] = $this->assignFileName;
		$st->fields['assign_file_size'] = $this->assignFileSize;
		$st->fields['assign_file_blob'] = $this->assignFileBlob;


		$st->key = 'id_class_assignments_turnin';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_assignments_turnin");
		$st->fields['id_class_assignments_turnin'] = $obj->idClassAssignmentsTurnin;
		$st->fields['id_class_assignments'] = $obj->idClassAssignments;
		$st->fields['id_student'] = $obj->idStudent;
		$st->fields['dateTurnin'] = $obj->dateTurnin;
		$st->fields['assign_type'] = $obj->assignType;
		$st->fields['assign_text'] = $obj->assignText;
		$st->fields['assign_file_mime'] = $obj->assignFileMime;
		$st->fields['assign_file_name'] = $obj->assignFileName;
		$st->fields['assign_file_size'] = $obj->assignFileSize;
		$st->fields['assign_file_blob'] = $obj->assignFileBlob;


		$st->key = 'id_class_assignments_turnin';
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
		$st = new PBDO_DeleteStatement("class_assignments_turnin","id_class_assignments_turnin = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassAssignmentsTurnin();
		$x->idClassAssignmentsTurnin = $row['id_class_assignments_turnin'];
		$x->idClassAssignments = $row['id_class_assignments'];
		$x->idStudent = $row['id_student'];
		$x->dateTurnin = $row['dateTurnin'];
		$x->assignType = $row['assign_type'];
		$x->assignText = $row['assign_text'];
		$x->assignFileMime = $row['assign_file_mime'];
		$x->assignFileName = $row['assign_file_name'];
		$x->assignFileSize = $row['assign_file_size'];
		$x->assignFileBlob = $row['assign_file_blob'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassAssignmentsTurnin extends ClassAssignmentsTurninBase {



}



class ClassAssignmentsTurninPeer extends ClassAssignmentsTurninPeerBase {

}

?>