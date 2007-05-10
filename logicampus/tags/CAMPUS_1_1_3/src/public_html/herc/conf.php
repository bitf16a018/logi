<?php
/*************************************************** 
 *
 * This file is under the LogiCreate Public License
 *
 * A copy of the license is in your LC distribution
 * called license.txt.  If you are missing this
 * file you can obtain the latest version from
 * http://logicreate.com/license.html
 *
 * LogiCreate is copyright by Tap Internet, Inc.
 * http://www.tapinternet.com/
 ***************************************************/

include_once(LIB_PATH."LC_registry.php");
include_once(LIB_PATH."LC_html.php");
	/**
	 * interface to lcConfig sql table
	 */

class conf extends HercAuth {

	var $presentor = "configurePresentation";

	function run (&$db,&$u,&$arg,&$t) {
		$mid= $arg->getvars[1];
		$reg = lcRegistry::load($mid);
		$t["configs"] = $reg->config;
		$t['type'] = $reg->type;
		$t['extra'] = $reg->extra;
		$t["modulename"] = $reg->displayName;
		$t['mid'] = $mid;
		//$t['user'] = $u;
	}

	function addNewRun (&$db,&$u,&$arg,&$t) {
		$mid = $arg->getvars[1];
		$reg = lcRegistry::load($mid);
		$reg->config[$arg->postvars['key']] = "";
		$reg->extra[$arg->postvars['key']] = $arg->postvars['extra'];
		$reg->type[$arg->postvars['key']] = $arg->postvars['type'];
		$reg->saveConfig();
		$t[message] = "New config added";
		$this->run($db,$u,$arg,$t);
	}

	function delRun (&$db,&$u,&$arg,&$t) {
		$mid = $arg->getvars[1];
		$reg = lcRegistry::load($mid);
		$reg->type[$arg->getvars['key']] = "";
		$reg->saveConfig();
		$t[message] = "Config deleted";
		$this->run($db,$u,$arg,$t);
	}

	function updateRun (&$db,&$u,&$arg,&$t) {
		$mid = $arg->getvars[1];
		$conf= $arg->postvars["configs"];
		$reg = lcRegistry::load($mid);
		$reg->config = $conf;
		$reg->saveConfig();
		$t[message] = "Configs updated";
		$this->run($db,$u,$arg,$t);
	}
}
?>
