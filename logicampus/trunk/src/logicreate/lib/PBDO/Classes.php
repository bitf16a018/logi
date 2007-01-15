<?

class ClassesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idClasses;
	var $idCourses;
	var $idSemesters;
	var $sectionNumbers;
	var $classType;
	var $facultyId;
	var $courseFamily;
	var $courseNumber;
	var $courseFamilyNumber;
	var $stylesheet;
	var $idClassResource;
	var $noexam;

	var $__attributes = array( 
	'idClasses'=>'integer',
	'idCourses'=>'integer',
	'idSemesters'=>'integer',
	'sectionNumbers'=>'longvarchar',
	'classType'=>'varchar',
	'facultyId'=>'varchar',
	'courseFamily'=>'varchar',
	'courseNumber'=>'integer',
	'courseFamilyNumber'=>'varchar',
	'stylesheet'=>'varchar',
	'idClassResource'=>'integer',
	'noexam'=>'tinyint');

	var $__nulls = array( 
	'noexam'=>'noexam');



	function getPrimaryKey() {
		return $this->idClasses;
	}


	function setPrimaryKey($val) {
		$this->idClasses = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassesPeer::doInsert($this,$dsn));
		} else {
			ClassesPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_classes='".$key."'";
		}
		$array = ClassesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassesPeer::doDelete($this,$deep,$dsn);
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


class ClassesPeerBase {

	var $tableName = 'classes';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("classes",$where);
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['id_courses'] = 'id_courses';
		$st->fields['id_semesters'] = 'id_semesters';
		$st->fields['sectionNumbers'] = 'sectionNumbers';
		$st->fields['classType'] = 'classType';
		$st->fields['facultyId'] = 'facultyId';
		$st->fields['courseFamily'] = 'courseFamily';
		$st->fields['courseNumber'] = 'courseNumber';
		$st->fields['courseFamilyNumber'] = 'courseFamilyNumber';
		$st->fields['stylesheet'] = 'stylesheet';
		$st->fields['id_class_resource'] = 'id_class_resource';
		$st->fields['noexam'] = 'noexam';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("classes");
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['id_courses'] = $this->idCourses;
		$st->fields['id_semesters'] = $this->idSemesters;
		$st->fields['sectionNumbers'] = $this->sectionNumbers;
		$st->fields['classType'] = $this->classType;
		$st->fields['facultyId'] = $this->facultyId;
		$st->fields['courseFamily'] = $this->courseFamily;
		$st->fields['courseNumber'] = $this->courseNumber;
		$st->fields['courseFamilyNumber'] = $this->courseFamilyNumber;
		$st->fields['stylesheet'] = $this->stylesheet;
		$st->fields['id_class_resource'] = $this->idClassResource;
		$st->fields['noexam'] = $this->noexam;

		$st->nulls['noexam'] = 'noexam';

		$st->key = 'id_classes';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("classes");
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['id_courses'] = $obj->idCourses;
		$st->fields['id_semesters'] = $obj->idSemesters;
		$st->fields['sectionNumbers'] = $obj->sectionNumbers;
		$st->fields['classType'] = $obj->classType;
		$st->fields['facultyId'] = $obj->facultyId;
		$st->fields['courseFamily'] = $obj->courseFamily;
		$st->fields['courseNumber'] = $obj->courseNumber;
		$st->fields['courseFamilyNumber'] = $obj->courseFamilyNumber;
		$st->fields['stylesheet'] = $obj->stylesheet;
		$st->fields['id_class_resource'] = $obj->idClassResource;
		$st->fields['noexam'] = $obj->noexam;

		$st->nulls['noexam'] = 'noexam';

		$st->key = 'id_classes';
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
		$st = new PBDO_DeleteStatement("classes","id_classes = '".$obj->getPrimaryKey()."'");

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
		$x = new Classes();
		$x->idClasses = $row['id_classes'];
		$x->idCourses = $row['id_courses'];
		$x->idSemesters = $row['id_semesters'];
		$x->sectionNumbers = $row['sectionNumbers'];
		$x->classType = $row['classType'];
		$x->facultyId = $row['facultyId'];
		$x->courseFamily = $row['courseFamily'];
		$x->courseNumber = $row['courseNumber'];
		$x->courseFamilyNumber = $row['courseFamilyNumber'];
		$x->stylesheet = $row['stylesheet'];
		$x->idClassResource = $row['id_class_resource'];
		$x->noexam = $row['noexam'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class Classes extends ClassesBase {



}



class ClassesPeer extends ClassesPeerBase {

}

?>