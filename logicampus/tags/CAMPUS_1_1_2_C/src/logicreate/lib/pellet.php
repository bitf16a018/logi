<?php
include_once(LIB_PATH."classObj.php");
include_once(SERVICE_PATH.'menu/menuObj.php');

	/**
	 * abstract class. <br>
	 * Do not create a new Service object directly,
	 * subclass it and flesh out the abstract methods.
	 * This class provides a common templating system for
	 * other sublcasses.  
	 * @abstract
	 */
class Service {

	var $logUsage = true;

	/**
	 * @abstract 
	 */
	function run($db,$u,$arg,&$t){}

	/**
	 * @abstract 
	 */
	function template($lcObj,$lcTempl){}

	/**
	 * @abstract 
	 */
	function authorize($lcObj,$lcUser) {}


	/**
	 * @static 
	 */
	function throwError($errormessage) {
			$t = $lcTemplate;
			global $lcUser;
			if (is_array($t)) {
				extract($t);
			}
		print $errormessage;
		closepage();
		exit();
	}



	// CONTENT HANDLERS



	function htmlPresentation (&$obj,&$t) {
		//put the template and content together to form a 
		// basic html page
			include_once(TEMPLATE_PATH."header.html.php");
			include_once($obj->module_root."templates/".$obj->templateName.".html");
			include_once(TEMPLATE_PATH."footer.html.php");
	}



	function printPresentation (&$obj,&$t) {
		//put the template and content together to form a 
		// basic html page
			include_once(TEMPLATE_PATH."print-header.html.php");
			include_once($obj->module_root."templates/".$obj->templateName.".html");
			include_once(TEMPLATE_PATH."print-footer.html.php");
	}


	function errorMessage (&$obj,&$t) {
			include_once(TEMPLATE_PATH."header.html.php");
			print "<h3>Error:</h3> \n\n ".$t[message]." <p>\n".$t[details];
			include_once(TEMPLATE_PATH."footer.html.php");
	}


	function emptyPresentation (&$obj,&$t) {
		include_once($obj->module_root."templates/".$obj->templateName.".html");
	}


	function preTemplate(&$obj,&$t){
	}


	//__FIXME__
	function buildNavLinks() {

		if ( !is_array($this->navlinks) ) return;
		$newlinks = array();
		while ( list ($k,$v) = each($this->navlinks) ) {
			$newlinks[ lct($k) ] = $v;
		}

		$this->navlinks = $newlinks;
	}

	//__FIXME__
	function buildAppLinks() {

		if ( !is_array($this->navlinks) ) return;
		$newlinks = array();
		while ( list ($k,$v) = each($this->navlinks) ) {
			$newlinks[ lct($k) ] = $v;
		}

		$this->navlinks = $newlinks;
	}
}



/**
 * supplies basic 'access' check for modules
 * @abstract
 */
class BasicAuth extends Service {

	var $authorizer = 'BasicAuth';
	var $navlinks = array();
	var $applinks = array();
	var $inactivelinks = array();
	var $sectionTitle = '';

