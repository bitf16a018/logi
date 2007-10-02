<?
include_once(SERVICE_PATH.'menu/menuObj.php');

////////////////////////////////////////////////////
//
// generic Classes
//
////////////////////////////////////////////////////
/**
* Create a WHERE clause for SQL for group checking
*
* Pass in the user group and a group name - this will 
* return a WHERE clause suitable for doing checks
* of group permissions 
*
* @param array $usergroup The user's group array
* @param string $gname The name of the group to check (groups or notgroups)
* @return string SQL WHERE clause
*
*/
	function createGroupCheck($usergroup,$gname='groups') {
		$group = '';
		if (is_array($usergroup)) {
			while(list($key,$val) = each($usergroup)) {
			if (trim($val)!="") { 
				if ($group) { $group .= " or "; }
				$group .= "$gname like '%|$val|%'";
			}
			}
		} else {
			//$group = " $gname like '%|".$usergroup."|%'";
			$group = " 0 ";
		}
		if ($group=="") { $group=" 1=0 "; } 
		return '('.$group.')';
	}


	// Campus addresses. Pass me a campus location abbreviation and I'll give you
	// the address
	function addressByLocation( $abbr, $nl2br=true ) {

		switch ( $abbr ) {
			case 'S':
				$addr = "South Campus\n5301 Campus Drive\nFort Worth, Texas 76119";
				break;
			case 'NE':
				$addr = "Northeast Campus\n828 Harwood Road\nHurst, Texas 76054";
				break;
			case 'SE':
				$addr = "Southeast Campus\n2100 Southeast Parkway\nArlington, Texas 76018";
				break;
			case 'NW':
				$addr = "Northwest Campus\n4801 Marine Creek Parkway\nFort Worth, Texas 76179";
				break;
			default:
				$addr = '';
		}

		if ( $nl2br ) return nl2br($addr);
			else return $addr;

 		/* Then there is this last one that isn't being used (yet)

			May Owen Center
			1500 Houston Street
			Fort Worth, Texas 76102
		*/

	}

	function updateSessionVars(&$db, &$u) {
		include_once(LIB_PATH.'lc_class.php');

		$db->queryOne("SELECT semesters.id_semesters FROM semesters INNER JOIN classes ON semesters.id_semesters=classes.id_semesters WHERE facultyId='". $u->username ."'");
		if($db->Record['id_semesters']==null)
			$u->sessionvars['classmgr']['currentsemester'] = 0;
		else
			$u->sessionvars['classmgr']['currentsemester'] = $db->Record['id_semesters'];

		if ($id_semesters > 0 ) {
			$semesterObj = semesterObj::_getFromDB($id_semesters, 'id_semesters');
		}
		
		include_once(INSTALLED_SERVICE_PATH."menu/menuObj.php");
		
		$u->classesTaken = classObj::getClassesTaken($u->username);
		$u->classesTaught = classObj::getClassesTaught($u->username);

		switch($u->userType) {
			case USERTYPE_STUDENT: 
				$u->classesTaken = classObj::getClassesTaken($u->username);
				$u->sessionvars['myClassesMenu'] = menuObj::getStudentMenu($u);
				break;
			case USERTYPE_FACULTY:
				$u->classesTaught = classObj::getClassesTaught($u->username);
				$u->classesTaken = classObj::getClassesTaken($u->username);
				$u->classesTaken = array_merge($u->classesTaken, classObj::getClassesTaught($u->username));
				
				$u->sessionvars['myClassesMenu'] = menuObj::getStudentMenu($u);
				break;
			case USERTYPE_STANDARD: 
				$u->classesTaught = array();
				$u->classesTaken = array();
				$u->classesTaken = array();
				$u->sessionvars = array();
				break;

		}
	}

	
/**
 * cache class
 *
 * Currently file-based cache system for 
 * arbitrary data to be stored for later retrieval
 * stored based on ID string, and TTL per data piece 
 * supported
*/


