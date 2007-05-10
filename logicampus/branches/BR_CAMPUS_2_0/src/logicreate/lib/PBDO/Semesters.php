<?

class SemestersBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idSemesters;
	var $semesterId;
	var $semesterTerm;
	var $dateCensus;
	var $dateFinalDrop;
	var $dateDeactivation;
	var $dateStart;
	var $dateEnd;
	var $dateRegistrationStart;
	var $dateRegistrationEnd;
	var $dateAccountActivation;
	var $dateStudentActivation;
	var $semesterYear;
	var $dateStartITVseminar;
	var $dateEndITVseminar;
	var $dateStartOrientation;
	var $dateEndOrientation;
	var $dateStartTextbook;
	var $dateEndTextbook;
	var $dateStartExam;
	var $dateEndExam;

	var $__attributes = array( 
	'idSemesters'=>'integer',
	'semesterId'=>'varchar',
	'semesterTerm'=>'varchar',
	'dateCensus'=>'date',
	'dateFinalDrop'=>'datetime',
	'dateDeactivation'=>'date',
	'dateStart'=>'date',
	'dateEnd'=>'date',
	'dateRegistrationStart'=>'date',
	'dateRegistrationEnd'=>'date',
	'dateAccountActivation'=>'datetime',
	'dateStudentActivation'=>'datetime',
	'semesterYear'=>'integer',
	'dateStartITVseminar'=>'datetime',
	'dateEndITVseminar'=>'datetime',
	'dateStartOrientation'=>'datetime',
	'dateEndOrientation'=>'datetime',
	'dateStartTextbook'=>'datetime',
	'dateEndTextbook'=>'datetime',
	'dateStartExam'=>'datetime',
	'dateEndExam'=>'datetime');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->idSemesters;
	}


	function setPrimaryKey($val) {
		$this->idSemesters = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(SemestersPeer::doInsert($this,$dsn));
		} else {
			SemestersPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_semesters='".$key."'";
		}
		$array = SemestersPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = SemestersPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		SemestersPeer::doDelete($this,$deep,$dsn);
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


class SemestersPeerBase {

	var $tableName = 'semesters';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("semesters",$where);
		$st->fields['id_semesters'] = 'id_semesters';
		$st->fields['semesterId'] = 'semesterId';
		$st->fields['semesterTerm'] = 'semesterTerm';
		$st->fields['dateCensus'] = 'dateCensus';
		$st->fields['dateFinalDrop'] = 'dateFinalDrop';
		$st->fields['dateDeactivation'] = 'dateDeactivation';
		$st->fields['dateStart'] = 'dateStart';
		$st->fields['dateEnd'] = 'dateEnd';
		$st->fields['dateRegistrationStart'] = 'dateRegistrationStart';
		$st->fields['dateRegistrationEnd'] = 'dateRegistrationEnd';
		$st->fields['dateAccountActivation'] = 'dateAccountActivation';
		$st->fields['dateStudentActivation'] = 'dateStudentActivation';
		$st->fields['semesterYear'] = 'semesterYear';
		$st->fields['dateStartITVseminar'] = 'dateStartITVseminar';
		$st->fields['dateEndITVseminar'] = 'dateEndITVseminar';
		$st->fields['dateStartOrientation'] = 'dateStartOrientation';
		$st->fields['dateEndOrientation'] = 'dateEndOrientation';
		$st->fields['dateStartTextbook'] = 'dateStartTextbook';
		$st->fields['dateEndTextbook'] = 'dateEndTextbook';
		$st->fields['dateStartExam'] = 'dateStartExam';
		$st->fields['dateEndExam'] = 'dateEndExam';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = SemestersPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("semesters");
		$st->fields['id_semesters'] = $this->idSemesters;
		$st->fields['semesterId'] = $this->semesterId;
		$st->fields['semesterTerm'] = $this->semesterTerm;
		$st->fields['dateCensus'] = $this->dateCensus;
		$st->fields['dateFinalDrop'] = $this->dateFinalDrop;
		$st->fields['dateDeactivation'] = $this->dateDeactivation;
		$st->fields['dateStart'] = $this->dateStart;
		$st->fields['dateEnd'] = $this->dateEnd;
		$st->fields['dateRegistrationStart'] = $this->dateRegistrationStart;
		$st->fields['dateRegistrationEnd'] = $this->dateRegistrationEnd;
		$st->fields['dateAccountActivation'] = $this->dateAccountActivation;
		$st->fields['dateStudentActivation'] = $this->dateStudentActivation;
		$st->fields['semesterYear'] = $this->semesterYear;
		$st->fields['dateStartITVseminar'] = $this->dateStartITVseminar;
		$st->fields['dateEndITVseminar'] = $this->dateEndITVseminar;
		$st->fields['dateStartOrientation'] = $this->dateStartOrientation;
		$st->fields['dateEndOrientation'] = $this->dateEndOrientation;
		$st->fields['dateStartTextbook'] = $this->dateStartTextbook;
		$st->fields['dateEndTextbook'] = $this->dateEndTextbook;
		$st->fields['dateStartExam'] = $this->dateStartExam;
		$st->fields['dateEndExam'] = $this->dateEndExam;


