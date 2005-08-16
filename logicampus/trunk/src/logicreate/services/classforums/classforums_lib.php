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
	var $threadLoaded = false;


	function ClassForum_Posts() {
		$this->_dao = new ClassForumPost();
	}


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
		$list = ClassForumPostPeer::doSelect(' class_forum_id='.$forumId.' and thread_id = class_forum_post_id ORDER BY is_sticky DESC, post_timedate DESC');

		$objList = array();
		foreach ($list as $k=>$v) {
			$x = new ClassForum_Posts();
			$x->_dao = $v;
			$objList[] = $x;
		}
		return $objList;
	}


	function getThread($limit=-1, $start=-1) {

		$topicId = intval($this->getPostId());
		$query =' thread_id='.$topicId.' and thread_id IS NOT NULL ORDER BY is_sticky DESC, post_timedate ASC';
		if ($limit > -1) {
			$query .= ' LIMIT '.$start.', '.$limit;
		}
		$list = ClassForumPostPeer::doSelect($query);

		foreach ($list as $k=>$v) {
			$x = new ClassForum_Posts();
			$x->_dao = $v;
			$this->replies[] = $x;
		}
		$this->threadLoaded = true;
		return $this->replies;
	}


	/**
	 */
	function getLastReplyTime() {
		$db = DB::getHandle();
		$db->query(
			ClassForum_Queries::getQuery('lastPostThread',
				array($this->_dao->getPrimaryKey())
			)
		);
		$db->nextRecord();

		$this->lastPostTime = $db->record['last_post_time'];
		return $this->lastPostTime;
	}


	function getForum() {
		return ClassForum_Forums::load($this->_dao->classForumId);
	}


	/**
	 * getThread returns the entire thread, including the topic starter
	 * so the number of replies is the thread - 1
	 * @return int reply count for this post
	 */
	function getReplyCount() {
		if ( !$this->threadLoaded ) {
			$this->getThread();
		}
		return count($this->replies)-1;
	}


	function getForumId() {
		return $this->_dao->classForumId;
	}


	function getPostId() {
		return $this->_dao->classForumPostId;
	}


	function getThreadId() {
		return $this->_dao->threadId;
	}


	function setThreadId($id) {
		$this->_dao->set('threadId',$id);
	}


	function setUser($uname) {
		$this->_dao->set('userId',$uname);
	}


	function setSubject($s) {
		$this->_dao->set('subject',htmlentities($s));
	}


	function setMessage($m) {
		$this->_dao->set('message',htmlentities($m));
	}

	function setForumId($id) {
		$this->_dao->set('classForumId',intval($id));
	}


	/**
	 * Returns unix timestamp of when this post was posted
	 *
	 */
	function getTime() {
		return $this->_dao->postTimedate;
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
		return ClassForum_Posts::swapForumTags($this->_dao->message);
	}



	function getSubject() {
		return $this->_dao->subject;
	}


	/**
	 * Changes [TAG] into <TAG>
	 *
	 * only works for QUOTE, CODE, B, I.
	 * don't use nl2br on text inside [CODE] tags because it's
	 * already in a PRE tag.
	 * @static
	 * @param string $code the forum code that needs to be converted
	 * @return string HTML ready code
	 */
	function swapForumTags($code) {
		$code = nl2br($code);

		//this is an expensive operation, only do it if we have
		// find a code tag
		if (strpos($code, '[/CODE]') > 1 ) {
		//remove BR tags inbetween CODE tags because they are going to have
		// a PRE around them
		$code = preg_replace_callback(
			"#\[CODE([^\]]*)\](((?!\[/?CODE(?:[^\]]*)\]).)*)\[/CODE\]#si",
			create_function(
				//nl2br doesn't replace the new line, it only appends to it
				'$matches',
				'return "[CODE]".str_replace("<br />","", $matches[2])."[/CODE]";'
			),
		$code);
		}


		//do regular FORUM CODE tag to html tag replacement
		$code = str_replace('[QUOTE]','<div class="forum_quote_shell"><b>Quote:</b><blockquote class="forum_quote">',$code);
		$code = str_replace('[/QUOTE]','</blockquote></div>',$code);

		//sneak the original codeText back in, after the nl2br
		$code = str_replace('[CODE]','<div class="forum_code_shell"><b>Code:</b><blockquote class="forum_code"><pre>',$code);
		$code = str_replace('[/CODE]','</pre></blockquote></div>',$code);

		//BOLD
		$code = str_replace('[B]','<B>',$code);
		$code = str_replace('[/B]','</B>',$code);

		$code = str_replace('[b]','<B>',$code);
		$code = str_replace('[/b]','</B>',$code);

		//ITALICS
		$code = str_replace('[I]','<I>',$code);
		$code = str_replace('[/I]','</I>',$code);

		$code = str_replace('[i]','<I>',$code);
		$code = str_replace('[/i]','</I>',$code);

		return $code;
	}


	/**
	 * Save
	 */
	function save() {
		return $this->_dao->save();
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


	function load($postId) {
		$x = ClassForum::load($postId);
		$y = new ClassForum_Forums();
		$y->_dao = $x;
		return $y;
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
	 * Is this forum viewable by users?
	 */
	function isVisible() {
		return $this->_dao->get('isVisible');
	}


	/**
	 * Is this forum viewable by users?
	 */
	function setVisible($b = true) {
		return $this->_dao->set('isVisible', $b);
	}


	/**
	 * Is this forum locked? (don't allow posts nor editing)
	 */
	function isLocked() {
		return $this->_dao->get('isLocked');
	}


	/**
	 * Is this person a moderator? for right now just check if
	 * the person is a faculty member, and the forum matches their 
	 * class id.
	 */
	function isModerator($u) {
		return ($u->isFaculty() && $this->_dao->get('classForumId') == $u->activeClassTaught->id_classes);
	}


	/**
	 * Save
	 */
	function save() {
		return $this->_dao->save();
	}


	/**
	 * Retrieve a list of all class forums 
	 * the response is sorted alphbetically and tied to the 
	 * category sort
	 *
	 * @static
	 * @param classId int id of the current class
	 */
	function getAll($classId) {

		$classId = intval($classId);
		$db = DB::getHandle();
		$db->query(
			ClassForum_Queries::getQuery('forumsSorted',
				array($classId)
			)
		);
		while ($db->nextRecord()) {
			$list[] = ClassForumPeer::row2Obj($db->record);
		}

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


	function getClassId() {
		return $this->_dao->classId;
	}


	function getForumId() {
		return $this->_dao->classForumId;
	}


	/**
	 * Get a count of posts under this forum, excluding topics
	 * (topics are thread starters, posts that were not a reply to anything)
	 */
	function getPostCount() {
		if ($this->postCount < 0) {
			$db = DB::getHandle();
			$db->query(
				ClassForum_Queries::getQuery('replyCountForum',
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


	/**
	 */
	function getLastPostTime() {
		$db = DB::getHandle();
		$db->query(
		//echo(
			ClassForum_Queries::getQuery('lastPostForum',
				array($this->_dao->getPrimaryKey())
			)
		);
		$db->nextRecord();

		$this->lastPostTime = $db->record['last_post_time'];
		return $this->lastPostTime;
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
		$generalDao = new ClassForumCategory();
		$generalDao->set('name','General');
		$generalDao->set('classForumCategoryId',0);
		$generalCategory = new ClassForum_Categories();
		$generalCategory->_dao = $generalDao;
		$objList[] = $generalCategory;

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

		$this->queries['postCountThread']  = 
		'SELECT count(class_forum_post_id) as num
		FROM `class_forum_post`
		WHERE class_forum_id = %d
		AND thread_id = %d';

		$this->queries['replyCountForum']  = 
		'SELECT count(class_forum_post_id) as num
		FROM `class_forum_post`
		WHERE class_forum_id = %d
		AND reply_id IS NOT NULL';

		$this->queries['topicCountForum']  = 
		'SELECT count(class_forum_post_id) as num
		FROM `class_forum_post`
		WHERE class_forum_id = %d
		AND thread_id = class_forum_post_id';

		$this->queries['forumsSorted'] = 
		'SELECT class_forum_id,A.name,A.class_id,is_locked,is_visible,is_moderated,allow_uploads,description,class_forum_recent_post_timedate,class_forum_recent_poster,class_forum_thread_count,class_forum_post_count,class_forum_unanswered_count,A.class_forum_category_id 
		FROM class_forum A
		LEFT JOIN class_forum_category B
		  ON A.class_forum_category_id = B.class_forum_category_id
		WHERE A.class_id=%d ORDER BY B.name, A.class_forum_category_id, A.name ASC';

		$this->queries['unsetAllForums']  = 
		'UPDATE `class_forum`
		SET %s = 0
		WHERE class_id = %d';

		$this->queries['setForum']  = 
		'UPDATE `class_forum`
		SET %s = 1
		WHERE class_forum_id = %d
		AND class_id = %d';

		$this->queries['lastPostForum']  = 
		'SELECT MAX(post_timedate) as last_post_time
		FROM `class_forum_post`
		WHERE class_forum_id = %d';

		$this->queries['lastPostThread']  = 
		'SELECT MAX(post_timedate) as last_post_time
		FROM `class_forum_post`
		WHERE thread_id = %d
		AND reply_id IS NOT NULL';

		$this->queries['moveThreadForum']  = 
		'UPDATE `class_forum_post`
		SET class_forum_id = %d
		WHERE thread_id = %d';
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
