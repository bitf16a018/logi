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

$settings = array();
$settings['defines_is_writable'] = is_writable('../defines.php');
$settings['root_is_writable'] = is_writable('../');
$settings['magic_quotes_gpc'] = ini_get('magic_quotes_gpc');

if (@$_GET['action']) {
	header('Content-type: text/plain');
	header('Content-disposition: attachment;filename="defines.php"');
	echo (file_get_contents('defines.template.php'));
	exit();
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


<h2 style="margin:1px;">Install LogiCampus</h2>
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
<!--
<p>
Here is an overview of the settings for this installation.  If there are any settings that are not "OK" you need to change them before procedding to the next step.
</p>
<fieldset style="background-color:#DDE;font-family:Helvetica,Arial;">
<legend style="font-size:120%;">Settings</legend>
<table border="0" width="40%">
<tr><th>Setting</th><th>Value</th><th>Ok?</th></tr>
<tr><td><em>defines.php</em> is writable</th><th><?=printbool($settings['defines_is_writable']);?></th><th><?=yesno($settings['defines_is_writable'],true);?></th></tr>
<tr><td><em>root </em> is writable</th><th><?=printbool($settings['defines_is_writable']);?></th><th><?=yesno($settings['defines_is_writable'],'either');?></th></tr>

</table>
</fieldset>
-->




<p>
Change your database settings with the form below.
</p>


<form method="POST" style="padding:0px;margin:0px;" name="dbsettings" id="dbsettings" action="install_proc.php">
<fieldset style="background-color:#DDE;font-family:Helvetica,Arial;">
<legend style="font-size:120%;">Database Settings</legend>

<table border="0" width="40%">


<tr>
	<td>Database User:</td>
	<td><input type="text" size="23" value="<?=$db_user;?>" name="db_user"/>
</tr>

<tr>
	<td>Database Password:</td>
	<td><input type="password" size="23" value="<?=$db_pass;?>" name="db_pass"/>
</tr>

<tr>
	<td>Database Name:</td>
	<td><input type="text" size="23" value="<?=$db_name;?>" name="db_name"/>
</tr>

<tr>
	<td>Database Host:</td>
	<td><input type="text" size="23" value="<?=$db_host;?>" name="db_host"/>
</tr>
</table>


</fieldset>

<p>
Now, you can try these settings by clicking the following button.
</p>


<input type="submit" value="Attempt Installation"/>
<input type="hidden" name="install" value="1"/>
</form>


</body>
</html>
