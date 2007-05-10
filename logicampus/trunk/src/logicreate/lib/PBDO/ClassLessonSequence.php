<?

class ClassLessonSequenceBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $classLessonSequenceId;
	var $lessonId;
	var $classId;
	var $lobId;
	var $lobMime;
	var $lobType;
	var $lobTitle;
	var $visible;
	var $notBeforeSeqId;
	var $allowAfterDays;
	var $allowOn;
	var $rank;

	var $__attributes = array( 
	'classLessonSequenceId'=>'integer',
	'lessonId'=>'integer',
	'classId'=>'integer',
	'lobId'=>'integer',
	'lobMime'=>'varchar',
	'lobType'=>'varchar',
	'lobTitle'=>'varchar',
	'visible'=>'int',
	'notBeforeSeqId'=>'int',
	'allowAfterDays'=>'int',
	'allowOn'=>'int',
	'rank'=>'integer');

	var $__nulls = array( 
	'notBeforeSeqId'=>'notBeforeSeqId',
	'allowAfterDays'=>'allowAfterDays',
	'allowOn'=>'allowOn');



	function getPrimaryKey() {
		return $this->classLessonSequenceId;
	}


	function setPrimaryKey($val) {
		$this->classLessonSequenceId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassLessonSequencePeer::doInsert($this,$dsn));
		} else {
			ClassLessonSequencePeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "class_lesson_sequence_id='".$key."'";
		}
		$array = ClassLessonSequencePeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassLessonSequencePeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassLessonSequencePeer::doDelete($this,$deep,$dsn);
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


class ClassLessonSequencePeerBase {

	var $tableName = 'class_lesson_sequence';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_lesson_sequence",$where);
		$st->fields['class_lesson_sequence_id'] = 'class_lesson_sequence_id';
		$st->fields['lesson_id'] = 'lesson_id';
		$st->fields['class_id'] = 'class_id';
		$st->fields['lob_id'] = 'lob_id';
		$st->fields['lob_mime'] = 'lob_mime';
		$st->fields['lob_type'] = 'lob_type';
		$st->fields['lob_title'] = 'lob_title';
		$st->fields['visible'] = 'visible';
		$st->fields['not_before_seq_id'] = 'not_before_seq_id';
		$st->fields['allow_after_days'] = 'allow_after_days';
		$st->fields['allow_on'] = 'allow_on';
		$st->fields['rank'] = 'rank';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassLessonSequencePeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_lesson_sequence");
		$st->fields['class_lesson_sequence_id'] = $this->classLessonSequenceId;
		$st->fields['lesson_id'] = $this->lessonId;
		$st->fields['class_id'] = $this->classId;
		$st->fields['lob_id'] = $this->lobId;
		$st->fields['lob_mime'] = $this->lobMime;
		$st->fields['lob_type'] = $this->lobType;
		$st->fields['lob_title'] = $this->lobTitle;
		$st->fields['visible'] = $this->visible;
		$st->fields['not_before_seq_id'] = $this->notBeforeSeqId;
		$st->fields['allow_after_days'] = $this->allowAfterDays;
		$st->fields['allow_on'] = $this->allowOn;
		$st->fields['rank'] = $this->rank;

		$st->nulls['not_before_seq_id'] = 'not_before_seq_id';
		$st->nulls['allow_after_days'] = 'allow_after_days';
		$st->nulls['allow_on'] = 'allow_on';

		$st->key = 'class_lesson_sequence_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_lesson_sequence");
		$st->fields['class_lesson_sequence_id'] = $obj->classLessonSequenceId;
		$st->fields['lesson_id'] = $obj->lessonId;
		$st->fields['class_id'] = $obj->classId;
		$st->fields['lob_id'] = $obj->lobId;
		$st->fields['lob_mime'] = $obj->lobMime;
		$st->fields['lob_type'] = $obj->lobType;
		$st->fields['lob_title'] = $obj->lobTitle;
		$st->fields['visible'] = $obj->visible;
		$st->fields['not_before_seq_id'] = $obj->notBeforeSeqId;
		$st->fields['allow_after_days'] = $obj->allowAfterDays;
		$st->fields['allow_on'] = $obj->allowOn;
		$st->fields['rank'] = $obj->rank;

		$st->nulls['not_before_seq_id'] = 'not_before_seq_id';
		$st->nulls['allow_after_days'] = 'allow_after_days';
		$st->nulls['allow_on'] = 'allow_on';

		$st->key = 'class_lesson_sequence_id';
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
		$st = new PBDO_DeleteStatement("class_lesson_sequence","class_lesson_sequence_id = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassLessonSequence();
		$x->classLessonSequenceId = $row['class_lesson_sequence_id'];
		$x->lessonId = $row['lesson_id'];
		$x->classId = $row['class_id'];
		$x->lobId = $row['lob_id'];
		$x->lobMime = $row['lob_mime'];
		$x->lobType = $row['lob_type'];
		$x->lobTitle = $row['lob_title'];
		$x->visible = $row['visible'];
		$x->notBeforeSeqId = $row['not_before_seq_id'];
		$x->allowAfterDays = $row['allow_after_days'];
		$x->allowOn = $row['allow_on'];
		$x->rank = $row['rank'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassLessonSequence extends ClassLessonSequenceBase {



}



class ClassLessonSequencePeer extends ClassLessonSequencePeerBase {

}

?>