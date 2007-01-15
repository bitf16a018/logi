<?

class ClassGradebookValBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idClassGradebookVal;
	var $idClassGradebookEntries;
	var $idClasses;
	var $username;
	var $score;
	var $comments;
	var $dateCreated;
	var $dateModified;

	var $__attributes = array( 
	'idClassGradebookVal'=>'integer',
	'idClassGradebookEntries'=>'integer',
	'idClasses'=>'integer',
	'username'=>'varchar',
	'score'=>'float',
	'comments'=>'longvarchar',
	'dateCreated'=>'integer',
	'dateModified'=>'integer');

	var $__nulls = array( 
	'score'=>'score',
	'comments'=>'comments');



	function getPrimaryKey() {
		return $this->idClassGradebookVal;
	}


	function setPrimaryKey($val) {
		$this->idClassGradebookVal = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassGradebookValPeer::doInsert($this,$dsn));
		} else {
			ClassGradebookValPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_gradebook_val='".$key."'";
		}
		$array = ClassGradebookValPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassGradebookValPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassGradebookValPeer::doDelete($this,$deep,$dsn);
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


class ClassGradebookValPeerBase {

	var $tableName = 'class_gradebook_val';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_gradebook_val",$where);
		$st->fields['id_class_gradebook_val'] = 'id_class_gradebook_val';
		$st->fields['id_class_gradebook_entries'] = 'id_class_gradebook_entries';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['username'] = 'username';
		$st->fields['score'] = 'score';
		$st->fields['comments'] = 'comments';
		$st->fields['date_created'] = 'date_created';
		$st->fields['date_modified'] = 'date_modified';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassGradebookValPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_gradebook_val");
		$st->fields['id_class_gradebook_val'] = $this->idClassGradebookVal;
		$st->fields['id_class_gradebook_entries'] = $this->idClassGradebookEntries;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['username'] = $this->username;
		$st->fields['score'] = $this->score;
		$st->fields['comments'] = $this->comments;
		$st->fields['date_created'] = $this->dateCreated;
		$st->fields['date_modified'] = $this->dateModified;

		$st->nulls['score'] = 'score';
		$st->nulls['comments'] = 'comments';

		$st->key = 'id_class_gradebook_val';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_gradebook_val");
		$st->fields['id_class_gradebook_val'] = $obj->idClassGradebookVal;
		$st->fields['id_class_gradebook_entries'] = $obj->idClassGradebookEntries;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['username'] = $obj->username;
		$st->fields['score'] = $obj->score;
		$st->fields['comments'] = $obj->comments;
		$st->fields['date_created'] = $obj->dateCreated;
		$st->fields['date_modified'] = $obj->dateModified;

		$st->nulls['score'] = 'score';
		$st->nulls['comments'] = 'comments';

		$st->key = 'id_class_gradebook_val';
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
		$st = new PBDO_DeleteStatement("class_gradebook_val","id_class_gradebook_val = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassGradebookVal();
		$x->idClassGradebookVal = $row['id_class_gradebook_val'];
		$x->idClassGradebookEntries = $row['id_class_gradebook_entries'];
		$x->idClasses = $row['id_classes'];
		$x->username = $row['username'];
		$x->score = $row['score'];
		$x->comments = $row['comments'];
		$x->dateCreated = $row['date_created'];
		$x->dateModified = $row['date_modified'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassGradebookVal extends ClassGradebookValBase {



}



class ClassGradebookValPeer extends ClassGradebookValPeerBase {

}

?>