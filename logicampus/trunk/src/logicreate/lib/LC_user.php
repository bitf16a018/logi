<?
require_once(LIB_PATH.'User.php');

	/**
	 * lcUser class
	 *
	 * A user is defined only as a username, email, and password.
	 * Extra info is stored in table 'profile'.  lcUser->saveSession()
	 * should only allow one login under that username at a time.
	 * Call lcUser->bindSession() from any login script to log-in a user.
	 */


class lcUser {

	var $username = "anonymous";
	var $password;
	var $email;
	var $userType;  // stores which type of user account it is so we know which object to load up
	var $sessionvars;			// store session data in this array; (e.x.: $u->sessionvars[voted] = date();)
	var $groups = array("public"); 		// array of group membership groups["public"], groups["admin"], etc.
	var $perms;				// nested arrays of available services (key) and actions (values)
	var $profile;
	var $loggedIn = false;
	var $userId = 0;
	var $_origChecksum = '';



	/**
	 * @return object	new lcUser
	 * @static
	 */
	function getUserByUsername($uname) {
		$db = DB::getHandle();
		$db->query("select * from lcUsers where username = '$uname'",false);
		$db->nextRecord();
		$db->freeResult();
		switch($db->record['userType']) {
			case USERTYPE_FACULTY:
				$temp = new FacultyUser($db->record['username']);
				break;
			case USERTYPE_STUDENT:
				$temp = new StudentUser($db->record['username']);
				break;
			case USERTYPE_STANDARD:
				$temp = new StandardUser($db->record['username']);
				break;
			default:
				$temp = new lcUser();
		}
		$temp->username = $uname;
		$temp->password = $db->record["password"];
		$temp->email = $db->record["email"];
		$temp->groups = array_merge($temp->groups,explode("|",substr($db->record['groups'],1,-1)));
		$temp->userId = $db->record['pkey'];
		$temp->loadProfile();
	return $temp;
	}



	/**
	 * returns a new lcUser with associated session data in <i>$sessionvars</i>.
	 * @return object	 new lcUser
	 * @static
	 */
	function getUserBySesskey($sessID) {
		$db = DB::getHandle();
		if ($sessID == "") {
			$temp =  new lcUser();
			$temp->loadProfile();
			return $temp;
		}

		/*
		if (rand(1,20) >= 20 ) {
		//gc cleanup, mysql specific with DATE_SUB
			global $PHPSESSID;
			$db->query("DELETE FROM lcSessions WHERE DATE_SUB(CURDATE(), INTERVAL 1 DAY) > gc",false);
			$db->freeResult();
		}
*/
		$db->query("select * from lcSessions where sesskey = '$sessID'",false);
		$j = $db->nextRecord();
		$db->freeResult();


		if (!$j) {
			//trigger_error('second try to get session for: '.$sessID);
			$db->query("select * from lcSessions where sesskey = '$sessID'",false);
			$j = $db->nextRecord();
			$db->freeResult();
		}

		if (function_exists("gzuncompress")) { 
			$sessArr = unserialize(gzuncompress(base64_decode($db->record['sessdata'])));
		} else {
			$sessArr = unserialize(base64_decode($db->record['sessdata']));
		}
		//maybe it wasn't gzipped
		if (!$sessArr) { 
			$sessArr = unserialize(base64_decode($db->record['sessdata']));
		}
		if (!$sessArr) { 
			$sessArr = unserialize($db->record['sessdata']);
		}

		if ($j) {

			$origSession = crc32($db->record['sessdata']);
			//DEPRECATED
			if ($sessArr["_userId"] != "") {
				$temp = lcUser::getUserByPkey($sessArr["_userId"]);
				$temp->sessionvars = $sessArr;
				$temp->unwrapSessionVars();
				$temp->_sessionKey = $sessID;
				$temp->_origChecksum = $origSession;
				$temp->loggedIn = true;
				$temp->loadProfile();
			}
			else if ($sessArr["_username"] != "") {
				$temp = lcUser::getUserByUsername($sessArr["_username"]);
				$temp->sessionvars = $sessArr;
				$temp->unwrapSessionVars();
				$temp->_sessionKey = $sessID;
				$temp->_origChecksum = $origSession;
				$temp->loggedIn = true;
				$temp->loadProfile();
			}
			else {
				$temp = new lcUser();
				$temp->sessionvars = $sessArr;
				$temp->unwrapSessionVars();
				$temp->_sessionKey = $sessID;
				$temp->_origChecksum = $origSession;
				$temp->loadProfile();
			}
		//added for mail server compat.
		$temp->_oldPassword = $temp->password;

		return $temp;
		} else {
			global $hadCookie;
			if ($hadCookie==true) {
				//trigger_error('we had a cookie submitted from you, but we cannot find your session.');
				// user might have been logged out
			}
			//none found, make new session, return new user
			sess_open(DB::getHandle(),$sessID);
			$temp =  new lcUser();
			$temp->loadProfile();
			return $temp;
		}
	}


