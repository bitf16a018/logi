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
<form method="post" action="<?=APP_URL?>login/main/">
<tr>
  <td colspan="2">
<br />
<table width="100%">
<tr>
  <td width="50%" align="right"><b><?=lct('username')?>:</b></td>
  <td width="50%"><input type="text" size="15" maxlength="32" name="username" value="teacher" /></td>
</tr>
<tr>
  <td width="50%" align="right"><b><?=lct('password')?>:</b></td>
  <td width="50%"><input type="password" size="15" maxlength="32" name="password" value="teacher" /></td>
</tr>
<tr>
  <td colspan="2" align="center">
    <input type="hidden" name="event" value="login"/>
    <input type="submit" value="<?=lct('Login')?>"/>
  </td>
</tr>
</table>

<br />
  </td>
</tr>
</form>
<tr>
  <td colspan="2" align="right" class="blue">
    LogiCampus <?=LOGICAMPUS_VERSION?>-<?=LOGICAMPUS_VERSION_STATUS?> </td>
<tr>

</table>
</div>
<br />
<a href="<?=APP_URL?>welcome/about">[ABOUT THIS DEMO]</a>
<p>&nbsp;</p>

Choose your language:<br/>
<a href="?switchlocale=en_US">English (US)</a>
<a href="?switchlocale=es_MX">Spanish (MX)</a>
<a href="?switchlocale=zh_CN">Chinese (PRC)</a>
</center>
<script language="JavaScript">
	document.forms[0].elements[0].focus();
</script>


</BODY>
</HTML> 
