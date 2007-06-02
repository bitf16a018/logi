<?php

$results['connect'] = $gdb->connect();

header('Pragma: No-cache');

if (!$results['connect']) { 
	//check to see if user/pass is right, but DB cannot be selected
	if (strstr($gdb->errorMessage, "select")) {
		if (! $_GET['install']) { 
			include('install.php');
			exit();
		}

		//try to make the DB
		$results['createdb'] = $gdb->query("CREATE DATABASE ".$dsn['default']['database']);
		if (!$results['createdb']) {
			include('install.php');
			exit();
		}
		$gdb->disconnect();
		$results['connect'] = $gdb->connect();
	} else {
		include('install.php');
		exit();
	}
}


if ($results['connect'] ) {

	//try to see if all the tables are installed
	$results['hastables'] = $gdb->query("select count(*) from lcUsers");
	if (!$results['hastables'] && $_GET['install']) {
		$e = ErrorStack:: pullError();
		$results['createtables'] = tryToMakeTables($gdb);

		if (!$results['createtables']) {
			die ('died on making tables.');
			include('install.php');
			exit();
		} else {
			$gdb->disconnect();
			header("Location: ".APP_URL);
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
		include('install/schema_'.sprintf('%02d',$x).'.php');
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
		include('install/data_'.sprintf('%02d',$x).'.php');
		if (! is_array($installTableSchemas) ) {
			return false;
		}
		foreach ($installTableSchemas as $schema) {
			if (trim($schema) == '') { continue;}
			if (!$gdb->query($schema)) {
				echo "query 2 failed.\n";
				print_r($schema);
				exit();
				return false;
			}
		}
	}

	return true;
}
?>
