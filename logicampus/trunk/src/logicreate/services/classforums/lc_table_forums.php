<?php

include_once(LIB_PATH.'lc_table.php');
include_once(LIB_PATH.'lc_table_renderer.php');


class LC_Table_ForumThread extends LC_TablePaged {

	var $maxRows = -1;

	/**
	 * Constructor uses an automatic LC_Table_ForumThreadModel
	 */
	function LC_Table_ForumThread($postId, $cp, $rpp) {
		$this->rowsPerPage = $rpp;
		$this->currentPage = $cp;
		$this->postId = $postId;

		$dataModel = new LC_Table_ForumThreadModel($postId, $cp, $rpp);

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

class LC_Table_ForumThreadModel extends LC_TableModelPaged {

	var $topicId;
	var $topicObj;
	var $replies = array();

	function LC_Table_ForumThreadModel($postId, $cp, $rpp) {
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



class LC_TableIconRenderer extends LC_TableCellRenderer {

	function getRenderedValue() {
		if ($this->row % 2 == 0 ) {
			return '<img height="32" width="32" src="'.IMAGES_URL.'messages_new.png" title="new posts" alt="new posts">';
		} else {
			return '<img height="32" width="32" src="'.IMAGES_URL.'messages_read.png" title="new posts" alt="new posts">';
			return 'no new posts.&nbsp;';
		}
	}
}



class LC_TableRenderer_ForumTopic extends LC_TableCellRenderer {

	function getRenderedValue() {
		return '<a href="'.appurl('classforums/posts/').'post_id='.$this->value->getPostId().'">'.$this->value->getSubject().'</a> <br/>'.substr($this->value->getMessage(),0,45);
	}
}



class LC_TableRenderer_ForumLastReply extends LC_TableCellRenderer {

	var $dateFormat;

	function getRenderedValue() {
		$ret = date($this->dateFormat, $this->value->_dao->postTimedate);
		$ret .= '<br/><a href="'.appurl('classforums/posts/').'post_id='.$this->value->getPostId().'">Go to last page</a>';

		return $ret;
	}
}



class LC_TableRenderer_ForumAuthor extends LC_TableCellRenderer {


	function getRenderedValue() {

		$ret .= $this->value;
		//$ret .= '<br/><img height="32" width="32" src="http://dev.logicampus.com/images/messages_new.png" title="new posts" alt="new posts"><br/>';
		$ret .= '<br/>[PENDING PHOTO]<br/>';

		$ret .= '<a href="">View Profile</a>';
		return $ret;
	}
}



class LC_TableRenderer_ForumPost extends LC_TableCellRenderer {

	var $dateFormat = 'M d y';
	var $dateTimeFormat = 'M d \'y - h:i A';

	function getRenderedValue() {
		$ret  = '<div style="float:left">posted on : '.date($this->dateTimeFormat,$this->value->getTime()).'</div>';
		$ret .= '<div align="right">';
		$ret .= '<a href="'.modurl('posts/event=reply/post_id='.$this->value->getPostId()).'">Reply</a> | ';
		$ret .= '<a href="'.modurl('posts/event=reply/quote=true/post_id='.$this->value->getPostId()).'">Reply &amp; Quote</a> | ';
		$ret .=  'Edit</div>';

		$ret .= "<hr>\n\t\t";
		$ret .= $this->value->showMessage();
		$ret .= "<hr>\n\t\t";
		$ret .= $this->value->getPostId();

		$ret .= "\n<br><p>&nbsp;</p>\n\t\t";

		return $ret;
	}
}



class LC_TableCheckboxRenderer extends LC_TableCellRenderer {

	var $selectedVal;
	var $selectedKey;
	var $idName;
	var $fieldName = 'item';

	function getRenderedValue() {
		//is the value an array ?
		if ( is_array($this->value) ) {
			$idValue = $this->value[$this->idName];
			$selected = ($this->selectedVal == $this->value[$this->selectedKey]) ? ' CHECKED ':'';
		}
		//is it a PBDO object wrapper?
		else if ( is_object($this->value) && is_object($this->value->_dao) ) {
			$idValue = $this->value->_dao->getPrimaryKey();
			$selected = ($this->selectedVal == $this->value->_dao->{$this->selectedKey}) ? ' CHECKED ':'';
		}
		//is it a regular object?
		else if ( is_object($this->value) ) {
			$idValue = $this->value->{$this->idName};
			$selected = ($this->selectedVal == $this->value->{$this->selectedKey}) ? ' CHECKED ':'';
		}
//		$selected = ($this->selectedVal == $this->value[$this->selectedKey]) ? ' CHECKED ':'';
		return '<input id="'.$this->fieldName.'['.$this->row.']" name="'.$this->fieldName.'['.$this->row.']" value="'.$idValue.'" '.$selected.' type="checkbox">';
	}
}


?>
