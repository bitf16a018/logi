<?php

define( QUESTION_TRUEFALSE, 1 );
define( QUESTION_MCHOICE, 2 );
define( QUESTION_MANSWER, 3 );
define( QUESTION_MATCHING, 4 );
define( QUESTION_FILLINBLANK, 5 );
define( QUESTION_ESSAY, 6 );

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

	function grade(&$answerObj)
	{
		$correct = $this->getCorrectAnswer();
		if (strtolower($answerObj->assessmentAnswerValues) == $correct)
		{
			if ($answerObj->pointsEarned != $this->questionPoints ) {
				$answerObj->set('pointsEarned',$this->questionPoints);
				$answerObj->save();
			}
		} else {
				//they got it wrong, if it's new then insert a 0,
				// if it's old && different, then save
				if ( $answerObj->isNew() ) {
					$answerObj->set('pointsEarned',0);
					$answerObj->save();
				}
				if ( $answerObj->pointsEarned != $this->questionPoints ) {
					$answerObj->set('pointsEarned',0);
					$answerObj->save();
				}
		}
	}

	function getCorrectAnswer()
	{
		$count = count($this->questionChoices);
		for ($i=0; $i<$count; $i++)
		{
			if ($this->questionChoices[$i]->correct)
			{
				return strtolower($this->questionChoices[$i]->label);	
			}
		}
	}


	function isCorrect()
	{
		$correct = $this->getCorrectAnswer();
		if (strtolower($this->answer->assessmentAnswerValues) == $correct)
		{
			return TRUE;
		}
		return FALSE;
	}
}


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
		if ($this->questionText == '')
		{
			$error = '<li>Please enter a question.</li>';
		}

		$count = count($this->questionChoices);
		for ($i=0; $i<$count; $i++)
		{
			$this->questionChoices[$i]->label =	trim(strip_tags($this->questionChoices[$i]->label));
			if ($this->questionChoices[$i]->label != '')
			{
				++$labels;
			}

			if ($this->questionChoices[$i]->correct)
			{
				++$correct;
			}
		}

		if ($labels< 2)
		{
			$error .= '<li>You must specify at least two possible answers.</li>';
		}

		if ($correct < 1)
		{
			$error .= '<li>You must choose at least one correct answer.</li>';
		}

		if ($correct > 1)
		{
			$error .= '<li>You can only select one answer for this type of question.</li>';
		}

		# Return error if there is one.
		if ($error)
		{
			return '<ul style="color: red;">'.$error.'</ul>';
		}
		return false;
	}

	function grade(&$answerObj)
	{
		$correct = $this->getCorrectAnswer();
		if (strtolower($answerObj->assessmentAnswerValues) == $correct)
		{
			if ($answerObj->pointsEarned != $this->questionPoints ) {
				$answerObj->set('pointsEarned',$this->questionPoints);
				$answerObj->save();
			}
		} else {
				//they got it wrong, if it's new then insert a 0,
				// if it's old && different, then save
				if ( $answerObj->isNew() ) {
					$answerObj->set('pointsEarned',0);
					$answerObj->save();
				}
				if ( $answerObj->pointsEarned != $this->questionPoints ) {
					$answerObj->set('pointsEarned',0);
					$answerObj->save();
				}
		}
	}

	function getCorrectAnswer()
	{
		$count = count($this->questionChoices);
		for ($i=0; $i<$count; $i++)
		{
			if ($this->questionChoices[$i]->correct)
			{
				return strtolower($this->questionChoices[$i]->label);	
			}
		}

		return false;
	}

	function isCorrect()
	{
		$correct = $this->getCorrectAnswer();
		if (strtolower($this->answer->assessmentAnswerValues) == $correct)
		{
			return TRUE;
		}
		return FALSE;

	}
}

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



	function validate()
	{
		# Check the question
		$this->questionText = trim(strip_tags($this->questionText));
		if ($this->questionText == '')
		{
			$error = '<li>Please enter a question.</li>';
		}

		$count = count($this->questionChoices);
		for ($i=0; $i<$count; $i++)
		{
			$this->questionChoices[$i]->label =	trim(strip_tags($this->questionChoices[$i]->label));
			if ($this->questionChoices[$i]->label != '')
			{
				++$labels;
			}

			if ($this->questionChoices[$i]->correct)
			{
				++$correct;
			}
		}

		if ($labels< 2)
		{
			$error .= '<li>You must specify at least two possible answers.</li>';
		}

		if ($correct < 1)
		{
			$error .= '<li>You must choose at least one correct answer.</li>';
		}


		# Return error if there is one.
		if ($error)
		{
			return '<ul style="color:red;">'.$error.'</ul>';
		}
		return false;
	}


	function grade(&$answerObj)
	{
		$correct = $this->getCorrectAnswer();
		$answers = unserialize($answerObj->assessmentAnswerValues);
		$numCorrect = 0;


		foreach ($answers as $k => $answer) {
			$answers[$k] = stripslashes($answer);
		}
		$c_count = count($correct);
		for ($x=0; $x<$c_count; $x++) {
			$correct[$x] = strtolower($correct[$x]);
		}
		$a_count = count($answers);
		for ($x=0; $x<$a_count; $x++) {
			$answers[$x] = strtolower($answers[$x]);
		}


		//array diff doesn't work
		// add one to num correct for every answer that is right
		// subtract one to num correct for every answer that is not right
		for ($x=0; $x<$a_count; $x++)
		{
			if ( in_array($answers[$x],$correct) )
			$numCorrect++;
			else
			$numCorrect--;
		}

		// the number of corret answers exactly matches the 
		// number of defined correct answers, IT'S RIGHT
		if ($numCorrect == $c_count) {
			//we don't want to save all the time so...
			if ( $naswerObj->pointsEarned != $this->questionPoints )
			$naswerObj->set('pointsEarned',$this->questionPoints);
		} else {
			// WRONG
			if ( $naswerObj->pointsEarned != 0 )
			$answerObj->set('pointsEarned',0);
		}

		$answerObj->save();
	}


	function getCorrectAnswer()
	{
		$count = count($this->questionChoices);
		for ($i=0; $i<$count; $i++)
		{
			if ($this->questionChoices[$i]->correct)
			{
				$x[] =  stripslashes(strtolower($this->questionChoices[$i]->label));
			}
		}
		return $x;
	}

	function isCorrect()
	{
		$correct = $this->getCorrectAnswer();
		$answer = $this->answer->assessmentAnswerValues;

		//array walk doesn't work with built in functions
		$c_count = count($correct);
		for ($x=0; $x<$c_count; $x++) {
			$correct[$x] = strtolower($correct[$x]);
		}
		$a_count = count($answer);
		for ($x=0; $x<$a_count; $x++) {
			$answer[$x] = strtolower($answer[$x]);
		}


		for ($x=0; $x<$c_count; $x++)
		{
			if (! in_array($correct[$x],$answer) )
			return FALSE;
		}

		for ($x=0; $x<$a_count; $x++)
		{
			if (! in_array($answer[$x],$correct) )
			return FALSE;
		}

		return TRUE;
	
	}


	function returnCorrectAnswers() {
		$correct = $this->getCorrectAnswer();
		$count = count($correct);
		$str = implode(", ", $correct);
		return $str;
	}

}


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

			$qc = new AssessmentChoice();
			$qc->label = stripslashes($question);
			$qc->correct = $postvars['correct'][$key];
			$this->questionChoices[] = $qc;

			// update object
			$this->questionChoices[$key] = $qc;
		}

		$this->setCorrectChoice($postvars);
	}


	function setCorrectChoice($postvars) {
		foreach ( $postvars['correct'] as $key => $answer) {
			++$newkey;
			if ( trim($answer) == '' ) continue;
			// store this for later use in the template
			$randomAnswers[$newkey][$key] = $answer;

			$this->questionChoices[$key]->correct =  $answer;
		}

		shuffle( $randomAnswers );
	
		$this->questionChoices['randomAnswers'] = $randomAnswers;
	}


	function grade(&$answerObj)
	{


		$correct = $this->getCorrectAnswer();
		$answers = unserialize($answerObj->assessmentAnswerValues);
		$count = count ($correct);

		for($i=0; $i<$count; $i++)
		{
			if ($correct[$i] == $answers[$i])
			{
				$num_correct++;
			}
		}


		if ($answerObj->pointsEarned != $this->questionPoints ) {
			$answerObj->set('pointsEarned',$this->questionPoints);
			$answerObj->save();
		} else {

			//they got it wrong, if it's new then insert a 0,
			// if it's old && different, then save
			if ( $answerObj->isNew() ) {
				$answerObj->set('pointsEarned',0);
				$answerObj->save();
			}
		}

	}

	function getCorrectAnswer()
	{
		$count = count($this->questionChoices);
		for ($i=0; $i<$count; $i++)
		{
			if ($this->questionChoices[$i]->label)
			{
					$x[$i] =  $this->questionChoices[$i]->correct;	
			}
		}
		return $x;
	}


		
}


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
		if ($this->questionText == '')
		{
			$error = '<li>Please enter a question.</li>';
		}

		$this->questionChoices[0]->label  = trim(strip_tags($this->questionChoices[0]->label));
		if ($this->questionChoices[0]->label  == '')
		{
			$error .= '<li>You must specify an answer.</li>';
		}

		# Return error if there is one.
		if ($error)
		{
			return '<div style="color: red;"><ul>'.$error.'</ul></div>';
		}
		return false;
	}


	function grade(&$answerObj)
	{
		//this is an ARRAY!!
		$correct = $this->getCorrectAnswer();
		$guess = strtolower($answerObj->assessmentAnswerValues);

		$gotItRight = false;
		foreach($correct as $blank=>$c) {
			if( $guess == $c ) { $gotItRight = true; }
		}
		if ($gotItRight)
		{
			if ($answerObj->pointsEarned != $this->questionPoints ) {
				$answerObj->set('pointsEarned',$this->questionPoints);
				$answerObj->save();
			}
		} else {
				//they got it wrong, if it's new then insert a 0,
				// if it's old && different, then save
				if ( $answerObj->isNew() ) {
					$answerObj->set('pointsEarned',0);
					$answerObj->save();
				}
				if ( $answerObj->pointsEarned != $this->questionPoints ) {
					$answerObj->set('pointsEarned',0);
					$answerObj->save();
				}
		}

	}


	function getCorrectAnswer()
	{
		$count = count($this->questionChoices);
		$x = array();
		for ($i=0; $i<$count; $i++)
		{
			if ($this->questionChoices[$i]->label)
			{
				$x[] = strtolower($this->questionChoices[$i]->label);	
			}
		}
		return $x;
	}

	function isCorrect()
	{
		$correct = $this->getCorrectAnswer();	
		if (in_array(strtolower($this->answer->assessmentAnswerValues), $correct))
		{
			return TRUE;
		}
		return FALSE;

	}

}


class AssessmentQuestionEssay extends AssessmentQuestion {

	var $questionType = 6;

	function AssessmentQuestionEssay() {
		$this->questionChoices = array ();
		$this->questionChoices[] = new AssessmentChoice('Enter your answer below');

		$this->questionInput = AssessmentInput::getInput('textarea',$this);

		$this->questionDisplay = 'Short Essay';
	}

	function validate()
	{
		# Check the question
		$this->questionText = trim(strip_tags($this->questionText));
		if ($this->questionText == '')
		{
			$error = '<li>Please enter a question.</li>';
		}

		# Return error if there is one.
		if ($error)
		{
			return '<div style="color: red;"><ul>'.$error.'</ul></div>';
		}
		return false;
	}

	function grade(&$answerObj)
	{
		// teacher needs to grade this one by hand
		$answerObj->pointsEarned = 0;
		if ($answerObj->isNew() ) {
			$answerObj->save();
		} else {
			if ($answerObj->pointsEarned != 0 ) {
				$answerObj->save();
			}
		}
	}


}
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
 * @abstract
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

		$x->question = &$z;
	return $x;
	}
}

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
