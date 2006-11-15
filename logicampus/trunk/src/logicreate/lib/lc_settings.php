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

}


?>
