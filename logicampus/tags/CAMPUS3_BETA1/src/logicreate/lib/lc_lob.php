<?php

include_once(LIB_PATH.'PBDO/LobRepoEntry.php');
include_once(LIB_PATH.'PBDO/LobMetadata.php');
include_once(LIB_PATH.'PBDO/LobContent.php');
//sub types
include_once(LIB_PATH.'PBDO/LobTest.php');
include_once(LIB_PATH.'PBDO/LobActivity.php');

/**
 * Base class for all lob types (content, test, activity)
 */
class Lc_Lob {

	var $repoObj;
	var $lobSub = null;
	var $lobMetaObj;
	var $type = 'unknown';

	function Lc_Lob($id=-1) {
		if ($id < 1) {
			$this->repoObj = new LobRepoEntry();
			$this->lobMetaObj = new LobMetadata();
			$this->lobMetaObj->createdOn = time();
		} else {
			$this->repoObj = LobRepoEntry::load($id);
			$this->lobMetaObj = LobMetadata::load(array('lob_repo_entry_id'=>$id));
			$this->type = $this->repoObj->lobType;
		}
	}

	function isImage() {
		return $this->repoObj->lobSubType == 'image';
	}

	/**
	 * Document style content, word processing files, audio, etc
	 */
	function isFile() {
		return $this->repoObj->lobSubType == 'document';
	}

	/**
	 * Acitivty/assignment style content. homework, upload a file, etc.
	 */
	function isActivity() {
		return $this->repoObj->lobType == 'activity';
	}

	/**
	 * Test/exam style content.
	 */
	function isTest() {
		return $this->repoObj->lobType == 'test';
	}

	function isText() {
		return $this->repoObj->lobSubType == 'text';
	}

	function get($key) {
		return $this->repoObj->{$key};
	}

	function getMeta($key) {
		return $this->lobMetaObj->{$key};
	}

	function set($key,$val) {
		$this->repoObj->set($key,$val);
	}

	function setMeta($key,$val) {
		$this->lobMetaObj->set($key,$val);
	}

