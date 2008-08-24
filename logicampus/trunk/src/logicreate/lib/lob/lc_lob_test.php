<?php
include_once(LIB_PATH.'PBDO/LobTest.php');
include_once(LIB_PATH.'PBDO/LobTestQst.php');
//defines constants for question types QUESTON_*
include_once(LIB_PATH.'AssessmentQuestion.php');
include_once(LIB_PATH.'AssessmentLib.php');

/**
 * Hold lob repo entries and lob test entries
 */
class Lc_Lob_Test extends Lc_Lob {

	var $type = 'test';
	var $questionObjs = array();
	var $mime = 'X-LMS/test';

	function Lc_Lob_Test($id = 0) {
		if ($id < 1) {
			$this->repoObj    = new LobRepoEntry();
			$this->repoObj->lobMime = $this->mime;
			$this->repoObj->lobType = $this->type;
			$this->repoObj->lobSubType = $this->type;
			$this->lobSub     = new LobTest();
		} else {
			$this->repoObj   = LobRepoEntry::load($id);
			$tests           = $this->repoObj->getLobTestsByLobRepoEntryId();
			$this->lobSub    = $tests[0];
			$this->loadQuestions();
			$this->lobMetaObj = LobMetadata::load(array('lob_repo_entry_id'=>$id));
		}

		if (isset($this->lobMetaObj) || !is_object($this->lobMetaObj)) {
			$this->lobMetaObj = new LobMetadata();
			$this->lobMetaObj->createdOn = time();
		}
	}

	function save() {
		$ret = parent::save();
		if (!$ret) { return FALSE;}

		$this->saveQuestions();
	}


	function setTitle($t) {
		$this->repoObj->set('lobTitle', $t);
	}

	function setInstructions($i) {
		$this->repoObj->set('lobDescription', $i);
	}

	function setNotes($n) {
		$this->repoObj->set('lobNotes', $n);
	}

	function setQuestion($qidx, $qtext, $type = 'QUESTION_ESSAY', $choices = '', $answers = '') {
		$q = $this->_makeQuestion($qtext, $type, $choices, $answers);
		if ($qidx > -1) {
			$this->questionObjs[$qidx] = $q;
		} else {
			$this->questionObjs[] = $q;
		}
	}

	function addQuestion($qtext, $type = 'QUESTION_ESSAY', $choices = '', $answers = '') {
		$q = $this->_makeQuestion($qtext, $type, $choices, $answers);
		$this->questionObjs[] = $q;
	}

	function getQuestionCount() {
		return count($this->questionObjs);
	}

	function _makeQuestion($qtext, $type, $choices, $answers='') {
		$q = new LobTestQst();
		$q->qstChoices = array();
		$q->qstText =  $qtext;
		$q->questionTypeId = constant($type);
		if ( is_array($choices) ) {
			$q->qstChoices = $choices;
		}
		return $q;
	}

	/**
	 * Load questions from the DB, add to internal questionObjs array
	 */
	function loadQuestions() {
		$this->questionObjs = array();
		if ($this->lobSub->get('lobTestId') < 1) { return; }
		$questionList =  LobTestQstPeer::doSelect( ' lob_test_id = '.$this->lobSub->get('lobTestId'));
		foreach ($questionList as $q) {
			$q->qstChoices = unserialize($q->qstChoices);
			$this->questionObjs[] = $q;
		}
	}


	function saveQuestions() {
		//clean out questions which have been deleted
		$ids = array();
		foreach ($this->questionObjs as $q) {
			if ((int) $q->lobTestQstId < 1)  continue;
			$ids[] = $q->lobTestQstId;
		}

		$idList = '('. implode(',', $ids).')';
		LobTestQstPeer::doQuery( 'delete from lob_test_qst WHERE lob_test_id = '.$this->lobSub->get('lobTestId') .' AND lob_test_qst_id NOT IN '.$idList);

		//save the questions which have been edited or created new
		foreach($this->questionObjs as $q) {
			if (!is_object($q)) { continue; }
			if (!method_exists( $q, 'set')) { continue; }
			$q->set('lobTestId', $this->lobSub->get('lobTestId'));
			$q->qstChoices = serialize($q->qstChoices);
			$q->save();
		}
	}

	/**
	 *
	 * @return bool successfully added the choice
	 */
	function addLabel($l, $correct, $qidx=-1) {
		if ($qidx == -1) {
			$qidx = $this->getQuestionCount()-1;
		}
		if ($qidx == -1) {
			return false;
		}
		$lidx = count($this->questionObjs[$qidx]->qstChoices);
		if ($lidx == -1) {
			$lidx = 0;
		}
	
		$this->questionObjs[$qidx]->qstChoices[$lidx]['label'] = $l;
		$this->questionObjs[$qidx]->qstChoices[$lidx]['correct'] = $correct;
		return true;
	}
}
?>
