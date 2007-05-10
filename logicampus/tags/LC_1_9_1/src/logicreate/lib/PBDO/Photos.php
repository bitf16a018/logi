<?

class PhotosBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $pkey;
	var $filename;
	var $thumbname;
	var $width;
	var $height;
	var $tWidth;
	var $tHeight;
	var $catID;
	var $caption;
	var $count;

	var $__attributes = array( 
	'pkey'=>'integer',
	'filename'=>'varchar',
	'thumbname'=>'varchar',
	'width'=>'smallint',
	'height'=>'smallint',
	'tWidth'=>'smallint',
	'tHeight'=>'smallint',
	'catID'=>'integer',
	'caption'=>'varchar',
	'count'=>'integer');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->pkey;
	}


	function setPrimaryKey($val) {
		$this->pkey = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(PhotosPeer::doInsert($this,$dsn));
		} else {
			PhotosPeer::doUpdate($this,$dsn);
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
		$array = PhotosPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = PhotosPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		PhotosPeer::doDelete($this,$deep,$dsn);
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


class PhotosPeerBase {

	var $tableName = 'photos';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("photos",$where);
		$st->fields['pkey'] = 'pkey';
		$st->fields['filename'] = 'filename';
		$st->fields['thumbname'] = 'thumbname';
		$st->fields['width'] = 'width';
		$st->fields['height'] = 'height';
		$st->fields['t_width'] = 't_width';
		$st->fields['t_height'] = 't_height';
		$st->fields['catID'] = 'catID';
		$st->fields['caption'] = 'caption';
		$st->fields['count'] = 'count';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = PhotosPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("photos");
		$st->fields['pkey'] = $this->pkey;
		$st->fields['filename'] = $this->filename;
		$st->fields['thumbname'] = $this->thumbname;
		$st->fields['width'] = $this->width;
		$st->fields['height'] = $this->height;
		$st->fields['t_width'] = $this->tWidth;
		$st->fields['t_height'] = $this->tHeight;
		$st->fields['catID'] = $this->catID;
		$st->fields['caption'] = $this->caption;
		$st->fields['count'] = $this->count;


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
		$st = new PBDO_UpdateStatement("photos");
		$st->fields['pkey'] = $obj->pkey;
		$st->fields['filename'] = $obj->filename;
		$st->fields['thumbname'] = $obj->thumbname;
		$st->fields['width'] = $obj->width;
		$st->fields['height'] = $obj->height;
		$st->fields['t_width'] = $obj->tWidth;
		$st->fields['t_height'] = $obj->tHeight;
		$st->fields['catID'] = $obj->catID;
		$st->fields['caption'] = $obj->caption;
		$st->fields['count'] = $obj->count;


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
		$st = new PBDO_DeleteStatement("photos","pkey = '".$obj->getPrimaryKey()."'");

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
		$x = new Photos();
		$x->pkey = $row['pkey'];
		$x->filename = $row['filename'];
		$x->thumbname = $row['thumbname'];
		$x->width = $row['width'];
		$x->height = $row['height'];
		$x->tWidth = $row['t_width'];
		$x->tHeight = $row['t_height'];
		$x->catID = $row['catID'];
		$x->caption = $row['caption'];
		$x->count = $row['count'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class Photos extends PhotosBase {



}



class PhotosPeer extends PhotosPeerBase {

}

?>