	/**
	 *  Get version
	 **/
	function getVersion() {
		return $this->repoObj->lobVersion;
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
	function getEditedOn() {
		if ($this->lobMetaObj->updatedOn < 1) {
			return 'unknown';
		}
		return date('M d \'y',$this->lobMetaObj->updatedOn);
	}

	/**
	 *  Get Metadata
	 **/
	function getCreatedOn() {
		if ($this->lobMetaObj->createdOn < 1) {
			return 'unknown';
		}

		return date('M d \'y',$this->lobMetaObj->createdOn);
	}


	/**
	 * Return the text to create a link to this object
	 */
	function getUrl() {
		return  $this->repoObj->lobUrltitle;
	}


	/**
	 * Return the type
	 */
	function getType() {
		return  $this->repoObj->lobType;
	}


	/**
	 * Return the sub type
	 */
	function getSubType() {
		return  $this->repoObj->lobSubType;
	}


	/**
	 * Return the primary key
	 */
	/*
	function getContentId() {
		return  $this->repoObj->lobContentId;
	}
	 */

	/**
	 * Return the primary key
	 */
	function getRepoId() {
		return  $this->repoObj->lobRepoEntryId;
	}



	function updateAsFile($title, $subType = 'document') {
		$this->set('lobSubType',$subType);

		$this->set('lobTitle', $title);
		$n = $this->lobSub->lobFilename;
		$ext = substr (
			$n, 
		       (strrpos($n, '.')  - strlen($n) +1)
			);
		$ext = strtolower($ext);
		$m = Lc_Lob_Util::getMimeForSubtype($subType,$ext);
		$this->set('lobMime', $m);
	}


	function updateAsText($title, $subType = 'text') {
		$this->set('lobSubType',$subType);
		$this->set('lobTitle', $title);
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
		if ($this->repoObj->lobGuid == '') {
			$guid = lcUuid();
			$this->repoObj->set('lobGuid',$guid);
		}

		if ($this->repoObj->lobType == '') {
			$this->repoObj->lobType = $this->type;
		}

		$this->repoObj->lobVersion++;
		$this->repoObj->save();
		$ret = ($this->repoObj->getPrimaryKey() > 0);
		

		$this->lobSub->lobRepoEntryId = $this->repoObj->getPrimaryKey();
		$this->lobSub->save();

		$this->lobMetaObj->updatedOn = time();
		$this->lobMetaObj->lobRepoEntryId = $this->repoObj->getPrimaryKey();
		if ($this->lobMetaObj->isNew()) {
			//might be a brand new object
			$this->lobMetaObj->lobRepoEntryId = $this->repoObj->getPrimaryKey();
		}
		$this->lobMetaObj->save();
		$meta = ($this->lobMetaObj->getPrimaryKey() > 0);
		return $meta && $ret;
	}

	/**
	 * Must be called by subclasses
	 */
	function &getRepoEntry() {
		return $this->repoObj;
	}

	function &getMetadata() {
		return $this->lobMetaObj;
	}

	/**
	 * Make a copy or reference (link) of this lob in the 
	 * class_repo.
	 */
	function useInClass($classId = -1, $copyStyle = 'notify') {
		$subLob = null;
		$classRepo = null;
		$classMeta = null;

		if ($this->type == 'unknown') {
			return null;
		}

		$repo = $this->getRepoEntry();
		$meta = $this->getMetadata();

		switch($this->type) {
			case 'content':
				$results  = $repo->getLobContentsByLobRepoEntryId();
				if (! count($results) ) {
					trigger_error('learning object missing internal data.');
					return null;
				}
				$subLob  = $results[0];
				include_once(LIB_PATH.'lc_lob_class.php');
				$classLob = new Lc_Lob_ClassContent();
				break;

			case 'activity':
			case 'interaction':
				$results  = $repo->getLobActivitysByLobRepoEntryId();
				if (! count($results) ) {
					trigger_error('learning object missing internal data.');
					return null;
				}
				$subLob  = $results[0];
				include_once(LIB_PATH.'lc_lob_class.php');
				$classLob = new Lc_Lob_ClassActivity();
				break;

			case 'test':
				include_once(LIB_PATH.'lc_lob_test.php');
				$results  = $repo->getLobTestsByLobRepoEntryId();
				if (! count($results) ) {
					trigger_error('learning object missing internal data.');
					return null;
				}
				$subLob  = $results[0];
				include_once(LIB_PATH.'lc_lob_class.php');
				include_once(LIB_PATH.'lc_lob_class_test.php');
				$classLob = new Lc_Lob_ClassTest();
				break;
		}

		//load or make a new class repository entry
		$classRepo = LobClassRepo::load( array ('lob_repo_entry_id'=> $repo->lobRepoEntryId) );
		if (isset($classRepo)) {

		} else {
			$classRepo = new LobClassRepo();
			$classRepo->type = $this->type;
		}

		//load or make a new class metadata entry
		$classMeta = LobClassMetadata::load( array ('lob_class_repo_id'=> $classRepo->lobClassRepoId) );
		if (isset($classMeta)) {

		} else {
			$classMeta = new LobClassMetadata();
			$classMeta->lobClassRepoId = $classRepo->lobClassRepoId;
		}


		$classLob->repoObj = $classRepo;
		$classLob->lobMetaObj = $classMeta;
		$classLob->loadSub();

		//copy all values to classRepoEntry
		//
		$classLob->repoObj->classId        = $classId;
		$classLob->repoObj->lobRepoEntryId = $repo->get('lobRepoEntryId');
		$classLob->repoObj->lobGuid        = $repo->get('lobGuid');
		$classLob->repoObj->lobCopyStyle   = $copyStyle;
		$classLob->repoObj->lobType        = $repo->lobType;
		$classLob->repoObj->lobSubType     = $repo->lobSubType;
		$classLob->repoObj->lobVersion     = $repo->lobVersion;
		$classLob->repoObj->lobBytes       = $repo->lobBytes;
		$classLob->repoObj->lobTitle       = $repo->lobTitle;
		$classLob->repoObj->lobUrltitle    = $repo->lobUrltitle;
		$classLob->repoObj->lobMime        = $repo->lobMime;
		$classLob->repoObj->lobDescription = $repo->lobDescription;

		//copy all the values to lobClassMetadata
		//
		$classLob->lobMetaObj->subject        = $meta->subject;
		$classLob->lobMetaObj->subdisc        = $meta->subdisc;
		$classLob->lobMetaObj->author         = $meta->author;
		$classLob->lobMetaObj->copyright      = $meta->copyright;
		$classLob->lobMetaObj->license        = $meta->license;
		$classLob->lobMetaObj->userVersion    = $meta->userVersion;
		$classLob->lobMetaObj->status         = $meta->status;
		$classLob->lobMetaObj->updatedOn      = $meta->updatedOn;
		$classLob->lobMetaObj->createdOn      = $meta->createdOn;

		//update values of the sub object
		//
		$classLob->copySub($subLob);

		//save, get id
		//
		$classLob->save();

		return $classLob;
	}
}



/**
 * Hold lob repo entries and lob content entries
 */
class Lc_Lob_Content extends Lc_Lob {

	var $type = 'content';

	function Lc_Lob_Content($id = -1) {
		if ($id < 1) {
			$this->lobSub     = new LobContent();
			$this->repoObj    = new LobRepoEntry();
			$this->lobMetaObj = new LobMetadata();
			$this->lobMetaObj->createdOn = time();
		} else {
			$this->repoObj   = LobRepoEntry::load($id);
			$content         = $this->repoObj->getLobContentsByLobRepoEntryId();
			$this->lobSub    = $content[0];
			$this->lobMetaObj = LobMetadata::load(array('lob_repo_entry_id'=>$id));
		}
	}