	function preTemplate (&$obj,&$t) {

		//__FIXME__ translation
		$this->buildNavLinks();
		$this->buildAppLinks();

		$t['sectionheader']  = '<table style="font-weight:bold;" width="100%" border=0 cellpadding=3 cellspacing=0><tr><td><big>'.$this->sectionTitle.'</big>';
		$t['sectionheader'] .= '</td></tr></table>';

		if ( count($this->navlinks) > 0 ) {
			$t['sectionheader']  .= '<div id="sectionheader">';
			while ( list($k,$v) = @each($this->navlinks) ) {

				if (in_array($k, $this->inactivelinks)) {
					$t['sectionheader'] .= '<b><a href="'.$link.'">'.$k.'</a></b> &bull; ';
				} else {
					if (preg_match('/^%/', $v)) {
						$link = appurl(preg_replace('/^%/', '', $v));
					} else {
						$link = modurl($v);
					}
					$t['sectionheader'] .= '<a href="'.$link.'">'.$k.'</a> &bull; ';
				}

			}
			if (count($this->navlinks)) $t['sectionheader'] = substr($t['sectionheader'],0,-8);
			$t['sectionheader']  .= '</div>';
		}

		if ( count($this->applinks) > 0 ) {
			$t['sectionheader'] .= '<div id="applinks"><b class="title">Application Links:</b>&nbsp;&nbsp;';
			while ( list($k,$v) = @each($this->applinks) ) {
				if (in_array($k, $this->inactivelinks)) {
				$t['sectionheader'] .= '<b><a href="'.$link.'">'.$k.'</a></b> &bull; ';
				} else {
					if (preg_match('/^%/', $v)) {
						$link = appurl(preg_replace('/^%/', '', $v));
					} else {
						$link = modurl($v);
					}
					$t['sectionheader'] .= '<a href="'.$link.'">'.$k.'</a> &bull; ';
				}
			}
			$t['sectionheader'] = substr($t['sectionheader'],0,-8);
			$t['sectionheader'] .= '</div>';
		}
		$t['sectionheader'] .= '<div style="margin:5px;"></div>';
	}

}



/**
 * Checks if a user is logged in and registered with the site (has a username)
 * @abstract
 */
class RegAuth extends Service {

	function authorize(&$lc,&$u) {
		if ($u->username == "anonymous" || $u->username == "") {
		return false;
		}
	return true;
	}

	function preTemplate (&$obj,&$t) {

		//__FIXME__ translation
		$this->buildNavLinks();
		$this->buildAppLinks();

		$t['sectionheader']  = '<table style="font-weight:bold;" width="100%" border=0 cellpadding=3 cellspacing=0><tr><td><big>'.$this->sectionTitle.'</big>';
		$t['sectionheader'] .= '</td></tr></table>';

		if ( count($this->navlinks) > 0 ) {
			$t['sectionheader']  .= '<div id="sectionheader">';
			while ( list($k,$v) = @each($this->navlinks) ) {

				if (in_array($k, $this->inactivelinks)) {
					$t['sectionheader'] .= "<b>$k</b>".' &bull; ';
				} else {
					if (preg_match('/^%/', $v)) {
						$link = appurl(preg_replace('/^%/', '', $v));
					} else {
						$link = modurl($v);
					}
					$t['sectionheader'] .= '<a href="'.$link.'">'.$k.'</a> &bull; ';
				}

			}
			if (count($this->navlinks)) $t['sectionheader'] = substr($t['sectionheader'],0,-8);
			$t['sectionheader']  .= '</div>';
		}

		if ( count($this->applinks) > 0 ) {
			$t['sectionheader'] .= '<div id="applinks"><b class="title">Application Links:</b>&nbsp;&nbsp;';
			while ( list($k,$v) = @each($this->applinks) ) {
				if (in_array($k, $this->inactivelinks)) {
					$t['sectionheader'] .= "<b>$k</b>".' &bull; ';
				} else {
					if (preg_match('/^%/', $v)) {
						$link = appurl(preg_replace('/^%/', '', $v));
					} else {
						$link = modurl($v);
					}
					$t['sectionheader'] .= '<a href="'.$link.'">'.$k.'</a> &bull; ';
				}
			}
			$t['sectionheader'] = substr($t['sectionheader'],0,-8);
			$t['sectionheader'] .= '</div>';
		}
		$t['sectionheader'] .= '<div style="margin:5px;"></div>';
	}
	
}


/**
 * Checks if a user is in one of the default groups called 'admin'
 * @abstract
 */
class AdminAuth extends Service {

	function authorize (&$obj,&$u) {
		if ( @in_array('admin',$u->groups) ) {
			return true;
		}
	return false;
	}

}


