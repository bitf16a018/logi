<?

class ClassExtraFacultyBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $pkey;
	var $idClasses;
	var $facultyId;
	var $facultyType;

	var $__attributes = array( 
	'pkey'=>'integer',
	'idClasses'=>'integer',
	'facultyId'=>'varchar',
	'facultyType'=>'char');

	var $__nulls = array( 
	'idClasses'=>'idClasses',
	'facultyId'=>'facultyId',
	'facultyType'=>'facultyType');



	function getPrimaryKey() {
		return $this->pkey;
	}


	function setPrimaryKey($val) {
		$this->pkey = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassExtraFacultyPeer::doInsert($this,$dsn));
		} else {
			ClassExtraFacultyPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "pkey='".$key."'";
		}
		$array = ClassExtraFacultyPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassExtraFacultyPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassExtraFacultyPeer::doDelete($this,$deep,$dsn);
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


class ClassExtraFacultyPeerBase {

	var $tableName = 'class_extra_faculty';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_extra_faculty",$where);
		$st->fields['pkey'] = 'pkey';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['facultyId'] = 'facultyId';
		$st->fields['facultyType'] = 'facultyType';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassExtraFacultyPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_extra_faculty");
		$st->fields['pkey'] = $this->pkey;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['facultyId'] = $this->facultyId;
		$st->fields['facultyType'] = $this->facultyType;

		$st->nulls['id_classes'] = 'id_classes';
		$st->nulls['facultyId'] = 'facultyId';
		$st->nulls['facultyType'] = 'facultyType';

		$st->key = 'pkey';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_extra_faculty");
		$st->fields['pkey'] = $obj->pkey;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['facultyId'] = $obj->facultyId;
		$st->fields['facultyType'] = $obj->facultyType;

		$st->nulls['id_classes'] = 'id_classes';
		$st->nulls['facultyId'] = 'facultyId';
		$st->nulls['facultyType'] = 'facultyType';

		$st->key = 'pkey';
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
		$st = new PBDO_DeleteStatement("class_extra_faculty","pkey = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassExtraFaculty();
		$x->pkey = $row['pkey'];
		$x->idClasses = $row['id_classes'];
		$x->facultyId = $row['facultyId'];
		$x->facultyType = $row['facultyType'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassExtraFaculty extends ClassExtraFacultyBase {



}



class ClassExtraFacultyPeer extends ClassExtraFacultyPeerBase {

}

?>