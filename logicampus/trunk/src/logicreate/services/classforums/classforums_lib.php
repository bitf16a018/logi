<?php

include_once(INSTALLED_SERVICE_PATH."classforums/ClassForum.php");
include_once(INSTALLED_SERVICE_PATH."classforums/ClassForumPost.php");
include_once(INSTALLED_SERVICE_PATH."classforums/ClassForumCategory.php");


/**
 * User-space wrapper for DAOs
 */
class ClassForum_Posts {

	var $_dao;
	var $replies = array();
	var $repliesLoaded = false;

	function load($postId) {
		$x = ClassForumPost::load($postId);
		$y = new ClassForum_Posts();
		$y->_dao = $x;
		return $y;
	}


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


	function getReplies() {

		$topicId = intval($this->getPostId());
		$list = ClassForumPostPeer::doSelect(' thread_id='.$topicId.' ORDER BY is_sticky DESC, post_timedate ASC');

		foreach ($list as $k=>$v) {
			$x = new ClassForum_Posts();
			$x->_dao = $v;
			$this->replies[] = $x;
		}
		$this->repliesLoaded = true;
		return $this->replies;
	}


	function getReplyCount() {
		if ( !$this->repliesLoaded ) {
			$this->getReplies();
		}
		return count($this->replies);
	}


	function getForumId() {
		return $this->_dao->classForumId;
	}


	function getPostId() {
		return $this->_dao->classForumPostId;
	}


	/**
	 * gets the raw message
	 *
	 * needed, for example, if you want to edit the message
	 * in a text area.
	 */
	function getMessage() {
		return $this->_dao->message;
	}


	/**
	 * gets the message for showing in HTML
	 */
	function showMessage() {
		return ClassForum_Posts::swapForumTags(nl2br($this->_dao->message));
	}



	function getSubject() {
		return $this->_dao->subject;
	}


	/**
	 * Changes [TAG] into <TAG>
	 *
	 * only works for QUOTE, CODE, B, I
	 * @static
	 * @param string $code the forum code that needs to be converted
	 * @return string HTML ready code
	 */
	function swapForumTags($code) {
		$code = str_replace('[QUOTE]','<div class="forum_quote_shell"><b>Quote:</b><div class="forum_quote">',$code);
		$code = str_replace('[/QUOTE]','</div></div>',$code);

		$code = str_replace('[CODE]','<div class="forum_code_shell"><b>Code:</b><div class="forum_code"><pre>',$code);
		$code = str_replace('[/CODE]','</pre></div></div>',$code);
		return $code;
	}
}


/**
 * User-space wrapper for DAOs
 */
class ClassForum_Forums {

	var $_dao;
	var $postCount = -1;
	var $topicCount = -1;

	/**
	 * Constructor
	 */
	function ClassForum_Forums() {
		$this->_dao = new ClassForum();
	}


	/**
	 * Set Name
	 */
	function setName($n) {
		$this->_dao->set('name',$n);
	}


	/**
	 * Set Description
	 */
	function setDescription($n) {
		$this->_dao->set('description',$n);
	}


	/**
	 * Set ClassId
	 */
	function setClassId($id) {
		$this->_dao->set('classId',$id);
	}

	/**
	 * Set CategoryId
	 */
	function setCategoryId($id) {
		$this->_dao->set('classForumCategoryId',$id);
	}



	/**
	 * Save
	 */
	function save() {
		return $this->_dao->save();
	}


	/**
	 * Retrieve a list of all class forums 
	 *
	 * @static
	 * @param classId int id of the current class
	 */
	function getAll($classId) {

		$classId = intval($classId);
		$list = ClassForumPeer::doSelect(' class_id='.$classId.' ORDER BY class_forum_category_id, name ASC');

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


	/**
	 * Get a count of posts under this forum, excluding topics
	 * (topics are thread starters, posts that were not a reply to anything)
	 */
	function getPostCount() {
		if ($this->postCount < 0) {
			$db = DB::getHandle();
			$db->query(
				ClassForum_Queries::getQuery('postCountForum',
					array($this->_dao->getPrimaryKey())
				)
			);
			$db->nextRecord();
			$this->postCount = $db->record['num'];
		}
		return $this->postCount;
	}


	/**
	 * Get a count of topics under this forum
	 */
	function getTopicCount() {
		if ($this->topicCount < 0) {
			$db = DB::getHandle();
			$db->query(
				ClassForum_Queries::getQuery('topicCountForum',
					array($this->_dao->getPrimaryKey())
				)
			);
			$db->nextRecord();
			$this->topicCount = $db->record['num'];
		}
		return $this->topicCount;
	}

}


/**
 * User-space wrapper for DAOs
 */
class ClassForum_Categories {

	var $forumCount = -1;
	var $_dao;


	/**
	 * Constructor
	 */
	function ClassForum_Categories() {
		$this->_dao = new ClassForumCategory();
	}


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
	 * Save
	 */
	function save() {
		return $this->_dao->save();
	}


	/**
	 * Set the name field
	 *
	 */
	function setClassId($id) {
		$this->_dao->set('classId', intval($id));
	}


	/**
	 * Set the name field
	 *
	 */
	function setName($n) {
		$this->_dao->set('name', $n);
	}


	/**
	 * Get the name field
	 *
	 */
	function getName() {
		return $this->_dao->get('name');
	}


	function getCategoryId() {
		return $this->_dao->getPrimaryKey();
	}


	/**
	 * Get a count of forums under this category
	 */
	function getForumCount() {
		if ($this->forumCount < 0) {
			$db = DB::getHandle();
			$db->query(
				ClassForum_Queries::getQuery('forumCountCategory',
					array($this->getCategoryId(),
					$this->_dao->classId)
				)
			);
			$db->nextRecord();
			$this->forumCount = $db->record['num'];
		}
		return $this->forumCount;
	}

}



/**
 * Holds all the raw queries for the class forums system
 */
class ClassForum_Queries {

	var $queries = array();


	function getQuery($name,$args) {
		$singleton = ClassForum_Queries::singleton();
		$s_args = array_merge( $singleton->queries[$name], $args);
		return call_user_func_array('sprintf', $s_args);
	}


	/**
	 * create the SQL statements
	 */
	function init() {
		$this->queries['forumCountCategory']  = 
		'SELECT count(class_forum_id) as num
		FROM `class_forum`
		WHERE class_forum_category_id = %d
		AND class_id = %d';

		$this->queries['moveForum']  = 
		'UPDATE `class_forum`
		SET class_forum_category_id = %d
		WHERE class_forum_id = %d 
		AND class_id = %d';

		$this->queries['postCountForum']  = 
		'SELECT count(class_forum_post_id) as num
		FROM `class_forum_post`
		WHERE class_forum_id = %d
		AND thread_id IS NOT NULL';

		$this->queries['topicCountForum']  = 
		'SELECT count(class_forum_post_id) as num
		FROM `class_forum_post`
		WHERE class_forum_id = %d
		AND thread_id IS NULL';
	}


	/**
	 * PHP4 has no static class variables
	 */
	function &singleton() {
		static $singleton;
		if (! is_object($singletone) ) {
			$singleton = new ClassForum_Queries();
			$singleton->init();
		}

		return $singleton;
	}
}


ClassForum_Queries::init();
