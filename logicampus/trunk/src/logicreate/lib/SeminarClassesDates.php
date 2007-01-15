<?

class SeminarClassesDatesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idSeminarClassesDates;
	var $idClasses;
	var $numSeminar;
	var $southDate;
	var $southTimeStart;
	var $southTimeEnd;
	var $northeastDate;
	var $northeastTimeStart;
	var $northeastTimeEnd;
	var $northwestDate;
	var $northwestTimeStart;
	var $northwestTimeEnd;
	var $southeastDate;
	var $southeastTimeStart;
	var $southeastTimeEnd;
	var $entryStatus;
	var $note;

	var $__attributes = array( 
	'idSeminarClassesDates'=>'integer',
	'idClasses'=>'integer',
	'numSeminar'=>'integer',
	'southDate'=>'datetime',
	'southTimeStart'=>'time',
	'southTimeEnd'=>'time',
	'northeastDate'=>'datetime',
	'northeastTimeStart'=>'time',
	'northeastTimeEnd'=>'time',
	'northwestDate'=>'datetime',
	'northwestTimeStart'=>'time',
	'northwestTimeEnd'=>'time',
	'southeastDate'=>'datetime',
	'southeastTimeStart'=>'time',
	'southeastTimeEnd'=>'time',
	'entryStatus'=>'integer',
	'note'=>'longvarchar');

	var $__nulls = array( 
	'southDate'=>'southDate',
	'southTimeStart'=>'southTimeStart',
	'southTimeEnd'=>'southTimeEnd',
	'northeastDate'=>'northeastDate',
	'northeastTimeStart'=>'northeastTimeStart',
	'northeastTimeEnd'=>'northeastTimeEnd',
	'northwestDate'=>'northwestDate',
	'northwestTimeStart'=>'northwestTimeStart',
	'northwestTimeEnd'=>'northwestTimeEnd',
	'southeastDate'=>'southeastDate',
	'southeastTimeStart'=>'southeastTimeStart',
	'southeastTimeEnd'=>'southeastTimeEnd',
	'note'=>'note');



	function getPrimaryKey() {
		return $this->idSeminarClassesDates;
	}


	function setPrimaryKey($val) {
		$this->idSeminarClassesDates = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(SeminarClassesDatesPeer::doInsert($this,$dsn));
		} else {
			SeminarClassesDatesPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_seminar_classes_dates='".$key."'";
		}
		$array = SeminarClassesDatesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = SeminarClassesDatesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		SeminarClassesDatesPeer::doDelete($this,$deep,$dsn);
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


class SeminarClassesDatesPeerBase {

	var $tableName = 'seminar_classes_dates';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("seminar_classes_dates",$where);
		$st->fields['id_seminar_classes_dates'] = 'id_seminar_classes_dates';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['num_seminar'] = 'num_seminar';
		$st->fields['south_date'] = 'south_date';
		$st->fields['south_time_start'] = 'south_time_start';
		$st->fields['south_time_end'] = 'south_time_end';
		$st->fields['northeast_date'] = 'northeast_date';
		$st->fields['northeast_time_start'] = 'northeast_time_start';
		$st->fields['northeast_time_end'] = 'northeast_time_end';
		$st->fields['northwest_date'] = 'northwest_date';
		$st->fields['northwest_time_start'] = 'northwest_time_start';
		$st->fields['northwest_time_end'] = 'northwest_time_end';
		$st->fields['southeast_date'] = 'southeast_date';
		$st->fields['southeast_time_start'] = 'southeast_time_start';
		$st->fields['southeast_time_end'] = 'southeast_time_end';
		$st->fields['entry_status'] = 'entry_status';
		$st->fields['note'] = 'note';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = SeminarClassesDatesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("seminar_classes_dates");
		$st->fields['id_seminar_classes_dates'] = $this->idSeminarClassesDates;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['num_seminar'] = $this->numSeminar;
		$st->fields['south_date'] = $this->southDate;
		$st->fields['south_time_start'] = $this->southTimeStart;
		$st->fields['south_time_end'] = $this->southTimeEnd;
		$st->fields['northeast_date'] = $this->northeastDate;
		$st->fields['northeast_time_start'] = $this->northeastTimeStart;
		$st->fields['northeast_time_end'] = $this->northeastTimeEnd;
		$st->fields['northwest_date'] = $this->northwestDate;
		$st->fields['northwest_time_start'] = $this->northwestTimeStart;
		$st->fields['northwest_time_end'] = $this->northwestTimeEnd;
		$st->fields['southeast_date'] = $this->southeastDate;
		$st->fields['southeast_time_start'] = $this->southeastTimeStart;
		$st->fields['southeast_time_end'] = $this->southeastTimeEnd;
		$st->fields['entry_status'] = $this->entryStatus;
		$st->fields['note'] = $this->note;

