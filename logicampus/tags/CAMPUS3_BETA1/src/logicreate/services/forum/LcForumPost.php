<?

class LcForumPostBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lcForumPostId;
	var $lcForumId;
	var $lcForumPostParentId;
	var $lcForumPostThreadId;
	var $lcForumPostTitle;
	var $lcForumPostMessage;
	var $lcForumPostUsername;
	var $lcForumPostTimedate;
	var $lcForumPostStatus;
	var $lcForumReplyCount;
	var $lcForumRecentPostId;
	var $lcForumRecentPostTimedate;
	var $lcForumRecentPoster;

	var $__attributes = array( 
	'lcForumPostId'=>'integer',
	'lcForumId'=>'integer',
	'lcForumPostParentId'=>'integer',
	'lcForumPostThreadId'=>'integer',
	'lcForumPostTitle'=>'varchar',
	'lcForumPostMessage'=>'longvarchar',
	'lcForumPostUsername'=>'varchar',
	'lcForumPostTimedate'=>'integer',
	'lcForumPostStatus'=>'integer',
	'lcForumReplyCount'=>'integer',
	'lcForumRecentPostId'=>'integer',
	'lcForumRecentPostTimedate'=>'integer',
	'lcForumRecentPoster'=>'varchar');

	var $__nulls = array( 
	'lcForumPostParentId'=>'lcForumPostParentId',
	'lcForumPostThreadId'=>'lcForumPostThreadId');



	function getPrimaryKey() {
		return $this->lcForumPostId;
	}


	function setPrimaryKey($val) {
		$this->lcForumPostId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LcForumPostPeer::doInsert($this,$dsn));
		} else {
			LcForumPostPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "lc_forum_post_id='".$key."'";
		}
		$array = LcForumPostPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LcForumPostPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LcForumPostPeer::doDelete($this,$deep,$dsn);
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


class LcForumPostPeerBase {

	var $tableName = 'lc_forum_post';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lc_forum_post",$where);
		$st->fields['lc_forum_post_id'] = 'lc_forum_post_id';
		$st->fields['lc_forum_id'] = 'lc_forum_id';
		$st->fields['lc_forum_post_parent_id'] = 'lc_forum_post_parent_id';
		$st->fields['lc_forum_post_thread_id'] = 'lc_forum_post_thread_id';
		$st->fields['lc_forum_post_title'] = 'lc_forum_post_title';
		$st->fields['lc_forum_post_message'] = 'lc_forum_post_message';
		$st->fields['lc_forum_post_username'] = 'lc_forum_post_username';
		$st->fields['lc_forum_post_timedate'] = 'lc_forum_post_timedate';
		$st->fields['lc_forum_post_status'] = 'lc_forum_post_status';
		$st->fields['lc_forum_reply_count'] = 'lc_forum_reply_count';
		$st->fields['lc_forum_recent_post_id'] = 'lc_forum_recent_post_id';
		$st->fields['lc_forum_recent_post_timedate'] = 'lc_forum_recent_post_timedate';
		$st->fields['lc_forum_recent_poster'] = 'lc_forum_recent_poster';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LcForumPostPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lc_forum_post");
		$st->fields['lc_forum_post_id'] = $this->lcForumPostId;
		$st->fields['lc_forum_id'] = $this->lcForumId;
		$st->fields['lc_forum_post_parent_id'] = $this->lcForumPostParentId;
		$st->fields['lc_forum_post_thread_id'] = $this->lcForumPostThreadId;
		$st->fields['lc_forum_post_title'] = $this->lcForumPostTitle;
		$st->fields['lc_forum_post_message'] = $this->lcForumPostMessage;
		$st->fields['lc_forum_post_username'] = $this->lcForumPostUsername;
		$st->fields['lc_forum_post_timedate'] = $this->lcForumPostTimedate;
		$st->fields['lc_forum_post_status'] = $this->lcForumPostStatus;
		$st->fields['lc_forum_reply_count'] = $this->lcForumReplyCount;
		$st->fields['lc_forum_recent_post_id'] = $this->lcForumRecentPostId;
		$st->fields['lc_forum_recent_post_timedate'] = $this->lcForumRecentPostTimedate;
		$st->fields['lc_forum_recent_poster'] = $this->lcForumRecentPoster;

		$st->nulls['lc_forum_post_parent_id'] = 'lc_forum_post_parent_id';
		$st->nulls['lc_forum_post_thread_id'] = 'lc_forum_post_thread_id';

