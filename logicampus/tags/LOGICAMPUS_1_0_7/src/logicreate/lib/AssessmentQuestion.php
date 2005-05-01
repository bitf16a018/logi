<?
/*************************************************** 
 *
 * This file is under the LogiCreate Public License
 *
 * A copy of the license is in your LC distribution
 * called license.txt.  If you are missing this
 * file you can obtain the latest version from
 * http://logicreate.com/license.html
 *
 * LogiCreate is copyright by Tap Internet, Inc.
 * http://www.tapinternet.com/
 ***************************************************/


class AssessmentQuestionBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
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
	'assessmentQuestionId'=>'int',
	'assessmentId'=>'int',
	'questionType'=>'int',
	'questionSort'=>'tinyint',
	'questionPoints'=>'float',
	'questionDisplay'=>'varchar',
	'questionText'=>'mediumtext',
	'questionChoices'=>'text',
	'questionInput'=>'text',
	'fileHash'=>'varchar');

	function getAssessmentAnswer() {
		$array = AssessmentAnswerPeer::doSelect('assessment_question_id = \''.$this->getPrimaryKey().'\'');
		return $array[0];
	}

	function getAssessment() {
		if ( $this->assessmentId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = AssessmentPeer::doSelect('assessment_id = \''.$this->assessmentId.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->assessmentQuestionId;
	}

	function setPrimaryKey($val) {
		$this->assessmentQuestionId = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(AssessmentQuestionPeer::doInsert($this));
		} else {
			AssessmentQuestionPeer::doUpdate($this);
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
			$where = "assessment_question_id='".$key."'";
		}
		$array = AssessmentQuestionPeer::doSelect($where);
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
		if ($array['assessmentId'])
			$this->assessmentId = $array['assessmentId'];
		if ($array['questionType'])
			$this->questionType = $array['questionType'];
		if ($array['questionSort'])
			$this->questionSort = $array['questionSort'];
		if ($array['questionPoints'])
			$this->questionPoints = $array['questionPoints'];
		if ($array['questionDisplay'])
			$this->questionDisplay = $array['questionDisplay'];
		if ($array['questionText'])
			$this->questionText = $array['questionText'];
		if ($array['questionChoices'])
			$this->questionChoices = $array['questionChoices'];
		if ($array['questionInput'])
			$this->questionInput = $array['questionInput'];
		if ($array['fileHash'])
			$this->fileHash = $array['fileHash'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class AssessmentQuestionPeer {

	var $tableName = 'assessment_question';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("assessment_question",$where);
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

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = AssessmentQuestionPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("assessment_question");
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

		$st->key = 'assessment_question_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("assessment_question");
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

		$st->key = 'assessment_question_id';
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
		$st = new LC_DeleteStatement("assessment_question","assessment_question_id = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

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

		$x->questionChoices = unserialize(base64_decode($x->questionChoices));

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class AssessmentQuestion extends AssessmentQuestionBase {


	var $allowMultiple = false;
	var $questionPoints = 5;

	function setQuestionText($t) {
		$this->questionText = $t;
	}


	/**
	 * this is needed because each question talks to the
	 * template differently.  Squeezing all these logic
	 * if's into one code base is getting confusing
	 */
	function resetLabels($postvars) {
		$this->questionChoices = array();

		while (list ($k,$v) = each($postvars['labels']) ) {
			if ( trim($v) == '' ) {
				continue;
			}

			$qc = new AssessmentChoice();
			$qc->label = stripslashes($v);
			$qc->correct = ($postvars['correct'][$k] == 'On') ? true:false;
			$this->questionChoices[] = $qc;
		}
	}



	/**
	 * Sometimes we only want to change the correct choice
	 * i.e. when editing an in-progress test
	 */
	function setCorrectChoice($postvars) {
		while (list ($k,$v) = each($postvars['labels']) ) {
			while (list ($kk,$vv) = each($this->questionChoices) ) {
				if ($vv->label ==  $v) {
					$this->questionChoices[$kk]->correct = true;
				} else {
					$this->questionChoices[$kk]->correct = false;
				}
			}
		}
	}


	function save() {

		$this->questionChoices = base64_encode(serialize($this->questionChoices));
		$this->questionInput = base64_encode(serialize($this->questionInput));

		if ( $this->isNew() ) {
			$this->setPrimaryKey(AssessmentQuestionPeer::doInsert($this));
		} else {
			AssessmentQuestionPeer::doUpdate($this);
		}
		$this->questionChoices = unserialize(base64_decode($this->questionChoices));
		$this->questionInput = unserialize(base64_decode($this->questionInput));

	}


	function toHTML() {

		$ret .= "<FIELDSET>\n";
		$ret .= "<LEGEND>".$this->questionDisplay ."</LEGEND>\n";
		$ret .= "<p>".$this->questionText."</p>\n";
		$ret .= $this->questionInput->render();
		$ret .= "</FIELDSET>\n";
		return $ret;
	}


	/*
	 * We overrode this load method for classes security
	 * If you use it, you HAVE to pass in the class_id
	 */
	function load($key, $id_classes) {
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$sql = "select * from assessment_question q
			left join assessment as a on a.assessment_id=q.assessment_id 
			where a.class_id='$id_classes' AND q.assessment_question_id='$key'";
		if ($db->queryOne($sql) ) {
			$superObj = AssessmentQuestionPeer::row2Obj($db->Record);
		}

		switch($superObj->questionType) {
			case QUESTION_TRUEFALSE:
				$subObj = new AssessmentQuestionTrueFalse();
				break;
			case QUESTION_MCHOICE:
				$subObj = new AssessmentQuestionMChoice();
				break;
			case QUESTION_MANSWER:
				$subObj = new AssessmentQuestionMAnswer();
				break;
			case QUESTION_MATCHING:
				$subObj = new AssessmentQuestionMatching();
				break;
			case QUESTION_FILLINBLANK:
				$subObj = new AssessmentQuestionFill();
				break;
			case QUESTION_ESSAY:
				$subObj = new AssessmentQuestionEssay();
				break;
		}



		if( $superObj->assessmentQuestionId )
			$subObj->_new = false;
		else
			$subObj->_new = true;

		$subObj->_modified = false;
		$subObj->assessmentQuestionId = $superObj->assessmentQuestionId;
		$subObj->assessmentId = $superObj->assessmentId;
		$subObj->questionType = $superObj->questionType;
		$subObj->questionSort = $superObj->questionSort;
		$subObj->questionDisplay = $superObj->questionDisplay;
		$subObj->questionText =  $superObj->questionText;
		$subObj->questionPoints = $superObj->questionPoints;
		$subObj->questionChoices = $superObj->questionChoices;
		$subObj->fileHash = $superObj->fileHash;

		// Adam added this here.. it seemed necessary
		//$subObj->questionChoices = unserialize(base64_decode($subObj->questionChoices));
		// Commented out by Keith since this needs to be in row2Obj above

	return $subObj;
	}
}

?>