		$st->nulls['south_date'] = 'south_date';
		$st->nulls['south_time_start'] = 'south_time_start';
		$st->nulls['south_time_end'] = 'south_time_end';
		$st->nulls['northeast_date'] = 'northeast_date';
		$st->nulls['northeast_time_start'] = 'northeast_time_start';
		$st->nulls['northeast_time_end'] = 'northeast_time_end';
		$st->nulls['northwest_date'] = 'northwest_date';
		$st->nulls['northwest_time_start'] = 'northwest_time_start';
		$st->nulls['northwest_time_end'] = 'northwest_time_end';
		$st->nulls['southeast_date'] = 'southeast_date';
		$st->nulls['southeast_time_start'] = 'southeast_time_start';
		$st->nulls['southeast_time_end'] = 'southeast_time_end';
		$st->nulls['note'] = 'note';

		$st->key = 'id_seminar_classes_dates';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("seminar_classes_dates");
		$st->fields['id_seminar_classes_dates'] = $obj->idSeminarClassesDates;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['num_seminar'] = $obj->numSeminar;
		$st->fields['south_date'] = $obj->southDate;
		$st->fields['south_time_start'] = $obj->southTimeStart;
		$st->fields['south_time_end'] = $obj->southTimeEnd;
		$st->fields['northeast_date'] = $obj->northeastDate;
		$st->fields['northeast_time_start'] = $obj->northeastTimeStart;
		$st->fields['northeast_time_end'] = $obj->northeastTimeEnd;
		$st->fields['northwest_date'] = $obj->northwestDate;
		$st->fields['northwest_time_start'] = $obj->northwestTimeStart;
		$st->fields['northwest_time_end'] = $obj->northwestTimeEnd;
		$st->fields['southeast_date'] = $obj->southeastDate;
		$st->fields['southeast_time_start'] = $obj->southeastTimeStart;
		$st->fields['southeast_time_end'] = $obj->southeastTimeEnd;
		$st->fields['entry_status'] = $obj->entryStatus;
		$st->fields['note'] = $obj->note;

		$st->nulls['south_date'] = 'south_date';
		$st->nulls['south_time_start'] = 'south_time_start';
		$st->nulls['south_time_end'] = 'south_time_end';
		$st->nulls['northeast_date'] = 'northeast_date';
		$st->nulls['northeast_time_start'] = 'northeast_time_start';
		$st->nulls['northeast_time_end'] = 'northeast_time_end';
		$st->nulls['northwest_date'] = 'northwest_date';
		$st->nulls['northwest_time_start'] = 'northwest_time_start';
		$st->nulls['northwest_time_end'] = 'northwest_time_end';
		$st->nulls['southeast_date'] = 'southeast_date';
		$st->nulls['southeast_time_start'] = 'southeast_time_start';
		$st->nulls['southeast_time_end'] = 'southeast_time_end';
		$st->nulls['note'] = 'note';

		$st->key = 'id_seminar_classes_dates';
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
		$st = new PBDO_DeleteStatement("seminar_classes_dates","id_seminar_classes_dates = '".$obj->getPrimaryKey()."'");

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
		$x = new SeminarClassesDates();
		$x->idSeminarClassesDates = $row['id_seminar_classes_dates'];
		$x->idClasses = $row['id_classes'];
		$x->numSeminar = $row['num_seminar'];
		$x->southDate = $row['south_date'];
		$x->southTimeStart = $row['south_time_start'];
		$x->southTimeEnd = $row['south_time_end'];
		$x->northeastDate = $row['northeast_date'];
		$x->northeastTimeStart = $row['northeast_time_start'];
		$x->northeastTimeEnd = $row['northeast_time_end'];
		$x->northwestDate = $row['northwest_date'];
		$x->northwestTimeStart = $row['northwest_time_start'];
		$x->northwestTimeEnd = $row['northwest_time_end'];
		$x->southeastDate = $row['southeast_date'];
		$x->southeastTimeStart = $row['southeast_time_start'];
		$x->southeastTimeEnd = $row['southeast_time_end'];
		$x->entryStatus = $row['entry_status'];
		$x->note = $row['note'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class SeminarClassesDates extends SeminarClassesDatesBase {



}



class SeminarClassesDatesPeer extends SeminarClassesDatesPeerBase {

}

?>