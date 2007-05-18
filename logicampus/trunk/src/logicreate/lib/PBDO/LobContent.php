<?

class LobContentBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lobContentId;
	var $lobGuid;
	var $lobTitle;
	var $lobType;
	var $lobSubType;
	var $lobMime;
	var $lobCaption;
	var $lobDescription;
	var $lobNotes;
	var $lobContent;
	var $lobBinary;
	var $lobFilename;
	var $lobUrltitle;

	var $__attributes = array( 
	'lobContentId'=>'integer',
	'lobGuid'=>'varchar',
	'lobTitle'=>'varchar',
	'lobType'=>'varchar',
	'lobSubType'=>'varchar',
	'lobMime'=>'varchar',
	'lobCaption'=>'varchar',
	'lobDescription'=>'text',
	'lobNotes'=>'text',
	'lobContent'=>'text',
	'lobBinary'=>'blob',
	'lobFilename'=>'varchar',
	'lobUrltitle'=>'varchar');

	var $__nulls = array();



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
		$st->fields['lob_guid'] = 'lob_guid';
		$st->fields['lob_title'] = 'lob_title';
		$st->fields['lob_type'] = 'lob_type';
		$st->fields['lob_sub_type'] = 'lob_sub_type';
		$st->fields['lob_mime'] = 'lob_mime';
		$st->fields['lob_caption'] = 'lob_caption';
		$st->fields['lob_description'] = 'lob_description';
		$st->fields['lob_notes'] = 'lob_notes';
		$st->fields['lob_content'] = 'lob_content';
		$st->fields['lob_binary'] = 'lob_binary';
		$st->fields['lob_filename'] = 'lob_filename';
		$st->fields['lob_urltitle'] = 'lob_urltitle';


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
		$st->fields['lob_content_id'] = $this->lobContentId;
		$st->fields['lob_guid'] = $this->lobGuid;
		$st->fields['lob_title'] = $this->lobTitle;
		$st->fields['lob_type'] = $this->lobType;
		$st->fields['lob_sub_type'] = $this->lobSubType;
		$st->fields['lob_mime'] = $this->lobMime;
		$st->fields['lob_caption'] = $this->lobCaption;
		$st->fields['lob_description'] = $this->lobDescription;
		$st->fields['lob_notes'] = $this->lobNotes;
		$st->fields['lob_content'] = $this->lobContent;
		$st->fields['lob_binary'] = $this->lobBinary;
		$st->fields['lob_filename'] = $this->lobFilename;
		$st->fields['lob_urltitle'] = $this->lobUrltitle;


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
		$st->fields['lob_guid'] = $obj->lobGuid;
		$st->fields['lob_title'] = $obj->lobTitle;
		$st->fields['lob_type'] = $obj->lobType;
		$st->fields['lob_sub_type'] = $obj->lobSubType;
		$st->fields['lob_mime'] = $obj->lobMime;
		$st->fields['lob_caption'] = $obj->lobCaption;
		$st->fields['lob_description'] = $obj->lobDescription;
		$st->fields['lob_notes'] = $obj->lobNotes;
		$st->fields['lob_content'] = $obj->lobContent;
		$st->fields['lob_binary'] = $obj->lobBinary;
		$st->fields['lob_filename'] = $obj->lobFilename;
		$st->fields['lob_urltitle'] = $obj->lobUrltitle;


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
		$x->lobGuid = $row['lob_guid'];
		$x->lobTitle = $row['lob_title'];
		$x->lobType = $row['lob_type'];
		$x->lobSubType = $row['lob_sub_type'];
		$x->lobMime = $row['lob_mime'];
		$x->lobCaption = $row['lob_caption'];
		$x->lobDescription = $row['lob_description'];
		$x->lobNotes = $row['lob_notes'];
		$x->lobContent = $row['lob_content'];
		$x->lobBinary = $row['lob_binary'];
		$x->lobFilename = $row['lob_filename'];
		$x->lobUrltitle = $row['lob_urltitle'];

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