<?

class OrientationClassesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $idOrientationClasses;
	var $idClasses;
	var $status;
	var $firstDateId;
	var $firstCampusLocation;
	var $firstAllottedMinutes;
	var $firstPreferredTime;
	var $firstTimeRangeStart;
	var $firstTimeRangeEnd;
	var $secondDateId;
	var $secondCampusLocation;
	var $secondAllottedMinutes;
	var $secondPreferredTime;
	var $secondTimeRangeStart;
	var $secondTimeRangeEnd;
	var $instructions;
	var $notes;
	var $finalDateTime;
	var $finalSessionLength;
	var $finalCampus;

	var $__attributes = array(
	'idOrientationClasses'=>'int',
	'idClasses'=>'int',
	'status'=>'int',
	'firstDateId'=>'int',
	'firstCampusLocation'=>'varchar',
	'firstAllottedMinutes'=>'int',
	'firstPreferredTime'=>'time',
	'firstTimeRangeStart'=>'time',
	'firstTimeRangeEnd'=>'time',
	'secondDateId'=>'int',
	'secondCampusLocation'=>'varchar',
	'secondAllottedMinutes'=>'int',
	'secondPreferredTime'=>'time',
	'secondTimeRangeStart'=>'time',
	'secondTimeRangeEnd'=>'time',
	'instructions'=>'text',
	'notes'=>'text',
	'finalDateTime'=>'datetime',
	'finalSessionLength'=>'int',
	'finalCampus'=>'char');



	function getPrimaryKey() {
		return $this->idOrientationClasses;
	}

	function setPrimaryKey($val) {
		$this->idOrientationClasses = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(OrientationClassesPeer::doInsert($this));
		} else {
			OrientationClassesPeer::doUpdate($this);
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
			$where = "id_orientation_classes='".$key."'";
		}
		$array = OrientationClassesPeer::doSelect($where);
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
		if ($array['idClasses'])
			$this->idClasses = $array['idClasses'];
		if ($array['status'])
			$this->status = $array['status'];
		if ($array['firstDateId'])
			$this->firstDateId = $array['firstDateId'];
		if ($array['firstCampusLocation'])
			$this->firstCampusLocation = $array['firstCampusLocation'];
		if ($array['firstAllottedMinutes'])
			$this->firstAllottedMinutes = $array['firstAllottedMinutes'];
		if ($array['firstPreferredTime'])
			$this->firstPreferredTime = $array['firstPreferredTime'];
		if ($array['firstTimeRangeStart'])
			$this->firstTimeRangeStart = $array['firstTimeRangeStart'];
		if ($array['firstTimeRangeEnd'])
			$this->firstTimeRangeEnd = $array['firstTimeRangeEnd'];
		if ($array['secondDateId'])
			$this->secondDateId = $array['secondDateId'];
		if ($array['secondCampusLocation'])
			$this->secondCampusLocation = $array['secondCampusLocation'];
		if ($array['secondAllottedMinutes'])
			$this->secondAllottedMinutes = $array['secondAllottedMinutes'];
		if ($array['secondPreferredTime'])
			$this->secondPreferredTime = $array['secondPreferredTime'];
		if ($array['secondTimeRangeStart'])
			$this->secondTimeRangeStart = $array['secondTimeRangeStart'];
		if ($array['secondTimeRangeEnd'])
			$this->secondTimeRangeEnd = $array['secondTimeRangeEnd'];
		if ($array['instructions'])
			$this->instructions = $array['instructions'];
		if ($array['notes'])
			$this->notes = $array['notes'];
		if ($array['finalDateTime'])
			$this->finalDateTime = $array['finalDateTime'];
		if ($array['finalSessionLength'])
			$this->finalSessionLength = $array['finalSessionLength'];
		if ($array['finalCampus'])
			$this->finalCampus = $array['finalCampus'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class OrientationClassesPeer {

	var $tableName = 'orientation_classes';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("orientation_classes",$where);
		$st->fields['id_orientation_classes'] = 'id_orientation_classes';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['status'] = 'status';
		$st->fields['first_date_id'] = 'first_date_id';
		$st->fields['first_campus_location'] = 'first_campus_location';
		$st->fields['first_allotted_minutes'] = 'first_allotted_minutes';
		$st->fields['first_preferred_time'] = 'first_preferred_time';
		$st->fields['first_time_range_start'] = 'first_time_range_start';
		$st->fields['first_time_range_end'] = 'first_time_range_end';
		$st->fields['second_date_id'] = 'second_date_id';
		$st->fields['second_campus_location'] = 'second_campus_location';
		$st->fields['second_allotted_minutes'] = 'second_allotted_minutes';
		$st->fields['second_preferred_time'] = 'second_preferred_time';
		$st->fields['second_time_range_start'] = 'second_time_range_start';
		$st->fields['second_time_range_end'] = 'second_time_range_end';
		$st->fields['instructions'] = 'instructions';
		$st->fields['notes'] = 'notes';
		$st->fields['finalDateTime'] = 'finalDateTime';
		$st->fields['finalSessionLength'] = 'finalSessionLength';
		$st->fields['finalCampus'] = 'finalCampus';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = OrientationClassesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("orientation_classes");
		$st->fields['id_orientation_classes'] = $this->idOrientationClasses;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['status'] = $this->status;
		$st->fields['first_date_id'] = $this->firstDateId;
		$st->fields['first_campus_location'] = $this->firstCampusLocation;
		$st->fields['first_allotted_minutes'] = $this->firstAllottedMinutes;
		$st->fields['first_preferred_time'] = $this->firstPreferredTime;
		$st->fields['first_time_range_start'] = $this->firstTimeRangeStart;
		$st->fields['first_time_range_end'] = $this->firstTimeRangeEnd;
		$st->fields['second_date_id'] = $this->secondDateId;
		$st->fields['second_campus_location'] = $this->secondCampusLocation;
		$st->fields['second_allotted_minutes'] = $this->secondAllottedMinutes;
		$st->fields['second_preferred_time'] = $this->secondPreferredTime;
		$st->fields['second_time_range_start'] = $this->secondTimeRangeStart;
		$st->fields['second_time_range_end'] = $this->secondTimeRangeEnd;
		$st->fields['instructions'] = $this->instructions;
		$st->fields['notes'] = $this->notes;
		$st->fields['finalDateTime'] = $this->finalDateTime;
		$st->fields['finalSessionLength'] = $this->finalSessionLength;
		$st->fields['finalCampus'] = $this->finalCampus;

		$st->key = 'id_orientation_classes';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("orientation_classes");
		$st->fields['id_orientation_classes'] = $obj->idOrientationClasses;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['status'] = $obj->status;
		$st->fields['first_date_id'] = $obj->firstDateId;
		$st->fields['first_campus_location'] = $obj->firstCampusLocation;
		$st->fields['first_allotted_minutes'] = $obj->firstAllottedMinutes;
		$st->fields['first_preferred_time'] = $obj->firstPreferredTime;
		$st->fields['first_time_range_start'] = $obj->firstTimeRangeStart;
		$st->fields['first_time_range_end'] = $obj->firstTimeRangeEnd;
		$st->fields['second_date_id'] = $obj->secondDateId;
		$st->fields['second_campus_location'] = $obj->secondCampusLocation;
		$st->fields['second_allotted_minutes'] = $obj->secondAllottedMinutes;
		$st->fields['second_preferred_time'] = $obj->secondPreferredTime;
		$st->fields['second_time_range_start'] = $obj->secondTimeRangeStart;
		$st->fields['second_time_range_end'] = $obj->secondTimeRangeEnd;
		$st->fields['instructions'] = $obj->instructions;
		$st->fields['notes'] = $obj->notes;
		$st->fields['finalDateTime'] = $obj->finalDateTime;
		$st->fields['finalSessionLength'] = $obj->finalSessionLength;
		$st->fields['finalCampus'] = $obj->finalCampus;

		$st->key = 'id_orientation_classes';
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
		$st = new LC_DeleteStatement("orientation_classes","id_orientation_classes = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new OrientationClasses();
		$x->idOrientationClasses = $row['id_orientation_classes'];
		$x->idClasses = $row['id_classes'];
		$x->status = $row['status'];
		$x->firstDateId = $row['first_date_id'];
		$x->firstCampusLocation = $row['first_campus_location'];
		$x->firstAllottedMinutes = $row['first_allotted_minutes'];
		$x->firstPreferredTime = $row['first_preferred_time'];
		$x->firstTimeRangeStart = $row['first_time_range_start'];
		$x->firstTimeRangeEnd = $row['first_time_range_end'];
		$x->secondDateId = $row['second_date_id'];
		$x->secondCampusLocation = $row['second_campus_location'];
		$x->secondAllottedMinutes = $row['second_allotted_minutes'];
		$x->secondPreferredTime = $row['second_preferred_time'];
		$x->secondTimeRangeStart = $row['second_time_range_start'];
		$x->secondTimeRangeEnd = $row['second_time_range_end'];
		$x->instructions = $row['instructions'];
		$x->notes = $row['notes'];
		$x->finalDateTime = $row['finalDateTime'];
		$x->finalSessionLength = $row['finalSessionLength'];
		$x->finalCampus = $row['finalCampus'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class OrientationClasses extends OrientationClassesBase {



}

?>