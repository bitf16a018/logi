<?

class LcForumPostBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
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
	'lcForumId'=>'LcForum',
	'lcForumPostParentId'=>'LcForumPost',
	'lcForumPostThreadId'=>'integer',
	'lcForumPostTitle'=>'varchar',
	'lcForumPostMessage'=>'text',
	'lcForumPostUsername'=>'varchar',
	'lcForumPostTimedate'=>'int',
	'lcForumPostStatus'=>'int',
	'lcForumReplyCount'=>'int',
	'lcForumRecentPostId'=>'int',
	'lcForumRecentPostTimedate'=>'int',
	'lcForumRecentPoster'=>'varchar');

	function getLcForumPosts() {
		$array = LcForumPostPeer::doSelect('lc_forum_post_thread_id = \''.$this->getPrimaryKey().'\' order by lc_forum_post_id, lc_forum_post_thread_id, lc_forum_id,lc_forum_post_parent_id, lc_forum_post_id');
		return $array;
	}

	function getLcForum() {
		if ( $this->lcForumId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = LcForumPeer::doSelect('lc_forum_id = \''.$this->lcForumId.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}

	function getLcForumPost() {
		if ( $this->lcForumPostId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = LcForumPostPeer::doSelect('lc_forum_post_id = \''.$this->lcForumPostParentId.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->lcForumPostId;
	}

	function setPrimaryKey($val) {
		$this->lcForumPostId = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LcForumPostPeer::doInsert($this));
		} else {
			LcForumPostPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "lc_forum_post_id='".$key."'";
		}
		$array = LcForumPostPeer::doSelect($where);
		return $array[0];
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

	/**
	 * set all properties of an object that aren't
	 * keys.  Relation attributes must be set manually
	 * by the programmer to ensure security
	 */
	function setArray($array) {
		if ($array['lcForumPostParentId'])
			$this->lcForumPostParentId = $array['lcForumPostParentId'];
		if ($array['lcForumPostThreadId'])
			$this->lcForumPostThreadId = $array['lcForumPostThreadId'];
		if ($array['lcForumPostTitle'])
			$this->lcForumPostTitle = $array['lcForumPostTitle'];
		if ($array['lcForumPostMessage'])
			$this->lcForumPostMessage = $array['lcForumPostMessage'];
		if ($array['lcForumPostUsername'])
			$this->lcForumPostUsername = $array['lcForumPostUsername'];
		if ($array['lcForumPostTimedate'])
			$this->lcForumPostTimedate = $array['lcForumPostTimedate'];
		if ($array['lcForumPostStatus'])
			$this->lcForumPostStatus = $array['lcForumPostStatus'];
		if ($array['lcForumReplyCount'])
			$this->lcForumReplyCount = $array['lcForumReplyCount'];
		if ($array['lcForumRecentPostId'])
			$this->lcForumRecentPostId = $array['lcForumRecentPostId'];
		if ($array['lcForumRecentPostTimedate'])
			$this->lcForumRecentPostTimedate = $array['lcForumRecentPostTimedate'];
		if ($array['lcForumRecentPoster'])
			$this->lcForumRecentPoster = $array['lcForumRecentPoster'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class LcForumPostPeerBase {

	var $tableName = 'lc_forum_post';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("lc_forum_post",$where);
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

		$st->key = $this->key;
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LcForumPostPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("lc_forum_post");
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

		$st->key = 'lc_forum_post_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("lc_forum_post");
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

		$st->key = 'lc_forum_post_id';
		$db->executeQuery($st);
		$obj->_modified = false;

	}

	function doReplace($obj) {
		//use this tableName
		if ($this->isNew() ) {
			$db->executeQuery(new LC_InsertStatement($criteria));
		} else {
			$db->executeQuery(new LC_UpdateStatement($criteria));
		}
	}



	function doDelete(&$obj,$shallow=false) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_DeleteStatement("lc_forum_post","lc_forum_post_id = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

			$st = new LC_DeleteStatement("lc_forum_post","lc_forum_post_id = '".$obj->getPrimaryKey()."'");
			$db->executeQuery($st);
		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

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
                $db->queryOne("select count(lc_forum_post_id) from lc_forum_post where (lc_forum_post_thread_id=".$this->lcForumPostId . ") and (lc_forum_post_status IS NULL or lc_forum_post_status=0)");
                $this->lcForumReplyCount= $db->Record[0];
                $db->queryOne("select max(lc_forum_post_id) as foo from lc_forum_post where (lc_forum_post_id=".$this->lcForumPostId." or lc_forum_post_thread_id=".$this->lcForumPostId.") and (lc_forum_post_status=0 or lc_forum_post_status IS NULL)");
                $max = (int)$db->Record['foo'];
                $db->queryOne("select * from lc_forum_post where lc_forum_post_id=$max and (lc_forum_post_status=0 or lc_forum_post_status IS NULL)");
                $this->lcForumRecentPostTimedate= $db->Record['lc_forum_post_timedate'];
                $this->lcForumRecentPoster = $db->Record['lc_forum_post_username'];
                $this->lcForumRecentPostId = $max;
		#                debug($this);exit();
                $this->save();  

        }

}



class LcForumPostPeer extends LcForumPostPeerBase {

}

?>
