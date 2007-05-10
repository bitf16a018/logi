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


include_once(LIB_PATH."LC_html.php"); 	//for hercBox()

/**
 * send mass emails to groups of users.
 */

class maillist extends HercAuth {

	var $presentor = "plainPresentation";

	/**
	 * show HTML form for message input
	 */
	function run (&$db,&$u,&$arg,&$t) {

			
		$db->query("select * from lcGroups");
		$exclude = array("public", "reg", "admin", "new", "adm_evt");
		while ($db->next_record() ) {
			

			# Build import groups ( groups that start with "imp_"
			#if (eregi("^imp_", $db->Record['gid']) )
			#{
			#	$t['importgroups'][$db->Record['gid']] = $db->Record['groupName'];
			#}
			# Build our mailing list groups
			if (  (eregi("^ml_", $db->Record['gid']) ) or (eregi("^imp_", $db->Record['gid']) ) )
			{ 
				# Put these in another variable
				$t['mlgroups'][$db->Record['gid']] = $db->Record['groupName'];
				
			}
						
			# Build our groups array
			if ( !eregi("^ml_", $db->Record['gid']) )
			{
				$t["groups"][$db->Record['gid']] = $db->Record['groupName'];
			}
						
		}
		
		# Grab all mailing list for the drop down.
		$db->query("select * from lcMailList");
		$db2 = DB::getHandle();
		while ($db->next_record())
		{
				# Put these in another variable
				$t['mldropdown'][$db->Record['gid']] = $db->Record['title'];
				$db2->queryOne("select count(*) as count from lcUsers where groups like '%|".$db->Record['gid']."|%'");
				$x[$db->Record['gid']] = $db2->Record['count'];

		}
		#print_r($x);
		
		# get all mailing list info
		$sql = "select * from lcMailList";
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$db->query($sql);
		$t['html'] = '<ul>';
		while($db->next_record())
		{
			$t['html'] .= "<li><a href=\""._APP_URL."maillist/event=edit/pkey=".$db->Record['pkey']."\">".$db->Record['title']." (".$x[$db->Record['gid']].")</a></li>";
		}
		$t['html'] .= '</ul>';
        
	}
	
	function editRun (&$db, &$u, &$arg, &$t) {
		$pkey = $arg->getvars['pkey'];
		$sql = "select * from lcMailList where pkey='$pkey'";
		$db->queryOne($sql);
		$t['list'] = $db->Record;
		$t['list']['groups'] = explode("|", $db->Record['groups']);
		$t['list']['notgroups'] = explode("|", $db->Record['notgroups']);
		$this->run($db, $u, $arg, $t);
		return;
	}


	function addUpdaterun (&$db,&$u,&$arg,&$t) {
		#print_r($arg->postvars);
		if ($arg->postvars['gid'] == 'none' ) 
		{
			$t['error'] = '<li>You must select at least one group which will be associated with a mailing list.</li>';
		}
		
		
		if (trim($arg->postvars['title']) == '')
		{
			$t['error'] .= '<li>You must enter a title.</li>';
		}
		
		if ($t['error'] != '')
		{
			# we have an error, send it back
				$t['list']['groups'] = $arg->postvars['groups'];
				$t['list']['notgroups'] = $arg->postvars['notgroups'];
				$t['list']['title'] = $arg->postvars['title'];
				$t['list']['description'] = $arg->postvars['description'];
				$t['list']['pkey'] = $arg->postvars['pkey'];
				$t['list']['gid'] = $arg->postvars['gid'];
				$this->run($db, $u, $arg, $t);
				return;
		}
		
		# If we've gotten this far, there are no errors.
		
		$groups = '|'.@implode($arg->postvars['groups'], '|').'|';
		$notgroups = '|'.@implode($arg->postvars['notgroups'], '|').'|';
		$pkey = $arg->postvars['pkey'];
		$title = $arg->postvars['title'];
		$description = $arg->postvars['description'];
		$gid = $arg->postvars['gid'];
		$sql = "REPLACE INTO lcMailList SET pkey='$pkey', 
				title='$title', 
				description='$description',
				gid='$gid',
				groups='$groups',
				notgroups='$notgroups'";
		
		$db->query($sql);
		
		# We now need to take all of the users that were allowed to see this
		# mailing list, and remove them from this group and reset their permissions
		# This sucks but we have to do it.
		
		$sql = "select pkey, groups from lcUsers where groups like '%|$gid|%'";
		#echo $sql;
		$db->query($sql);
		$db2 = DB::getHandle();
		while($db->next_record() )
		{
			$tmp_perms = explode("|", $db->Record['groups']);
			# clean the array
			$tmp_perms = array_filter($tmp_perms, "emptyValue");
			if (in_array($gid, $tmp_perms) )
			{
				while (list ($x, $grp) = @each($tmp_perms) )
				{
					if ($gid == $grp)
					{
						continue;
					}
					$cleanArray[] = $grp;
				}
				unset($tmp_perms);
				# update the database with new group info
				$groups = '|'.@implode($cleanArray, "|").'|';
				$db2->query("update lcUsers set groups='$groups' where pkey='".$db->Record['pkey']."'");
			}
			
			
			
		}
		
		$t['msg'] = '<div style="color: blue"><b>Mailing list "'.$title.'" updated.</b></div>';
		$this->run($db, $u, $arg, $t);
		return;
		
	}

