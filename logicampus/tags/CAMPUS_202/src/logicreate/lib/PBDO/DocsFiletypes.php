<?

class DocsFiletypesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $TYPE;
	var $icon;

	var $__attributes = array( 
	'TYPE'=>'char',
	'icon'=>'char');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->TYPE;
	}


	function setPrimaryKey($val) {
		$this->TYPE = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(DocsFiletypesPeer::doInsert($this,$dsn));
		} else {
			DocsFiletypesPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "TYPE='".$key."'";
		}
		$array = DocsFiletypesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = DocsFiletypesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		DocsFiletypesPeer::doDelete($this,$deep,$dsn);
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


class DocsFiletypesPeerBase {

	var $tableName = 'docs_filetypes';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("docs_filetypes",$where);
		$st->fields['TYPE'] = 'TYPE';
		$st->fields['icon'] = 'icon';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = DocsFiletypesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("docs_filetypes");
		$st->fields['TYPE'] = $this->TYPE;
		$st->fields['icon'] = $this->icon;


		$st->key = 'TYPE';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("docs_filetypes");
		$st->fields['TYPE'] = $obj->TYPE;
		$st->fields['icon'] = $obj->icon;


		$st->key = 'TYPE';
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
		$st = new PBDO_DeleteStatement("docs_filetypes","TYPE = '".$obj->getPrimaryKey()."'");

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
		$x = new DocsFiletypes();
		$x->TYPE = $row['TYPE'];
		$x->icon = $row['icon'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class DocsFiletypes extends DocsFiletypesBase {



}



class DocsFiletypesPeer extends DocsFiletypesPeerBase {

}

?>