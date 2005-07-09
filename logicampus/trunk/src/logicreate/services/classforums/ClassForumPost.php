<?

class ClassForumPostBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.4';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $classForumPostId;
	var $classForumId;
	var $isSticky;
	var $replyId;
	var $threadId;
	var $subject;
	var $message;
	var $userId;
	var $postTimedate;
	var $classForumPostStatus;

	var $__attributes = array(
	'classForumPostId'=>'integer',
	'classForumId'=>'integer',
	'isSticky'=>'tinyint',
	'replyId'=>'integer',
	'threadId'=>'integer',
	'subject'=>'varchar',
	'message'=>'longvarchar',
	'userId'=>'varchar',
	'postTimedate'=>'integer',
	'classForumPostStatus'=>'integer');



	function getPrimaryKey() {
		return $this->classForumPostId;
	}

	function setPrimaryKey($val) {
		$this->classForumPostId = $val;
	}
	
	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassForumPostPeer::doInsert($this,$dsn));
		} else {
			ClassForumPostPeer::doUpdate($this,$dsn);
		}
	}

	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "class_forum_post_id='".$key."'";
		}
		$array = ClassForumPostPeer::doSelect($where,$dsn);
		return $array[0];
	}

	function delete($deep=false,$dsn="default") {
		ClassForumPostPeer::doDelete($this,$deep,$dsn);
	}


	function isNew() {
		return $this->_new;
	}

	function isModified() {
		return $this->_modified;

	}

	function get($key) {
		return $this->{$key};
	}

	function set($key,$val) {
		$this->_modified = true;
		$this->{$key} = $val;

	}

}


class ClassForumPostPeerBase {

	var $tableName = 'class_forum_post';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_SelectStatement("class_forum_post",$where);
		$st->fields['class_forum_post_id'] = 'class_forum_post_id';
		$st->fields['class_forum_id'] = 'class_forum_id';
		$st->fields['is_sticky'] = 'is_sticky';
		$st->fields['reply_id'] = 'reply_id';
		$st->fields['thread_id'] = 'thread_id';
		$st->fields['subject'] = 'subject';
		$st->fields['message'] = 'message';
		$st->fields['user_id'] = 'user_id';
		$st->fields['post_timedate'] = 'post_timedate';
		$st->fields['class_forum_post_status'] = 'class_forum_post_status';

		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassForumPostPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_InsertStatement("class_forum_post");
		$st->fields['class_forum_post_id'] = $this->classForumPostId;
		$st->fields['class_forum_id'] = $this->classForumId;
		$st->fields['is_sticky'] = $this->isSticky;
		$st->fields['reply_id'] = $this->replyId;
		$st->fields['thread_id'] = $this->threadId;
		$st->fields['subject'] = $this->subject;
		$st->fields['message'] = $this->message;
		$st->fields['user_id'] = $this->userId;
		$st->fields['post_timedate'] = $this->postTimedate;
		$st->fields['class_forum_post_status'] = $this->classForumPostStatus;

		$st->key = 'class_forum_post_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_UpdateStatement("class_forum_post");
		$st->fields['class_forum_post_id'] = $obj->classForumPostId;
		$st->fields['class_forum_id'] = $obj->classForumId;
		$st->fields['is_sticky'] = $obj->isSticky;
		$st->fields['reply_id'] = $obj->replyId;
		$st->fields['thread_id'] = $obj->threadId;
		$st->fields['subject'] = $obj->subject;
		$st->fields['message'] = $obj->message;
		$st->fields['user_id'] = $obj->userId;
		$st->fields['post_timedate'] = $obj->postTimedate;
		$st->fields['class_forum_post_status'] = $obj->classForumPostStatus;

		$st->key = 'class_forum_post_id';
		$db->executeQuery($st);
		$obj->_modified = false;

	}

	function doReplace($obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		if ($this->isNew() ) {
			$db->executeQuery(new LC_InsertStatement($criteria));
		} else {
			$db->executeQuery(new LC_UpdateStatement($criteria));
		}
	}


	/**
	 * remove an object
	 */
	function doDelete(&$obj,$deep=false,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_DeleteStatement("class_forum_post","class_forum_post_id = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( $deep ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}



	/**
	 * send a raw query
	 */
	function doQuery(&$sql,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);

		$db->query($sql);

	  	return;
	}



	function row2Obj($row) {
		$x = new ClassForumPost();
		$x->classForumPostId = $row['class_forum_post_id'];
		$x->classForumId = $row['class_forum_id'];
		$x->isSticky = $row['is_sticky'];
		$x->replyId = $row['reply_id'];
		$x->threadId = $row['thread_id'];
		$x->subject = $row['subject'];
		$x->message = $row['message'];
		$x->userId = $row['user_id'];
		$x->postTimedate = $row['post_timedate'];
		$x->classForumPostStatus = $row['class_forum_post_status'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassForumPost extends ClassForumPostBase {



}



class ClassForumPostPeer extends ClassForumPostPeerBase {

}

?>