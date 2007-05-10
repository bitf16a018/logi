<?

class ClassForumBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.4';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $classForumId;
	var $name;
	var $classId;
	var $isLocked;
	var $isVisible;
	var $isModerated;
	var $allowUploads;
	var $description;
	var $recentPostDatetime;
	var $recentPoster;
	var $threadCount;
	var $postCount;
	var $unansweredCount;
	var $classForumCategoryId;

	var $__attributes = array(
	'classForumId'=>'integer',
	'name'=>'varchar',
	'classId'=>'integer',
	'isLocked'=>'tinyint',
	'isVisible'=>'tinyint',
	'isModerated'=>'tinyint',
	'allowUploads'=>'tinyint',
	'description'=>'varchar',
	'recentPostDatetime'=>'integer',
	'recentPoster'=>'varchar',
	'threadCount'=>'integer',
	'postCount'=>'integer',
	'unansweredCount'=>'integer',
	'classForumCategoryId'=>'integer');

	function getClassForumCategoryByClassForumCategoryId($dsn='default') {
		if ( $this->classForumCategoryId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = ClassForumCategoryPeer::doSelect('class_forum_category_id = \''.$this->classForumCategoryId.'\'',$dsn);
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}

	function getClassForumPostsByClassForumId($dsn='default') {
		if ( $this->classForumId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = ClassForumPostPeer::doSelect('class_forum_id = \''.$this->classForumId.'\'',$dsn);
		return $array;
	}



	function getPrimaryKey() {
		return $this->classForumId;
	}

	function setPrimaryKey($val) {
		$this->classForumId = $val;
	}
	
	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassForumPeer::doInsert($this,$dsn));
		} else {
			ClassForumPeer::doUpdate($this,$dsn);
		}
	}

	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "class_forum_id='".$key."'";
		}
		$array = ClassForumPeer::doSelect($where,$dsn);
		return $array[0];
	}

	function delete($deep=false,$dsn="default") {
		ClassForumPeer::doDelete($this,$deep,$dsn);
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


class ClassForumPeerBase {

	var $tableName = 'class_forum';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_SelectStatement("class_forum",$where);
		$st->fields['class_forum_id'] = 'class_forum_id';
		$st->fields['name'] = 'name';
		$st->fields['class_id'] = 'class_id';
		$st->fields['is_locked'] = 'is_locked';
		$st->fields['is_visible'] = 'is_visible';
		$st->fields['is_moderated'] = 'is_moderated';
		$st->fields['allow_uploads'] = 'allow_uploads';
		$st->fields['description'] = 'description';
		$st->fields['recent_post_datetime'] = 'recent_post_datetime';
		$st->fields['recent_poster'] = 'recent_poster';
		$st->fields['thread_count'] = 'thread_count';
		$st->fields['post_count'] = 'post_count';
		$st->fields['unanswered_count'] = 'unanswered_count';
		$st->fields['class_forum_category_id'] = 'class_forum_category_id';

		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassForumPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_InsertStatement("class_forum");
		$st->fields['class_forum_id'] = $this->classForumId;
		$st->fields['name'] = $this->name;
		$st->fields['class_id'] = $this->classId;
		$st->fields['is_locked'] = $this->isLocked;
		$st->fields['is_visible'] = $this->isVisible;
		$st->fields['is_moderated'] = $this->isModerated;
		$st->fields['allow_uploads'] = $this->allowUploads;
		$st->fields['description'] = $this->description;
		$st->fields['recent_post_datetime'] = $this->recentPostDatetime;
		$st->fields['recent_poster'] = $this->recentPoster;
		$st->fields['thread_count'] = $this->threadCount;
		$st->fields['post_count'] = $this->postCount;
		$st->fields['unanswered_count'] = $this->unansweredCount;
		$st->fields['class_forum_category_id'] = $this->classForumCategoryId;

		$st->key = 'class_forum_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_UpdateStatement("class_forum");
		$st->fields['class_forum_id'] = $obj->classForumId;
		$st->fields['name'] = $obj->name;
		$st->fields['class_id'] = $obj->classId;
		$st->fields['is_locked'] = $obj->isLocked;
		$st->fields['is_visible'] = $obj->isVisible;
		$st->fields['is_moderated'] = $obj->isModerated;
		$st->fields['allow_uploads'] = $obj->allowUploads;
		$st->fields['description'] = $obj->description;
		$st->fields['recent_post_datetime'] = $obj->recentPostDatetime;
		$st->fields['recent_poster'] = $obj->recentPoster;
		$st->fields['thread_count'] = $obj->threadCount;
		$st->fields['post_count'] = $obj->postCount;
		$st->fields['unanswered_count'] = $obj->unansweredCount;
		$st->fields['class_forum_category_id'] = $obj->classForumCategoryId;

		$st->key = 'class_forum_id';
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
		$st = new LC_DeleteStatement("class_forum","class_forum_id = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassForum();
		$x->classForumId = $row['class_forum_id'];
		$x->name = $row['name'];
		$x->classId = $row['class_id'];
		$x->isLocked = $row['is_locked'];
		$x->isVisible = $row['is_visible'];
		$x->isModerated = $row['is_moderated'];
		$x->allowUploads = $row['allow_uploads'];
		$x->description = $row['description'];
		$x->recentPostDatetime = $row['recent_post_datetime'];
		$x->recentPoster = $row['recent_poster'];
		$x->threadCount = $row['thread_count'];
		$x->postCount = $row['post_count'];
		$x->unansweredCount = $row['unanswered_count'];
		$x->classForumCategoryId = $row['class_forum_category_id'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassForum extends ClassForumBase {



}



class ClassForumPeer extends ClassForumPeerBase {

}

?>
