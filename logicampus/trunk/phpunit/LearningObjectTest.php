<?

require_once 'PHPUnit/Framework.php';
require_once 'src/public_html/defines.php';

@include_once(LIB_PATH."LC_include.php");
@include_once(LIB_PATH."lc_settings.php");
@include_once(LIB_PATH."LC_user.php");
@include_once(LIB_PATH."pellet.php");
@include_once(LIB_PATH."LC_db.php");
@include_once(LIB_PATH."LC_registry.php");
@include_once(LIB_PATH."pbdo_sql.php");
@include_once(LIB_PATH."LC_html.php");
@include_once(LIB_PATH."inputValidation.php");


require(LIB_PATH.'lob/lc_lob.php');
require(LIB_PATH.'lob/lc_lob_class.php');
require(LIB_PATH.'lob/lc_lob_test.php');

class LogiCampus_PhpUnit_LearningObjectTest extends PHPUnit_Framework_TestCase {

	var $description = "Learning objects and publishing to the repository.";

	var $newContentId = 0;

	/**
	 * make a new content object (lob)
	 */
	function testCreateTextContent() {
		$content = new Lc_Lob_Content();
		$sample = 'Hello, World!  This is some text.';
		$content->setTextContent($sample);

		$savedGood = $content->save();
		$this->newContentId = $content->getRepoId();


		$this->assertTrue( $savedGood );
		$this->assertEquals( strtolower(get_class($content)), strtolower('lc_lob_content'));

		$this->assertEquals( $content->type, 'content');
		$this->assertTrue( $content->isText() );

		$this->assertTrue( is_object($content->repoObj) );
		$this->assertTrue( is_object($content->lobSub) );
		$this->assertEquals( strtolower(get_class(($content->lobSub))), 'lobcontent');
		$this->assertTrue( is_object($content->lobMetaObj) );
	}


	/**
	 * Make a new content object (lob).
	 * Save a file to it.
	 */
	function testCreateFileContent() {
		$content = new Lc_Lob_Content();

		$content->setFile(SERVICE_PATH.'unitTest/sample_content.zip');
		$this->assertEquals ($content->getFilename(), 'sample_content.zip');


		$content->setFile(SERVICE_PATH.'unitTest/sample_content.zip', 'myzip.zip');
		$this->assertEquals ($content->getFilename(), 'myzip.zip');

		$savedGood = $content->save();
		$this->newContentId = $content->getRepoId();


		$this->assertTrue( $savedGood );
		$this->assertEquals( strtolower(get_class($content)), strtolower('lc_lob_content'));

		$this->assertEquals( $content->type, 'content');
		$this->assertTrue( $content->isFile() );

		$this->assertTrue( is_object($content->repoObj) );
		$this->assertTrue( is_object($content->lobSub) );
		$this->assertEquals( strtolower(get_class(($content->lobSub))), 'lobcontent');
		$this->assertTrue( is_object($content->lobMetaObj) );
	}


	/**
	 * publish new content object (lob)
	 */
	function testClassContent() {
		$content = new Lc_Lob_ClassContent();
		$this->assertEquals( strtolower(get_class($content)), strtolower('lc_lob_classcontent'));

		$this->assertEquals( $content->type, 'content');

		/*
		$this->assertTrue( is_object($content->repoObj) );
		$this->assertTrue( is_object($content->lobSub) );
		$this->assertTrue( is_object($content->lobMetaObj) );
		*/
	}


	/**
	 * Make a new class content from a repo entry object.
	 */
	/*
	 */
	function testCopyARepoEntry() {
		$classId = 1;
		$lob = new Lc_Lob_Content();
		//setup a fake PKEY
		$lob->repoObj->lobRepoEntryId = 1;

		$classContent = $lob->useInClass($classId,'notify');
		$e = ErrorStack::pullError('php');
		//e might be an error saying that the repo doesn't have all its data.
		if ($e) {
			$this->fail($e->message);
		} else {
			$this->assertTrue( is_object($classContent) );
			$this->assertEquals( $classContent->type , 'content' );
			$id = $classContent->getRepoId();
			$this->assertTrue( $id > 0 );
		}
	}


	/**
	 * Make a new test object and save it as a lob
	 */
	function testCreateATest() {
		$test = new Lc_Lob_Test();

		$test->set('lobTitle', 'my first test');

		$this->assertEquals($test->get('lobTitle'), 'my first test');

		$choices = array(1=>'George Washington', 2=>'Abe Lincoln', 3=>'Dennis Hopper', 4=>'Queen Latifa');
		$correct = array (1, 3);
		$test->addQuestion('Who is the first president and the first queen?', 'QUESTION_MCHOICE', $choices, $correct);

		$this->assertEquals( $test->getQuestionCount(), 1);

		$savedGood = $test->save();
		$this->newContentId = $test->getRepoId();


		$this->assertTrue( $savedGood );
		$this->assertEquals( strtolower(get_class($test)), strtolower('lc_lob_test'));


	//	$this->pass();
	}
	/*
	 */


	/**
	 * Make a new activity object and save it as a lob
	 */
	function testCreateAnActivity() {
		//$this->pass();
	}


	/**
	 * Can the user view his/her own objects?
	 */
	function testViewMyObjs() {
//		$this->pass();
	}
}
?>
