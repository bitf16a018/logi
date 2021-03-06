<?php

include_once(LIB_PATH.'lc_table.php');
include_once(LIB_PATH.'lc_table_renderer.php');


class LC_Table_ForumThread extends LC_TablePaged {

	var $maxRows = -1;

	/**
	 * Constructor uses an automatic LC_TableModel_ForumThread
	 */
	function LC_Table_ForumThread($postId, $cp, $rpp) {
		$this->rowsPerPage = $rpp;
		$this->currentPage = $cp;
		$this->postId = $postId;

		$dataModel = new LC_TableModel_ForumThread($postId, $cp, $rpp);

		parent::LC_Table($dataModel);
	}


	/**
	 * Return the forum id of this thread
	 */
	function getThreadId() {
		if ( is_object($this->tableModel->topicObj) ) {
			return $this->tableModel->topicObj->getThreadId();
		} else {
			return false;
		}
	}


	/**
	 * Return the forum id of this thread
	 */
	function getForumId() {
		if ( is_object($this->tableModel->topicObj) ) {
			return $this->tableModel->topicObj->getForumId();
		} else {
			return false;
		}
	}


	function setRowsPerPage($n) {
		$this->rowsPerPage = $n;
		$this->dataModel->rowsPerPage = $n;
	}


	function getPrevUrl() {
		$prevPage = $this->currentPage -1;
		if ($prevPage < 1) {
			$prevPage = 1;
		}

		return $this->getPageUrl($prevPage);
	}


	function getNextUrl() {
		$maxRows = $this->getMaxRows();
		$pages = ceil($maxRows / $this->rowsPerPage);
		$nextPage = $this->currentPage +1;
		if ($nextPage > $pages) {
			$nextPage = $pages;
		}

		return $this->getPageUrl($nextPage);
	}


	function getPageUrl($i) {
		return modurl('posts/post_id='.$this->postId.'/page='.$i);
	}


	function getMaxRows() {
		if ($this->maxRows > -1) {
			return $this->maxRows;
		}

		$db = DB::getHandle();
		$db->query(
			ClassForum_Queries::getQuery('postCountThread',
			array($this->getForumId(),
				$this->getThreadId())
			)
		);

		$db->nextRecord();
		return $db->record['num'];
	}

}

class LC_TableModel_ForumThread extends LC_TableModelPaged {

	var $topicId;
	var $topicObj;
	var $replies = array();

	function LC_TableModel_ForumThread($postId, $cp, $rpp) {
		$this->rowsPerPage = $rpp;
		$this->currentPage = $cp;
		$this->topicId = $postId;
		$this->topicObj = ClassForum_Posts::load($postId);
		$this->replies = $this->topicObj->getThread($this->rowsPerPage, (($this->currentPage-1) * $this->rowsPerPage));
	}


	function getRowCount() {
		//FIXME this won't work on the last page
		$x = count($this->replies);
		if ($x > $this->rowsPerPage) {
			return $this->rowsPerPage;
		}
		return $x;
	}


	function getMaxRows() {
		return 100;
	}


	/**
	 * Returns the number of cols in the model.
	 */
	function getColumnCount() {
		return 2;
	}


	/**
	 * Returns the name of a column.
	 */
	function getColumnName($columnIndex) {
		switch ($columnIndex) {
			case '0':
				return 'Author'; break;

			case '1':
				if (is_object($this->topicObj) ) {
					return 'Post: '.$this->topicObj->_dao->subject;
				} else {
					return 'Post';
				}
				break;

		}
	}


	/**
	 * return the value at an x,y coord
	 */
	function getValueAt($x,$y) {
		$post = $this->replies[$x];

		switch ($y) {
			case 0:
				return $post->_dao->userId;
			case 1:
				return $post;
		}
	}
}



class LC_TableNewMessageRenderer extends LC_TableCellRenderer {

	var $u;

