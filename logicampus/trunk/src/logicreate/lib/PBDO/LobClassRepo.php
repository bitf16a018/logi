<?

class LobClassRepoBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lobClassRepoId;
	var $classId;
	var $lobRepoEntryId;
	var $lobGuid;
	var $lobCopyStyle;
	var $lobType;
	var $lobSubType;
	var $lobVersion;

	var $__attributes = array( 
	'lobClassRepoId'=>'integer',
	'classId'=>'integer',
	'lobRepoEntryId'=>'integer',
	'lobGuid'=>'varchar',
	'lobCopyStyle'=>'char',
	'lobType'=>'varchar',
	'lobSubType'=>'varchar',
	'lobVersion'=>'integer');

	var $__nulls = array();

	/**
	 * Retrieves an array of lob_class_content objects via the foreign key lob_class_repo_id.
	 * 
	 * @param String $dsn the name of the data source to use for the sql query.
	 * @return Array related objects.
	 */
	function getLobClassContentsByLobClassRepoId($dsn='default') {
		if ( $this->lobClassRepoId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = LobClassContentPeer::doSelect('lob_class_repo_id = \''.$this->lobClassRepoId.'\'',$dsn);
		return $array;
	}



	function getPrimaryKey() {
		return $this->lobClassRepoId;
	}


	function setPrimaryKey($val) {
		$this->lobClassRepoId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LobClassRepoPeer::doInsert($this,$dsn));
		} else {
			LobClassRepoPeer::doUpdate($this,$dsn);
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
			$where = "lob_class_repo_id='".$key."'";
		}
		$array = LobClassRepoPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LobClassRepoPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LobClassRepoPeer::doDelete($this,$deep,$dsn);
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


class LobClassRepoPeerBase {

	var $tableName = 'lob_class_repo';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lob_class_repo",$where);
		$st->fields['lob_class_repo_id'] = 'lob_class_repo_id';
		$st->fields['class_id'] = 'class_id';
		$st->fields['lob_repo_entry_id'] = 'lob_repo_entry_id';
		$st->fields['lob_guid'] = 'lob_guid';
		$st->fields['lob_copy_style'] = 'lob_copy_style';
		$st->fields['lob_type'] = 'lob_type';
		$st->fields['lob_sub_type'] = 'lob_sub_type';
		$st->fields['lob_version'] = 'lob_version';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LobClassRepoPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lob_class_repo");
		$st->fields['lob_class_repo_id'] = $this->lobClassRepoId;
		$st->fields['class_id'] = $this->classId;
		$st->fields['lob_repo_entry_id'] = $this->lobRepoEntryId;
		$st->fields['lob_guid'] = $this->lobGuid;
		$st->fields['lob_copy_style'] = $this->lobCopyStyle;
		$st->fields['lob_type'] = $this->lobType;
		$st->fields['lob_sub_type'] = $this->lobSubType;
		$st->fields['lob_version'] = $this->lobVersion;


		$st->key = 'lob_class_repo_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lob_class_repo");
		$st->fields['lob_class_repo_id'] = $obj->lobClassRepoId;
		$st->fields['class_id'] = $obj->classId;
		$st->fields['lob_repo_entry_id'] = $obj->lobRepoEntryId;
		$st->fields['lob_guid'] = $obj->lobGuid;
		$st->fields['lob_copy_style'] = $obj->lobCopyStyle;
		$st->fields['lob_type'] = $obj->lobType;
		$st->fields['lob_sub_type'] = $obj->lobSubType;
		$st->fields['lob_version'] = $obj->lobVersion;


		$st->key = 'lob_class_repo_id';
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
		$st = new PBDO_DeleteStatement("lob_class_repo","lob_class_repo_id = '".$obj->getPrimaryKey()."'");

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
		$x = new LobClassRepo();
		$x->lobClassRepoId = $row['lob_class_repo_id'];
		$x->classId = $row['class_id'];
		$x->lobRepoEntryId = $row['lob_repo_entry_id'];
		$x->lobGuid = $row['lob_guid'];
		$x->lobCopyStyle = $row['lob_copy_style'];
		$x->lobType = $row['lob_type'];
		$x->lobSubType = $row['lob_sub_type'];
		$x->lobVersion = $row['lob_version'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LobClassRepo extends LobClassRepoBase {



}



class LobClassRepoPeer extends LobClassRepoPeerBase {

}

?>