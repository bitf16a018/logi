<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<HTML>
<HEAD>

	<TITLE>LogiCampus</TITLE>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <meta name="keywords" content="distance learning, LogiCampus, courseware, e-learning, course management" />

	<link rel="stylesheet" type="text/css" href="<?=TEMPLATE_URL;?>sinorca-screen.css" media="screen" title="Sinorca (screen)" />
	<link rel="stylesheet" type="text/css" href="<?=TEMPLATE_URL;?>calendar.css"  media="screen" title="Sinorca (screen)" />
	<link rel="stylesheet alternative" type="text/css" href="sinorca-screen-alt.css" media="screen" title="Sinorca (alternative)" />
	<link rel="stylesheet" type="text/css" href="sinorca-print.css" media="print" />


	<script type="text/javascript" src="<?=BASE_URL;?>htmlarea/htmlarea.js"></script>
	<script type="text/javascript" src="<?=BASE_URL;?>htmlarea/htmlarea-lang-en.js"></script>
	<script type="text/javascript" src="<?=BASE_URL;?>htmlarea/dialog.js"></script>
	<script type="text/javascript" src="<?=BASE_URL;?>htmlarea/popupwin.js"></script>
	<script type="text/javascript" src="<?=BASE_URL;?>htmlarea/custom.js"></script>
</HEAD> 
<BODY style="background-color:silver;" bgcolor="silver" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" link="#0066FF">

<center>

<div style="background-color:silver;">
<br/>
<br/>

<form id="login" method="post" action="<?=APP_URL?>login/main/">
<table width="400" border="0" cellpadding="0" cellspacing="0" style="background-color:white;">
	<tr>
		<td colspan="2">
			<div class="midHeader">
				<h1 class="headerTitle">LogiCampus</h1>
			</div>
		</td>
	</tr>
	<tr bgcolor="#003366"><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
			<br />
			<table width="80%" border="0" align="center">
			<tr>
			  <td width="50%" align="right"><b><?=lct('username');?>:</b></td>
			  <td width="50%"><input id="login_name" type="text" size="15" maxlength="32" name="username" /></td>
			</tr>
			<tr>
			  <td width="50%" align="right"><b><?=lct('password');?>:</b></td>
			  <td width="50%"><input id="login_passwd" type="password" size="15" maxlength="32" name="password" /></td>
			</tr>
			<tr>
			  <td colspan="2" align="center">
			    <input type="hidden" name="event" value="login"/>
			    <input type="submit" name="login_button" value="<?=lct('Login');?>"/>
			  </td>
			</tr>
			</table>

		    <br />
  </td>
</tr>
<tr>
  <td colspan="2" align="right" class="blue">
    LogiCampus <?=LOGICAMPUS_VERSION.LOGICAMPUS_VERSION_STATUS?> </td>
<tr>
<tr>
<td colspan="2">
<div style="padding:.5em;">
	<?PHP if(LcSettings::isModuleOn('MODULE_REGISTRATION')) { ?>
	<strong>To create your own student login</strong>, click below.
	<br/>
	<a href="<?= BASE_URL . "index.php/register/users/event=new" ?>">Create Account</a><br/>
	<strong>To browse our course catalog</strong>, click below.
	<br/>
	<a href="<?= BASE_URL . "index.php/welcome/catalog" ?>">Course Catalog</a><br/>
	<br/>
	<br/>
	<?PHP } ?>

	<p style="clear:both;">&nbsp;</p>
	Choose your language (new, not completed):<br/>
	<a href="?switchlocale=en_US">English (US)</a>
	<a href="?switchlocale=es_MX">Spanish (MX)</a>
	<a href="?switchlocale=zh_CN">Chinese (PRC)</a>
	<a href="?switchlocale=ru_RU">Russian</a>
	<a href="?switchlocale=ja_JP">Japanese</a>

	<p>&nbsp;</p>
</div>
</td>
</tr>
</table>

</form>


<a href="http://sourceforge.net/projects/logicampus/"> <img src="http://sourceforge.net/sflogo.php?group_id=95474&amp;type=4" border="0" alt="SourceForge.net Logo" /></a>

</div>
</center>

</BODY>
</HTML> 