	/**
	 * Return one user given the database key
	 *
	 * @return  object  new lcUser
	 * @static
	 */
	function getUserByPkey($key) {
		$db = DB::getHandle();
		$db->query("select * from lcUsers where pkey = $key",false);
		if ( !$db->nextRecord() ) {  return new lcUser();  }
		$db->freeResult();
		switch($db->record['userType']) {
			case USERTYPE_FACULTY:
				$temp = new FacultyUser($db->record['username']);
				break;
			case USERTYPE_STUDENT:
				$temp = new StudentUser($db->record['username']);
				break;
			case USERTYPE_STANDARD:
				$temp = new StandardUser($db->record['username']);
				break;
			default:
				$temp = new lcUser();
		}
		$temp->username = $db->record['username'];
		$temp->password = $db->record['password'];
		$temp->email = $db->record['email'];
		$temp->groups = array_merge($temp->groups,explode("|",$db->record['groups']));
		$temp->userId = $db->record['pkey'];
		$temp->loadProfile();
	return $temp;
	}



	/**
	 * Returns true or false based on if the current user is 
	 * logged into the site or not
	 */
	function isAnonymous() {
		return !$this->loggedIn || $this->userId < 1;
	}


	/**
	 * Return an array of user objects 
	 *
	 * @return      array   lcUser array
	 * @static
	 */
        function getListByPkey($keys) {
		$db = DB::getHandle();
		$or = join("  or pkey = ", $keys);
		$db->query("select * from lcUsers where pkey = $or",false);
		while ( $db->nextRecord() ) {
			unset($temp);
			$temp =   new lcUser();
			$temp->username = $db->record[username];
			$temp->password = $db->record[password];
			$temp->email = $db->record[email];
			$temp->groups = explode('|',substr($db->record[groups],1,-1));
			$temp->userId = $db->record['pkey'];

			if (! in_array('public',$temp->groups) ) 
				$temp->groups[] = 'public';

			$retarray[] = $temp;
		}
	return $retarray;
	}


	/**
	 * loads the current user's profile from the 'profile' table
	 * Will also try to get from a profile_xxxxx table depending
	 * on the user's ->type variable
	 *
	 * the table's columns will become the key's of the $this->profile profile
	 * @return 	void
	 */

	function loadProfile() { 
		if ($this->username =='' || $this->username == 'anonymous') {
			$this->profile = UserProfile::loadAnonProfile();
		} else {
			$this->profile = UserProfile::load($this->username,$this->userType);
		}
	}


	/**
	 * Save the user to the lcUser table
	 *
	 * @return 	boolean 	True if the SQL statement was sent (i.e. not an anonymous user)
	 */

