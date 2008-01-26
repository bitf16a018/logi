<?


class LoginTest extends UnitTestCase {

	var $tests = array (
		'Login Faculty'=> array ('name'=>'facultyLogin','expected'=>1)
		);

	var $description = "Test logins and session";


	/**
	 */
	function testLoginFaculty() {
		$u = lcUser::getUserBySesskey('aabb');

		$this->assertTrue( is_object($u) );

		$db = DB::getHandle();
		$u->username = 'admin';
		$u->password = 'teacher2';
		$loggedIn = $u->validateLogin($db);
		$this->assertFalse( $loggedIn );


		$u->username = 'admin';
		$u->password = 'admin';
		$loggedIn = $u->validateLogin($db);
		$this->assertTrue( $loggedIn );

		$sess = $u->bindSession();
		$save = $u->saveSession();

		$this->assertTrue($sess);
		$this->assertTrue($save);
		$this->assertEqual( 'aabb', $u->_sessionKey );
/**
		var_dump($sess);
		var_dump($u->sessionvars);
		var_dump($u);
 */
	}


	/**
	 */
	function testAnonSession() {
		$u = new lcUser();

		$this->assertTrue( is_object($u) );

		$db = DB::getHandle();
		$u->username = 'admin';
		$u->password = 'teacher2';
		$loggedIn = $u->validateLogin($db);
		$this->assertFalse( $loggedIn );

		$sess = $u->bindSession();
		$save = $u->saveSession();

		$this->assertFalse($sess);
		$this->assertFalse($save);
		$this->assertEqual( '', $u->_sessionKey );

		$u->_sessionKey = '12345';
		$sess = $u->bindSession();
		$save = $u->saveSession();

		$this->assertFalse($sess);
		$this->assertTrue($save);
		$this->assertEqual( '12345', $u->_sessionKey );
	}

}
?>
