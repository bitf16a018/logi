<?

class ExamScheduleDatesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idExamScheduleDates;
	var $idSemester;
	var $dateStart;
	var $dateEnd;

	var $__attributes = array( 
	'idExamScheduleDates'=>'bigint',
	'idSemester'=>'bigint',
	'dateStart'=>'datetime',
	'dateEnd'=>'datetime');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->idExamScheduleDates;
	}


	function setPrimaryKey($val) {
		$this->idExamScheduleDates = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ExamScheduleDatesPeer::doInsert($this,$dsn));
		} else {
			ExamScheduleDatesPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_exam_schedule_dates='".$key."'";
		}
		$array = ExamScheduleDatesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ExamScheduleDatesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ExamScheduleDatesPeer::doDelete($this,$deep,$dsn);
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


class ExamScheduleDatesPeerBase {

	var $tableName = 'exam_schedule_dates';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("exam_schedule_dates",$where);
		$st->fields['id_exam_schedule_dates'] = 'id_exam_schedule_dates';
		$st->fields['id_semester'] = 'id_semester';
		$st->fields['date_start'] = 'date_start';
		$st->fields['date_end'] = 'date_end';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ExamScheduleDatesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("exam_schedule_dates");
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

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("exam_schedule_dates");
		$st->fields['id_exam_schedule_dates'] = $obj->idExamScheduleDates;
		$st->fields['id_semester'] = $obj->idSemester;
		$st->fields['date_start'] = $obj->dateStart;
		$st->fields['date_end'] = $obj->dateEnd;


		$st->key = 'id_exam_schedule_dates';
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
		$st = new PBDO_DeleteStatement("exam_schedule_dates","id_exam_schedule_dates = '".$obj->getPrimaryKey()."'");

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
		$x = new ExamScheduleDates();
		$x->idExamScheduleDates = $row['id_exam_schedule_dates'];
		$x->idSemester = $row['id_semester'];
		$x->dateStart = $row['date_start'];
		$x->dateEnd = $row['date_end'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
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



class ExamScheduleDatesPeer extends ExamScheduleDatesPeerBase {

}

?>