/**
 * Uses HTTP headers for authentication, challenge with 401 if incorrect
 * @abstract
 */
class HercAuth extends Service {
	function authenticate(&$obj,&$u) {
		global $HTTP_SERVER_VARS;

		if ( (HERC_USER == '') || (HERC_PASSWD == '') ){
			echo "No user/password defined.<br>\n";
			echo "Follow the setup instructions.\n";
			exit();
		}

		if ( PASSWD_IS_MD5) $HTTP_SERVER_VARS['PHP_AUTH_PW'] = md5($HTTP_SERVER_VARS['PHP_AUTH_PW']);
		if ( $HTTP_SERVER_VARS['PHP_AUTH_USER'] == HERC_USER and $HTTP_SERVER_VARS['PHP_AUTH_PW'] == HERC_PASSWD) {
			return true;
		}
		return false;
	}


	function authorize (&$obj,&$u) {
		global $HTTP_SERVER_VARS;

		if ( (HERC_USER == '') || (HERC_PASSWD == '') ){
			echo "No user/password defined.<br>\n";
			echo "Follow the setup instructions.\n";
			exit();
		}

		if ( PASSWD_IS_MD5) $HTTP_SERVER_VARS['PHP_AUTH_PW'] = md5($HTTP_SERVER_VARS['PHP_AUTH_PW']);
		if ( $HTTP_SERVER_VARS['PHP_AUTH_USER'] == HERC_USER and $HTTP_SERVER_VARS['PHP_AUTH_PW'] == HERC_PASSWD) {
			return true;
		}
		return false;
	}

}



/**
 * No security at all
 * @abstract
 */
class NoAuth extends Service {
	function authorize (&$lc,&$u) {
		return true;
	}
}


/**
 * Provides direct permission => event access mapping
 *
 * Assumes that every event to the subclassed module will have
 * a corresponding permission assigned to it with the same name.
 * Function level permissions can then be applied from the back end.
 * Drawback, doesn't take into account the specific Service + function name.
 */
class FuncMapAuth extends Service {
	function authorize (&$obj,&$u) {
		$obj->postvars[event] == '' ? $event = $obj->getvars[event] : $event = $obj->postvars[event];

		if ($event == '') return true;

		if ( @in_array($event,$u->perms) ) {
			return true;
		} else {
			return false;
		}
	}
}


/**
 * Every service that responds
 */
class AdminService extends Service {

	var $authorizer = 'adminAuth';
	var $navlinks = array();
	var $applinks = array();
	var $inactivelinks = array();
	var $sectionTitle = 'Admin Links';


	/**
	 * constructor
	 * globalize LC
	 * check lc->getvars for id_classes
	 * if different from $u->activeClassTaught load the new class into activeClass
	 */
	function AdminService() {
		global $lcObj;
		global $lcUser;

		$lcObj->templateStyle = 'private';
	}


	function preTemplate (&$obj,&$t) {

		//__FIXME__ translation
		$this->buildNavLinks();
		$this->buildAppLinks();

		$t['sectionheader']  = '<table style="font-weight:bold;" width="100%" border=0 cellpadding=3 cellspacing=0><tr><td><big>'.$this->sectionTitle.'</big>';
		$t['sectionheader'] .= '</td></tr></table>';
		$t['sectionheader']  .= '<div id="sectionheader">';
		while ( list($k,$v) = @each($this->navlinks) ) {

			if (in_array($k, $this->inactivelinks)) {
				$t['sectionheader'] .= "<b>$k</b>".' &bull; ';
			} else {
				if (preg_match('/^%/', $v)) {
					$link = appurl(preg_replace('/^%/', '', $v));
				} else {
					$link = modurl($v);
				}
				$t['sectionheader'] .= '<a href="'.$link.'">'.$k.'</a> &bull; ';
			}

		}
		$t['sectionheader'] = substr($t['sectionheader'],0,-8);
		$t['sectionheader']  .= '</div>';
		if ( count($this->applinks) > 0 ) {
			$t['sectionheader'] .= '<div id="applinks"><b class="title">Application Links:</b>&nbsp;&nbsp;';
			while ( list($k,$v) = @each($this->applinks) ) {
				if (in_array($k, $this->inactivelinks)) {
					$t['sectionheader'] .= "<b>$k</b>".' &bull; ';
				} else {
					if (preg_match('/^%/', $v)) {
						$link = appurl(preg_replace('/^%/', '', $v));
					} else {
						$link = modurl($v);
					}
					$t['sectionheader'] .= '<a href="'.$link.'">'.$k.'</a> &bull; ';
				}
			}
			$t['sectionheader'] = substr($t['sectionheader'],0,-8);
			$t['sectionheader'] .= '</div>';
		}
		$t['sectionheader'] .= '<div style="margin:5px;"></div>';
	}
	
}


