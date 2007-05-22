<?
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

//
// +----------------------------------------------------------------------+
// | PHPellet server 	beta version					  |
// +----------------------------------------------------------------------+
// | Copyright (c)  2001 tapinternet.com	                          |
// +----------------------------------------------------------------------+
// |                                                                      |
// +----------------------------------------------------------------------+
// | Authors: Michael Kimsal                                              |
// |          Mark Kimsal                                                 |
// +----------------------------------------------------------------------+
//
// ob_start("ob_gzhandler");


//$debugmode="y";


		/*
		 * if you're going to time things,
		 * start the timer as the first step
		 */

	$start = microtime();
	srand ((double) microtime() * 1000000);



//	$cookiehost = "web.tapinternet.com";
extract($_SERVER);
$PHPSESSID = $_COOKIE['PHPSESSID'];
$cookiehost = $HTTP_HOST;


/*
 * Define base constants
 * DOCUMENT_ROOT	= server's DOCUMENT_ROOT variable
 * BASE_URL 		= standard URL for web browser
 * APP_URL		= base app URL - the main engine - this file!
 * LIB_PATH		= path to common data objects
 * DEFAULT_URL		= if 'no service' in URL, redirect to this URL
 * PICS_URL		= main directory for graphics - use in templates if needed
 */



//all herc defines now start with _
include("../defines.php");
include("./auth.php");





	//
	//Include main files
	// create system object
	//

include_once(LIB_PATH."LC_include.php");
include_once(LIB_PATH."pellet.php");
include_once(LIB_PATH."LC_db.php");
include_once(LIB_PATH."LC_user.php");
include_once(LIB_PATH."LC_html.php");
include_once(LIB_PATH."lc_settings.php");

$lcObj = new lcSystem();




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


	$url = explode("/",$PATH_INFO);
//	print_r($url);exit();


	if ($url[1] == "adm") {
	        $gdb->query("select * from lcRegistry where mid = '$url[2]'");
		$gdb->next_record();	
		$lcObj->moduleName = $gdb->Record['moduleName'];
		$serviceName = $url[3];
		$className = $url[3];

		if($serviceName == "") { $lcObj->serviceName = "main"; $className = "main"; }
		else { $lcObj->serviceName = $serviceName;}
	        $lcObj->templateName = $lcObj->serviceName;


	        DEFINE(MOD_PATH,INSTALLED_SERVICE_PATH.$lcObj->moduleName."/");
	        DEFINE(MOD_URL,_APP_URL."adm/".$url[2]."/");
		DEFINE(MOD_URL_SECURE, _SECURE_APP_URL. "adm/".$url[2]."/");
		if ($className == "main" ) {$className = $lcObj->moduleName; }
	} else {
                $serviceName = $url[1];
                $className = $serviceName;
	        DEFINE(MOD_PATH,INSTALLED_SERVICE_PATH.$lcObj->moduleName."/");
	        DEFINE(MOD_URL,_APP_URL.$className);
	        $lcObj->templateName = $serviceName;
	}
        $lcObj->mid = $url[2];







		/*
		 * parse the get string
		 * if we find /foo=bar/ then set
		 * getvars[foo] = bar
		 */
$x=2;
while ($x<=sizeof($url)) {
	$key="";
	$tempval = trim($url[$x-1]);
	if (ereg("=",$tempval)) {
		list($key,$val) = explode("=",$tempval);
	} else {
		$val = $tempval;
	}
	$val = urldecode($val);
	$lcObj->getvars[] = $val;
	if ($key!="") { $lcObj->getvars[$key] = $val; }
	if (substr($url[$x-2],0,3)=="rd=") {
		$lcObj->redir = substr($url[$x-1],3);
	}
	$x++;
}








	/*
	 * move to default service if none is specified
	 */

if (($url=="") || ($url[1]=="") || ($url=="/") ) {
	//add close page functionality for tracking/logging
	header("Location: "._DEFAULT_URL);
	exit();
}







		/*
		 * Start session handling
		 */

if ( $PHPSESSID=="deleted" )  {
	$PHPSESSID=md5 (uniqid (rand()));
        if (stristr($HTTP_HOST, "$cookiehost")) {
		setcookie("PHPSESSID",$PHPSESSID,time()+36000,"/","$cookiehost");
        }
        else {
		setcookie("PHPSESSID",$PHPSESSID,time()+36000,"/","");
        }
}
session_start();


		/*
		 * Create the user object
		 */

$lcUser = lcUser::getUserBySesskey($PHPSESSID);
$lcUser->_sessionKey = $PHPSESSID;




		/*
		 * Include the actual service
		 * /main.php/disp
		 * 'module' is 'disp'
		 * 'service' is 'main'
		 * so we pull in disp/main.lcp from services/disp/
		 */

if ( ! @include (MOD_PATH."admin/".$lcObj->serviceName.".lcp") ) {
	if ( ! @include (_SERVICE_PATH.$serviceName.".php") ) {
		$lcObj->templateName = "noadmin";
		configurePresentation($lcObj,$lcTempalte);
		exit();
        }
}

	$service = new $className();

	if (!$service->authenticate($lcUser,$lcObj) ) {
		HTTPAuthPresentation($lcObj,$lcTemplate);
		exit();
	}

	/*
	 * get configuration for this module
	 * if you are configuring an installed module
	 */

	if ($url[1] == 'adm' ) {
		$gdb->query("select k,v from lcConfig where mid = '".$url[2]."'");
		while ($gdb->nextRecord()  ){
			$service->{$gdb->record['k']} = $gdb->record['v'];
		}
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
	if ($event == "") {
		$service->run($gdb,$lcUser,$lcObj,$lcTemplate);
	} else {
		if (method_exists($service,$event."Run")) {
			$a = "\$service->".$event."Run(\$gdb,\$lcUser,\$lcObj,\$lcTemplate);";
			eval($a);
		} else {
			Service::throwError("The function <i>$event</i> does not exist.");
		}
	}



		/*
		 * Call the template function of the main
		 * service class.  Can be overridden for
		 * custom templates per service, or replaced
		 * in 'service.php' with a different template
		 * system.
		 */

$handler = $service->presentor;
	// debugging
if ($handler == "debug") {
	print "DEBUGGING<br>\n<pre>\n";
	print_r ($lcObj);
	print "\n\n";
	print_r ($lcTemplate);
	print "\n\n";
	print_r ($lcUser);
print "</pre>\n";
} else {
	// templatize
	if ($handler != "") {
	
                //call the system pretemplate function
                //systemPreTemplate($lcObj,$lcTemplate);

                //call the module pretemplate function
                $service->preTemplate($lcObj,$lcTemplate);

                // templatize
                if ( method_exists($service,$handler) ) {
                        $service->$handler($lcObj,$lcTemplate);
                } else {
                        $handler($lcObj,$lcTemplate);
                }
	}
}


		/*
		 * Call closepage()
		 * wrap up database connections and sessions
		 * and any last-minute detail stuff.
		 */

	closepage();


?>
