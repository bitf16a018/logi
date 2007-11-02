<?php

/*
 * COMMENT ON CHANGES - 7/29/04 - MGK
 *
 * There were many instances of 
 * if (condition) { $answerObj->save(); }
 *
 * I've taken out the condition and the grade() methods should
 * now save answerObjs all the time.  I think this was done
 * earlier as an optimization, but seems to cause problems in 
 * some cases.  This change *may* cause problems if people 
 * were hoping that retaking a test would only recount newly submitted 
 * correct answers, as it'll now count all resubmitted answers, 
 * and lower your grade if you get it wrong the second time
 *
 * @package Assessments
 *
 */

define( 'QUESTION_TRUEFALSE',   1 );
define( 'QUESTION_MCHOICE',     2 );
define( 'QUESTION_MANSWER',     3 );
define( 'QUESTION_MATCHING',    4 );
define( 'QUESTION_FILLINBLANK', 5 );
define( 'QUESTION_ESSAY',       6 );


/**
 * True or False Type Questions
 * 
 * @package Assessments
 */
class AssessmentQuestionTrueFalse extends AssessmentQuestion {

	var $questionType = 1;

	function AssessmentQuestionTrueFalse() {

		$this->questionChoices[] = new AssessmentChoice('True');
		$this->questionChoices[] = new AssessmentChoice('False');
		$this->questionInput = AssessmentInput::getInput('multiple',$this);

		$this->questionDisplay = 'True/False';
	}


	/**
	 * Overriden for true false questions and radio buttons
	 */
	function resetLabels($postvars) {
		$this->questionChoices[0]->correct = false;
		$this->questionChoices[0]->label = 'True';
		$this->questionChoices[1]->correct = false;
		$this->questionChoices[1]->label = 'False';
		$this->questionChoices[$postvars['correct']]->correct = true;
	}


	/**
	 * Overriden for true false questions and radio buttons
	 */
	function setCorrectChoice($postvars) {
		$this->questionChoices[0]->correct = false;
		$this->questionChoices[1]->correct = false;
		$this->questionChoices[$postvars['correct']]->correct = true;
	}


	function validate()
	{
		# Check the question
		$this->questionText = trim(strip_tags($this->questionText));
		if ($this->questionText == '')
		{
			$error = '<li>Please enter a question.</li>';
		}

		# Check the answers
		if ( !($this->questionChoices[0]->correct || $this->questionChoices[1]->correct) ) 
		{
			$error .= '<li>Please select an answer.</li>';
		}
	
		# Return error if there is one.
		if ($error)
		{
			return '<ul style="color: red;">'.$error.'</ul>';
		}
		return false;
	}

	function grade(&$answerObj) {
		$correct = $this->getCorrectAnswer();
		if (strtolower($answerObj->assessmentAnswerValues) == $correct) {
			if ($answerObj->pointsEarned != $this->questionPoints ) {
				$answerObj->set('pointsEarned',$this->questionPoints);
			}
		} else {
				//they got it wrong, if it's new then insert a 0,
				// if it's old && different, then save
				if ( $answerObj->isNew() ) {
					$answerObj->set('pointsEarned',0);
				}
				if ( $answerObj->pointsEarned != $this->questionPoints ) {
					$answerObj->set('pointsEarned',0);
				}
		}
		$answerObj->save();
	}

	function getCorrectAnswer() {
		$count = count($this->questionChoices);
		for ($i=0; $i<$count; $i++) {
			if ($this->questionChoices[$i]->correct) {
				return strtolower($this->questionChoices[$i]->label);	
			}
		}
	}


	function isCorrect() {
		$correct = $this->getCorrectAnswer();
		if (strtolower($this->answer->assessmentAnswerValues) == $correct) {
			return TRUE;
		}
		return FALSE;
	}
}


/**
 * Multiple Choice Type Questions
 * 
 * @package Assessments
 */
class AssessmentQuestionMChoice extends AssessmentQuestion {

	var $questionType = 2;

	function AssessmentQuestionMChoice() {
		$this->questionChoices = array ();
		for ($x=0; $x<10; ++$x) {
			$this->questionChoices[] = new AssessmentChoice('');
		}
		$this->questionInput = AssessmentInput::getInput('multiple',$this);

		$this->questionDisplay = 'Multiple Choice';
	}