	function update() {
	    if ($this->username == "anonymous" ) {
		return 0; }
	    $db = DB::getHandle();

		// getting rid of duplicate groups
		$g = array();
		if (is_array($this->groups)) { 
			while (list($k,$v) = each($this->groups)) {
				if (!@in_array($v,$g)) { 
					$g[$k] = $v;
				}
			}
			unset($this->groups);
			$this->groups = $g;
			$g = "";
		}
		if (is_array($this->groups)) { $g = implode("|",$this->groups); } else { $g = $this->groups; }
	    $sql = "update lcUsers set groups='|".$g."|',username = '".$this->username."',password='".$this->password."',email='".$this->email."' where username='".$this->username."'";
	    $db->query($sql);
	    return true;
	}



	/**
	 * Save the current user's profile to the 'profile' table
	 *
	 * @return boolean 	Anonymous user will return false
	 */

	function updateProfile($profile='') {
	    if ($this->username == "anonymous" ) {
		return 0;
	    }
	    unset($this->profile['username']);
	    if ($profile=='') { $profile = $this->profile; }
	    $db = DB::getHandle();

	    $sql = "replace into profile (username, %s) VALUES ('".$this->username."', %s)";

	    foreach($profile as $k=>$v) {
			$set .= "$k, ";
			$vals .= "'$v', ";
	    }
	    $set = substr($set,0,-2);
	    $vals = substr($vals,0,-2);

	    $db->query( sprintf($sql,$set,$vals) );
	    return true;
	}



	/**
	 * Remove from lcUsers table
	 * Remove from profile and profile_* specific table
	 * Remove from proflie_course_family
	 */
	function deleteUser() {
		
	    $db = DB::getHandle();
	    $sql = "delete from lcUsers where username='".$this->username."'";
	    $db->query($sql);

	    $sql = "delete from profile_faculty_coursefamily where username='".$this->username."'";
	    $db->query($sql);
	    
	    if (!$this->profile->delete()) {
	    	trigger_error('Profile was not delete for user : '.$this->username);
	    }

	}


	/**
	 *	Use this function instead of self::addUser() becuase
	 *	this is an administrator only function as it does not
	 *	bind the administrator to the user (auto login)
	 */
	function administrationAddNewUser($db) {
		if ($this->username == '')
			return -1;

		// __FIXME__ don't hardcode tccd.edu
		if ($this->email == '') 
			$this->email = $this->username . $_SERVER['SERVER_NAME'];

		$sql = "select count(*) as user_exists from lcUsers where username = '".$this->username."' or email='".$this->email."'";
		$db->queryOne($sql,false);
		
		if ($db->record['user_exists'])
		{	return -1;
		}
		
		$sql = "insert into lcUsers (groups,username,password,email,createdOn,userType) values ('|".implode("|",$this->groups)."|','".$this->username."','".$this->password."','".$this->email."',".DB::getFuncName('NOW()').", '".$this->userType."')";
		$db->query($sql,false);
		$pkey = $db->getInsertID();

		//profile insert
		if (! is_object($this->profile) ) $this->profile = new UserProfile($this->username,0);
		$this->profile->addProfile($this->username);
	
		
		# save the user's profile since their account is good
		$this->profile->save();
		
		return $pkey;
	}

	/**
	 * @return boolean	returns false if username is already taken
	 */

	function addUser($db) {
		$sql = "select count(username) as username, count(email) as email from lcUsers where username = '".$this->username."' or email='".$this->email."'";
		$db->queryOne($sql);
		$ucount = $db->record['username'];
		$ecount = $db->record['email'];
		if ( ($ucount != 0) and ($ecount != 0) ) {
			return false;
		}
		$sql = "insert into lcUsers (groups,username,password,email,createdOn) values ('|".implode("|",$this->groups)."|','".$this->username."','".$this->password."','".$this->email."',".DB::getFuncName('NOW()').")";
		$db->query($sql);
		
		$pkey = $db->getInsertID();
		$this->bindSession();
		return $pkey;
	}

	function commitSessionVars() {
		$this->sessionvars['_userId'] = $this->userId;
		$this->sessionvars['_activeClassTaught'] = $this->activeClassTaught;
		$this->sessionvars['_activeClassTaken'] = $this->activeClassTaken;
		$this->sessionvars['_classesTaken'] = $this->classesTaken;
		$this->sessionvars['_classesTaught'] = $this->classesTaught;
	}

