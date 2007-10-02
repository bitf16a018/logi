<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en-AU">
  <head>
    <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
    <meta name="author" content="haran" />
    <meta name="generator" content="author" />
    <meta name="keywords" content="distance learning, LogiCampus, courseware, e-learning, course management, LMS, CMS, classroom, grade book, online" />

    <!-- Navigational metadata for large websites (an accessibility feature): -->
    <link rel="top"      href="./index.html" title="Homepage" />
    <link rel="up"       href="./index.html" title="Up" />
    <link rel="first"    href="./index.html" title="First page" />
    <link rel="previous" href="./index.html" title="Previous page" />
    <link rel="next"     href="./index.html" title="Next page" />
    <link rel="last"     href="./index.html" title="Last page" />
    <link rel="toc"      href="./index.html" title="Table of contents" />
    <link rel="index"    href="./index.html" title="Site map" />

    <link rel="stylesheet" type="text/css" href="<?=TEMPLATE_URL;?>sinorca-screen.css" media="screen" title="Sinorca (screen)" />
    <link rel="stylesheet" type="text/css" href="<?=TEMPLATE_URL;?>calendar.css"  media="screen" title="Sinorca (screen)" />
    <link rel="stylesheet" type="text/css" href="<?=TEMPLATE_URL;?>datagrid.css"  media="screen" title="Sinorca (screen)" />
    <link rel="stylesheet alternative" type="text/css" href="<?=TEMPLATE_URL;?>sinorca-screen-alt.css" media="screen" title="Sinorca (alternative)" />
    <link rel="stylesheet" type="text/css" href="<?=TEMPLATE_URL;?>sinorca-print.css" media="print" />

    <script type="text/javascript" src="<?=BASE_URL;?>htmlarea/htmlarea.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>htmlarea/htmlarea-lang-en.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>htmlarea/dialog.js"></script>
    <script type="text/javascript" src="<?=BASE_URL;?>htmlarea/popupwin.js"></script>

    <style type="text/css">
	@import url(<?=BASE_URL;?>htmlarea/htmlarea.css);
    </style>


    <title>LogiCampus</title>
  </head>

  <body>
    <!-- For non-visual user agents: -->
      <div id="top"><a href="#main-copy" class="doNotDisplay doNotPrint">Skip to main content.</a></div>

    <!-- ##### Header ##### -->

    <div id="header">
      <!--
      <div class="superHeader">
        <div class="left">
          <span class="doNotDisplay">Related sites:</span>
          <a href="./index.html">Link 1</a> |
          <a href="./index.html">Link 2</a>
        </div>
        <div class="right">
          <span class="doNotDisplay">More related sites:</span>
          <a href="./index.html">Link 3</a> |
          <a href="./index.html">Link 4</a> |
          <a href="./index.html">Link 5</a> |
          <a href="./index.html">Link 6</a> |
          <a href="./index.html">Link 7</a>
        </div>
      </div>
	  -->

      <div class="midHeader">
        <h1 class="headerTitle">LogiCampus</h1>
      </div>

      <div class="subHeader">
        <span class="doNotDisplay">Navigation:</span>

	<a title="Home" href="<?=appurl('');?>"><?=lct('Home Page')?></a> |
	<a title="questions" href="<?=appurl('faq/')?>"><?=lct('FAQs')?></a> |
	<a title="calendar" href="<?=appurl('mastercalendar/')?>"><?=lct('Calendar')?></a> |
	<a title="help" href="<?=appurl('helpdesk/')?>"><?=lct('Help Desk')?></a> |
	<a title="messages" style="color: white;" href="<?=APP_URL?>pm/"><?=lct('Messages')?> [<?=(int)$t['_privMsgs']?>]</a>

	<?
		if (!$obj->user->isAnonymous() ) {
	?>
	| <a href="<?=appurl('login/out/');?>"><?=lct('Logout')?></a>
	<?php
		}
	?>

      </div>
    </div>

    <!-- ##### Side Bar ##### -->

    <div style="min-height:92%" id="side-bar">
      <div>
	<?php
		if ($t['_classesTaught'] != '') { 
	?>
        	<p class="sideBarTitle"><?=lct('Classroom Manager')?></p>
		<a class="menuitem" href="<?=APP_URL?>classmgr"><?=lct('Faculty Overview')?></a>
		<ul>
	<?php
		foreach($obj->user->classesTaught as $k => $v )
		{
			echo '<li><a class="menuitem" href="'.APP_URL.'classmgr/display/id_classes='.$v->id_classes.'">&rsaquo;&nbsp;'.$v->courseFamily.$v->courseNumber.' ('.$v->semesterID.')</a>';
			echo '<a class="menuitem" href="'.APP_URL.'gradebook/main/id_classes='.$v->id_classes.'">&nbsp;&nbsp;&rsaquo;&nbsp;'.lct('Gradebook').'</a></li>';
		}
	?>
		</ul>
	<?php

		}
	?>
      </div>


      <div>
	<?php
		if ($t['_classesTaken'] != '') { 
	?>
        	<p class="sideBarTitle"><?=lct('My Classes')?></p>
		<a class="menuitem" href="<?=appurl('classroom/')?>"><?=lct('Classroom Portal');?></a>
		<ul>
	<?php

		foreach($obj->user->classesTaken as $k => $v ) {
			if ($v->semesterID) { 
			echo '<li><a class="menuitem" href="'.APP_URL.'classroom/details/id_classes='.$v->id_classes.'">&raquo;&nbsp;'.$v->courseFamily.$v->courseNumber.' ('.$v->semesterID.')</a>';
			} else { 
			echo '<li><a class="menuitem" href="'.APP_URL.'classroom/details/id_classes='.$v->id_classes.'">&raquo;&nbsp;'.$v->courseFamily.$v->courseNumber.'</a>';
			}
			echo '<a class="menuitem" href="'.APP_URL.'classroom/gradebook/id_classes='.$v->id_classes.'">&nbsp;&nbsp;&raquo;&nbsp;'.lct('Gradebook').'</a></li>';
		}
	?>
		</ul>
	<?php

		}
	?>
      </div>


      <div class="lighterBackground">
       	<p class="sideBarTitle"><?=lct('Member Services')?></p>
