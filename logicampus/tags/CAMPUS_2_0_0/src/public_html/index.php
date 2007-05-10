<?
//
// +----------------------------------------------------------------------+
// | LogiCreate Application Server sversion 2.9.1                         |
// | Copyright (c)  2002 tapinternet.com	                              |
// +----------------------------------------------------------------------+
// |	                                                                  |
// +----------------------------------------------------------------------+
// | Authors: Mark Kimsal      		                                      |
// |          Michael Kimsal                                              |
// |          Keith Elder                                                 |
// |          Ryan Sexton                                                 |
// +----------------------------------------------------------------------+
//
//xdebug_start_profiling();


//hack to get some java plugins from requesting classes outside the class path
//  known bug in jres since 2000
if (@strstr($_SERVER['PATH_INFO'],'javax') ) {header("HTTP/1.0 404 File Not Found"); exit();}
ob_start();

		/*
		 * if you're going to time things,
		 * start the timer as the first step
		 */

function get_microtime()
{	$tmp = split(' ', microtime());
	$ret = $tmp[0]+$tmp[1];
return $ret;
}
$execution_time=get_microtime();

	$start = microtime();
	srand ((double) microtime() * 1000000);

	if (!@include('defines.php')) {
		include('install.php');
		exit();
	}
	if (!@include('settings.php')) {
		if (!@include('settings.simple.php')){
			include('install.php');
			exit();
		}
	}

		/*
		 * Start session handling
		 */
	//keep the login as feature in a seperate cookie so that people can logout
	if ( @$_COOKIE['LOGINAS'] != '' ) {
		$PHPSESSID= $_COOKIE['LOGINAS'];
	}
	if ( $PHPSESSID=="" )  {		//if no cookie was passed, set a new one
		$hadCookie = false;
		$PHPSESSID=md5 (uniqid (rand()));
		setcookie("PHPSESSID",$PHPSESSID,0,$tail);
	} else { 
		$hadCookie = true;
	}


		//
		//Include main files
		// create system object
		//

@include_once(LIB_PATH."LC_include.php");
@include_once(LIB_PATH."lc_settings.php");
@include_once(LIB_PATH."LC_user.php");
@include_once(LIB_PATH."pellet.php");
@include_once(LIB_PATH."LC_db.php");
@include_once(LIB_PATH."LC_registry.php");
@include_once(LIB_PATH."pbdo_sql.php");
@include_once(LIB_PATH."LC_html.php");
@include_once(LIB_PATH."inputValidation.php");


	//start the error system
	$lcObj = new lcSystem();

	//first time
	if (file_exists('first_time.php') ) {
		include('first_time.php');
	}

// ************* I18N ******************************
//if get vars, switchlocale, then set a cookie
if ( strlen(@$_GET['switchlocale']) == 5 || strlen(@$_GET['switchlocale']) == 3) {
	$_COOKIE['locale'] = $_GET['switchlocale'];
	setcookie('locale',$_GET['switchlocale'],0);
}
//determind language choice from cookie
if ( strlen(@$_COOKIE['locale']) == 5 || strlen(@$_COOKIE['locale']) == 3) {
	define('LOCALE', $_COOKIE['locale']);
} else {
	define('LOCALE', 'en_US');
}

if (!@include_once(LANG_PATH."lct.".LOCALE.".php") ) {
	include_once(LANG_PATH."fallback.php");
}
// ************* I18N ******************************



$lcTemplate = array('cssFile'=>'site.css');
define('HERC',false);

		//
		//Authenticate the URL
		//and make PATH_INFO into variables
		//for others to use via the lcObj
		//

if ($QUERY_STRING!="") {
	$QUERY_STRING = ereg_replace("&","/",$QUERY_STRING);
	$PATH_INFO .= "/$QUERY_STRING";
}


		/*
		 * Parse the url to find out module information
		 * possible URL configurations:	
		 * 	index.php/foo		=> 	module=foo, service=main
		 *	index.php/foo/main	=>	module=foo, service=main
		 *	index.php/foo/bar	=>	module=foo, service=bar
		 *	index.php/foo/bar/lunix	=>	module=foo, service=bar, getvars[0]=lunix
		 */
	$url = $_SERVER['PATH_INFO'];
	if (!$url) { $url = $HTTP_SERVER_VARS['PATH_INFO']; }
	$name = explode("/",$url);
	/*
	 * move to default service if none is specified
	 */
	if (($url=="") || ($name[1]=="") || ($url=="/") ) {
		//add close page functionality for tracking/logging
		header("Location: ".DEFAULT_URL); 
		exit();
	}

	$registry = lcRegistry::load($name[1]);

	$moduleName = $name[1];
	$serviceName = $name[2];
	$className = $serviceName;

	if ($className == "main") { $className = $name[1]; }
	if ($serviceName == "") { $serviceName = "main"; $className = $moduleName;}
	$gdb->query("select * from lcRegistry where moduleName ='$moduleName'",false);
	$gdb->next_record();
	$module = $gdb->Record;

		/*
		 * parse the get string
		 * if we find /foo=bar/ then set
		 * getvars[foo] = bar
		 * x=3 for no random cache-buster, 
		 * x=4 if you want a random string in each URL
		 */

$lcObj->getvars = $HTTP_GET_VARS;
$lcObj->moduleName = $moduleName;
$lcObj->serviceName = $serviceName;


