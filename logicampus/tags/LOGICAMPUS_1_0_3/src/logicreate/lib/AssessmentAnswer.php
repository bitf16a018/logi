<?

class AssessmentAnswerBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $assessmentAnswerId;
	var $assessmentId;
	var $assessmentQuestionId;
	var $studentId;
	var $idClasses;
	var $assessmentAnswerValues;
	var $pointsEarned;
	var $pointsGiven;

	var $__attributes = array(
	'assessmentAnswerId'=>'int',
	'assessmentId'=>'Assessment',
	'assessmentQuestionId'=>'AssessmentQuestion',
	'studentId'=>'LcUsers',
	'idClasses'=>'int',
	'assessmentAnswerValues'=>'text',
	'pointsEarned'=>'float',
	'pointsGiven'=>'float');

	function getAssessment() {
		if ( $this->assessmentId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = AssessmentPeer::doSelect('assessment_id = \''.$this->assessmentId.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}

	function getAssessmentQuestion() {
		if ( $this->assessmentQuestionId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = AssessmentQuestionPeer::doSelect('assessment_question_id = \''.$this->assessmentQuestionId.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}

	function getLcUsers() {
		if ( $this->username == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = LcUsersPeer::doSelect('username = \''.$this->studentId.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->assessmentAnswerId;
	}

	function setPrimaryKey($val) {
		$this->assessmentAnswerId = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(AssessmentAnswerPeer::doInsert($this));
		} else {
			AssessmentAnswerPeer::doUpdate($this);
		}
	}

	function load($key) {
		$this->_new = false;
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "assessment_answer_id='".$key."'";
		}
		$array = AssessmentAnswerPeer::doSelect($where);
		return $array[0];
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
		if ($array['studentId'])
			$this->studentId = $array['studentId'];
		if ($array['idClasses'])
			$this->idClasses = $array['idClasses'];
		if ($array['assessmentAnswerValues'])
			$this->assessmentAnswerValues = $array['assessmentAnswerValues'];
		if ($array['pointsEarned'])
			$this->pointsEarned = $array['pointsEarned'];
		if ($array['pointsGiven'])
			$this->pointsGiven = $array['pointsGiven'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class AssessmentAnswerPeer {

	var $tableName = 'assessment_answer';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("assessment_answer",$where);
		$st->fields['assessment_answer_id'] = 'assessment_answer_id';
		$st->fields['assessment_id'] = 'assessment_id';
		$st->fields['assessment_question_id'] = 'assessment_question_id';
		$st->fields['student_id'] = 'student_id';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['assessment_answer_values'] = 'assessment_answer_values';
		$st->fields['points_earned'] = 'points_earned';
		$st->fields['points_given'] = 'points_given';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = AssessmentAnswerPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("assessment_answer");
		$st->fields['assessment_answer_id'] = $this->assessmentAnswerId;
		$st->fields['assessment_id'] = $this->assessmentId;
		$st->fields['assessment_question_id'] = $this->assessmentQuestionId;
		$st->fields['student_id'] = $this->studentId;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['assessment_answer_values'] = $this->assessmentAnswerValues;
		if ($st->fields['points_earned']!='NULL')  
			$st->fields['points_earned'] = $this->pointsEarned;
		if ($st->fields['points_given']!='NULL')  
			$st->fields['points_given'] = $this->pointsGiven;

		$st->key = 'assessment_answer_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("assessment_answer");
		$st->fields['assessment_answer_id'] = $obj->assessmentAnswerId;
		$st->fields['assessment_id'] = $obj->assessmentId;
		$st->fields['assessment_question_id'] = $obj->assessmentQuestionId;
		$st->fields['student_id'] = $obj->studentId;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['assessment_answer_values'] = $obj->assessmentAnswerValues;
		if ($st->fields['points_earned']!='NULL')  
			$st->fields['points_earned'] = $obj->pointsEarned;
		if ($st->fields['points_given']!='NULL')  
			$st->fields['points_given'] = $obj->pointsGiven;

		$st->key = 'assessment_answer_id';
		$db->executeQuery($st);
		$obj->_modified = false;

	}

	function doReplace($obj) {
		//use this tableName
		if ($this->isNew() ) {
			$db->executeQuery(new LC_InsertStatement($criteria));
		} else {
			$db->executeQuery(new LC_UpdateStatement($criteria));
		}
	}



	function doDelete(&$obj,$shallow=false) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_DeleteStatement("assessment_answer","assessment_answer_id = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new AssessmentAnswer();
		$x->assessmentAnswerId = $row['assessment_answer_id'];
		$x->assessmentId = $row['assessment_id'];
		$x->assessmentQuestionId = $row['assessment_question_id'];
		$x->studentId = $row['student_id'];
		$x->idClasses = $row['id_classes'];
		$x->assessmentAnswerValues = $row['assessment_answer_values'];
		$x->pointsEarned = $row['points_earned'];
		$x->pointsGiven = $row['points_given'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class AssessmentAnswer extends AssessmentAnswerBase {



}

?>
