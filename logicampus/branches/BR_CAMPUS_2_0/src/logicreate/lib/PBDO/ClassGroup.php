<?

class ClassGroupBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.4';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $classGroupId;
	var $classGroupName;
	var $classId;

	var $__attributes = array(
	'classGroupId'=>'int',
	'classGroupName'=>'varchar',
	'classId'=>'int');

	function getClassGroup($dsn='default') {
		if ( $this->classGroupId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = ClassGroupPeer::doSelect('class_group_id = \''.$this->classGroupId.'\'',$dsn);
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->classGroupId;
	}

	function setPrimaryKey($val) {
		$this->classGroupId = $val;
	}
	
	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassGroupPeer::doInsert($this,$dsn));
		} else {
			ClassGroupPeer::doUpdate($this,$dsn);
		}
	}

	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "class_group_id='".$key."'";
		}
		$array = ClassGroupPeer::doSelect($where,$dsn);
		return $array[0];
	}

	function delete($deep=false,$dsn="default") {
		ClassGroupPeer::doDelete($this,$deep,$dsn);
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

	function set($key,$val) {
		$this->_modified = true;
		$this->{$key} = $val;

	}

}


class ClassGroupPeerBase {

	var $tableName = 'class_group';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_SelectStatement("class_group",$where);
		$st->fields['class_group_id'] = 'class_group_id';
		$st->fields['class_group_name'] = 'class_group_name';
		$st->fields['class_id'] = 'class_id';

		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassGroupPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_InsertStatement("class_group");
		$st->fields['class_group_id'] = $this->classGroupId;
		$st->fields['class_group_name'] = $this->classGroupName;
		$st->fields['class_id'] = $this->classId;

		$st->key = 'class_group_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_UpdateStatement("class_group");
		$st->fields['class_group_id'] = $obj->classGroupId;
		$st->fields['class_group_name'] = $obj->classGroupName;
		$st->fields['class_id'] = $obj->classId;

		$st->key = 'class_group_id';
		$db->executeQuery($st);
		$obj->_modified = false;

	}

	function doReplace($obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		if ($this->isNew() ) {
			$db->executeQuery(new LC_InsertStatement($criteria));
		} else {
			$db->executeQuery(new LC_UpdateStatement($criteria));
		}
	}


	/**
	 * remove an object
	 */
	function doDelete(&$obj,$deep=false,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_DeleteStatement("class_group","class_group_id = '".$obj->getPrimaryKey()."'");

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
		$db = lcDB::getHandle($dsn);

		$db->query($sql);

	  	return;
	}



	function row2Obj($row) {
		$x = new ClassGroup();
		$x->classGroupId = $row['class_group_id'];
		$x->classGroupName = $row['class_group_name'];
		$x->classId = $row['class_id'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassGroup extends ClassGroupBase {



}



class ClassGroupPeer extends ClassGroupPeerBase {

}

?>