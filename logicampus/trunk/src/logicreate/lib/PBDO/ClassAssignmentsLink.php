<?

class ClassAssignmentsLinkBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.4';	//PBDO version number
	var $_entityVersion = '0.0';	//Source version number
	var $idClassLessons;
	var $idClassAssignments;

	var $__attributes = array(
	'idClassLessons'=>'int',
	'idClassAssignments'=>'int');



	function getPrimaryKey() {
		return $this->;
	}

	function setPrimaryKey($val) {
		$this-> = $val;
	}
	
	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassAssignmentsLinkPeer::doInsert($this,$dsn));
		} else {
			ClassAssignmentsLinkPeer::doUpdate($this,$dsn);
		}
	}

	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "='".$key."'";
		}
		$array = ClassAssignmentsLinkPeer::doSelect($where,$dsn);
		return $array[0];
	}

	function delete($deep=false,$dsn="default") {
		ClassAssignmentsLinkPeer::doDelete($this,$deep,$dsn);
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

	/**
	 * set all properties of an object that aren't
	 * keys.  Relation attributes must be set manually
	 * by the programmer to ensure security
	 */
	function setArray($array) {
		if ($array['idClassLessons'])
			$this->idClassLessons = $array['idClassLessons'];
		if ($array['idClassAssignments'])
			$this->idClassAssignments = $array['idClassAssignments'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class ClassAssignmentsLinkPeerBase {

	var $tableName = 'class_assignments_link';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_SelectStatement("class_assignments_link",$where);
		$st->fields['id_class_lessons'] = 'id_class_lessons';
		$st->fields['id_class_assignments'] = 'id_class_assignments';

		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassAssignmentsLinkPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_InsertStatement("class_assignments_link");
		$st->fields['id_class_lessons'] = $this->idClassLessons;
		$st->fields['id_class_assignments'] = $this->idClassAssignments;

		$st->key = '';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_UpdateStatement("class_assignments_link");
		$st->fields['id_class_lessons'] = $obj->idClassLessons;
		$st->fields['id_class_assignments'] = $obj->idClassAssignments;

		$st->key = '';
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



	function doDelete(&$obj,$deep=false,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_DeleteStatement("class_assignments_link"," = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( $deep ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new ClassAssignmentsLink();
		$x->idClassLessons = $row['id_class_lessons'];
		$x->idClassAssignments = $row['id_class_assignments'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassAssignmentsLink extends ClassAssignmentsLinkBase {



}



class ClassAssignmentsLinkPeer extends ClassAssignmentsLinkPeerBase {

}

?>