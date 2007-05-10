<?

class OrientationDatesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $idOrientationDates;
	var $idSemesters;
	var $date;
	var $timeStart;
	var $timeEnd;

	var $__attributes = array(
	'idOrientationDates'=>'int',
	'idSemesters'=>'int',
	'date'=>'date',
	'timeStart'=>'time',
	'timeEnd'=>'time');



	function getPrimaryKey() {
		return $this->idOrientationDates;
	}

	function setPrimaryKey($val) {
		$this->idOrientationDates = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(OrientationDatesPeer::doInsert($this));
		} else {
			OrientationDatesPeer::doUpdate($this);
		}
	}

	function load($key) {
		$this->_new = false;
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_orientation_dates='".$key."'";
		}
		$array = OrientationDatesPeer::doSelect($where);
		return $array[0];
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
		if ($array['idSemesters'])
			$this->idSemesters = $array['idSemesters'];
		if ($array['date'])
			$this->date = $array['date'];
		if ($array['timeStart'])
			$this->timeStart = $array['timeStart'];
		if ($array['timeEnd'])
			$this->timeEnd = $array['timeEnd'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class OrientationDatesPeer {

	var $tableName = 'orientation_dates';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("orientation_dates",$where);
		$st->fields['id_orientation_dates'] = 'id_orientation_dates';
		$st->fields['id_semesters'] = 'id_semesters';
		$st->fields['date'] = 'date';
		$st->fields['time_start'] = 'time_start';
		$st->fields['time_end'] = 'time_end';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = OrientationDatesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("orientation_dates");
		$st->fields['id_orientation_dates'] = $this->idOrientationDates;
		$st->fields['id_semesters'] = $this->idSemesters;
		$st->fields['date'] = $this->date;
		$st->fields['time_start'] = $this->timeStart;
		$st->fields['time_end'] = $this->timeEnd;

		$st->key = 'id_orientation_dates';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("orientation_dates");
		$st->fields['id_orientation_dates'] = $obj->idOrientationDates;
		$st->fields['id_semesters'] = $obj->idSemesters;
		$st->fields['date'] = $obj->date;
		$st->fields['time_start'] = $obj->timeStart;
		$st->fields['time_end'] = $obj->timeEnd;

		$st->key = 'id_orientation_dates';
		$db->executeQuery($st);
		$obj->_modified = false;

	}

	function doReplace($obj) {
		//use this tableName
		if ($this->isNew() ) {
			$db->executeQuery(new LC_InsertStatement($criteria));
		} else {
			$db->executeQuery(new LC_UpdateStatement($criteria));
		}
	}



	function doDelete(&$obj,$shallow=false) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_DeleteStatement("orientation_dates","id_orientation_dates = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new OrientationDates();
		$x->idOrientationDates = $row['id_orientation_dates'];
		$x->idSemesters = $row['id_semesters'];
		$x->date = $row['date'];
		$x->timeStart = $row['time_start'];
		$x->timeEnd = $row['time_end'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class OrientationDates extends OrientationDatesBase {



}

?>