	/**
	 * Overriden to make the question choices sorted properly
	 * what is happening is the correct answer was always showing as
	 * option 2 for MChoice questions
	 */
	function resetLabels($postvars) {

		$this->questionChoices = array();

		while (list ($k,$v) = each($postvars['labels']) ) {
		// added per phone with mark 10/18/03 10:55pm 
			if ( trim(strip_tags($v)) == '' ) continue;
			$qc = new AssessmentChoice();
			$qc->label = stripslashes($v);

			# If it is mutiple choice we need to do a little different type of save
			if ( $postvars['correct'] == $k ) {
				$qc->correct = true;
			}

			$this->questionChoices[] = $qc;
		}

	}


	/**
	 * needed for special layout of template for mchoices
	 */
	function setCorrectChoice($postvars) {

		while (list ($k,$v) = each($this->questionChoices) ) {
			# If it is mutiple choice we need to do a little different type of save
			if ( $postvars['correct'] == $k ) {
				$this->questionChoices[$k]->correct = true;
			} else {
				$this->questionChoices[$k]->correct = false;
			}
		}
	}



	function validate() {
		# Check the question
		$this->questionText = trim(strip_tags($this->questionText));
		if ($this->questionText == '') { 
			$error = '<li>Please enter a question.</li>';
		}

		$count = count($this->questionChoices);
		for ($i=0; $i<$count; $i++) {
			$this->questionChoices[$i]->label =	trim(strip_tags($this->questionChoices[$i]->label));
			if ($this->questionChoices[$i]->label != '') {
				++$labels;
			}

			if ($this->questionChoices[$i]->correct) {
				++$correct;
			}
		}

		if ($labels< 2) {
			$error .= '<li>You must specify at least two possible answers.</li>';
		}

		if ($correct < 1) {
			$error .= '<li>You must choose at least one correct answer.</li>';
		}

		if ($correct > 1) {
			$error .= '<li>You can only select one answer for this type of question.</li>';
		}

		# Return error if there is one.
		if ($error) {
			return '<ul style="color: red;">'.$error.'</ul>';
		}
		return false;
	}


	function grade(&$answerObj) {

		$correct = $this->getCorrectAnswer();
		if (strtolower($answerObj->assessmentAnswerValues) == $correct) {
			// mgk - 7/10/04
			// this doesn't make any sense
			// why would points earned NOT be the questionpoints for a multiple choice?
			// may make sense for situations where you can have partial points - 
		        // can't tell here.  going to test without this check.	
			#	if ($answerObj->pointsEarned != $this->questionPoints ) {
				$answerObj->set('pointsEarned',$this->questionPoints);
			#}
		} else {
				//they got it wrong, if it's new then insert a 0,
				// if it's old && different, then save
				if ( $answerObj->isNew() ) {
					$answerObj->set('pointsEarned',0);
				}
				// see above
				#if ( $answerObj->pointsEarned != $this->questionPoints ) {
					$answerObj->set('pointsEarned',0);
				#}
		}
		$answerObj->save();
	}

	// 7/10/04 - mgk
	// changed to deal with numeric value of option rather than full 'label' value
	// part of this is a size issue - perhaps we can optimize the database tables
	// because of this
	// but it's more an issue of data corruption when weird values are multiple choice options
	// example
	// Which is correct?
	// 1. I'm going to "hit" you.
	// 2. I'm going to 'hit' you.
	// 3. I am a gonna' "hit" you.
	// Storing quotes is awkward.

	function getCorrectAnswer() {
		$count = count($this->questionChoices);
		for ($i=0; $i<$count; $i++) {
			// __FIXME__ - is 1/0 binary checking here for 'correct' good enough?
			if ($this->questionChoices[$i]->correct) {
				return $i;
			}
		}

		return false;
	}

	function isCorrect() {
		$correct = $this->getCorrectAnswer();
		if (strtolower($this->answer->assessmentAnswerValues) === strtolower($correct)) {
			return TRUE;
		}
		return FALSE;

	}
	
	// mgk 8/14/04
	// for some reason the 'grade' template was calling 
	// returnCorrectAnswers for what the student submitted???
	function returnStudentAnswer() {
		$answer = $this->answer->assessmentAnswerValues;
		$str = chr($answer+65);
		return $str;
	}

	
}


/**
 * Multiple Answer Type Questions
 * 
 * @package Assessments
 */
