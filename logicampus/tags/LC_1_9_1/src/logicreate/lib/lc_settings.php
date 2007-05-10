<?php


class LcSettings {

	/**
	 * Retreive the message of the day off the file system
	 * @static
	 */
	function getSystemMotd() {
		$file = CONTENT_PATH.'__messageoftheday__';
		$fp = fopen ($file, 'r');
		$t['motd'] = fread($fp, filesize($file) );
		fclose($fp);
		return trim($t['motd']);
	}


	function isModuleOn($name) {
		if (defined($name) && constant($name) == true) {
			return true;
		} else {
			return false;
		}
	}

	function isModuleOff($name) {
		if (defined($name) && constant($name) == false) {
			return true;
		}
		if (! defined ($name) ) {
			return true;
		}
		return false;
	}
}


?>
