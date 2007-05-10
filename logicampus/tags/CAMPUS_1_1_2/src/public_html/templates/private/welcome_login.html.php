<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<HTML>
<HEAD>

	<TITLE><?=$t['title']?></TITLE>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta http-equiv="keywords" content="">
	<meta http-equiv="description" content="">

	<link rel="stylesheet" type="text/css" href="<?=TEMPLATE_URL.'/'.$t['cssFile'];?>">

<? if (trim($obj->user->activeClassTaken->stylesheet) != '' && $this->module == 'classroom') { ?>
	<link rel="stylesheet" type="text/css" href="<?=BASE_URL. 'templates/student/';?><?=$obj->user->activeClassTaken->stylesheet;?>">
<? } ?>

	<script type="text/javascript" src="<?=BASE_URL;?>htmlarea/htmlarea.js"></script>
	<script type="text/javascript" src="<?=BASE_URL;?>htmlarea/htmlarea-lang-en.js"></script>
	<script type="text/javascript" src="<?=BASE_URL;?>htmlarea/dialog.js"></script>
	<script type="text/javascript" src="<?=BASE_URL;?>htmlarea/popupwin.js"></script>
	<script type="text/javascript" src="<?=BASE_URL;?>htmlarea/custom.js"></script>
	<style type="text/css">
		@import url(<?=BASE_URL;?>htmlarea/htmlarea.css);
		.r_wrapper
		{
		float:right;width:47%;text-align:top;
		}

		.l_wrapper
		{
		float:left;width:47%;text-align:top;
		}

		.box_standard
		{
		margin-bottom:1em;padding:.5em;background-color:#f7f7f7;border:1px solid silver;
		}
	</style>
</HEAD> 
 
<BODY bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" link="#0066FF">

	<style type="text/css">

  td.end_cap {
		background:url("<?=TEMPLATE_URL?>images/tab-end-cap-bg.png")
		no-repeat left top #900;
		font-weight:bold;
		font-variant:small-caps;
		padding:0px 0px 0px 0px;
  }

  table.main {
    border: solid;
    border-color: #003366;
    border-width: 1px;
  }

	#tabs table tr td {
		color:white; 
		background:url("<?=TEMPLATE_URL?>images/tab-stop.png")
		no-repeat right top #036;
		padding:0px 0px 0px 7px;
		}

	#tabs table tr td.end_cap {
		background:url("<?=TEMPLATE_URL?>images/tab-end-cap-bg.png")
		no-repeat left top #900;
		font-weight:bold;
		font-variant:small-caps;
		padding:0px 0px 0px 0px;
	}



</style>

<center>
<div id="colored">
<br /><br />
<table width="400" border="0" cellspacing="0" class="main">
<tr>
  <td colspan="2">
			<a href="<?=APP_URL;?>"><img src="<?=TEMPLATE_URL;?>images/logo.png" alt="Logi-Campus" border="0"/></a>
  </td>
</tr>
<tr bgcolor="#003366">
  <td>&nbsp;</td>
  <td align="right" class="end_cap">
    &nbsp;
  </td>
</tr>
<form id="login" method="post" action="<?=APP_URL?>login/main/">
<tr>
  <td colspan="2">
<br />
<table width="100%">
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
</form>
<tr>
  <td colspan="2" align="right" class="blue">
    LogiCampus <?=LOGICAMPUS_VERSION.LOGICAMPUS_VERSION_STATUS?> </td>
<tr>
<tr>
<td colspan="2">
<strong>IMPORTANT</strong>
<p>
The system only allows one login of each username at one time.  Therefore, you may experience disruption in your demo as other people login to the system.  If the system says you don't have permission to do something, this may be because you have been logged out as someone else logs in with the same username.
</p>

<strong>Login Information</strong><br>
LogiCampus works differently depending on which user you log in as.  
Here are three different logins you can use:


<div class="l_wrapper">
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
	<a href="#" onclick="loginAs('nelson.muntz','nelson.muntz');return false;" >login as...</a>
	<br>
	Login: nelson.muntz<br>
	Password: nelson.muntz<br>

	<strong>Student:</strong>
	<a href="#" onclick="loginAs('bart.simpson','bart.simpson');return false;" >login as...</a>
	<br>
	Login: bart.simpson<br>
	Password: bart.simpson<br>
</fieldset>
</div>

<div class="r_wrapper">
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
If you are using MAC OS X or Linux, we suggest using Mozilla 1.3 or higher (1.5 recommended).</td>
</tr>
</table>
</div>
<br />
<a href="<?=APP_URL?>welcome/about">[HOW TO USE THIS DEMO]</a>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<a href="http://sourceforge.net/projects/logicampus/"> <img src="http://sourceforge.net/sflogo.php?group_id=95474&amp;type=4" border="0" alt="SourceForge.net Logo" /></a>





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
