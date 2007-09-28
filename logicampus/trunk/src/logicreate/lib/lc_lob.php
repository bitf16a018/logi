<?php

include_once(LIB_PATH.'PBDO/LobRepoEntry.php');
include_once(LIB_PATH.'PBDO/LobMetadata.php');
include_once(LIB_PATH.'PBDO/LobContent.php');
include_once(LIB_PATH.'PBDO/LobTest.php');
include_once(LIB_PATH.'PBDO/LobTestQst.php');

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

	function isFile() {
		return $this->repoObj->lobSubType == 'document';
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



	/*
	function updateAsFile(&$vars, $name='', $tmp_name='') {
		$this->set('lobTitle', $vars['txTitle']);

		if ($tmp_name != '') {
			$this->set('lobFilename', urlencode( $name ) );
			$this->set('lobBinary', file_get_contents( $tmp_name ) );
		}
		$this->set('lobSubType',$vars['lob_sub_type']);
		$n =& $name;

		$ext = substr (
			$n, 
		       (strrpos($n, '.')  - strlen($n) +1)
			);

		$ext = strtolower($ext);
		$m = Lc_Lob_Util::getMimeForSubtype($vars['lob_sub_type'],$ext);
		$this->set('lobMime', $m);

		//create the link text in a standard way
		$this->set('lobUrltitle',
			Lc_Lob_Util::createLinkText($this->get('lobTitle'),$ext)
		);
	}
	 */


	/*
	function updateAsText($vars) {
		$this->set('lobContent', $vars['txText']);
		$this->set('lobSubType',$vars['lob_sub_type']);
		$this->set('lobTitle', $vars['txTitle']);
		if (@isset($vars['mime'])  && strlen($vars['mime'])) {
			$this->set('lobMime', $vars['mime']);
		}

		//create the link text in a standard way
		$this->set('lobUrltitle',
			Lc_Lob_Util::createLinkText($this->get('lobTitle'))
		);
	}
	 */

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

	/**
	 * Make a copy or reference (link) of this lob in the 
	 * class_repo.
	 */
	function useInClass($classId = -1, $copyStyle = 'notify') {
		$subLob = null;
		$classRepo = null;

		if ($this->type == 'unknown') {
			return null;
		}

		$repo = $this->getRepoEntry();

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
				$results  = $this->getLobActivitysByLobRepoEntryId();
				if (! count($results) ) {
					trigger_error('learning object missing internal data.');
					return null;
				}
				$subLob  = $results[0];
				include_once(LIB_PATH.'lc_lob_class.php');
				$classLob = new Lc_Lob_ClassActivity();
				break;

			case 'test':
				$results  = $this->getLobTestsByLobRepoEntryId();
				if (! count($results) ) {
					trigger_error('learning object missing internal data.');
					return null;
				}
				$subLob  = $results[0];
				include_once(LIB_PATH.'lc_lob_class.php');
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

		$classLob->repoObj = $classRepo;
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
		$this->repoObj->lobBytes = strlen($content);
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
 * Hold lob repo entries and lob content entries
 */
class Lc_Lob_Test extends Lc_Lob {

	var $type = 'test';
	var $questionObjs = array();
	var $mime = 'X-LMS/test';

	function Lc_Lob_Test($id = -1) {
		if ($id == -1) {
			$this->repoObj    = new LobRepoEntry();
			$this->lobSub     = new LobTest();
			$this->lobMetaObj = new LobMetadata();
			$this->lobMetaObj->createdOn = time();
		} else {
			$this->repoObj   = LobRepoEntry::load($id);
			$tests           = $this->repoObj->getLobTestsByLobRepoEntryId();
			$this->lobSub    = $tests[0];
		}
	}

	function addQuestion($qtext, $type = 'QUESTION_ESSAY', $choices = '', $answers = '') {

		$q = new LobTestQst();
		$q->qstText =  $qtext;
		if ( is_array($choices) ) {
		}
		$this->questionObjs[] = $q;
	}

	function getQuestionCount() {
		return count($this->questionObjs);
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