class cache {
// playing with new methods
	function getStatic($id) { 
		$j = new cache();
		$j->getFromCache($id);
		return $j;
	}
	function get($id) { 
		$this->getFromCache($id);
		return $this->data;
	}
	function put($id,$data,$ttl=60) { 
		$this->putInCache($id,$data,$ttl);
	}
/**
 * get info from cache based on id
 *
 * pulls cached into basd on the provided id string
 * data will be returned in $this->data
 *
 * @param string $id ID string of the cached info
 * @return bool True or false - did it get back info?  
 */
	function getFromCache($id="") {


		if (rand(0,50) >46) {

		if ($dir = @opendir(CACHE_PATH)) {
		  while($file = readdir($dir)) {

			if (substr($file,0,6)=="cache_") {
				$f = fopen(CACHE_PATH."$file","r");
				$time = fgets($f,500);
				fclose($f);
				if ($time<time()) {
					unlink(CACHE_PATH."$file");
				}
			}

		  }  
		  closedir($dir);
		}

		}


		if (!$id) {
			$id = $this->id;
		}
		$filename = CACHE_PATH."cache_"."$id";
		$f = fopen($filename,"r");
		if (!$f) {
			return false;
		}
		$file = fread($f,filesize($filename));
		fclose($f);
		list($exp,$data) = explode("\n",$file);
		if ($exp<time()) {
			unlink($filename);
			return false;
		}
//		$this->data = gzuncompress(base64_decode($data));	
		$this->data = unserialize(base64_decode($data));	
		return true;
	}


/**
* puts data in cache
*
* caches data based on an ID string 
* and will allow for TTL (time to live) to be set
* 
* @param string $id ID string to reference data
* @param string $data Data to cache for later use
* @param int $ttl Time to live - number of seconds to cache data
* @return true 
*/

	function putInCache($id="",$data="",$ttl="") {
		if (!$id) {
			$id = $this->id;
			$data = $this->data;
			$ttl = $this->ttl;
		}
		$exptime = time() + $ttl;
		$filename = CACHE_PATH."cache_"."$id";
//		$data = base64_encode(gsddcompress($data,9));
		$data = base64_encode(serialize($data));
		$output = "$exptime\n$data";
		$f = fopen($filename,"w");
		fputs($f,$output);
		fclose($f);
		return true;
	}
}




/**
 * lcSsytem
 *
 * Base system class which the standard $lcObj
 * is based on. Object used to pass around 
 * input paramters from main file to specific 
 * modules as well as between modules if necessary
 *
 */

class lcSystem {

	var $postvars;
	var $getvars;
	var $templateStyle = 'sinorca';
	var $TRACK_SESSIONS = true;
	var $cssFile;

	function lcSystem() {
		// doesn't check for magic_quotes_sybase, which may mess things up
		 if (get_magic_quotes_gpc() ) { 
                        $stripquotes = create_function('&$data, $self',
                        'if (is_array($data)) foreach ($data as $k=>$v) $self($data[$k], $self); '.
                        'else $data = stripslashes($data);');
                        $stripquotes($_POST,$stripquotes);
                        $stripquotes($_GET,$stripquotes);
                }

		$this->postvars =      $_POST;
		$this->getvars  =      $_GET;
		$this->uploads  =      $_FILES;

		//__FIXME__ use a constant to turn on and off
		$e =& ErrorStack::_singleton();
		set_error_handler( array( &$e,'_errorHandler') );
		$style = LcSettings::getValue('TEMPLATE_STYLE');
		if ($style != null) {
			$this->templateStyle = $style;
		}
	}

