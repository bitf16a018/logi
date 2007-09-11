<?php

class LC_Lob {

	var $lobObj;
	var $lobMetaObj;

	function LC_Lob($id=-1) {
		if ($id < 1) {
			$this->lobObj = new LobContent();
			$this->lobMetaObj = new LobMetadata();
			$this->lobMetaObj->createdOn = time();
		} else {
			$this->lobObj = LobContent::load($id);
			$this->lobMetaObj = LobMetadata::load(array('lob_id'=>$id, 'lob_kind'=>$this->lobObj->lobType));
		}
	}

	function isFile() {
		return $this->lobObj->lobSubType == 'document';
	}

	function get($key) {
		return $this->lobObj->{$key};
	}

	function getMeta($key) {
		return $this->lobMetaObj->{$key};
	}

	function set($key,$val) {
		$this->lobObj->set($key,$val);
	}

	function setMeta($key,$val) {
		$this->lobMetaObj->set($key,$val);
	}

	/**
	 *  Get Metadata
	 **/
	function getLicense() {
		return $this->lobMetaObj->license;
	}

	/**
	 *  Get Metadata
	 **/
	function getCopyright() {
		return $this->lobMetaObj->copyright;
	}

	/**
	 *  Get Metadata
	 **/
	function getSource() {
		return $this->lobMetaObj->source;
	}

	/**
	 *  Get Metadata
	 **/
	function getAuthor() {
		return $this->lobMetaObj->author;
	}

	/**
	 *  Get Metadata
	 **/
	function getSubject() {
		return $this->lobMetaObj->subject;
	}

	/**
	 *  Get Metadata
	 **/
	function getSubdiscipline() {
		return $this->lobMetaObj->subdisc;
	}

	/**
	 *  Get Metadata
	 **/
	function getVersion() {
		return $this->lobMetaObj->version;
	}

	/**
	 *  Get Metadata
	 **/
	function getEditedOn() {
		if ($this->lobMetaObj->updatedOn < 1) {
			return 'unkonwn';
		}
		return date('M d \'y',$this->lobMetaObj->updatedOn);
	}

	/**
	 *  Get Metadata
	 **/
	function getCreatedOn() {
		if ($this->lobMetaObj->createdOn < 1) {
			return 'unkonwn';
		}

		return date('M d \'y',$this->lobMetaObj->createdOn);
	}


	/**
	 * Return the text to create a link to this object
	 */
	function getUrl() {
		return  $this->lobObj->lobUrltitle;
	}


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
			case 'X-LMS/assignment':
			case 'X-LMS/interaction':
				return 'activity.png';
				break;
			case 'image/':
			case 'image/jpeg':
			case 'image/jpg':
			case 'image/gif':
			case 'image/bmp':
			case 'image/png':
			case 'image/mng':
				return 'image.png';
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

		$ret = str_replace('&', ' and ', $name);
		$ret = str_replace(' ', '_', $ret);

		$pattern = '/[\x{21}-\x{2C}]|[\x{2F}]|[\x{5B}-\x{5E}]/';
		$ret = preg_replace($pattern, '_', $ret);
		$ret = str_replace('___', '_', $ret);
		$ret = str_replace('__', '_', $ret);
		$ret = str_replace('__', '_', $ret);

		if ($ext != '' && $ext != 'html' && $ext != 'htm') {
			$ret .= '.'.$ext;
		}
		return $ret;
	}


	function updateAsFile(&$vars,$upName) {
		$this->set('lobTitle', $vars['txTitle']);

		if (@$lc->uploads[$upName]) {
			$this->set('lobFilename', urlencode( $lc->uploads[$upName]['name'] ) );
			$this->set('lobBinary', file_get_contents( $lc->uploads[$upName]['tmp_name'] ) );
		}
		$this->set('lobSubType',$vars['lob_sub_type']);
		$n =& $lc->uploads[$upName]['name'];

		$ext = substr (
			$n, 
		       (strrpos($n, '.')  - strlen($n) +1)
			);

		$ext = strtolower($ext);
		$m = Lc_Lob::getMimeForSubtype($vars['lob_sub_type'],$ext);
		$this->set('lobMime', $m);

		//create the link text in a standard way
		$this->set('lobUrltitle',
			LC_Lob::createLinkText($this->get('lobTitle'),$ext)
		);
	}


	function updateAsText($vars) {
		$this->set('lobContent', $vars['txText']);
		$this->set('lobSubType','text');
		$this->set('lobTitle', $vars['txTitle']);
		if (@isset($vars['mime'])  && strlen($vars['mime'])) {
			$this->set('lobMime', $vars['mime']);
		}

		//create the link text in a standard way
		$this->set('lobUrltitle',
			LC_Lob::createLinkText($this->get('lobTitle'))
		);
	}

	function makePublic() {
		$this->lobMetaObj->private = 0;
	}

	function makePrivate() {
		$this->lobMetaObj->private = 1;
	}

	function isPrivate() {
		if ($this->lobMetaObj->private ) {
			return 'yes';
		} else {
			return 'no';
		}
	}

	function updateMeta($vars) {
		$this->setMeta('lobKind','content');
		$this->setMeta('author', $vars['md_author']);
		$this->setMeta('copyright', $vars['md_copyright']);
		$this->setMeta('license', $vars['md_license']);
		$this->setMeta('subject', $vars['md_subj']);
		$this->setMeta('subdisc', $vars['md_subdisc']);
	}


	function save() {
		$ret = $this->lobObj->save();
		$this->lobMetaObj->version++;
		$this->lobMetaObj->updatedOn = time();
		if ($this->lobMetaObj->isNew()) {
			//might be a brand new object
			$this->lobMetaObj->lobId = $this->lobObj->getPrimaryKey();
		}
		return $this->lobMetaObj->save() && $ret;
	}
}
?>
