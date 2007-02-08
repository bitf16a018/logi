<?

class ExamScheduleClassesDatesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idExamScheduleClassesDates;
	var $idClasses;
	var $idExamScheduleDates;
	var $newExam;
	var $title;
	var $instructions;
	var $southCopies;
	var $southeastCopies;
	var $northeastCopies;
	var $northwestCopies;
	var $numOfCopies;
	var $note;
	var $status;

	var $__attributes = array( 
	'idExamScheduleClassesDates'=>'integer',
	'idClasses'=>'bigint',
	'idExamScheduleDates'=>'bigint',
	'newExam'=>'integer',
	'title'=>'varchar',
	'instructions'=>'longvarchar',
	'southCopies'=>'integer',
	'southeastCopies'=>'integer',
	'northeastCopies'=>'integer',
	'northwestCopies'=>'integer',
	'numOfCopies'=>'integer',
	'note'=>'longvarchar',
	'status'=>'tinyint');

	var $__nulls = array( 
	'southCopies'=>'southCopies',
	'southeastCopies'=>'southeastCopies',
	'northeastCopies'=>'northeastCopies',
	'northwestCopies'=>'northwestCopies',
	'numOfCopies'=>'numOfCopies',
	'note'=>'note');



	function getPrimaryKey() {
		return $this->idExamScheduleClassesDates;
	}


	function setPrimaryKey($val) {
		$this->idExamScheduleClassesDates = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ExamScheduleClassesDatesPeer::doInsert($this,$dsn));
		} else {
			ExamScheduleClassesDatesPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_exam_schedule_classes_dates='".$key."'";
		}
		$array = ExamScheduleClassesDatesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ExamScheduleClassesDatesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ExamScheduleClassesDatesPeer::doDelete($this,$deep,$dsn);
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


class ExamScheduleClassesDatesPeerBase {

	var $tableName = 'exam_schedule_classes_dates';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("exam_schedule_classes_dates",$where);
		$st->fields['id_exam_schedule_classes_dates'] = 'id_exam_schedule_classes_dates';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['id_exam_schedule_dates'] = 'id_exam_schedule_dates';
		$st->fields['new_exam'] = 'new_exam';
		$st->fields['title'] = 'title';
		$st->fields['instructions'] = 'instructions';
		$st->fields['south_copies'] = 'south_copies';
		$st->fields['southeast_copies'] = 'southeast_copies';
		$st->fields['northeast_copies'] = 'northeast_copies';
		$st->fields['northwest_copies'] = 'northwest_copies';
		$st->fields['num_of_copies'] = 'num_of_copies';
		$st->fields['note'] = 'note';
		$st->fields['status'] = 'status';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ExamScheduleClassesDatesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("exam_schedule_classes_dates");
		$st->fields['id_exam_schedule_classes_dates'] = $this->idExamScheduleClassesDates;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['id_exam_schedule_dates'] = $this->idExamScheduleDates;
		$st->fields['new_exam'] = $this->newExam;
		$st->fields['title'] = $this->title;
		$st->fields['instructions'] = $this->instructions;
		$st->fields['south_copies'] = $this->southCopies;
		$st->fields['southeast_copies'] = $this->southeastCopies;
		$st->fields['northeast_copies'] = $this->northeastCopies;
		$st->fields['northwest_copies'] = $this->northwestCopies;
		$st->fields['num_of_copies'] = $this->numOfCopies;
		$st->fields['note'] = $this->note;
		$st->fields['status'] = $this->status;

		$st->nulls['south_copies'] = 'south_copies';
		$st->nulls['southeast_copies'] = 'southeast_copies';
		$st->nulls['northeast_copies'] = 'northeast_copies';
		$st->nulls['northwest_copies'] = 'northwest_copies';
		$st->nulls['num_of_copies'] = 'num_of_copies';
		$st->nulls['note'] = 'note';

		$st->key = 'id_exam_schedule_classes_dates';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("exam_schedule_classes_dates");
		$st->fields['id_exam_schedule_classes_dates'] = $obj->idExamScheduleClassesDates;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['id_exam_schedule_dates'] = $obj->idExamScheduleDates;
		$st->fields['new_exam'] = $obj->newExam;
		$st->fields['title'] = $obj->title;
		$st->fields['instructions'] = $obj->instructions;
		$st->fields['south_copies'] = $obj->southCopies;
		$st->fields['southeast_copies'] = $obj->southeastCopies;
		$st->fields['northeast_copies'] = $obj->northeastCopies;
		$st->fields['northwest_copies'] = $obj->northwestCopies;
		$st->fields['num_of_copies'] = $obj->numOfCopies;
		$st->fields['note'] = $obj->note;
		$st->fields['status'] = $obj->status;

		$st->nulls['south_copies'] = 'south_copies';
		$st->nulls['southeast_copies'] = 'southeast_copies';
		$st->nulls['northeast_copies'] = 'northeast_copies';
		$st->nulls['northwest_copies'] = 'northwest_copies';
		$st->nulls['num_of_copies'] = 'num_of_copies';
		$st->nulls['note'] = 'note';

		$st->key = 'id_exam_schedule_classes_dates';
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
		$st = new PBDO_DeleteStatement("exam_schedule_classes_dates","id_exam_schedule_classes_dates = '".$obj->getPrimaryKey()."'");

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
		$x = new ExamScheduleClassesDates();
		$x->idExamScheduleClassesDates = $row['id_exam_schedule_classes_dates'];
		$x->idClasses = $row['id_classes'];
		$x->idExamScheduleDates = $row['id_exam_schedule_dates'];
		$x->newExam = $row['new_exam'];
		$x->title = $row['title'];
		$x->instructions = $row['instructions'];
		$x->southCopies = $row['south_copies'];
		$x->southeastCopies = $row['southeast_copies'];
		$x->northeastCopies = $row['northeast_copies'];
		$x->northwestCopies = $row['northwest_copies'];
		$x->numOfCopies = $row['num_of_copies'];
		$x->note = $row['note'];
		$x->status = $row['status'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ExamScheduleClassesDates extends ExamScheduleClassesDatesBase {

	/**
	 * __FIXME__ what does this function do?
	 */
	function loadClassDates($id_classes) {
		$db = DB::getHandle();
		$sql = "SELECT * 
			FROM `exam_schedule_dates` AS a 
			RIGHT JOIN exam_schedule_classes_dates AS d 
			ON d.id_exam_schedule_dates=a.id_exam_schedule_dates 
			WHERE d.id_classes='$id_classes' and status=3
			ORDER BY a.date_start";
		$db->query($sql);
		while($db->nextRecord() ) {
			$array[] = ExamScheduleClassesDatesPeer::row2Obj($db->record);
		}
		return $array;
	}
}



class ExamScheduleClassesDatesPeer extends ExamScheduleClassesDatesPeerBase {

}

?>
