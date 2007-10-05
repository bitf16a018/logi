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

	function addQuestion($qtext, $type = 'QUESTION_ESSAY', $choices = '', $answers = '') {

		$q = new LobTestQst();
		$q->qstText =  $qtext;
		if ( is_array($choices) ) {
		}
		$this->questionObjs[] = $q;
	}

	function getQuestionCount() {
		return count($this->questionObjs);
	}
}
?>
