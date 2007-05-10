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


class AssessmentBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $assessmentId;
	var $displayName;
	var $classId;
	var $dateAvailable;
	var $dateUnavailable;
	var $mailResponses;
	var $autoPublish;
	var $numRetries;
	var $minuteLimit;
	var $showResultType = 0;
	var $description;
	var $instructions;
	var $possiblePoints = 0;

	var $__attributes = array(
	'assessmentId'=>'int',
	'displayName'=>'varchar',
	'classId'=>'Classes',
	'dateAvailable'=>'int',
	'dateUnavailable'=>'int',
	'mailResponses'=>'tinyint',
	'autoPublish'=>'tinyint',
	'numRetries'=>'tinyint',
	'minuteLimit'=>'int',
	'showResultType'=>'tinyint',
	'description'=>'text',
	'instructions'=>'text',
	'possiblePoints'=>'float');

	function getAssessmentQuestions() {
		$array = AssessmentQuestionPeer::doSelect('assessment_id = \''.$this->getPrimaryKey().'\' order by question_sort');
		return $array;
	}

	function getAssessmentAnswers() {
		$array = AssessmentAnswerPeer::doSelect('assessment_id = \''.$this->getPrimaryKey().'\'');
		return $array;
	}

	function getClasses() {
		if ( $this->idClasses == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = ClassesPeer::doSelect('id_classes = \''.$this->classId.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->assessmentId;
	}

	function setPrimaryKey($val) {
		$this->assessmentId = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(AssessmentPeer::doInsert($this));
		} else {
			AssessmentPeer::doUpdate($this);
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
			$where = "assessment_id='".$key."'";
		}
		$array = AssessmentPeer::doSelect($where);
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
		if ($array['displayName'])
			$this->displayName = $array['displayName'];
		if ($array['classId'])
			$this->classId = $array['classId'];
		if ($array['dateAvailable'])
			$this->dateAvailable = $array['dateAvailable'];
		if ($array['dateUnavailable'])
			$this->dateUnavailable = $array['dateUnavailable'];
		if ($array['mailResponses'])
			$this->mailResponses = $array['mailResponses'];
		if ($array['autoPublish'])
			$this->autoPublish = $array['autoPublish'];
		if ($array['numRetries'])
			$this->numRetries = $array['numRetries'];
		if ($array['minuteLimit'])
			$this->minuteLimit = $array['minuteLimit'];
		if ($array['showResultType'])
			$this->showResultType = $array['showResultType'];
		if ($array['description'])
			$this->description = $array['description'];
		if ($array['instructions'])
			$this->instructions = $array['instructions'];
		if ($array['possiblePoints'])
			$this->possiblePoints = $array['possiblePoints'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class AssessmentPeer {

	var $tableName = 'assessment';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("assessment",$where);
		$st->fields['assessment_id'] = 'assessment_id';
		$st->fields['display_name'] = 'display_name';
		$st->fields['class_id'] = 'class_id';
		$st->fields['date_available'] = 'date_available';
		$st->fields['date_unavailable'] = 'date_unavailable';
		$st->fields['mail_responses'] = 'mail_responses';
		$st->fields['auto_publish'] = 'auto_publish';
		$st->fields['num_retries'] = 'num_retries';
		$st->fields['minute_limit'] = 'minute_limit';
		$st->fields['show_result_type'] = 'show_result_type';
		$st->fields['description'] = 'description';
		$st->fields['instructions'] = 'instructions';
		$st->fields['possible_points'] = 'possible_points';

		$st->key = $this->key;
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = AssessmentPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("assessment");
		$st->fields['assessment_id'] = $this->assessmentId;
		$st->fields['display_name'] = $this->displayName;
		$st->fields['class_id'] = $this->classId;
		$st->fields['date_available'] = $this->dateAvailable;
		$st->fields['date_unavailable'] = $this->dateUnavailable;
		$st->fields['mail_responses'] = $this->mailResponses;
		$st->fields['auto_publish'] = $this->autoPublish;
		$st->fields['num_retries'] = $this->numRetries;
		$st->fields['minute_limit'] = $this->minuteLimit;
		$st->fields['show_result_type'] = $this->showResultType;
		$st->fields['description'] = $this->description;
		$st->fields['instructions'] = $this->instructions;
		$st->fields['possible_points'] = $this->possiblePoints;

		$st->key = 'assessment_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("assessment");
		$st->fields['assessment_id'] = $obj->assessmentId;
		$st->fields['display_name'] = $obj->displayName;
		$st->fields['class_id'] = $obj->classId;
		$st->fields['date_available'] = $obj->dateAvailable;
		$st->fields['date_unavailable'] = $obj->dateUnavailable;
		$st->fields['mail_responses'] = $obj->mailResponses;
		$st->fields['auto_publish'] = $obj->autoPublish;
		$st->fields['num_retries'] = $obj->numRetries;
		$st->fields['minute_limit'] = $obj->minuteLimit;
		$st->fields['show_result_type'] = $obj->showResultType;
		$st->fields['description'] = $obj->description;
		$st->fields['instructions'] = $obj->instructions;
		$st->fields['possible_points'] = $obj->possiblePoints;

		$st->key = 'assessment_id';
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
		$st = new LC_DeleteStatement("assessment","assessment_id = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

			$st = new LC_DeleteStatement("assessment_question","assessment_id = '".$obj->getPrimaryKey()."'");
			$db->executeQuery($st);
			$st = new LC_DeleteStatement("assessment_answer","assessment_id = '".$obj->getPrimaryKey()."'");
			$db->executeQuery($st);
		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new Assessment();
		$x->assessmentId = $row['assessment_id'];
		$x->displayName = $row['display_name'];
		$x->classId = $row['class_id'];
		$x->dateAvailable = $row['date_available'];
		$x->dateUnavailable = $row['date_unavailable'];
		$x->mailResponses = $row['mail_responses'];
		$x->autoPublish = $row['auto_publish'];
		$x->numRetries = $row['num_retries'];
		$x->minuteLimit = $row['minute_limit'];
		$x->showResultType = $row['show_result_type'];
		$x->description = $row['description'];
		$x->instructions = $row['instructions'];
		$x->possiblePoints = $row['possible_points'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class Assessment extends AssessmentBase {

	# When teacher is emailed, the from email address that is sent out
	var $emailFrom = WEBMASTER_EMAIL;

	# Total Assessment Points
	var $totalPoints = '';

	# Total Points Earned on Assessment
	var $pointsEarned = '';

	# total number of questions
	var $questionCount = '';

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
			$email = $db->Record['email'];
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
