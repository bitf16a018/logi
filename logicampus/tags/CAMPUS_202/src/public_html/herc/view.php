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

class view extends HercAuth {
	var $presentor = "configurePresentation";

	function run (&$db,&$u,&$arg,&$t) {

                $db->query("select * from lcRegistry where mid = '".$arg->getvars[1]."'");
                $db->next_record();
		$modName = $db->Record[moduleName];
                $t["modName"] = ucfirst($db->Record[moduleName]);
                $t["mid"] = $db->Record[mid];
                $t["installedOn"] = $db->Record[lastModified];
                $t["author"] = $db->Record[author];


                if ( $t[presentor] == "") {
                        $t[presentor] = "default";
                }
		$db->query("select count(DISTINCT sesskey) from lcLogging where moduleName = '".$modName."' and (accesstime > (DATE_SUB(NOW(),INTERVAL 1 HOUR) ) )");
		$db->next_record();
			$t[hourly] = $db->Record[0];


		$db->query("select count(DISTINCT sesskey) from lcLogging where moduleName = '".$modName."' and (accesstime > (DATE_SUB(NOW(),INTERVAL 1 DAY) ) )");
		$db->next_record();
			$t[day] = $db->Record[0];


		$db->query("select count(pkey) from lcLogging where moduleName = '".$modName."' and (accesstime > (DATE_SUB(NOW(),INTERVAL 1 HOUR) ) )");
		$db->next_record();
			$t[hits_hourly] = $db->Record[0];


		$db->query("select count(pkey) from lcLogging where moduleName = '".$modName."' and (accesstime > (DATE_SUB(NOW(),INTERVAL 1 DAY) ) )");
		$db->next_record();
			$t[hits_day] = $db->Record[0];

        }
}
?>