/**
 * @see facultyOnlyAuth
 */
class FacultyOnlyService extends Service {
	var $authorizer = 'facultyOnlyAuth';
}


/**
 * Every service that responds to faculty needs to subclass this
 */
class FacultyService extends Service {

	var $authorizer = 'FacultyAuth';
	var $navlinks = array();
	var $applinks = array();
	var $inactivelinks = array();
	var $sectionTitle = 'Faculty Links';

	/**
	 * constructor
	 * globalize LC
	 * check lc->getvars for id_classes
	 * if different from $u->activeClassTaught load the new class into activeClass
	 */
	function FacultyService() {
		global $lcObj;
		global $lcUser;
		global $lcTemplate;
		if ( $lcObj->getvars['id_classes']!='' &&
			$lcUser->activeClassTaught->id_classes != $lcObj->getvars['id_classes'] )
		{
			//__FIXME__ add constraint against classesTaught array;

			foreach ( $lcUser->classesTaught as $k => $v) {
				if ($v->id_classes == $lcObj->getvars['id_classes'])
					$lcUser->activeClassTaught = $lcUser->classesTaught[$k];
			}
			reset($lcUser->classesTaught);
		}
		// moved out so that it's always called to avoid caching issues
		// 8/23/03 - mgk
		$lcUser->sessionvars['myClassesMenu'] = menuObj::getStudentMenu($lcUser);
		/*
		print "Debug: active class is ".$lcUser->activeClassTaught->id_classes. "<br />\n";
		print "Debug: classesTaught array is ";

		while ( list($k,$v) = @each($lcUser->classesTaught) ) {
			print "$v->id_classes, ";
		}
//		print "<hr />\n";
		//*/
		$lcObj->templateStyle = 'private';
	}


