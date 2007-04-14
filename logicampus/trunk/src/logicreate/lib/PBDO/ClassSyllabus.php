<?

class ClassSyllabusBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idClassSyllabus;
	var $idClasses;
	var $sectionTitle;
	var $sectionContent;

	var $__attributes = array( 
	'idClassSyllabus'=>'integer',
	'idClasses'=>'integer',
	'sectionTitle'=>'varchar',
	'sectionContent'=>'longvarchar');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->idClassSyllabus;
	}


	function setPrimaryKey($val) {
		$this->idClassSyllabus = $val;
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
			$where = "id_class_syllabus='".$key."'";
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
		$st->fields['id_class_syllabus'] = 'id_class_syllabus';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['section_title'] = 'section_title';
		$st->fields['section_content'] = 'section_content';


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
		$st->fields['id_class_syllabus'] = $this->idClassSyllabus;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['section_title'] = $this->sectionTitle;
		$st->fields['section_content'] = $this->sectionContent;


		$st->key = 'id_class_syllabus';
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
		$st->fields['id_class_syllabus'] = $obj->idClassSyllabus;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['section_title'] = $obj->sectionTitle;
		$st->fields['section_content'] = $obj->sectionContent;


		$st->key = 'id_class_syllabus';
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
		$st = new PBDO_DeleteStatement("class_syllabus","id_class_syllabus = '".$obj->getPrimaryKey()."'");

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
		$x->idClassSyllabus = $row['id_class_syllabus'];
		$x->idClasses = $row['id_classes'];
		$x->sectionTitle = $row['section_title'];
		$x->sectionContent = $row['section_content'];

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