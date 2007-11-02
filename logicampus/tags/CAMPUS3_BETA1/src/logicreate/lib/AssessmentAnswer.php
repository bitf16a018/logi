<?

class AssessmentAnswerBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $assessmentAnswerId;
	var $assessmentId;
	var $assessmentQuestionId;
	var $studentId;
	var $assessmentAnswerValues;
	var $idClasses;
	var $pointsEarned;
	var $pointsGiven;

	var $__attributes = array( 
	'assessmentAnswerId'=>'integer',
	'assessmentId'=>'integer',
	'assessmentQuestionId'=>'integer',
	'studentId'=>'varchar',
	'assessmentAnswerValues'=>'longvarchar',
	'idClasses'=>'integer',
	'pointsEarned'=>'float',
	'pointsGiven'=>'float');

	var $__nulls = array( 
	'assessmentId'=>'assessmentId',
	'assessmentQuestionId'=>'assessmentQuestionId',
	'studentId'=>'studentId',
	'assessmentAnswerValues'=>'assessmentAnswerValues',
	'pointsEarned'=>'pointsEarned',
	'pointsGiven'=>'pointsGiven');



	function getPrimaryKey() {
		return $this->assessmentAnswerId;
	}


	function setPrimaryKey($val) {
		$this->assessmentAnswerId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(AssessmentAnswerPeer::doInsert($this,$dsn));
		} else {
			AssessmentAnswerPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "assessment_answer_id='".$key."'";
		}
		$array = AssessmentAnswerPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = AssessmentAnswerPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		AssessmentAnswerPeer::doDelete($this,$deep,$dsn);
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


class AssessmentAnswerPeerBase {

	var $tableName = 'assessment_answer';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("assessment_answer",$where);
		$st->fields['assessment_answer_id'] = 'assessment_answer_id';
		$st->fields['assessment_id'] = 'assessment_id';
		$st->fields['assessment_question_id'] = 'assessment_question_id';
		$st->fields['student_id'] = 'student_id';
		$st->fields['assessment_answer_values'] = 'assessment_answer_values';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['points_earned'] = 'points_earned';
		$st->fields['points_given'] = 'points_given';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = AssessmentAnswerPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("assessment_answer");
		$st->fields['assessment_answer_id'] = $this->assessmentAnswerId;
		$st->fields['assessment_id'] = $this->assessmentId;
		$st->fields['assessment_question_id'] = $this->assessmentQuestionId;
		$st->fields['student_id'] = $this->studentId;
		$st->fields['assessment_answer_values'] = $this->assessmentAnswerValues;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['points_earned'] = $this->pointsEarned;
		$st->fields['points_given'] = $this->pointsGiven;

		$st->nulls['assessment_id'] = 'assessment_id';
		$st->nulls['assessment_question_id'] = 'assessment_question_id';
		$st->nulls['student_id'] = 'student_id';
		$st->nulls['assessment_answer_values'] = 'assessment_answer_values';
		$st->nulls['points_earned'] = 'points_earned';
		$st->nulls['points_given'] = 'points_given';

		$st->key = 'assessment_answer_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("assessment_answer");
		$st->fields['assessment_answer_id'] = $obj->assessmentAnswerId;
		$st->fields['assessment_id'] = $obj->assessmentId;
		$st->fields['assessment_question_id'] = $obj->assessmentQuestionId;
		$st->fields['student_id'] = $obj->studentId;
		$st->fields['assessment_answer_values'] = $obj->assessmentAnswerValues;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['points_earned'] = $obj->pointsEarned;
		$st->fields['points_given'] = $obj->pointsGiven;

		$st->nulls['assessment_id'] = 'assessment_id';
		$st->nulls['assessment_question_id'] = 'assessment_question_id';
		$st->nulls['student_id'] = 'student_id';
		$st->nulls['assessment_answer_values'] = 'assessment_answer_values';
		$st->nulls['points_earned'] = 'points_earned';
		$st->nulls['points_given'] = 'points_given';

		$st->key = 'assessment_answer_id';
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
		$st = new PBDO_DeleteStatement("assessment_answer","assessment_answer_id = '".$obj->getPrimaryKey()."'");

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
		$x = new AssessmentAnswer();
		$x->assessmentAnswerId = $row['assessment_answer_id'];
		$x->assessmentId = $row['assessment_id'];
		$x->assessmentQuestionId = $row['assessment_question_id'];
		$x->studentId = $row['student_id'];
		$x->assessmentAnswerValues = $row['assessment_answer_values'];
		$x->idClasses = $row['id_classes'];
		$x->pointsEarned = $row['points_earned'];
		$x->pointsGiven = $row['points_given'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class AssessmentAnswer extends AssessmentAnswerBase {



}



class AssessmentAnswerPeer extends AssessmentAnswerPeerBase {

}

?>