	function preTemplate (&$obj,&$t) {

		//__FIXME__ translation
		$this->buildNavLinks();
		$this->buildAppLinks();

		if ($obj->getvars['print']) {
			$t['sectionheader']  .= '<h3>'.$this->sectionTitle;
			if ($obj->user->activeClassTaken->courseName)
				$t['sectionheader'] .= ' - '.$obj->user->activeClassTaken->courseName
					.' ('.$obj->user->activeClassTaken->facultyName.')';
			$t['sectionheader'] .= '</h3>';
			return;
		}

		$t['sectionheader']  = '<table style="font-weight:bold;" width="100%" border=0 cellpadding=3 cellspacing=0><tr><td><big>'.$this->sectionTitle.'</big>';
		if ($obj->user->activeClassTaught->courseName)
			$t['sectionheader'] .= '</td><td align="right">'.$obj->user->activeClassTaught->courseName.' ('.$obj->user->activeClassTaught->courseFamily.' '.$obj->user->activeClassTaught->courseNumber.' - '.$obj->user->activeClassTaught->semesterID.') ('.$obj->user->activeClassTaught->facultyName.')';
		$t['sectionheader'] .= '</td></tr></table>';
		if ( count($this->navlinks) > 0 ) {
			$t['sectionheader']  .= '<div id="sectionheader">';
			while ( list($k,$v) = @each($this->navlinks) ) {
				if (in_array($k, $this->inactivelinks)) {
					$t['sectionheader'] .= "<b>$k</b>".' &bull; ';
				} else {
					if (preg_match('/^%/', $v)) {
						$link = appurl(preg_replace('/^%/', '', $v));
					} else {
						$link = modurl($v);
					}
					$t['sectionheader'] .= '<a href="'.$link.'">'.$k.'</a> &bull; ';
				}
			}
			if (count($this->navlinks)) $t['sectionheader'] = substr($t['sectionheader'],0,-8);
			$t['sectionheader']  .= '</div>';
		}

		if ( count($this->applinks) > 0 ) {
			$t['sectionheader'] .= '<div id="applinks"><b class="title">Application Links:</b>&nbsp;&nbsp;';
			while ( list($k,$v) = @each($this->applinks) ) {
				if (in_array($k, $this->inactivelinks)) {
					$t['sectionheader'] .= "<b>$k</b>".' &bull; ';
				} else {
					if (preg_match('/^%/', $v)) {
						$link = appurl(preg_replace('/^%/', '', $v));
					} else {
						$link = modurl($v);
					}
					$t['sectionheader'] .= '<a href="'.$link.'">'.$k.'</a> &bull; ';
				}
			}
			$t['sectionheader'] = substr($t['sectionheader'],0,-8);
			$t['sectionheader'] .= '</div>';
		}
		$t['sectionheader'] .= '<div style="margin:5px;"></div>';
	}



	/**
	 * Allow for the links to be translated
	 */
	function buildNavLinks() {
		$this->navlinks = array (
		lct('Classroom Manager') => '%classmgr/display/',
		lct('Announcements')=>'%classmgr/announcements/',
		lct('Assessment Manager') => '%assessments/',
		lct('Assignments') => '%classmgr/assignmentManage/',
		lct('Content') => '%classmgr/lessonContent/',
		lct('FAQ') => '%classmgr/faq/',
		lct('File Resource Manager') => '%classdoclib/',
		lct('Gradebook') => '%gradebook/',
		lct('Lessons') => '%classmgr/lessonManager/',
		lct('Objectives') => '%classmgr/lessonObjectives/',
		lct('Webliography') => '%classmgr/lessonWebliography/'
		);
	}

}



/**
 * Every service that responds to a student needs to subclass this
 */
class StudentService extends Service {

	var $authorizer = 'studentAuth';
	var $navlinks = array();
	var $applinks = array();
	var $inactivelinks = array();
	var $sectionTitle = 'Student Links';

	// these are the same for all pages
	var	$navlinks = array(
		'Classroom Home' => 'details/',
		'Announcements' => 'announcements/',
		'Assessments' => 'assessments/',
		'Assignments' => 'assignments/',
		'Calendar' => 'classCalendar/',
		'Chat' => 'chat/',
		'Classmates' => 'classmates/',
		'Contact Classmates' => 'contactStudents/',
		'Discussion Board' => '%classforums/',
		'FAQs' => 'faq/',
		'Faculty Profile' => 'facultyProfile/',
		'Gradebook' => 'gradebook/',
		'Lessons' => 'lessons/',
		'Presentations' => 'presentations/',
		'Syllabus' => 'syllabus/',
		'Who\'s Online' => 'online/',
		'Webliography' => 'webliography/',
		'Dictionary / Thesaurus' =>'details/event=showtools'
	);

