<?

class ClassGroupMemberBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.4';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $classGroupMemberId;
	var $classGroupId;
	var $studentId;

	var $__attributes = array(
	'classGroupMemberId'=>'int',
	'classGroupId'=>'int',
	'studentId'=>'varchar');

	function getClassGroups($dsn='default') {
		$array = ClassGroupPeer::doSelect('class_group_id = \''.$this->getPrimaryKey().'\'',$dsn);
		return $array;
	}



	function getPrimaryKey() {
		return $this->classGroupMemberId;
	}

	function setPrimaryKey($val) {
		$this->classGroupMemberId = $val;
	}
	
	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassGroupMemberPeer::doInsert($this,$dsn));
		} else {
			ClassGroupMemberPeer::doUpdate($this,$dsn);
		}
	}

	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "class_group_member_id='".$key."'";
		}
		$array = ClassGroupMemberPeer::doSelect($where,$dsn);
		return $array[0];
	}

	function delete($deep=false,$dsn="default") {
		ClassGroupMemberPeer::doDelete($this,$deep,$dsn);
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


class ClassGroupMemberPeerBase {

	var $tableName = 'class_group_member';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_SelectStatement("class_group_member",$where);
		$st->fields['class_group_member_id'] = 'class_group_member_id';
		$st->fields['class_group_id'] = 'class_group_id';
		$st->fields['student_id'] = 'student_id';

		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassGroupMemberPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_InsertStatement("class_group_member");
		$st->fields['class_group_member_id'] = $this->classGroupMemberId;
		$st->fields['class_group_id'] = $this->classGroupId;
		$st->fields['student_id'] = $this->studentId;

		$st->key = 'class_group_member_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_UpdateStatement("class_group_member");
		$st->fields['class_group_member_id'] = $obj->classGroupMemberId;
		$st->fields['class_group_id'] = $obj->classGroupId;
		$st->fields['student_id'] = $obj->studentId;

		$st->key = 'class_group_member_id';
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
		$st = new LC_DeleteStatement("class_group_member","class_group_member_id = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassGroupMember();
		$x->classGroupMemberId = $row['class_group_member_id'];
		$x->classGroupId = $row['class_group_id'];
		$x->studentId = $row['student_id'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassGroupMember extends ClassGroupMemberBase {



}



class ClassGroupMemberPeer extends ClassGroupMemberPeerBase {

}

?>