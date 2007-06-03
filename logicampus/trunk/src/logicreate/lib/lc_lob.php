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
			case 'application/pdf':
				return 'pdf.png';
				break;
			case 'application/octet-stream':
				return 'document.png';
				break;
			case 'X-LMS/assessment':
				return 'quiz.png';
				break;
			case 'X-LMS/interaction':
				return 'activity.png';
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

		if ($subType == 'document' || $subType == 'doc') {
			switch($ext) {
				case 'pdf':
				return 'application/pdf';
				break;

				case 'sxw':
				return 'application/vnd.sun.xml.writer';
				break;

				case 'sxc':
				return 'application/vnd.sun.xml.calc';
				break;
			}
		}

		if ($subType == 'audio') {
			switch($ext) {
				case 'mp3':
				return 'audio/mpeg';
				break;
			}
		}

		return "application/octet-stream";
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
