<?
define('IMAGES_URL',"./images/");
define('TEMPLATE_URL',"./templates/default");
define('REQ_PHP_VERSION','4.3.1');
define('SQL_PATH','../logicreate/data/');

$t['cssFile'] = "blue.css";

$m[1] = "1. Permission checking";
$m[2] = "2. License";
$m[3] = "3. Requirement checking";
$m[4] = "4. Site Information";
$m[5] = "5. Modules";
$m[6] = "6. Finished";

# Check defines file, make sure it hasn't been setup before
if ( filesize('defines.php') > 500) 
{
	displaySorry(1);
	displayFooter();
	exit();
}

# make sure file exists
if ( ! file_exists('defines.php'))
{
	displaySorry(2);
	displayFooter();
	exit();
}

# make sure web server can write to the file
if ( ! is_writeable('.') || ! is_writeable('defines.php') ) {
	    displaySorry(3);
	displayFooter();
	    exit();
}



// do some static setting up of the DB
$dsn['default'] = array(
        'driver'=>$_POST['driver'],
        'host'=>$_POST['dbserver'],
        'user'=>$_POST['dbuser'],
        'password'=>$_POST['dbpasswd'],
        'database'=>$_POST['dbname'],
        'persistent'=>'y');



DB::getDSN($dsn);


//closely follows flow chart
$arg = array();
switch($_POST['event']) {

	case 'processTwo':
		displayStepTwo($arg);
		break;

	case 'processThree':
		displayStepThree($arg);
		break;

	case 'processFour':
		displayStepFour($arg);
		break;

	case 'initialCheck':
        if (initialCheck($arg) ) {
            findModules($arg);
            displayStepFive($arg);
        } else {
            if ($e = ErrorStack::pullError('db') ) {
                $arg['error'] = 'Either the database username, password, or both
 are incorrect. Check your settings and make sure your database server
 is running.';
                $arg['dbpasswd'] = '';
                displayStepFour($arg);
            } else {
                $arg['error'] = 'You need to fill out all fields';
                displayStepFour($arg);
            }
        }

		initialCheck($arg);
		break;

	case 'processFive':
		displayStepFive($arg);
		initialCheck($arg);

		break;
	
	case 'processSix':
		displayHeader(6);
		if (!writeDefines($arg) ) {
			$arg['error'] = 'No write permission to the current directory.';
			displayEnd($arg);
			exit();
		}

		include('defines.php');
		echo '<h2>Setup Information</h2>';
		$arg['default'] = trim($_POST['default']);
		echo '<ol>';
		echo '<li>Finding modules</li>';
		findModules($arg);
		echo '<li>Finished finding modules</li>';
		echo '<li>Now running setup</li>';

		runSetup($arg);
					
		echo '<li>Setup finished</li>';

		include_once('defines.php');
		while ($e = ErrorStack::pullError() ) {
			$art['error'] .= $e->message ."<br />\n";
		}
		if (!$arg['error']) 
		{
			$arg['error'] .= 'It looks like everything was installed normally.';

			displayFinalInstructions();
		}
		displayFooter();


		break;

	default:
		displayLicense();
		break;

	case "processZero":
		$tpl = array('dbserver'=>'localhost',
			     'dbname'=>'logicampus',
			     'dbuser'=>'user',
			     'dbpasswd'=>'passwd');
		displayStepOne($tpl);
		break;

}





//******
//events
//******

function initialCheck (&$arg) {
	$fields = array (	"dbserver",
				"dbname",
				"dbuser",
				"dbpasswd",
				"driver",
				"sitename",
				"masteremail",
				"studentemail");

	while ( list($k,$v) = @each($fields) ) {
		if ( trim($_POST[$v]) != '' || $v == 'dbpasswd') 
			$arg[$v] = trim($_POST[$v]);
		else
			$err = 1;
	}

	if ($err)  
		return false;

	$db = DB::getHandle();
	if (!$db->connect()) {
		lcError::throwError(6,'Bad Password',__FILE__,__LINE__,'db');
		return false;
	}
	// this field is not required
	$arg['dbcreate'] = $_POST['dbcreate'];
	$arg['sampledata'] = $_POST['sampledata'];

return true;
}



function findModules (&$arg) {
	//all fields are good, let's find the services
	$dir = @dir('../logicreate/services');

	if ( ! $dir->handle ) { $arg[error] = 'Couldn\'t find module directory, tried ../logicreate/services.<br>
		This setup tool only works with a standard directory layout.<br>  If you require a speicalized layout
		you will need to do a manual setup.';
			return false;
	}

	while ($entry = $dir->read() ) {
		if ($entry == '.' or $entry == '..' or $entry=="CVS") continue;
		if ( file_exists('../logicreate/services/'.$entry.'/META-INFO/setup.sql') ) {
			$s[$entry] = 1;
		} else {
			$s[$entry] = 0;
		}
	}
	$arg['modules'] = $s;
	ksort($arg['modules']);

return true;
}



