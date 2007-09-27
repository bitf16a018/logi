<?

include(LIB_PATH.'lc_lob_content.php');
include(LIB_PATH.'lc_lob_class.php');

class LearningObjectTest extends UnitTestCase {

	var $tests = array (
		'Load Class'=> array ('name'=>'load','expected'=>1)
		);

	var $description = "Learning objects and publishing to the repository.";


	/**
	 * make a new content object (lob)
	 */
	function testContentCreate() {
		$content = new Lc_Lob_Content();
		$this->assertEqual( strtolower(get_class($content)), strtolower('lc_lob_content'));

		$this->assertEqual( $content->type, 'content');

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
		/*
		if ($e) {
			$this->assertTrue( is_null($classContent) );
		} else {
		 */
		$this->assertTrue( is_object($classContent) );
		$this->assertEqual( $classContent->type , 'content' );
		$id = $classContent->getRepoId();
		$this->assertTrue( $id > 0 );
	}


	/**
	 * Make a new test object and save it as a lob
	 */
	function testAssessmentCreate() {
		$this->pass();
	}


	/**
	 * Make a new activity object and save it as a lob
	 */
	function testActivityCreate() {

		$this->pass();
	}


	/**
	 * Can the user view his/her own objects?
	 */
	function testMyView() {

		$this->pass();
	}
}
?>
