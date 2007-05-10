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


/**
 * handle group create, deletion, and permission
 * setting for the whole site.
 */
class groups extends HercAuth {

	var $presentor = "plainPresentation";
	var $dontdelete = array('public','admin','reg','advert','pub','new');
	
	/**
	 * display all groups in a large select box
	 */
	function run (&$db,&$u,&$arg,&$t) {

		$db->query("select * from lcGroups");
		while ($db->next_record() ) {
			if ( in_array($db->Record[gid],$this->dontdelete) ) {
				$db->Record[groupName] = '*'.$db->Record[groupName];
			}
			$t["group_opt"] .= "<option value=\"".$db->Record[gid]."\">".$db->Record[groupName]." (".$db->Record[gid].") </option>\n";
		}
        }



	/**
	 * show all the permissions for each module in a matrix
	 *
	 *  ========== map of output structure ==============
	 * $t [modNames]  (Welcome,
	 *			[id] ( welcome)
	 *			     ( foo )
	 *			[perms] (foo, allowFoo)
	 *		  )
	 *		  (Advertising, 
	 *			[id]  (banners)
	 *		[perms]		(time, AllowTime)
	 *				(foo,  AllowFoo)
	 *				(access, Access)
	 *
	 *    [perms]	  (Welcome
	 *			  (0,access)
	 *		  )
	 *
	 */
	function showRun (&$db,&$u,&$arg,&$t) {

		//grab the permissions that they have
		$db->query("select displayName, lcPerms.action, mid from lcRegistry left join lcPerms on lcRegistry.mid = lcPerms.moduleID and lcPerms.groupID = '".$arg->getvars[1]."' order by displayName");
		while ($db->next_record() ) {
			$t[modNames][$db->Record[0]][id] = $db->Record[2];
			$temp[$db->Record[0]][] = $db->Record[1];
		}

		$t[perms] = $temp;


		//grab all custom permissions
		while (list ($modName,$mid) = @each($t[modNames]) ) {
			$db->queryOne("select perms from lcRegistry where mid = '".$mid[id]."'");
			$permsPairs = explode('|',substr($db->Record[perms],1,-1) );
				while (list ($k,$v) = @each($permsPairs) ) {
					list ($permk,$permname) = split(';',$v);
					if ($permk == '') {continue; }
					$modPerms[$permk] = $permname;
				}
			$t[modNames][$modName][perms] = $modPerms;
			unset($modPerms);
		}
		@reset($t[modNames]);

		//a few other UI things
		$db->queryOne("Select groupName from lcGroups where  gid = '".$arg->getvars[1]."'");
		$t[gName] = $db->Record[0];
		$t[gid] = $arg->getvars[1];
		$arg->templateName = "groups_show";
	}


	/**
	 * remove a group from the system.
	 * clean up any remaining permissions
	 */
	function deleteRun (&$db,&$u,&$arg,&$t) {

		if ( in_array($arg->postvars[group_opt],$this->dontdelete) ) {
			$t[message] = "You cannot delete that group";
			$this->run($db,$u,$arg,$t);
			return;
		}
		
		$sql = "select * from lcGroups where gid = '".$arg->postvars[group_opt]."'";
		$db->query($sql);
		$db->next_record();
		$oldGroup = $db->Record;

				//get full name from gid
		$sql = "delete from lcGroups where pkey = ".$oldGroup[pkey];
		$db->query($sql);
		$t[message] = "Group '$oldGroup[groupName]' deleted";

				//remove from tables lcPerms
		$sql = "delete from lcPerms where groupID = '".$oldGroup[gid]."'";
		$db->query($sql);

		//no more permissions array in lcRegistry table

		$this->run($db,$u,$arg,$t);
	}



	/**
	 * create a new groups
	 * possibly default access for this groups in all services
	 */
	function newRun (&$db,&$u,&$arg,&$t) {

		if ( ($arg->postvars[gid] == "") || ($arg->postvars[groupName] == "") ) {
			$t[message] = "Error, missing input fields";
			$this->run($db,$u,$arg,$t);
			return;
		}

		//integrity check
		$sql = "select * from lcGroups where gid = '".$arg->postvars['gid']."' or groupName = '".$arg->postvars['groupName']."'";
		$db->query($sql);
		if ($db->next_record()) {
			$t[message] = "Duplicate Groups (".$arg->postvars['groupName'].",".$arg->postvars['gid'].").  Either the gid or groupName chosen is already in use.";
			$this->run($db,$u,$arg,$t);
			return;
		}	
		$sql = "insert into lcGroups (gid,groupName,created) VALUES ('".$arg->postvars[gid]."','".$arg->postvars[groupName]."', NOW())";
		$db->query($sql);

		$t[message] = "Group Added";
		$this->run($db,$u,$arg,$t);
	}


	/**
	 * set the new permissions in the DB
	 */
	function updateRun (&$db,&$u,&$arg,&$t) {

		$sql = "insert into lcPerms (groupID,moduleID,action) VALUES ('%s','%s','%s')";


		$gid = $arg->postvars[gid];
		$mid = $arg->postvars[mid];

		$db->query("delete from lcPerms where groupID = '".$arg->postvars[gid]."' and moduleID = '".$arg->postvars[mid]."'");
			while ( list ($k,$v) = @each ($arg->postvars[perms]) ) {
//	printf($sql,$gid,$mid,$k);
				$db->query( sprintf($sql,$gid,$mid,$k) );
			}
//exit();
		$db->query("select displayName from lcRegistry where mid = '".$mid."'");
		$db->next_record();
	$t[message] = "Group permissions updated for module : ".$db->Record['displayName'];
	$this->showRun($db,$u,$arg,$t);
	}

}
?>
