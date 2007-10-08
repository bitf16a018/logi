<?
/*
 * forum
 * Last updated 10/01/2002
 * 
 * Purpose:
 * Forum module system
 */

require_once(LIB_PATH."LC_sql.php");


class newForum {

	function newForum($fid="") { 
		$this->fid = $fid;
	}

	/**
	 * check forum specific permissions
	 * regular permissions are not fine grained enough to hancle
	 * specific data objects inside a module
	 * maybe the new onces can
	 */
	function hasPerm($perm,$groups) {
		$db = DB::getHandle();
		$g = @implode("' or groups='",$groups);
		$fid = $this->fid;
		$db->queryOne("select count(fid) AS total from forumPerms where perm='$perm' and fid='$fid' and (groups='$g')");
		$x = $db->record['total'];
		unset($db);
		if ($x>0) { return true; } else { return false; }
	}

	/**
	 * check forum preferences like sending emails (bcls)
	 */
	function getPref($prefName,$username) {
		$db = DB::getHandle();
		$sql = "select * from forumPrefs where username = '$username' and pref_key = 'sendEmail' and pref_val = '".$this->fid."'";
		$db->query($sql);
		if ($db->nextRecord() ) {
			return true;
		} else {
			return false;
		}			
	}
	
	
	function _get($fid="") { 
		$db = DB::getHandle();
		if (!$fid) { $fid = $this->fid; }
		$db->queryOne("select * from forums where fid='$fid'");
		$j = $db->record;
		unset($db);
		return $j;
	}


}


class forummod extends PersistantObject {


	function getmessage($db,$sql) {
		$db->query($sql);
		while ($db->nextRecord()) {
			$message = $db->record["message"];
			$body = $db->record["body"];
			$pkey = $db->record["pkey"];
			$timedate = date("m/d/Y h:i:s A",$db->record["stamptime"]);
			$parent = $db->record["parent"];
			$fid = $db->record["fid"];
			$username = $db->record["username"];
			if (!$username) { $username="Anonymous"; }
			$messageshow .= "<h2>$message</h2>\n";
			$messageshow .= "Posted on $timedate by $username<br>\n";
			$messageshow .= "$body<BR><hR>";
			}
		return array($messageshow,$pkey);
	}



	function getForums($group="") {
		$db = DB::getHandle();

		if (trim($group) != "") { $where = " where $group"; }
		$sql = "select forumname,fid,forumdesc from forums $where";
		$db->query($sql);
		while ($db->nextRecord()) {
			extract($db->record);
			$this->forumList["forumid"][] = $fid;
			$this->forumList["forumname"][] = $forumname;
			$this->forumList["forumdesc"][] = $forumdesc;
			$list .= "<option value=\"$fid\">$forumname\n";
		}
		$this->optionList = $list;
	}			

	function forumList2HTML() {
		while (list($key,$val) = each($this->forumList["forumid"])) {
			$fid = $this->forumList["forumid"][$key];
			$forumname = $this->forumList["forumname"][$key];
			$colorcount++ % 2 == 0 ? $rowclass = 'forum_row1' : $rowclass='forum_row2';        //alternating colors
			$this->forumlist .= "<a class=\"".$rowclass."\" href=\"".modurl("forum/event=list/fid=$fid")."\">$forumname</a><BR>\n";
		}
		reset($this->forumList);
	}

	function getForum() {
		$db = DB::getHandle();
		$db2 = DB::getHandle();
$fid = $this->fid;
		$sql = "select * from forums where fid = '$fid'";
		$db->query($sql);
		while($db->nextRecord()) {
			$sql = "select count(pkey) AS total from forumPosts where fid='$fid' and status<>'y'";
			$db2->query($sql);
			$db2->nextRecord();
			$count = intval($db2->record['total']);
			$this->off = $count;
			$this->forumname = $db->record["forumname"];
			$this->forumdesc = $db->record["forumdesc"];
			$this->forumemail = $db->record["email"];
			$this->uploadmaxk = $db->record["uploadmaxk"];
			$this->uploadcount = $db->record["uploadcount"];
			$this->defaultstatus = $db->record["defaultstatus"];
			$this->groups = explode("|",$db->record["groups"]);
		}
	}

