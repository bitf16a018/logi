<?

class LcForumPermBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lcForumPermId;
	var $lcForumId;
	var $lcForumPermAction;
	var $lcForumPermLabel;
	var $lcForumPermGroup;

	var $__attributes = array( 
	'lcForumPermId'=>'integer',
	'lcForumId'=>'integer',
	'lcForumPermAction'=>'varchar',
	'lcForumPermLabel'=>'varchar',
	'lcForumPermGroup'=>'varchar');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->lcForumPermId;
	}


	function setPrimaryKey($val) {
		$this->lcForumPermId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LcForumPermPeer::doInsert($this,$dsn));
		} else {
			LcForumPermPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "lc_forum_perm_id='".$key."'";
		}
		$array = LcForumPermPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LcForumPermPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LcForumPermPeer::doDelete($this,$deep,$dsn);
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


class LcForumPermPeerBase {

	var $tableName = 'lc_forum_perm';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lc_forum_perm",$where);
		$st->fields['lc_forum_perm_id'] = 'lc_forum_perm_id';
		$st->fields['lc_forum_id'] = 'lc_forum_id';
		$st->fields['lc_forum_perm_action'] = 'lc_forum_perm_action';
		$st->fields['lc_forum_perm_label'] = 'lc_forum_perm_label';
		$st->fields['lc_forum_perm_group'] = 'lc_forum_perm_group';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LcForumPermPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lc_forum_perm");
		$st->fields['lc_forum_perm_id'] = $this->lcForumPermId;
		$st->fields['lc_forum_id'] = $this->lcForumId;
		$st->fields['lc_forum_perm_action'] = $this->lcForumPermAction;
		$st->fields['lc_forum_perm_label'] = $this->lcForumPermLabel;
		$st->fields['lc_forum_perm_group'] = $this->lcForumPermGroup;


		$st->key = 'lc_forum_perm_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lc_forum_perm");
		$st->fields['lc_forum_perm_id'] = $obj->lcForumPermId;
		$st->fields['lc_forum_id'] = $obj->lcForumId;
		$st->fields['lc_forum_perm_action'] = $obj->lcForumPermAction;
		$st->fields['lc_forum_perm_label'] = $obj->lcForumPermLabel;
		$st->fields['lc_forum_perm_group'] = $obj->lcForumPermGroup;


		$st->key = 'lc_forum_perm_id';
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
		$st = new PBDO_DeleteStatement("lc_forum_perm","lc_forum_perm_id = '".$obj->getPrimaryKey()."'");

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
		$x = new LcForumPerm();
		$x->lcForumPermId = $row['lc_forum_perm_id'];
		$x->lcForumId = $row['lc_forum_id'];
		$x->lcForumPermAction = $row['lc_forum_perm_action'];
		$x->lcForumPermLabel = $row['lc_forum_perm_label'];
		$x->lcForumPermGroup = $row['lc_forum_perm_group'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LcForumPerm extends LcForumPermBase {

	/**
	 * Load a list of LcForums based on the user's groups and section id
	 *
	 * @return: array
	 * @throws: Permission error
	 */
	function secureLoadBySection($u,$s) {
		//trigger_error('loading all forums for user '.$u->username.' under section ' .$s->lcForumSectionName);
		$db = lcDB::getHandle();
		$st = new PBDO_SelectStatement("lc_forum",$where);
		$st->fields['lc_forum_id'] = 'lc_forum.lc_forum_id';
		$st->fields['lc_forum_parent_id'] = 'lc_forum_parent_id';
		$st->fields['lc_forum_name'] = 'lc_forum_name';
		$st->fields['lc_forum_description'] = 'lc_forum_description';
		$st->fields['lc_forum_recent_post_id'] = 'lc_forum_recent_post_id';
		$st->fields['lc_forum_recent_post_timedate'] = 'lc_forum_recent_post_timedate';
		$st->fields['lc_forum_recent_poster'] = 'lc_forum_recent_poster';
		$st->fields['lc_forum_thread_count'] = 'lc_forum_thread_count';
		$st->fields['lc_forum_post_count'] = 'lc_forum_post_count';
		$st->fields['lc_forum_unanswered_count'] = 'lc_forum_unanswered_count';
		$st->fields['lc_forum_section_id'] = 'lc_forum.lc_forum_section_id';
		$st->fields['lc_forum_numeric_link'] = 'lc_forum_numeric_link';
		$st->fields['lc_forum_char_link'] = 'lc_forum_char_link';

		$st->key = $s->key;

		$st->join = 'LEFT JOIN lc_forum_section s ON s.lc_forum_section_id = lc_forum.lc_forum_section_id
					LEFT JOIN lc_forum_perm as p ON lc_forum.lc_forum_id=p.lc_forum_id
					';
		//use a big or clause here
		$x = "p.lc_forum_perm_group=\"".implode("\" or p.lc_forum_perm_group=\"", $u->groups)."\"";
		$st->where = '('.$x.') 
					  AND s.lc_forum_section_id = '.$s->lcForumSectionId;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
		//trigger_error('found one forum');
			$array[$db->record['lc_forum_id']] = LcForumPeer::row2Obj($db->record);
		}
		return $array;
	}


	/**
	 * Load one forum based on user's groups and the lc_forum_perm table
	 *
	 * @return: LcForum object or null
	 * @throws: Permission error
	 */
	function secureLoadForum($u,$s) {


	}
}



class LcForumPermPeer extends LcForumPermPeerBase {

}

?>
