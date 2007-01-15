<?

class TextbookBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idTextbook;
	var $idClasses;
	var $southCampus;
	var $southeastCampus;
	var $northeastCampus;
	var $northwestCampus;
	var $noTextbooks;

	var $__attributes = array( 
	'idTextbook'=>'integer',
	'idClasses'=>'integer',
	'southCampus'=>'integer',
	'southeastCampus'=>'integer',
	'northeastCampus'=>'integer',
	'northwestCampus'=>'integer',
	'noTextbooks'=>'tinyint');

	var $__nulls = array( 
	'southCampus'=>'southCampus',
	'southeastCampus'=>'southeastCampus',
	'northeastCampus'=>'northeastCampus',
	'northwestCampus'=>'northwestCampus');



	function getPrimaryKey() {
		return $this->idTextbook;
	}


	function setPrimaryKey($val) {
		$this->idTextbook = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(TextbookPeer::doInsert($this,$dsn));
		} else {
			TextbookPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_textbook='".$key."'";
		}
		$array = TextbookPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = TextbookPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		TextbookPeer::doDelete($this,$deep,$dsn);
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


class TextbookPeerBase {

	var $tableName = 'textbook';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("textbook",$where);
		$st->fields['id_textbook'] = 'id_textbook';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['south_campus'] = 'south_campus';
		$st->fields['southeast_campus'] = 'southeast_campus';
		$st->fields['northeast_campus'] = 'northeast_campus';
		$st->fields['northwest_campus'] = 'northwest_campus';
		$st->fields['noTextbooks'] = 'noTextbooks';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = TextbookPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("textbook");
		$st->fields['id_textbook'] = $this->idTextbook;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['south_campus'] = $this->southCampus;
		$st->fields['southeast_campus'] = $this->southeastCampus;
		$st->fields['northeast_campus'] = $this->northeastCampus;
		$st->fields['northwest_campus'] = $this->northwestCampus;
		$st->fields['noTextbooks'] = $this->noTextbooks;

		$st->nulls['south_campus'] = 'south_campus';
		$st->nulls['southeast_campus'] = 'southeast_campus';
		$st->nulls['northeast_campus'] = 'northeast_campus';
		$st->nulls['northwest_campus'] = 'northwest_campus';

		$st->key = 'id_textbook';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("textbook");
		$st->fields['id_textbook'] = $obj->idTextbook;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['south_campus'] = $obj->southCampus;
		$st->fields['southeast_campus'] = $obj->southeastCampus;
		$st->fields['northeast_campus'] = $obj->northeastCampus;
		$st->fields['northwest_campus'] = $obj->northwestCampus;
		$st->fields['noTextbooks'] = $obj->noTextbooks;

		$st->nulls['south_campus'] = 'south_campus';
		$st->nulls['southeast_campus'] = 'southeast_campus';
		$st->nulls['northeast_campus'] = 'northeast_campus';
		$st->nulls['northwest_campus'] = 'northwest_campus';

		$st->key = 'id_textbook';
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
		$st = new PBDO_DeleteStatement("textbook","id_textbook = '".$obj->getPrimaryKey()."'");

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
		$x = new Textbook();
		$x->idTextbook = $row['id_textbook'];
		$x->idClasses = $row['id_classes'];
		$x->southCampus = $row['south_campus'];
		$x->southeastCampus = $row['southeast_campus'];
		$x->northeastCampus = $row['northeast_campus'];
		$x->northwestCampus = $row['northwest_campus'];
		$x->noTextbooks = $row['noTextbooks'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class Textbook extends TextbookBase {



}



class TextbookPeer extends TextbookPeerBase {

}

?>