	/**
	 * Called before the system does template processing
	 *
	 * Include things that are common to all templatized pages:
	 * banners, menus, styles, themes, shopping cart...
	 * To setup the shopping cart, uncomment the lines labeled #CART at the end
	 */
	function systemPreTemplate(&$obj,&$t){
		define('TEMPLATE_PATH',TEMPLATE_PATH_PARTIAL.$obj->templateStyle."/");
		define('TEMPLATE_URL',TEMPLATE_URL_PARTIAL.$obj->templateStyle."/");
		define('CSS_FILE',TEMPLATE_URL_PARTIAL.$obj->templateStyle."/".$obj->cssFile);

               #  Shopping cart includes
               #include_once(INSTALLED_SERVICE_PATH."shop/main.lcp"); #CART
               #include_once(INSTALLED_SERVICE_PATH."shop/lcshop.lcp"); #CART
		include_once(INSTALLED_SERVICE_PATH."menu/menuObj.php");
		$obj->user =& lcUser::getCurrentUser();
		$obj->menu = menuObj::getVisibleCached($obj->user->groups);

               # Shopping cart menu
               #shop::getMenu($obj->menu,$t['cart']); #CART
		/*****
		 * Faculty classes taught
		 *****/

		if (!$obj->user->sessionvars['myClassesMenu']) {
			$obj->user->sessionvars['myClassesMenu'] = menuObj::getStudentMenu($obj->user);
		}
		$t['_classesTaken'] = $obj->user->sessionvars['myClassesMenu'];
		$t['_classesTaught'] = menuObj::getFacultyMenu($obj->user);

/*
		if ($obj->user->isFaculty() ) {
		while (list ($k, $v)  = @each($obj->user->classesTaught) )
		{
			if (strlen($v->courseName) >= 20) { $pad = '...'; }
			$t['_classesTaught'] .= '<a class="menuitem"
			href="'.APP_URL.'classmgr/main/event=displayClass/id_classes='.$v->id_classes.'">'.substr($v->courseName, 0, 20).$pad.'</a><br>';
			unset($pad);
		}
		}
		*/

		/*****
		 * Private Messages
		 ****/
		 if (!$obj->user->isAnonymous() )
		 {
		 	$db = DB::getHandle();
			$db->queryOne("select count(pkey) as count from privateMessages where sentReceived=0 and
			messageTo='".$obj->user->username."'",false);
			$t['_privMsgs'] = $db->Record['count'];
			if ( isset($obj->user->sessionvars['_privMsgs']) ) {
				if ( $t['_privMsgs'] > $obj->user->sessionvars['_privMsgs'] ) {
					$t['_newPrivMsgs'] = true;
				}
			}
			$obj->user->sessionvars['_privMsgs'] = $t['_privMsgs'];
		 }

			if (defined('DEBUG') && DEBUG) {
				$e =& ErrorStack::_singleton();
				if ($e->count) { 

				echo <<<END

		<form id="errorbox">
			<div style="position:absolute;top:80px;left:70px;padding:3px;width:40em;background-color:#C0C0C0;border-style:outset">
			<table width="100%" cellpadding="5" cellspacing="0" border="0">
				<tr>
					<td valign="top">
						<font color="red">
<pre>
 **
**** 
**** 
 **
 **

 **
 **
</pre>
						</font>
					</td>
					<td width="80%" valign="top">
						<h3>Error</h3>
						There was a problem executing this program,
						click 'Details' to find out more information.
						This information will be usefull when debugging the program.
					</td>
					<td valign="top">
						<input type="button" value="Close"
						onclick="
document.getElementById('errdetails').style.visibility='hidden';
document.getElementById('errscroll').style.visibility='hidden';
document.getElementById('errscroll').style.height='0px';
document.getElementById('errdetailsbutton').disabled=false;
document.getElementById('errorbox').style.visibility='hidden';"/>
						<p>&nbsp;
						<input type="button" id="errdetailsbutton" value="Details -&gt;"
						onclick="
document.getElementById('errdetails').style.visibility='visible';
document.getElementById('errscroll').style.visibility='visible';
document.getElementById('errscroll').style.height='175px';
this.disabled = true;
						"/>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<div id="errdetails" style="visibility:hidden" align="right">
							<div style="border-style:inset;overflow:auto;height:0px;visibility:hidden" id="errscroll" align="left">


END;
				ErrorStack::dumpStack();
				echo <<<END

							</div>
							<br/>
							<input type="button" value="&lt;- No Details"
							onclick="
document.getElementById('errdetails').style.visibility='hidden';
document.getElementById('errscroll').style.visibility='hidden';
document.getElementById('errscroll').style.height='0px';
document.getElementById('errdetailsbutton').disabled=false;
						"/>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</form>

END;

				$errlog = ErrorStack::logStack();
				//add your own email name here
				//mail('errors@ownerssite.com','ERRORS ON CAMPUS',$errlog);
				unset($errlog);
				}
			} else {
				$e =& ErrorStack::_singleton();
				if ($e->count) { 
				$errlog = ErrorStack::logStack();
				$date = date('m-d-Y');
				$time = time();
				$u = lcUser::getCurrentUser();
				$log = $time.':'.$u->username.':' . base64_encode($errlog);
				$touch = 0;
				system("touch /tmp/lcerrlog/$date.log",$touch);
				if ($touch) {
					system("mkdir /tmp/lcerrlog/");
					system("touch /tmp/lcerrlog/$date.log",$touch);
				}
				system("echo $log >> /tmp/lcerrlog/$date.log");
				}
			}

	}

}



/**
 * function for creating standard URLs
 *
 * Function to create standard URLs from APP_URL
 * Mostly useful if you need to append things AFTER
 * the URL end.  For example, if you needed to 
 * put the session ID at the end of the URL 
 * and you've been calling appurl() it's simply 
 * changing the function instead of the multiple HREF 
 * refernces in the templates/code
 *
* @param string $link The URL to link to
* @param boolean $secure Boolean to use SECURE version of URL (https) 
* @return string URL to link to 
*

 */
function appurl($link,$secure="") {
	if (HERC && $secure) { return _SECURE_APP_URL."$link"; } 
	if (HERC) { return _APP_URL."$link"; }
	if ($secure) { return SECURE_APP_URL."$link"; } else { return APP_URL."$link"; }
}

/**
 * function for creating standard URLs
 *
 * Function to create standard URLs from MOD_URL 
 * Same as appurl() but uses MOD_URL instead
 *
* @param string $link The URL to link to
* @param boolean $secure Boolean to use SECURE version of URL (https) 
* @return string URL to link to 
*

 */
function modurl($link,$secure="") {
	if ($secure) { return SECURE_MOD_URL."$link"; } else { return MOD_URL."$link"; }
}







/**
	* Group class
	*
	* Add/edit/delete groups (collections of users)
        *
	* @author mgkimsal 
	* @date 12/16/2000
	*
	*/


class lcGroup {

