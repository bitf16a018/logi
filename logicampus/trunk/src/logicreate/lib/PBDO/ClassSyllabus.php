<?

class ClassSyllabusBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $classSyllabusId;
	var $classId;
	var $sectionTitle;
	var $sectionContent;
	var $rank;

	var $__attributes = array( 
	'classSyllabusId'=>'integer',
	'classId'=>'integer',
	'sectionTitle'=>'varchar',
	'sectionContent'=>'longvarchar',
	'rank'=>'integer');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->classSyllabusId;
	}


	function setPrimaryKey($val) {
		$this->classSyllabusId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassSyllabusPeer::doInsert($this,$dsn));
		} else {
			ClassSyllabusPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "class_syllabus_id='".$key."'";
		}
		$array = ClassSyllabusPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassSyllabusPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassSyllabusPeer::doDelete($this,$deep,$dsn);
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


class ClassSyllabusPeerBase {

	var $tableName = 'class_syllabus';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_syllabus",$where);
		$st->fields['class_syllabus_id'] = 'class_syllabus_id';
		$st->fields['class_id'] = 'class_id';
		$st->fields['section_title'] = 'section_title';
		$st->fields['section_content'] = 'section_content';
		$st->fields['rank'] = 'rank';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassSyllabusPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_syllabus");
		$st->fields['class_syllabus_id'] = $this->classSyllabusId;
		$st->fields['class_id'] = $this->classId;
		$st->fields['section_title'] = $this->sectionTitle;
		$st->fields['section_content'] = $this->sectionContent;
		$st->fields['rank'] = $this->rank;


		$st->key = 'class_syllabus_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_syllabus");
		$st->fields['class_syllabus_id'] = $obj->classSyllabusId;
		$st->fields['class_id'] = $obj->classId;
		$st->fields['section_title'] = $obj->sectionTitle;
		$st->fields['section_content'] = $obj->sectionContent;
		$st->fields['rank'] = $obj->rank;


		$st->key = 'class_syllabus_id';
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
		$st = new PBDO_DeleteStatement("class_syllabus","class_syllabus_id = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassSyllabus();
		$x->classSyllabusId = $row['class_syllabus_id'];
		$x->classId = $row['class_id'];
		$x->sectionTitle = $row['section_title'];
		$x->sectionContent = $row['section_content'];
		$x->rank = $row['rank'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassSyllabus extends ClassSyllabusBase {



}



class ClassSyllabusPeer extends ClassSyllabusPeerBase {

}

?>