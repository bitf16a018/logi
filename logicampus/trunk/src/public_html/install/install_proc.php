<?php

$errorIds = array();
//write out the new defines file.
//  it should be writable by now.
//if we have POST variables, assume that they came from the db.php settings page
if (isset($_POST['db_name']) ) {
	if (is_writable('../defines.php') ) {
		$defines = file_get_contents('../defines.template.php');
		/*
		$dsn['default'] = array(
				'driver'=>'@db.driver@',
				'host'=>'@db.host@',
				'user'=>'@db.user@',
				'password'=>'@db.password@',
				'database'=>'@db.database@',
				'persistent'=>'n');

		 */
		$defines = str_replace( '@db.driver@', 'mysql', $defines);
		$defines = str_replace( '@db.host@', $_POST['db_host'], $defines);
		$defines = str_replace( '@db.user@', $_POST['db_user'], $defines);
		$defines = str_replace( '@db.password@', $_POST['db_pass'], $defines);
		$defines = str_replace( '@db.database@', $_POST['db_name'], $defines);
		$f = fopen('../defines.php','w');
		if (!$f) {
			$errorIds[] = 5;
			redirBack();
		}
		fputs($f, $defines);
		fclose($f);


	//use the fields passed by the previous page
	$dsn = array();

	$dsn['default'] = array(
			'driver'=>'mysql',
			'host'=>$_POST['db_host'],
			'user'=>$_POST['db_user'],
			'password'=>$_POST['db_pass'],
			'database'=>$_POST['db_name'],
			'persistent'=>'n');

	}
}

if (! defined('BASE_URL') ) {
	if (@!include('../defines.php')) {
		die("no defines file found, cannot proceed.");
	}
}



include_once(LIB_PATH."LC_db.php");
include_once(LIB_PATH."LC_include.php");

$results['connect'] = $gdb->connect();

header('Pragma: No-cache');


if (!$results['connect']) { 
	//if driverID is not a resource, then the user/pass were rejected
	if (! is_resource($gdb->driverID) ) { 
		$errorIds[] = 3; //user not allowed
		redirBack();
	}
	
	//check to see if user/pass is right, but DB cannot be selected
	if (strstr($gdb->errorMessage, "select")) {

		//try to make the DB
		$results['createdb'] = $gdb->query("CREATE DATABASE ".$dsn['default']['database']);
		if (!$results['createdb']) {
			$errorIds[] = 2;
			redirBack();
		}

		$gdb->disconnect();
		$results['connect'] = $gdb->connect();
	}
}

if (!$results['connect']) { 
	$errorIds[] = 1;
	redirBack();
}

if ($results['connect'] ) {

	//try to see if all the tables are installed
	$results['hastables'] = $gdb->query("select count(*) from lcUsers");
	if (!$results['hastables'] ) {
		$e = ErrorStack:: pullError();
		$results['createtables'] = tryToMakeTables($gdb);

		if (!$results['createtables']) {
			die ('died on making tables.');
			include('install.php');
			exit();
		} else {
			$gdb->disconnect();
			header("Location: install_done.php");
			exit();
		}
	}
	if (!$results['hastables'] && !$_GET['install'] ) {
		include('install.php');
		exit();
	}
}


function tryToMakeTables(&$gdb) {

	for ($x=1; $x <= 26; $x++) {
		$installTableSchemas = array();
		include('./schema_'.sprintf('%02d',$x).'.php');
		if (! is_array($installTableSchemas) ) {
			return false;
		}
		foreach ($installTableSchemas as $schema) {
			if (trim($schema) == '') { continue;}
			if (!$gdb->query($schema)) {
				echo "query failed. ($x)\n";
				echo $gdb->errorMessage."\n";
				print_r($schema);
				exit();
				return false;
			}
		}
	}
	for ($x=1; $x <= 15; $x++) {
		$installTableSchemas = array();
		include('./data_'.sprintf('%02d',$x).'.php');
		if (! is_array($installTableSchemas) ) {
			return false;
		}
		foreach ($installTableSchemas as $schema) {
			if (trim($schema) == '') { continue;}
			if (!$gdb->query($schema)) {
				echo "data insert failed.\n";
				print_r($schema);
				exit();
				return false;
			}
		}
	}

	return true;
}

function redirBack() {
	global $errorIds;
	if (strstr($_SERVER['HTTP_REFERER'], '?') ) {
		$getstr = '&';
	} else {
		$getstr = '?';
	}
	$getstr .= 'errid='.$errorIds[0];
	header('Location: '.$_SERVER['HTTP_REFERER'].$getstr);
	exit();
}

?>
