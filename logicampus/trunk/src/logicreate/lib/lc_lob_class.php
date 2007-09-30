<?php

include_once(LIB_PATH.'lc_lob.php');
include_once(LIB_PATH.'PBDO/LobClassRepo.php');
include_once(LIB_PATH.'PBDO/LobClassContent.php');
include_once(LIB_PATH.'PBDO/LobClassActivity.php');
include_once(LIB_PATH.'PBDO/LobClassTest.php');

class Lc_Lob_Class extends Lc_Lob {
	var $repoObj;
	var $lobSub;
	var $lobMetaObj = null;
	var $type = 'unknown';

	function Lc_Lob_Class($id=-1) {
		if ($id < 1) {
			$this->repoObj = new LobClassRepo();
			$this->lobMetaObj = new LobMetadata();
			$this->lobMetaObj->createdOn = time();
		} else {
			$this->repoObj = LobClassRepo::load($id);
			$this->lobMetaObj = LobMetadata::load(array('lob_id'=>$id, 'lob_kind'=>$this->repoObj->lobType));
		}
	}

	/**
	 * Load a specific sub lob based on this type
	 */
	function loadSub() {
		switch($this->type) {
			case 'content':
				if ($this->repoObj->getPrimaryKey() > 0) {
					$results = $this->repoObj->getLobClassContentsByLobClassRepoId();
					$this->lobSub = $results[0];
				} else {
					$this->lobSub = new LobClassContent();
				}
				break;

			case 'activity':

				if ($this->repoObj->getPrimaryKey() > 0) {
					$results = $this->repoObj->getLobClassActivitysByLobClassRepoId();
					$this->lobSub = $results[0];
				} else {
					$this->lobSub = new LobClassActivity();
				}

				/*
				$results  = $this->getLobActivitysByLobRepoEntryId();
				if (! count($results) ) {
					trigger_error('learning object missing internal data.');
					return null;
				}
				$subLob  = $results[0];
				include_once(LIB_PATH.'lc_lob_class.php');
				$classLob = new Lc_Lob_ClassActivity();
				trigger_error('un-implemented');
				 */
				break;

			case 'test':
				/*
				$results  = $this->getLobTestsByLobRepoEntryId();
				if (! count($results) ) {
					trigger_error('learning object missing internal data.');
					return null;
				}
				$subLob  = $results[0];
				include_once(LIB_PATH.'lc_lob_class.php');
				$classLob = new Lc_Lob_ClassTest();
				*/

				trigger_error('un-implemented');
				break;
		}
	}

	/**
	 * Skip the meta object for now
	 */
	function save() {
		if ($this->repoObj->lobGuid == '') {
			$guid = lcUuid();
			$this->repoObj->set('lobGuid',$guid);
		}
		$this->repoObj->version++;
		$this->repoObj->save();
		$ret = ($this->repoObj->getPrimaryKey() > 0);
		return $ret;
//		$this->lobMetaObj->updatedOn = time();
//		if ($this->lobMetaObj->isNew()) {
			//might be a brand new object
//			$this->lobMetaObj->lobId = $this->repoObj->getPrimaryKey();
//		}
//		return $this->lobMetaObj->save() && $ret;
	}


	/**
	 * Return the primary key
	 */
	function getRepoId() {
		return  $this->repoObj->lobClassRepoId;
	}
}


class Lc_Lob_ClassContent extends Lc_Lob_Class {

	var $repoObj;
	var $type = 'content';

	function Lc_Lob_ClassContent($id=-1) {
		if ($id < 1) {
			$this->repoObj = new LobClassRepo();
			$this->lobSub = new LobClassContent();
		} else {
			$this->repoObj = LobClassRepo::load($id);
			$this->lobSub = LobClassContent::load($id);
		}
	}

	/**
	 * Copy all the values of a specific sub Object to this lobSub
	 */
	function copySub(&$repoSub) {
		$this->lobSub->lobText     = $repoSub->lobText;
		$this->lobSub->lobBinary   = $repoSub->lobBinary;
		$this->lobSub->lobFilename = $repoSub->lobFilename;
		$this->lobSub->lobCaption  = $repoSub->lobCaption;
	}

	/**
	 * Skip the meta object for now
	 */
	function save() {
		if ($this->repoObj->lobGuid == '') {
			$guid = lcUuid();
			$this->repoObj->set('lobGuid',$guid);
		}
		$this->repoObj->version++;
		$this->repoObj->save();
		$ret = ($this->repoObj->getPrimaryKey() > 0);

		$this->lobSub->lobClassRepoId = $this->repoObj->getPrimaryKey();
		$this->lobSub->save();

		return $ret;
	}
}

class Lc_Lob_ClassActivity extends Lc_Lob_Class {

	var $repoObj;
	var $type = 'activity';

	function Lc_Lob_ClassActivity($id=-1) {

		include_once(LIB_PATH.'PBDO/LobClassActivity.php');
		if ($id < 1) {
			$this->repoObj = new LobClassRepo();
			$this->lobSub = new LobClassActivity();
		} else {
			$this->repoObj = LobClassRepo::load($id);
			$this->lobSub = LobClassActivity::load($id);
		}
	}

	/**
	 * Copy all the values of a specific sub Object to this lobSub
	 */
	function copySub(&$repoSub) {
		$this->lobSub->responseTypeId  = $repoSub->responseTypeId;
		/*
		$this->lobSub->instructions  = $repoSub->lobDescription;
		$this->lobSub->lobFilename   = $repoSub->lobFilename;
		$this->lobSub->lobCaption    = $repoSub->lobCaption;
		 */
	}


	/**
	 * Skip the meta object for now
	 */
	function save() {
		if ($this->repoObj->lobGuid == '') {
			$guid = lcUuid();
			$this->repoObj->set('lobGuid',$guid);
		}
		$this->repoObj->version++;
		$this->repoObj->save();
		$ret = ($this->repoObj->getPrimaryKey() > 0);

		$this->lobSub->lobClassRepoId = $this->repoObj->getPrimaryKey();
		$this->lobSub->save();

		return $ret;
	}
}
?>
