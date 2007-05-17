<?

class ClassStudentSectionsBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $sectionNumber;
	var $idStudent;
	var $semesterId;
	var $active;

	var $__attributes = array( 
	'sectionNumber'=>'integer',
	'idStudent'=>'varchar',
	'semesterId'=>'integer',
	'active'=>'tinyint');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->semesterId;
	}


	function setPrimaryKey($val) {
		$this->semesterId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassStudentSectionsPeer::doInsert($this,$dsn));
		} else {
			ClassStudentSectionsPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "semester_id='".$key."'";
		}
		$array = ClassStudentSectionsPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassStudentSectionsPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassStudentSectionsPeer::doDelete($this,$deep,$dsn);
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


class ClassStudentSectionsPeerBase {

	var $tableName = 'class_student_sections';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_student_sections",$where);
		$st->fields['sectionNumber'] = 'sectionNumber';
		$st->fields['id_student'] = 'id_student';
		$st->fields['semester_id'] = 'semester_id';
		$st->fields['active'] = 'active';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassStudentSectionsPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_student_sections");
		$st->fields['sectionNumber'] = $this->sectionNumber;
		$st->fields['id_student'] = $this->idStudent;
		$st->fields['semester_id'] = $this->semesterId;
		$st->fields['active'] = $this->active;


		$st->key = 'semester_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_student_sections");
		$st->fields['sectionNumber'] = $obj->sectionNumber;
		$st->fields['id_student'] = $obj->idStudent;
		$st->fields['semester_id'] = $obj->semesterId;
		$st->fields['active'] = $obj->active;


		$st->key = 'semester_id';
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
		$st = new PBDO_DeleteStatement("class_student_sections","semester_id = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassStudentSections();
		$x->sectionNumber = $row['sectionNumber'];
		$x->idStudent = $row['id_student'];
		$x->semesterId = $row['semester_id'];
		$x->active = $row['active'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassStudentSections extends ClassStudentSectionsBase {



}



class ClassStudentSectionsPeer extends ClassStudentSectionsPeerBase {

}

?>