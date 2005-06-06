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
	var $lcForumFile1Name;
	var $lcForumFile1SysName;
	var $lcForumFile1Size;
	var $lcForumFile1MIME;
	var $lcForumFile2Name;
	var $lcForumFile2SysName;
	var $lcForumFile2Size;
	var $lcForumFile2MIME;
	var $lcForumFile1Count;
	var $lcForumFile2Count;


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
	'lcForumRecentPoster'=>'varchar',
	'lcForumFile1Name'=>'varchar',
	'lcForumFile1SysName'=>'varchar',
	'lcForumFile1Size'=>'varchar',
	'lcForumFile1MIME'=>'varchar',

	'lcForumFile2Name'=>'varchar',
	'lcForumFile2SysName'=>'varchar',
	'lcForumFile2Size'=>'varchar',
	'lcForumFile2MIME'=>'varchar',
	'lcForumFile1Count'=>'int',
	'lcForumFile2Count'=>'int',
	);

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
		if ($array['lcForumFile1Name'])
			$this->lcForumFile1Name= $array['lcForumFile1Name'];
		if ($array['lcForumFile1SysName'])
			$this->lcForumFile1SysName= $array['lcForumFile1SysName'];
		if ($array['lcForumFile1Size'])
			$this->lcForumFile1Size= $array['lcForumFile1Size'];
		if ($array['lcForumFile1MIME'])
			$this->lcForumFile1MIME= $array['lcForumFile1MIME'];

		if ($array['lcForumFile2Name'])
			$this->lcForumFile2Name= $array['lcForumFile2Name'];
		if ($array['lcForumFile2SysName'])
			$this->lcForumFile2SysName= $array['lcForumFile2SysName'];
		if ($array['lcForumFile2Size'])
			$this->lcForumFile2Size= $array['lcForumFile2Size'];
		if ($array['lcForumFile2MIME'])
			$this->lcForumFile2MIME= $array['lcForumFile2MIME'];

		if ($array['lcForumFile1Count'])
			$this->lcForumFile1Count= $array['lcForumFile1Count'];

		if ($array['lcForumFile2Count'])
			$this->lcForumFile2Count= $array['lcForumFile2Count'];

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

		$st->fields['lc_forum_file1_name'] = 'lc_forum_file1_name';
		$st->fields['lc_forum_file1_sys_name'] = 'lc_forum_file1_sys_name';
		$st->fields['lc_forum_file1_size'] = 'lc_forum_file1_size';
		$st->fields['lc_forum_file1_mime'] = 'lc_forum_file1_mime';
		$st->fields['lc_forum_file1_count'] = 'lc_forum_file1_count';
		$st->fields['lc_forum_file2_count'] = 'lc_forum_file2_count';

		$st->fields['lc_forum_file2_name'] = 'lc_forum_file2_name';
		$st->fields['lc_forum_file2_sys_name'] = 'lc_forum_file2_sys_name';
		$st->fields['lc_forum_file2_size'] = 'lc_forum_file2_size';
		$st->fields['lc_forum_file2_mime'] = 'lc_forum_file2_mime';

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
		$st->fields['lc_forum_file1_name'] = $this->lcForumFile1Name;
		$st->fields['lc_forum_file1_sys_name'] = $this->lcForumFile1SysName;
		$st->fields['lc_forum_file1_size'] = $this->lcForumFile1Size;
		$st->fields['lc_forum_file1_mime'] = $this->lcForumFile1MIME;
		$st->fields['lc_forum_file2_name'] = $this->lcForumFile2Name;
		$st->fields['lc_forum_file2_sys_name'] = $this->lcForumFile2SysName;
		$st->fields['lc_forum_file2_size'] = $this->lcForumFile2Size;
		$st->fields['lc_forum_file2_mime'] = $this->lcForumFile2MIME;
		$st->fields['lc_forum_file1_count'] = $this->lcForumFile1Count;
		$st->fields['lc_forum_file2_count'] = $this->lcForumFile2Count;


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

		$st->fields['lc_forum_file1_name'] = $obj->lcForumFile1Name;
		$st->fields['lc_forum_file1_sys_name'] = $obj->lcForumFile1SysName;
		$st->fields['lc_forum_file1_size'] = $obj->lcForumFile1Size;
		$st->fields['lc_forum_file1_mime'] = $obj->lcForumFile1MIME;
		$st->fields['lc_forum_file1_count'] = $obj->lcForumFile1Count;
		$st->fields['lc_forum_file2_count'] = $obj->lcForumFile2Count;

		$st->fields['lc_forum_file2_name'] = $obj->lcForumFile2Name;
		$st->fields['lc_forum_file2_sys_name'] = $obj->lcForumFile2SysName;
		$st->fields['lc_forum_file2_size'] = $obj->lcForumFile2Size;
		$st->fields['lc_forum_file2_mime'] = $obj->lcForumFile2MIME;


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

		$x->lcForumFile1Name= $row['lc_forum_file1_name'];
		$x->lcForumFile1SysName= $row['lc_forum_file1_sys_name'];
		$x->lcForumFile1Size= $row['lc_forum_file1_size'];
		$x->lcForumFile1MIME= $row['lc_forum_file1_mime'];
		$x->lcForumFile2Name= $row['lc_forum_file2_name'];
		$x->lcForumFile2SysName= $row['lc_forum_file2_sys_name'];
		$x->lcForumFile2Size= $row['lc_forum_file2_size'];
		$x->lcForumFile2MIME= $row['lc_forum_file2_mime'];
		$x->lcForumFile1Count= $row['lc_forum_file1_count'];
		$x->lcForumFile2Count= $row['lc_forum_file2_count'];


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
                $this->lcForumReplyCount= $db->Record[0];

                $db->queryOne("select max(lc_forum_post_id) as foo 
			FROM lc_forum_post 
			WHERE (lc_forum_post_id=".$this->lcForumPostId." or lc_forum_post_thread_id=".$this->lcForumPostId.") 
			AND (lc_forum_post_status=0 or lc_forum_post_status IS NULL)");
                $max = sprintf('%d',$db->Record['foo']);

                $db->queryOne("select * 
			FROM lc_forum_post 
			WHERE lc_forum_post_id=$max 
			AND (lc_forum_post_status=0 or lc_forum_post_status IS NULL)");
                $this->lcForumRecentPostTimedate= $db->Record['lc_forum_post_timedate'];
                $this->lcForumRecentPoster = $db->Record['lc_forum_post_username'];
                $this->lcForumRecentPostId = $max;
                $this->save();  
        }
}


class LcForumPostPeer extends LcForumPostPeerBase {

}

?>
