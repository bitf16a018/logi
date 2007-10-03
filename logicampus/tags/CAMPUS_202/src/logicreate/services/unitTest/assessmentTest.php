<?


class assessmentTest extends UnitTestCase {

	var $tests = array (
		'Load Assessment'=> array ('name'=>'load','expected'=>1),
		'Answer Questions'=> array ('name'=>'answer','expected'=>1), 
		'Score Questions'=> array ('name'=>'score','expected'=>1),
		'Save Answers'=> array ('name'=>'saveAnswers','expected'=>1),
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
		$this->class_id = 1;
		include(LIB_PATH.'Assessment.php');
		include_once(LIB_PATH.'AssessmentQuestion.php');
		include_once(LIB_PATH.'AssessmentLib.php');
		include_once(LIB_PATH.'AssessmentAnswer.php');
	}


	/**
	 */
	function testLoad() {
		$assessment = Assessment::load($this->assessment_id,$this->class_id);
		$this->assertEqual( strtolower(get_class($assessment)), strtolower('Assessment'));
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

		$q2->grade($answers[1]);
		return $answers[1]->pointsEarned == $q2->questionPoints;
	}


	/**
	 */
	function saveAnswersTest() {

		$assessment = Assessment::load($this->assessment_id,$this->class_id);

		$questions = $assessment->getAssessmentQuestions();

		$answers = array();
		$answers[0] = new AssessmentAnswer();
		$answers[0]->assessmentAnswerValues = 0;

		$answers[1] = new AssessmentAnswer();
		$answers[1]->assessmentAnswerValues = array(0=>0,2=>2);
		$answers[1]->idClasses = $this->class_id;

		//assume some order, I'm sure other code does it too,
		// probably should make a test to explicitly test the ordering
		$q1 = $questions[0];
		$correct1 = $q1->getCorrectAnswer();

		$q2 = $questions[1];
		$correct2 = $q2->getCorrectAnswer();

		$q2->grade($answers[1]);
		$answer_id = $answers[1]->assessmentAnswerId;

		$db = DB::getHandle();
		$db->query("select * from assessment_answer where assessment_answer_id = ".$answer_id);

		return $db->nextRecord();
	}


	/**
	 */
	function saveScoreTest() {
	}

}


?>
