<?php

if (!include_once('../../public_html/defines.php') ) {
	die("Can't include database connection info ('../../public_html/defines.php')\n");
}


$conn = mysql_connect($dsn['default']['host'],
		$dsn['default']['user'],
		$dsn['default']['password']
	);

mysql_select_db($dsn['default']['database'],$conn);

//get the lesson form
$res = mysql_query("SELECT lcFormInfo.pkey FROM lcFormInfo WHERE lcFormInfo.formCode = 'lesson'",$conn);
echo("SELECT lcFormInfo.pkey FROM lcFormInfo WHERE lcFormInfo.formCode = 'lesson'");
echo mysql_error($conn);
echo "\n";
echo "\n";
$row = mysql_fetch_assoc($res);
$formInfoId = $row['pkey'];


//remove the pieces of it
$res = mysql_query("DELETE FROM lcForms WHERE formId = $formInfoId");
echo("DELETE FROM lcForms WHERE formId = $formInfoId\n");

//remove the form itself
$res = mysql_query("DELETE FROM lcFormInfo WHERE pkey = $formInfoId");
echo("DELETE FROM lcFormInfo WHERE pkey = $formInfoId\n");


?>
