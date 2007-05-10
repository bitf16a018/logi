<?php
/*************************************************** 
 *
 * This file is under the LogiCreate Public License
 *
 * A copy of the license is in your LC distribution
 * called license.txt.  If you are missing this
 * file you can obtain the latest version from
 * http://logicreate.com/license.html
 *
 * LogiCreate is copyright by Tap Internet, Inc.
 * http://www.tapinternet.com/
 ***************************************************/

class users extends HercAuth {

	var $presentor = "plainPresentation";
	var $PAGE_SIZE = 30;


	/**
	 * Show the main control panel for users
	 *
	 * Retrieve a list of users, groups, collections,
	 * and profile meta-data to populate all the controls.
	 */
	function run (&$db,&$u,&$arg,&$t) {

		$t[start] = $arg->getvars[start];
		settype($t[start],"integer");

		$db->query("select *, lc.username as lc_username from lcUsers as lc LEFT JOIN profile on lc.username = profile.username order by lc.username LIMIT ".$t['start'].",".$this->PAGE_SIZE);

		//old query overwrote lcUsers.username with profile.username during join
		//$db->query("select lcUsers.*, profile.username as p-username from lcUsers as lc LEFT JOIN profile on lc.username = profile.username order by lc.username LIMIT ".$t[start].",".$this->PAGE_SIZE);
		while ($db->next_record() ) {
			if ( ($db->Record['firstname']== '') and ($db->Record['lastname'] == '') ) {
				$db->Record['profiledata'] = "<i>Incomplete profile data</i>";
			} else {
				$db->Record['profiledata'] = "<a href=\""._APP_URL."users/".$db->Record['pkey']."/event=show\">".$db->Record['lastname'].", ".$db->Record['firstname']."</a>";
			}
			$t['users'][] =$db->Record;
		}
		$db->query("select count(username) from lcUsers");
		$db->next_record();
		$t[totalCount] = $db->Record[0];
		$t[result_pages] = ceil( $db->Record[0] / $this->PAGE_SIZE);
		$t[current_page] = ceil( $t[start] / $this->PAGE_SIZE) + 1;
		$t[max_results] = $db->Record[0];
		$t[PAGE_SIZE] = $this->PAGE_SIZE;

		//groups
		$db->query("select * from lcGroups");
		while ($db->next_record() ) {
			$t["group_opt"] .= "<option value=\"".$db->Record[gid]."\">".$db->Record[groupName]." (".$db->Record[gid].")</option>\n";
		}

		//collections
		$t['collectionCount'] = count($u->sessionvars['user_collection']);

		//profile
		$db->query("describe profile");	//get profile meta data
		$db->next_record(); 		//drop off pkey
		$t['profile_opt'] .= "<option value='_email'>Email</option>\n";
		$t['profile_opt'] .= "<option value='_username'>Username</option>\n";
		while ($db->next_record() ) {
			$t[profile_opt] .= "<option value=\"".$db->Record[0]."\">".$db->Record[0]."</option>\n";
		}
	}



