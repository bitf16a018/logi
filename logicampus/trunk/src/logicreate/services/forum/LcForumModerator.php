<?

class LcForumModeratorBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lcForumModeratorId;
	var $lcForumId;
	var $lcForumModeratorUsername;

	var $__attributes = array( 
	'lcForumModeratorId'=>'integer',
	'lcForumId'=>'integer',
	'lcForumModeratorUsername'=>'varchar');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->lcForumModeratorId;
	}


	function setPrimaryKey($val) {
		$this->lcForumModeratorId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LcForumModeratorPeer::doInsert($this,$dsn));
		} else {
			LcForumModeratorPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "lc_forum_moderator_id='".$key."'";
		}
		$array = LcForumModeratorPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LcForumModeratorPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LcForumModeratorPeer::doDelete($this,$deep,$dsn);
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


class LcForumModeratorPeerBase {

	var $tableName = 'lc_forum_moderator';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lc_forum_moderator",$where);
		$st->fields['lc_forum_moderator_id'] = 'lc_forum_moderator_id';
		$st->fields['lc_forum_id'] = 'lc_forum_id';
		$st->fields['lc_forum_moderator_username'] = 'lc_forum_moderator_username';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LcForumModeratorPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lc_forum_moderator");
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

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lc_forum_moderator");
		$st->fields['lc_forum_moderator_id'] = $obj->lcForumModeratorId;
		$st->fields['lc_forum_id'] = $obj->lcForumId;
		$st->fields['lc_forum_moderator_username'] = $obj->lcForumModeratorUsername;


		$st->key = 'lc_forum_moderator_id';
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
		$st = new PBDO_DeleteStatement("lc_forum_moderator","lc_forum_moderator_id = '".$obj->getPrimaryKey()."'");

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