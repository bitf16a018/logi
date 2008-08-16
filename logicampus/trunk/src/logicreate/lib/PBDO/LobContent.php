<?

class LobContentBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.7';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lobContentId;
	var $lobText;
	var $lobBinary;
	var $lobFilename;
	var $lobCaption;
	var $lobRepoEntryId;

	var $__attributes = array( 
	'lobContentId'=>'integer',
	'lobText'=>'longtext',
	'lobBinary'=>'longblob',
	'lobFilename'=>'varchar',
	'lobCaption'=>'varchar',
	'lobRepoEntryId'=>'integer');

	var $__nulls = array( 
	'lobText'=>'lobText',
	'lobBinary'=>'lobBinary');

	/**
	 * Retrieves one lob_repo_entry object via the foreign key lob_repo_entry_id.
	 * 
	 * @param String $dsn the name of the data source to use for the sql query.
	 * @return Object the related object.
	 */
	function getLobRepoEntryByLobRepoEntryId($dsn='default') {
		if ( $this->lobRepoEntryId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = LobRepoEntryPeer::doSelect('lob_repo_entry_id = \''.$this->lobRepoEntryId.'\'',$dsn);
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->lobContentId;
	}


	function setPrimaryKey($val) {
		$this->lobContentId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LobContentPeer::doInsert($this,$dsn));
		} else {
			LobContentPeer::doUpdate($this,$dsn);
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
			$where = "lob_content_id='".$key."'";
		}
		$array = LobContentPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LobContentPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LobContentPeer::doDelete($this,$deep,$dsn);
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


class LobContentPeerBase {

	var $tableName = 'lob_content';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lob_content",$where);
		$st->fields['lob_content_id'] = 'lob_content_id';
		$st->fields['lob_text'] = 'lob_text';
		$st->fields['lob_binary'] = 'lob_binary';
		$st->fields['lob_filename'] = 'lob_filename';
		$st->fields['lob_caption'] = 'lob_caption';
		$st->fields['lob_repo_entry_id'] = 'lob_repo_entry_id';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LobContentPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lob_content");
		$st->fields['lob_content_id'] = $obj->lobContentId;
		$st->fields['lob_text'] = $obj->lobText;
		$st->fields['lob_binary'] = $obj->lobBinary;
		$st->fields['lob_filename'] = $obj->lobFilename;
		$st->fields['lob_caption'] = $obj->lobCaption;
		$st->fields['lob_repo_entry_id'] = $obj->lobRepoEntryId;

		$st->nulls['lob_text'] = 'lob_text';
		$st->nulls['lob_binary'] = 'lob_binary';

		$st->key = 'lob_content_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lob_content");
		$st->fields['lob_content_id'] = $obj->lobContentId;
		$st->fields['lob_text'] = $obj->lobText;
		$st->fields['lob_binary'] = $obj->lobBinary;
		$st->fields['lob_filename'] = $obj->lobFilename;
		$st->fields['lob_caption'] = $obj->lobCaption;
		$st->fields['lob_repo_entry_id'] = $obj->lobRepoEntryId;

		$st->nulls['lob_text'] = 'lob_text';
		$st->nulls['lob_binary'] = 'lob_binary';

		$st->key = 'lob_content_id';
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
		$st = new PBDO_DeleteStatement("lob_content","lob_content_id = '".$obj->getPrimaryKey()."'");

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
		$x = new LobContent();
		$x->lobContentId = $row['lob_content_id'];
		$x->lobText = $row['lob_text'];
		$x->lobBinary = $row['lob_binary'];
		$x->lobFilename = $row['lob_filename'];
		$x->lobCaption = $row['lob_caption'];
		$x->lobRepoEntryId = $row['lob_repo_entry_id'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LobContent extends LobContentBase {



}



class LobContentPeer extends LobContentPeerBase {

}

?>