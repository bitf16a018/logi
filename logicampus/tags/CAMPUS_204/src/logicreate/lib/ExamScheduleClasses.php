<?

class ExamScheduleClassesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idExamScheduleClasses;
	var $idClasses;
	var $idSemester;
	var $status;
	var $receivedDate;
	var $southCampus;
	var $southeastCampus;
	var $northeastCampus;
	var $northwestCampus;
	var $note;

	var $__attributes = array( 
	'idExamScheduleClasses'=>'integer',
	'idClasses'=>'integer',
	'idSemester'=>'integer',
	'status'=>'integer',
	'receivedDate'=>'datetime',
	'southCampus'=>'integer',
	'southeastCampus'=>'integer',
	'northeastCampus'=>'integer',
	'northwestCampus'=>'integer',
	'note'=>'longvarchar');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->idExamScheduleClasses;
	}


	function setPrimaryKey($val) {
		$this->idExamScheduleClasses = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ExamScheduleClassesPeer::doInsert($this,$dsn));
		} else {
			ExamScheduleClassesPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_exam_schedule_classes='".$key."'";
		}
		$array = ExamScheduleClassesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ExamScheduleClassesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ExamScheduleClassesPeer::doDelete($this,$deep,$dsn);
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


class ExamScheduleClassesPeerBase {

	var $tableName = 'exam_schedule_classes';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("exam_schedule_classes",$where);
		$st->fields['id_exam_schedule_classes'] = 'id_exam_schedule_classes';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['id_semester'] = 'id_semester';
		$st->fields['status'] = 'status';
		$st->fields['received_date'] = 'received_date';
		$st->fields['south_campus'] = 'south_campus';
		$st->fields['southeast_campus'] = 'southeast_campus';
		$st->fields['northeast_campus'] = 'northeast_campus';
		$st->fields['northwest_campus'] = 'northwest_campus';
		$st->fields['note'] = 'note';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ExamScheduleClassesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("exam_schedule_classes");
		$st->fields['id_exam_schedule_classes'] = $this->idExamScheduleClasses;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['id_semester'] = $this->idSemester;
		$st->fields['status'] = $this->status;
		$st->fields['received_date'] = $this->receivedDate;
		$st->fields['south_campus'] = $this->southCampus;
		$st->fields['southeast_campus'] = $this->southeastCampus;
		$st->fields['northeast_campus'] = $this->northeastCampus;
		$st->fields['northwest_campus'] = $this->northwestCampus;
		$st->fields['note'] = $this->note;


		$st->key = 'id_exam_schedule_classes';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("exam_schedule_classes");
		$st->fields['id_exam_schedule_classes'] = $obj->idExamScheduleClasses;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['id_semester'] = $obj->idSemester;
		$st->fields['status'] = $obj->status;
		$st->fields['received_date'] = $obj->receivedDate;
		$st->fields['south_campus'] = $obj->southCampus;
		$st->fields['southeast_campus'] = $obj->southeastCampus;
		$st->fields['northeast_campus'] = $obj->northeastCampus;
		$st->fields['northwest_campus'] = $obj->northwestCampus;
		$st->fields['note'] = $obj->note;


		$st->key = 'id_exam_schedule_classes';
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
		$st = new PBDO_DeleteStatement("exam_schedule_classes","id_exam_schedule_classes = '".$obj->getPrimaryKey()."'");

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
		$x = new ExamScheduleClasses();
		$x->idExamScheduleClasses = $row['id_exam_schedule_classes'];
		$x->idClasses = $row['id_classes'];
		$x->idSemester = $row['id_semester'];
		$x->status = $row['status'];
		$x->receivedDate = $row['received_date'];
		$x->southCampus = $row['south_campus'];
		$x->southeastCampus = $row['southeast_campus'];
		$x->northeastCampus = $row['northeast_campus'];
		$x->northwestCampus = $row['northwest_campus'];
		$x->note = $row['note'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ExamScheduleClasses extends ExamScheduleClassesBase {



}



class ExamScheduleClassesPeer extends ExamScheduleClassesPeerBase {

}

?>