<?

class ClassForumBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.4';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $classForumId;
	var $name;
	var $description;
	var $classForumRecentPostTimedate;
	var $classForumRecentPoster;
	var $classForumThreadCount;
	var $classForumPostCount;
	var $classForumUnansweredCount;
	var $classForumSectionId;

	var $__attributes = array(
	'classForumId'=>'integer',
	'name'=>'varchar',
	'description'=>'varchar',
	'classForumRecentPostTimedate'=>'integer',
	'classForumRecentPoster'=>'varchar',
	'classForumThreadCount'=>'integer',
	'classForumPostCount'=>'integer',
	'classForumUnansweredCount'=>'integer',
	'classForumSectionId'=>'integer');



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

	function set($key,$val) {
		$this->_modified = true;
		$this->{$key} = $val;

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
		$st->fields['description'] = 'description';
		$st->fields['class_forum_recent_post_timedate'] = 'class_forum_recent_post_timedate';
		$st->fields['class_forum_recent_poster'] = 'class_forum_recent_poster';
		$st->fields['class_forum_thread_count'] = 'class_forum_thread_count';
		$st->fields['class_forum_post_count'] = 'class_forum_post_count';
		$st->fields['class_forum_unanswered_count'] = 'class_forum_unanswered_count';
		$st->fields['class_forum_section_id'] = 'class_forum_section_id';

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
		$st->fields['description'] = $this->description;
		$st->fields['class_forum_recent_post_timedate'] = $this->classForumRecentPostTimedate;
		$st->fields['class_forum_recent_poster'] = $this->classForumRecentPoster;
		$st->fields['class_forum_thread_count'] = $this->classForumThreadCount;
		$st->fields['class_forum_post_count'] = $this->classForumPostCount;
		$st->fields['class_forum_unanswered_count'] = $this->classForumUnansweredCount;
		$st->fields['class_forum_section_id'] = $this->classForumSectionId;

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
		$st->fields['description'] = $obj->description;
		$st->fields['class_forum_recent_post_timedate'] = $obj->classForumRecentPostTimedate;
		$st->fields['class_forum_recent_poster'] = $obj->classForumRecentPoster;
		$st->fields['class_forum_thread_count'] = $obj->classForumThreadCount;
		$st->fields['class_forum_post_count'] = $obj->classForumPostCount;
		$st->fields['class_forum_unanswered_count'] = $obj->classForumUnansweredCount;
		$st->fields['class_forum_section_id'] = $obj->classForumSectionId;

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
		$x->description = $row['description'];
		$x->classForumRecentPostTimedate = $row['class_forum_recent_post_timedate'];
		$x->classForumRecentPoster = $row['class_forum_recent_poster'];
		$x->classForumThreadCount = $row['class_forum_thread_count'];
		$x->classForumPostCount = $row['class_forum_post_count'];
		$x->classForumUnansweredCount = $row['class_forum_unanswered_count'];
		$x->classForumSectionId = $row['class_forum_section_id'];

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