<?

class SeminarClassesDatesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
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
	'idSeminarClassesDates'=>'int',
	'idClasses'=>'int',
	'numSeminar'=>'int',
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
	'entryStatus'=>'int',
	'note'=>'text');



	function getPrimaryKey() {
		return $this->idSeminarClassesDates;
	}

	function setPrimaryKey($val) {
		$this->idSeminarClassesDates = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(SeminarClassesDatesPeer::doInsert($this));
		} else {
			SeminarClassesDatesPeer::doUpdate($this);
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
			$where = "id_seminar_classes_dates='".$key."'";
		}
		$array = SeminarClassesDatesPeer::doSelect($where);
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
		if ($array['numSeminar'])
			$this->numSeminar = $array['numSeminar'];
		if ($array['southDate'])
			$this->southDate = $array['southDate'];
		if ($array['southTimeStart'])
			$this->southTimeStart = $array['southTimeStart'];
		if ($array['southTimeEnd'])
			$this->southTimeEnd = $array['southTimeEnd'];
		if ($array['northeastDate'])
			$this->northeastDate = $array['northeastDate'];
		if ($array['northeastTimeStart'])
			$this->northeastTimeStart = $array['northeastTimeStart'];
		if ($array['northeastTimeEnd'])
			$this->northeastTimeEnd = $array['northeastTimeEnd'];
		if ($array['northwestDate'])
			$this->northwestDate = $array['northwestDate'];
		if ($array['northwestTimeStart'])
			$this->northwestTimeStart = $array['northwestTimeStart'];
		if ($array['northwestTimeEnd'])
			$this->northwestTimeEnd = $array['northwestTimeEnd'];
		if ($array['southeastDate'])
			$this->southeastDate = $array['southeastDate'];
		if ($array['southeastTimeStart'])
			$this->southeastTimeStart = $array['southeastTimeStart'];
		if ($array['southeastTimeEnd'])
			$this->southeastTimeEnd = $array['southeastTimeEnd'];
		if ($array['entryStatus'])
			$this->entryStatus = $array['entryStatus'];
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


class SeminarClassesDatesPeer {

	var $tableName = 'seminar_classes_dates';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("seminar_classes_dates",$where);
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

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = SeminarClassesDatesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("seminar_classes_dates");
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

		$st->key = 'id_seminar_classes_dates';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("seminar_classes_dates");
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

		$st->key = 'id_seminar_classes_dates';
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
		$st = new LC_DeleteStatement("seminar_classes_dates","id_seminar_classes_dates = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

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
	
	/**
	 * @return void
	 * @desc Mails all admins if an entry is added or updated
	 */
	function  mailAdmin($msg)
	{
		$db = DB::getHandle();
		$sql = "SELECT email FROM lcUsers where groups LIKE
		'%|semmgr|%'";
		$db->query($sql);
		while($db->next_record() )
		{
			$emailTo .= $db->Record['email'].',';	
		}
		
		$emailTo = substr($emailTo, 0, -1);
		mail($emailTo, "Seminar Added / Modifed", $msg, "From: ".WEBMASTER_EMAIL."\r\n");
	}
}

function getStatus($x)
	{
		switch($x)
		{
			case 1;
			return 'New';

			case 0;
			return 'N/A';

			case 2;
			return 'Pending';

			case 3;
			return 'Approved';

			case 4;
			return 'Waiting on Inst.';
		}
			
	}


# Converts the 00:00:00 format of the TIME field in the database
# to 8:00 AM or 1:15 PM
function convertTime($time)
{
	$date = date('Y-m-d');
	$ut = strtotime("$date $time");
	return date('h:i A', $ut);
}

function convertDateTime($date)
{
	return date('D F dS, Y h:i A', strtotime($date));
}


?>
