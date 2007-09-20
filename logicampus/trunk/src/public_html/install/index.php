<?php
if (! defined('BASE_URL') ) {
	if (@!include('../defines.php')) {
		die("no defines file found, cannot proceed.");
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

function getErrMessage($id) {
	switch ($id) {
	case 3:
		return "That user and password were not accepted by the server.";

	case 1:
		return "The database user cannot access the chosen database.";

	case 2:
		return "The user does not have permissions to create the chosen database.";

	case 4:
		return "An error occured that stopped the installation.  Make sure the user has all the proper permissions.<br/>You might need to drop and re-create the database since the installation was not properly finished.";

	}
}



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
If this is your first run, you must setup a database connection.
</p>


<fieldset style="background-color:#DDE;font-family:Helvetica,Arial;">
<legend style="font-size:120%;">Default Settings</legend>
LogiCampus is designed to install onto desktop systems very easily.  
<br/>
* If you are installing on a shared host the default settings <b>will not work</b>.  
<br/>
* If you are installing on your desktop for evaluation purposes, the default settings will most likely work.
</fieldset>


<p>
You can try the default settings by clicking the following button.
</p>


<form method="GET" style="padding:0px;margin:0px;" action="install_proc.php">
<input type="submit" value="Attempt Installation"/>
<input type="hidden" name="install" value="1"/>
</form>


<hr/>

<h4>Help, I know I need to change my settings!</h4>
<h5>... or, the default settings didn't work!</h5>


<fieldset style="background-color:#DDE;font-family:Helvetica,Arial;">
<legend style="font-size:120%;">Web server needs to write to <em>defines.php</em></legend>
<table border="0" width="40%">
<tr><th>Setting</th><th>Value</th><th>Ok?</th></tr>
<tr><td><em>defines.php</em> is writable</th><th><?=printbool($settings['defines_is_writable']);?></th><th><?=yesno($settings['defines_is_writable'],true);?></th></tr>

</table>
</fieldset>

<?php
	 if ( !$settings['defines_is_writable']) {
?>
	<p>
	If your Web server cannot write to <em>defines.php</em> you have two options:
	<ol>
		<li>Change permissions on the file <em>defines.php</em></li>
		<li>Edit the <em>defines.php</em> file manuall, in a text editor that can save as plain text</li>
	</ol>
	</p>


<fieldset style="background-color:#DDE;font-family:Helvetica,Arial;">
<legend style="font-size:120%;">Option #1 -- Change Permissions Manually</legend>
<p>
Use an FTP program or the control panel from your Web host to change permissions. The UNIX-style numeric permisions should be "666".  Also, if you have shell access, you can run the command <em>chmod a+w defines.php</em> from the directory that holds the file.
</p> 
<hr/>
<p>
Once you're finished, click this button to refresh this page.
</p>

<form method="GET" style="padding:0px;margin:0px;" action="<?php echo @$_SERVER['PHP_SELF'];?>">
<input type="submit" name="sbmbutton" value="Refresh"/>
</form>
</fieldset>

<fieldset style="background-color:#DDE;font-family:Helvetica,Arial;">
<legend style="font-size:120%;">Option #2 -- Edit <em>defines</em> File Manually</legend>
<p>
You can also use an FTP program to download the defines file, change the database settings, then re-upload your file.  
</p> 
<hr/>
<p>
Once you're finished, click this button to attempt an installation
</p>

<form method="GET" style="padding:0px;margin:0px;" action="install_proc.php">
<input type="submit" name="sbmbutton" value="Attempt Installation"/>
</form>
</fieldset>


<?php
	 }//end if
?>


<?php
	 if ($settings['defines_is_writable']) {
?>
<form method="GET" style="padding:0px;margin:0px;" action="db.php">
<input type="submit" name="sbmbutton" value="Change Databaes Settings"/>
</form>

<?php
	 }//end if
?>



<!--
<form method="GET" style="padding:0px;margin:0px;" action="<?php echo @$_SERVER['PHP_SELF'];?>">
<fieldset style="background-color:#DDE;font-family:Helvetica,Arial;">
<legend style="font-size:120%;">Advanced Installation</legend>
	<p>
	For an advanced installation you can change the default settings by downloading the following file and saving it as <i><?= dirname(__FILE__);?>/defines.php</i>.
	</p>
	<p>
	<a href="install.php?action=getdefines.php">Download the configuration file (defines.template.php)</a>

	<p>
	For a manual setup, please execute all the sql files in <i><?=dirname(__FILE__);?>/install/</i>.
	</p>
</fieldset>

<br/>
<?php
if (isset($_GET['send']) && $_GET['send'] == 'go') {
	$stats = true;
	if ( !sendStats('logicampus.com') ) {
		$stats = sendStats('216.40.247.38');
	}

	if ($stats) {
		echo '<h3>Thanks for sending your data.</h3>';
	} else {
		echo '<h3>There was a problem sending your data.</h3>';
	}
}

?>

<fieldset style="background-color:#DDE;font-family:Helvetica,Arial;">
<legend style="font-size:120%;">Statistics</legend>
	<p>
	You may report this installation by clicking on the submit button below.
	No personally identifiable information is required.  The information that will 
	be submitted automatically is:

		<ol>
			<li>Web Server Name and/or IP Address: <?php echo $_SERVER['HTTP_HOST'].'/'.$_SERVER['SERVER_ADDR'];?></li>
			<li>Browser Type: <?php echo $_SERVER['HTTP_USER_AGENT'];?></li>
			<li>Campus Version: 1.1.6a</li>
			<li>PHP Version: <?php echo PHP_VERSION;?></li>
			<li>Today's Date: <?php echo  date('m.d.Y');?></li>
		</ol>
	</p>

	<input type="submit" id="submit_button" value="Don't Send Personal Info."/>
	<p>
	In addition, you may also add personal information if you wish:
	<div style="width:300px;text-align:right">
		<ol>
			<li style="float:left;"><label for="org_name">
				Organization Name:</label></li>
			<input id="org_name" type="text" size="35" value=""/>
			<li style="float:left;"><label for="contact_name">
				Contact Name:</label></li>
		       	<input id="contact_name" type="text" size="35" value=""/>
			<li style="float:left;"><label for="contact_email">
				Contact Email:</label></li> 
			<input id="contact_name" type="text" size="35" value=""/>
			<li style="float:left;"><label for="contact_phone">
				Contact Phone Number:</label></li>
			<input type="text" size="35" value=""/>
		</ol>
	</div>
	<input type="hidden" name="send" value="go"/>
	<input type="submit"  id="submit_button" value="Send Statistics"/>
	</p>

</fieldset>
</form>


<br/>
-->

<div style="margin-top:2em;font-size:75%;">
LogiCampus <?php echo LOGICAMPUS_VERSION.LOGICAMPUS_VERSION_STATUS;?>
<br/>
Build Date: <?php echo LOGICAMPUS_BUILD_DATE;?>
</div>
<pre>
<?php //print_r($_SERVER);?>
</pre>
</body>
</html>
<?php
	//define function to send stat info
	function sendStats($host) {
		$post = 'http_host='.$_SERVER['HTTP_HOST'];
		$post .="\n";
		$post .= '&server_addr='.$_SERVER['SERVER_ADDR'];
		$post .="\n";
		$post .= '&user_agent='.$_SERVER['HTTP_USER_AGENT'];
		$post .="\n";
		$post .= '&campus_version='.LOGICAMPUS_VERSION.LOGICAMPUS_VERSION_STATUS;
		$post .="\n";
		$post .= '&php_version='.$PHP_VERSION;
		$post .="\n";
		$post .= '&install_date='.time();

		//echo $post;


		$fp = fsockopen ($host, 80);
		if ($fp) {

			fputs ($fp, "
POST /web_reg.php HTTP/1.0
Host: logicampus.com
Content-Length: ".strlen($post)."
Content-Type: application/x-www-form-urlencoded
Connection: Close

".$post."

");


			while (!feof($fp)) {fgets ($fp,4096); }
			 fclose ($fp);
			return 1;
		} else {
			return 0;
		}
	}
?>
