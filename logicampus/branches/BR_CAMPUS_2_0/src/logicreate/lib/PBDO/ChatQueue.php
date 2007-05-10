<?

class ChatQueueBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $pkey;
	var $username;
	var $userpkey;
	var $usertype;
	var $timeint;
	var $timedate;
	var $message;

	var $__attributes = array( 
	'pkey'=>'integer',
	'username'=>'varchar',
	'userpkey'=>'integer',
	'usertype'=>'integer',
	'timeint'=>'integer',
	'timedate'=>'date',
	'message'=>'longvarchar');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->pkey;
	}


	function setPrimaryKey($val) {
		$this->pkey = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ChatQueuePeer::doInsert($this,$dsn));
		} else {
			ChatQueuePeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "pkey='".$key."'";
		}
		$array = ChatQueuePeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ChatQueuePeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ChatQueuePeer::doDelete($this,$deep,$dsn);
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


class ChatQueuePeerBase {

	var $tableName = 'chat_queue';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("chat_queue",$where);
		$st->fields['pkey'] = 'pkey';
		$st->fields['username'] = 'username';
		$st->fields['userpkey'] = 'userpkey';
		$st->fields['usertype'] = 'usertype';
		$st->fields['timeint'] = 'timeint';
		$st->fields['timedate'] = 'timedate';
		$st->fields['message'] = 'message';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ChatQueuePeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("chat_queue");
		$st->fields['pkey'] = $this->pkey;
		$st->fields['username'] = $this->username;
		$st->fields['userpkey'] = $this->userpkey;
		$st->fields['usertype'] = $this->usertype;
		$st->fields['timeint'] = $this->timeint;
		$st->fields['timedate'] = $this->timedate;
		$st->fields['message'] = $this->message;


		$st->key = 'pkey';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("chat_queue");
		$st->fields['pkey'] = $obj->pkey;
		$st->fields['username'] = $obj->username;
		$st->fields['userpkey'] = $obj->userpkey;
		$st->fields['usertype'] = $obj->usertype;
		$st->fields['timeint'] = $obj->timeint;
		$st->fields['timedate'] = $obj->timedate;
		$st->fields['message'] = $obj->message;


		$st->key = 'pkey';
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
		$st = new PBDO_DeleteStatement("chat_queue","pkey = '".$obj->getPrimaryKey()."'");

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
		$x = new ChatQueue();
		$x->pkey = $row['pkey'];
		$x->username = $row['username'];
		$x->userpkey = $row['userpkey'];
		$x->usertype = $row['usertype'];
		$x->timeint = $row['timeint'];
		$x->timedate = $row['timedate'];
		$x->message = $row['message'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ChatQueue extends ChatQueueBase {



}



class ChatQueuePeer extends ChatQueuePeerBase {

}

?>