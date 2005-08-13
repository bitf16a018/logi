<?php

include_once(LIB_PATH.'lc_table.php');
include_once(LIB_PATH.'lc_table_renderer.php');


class LC_Table_ForumThread extends LC_Table {

	var $rowsPerPage = 30;

	/**
	 * Constructor uses an automatic LC_Table_ForumThreadModel
	 */
	function LC_Table_ForumThread($postId) {

		$dataModel = new LC_Table_ForumThreadModel($postId);

		parent::LC_Table($dataModel);
	}

	function setRowsPerPage($n) {
		$this->rowsPerPage = $n;
		$this->dataModel->rowsPerPage = $n;
	}

}

class LC_Table_ForumThreadModel extends LC_TableModel {

	var $topicId;
	var $topicObj;
	var $replies = array();
	var $rowsPerPage = 30;

	function LC_Table_ForumThreadModel($postId) {
		$this->topicId = $postId;
		$this->topicObj = ClassForum_Posts::load($postId);
		$this->replies = $this->topicObj->getReplies();
	}


	function getRowCount() {
		//FIXME this won't work on the last page
		$x = count($this->replies) + 1;
		if ($x > $this->rowsPerPage) {
			return $this->rowsPerPage;
		}
		return $x;
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
		if ($x == 0 ) {
			$post = $this->topicObj;
		} else {
			$post = $this->replies[$x-1];
		}
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
			return '<img height="32" width="32" src="http://dev.logicampus.com/images/messages_new.png" title="new posts" alt="new posts">';
		} else {
			return '<img height="32" width="32" src="http://dev.logicampus.com/images/messages_read.png" title="new posts" alt="new posts">';
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

	function getRenderedValue() {
		$ret  = '<div style="float:left">posted on : 8/10/2005</div>';
		$ret .= '<div align="right">';
		$ret .= '<a href="'.modurl('posts/event=reply/p_id='.$this->value->getPostId()).'">Reply</a> | ';
		$ret .= '<a href="'.modurl('posts/event=reply/quote=true/p_id='.$this->value->getPostId()).'">Reply &amp; Quote</a> | ';
		$ret .=  'Edit</div>';

		$ret .= "<hr>\n\t\t";
		$ret .= $this->value->showMessage();

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
		}
		//is it a PBDO object wrapper?
		else if ( is_object($this->value) && is_object($this->value->_dao) ) {
			$idValue = $this->value->_dao->getPrimaryKey();
		}
		//is it a regular object?
		else if ( is_object($this->value) ) {
			$idValue = $this->value->{$this->idName};
		}
		$selected = ($this->selectedVal == $this->value[$this->selectedKey]) ? ' CHECKED ':'';
		return '<input id="'.$this->fieldName.'['.$this->row.']" name="'.$this->fieldName.'['.$this->row.']" value="'.$idValue.'" '.$selected.' type="checkbox">'.$idValue;
	}
}


?>