	/**
	 * constructor
	 * globalize LC
	 * check lc->getvars for id_classes
	 * if different from $u->activeClassTaken load the new class into activeClass
	 */
	function StudentService() {
		global $lcObj;
		global $lcUser;
		global $lcTemplate;

		if ( $lcObj->getvars['id_classes']!='' &&
			$lcUser->activeClassTaken->id_classes != $lcObj->getvars['id_classes'] )
		{
			for ($k=0; $k<count($lcUser->classesTaken); ++$k) {
				$v = $lcUser->classesTaken[$k];
				if ($v->id_classes == $lcObj->getvars['id_classes']) {
					$lcUser->activeClassTaken = $lcUser->classesTaken[$k];
				}
			}
			$lcUser->sessionvars['activeLesson'] = '';
			$lcUser->sessionvars['activeLessonSidebar'] = '';
		}
		// moved this out so that things are still regenerated - 
		// cached menu links to 'dl-qm' were causing HUGE headaches 8/23/03
		// mgk
		$lcUser->sessionvars['myClassesMenu'] = menuObj::getStudentMenu($lcUser);

		#print "Debug: active class taken is ".$lcUser->activeClassTaken->id_classes. "<br />\n";
		#print "Debug: classesTaken array is ";
		#while ( list($k,$v) = @each($lcUser->classesTaken) ) {
		#	print "$v->id_classes, ";
		#}
		#print "<hr />\n";

		$lcObj->templateStyle = 'private';
	}

	function preTemplate(&$obj,&$t) {

		//__FIXME__ translation
		$this->buildNavLinks();
		$this->buildAppLinks();

		if ($obj->getvars['print']) {
			$t['sectionheader']  .= '<h3>'.$this->sectionTitle;
			if ($obj->user->activeClassTaken->courseName)
				$t['sectionheader'] .= ' - '.$obj->user->activeClassTaken->courseName
					.' <br/><a href="'.appurl('pm/main/event=compose/sendto='.$obj->user->activeClassTaken->facultyId).'">Contact Instructor</a>: '.$obj->user->activeClassTaken->facultyName;
			$t['sectionheader'] .= '</h3>';
			return;
		}

		$t['sectionheader']  = '<table style="font-weight:bold;" width="100%" border=0 cellpadding=3 cellspacing=0><tr><td><big>'.$this->sectionTitle.'</big>';
		if ($obj->user->activeClassTaken->courseName)
			$t['sectionheader'] .= '</td><td align="right">'.$obj->user->activeClassTaken->courseName.' <br/><a href="'.appurl('pm/main/event=compose/sendto='.$obj->user->activeClassTaken->facultyId).'">Contact Instructor</a>: '.$obj->user->activeClassTaken->facultyName;
		$t['sectionheader'] .= '</td></tr></table>';

		if ( count($this->navlinks) > 0 ) {
			$t['sectionheader']  .= '<div id="sectionheader">';
			while ( list($k,$v) = @each($this->navlinks) ) {
				if (in_array($k, $this->inactivelinks)) {
					
					if (preg_match('/^%/', $v)) {
						$link = appurl(preg_replace('/^%/', '', $v));
					} else {
						$link = modurl($v);
					}
					$t['sectionheader'] .= '<b><a href="'.$link.'">'.$k.'</a></b> &bull; ';
					
				} else {
					if (preg_match('/^%/', $v)) {
						$link = appurl(preg_replace('/^%/', '', $v));
					} else {
						$link = modurl($v);
					}
					$t['sectionheader'] .= '<a href="'.$link.'">'.$k.'</a> &bull; ';
				}
			}
			
			if (count($this->navlinks)) $t['sectionheader'] = substr($t['sectionheader'],0,-8);
			$t['sectionheader']  .= '</div>';
		}

		if ( count($this->applinks) > 0 ) {
			$t['sectionheader'] .= '<div id="applinks"><b class="title">Application Links:</b>&nbsp;&nbsp;';
			while ( list($k,$v) = @each($this->applinks) ) {
				if (in_array($k, $this->inactivelinks)) {
					if (preg_match('/^%/', $v)) {
						$link = appurl(preg_replace('/^%/', '', $v));
					} else {
						$link = modurl($v);
					}
					$t['sectionheader'] .= '<b><a href="'.$link.'">'.$k.'</a></b> &bull; ';
				} else {
					if (preg_match('/^%/', $v)) {
						$link = appurl(preg_replace('/^%/', '', $v));
					} else {
						$link = modurl($v);
					}
					$t['sectionheader'] .= '<a href="'.$link.'">'.$k.'</a> &bull; ';
				}
			}
			$t['sectionheader'] = substr($t['sectionheader'],0,-8);
			$t['sectionheader'] .= '</div>';
		}
		$t['sectionheader'] .= '<div style="margin:5px;"></div>';
	}
}





