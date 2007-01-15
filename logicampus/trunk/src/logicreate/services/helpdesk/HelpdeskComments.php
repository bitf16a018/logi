<?

class HelpdeskCommentsBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $helpdeskCommentsId;
	var $userid;
	var $comment;

	var $__attributes = array( 
	'helpdeskCommentsId'=>'integer',
	'userid'=>'varchar',
	'comment'=>'longvarchar');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->helpdeskCommentsId;
	}


	function setPrimaryKey($val) {
		$this->helpdeskCommentsId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(HelpdeskCommentsPeer::doInsert($this,$dsn));
		} else {
			HelpdeskCommentsPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "helpdesk_comments_id='".$key."'";
		}
		$array = HelpdeskCommentsPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = HelpdeskCommentsPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		HelpdeskCommentsPeer::doDelete($this,$deep,$dsn);
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


class HelpdeskCommentsPeerBase {

	var $tableName = 'helpdesk_comments';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("helpdesk_comments",$where);
		$st->fields['helpdesk_comments_id'] = 'helpdesk_comments_id';
		$st->fields['userid'] = 'userid';
		$st->fields['comment'] = 'comment';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = HelpdeskCommentsPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("helpdesk_comments");
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

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("helpdesk_comments");
		$st->fields['helpdesk_comments_id'] = $obj->helpdeskCommentsId;
		$st->fields['userid'] = $obj->userid;
		$st->fields['comment'] = $obj->comment;


		$st->key = 'helpdesk_comments_id';
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
		$st = new PBDO_DeleteStatement("helpdesk_comments","helpdesk_comments_id = '".$obj->getPrimaryKey()."'");

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