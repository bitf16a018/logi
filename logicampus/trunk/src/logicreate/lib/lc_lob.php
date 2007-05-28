<?php

class LC_Lob {


	/**
	 * @static
	 */
	function getMimeIcon($mime) {
		switch ($mime) {
			case 'text/html':
				return 'html.png';
				break;
			default:
				return 'document.png';
				break;
		}
	}


	function getMimeForSubtype($subType,$ext='') {
		if ($ext == 'jpeg' || $ext == 'pjpeg' || $ext == 'jpg') {
			$ext = 'jpeg';
		}

		switch($subType) {
			case 'text':
				return 'text/plain';
			case 'wiki':
				return 'text/wiki';
			case 'html':
				return 'text/html';
			case 'image':
				return 'image/'.$ext;
		}

	}

	function createLinkText($name,$ext='') {
		$ext = strtolower($ext);
		$ret = str_replace(' ', '_',$name);
		$ret = urlencode($ret);
		if ($ext != '' && $ext != 'html' && $ext != 'htm') {
			$ret .= '.'.$ext;
		}
		return $ret;
	}
}

?>
