<?

class ClassForumCategoryBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $classForumCategoryId;
	var $name;
	var $classId;

	var $__attributes = array( 
	'classForumCategoryId'=>'integer',
	'name'=>'varchar',
	'classId'=>'integer');

	var $__nulls = array();

	/**
	 * Retrieves an array of class_forum objects via the foreign key class_forum_category_id.
	 * 
	 * @param String $dsn the name of the data source to use for the sql query.
	 * @return Array related objects.
	 */
	function getClassForumsByClassForumCategoryId($dsn='default') {
		if ( $this->classForumCategoryId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = ClassForumPeer::doSelect('class_forum_category_id = \''.$this->classForumCategoryId.'\'',$dsn);
		return $array;
	}



	function getPrimaryKey() {
		return $this->classForumCategoryId;
	}


	function setPrimaryKey($val) {
		$this->classForumCategoryId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassForumCategoryPeer::doInsert($this,$dsn));
		} else {
			ClassForumCategoryPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "class_forum_category_id='".$key."'";
		}
		$array = ClassForumCategoryPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassForumCategoryPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassForumCategoryPeer::doDelete($this,$deep,$dsn);
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


class ClassForumCategoryPeerBase {

	var $tableName = 'class_forum_category';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_forum_category",$where);
		$st->fields['class_forum_category_id'] = 'class_forum_category_id';
		$st->fields['name'] = 'name';
		$st->fields['class_id'] = 'class_id';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassForumCategoryPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_forum_category");
		$st->fields['class_forum_category_id'] = $this->classForumCategoryId;
		$st->fields['name'] = $this->name;
		$st->fields['class_id'] = $this->classId;


		$st->key = 'class_forum_category_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_forum_category");
		$st->fields['class_forum_category_id'] = $obj->classForumCategoryId;
		$st->fields['name'] = $obj->name;
		$st->fields['class_id'] = $obj->classId;


		$st->key = 'class_forum_category_id';
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
		$st = new PBDO_DeleteStatement("class_forum_category","class_forum_category_id = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassForumCategory();
		$x->classForumCategoryId = $row['class_forum_category_id'];
		$x->name = $row['name'];
		$x->classId = $row['class_id'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassForumCategory extends ClassForumCategoryBase {



}



class ClassForumCategoryPeer extends ClassForumCategoryPeerBase {

}

?>