class AssessmentQuestionMAnswer extends AssessmentQuestion {

	var $allowMultiple = true;
	var $questionType = 3;

	function AssessmentQuestionMAnswer() {
		$this->questionChoices = array ();
		for ($x=0; $x<10; ++$x) {
			$this->questionChoices[] = new AssessmentChoice('');
		}
		$this->questionInput = AssessmentInput::getInput('multiple',$this);
		$this->questionDisplay = 'Multiple Answer';
	}


	/**
	 * needed for special layout of template for manswer
	 */
	function setCorrectChoice($postvars) {
		while (list ($k,$v) = each($this->questionChoices) ) {
			# If it is mutiple choice we need to do a little different type of save
			if ( $postvars['correct'][$k] == 'On' ) {
				$this->questionChoices[$k]->correct = true;
			} else {
				$this->questionChoices[$k]->correct = false;
			}
		}
	}



	function validate() {
		# Check the question
		$this->questionText = trim(strip_tags($this->questionText));
		if ($this->questionText == '') {
			$error = '<li>Please enter a question.</li>';
		}

		$count = count($this->questionChoices);
		for ($i=0; $i<$count; $i++) {
			$this->questionChoices[$i]->label =	trim(strip_tags($this->questionChoices[$i]->label));
			if ($this->questionChoices[$i]->label != '') {
				++$labels;
			}

			if ($this->questionChoices[$i]->correct) {
				++$correct;
			}
		}

		if ($labels< 2) {
			$error .= '<li>You must specify at least two possible answers.</li>';
		}

		if ($correct < 1) {
			$error .= '<li>You must choose at least one correct answer.</li>';
		}


		# Return error if there is one.
		if ($error) {
			return '<ul style="color:red;">'.$error.'</ul>';
		}
		return false;
	}


	function grade(&$answerObj) {
		$correct = $this->getCorrectAnswer();

		//the AssessmentAnswerObject should be unserializing for us
		// why is this unserialize here?  Unit tests aren't pulling
		// from the DB so they are already unserialized
		if ( is_array($answerObj->assessmentAnswerValues) ) {
			$answers = $answerObj->assessmentAnswerValues;
			$answerObj->assessmentAnswerValues = serialize($answers);
		} else {
			$answers = unserialize($answerObj->assessmentAnswerValues);
		}

		$numCorrect = 0;
		$definedCorrect= count($correct);


		// mgk 7/11/04
		// array diff DOES work - or can be made to 
		//
		$diffCount = count(array_diff($answers,$correct));
		
		
		// mgk 7/11/04
		// __FIXME__ do we give partial credit for only some right, 
		// or if they get all right but a fudge-factor wrong?  
		// for 2 choices out of 4, allowing 3 guesses woudln't make sense,
		// but what about choosing 8 out of 24, for example?  If 9 were chosen, 
		// and 8 were correct with 1 extra wrong, should the whole question be 'wrong'?

		// if the diffCount ==0, we have a perfect match		
		if ($diffCount==0) {
			//we don't want to save all the time so...
//			if ( $answerObj->pointsEarned != $this->questionPoints )
// mgk - 7/11/04 - WHY NOT SAVE ALL THE TIME?
// premature optimization, it seems, here, and until it's all 110% tested, 
// why not be sure and save it every time?
			$answerObj->set('pointsEarned',$this->questionPoints);
		} else {
			// WRONG
			// why bother checking here? mgk 7/11/04
//			if ( $answerObj->pointsEarned != 0 )
			$answerObj->set('pointsEarned',0);
		}

		$answerObj->save();
	}


	function getCorrectAnswer() {
		$count = count($this->questionChoices);
		for ($i=0; $i<$count; $i++) {
			if ($this->questionChoices[$i]->correct!='') {
				$x[$i] = $i; 
			}
		}
		return $x;
	}


	function isCorrect() {
		$correct = $this->getCorrectAnswer();
		$answer = $this->answer->assessmentAnswerValues;

		//array walk doesn't work with built in functions
		foreach($correct as $k=>$v) {
			$correct[$k] = strtolower($correct[$k]);
		}
		foreach($answer as $k=>$v) {
			$answer[$k] = strtolower($answer[$k]);
		}


		foreach($correct as $k=>$v) {
			if (! in_array($correct[$k],$answer) )
			return FALSE;
		}

		foreach($answer as $k=>$v) {
			if (! in_array($answer[$k],$correct) )
			return FALSE;
		}

		return TRUE;
	}


