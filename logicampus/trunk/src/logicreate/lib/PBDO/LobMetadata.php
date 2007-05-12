<?

class LobMetadataBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lobMetadataId;
	var $lobId;
	var $lobKind;
	var $subject;
	var $subdisc;
	var $author;
	var $copyright;
	var $license;
	var $version;
	var $status;
	var $updatedOn;
	var $createdOn;

	var $__attributes = array( 
	'lobMetadataId'=>'integer',
	'lobId'=>'integer',
	'lobKind'=>'varchar',
	'subject'=>'varchar',
	'subdisc'=>'varchar',
	'author'=>'varchar',
	'copyright'=>'varchar',
	'license'=>'varchar',
	'version'=>'varchar',
	'status'=>'varchar',
	'updatedOn'=>'integer',
	'createdOn'=>'integer');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->lobMetadataId;
	}


	function setPrimaryKey($val) {
		$this->lobMetadataId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LobMetadataPeer::doInsert($this,$dsn));
		} else {
			LobMetadataPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "lob_metadata_id='".$key."'";
		}
		$array = LobMetadataPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LobMetadataPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LobMetadataPeer::doDelete($this,$deep,$dsn);
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


class LobMetadataPeerBase {

	var $tableName = 'lob_metadata';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lob_metadata",$where);
		$st->fields['lob_metadata_id'] = 'lob_metadata_id';
		$st->fields['lob_id'] = 'lob_id';
		$st->fields['lob_kind'] = 'lob_kind';
		$st->fields['subject'] = 'subject';
		$st->fields['subdisc'] = 'subdisc';
		$st->fields['author'] = 'author';
		$st->fields['copyright'] = 'copyright';
		$st->fields['license'] = 'license';
		$st->fields['version'] = 'version';
		$st->fields['status'] = 'status';
		$st->fields['updated_on'] = 'updated_on';
		$st->fields['created_on'] = 'created_on';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LobMetadataPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lob_metadata");
		$st->fields['lob_metadata_id'] = $this->lobMetadataId;
		$st->fields['lob_id'] = $this->lobId;
		$st->fields['lob_kind'] = $this->lobKind;
		$st->fields['subject'] = $this->subject;
		$st->fields['subdisc'] = $this->subdisc;
		$st->fields['author'] = $this->author;
		$st->fields['copyright'] = $this->copyright;
		$st->fields['license'] = $this->license;
		$st->fields['version'] = $this->version;
		$st->fields['status'] = $this->status;
		$st->fields['updated_on'] = $this->updatedOn;
		$st->fields['created_on'] = $this->createdOn;


		$st->key = 'lob_metadata_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lob_metadata");
		$st->fields['lob_metadata_id'] = $obj->lobMetadataId;
		$st->fields['lob_id'] = $obj->lobId;
		$st->fields['lob_kind'] = $obj->lobKind;
		$st->fields['subject'] = $obj->subject;
		$st->fields['subdisc'] = $obj->subdisc;
		$st->fields['author'] = $obj->author;
		$st->fields['copyright'] = $obj->copyright;
		$st->fields['license'] = $obj->license;
		$st->fields['version'] = $obj->version;
		$st->fields['status'] = $obj->status;
		$st->fields['updated_on'] = $obj->updatedOn;
		$st->fields['created_on'] = $obj->createdOn;


		$st->key = 'lob_metadata_id';
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
		$st = new PBDO_DeleteStatement("lob_metadata","lob_metadata_id = '".$obj->getPrimaryKey()."'");

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
		$x = new LobMetadata();
		$x->lobMetadataId = $row['lob_metadata_id'];
		$x->lobId = $row['lob_id'];
		$x->lobKind = $row['lob_kind'];
		$x->subject = $row['subject'];
		$x->subdisc = $row['subdisc'];
		$x->author = $row['author'];
		$x->copyright = $row['copyright'];
		$x->license = $row['license'];
		$x->version = $row['version'];
		$x->status = $row['status'];
		$x->updatedOn = $row['updated_on'];
		$x->createdOn = $row['created_on'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LobMetadata extends LobMetadataBase {



}



class LobMetadataPeer extends LobMetadataPeerBase {

}

?>