	function getRenderedValue() {
		if (! is_object($this->value) ) {
			return '';
		}

		//posts and forums both use this function, but only forums can be locked
		if ( method_exists($this->value, 'isLocked') && $this->value->isLocked() ) {
			return '<img height="32" width="32" src="'.IMAGES_URL.'messages_locked.png" title="new posts" alt="new posts"><br/>LOCKED';
		}

		$x = $this->value->getLastVisit($this->u);
		$y = $this->value->getLastPostTime();
		//echo "$x <br>$y <hr>";
		if ($y > $x ) {
			return '<img height="32" width="32" src="'.IMAGES_URL.'messages_new.png" title="new posts" alt="new posts"><br/>NEW MESSAGES';
		} else {
			return '<img height="32" width="32" src="'.IMAGES_URL.'messages_read.png" title="new posts" alt="new posts">';
		}
	}
}



class LC_TableRenderer_ForumTopic extends LC_TableCellRenderer {

	function getRenderedValue() {
		return '<a href="'.appurl('classforums/posts/').'post_id='.$this->value->getPostId().'">'.$this->value->getSubject().'</a> <br/>'.substr($this->value->getMessage(),0,45);
	}
}



class LC_TableRenderer_TrashTopic extends LC_TableCellRenderer {

	function getRenderedValue() {
		return '<b>'.$this->value->getSubject().'</b> <br/>'.substr($this->value->getMessage(),0,100);
	}
}



class LC_TableRenderer_ForumLastReply extends LC_TableCellRenderer {

	var $dateFormat;

	function getRenderedValue() {

		$lastPostTime = $this->value->getLastReplyTime();
		if ($lastPostTime < 1) {
			//there are no replies
			return '&nbsp;';
		}
		$ret = date($this->dateFormat, $lastPostTime);
		//$ret .= '<br/><a href="'.appurl('classforums/posts/').'post_id='.$this->value->getPostId().'">Go to last page</a>';

		return $ret;
	}
}



class LC_TableRenderer_ForumAuthor extends LC_TableCellRenderer {


	function getRenderedValue() {

		$ret .= $this->value;
		//$ret .= '<br/><img height="32" width="32" src="http://dev.logicampus.com/images/messages_new.png" title="new posts" alt="new posts"><br/>';
		//$ret .= '<br/>[PENDING PHOTO]';

		$ret .= '<br/><a href="'.appurl('users/view/'.$this->value).'">View Profile</a>';
		return $ret;
	}
}



class LC_TableRenderer_ForumPost extends LC_TableCellRenderer {

	var $dateFormat = 'M d y';
	var $dateTimeFormat = 'M j, Y - h:i A';
	var $userIsModerator = false;
	var $username = '';

	function getRenderedValue() {
		$ret  = '<div style="float:left">posted on : '.date($this->dateTimeFormat,$this->value->getTime());
		if ($this->value->_dao->lastEditDatetime > 0 ) {
			$ret .= "<br/><span style=\"font-weight:bold\">edited on: " .date($this->dateTimeFormat,$this->value->_dao->lastEditDatetime). " by: ".$this->value->_dao->lastEditUsername."</span>";
		}
		$ret .= '</div>';

		$ret .= '<div align="right">';
		$forum = $this->value->getForum();
		if ( !$forum->isLocked() ) {
		$ret .= '<a href="'.modurl('posts/event=reply/post_id='.$this->value->getPostId()).'">Reply</a> | ';
		$ret .= '<a href="'.modurl('posts/event=reply/quote=true/post_id='.$this->value->getPostId()).'">Reply &amp; Quote</a> ';
		}

		if ($this->userIsModerator
			|| $this->value->getUser() == $this->username) {
			$ret .= ' | <a href="'.modurl('posts/event=edit/post_id='.$this->value->getPostId()).'">Edit</a> ';
		}
		$ret .= '</div>';

		$ret .= "<hr style=\"clear:both\">\n\t\t";
		$ret .= $this->value->showMessage();
		//$ret .= "<hr>\n\t\t";
		//$ret .= $this->value->getPostId();

		$ret .= "\n<br><p>&nbsp;</p>\n\t\t";

		return $ret;
	}
}


class LC_TablePaged_TopicList extends LC_TablePaged {

	var $forumId = 0;