	/**
	 * Search for users based on their username
	 */
	function firstLetterRun(&$db, &$u, &$arg, &$t) {

		$arg->getvars[firstletter] != ''? $firstletter = $arg->getvars[firstletter]:$firstletter = $arg->postvars[firstletter];

		$t[start] = $arg->getvars[start];
		settype($t[start],"integer");

		$db->query("select *, lc.username as lc_username from lcUsers as lc LEFT JOIN profile on lc.username = profile.username where lc.username like '".$firstletter."%' order by lc.username LIMIT ".$t[start].",".$this->PAGE_SIZE);
		while ($db->next_record() ) {
			if ( ($db->Record['firstname']== '') and ($db->Record['lastname'] == '') ) {
				$db->Record['profiledata'] = "<i>Incomplete profile data</i>";
			} else {
				$db->Record['profiledata'] = "<a href=\""._APP_URL."users/".$db->Record['pkey']."/event=show\">".$db->Record['lastname'].", ".$db->Record['firstname']."</a>";
			}
			$t['users'][] = $db->Record;

		}
		$db->query("select count(username) from lcUsers where username like '".$firstletter."%'");
		$db->next_record();
		$t[result_pages] = ceil( $db->Record[0] / $this->PAGE_SIZE);
		$t[current_page] = ceil( $t[start] / $this->PAGE_SIZE) + 1;
		$t[max_results] = $db->Record[0];
		$t[PAGE_SIZE] = $this->PAGE_SIZE;

		//groups
		$db->query("select * from lcGroups");
		while ($db->next_record() ) {
			$t["group_opt"] .= "<option value=\"".$db->Record[gid]."\">".$db->Record[groupName]." (".$db->Record[gid].") </option>\n";
		}

		//profile
		$db->query("describe profile");	//get profile meta data
		$db->next_record(); 		//drop off pkey
		$t['profile_opt'] .= "<option value='_email'>Email</option>\n";
		$t['profile_opt'] .= "<option value='_username'>Username</option>\n";
		while ($db->next_record() ) {
			$t[profile_opt] .= "<option value=\"".$db->Record[0]."\">".$db->Record[0]."</option>\n";
		}

		$t[opt1] = 'event=firstLetter';
		$t[opt2] = 'firstletter='.$firstletter;
	}


	/**
	 * Search for a user based on one group
	 */
	function groupSearchRun(&$db, &$u, &$arg, &$t) {

		$arg->getvars[gid] != ''? $gid = $arg->getvars[gid]:$gid = $arg->postvars[gid];

		//patch for broken groups/suspended accounts
		if ($gid == '') { $or = " or groups  = '' "; }
		$t[start] = $arg->getvars[start];
		settype($t[start],"integer");


		$db->query("select *, lc.username as lc_username from lcUsers as lc LEFT JOIN profile on lc.username = profile.username where groups like '%|".$gid."|%' $or order by lc.username LIMIT ".$t[start].",".$this->PAGE_SIZE);
		while ($db->next_record() ) {
			if ( ($db->Record['firstname']== '') and ($db->Record['lastname'] == '') ) {
				$db->Record['profiledata'] = "<i>Incomplete profile data</i>";
			} else {
				$db->Record['profiledata'] = "<a href=\""._APP_URL."users/".$db->Record['pkey']."/event=show\">".$db->Record['lastname'].", ".$db->Record['firstname']."</a>";
			}
			$t['users'][] = $db->Record;
		}
		$db->query("select count(username) from lcUsers where groups like '%|".$gid."|%' $or");
		$db->next_record();
		$t[result_pages] = ceil( $db->Record[0] / $this->PAGE_SIZE);
		$t[current_page] = ceil( $t[start] / $this->PAGE_SIZE) + 1;
		$t[max_results] = $db->Record[0];
		$t[PAGE_SIZE] = $this->PAGE_SIZE;

		//groups
		$db->query("select * from lcGroups");
		while ($db->next_record() ) {
			$t["group_opt"] .= "<option value=\"".$db->Record[gid]."\">".$db->Record[groupName]." (".$db->Record[gid].") </option>\n";
		}

		//profile
		$db->query("describe profile");	//get profile meta data
		$db->next_record(); 		//drop off pkey
		$t['profile_opt'] .= "<option value='_email'>Email</option>\n";
		$t['profile_opt'] .= "<option value='_username'>Username</option>\n";
		while ($db->next_record() ) {
			$t[profile_opt] .= "<option value=\"".$db->Record[0]."\">".$db->Record[0]."</option>\n";
		}

		$t[opt1] = 'event=groupSearch';
		$t[opt2] = 'gid='.$gid;
	}



