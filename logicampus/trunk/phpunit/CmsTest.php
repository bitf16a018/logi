<?php
/**
 */

require_once 'PHPUnit/Framework.php';

//require_once dirname(__FILE__) . '/../src/testharness.php';

/**
 * Simple math test class.
 *
 * @package   Example
 * @author    Manuel Pichler <mapi@phpundercontrol.org>
 * @copyright 2007-2008 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: @package_version@
 * @link      http://www.phpundercontrol.org/
 */
class LogiCampus_PhpUnit_SystemTest extends PHPUnit_Framework_TestCase
{
    /**
     * Creates a new {@link PhpUnderControl_Example_Math} object.
     */
    public function setUp()
    {
    }


	/**
	 * Test for magic quotes GPC on
	 */
	function testMagic() {
		return (ini_get('magic_quotes_gpc') == true);
	}

	/**
	 * Test for uploads on
	 */
	function testUpload() {
		return (ini_get('file_uploads') == true);
	}

	/**
	 * we like safe mode off
	 */
	function testSafemode() {
		return (ini_get('safe_mode') == true);
	}

	/**
	 * some GD action for jpgraph
	 */
	function testGd() {
		return (function_exists('imagecreate') == true);
	}

	/**
	 * zlib (?)
	 */
	function testZlib() {
		return (function_exists('gzcompress') == true);
	}

	/**
	 * zip extensions (for opening packages)
	 */
	function testZipext() {
		return (function_exists('zip_open') == true);
	}
}
