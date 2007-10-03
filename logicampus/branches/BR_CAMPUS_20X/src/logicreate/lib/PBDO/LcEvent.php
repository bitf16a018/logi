<?

class LcEventBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $lcEventId;
	var $calendarType;
	var $username;
	var $title;
	var $description;
	var $location;
	var $startDate;
	var $endDate;
	var $groups;
	var $notgroups;
	var $lastModified;
	var $repeatType;
	var $repeatCount;
	var $repeatMask;
	var $repeatExclude;
	var $classId;

	var $__attributes = array( 
	'lcEventId'=>'int',
	'calendarType'=>'varchar',
	'username'=>'varchar',
	'title'=>'varchar',
	'description'=>'text',
	'location'=>'varchar',
	'startDate'=>'int',
	'endDate'=>'int',
	'groups'=>'text',
	'notgroups'=>'text',
	'lastModified'=>'timestamp',
	'repeatType'=>'int',
	'repeatCount'=>'int',
	'repeatMask'=>'int',
	'repeatExclude'=>'text',
	'classId'=>'int');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->lcEventId;
	}


	function setPrimaryKey($val) {
		$this->lcEventId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(LcEventPeer::doInsert($this,$dsn));
		} else {
			LcEventPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "lc_event_id='".$key."'";
		}
		$array = LcEventPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = LcEventPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		LcEventPeer::doDelete($this,$deep,$dsn);
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


class LcEventPeerBase {

	var $tableName = 'lc_event';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("lc_event",$where);
		$st->fields['lc_event_id'] = 'lc_event_id';
		$st->fields['calendar_type'] = 'calendar_type';
		$st->fields['username'] = 'username';
		$st->fields['title'] = 'title';
		$st->fields['description'] = 'description';
		$st->fields['location'] = 'location';
		$st->fields['start_date'] = 'start_date';
		$st->fields['end_date'] = 'end_date';
		$st->fields['groups'] = 'groups';
		$st->fields['notgroups'] = 'notgroups';
		$st->fields['last_modified'] = 'last_modified';
		$st->fields['repeat_type'] = 'repeat_type';
		$st->fields['repeat_count'] = 'repeat_count';
		$st->fields['repeat_mask'] = 'repeat_mask';
		$st->fields['repeat_exclude'] = 'repeat_exclude';
		$st->fields['class_id'] = 'class_id';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = LcEventPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("lc_event");
		$st->fields['lc_event_id'] = $this->lcEventId;
		$st->fields['calendar_type'] = $this->calendarType;
		$st->fields['username'] = $this->username;
		$st->fields['title'] = $this->title;
		$st->fields['description'] = $this->description;
		$st->fields['location'] = $this->location;
		$st->fields['start_date'] = $this->startDate;
		$st->fields['end_date'] = $this->endDate;
		$st->fields['groups'] = $this->groups;
		$st->fields['notgroups'] = $this->notgroups;
		$st->fields['last_modified'] = $this->lastModified;
		$st->fields['repeat_type'] = $this->repeatType;
		$st->fields['repeat_count'] = $this->repeatCount;
		$st->fields['repeat_mask'] = $this->repeatMask;
		$st->fields['repeat_exclude'] = $this->repeatExclude;
		$st->fields['class_id'] = $this->classId;


		$st->key = 'lc_event_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("lc_event");
		$st->fields['lc_event_id'] = $obj->lcEventId;
		$st->fields['calendar_type'] = $obj->calendarType;
		$st->fields['username'] = $obj->username;
		$st->fields['title'] = $obj->title;
		$st->fields['description'] = $obj->description;
		$st->fields['location'] = $obj->location;
		$st->fields['start_date'] = $obj->startDate;
		$st->fields['end_date'] = $obj->endDate;
		$st->fields['groups'] = $obj->groups;
		$st->fields['notgroups'] = $obj->notgroups;
		$st->fields['last_modified'] = $obj->lastModified;
		$st->fields['repeat_type'] = $obj->repeatType;
		$st->fields['repeat_count'] = $obj->repeatCount;
		$st->fields['repeat_mask'] = $obj->repeatMask;
		$st->fields['repeat_exclude'] = $obj->repeatExclude;
		$st->fields['class_id'] = $obj->classId;


		$st->key = 'lc_event_id';
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
		$st = new PBDO_DeleteStatement("lc_event","lc_event_id = '".$obj->getPrimaryKey()."'");

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
		$x = new LcEvent();
		$x->lcEventId = $row['lc_event_id'];
		$x->calendarType = $row['calendar_type'];
		$x->username = $row['username'];
		$x->title = $row['title'];
		$x->description = $row['description'];
		$x->location = $row['location'];
		$x->startDate = $row['start_date'];
		$x->endDate = $row['end_date'];
		$x->groups = $row['groups'];
		$x->notgroups = $row['notgroups'];
		$x->lastModified = $row['last_modified'];
		$x->repeatType = $row['repeat_type'];
		$x->repeatCount = $row['repeat_count'];
		$x->repeatMask = $row['repeat_mask'];
		$x->repeatExclude = $row['repeat_exclude'];
		$x->classId = $row['class_id'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class LcEvent extends LcEventBase {



}



class LcEventPeer extends LcEventPeerBase {

}

?>