		$st->key = 'id_semesters';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("semesters");
		$st->fields['id_semesters'] = $obj->idSemesters;
		$st->fields['semesterId'] = $obj->semesterId;
		$st->fields['semesterTerm'] = $obj->semesterTerm;
		$st->fields['dateCensus'] = $obj->dateCensus;
		$st->fields['dateFinalDrop'] = $obj->dateFinalDrop;
		$st->fields['dateDeactivation'] = $obj->dateDeactivation;
		$st->fields['dateStart'] = $obj->dateStart;
		$st->fields['dateEnd'] = $obj->dateEnd;
		$st->fields['dateRegistrationStart'] = $obj->dateRegistrationStart;
		$st->fields['dateRegistrationEnd'] = $obj->dateRegistrationEnd;
		$st->fields['dateAccountActivation'] = $obj->dateAccountActivation;
		$st->fields['dateStudentActivation'] = $obj->dateStudentActivation;
		$st->fields['semesterYear'] = $obj->semesterYear;
		$st->fields['dateStartITVseminar'] = $obj->dateStartITVseminar;
		$st->fields['dateEndITVseminar'] = $obj->dateEndITVseminar;
		$st->fields['dateStartOrientation'] = $obj->dateStartOrientation;
		$st->fields['dateEndOrientation'] = $obj->dateEndOrientation;
		$st->fields['dateStartTextbook'] = $obj->dateStartTextbook;
		$st->fields['dateEndTextbook'] = $obj->dateEndTextbook;
		$st->fields['dateStartExam'] = $obj->dateStartExam;
		$st->fields['dateEndExam'] = $obj->dateEndExam;


		$st->key = 'id_semesters';
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
		$st = new PBDO_DeleteStatement("semesters","id_semesters = '".$obj->getPrimaryKey()."'");

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
		$x = new Semesters();
		$x->idSemesters = $row['id_semesters'];
		$x->semesterId = $row['semesterId'];
		$x->semesterTerm = $row['semesterTerm'];
		$x->dateCensus = $row['dateCensus'];
		$x->dateFinalDrop = $row['dateFinalDrop'];
		$x->dateDeactivation = $row['dateDeactivation'];
		$x->dateStart = $row['dateStart'];
		$x->dateEnd = $row['dateEnd'];
		$x->dateRegistrationStart = $row['dateRegistrationStart'];
		$x->dateRegistrationEnd = $row['dateRegistrationEnd'];
		$x->dateAccountActivation = $row['dateAccountActivation'];
		$x->dateStudentActivation = $row['dateStudentActivation'];
		$x->semesterYear = $row['semesterYear'];
		$x->dateStartITVseminar = $row['dateStartITVseminar'];
		$x->dateEndITVseminar = $row['dateEndITVseminar'];
		$x->dateStartOrientation = $row['dateStartOrientation'];
		$x->dateEndOrientation = $row['dateEndOrientation'];
		$x->dateStartTextbook = $row['dateStartTextbook'];
		$x->dateEndTextbook = $row['dateEndTextbook'];
		$x->dateStartExam = $row['dateStartExam'];
		$x->dateEndExam = $row['dateEndExam'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class Semesters extends SemestersBase {



}



class SemestersPeer extends SemestersPeerBase {

}

?>