<?

class LcForumSectionBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $lcForumSectionId;
	var $lcForumSectionName;
	var $lcForumSectionParentId;

	var $__attributes = array(
	'lcForumSectionId'=>'integer',
	'lcForumSectionName'=>'varchar',
	'lcForumSectionParentId'=>'int');

	function getLcForums() {
		$array = LcForumPeer::doSelect('lc_forum_section_id = \''.$this->getPrimaryKey().'\'');
		return $array;
	}



	function getPrimaryKey() {
		return $this->lcForumSectionId;
	}

	function setPrimaryKey($val) {
		$this->lcForumSectionId = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LcForumSectionPeer::doInsert($this));
		} else {
			LcForumSectionPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "lc_forum_section_id='".$key."'";
		}
		$array = LcForumSectionPeer::doSelect($where);
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
		if ($array['lcForumSectionName'])
			$this->lcForumSectionName = $array['lcForumSectionName'];
		if ($array['lcForumSectionParentId'])
			$this->lcForumSectionParentId = $array['lcForumSectionParentId'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class LcForumSectionPeerBase {

	var $tableName = 'lc_forum_section';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("lc_forum_section",$where);
		$st->fields['lc_forum_section_id'] = 'lc_forum_section_id';
		$st->fields['lc_forum_section_name'] = 'lc_forum_section_name';
		$st->fields['lc_forum_section_parent_id'] = 'lc_forum_section_parent_id';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LcForumSectionPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("lc_forum_section");
		$st->fields['lc_forum_section_id'] = $this->lcForumSectionId;
		$st->fields['lc_forum_section_name'] = $this->lcForumSectionName;
		$st->fields['lc_forum_section_parent_id'] = $this->lcForumSectionParentId;

		$st->key = 'lc_forum_section_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("lc_forum_section");
		$st->fields['lc_forum_section_id'] = $obj->lcForumSectionId;
		$st->fields['lc_forum_section_name'] = $obj->lcForumSectionName;
		$st->fields['lc_forum_section_parent_id'] = $obj->lcForumSectionParentId;

		$st->key = 'lc_forum_section_id';
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
		$st = new LC_DeleteStatement("lc_forum_section","lc_forum_section_id = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

			$st = new LC_DeleteStatement("lc_forum","lc_forum_section_id = '".$obj->getPrimaryKey()."'");
			$db->executeQuery($st);
		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

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