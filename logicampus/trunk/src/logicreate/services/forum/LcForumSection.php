<?

class LcForumSectionBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lcForumSectionId;
	var $lcForumSectionName;
	var $lcForumSectionParentId;

	var $__attributes = array( 
	'lcForumSectionId'=>'integer',
	'lcForumSectionName'=>'varchar',
	'lcForumSectionParentId'=>'integer');

	var $__nulls = array( 
	'lcForumSectionName'=>'lcForumSectionName',
	'lcForumSectionParentId'=>'lcForumSectionParentId');



	function getPrimaryKey() {
		return $this->lcForumSectionId;
	}


	function setPrimaryKey($val) {
		$this->lcForumSectionId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LcForumSectionPeer::doInsert($this,$dsn));
		} else {
			LcForumSectionPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "lc_forum_section_id='".$key."'";
		}
		$array = LcForumSectionPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LcForumSectionPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LcForumSectionPeer::doDelete($this,$deep,$dsn);
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


class LcForumSectionPeerBase {

	var $tableName = 'lc_forum_section';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lc_forum_section",$where);
		$st->fields['lc_forum_section_id'] = 'lc_forum_section_id';
		$st->fields['lc_forum_section_name'] = 'lc_forum_section_name';
		$st->fields['lc_forum_section_parent_id'] = 'lc_forum_section_parent_id';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LcForumSectionPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lc_forum_section");
		$st->fields['lc_forum_section_id'] = $this->lcForumSectionId;
		$st->fields['lc_forum_section_name'] = $this->lcForumSectionName;
		$st->fields['lc_forum_section_parent_id'] = $this->lcForumSectionParentId;

		$st->nulls['lc_forum_section_name'] = 'lc_forum_section_name';
		$st->nulls['lc_forum_section_parent_id'] = 'lc_forum_section_parent_id';

		$st->key = 'lc_forum_section_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lc_forum_section");
		$st->fields['lc_forum_section_id'] = $obj->lcForumSectionId;
		$st->fields['lc_forum_section_name'] = $obj->lcForumSectionName;
		$st->fields['lc_forum_section_parent_id'] = $obj->lcForumSectionParentId;

		$st->nulls['lc_forum_section_name'] = 'lc_forum_section_name';
		$st->nulls['lc_forum_section_parent_id'] = 'lc_forum_section_parent_id';

		$st->key = 'lc_forum_section_id';
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
		$st = new PBDO_DeleteStatement("lc_forum_section","lc_forum_section_id = '".$obj->getPrimaryKey()."'");

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
		$x = new LcForumSection();
		$x->lcForumSectionId = $row['lc_forum_section_id'];
		$x->lcForumSectionName = $row['lc_forum_section_name'];
		$x->lcForumSectionParentId = $row['lc_forum_section_parent_id'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LcForumSection extends LcForumSectionBase {



}



class LcForumSectionPeer extends LcForumSectionPeerBase {

}

?>