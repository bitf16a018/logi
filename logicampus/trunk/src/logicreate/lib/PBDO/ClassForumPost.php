<?

class ClassForumPostBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.4';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $classForumPostId;
	var $classForumId;
	var $isSticky;
	var $isHidden;
	var $replyId;
	var $threadId;
	var $subject;
	var $message;
	var $userId;
	var $postDatetime;
	var $lastEditUsername;
	var $lastEditDatetime;

	var $__attributes = array(
	'classForumPostId'=>'integer',
	'classForumId'=>'integer',
	'isSticky'=>'tinyint',
	'isHidden'=>'tinyint',
	'replyId'=>'integer',
	'threadId'=>'integer',
	'subject'=>'varchar',
	'message'=>'text',
	'userId'=>'varchar',
	'postDatetime'=>'integer',
	'lastEditUsername'=>'varchar',
	'lastEditDatetime'=>'integer');

	function getClassForumByClassForumId($dsn='default') {
		if ( $this->classForumId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = ClassForumPeer::doSelect('class_forum_id = \''.$this->classForumId.'\'',$dsn);
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



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


	/**
	 * only sets if the new value is !== the current value
	 * returns true if the value was updated
	 * also, sets _modified to true on success
	 */
	function set($key,$val) {
		if ($this->{$key} !== $val) {
			$this->_modified = true;
			$this->{$key} = $val;
			return true;
		}
		return false;
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
		$st->fields['is_hidden'] = 'is_hidden';
		$st->fields['reply_id'] = 'reply_id';
		$st->fields['thread_id'] = 'thread_id';
		$st->fields['subject'] = 'subject';
		$st->fields['message'] = 'message';
		$st->fields['user_id'] = 'user_id';
		$st->fields['post_datetime'] = 'post_datetime';
		$st->fields['last_edit_username'] = 'last_edit_username';
		$st->fields['last_edit_datetime'] = 'last_edit_datetime';

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
		$st->fields['is_hidden'] = $this->isHidden;
		$st->fields['reply_id'] = $this->replyId;
		$st->fields['thread_id'] = $this->threadId;
		$st->fields['subject'] = $this->subject;
		$st->fields['message'] = $this->message;
		$st->fields['user_id'] = $this->userId;
		$st->fields['post_datetime'] = $this->postDatetime;
		$st->fields['last_edit_username'] = $this->lastEditUsername;
		$st->fields['last_edit_datetime'] = $this->lastEditDatetime;

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
		$st->fields['is_hidden'] = $obj->isHidden;
		$st->fields['reply_id'] = $obj->replyId;
		$st->fields['thread_id'] = $obj->threadId;
		$st->fields['subject'] = $obj->subject;
		$st->fields['message'] = $obj->message;
		$st->fields['user_id'] = $obj->userId;
		$st->fields['post_datetime'] = $obj->postDatetime;
		$st->fields['last_edit_username'] = $obj->lastEditUsername;
		$st->fields['last_edit_datetime'] = $obj->lastEditDatetime;

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
		$x->isHidden = $row['is_hidden'];
		$x->replyId = $row['reply_id'];
		$x->threadId = $row['thread_id'];
		$x->subject = $row['subject'];
		$x->message = $row['message'];
		$x->userId = $row['user_id'];
		$x->postDatetime = $row['post_datetime'];
		$x->lastEditUsername = $row['last_edit_username'];
		$x->lastEditDatetime = $row['last_edit_datetime'];

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
