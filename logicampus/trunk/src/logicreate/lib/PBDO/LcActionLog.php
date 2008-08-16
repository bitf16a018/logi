<?

class LcActionLogBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.7';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lcActionLogId;
	var $lcActionLogTypeId;
	var $actionDatetime;
	var $agentIp;
	var $agentUrl;
	var $file;
	var $line;
	var $agentUsername;
	var $message;
	var $classId;
	var $semesterId;

	var $__attributes = array( 
	'lcActionLogId'=>'int',
	'lcActionLogTypeId'=>'int',
	'actionDatetime'=>'int',
	'agentIp'=>'varchar',
	'agentUrl'=>'varchar',
	'file'=>'varchar',
	'line'=>'varchar',
	'agentUsername'=>'varchar',
	'message'=>'blob',
	'classId'=>'int',
	'semesterId'=>'int');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->lcActionLogId;
	}


	function setPrimaryKey($val) {
		$this->lcActionLogId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LcActionLogPeer::doInsert($this,$dsn));
		} else {
			LcActionLogPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		$where = '';
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "lc_action_log_id='".$key."'";
		}
		$array = LcActionLogPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LcActionLogPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LcActionLogPeer::doDelete($this,$deep,$dsn);
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


class LcActionLogPeerBase {

	var $tableName = 'lc_action_log';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lc_action_log",$where);
		$st->fields['lc_action_log_id'] = 'lc_action_log_id';
		$st->fields['lc_action_log_type_id'] = 'lc_action_log_type_id';
		$st->fields['action_datetime'] = 'action_datetime';
		$st->fields['agent_ip'] = 'agent_ip';
		$st->fields['agent_url'] = 'agent_url';
		$st->fields['file'] = 'file';
		$st->fields['line'] = 'line';
		$st->fields['agent_username'] = 'agent_username';
		$st->fields['message'] = 'message';
		$st->fields['class_id'] = 'class_id';
		$st->fields['semester_id'] = 'semester_id';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LcActionLogPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lc_action_log");
		$st->fields['lc_action_log_id'] = $obj->lcActionLogId;
		$st->fields['lc_action_log_type_id'] = $obj->lcActionLogTypeId;
		$st->fields['action_datetime'] = $obj->actionDatetime;
		$st->fields['agent_ip'] = $obj->agentIp;
		$st->fields['agent_url'] = $obj->agentUrl;
		$st->fields['file'] = $obj->file;
		$st->fields['line'] = $obj->line;
		$st->fields['agent_username'] = $obj->agentUsername;
		$st->fields['message'] = $obj->message;
		$st->fields['class_id'] = $obj->classId;
		$st->fields['semester_id'] = $obj->semesterId;


		$st->key = 'lc_action_log_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lc_action_log");
		$st->fields['lc_action_log_id'] = $obj->lcActionLogId;
		$st->fields['lc_action_log_type_id'] = $obj->lcActionLogTypeId;
		$st->fields['action_datetime'] = $obj->actionDatetime;
		$st->fields['agent_ip'] = $obj->agentIp;
		$st->fields['agent_url'] = $obj->agentUrl;
		$st->fields['file'] = $obj->file;
		$st->fields['line'] = $obj->line;
		$st->fields['agent_username'] = $obj->agentUsername;
		$st->fields['message'] = $obj->message;
		$st->fields['class_id'] = $obj->classId;
		$st->fields['semester_id'] = $obj->semesterId;


		$st->key = 'lc_action_log_id';
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
		$st = new PBDO_DeleteStatement("lc_action_log","lc_action_log_id = '".$obj->getPrimaryKey()."'");

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
		$x = new LcActionLog();
		$x->lcActionLogId = $row['lc_action_log_id'];
		$x->lcActionLogTypeId = $row['lc_action_log_type_id'];
		$x->actionDatetime = $row['action_datetime'];
		$x->agentIp = $row['agent_ip'];
		$x->agentUrl = $row['agent_url'];
		$x->file = $row['file'];
		$x->line = $row['line'];
		$x->agentUsername = $row['agent_username'];
		$x->message = $row['message'];
		$x->classId = $row['class_id'];
		$x->semesterId = $row['semester_id'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LcActionLog extends LcActionLogBase {



}



class LcActionLogPeer extends LcActionLogPeerBase {

}

?>