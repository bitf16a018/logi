<?php
include_once(LIB_PATH.'PBDO/LobTest.php');
include_once(LIB_PATH.'PBDO/LobTestQst.php');

/**
 * Hold lob repo entries and lob test entries
 */
class Lc_Lob_ClassTest extends Lc_Lob_Class {

	var $type = 'test';
	var $questionObjs = array();
	var $mime = 'X-LMS/test';

	function Lc_Lob_ClassTest($id = 0) {
		if ($id < 1) {
			$this->repoObj    = new LobClassRepo();
			$this->lobSub     = new LobClassTest();
			$this->lobMetaObj = new LobClassMetadata();
			$this->lobMetaObj->createdOn = time();
		} else {
			$this->repoObj   = LobClassRepo::load($id);
			$tests           = $this->repoObj->getLobClassTestsByLobClassRepoId();
			$this->lobSub    = $tests[0];
		}
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

	/**
	 * Copy all the values of a specific sub Object to this lobSub
	 */
	function copySub(&$repoSub) {
		/*
		$this->lobSub->lobText     = $repoSub->lobText;
		$this->lobSub->lobBinary   = $repoSub->lobBinary;
		$this->lobSub->lobFilename = $repoSub->lobFilename;
		$this->lobSub->lobCaption  = $repoSub->lobCaption;
		 */
	}


	/**
	 * Skip the meta object for now
	 */
	function save() {
		if ($this->repoObj->lobGuid == '') {
			$guid = lcUuid();
			$this->repoObj->set('lobGuid',$guid);
		}
		$this->repoObj->version++;
		$this->repoObj->save();
		$ret = ($this->repoObj->getPrimaryKey() > 0);

		$this->lobSub->lobClassRepoId = $this->repoObj->getPrimaryKey();
		$this->lobSub->save();

		$this->lobMetaObj->updatedOn = time();
		if ($this->lobMetaObj->isNew()) {
			//might be a brand new object
			$this->lobMetaObj->lobId = $this->repoObj->getPrimaryKey();
		}
		return $this->lobMetaObj->save() && $ret;
	}

	//////////////// DEPRECATED ////////////////

	# Gradebook entry id
	# used for redirects back to the gradebook when modifying a user's score
	var $idClassGradebookEntries= '';

	function load($id,$class_id) {
		if ( $class_id == '' ) { trigger_error('load with empty class id'); return false; }
		$array = AssessmentPeer::doSelect("class_id = $class_id and assessment_id = $id");
		if (!is_array($array) ) { trigger_error('No permission to load assessment '.$id); return false; }
		return $array[0];
	}



	function loadAll($class_id) {
		if ( $class_id == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = AssessmentPeer::doSelect("class_id = $class_id");
		return $array;

	}

	# boolean returns true if student can take the
	# test, false if they cannot
	# pass in the time stamp of when the user started taking the test
	# ($u->sessionvars['asmt_start_date'] for example
	function canTake($start)
	{
		$end = $this->dateUnavailable;
		$timeLimitSeconds = $this->minuteLimit * 60;
		$newEndingTime = $start + $timeLimitSeconds;
		$time = time();
		/*
		echo '<br>'.$time. '= current time<br>';
		echo $newEndingTime. '= ending time<br>';
		*/

		if ( ($time > $newEndingTime) || ($time > $end) )
		{
			return FALSE;
		}
		return TRUE;
	}


	function getAssessmentQuestions() {

		$array = AssessmentQuestionPeer::doSelect('assessment_id = \''.$this->getPrimaryKey().'\' order by question_sort');
		$cc = count ($array);

		for($x=0; $x<$cc; ++$x) {
			$superObj = $array[$x];

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
				default:
					trigger_error("Cannot find appropriate class for question.  Question type was ".$superObj->questionType);
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

		$subObjArray[] =$subObj;
		}

	return $subObjArray;
	}

	# $questions = array of question objects with answer object added on
	# $answers = array 0f answer objects
	# $u = user object
	# $grade = on / off to re-grade the assessment
	# If you want it to re-grade the assessment for you before sending out
	# the email, this does update the students grades for points_earned in the database
	function emailTeacher($questions, $stuUserObj, $logObj, $grade=0)
	{
			$u = $stuUserObj;

			$qstans .= "Student ID: ".$stuUserObj->username."\n";
			$qstans .= "Name: ".$stuUserObj->profile->values['firstname']." ".$stuUserObj->profile->values['lastname']."\n";
			$qstans .= "Assessment: Name ".$this->displayName."\n";
			$qstans .= "Date Started: ".date('m-d-y h:i A', $u->sessionvars['asmt_date_start'])."\n";
			$qstans .= "Date Stopped: ".date('m-d-y h:i A', $logObj->end_date)."\n\n";

			$questionCount = count($questions);
			for ($i=0; $i<$questionCount; $i++)
			{
				$num = $i +1;
				$questionId = $questions[$i]->assessmentQuestionId;
					$qstans .= $num.".\n";
					$qstans .= "Type of Question: ".$questions[$i]->questionDisplay."\nQuestion: ".$questions[$i]->questionText."\n";
					$qstans .= "Points Assigned: ".$questions[$i]->answer->pointsEarned."\n";	
					if ($questions[$i]->questionType == QUESTION_MATCHING || $questions[$i]->questionType == QUESTION_MANSWER) 
						{
							$answer = unserialize($questions[$i]->answer->assessmentAnswerValues);
							$qstans .= "Answers: \n";
							for ($y=0;$y<$answerCount; $y++)
							{
								$ansnum = $y + 1;
+                                                               //$qstans .= "\t $ansnum. ".$answer[$y]."\n";
+                                                               //trying out a fix for a bug where the teacher just
+                                                               //gets the index of the correct answer
+                                                               //MAK 11-03-04
+                                                               $qstans .= "\t $ansnum. ".$questions[$i]->questionChoices[$y]->label ." " .$answer[$y]."\n";
 
							}
						} else {
							$qstans .= "Answer: ".$questions[$i]->answer->assessmentAnswerValues."\n\n";
						}
						$total_points_earned += $questions[$i]->answer->pointsEarned;
						$total_possible_points += $questions[$i]->questionPoints;
			}
			
			$qstans .= "\n\nTotal Points Earned: ". $total_points_earned ." out of ". $total_possible_points;
			# Send email to teacher
			$db = DB::getHandle();
			$sql = "select email from lcUsers where username='".$u->activeClassTaken->facultyId."'";
			$db->queryOne($sql);
			$email = $db->record['email'];
			$subject = $this->displayName." completed by ".$u->profile->values['firstname']." ".$u->profile->values['lastname'];

			if ( mail($email, $subject, $qstans) )
			{
				return TRUE;
			}
			return FALSE;
			
	}

	# Pulls in the last log entry for an assessment
	function getLastLogEntry($username)
	{
		include_once(LIB_PATH.'AssessmentLog.php');
		$log = AssessmentLogPeer::doSelect("assessment_id='".$this->assessmentId."' AND id_student='".$username."' ORDER BY start_date DESC LIMIT 1");	
		return $log[0];
	}

	# Loads answers onto questions object
	# And unserializes the matching and multiple answer questions for you automatcially
	function getQuestionsAndAnswers($studentId, $id_classes)
	{
		$questions = $this->getAssessmentQuestions();
		$answers = AssessmentAnswerPeer::doSelect("assessment_id='".$this->assessmentId."' AND student_id='".$studentId."' AND id_classes='".$id_classes."'");
		 #debug($answers,1);
		$this->questionCount = count($questions);
		$answerCount = count($answers);
		for ($i=0; $i<$this->questionCount; $i++) {
			$num = $i +1;
			$questionId = $questions[$i]->assessmentQuestionId;
			for($x=0; $x<$answerCount; $x++) {
				if ($answers[$x]->assessmentQuestionId == $questionId) {
					#$questions[$i]->grade($answers[$x]);
					$questions[$i]->answer = $answers[$x];
#					debug($questions[$i],1);
					if ($questions[$i]->questionType == QUESTION_MATCHING || $questions[$i]->questionType == QUESTION_MANSWER) 
					{
						$questions[$i]->answer->assessmentAnswerValues = unserialize($questions[$i]->answer->assessmentAnswerValues);
					} else {
						$qstans .= "Answer: ".$questions[$i]->answer->assessmentAnswerValues."\n\n";
					}

				}

				$this->pointsEarned += $questions[$i]->answer->pointsEarned;
			}
			
			$this->totalPoints += $questions[$i]->questionPoints;
		}
		return $questions;
	}

	# Loads the answers for a student for a given class and
	# update the gradebook score
	# Normally called in assessements/grade/event=updatePoints
	# MAK added 9/4/03
	# always update gradebook scores in entries table to fix previous problem	
	function updateGradebookScore($studentId, $id_classes) {
		$answer = AssessmentAnswerPeer::doSelect("student_id='$studentId' AND id_classes='$id_classes' AND assessment_id='".$this->assessmentId."'");
		$count = count($answer);
		for ($i=0; $i<$count; $i++) { 
			if ($answer[$i]->pointsGiven) { 
				$totalPoints += $answer[$i]->pointsGiven;
			} else {
				$totalPoints += $answer[$i]->pointsEarned;
			}
		}
		$entry = $this->loadGradebookEntry($studentId);
		if (is_object($entry) ) { 
			$entryId = $entry->getPrimaryKey();
			$val = $this->loadGradebookVal($entryId, $studentId);
			if (is_object($val) ) { 
				$val->score = $totalPoints;
				$val->save();
				return $totalPoints;
			} else {
				# create val entry
				$val = new ClassGradebookVal();
				$val->idClasses = $id_classes;
				$val->username = $studentId;
				$val->score = $totalPoints;
				$val->dateCreated = date('Y-m-d H:i:s');
				$val->idClassGradebookEntries = $entryId;
				//__FIXME__ make comments field accept nulls
				// class_gradebook_val
				$val->save();
				return $totalPoints;
			}

		}
		return $totalPoints;
	}

	function loadGradebookEntry($studentId) { 
		include_once(LIB_PATH.'ClassGradebookEntries.php');
		$entry =
		ClassGradebookEntriesPeer::doSelect("assessment_id='".$this->assessmentId."'");
		$this->idClassGradebookEntries = $entry[0]->idClassGradebookEntries;
		return $entry[0];
	}

	function loadGradebookVal($entryId, $studentId) { 
		include_once(LIB_PATH.'ClassGradebookVal.php');
		$val = ClassGradebookValPeer::doSelect("id_class_gradebook_entries='".$entryId."'
		AND username='".$studentId."'");
		return $val[0];
	}

	# Returns BOOL if the test has already been taken
	# or started by a student
	function isTaken()
	{
		include_once(LIB_PATH.'AssessmentLog.php');	
		$log =
		AssessmentLogPeer::doSelect("assessment_id='".$this->assessmentId."' AND id_classes='".$this->classId."'");
		$count = count($log);
		if ($count)
		{
			return TRUE;
		}
		return FALSE;
	}
}
?>
