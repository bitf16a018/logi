<?

class LcForumBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $lcForumId;
	var $lcForumParentId;
	var $lcForumName;
	var $lcForumDescription;
	var $lcForumRecentPostId;
	var $lcForumRecentPostTimedate;
	var $lcForumRecentPoster;
	var $lcForumThreadCount;
	var $lcForumPostCount;
	var $lcForumUnansweredCount;
	var $lcForumSectionId;
	var $lcForumNumericLink;
	var $lcForumCharLink;

	var $__attributes = array(
	'lcForumId'=>'integer',
	'lcForumParentId'=>'LcForum',
	'lcForumName'=>'varchar',
	'lcForumDescription'=>'varchar',
	'lcForumRecentPostId'=>'int',
	'lcForumRecentPostTimedate'=>'int',
	'lcForumRecentPoster'=>'varchar',
	'lcForumThreadCount'=>'int',
	'lcForumPostCount'=>'int',
	'lcForumUnansweredCount'=>'int',
	'lcForumSectionId'=>'LcForumSection',
	'lcForumNumericLink'=>'int',
	'lcForumCharLink'=>'varchar',
	);

	function getLcForums() {
		$array = LcForumPeer::doSelect('lc_forum_parent_id = \''.$this->getPrimaryKey().'\'');
		return $array;
	}

	function getLcForumPosts() {
		$array = LcForumPostPeer::doSelect('lc_forum_id = \''.$this->getPrimaryKey().'\'');
		return $array;
	}

	function getLcForumModerators() {
		$array = LcForumModeratorPeer::doSelect('lc_forum_id = \''.$this->getPrimaryKey().'\'');
		return $array;
	}

	function getLcForumPerms() {
		$array = LcForumPermPeer::doSelect('lc_forum_id = \''.$this->getPrimaryKey().'\'');
		return $array;
	}

	function getLcForum() {
		if ( $this->lcForumId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = LcForumPeer::doSelect('lc_forum_id = \''.$this->lcForumParentId.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}

	function getLcForumSection() {
		if ( $this->lcForumSectionId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = LcForumSectionPeer::doSelect('lc_forum_section_id = \''.$this->lcForumSectionId.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->lcForumId;
	}

	function setPrimaryKey($val) {
		$this->lcForumId = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LcForumPeer::doInsert($this));
		} else {
			LcForumPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "lc_forum_id='".$key."'";
		}
		$array = LcForumPeer::doSelect($where);
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
		if ($array['lcForumParentId'])
			$this->lcForumParentId = $array['lcForumParentId'];
		if ($array['lcForumName'])
			$this->lcForumName = $array['lcForumName'];
		if ($array['lcForumDescription'])
			$this->lcForumDescription = $array['lcForumDescription'];
		if ($array['lcForumRecentPostId'])
			$this->lcForumRecentPostId = $array['lcForumRecentPostId'];
		if ($array['lcForumRecentPostTimedate'])
			$this->lcForumRecentPostTimedate = $array['lcForumRecentPostTimedate'];
		if ($array['lcForumRecentPoster'])
			$this->lcForumRecentPoster = $array['lcForumRecentPoster'];
		if ($array['lcForumThreadCount'])
			$this->lcForumThreadCount = $array['lcForumThreadCount'];
		if ($array['lcForumPostCount'])
			$this->lcForumPostCount = $array['lcForumPostCount'];
		if ($array['lcForumUnansweredCount'])
			$this->lcForumUnansweredCount = $array['lcForumUnansweredCount'];
		if ($array['lcForumNumericLink'])
			$this->lcForumNumericLink = $array['lcForumNumericLink'];
		if ($array['lcForumCharLink'])
			$this->lcForumCharLink = $array['lcForumCharLink'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class LcForumPeerBase {

	var $tableName = 'lc_forum';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("lc_forum",$where);
		$st->fields['lc_forum_id'] = 'lc_forum_id';
		$st->fields['lc_forum_parent_id'] = 'lc_forum_parent_id';
		$st->fields['lc_forum_name'] = 'lc_forum_name';
		$st->fields['lc_forum_description'] = 'lc_forum_description';
		$st->fields['lc_forum_recent_post_id'] = 'lc_forum_recent_post_id';
		$st->fields['lc_forum_recent_post_timedate'] = 'lc_forum_recent_post_timedate';
		$st->fields['lc_forum_recent_poster'] = 'lc_forum_recent_poster';
		$st->fields['lc_forum_thread_count'] = 'lc_forum_thread_count';
		$st->fields['lc_forum_post_count'] = 'lc_forum_post_count';
		$st->fields['lc_forum_unanswered_count'] = 'lc_forum_unanswered_count';
		$st->fields['lc_forum_section_id'] = 'lc_forum_section_id';
		$st->fields['lc_forum_numeric_link'] = 'lc_forum_numeric_link';
		$st->fields['lc_forum_char_link'] = 'lc_forum_char_link';
		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LcForumPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("lc_forum");
		$st->fields['lc_forum_id'] = $this->lcForumId;
		$st->fields['lc_forum_parent_id'] = $this->lcForumParentId;
		$st->fields['lc_forum_name'] = $this->lcForumName;
		$st->fields['lc_forum_description'] = $this->lcForumDescription;
		$st->fields['lc_forum_recent_post_id'] = $this->lcForumRecentPostId;
		$st->fields['lc_forum_recent_post_timedate'] = $this->lcForumRecentPostTimedate;
		$st->fields['lc_forum_recent_poster'] = $this->lcForumRecentPoster;
		$st->fields['lc_forum_thread_count'] = $this->lcForumThreadCount;
		$st->fields['lc_forum_post_count'] = $this->lcForumPostCount;
		$st->fields['lc_forum_unanswered_count'] = $this->lcForumUnansweredCount;
		$st->fields['lc_forum_section_id'] = $this->lcForumSectionId;
		$st->fields['lc_forum_numeric_link'] = $this->lcForumNumericLink;
		$st->fields['lc_forum_char_link'] = $this->lcForumCharLink;
		$st->key = 'lc_forum_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("lc_forum");
		$st->fields['lc_forum_id'] = $obj->lcForumId;
		$st->fields['lc_forum_parent_id'] = $obj->lcForumParentId;
		$st->fields['lc_forum_name'] = $obj->lcForumName;
		$st->fields['lc_forum_description'] = $obj->lcForumDescription;
		$st->fields['lc_forum_recent_post_id'] = $obj->lcForumRecentPostId;
		$st->fields['lc_forum_recent_post_timedate'] = $obj->lcForumRecentPostTimedate;
		$st->fields['lc_forum_recent_poster'] = $obj->lcForumRecentPoster;
		$st->fields['lc_forum_thread_count'] = $obj->lcForumThreadCount;
		$st->fields['lc_forum_post_count'] = $obj->lcForumPostCount;
		$st->fields['lc_forum_unanswered_count'] = $obj->lcForumUnansweredCount;
		$st->fields['lc_forum_section_id'] = $obj->lcForumSectionId;
		$st->fields['lc_forum_numeric_link'] = $obj->lcForumNumericLink;
		$st->fields['lc_forum_char_link'] = $obj->lcForumCharLink;

		$st->key = 'lc_forum_id';
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
		$st = new LC_DeleteStatement("lc_forum","lc_forum_id = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

			$st = new LC_DeleteStatement("lc_forum","lc_forum_id = '".$obj->getPrimaryKey()."'");
			$db->executeQuery($st);
			$st = new LC_DeleteStatement("lc_forum_post","lc_forum_id = '".$obj->getPrimaryKey()."'");
			$db->executeQuery($st);
			$st = new LC_DeleteStatement("lc_forum_moderator","lc_forum_id = '".$obj->getPrimaryKey()."'");
			$db->executeQuery($st);
			$st = new LC_DeleteStatement("lc_forum_perm","lc_forum_id = '".$obj->getPrimaryKey()."'");
			$db->executeQuery($st);
		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new LcForum();
		$x->lcForumId = $row['lc_forum_id'];
		$x->lcForumParentId = $row['lc_forum_parent_id'];
		$x->lcForumName = $row['lc_forum_name'];
		$x->lcForumDescription = $row['lc_forum_description'];
		$x->lcForumRecentPostId = $row['lc_forum_recent_post_id'];
		$x->lcForumRecentPostTimedate = $row['lc_forum_recent_post_timedate'];
		$x->lcForumRecentPoster = $row['lc_forum_recent_poster'];
		$x->lcForumThreadCount = $row['lc_forum_thread_count'];
		$x->lcForumPostCount = $row['lc_forum_post_count'];
		$x->lcForumUnansweredCount = $row['lc_forum_unanswered_count'];
		$x->lcForumSectionId = $row['lc_forum_section_id'];
		$x->lcForumNumericLink = $row['lc_forum_numeric_link'];
		$x->lcForumCharLink = $row['lc_forum_char_link'];
		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class LcForum extends LcForumBase {

// overridden because we don't want to normally pull ALL posts
// related, just the top level posts - we'll drill down in a post
// to see the responses, but technically they still belong
// to the forum too


        function getLcForumPosts() {
                $array = LcForumPostPeer::doSelect('lc_forum_id = \''.$this->getPrimaryKey().'\' and lc_forum_post_parent_id=0');
                return $array;
        }
// only get forums not linked to any classes
// via the generic numeric_link (default to 0)

        function getLcForums() {
                $array = LcForumPeer::doSelect('lc_forum_parent_id = \''.$this->getPrimaryKey().'\' and lc_forum_numeric_link=0');
                return $array;
        }
// get forum (singular) for a class
// based on ID
// only one forum per class - executive decision by mgk
        function getLcForumForClass($class_id) {
                $array = LcForumPeer::doSelect('lc_forum_numeric_link='.$class_id);
                if (!is_array($array)) { // didn't get a forum for a class
                                        // so we make a new one
                        $x = new lcForum();
                        $x->lcForumName= "Classroom forum";
                        $x->lcForumNumericLink = $class_id;
			$x->lcForumDescription = ' ';
			$x->lcForumRecentPostId = 0;
			$x->lcForumRecentPostTimedate = 0;
			$x->lcForumRecentPoster = '';
			$x->lcForumThreadCount = 0;
			$x->lcForumPostCount = 0;
			$x->lcForumUnansweredCount = 0;
			$x->lcForumSectionId = 0;
			$x->lcForumCharLink = '';
			$x->lcForumParentId = 0;
			$x->lcForumFile1Name= '';
			$x->lcForumFile1SysName= '';
			$x->lcForumFile1Size= '';
			$x->lcForumFile1MIME= '';
			$x->lcForumFile2Name= '';
			$x->lcForumFile2SysName= '';
			$x->lcForumFile2Size= '';
			$x->lcForumFile2MIME= '';
                        $x->save();
                        return $x;
                }
                return $array[0];
        }
        
        function updateStats() {
                $db =db::getHandle();
                // __FIX_ME
                // check 'status' in here too eventually?
                #echo("select count(lc_forum_post_id) from lc_forum_post where lc_forum_id=".$this->lcForumId." and lc_forum_post_status=0");
                $db->queryOne("select count(lc_forum_post_id) from lc_forum_post where lc_forum_id=".$this->lcForumId." and lc_forum_post_status=0");
                $this->lcForumPostCount = $db->Record[0];
                #echo("select count(lc_forum_post_id) from lc_forum_post where lc_forum_id=".$this->lcForumId . " and lc_forum_post_parent_id=0 and lc_forum_post_status=0");
                $db->queryOne("select count(lc_forum_post_id) from lc_forum_post where lc_forum_id=".$this->lcForumId . " and lc_forum_post_parent_id=0 and lc_forum_post_status=0");
                $this->lcForumThreadCount = $db->Record[0];
                #echo("select max(lc_forum_post_id) from lc_forum_post where lc_forum_id=".$this->lcForumId. " and lc_forum_post_status=0");
                $db->queryOne("select max(lc_forum_post_id) from lc_forum_post where lc_forum_id=".$this->lcForumId. " and lc_forum_post_status=0");
                $max = $db->Record[0];
                #echo("select * from lc_forum_post where lc_forum_post_id=$max and lc_forum_post_status=0");
                $db->queryOne("select * from lc_forum_post where lc_forum_post_id=$max and lc_forum_post_status=0");
                $this->lcForumRecentPostTimedate= $db->Record['lc_forum_post_timedate'];
                $this->lcForumRecentPoster = $db->Record['lc_forum_post_username'];
                $this->lcForumRecentPostId = $max;
#               debug($this);exit();
                $this->save();  

        }

}



class LcForumPeer extends LcForumPeerBase {

}

?>
