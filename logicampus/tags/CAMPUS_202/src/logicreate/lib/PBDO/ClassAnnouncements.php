<?

class ClassAnnouncementsBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idClassAnnouncements;
	var $idClasses;
	var $dtDisplay;
	var $txTitle;
	var $txDescription;
	var $idFacultyCreatedby;
	var $dtCreated;

	var $__attributes = array( 
	'idClassAnnouncements'=>'integer',
	'idClasses'=>'integer',
	'dtDisplay'=>'datetime',
	'txTitle'=>'varchar',
	'txDescription'=>'longvarchar',
	'idFacultyCreatedby'=>'varchar',
	'dtCreated'=>'datetime');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->idClassAnnouncements;
	}


	function setPrimaryKey($val) {
		$this->idClassAnnouncements = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassAnnouncementsPeer::doInsert($this,$dsn));
		} else {
			ClassAnnouncementsPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_announcements='".$key."'";
		}
		$array = ClassAnnouncementsPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassAnnouncementsPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassAnnouncementsPeer::doDelete($this,$deep,$dsn);
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


class ClassAnnouncementsPeerBase {

	var $tableName = 'class_announcements';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_announcements",$where);
		$st->fields['id_class_announcements'] = 'id_class_announcements';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['dt_display'] = 'dt_display';
		$st->fields['tx_title'] = 'tx_title';
		$st->fields['tx_description'] = 'tx_description';
		$st->fields['id_faculty_createdby'] = 'id_faculty_createdby';
		$st->fields['dt_created'] = 'dt_created';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassAnnouncementsPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_announcements");
		$st->fields['id_class_announcements'] = $this->idClassAnnouncements;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['dt_display'] = $this->dtDisplay;
		$st->fields['tx_title'] = $this->txTitle;
		$st->fields['tx_description'] = $this->txDescription;
		$st->fields['id_faculty_createdby'] = $this->idFacultyCreatedby;
		$st->fields['dt_created'] = $this->dtCreated;


		$st->key = 'id_class_announcements';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_announcements");
		$st->fields['id_class_announcements'] = $obj->idClassAnnouncements;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['dt_display'] = $obj->dtDisplay;
		$st->fields['tx_title'] = $obj->txTitle;
		$st->fields['tx_description'] = $obj->txDescription;
		$st->fields['id_faculty_createdby'] = $obj->idFacultyCreatedby;
		$st->fields['dt_created'] = $obj->dtCreated;


		$st->key = 'id_class_announcements';
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
		$st = new PBDO_DeleteStatement("class_announcements","id_class_announcements = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassAnnouncements();
		$x->idClassAnnouncements = $row['id_class_announcements'];
		$x->idClasses = $row['id_classes'];
		$x->dtDisplay = $row['dt_display'];
		$x->txTitle = $row['tx_title'];
		$x->txDescription = $row['tx_description'];
		$x->idFacultyCreatedby = $row['id_faculty_createdby'];
		$x->dtCreated = $row['dt_created'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassAnnouncements extends ClassAnnouncementsBase {



}



class ClassAnnouncementsPeer extends ClassAnnouncementsPeerBase {

}

?>