	function returnCorrectAnswers() {
		$correct = $this->getCorrectAnswer();
		foreach($correct as $k=>$v) { 
			$temp[] = chr($v+65);
		}
		$str = implode(", ", $temp);
		return $str;
	}
	
	// mgk 8/14/04
	// for some reason the 'grade' template was calling 
	// returnCorrectAnswers for what the student submitted???
	function returnStudentAnswer() {
		$answer = $this->answer->assessmentAnswerValues;
		foreach($answer as $k=>$v) { 
			$temp[] = chr($v+65);
		}
		$str = implode(", ", $temp);
		return $str;
	}

}


/**
 * Matching Type Questions
 * 
 * @package Assessments
 */
class AssessmentQuestionMatching extends AssessmentQuestion {

	var $questionType = 4;

	function AssessmentQuestionMatching() {
		$this->questionChoices = array ();

		$this->questionInput = AssessmentInput::getInput('matching',$this);

		$this->questionDisplay = 'Matching';
	}


	function validate() {

		$questionCount = $answerCount = 0;
		
		// make sure they put in a Question/Instructions
		$this->questionText = trim(strip_tags($this->questionText));
		if ($this->questionText == '') $error = '<li>Please enter a question.</li>';

		// make sure they have an answer for every question (but not necessarily vice versa)
		foreach ( $this->questionChoices as $key => $choice ) {
			if ( $key == 'randomAnswers' ) continue;
			if ( trim(strip_tags($choice->label)) || trim(strip_tags($choice->correct)) )
				continue;
			$error .= '<li>You must have an answer for every question.</li>';
			break;
		}

		// make sure they have at least two questions and answers
		if ( count($this->questionChoices) < 2 )
			$error .= '<li>You must have at least 2 question/answer pairs.';
		
		if ($error) return '<ul style="color:red;">'.$error.'</ul>';
		return false;
	}



	function resetLabels($postvars) {
		foreach ( $postvars['labels'] as $key => $question) {

			if ( trim(strip_tags($question)) == '' ) continue;
#debug($postvars['correct'],1);
			$qc = new AssessmentChoice();
			$qc->label = htmlentities(stripslashes($question), ENT_QUOTES);
			$qc->correct = htmlentities(stripslashes($postvars['correct'][$key]), ENT_QUOTES);
			
#			$this->questionChoices[] = $qc;

			// update object
			$this->questionChoices[$key] = $qc;
		}
		$this->setCorrectChoice($postvars);
	}


	function setCorrectChoice($postvars) {
		foreach ( $postvars['correct'] as $key => $answer) {
			++$newkey;
			if ( trim($answer) == '' ) continue;
			
			$answer = htmlentities(stripslashes($answer),ENT_QUOTES);
			// store this for later use in the template
			$randomAnswers[$newkey][$key] = $answer;

			$this->questionChoices[$key]->correct =  $answer;
		}

		// mgk 7/29/04 - commented out
		// mgk - 8/15/04 - commented in for matching ????
		shuffle( $randomAnswers );
	
		$this->questionChoices['randomAnswers'] = $randomAnswers;
	}


	function grade(&$answerObj) {
#	debug($answerObj);
#	debug($this,1);

		$correct = $this->getCorrectAnswer();
		$answers = unserialize($answerObj->assessmentAnswerValues);
		$count = count ($correct);

#debug($this);
#debug($answers);
#debug($correct,1);
		for($i=0; $i<$count; $i++) {
			if ($correct[$i] == $answers[$i]) {
				$num_correct++;
			}
		}

		if ($num_correct == $this->questionPoints ) {
			$answerObj->set('pointsEarned',$this->questionPoints);
		} else {

			//they got it wrong, insert a 0,
			$score = floor($this->questionPoints * ($num_correct/$count));
			$answerObj->set('pointsEarned',$score);
		}
		
		$answerObj->save();

	}

	function getCorrectAnswer() {
		$count = count($this->questionChoices);
		for ($i=0; $i<$count; $i++) {
			if ($this->questionChoices[$i]->label) {
					$x[$i] =  $this->questionChoices[$i]->correct;	
			}
		}
		return $x;
	}


		
}


/**
 * Fill in the Blank Type Questions
 * 
 * @package Assessments
 */