	function unwrapSessionVars() {
		$this->userId = $this->sessionvars['_userId'];
		$this->activeClassTaught = $this->sessionvars['_activeClassTaught'];
		$this->activeClassTaken = $this->sessionvars['_activeClassTaken'];
		$this->classesTaken = $this->sessionvars['_classesTaken'];
		$this->classesTaught = $this->sessionvars['_classesTaught'];
	}



	/**
	 * Saves current session (user->sessionvars) into lcSession table
	 * prevents multiple logins because it overwrites the session key - necassary
	 * for persistent userinfo - after every page.
	 */

	function saveSession() {
		$this->sessionvars['__sysMessages'] = $this->sysMessages;
		$this->sysMessages = array();

		if ($this->_sessionKey == "") { return false; }
		if ($this->username == "") { return false; /*print "no username"; exit();*/}
		//save userID to the session
		$this->commitSessionVars();

		$sessBlob = $this->sessionvars;
//		unset($this->sessionvars);
		// combatting access denied issue
		// 8/5/03 mgk
		// 10-16-2003 MAK
		// $val is not defined, doesn't make sense
		//$this->newval = crc32($val);

		if (function_exists("gzcompress")) { 
			$val = gzcompress(serialize($sessBlob));
		} else { 
			$val = serialize($sessBlob);
		}

		if ( crc32($val) == $this->_origChecksum) { return true; }
		$db = DB::getHandle();
		$sessid = $this->_sessionKey;
		$val=base64_encode($val);
		$s="UPDATE lcSessions SET username =\"".$this->username."\", sessdata = \"".$val."\" WHERE sesskey = '".$sessid."'";
		if ($this->username == "anonymous" ) { 
			$s="UPDATE lcSessions SET sessdata = \"".$val."\" WHERE sesskey = '".$sessid."'";
		}
		$queryWorked = $db->query($s);
		$updateWorked = $db->getAffectedRows();
		if ($updateWorked < 0) {
			$e = ErrorStack::pullError('php');

			$s="DELETE FROM lcSessions WHERE username = '".$this->username."'";
			$queryWorked = $db->query($s);
			$e = ErrorStack::pullError('php');
			$s="INSERT into lcSessions (username,sessdata,sesskey) values ('".$this->username."','$val','$sessid')";
			if ($this->username == "anonymous" ) { 
				$s="INSERT into lcSessions (sessdata,sesskey) values ('$val','$sessid')";
			}
			$db->query($s);
		}
		return true;
		//sess_close(DB::getHandle(),$this->uid,serialize($this->session));
//		$sessBlob['_userobj'] = '';
//		$this->sessionvars = $sessBlob;
	}


	/**
	 * links an already started session with a registered user
	 * sessions can exist w/anonymous users, this function
	 * will link userdata to the open session;
	 * also destroys multiple logins
	 */
	function bindSession() {
		if ($this->_sessionKey == "" ) { return false; }
		if ($this->username == "anonymous" ){ return false; }
		if ($this->username == "" ){ $this->username = 'anonymous'; return false; }
		global $tail;
		/*
		if (!$this->isAnonymous()) {
			$PHPSESSID=md5 (uniqid (rand()));
			setcookie("PHPSESSID",$PHPSESSID,0,$tail);
			$this->_sessionKey = $PHPSESSID;
		}
		 */
		$this->commitSessionVars();
		if (function_exists("gzcompress")) { 
			$val = base64_encode(gzcompress(serialize($this->sessionvars)));
		} else {
			$val = base64_encode((serialize($this->sessionvars)));

		}
		/*
		 */
		$val = serialize($this->sessionvars);
		$this->_origChecksum = crc32($val);

		$this->saveSession();
		return true;
	}



