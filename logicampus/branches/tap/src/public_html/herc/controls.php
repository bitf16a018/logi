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

class controls extends HercAuth {
	var $presentor = "plain";

	function run (&$db,&$u,&$arg,&$t) {
		$db->query("select* from lcRegistry where showInMenu = 1 order by displayname");
		while ($db->next_record() ) {
			//print_r($db->Record);
			$t["modules_opt"] .= "<option value=\"".$db->Record[mid]."\">".$db->Record["displayName"]."</option>\n";
		}
	}
}

function plain (&$obj, &$t) {
	include ("templates/".$obj->templateName.".html");
}
?>
