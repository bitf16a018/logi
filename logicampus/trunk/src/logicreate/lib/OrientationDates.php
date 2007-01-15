<?

class OrientationDatesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idOrientationDates;
	var $idSemesters;
	var $date;
	var $timeStart;
	var $timeEnd;

	var $__attributes = array( 
	'idOrientationDates'=>'integer',
	'idSemesters'=>'integer',
	'date'=>'date',
	'timeStart'=>'time',
	'timeEnd'=>'time');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->idOrientationDates;
	}


	function setPrimaryKey($val) {
		$this->idOrientationDates = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(OrientationDatesPeer::doInsert($this,$dsn));
		} else {
			OrientationDatesPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_orientation_dates='".$key."'";
		}
		$array = OrientationDatesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = OrientationDatesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		OrientationDatesPeer::doDelete($this,$deep,$dsn);
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


class OrientationDatesPeerBase {

	var $tableName = 'orientation_dates';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("orientation_dates",$where);
		$st->fields['id_orientation_dates'] = 'id_orientation_dates';
		$st->fields['id_semesters'] = 'id_semesters';
		$st->fields['date'] = 'date';
		$st->fields['time_start'] = 'time_start';
		$st->fields['time_end'] = 'time_end';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = OrientationDatesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("orientation_dates");
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

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("orientation_dates");
		$st->fields['id_orientation_dates'] = $obj->idOrientationDates;
		$st->fields['id_semesters'] = $obj->idSemesters;
		$st->fields['date'] = $obj->date;
		$st->fields['time_start'] = $obj->timeStart;
		$st->fields['time_end'] = $obj->timeEnd;


		$st->key = 'id_orientation_dates';
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
		$st = new PBDO_DeleteStatement("orientation_dates","id_orientation_dates = '".$obj->getPrimaryKey()."'");

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



class OrientationDatesPeer extends OrientationDatesPeerBase {

}

?>