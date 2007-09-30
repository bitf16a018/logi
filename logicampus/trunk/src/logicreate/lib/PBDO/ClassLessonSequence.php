<?

class ClassLessonSequenceBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $classLessonSequenceId;
	var $lessonId;
	var $classId;
	var $lobClassRepoId;
	var $lobType;
	var $lobSubType;
	var $lobMime;
	var $lobTitle;
	var $linkText;
	var $notBeforeSeqId;
	var $startOffset;
	var $endOffset;
	var $dueOffset;
	var $gracePeriodDays;
	var $rank;
	var $hideUntilStart;
	var $hideAfterEnd;

	var $__attributes = array( 
	'classLessonSequenceId'=>'integer',
	'lessonId'=>'integer',
	'classId'=>'integer',
	'lobClassRepoId'=>'integer',
	'lobType'=>'varchar',
	'lobSubType'=>'varchar',
	'lobMime'=>'varchar',
	'lobTitle'=>'varchar',
	'linkText'=>'varchar',
	'notBeforeSeqId'=>'int',
	'startOffset'=>'int',
	'endOffset'=>'int',
	'dueOffset'=>'int',
	'gracePeriodDays'=>'int',
	'rank'=>'integer',
	'hideUntilStart'=>'int',
	'hideAfterEnd'=>'int');

	var $__nulls = array( 
	'notBeforeSeqId'=>'notBeforeSeqId',
	'startOffset'=>'startOffset',
	'endOffset'=>'endOffset',
	'dueOffset'=>'dueOffset',
	'gracePeriodDays'=>'gracePeriodDays');



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
		$where = '';
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
		$st->fields['lob_class_repo_id'] = 'lob_class_repo_id';
		$st->fields['lob_type'] = 'lob_type';
		$st->fields['lob_sub_type'] = 'lob_sub_type';
		$st->fields['lob_mime'] = 'lob_mime';
		$st->fields['lob_title'] = 'lob_title';
		$st->fields['link_text'] = 'link_text';
		$st->fields['not_before_seq_id'] = 'not_before_seq_id';
		$st->fields['start_offset'] = 'start_offset';
		$st->fields['end_offset'] = 'end_offset';
		$st->fields['due_offset'] = 'due_offset';
		$st->fields['grace_period_days'] = 'grace_period_days';
		$st->fields['rank'] = 'rank';
		$st->fields['hide_until_start'] = 'hide_until_start';
		$st->fields['hide_after_end'] = 'hide_after_end';


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
		$st->fields['lob_class_repo_id'] = $this->lobClassRepoId;
		$st->fields['lob_type'] = $this->lobType;
		$st->fields['lob_sub_type'] = $this->lobSubType;
		$st->fields['lob_mime'] = $this->lobMime;
		$st->fields['lob_title'] = $this->lobTitle;
		$st->fields['link_text'] = $this->linkText;
		$st->fields['not_before_seq_id'] = $this->notBeforeSeqId;
		$st->fields['start_offset'] = $this->startOffset;
		$st->fields['end_offset'] = $this->endOffset;
		$st->fields['due_offset'] = $this->dueOffset;
		$st->fields['grace_period_days'] = $this->gracePeriodDays;
		$st->fields['rank'] = $this->rank;
		$st->fields['hide_until_start'] = $this->hideUntilStart;
		$st->fields['hide_after_end'] = $this->hideAfterEnd;

		$st->nulls['not_before_seq_id'] = 'not_before_seq_id';
		$st->nulls['start_offset'] = 'start_offset';
		$st->nulls['end_offset'] = 'end_offset';
		$st->nulls['due_offset'] = 'due_offset';
		$st->nulls['grace_period_days'] = 'grace_period_days';

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
		$st->fields['lob_class_repo_id'] = $obj->lobClassRepoId;
		$st->fields['lob_type'] = $obj->lobType;
		$st->fields['lob_sub_type'] = $obj->lobSubType;
		$st->fields['lob_mime'] = $obj->lobMime;
		$st->fields['lob_title'] = $obj->lobTitle;
		$st->fields['link_text'] = $obj->linkText;
		$st->fields['not_before_seq_id'] = $obj->notBeforeSeqId;
		$st->fields['start_offset'] = $obj->startOffset;
		$st->fields['end_offset'] = $obj->endOffset;
		$st->fields['due_offset'] = $obj->dueOffset;
		$st->fields['grace_period_days'] = $obj->gracePeriodDays;
		$st->fields['rank'] = $obj->rank;
		$st->fields['hide_until_start'] = $obj->hideUntilStart;
		$st->fields['hide_after_end'] = $obj->hideAfterEnd;

		$st->nulls['not_before_seq_id'] = 'not_before_seq_id';
		$st->nulls['start_offset'] = 'start_offset';
		$st->nulls['end_offset'] = 'end_offset';
		$st->nulls['due_offset'] = 'due_offset';
		$st->nulls['grace_period_days'] = 'grace_period_days';

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
		$x->lobClassRepoId = $row['lob_class_repo_id'];
		$x->lobType = $row['lob_type'];
		$x->lobSubType = $row['lob_sub_type'];
		$x->lobMime = $row['lob_mime'];
		$x->lobTitle = $row['lob_title'];
		$x->linkText = $row['link_text'];
		$x->notBeforeSeqId = $row['not_before_seq_id'];
		$x->startOffset = $row['start_offset'];
		$x->endOffset = $row['end_offset'];
		$x->dueOffset = $row['due_offset'];
		$x->gracePeriodDays = $row['grace_period_days'];
		$x->rank = $row['rank'];
		$x->hideUntilStart = $row['hide_until_start'];
		$x->hideAfterEnd = $row['hide_after_end'];

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