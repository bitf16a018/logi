<?

class LcForumPermBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $lcForumPermId;
	var $lcForumId;
	var $lcForumPermAction;
	var $lcForumPermLabel;
	var $lcForumPermGroup;

	var $__attributes = array(
	'lcForumPermId'=>'integer',
	'lcForumId'=>'LcForum',
	'lcForumPermAction'=>'char',
	'lcForumPermLabel'=>'varchar',
	'lcForumPermGroup'=>'varchar');

	function getLcForum() {
		if ( $this->lcForumId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = LcForumPeer::doSelect('lc_forum_id = \''.$this->lcForumId.'\'');
		if ( count($array) > 1 ) { 
	//	trigger_error('multiple objects on one-to-one relationship'); 
		}
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->lcForumPermId;
	}

	function setPrimaryKey($val) {
		$this->lcForumPermId = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LcForumPermPeer::doInsert($this));
		} else {
			LcForumPermPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "lc_forum_perm_id='".$key."'";
		}
		$array = LcForumPermPeer::doSelect($where);
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
		if ($array['lcForumPermAction'])
			$this->lcForumPermAction = $array['lcForumPermAction'];
		if ($array['lcForumPermLabel'])
			$this->lcForumPermLabel = $array['lcForumPermLabel'];
		if ($array['lcForumPermGroup'])
			$this->lcForumPermGroup = $array['lcForumPermGroup'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class LcForumPermPeerBase {

	var $tableName = 'lc_forum_perm';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("lc_forum_perm",$where);
		$st->fields['lc_forum_perm_id'] = 'lc_forum_perm_id';
		$st->fields['lc_forum_id'] = 'lc_forum_id';
		$st->fields['lc_forum_perm_action'] = 'lc_forum_perm_action';
		$st->fields['lc_forum_perm_label'] = 'lc_forum_perm_label';
		$st->fields['lc_forum_perm_group'] = 'lc_forum_perm_group';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LcForumPermPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("lc_forum_perm");
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

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("lc_forum_perm");
		$st->fields['lc_forum_perm_id'] = $obj->lcForumPermId;
		$st->fields['lc_forum_id'] = $obj->lcForumId;
		$st->fields['lc_forum_perm_action'] = $obj->lcForumPermAction;
		$st->fields['lc_forum_perm_label'] = $obj->lcForumPermLabel;
		$st->fields['lc_forum_perm_group'] = $obj->lcForumPermGroup;

		$st->key = 'lc_forum_perm_id';
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
		$st = new LC_DeleteStatement("lc_forum_perm","lc_forum_perm_id = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

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
		$st = new LC_SelectStatement("lc_forum",$where);
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
