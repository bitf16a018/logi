<?

require_once(LIB_PATH.'classObj.php');

class systemTest extends UnitTestCase {

	var $tests = array (
		'Magic Quotes GPC'=> array ('name'=>'magic','expected'=>1),
		'Safe Mode Off'=> array ('name'=>'safemode','expected'=>0),
		'Allow uploads'=> array ('name'=>'upload','expected'=>1),
		'libGD'=> array ('name'=>'gd','expected'=>1),
		'Zip Extensions'=> array ('name'=>'zipext','expected'=>1),
		'Zlib'=> array ('name'=>'zlib','expected'=>1)
		);


	var $description = "Tests various ini file settings and extension availability.";


	/**
	 * Test for magic quotes GPC off, db layer should take care of everything
	 */
	function testMagic() {
		$this->assertFalse(ini_get('magic_quotes_gpc'));
	}

	/**
	 * Test for uploads on
	 */
	function testUpload() {
		$this->assertTrue(ini_get('file_uploads'));
	}

	/**
	 * we like safe mode off
	 */
	function testSafemode() {
		$this->assertFalse(ini_get('safe_mode'));
	}

	/**
	 * some GD action for jpgraph
	 */
	function testGd() {
		$this->assertTrue(function_exists('imagecreate'));
	}

	/**
	 * zlib (?)
	 */
	function testZlib() {
		$this->assertTrue(function_exists('gzcompress'));
	}

	/**
	 * zip extensions (for opening packages)
	 */
	function testZipext() {
		$this->assertTrue(function_exists('zip_open'));
	}
}


?>
