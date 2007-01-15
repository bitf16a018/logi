<?

class TextbookEstimatesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $textbookEstimatesKey;
	var $textbookEstimatesName;

	var $__attributes = array( 
	'textbookEstimatesKey'=>'integer',
	'textbookEstimatesName'=>'varchar');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->textbookEstimatesKey;
	}


	function setPrimaryKey($val) {
		$this->textbookEstimatesKey = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(TextbookEstimatesPeer::doInsert($this,$dsn));
		} else {
			TextbookEstimatesPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "textbook_estimates_key='".$key."'";
		}
		$array = TextbookEstimatesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = TextbookEstimatesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		TextbookEstimatesPeer::doDelete($this,$deep,$dsn);
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


class TextbookEstimatesPeerBase {

	var $tableName = 'textbook_estimates';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("textbook_estimates",$where);
		$st->fields['textbook_estimates_key'] = 'textbook_estimates_key';
		$st->fields['textbook_estimates_name'] = 'textbook_estimates_name';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = TextbookEstimatesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("textbook_estimates");
		$st->fields['textbook_estimates_key'] = $this->textbookEstimatesKey;
		$st->fields['textbook_estimates_name'] = $this->textbookEstimatesName;


		$st->key = 'textbook_estimates_key';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("textbook_estimates");
		$st->fields['textbook_estimates_key'] = $obj->textbookEstimatesKey;
		$st->fields['textbook_estimates_name'] = $obj->textbookEstimatesName;


		$st->key = 'textbook_estimates_key';
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
		$st = new PBDO_DeleteStatement("textbook_estimates","textbook_estimates_key = '".$obj->getPrimaryKey()."'");

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
		$x = new TextbookEstimates();
		$x->textbookEstimatesKey = $row['textbook_estimates_key'];
		$x->textbookEstimatesName = $row['textbook_estimates_name'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class TextbookEstimates extends TextbookEstimatesBase {



}



class TextbookEstimatesPeer extends TextbookEstimatesPeerBase {

}

?>