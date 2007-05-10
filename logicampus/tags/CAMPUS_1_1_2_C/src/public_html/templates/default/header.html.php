<DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
        <title><?=$t['title']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="keywords" content="">
<meta http-equiv="description" content="">
<link rel="stylesheet" type="text/css" href="<?=TEMPLATE_URL.'/'.$t['cssFile'];?>">
</head>
<body leftmargin="0" topmargin="20" marginwidth="0" marginheight="30">

<table class='maintable' cellspacing="0" width="80%" align='center'>
	<tr><td width="100%">

<table width='100%' class='toptable'>
<tr>
<td valign='top' width='100%'>
<a href="<?=BASE_URL;?>">HOME</a> | 
<a href="<?=appurl('search');?>">SEARCH</a> | 
<? if ( ($obj->user->username!='anonymous') && ($obj->user->username!='')) { ?> 
	Welcome <?=$obj->user->username;?>! (<a href="<?=appurl('login/out');?>">LOGOUT</a>)
<? } else { ?>
	<a href="<?=appurl('login');?>">LOGIN / REGISTER</a>
<? } ?>
</td>
</tr>
</table>




<table width='100%'>
<tr>
<td valign='top' width='140'>
<a href="<?=BASE_URL?>"><img src="<?=TEMPLATE_URL;?>images/lc-logo.gif" alt="LogiCreate Demo" border="0" hspace='5' vspace='5' /></a>
	<table class='sidebar'>
		<tr>
		      <td valign="top" width="140" class="leftnav">
		      <? while ( list($k,$m) = @each($obj->menu)) print $m->toHTML();?>
		      </td>
		</tr>
	</table>
</td>
<td width='15'>&nbsp;</td>
<td valign='top'>





	<? if ($t['lc_message']) { ?>
	  <!-- div layover for messages should go here -->
	  <div class="notice" id="lc_warning">
		  <div style="float:right;margin-right:5px;border-width:2px;border-style:solid;margin-top:3px;"
			  onclick="document.getElementById('lc_warning').style.visibility='hidden';">X</div>
			<b><?= $t['lc_message'];?></b>
			<br/>
			<?= $t['lc_message_details'];?>
		  <br/>
		  <br/>
	  </div>
	<? } ?>

	<? if ($t['lc_warning']) { ?>
	  <!-- div layover for messages should go here -->
	  <div class="warning" id="lc_warning">
		  <div style="float:right;margin-right:5px;border-width:2px;border-style:solid;margin-top:3px;"
			  onclick="document.getElementById('lc_warning').style.visibility='hidden';">X</div>
			<b><?= $t['lc_warning'];?></b>
			<br/>
			<?= $t['lc_warning_details'];?>
		  <br/>
		  <br/>
	  </div>
	<? } ?>

