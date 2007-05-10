<?php
	include('defines.template.php');
?><html>
<body>


	<h2 style="margin:1px;">Installation</h2>
<div style="background-color:#9C0000;color:white">
&nbsp;
</div>

<br/>

<form method="GET" style="padding:0px;margin:0px;" action="<?php echo $PHP_SELF;?>">
<fieldset style="background-color:#DDE;font-family:Helvetica,Arial;">
<legend style="font-size:120%;">Instructions</legend>
	<p>
	It seems as though the site has not been installed yet.  To complete the installation 
	you need to:
		<ol>
			<li>Edit the file called <em>'defines.template.php'</em>.</li>
			<li>Change the database settings near the bottom
			of the file and save it as a file called <em>'defines.php'</em>.</li>
			<li>Save or upload this file to the 
			same folder that has the <em>'defines.template.php'</em> file.</li>
		</ol>
	</p>

	<p>
	After you setup the configuration file you will need to populate the database.
	A bash script called <i>'wipe_clean.sh'</i> is provided in the <i>'logicampus/scripts/'</i> directory.  It will <em><u>erase ALL TABLES</u></em> in the given database and
	insert the proper LogiCampus tables.  It is important to use a new database and to 
	remove the <i>'logicampus/scripts/'</i> directory after running <i>'wipe_clean.sh'</i>.
	</p>

	<p>
	<pre>
	# cd logicampus/scripts/
	# sh ./wipe_clean.sh db_user db_pass db_name
	</pre>
	</p>
</fieldset>

<br/>
<a href="<?php echo $PHP_SELF;?>">Click here</a> to reload the page when you're done with the installation.
<br/>
<br/>
<?php
if ($_GET['send'] == 'go') {
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
			<li>Campus Version: @version.number@@version.extra@</li>
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
		$post .= '&campus_version=@version.number@@version.extra@';
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
