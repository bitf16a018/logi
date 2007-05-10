<?

class ClassForumUserActivityBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.4';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $classForumUserActivityId;
	var $classForumId;
	var $userId;
	var $views;

	var $__attributes = array(
	'classForumUserActivityId'=>'integer',
	'classForumId'=>'integer',
	'userId'=>'integer',
	'views'=>'blob');



	function getPrimaryKey() {
		return $this->classForumUserActivityId;
	}

	function setPrimaryKey($val) {
		$this->classForumUserActivityId = $val;
	}
	
	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassForumUserActivityPeer::doInsert($this,$dsn));
		} else {
			ClassForumUserActivityPeer::doUpdate($this,$dsn);
		}
	}

	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "class_forum_user_activity_id='".$key."'";
		}
		$array = ClassForumUserActivityPeer::doSelect($where,$dsn);
		return $array[0];
	}

	function delete($deep=false,$dsn="default") {
		ClassForumUserActivityPeer::doDelete($this,$deep,$dsn);
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


class ClassForumUserActivityPeerBase {

	var $tableName = 'class_forum_user_activity';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_SelectStatement("class_forum_user_activity",$where);
		$st->fields['class_forum_user_activity_id'] = 'class_forum_user_activity_id';
		$st->fields['class_forum_id'] = 'class_forum_id';
		$st->fields['user_id'] = 'user_id';
		$st->fields['views'] = 'views';

		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassForumUserActivityPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_InsertStatement("class_forum_user_activity");
		$st->fields['class_forum_user_activity_id'] = $this->classForumUserActivityId;
		$st->fields['class_forum_id'] = $this->classForumId;
		$st->fields['user_id'] = $this->userId;
		$st->fields['views'] = $this->views;

		$st->key = 'class_forum_user_activity_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_UpdateStatement("class_forum_user_activity");
		$st->fields['class_forum_user_activity_id'] = $obj->classForumUserActivityId;
		$st->fields['class_forum_id'] = $obj->classForumId;
		$st->fields['user_id'] = $obj->userId;
		$st->fields['views'] = $obj->views;

		$st->key = 'class_forum_user_activity_id';
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
		$st = new LC_DeleteStatement("class_forum_user_activity","class_forum_user_activity_id = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassForumUserActivity();
		$x->classForumUserActivityId = $row['class_forum_user_activity_id'];
		$x->classForumId = $row['class_forum_id'];
		$x->userId = $row['user_id'];
		$x->views = $row['views'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassForumUserActivity extends ClassForumUserActivityBase {



}



class ClassForumUserActivityPeer extends ClassForumUserActivityPeerBase {

}

?>