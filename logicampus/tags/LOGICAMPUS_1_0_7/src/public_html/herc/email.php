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

class email extends HercAuth {

	var $presentor = "plainPresentation";

	/**
	 * show HTML form for message input
	 */
	function run (&$db,&$u,&$arg,&$t) {
                 $g = new lcGroup($db);
               	 $g->getList();
               	 $t["groups"] = $g->optionList;
               	 $t["notgroups"] = $g->optionList;
		$db->query("describe lcUsers");
		while($db->next_record()) {
			if (!is_int($db->Record[0])) {
				$x[$db->Record[0]] = "[{$db->Record[0]}]";
			}
		}

		$db->query("describe profile");
		while($db->next_record()) {
			if (!is_int($db->Record[0])) {
				$x[$db->Record[0]] = "[{$db->Record[0]}]";
			}
		}
		ksort($x);
		reset($x);
		$t['optionlist'] = $x;

		
	}



	/**
	 * send the emial with PHP's mail function (sendmail)
	 */
	function sendRun(&$db, &$u, &$arg, &$t) {
		$arg->templateName = "emaildone";


		$groups = $arg->postvars["groups"];
		$subject = $arg->postvars["subject"];
		$from = $arg->postvars["from"];
		$message = $arg->postvars["message"];

			$notgroups = $arg->postvars["notgroups"];

         if (! is_array($groups) ) {
		$t['emails'] = "You did not select any one at all to mail.  <h2>No mails were sent</h2>";
		return;
         }

		$orClause = createGroupCheck($groups);

		if ( is_array($notgroups) ) {
			$orNotClause = createGroupCheck($notgroups);
		}

		if ($orClause) { $where = " where  ($orClause)"; }
		if ($orNotClause) { 
			if ($where) { 
				$where .= " and not ($orNotClause)"; 
			} else {
				$where = " where ($orNotClause)";
			}
		}

		$db->query("select * from lcUsers left join profile on profile.username=lcUsers.username $where");
$start = date("m/d/Y h:i:s A");
		$subject = stripslashes($subject);
		$message = stripslashes($message);
		while($db->next_record()) { 
                        if (ereg("@",$db->Record['email'])) {
                        $newmessage = $message;
                        while(list($k,$v) = each($db->Record)) {
                                if (!is_int($k)) {
                                $k = '['.$k.']';
                                $newmessage = str_replace($k,$v,$newmessage);
                                }
                        }
                                mail($db->Record['email'],$subject,$newmessage,"From: $from");
				$x .=  $db->Record['email']."<BR>";
			}
		}
$end = date("m/d/Y h:i:s A");
		$t["emails"] = $x;
		$t["start"] = $start;
		$t["end"] = $end;

	}	

}
?>