	/**
	 * Search for a user based on one profile field
	 */
	function profileSearchRun(&$db, &$u, &$arg, &$t) {

		if ($arg->getvars[prof] != '') {
			$prof = $arg->getvars[prof];
		} else {
			$prof = $arg->postvars[profile_field].'|'.$arg->postvars[q];
		}

		list ($prof_field,$prof_val)  = explode('|',addslashes(stripslashes($prof)));


		$t[start] = $arg->getvars[start];
		settype($t[start],"integer");

		if (($prof_field=='_email') || ($prof_field=='_username')) {
			$prof_field = substr($prof_field,1);
		$db->query("select *, lc.username as lc_username from lcUsers as lc LEFT JOIN profile on lc.username = profile.username where lc.".$prof_field." like '%".$prof_val."%' order by lc.username LIMIT ".$t[start].",".$this->PAGE_SIZE);
		$table = 'lcUsers';
		} else  {
		$db->query("select *, lc.username as lc_username from lcUsers as lc LEFT JOIN profile on lc.username = profile.username where profile.".$prof_field." like '%".$prof_val."%' order by lc.username LIMIT ".$t[start].",".$this->PAGE_SIZE);
		$table = 'profile';
		}

		while ($db->next_record() ) {
			if ( ($db->Record['firstname']== '') and ($db->Record['lastname'] == '') ) {
				$db->Record['profiledata'] = "<i>Incomplete profile data</i>";
			} else {
				$db->Record['profiledata'] = "<a href=\""._APP_URL."users/".$db->Record['pkey']."/event=show\">".$db->Record['lastname'].", ".$db->Record['firstname']."</a>";
			}
			$t['users'][] = $db->Record;
		}
		$db->query("select count(username) from $table where $prof_field like '%".$prof_val."%'");
		$db->next_record();
		$t[result_pages] = ceil( $db->Record[0] / $this->PAGE_SIZE);
		$t[current_page] = ceil( $t[start] / $this->PAGE_SIZE) + 1;
		$t[max_results] = $db->Record[0];
		$t[PAGE_SIZE] = $this->PAGE_SIZE;


		//groups
		$db->query("select * from lcGroups");
		while ($db->next_record() ) {
			$t["group_opt"] .= "<option value=\"".$db->Record[gid]."\">".$db->Record[groupName]." (".$db->Record[gid].") </option>\n";
		}

		//profile
		$db->query("describe profile");	//get profile meta data
		$db->next_record(); 		//drop off pkey
		$t['profile_opt'] .= "<option value='_email'>Email</option>\n";
		$t['profile_opt'] .= "<option value='_username'>Username</option>\n";
		while ($db->next_record() ) {
			$t[profile_opt] .= "<option value=\"".$db->Record[0]."\">".$db->Record[0]."</option>\n";
		}

		$t[opt1] = 'event=profileSearch';
		$t[opt2] = 'prof='.$prof;
	}



	/**
	 * Show the form for new user creation
	 */
	function newRun (&$db, &$u, &$arg, &$t) {
		$arg->templateName = "users_new";

		//grab optional profile data
		$db->query("describe profile");	//get profile meta data
		$db->next_record(); 		//drop off pkey
		$t['profile_opt'] .= "<option value='_email'>Email</option>\n";
		$t['profile_opt'] .= "<option value='_username'>Username</option>\n";
		while ($db->next_record() ) {
			$t[profile][] = $db->Record[0];
		}
	}



	/**
	 * add a user to the DB
	 */
	function addNewRun (&$db, &$u, &$arg, &$t) {

		//validate $required input, insert both 
		// required and optional

		$req = $arg->postvars[required];
		$opt = $arg->postvars[profile];
		$sendemail = $arg->postvars['sendemail'];


		$bad = checkRequired ($req);

		if ($bad) {
			$arg->templateName = "users_new";
			$this->newRun($db,$u,$arg,$t);
			return;
		}

		//insert core user
		$newuser = new lcUser();
		$newuser->username = $req[username];
		$newuser->password = $req[password];
		$newuser->email = $req[email];
                $newuser->groups[] = 'reg';     //add user to register group
		//$newuser->groups = implode("|", $req[groups]);
		
		$key = $newuser->addUser($db);


		//insert profile
		$newuser->updateProfile($opt);


		if ($sendemail=='on') { 
mail($req['email'],"Your new ".SITE_NAME." account","A new user account has been established for you at the ".SITE_NAME." website.\n\nPlease visit ".DEFAULT_URL." to use your new account.\n\nYour username is ".$req['username']." and your password is ".$req['password']."\n\nThank you.","From: ".WEBMASTER_EMAIL);
		}


		header("Location: "._APP_URL."users/$key/event=show");
		exit();
	}




