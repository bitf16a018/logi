<?

class LcForumModeratorBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $lcForumModeratorId;
	var $lcForumId;
	var $lcForumModeratorUsername;

	var $__attributes = array(
	'lcForumModeratorId'=>'integer',
	'lcForumId'=>'LcForum',
	'lcForumModeratorUsername'=>'varchar');

	function getLcForum() {
		if ( $this->lcForumId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = LcForumPeer::doSelect('lc_forum_id = \''.$this->lcForumId.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->lcForumModeratorId;
	}

	function setPrimaryKey($val) {
		$this->lcForumModeratorId = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LcForumModeratorPeer::doInsert($this));
		} else {
			LcForumModeratorPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "lc_forum_moderator_id='".$key."'";
		}
		$array = LcForumModeratorPeer::doSelect($where);
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
		if ($array['lcForumModeratorUsername'])
			$this->lcForumModeratorUsername = $array['lcForumModeratorUsername'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class LcForumModeratorPeerBase {

	var $tableName = 'lc_forum_moderator';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("lc_forum_moderator",$where);
		$st->fields['lc_forum_moderator_id'] = 'lc_forum_moderator_id';
		$st->fields['lc_forum_id'] = 'lc_forum_id';
		$st->fields['lc_forum_moderator_username'] = 'lc_forum_moderator_username';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LcForumModeratorPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("lc_forum_moderator");
		$st->fields['lc_forum_moderator_id'] = $this->lcForumModeratorId;
		$st->fields['lc_forum_id'] = $this->lcForumId;
		$st->fields['lc_forum_moderator_username'] = $this->lcForumModeratorUsername;

		$st->key = 'lc_forum_moderator_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("lc_forum_moderator");
		$st->fields['lc_forum_moderator_id'] = $obj->lcForumModeratorId;
		$st->fields['lc_forum_id'] = $obj->lcForumId;
		$st->fields['lc_forum_moderator_username'] = $obj->lcForumModeratorUsername;

		$st->key = 'lc_forum_moderator_id';
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
		$st = new LC_DeleteStatement("lc_forum_moderator","lc_forum_moderator_id = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new LcForumModerator();
		$x->lcForumModeratorId = $row['lc_forum_moderator_id'];
		$x->lcForumId = $row['lc_forum_id'];
		$x->lcForumModeratorUsername = $row['lc_forum_moderator_username'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class LcForumModerator extends LcForumModeratorBase {



}



class LcForumModeratorPeer extends LcForumModeratorPeerBase {

}

?>