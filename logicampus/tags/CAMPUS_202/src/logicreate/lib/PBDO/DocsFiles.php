<?

class DocsFilesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $fileID;
	var $username;
	var $name;
	var $TYPE;
	var $mime;
	var $title;
	var $abstract;
	var $posted;
	var $hits;

	var $__attributes = array( 
	'fileID'=>'integer',
	'username'=>'varchar',
	'name'=>'varchar',
	'TYPE'=>'varchar',
	'mime'=>'varchar',
	'title'=>'varchar',
	'abstract'=>'varchar',
	'posted'=>'integer',
	'hits'=>'integer');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->fileID;
	}


	function setPrimaryKey($val) {
		$this->fileID = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(DocsFilesPeer::doInsert($this,$dsn));
		} else {
			DocsFilesPeer::doUpdate($this,$dsn);
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
		$array = DocsFilesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = DocsFilesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		DocsFilesPeer::doDelete($this,$deep,$dsn);
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


class DocsFilesPeerBase {

	var $tableName = 'docs_files';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("docs_files",$where);
		$st->fields['fileID'] = 'fileID';
		$st->fields['username'] = 'username';
		$st->fields['name'] = 'name';
		$st->fields['TYPE'] = 'TYPE';
		$st->fields['mime'] = 'mime';
		$st->fields['title'] = 'title';
		$st->fields['abstract'] = 'abstract';
		$st->fields['posted'] = 'posted';
		$st->fields['hits'] = 'hits';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = DocsFilesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("docs_files");
		$st->fields['fileID'] = $this->fileID;
		$st->fields['username'] = $this->username;
		$st->fields['name'] = $this->name;
		$st->fields['TYPE'] = $this->TYPE;
		$st->fields['mime'] = $this->mime;
		$st->fields['title'] = $this->title;
		$st->fields['abstract'] = $this->abstract;
		$st->fields['posted'] = $this->posted;
		$st->fields['hits'] = $this->hits;


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
		$st = new PBDO_UpdateStatement("docs_files");
		$st->fields['fileID'] = $obj->fileID;
		$st->fields['username'] = $obj->username;
		$st->fields['name'] = $obj->name;
		$st->fields['TYPE'] = $obj->TYPE;
		$st->fields['mime'] = $obj->mime;
		$st->fields['title'] = $obj->title;
		$st->fields['abstract'] = $obj->abstract;
		$st->fields['posted'] = $obj->posted;
		$st->fields['hits'] = $obj->hits;


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
		$st = new PBDO_DeleteStatement("docs_files","fileID = '".$obj->getPrimaryKey()."'");

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
		$x = new DocsFiles();
		$x->fileID = $row['fileID'];
		$x->username = $row['username'];
		$x->name = $row['name'];
		$x->TYPE = $row['TYPE'];
		$x->mime = $row['mime'];
		$x->title = $row['title'];
		$x->abstract = $row['abstract'];
		$x->posted = $row['posted'];
		$x->hits = $row['hits'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class DocsFiles extends DocsFilesBase {



}



class DocsFilesPeer extends DocsFilesPeerBase {

}

?>