<?

class ClassAssignmentsGradesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idClassAssignmentsGrades;
	var $idClassAssignments;
	var $idStudent;
	var $comments;
	var $grade;

	var $__attributes = array( 
	'idClassAssignmentsGrades'=>'integer',
	'idClassAssignments'=>'integer',
	'idStudent'=>'varchar',
	'comments'=>'longvarchar',
	'grade'=>'float');

	var $__nulls = array( 
	'grade'=>'grade');



	function getPrimaryKey() {
		return $this->idClassAssignmentsGrades;
	}


	function setPrimaryKey($val) {
		$this->idClassAssignmentsGrades = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassAssignmentsGradesPeer::doInsert($this,$dsn));
		} else {
			ClassAssignmentsGradesPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_assignments_grades='".$key."'";
		}
		$array = ClassAssignmentsGradesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassAssignmentsGradesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassAssignmentsGradesPeer::doDelete($this,$deep,$dsn);
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


class ClassAssignmentsGradesPeerBase {

	var $tableName = 'class_assignments_grades';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_assignments_grades",$where);
		$st->fields['id_class_assignments_grades'] = 'id_class_assignments_grades';
		$st->fields['id_class_assignments'] = 'id_class_assignments';
		$st->fields['id_student'] = 'id_student';
		$st->fields['comments'] = 'comments';
		$st->fields['grade'] = 'grade';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassAssignmentsGradesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_assignments_grades");
		$st->fields['id_class_assignments_grades'] = $this->idClassAssignmentsGrades;
		$st->fields['id_class_assignments'] = $this->idClassAssignments;
		$st->fields['id_student'] = $this->idStudent;
		$st->fields['comments'] = $this->comments;
		$st->fields['grade'] = $this->grade;

		$st->nulls['grade'] = 'grade';

		$st->key = 'id_class_assignments_grades';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_assignments_grades");
		$st->fields['id_class_assignments_grades'] = $obj->idClassAssignmentsGrades;
		$st->fields['id_class_assignments'] = $obj->idClassAssignments;
		$st->fields['id_student'] = $obj->idStudent;
		$st->fields['comments'] = $obj->comments;
		$st->fields['grade'] = $obj->grade;

		$st->nulls['grade'] = 'grade';

		$st->key = 'id_class_assignments_grades';
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
		$st = new PBDO_DeleteStatement("class_assignments_grades","id_class_assignments_grades = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassAssignmentsGrades();
		$x->idClassAssignmentsGrades = $row['id_class_assignments_grades'];
		$x->idClassAssignments = $row['id_class_assignments'];
		$x->idStudent = $row['id_student'];
		$x->comments = $row['comments'];
		$x->grade = $row['grade'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassAssignmentsGrades extends ClassAssignmentsGradesBase {



}



class ClassAssignmentsGradesPeer extends ClassAssignmentsGradesPeerBase {

}

?>