<?php

include_once(INSTALLED_SERVICE_PATH."classforums/ClassForum.php");
include_once(INSTALLED_SERVICE_PATH."classforums/ClassForumPost.php");
include_once(INSTALLED_SERVICE_PATH."classforums/ClassForumCategory.php");


/**
 * User-space wrapper for DAOs
 */
class ClassForum_Posts {

	var $_dao;


	/**
	 * Retrieve a list of all 'topic' posts in a class forums 
	 * Topics have a null thread ID because they are not
	 * replying to any particular topic.
	 *
	 * @static
	 * @param forumId int id of the forum
	 */
	function getTopics($forumId) {

		$forumId = intval($forumId);
		$list = ClassForumPostPeer::doSelect(' class_forum_id='.$forumId.' and thread_id IS NULL ORDER BY is_sticky DESC, post_timedate DESC');

		$objList = array();
		foreach ($list as $k=>$v) {
			$x = new ClassForum_Posts();
			$x->_dao = $v;
			$objList[] = $x;
		}

		return $objList;
	}


	function getReplyCount() {
		return 1;
	}


	function getForumId() {
		return $this->_dao->classForumId;
	}


	function getPostId() {
		return $this->_dao->classForumPostId;
	}

	
	function getMessage() {
		return $this->_dao->message;
	}


	function getSubject() {
		return $this->_dao->subject;
	}

}


/**
 * User-space wrapper for DAOs
 */
class ClassForum_Forums {

	var $_dao;


	/**
	 * Retrieve a list of all class forums 
	 *
	 * @static
	 * @param classId int id of the current class
	 */
	function getAll($classId) {

		$classId = intval($classId);
		$list = ClassForumPeer::doSelect(' class_id='.$classId.' ORDER BY name ASC,class_forum_category_id');

		$objList = array();
		foreach ($list as $k=>$v) {
			$x = new ClassForum_Forums();
			$x->_dao = $v;
			$objList[] = $x;
		}

		return $objList;
	}


	function getCategoryId() {
		return $this->_dao->classForumCategoryId;
	}
}


/**
 * User-space wrapper for DAOs
 */
class ClassForum_Categories {

	var $forumCount = -1;
	var $_dao;

	/**
	 * Retrieve a list of all class forum categories
	 *
	 * @static
	 * @param classId int id of the current class
	 */
	function getAll($classId) {

		$classId = intval($classId);
		$list = ClassForumCategoryPeer::doSelect(' class_id='.$classId.' ORDER BY name ASC');

		$objList = array();
		foreach ($list as $k=>$v) {
			$x = new ClassForum_Categories();
			$x->_dao = $v;
			$objList[] = $x;
		}

		return $objList;
	}


	/**
	 * Get a count of forums under this category
	 *
	 */
	function getName() {
		return $this->_dao->name;
	}


	/**
	 * Get a count of forums under this category
	 *
	 */
	function getForumCount() {
		if ($this->forumCount > -1) {
			return $this->forumCount;
		} else {
			// TODO: hit DB
			return 10;
		}
	}


	function getCategoryId() {
		return $this->_dao->getPrimaryKey();
	}
}
