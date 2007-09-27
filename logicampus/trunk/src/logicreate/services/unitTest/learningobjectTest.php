<?

include(LIB_PATH.'lc_lob_content.php');
include(LIB_PATH.'lc_lob_class.php');

class LearningObjectTest extends UnitTestCase {

	var $tests = array (
		'Load Class'=> array ('name'=>'load','expected'=>1)
		);

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
		$this->assertEqual( strtolower(get_class($content)), strtolower('lc_lob_content'));

		$this->assertEqual( $content->type, 'content');
		$this->assertTrue( $content->isText() );

		$this->assertTrue( is_object($content->repoObj) );
		$this->assertTrue( is_object($content->lobSub) );
		$this->assertEqual( strtolower(get_class(($content->lobSub))), 'lobcontent');
		$this->assertTrue( is_object($content->lobMetaObj) );
	}


	/**
	 * Make a new content object (lob).
	 * Save a file to it.
	 */
	function testCreateFileContent() {
		$content = new Lc_Lob_Content();

		$content->setFile(SERVICE_PATH.'unitTest/sample_content.zip');
		$this->assertEqual ($content->getFilename(), 'sample_content.zip');


		$content->setFile(SERVICE_PATH.'unitTest/sample_content.zip', 'myzip.zip');
		$this->assertEqual ($content->getFilename(), 'myzip.zip');

		$savedGood = $content->save();
		$this->newContentId = $content->getRepoId();


		$this->assertTrue( $savedGood );
		$this->assertEqual( strtolower(get_class($content)), strtolower('lc_lob_content'));

		$this->assertEqual( $content->type, 'content');
		$this->assertTrue( $content->isFile() );

		$this->assertTrue( is_object($content->repoObj) );
		$this->assertTrue( is_object($content->lobSub) );
		$this->assertEqual( strtolower(get_class(($content->lobSub))), 'lobcontent');
		$this->assertTrue( is_object($content->lobMetaObj) );
	}


	/**
	 * publish new content object (lob)
	 */
	function testClassContent() {
		$content = new Lc_Lob_ClassContent();
		$this->assertEqual( strtolower(get_class($content)), strtolower('lc_lob_classcontent'));

		$this->assertEqual( $content->type, 'content');

		/*
		$this->assertTrue( is_object($content->repoObj) );
		$this->assertTrue( is_object($content->lobSub) );
		$this->assertTrue( is_object($content->lobMetaObj) );
		 */
	}


	/**
	 * Make a new class content from a repo entry object.
	 */
	function testCopyARepoEntry() {
		$lob = new Lc_Lob_Content();
		//setup a fake PKEY
		$lob->repoObj->lobRepoEntryId = 1;

		$classContent = $lob->useInClass('notify');
		$e = ErrorStack::pullError('php');
		//e might be an error saying that the repo doesn't have all its data.
		if ($e) {
			$this->fail();
		} else {
			$this->assertTrue( is_object($classContent) );
			$this->assertEqual( $classContent->type , 'content' );
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

		$this->assertEqual($test->get('lobTitle'), 'my first test');

		$choices = array(1=>'George Washington', 2=>'Abe Lincoln', 3=>'Dennis Hopper', 4=>'Queen Latifa');
		$correct = array (1, 3);
		$test->addQuestion('Who is the first president and the first queen?', $choices, $correct);

		$this->assertEqual( $test->getQuestionCount(), 1);

		$savedGood = $test->save();
		$this->newContentId = $test->getRepoId();


		$this->assertTrue( $savedGood );
		$this->assertEqual( strtolower(get_class($test)), strtolower('lc_lob_test'));


		$this->pass();
	}


	/**
	 * Make a new activity object and save it as a lob
	 */
	function testCreateAnActivity() {

		$this->pass();
	}


	/**
	 * Can the user view his/her own objects?
	 */
	function testViewMyObjs() {

		$this->pass();
	}
}
?>