	var $groupName;
	var $gid;


	/**
	 * Get an array of groups from the system
	 *
	 * @return 	array 	List of groups
	 */
	function getList($permlist="") {
		$db = DB::getHandle();
		$sql = "select * from lcGroups order by groupName";
		$db->query($sql,false);

		while ($db->next_record()) {
			$tmp[$db->Record['gid']] = $db->Record['groupName'];
		}
		$this->optionList = makeOptions($tmp);
		$this->displayList = $tmp;
	return $tmp;
	}


	function getGroup() {
		$db = DB::getHandle();
		$sql = "select * from lcGroups where gid='".$this->gid."'";
		$db->query($sql,false);
		while($db->next_record()) {
			$this->groupName = $db->Record["groupName"];
		}

	}


	function addGroup() {
		$db = DB::getHandle();
		$sql = "select count(gid) from lcGroups where gid='".$this->gid."' or groupName = '".$this->groupName."'";
		$db->query($sql,false);
		$db->next_record();
		$count = $db->Record[0];
		if (intval($count)>0) {
			return false;
		}
		$sql = "insert into lcGroups (groupName,gid,created) values ('".$this->groupName."','".$this->gid."',".time().")";
		$db->query($sql,false);
		return true;
	}
	function updateGroup() {
		$db = DB::getHandle();
		$sql = "update lcGroups set groupName = '".$this->groupName."' where gid = '".$this->gid."'";
		$db->query($sql,false);
		$this->updatePerms();
		return true;
	}
	function deleteGroup() {
		$db = DB::getHandle();
		$sql = "delete from lcGroups where gid = '".$this->gid."'";
		$db->query($sql,false);
	}

	function getPerms() {
		$db = DB::getHandle();
		$gid = $this->gid;
		if (!is_array($this->grouparray)) {
			$this->grouparray[] = $gid;
		}
		$ga = $this->grouparray;
		while (list($key,$val) = each($ga)) {
			if ($where != "") { $where .= " or "; }
			$where .= "gid='$val'";
		}
		if ($where) {
			$sql = "select DISTINCT A.sid,B.serviceename,A.perm from lcPerms A , lcService B where ($where)";
			$db->query($sql,false);
			while ($db->next_record()) {
				$this->serviceperm[$db->Record[0]] = $db->Record[2];
			}
		}
		if ($gid) { $this->getPerm(); }
	}

