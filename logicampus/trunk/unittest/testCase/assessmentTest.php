<?

require_once(SERVICE_PATH.'testCase/unitTest.php');

class assessmentTest extends unitTest {

	var $tests = array (
		'Load Assessment'=> array ('name'=>'load','expected'=>1),
		'Answer Questions'=> array ('name'=>'answer','expected'=>1), 
		'Score Questions'=> array ('name'=>'score','expected'=>1),
		'Save Questions'=> array ('name'=>'saveQuestions','expected'=>1),
		'Save Score'=> array ('name'=>'saveScore','expected'=>1)
		);

	var $description = "Tests the taking, scoring, and grading of a test (an assessment).";

	var $assessment_id; //int for holding assessment id

	/**
	 * default constructor, init some data here for 
	 * the other Test() functions to use
	 */
	function assessmentTest() {
		$this->assessment_id = 1;
		$this->class_id = 2;
		include(LIB_PATH.'Assessment.php');
		include_once(LIB_PATH.'AssessmentQuestion.php');
		include_once(LIB_PATH.'AssessmentLib.php');
		include_once(LIB_PATH.'AssessmentAnswer.php');
	}


	/**
	 */
	function loadTest() {
		$assessment = Assessment::load($this->assessment_id,$this->class_id);
		return get_class($assessment) == 'Assessment';
	}

	/**
	 */
	function answerTest() {
		$assessment = Assessment::load($this->assessment_id,$this->class_id);

		$questions = $assessment->getAssessmentQuestions();

		$answers = array();
		$answers[0] = new AssessmentAnswer();
		$answers[0]->assessmentAnswerValues = 0;

		$answers[1] = new AssessmentAnswer();
		$answers[1]->assessmentAnswerValues = array(0=>0,2=>2);

		//assume some order, I'm sure other code does it too,
		// probably should make a test to explicitly test the ordering
		$q1 = $questions[0];
		$correct1 = $q1->getCorrectAnswer();

		$q2 = $questions[1];
		$correct2 = $q2->getCorrectAnswer();

		if ( $answers[1]->assessmentAnswerValues === $correct2) {
			return true;
		} else {
			return false;
		}

	}

	/**
	 */
	function scoreTest() {
	}

	/**
	 */
	function saveQuestionsTest() {
	}

	/**
	 */
	function saveScoreTest() {
	}

}


?>