	function addForum() {
		$db = DB::getHandle();
		$sql = "select count(fid) AS total from forums where fid='".$this->fid."'";
		$db->query($sql);
		$db->nextRecord();
		$count = intval($db->record['total']);
		if ($count>0) {
			return false;
		} else {
			$fid = $this->fid;
			$forumname = $this->forumname;
			$forumdesc = $this->forumdesc;
			$forumuploads = intval($this->uploadcount);
			$forummaxk = intval($this->uploadmaxk);

			$email = $this->email;
			$defaultstatus = $this->defaultstatus;
			
			$sql = "insert into forums (fid,forumname,forumdesc,email,defaultstatus,uploadcount,uploadmaxk) values (";
			$sql .= "'$fid','$forumname','$forumdesc','$email','$defaultstatus',$forumuploads,$forummaxk)";
			$db->query($sql);
			return true;
		}
	}

	function updateForum() {
		
        $db = DB::getHandle();
        
        $sql = "select count(fid) existance_count from forums where fid='".$this->fid."'";
		$db->queryOne($sql);
        if ((int)$db->record['existance_count'] > 0)
        {
            $sql = '
            UPDATE forums
            SET forumname=\''.$this->forumname.'\',
            forumdesc=\''.$this->forumdesc.'\',
            email=\''.$this->email.'\',
            defaultstatus=\''.$this->defaultstatus.'\'
            WHERE fid=\''.$this->fid.'\'
            ';

            $db->query($sql);
            if (mysql_affected_rows() > 0)
                return true;
                else
                return false;
        }

    return false;
	}

	function deleteForum() {
		$db = DB::getHandle();
			$fid = $this->fid;

		$sql = "delete from forums where fid='$fid'";
		$db->query($sql);
	}



	function postmessage() {
		$db = DB::getHandle();
		$this->body = $this->body;
		$this->message = $this->message;

		$stamp = time();
		$sql = "insert into forumPosts (status,parent,stamptime,recentpost,username,body,message,fid) values (";
		$sql .= "'".$this->defaultstatus."','".$this->mid."',$stamp,$stamp,'".$this->username."','".$this->body."','".$this->message."','".$this->fid."')";
		$db->query($sql);
		if ($this->parent>0) { 
			$db->query("update forumPosts set recentpost=$stamp where pkey=".$this->parent);
		}
		$db->query("select pkey from forumPosts where stamptime = $stamp and username='".$this->username."' and body='".$this->body."'");
		$db->nextRecord();
		$this->messageid = $db->record['pkey'];
	}


	function addAttach() {
		$db = DB::getHandle();
		$fid = $this->fid;
		$mid = intval($this->mid);
		$name = $this->filename;
		$loc = $this->filelocation;
		$type = $this->filetype;
		$size = intval($this->filesize);
		$desc = $this->filedesc;
		$sql = "insert into forumfiles (fid,mid,filedesc,filelocation,filetype,filesize,filename) values (";
		$sql .= "'$fid',$mid,'$desc','$loc','$type',$size,'$name')";
		$db->query($sql);
	}

	function getAttach() {
		$db = DB::getHandle();
		$fid = $this->fid;
		$mid = intval($this->mid);
		$sql = "select filename,filedesc from forumfile where fid='$fid' and mid=$mid";
		$db->query($sql);
		unset($name);
		unset($desc);
		while ($db->nextRecord()) {
			$name[] = $db->record["filename"];
			$desc[] = $db->record["filedesc"];
		}
		$this->filename = $name;
		$this->filedesc = $desc;
	}
}



class ForumPost extends baseObject {

/* 
 * "transient" variables 
 * won't get saved/read by default
 * need to come up with a better way to handle one-to-many relations
 * (attachments)
 */
	function _getTrans() { 
		return array("attach");
	}