function configurePresentation (&$obj,&$t) {
	include_once("templates/mod_header.html.php");
	include_once("templates/".$obj->templateName.".html");
	include_once("templates/mod_footer.html.php");
}

function adminPresentation (&$obj,&$t) {
	include_once("templates/mod_header.html.php");
	include_once(MOD_PATH."admin/templates/".$obj->templateName.".html");
	include_once("templates/mod_footer.html.php");
}

function plainPresentation (&$obj,&$t) {
	include_once($obj->module_root."templates/".$obj->templateName.".html");
}

/*
 * relies on output buffering being on!
 */
function redirectPresentation (&$obj,&$t) {

	$e =& ErrorStack::_singleton();
	if (DEBUG && $e->count ) {
		echo "you are being redirected but there are errors.";
		echo "\n<br/>\n";

		echo "click to continue:";
		echo "\n<br/>\n";
		echo '<a href="'.$t['url'].'">continue</a>';
	} else {
		header("Location: ".$t['url']);
	}
}

function HTTPAuthPresentation (&$obj,&$t) {
	header( 'WWW-Authenticate: Basic realm="Hercules"' );
	header( 'HTTP/1.0 401 Unauthorized' );
	echo '<h1>Authorization Required</h1>';
}

function _errorMessage (&$obj,&$t) {
		include_once("templates/mod_header.html");
		print "<h3>Error:</h3> \n\n ".$t[message]." <p>\n".$t[details];
		include_once("templates/mod_footer.html");
}


function debugPresentation(&$obj,&$t) {
		include_once(TEMPLATE_PATH."/debug.html");
}


//*********************** Authorizer ********************
function noAuth(&$lc,&$u) {
	return true;
}


function adminAuth(&$lc,&$u) {
	if (in_array('admin', $u->groups) )
	{
		return true;
	}
	return false;
}

/* 
 * Checks to see if the user is in the faculty group
 */
function teachesClassesAuth(&$lc,&$u) {
	if (count($u->classesTaught) > 0)
	{
		return true;
	}
	global $lcTemplate;
	$lcTemplate['reason'] = 'It seems that you are not a <u>teacher</u> of any classes.';
	ob_end_clean();
	ob_start();
	unset($u->password);
	print_r($u);
	$lcTemplate['debug'] = ob_get_contents();
	ob_end_clean();
	ob_start();

	return false;
}

function takesClassesAuth(&$lc,&$u) {
	if (count($u->classesTaken) > 0)
	{
		return true;
	}
	global $lcTemplate;
	$lcTemplate['reason'] = 'It seems that you are not a <u>student</u> of any classes.';
	ob_end_clean();
	ob_start();
	unset($u->password);
	print_r($u);
	$lcTemplate['debug'] = ob_get_contents();
	ob_end_clean();
	ob_start();

	return false;
}


/**
 * this is just like facultyAuth except it will just stop 
 * observers from seeing certain service files
 * this should probably be taken care of more with basicauth
 * but this is so far gone that I'm not sure how to do this
 * mgk - 5/30/04  - based on an email from davidw
 * gradebook will be facultyOnlyAuth to start with
 */
