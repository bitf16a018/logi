<?

require_once(LIB_PATH.'classObj.php');
require_once(SERVICE_PATH.'testCase/unitTest.php');

class systemTest extends unitTest {

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
	 * Test for magic quotes GPC on
	 */
	function magicTest() {
		return (ini_get('magic_quotes_gpc') == true);
	}

	/**
	 * Test for uploads on
	 */
	function uploadTest() {
		return (ini_get('file_uploads') == true);
	}

	/**
	 * we like safe mode off
	 */
	function safemodeTest() {
		return (ini_get('safe_mode') == true);
	}

	/**
	 * some GD action for jpgraph
	 */
	function gdTest() {
		return (function_exists('imagecreate') == true);
	}

	/**
	 * zlib (?)
	 */
	function zlibTest() {
		return (function_exists('gzcompress') == true);
	}

	/**
	 * zip extensions (for opening packages)
	 */
	function zipextTest() {
		return (function_exists('zip_open') == true);
	}
}


?>