	function getMaxRows() {
		return $this->tableModel->getMaxRows();
	}


	function getPrevUrl() {
		$prevPage = $this->currentPage -1;
		if ($prevPage < 1) {
			$prevPage = 1;
		}

		return $this->getPageUrl($prevPage);
	}


	function getNextUrl() {
		$maxRows = $this->getMaxRows();
		$pages = ceil($maxRows / $this->rowsPerPage);
		$nextPage = $this->currentPage +1;
		if ($nextPage > $pages) {
			$nextPage = $pages;
		}

		return $this->getPageUrl($nextPage);
	}


	function getPageUrl($i) {
		return modurl('forum/forum_id='.$this->forumId.'/page='.$i);
	}
}



class LC_TableModel_TopicList extends LC_TableModelPaged {

	var $posts = array();

	/**
	 * Paged topic listing of a forum
	 */
	function LC_TableModel_TopicList($fid, $rpp, $cp) {
		$this->rowsPerPage = $rpp;
		$this->currentPage = $cp;

		$this->posts = ClassForum_Posts::getTopics($fid, $rpp, ($cp-1) * $rpp);
		$this->maxPosts = ClassForum_Forums::staticGetTopicCount($fid);
	}


	//sub-class
	/**
	 * Returns the number of rows in the model.
	 */
	function getRowCount() {
		return (count($this->posts));
	}


	//sub-class
	/**
	 * Returns the number of rows in the model.
	 */
	function getMaxRows() {
		return $this->maxPosts;
	}


	/**
	 * Returns the number of cols in the model.
	 */
	function getColumnCount() {
		return 5;
	}


	/**
	 * Returns the name of a column.
	 */
	function getColumnName($columnIndex) {
		switch ($columnIndex) {
			case '0':
				return '&nbsp;'; break;

			case '1':
				return 'Topics'; break;

			case '2':
				return 'Started By'; break;

			case '3':
				return 'Replies'; break;

			case '4':
				return 'Last Reply'; break;
		}
	}


	/**
	 * return the value at an x,y coord
	 */
	function getValueAt($x,$y) {
		$post = $this->posts[$x];
		switch ($y) {
			case 0:
				return $post;
			case 1:
				return $post;
			case 2:
				return $post->_dao->userId;
			case 3:
				return $post->getReplyCount();
			case 4:
				return $post;
		}
	}
}



class LC_TablePaged_TrashTopicList extends LC_TablePaged_TopicList {

	function getPageUrl($i) {
		return modurl('forumAdmin/event=viewTrash/page='.$i);
	}
}



class LC_TableModel_TrashTopicList extends LC_TableModel_TopicList {

	var $posts = array();


	/**
	 * Paged topic listing of a forum
	 */
	function LC_TableModel_TrashTopicList($classId, $rpp, $cp) {
		$this->rowsPerPage = $rpp;
		$this->currentPage = $cp;

		$this->posts = ClassForum_Posts::getTrashTopics($classId, $rpp, ($cp-1) * $rpp);
		$this->maxPosts = ClassForum_Forums::staticGetTrashTopicCount($classId);
	}


	/**
	 * Returns the number of cols in the model.
	 */
	function getColumnCount() {
		return 4;
	}


	/**
	 * Returns the name of a column.
	 */
	function getColumnName($columnIndex) {
		switch ($columnIndex) {
			case '0':
				return 'Threads'; break;

			case '1':
				return 'Started By'; break;

			case '2':
				return 'Original Forum'; break;

			case '3':
				return '&nbsp;'; break;
		}
	}


	/**
	 * return the value at an x,y coord
	 */
	function getValueAt($x,$y) {
		$post = $this->posts[$x];
		switch ($y) {
			case 0:
				return $post;
			case 1:
				return $post->_dao->userId;
			case 2:
				$f = $post->getForum(); return $f->getName();
			case 3:
				return '<a href="'.modurl('forumAdmin/event=unTrash/thread_id='.$post->_dao->threadId).'">[&nbsp;Un-Trash&nbsp;]</a>';
		}
	}
}


?>
