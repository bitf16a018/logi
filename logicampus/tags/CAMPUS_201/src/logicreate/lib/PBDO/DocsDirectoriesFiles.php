<?

class DocsDirectoriesFilesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $directoryID;
	var $fileID;

	var $__attributes = array( 
	'directoryID'=>'integer',
	'fileID'=>'integer');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->fileID;
	}


	function setPrimaryKey($val) {
		$this->fileID = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(DocsDirectoriesFilesPeer::doInsert($this,$dsn));
		} else {
			DocsDirectoriesFilesPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "fileID='".$key."'";
		}
		$array = DocsDirectoriesFilesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = DocsDirectoriesFilesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		DocsDirectoriesFilesPeer::doDelete($this,$deep,$dsn);
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


class DocsDirectoriesFilesPeerBase {

	var $tableName = 'docs_directories_files';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("docs_directories_files",$where);
		$st->fields['directoryID'] = 'directoryID';
		$st->fields['fileID'] = 'fileID';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = DocsDirectoriesFilesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("docs_directories_files");
		$st->fields['directoryID'] = $this->directoryID;
		$st->fields['fileID'] = $this->fileID;


		$st->key = 'fileID';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("docs_directories_files");
		$st->fields['directoryID'] = $obj->directoryID;
		$st->fields['fileID'] = $obj->fileID;


		$st->key = 'fileID';
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
		$st = new PBDO_DeleteStatement("docs_directories_files","fileID = '".$obj->getPrimaryKey()."'");

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
		$x = new DocsDirectoriesFiles();
		$x->directoryID = $row['directoryID'];
		$x->fileID = $row['fileID'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class DocsDirectoriesFiles extends DocsDirectoriesFilesBase {



}



class DocsDirectoriesFilesPeer extends DocsDirectoriesFilesPeerBase {

}

?>