	/**
	 * removes session from database
	 * if you simply want to end a session, but keep the
	 * data in the db for records, use $u->endSession($db);
	 */
	function destroySession($db="") {
	if (!is_object($db)) { $db = DB::getHandle(); }
		$db->query("delete from lcSessions where sesskey = '".$this->_sessionKey."'",false);
		$this->sessionvars = array();
		$this->_sessionKey = "";
	}



	/**
	 * invalidates a session but keeps the data in
	 * the db for debugging/logging
	 */
	function endSession($db) {
		$this->sessionvars["_username"] = "";
		$this->sessionvars["_userId"] = "";
		setCookie("PHPSESSID","",0);
	}


	/**
	 * try to get rid of this,
	 * functionality should be in a login script
	 */

	function validateLogin($db) {
		/*
		include(LIB_PATH."imap.php");
		$j = new imap(array("username"=>$this->username,"password"=>$this->password));
		if ($j->testConnectionOnly()) { 
			$this->groups = array("pub","public","student");
			return true;
		} else { 
			return false;
		}
		*/
		$username = addslashes($this->username);
		$password = addslashes($this->password);
		if(LcSettings::getValue('USE_MD5_PASSWORDS')==TRUE) { 
			$password = md5($password);
		}

		$countSql = "select count(username) as total from lcUsers where username='".$username."' and password='" . $password . "'";

		$db->query($countSql,false);

		$db->nextRecord();
		$db->freeResult();

		if( $db->record['total'] == 1 ) {
			$db->query("select * from lcUsers where username = '$username' and password = '".$password."'",false);
			if (!$db->nextRecord()) {
				die('some wierdo problem.');
			}

			$this->email = $db->record['email'];
			$this->password = $db->record['password'];
			$this->username = $db->record['username'];
			$this->sessionvars['_userId'] = $db->record['pkey'];
			$this->groups = array_merge($this->groups,explode("|",substr($db->record['groups'],1,-1)));
			$this->userId = $db->record['pkey'];
			$this->loadProfile();
			return true;
		} else {
			$this->password = '';
			$this->username = 'anonymous';
			$this->groups[] = 'public';
			return false;
		}
	}



	/**
	 * loads permissions for this user and module
	 */
	function loadPerms ($mname) {

#	if ( is_array($this->perms) ) {
#		return;
#	}

		$db = DB::getHandle();

		$sql = "select mid from lcRegistry where moduleName = '$mname'";
		$db->query($sql,false);
		$db->nextRecord();		//get the moduleID from the registry
		$db->freeResult();
		$mid = $db->record['mid'];
		 // usefull for both mid and moduleName values.
		 
		$where = '';
		$sql = "select action from lcPerms where moduleID = '$mid' and (%s)";
		for ($z=0; $z < count($this->groups); ++$z) {
			$where .= "groupID = '".$this->groups[$z]."' or ";
		}
		$where = substr($where,0,-3);

		$sql = sprintf($sql,$where);
		$db->query($sql,false);
		while ($db->nextRecord() ) {
			$ret[] = $db->record['action'];
		}
	$this->perms = $ret;

	}


	/**
	 * Save a message in the session so it can be displayed on the
	 * next page.
	 * Store all messages based by their type.
	 */
	function addSessionMessage($msg,$type='i') {
		$this->sysMessages[$type][] = $msg;
	}

	/**
	 * return system messages and clean them
	 * @return array list of messages.
	 */
	function getSessionMessages() {
		$msg = $this->sessionvars['__sysMessages'];
		$this->sessionvars['__sysMessages'] = '';
		return $msg;
	}


	/**
	 * used to include user into current namespace
	 * @static
	 */
	function &getCurrentUser() {
		global $lcUser;
		return $lcUser;
	}
	
	/**
	 * If called it will send an email greeting to the user
	 * with their password and user name
	 */
	 