		function deleteRun(&$db, &$u, &$arg, &$t)
		{
			$sql = "delete from lcMailList where pkey='".$arg->getvars['pkey']."'";
			$db->query($sql);
			$t['msg'] = '<div style="color: blue"><b>Mailing list deleted.</b></div>';
			$this->run($db, $u, $arg, $t);
			return;
		}

		function importRun(&$db, &$u, &$arg, &$t)
		{
			$starttime = time();
			$db2 = DB::getHandle();
			ini_alter("max_execution_time", 3600);
			#print_r($arg->uploads);
			if ($arg->uploads['file']['tmp_name'] != '') 
			{
				 #We have an upload, let's process it!
				 extract($arg->uploads['file']);
				 $fp = fopen($tmp_name, "r");
				 $buffer = fread($fp, $size);
				 fclose($fp);
				 
			}	 
			
			if (!$buffer) {
				
				if (strlen(trim($arg->postvars['emails'])) <= 4 )
					{
						redirect($db, _APP_URL."maillist");
						return;
					} else 
					{
						
						$buffer = $arg->postvars['emails'];
						
					}
			}
				
			$tmp = split("\n",$buffer);
			while (list ($k, $v) = @each($tmp) )
			{
				$tmp[$k] = strtolower($v);
			}
			
			$tmp = array_unique($tmp);
			#print_r($tmp);
			#exit();
			
			# Check the size of the import
			# If it is over 5000 lines, print an error
			
			$t['count'] = count($tmp);
			if ($t['count'] >= 2000) {
				$t['error'] = "<li>You can only upload 2000 emails at a time. Total entered:  {$t['count']}</li>";	
				$this->run($db, $u, $arg, $t);
				return;
			}
			
			for ($i=0; $i<$t['count']; $i++)
			{
				++$t['total'];
				#echo $t['total'].' '.$tmp[$i].'<br>';
				$tmp[$i] = trim($tmp[$i]);
				if ($tmp[$i] == '' ) continue;
				$tmpuser = split("@", $tmp[$i]);
				# Generate appending 
				$append = substr(md5($tmp[$i]), 0, 4);
				$acc = new lcUser();
				
				# Note: I had to addslashes because some idiots have a ' in their 
				# username, the one I ran into was "o'reilly.patrick"
				$acc->username = addslashes($tmpuser[0].$append);
				$acc->password = substr(md5($tmp[$i]), 0, 8);
				$acc->groups = array($arg->postvars['group']);
				$acc->email = addslashes($tmp[$i]);
				$key = $acc->addUser($db);
				if ( intval($key) < 1 ) {
					$t['previousAccounts'] .= $acc->email."\n";
					++$t['diff'];	
					
					#Let's hit the DB and update this users's group so
					#he is in the group the site admin just added him to.
					#this of course assumes that email is a unique field in the DB
					$sql = "select pkey, groups from lcUsers where email='{$acc->email}'";
					
					$db2->query($sql);
					$db3 = DB::getHandle();
					while($db2->next_record() )
					{
						$tmp_perms = explode("|", $db2->Record['groups']);
						# clean the array
						$tmp_perms = array_filter($tmp_perms, "emptyValue");
						
						# Make sure the user doesn't already belong to that group
						if (!in_array($arg->postvars['group'], $tmp_perms))
						{
							$tmp_perms[] = $arg->postvars['group'];
							# update the database with new group info
							$groups = '|'.@implode($tmp_perms, "|").'|';
							$db3->query("update lcUsers set groups='$groups' where pkey='".$db2->Record['pkey']."'");
						}
					}
						
					
			}  else {
				$db->query("insert into profile (username) VALUES ('".$acc->username."')");
			}
			unset($acc);
			}
			$t['msg'] = "List Updated.";
			$endtime = time();
			
			$t['seconds'] = $endtime - $starttime;
			$arg->templateName = "import_review";
			return;	
			#print_r($username);
		}

}
		
		# Used to clean the groups array
		function emptyValue($var)
		{
			trim($var);
			if ($var != '')
			{
				return $var;
			}
			
		}
?>
