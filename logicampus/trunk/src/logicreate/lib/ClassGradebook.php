<?

class ClassGradebookBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idClassGradebook;
	var $idClasses;
	var $aUpper;
	var $aLower;
	var $bLower;
	var $cLower;
	var $dLower;
	var $calculationType;
	var $colorMissingGrade;
	var $roundScoresUp;
	var $totalPoints;

	var $__attributes = array( 
	'idClassGradebook'=>'integer',
	'idClasses'=>'integer',
	'aUpper'=>'float',
	'aLower'=>'float',
	'bLower'=>'float',
	'cLower'=>'float',
	'dLower'=>'float',
	'calculationType'=>'integer',
	'colorMissingGrade'=>'char',
	'roundScoresUp'=>'tinyint',
	'totalPoints'=>'integer');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->idClassGradebook;
	}


	function setPrimaryKey($val) {
		$this->idClassGradebook = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassGradebookPeer::doInsert($this,$dsn));
		} else {
			ClassGradebookPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_gradebook='".$key."'";
		}
		$array = ClassGradebookPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassGradebookPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassGradebookPeer::doDelete($this,$deep,$dsn);
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


class ClassGradebookPeerBase {

	var $tableName = 'class_gradebook';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_gradebook",$where);
		$st->fields['id_class_gradebook'] = 'id_class_gradebook';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['a_upper'] = 'a_upper';
		$st->fields['a_lower'] = 'a_lower';
		$st->fields['b_lower'] = 'b_lower';
		$st->fields['c_lower'] = 'c_lower';
		$st->fields['d_lower'] = 'd_lower';
		$st->fields['calculation_type'] = 'calculation_type';
		$st->fields['color_missing_grade'] = 'color_missing_grade';
		$st->fields['roundScoresUp'] = 'roundScoresUp';
		$st->fields['total_points'] = 'total_points';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassGradebookPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_gradebook");
		$st->fields['id_class_gradebook'] = $this->idClassGradebook;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['a_upper'] = $this->aUpper;
		$st->fields['a_lower'] = $this->aLower;
		$st->fields['b_lower'] = $this->bLower;
		$st->fields['c_lower'] = $this->cLower;
		$st->fields['d_lower'] = $this->dLower;
		$st->fields['calculation_type'] = $this->calculationType;
		$st->fields['color_missing_grade'] = $this->colorMissingGrade;
		$st->fields['roundScoresUp'] = $this->roundScoresUp;
		$st->fields['total_points'] = $this->totalPoints;


		$st->key = 'id_class_gradebook';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_gradebook");
		$st->fields['id_class_gradebook'] = $obj->idClassGradebook;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['a_upper'] = $obj->aUpper;
		$st->fields['a_lower'] = $obj->aLower;
		$st->fields['b_lower'] = $obj->bLower;
		$st->fields['c_lower'] = $obj->cLower;
		$st->fields['d_lower'] = $obj->dLower;
		$st->fields['calculation_type'] = $obj->calculationType;
		$st->fields['color_missing_grade'] = $obj->colorMissingGrade;
		$st->fields['roundScoresUp'] = $obj->roundScoresUp;
		$st->fields['total_points'] = $obj->totalPoints;


		$st->key = 'id_class_gradebook';
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
		$st = new PBDO_DeleteStatement("class_gradebook","id_class_gradebook = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassGradebook();
		$x->idClassGradebook = $row['id_class_gradebook'];
		$x->idClasses = $row['id_classes'];
		$x->aUpper = $row['a_upper'];
		$x->aLower = $row['a_lower'];
		$x->bLower = $row['b_lower'];
		$x->cLower = $row['c_lower'];
		$x->dLower = $row['d_lower'];
		$x->calculationType = $row['calculation_type'];
		$x->colorMissingGrade = $row['color_missing_grade'];
		$x->roundScoresUp = $row['roundScoresUp'];
		$x->totalPoints = $row['total_points'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassGradebook extends ClassGradebookBase {



}



class ClassGradebookPeer extends ClassGradebookPeerBase {

}

?>