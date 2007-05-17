<?

class CoursesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idCourses;
	var $courseFamily;
	var $courseNumber;
	var $courseName;
	var $courseDescription;
	var $preReq1;
	var $preReq2;
	var $preReq3;
	var $preReq4;
	var $coReq1;
	var $coReq2;
	var $coReq3;
	var $coReq4;

	var $__attributes = array( 
	'idCourses'=>'integer',
	'courseFamily'=>'varchar',
	'courseNumber'=>'integer',
	'courseName'=>'varchar',
	'courseDescription'=>'longvarchar',
	'preReq1'=>'varchar',
	'preReq2'=>'varchar',
	'preReq3'=>'varchar',
	'preReq4'=>'varchar',
	'coReq1'=>'varchar',
	'coReq2'=>'varchar',
	'coReq3'=>'varchar',
	'coReq4'=>'varchar');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->idCourses;
	}


	function setPrimaryKey($val) {
		$this->idCourses = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(CoursesPeer::doInsert($this,$dsn));
		} else {
			CoursesPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_courses='".$key."'";
		}
		$array = CoursesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = CoursesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		CoursesPeer::doDelete($this,$deep,$dsn);
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


class CoursesPeerBase {

	var $tableName = 'courses';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("courses",$where);
		$st->fields['id_courses'] = 'id_courses';
		$st->fields['courseFamily'] = 'courseFamily';
		$st->fields['courseNumber'] = 'courseNumber';
		$st->fields['courseName'] = 'courseName';
		$st->fields['courseDescription'] = 'courseDescription';
		$st->fields['preReq1'] = 'preReq1';
		$st->fields['preReq2'] = 'preReq2';
		$st->fields['preReq3'] = 'preReq3';
		$st->fields['preReq4'] = 'preReq4';
		$st->fields['coReq1'] = 'coReq1';
		$st->fields['coReq2'] = 'coReq2';
		$st->fields['coReq3'] = 'coReq3';
		$st->fields['coReq4'] = 'coReq4';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = CoursesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("courses");
		$st->fields['id_courses'] = $this->idCourses;
		$st->fields['courseFamily'] = $this->courseFamily;
		$st->fields['courseNumber'] = $this->courseNumber;
		$st->fields['courseName'] = $this->courseName;
		$st->fields['courseDescription'] = $this->courseDescription;
		$st->fields['preReq1'] = $this->preReq1;
		$st->fields['preReq2'] = $this->preReq2;
		$st->fields['preReq3'] = $this->preReq3;
		$st->fields['preReq4'] = $this->preReq4;
		$st->fields['coReq1'] = $this->coReq1;
		$st->fields['coReq2'] = $this->coReq2;
		$st->fields['coReq3'] = $this->coReq3;
		$st->fields['coReq4'] = $this->coReq4;


		$st->key = 'id_courses';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("courses");
		$st->fields['id_courses'] = $obj->idCourses;
		$st->fields['courseFamily'] = $obj->courseFamily;
		$st->fields['courseNumber'] = $obj->courseNumber;
		$st->fields['courseName'] = $obj->courseName;
		$st->fields['courseDescription'] = $obj->courseDescription;
		$st->fields['preReq1'] = $obj->preReq1;
		$st->fields['preReq2'] = $obj->preReq2;
		$st->fields['preReq3'] = $obj->preReq3;
		$st->fields['preReq4'] = $obj->preReq4;
		$st->fields['coReq1'] = $obj->coReq1;
		$st->fields['coReq2'] = $obj->coReq2;
		$st->fields['coReq3'] = $obj->coReq3;
		$st->fields['coReq4'] = $obj->coReq4;


		$st->key = 'id_courses';
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
		$st = new PBDO_DeleteStatement("courses","id_courses = '".$obj->getPrimaryKey()."'");

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
		$x = new Courses();
		$x->idCourses = $row['id_courses'];
		$x->courseFamily = $row['courseFamily'];
		$x->courseNumber = $row['courseNumber'];
		$x->courseName = $row['courseName'];
		$x->courseDescription = $row['courseDescription'];
		$x->preReq1 = $row['preReq1'];
		$x->preReq2 = $row['preReq2'];
		$x->preReq3 = $row['preReq3'];
		$x->preReq4 = $row['preReq4'];
		$x->coReq1 = $row['coReq1'];
		$x->coReq2 = $row['coReq2'];
		$x->coReq3 = $row['coReq3'];
		$x->coReq4 = $row['coReq4'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class Courses extends CoursesBase {



}



class CoursesPeer extends CoursesPeerBase {

}

?>