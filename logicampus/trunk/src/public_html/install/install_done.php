<?php
if (! defined('BASE_URL') ) {
	if (@!include('../defines.php')) {
		die("no defines file found, cannot proceed.");
	}
}
function getErrMessage($id) {
	switch ($id) {
	case 3:
		return "That user and password were not accepted by the server.";

	case 1:
		return "The database user cannot access the chosen database.";

	case 2:
		return "The user does not have permissions to create the chosen database.";

	}
}
$hasErrors = false;

function yesno($val, $req) {
	if ($val == $req) {
		return "<font color=\"green\">Yes</font>";
	} else if ($req === 'either') {
		return "<font color=\"green\">Yes</font>";
	} else {
		global $hasErrors;
		$hasErrors = true;
		return "<font color=\"red\">No</font>";
	}
}

function printbool($val) {
	if ($val === true) {
		echo "true";
	} else {
		echo "false";
	}
}

//variables just for this page
$db_name = '';
$db_user = '';
$db_pass = '';
$db_host = '';

?><html>
<head><title>LogiCampus Installation</title></head>
<body>


<h2 style="margin:1px;">Installation Complete</h2>
<div style="background-color:#9C0000;color:white">
&nbsp;
</div>

<?php
	if (isset($_GET['errid'])) {
		$errid = $_GET['errid'];
?>
<br/>
<div style="border:1px solid red;background-color:#FEE;">
	<h3 style="color:red;">There was an error:</h3>
		<p><?=getErrMessage($errid);?></p>
</div>
<?php
	}
?>


<p>
It seems that you're all done.
</p>


<form method="POST" style="padding:0px;margin:0px;" name="dbsettings" id="dbsettings" action="install_proc.php">
<fieldset style="background-color:#DDE;font-family:Helvetica,Arial;">
<legend style="font-size:120%;">Notice</legend>

<p>
Please delete the directory "install" from your server.  It is no longer needed and could allow someone to reset your system if there are any database problems in the future.
</p>
</fieldset>

<br/>

<a href="../index.php">Login to LogiCampus</a>

</body>
</html>
