<?

class TextbookBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $idTextbook;
	var $idClasses;
	var $southCampus;
	var $southeastCampus;
	var $northeastCampus;
	var $northwestCampus;
	var $noTextbooks;

	var $__attributes = array(
	'idTextbook'=>'int',
	'idClasses'=>'int',
	'southCampus'=>'int',
	'southeastCampus'=>'int',
	'northeastCampus'=>'int',
	'northwestCampus'=>'int',
	'noTextbooks'=>'int');



	function getPrimaryKey() {
		return $this->idTextbook;
	}

	function setPrimaryKey($val) {
		$this->idTextbook = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(TextbookPeer::doInsert($this));
		} else {
			TextbookPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_textbook='".$key."'";
		}
		$array = TextbookPeer::doSelect($where);
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
		if ($array['southCampus'])
			$this->southCampus = $array['southCampus'];
		if ($array['southeastCampus'])
			$this->southeastCampus = $array['southeastCampus'];
		if ($array['northeastCampus'])
			$this->northeastCampus = $array['northeastCampus'];
		if ($array['northwestCampus'])
			$this->northwestCampus = $array['northwestCampus'];
		if ($array['noTextbooks'])
			$this->noTextbooks = $array['noTextbooks'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class TextbookPeer {

	var $tableName = 'textbook';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("textbook",$where);
		$st->fields['id_textbook'] = 'id_textbook';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['south_campus'] = 'south_campus';
		$st->fields['southeast_campus'] = 'southeast_campus';
		$st->fields['northeast_campus'] = 'northeast_campus';
		$st->fields['northwest_campus'] = 'northwest_campus';
		$st->fields['noTextbooks'] = 'noTextbooks';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = TextbookPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("textbook");
		$st->fields['id_textbook'] = $this->idTextbook;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['south_campus'] = $this->southCampus;
		$st->fields['southeast_campus'] = $this->southeastCampus;
		$st->fields['northeast_campus'] = $this->northeastCampus;
		$st->fields['northwest_campus'] = $this->northwestCampus;
		$st->fields['noTextbooks'] = $this->noTextbooks;

		$st->key = 'id_textbook';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("textbook");
		$st->fields['id_textbook'] = $obj->idTextbook;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['south_campus'] = $obj->southCampus;
		$st->fields['southeast_campus'] = $obj->southeastCampus;
		$st->fields['northeast_campus'] = $obj->northeastCampus;
		$st->fields['northwest_campus'] = $obj->northwestCampus;
		$st->fields['noTextbooks'] = $obj->noTextbooks;

		$st->key = 'id_textbook';
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
		$st = new LC_DeleteStatement("textbook","id_textbook = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

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

	/**
	 * Overides one above, I did this because I am using 0's and 1's
	 * and with the above code if it is a 0 it doesn't update, however
	 * i am relying on the 0 to be in the database.
	 */
	function setArray($array) {
			$this->idClasses = $array['idClasses'];
			$this->southCampus = $array['southCampus'];
			$this->southeastCampus = $array['southeastCampus'];
			$this->northeastCampus = $array['northeastCampus'];
			$this->northwestCampus = $array['northwestCampus'];
			$this->noTextbooks = $array['noTextbooks'];

			$this->_modified = true;
	}



}

?>
