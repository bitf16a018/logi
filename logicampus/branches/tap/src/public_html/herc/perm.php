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



class perm extends HercAuth {

	var $presentor = "configurePresentation";
//	var $presentor = "debug";



	/**
	 * show a matrix of all groups and available permissions
	 * permissions are now defined in the registry rather than
	 * just assuming read,write,delete, etc...
	 */
	function run (&$db,&$u,&$arg,&$t) {

		$sql = "select * from lcGroups";

		$db->query($sql);
		while ($db->next_record() ) {
			$t[groups][] = array($db->Record[groupName],$db->Record[gid]);
			
		}

		$sql = "select *  from lcPerms where moduleID = '".$arg->getvars[1]."'";
		$db->query($sql);
		while ($db->next_record() ) {
			$ar[$db->Record[0]][] = $db->Record[2];
		}

		$t[perms] = $ar;
		$t[mid] = $arg->getvars[1];
		$t[modID] = $arg->getvars[1];

		$db->query("select moduleName,displayName,perms from lcRegistry where mid = '".$arg->getvars[1]."'");
//print "select moduleName,displayName,perms from lcRegistry where mid = '".$arg->getvars[1]."'";
		$db->next_record();

		$db->Record[displayName] =='' ? $t["modName"] = ucfirst($db->Record[moduleName]): $t["modName"] = ucfirst($db->Record[displayName]);

		$permsPairs = explode('|',substr($db->Record[perms],1,-1) );
			while (list ($k,$v) = @each($permsPairs) ) {
				list ($permk,$permname) = split(';',$v);
				if ($permk == '') {continue; }
				$t[modPerms][$permk] = $permname;
			}
		$arg->templateName = 'perm';
	}


	/**
	 * reset all permissions for this service to nothing.
	 * re-insert what was submitted as the current permissions
	 */
	function updateRun (&$db,&$u,&$arg,&$t) {

		//$this->presentor = "debug";

		if ( trim($arg->getvars['modID']) == '' ) {
			$t['message'] = "Permission key lost, no permissions were altered.";
			$this->run($db,$u,$arg,$t);
			return;
		}

		$sql = "insert into lcPerms (groupID,moduleID,action) VALUES ('%s','".$arg->getvars['modID']."','%s')";

		//we're going to reset all the perms with info from the website, so 
		// remove all existing info.
		$db->query("delete from lcPerms where moduleID = '".$arg->getvars['modID']."'");
		while ( list ($group,$actions) = @each($arg->postvars[perms]) ) {
			while ( list ($k,$v) = @each ($actions) ) {
				$db->query( sprintf($sql,$group,$k) );
			}
		}

		$t["message"] = "Permissions updated!";
		$arg->getvars[1] = $arg->getvars['modID'];
			//show the table again
		$this->run($db,$u,$arg,$t);
	}


	/**
	 * show a list of all the permissions available to this service
	 * allow for adding and removing of permissions
	 */
	function permChangeRun (&$db,&$u,&$arg,&$t) {
		$db->queryOne("select moduleName,displayName,perms from lcRegistry where mid = '".$arg->getvars[modID]."'");

		$db->Record[displayName] =='' ? $t["modName"] = ucfirst($db->Record[moduleName]): $t["modName"] = ucfirst($db->Record[displayName]);

		$permsPairs = explode('|',substr($db->Record[perms],1,-1) );
			while (list ($k,$v) = @each($permsPairs) ) {
				list ($permk,$permname) = split(';',$v);
				if ($permk == '') {continue; }
				$t[modPerms][$permk] = $permname;
			}
	$t[modID] = $arg->getvars[modID];
	$arg->templateName = 'perm_change';
	}


	/**
	 * show a list of all the permissions available to this service
	 * allow for adding and removing of permissions
	 */
	function alterRun (&$db,&$u,&$arg,&$t) {
		$db->queryOne("select moduleName,displayName,perms from lcRegistry where mid = '".$arg->getvars[modID]."'");

		$db->Record[displayName] =='' ? $t["modName"] = ucfirst($db->Record[moduleName]): $t["modName"] = ucfirst($db->Record[displayName]);

		//prune changes to old perms
		while (list ($k,$v) = @each($arg->postvars[modPerms]) ) {
			if ($v[key] == '') {continue; }
			$newPerms[$v[key]] = $v[name];
		}

		//check to add new perm
		$np = $arg->postvars[newPerm];
		if ( ($np[key] != '') && ($np[name] != '')) {
			@extract($arg->postvars[newPerm]);
			$newPerms[$key] = $name;
		}

		//if the button save was hit, write to db and redirect
		if ($arg->postvars[b] == 'save') {
			while ( list($k,$v) = @each($newPerms) ) {
				$string .= "$k;$v|";
			}
			$db->query("update lcRegistry set perms = '|$string' where mid='".$arg->postvars[modID]."'");
			$t["message"] = "Permissions altered!";
			//show the table again
			$arg->getvars[1] = $arg->getvars[modID];
			$this->run($db,$u,$arg,$t);
			return;
		}
	$t[modPerms] = $newPerms;
	$t[modID] = $arg->postvars[modID];
	$arg->templateName = 'perm_change';
	}
}

?>
