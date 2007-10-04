<?

class ClassGradebookEntriesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idClassGradebookEntries;
	var $idClasses;
	var $idClassGradebookCategories;
	var $title;
	var $gradebookCode;
	var $totalPoints;
	var $publishFlag;
	var $notes;
	var $classLessonSequenceId;

	var $__attributes = array( 
	'idClassGradebookEntries'=>'integer',
	'idClasses'=>'integer',
	'idClassGradebookCategories'=>'integer',
	'title'=>'varchar',
	'gradebookCode'=>'varchar',
	'totalPoints'=>'float',
	'publishFlag'=>'tinyint',
	'notes'=>'longvarchar',
	'classLessonSequenceId'=>'integer');

	var $__nulls = array( 
	'notes'=>'notes');



	function getPrimaryKey() {
		return $this->idClassGradebookEntries;
	}


	function setPrimaryKey($val) {
		$this->idClassGradebookEntries = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassGradebookEntriesPeer::doInsert($this,$dsn));
		} else {
			ClassGradebookEntriesPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		$where = '';
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_gradebook_entries='".$key."'";
		}
		$array = ClassGradebookEntriesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassGradebookEntriesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassGradebookEntriesPeer::doDelete($this,$deep,$dsn);
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


class ClassGradebookEntriesPeerBase {

	var $tableName = 'class_gradebook_entries';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_gradebook_entries",$where);
		$st->fields['id_class_gradebook_entries'] = 'id_class_gradebook_entries';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['id_class_gradebook_categories'] = 'id_class_gradebook_categories';
		$st->fields['title'] = 'title';
		$st->fields['gradebook_code'] = 'gradebook_code';
		$st->fields['total_points'] = 'total_points';
		$st->fields['publish_flag'] = 'publish_flag';
		$st->fields['notes'] = 'notes';
		$st->fields['class_lesson_sequence_id'] = 'class_lesson_sequence_id';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassGradebookEntriesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_gradebook_entries");
		$st->fields['id_class_gradebook_entries'] = $this->idClassGradebookEntries;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['id_class_gradebook_categories'] = $this->idClassGradebookCategories;
		$st->fields['title'] = $this->title;
		$st->fields['gradebook_code'] = $this->gradebookCode;
		$st->fields['total_points'] = $this->totalPoints;
		$st->fields['publish_flag'] = $this->publishFlag;
		$st->fields['notes'] = $this->notes;
		$st->fields['class_lesson_sequence_id'] = $this->classLessonSequenceId;

		$st->nulls['notes'] = 'notes';

		$st->key = 'id_class_gradebook_entries';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_gradebook_entries");
		$st->fields['id_class_gradebook_entries'] = $obj->idClassGradebookEntries;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['id_class_gradebook_categories'] = $obj->idClassGradebookCategories;
		$st->fields['title'] = $obj->title;
		$st->fields['gradebook_code'] = $obj->gradebookCode;
		$st->fields['total_points'] = $obj->totalPoints;
		$st->fields['publish_flag'] = $obj->publishFlag;
		$st->fields['notes'] = $obj->notes;
		$st->fields['class_lesson_sequence_id'] = $obj->classLessonSequenceId;

		$st->nulls['notes'] = 'notes';

		$st->key = 'id_class_gradebook_entries';
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
		$st = new PBDO_DeleteStatement("class_gradebook_entries","id_class_gradebook_entries = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassGradebookEntries();
		$x->idClassGradebookEntries = $row['id_class_gradebook_entries'];
		$x->idClasses = $row['id_classes'];
		$x->idClassGradebookCategories = $row['id_class_gradebook_categories'];
		$x->title = $row['title'];
		$x->gradebookCode = $row['gradebook_code'];
		$x->totalPoints = $row['total_points'];
		$x->publishFlag = $row['publish_flag'];
		$x->notes = $row['notes'];
		$x->classLessonSequenceId = $row['class_lesson_sequence_id'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassGradebookEntries extends ClassGradebookEntriesBase {

	/**
	 * Update associated assignments if neccessary
	 */
	function updateAssignmentGradeForStudent($val,$id_student) {
		if ( $this->assignmentId < 1) {
			//we're not tied to an assignment
			return false;
		}

		if ( strlen($id_student) < 1) {
			//something is wrong
			// can't guarantee atomic updates
			return false;
		}

		$db = DB::getHandle();
		$db->query("UPDATE class_assignments_grades
			SET grade = '".$val->score."',
			comments = '".addslashes($val->comments)."'
			WHERE id_class_assignments = '".$this->assignmentId."'
			AND id_student = '".$id_student."'");


		if (! $db->getNumRows() ) {
			$db->query("INSERT INTO class_assignments_grades
			(comments,grade,id_class_assignments,id_student)
			VALUES ('".addslashes($val->comments)."',
				".$val->score.",
				".$this->assignmentId.",
				'".$id_student."')");
		}

		return true;
	}


}



class ClassGradebookEntriesPeer extends ClassGradebookEntriesPeerBase {

}

?>