		$st->key = 'lc_forum_post_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lc_forum_post");
		$st->fields['lc_forum_post_id'] = $obj->lcForumPostId;
		$st->fields['lc_forum_id'] = $obj->lcForumId;
		$st->fields['lc_forum_post_parent_id'] = $obj->lcForumPostParentId;
		$st->fields['lc_forum_post_thread_id'] = $obj->lcForumPostThreadId;
		$st->fields['lc_forum_post_title'] = $obj->lcForumPostTitle;
		$st->fields['lc_forum_post_message'] = $obj->lcForumPostMessage;
		$st->fields['lc_forum_post_username'] = $obj->lcForumPostUsername;
		$st->fields['lc_forum_post_timedate'] = $obj->lcForumPostTimedate;
		$st->fields['lc_forum_post_status'] = $obj->lcForumPostStatus;
		$st->fields['lc_forum_reply_count'] = $obj->lcForumReplyCount;
		$st->fields['lc_forum_recent_post_id'] = $obj->lcForumRecentPostId;
		$st->fields['lc_forum_recent_post_timedate'] = $obj->lcForumRecentPostTimedate;
		$st->fields['lc_forum_recent_poster'] = $obj->lcForumRecentPoster;

		$st->nulls['lc_forum_post_parent_id'] = 'lc_forum_post_parent_id';
		$st->nulls['lc_forum_post_thread_id'] = 'lc_forum_post_thread_id';

		$st->key = 'lc_forum_post_id';
		$db->executeQuery($st);
		$obj->_modified = false;

	}

	function doReplace($obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		if ($this->isNew() ) {
			$db->executeQuery(new PBDO_InsertStatement($criteria));
		} else {
			$db->executeQuery(new PBDO_UpdateStatement($criteria));
		}
	}


	/**
	 * remove an object
	 */
	function doDelete(&$obj,$deep=false,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_DeleteStatement("lc_forum_post","lc_forum_post_id = '".$obj->getPrimaryKey()."'");

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
		$db = DB::getHandle($dsn);

		$db->query($sql);

	  	return;
	}



	function row2Obj($row) {
		$x = new LcForumPost();
		$x->lcForumPostId = $row['lc_forum_post_id'];
		$x->lcForumId = $row['lc_forum_id'];
		$x->lcForumPostParentId = $row['lc_forum_post_parent_id'];
		$x->lcForumPostThreadId = $row['lc_forum_post_thread_id'];
		$x->lcForumPostTitle = $row['lc_forum_post_title'];
		$x->lcForumPostMessage = $row['lc_forum_post_message'];
		$x->lcForumPostUsername = $row['lc_forum_post_username'];
		$x->lcForumPostTimedate = $row['lc_forum_post_timedate'];
		$x->lcForumPostStatus = $row['lc_forum_post_status'];
		$x->lcForumReplyCount = $row['lc_forum_reply_count'];
		$x->lcForumRecentPostId = $row['lc_forum_recent_post_id'];
		$x->lcForumRecentPostTimedate = $row['lc_forum_recent_post_timedate'];
		$x->lcForumRecentPoster = $row['lc_forum_recent_poster'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LcForumPost extends LcForumPostBase {

        function getLcForumPosts() {
                $array = LcForumPostPeer::doSelect('lc_forum_post_thread_id = \''.$this->getPrimaryKey().'\' order by lc_forum_post_id');
                return $array;
        }


        function updateStats() {
                $db =db::getHandle();
                // __FIX_ME
                // check 'status' in here too eventually?

                // how many replies
                $db->queryOne("SELECT count(lc_forum_post_id) 
			FROM lc_forum_post 
			WHERE (lc_forum_post_thread_id=".$this->lcForumPostId . ") 
			AND (lc_forum_post_status=0 or lc_forum_post_status IS NULL)");
                $this->lcForumReplyCount= $db->record[0];

                $db->queryOne("select max(lc_forum_post_id) as foo 
			FROM lc_forum_post 
			WHERE (lc_forum_post_id=".$this->lcForumPostId." or lc_forum_post_thread_id=".$this->lcForumPostId.") 
			AND (lc_forum_post_status=0 or lc_forum_post_status IS NULL)");
                $max = sprintf('%d',$db->record['foo']);

                $db->queryOne("select * 
			FROM lc_forum_post 
			WHERE lc_forum_post_id=$max 
			AND (lc_forum_post_status=0 or lc_forum_post_status IS NULL)");
                $this->lcForumRecentPostTimedate= $db->record['lc_forum_post_timedate'];
                $this->lcForumRecentPoster = $db->record['lc_forum_post_username'];
                $this->lcForumRecentPostId = $max;
                $this->save();  
        }
}



class LcForumPostPeer extends LcForumPostPeerBase {

}

?>
