<?

class DocsFilesGroupsBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $fileID;
	var $gid;

	var $__attributes = array( 
	'fileID'=>'integer',
	'gid'=>'varchar');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->gid;
	}


	function setPrimaryKey($val) {
		$this->gid = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(DocsFilesGroupsPeer::doInsert($this,$dsn));
		} else {
			DocsFilesGroupsPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "gid='".$key."'";
		}
		$array = DocsFilesGroupsPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = DocsFilesGroupsPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		DocsFilesGroupsPeer::doDelete($this,$deep,$dsn);
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


class DocsFilesGroupsPeerBase {

	var $tableName = 'docs_files_groups';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("docs_files_groups",$where);
		$st->fields['fileID'] = 'fileID';
		$st->fields['gid'] = 'gid';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = DocsFilesGroupsPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("docs_files_groups");
		$st->fields['fileID'] = $this->fileID;
		$st->fields['gid'] = $this->gid;


		$st->key = 'gid';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("docs_files_groups");
		$st->fields['fileID'] = $obj->fileID;
		$st->fields['gid'] = $obj->gid;


		$st->key = 'gid';
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
		$st = new PBDO_DeleteStatement("docs_files_groups","gid = '".$obj->getPrimaryKey()."'");

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
		$x = new DocsFilesGroups();
		$x->fileID = $row['fileID'];
		$x->gid = $row['gid'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class DocsFilesGroups extends DocsFilesGroupsBase {



}



class DocsFilesGroupsPeer extends DocsFilesGroupsPeerBase {

}

?>