	/**
	 * show a page for editing email, password, groups, and profile.
	 */

	function showRun (&$db, &$u, &$arg, &$t ) {
		$arg->templateName = "users_show";


			// USER
		$user = lcUser::getUserByPkey($arg->getvars[1]);
		if ($user->username == "anonymous" ) {
			$t[message] == "Cannot find user in database";
			return;
		}

		$t[user_info][username] = $user->username;
		$t[user_info][email] = $user->email;


			// GROUPS
		$db->query("select * from lcGroups order by groupName");
		while ($db->next_record() ) {
			$t[group_opt] .= "<option value=\"".$db->Record[gid]."\"";
			if ( @ in_array ($db->Record[gid],$user->groups) ) { $t[group_opt] .= " SELECTED "; }
			$t[group_opt] .= ">".$db->Record[groupName]." (".$db->Record[gid].") </option>\n";
		}


			// PROFILE
		$db->query("describe profile");	//get profile meta data
		$db->next_record(); 		//drop off pkey
		while ($db->next_record() ) {
			$t[profile_meta][] = $db->Record[0];
		}

		$db->query("select * from profile where username='".$user->username."'");
		$db->next_record();
		$t[user_profile] = $db->Record;

	}





	/**
	 * update the db with info about the users email, password, profile, and groups
	 */

	function updateRun (&$db, &$u, &$arg, &$t ) {
	//	$this->presentor = "debug"; return;
		$user = lcUser::getUserByPkey($arg->getvars[1]);
		$user->groups = $arg->postvars[group_opt];
		$user->email = $arg->postvars[email];
		if ( $arg->postvars[password] != "") {
			$user->password = $arg->postvars[password];
		}

		$user->update();

			// PROFILE
		$user = lcUser::getUserByPkey($arg->getvars[1]);
		$user->updateProfile($arg->postvars[profile]);

	header("Location: ". _APP_URL."users");
	exit();
	}



	function ShowDeleteRun (&$db, &$u, &$arg, &$t ) {
		if ($arg->postvars[confirm] == "yes") {
			if ($arg->postvars[uid] == "") {
				$this->presentor = "errorMessage";
				$t[message] = "There was a problem when trying to delete the user.";
				$t[details] = "No valid user id was passed to this service.";
				return;
			}
			$db->query("select username from lcUsers where pkey = ".$arg->postvars[uid]);
			$db->next_record();
			$uname = $db->Record[0];

			$db->query("delete from lcUsers where pkey = ".$arg->postvars[uid]);
			$db->query("delete from profile where username = '".$uname."'");
			header("Location: "._APP_URL."users");
			exit();
		}
		else {
			$arg->templateName ="users_delete";
			$t[uid] = $arg->getvars[1];
			$db->query("select username from lcUsers where pkey = ".$arg->getvars[1]);
			$db->next_record();
			$t[username] = $db->Record[0];
		}
	}


	/**
	 * if the submitted username is currently logged in, set a 
	 * cookie so the admin calling this function can be seen as
	 * said user.  Else log the admin in as the user.
	 * 10 min time limit
	 */
	function loginAsRun (&$db, &$u, &$arg, &$t ) {
		$this->presentor = 'debug';
		$username = $arg->getvars[1];
		$db->query("select sessKey from lcSessions where username = '$username'");
		if ($db->next_record() && $db->numrows ) {
			//set cookie
			setcookie("PHPSESSID",$db->Record[0],time()+600,"/",COOKIE_HOST);
			header("Location: ".DEFAULT_URL);
			exit();
		} else {
			//log in as normal user
			$u->username = $username;
			$u->bindSession();
			header("Location: ".DEFAULT_URL);
			exit();
		}
	}