	function getPerm() {
		$db = DB::getHandle();
		$gid = $this->gid;

		$a = new lcAction($db);
		$a->getList();
		$alist = $a->displayList;
		$s = new lcService($db);
		$s->getList();
		$x = $s->displayList;

		$html .= "<tr><td>Service name</td>";
		while (list($key,$val) = each($alist)) {
			$html .= "<td>$key</td>";
		}
		$html .= "</tr>\n";
		while (list($sid,$servicename) = each ($x)) {
			$q = $this->serviceperm[$sid];
			$servperm = explode("|",$q);
			$html .= "<tr><td>$servicename</td>";
			reset($alist);
			while (list($key,$val) = each($alist)) {
				if (in_array($key,$servperm)) { $check = " checked"; $on="$key";} else { $check= ""; $on=""; }
				$p[$gid][$sid][$key]=$on;
				$p2[$servicename][$key] = $on;
				$html .= "<td><input type=\"checkbox\" name=\"perm[$gid][$sid][$key]\"$check></td>";
			}
			$html .= "</tr>\n";
		}
		reset($x);
		$this->groupPermsHTML = $html;
		$this->perm = $p;
		$this->perm2 = $p2;

	}

	function updatePerms() {
		$db = DB::getHandle();
		$sql = "delete from lcPerms where gid='".$this->gid."'";
		$db->query($sql,false);
		while (list($g,$s) = each($this->perm)) {
			$temperm;
			while (list($sv,$p) = each($s)) {
				if (is_array($p)) {
					$temperm = implode("|",array_keys($p));
					$sql = "insert into lcPerms (sid,gid,perm) values ('$sv','$g','$temperm')";
					$db->query($sql,false);
				}
			}
		}
	}		

}




////////////////////////////////////////////////////
//
// generic Functions
//
////////////////////////////////////////////////////


/**
 * closepage function
 *
 * Provides shutdown functions for closing stuff on a page
 * calls the lcUser saveSession method now
 * bug reports and session tracking
 */
function closepage($logUsage = true) {
	global $PHPSESSID, $HTTP_REFERER, $REMOTE_ADDR,$lcObj, $start,$execution_time;
	if ($lcUser = lcUser::getCurrentUser()) $lcUser->saveSession();

	$db = DB::getHandle();

	/* 
	if ($lcObj->TRACK_SESSIONS) {
		$sql = 'INSERT INTO lcSessionTrack
			(username,time,sessionKey,lcSystem,screen)
			VALUES
			(\'%s\',UNIX_TIMESTAMP(),\'%s\',\'%s\',\'%s\')';

		$system = base64_encode(serialize($lcObj));

		$screen = ob_get_contents();
		$screen = gzcompress($screen);
		$screen = base64_encode($screen);

		$db->query( sprintf($sql, $lcUser->username, $lcUser->_sessionKey, $system,$screen),false);
	}
	/* */
	if (REPORT_BUGS) {


	}


	if ($logUsage) { 
		include_once(LIB_PATH."LC_usage.php");
		$log = new usagelog();
		if (LOG_EXECUTION_TIME) { 
			$endarray=split(" ",microtime());
			$endtime=$endarray[0]+$endarray[1]; 
			$startarray=split(" ",$start);
			$starttime=$startarray[0]+$startarray[1]; 
			$exectime = $endtime - $starttime;
			$log->exectime = $exectime;
		}
		if (LOG_OUTPUT) {
			$x = addslashes(ob_get_contents());
			$log->output = $x;
		}
		$log->user = $lcUser->username;
		$log->ip = $REMOTE_ADDR;
		$log->moduleName = $lcObj->moduleName;
		$log->serviceName = $lcObj->serviceName;
		$log->refer = $HTTP_REFERER;
		$log->sesskey = $PHPSESSID;
		$log->add();
	}

	
	$db->disconnect();
	// want to shut off execution time display
	if ($execution_time < 0)
	{	echo '<font size="1">EXECTIME: '.number_format((get_microtime()-$execution_time ), 2). ' sec</font>';
	}

// remove later 0 debugging
$d = date("Ymd");
global $PHPSESSID;
//mylog("/tmp/query_$d"."_$PHPSESSID","==========================\nEND PAGE\n=======================");

	exit();
}



////////////////////////////////////////////////////
//
//  end generic functions
//
////////////////////////////////////////////////////


/*
 * session open function
 * 
 * will be deprecated soon- moving into user object
 * changed gc to be a TIMESTAMP. no need to set its value now
 */

function sess_open($db,$sessid) {
	if ($sessid == "") { return; }

	//$db->query("select * from lcSessions where sesskey = '$sessid'");
	//always assume session is open from lc_user::getUserBySessionKey()

	$db->query("insert into lcSessions (sesskey,sessdata) values ('$sessid','')",false);
}



class PersistantObject {


