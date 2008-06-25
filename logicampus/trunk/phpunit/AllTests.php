<?php

if ( defined( 'PHPUnit_MAIN_METHOD' ) === false )
{
    define( 'PHPUnit_MAIN_METHOD', 'phpucAllTests::main' );
}


/**
 */
class phpucAllTests
{
    /**
     * Test suite main method.
     *
     * @return void
     */
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run( self::suite() );
    }
    
    /**
     * Creates the phpunit test suite for this package.
     *
     * @return PHPUnit_Framework_TestSuite
     */
    public static function suite()
    {
		require_once('phpunit/CmsTest.php');
		require_once('phpunit/UserTest.php');
		require_once('phpunit/LearningObjectTest.php');
        $suite = new PHPUnit_Framework_TestSuite( 'phpUnderControl - AllTests' );

		$suite->addTestSuite('LogiCampus_PhpUnit_SystemTest');
		$suite->addTestSuite('LogiCampus_PhpUnit_UserTest');
		$suite->addTestSuite('LogiCampus_PhpUnit_LearningObjectTest');

        return $suite;
    }
}

if ( PHPUnit_MAIN_METHOD === 'phpucAllTests::main' )
{
    phpucAllTests::main();
}