class AssessmentQuestionFill extends AssessmentQuestion {

	var $questionType = 5;

	function AssessmentQuestionFill() {
		$this->questionChoices = array ();
		for ($x=0; $x<5; ++$x) {
			$this->questionChoices[] = new AssessmentChoice('');
		}
		$this->questionInput = AssessmentInput::getInput('text',$this);

		$this->questionDisplay = 'Fill in the Blank';
	}


	/**
	 * All fill in the blank choices are true
	 */
	function resetLabels($postvars) {

		$this->questionChoices = array();

		while (list ($k,$v) = each($postvars['labels']) ) {
			if (trim($v) == '' ) continue;
			$qc = new AssessmentChoice();
			$qc->label = stripslashes($v);

			$qc->correct = true;
			$this->questionChoices[] = $qc;
		}

	}



	function validate() {
		# Check the question
		$this->questionText = trim(strip_tags($this->questionText));
		if ($this->questionText == '') {
			$error = '<li>Please enter a question.</li>';
		}

		$this->questionChoices[0]->label  = trim(strip_tags($this->questionChoices[0]->label));
		if ($this->questionChoices[0]->label  == '') {
			$error .= '<li>You must specify an answer.</li>';
		}

		# Return error if there is one.
		if ($error) {
			return '<div style="color: red;"><ul>'.$error.'</ul></div>';
		}
		
		// mgk - 07/25/04 - what the heck?  return false or an error string???
		return false;
	}


	function grade(&$answerObj) {
		//this is an ARRAY!!
		$correct = $this->getCorrectAnswer();
		// mgk 7/25/04 - both getCorrectAnswer and this guess are strtolower just to be sure
		// this would prevent someone from checking capitalization as an aspect of the test
		// just should be documented - I don't think this is a big drawback at this time.
		$guess = strtolower($answerObj->assessmentAnswerValues);

		$gotItRight = false;
		foreach($correct as $blank=>$c) {
			if( $guess == $c ) { $gotItRight = true; }
		}
		if ($gotItRight) {
			$answerObj->set('pointsEarned',$this->questionPoints);
		} else {
			$answerObj->set('pointsEarned',0);
		}
		$answerObj->save();
	}


	function getCorrectAnswer() {
		$count = count($this->questionChoices);
		$x = array();
		for ($i=0; $i<$count; $i++) {
			if ($this->questionChoices[$i]->label) {
				$x[] = strtolower($this->questionChoices[$i]->label);	
			}
		}
		return $x;
	}

	function isCorrect() {
		$correct = $this->getCorrectAnswer();	
		if (in_array(strtolower($this->answer->assessmentAnswerValues), strtolower($correct))) {
			return TRUE;
		}
		return FALSE;

	}

}


/**
 * Essay Type Questions
 * 
 * @package Assessments
 */
class AssessmentQuestionEssay extends AssessmentQuestion {

	var $questionType = 6;

	function AssessmentQuestionEssay() {
		$this->questionChoices = array ();
		$this->questionChoices[] = new AssessmentChoice('Enter your answer below');

		$this->questionInput = AssessmentInput::getInput('textarea',$this);

		$this->questionDisplay = 'Short Essay';
	}

	function validate() {
		# Check the question
		$this->questionText = trim(strip_tags($this->questionText));
		if ($this->questionText == '') {
			$error = '<li>Please enter a question.</li>';
		}

		# Return error if there is one.
		if ($error) {
			return '<div style="color: red;"><ul>'.$error.'</ul></div>';
		}
		return false;
	}

	function grade(&$answerObj) {
		// teacher needs to grade this one by hand
		$answerObj->pointsEarned = 0;
		$answerObj->save();

	}


}


/**
 * Test for Automatic Validation
 * 
 * @package Assessments
 * @deprecated
 */
class AssessmentQuestionConstraint {

	var $minVal;
	var $maxVal;
	var $char = false;		//response must be character based
	var $num =  false;		//response must be numeric
	var $mult = false;		//multiple responses allowed


	function mustBeChar() {
		return $this->char;
	}

	function mustBeNumeric() {
		return $this->num;
	}

}


/**
 * Choice Type Question
 * 
 * @package Assessments
 */
class AssessmentChoice {

	var $rank;
	var $other = false;	//if it's an other choice allow user input
	var $label;
	var $correct = false;

	function AssessmentChoice($l) {
		$this->label = $l;
	}


