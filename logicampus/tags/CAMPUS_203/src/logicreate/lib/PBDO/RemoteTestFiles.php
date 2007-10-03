<?

class RemoteTestFilesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $pkey;
	var $email;
	var $hash;
	var $FILE;
	var $displayname;
	var $description;
	var $mime;
	var $filedate;
	var $size;
	var $clicks;

	var $__attributes = array( 
	'pkey'=>'integer',
	'email'=>'varchar',
	'hash'=>'varchar',
	'FILE'=>'varchar',
	'displayname'=>'varchar',
	'description'=>'varchar',
	'mime'=>'varchar',
	'filedate'=>'datetime',
	'size'=>'integer',
	'clicks'=>'integer');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->pkey;
	}


	function setPrimaryKey($val) {
		$this->pkey = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(RemoteTestFilesPeer::doInsert($this,$dsn));
		} else {
			RemoteTestFilesPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "pkey='".$key."'";
		}
		$array = RemoteTestFilesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = RemoteTestFilesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		RemoteTestFilesPeer::doDelete($this,$deep,$dsn);
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


class RemoteTestFilesPeerBase {

	var $tableName = 'remote_test_files';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("remote_test_files",$where);
		$st->fields['pkey'] = 'pkey';
		$st->fields['email'] = 'email';
		$st->fields['hash'] = 'hash';
		$st->fields['FILE'] = 'FILE';
		$st->fields['displayname'] = 'displayname';
		$st->fields['description'] = 'description';
		$st->fields['mime'] = 'mime';
		$st->fields['filedate'] = 'filedate';
		$st->fields['size'] = 'size';
		$st->fields['clicks'] = 'clicks';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = RemoteTestFilesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("remote_test_files");
		$st->fields['pkey'] = $this->pkey;
		$st->fields['email'] = $this->email;
		$st->fields['hash'] = $this->hash;
		$st->fields['FILE'] = $this->FILE;
		$st->fields['displayname'] = $this->displayname;
		$st->fields['description'] = $this->description;
		$st->fields['mime'] = $this->mime;
		$st->fields['filedate'] = $this->filedate;
		$st->fields['size'] = $this->size;
		$st->fields['clicks'] = $this->clicks;


		$st->key = 'pkey';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("remote_test_files");
		$st->fields['pkey'] = $obj->pkey;
		$st->fields['email'] = $obj->email;
		$st->fields['hash'] = $obj->hash;
		$st->fields['FILE'] = $obj->FILE;
		$st->fields['displayname'] = $obj->displayname;
		$st->fields['description'] = $obj->description;
		$st->fields['mime'] = $obj->mime;
		$st->fields['filedate'] = $obj->filedate;
		$st->fields['size'] = $obj->size;
		$st->fields['clicks'] = $obj->clicks;


		$st->key = 'pkey';
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
		$st = new PBDO_DeleteStatement("remote_test_files","pkey = '".$obj->getPrimaryKey()."'");

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
		$x = new RemoteTestFiles();
		$x->pkey = $row['pkey'];
		$x->email = $row['email'];
		$x->hash = $row['hash'];
		$x->FILE = $row['FILE'];
		$x->displayname = $row['displayname'];
		$x->description = $row['description'];
		$x->mime = $row['mime'];
		$x->filedate = $row['filedate'];
		$x->size = $row['size'];
		$x->clicks = $row['clicks'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class RemoteTestFiles extends RemoteTestFilesBase {



}



class RemoteTestFilesPeer extends RemoteTestFilesPeerBase {

}

?>