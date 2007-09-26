<?

class LobClassContentBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lobClassContentId;
	var $lobClassRepoId;
	var $lobText;
	var $lobBinary;
	var $lobFilename;
	var $lobCaption;

	var $__attributes = array( 
	'lobClassContentId'=>'integer',
	'lobClassRepoId'=>'integer',
	'lobText'=>'longtext',
	'lobBinary'=>'longblob',
	'lobFilename'=>'varchar',
	'lobCaption'=>'varchar');

	var $__nulls = array( 
	'lobText'=>'lobText',
	'lobBinary'=>'lobBinary');

	/**
	 * Retrieves one lob_class_repo object via the foreign key lob_class_repo_id.
	 * 
	 * @param String $dsn the name of the data source to use for the sql query.
	 * @return Object the related object.
	 */
	function getLobClassRepoByLobClassRepoId($dsn='default') {
		if ( $this->lobClassRepoId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = LobClassRepoPeer::doSelect('lob_class_repo_id = \''.$this->lobClassRepoId.'\'',$dsn);
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->lobClassContentId;
	}


	function setPrimaryKey($val) {
		$this->lobClassContentId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LobClassContentPeer::doInsert($this,$dsn));
		} else {
			LobClassContentPeer::doUpdate($this,$dsn);
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
			$where = "lob_class_content_id='".$key."'";
		}
		$array = LobClassContentPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LobClassContentPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LobClassContentPeer::doDelete($this,$deep,$dsn);
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


class LobClassContentPeerBase {

	var $tableName = 'lob_class_content';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lob_class_content",$where);
		$st->fields['lob_class_content_id'] = 'lob_class_content_id';
		$st->fields['lob_class_repo_id'] = 'lob_class_repo_id';
		$st->fields['lob_text'] = 'lob_text';
		$st->fields['lob_binary'] = 'lob_binary';
		$st->fields['lob_filename'] = 'lob_filename';
		$st->fields['lob_caption'] = 'lob_caption';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LobClassContentPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lob_class_content");
		$st->fields['lob_class_content_id'] = $this->lobClassContentId;
		$st->fields['lob_class_repo_id'] = $this->lobClassRepoId;
		$st->fields['lob_text'] = $this->lobText;
		$st->fields['lob_binary'] = $this->lobBinary;
		$st->fields['lob_filename'] = $this->lobFilename;
		$st->fields['lob_caption'] = $this->lobCaption;

		$st->nulls['lob_text'] = 'lob_text';
		$st->nulls['lob_binary'] = 'lob_binary';

		$st->key = 'lob_class_content_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lob_class_content");
		$st->fields['lob_class_content_id'] = $obj->lobClassContentId;
		$st->fields['lob_class_repo_id'] = $obj->lobClassRepoId;
		$st->fields['lob_text'] = $obj->lobText;
		$st->fields['lob_binary'] = $obj->lobBinary;
		$st->fields['lob_filename'] = $obj->lobFilename;
		$st->fields['lob_caption'] = $obj->lobCaption;

		$st->nulls['lob_text'] = 'lob_text';
		$st->nulls['lob_binary'] = 'lob_binary';

		$st->key = 'lob_class_content_id';
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
		$st = new PBDO_DeleteStatement("lob_class_content","lob_class_content_id = '".$obj->getPrimaryKey()."'");

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
		$x = new LobClassContent();
		$x->lobClassContentId = $row['lob_class_content_id'];
		$x->lobClassRepoId = $row['lob_class_repo_id'];
		$x->lobText = $row['lob_text'];
		$x->lobBinary = $row['lob_binary'];
		$x->lobFilename = $row['lob_filename'];
		$x->lobCaption = $row['lob_caption'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LobClassContent extends LobClassContentBase {



}



class LobClassContentPeer extends LobClassContentPeerBase {

}

?>