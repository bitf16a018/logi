<?php
if ($_GET['action']) {
	header('Content-type: text/plain');
	header('Content-disposition: attachment;filename="defines.php"');
	echo (file_get_contents('defines.template.php'));
	exit();
}
?><html>
<head><title>LogiCampus Installation</title></head>
<body>


	<h2 style="margin:1px;">First Run</h2>
<div style="background-color:#9C0000;color:white">
&nbsp;
</div>

<p>
If this is your first run, you must setup a database connection.
<?php if ($_GET['install']) { 
print_r($results);
 } ?>
</p>
<fieldset style="background-color:#DDE;font-family:Helvetica,Arial;">
<legend style="font-size:120%;">Database</legend>
	<ul>
		<li>Database Host: localhost</li>
		<li>Database User: root</li>
		<li>Database Pass: <i>(leave unset)</i></li>
		<li>Database Name: campus</li>
	</ul>
</fieldset>

<p>
Once you are done creating the database, you can try to install LogiCampus with the following button.

<form method="GET" style="padding:0px;margin:0px;" action="<?php echo BASE_URL;?>">
<input type="submit" value="Attempt Installation"/>
<input type="hidden" name="install" value="1"/>
</form>

<form method="GET" style="padding:0px;margin:0px;" action="<?php echo $PHP_SELF;?>">
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
		$post .= '&campus_version=1.1.6a';
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
