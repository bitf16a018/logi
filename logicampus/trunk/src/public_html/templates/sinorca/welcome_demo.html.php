<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<HTML>
<HEAD>

	<TITLE>LogiCampus</TITLE>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta http-equiv="keywords" content="">
	<meta http-equiv="description" content="">

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
<BODY bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" link="#0066FF">

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
	<strong>IMPORTANT</strong>
	<p>
	The system only allows one login of each username at one time.  Therefore, you may experience disruption in your demo as other people login to the system.  If the system says you don't have permission to do something, this may be because you have been logged out as someone else logs in with the same username.
	</p>
	<?PHP if(MODULE_REGISTRATION) { ?>
	<strong>To create your own student login</strong>, click below<BR>
	<a href="<?= BASE_URL . "index.php/register/users/event=new" ?>">Create Account</a><br><br>
	<?PHP } ?>
	<strong>Login Information</strong><br>
	LogiCampus works differently depending on which user you log in as.  
	Here are three different logins you can use:


	<div style="float:left;width:47%;text-align:top;">
		
	<fieldset class="box_standard">
		<legend>Staff</legend>
		<strong>Administrator</strong>
		<a href="#" onclick="loginAs('admin','admin');return false;" >login as...</a>
		<br>
		Login: admin<br>
		Password: admin<br>
	</fieldset>

	<br/>


	<fieldset class="box_standard">
		<legend>Students</legend>
		<strong>Student:</strong>
		<a href="#" onclick="loginAs('student1','student1');return false;" >login as...</a>
		<br>
		Login: student1<br>
		Password: student1<br>

		<strong>Student:</strong>
		<a href="#" onclick="loginAs('student2','student2');return false;" >login as...</a>
		<br>
		Login: student2<br>
		Password: student2<br>

		<strong>Student:</strong>
		<a href="#" onclick="loginAs('student3','student3');return false;" >login as...</a>
		<br>
		Login: student3<br>
		Password: student3<br>

	</fieldset>
	</div>

	<div style="float:right;width:47%;text-align:top;">
	<fieldset class="box_standard">
		<legend>Faculty</legend>
		<strong>Teacher:</strong>
		<a href="#" onclick="loginAs('teacher1','teacher1');return false;" >login as...</a>
		<br>
		Login: teacher1<br>
		Password: teacher1<br>

		<strong>Teacher:</strong>
		<a href="#" onclick="loginAs('teacher2','teacher2');return false;" >login as...</a>
		<br>
		Login: teacher2<br>
		Password: teacher2<br>
	</fieldset>
	</div>

	<p style="clear:both;">&nbsp;</p>
	Choose your language (new, not completed):<br/>
	<a href="?switchlocale=en_US">English (US)</a>
	<a href="?switchlocale=es_MX">Spanish (MX)</a>
	<a href="?switchlocale=zh_CN">Chinese (PRC)</a>

	<p>&nbsp;</p>

	<strong>Requirements</strong><br>
	If you are using Windows, in order to use the content editor that is built in, you must be running either IE version 5.5 or higher.
	<br><br>
	If you are using MAC OS X or Linux, we suggest using Mozilla 1.3 or higher (1.5 recommended).
</div>
</td>
</tr>
</table>

</form>


<br />
<a href="<?=APP_URL?>welcome/about">[HOW TO USE THIS DEMO]</a>
<br />
<br />
<br />
<br />
<br />
<br />
<a href="http://sourceforge.net/projects/logicampus/"> <img src="http://sourceforge.net/sflogo.php?group_id=95474&amp;type=4" border="0" alt="SourceForge.net Logo" /></a>

</div>
</center>
<script language="JavaScript">
	document.forms[0].elements[0].focus();

	function loginAs(user,pass) {
		document.getElementById('login_name').value = user;
		document.getElementById('login_passwd').value = pass;
		document.getElementById('login').submit();
	}
</script>


</BODY>
</HTML> 
