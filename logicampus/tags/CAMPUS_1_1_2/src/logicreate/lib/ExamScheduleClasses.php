<?

class ExamScheduleClassesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
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
	'idExamScheduleClasses'=>'int',
	'idClasses'=>'int',
	'idSemester'=>'int',
	'status'=>'int',
	'receivedDate'=>'datetime',
	'southCampus'=>'int',
	'southeastCampus'=>'int',
	'northeastCampus'=>'int',
	'northwestCampus'=>'int',
	'note'=>'text');



	function getPrimaryKey() {
		return $this->idExamScheduleClasses;
	}

	function setPrimaryKey($val) {
		$this->idExamScheduleClasses = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ExamScheduleClassesPeer::doInsert($this));
		} else {
			ExamScheduleClassesPeer::doUpdate($this);
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
			$where = "id_exam_schedule_classes='".$key."'";
		}
		$array = ExamScheduleClassesPeer::doSelect($where);
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
		if ($array['idSemester'])
			$this->idSemester = $array['idSemester'];
		if ($array['status'])
			$this->status = $array['status'];
		if ($array['receivedDate'])
			$this->receivedDate = $array['receivedDate'];
		if ($array['southCampus'])
			$this->southCampus = $array['southCampus'];
		if ($array['southeastCampus'])
			$this->southeastCampus = $array['southeastCampus'];
		if ($array['northeastCampus'])
			$this->northeastCampus = $array['northeastCampus'];
		if ($array['northwestCampus'])
			$this->northwestCampus = $array['northwestCampus'];
		if ($array['note'])
			$this->note = $array['note'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class ExamScheduleClassesPeer {

	var $tableName = 'exam_schedule_classes';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("exam_schedule_classes",$where);
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

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ExamScheduleClassesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("exam_schedule_classes");
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

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("exam_schedule_classes");
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
		$st = new LC_DeleteStatement("exam_schedule_classes","id_exam_schedule_classes = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

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

?>