function writeDefines(&$arg) {
$arg = $_POST;
$defines = "<?

/*
 * Define base constants
 * DOCUMENT_ROOT	= server's DOCUMENT_ROOT variable
 * BASE_URL 		= standard URL for web browser
 * APP_URL		= base app URL - the main engine - this file!
 * LIB_PATH		= path to common data objects
 * DEFAULT_URL		= if 'no service' in URL, redirect to this URL
 * PICS_URL		= main directory for graphics - use in templates if needed
 */

define('LOGICAMPUS_VERSION','1.0.3');
define('LOGICAMPUS_VERSION_STATUS','gamma');
define('SITE_NAME','logicampus');
define('SITE_DISPLAY_NAME','LogiCampus');


//	http://www.foo.com/~user/home/
//	        ^----base      ^------tail

\$relpath='../logicreate/';
extract(\$_SERVER);
\$PHPSESSID = \$_COOKIE['PHPSESSID'];

\$base = \$HTTP_HOST;
\$script = substr(\$SCRIPT_FILENAME,strrpos(\$SCRIPT_FILENAME,'/')+1); 
\$tail = str_replace(\$script,'',\$SCRIPT_NAME);
\$tail = str_replace('herc/','',\$tail);
\$doc = str_replace(\$script,'',\$SCRIPT_FILENAME);
\$doc = str_replace('herc/','',\$doc);


define('DOCUMENT_ROOT',\$doc);
define('LIB_PATH',DOCUMENT_ROOT.\$relpath.'lib/');
define('LANG_PATH',DOCUMENT_ROOT.\$relpath.'lang/');
define('SERVICE_PATH',DOCUMENT_ROOT.\$relpath.'services/');
define('BASE_URL','http://'.\$base.\$tail);
define('SECURE_BASE_URL','https://'.\$base.\$tail);

define('APP_URL',BASE_URL.'index.php/');
define('SECURE_APP_URL',SECURE_BASE_URL.'index.php/');

define('DEFAULT_SERVICE','$arg[default]');
define('DEFAULT_URL',APP_URL.DEFAULT_SERVICE);
define('UNAUTHORIZED_SERVICE','welcome/login');
define('COOKIE_HOST',\$HTTP_HOST);

//Templates, images, html content
DEFINE('TEMPLATE_PATH_PARTIAL',DOCUMENT_ROOT.'templates/');
if (\$HTTPS=='on') {
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

define('CONTENT_PATH',DOCUMENT_ROOT.\$relpath.'content/');
define('HTML_PATH',DOCUMENT_ROOT.'lchtml/');	//legacy
define('CACHE_PATH',DOCUMENT_ROOT.\$relpath.'cache/');
define('SITE_NAME','$arg[sitename]');
define('WEBMASTER_EMAIL','$arg[masteremail]');
define('LOG_USAGE_DB',true);
define('LOG_EXECUTION_TIME',true);
define('LOG_OUTPUT',false );

// Defines for Hercules Admin system
define('_SERVICE_PATH',DOCUMENT_ROOT.'herc/');
define('_BASE_URL','http://'.\$base.\$tail.'herc/');
define('_SECURE_BASE_URL','https://'.\$base.\$tail.'herc/');

define('INSTALLED_SERVICE_PATH',DOCUMENT_ROOT.\$relpath.'services/');
define('_APP_URL',_BASE_URL.'main.php/');
define('_SECURE_APP_URL',_SECURE_BASE_URL.'main.php/');
define('_DEFAULT_URL',_APP_URL);
define('_PICS_URL',_BASE_URL.'templates/images/');
define('DEBUG',true);

\$dsn = array();
\$dsn['default'] = array(
        'driver'=>'".strtolower($arg[driver])."',
        'host'=>'".$arg['dbserver']."',
        'user'=>'".$arg['dbuser']."',
        'password'=>'".$arg['dbpasswd']."',
        'database'=>'".$arg['dbname']."',
        'persistent'=>'y');

# If you are using the integrated qmail services and shell scripts
# you will need to setup this dsn handle for email to work
\$dsn['mail'] = array(
        'driver'=>'',
        'host'=>'',
        'user'=>'',
        'password'=>'',
        'database'=>'',
        'persistent'=>'y');

#logusagedb_define('LOG_USAGE_DB',<!--logusagedb-->);
#logexecutiontime_define('LOG_EXECUTION_TIME',<!--logexecutiontime-->);
#logoutput_define('LOG_OUTPUT',<!--logoutput-->);

# The following defines are specific to the lcUser's table.
# These are used to key off of which user type we have so
# we can load the appropiate user object for that user when
# they log into the system.

# DO NOT MODIFY OR CHANGE THESE YOUR SYSTEM WILL BREAK!
define('USERTYPE_STANDARD', 1);
define('USERTYPE_STUDENT', 2);
define('USERTYPE_FACULTY', 3);

# CUSTOM SYSTEM CONFIGURE OPTIONS #

# Domain appended to student accounts when they are imported or synced
define('SITE_TITLE','".$arg['sitename']."');
define('STUDENT_EMAIL_DOMAIN', '".$arg['studentemail']."');
define('UPDATE_MAILSERVER_DB', FALSE);
define('MAX_COURSES', '".base64_encode(1000000)."');
";
if (@exec('aspell')) { 
	$defines .= "define('HAS_ASPELL', TRUE);\n";
} else { 
	$defines .= "define('HAS_ASPELL', FALSE);\n";
}
if (@exec('tidy -v')) { 
	$defines .= "define('HAS_TIDY', TRUE);\n";
} else { 
	$defines .= "define('HAS_TIDY', FALSE);\n";
}

$defines .= "\n?>";
$foo =@fopen ("./defines.php",'w+');
if ( ! $foo ) { return false; }
fwrite($foo,$defines,strlen($defines));
fclose($foo);
return true;
}


function runSetup(&$arg) {
	//check images dir
	if ( is_writeable('images') ) {
		$copyImages = true;
	}

	//use native LC driver
	$dsn = array();
	$arg = $_POST;
	$sampledata = $arg['sampledata'];
	$dsn['default'] = array(
		'driver'=>strtolower($arg['driver']),
		'host'=>$arg['dbserver'],
		'user'=>$arg['dbuser'],
		'password'=>$arg['dbpasswd'],
		'database'=>$arg['dbname'],
		'persistent'=>'y');
	define('LIB_PATH','../logicreate/lib/');
	$db =  DB::getHandle();

	if ($e = ErrorStack::pullError('db')) {
		$e->message .= '<br />Cannot connect to the database with the supplied username and password.<br />Go back and enter a different username and/or password.';
		fatalError($e);
	}
	if ($arg['dbcreate'] == 'on') 
		$db->query("create database `".$arg['dbname']."`");
		$db->useDB($arg['dbname']);
	if ($e = ErrorStack::pullError('db')) {
		$e->message .= '<br />Cannot create database or use existing database. Check your database software and permissions. <br />If you want to use an existing database uncheck "create database" on the first page of the installer.
		
		<br><br>
		After you address this, simply refresh your browser to
		try again.';
		fatalError($e);
	}

	// grab all SQL files 
	
	$sqlFiles = array (
		'setup.sql',
		'lcConfig.sql',
 		'lcRegistry.sql',
		'lcForms_and_lcFormInfo.sql',
		'lcUsers.sql',
		'lcGroups.sql',
		'lcPerms.sql'
	);

	while (list ($k, $v) = @each($sqlFiles) )
	{
		$f = @fopen(SQL_PATH.$v,'r');
		if (!$f)
		{
			echo "cannot open $v in ".SQL_PATH;
			displayFooter();
			exit();
		}
		$contents .= fread($f,filesize(SQL_PATH.$v));
		fclose($f);

	}

	$contents = str_replace("\r","",$contents);
	$contents = str_replace("\n\n ","\n",$contents);
	$contents = str_replace(",\n",", ",$contents);
	$contents = str_replace("\n)"," ) ",$contents);
	$contents = str_replace("(\n","(",$contents);
	$x = explode("\n",$contents);
	while(list($i,$j) = each($x)) { 
		if ( substr( trim($j), 0, 1) == '#') continue;
		if ( (trim($j)) && (!eregi("^#",$v)) ) { 
			$db->query($j);
		}
	}

	//each module that has META-INFO/setup.sql
	while ( list($k,$v) = @each($arg['modules']) ) {
#		if ($arg['module'][$v]!=1) { continue; }
		if ( $v ) {
			$f = @fopen('../logicreate/services/'.$k.'/META-INFO/setup.sql','r');
			if ($f) { 
				$contents = fread($f,filesize('../logicreate/services/'.$k.'/META-INFO/setup.sql'));
				fclose($f);
				$contents = str_replace("\r","",$contents);
				$contents = str_replace("\n\n ","\n",$contents);
				$contents = str_replace("(\n","(",$contents);
				$contents = str_replace("\n)"," ) ",$contents);
				$contents = str_replace(",\n",", ",$contents);
				$x = explode("\n",$contents);
				while(list($i,$j) = each($x)) { 
					if ( substr( trim($j), 0, 1) == '#') continue;
					if ( (trim($j)) && (!eregi("^#",$v)) ) { 
							$db->query($j);
					}
				}
			}
		}
		//try to move media/*gif, *jpg, *png to public_html/images;
		if ($copyImages) {
			$d = @dir('../logicreate/services/'.$k.'/media');
			if($d) {
			while ($entry = $d->read() ){
				if ( $entry == '.' or $entry == '..' or $entry == 'CVS') continue;
				@copy('../logicreate/services/'.$k.'/media/*.jpg','images/');
				@copy('../logicreate/services/'.$k.'/media/*.gif','images/');
				@copy('../logicreate/services/'.$k.'/media/*.png','images/');
			}
			}
		}
	
	}

	//
	// grab remaining SQL files 
	// but determine if we want to include semesters_and_classes or not
	// ideally we would include separate sets of files 
	// to be distributed altogether
	//
	if ($sampledata=='on') { 	
		$sqlFiles = array (
			'profile.sql',
			'semesters_and_classes.sql'
		);
	} else {
		$sqlFiles = array (
			'profile.sql'
		);
	}

	$contents = '';
	while (list ($k, $v) = @each($sqlFiles) )
	{
		$f = @fopen(SQL_PATH.$v,'r');
		if (!$f)
		{
			echo "cannot open $v in ".SQL_PATH;
			displayFooter();
			exit();
		}
		$contents .= fread($f,filesize(SQL_PATH.$v));
		fclose($f);

	}

	$contents = str_replace("\r","\n",$contents);
	$contents = str_replace("\n\n ","\n",$contents);
	$contents = str_replace(",\n",", ",$contents);
	$contents = str_replace("\n)"," ) ",$contents);
	$contents = str_replace("(\n","(",$contents);
	$x = explode("\n",$contents);
	while(list($i,$j) = each($x)) { 
		if ( substr( trim($j), 0, 1) == '#') continue;
		if ( (trim($j)) && (!eregi("^#",$v)) ) { 
			$db->query($j);
		}
	}



}



//*****************
//display functions
//*****************

function fatalError($e, $resetDefines=TRUE) {
	print "<h1>Fatal Error</h1>";
	print '<div style="color: red;">'.$e->message.'</dvi>';
	print "<br />\n";

	if ($resetDefines)
	{
		unlink('defines.php');
		touch('defines.php');
	}
	displayFooter();
	exit();
}

function displaySorry($error) {
	displayHeader(1);
	
	echo '<h2 style="color: red;">ERROR</h2>';

	switch($error)
	{
			case 1:
			echo '<h2>Sorry...</h2>
			In the interest of security, this installer can only be run
			once.';
				break;

			case 2:
			echo '<h2>Defines.php not found</h2>
			The defines file does not exists.  Please create a zero byte
			file. (example: touch defines.php)';
				break;

			case 3:
				list($isApache, $user, $group) = getUserGroup();
				if ($isApache) { 
					echo '<h2>No Permission...</h2>
					This installer needs to be able to write to the current directory and to the "defines.php" file.  It
					is running as the webserver user (user "'.$user.'").<br />
					To change the permissions of this directory on a UNIX-type operating system
					use the chmod & chown commands.
					<p>
					chmod 755 '.dirname(__FILE__).' <br />
					chown '.$user.' '.dirname(__FILE__).'<BR/>
					chmod 755 '.dirname(__FILE__).'/defines.php <br />
					chown '.$user.' '.dirname(__FILE__).'/defines.php <br />
					</p>
					NOTE: You may need "root" access to make these changes
					After you have made these changes, <a href="'.$_SERVER['PHP_SELF'].'?event=processOne">click here</a>
					to try again.';
				} else {
					echo '<h2>No Permission...</h2>
					This installer needs to be able to write to the current directory and to the "defines.php" file.  It
					is running as the webserver user (usually nobody).<br />
					To change the permissions of this directory on a UNIX-type operating system
					use the chmod & chown commands.
					<p>
					chmod 755 '.dirname(__FILE__).' <br />
					chown '.$user.' '.dirname(__FILE__).'<BR/>
					chmod 755 '.dirname(__FILE__).'/defines.php <br />
					chown '.$user.' '.dirname(__FILE__).'/defines.php <br />
					</p>
					After you have made these changes, <a href="'.$_SERVER['PHP_SELF'].'?event=processOne">click here</a>
					to try again.';



			}
				break;
		}
}

function displayStepTwo(&$arg) {
	displayHeader(3);
	?>
	<h2>Server Requirements</h2>
	The following dipslays the list of minimal requirements needed to 
	run LogiCampus.  You will not be able to install LogiCampus until
	these requirements are met. 
	<?
		# is GD installed
		$no = '<span style="color: red;">No</span>';
		$yes = '<span style="color: green;">Yes</span>';

		$gd =  $yes;
		if (!function_exists('imagecreatetruecolor'))
		{
			$gd =  $no;
			$error = TRUE;
		}
		
		$mysql =  $yes;
		if (!function_exists('mysql_connect'))
		{
			$mysql = $no;	
			$error = TRUE;
		}

		$aspell = $yes;
		$aspell_check = exec('aspell');
		if (!$aspell_check)
		{
			$aspell = $no;
			$error = TRUE;
			$partial = TRUE;
		}

		$tidy = $yes;
		$tidy_check = exec('tidy -v');
		if (!$tidy_check)
		{
			$tidy = $no;
			$error = TRUE;
			$partial = TRUE;
		}

		$php = $yes;
		$compare = version_compare(REQ_PHP_VERSION, phpversion());
		if ($compare == 1)
		{
			$php = $no;	
			$error = TRUE;
		}

	$check = '<span style="color: green;">Passed</span>';
	if($error)
	{
		if ($partial) { 
			$check = '<span style="color: orange;">Failed partially</span>';
		} else { 
			$check = '<span style="color: red;">Failed</span>';
		}
	}
	?>

	<br><br>
	<fieldset>
	<legend><strong>Requirement Results - <?=$check?></strong></legend>
	<ol>
		<li>PHP Version <?=REQ_PHP_VERSION?> or higher = <?=$php?> (currently running <?=phpversion();?>)</li>
		<li>GD 2.0 built into PHP = <?=$gd?></li>
		<li>MySQL built into PHP = <?=$mysql?></li>
		<li>Aspell Binary Found = <?=$aspell?></li>
		<li>Tidy Binary Found = <?=$tidy?></li>
	</ol>
	</fieldset>
	<br><br>
		<? if ($partial) { ?>
		If Tidy or ASpell are missing, you may still install the system, 
		but some pieces of functionality may be missing or cause errors.

		<div style="text-align: right;">
				<form METHOD="POST" action=<?=$_SERVER['PHP_SELF']?>>
				<input type="hidden" name="event" value="processFour">
				<input type="submit" name="submit" value="Proceed anyway&gt;">
				</form>
				</div>
		<? } ?>

	<?

	if ($error) { ?>
	<fieldset>
	<legend>How to fix errors</legend>
	<strong>PHP</strong><br>
	If you do not meet the minimum requirement for the version of PHP
	that is required, you need to upgrade your version of PHP. The
	version that is required is <?=REQ_PHP_VERSION?> and you are currently
	using <?=phpversion()?>.
	
	<br><br>
	<strong>GD</strong><br>
	GD 2.0 is required for LogiCampus. Please build that into your PHP
	version.

	<br><br>
	<strong>MySQL</strong><br>
	Currenlty LogiCampus only supports the MySQL database.  Make sure
	you have MySQL compiled into PHP and that you are at least running
	MySQL version 3.23 or higher.  MySQL 4.0.12 and higher is
	recommended.

	<br><br>
	<strong>Aspell</strong><br>
	So faculty can spell check their assessments, the binary 'aspell'
	is required.  This normally comes with most unix systems and can
	also be obtained for windows machines.  

	<br><br>
	<strong>Tidy</strong><br>
	Content pages that are imported into LogiCampus by faculty are run
	through Tidy.  Tidy is an open source project that will clean and
	validate HTML.  If you do not have Tidy, you can download it from
	<a href="http://tidy.sourceforge.net/" target="_blank">Tidy.Sourceforge.net</a>.
	In order for the installer to find Tidy, be sure Tidy is installed
	in a path the web server can find it.
	</fieldset>
	<? } else { ?>
		<div style="text-align: right;">
				<form METHOD="POST" action=<?=$_SERVER['PHP_SELF']?>>
				<input type="hidden" name="event" value="processThree">
				<input type="submit" name="submit" value="Next&gt;">
		</div>
	<? } ?>
<?
	displayFooter();
}

function displayStepThree(&$arg) {
	displayHeader(3);
	list($isApache, $user,$group) = getUserGroup();
	echo "
	<h2>Permission checking</h2>
	This installer needs to be able to write to the current directory and to the 'defines.php' file.  It
	is running as the webserver user (usually nobody).<br />
	<BR>
	chmod 755 ".dirname(__FILE__)." <br />
	chmod 755 ".dirname(__FILE__)."/defines.php <br />
	chown nobody ".dirname(__FILE__)." 
	<BR>
	<BR>
	</p>
	The server appears to have the proper permissions.  Press the 'continue' button to continue.
	<BR><BR>
	<BR>
	<form method='POST'>
	<input type='hidden' name='event' value='processFour'>
	<input type='submit' value='Continue...'>
	</form>
	";
	displayFooter();
}

function displayEnd(&$t) {
	displayHeader(4);
	echo <<<END
	<h2>Final Step</h2>
	$t[error]
END;
	displayFooter();
}

/*
function displayStepSix(&$t) {
include('defines.php');
	displayHeader(6);
	?>
	<h2>Finished</h2>
	<?=$t['error']?>
<?
	displayFinalInstructions();
	displayFooter();
}
*/

function displayLicense() {
	displayHeader(2);
	if(! @include ('license.txt') ) {
		echo "Someone has tampered with your LogiCampus distribution as we 
			  cannot locate some needed files.
		<br />
		Please try to uncompress the files and start again.  If you continue
		to get this message, please visit the http://www.logicampuscom forums 
		for assistance.  The installation cannot continue.
		";
		exit();
	}
	echo "</pre>\n";
	echo <<<END
	You must agree to this license before continuing.<br />
	<form method="POST">
	<input type="submit" value="I Agree" name="agree">
	<input type="hidden" value="processTwo" name="event">
	</form>

END;
	displayFooter();
}

function displayStepFour($t) {
	displayHeader(4);
	$t['sitename'] = stripslashes($t['sitename']);
	echo <<<END
		<h2>Enter Your Server Database Information</h2>
		Enter your database information in this form:
		<br>
		<span style="color:red;font-size:150%;">$t[error]</span>
		<form method="post">
		<table>
			  <tr>
			    <td>Server host</td>
			    <td><input type="text" name="dbserver" value="$t[dbserver]"></td>
			  </tr>
			  <tr>
			    <td>Database name</td>
			    <td><input type="text" name="dbname" value="$t[dbname]"></td>
			  </tr>
			  <tr>
			    <td>Database user</td>
			    <td><input type="text" name="dbuser" value="$t[dbuser]"></td>
			  </tr>
			  <tr>
			    <td>Database password</td>
			    <td><input type="password" name="dbpasswd" value="$t[dbpasswd]"></td>
			  </tr>
			  <tr>
			    <td>Database driver</td>
			    <td><select name="driver"><option name="driver">MySQL</option></select></td>
			  </tr>
			  <tr>
			    <td>Create database ?</td>
			    <td><input type="checkbox" name="dbcreate" value="on" CHECKED></td>
			  </tr>
			  <tr>
			    <td>Install sample data ?</td>
			    <td><input type="checkbox" name="sampledata" value="on" CHECKED></td>
			  </tr>
		</table>
		<hr>
		<h2>Configuration Options</h2>
		<table width="100%">
			<tr>
			   <td width="175" valign="top" >Site name</td>
			   <td>
			   		<input type="text" name="sitename" value="$t[sitename]"><br>
					The site name is the title that will be displayed
					in the browser for visitors when they access your
					site.  LogiCampus builds dynamic titles for you on
					certain pages.  This sets the default title if one
					is not set.
				</td>
			</tr>
			<tr>
			   <td valign="top">Webmaster email address</td>
			   <td>
			   	<input type="text" name="masteremail" value="$t[masteremail]"><br>
				Enter the webmaster email address for your school.
				This email is appended to certain emails the system
				sends out.
			   </td>
			</tr>
			<tr>
			   <td valign="top">Student Mail Domain Name</td>
			   <td>
			   		<input type="text" name="studentemail" value="$t[studentemail]">
					<br>
					When student accounts are synced with the system,
					this domain is used to append to the accounts the
					system creates.  For example, if your domain name
					for your school is "myschool.com" but email
					accounts are "mail.myschool.com" you will enter
				 "mail.myschool.com".  When student accounts are
				 imported, their email accounts will be set to "username@mail.myschool.com".
				</td>
			</tr>

		</table>
		<br>
		<input type="hidden" value="initialCheck" name="event" style="width: 100px;">
		<input type="submit" value="NEXT&gt;" style="width: 100px;">
		</form>

END;
	displayFooter();
}



function displayStepFive ($t) {

displayHeader(5);
?>
	<h2>List of modules that will be installed</h2>
		<span style="color:red;"><?=$t[error]?></span>
	<form method="POST" action="<?=$_SERVER['PHP_SELF']?>">
	<table>
		<tr bgcolor="#E0E0ff">
<!--			<td align="center" valign="bottom"></td>-->
			<td align="center" valign="bottom"><strong>Modules Found</strong></td>
			<td colspan="2"><strong>Setup information</strong></td>
		</tr>
<?
	while ( list ($k,$v) = @each($t['modules']) ) {
	?>
		<tr>
						<td><?= ucfirst($k);?>
				<input type="hidden" name="modules[<?=$k?>]" value="<?=$k?>">
						</td>
			<? if ($v) { ?>
			<td><i>Custom setup file found</i></td>
			<? } else { ?>
			<td><i>Using default setup procedure</i></td>
			<? } ?>
	


	<?
	}
?>
		</tr>
		<tr><td colspan="3"><strong>Select default module you want your site to use when visitors enter the site.</strong></td>
		</tr>
		<tr>
			<td><input type="radio" name="default" value="welcome" CHECKED></td>
			<td colspan="2">Welcome Module</td>
		</tr>
			<tr>
			<td><input type="radio" name="default" value="login"></td>
			<td colspan="2">Login Module</td>
		</tr>
	</table>
	<br>*  New visitors will automatically see the default module.<br>
	<br>

	<input type="hidden" value="<?=$t[dbserver]?>" name="dbserver">
	<input type="hidden" value="<?=$t[dbname]?>" name="dbname">
	<input type="hidden" value="<?=$t[dbuser]?>" name="dbuser">
	<input type="hidden" value="<?=$t[dbpasswd]?>" name="dbpasswd">
	<input type="hidden" value="<?=$t[driver]?>" name="driver">
	<input type="hidden" value="<?=$t[sitename]?>" name="sitename">
	<input type="hidden" value="<?=$t[masteremail]?>" name="masteremail">
	<input type="hidden" value="<?=$t[studentemail]?>" name="studentemail">
	<input type="hidden" value="<?=$t[dbcreate]?>" name="dbcreate">
	<input type="hidden" value="<?=$t['sampledata']?>" name="sampledata">

	<input type="hidden" value="processSix" name="event">
	<input type="submit" value="Install" style="width:100px;">
	</form>
<?

displayFooter();
}



function displayHeader($step=1) {
global $t, $m;
$t['menu'] = doMenu($m, $step);
$t['title'] = "LogiCampus installer";
$t['toptitle'] = "LogiCampus installer";
include("templates/default/install_header.html.php");
}

function displayFooter() {
	echo <<<END
	<br>
	<p style="font-size:75%;">
	LogiCampus installer 
	</p>
	</body>
	</html>
END;
}
function displayFinalInstructions() {
	echo <<<END
 
 
<h3>Additonal Setup Required: </h3>
<ol>
  <li>You will need to modify permissions on the following directories to allow 
    the web server 'write' access:<BR>
    <BR>
    logicreate/cache/<BR>
    logicreate/classLibrary/<BR>
    logicreate/content/<BR>
    logicreate/content/docs/<BR>
    public_html/images/ <br>
    public_html/images/photos <br>
    public_html/images/photos/thumb <br>

	<!--
    <br>
	Locate the <strong>setpermissions.sh</strong> script in the
	logicreate/scripts/ directory and run it:

	
	<br><br>
	Example:  ./setpermission.sh  (should be run as root)
	-->

	<br><br>

	There are several options to do this depending on how your server is setup.  Example:<br>
    <br>
    chown -R nobody logicreate/content<br>
    chmod -R 755 logicreate/content<br>
	etc.....<br>
    <br>
    Please consult your system admin for the best solution to make these directories writable by the web server.<br>
  </li>
  <li> You will also need to edit the public_html/herc/auth.php file to allow 
    for a username/password for the system administrator. The system does not 
    set a default password - you MUST set a username/password, or you won't be 
    able to use the master control panel. <br>
  </li>
</ol>
END;
 echo "<a href='".DEFAULT_URL."'>Get started!</a></p>";
}


/******************************
 * Libraries		'
/******************************/
class ErrorStack {

	var $stack = array(); 	//pile of errors
	var $count = 0;

	function stack($e) {
		$x =& ErrorStack::_singleton();
		$x->stack[] = $e;
		$x->count++;
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

	function pullError($t='error') {
		$ret = false;
		$newstack = array();
		$found = false;
		$s =& ErrorStack::_singleton();
		for ($x= $s->count; $x >= 0; --$x)  {
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
		static $count;
		//drop unintialized variables
		if ($level == 8 ) return;

		$e = new lcError($message,$level,$line,$file,$context);
#		$bt = debug_backtrace();
		$e->addBackTrace($bt);
		ErrorStack::stack($e);
	}


	function dumpStack() {
		$s =& ErrorStack::_singleton();
		for ($z=0; $z < $s->count; ++$z) {
			//start at 1, skip the backtrace to this function, not necassary
#			$bt = $s->stack[$z]->backtrace;
			for ($x=1; $x < count($bt); ++$x ) {
				if ($x == 1) {print $indent."<h3>".$s->stack[$z]->message ."</h3><br />\n";}
				$indent = str_repeat("&nbsp;&nbsp;&nbsp;",$x);
				if ($bt[$x]['class'] != '' ) {
					print $indent."method : <b>".$bt[$x]['class']."::".$bt[$x]['function']."</b>";
				} else {
					print $indent."function : <b>".$bt[$x]['function']."</b>";
				}
				print "\n";
				print $bt[$x]['file']." ";
				print "(".$bt[$x]['line'].")<br />\n";
				print "<br />\n";
			}
		}
	}
}


class lcError {
	var $message;
	var $priority;
	var $type;

	function lcError($m='',$p=0,$l='',$f='', $t='error') {
		if ($m == '' )
			$m = $php_errormsg;

		$this->message = $m;
		$this->priority = $p;
		$this->type = $t;
		$this->line = $l;
		$this->file = $f;
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
	function throwError ($level,$m,$f,$l,$c) {
		ErrorStack::_errorHandler($level,$m,$f,$l,$c);
	}

	function addBackTrace ($bt) {
#		$this->backtrace = $bt;
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
}



/**
 * class to abstract mysql into LC framework
 *
 * This class wraps the mysql php function calls in
 * a layer that is used directly with the LC modules and
 * system infrastructure.  This class can easily be 
 * duplicated or subclassed to work with other DBs.
 *
 * This class supports multiple result sets, wherein
 * DB queries and result sets may be stacked on top
 * of each other. 
 * <i>Example:</i>  
 * 	$db->query("select * from lcUsers");
 *	while ($db->next_record() ) {
 *		$db->query("select * from payments where username = '".$db->Record['username']."'");
 *		while ($db->next_record() ) {
 *			print_r($db->Record);
 *		}
 *	}
 *
 * @abstract
 */


class DB {

	var $driverID;  		// Result of mysql_connect(). 
	var $resultSet;		 	// Result of most recent mysql_query(). 
	var $record = array(); 		// current mysql_fetch_array()-result. 
	var $row;  			// current row number. 
	var $RESULT_TYPE; 
	var $errorNumber; 		// Error number when there's an error 
	var $errorMessage = ""; 		// Error message when there's an error


	function DB() { 
	}


	/**
	 * Get a copy of the global instance
	 *
	 * The copy returned will use the same database connection
	 * as the global object.
	 * @return 	object 	copy of a db object that has the settings of a DSN entry
	 */
	function getHandle($dsn='default') {
		static $handles = array();

		//get the list of connection setups
		$_dsn = DB::getDSN();

		// if a connection has already been made and in the handles array
		// get it out
                if (is_object($handles[$dsn]) ) {
			$x = $handles[$dsn];
			$x->connect();
                } else {
			//make sure the driver is loaded
			$driver = $_dsn[$dsn]['driver'];
			// and make a new one
                        $x = new $driver();
			$x->host = $_dsn[$dsn]['host'];
			$x->database = $_dsn[$dsn]['database'];
			$x->user = $_dsn[$dsn]['user'];
			$x->password = $_dsn[$dsn]['password'];
			$x->persistent = $_dsn[$dsn]['persistent'];
                	$x->connect(); 
                        $handles[$dsn] = $x;
		}

		//return by value (copy) to make sure
		// nothing has access to old query results
		// keeps the same connection ID though
		return $x;
	}




	/**
	 * Connect to the DB server
	 *
	 * Uses the classes internal host,user,password, and database variables
	 * @return void
	 */
	function connect() {


	} 


	/**
	 * Send query to the DB
	 *
	 * Results are stored in $this->resultSet;
	 * @return 	void
	 * @param 	string	$queryString	SQL command to send
	 */
	function query($queryString) {

	}


	/**
	 * Close connection
	 * 
	 * @return void
	 */
	function close() {

	}


	/**
	 * Grab the next record from the resultSet
	 *
	 * Returns true while there are more records, false when the set is empty
	 * Automatically frees result when the result set is emtpy
	 * @return boolean
	 * @param  int	$resID	Specific resultSet, default is last query
	 */
	function next_record($resID=false) {

	}


	/**
	 * Short hand for query() and next_record().
	 *
	 * @param string $sql SQL Command
	 */
	function queryOne($sql) {

	}

	/**
	 * Short hand way to send a select statement.
	 *
	 * @param string $table 	SQL table name
	 * @param string $fields 	Column names
	 * @param string $where 	Additional where clause
	 * @param string $orderby	Optional orderby clause
	 */
	function select($table,$fields="*",$where="",$orderby="") {
		if ($where) { 
			$where = " where $where";
		}
		if ($orderby) { 
			$orderby = " order by $orderby";
		}
		$sql = "select $fields from $table $where $orderby";
		$this->query($sql);
	}


	/**
	 * Short hand way to send a select statement and pull back one result.
	 *
	 * @param string $table 	SQL table name
	 * @param string $fields 	Column names
	 * @param string $where 	Additional where clause
	 * @param string $orderby	Optional orderby clause
	 */
	function selectOne($table,$fields="*",$where="",$orderby="") {
		if ($where) { 
			$where = " where $where";
		}
		if ($orderby) { 
			$orderby = " order by $orderby";
		}
		$sql = "select $fields from $table $where $orderby";
		$this->queryOne($sql);
	}


	/**
	 * Halt execution after a fatal DB error
	 * 
	 * Called when the last query to the DB produced an error.
	 * Exiting from the program ensures that no data can be
	 * corrupted.  This is called only after fatal DB queries
	 * such as 'no such table' or 'syntax error'.
	 *
	 * @return void
	 */
	function halt() { 
//		include(TEMPLATE_PATH_PARTIAL."default/header.html.php");
		print "We are having temporary difficulties transmitting to our database.  We recommend you stop for a few minutes, and start over again from the beginning of the website.  Thank you for your patience.";
		printf("<b>Database Error</b>: (%s) %s<br>%s\n", $this->errorNumber, $this->errorMessage,$this->queryString);
//		include(TEMPLATE_PATH_PARTIAL."default/footer.html.php");
		exit();
	 }



	/**
	 * Moves resultSet cursor to beginning
	 * @return void
	 */
	function reset() {

	}


	/**
	 * Moves resultSet cursor to an aribtrary position
	 *
	 * @param int $row	Desired index offset
	 * @return void
	 */
	function seek($row) {

	}


	/**
	 * Retrieves last error message from the DB
	 * 
	 * @return string Error message
	 */
	function getLastError() {

	}


	/**
	 * Return the last identity field to be created
	 *
	 * @return mixed
	 */
	function getInsertID() {

	}


	/**
	 * Return the number of rows affected by the last query
	 *
	 * @return int	number of affected rows
	 */
	function getNumRows() {

	}


	function disconnect() {

	}



	function &getDSN($d='') {
		static $dsn;
		if (isset($dsn) ) {
			return $dsn;
		} else {
			if ($d) {
				$dsn = $d;
			}
		}
	}
		

	function singleton($s='') {
		static $singleton;
		if (isset($singleton)) {
			return $singleton;
		}
		else {
			if ($s) {
				$singleton = $s;
			}
		}
	}



}


class mysql extends DB {


 	var $RESULT_TYPE = MYSQL_BOTH;


	/**
	 * Connect to the DB server
	 *
	 * Uses the classes internal host,user,password, and database variables
	 * @return void
	 */
	function connect() {


		if ( $this->driverID == 0 ) {
                #echo "g<Br>";
                if ($this->persistent=='y') {
			$this->driverID=@mysql_pconnect($this->host, $this->user,$this->password);
                } else {
			$this->driverID=@mysql_connect($this->host, $this->user,$this->password);
                }
			if (!$this->driverID) {
				lcError::throwError(5,mysql_error(),__FILE__,__LINE__,'db');
				return false;
			}
		}
		@mysql_select_db($this->database, $this->driverID);
		return true;
	}
	function useDB($database) { 
		@mysql_select_db($database, $this->driverID);
	}


	/**
	 * Send query to the DB
	 *
	 * Results are stored in $this->resultSet;
	 * @return 	void
	 * @param 	string	$queryString	SQL command to send
	 */
	function query($queryString) {
		$this->queryString = $queryString;
		if ($this->driverID == 0 ) {$this->connect();}

		$resSet = mysql_query($queryString,$this->driverID);
		$this->row = 0;
		if ( !$resSet ) {
			$this->errorNumber = mysql_errno();
			$this->errorMessage = mysql_error();
			lcError::throwError(5,mysql_error(),__FILE__,__LINE__,'db');
		}
		if (is_resource($resSet) )
			$this->resultSet[] = $resSet;
	}


	/**
	 * Close connection
	 *
	 * @return void
	 */
	function close() {
		mysql_close($this->driverID);
	}


	/**
	 * Grab the next record from the resultSet
	 *
	 * Returns true while there are more records, false when the set is empty
	 * Automatically frees result when the result set is emtpy
	 * @return boolean
	 * @param  int	$resID	Specific resultSet, default is last query
	 */
	function next_record($resID=false) {
		if ( ! $resID ) { $resID = count($this->resultSet) -1; }

		$this->Record = mysql_fetch_array($this->resultSet[$resID],$this->RESULT_TYPE);
		$this->row += 1;

		//no more records in the result set?
		$ret = is_array($this->Record);
		if ( ! $ret ) {
			mysql_free_result($this->resultSet[$resID]);
			array_pop($this->resultSet);
		}
		return $ret;
	}


	/**
	 * Short hand for query() and next_record().
	 *
	 * @param string $sql SQL Command
	 */
	function queryOne($sql) {
		$this->query($sql);
		$this->next_record();
		array_pop($this->resultSet);
	}



	function queryAll($sql) {
		$this->query($sql);
		while($this->next_record()) {
			$ret [] = $this->Record;
		}
	return $ret;
	}

	/**
	 * Short hand way to send a select statement.
	 *
	 * @param string $table 	SQL table name
	 * @param string $fields 	Column names
	 * @param string $where 	Additional where clause
	 * @param string $orderby	Optional orderby clause
	 */
	function select($table,$fields="*",$where="",$orderby="") {
		if ($where) {
			$where = " where $where";
		}
		if ($orderby) {
			$orderby = " order by $orderby";
		}
		$sql = "select $fields from $table $where $orderby";
		$this->query($sql);
	}


	/**
	 * Short hand way to send a select statement and pull back one result.
	 *
	 * @param string $table 	SQL table name
	 * @param string $fields 	Column names
	 * @param string $where 	Additional where clause
	 * @param string $orderby	Optional orderby clause
	 */
	function selectOne($table,$fields="*",$where="",$orderby="") {
		if ($where) {
			$where = " where $where";
		}
		if ($orderby) {
			$orderby = " order by $orderby";
		}
		$sql = "select $fields from $table $where $orderby";
		$this->queryOne($sql);
	}


	/**
	 * Halt execution after a fatal DB error
	 *
	 * Called when the last query to the DB produced an error.
	 * Exiting from the program ensures that no data can be
	 * corrupted.  This is called only after fatal DB queries
	 * such as 'no such table' or 'syntax error'.
	 *
	 * @return void
	 */
	function halt() {
//		include(TEMPLATE_PATH_PARTIAL."default/header.html.php");
		print "We are having temporary difficulties transmitting to our database.  We recommend you stop for a few minutes, and start over again from the beginning of the website.  Thank you for your patience.";
		printf("<b>Database Error</b>: (%s) %s<br>%s\n", $this->errorNumber, $this->errorMessage,$this->queryString);
//		include(TEMPLATE_PATH_PARTIAL."default/footer.html.php");
		exit();
	 }



	/**
	 * Moves resultSet cursor to beginning
	 * @return void
	 */
	function reset() {
		mysql_data_seek($this->Query_ID,0);
	}


	/**
	 * Moves resultSet cursor to an aribtrary position
	 *
	 * @param int $row	Desired index offset
	 * @return void
	 */
	function seek($row) {
		mysql_data_seek($this->resultSet,$row);
		$this->row  = $row;
	}


	/**
	 * Retrieves last error message from the DB
	 *
	 * @return string Error message
	 */
	function getLastError() {
	    $this->errorNumber = mysql_errno();
	    $this->errorMessage = mysql_error();
	return $this->errorMessage;
	}


	/**
	 * Return the last identity field to be created
	 *
	 * @return mixed
	 */
	function getInsertID() {
		return mysql_insert_id($this->driverID);
	}


	/**
	 * Return the number of rows affected by the last query
	 *
	 * @return int	number of affected rows
	 */
	function getNumRows() {
		$resID = count($this->resultSet) -1;
		return @mysql_num_rows($this->resultSet[$resID]);
	}



	function disconnect() {
		mysql_close();
	}

	function getTableColumns($table='') { 
		if ($this->driverID == 0 ) {$this->connect();}
		$dbfields = mysql_list_fields($this->database,$table,$this->driverID);
		$columns =  mysql_num_fields($dbfields);

for ($i = 0; $i < $columns; $i++) {
	$name = mysql_field_name($dbfields, $i);
if ( ($this->RESULT_TYPE == MYSQL_ASSOC)  || ($this->RESULT_TYPE == MYSQL_BOTH) ) { 
	$field[name][$name] = $name;
	 $field[type][$name] =  mysql_field_type($dbfields, $i);
	 $field[len][$name] =  mysql_field_len($dbfields, $i);
	 $field[flags][$name] =  mysql_field_flags($dbfields, $i);
}
if ( ($this->RESULT_TYPE == MYSQL_NUM)  || ($this->RESULT_TYPE == MYSQL_BOTH) ) { 
	 $field[name][] =  $name;
	 $field[type][] =  mysql_field_type($dbfields, $i);
	 $field[len][] =  mysql_field_len($dbfields, $i);
	 $field[flags][] =  mysql_field_flags($dbfields, $i);
}
}
return $field;
	}

}
function doMenu($menuData, $step=1) { 
while(list($k,$v) = each($menuData)) {
$m= "background-color:#FFFFFF;";
if ($k==$step) { 
$m= "background-color:#335599; color: #FFFFFF;";
}
$x.= "<tr><td style=\"$m\">$v</td></tr>";
}
return $x;
}



function getUserGroup() { 

ob_start();
phpinfo(INFO_MODULES);
$s = ob_get_contents();
ob_end_clean();
$parts = explode("<h2", $s);
$set = array();
foreach($parts as $val) {
	  preg_match("/<a name=\"module_([^<>]*)\">/", $val, $sub_key);
	  preg_match_all("/<tr[^>]*>
	  <td[^>]*>(.*)<\/td>
	  <td[^>]*>(.*)<\/td>/Ux", $val, $sub);
	  preg_match_all("/<tr[^>]*>
	  <td[^>]*>(.*)<\/td>
	  <td[^>]*>(.*)<\/td>
	  <td[^>]*>(.*)<\/td>/Ux", $val, $sub_ext);
	foreach($sub[0] as $key => $val) {
	  $set[$sub_key[1]][strip_tags($sub[1][$key])] = array(strip_tags($sub[2][$key]));
	 }
	foreach($sub_ext[0] as $key => $val) { 
	  $set[$sub_key[1]][strip_tags($sub_ext[1][$key])] = array(strip_tags($sub_ext[2][$key]), strip_tags($sub_ext[3][$key]));
	}
}
$changeToUser = "nobody";
$changeToGroup = "nobody";
$isApache = false;
if (eregi("apache", php_sapi_name())) { // using apache
$isApache=true;
$ug = $set[php_sapi_name()]['User/Group '][0];
list($user,$changeToGroup) = split("/",$ug);
list($junk,$user) = split("\(",$user);
list($changeToUser,$junk) = split("\)",$user);
}
return array($isApache, $changeToUser, $changeToGroup);
}

?>
