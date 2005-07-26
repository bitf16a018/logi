<?php
	include('defines.template.php');
?><html>
<body>


	<h2 style="margin:1px;">Installation</h2>
<div style="background-color:#9C0000;color:white">
&nbsp;
</div>

<br/>

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
</fieldset>

<br/>

<a href="<?= $PHP_SELF;?>">Click here</a> to reload the page when you're done with the installation.

<div style="margin-top:2em;font-size:75%;">
Logicampus <?= LOGICAMPUS_VERSION.LOGICAMPUS_VERSION_STATUS;?>
<br/>
Build Date: <?= LOGICAMPUS_BUILD_DATE;?>
</div>
</body>
</html>