	/**
	 * Show the presentation of all user collection UIs.
	 *
	 * A collection of users is stored in the herc user's session.
	 * A collection of users can have specific operations performed on
	 * all users at one time.  If a list of users is provided at call time,
	 * this function will save the users to the session object.
	 */
	function showTabRun (&$db, &$u, &$arg, &$t ) {
		// if we get some users, add them to the list
		if ($arg->postvars['users']) {
			$orclause = @join(" or pkey = ",$arg->postvars['users']);
			$db->query("select pkey,username from lcUsers where pkey = $orclause");
			while ($db->next_record() ) {
				$u->sessionvars['user_collection'][$db->Record[0]] = $db->Record[1];
			}
			$u->saveSession();
		}

		$t['groupOpts'] = makeOptions(lcGroup::getList());

		$t['collection'] = $u->sessionvars['user_collection'];

		$this->presentor = 'configurePresentation';
		$arg->templateName = 'users_'.$arg->getvars['tab'];
	}


	/**
	 * Add or remove groups to or from all the users in the current collection
	 *
	 */
	function alterGroupsRun (&$db, &$u, &$arg, &$t ) {
		$this->presentor="debug";

		$userList = lcUser::getListByPkey(array_keys($u->sessionvars['user_collection']));

			while ( list($x, $user) = @each($userList) ) {
				reset ($arg->postvars[groups]);
				unset($newGroups);

				if ($arg->postvars['groupAct'] == 'add') {
					while ( list ($k,$v) = @each($arg->postvars[groups]) ) {
						$user->groups[] = $v;
					}
					$user->update();
				}
				if ($arg->postvars['groupAct'] == 'del') {
					$user->groups = array_diff($user->groups,$arg->postvars[groups]);
					$user->update();
				}

			}
		
		unset($u->sessionvars['user_collection']);
		$u->saveSession();
		header("Location: "._APP_URL."users");
		exit();
	}

	/**
	 * Make every user in the current collection have exactly the groups that were submitted
	 *
	 */
	function resetGroupsRun (&$db, &$u, &$arg, &$t ) {
		$userList = lcUser::getListByPkey(array_keys($u->sessionvars['user_collection']));
			while ( list($x, $user) = @each($userList) ) {
				$user->groups = $arg->postvars[groups];
				$user->update();
			}
		unset($u->sessionvars['user_collection']);
		$u->saveSession();
		header("Location: "._APP_URL."users");
		exit();
	}


	/**
	 * Delete all users in the collection 
	 *
	 * This function does not take into account any module that stores
	 * user information internally (i.e. other tables).
	 * Optionally, a ~lcUser function may be added to the lcUser class
	 * in the future, this function should call that destructor instead.
	 */
	function deleteCollectionRun (&$db, &$u, &$arg, &$t ) {

		$orclause = @join(" or pkey = ",array_keys($u->sessionvars['user_collection']));
		if ($orclause != '')
			$db->query("delete from lcUsers where pkey = $orclause"); 

		unset($u->sessionvars['user_collection']);
		$u->saveSession();
		header("Location: "._APP_URL."users");
		exit();
	}

	/**
	 * Erase the user collection from the current session
	 *
	 */
	function clearCollectionRun (&$db, &$u, &$arg, &$t ) {
		unset($u->sessionvars['user_collection']);
		$this->run( $db, $u, $arg, $t ); 
	}
}


	function checkRequired($req) {
		foreach($req as $k=>$v) {
			if ($v == "") {
			$bad =1;
			}
		}
			
		if ($req[password] != $req[password2] ) {
			$bad = 1;
		}		
	return $bad;
	}
?>
