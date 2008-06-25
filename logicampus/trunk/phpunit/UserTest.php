<?php
/**
 */

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
class LogiCampus_PhpUnit_UserTest extends PHPUnit_Framework_TestCase
{
    /**
     * Creates a new {@link PhpUnderControl_Example_Math} object.
     */
    public function setUp()
    {
    }


	/**
	 * default constructor, init some data here for 
	 * the other Test() functions to use
	 */
	function __construct() {
		$this->data = array('rockinryan');
	}


	/**
	 * make sure mark is of userType 4
	 * should return true and PASS
	 */
	function testLogin() {
		$user = lcUser::getUserByUsername('mark');

		$user->profile->set('city','Ypsilanti');
		$user->profile->set('foo','bar');
		//debug($user->profile);
//		$this->assertEquals($user->userType, 3);
//		return ($user->userType == 3);
	}


	/**
	 * make sure garbage users are anonymous
	 * should return false, but PASS
	 */
	function testBadlogin() {
		$user = lcUser::getUserByUsername('oaweurwhnjw ehwekf');
		$this->assertTrue( $user->isAnonymous() );
//		return ( $user->isAnonymous() );
	}

	function testDbFuncs() {
		$db = DB::getHandle();
		$this->assertEquals(  $db->getFuncName('now()'), 'NOW()');
		$this->assertEquals(  $db->getFuncName('unix_timestamp'), 'UNIX_TIMESTAMP()');
		/*
function getFuncName($func,$param1='') {
		$_dsn = DB::DSN();
		$func = strtolower($func);
		switch ($func) {
			case 'now()':
				if ( $_dsn['default']['driver'] == 'mysql') { return 'NOW()';}
				if ( $_dsn['default']['driver'] == 'sqlite') { return 'DATETIME(\'NOW\')';}
			case 'unix_timestamp':
				if ( $_dsn['default']['driver'] == 'mysql') { return 'UNIX_TIMESTAMP('.$param1.')';}
				if ( $_dsn['default']['driver'] == 'sqlite') { return 'strftime(\'%s\','.$param1.')';}
		}
	}
		 */


	}
}