	/**
	 * Set the textual content
	 */
	function setTextContent(&$content) {
		$this->lobSub->lobText =& $content;
		$this->repoObj->lobSubType = 'text';
		$this->repoObj->lobBytes = strlen($content);
		$this->lobSub->lobBinary = null;
	}


	/**
	 * Set the textual content
	 */
	function setBinContent(&$binary) {
		$this->lobSub->lobBinary =& $binary;
		$this->repoObj->lobSubType = 'document';
		$this->repoObj->lobBytes = strlen($binary);
		$this->lobSub->lobText = null;
	}

	/**
	 * Set the textual content
	 */
	function setFile($filename, $filetitle = '') {
		if ($filetitle == '') {
			$filetitle = basename($filename);
		}
		$binary = file_get_contents($filename);
		$this->setBinContent($binary);
		$this->lobSub->lobFilename = $filetitle;
	}


	/**
	 * Return the caption for this content, mostly for images
	 */
	function getCaption() {
		return $this->lobSub->lobCaption;
	}

	/**
	 * Set the caption for this content, mostly for images
	 */
	function setCaption($cap) {
		$this->lobSub->lobCaption = $cap;
	}

	function getFilename() {
		return $this->lobSub->lobFilename;
	}

	/**
	 * Return the text content contained in "lobSub"
	 */
	function getTextContent() {
		return $this->lobSub->lobText;
	}
}


/**
 * Hold lob repo entries and lob activity entries
 */
class Lc_Lob_Activity extends Lc_Lob {

	var $type = 'activity';
	var $questionObjs = array();
	var $mime = 'X-LMS/activity';

	function Lc_Lob_Activity($id = -1) {
		if ($id < 1) {
			$this->repoObj    = new LobRepoEntry();
			$this->lobSub     = new LobActivity();
			$this->lobMetaObj = new LobMetadata();
			$this->lobMetaObj->createdOn = time();
			$this->repoObj->lobMime = $this->mime;
		} else {
			$this->repoObj   = LobRepoEntry::load($id);
			$tests           = $this->repoObj->getLobActivitysByLobRepoEntryId();
			$this->lobSub    = $tests[0];
			$this->lobMetaObj = LobMetadata::load(array('lob_repo_entry_id'=>$id));
		}
	}

	/**
	 * Available response types are:
	 *
	 * 1 = upload file
	 * 2 = text response
	 * 3 = upload & text
	 * 4 = forum post
	 * 5 = None
	 * 6 = audio
	 */ 
	function setResponseType($typeInt=5) {
		$this->lobSub->responseTypeId = $typeInt;
	}

	function getResponseTypeName($typeInt=-1) {
		if ($typeInt == -1) { $typeInt = $this->lobSub->responseTypeId; }
		switch ($typeInt) {

			case 1: return 'File Upload';
			case 2: return 'Text Response';
			case 3: return 'File Upload and Text Response';
			case 4: return 'Forum Post';
			case 5: return 'None';
			case 6: return 'Audio Recording';
		}
	}
}



/**
 * Handle static functions to reduce the size of Lc_Lob class
 */
class Lc_Lob_Util {

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
			case 'X-LMS/test':
				return 'quiz.png';
				break;
			case 'X-LMS/assignment':
			case 'X-LMS/activity':
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


	/**
	 * @static
	 */
	function getSubTypeIcon($subType) {
		return Lc_Lob_Util::getMimeIcon( Lc_Lob_Util::getMimeForSubtype($subType));
	}


	/**
	 * Return an internet MIME for a specific sub-type.
	 * Optional extension for generic sub-types like "open office"
	 *
	 * @static
	 */
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

		if ($subtype == 'document' || $subtype == 'doc') {
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

		if ($subtype == 'audio') {
			switch($ext) {
				case 'mp3':
				return 'audio/mpeg';
				break;
			}
		}

		return "application/octet-stream";
	}

	/**
	 * Make the text URL friendly by removing characters that would
	 * have to be URL encoded to be valid.
	 *
	 * @static
	 */
	function createLinkText($name,$ext='') {
		$ext = strtolower($ext);

		$ret = str_replace('&', ' and ', $name);
		$ret = str_replace(' ', '_', $ret);

		$pattern = '/[\x{21}-\x{2C}]|[\x{2F}]|[\x{5B}-\x{5E}]|[\x{7E}]/';
		$ret = preg_replace($pattern, '_', $ret);
		$ret = str_replace('___', '_', $ret);
		$ret = str_replace('__', '_', $ret);
		$ret = str_replace('__', '_', $ret);

		if ($ext != '' && $ext != 'html' && $ext != 'htm') {
			$ret .= '.'.$ext;
		}
		return $ret;
	}


	/**
	 * Return a number of bytes as at least 0.00 kilobytes
	 */
	function formatBytes($intSize) {
		return sprintf('%0.2f', ($intSize/1000)). ' Kb';
	}
}
?>
