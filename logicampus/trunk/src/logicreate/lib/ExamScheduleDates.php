<?

include_once(LIB_PATH.'ExamScheduleClassesDates.php');

class ExamScheduleDatesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $idExamScheduleDates;
	var $idSemester;
	var $dateStart;
	var $dateEnd;

	var $__attributes = array(
	'idExamScheduleDates'=>'bigint',
	'idSemester'=>'bigint',
	'dateStart'=>'datetime',
	'dateEnd'=>'datetime');



	function getPrimaryKey() {
		return $this->idExamScheduleDates;
	}

	function setPrimaryKey($val) {
		$this->idExamScheduleDates = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ExamScheduleDatesPeer::doInsert($this));
		} else {
			ExamScheduleDatesPeer::doUpdate($this);
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
			$where = "id_exam_schedule_dates='".$key."'";
		}
		$array = ExamScheduleDatesPeer::doSelect($where);
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
		if ($array['idSemester'])
			$this->idSemester = $array['idSemester'];
		if ($array['dateStart'])
			$this->dateStart = $array['dateStart'];
		if ($array['dateEnd'])
			$this->dateEnd = $array['dateEnd'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class ExamScheduleDatesPeer {

	var $tableName = 'exam_schedule_dates';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("exam_schedule_dates",$where);
		$st->fields['id_exam_schedule_dates'] = 'id_exam_schedule_dates';
		$st->fields['id_semester'] = 'id_semester';
		$st->fields['date_start'] = 'date_start';
		$st->fields['date_end'] = 'date_end';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ExamScheduleDatesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("exam_schedule_dates");
		$st->fields['id_exam_schedule_dates'] = $this->idExamScheduleDates;
		$st->fields['id_semester'] = $this->idSemester;
		$st->fields['date_start'] = $this->dateStart;
		$st->fields['date_end'] = $this->dateEnd;

		$st->key = 'id_exam_schedule_dates';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("exam_schedule_dates");
		$st->fields['id_exam_schedule_dates'] = $obj->idExamScheduleDates;
		$st->fields['id_semester'] = $obj->idSemester;
		$st->fields['date_start'] = $obj->dateStart;
		$st->fields['date_end'] = $obj->dateEnd;

		$st->key = 'id_exam_schedule_dates';
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
		$st = new LC_DeleteStatement("exam_schedule_dates","id_exam_schedule_dates = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new ExamScheduleDates();
		$x->idExamScheduleDates = $row['id_exam_schedule_dates'];
		$x->idSemester = $row['id_semester'];
		$x->dateStart = $row['date_start'];
		$x->dateEnd = $row['date_end'];

		$x->_new = false;
		return $x;
	}

}


// You can edit this class, but do not change this next line!
class ExamScheduleDates extends ExamScheduleDatesBase {

	// returns an array of ExamScheduleClassesDates objects with extra data
	// from ExamScheduleDates. Some of the ExamScheduleDates
	function getAllDates( $classid, $semesterid, $showEnteredDatesOnly ) {

		$escds = array();

		$esds = ExamScheduleDatesPeer::doSelect( "id_semester='$semesterid'" );
		while ( list(,$esd) = @each($esds) ) {
			$escd = ExamScheduleClassesDates::load( array(
				'id_classes' => $classid,
				'id_exam_schedule_dates' => $esd->idExamScheduleDates
			) );
			if ( !is_object($escd) ) {

				// don't make an empty object; they only want to see dates that were entered
				//if ( $showEnteredDatesOnly ) continue;

				$escd = new ExamScheduleClassesDates();
				$escd->set( 'idClasses', $classid );
				$escd->set( 'idExamScheduleDates', $esd->idExamScheduleDates );
				$escd->set( 'status', 1 ); // not approved
			}
			$escd->dateStart = $esd->dateStart;
			$escd->dateEnd = $esd->dateEnd;
			$escds[$esd->idExamScheduleDates] = $escd;
		}
		return $escds;
	}

	# Finds all user accounts in system in the exam
	# manager group and emails them.
	function mailAdmin( $msg, $subject='' )
	{
		$db = DB::getHandle();
		$sql = "SELECT email FROM lcUsers where groups LIKE
		'%|exammgr|%'";
		$db->query($sql);
		while($db->next_record() )
		{
			$emailTo .= $db->Record['email'].',';	
		}
		$emailTo = substr($emailTo, 0, -1);
		mail($emailTo, "Exam Date Added / Modified".$subject, $msg, "From: ".WEBMASTER_EMAIL."\r\n");
	}

}

?>