	/**
	 * static
	 */
	function _load($class,$table,$id,$fields="*",$prime="pkey") {
		$obj = null;
		$at = array();
		$db = DB::getHandle();
		$db->query("select $fields from $table where $prime = '$id'");
		$db->RESULT_TYPE = MYSQL_ASSOC;
		if ($db->nextRecord() ) {
			$at = $db->record;
		}
		$db->freeResult();
		$obj = PersistantObject::createFromArray($class,$at);

	return $obj;
	}

	/**
	 * static
	 */
	function _delete($table,$id,$prime="pkey") {
		$db = DB::getHandle();
		$db->query("delete from $table where $prime = '$id'");
	}
		
// we need some way to get back the 
// inserted id - $db->getInsertID() works
// but isn't passed back in the object
// I've put it in _lc_insertedKey and modified 'save' 
// so that it'll skip over _lc_ in addition to anything in 
// getTransient().  There are two functions for 
// objects __sleep and __wake - perhaps those would
// work better than a getTransient() ?

	function _save($table) {
		$db = DB::getHandle();
		$attrs = get_object_vars($this);
		$trans = $this->_getTransient();

		while ( list($k,$v) = @each($attrs) ) {
			if (@ in_array($k, $trans) ) {continue;}
			if (substr($k,0,4) == "_lc_") { continue; }
			if (gettype($v) == "string") {$v = "'".addslashes(stripslashes($v))."'";}
			if (gettype($v) == "object") {$v = "'".serialize($v)."'";}
			if ($v == null) {$v = "''";}
// mgk - 1/1/2002
// if we happen to get a numeric-indexed array, don't save the numbered parts
//
			if (gettype($k)=="string") { 
				$sql .= " $k = $v, ";
			}
		}
		$sql = substr($sql,0,-2);

		$db->query("replace into $table set $sql");
		
		$this->_lc_insertedKey = $db->getInsertID();
		return $this->_lc_insertedKey;
	}



	function _toArray() {

	}


	function _toString() {

	}


	function _getTransient() {
		return array();
	}


	/**
	 * static
	 */

	function createFromArray($class,&$attribs) {
		$z = count($attribs);
		$obj =  new $class();

		while ( list ($k,$v) = @each($attribs) ) {
			$obj->{$k} = $v;
		}

	$x = &$obj;
	return $x;
	}
}

/**
 * auditing class
 *
 * audit::log($action,$userobject);
 *
 * @static
 * @param string $action Action being logged - keep it short, but can be short sentence
 * @param object $user User object - current will just pull username - maybe need other things?  Passed by reference
 * @return boolean Return true
 */

class audit {

	function log($action,$user="") {
		$db = DB::getHandle();
		$action = addslashes(stripslashes($action) );
		global $REMOTE_ADDR;
		$username = $user->username;
		$sql = "insert into lcAudit (username,action,ip,timedate) values ('$username','$action','$REMOTE_ADDR',".DB::getFuncName('NOW()')." )";
		$db->query($sql,false);
		return true;
	}

}

	# Added by keith to help with faster debugging
	function debug($x, $y='')
	{
		echo '<pre>';
		print_r($x);
		echo '</pre>';
		
		if ($y != '')
		{
			exit();
		}
	}

	
	// here, let's put it in this ONE place so it doesn't need to be in 5.
	function object2array($object)
	{
		if (!is_object($object)) return $object;
	
		$ret = array();
	
		$v = get_object_vars($object);

		while (list($prop, $value)= @each($v))
			$ret[$prop] = object2array($value);
	
		return $ret;
	}

	// give me an array('month' => MONTH, 'day' => DAY, 'year' => YEAR), and I'll turn it into
	// a unix timestamp so that you can commit it to the database. this was written for the
	// form manager's datedropdown widget.
	function dateArray2Timestamp($array) {
		return dateArray2TimestampFull($array);
	}

