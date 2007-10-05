<?php
include_once(LIB_PATH.'PBDO/LobTest.php');
include_once(LIB_PATH.'PBDO/LobTestQst.php');

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
			$this->lobSub     = new LobTest();
			$this->lobMetaObj = new LobMetadata();
			$this->lobMetaObj->createdOn = time();
		} else {
			$this->repoObj   = LobRepoEntry::load($id);
			$tests           = $this->repoObj->getLobTestsByLobRepoEntryId();
			$this->lobSub    = $tests[0];
		}
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
		}
		return $q;
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
