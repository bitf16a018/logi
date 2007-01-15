<?

class AssessmentQuestionBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $assessmentQuestionId;
	var $assessmentId;
	var $questionType;
	var $questionSort;
	var $questionPoints;
	var $questionDisplay;
	var $questionText;
	var $questionChoices;
	var $questionInput;
	var $fileHash;

	var $__attributes = array( 
	'assessmentQuestionId'=>'integer',
	'assessmentId'=>'integer',
	'questionType'=>'integer',
	'questionSort'=>'tinyint',
	'questionPoints'=>'float',
	'questionDisplay'=>'varchar',
	'questionText'=>'mediumtext',
	'questionChoices'=>'longvarchar',
	'questionInput'=>'longvarchar',
	'fileHash'=>'varchar');

	var $__nulls = array( 
	'assessmentId'=>'assessmentId',
	'questionType'=>'questionType',
	'questionDisplay'=>'questionDisplay',
	'questionText'=>'questionText',
	'questionChoices'=>'questionChoices');



	function getPrimaryKey() {
		return $this->assessmentQuestionId;
	}


	function setPrimaryKey($val) {
		$this->assessmentQuestionId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(AssessmentQuestionPeer::doInsert($this,$dsn));
		} else {
			AssessmentQuestionPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "assessment_question_id='".$key."'";
		}
		$array = AssessmentQuestionPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = AssessmentQuestionPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		AssessmentQuestionPeer::doDelete($this,$deep,$dsn);
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


class AssessmentQuestionPeerBase {

	var $tableName = 'assessment_question';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("assessment_question",$where);
		$st->fields['assessment_question_id'] = 'assessment_question_id';
		$st->fields['assessment_id'] = 'assessment_id';
		$st->fields['question_type'] = 'question_type';
		$st->fields['question_sort'] = 'question_sort';
		$st->fields['question_points'] = 'question_points';
		$st->fields['question_display'] = 'question_display';
		$st->fields['question_text'] = 'question_text';
		$st->fields['question_choices'] = 'question_choices';
		$st->fields['question_input'] = 'question_input';
		$st->fields['file_hash'] = 'file_hash';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = AssessmentQuestionPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("assessment_question");
		$st->fields['assessment_question_id'] = $this->assessmentQuestionId;
		$st->fields['assessment_id'] = $this->assessmentId;
		$st->fields['question_type'] = $this->questionType;
		$st->fields['question_sort'] = $this->questionSort;
		$st->fields['question_points'] = $this->questionPoints;
		$st->fields['question_display'] = $this->questionDisplay;
		$st->fields['question_text'] = $this->questionText;
		$st->fields['question_choices'] = $this->questionChoices;
		$st->fields['question_input'] = $this->questionInput;
		$st->fields['file_hash'] = $this->fileHash;

		$st->nulls['assessment_id'] = 'assessment_id';
		$st->nulls['question_type'] = 'question_type';
		$st->nulls['question_display'] = 'question_display';
		$st->nulls['question_text'] = 'question_text';
		$st->nulls['question_choices'] = 'question_choices';

		$st->key = 'assessment_question_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("assessment_question");
		$st->fields['assessment_question_id'] = $obj->assessmentQuestionId;
		$st->fields['assessment_id'] = $obj->assessmentId;
		$st->fields['question_type'] = $obj->questionType;
		$st->fields['question_sort'] = $obj->questionSort;
		$st->fields['question_points'] = $obj->questionPoints;
		$st->fields['question_display'] = $obj->questionDisplay;
		$st->fields['question_text'] = $obj->questionText;
		$st->fields['question_choices'] = $obj->questionChoices;
		$st->fields['question_input'] = $obj->questionInput;
		$st->fields['file_hash'] = $obj->fileHash;

		$st->nulls['assessment_id'] = 'assessment_id';
		$st->nulls['question_type'] = 'question_type';
		$st->nulls['question_display'] = 'question_display';
		$st->nulls['question_text'] = 'question_text';
		$st->nulls['question_choices'] = 'question_choices';

		$st->key = 'assessment_question_id';
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
		$st = new PBDO_DeleteStatement("assessment_question","assessment_question_id = '".$obj->getPrimaryKey()."'");

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
		$x = new AssessmentQuestion();
		$x->assessmentQuestionId = $row['assessment_question_id'];
		$x->assessmentId = $row['assessment_id'];
		$x->questionType = $row['question_type'];
		$x->questionSort = $row['question_sort'];
		$x->questionPoints = $row['question_points'];
		$x->questionDisplay = $row['question_display'];
		$x->questionText = $row['question_text'];
		$x->questionChoices = $row['question_choices'];
		$x->questionInput = $row['question_input'];
		$x->fileHash = $row['file_hash'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class AssessmentQuestion extends AssessmentQuestionBase {



}



class AssessmentQuestionPeer extends AssessmentQuestionPeerBase {

}

?>