	function dateArray2TimestampFull($array)
	{
		if (($array['ampm'] == 'PM' && $array['hours'] != 12) || ($array['ampm'] == 'AM' && $array['hours'] == 12))
		{	$array['hours'] += 12;
			if ($array['hours'] >= 24)
			{	$array['hours'] = '00';
			}
		}
		return mktime((int)$array['hours'],(int)$array['minutes'],0,$array['month'],$array['day'],$array['year']);

	}

	function dateArray2DBDateTime($array)
	{
		$date = dateArray2TimestampFull($array)	;
		return date('Y-m-d H:i:s', $date);

	}
		
	function dateArray2DBTime($array)
	{
		$array['year'] = date('Y');
		$array['month'] = date('m');
		$date = dateArray2TimestampFull($array)	;
		return date('H:i:s', $date);

	}

/**
 * Store and mete errors of the system.
 *
 * use pullError($context) to find errors.
 * use lcError::throwError() to throw a new error.
 */
class ErrorStack {

	var $stack = array(); 	//pile of errors
	var $count = 0;

	function stack($e) {
		$x =& ErrorStack::_singleton();
//		if ($x->count > 10 ) {  echo "too many errors. ".$x->count; return;}
		$x->stack[] = $e;
		$x->count++;
//		debug($x->stack);
	}

	function count() {
		$x =& ErrorStack::_singleton();
	return $x->count;
	}


	function& _singleton() {
		static $single;
		if (! isset($single) ) {
			$single = new ErrorStack();
		}
		return $single;
	}

	/**
	 * return null or an error of the specified context
	 */
	function pullError($t='error') {
		$ret = false;
		$newstack = array();
		$found = false;
		$s =& ErrorStack::_singleton();
		for ($x= ($s->count-1); $x >= 0; --$x)  {
			if ( ($s->stack[$x]->type == $t) and (!$found)) {
				$ret = $s->stack[$x];
				$found = true;
				$s->count--;
			}
			else {
				$newstack[] = $s->stack[$x];
			}
		}
		$s->stack = $newstack;
	return $ret;
	}



	function _errorHandler ($level, $message, $file, $line, $context='error') {
//		static $count;

		//drop unintialized variables
		if ($level == 8 ) return;
		if ($level == 2 ) return;
		if ($level == 2048 ) return;

		//if ( is_array($context)) $context = 'error';
		$e = new lcError($level,$message,'php',$context);
		$bt = debug_backtrace();
		array_shift($bt);
		$e->addBackTrace($bt);
		ErrorStack::stack($e);
	}


	function dumpStack() {
		$s =& ErrorStack::_singleton();
		for ($z=0; $z <= $s->count; ++$z) {
			//start at 1, skip the backtrace to this function, not necassary
			// sometimes it's not necassary, sometimes it is (MAK)
			$bt = $s->stack[$z]->backtrace;
			print "<h3>".$s->stack[$z]->message ."</h3>\n";
			for ($x=0; $x < count($bt); ++$x ) {
				$indent = "&nbsp;&nbsp;&nbsp;";
				if ( isset($bt[$x]['class']) && strlen($bt[$x]['class']) > 0 ) {
					print $indent."<b>".$bt[$x]['class']."::".$bt[$x]['function']."</b>";
				} else {
					print $indent."<b>".$bt[$x]['function']."</b>";
				}
				print $indent.' '.basename($bt[$x]['file'])." ";
				print "(".$bt[$x]['line'].")<br/>\n";
				print "<br/>\n";
			}
		}
	}


	function logStack() {
		$s =& ErrorStack::_singleton();
		for ($z=0; $z <= $s->count; ++$z) {
			//start at 1, skip the backtrace to this function, not necassary
			// sometimes it's not necassary, sometimes it is (MAK)
			$bt = $s->stack[$z]->backtrace;
			$ret .= $s->stack[$z]->message . "\n";
			for ($x=0; $x < count($bt); ++$x ) {
				$indent = str_repeat("  ",$x);
				if ($bt[$x]['class'] != '' ) {
					$ret .= $indent."method : ".$bt[$x]['class']."::".$bt[$x]['function'];
				} else {
					$ret .= $indent."function : ".$bt[$x]['function'];
				}
				$ret .= "\n";
				$ret .= $bt[$x]['file']." ";
				$ret .= "(".$bt[$x]['line'].")\n";
			}
		}
		return $ret;
	}
}

/**
 * Represent one error of the system or a module
 *
 * An error has a message, priority level, line & file, and a
 * context, or type.  The context can help with organizing errors.
 * For example, you can query the error stack for any error from
 * the context of the database or the forums; contexts are not
 * enforced.
 */
class lcError {
	var $message;
	var $priority;
	var $type;