	//return an object for testing
	function & getTest() {
		$x = new AssessmentChoice();
		$x->label = 'Your age';
	return $x;
	}

	function isCorrect() {
		return $this->correct;
	}
}

/**
 * Define Interface for Assessment Input
 * 
 * @abstract
 * @package Assessments
 */
class AssessmentInput {

	var $label;
	var $question;
	var $allowMultiple = false;


	function & getInput($t,&$z) {

//		print "inside getInput with id of $z->id <br><br>\n\n";
		switch($t) {
			case 'single':
				$x= new AssessmentInputText();
				break;
			case 'multiple':
				if ($z->allowMultiple) {
					$x= new AssessmentInputCheckbox();
				} else {
					$x= new AssessmentInputRadio();
				}
				break;
			case 'textarea':
				$x = new AssessmentInputArea();
				break;
			case 'matching':
				$x = new AssessmentInputMatching();
				break;
			default:
				$x= new AssessmentInputText();
		}

		#		$x->question = &$z;
	return $x;
	}
}


/**
 * Input Widgest for Input Boxes
 * @package Assessments
 */
class AssessmentInputText extends AssessmentInput {

	function render() {
		for ($x=0; $x< count($this->question->questionChoices); $x++) {
			$choice = $this->question->questionChoices[$x];
			$ret .= $choice->label.' <br>';
			$ret .='<input type="text" name="assessment['.$this->question->assessmentQuestionId.']"><br>';
		}
	return $ret;
	}

}


/**
 * Input Widgest for Dropdowns
 * @package Assessments
 */
class AssessmentInputSelect extends AssessmentInput {

	function render() {
		if ($this->allowMultiple) { $mul = 'MULTIPLE'; }
		$ret .='<select name="assessment['.$this->question->assessmentQuestionId.']" '.$mul.'>';
		for ($x=0; $x< count($this->question->questionChoices); $x++) {
			$ret .= '<option value="'.$x.'">'.$this->question->questionChoices[$x]->label.'</option>';
		}
		$ret .='</select>';
	return $ret;
	}


	function getTest() {
		return new AssessmentInputSelect();
	}
}


/**
 * Input Widgest for Essays
 * @package Assessments
 */
class AssessmentInputArea extends AssessmentInput {
	function render() {
		for ($x=0; $x< count($this->question->questionChoices); $x++) {
			$choice = $this->question->questionChoices[$x];	
			$ret .= $choice->label.' <br>';
			$ret .='<textarea cols="80" rows="10" name="'.$this->question->assessmentQuestionId.'"></textarea><br>';
		}
	return $ret;
	}
}


/**
 * Input Widget for Checkboxes
 * @package Assessments
 */
class AssessmentInputCheckbox extends AssessmentInput {
	function render() {
		for ($x=0; $x< count($this->question->questionChoices); $x++) {
			$choice = $this->question->questionChoices[$x];	
			$ret .='<input type="checkbox" name="'.$this->question->assessmentQuestionId.'[]" value="'.htmlspecialchars($x,ENT_QUOTES).'">&nbsp;';
			$ret .= $choice->label.' <br>';
		}
	return $ret;
	}
}


/**
 * Input Widget for Radio Buttons
 * @package Assessments
 */
class AssessmentInputRadio extends AssessmentInput {
	function render() {
		for ($x=0; $x< count($this->question->questionChoices); $x++) {
			$choice = $this->question->questionChoices[$x];	
			$ret .='<input type="radio" name="'.$this->question->assessmentQuestionId.'" value="'.$x.'">&nbsp;';
			$ret .= $choice->label.' <br>';
		}
	return $ret;
	}
}


/**
 * Input Widget for Matching Questions
 * @package Assessments
 */
class AssessmentInputMatching extends AssessmentInput {
	function render() {
		for ($x=0; $x< count($this->question->questionChoices); $x++) {
			$choice = $this->question->questionChoices[$x];	
			list ($c,$a) = explode('|:|',$choice->label);
			$right[] = $c;
			$opts .= '<option>'.$a.'</option>';
		}

		while (list (,$v) = @each($right) ) {
			$ret .= '<select>'.$opts.'</select>';
			$ret .= '&nbsp;&nbsp;&nbsp;';
			$ret .= $v;
			$ret .= '<br/>';
		}
		
	return $ret;
	}
}
?>
