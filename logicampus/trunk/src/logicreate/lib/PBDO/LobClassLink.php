<?

class LobClassLinkBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lobClassLinkId;
	var $lobId;
	var $lobKind;
	var $classId;

	var $__attributes = array( 
	'lobClassLinkId'=>'integer',
	'lobId'=>'integer',
	'lobKind'=>'varchar',
	'classId'=>'integer');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->lobClassLinkId;
	}


	function setPrimaryKey($val) {
		$this->lobClassLinkId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LobClassLinkPeer::doInsert($this,$dsn));
		} else {
			LobClassLinkPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "lob_class_link_id='".$key."'";
		}
		$array = LobClassLinkPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LobClassLinkPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LobClassLinkPeer::doDelete($this,$deep,$dsn);
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


class LobClassLinkPeerBase {

	var $tableName = 'lob_class_link';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lob_class_link",$where);
		$st->fields['lob_class_link_id'] = 'lob_class_link_id';
		$st->fields['lob_id'] = 'lob_id';
		$st->fields['lob_kind'] = 'lob_kind';
		$st->fields['class_id'] = 'class_id';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LobClassLinkPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lob_class_link");
		$st->fields['lob_class_link_id'] = $this->lobClassLinkId;
		$st->fields['lob_id'] = $this->lobId;
		$st->fields['lob_kind'] = $this->lobKind;
		$st->fields['class_id'] = $this->classId;


		$st->key = 'lob_class_link_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lob_class_link");
		$st->fields['lob_class_link_id'] = $obj->lobClassLinkId;
		$st->fields['lob_id'] = $obj->lobId;
		$st->fields['lob_kind'] = $obj->lobKind;
		$st->fields['class_id'] = $obj->classId;


		$st->key = 'lob_class_link_id';
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
		$st = new PBDO_DeleteStatement("lob_class_link","lob_class_link_id = '".$obj->getPrimaryKey()."'");

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
		$x = new LobClassLink();
		$x->lobClassLinkId = $row['lob_class_link_id'];
		$x->lobId = $row['lob_id'];
		$x->lobKind = $row['lob_kind'];
		$x->classId = $row['class_id'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LobClassLink extends LobClassLinkBase {



}



class LobClassLinkPeer extends LobClassLinkPeerBase {

}

?>