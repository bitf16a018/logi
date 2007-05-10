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
<?=$t['toptitle'];?>
</td>
</tr>
</table>





<table width='100%'>
<tr>
<td valign='top' width='140'>
<a href="<?=BASE_URL?>"><img src="<?=IMAGES_URL;?>lc-logo.gif" alt="LogiCreate Demo" border="0" hspace='5' vspace='5' /></a>
	<table class='sidebar' border='0' cellpadding='4' cellspacing='0'>
		<tr>
		      <td valign="top" width="140" class="leftnav">
		      <?=$t['menu'];?>
		      <? while ( list($k,$m) = @each($obj->menu)) print $m->toHTML();?>
		      </td>
		</tr>
	</table>
</td>
<td width='15'>&nbsp;</td>
<td valign='top'>






