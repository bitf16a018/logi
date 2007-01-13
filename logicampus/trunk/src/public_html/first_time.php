<?php

$results['connect'] = $gdb->connect();

if (!$results['connect']) { 
	//check to see if user/pass is right, but DB cannot be selected
	if (strstr($gdb->errorMessage, "select")) {
		//try to make the DB
		$results['createdb'] = $gdb->query("CREATE DATABASE ".$dsn['default']['database']);
		if (!$results['createdb']) {
			include('install.php');
			exit();
		}
	} else {
		echo "can't connect";
		exit();
	}
}

if ($results['connect']) {

	//try to see if all the tables are installed
	$results['hastables'] = $gdb->query("select count(*) from lcUsers");
	if (!$results['hastables']) {
		$e = ErrorStack:: pullError();
		$results['createtables'] = tryToMakeTables($gdb);

		if (!$results['createtables']) {
			include('install.php');
			exit();
		} else {
			$gdb->disconnect();
			header("Location: ".APP_URL);
			exit();
		}
	}
}


function tryToMakeTables($gdb) {

	include('install_schemas.php');
	foreach ($installTableSchemas as $schema) {
		if (trim($schema) == '') { continue;}
		if (!@$gdb->query($schema)) {
			return false;
		}
	}
	return true;
}
?>
