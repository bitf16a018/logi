<?

class AssessmentEventLinkBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $assessmentEventLinkId;
	var $assessmentId;
	var $lcEventId;

	var $__attributes = array( 
	'assessmentEventLinkId'=>'int',
	'assessmentId'=>'int',
	'lcEventId'=>'int');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->assessmentEventLinkId;
	}


	function setPrimaryKey($val) {
		$this->assessmentEventLinkId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(AssessmentEventLinkPeer::doInsert($this,$dsn));
		} else {
			AssessmentEventLinkPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "assessment_event_link_id='".$key."'";
		}
		$array = AssessmentEventLinkPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = AssessmentEventLinkPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		AssessmentEventLinkPeer::doDelete($this,$deep,$dsn);
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


class AssessmentEventLinkPeerBase {

	var $tableName = 'assessment_event_link';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("assessment_event_link",$where);
		$st->fields['assessment_event_link_id'] = 'assessment_event_link_id';
		$st->fields['assessment_id'] = 'assessment_id';
		$st->fields['lc_event_id'] = 'lc_event_id';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = AssessmentEventLinkPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("assessment_event_link");
		$st->fields['assessment_event_link_id'] = $this->assessmentEventLinkId;
		$st->fields['assessment_id'] = $this->assessmentId;
		$st->fields['lc_event_id'] = $this->lcEventId;


		$st->key = 'assessment_event_link_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("assessment_event_link");
		$st->fields['assessment_event_link_id'] = $obj->assessmentEventLinkId;
		$st->fields['assessment_id'] = $obj->assessmentId;
		$st->fields['lc_event_id'] = $obj->lcEventId;


		$st->key = 'assessment_event_link_id';
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
		$st = new PBDO_DeleteStatement("assessment_event_link","assessment_event_link_id = '".$obj->getPrimaryKey()."'");

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
		$x = new AssessmentEventLink();
		$x->assessmentEventLinkId = $row['assessment_event_link_id'];
		$x->assessmentId = $row['assessment_id'];
		$x->lcEventId = $row['lc_event_id'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class AssessmentEventLink extends AssessmentEventLinkBase {



}



class AssessmentEventLinkPeer extends AssessmentEventLinkPeerBase {

}

?>