	function lcError($p=0,$m='',$t='error',$context) {
		if ($m == '' )
			$m = $php_errormsg;

		//forget the context, it's too huge to print_r on and still make sense of the bt
		$this->message = $m;
		$this->priority = $p;
		$this->type = $t;
	}

	function setType ($t) {
		$this->type = $t;
	}

	function getType () {
		return $this->type;
	}


	/**
	 *
	 * wrapper function for directly accessing the error handler
	 * for some reason, directly calling ErrorStack::stack from userspace
	 * doesn't cut it
	 */
	function throwError ($level,$m,$c='error') {
		ErrorStack::_errorHandler($level,$m,'',-1,$c);
	}

	function addBackTrace ($bt) {
		for ($x=count($bt); $x > 6; $x--) {
			array_pop($bt);
		}
		$this->backtrace = $bt;
		/*
		//start at 1, skip the backtrace to this function, not necassary
		for ($x=1; $x < count($bt); ++$x ) {
			print "function : ".$bt[$x]['function'];
			if ($bt[$x]['class'] != '' ) {
				print "     of class: ".$bt[$x]['class']; }
			print "\n";
			print $bt[$x]['file']." ";
			print "(".$bt[$x]['line'].")\n";
			print "\n";
		}
		*/
	}

	// This is used at the top of getForm() if it was passed an object
	// instead of an array as Keith had originally intended.
	function object2array($object)
	{
		if (!is_object($object)) return $object;
	
		$ret = array();
		$v = get_object_vars($object);
	
		while (list($prop, $value)= @each($v))
		{	$ret[$prop] = $this->object2array($value);
		}
	
		return $ret;
		}
}

function mylog($file,$string) {
return;
	$f = fopen($file,"a");
	$d = date("m/d/Y h:i:s A");
	global $PHPSESSID;
	$string = "$d - $PHPSESSID - ".$_SERVER['REMOTE_ADDR']."\n-----\n$string";
	fputs($f,$string."\n==========\n");
	fclose($f);
}


/**
 * Universal Unique ID (UUID or GUID)
 * Taken from http://us2.php.net/manual/en/function.uniqid.php
 * Thanks to all the comment posters, including:
 * maciej dot strzelecki, dholmes, and mimic
 */
function lcUuid() {
	return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			  mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
			  mt_rand( 0, 0x0fff ) | 0x4000,
			  mt_rand( 0, 0x3fff ) | 0x8000,
			  mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ) 
		);
}

function lcMessageBox($errorList, $type='i', $title='') {
	$html = '';
	$errors = '';
	switch ($type) {
		case 'e':
		case 'w':
			$img = 'msg_warn.png';
			$class = 'msg_warn';
			break;
		case 'a':
			$img = 'msg_alert.png';
			$class = 'msg_alert';
			break;
		case 'q':
			$img = 'msg_question.png';
			$class = 'msg_question';
			break;
		case 'i':
		default :
			$img = 'msg_info.png';
			$class = 'msg_info';
			break;
	}
	if (is_array($errorList) ) {
		$errors = '<ul>';
		foreach ($errorList as $e) {
			$errors .= "<li>".$e."</li>\n";
		}
		$errors .= '</ul>';
	} else {
		$errors = $errorList;
	}
	if (strlen($title) ) {
		$title = '<h3>'.$title.'</h3>';
	}
$html .= '<div class="messagebox '.$class.'">
	<table width="100%" cellpadding="0" cellspacing="0"><tr><td width="60">
				<img src="'.IMAGES_URL.$img.'"/>
	</td><td>
		'.$title.'
		'.$errors.'
	</td></tr></table>
</div>
';
return $html;
}
?>
