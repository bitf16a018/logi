<?

class LcForumBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
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
	'lcForumParentId'=>'integer',
	'lcForumName'=>'varchar',
	'lcForumDescription'=>'varchar',
	'lcForumRecentPostId'=>'integer',
	'lcForumRecentPostTimedate'=>'integer',
	'lcForumRecentPoster'=>'varchar',
	'lcForumThreadCount'=>'integer',
	'lcForumPostCount'=>'integer',
	'lcForumUnansweredCount'=>'integer',
	'lcForumSectionId'=>'integer',
	'lcForumNumericLink'=>'integer',
	'lcForumCharLink'=>'varchar');

	var $__nulls = array( 
	'lcForumParentId'=>'lcForumParentId',
	'lcForumNumericLink'=>'lcForumNumericLink',
	'lcForumCharLink'=>'lcForumCharLink');



	function getPrimaryKey() {
		return $this->lcForumId;
	}


	function setPrimaryKey($val) {
		$this->lcForumId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LcForumPeer::doInsert($this,$dsn));
		} else {
			LcForumPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "lc_forum_id='".$key."'";
		}
		$array = LcForumPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LcForumPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LcForumPeer::doDelete($this,$deep,$dsn);
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


class LcForumPeerBase {

	var $tableName = 'lc_forum';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lc_forum",$where);
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


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LcForumPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lc_forum");
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

		$st->nulls['lc_forum_parent_id'] = 'lc_forum_parent_id';
		$st->nulls['lc_forum_numeric_link'] = 'lc_forum_numeric_link';
		$st->nulls['lc_forum_char_link'] = 'lc_forum_char_link';

		$st->key = 'lc_forum_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lc_forum");
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

		$st->nulls['lc_forum_parent_id'] = 'lc_forum_parent_id';
		$st->nulls['lc_forum_numeric_link'] = 'lc_forum_numeric_link';
		$st->nulls['lc_forum_char_link'] = 'lc_forum_char_link';

		$st->key = 'lc_forum_id';
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
		$st = new PBDO_DeleteStatement("lc_forum","lc_forum_id = '".$obj->getPrimaryKey()."'");

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

        function getLcForumsStudentGroups($studentGroups) {
		while(list($k,$v) = @each($studentGroups)) { 
			$x[] = "lc_forum_char_link='g_$v'";
		}
		if ( is_array($x) ) {
			$where = " and (";
			$where .= implode(" or ",$x);
			$where .= ")";
		}

                $array = LcForumPeer::doSelect('lc_forum_parent_id = \''.$this->getPrimaryKey().'\' '.$where);
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

        function getLcForumForClassStudentGroups($class_id,$studentGroups) {
		while(list($k,$v) = @each($studentGroups)) { 
			$x[] = "lc_forum_char_link='g_$v'";
		}
		$where = "lc_forum_numeric_link=$class_id and (";
		$where .= implode(" or ",$x);
		$where .= ")";
	        $array = LcForumPeer::doSelect($where);
                return $array[0];
        }
 
        function updateStats() {
                $db =db::getHandle();
		$forumId = intval($this->lcForumId);
                // __FIX_ME
                // check 'status' in here too eventually?
                $db->queryOne("SELECT count(lc_forum_post_id) 
			FROM lc_forum_post 
			WHERE lc_forum_id=".$forumId." 
			AND  (lc_forum_post_status=0 OR lc_forum_post_status IS NULL)");
                $this->lcForumPostCount = $db->record[0];

                $db->queryOne("SELECT count(lc_forum_post_id) 
			FROM lc_forum_post 
			WHERE lc_forum_id=".$forumId . " 
			AND lc_forum_post_parent_id=0 
			AND (lc_forum_post_status=0 OR lc_forum_post_status IS NULL)");
                $this->lcForumThreadCount = $db->record[0];

                $db->queryOne("SELECT max(lc_forum_post_id) 
			FROM lc_forum_post 
			WHERE lc_forum_id=".$forumId. " 
			AND (lc_forum_post_status=0 OR lc_forum_post_status IS NULL)");
                $max = sprintf('%d',$db->record[0]);

                $db->queryOne("SELECT * 
			FROM lc_forum_post 
			WHERE lc_forum_post_id=$max 
			AND (lc_forum_post_status=0 OR lc_forum_post_status IS NULL)");
                $this->lcForumRecentPostTimedate= $db->record['lc_forum_post_timedate'];
                $this->lcForumRecentPoster = $db->record['lc_forum_post_username'];
                $this->lcForumRecentPostId = $max;
                $this->save();  
        }
}



class LcForumPeer extends LcForumPeerBase {

}

?>
