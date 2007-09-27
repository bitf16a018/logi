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
	 * Skip the meta object for now
	 */
	function save() {
		$ret = $this->repoObj->save();
//		$this->lobMetaObj->version++;
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
}
?>
