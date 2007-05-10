<?

class ExamScheduleClassesDatesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
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
	'idExamScheduleClassesDates'=>'int',
	'idClasses'=>'bigint',
	'idExamScheduleDates'=>'bigint',
	'newExam'=>'int',
	'title'=>'varchar',
	'instructions'=>'text',
	'southCopies'=>'int',
	'southeastCopies'=>'int',
	'northeastCopies'=>'int',
	'northwestCopies'=>'int',
	'numOfCopies'=>'int',
	'note'=>'text',
	'status'=>'tinyint');



	function getPrimaryKey() {
		return $this->idExamScheduleClassesDates;
	}

	function setPrimaryKey($val) {
		$this->idExamScheduleClassesDates = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ExamScheduleClassesDatesPeer::doInsert($this));
		} else {
			ExamScheduleClassesDatesPeer::doUpdate($this);
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
			$where = "id_exam_schedule_classes_dates='".$key."'";
		}
		$array = ExamScheduleClassesDatesPeer::doSelect($where);
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
		if ($array['idExamScheduleDates'])
			$this->idExamScheduleDates = $array['idExamScheduleDates'];
		if ($array['newExam'])
			$this->newExam = $array['newExam'];
		if ($array['title'])
			$this->title = $array['title'];
		if ($array['instructions'])
			$this->instructions = $array['instructions'];
		if ($array['southCopies'])
			$this->southCopies = $array['southCopies'];
		if ($array['southeastCopies'])
			$this->southeastCopies = $array['southeastCopies'];
		if ($array['northeastCopies'])
			$this->northeastCopies = $array['northeastCopies'];
		if ($array['northwestCopies'])
			$this->northwestCopies = $array['northwestCopies'];
		if ($array['numOfCopies'])
			$this->numOfCopies = $array['numOfCopies'];
		if ($array['note'])
			$this->note = $array['note'];
		if ($array['status'])
			$this->status = $array['status'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class ExamScheduleClassesDatesPeer {

	var $tableName = 'exam_schedule_classes_dates';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("exam_schedule_classes_dates",$where);
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

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ExamScheduleClassesDatesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("exam_schedule_classes_dates");
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

		$st->key = 'id_exam_schedule_classes_dates';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("exam_schedule_classes_dates");
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

		$st->key = 'id_exam_schedule_classes_dates';
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
		$st = new LC_DeleteStatement("exam_schedule_classes_dates","id_exam_schedule_classes_dates = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

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

?>
