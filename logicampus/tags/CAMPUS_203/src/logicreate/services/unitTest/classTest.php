<?

require_once(LIB_PATH.'classObj.php');

class classTest extends UnitTestCase {

	var $tests = array (
		'Load Class'=> array ('name'=>'load','expected'=>1)
		);

	var $description = "Tests loading of a class";

	/**
	 * 
	 */
	function testLoad() {
//		$class = classObj::_getFromDB('1','id_classes');
//		return is_object($class);
		$this->assertFalse(true);
	}

}
?>