function facultyOnlyAuth(&$lc,&$u) {
        global $lcTemplate;
        if ($u->activeClassTaught->facultyType == 'o') { 
            $lcTemplate['reason'] = "You are an observer and can not access this functionality.";
            return false;
        }

	if ($u->activeClassTaught->id_classes != '') {
		return true;
	}
	$u->activeClassTaught = $u->classesTaught[0];
	if ($u->activeClassTaught->id_classes != '') {
		return true;
	}

	$lcTemplate['reason'] = 'It seems that you do not have a class that you teach loaded in memory.';
	ob_end_clean();
	ob_start();
	unset($u->password);
	print_r($u);
	$lcTemplate['debug'] = ob_get_contents();
	ob_end_clean();
	ob_start();

	return false;
}


function facultyAuth(&$lc,&$u) {
        global $lcTemplate;
        if ($u->activeClassTaught->facultyType == 'o') { 
                if (count($lc->postvars)>0) { // observer's can't post
                        $lcTemplate['reason'] = "You are an observer and can not access this functionality.";
                        return false;
                }
                $bannedEvents = array("delete","del","remove","update","add","insert");
		if (is_array($lc->getvars)) { 
			if (in_array($lc->getvars['event'],$bannedEvents)) {
				$lcTemplate['reason'] = "You are an observer and can not access this functionality.";
				return false;
			}
		}
        }



	if ($u->activeClassTaught->id_classes != '') {
		return true;
	}
	$u->activeClassTaught = $u->classesTaught[0];
	if ($u->activeClassTaught->id_classes != '') {
		return true;
	}

	$lcTemplate['reason'] = 'It seems that you do not have a class that you teach loaded in memory.';
	ob_end_clean();
	ob_start();
	unset($u->password);
	print_r($u);
	$lcTemplate['debug'] = ob_get_contents();
	ob_end_clean();
	ob_start();

	return false;
}


function studentAuth(&$lc,&$u) {
	if ($u->activeClassTaken->id_classes != '')
	{
		return true;
	}
	$u->activeClassTaken = $u->classesTaken[0];
	if ($u->activeClassTaken->id_classes != '')
	{
		return true;
	}

	global $lcTemplate;
	$lcTemplate['reason'] = 'It seems that you do not have a class that you take loaded in memory.';
	ob_end_clean();
	ob_start();
	unset($u->password);
	print_r($u);
	$lcTemplate['debug'] = ob_get_contents();
	ob_end_clean();
	ob_start();

	return false;
}

function basicAuth(&$lc,$u) {
		if (! @in_array('access',$u->perms) ) {
			return false;
		} else {
			return true;
		}
	}



/**
 * Provides direct permission => service access mapping
 *
 * Assumes that every service in the module will have
 * a corresponding permission assigned to it with the same name.
 */
function serviceMapAuth (&$lc,&$u) {
	//__FIXME__ don't globalize serviceName, implement new lcSystem class
	global $serviceName;
	if ($serviceName == '') return true;

	if ( @in_array($serviceName,$u->perms) ) {
		return true;
	} else {
		return false;
	}
}



/** 
 * Error handling
 *
 * Write all php script errors to a file.
 */

function lcErrorHandler($errno, $errstr, $errfile='?', $errline= '?')  { 
   global $lcAdminMail, $lcErrorPage, $err;

if (DEBUG_FILE != "") {
	$f = fopen(DEBUG_FILE,"r");
	$x = fread($f,sizeof(DEBUG_FILE));
	fclose($f);
	$x = "$errfile\tLine $errline\t$err($errno)\t$errstr\n$x";
	$f = fopen(DEBUG_FILE,"w+");
	fputs($f,$x);
	fclose($f);
}
    $err = '';
    switch($errno) {
    case E_ERROR: $err = 'FATAL'; die();
    case E_WARNING: $err = 'ERROR'; die();
    case E_NOTICE: $err = 'WARNING';break;
   }

   
} 
	function regauth(&$lc,&$u) {
		if ($u->username == "anonymous" || $u->username == "") {
		return false;
		}
	return true;
	}


?>
