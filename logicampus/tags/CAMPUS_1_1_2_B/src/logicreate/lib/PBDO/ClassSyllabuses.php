<?

class ClassSyllabusesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.4';	//PBDO version number
	var $_entityVersion = '0.0';	//Source version number
	var $idClassSyllabuses;
	var $idClasses;
	var $other;
	var $courseObjectives;
	var $courseReqs;
	var $gradingScale;
	var $instructionMethods;
	var $emailPolicy;
	var $noExam;

	var $__attributes = array(
	'idClassSyllabuses'=>'int',
	'idClasses'=>'int',
	'other'=>'text',
	'courseObjectives'=>'text',
	'courseReqs'=>'text',
	'gradingScale'=>'text',
	'instructionMethods'=>'text',
	'emailPolicy'=>'text',
	'noExam'=>'text');



	function getPrimaryKey() {
		return $this->idClassSyllabuses;
	}

	function setPrimaryKey($val) {
		$this->idClassSyllabuses = $val;
	}
	
	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassSyllabusesPeer::doInsert($this,$dsn));
		} else {
			ClassSyllabusesPeer::doUpdate($this,$dsn);
		}
	}

	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_syllabuses='".$key."'";
		}
		$array = ClassSyllabusesPeer::doSelect($where,$dsn);
		return $array[0];
	}

	function delete($deep=false,$dsn="default") {
		ClassSyllabusesPeer::doDelete($this,$deep,$dsn);
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
		if ($array['idClasses'])
			$this->idClasses = $array['idClasses'];
		if ($array['other'])
			$this->other = $array['other'];
		if ($array['courseObjectives'])
			$this->courseObjectives = $array['courseObjectives'];
		if ($array['courseReqs'])
			$this->courseReqs = $array['courseReqs'];
		if ($array['gradingScale'])
			$this->gradingScale = $array['gradingScale'];
		if ($array['instructionMethods'])
			$this->instructionMethods = $array['instructionMethods'];
		if ($array['emailPolicy'])
			$this->emailPolicy = $array['emailPolicy'];
		if ($array['noExam'])
			$this->noExam = $array['noExam'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class ClassSyllabusesPeerBase {

	var $tableName = 'class_syllabuses';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_SelectStatement("class_syllabuses",$where);
		$st->fields['id_class_syllabuses'] = 'id_class_syllabuses';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['other'] = 'other';
		$st->fields['courseObjectives'] = 'courseObjectives';
		$st->fields['courseReqs'] = 'courseReqs';
		$st->fields['gradingScale'] = 'gradingScale';
		$st->fields['instructionMethods'] = 'instructionMethods';
		$st->fields['emailPolicy'] = 'emailPolicy';
		$st->fields['noExam'] = 'noExam';

		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassSyllabusesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_InsertStatement("class_syllabuses");
		$st->fields['id_class_syllabuses'] = $this->idClassSyllabuses;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['other'] = $this->other;
		$st->fields['courseObjectives'] = $this->courseObjectives;
		$st->fields['courseReqs'] = $this->courseReqs;
		$st->fields['gradingScale'] = $this->gradingScale;
		$st->fields['instructionMethods'] = $this->instructionMethods;
		$st->fields['emailPolicy'] = $this->emailPolicy;
		$st->fields['noExam'] = $this->noExam;

		$st->key = 'id_class_syllabuses';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_UpdateStatement("class_syllabuses");
		$st->fields['id_class_syllabuses'] = $obj->idClassSyllabuses;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['other'] = $obj->other;
		$st->fields['courseObjectives'] = $obj->courseObjectives;
		$st->fields['courseReqs'] = $obj->courseReqs;
		$st->fields['gradingScale'] = $obj->gradingScale;
		$st->fields['instructionMethods'] = $obj->instructionMethods;
		$st->fields['emailPolicy'] = $obj->emailPolicy;
		$st->fields['noExam'] = $obj->noExam;

		$st->key = 'id_class_syllabuses';
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
		$st = new LC_DeleteStatement("class_syllabuses","id_class_syllabuses = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( $deep ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new ClassSyllabuses();
		$x->idClassSyllabuses = $row['id_class_syllabuses'];
		$x->idClasses = $row['id_classes'];
		$x->other = $row['other'];
		$x->courseObjectives = $row['courseObjectives'];
		$x->courseReqs = $row['courseReqs'];
		$x->gradingScale = $row['gradingScale'];
		$x->instructionMethods = $row['instructionMethods'];
		$x->emailPolicy = $row['emailPolicy'];
		$x->noExam = $row['noExam'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassSyllabuses extends ClassSyllabusesBase {



}



class ClassSyllabusesPeer extends ClassSyllabusesPeerBase {

}

?>