<?

$dsn = array();

/*
Sample values for the database driver
$dsn['default'] = array(
        'driver'=>'mysql',
        'host'=>'localhost',
        'user'=>'campus',
        'password'=>'campus',
        'database'=>'campus',
        'persistent'=>'n');
*/

//CHANGE THESE SETTINGS TO MATCH YOUR DATABASE SETUP
$dsn['default'] = array(
        'driver'=>'@db.driver@',
        'host'=>'@db.host@',
        'user'=>'@db.user@',
        'password'=>'@db.password@',
        'database'=>'@db.database@',
        'persistent'=>'n');

//If you change the default directory layout after unzipping, 
//  change $relpath, on line 40 of this file.
//
//Example, you can place the "logicreate" folder under your Document root
//  by setting $relpath to "./logicreate/" instead of "../logicreate/";

/*
 * Define base constants
 * DOCUMENT_ROOT	= server's DOCUMENT_ROOT variable
 * BASE_URL 		= standard URL for web browser
 * APP_URL		= base app URL - the main engine - this file!
 * LIB_PATH		= path to common data objects
 * DEFAULT_URL		= if 'no service' in URL, redirect to this URL
 * PICS_URL		= main directory for graphics - use in templates if needed
 */

define('LOGICAMPUS_VERSION','@version.number@');
define('LOGICAMPUS_VERSION_STATUS','@version.extra@');
define('LOGICAMPUS_BUILD_DATE','@build.date@');
define('SITE_NAME','logicampus');
define('SITE_DISPLAY_NAME','LogiCampus');

//	http://www.foo.com/~user/home/
//	        ^----base      ^------tail

$relpath='../logicreate/';
if (! file_exists($relpath)) {
	$relpath='./logicreate/';
	if (! file_exists($relpath)) {
		$relpath='../../logicreate/';
		if (! file_exists($relpath)) {
			die("Cannot find logicreate directory.");
		}
	}
}

extract($_SERVER);
$PHPSESSID = @$_COOKIE['PHPSESSID'];

$base = $_SERVER['HTTP_HOST'];
$script = substr($SCRIPT_FILENAME,strrpos($SCRIPT_FILENAME,'/')+1); 
$tail = str_replace($script,'',$SCRIPT_NAME);
$tail = str_replace('herc/','',$tail);
$doc = str_replace($script,'',$SCRIPT_FILENAME);
//$doc = str_replace('herc/','',$doc);


define('DOCUMENT_ROOT',$doc);
define('LIB_PATH',DOCUMENT_ROOT.$relpath.'lib/');
define('LANG_PATH',DOCUMENT_ROOT.$relpath.'lang/');
define('SERVICE_PATH',DOCUMENT_ROOT.$relpath.'services/');
define('BASE_URL','http://'.$base.$tail);
define('SECURE_BASE_URL','https://'.$base.$tail);

define('APP_URL',BASE_URL.'index.php/');
define('SECURE_APP_URL',SECURE_BASE_URL.'index.php/');

define('DEFAULT_SERVICE','welcome');
define('DEFAULT_URL',APP_URL.DEFAULT_SERVICE);
define('UNAUTHORIZED_SERVICE','welcome/login');
define('COOKIE_HOST',$_SERVER['HTTP_HOST']);

//Templates, images, html content
DEFINE('TEMPLATE_PATH_PARTIAL',DOCUMENT_ROOT.'templates/');
if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS']=='on') {
	DEFINE('IMAGES_URL',SECURE_BASE_URL.'images/');
	DEFINE('PICS_URL',SECURE_BASE_URL.'templates/');
	DEFINE('IMAGES_PATH',DOCUMENT_ROOT.'images/');
	DEFINE('TEMPLATE_URL_PARTIAL',SECURE_BASE_URL.'templates/');
} else {
	DEFINE('IMAGES_URL',BASE_URL.'images/');
	DEFINE('PICS_URL',BASE_URL.'templates/');
	DEFINE('IMAGES_PATH',DOCUMENT_ROOT.'images/');
	DEFINE('TEMPLATE_URL_PARTIAL',BASE_URL.'templates/');
}

define('CONTENT_PATH',DOCUMENT_ROOT.$relpath.'content/');
define('HTML_PATH',DOCUMENT_ROOT.'lchtml/');	//legacy
define('CACHE_PATH',DOCUMENT_ROOT.$relpath.'cache/');
define('WEBMASTER_EMAIL','Email@address.com');
define('LOG_USAGE_DB',true);
define('LOG_EXECUTION_TIME',true);
define('LOG_OUTPUT',false );

// Defines for Hercules Admin system
define('_SERVICE_PATH',DOCUMENT_ROOT.'/');
define('_BASE_URL','http://'.$base.$tail.'herc/');
define('_SECURE_BASE_URL','https://'.$base.$tail.'herc/');

define('INSTALLED_SERVICE_PATH',DOCUMENT_ROOT.$relpath.'services/');
define('_APP_URL',_BASE_URL.'main.php/');
define('_SECURE_APP_URL',_SECURE_BASE_URL.'main.php/');
define('_DEFAULT_URL',_APP_URL);
define('_PICS_URL',_BASE_URL.'templates/images/');
define('DEBUG',true);


#logusagedb_define(LOG_USAGE_DB,<!--logusagedb-->);
#logexecutiontime_define(LOG_EXECUTION_TIME,<!--logexecutiontime-->);
#logoutput_define(LOG_OUTPUT,<!--logoutput-->);

# The following defines are specific to the lcUser's table.
# These are used to key off of which user type we have so
# we can load the appropiate user object for that user when
# they log into the system.

define('USERTYPE_STANDARD', 1);
define('USERTYPE_STUDENT', 2);
define('USERTYPE_FACULTY', 3);
define('USERTYPE_ADMIN', 4);
define('UPDATE_MAILSERVER_DB', false);
?>
