<?

class DocsDirectoriesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $directoryID;
	var $parentID;
	var $username;
	var $name;
	var $posted;

	var $__attributes = array( 
	'directoryID'=>'integer',
	'parentID'=>'integer',
	'username'=>'varchar',
	'name'=>'varchar',
	'posted'=>'integer');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->directoryID;
	}


	function setPrimaryKey($val) {
		$this->directoryID = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(DocsDirectoriesPeer::doInsert($this,$dsn));
		} else {
			DocsDirectoriesPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "directoryID='".$key."'";
		}
		$array = DocsDirectoriesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = DocsDirectoriesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		DocsDirectoriesPeer::doDelete($this,$deep,$dsn);
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


class DocsDirectoriesPeerBase {

	var $tableName = 'docs_directories';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("docs_directories",$where);
		$st->fields['directoryID'] = 'directoryID';
		$st->fields['parentID'] = 'parentID';
		$st->fields['username'] = 'username';
		$st->fields['name'] = 'name';
		$st->fields['posted'] = 'posted';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = DocsDirectoriesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("docs_directories");
		$st->fields['directoryID'] = $this->directoryID;
		$st->fields['parentID'] = $this->parentID;
		$st->fields['username'] = $this->username;
		$st->fields['name'] = $this->name;
		$st->fields['posted'] = $this->posted;


		$st->key = 'directoryID';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("docs_directories");
		$st->fields['directoryID'] = $obj->directoryID;
		$st->fields['parentID'] = $obj->parentID;
		$st->fields['username'] = $obj->username;
		$st->fields['name'] = $obj->name;
		$st->fields['posted'] = $obj->posted;


		$st->key = 'directoryID';
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
		$st = new PBDO_DeleteStatement("docs_directories","directoryID = '".$obj->getPrimaryKey()."'");

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
		$x = new DocsDirectories();
		$x->directoryID = $row['directoryID'];
		$x->parentID = $row['parentID'];
		$x->username = $row['username'];
		$x->name = $row['name'];
		$x->posted = $row['posted'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class DocsDirectories extends DocsDirectoriesBase {



}



class DocsDirectoriesPeer extends DocsDirectoriesPeerBase {

}

?>