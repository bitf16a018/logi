<?

require_once(SERVICE_PATH.'testCase/unitTest.php');

class userTest extends unitTest {

	var $tests = array (
		'Good Login'=> array ('name'=>'login','expected'=>1),
		'Bad Login' => array ('name'=>'badlogin','expected'=>1), 
		'Read common profile'=> array ('name'=>'readProfile','expected'=>1),
		'Save common profile'=> array ('name'=>'saveProfile','expected'=>1)
		);

	var $description = "Gets users by username and tests profile information";

	/**
	 * default constructor, init some data here for 
	 * the other Test() functions to use
	 */
	function userTest() {
		$this->data = array('rockinryan');

	}


	/**
	 * make sure mark is of userType 4
	 * should return true and PASS
	 */
	function loginTest() {
		$user = lcUser::getUserByUsername('mark');

		$user->profile->set('city','Ypsilanti');
		$user->profile->set('foo','bar');
		//debug($user->profile);
		return ($user->userType == 3);
	}


	/**
	 * make sure garbage users are anonymous
	 * should return false, but PASS
	 */
	function badloginTest() {
		$user = lcUser::getUserByUsername('oaweurwhnjw ehwekf');
		return ( $user->isAnonymous() );
	}



	/**
	 * make sure profile is object and has first_name,last_name for all
	 */
	function readProfileTest() {
		$user = lcUser::getUserByUsername('mark');
		$profile = $user->profile;
		$common = $profile->common_attribs;
		$ret = (in_array('firstname',$common));
		$ret &= (in_array('lastname',$common));
		$ret &= (is_object($profile));
		return $ret;
	}


	/**
	 * make sure profile is object and has first_name,last_name for all
	 */
	function saveProfileTest() {
		$user = lcUser::getUserByUsername('mark');
		$profile = $user->profile;
		$profile->set('city','Ypsilanti');
		$profile->set('degree','BSA');
		//debug($profile,1);
		$ret = $profile->save();
		return $ret;
		/**
		$common = $profile->common_attribs;
		$ret = (in_array('first_name',$common));
		$ret &= (in_array('last_name',$common));
		$ret &= (is_object($profile));
		return $ret;
		*/
	}

}


?>