	function forumpost($tablename="forumPosts",$key="pkey") {
		$this->_tableName = $tablename;
		$this->_key = $key;
		$this->_getAllSQL = " select * from forumPosts ";
	}

	function addAttach($filename,$location,$filedesc="") {
		$this->attach[name][] = $filename;
		$this->attach[path][] = $location;
		$this->attach[desc][] = $filedesc;
	}

	function & getMessage($message,$forumID,$canModerate) { 
		$db = DB::getHandle();

		if (!$canModerate) {
			$st = " and status='y'";
		}
		$db->queryOne("select * from forumPosts where pkey=$message and parent=0 and fid='$forumID' $st");
		$results[] = $db->record;
		$db->query("select * from forumPosts where  parent=$message $st");
		while($db->nextRecord()) { 
			$results[] = $db->record;
		}
		return $results;
	}

	function & readMessage($message,$forumID,$canModerate) { 
		$db = DB::getHandle();
		$db->query("update forumPosts set views = views + 1 where pkey=$message");
		return ForumPost::getMessage($message,$forumID,$canModerate);
	}


	function message2HTML($list,$canModerate) {
		$db = DB::getHandle();
		while (list($key,$val) = @each($list)) {
			$message = $val["message"];
			$body = $val["body"];
			$pkey = $val["pkey"];
			$date = date("m/d/Y h:i A",$val["stamptime"]);
			$parent = $val["parent"];
			$fid = $val["fid"];
			$ip = $val["ip"];
			if ($ip) { $ip = "($ip)"; }
			$username = $val["username"];
			$status = $val["status"];

			if ($this->_wordWrap != 0 ) $body = wordwrap($body, $this->_wordWrap);
			if (!$username) { $username="anonymous"; }
			$u = $username;
			if ($u != "anonymous") {
				$u = urlencode($u);
//				$username = "<a href=\"".modurl("forum/viewuser/$u")."\">$username</a>";
			}
			if ($row=="forum_row1") { $row="forum_row2"; } else { $row="forum_row1"; }

// not approved - make it red
			$approve = "";
			global $PATH_INFO;
			$return = @base64_encode($PATH_INFO);
			if ($status!="y") { 
				$row="forum_moderated";
				if ($canModerate) { 
// ack - global!!
					$approve[] = "<a href=\"".modurl("forum/event=mod_approve/fid=$fid/pkey=$pkey/return=$return")."\">approve</a>";
				}
			}
			if ($status=="y") { 
				if ($canModerate) { 
					$approve[] = "<a href=\"".modurl("forum/event=mod_suspend/fid=$fid/pkey=$pkey/return=$return")."\">suspend</a>";
				}
			}

			if ($canModerate) { 
				$approve[] = "<a href=\"".modurl("forum/event=mod_delete/fid=$fid/pkey=$pkey/return=$return")."\">delete</a>";
			}

			if ($approve) { $approve = @implode(" | ",$approve); }

			
			$messageshow .= "<tr><td class=\"$row\" width=\"30%\" class=\"$row\" valign=\"top\"><b>$username</b></td><td class=\"$row\" valign=:\"top\">Subject: <b>$message</b></td><td width=\"30%\" class=\"$row\" valign=\"top\" align=\"right\"><i>$ip$approve</i></td></tr>";
			$messageshow .= "<tr><td class=\"$row\" width=\"30%\" class=\"$row\" valign=\"top\">Posted on:<br> $date</td><td class=\"$row\" valign=\"top\" colspan=\"2\"><pre>".$body."</pre></td></tr>\n";


			++$messageCount;

			if ($messageCount==1) { 
				$messageshow .= "<tr><td class=\"forum_head2\" colspan=\"3\" align=\"left\">Replies</td></tr>\n";
			}

		}
		return $messageshow;
	}


