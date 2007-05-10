<?

class LcActionLogTypeBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.4';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lcActionLogTypeId;
	var $actionCode;
	var $displayName;

	var $__attributes = array(
	'lcActionLogTypeId'=>'int',
	'actionCode'=>'varchar',
	'displayName'=>'varchar');



	function getPrimaryKey() {
		return $this->lcActionLogTypeId;
	}

	function setPrimaryKey($val) {
		$this->lcActionLogTypeId = $val;
	}
	
	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LcActionLogTypePeer::doInsert($this,$dsn));
		} else {
			LcActionLogTypePeer::doUpdate($this,$dsn);
		}
	}

	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "lc_action_log_type_id='".$key."'";
		}
		$array = LcActionLogTypePeer::doSelect($where,$dsn);
		return $array[0];
	}

	function delete($deep=false,$dsn="default") {
		LcActionLogTypePeer::doDelete($this,$deep,$dsn);
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


class LcActionLogTypePeerBase {

	var $tableName = 'lc_action_log_type';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_SelectStatement("lc_action_log_type",$where);
		$st->fields['lc_action_log_type_id'] = 'lc_action_log_type_id';
		$st->fields['action_code'] = 'action_code';
		$st->fields['display_name'] = 'display_name';

		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LcActionLogTypePeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_InsertStatement("lc_action_log_type");
		$st->fields['lc_action_log_type_id'] = $this->lcActionLogTypeId;
		$st->fields['action_code'] = $this->actionCode;
		$st->fields['display_name'] = $this->displayName;

		$st->key = 'lc_action_log_type_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_UpdateStatement("lc_action_log_type");
		$st->fields['lc_action_log_type_id'] = $obj->lcActionLogTypeId;
		$st->fields['action_code'] = $obj->actionCode;
		$st->fields['display_name'] = $obj->displayName;

		$st->key = 'lc_action_log_type_id';
		$db->executeQuery($st);
		$obj->_modified = false;

	}

	function doReplace($obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		if ($this->isNew() ) {
			$db->executeQuery(new LC_InsertStatement($criteria));
		} else {
			$db->executeQuery(new LC_UpdateStatement($criteria));
		}
	}


	/**
	 * remove an object
	 */
	function doDelete(&$obj,$deep=false,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_DeleteStatement("lc_action_log_type","lc_action_log_type_id = '".$obj->getPrimaryKey()."'");

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
		$db = lcDB::getHandle($dsn);

		$db->query($sql);

	  	return;
	}



	function row2Obj($row) {
		$x = new LcActionLogType();
		$x->lcActionLogTypeId = $row['lc_action_log_type_id'];
		$x->actionCode = $row['action_code'];
		$x->displayName = $row['display_name'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LcActionLogType extends LcActionLogTypeBase {



}



class LcActionLogTypePeer extends LcActionLogTypePeerBase {

}

?>