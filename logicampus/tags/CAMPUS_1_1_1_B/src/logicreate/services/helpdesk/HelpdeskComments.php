<?

class HelpdeskCommentsBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $helpdeskCommentsId;
	var $userid;
	var $comment;

	var $__attributes = array(
	'helpdeskCommentsId'=>'INTEGER',
	'userid'=>'varchar',
	'comment'=>'text');



	function getPrimaryKey() {
		return $this->helpdeskCommentsId;
	}

	function setPrimaryKey($val) {
		$this->helpdeskCommentsId = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(HelpdeskCommentsPeer::doInsert($this));
		} else {
			HelpdeskCommentsPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "helpdesk_comments_id='".$key."'";
		}
		$array = HelpdeskCommentsPeer::doSelect($where);
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
		if ($array['userid'])
			$this->userid = $array['userid'];
		if ($array['comment'])
			$this->comment = $array['comment'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class HelpdeskCommentsPeerBase {

	var $tableName = 'helpdesk_comments';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("helpdesk_comments",$where);
		$st->fields['helpdesk_comments_id'] = 'helpdesk_comments_id';
		$st->fields['userid'] = 'userid';
		$st->fields['comment'] = 'comment';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = HelpdeskCommentsPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("helpdesk_comments");
		$st->fields['helpdesk_comments_id'] = $this->helpdeskCommentsId;
		$st->fields['userid'] = $this->userid;
		$st->fields['comment'] = $this->comment;

		$st->key = 'helpdesk_comments_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("helpdesk_comments");
		$st->fields['helpdesk_comments_id'] = $obj->helpdeskCommentsId;
		$st->fields['userid'] = $obj->userid;
		$st->fields['comment'] = $obj->comment;

		$st->key = 'helpdesk_comments_id';
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
		$st = new LC_DeleteStatement("helpdesk_comments","helpdesk_comments_id = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new HelpdeskComments();
		$x->helpdeskCommentsId = $row['helpdesk_comments_id'];
		$x->userid = $row['userid'];
		$x->comment = $row['comment'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class HelpdeskComments extends HelpdeskCommentsBase {



}



class HelpdeskCommentsPeer extends HelpdeskCommentsPeerBase {

}

?>