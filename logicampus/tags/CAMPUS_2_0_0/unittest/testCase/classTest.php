<?

require_once(LIB_PATH.'classObj.php');
require_once(SERVICE_PATH.'testCase/unitTest.php');

class classTest extends unitTest {

	var $tests = array (
		'Load Class'=> array ('name'=>'load','expected'=>1)
		);

	var $description = "Tests loading of a class";

	/**
	 * 
	 */
	function loadTest() {
		$class = classObj::_getFromDB('1','id_classes');
		return is_object($class);
	}



}


?>
