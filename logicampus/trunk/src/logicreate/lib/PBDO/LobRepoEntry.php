<?

class LobRepoEntryBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lobRepoEntryId;
	var $lobGuid;
	var $lobTitle;
	var $lobType;
	var $lobSubType;
	var $lobMime;
	var $lobDescription;
	var $lobNotes;
	var $lobUrltitle;
	var $lobVersion;

	var $__attributes = array( 
	'lobRepoEntryId'=>'integer',
	'lobGuid'=>'varchar',
	'lobTitle'=>'varchar',
	'lobType'=>'varchar',
	'lobSubType'=>'varchar',
	'lobMime'=>'varchar',
	'lobDescription'=>'text',
	'lobNotes'=>'longtext',
	'lobUrltitle'=>'varchar',
	'lobVersion'=>'integer');

	var $__nulls = array();

	/**
	 * Retrieves an array of lob_content objects via the foreign key lob_repo_entry_id.
	 * 
	 * @param String $dsn the name of the data source to use for the sql query.
	 * @return Array related objects.
	 */
	function getLobContentsByLobRepoEntryId($dsn='default') {
		if ( $this->lobRepoEntryId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = LobContentPeer::doSelect('lob_repo_entry_id = \''.$this->lobRepoEntryId.'\'',$dsn);
		return $array;
	}

	/**
	 * Retrieves an array of lob_test objects via the foreign key lob_repo_entry_id.
	 * 
	 * @param String $dsn the name of the data source to use for the sql query.
	 * @return Array related objects.
	 */
	function getLobTestsByLobRepoEntryId($dsn='default') {
		if ( $this->lobRepoEntryId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = LobTestPeer::doSelect('lob_repo_entry_id = \''.$this->lobRepoEntryId.'\'',$dsn);
		return $array;
	}

	/**
	 * Retrieves an array of lob_activity objects via the foreign key lob_repo_entry_id.
	 * 
	 * @param String $dsn the name of the data source to use for the sql query.
	 * @return Array related objects.
	 */
	function getLobActivitysByLobRepoEntryId($dsn='default') {
		if ( $this->lobRepoEntryId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = LobActivityPeer::doSelect('lob_repo_entry_id = \''.$this->lobRepoEntryId.'\'',$dsn);
		return $array;
	}



	function getPrimaryKey() {
		return $this->lobRepoEntryId;
	}


	function setPrimaryKey($val) {
		$this->lobRepoEntryId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LobRepoEntryPeer::doInsert($this,$dsn));
		} else {
			LobRepoEntryPeer::doUpdate($this,$dsn);
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
			$where = "lob_repo_entry_id='".$key."'";
		}
		$array = LobRepoEntryPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LobRepoEntryPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LobRepoEntryPeer::doDelete($this,$deep,$dsn);
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


class LobRepoEntryPeerBase {

	var $tableName = 'lob_repo_entry';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lob_repo_entry",$where);
		$st->fields['lob_repo_entry_id'] = 'lob_repo_entry_id';
		$st->fields['lob_guid'] = 'lob_guid';
		$st->fields['lob_title'] = 'lob_title';
		$st->fields['lob_type'] = 'lob_type';
		$st->fields['lob_sub_type'] = 'lob_sub_type';
		$st->fields['lob_mime'] = 'lob_mime';
		$st->fields['lob_description'] = 'lob_description';
		$st->fields['lob_notes'] = 'lob_notes';
		$st->fields['lob_urltitle'] = 'lob_urltitle';
		$st->fields['lob_version'] = 'lob_version';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LobRepoEntryPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lob_repo_entry");
		$st->fields['lob_repo_entry_id'] = $this->lobRepoEntryId;
		$st->fields['lob_guid'] = $this->lobGuid;
		$st->fields['lob_title'] = $this->lobTitle;
		$st->fields['lob_type'] = $this->lobType;
		$st->fields['lob_sub_type'] = $this->lobSubType;
		$st->fields['lob_mime'] = $this->lobMime;
		$st->fields['lob_description'] = $this->lobDescription;
		$st->fields['lob_notes'] = $this->lobNotes;
		$st->fields['lob_urltitle'] = $this->lobUrltitle;
		$st->fields['lob_version'] = $this->lobVersion;


		$st->key = 'lob_repo_entry_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lob_repo_entry");
		$st->fields['lob_repo_entry_id'] = $obj->lobRepoEntryId;
		$st->fields['lob_guid'] = $obj->lobGuid;
		$st->fields['lob_title'] = $obj->lobTitle;
		$st->fields['lob_type'] = $obj->lobType;
		$st->fields['lob_sub_type'] = $obj->lobSubType;
		$st->fields['lob_mime'] = $obj->lobMime;
		$st->fields['lob_description'] = $obj->lobDescription;
		$st->fields['lob_notes'] = $obj->lobNotes;
		$st->fields['lob_urltitle'] = $obj->lobUrltitle;
		$st->fields['lob_version'] = $obj->lobVersion;


		$st->key = 'lob_repo_entry_id';
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
		$st = new PBDO_DeleteStatement("lob_repo_entry","lob_repo_entry_id = '".$obj->getPrimaryKey()."'");

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
		$x = new LobRepoEntry();
		$x->lobRepoEntryId = $row['lob_repo_entry_id'];
		$x->lobGuid = $row['lob_guid'];
		$x->lobTitle = $row['lob_title'];
		$x->lobType = $row['lob_type'];
		$x->lobSubType = $row['lob_sub_type'];
		$x->lobMime = $row['lob_mime'];
		$x->lobDescription = $row['lob_description'];
		$x->lobNotes = $row['lob_notes'];
		$x->lobUrltitle = $row['lob_urltitle'];
		$x->lobVersion = $row['lob_version'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LobRepoEntry extends LobRepoEntryBase {



}



class LobRepoEntryPeer extends LobRepoEntryPeerBase {

}

?>