$x=3;
while ($x<=sizeof($name)) {
	$key="";
	$tempval = trim($name[$x-1]);
	if (ereg("=",$tempval)) {
		list($key,$val) = explode("=",$tempval);
	} else {
		$val = $tempval;
	}
	$val = urldecode($val);
	$lcObj->getvars[] = $val;
	if ($key!="") { $lcObj->getvars[$key] = $val; }
	if (substr($name[$x-2],0,3)=="rd=") {
		$lcObj->redir = substr($name[$x-1],3);
	}
	$x++;
}


		/*
		 * Include the actual service
		 * /main.php/disp
		 * 'module' is 'disp'
		 * 'service' is 'main'
		 * so we pull in disp/main.lcp from services/disp/
		 */
if ( !include (SERVICE_PATH.$moduleName."/$serviceName.lcp") ) {
	if (!file_exists(SERVICE_PATH.$moduleName."/$serviceName.lcp") ) {
		$lcTemplate[message] = "The service <i>$serviceName</i> does not exist.";
	} else {
		$lcTemplate[message] = "The service <i>$serviceName</i> cannot be run.  It might contain errors.";
	}
	$service = new Service();
//	lcSystem::systemPreTemplate($lcObj,$lcTemplate);
	$service->errorMessage($lcObj,$lcTemplate);
	closepage();
}

		/*
		 * Create the user object
		 */

$lcUser = lcUser::getUserBySesskey($PHPSESSID);
$lcUser->_sessionKey = $PHPSESSID;


# Added for shopping cart to track where orders
# are coming from.  Also has other uses as well
# as a standars LC session variable.
if ($lcUser->sessionvars['_CAMEFROM']=='') { 
	$lcUser->sessionvars['_CAMEFROM'] = $_SERVER['HTTP_REFERER'];
}


	$lcUser->loadPerms($moduleName);
	$service = new $className();
	$authHandle = $service->authorizer;
	if ($authHandle == '' || $authHandle == 'native') {
		$authHandle = '$authResponse = $service->authorize($lcObj,$lcUser);';
	} else {
		$authHandle = '$authResponse = '.$authHandle.'($lcObj,$lcUser);';
	}

	eval($authHandle);

	if (! $authResponse ) 
	{   // default access denied message
	    $lcTemplate['message'] = 'You do not have permission to view this document.
	    You may need to <a href="'.APP_URL.'login/">register</a> on this site to
	    gain access.
	    If you feel you have gotten this page in error, contact the site
	    administrator.';
	        
	    // checking to see if we should use system default or user editable message
	    if (file_exists(CONTENT_PATH.'err_access_denied.html'))
	    {   # I use ob_end and start to maintain backwards compatability of old php v.
		ob_end_flush();
		ob_start();
		@include(CONTENT_PATH.'err_access_denied.html');
		$lcTemplate['message'] = ob_get_contents();
		ob_end_clean();
		ob_start();
	    }

		lcSystem::systemPreTemplate($lcObj,$lcTemplate);
		$service->errorMessage($lcObj,$lcTemplate);
		closepage();
	}


/*
 * template stuff
 */
$lcObj->module_root = SERVICE_PATH."$moduleName/";
$lcObj->templateName = $serviceName;

$service->serviceName = $serviceName;
$service->className = $className;

$service->module = $moduleName;
$service->templateName = $serviceName;

DEFINE(MOD_URL,APP_URL.$moduleName."/");
DEFINE(SECURE_MOD_URL,SECURE_APP_URL.$moduleName."/");
DEFINE(MOD_PATH,SERVICE_PATH.$moduleName."/");



	/*
	 * get configuration for this module
	 */

	while ( list($k,$v) = @each($registry->config) ) {
		$service->{$k} = $v;
	}

		/*
		 * If we have an 'event' posted
		 * assume the event is a function in the 
		 * service we included
		 * and execute it (eval)
		 * event = blah 
		 * $service->blahRun($params)
		 */

	$event = $lcObj->postvars["event"];
	if ($event =="") {
		$event = $lcObj->getvars["event"];
	}

$service->event = $event;
if($event != '' ) {
	$lcObj->templateName .= '_'.$event;
}

	if ($event == "") {
		$_db = DB::getHandle();
		$service->run($_db,$lcUser,$lcObj,$lcTemplate);
	} else {
		if (method_exists($service,$event."Run")) {
			
			$event_full = $event. 'Run';
			$_db = DB::getHandle();
			$service->$event_full($_db,$lcUser,$lcObj,$lcTemplate);
			
		} else { 
			$lcTemplate[message] = "The function <i>$event</i> does not exist.";
			lcSystem::systemPreTemplate($lcObj,$lcTemplate);
			$service->errorMessage($lcObj, $lcTemplate);
			closepage();
		}
	}
	

		/*
		 * Call the template function of the main
		 * service class.  Can be overridden for 
		 * custom templates per service, or replaced 
		 * in 'service.php' with a different template 
		 * system.
		 *
		 * Need to create the TEMPLATE_URL constant here
		 *
		 */

$handler = $service->presentor;
// go inside the class if the keyword is 'native'
if ($handler == 'native') { $handler = 'presentation'; }
	// debugging
if  ( ($handler == '' ) || ($handler == 'debug') ) {
	$lcObj->templateStyle = 'debug';
	lcSystem::systemPreTemplate($lcObj,$lcTemplate);
	debugPresentation($lcObj,$lcTemplate);
} else {
	// templatize
                //call the system pretemplate function
                lcSystem::systemPreTemplate($lcObj,$lcTemplate);

                //call the module pretemplate function
                $service->preTemplate($lcObj,$lcTemplate);

                // templatize
                if ( method_exists($service,$handler) ) {
                        $service->$handler($lcObj,$lcTemplate);
                } else {
                        $handler($lcObj,$lcTemplate);
                }
}


//xdebug_dump_function_profile(5);
//xdebug_stop_profiling();
closepage();

?>
