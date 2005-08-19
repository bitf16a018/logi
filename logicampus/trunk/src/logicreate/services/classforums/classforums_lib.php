<?php

include_once(LIB_PATH."PBDO/ClassForum.php");
include_once(LIB_PATH."PBDO/ClassForumCategory.php");
include_once(LIB_PATH."PBDO/ClassForumPost.php");
include_once(LIB_PATH."PBDO/ClassForumTrashPost.php");


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
		if  (!is_object($x) ) {
			$x = new ClassForumPost();
		}
		$y = new ClassForum_Posts();
		$y->_dao = $x;
		return $y;
	}


	/**
	 * Wraps a different DAO under the same user class
	 */
	function loadFromTrash($threadId) {
		$query = ' thread_id='.$threadId.' and reply_id IS NULL ';
		$list = ClassForumTrashPostPeer::doSelect($query);

		$x = $list[0];
		if  (!is_object($x) ) {
			$x = new ClassForumTrashPost();
		}
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
	function getTopics($forumId, $limit=-1, $start=-1) {

		$forumId = intval($forumId);
		$query = ' class_forum_id='.$forumId.' and thread_id = class_forum_post_id ORDER BY is_sticky DESC, post_datetime DESC';
		if ($limit > -1) {
			$query .= ' LIMIT '.$start.', '.$limit;
		}
		$list = ClassForumPostPeer::doSelect($query);

		$objList = array();
		foreach ($list as $k=>$v) {
			$x = new ClassForum_Posts();
			$x->_dao = $v;
			$objList[] = $x;
		}
		return $objList;
	}


	/**
	 * Retrieve a list of all 'topic' posts in the trash
	 * Topics have a null thread ID because they are not
	 * replying to any particular topic.
	 *
	 * @static
	 * @param forumId int id of the forum
	 */
	function getTrashTopics($classId, $limit=-1, $start=-1) {

		if ($limit > -1) {
			$query = ClassForum_Queries::getQuery('trashTopicsLimit',
				array($classId,$start,$limit)
				);

		} else {
			$query = ClassForum_Queries::getQuery('trashTopics',
				array($classId)
				);
		}

		$db = DB::getHandle();
		$db->query(
			$query
		);
		$objList = array();
		while ( $db->nextRecord() ) {
			$x = new ClassForum_Posts();
			$v = ClassForumTrashPostPeer::row2obj($db->record);
			$x->_dao = $v;
			$objList[] = $x;
		}

		return $objList;
	}


	/**
	 * get's the entire thread, including topic starter
	 */
	function getThread($limit=-1, $start=-1) {

		$topicId = intval($this->getPostId());
		$query =' thread_id='.$topicId.' and thread_id IS NOT NULL ORDER BY is_sticky DESC, post_datetime ASC';
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
	 * get's the entire thread from the trash
	 */
	function getTrashThread($limit=-1, $start=-1) {

		$threadId = intval($this->_dao->get('threadId'));
		$query =' thread_id='.$threadId.' ORDER BY is_sticky DESC, post_datetime ASC';
		if ($limit > -1) {
			$query .= ' LIMIT '.$start.', '.$limit;
		}
		$list = ClassForumTrashPostPeer::doSelect($query);

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
			ClassForum_Queries::getQuery('lastReplyThread',
				array($this->_dao->getPrimaryKey())
			)
		);
		$db->nextRecord();

		$this->lastPostTime = $db->record['last_post_time'];
		return (int)$this->lastPostTime;
	}


	/**
	 * Wrapper function so table render's can call one function
	 */
	function getLastPostTime() {
		$db = DB::getHandle();
		$db->query(
			ClassForum_Queries::getQuery('lastPostThread',
				array($this->_dao->getPrimaryKey())
			)
		);
		$db->nextRecord();

		$this->lastPostTime = $db->record['last_post_time'];
		return (int)$this->lastPostTime;
	}


	/**
	 * This is a wrapper function for the ClassForum_Settings so
	 * that the table renderers can call one function, be it against
	 * a forum or a post
	 */
	function getLastVisit($u) {
		return ClassForum_Settings::getLastThreadVisit($u,$this);
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


	function getUser() {
		return $this->_dao->get('userId');
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
		return $this->_dao->postDatetime;
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


	/**
	 * Make a copy of this post and all replies in the trash table
	 */
	function trashThread() {
		$this->getThread();
		foreach ($this->replies as $x=>$v) {
			$v->trash();
		}
		//the post itself is included in the replies array
		//get thread is the entire thread
	}


	/**
	 * Make a copy of this post in the trash table
	 */
	function trash() {
		$attribs = array('classForumId','isHidden','isSticky',
			'lastEditDatetime','lastEditUsername',
			'message','postDatetime','replyId',
			'subject','threadId','userId');

		$trashPost = new ClassForumTrashPost();
		for ($x=0; $x < count($attribs); ++$x) {
			$trashPost->set($attribs[$x],$this->_dao->get($attribs[$x]));
		}

		$okay = $trashPost->save();
		$okay &= $this->_dao->delete();
		return $okay;
	}


	/**
	 * Make a copy of this post and all replies in the trash table
	 */
	function unTrashThread() {
		$this->getTrashThread();
		foreach ($this->replies as $x=>$v) {
			$v->unTrash();
		}
		//the post itself is included in the replies array
		//get thread is the entire thread
	}


	/**
	 * Make a copy of this post in the trash table
	 */
	function unTrash() {
		$attribs = array('classForumId','isHidden','isSticky',
			'lastEditDatetime','lastEditUsername',
			'message','postDatetime','replyId',
			'subject','threadId','userId');

		$unTrashPost = new ClassForumPost();
		for ($x=0; $x < count($attribs); ++$x) {
			$unTrashPost->set($attribs[$x],$this->_dao->get($attribs[$x]));
		}

		$okay = $unTrashPost->save();
		$okay &= $this->_dao->delete();
		return $okay;
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
		if  (!is_object($x) ) {
			$x = new ClassForum();
		}
		$y = new ClassForum_Forums();
		$y->_dao = $x;
		return $y;
	}


	/**
	 * Set Name
	 */
	function setName($n) {
		$this->_dao->set('name',htmlentities($n));
	}


	/**
	 * Set Description
	 */
	function setDescription($n) {
		$this->_dao->set('description',htmlentities($n));
	}


	/**
	 * Set ClassId
	 */
	function setClassId($id) {
		$this->_dao->set('classId',(int)$id);
	}

	/**
	 * Set CategoryId
	 */
	function setCategoryId($id) {
		$this->_dao->set('classForumCategoryId',(int)$id);
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
		return ($u->isFaculty() && $this->_dao->get('classId') == $u->activeClassTaught->id_classes);
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


	function getName() {
		return $this->_dao->get('name');
	}


	function getDescription() {
		return $this->_dao->get('description');
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
	 * Get a count of topics under this forum
	 *
	 * @static
	 */
	function staticGetTopicCount($fid=-1) {
		if ($fid < 0 ) {
			return 0;
		}

		$db = DB::getHandle();
		$db->query(
			ClassForum_Queries::getQuery('topicCountForum',
				array($fid)
			)
		);
		$db->nextRecord();
		return $db->record['num'];
	}


	/**
	 * Get a count of topics under the trash
	 *
	 * @static
	 */
	function staticGetTrashTopicCount($classId) {

		$db = DB::getHandle();
		$db->query(
			ClassForum_Queries::getQuery('topicCountTrash',
				array($classId)
			)
		);
		$db->nextRecord();
		return $db->record['num'];
	}


	/**
	 */
	function getLastPostTime() {
		$db = DB::getHandle();
		$db->query(
			ClassForum_Queries::getQuery('lastPostForum',
				array($this->_dao->getPrimaryKey())
			)
		);
		$db->nextRecord();

		$this->lastPostTime = $db->record['last_post_time'];
		return $this->lastPostTime;
	}


	/**
	 * This is a wrapper function for the ClassForum_Settings so
	 * that the table renderers can call one function, be it against
	 * a forum or a post
	 */
	function getLastVisit($u) {
		return ClassForum_Settings::getLastForumVisit($u,$this);
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
 * Handle settings and last visit time
 */
class ClassForum_Settings {


	/**
	 * set a cookie with this forum's ID for one year
	 */
	function setLastThreadVisit($u,$thread) {
		if (! is_object($thread) ) {
			return 0;
		}
		$threadId = $thread->getPostId();
		$forumId = $thread->getForumId();
		$db = DB::getHandle();
		$db->query(
			ClassForum_Queries::getQuery('getUserViews',
				array ($u->userId, $forumId)
			)
		);
		$db->nextRecord();
		if ( $db->getNumRows() < 1 ) {
			$queryName = 'addUserViews';
		} else {
			$queryName = 'setUserViews';
		}
		$viewStruct = unserialize(base64_decode($db->record['views']));
		$viewStruct['forum'][$forumId] = time();
		$viewStruct['thread'][$threadId] = time();
		$views = base64_encode(serialize($viewStruct));
		$db->query(
			ClassForum_Queries::getQuery($queryName,
				array ($views, $u->userId, $forumId)
			)
		);
	}


	function getLastForumVisit($u,$forum) {
		if (! is_object($forum) ) {
			return 0;
		}
		$forumId = $forum->getForumId();

		$db = DB::getHandle();
		$db->query(
			ClassForum_Queries::getQuery('getUserViews',
				array ($u->userId, $forumId)
			)
		);
		$db->nextRecord();
		$viewStruct = unserialize(base64_decode($db->record['views']));
		return (int)$viewStruct['forum'][$forumId];
	}


	function getLastThreadVisit($u,$thread) {
		if (! is_object($thread) ) {
			return 0;
		}
		$threadId = $thread->getPostId();
		$forumId = $thread->getForumId();
		$db = DB::getHandle();
		$db->query(
			ClassForum_Queries::getQuery('getUserViews',
				array ($u->userId, $forumId)
			)
		);
		$db->nextRecord();
		$viewStruct = unserialize(base64_decode($db->record['views']));
		return (int)$viewStruct['thread'][$threadId];
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

		$this->queries['topicCountTrash']  = 
		'SELECT count(class_forum_trash_post_id) as num
		FROM `class_forum_trash_post` A
		LEFT JOIN class_forum B
		  ON A.class_forum_id = B.class_forum_id
		WHERE reply_id IS NULL
		AND B.class_id = %d';

		$this->queries['forumsSorted'] = 
		'SELECT A.*
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
		'SELECT MAX(post_datetime) as last_post_time
		FROM `class_forum_post`
		WHERE class_forum_id = %d';

		$this->queries['lastReplyThread']  = 
		'SELECT MAX(post_datetime) as last_post_time
		FROM `class_forum_post`
		WHERE thread_id = %d
		AND reply_id IS NOT NULL';

		$this->queries['lastPostThread']  = 
		'SELECT MAX(post_datetime) as last_post_time
		FROM `class_forum_post`
		WHERE thread_id = %d';

		$this->queries['moveThreadForum']  = 
		'UPDATE `class_forum_post`
		SET class_forum_id = %d
		WHERE thread_id = %d';

		$this->queries['getUserViews']  = 
		'SELECT views 
		FROM `class_forum_user_activity`
		WHERE user_id = %d
		AND class_forum_id = %d';

		$this->queries['setUserViews']  = 
		'UPDATE `class_forum_user_activity`
		SET views = "%s"
		WHERE user_id = %d
		AND class_forum_id = %d';

		$this->queries['addUserViews']  = 
		'INSERT INTO `class_forum_user_activity`
		(views, user_id, class_forum_id)
		VALUES ("%s", %d, %d)';

		$this->queries['trashTopics']  = 
		'SELECT A.* 
		FROM class_forum_trash_post A
		LEFT JOIN class_forum B
		  ON A.class_forum_id = B.class_forum_id
		WHERE B.class_id = %d';

		$this->queries['trashTopicsLimit']  = 
		'SELECT A.* 
		FROM class_forum_trash_post A
		LEFT JOIN class_forum B
		  ON A.class_forum_id = B.class_forum_id
		WHERE B.class_id = %d
		LIMIT %d, %d';
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

