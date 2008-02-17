<?

class LobClassMetadataBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lobClassMetadataId;
	var $lobClassRepoId;
	var $subject;
	var $subdisc;
	var $author;
	var $source;
	var $copyright;
	var $license;
	var $userVersion;
	var $status;
	var $updatedOn;
	var $createdOn;

	var $__attributes = array( 
	'lobClassMetadataId'=>'integer',
	'lobClassRepoId'=>'integer',
	'subject'=>'varchar',
	'subdisc'=>'varchar',
	'author'=>'varchar',
	'source'=>'varchar',
	'copyright'=>'varchar',
	'license'=>'varchar',
	'userVersion'=>'varchar',
	'status'=>'varchar',
	'updatedOn'=>'integer',
	'createdOn'=>'integer');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->lobClassMetadataId;
	}


	function setPrimaryKey($val) {
		$this->lobClassMetadataId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LobClassMetadataPeer::doInsert($this,$dsn));
		} else {
			LobClassMetadataPeer::doUpdate($this,$dsn);
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
			$where = "lob_class_metadata_id='".$key."'";
		}
		$array = LobClassMetadataPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LobClassMetadataPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LobClassMetadataPeer::doDelete($this,$deep,$dsn);
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


class LobClassMetadataPeerBase {

	var $tableName = 'lob_class_metadata';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lob_class_metadata",$where);
		$st->fields['lob_class_metadata_id'] = 'lob_class_metadata_id';
		$st->fields['lob_class_repo_id'] = 'lob_class_repo_id';
		$st->fields['subject'] = 'subject';
		$st->fields['subdisc'] = 'subdisc';
		$st->fields['author'] = 'author';
		$st->fields['source'] = 'source';
		$st->fields['copyright'] = 'copyright';
		$st->fields['license'] = 'license';
		$st->fields['user_version'] = 'user_version';
		$st->fields['status'] = 'status';
		$st->fields['updated_on'] = 'updated_on';
		$st->fields['created_on'] = 'created_on';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LobClassMetadataPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lob_class_metadata");
		$st->fields['lob_class_metadata_id'] = $this->lobClassMetadataId;
		$st->fields['lob_class_repo_id'] = $this->lobClassRepoId;
		$st->fields['subject'] = $this->subject;
		$st->fields['subdisc'] = $this->subdisc;
		$st->fields['author'] = $this->author;
		$st->fields['source'] = $this->source;
		$st->fields['copyright'] = $this->copyright;
		$st->fields['license'] = $this->license;
		$st->fields['user_version'] = $this->userVersion;
		$st->fields['status'] = $this->status;
		$st->fields['updated_on'] = $this->updatedOn;
		$st->fields['created_on'] = $this->createdOn;


		$st->key = 'lob_class_metadata_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lob_class_metadata");
		$st->fields['lob_class_metadata_id'] = $obj->lobClassMetadataId;
		$st->fields['lob_class_repo_id'] = $obj->lobClassRepoId;
		$st->fields['subject'] = $obj->subject;
		$st->fields['subdisc'] = $obj->subdisc;
		$st->fields['author'] = $obj->author;
		$st->fields['source'] = $obj->source;
		$st->fields['copyright'] = $obj->copyright;
		$st->fields['license'] = $obj->license;
		$st->fields['user_version'] = $obj->userVersion;
		$st->fields['status'] = $obj->status;
		$st->fields['updated_on'] = $obj->updatedOn;
		$st->fields['created_on'] = $obj->createdOn;


		$st->key = 'lob_class_metadata_id';
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
		$st = new PBDO_DeleteStatement("lob_class_metadata","lob_class_metadata_id = '".$obj->getPrimaryKey()."'");

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
		$x = new LobClassMetadata();
		$x->lobClassMetadataId = $row['lob_class_metadata_id'];
		$x->lobClassRepoId = $row['lob_class_repo_id'];
		$x->subject = $row['subject'];
		$x->subdisc = $row['subdisc'];
		$x->author = $row['author'];
		$x->source = $row['source'];
		$x->copyright = $row['copyright'];
		$x->license = $row['license'];
		$x->userVersion = $row['user_version'];
		$x->status = $row['status'];
		$x->updatedOn = $row['updated_on'];
		$x->createdOn = $row['created_on'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LobClassMetadata extends LobClassMetadataBase {



}



class LobClassMetadataPeer extends LobClassMetadataPeerBase {

}

?>