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
	
	<style type="text/css">
		@import url(<?=BASE_URL;?>htmlarea/htmlarea.css);
	</style>
</HEAD> 
 
<BODY bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" link="#0066FF">



<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" height="18" background="<?=TEMPLATE_URL;?>images/stripes.png">
		</td>
	</tr>
	<tr>
		<td width="350" height="81">
			<a href="<?=APP_URL;?>"><img align="right" src="<?=TEMPLATE_URL;?>images/logo.png" alt="Logi-Campus" border="0"/></a>
		</td>
		<td>
			<br/>
			<img src="<?=TEMPLATE_URL;?>images/tagline.png" alt="Open Source Educational Platform from Tap Internet, Inc." border="0"/>
		</td>
	</tr>
</table>

<!-- these need to be in here to get URLs parsed -->
<style type="text/css">
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


<div id="tabs">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="170" height="20" class="home">
			<a alt="Home" href="<?=appurl('');?>"><img src="<?=TEMPLATE_URL;?>images/menu-widget.png" height="16" border="0" alt="" /><?=lct('Home Page')?></a>
		</td>

		<td NOWRAP><a href="<?=appurl('faq/')?>"><?=lct('FAQs')?></a></td>
		<td NOWRAP><a href="<?=appurl('mastercalendar/')?>"><?=lct('Calendar')?></a></td>
		<td NOWRAP><a href="<?=appurl('helpdesk/')?>"><?=lct('Help Desk')?></a></td>

		<td class="last_tab" NOWRAP>
			<a style="color: white;" href="<?=APP_URL?>pm/"><?=lct('Messages')?>[<?=(int)$t['_privMsgs']?>]</a>&nbsp;&nbsp;
		</td>
		<td class="end_cap" background="<?=TEMPLATE_URL?>images/tab-end-cap-bg.png" width="250" valign="top">
			<img src="<?=TEMPLATE_URL?>images/tab-end-cap.png" border="0" style="float:left;">
		</td>
		<td class="end_cap"></td>
	</tr>
</table>
</div>

<!-- below this line is still tarrant -->

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="150" height="20" valign="top" bgcolor="#EFEFEF">
			<div id="menu">


			<table width="100%" cellspacing="0" cellpadding="0">
			<tr><td>

			<?
		 	if ($obj->user->username != 'anonymous')
			{ ?>
			<p>
			<div style="color:#036;font-weight:bold;"><?=lct('welcome',array('name'=>$obj->user->profile->values['firstname'])) ?></div>
			</p>

			<p>
			<a href="<?=appurl('login/out/');?>"><?=lct('Logout')?></a>
			</p>
			</td></tr>
			</table>
			<br/>

			<? } else { ?>
			<p>
				<form method="POST" action="<?=APP_URL?>login/main">
				<strong><?=lct('username')?>:</strong><br/>
				 <input type="text" size="10" maxlength="32" name="username" />
				 <br/>
				<strong><?=lct('password')?>:</strong><br/> 
				 <input type="password" size="10" maxlength="32" name="password" /><br>
				<input type="hidden" name="event" value="login"/>
				<input type="submit" value="<?=lct('Login')?>"/>
				</form>
			</td></tr>
			</table>
			<br/>
			
			<?
			}
			/* Display facutly classes they teach */
			if ($t['_classesTaught'] != '') { ?>
	<table border="0" width="100%" class="menutable" cellpadding="0" cellspacing="0">
		<tr><td NOWRAP class="menu_head"><b><?=lct('classroom manager')?></b></td></tr>
		<tr><td NOWRAP class="menu_item"> <?=$t['_classesTaught']?></td></tr>
	</table>
<p>
			<? } 

			if ($t['_classesTaken']) { ?>
	<table border="0" width="100%" class="menutable" cellpadding="0" cellspacing="0">
		<tr><td NOWRAP class="menu_head"><b><?=lct('my classes')?></b></td></tr>
		<tr><td NOWRAP class="menu_item"><?=$t['_classesTaken'];?></td></tr>
	</table>
<p>
			<? } 
			#menuObj::getCachedById('faculty', $obj->user->groups);
			menuObj::getCachedById('memberservices', $obj->user->groups);
			menuObj::getCachedById('main', $obj->user->groups);
			menuObj::getCachedById('administration', $obj->user->groups);
			?>
			</div>


			</td>
			<td height="20" valign="top" bgcolor="#FFFFFF">

		
			<table cellpadding="15" cellspacing="0" border="0" width="100%">
			<tr>
				<td>
					
					<table bgcolor="#FFFFFF" class="content" cellpadding="12" cellspacing="0" width="100%">
					<tr>
						<td class="content">	


