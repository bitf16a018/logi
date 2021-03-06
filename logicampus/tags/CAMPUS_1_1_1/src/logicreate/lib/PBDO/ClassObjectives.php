<?

class ClassObjectivesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.4';	//PBDO version number
	var $_entityVersion = '0.0';	//Source version number
	var $idClassObjectives;
	var $idClasses;
	var $objective;
	var $fHide;
	var $iSort;

	var $__attributes = array(
	'idClassObjectives'=>'int',
	'idClasses'=>'int',
	'objective'=>'text',
	'fHide'=>'int',
	'iSort'=>'int');



	function getPrimaryKey() {
		return $this->idClassObjectives;
	}

	function setPrimaryKey($val) {
		$this->idClassObjectives = $val;
	}
	
	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassObjectivesPeer::doInsert($this,$dsn));
		} else {
			ClassObjectivesPeer::doUpdate($this,$dsn);
		}
	}

	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_objectives='".$key."'";
		}
		$array = ClassObjectivesPeer::doSelect($where,$dsn);
		return $array[0];
	}

	function delete($deep=false,$dsn="default") {
		ClassObjectivesPeer::doDelete($this,$deep,$dsn);
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
		if ($array['idClasses'])
			$this->idClasses = $array['idClasses'];
		if ($array['objective'])
			$this->objective = $array['objective'];
		if ($array['fHide'])
			$this->fHide = $array['fHide'];
		if ($array['iSort'])
			$this->iSort = $array['iSort'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class ClassObjectivesPeerBase {

	var $tableName = 'class_objectives';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_SelectStatement("class_objectives",$where);
		$st->fields['id_class_objectives'] = 'id_class_objectives';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['objective'] = 'objective';
		$st->fields['f_hide'] = 'f_hide';
		$st->fields['i_sort'] = 'i_sort';

		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassObjectivesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_InsertStatement("class_objectives");
		$st->fields['id_class_objectives'] = $this->idClassObjectives;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['objective'] = $this->objective;
		$st->fields['f_hide'] = $this->fHide;
		$st->fields['i_sort'] = $this->iSort;

		$st->key = 'id_class_objectives';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_UpdateStatement("class_objectives");
		$st->fields['id_class_objectives'] = $obj->idClassObjectives;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['objective'] = $obj->objective;
		$st->fields['f_hide'] = $obj->fHide;
		$st->fields['i_sort'] = $obj->iSort;

		$st->key = 'id_class_objectives';
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
		$st = new LC_DeleteStatement("class_objectives","id_class_objectives = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( $deep ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new ClassObjectives();
		$x->idClassObjectives = $row['id_class_objectives'];
		$x->idClasses = $row['id_classes'];
		$x->objective = $row['objective'];
		$x->fHide = $row['f_hide'];
		$x->iSort = $row['i_sort'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassObjectives extends ClassObjectivesBase {



}



class ClassObjectivesPeer extends ClassObjectivesPeerBase {

}

?>