<?php
		menuObj::getCachedById('memberservices', $obj->user->groups,true);
?>
      </div>
<?php
     if($obj->user->isAdmin()) {
?>
      <div style="min-height:80%;">
	<p class="sideBarTitle">
<?php
		menuObj::getCachedById('administration', $obj->user->groups);
?></p>
      </div>

<?php
	}
?>

<!--
      <div class="lighterBackground">
        <p class="sideBarTitle">Alternative stylesheet</p>
        <span class="sideBarText">
          Sinorca contains an alternative stylesheet that renders this side bar differently.
        </span>
        <span class="sideBarText">
          To view the alternative stylesheet in (certain)
          <span class="titleTip" title="eg: Mozilla, Camino, Netscape 6+">Gecko-based browsers</span>,
          select <em>Sinorca (alternative)</em> from the <em>View</em> &rsaquo; <em>Use Style</em>
          submenu.
        </span>
      </div>
    
-->
<!--
      <div>
        <p class="sideBarTitle">Validation</p>
        <span class="sideBarText">
          Validate the <a href="http://validator.w3.org/check/referer">XHTML</a> and
          <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> of this page.
        </span>
      </div>
-->
    </div>

    <!-- ##### Main Copy ##### -->

    <div id="main-copy">

<?php 
	$sysMessages = $obj->user->getSessionMessages();
	if ( count($sysMessages) ) {
		foreach ($sysMessages as $msgType => $msgText) {
			echo lcMessageBox($msgText, $msgType);
		}
	}

	if (isset($t['_newPrivMsgs'])) {  
		echo lcMessageBox('Someone sent you a new private message.  Do you want to read them?  <a href="'.appurl('pm').'">Yes, take me to my private messages.</a>','q');
	} 
?>