	 function sendGreeting() {
	 	$subject = "your new ".SITE_NAME." account";
	 	$message =
'A new user account has been established for you at '.SITE_NAME.' website.

Please visit '.DEFAULT_URL.' to use your new account.  Your username and password
information is below:

Username: '.$this->username.'
Password: '.$this->password.'

Thank you,

'.SITE_NAME.' Admission and Registration Department
'.WEBMASTER_EMAIL;
	 	mail($this->email,$subject,$message, "From: ".WEBMASTER_EMAIL."\r\nReply-To: ".WEBMASTER_EMAIL."\r\nReturn-Path: ".WEBMASTER_EMAIL."\r\n");
	 }

	/**
	 * Communicate with a database on the mail server
	 * to instruct password changes and what not
	 * not passing a flag will make the function analyze the user
	 * to see if their password changed, if not then no action is taken
	 *
	 * MESSAGES:
	 * user is not in any sections this semester, send status 1 with random password
	 * user is added to a section, send 1 with regular information
	 *
	 * FLAGS:
	 * 0 = suspend existing account (random password)
	 * 1 = add new account
	 * 2 = update account
	 *
     * Set UPDATE_MAILSERVER_DB to TRUE to use this feature
     * Also update the mail dns handle in defines so it 
     * knows where the database table is to write to
     * additional scripts are in bin that should be run
     * on the mail server
     */
    function updateMailServer($flag=false) {
        if (UPDATE_MAILSERVER_DB == FALSE)
        {
            return FALSE;
        }

		$mailSQL = "insert into mail_accounts_temp
			(username,real_name,password,action)
			VALUES
			('%s','%s','%s',%d)";

		if ($flag === false) {
			if ( $this->password == $this->_oldPassword  || $this->username == 'anonymous')
				return false;

			if ($this->password == '') return false;
			//keep going, this is a change password scenario
			$db = DB::getHandle('mail');
			$db->query(
			sprintf( $mailSQL,
				$this->username,
				$this->profile->get('firstname'). ' ' .$this->profile->get('lastname'),
				$this->password,
				2),false
			);
			return true;
		}
		//remove the user
		// a.k.a. update with random password
		if ($flag === 0) {
			$db = DB::getHandle('mail');
			$db->query(
			sprintf( $mailSQL,
				$this->username,
				$this->profile->get('firstname'). ' ' .$this->profile->get('lastname'),
				md5(rand(10000)),
				0),false
			);
			return true;
		}

		//new user info
		if ($flag === 1 || $flag === 2) {
			$db = DB::getHandle('mail');
			$db->query(
			sprintf( $mailSQL,
				$this->username,
				$this->profile->get('firstname'). ' ' .$this->profile->get('lastname'),
				$this->password,
				$flag),false
			);
			return true;
		}

	}


		# Returns true if the user is a student
		# False is user is not a student
		function isStudent() {
			return $this->userType == USERTYPE_STUDENT;
//			return false;
		}

		function isAdmin() {
			if (in_array('admin', $this->groups) ) {
				return true;
			}
			return false;
		}

		function isFaculty() {
			return false;
		}

		function isStandard() {
			return false;
		}


}



/**
 * Profile Object
 */
class UserProfile {
	var $tableName;
	var $username;
	var $keys = array();
	var $values = array();
	var $dirty;
	var $specific = true;
	var $common_attribs = array('firstname','lastname','emailAlternate','homePhone',
			'workPhone','faxPhone','cellPhone','pagerPhone','photo','address','address2',
			'city','state','zip',
			//Added when merging self registration Module
			'country','hphone','education','lastinstitute',
			//End of addition
			'showaddinfo','url','icq','aim',
			'yim','msn','showonlineinfo','occupation','gender','sig','bio',
			'showbioinfo','emailNotify');
	var $specific_attribs = array();
	var $student_attribs = array( 'isp', 'operatingSystem', 'connectionType' );
	var $faculty_attribs = array(
			'emergencyContact','emergencyPhone',
			'title','degree','jobtitle','officeLocation',
			'campusLocation', 'relevantExp','officePhone',
			'offHrsMonday','offHrsTuesday','offHrsWednesday',
			'offHrsThursday','offHrsFriday');
	var $admin_attribs = array(
			'emergencyContact','emergencyPhone'
			);