	/**
	 * make html out of a list of replies
	 */
	function messageList2HTML($list,$canModerate) {
		if (is_array($list)) {
		$db = DB::getHandle();
		while (list($key,$val) = each($list)) {
			$pkey = $val["pkey"];
			$count = $val["replies"];
			$colorcount++ % 2 == 0 ? $rowclass = 'forum_row1' : $rowclass='forum_row2';        //alternating colors
			//colorize the suspended posts
			if ( $val["status"] != 'y' ) {
				$rowclass = 'forum_suspended';
			}

			if (intval($count)==0) {
				$db->query("select count(pkey) AS total from forumPosts where parent=$pkey and status='y'");
				$db->nextRecord();
				$count = intval($db->record['total']);	
			}
			
			$views = $val["views"];
			$message = $val["message"];
			$body = $val["body"];
			$timedate = $val["stamptime"];
			$parent = $val["parent"];
			$fid = $val["fid"];
			$username = $val["username"];
			$status = $val["status"];

			$u = $username;
			if ($u != "") {
				$u = urlencode($u);
//				$username = "<a href=\"".modurl("forum/viewuser/$u")."\">$username</a>";
			} else { 
				$username="anonymous"; 
			}
			$recentpost = $val["recentpost"];
			if (intval($recentpost)==0) { $recentpost=""; } else {
				$recentpost = date("m/d/Y",$recentpost)."<BR>".date("h:i:s A",$recentpost);
			}
			$datetime = date("m/d/Y",$timedate)."<BR>".date("h:i:s A",$timedate);

// not approved - make it red
			if ($status!="y") { 
				$bgcolor="rowred";
			}

			$mlist .= "<tr><td  class=\"".$rowclass."\" valign=\"top\">$username</td><td valign=\"top\" class=\"".$rowclass."\">\n";
			$mlist .= "<a href=\"".modurl("forum/event=read/fid=$fid/m=$pkey")."\">$message</a>\n";
			$mlist .= "</td><td  class=\"".$rowclass."\">$count</td><td class=\"".$rowclass."\">$views</td>\n";
			$mlist .= "<td class=\"".$rowclass."\">$recentpost</td>";
			$mlist .= "</tr>\n";


		}
		}
		return $mlist;
	}



}






class forums {

/* 
 * "transient" variables 
 * won't get saved/read by default
 * need to come up with a better way to handle one-to-many relations
 * (attachments)
 */
	function _getTrans() { 
		return array("attach");
	}


	function forums($tablename="forums",$key="pkey") {
		$this->_tableName = $tablename;
		$this->_key = $key;
	}

	function isValid($forumID,$groups) {
		$db = DB::getHandle();
		$db->queryOne("select count(fid) AS total from forums where 1=1 and ".createGroupCheck($groups)." and fid='$forumID'");
		return $db->record['total'];
	}

	function addAttach($filename,$location,$filedesc="") {
		$this->attach[name][] = $filename;
		$this->attach[path][] = $location;
		$this->attach[desc][] = $filedesc;
	}


	function forumList2HTML($list) {
		while (list($key,$val) = @each($list)) {


			$fid = $val["fid"];
			$posts = $val["validposts"];
			$threads = $val["numthreads"];
			$forumname = $val["forumname"];
			$forumdesc = $val["forumdesc"];
			$recentpost = $val["recentpost"];
			if (intval($recentpost)==0) { $recentpost=""; } else {
				$recentpost = date("m/d/Y",$recentpost)."<BR>".date("h:i:s A",$recentpost);
			}
			if ($row=="forum_row1") { $row="forum_row2"; } else { $row="forum_row1"; }
			$html .= "<tr><td class=\"$row\" valign=\"top\"><a href=\"".modurl("forum/event=list/fid=$fid")."\">$forumname</a><BR>$forumdesc<BR><BR></td><td class=\"$row\" valign=\"top\">$threads</td><td class=\"$row\" valign=\"top\">$posts</td><td class=\"$row\" valign=\"top\">$recentpost</td></tr>\n";
		}
		return $html;
		$this->forumlist = $html;
		reset($this->forumList);
	}


}

?>
