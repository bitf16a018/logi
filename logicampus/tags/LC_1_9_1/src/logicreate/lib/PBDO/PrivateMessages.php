<?

class PrivateMessagesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $pkey;
	var $messageFrom;
	var $messageTo;
	var $message;
	var $sentTime;
	var $receivedTime;
	var $subject;
	var $repliedTime;

	var $__attributes = array( 
	'pkey'=>'integer',
	'messageFrom'=>'varchar',
	'messageTo'=>'varchar',
	'message'=>'longvarchar',
	'sentTime'=>'integer',
	'receivedTime'=>'integer',
	'subject'=>'varchar',
	'repliedTime'=>'integer');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->pkey;
	}


	function setPrimaryKey($val) {
		$this->pkey = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(PrivateMessagesPeer::doInsert($this,$dsn));
		} else {
			PrivateMessagesPeer::doUpdate($this,$dsn);
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
		$array = PrivateMessagesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = PrivateMessagesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		PrivateMessagesPeer::doDelete($this,$deep,$dsn);
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


class PrivateMessagesPeerBase {

	var $tableName = 'privateMessages';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("privateMessages",$where);
		$st->fields['pkey'] = 'pkey';
		$st->fields['messageFrom'] = 'messageFrom';
		$st->fields['messageTo'] = 'messageTo';
		$st->fields['message'] = 'message';
		$st->fields['sentTime'] = 'sentTime';
		$st->fields['receivedTime'] = 'receivedTime';
		$st->fields['subject'] = 'subject';
		$st->fields['repliedTime'] = 'repliedTime';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = PrivateMessagesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("privateMessages");
		$st->fields['pkey'] = $this->pkey;
		$st->fields['messageFrom'] = $this->messageFrom;
		$st->fields['messageTo'] = $this->messageTo;
		$st->fields['message'] = $this->message;
		$st->fields['sentTime'] = $this->sentTime;
		$st->fields['receivedTime'] = $this->receivedTime;
		$st->fields['subject'] = $this->subject;
		$st->fields['repliedTime'] = $this->repliedTime;


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
		$st = new PBDO_UpdateStatement("privateMessages");
		$st->fields['pkey'] = $obj->pkey;
		$st->fields['messageFrom'] = $obj->messageFrom;
		$st->fields['messageTo'] = $obj->messageTo;
		$st->fields['message'] = $obj->message;
		$st->fields['sentTime'] = $obj->sentTime;
		$st->fields['receivedTime'] = $obj->receivedTime;
		$st->fields['subject'] = $obj->subject;
		$st->fields['repliedTime'] = $obj->repliedTime;


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
		$st = new PBDO_DeleteStatement("privateMessages","pkey = '".$obj->getPrimaryKey()."'");

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
		$x = new PrivateMessages();
		$x->pkey = $row['pkey'];
		$x->messageFrom = $row['messageFrom'];
		$x->messageTo = $row['messageTo'];
		$x->message = $row['message'];
		$x->sentTime = $row['sentTime'];
		$x->receivedTime = $row['receivedTime'];
		$x->subject = $row['subject'];
		$x->repliedTime = $row['repliedTime'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class PrivateMessages extends PrivateMessagesBase {



}



class PrivateMessagesPeer extends PrivateMessagesPeerBase {

}

?>