	/**
	 * default constructor for UserProfiles
	 */
	function UserProfile($u,$t=0) {
		$this->username = $u;
		switch($t) {
			case 2:
				$this->tableName = 'profile_student';
				break;
			case 3:
				$this->tableName = 'profile_faculty';
				$this->specific_attribs =& $this->faculty_attribs;
				break;
			case 1:
			default:
				$this->tableName = '';
				$this->specific = false;
		}
		if ($this->username == 'anonymous') {
			$this->common_attribs = array('firstname','lastname');
			$this->values['firstname'] = 'Unregistered';
			$this->values['lastname'] = 'User';
			$this->keys[] = 'firstname';
			$this->keys[] = 'lastname';
			$this->specific_attribs = array();
			$this->specific = false;
		}
		
	}


	/**
	 * Load a profile from the database given a username
	 * and usertype (optional)
	 *
	 * @static
	 */
	function load($username,$type='') { 

		$prof = new UserProfile($username,$type);
		$db = DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$db->queryOne("select * from profile where username='".$prof->username."'",false);

		while ( list($k,$v) = @each($db->record) ) {
			$prof->values[$k] = $v;
			$prof->keys[] = $k;
		}

		if ($type > 1 && strlen($prof->tableName) > 1) {
			$db->queryOne("select * from ".$prof->tableName." where username='".$prof->username."'",false);
			while ( list($k,$v) = @each($db->record) ) {
				$prof->values[$k] = $v;
				$prof->keys[] = $k;
			}
		}
	return $prof;
	}



	function loadAnonProfile() { 
		$prof = new UserProfile('anonymous');
		return $prof;
	}



	/**
	 * check to see if saving is needed
	 */
	function save() {
		if ( ! $this->isDirty() ) {
			return true;
		}
		reset($this->common_attribs);
		reset($this->specific_attribs);

		$db = DB::getHandle();

		while(list ($k, $v) =@each($this->common_attribs) ) {
			if ($this->values[$v])
			$update .= "$v='".addslashes(trim($this->values[$v]))."', ";
		}
		$update = substr($update, 0, -2);

		$sql = "update profile set ".$update." where username = '".$this->username."'";
		//trigger_error($sql);
		$db->query($sql,false);
		$update = null;
		$sql = null;

		//specific
		if (is_array($this->specific_attribs) && count ($this->specific_attribs) > 0) {
			reset($this->specific_attribs);
			while(list ($k, $v) =@each($this->specific_attribs) ) {
				$update .= "$v='".$this->values[$v]."', ";
			}
			$update = substr($update, 0, -2);

			$sql = "update ".$this->tableName." set ".$update." where username = '".$this->username."'";
			$db->query($sql,false);
		}
		return true;
	}


	/**
	 * return a value from the object's value array
	 */
	function get($k) {
		return $this->values[$k];
	}


	/**
	 * set a value in the object's value array
	 */
	function set($k,$v) {
		if (@$this->values[$k] == $v) {
			return true;
		}

		// don't allow set access to keys
		// that aren't already in the database
		if (! in_array($k,$this->common_attribs) && 
			(is_array($this->specific_attribs) && ! in_array($k,$this->specific_attribs)) ) {
			return false;
			//$this->keys[] = $k;
		}

		$this->values[$k] = $v;
		$this->dirty = true;
		return true;
	}


	/**
	 * does the object need saving?
	 */
	function isDirty() {
		return $this->dirty;
	}


	function addProfile($name=null) {
		if (!$name) $name = $this->username;
		$db = DB::getHandle();
		$db->query("insert into profile (username) VALUES ('$name')",false);
		if ($this->specific)
			$db->query("insert into ".$this->tableName." (username) VALUES ('$name')",false);
	}
	

	function delete() {
		$db = DB::getHandle();
		if ($this->username == '') return false;

		$db->query("delete from profile where username = '".$this->username."'");
		if ($this->specific)
			$db->query("delete from  ".$this->tableName." where username = '".$this->username."'");
		return true;
	}
}


?>
