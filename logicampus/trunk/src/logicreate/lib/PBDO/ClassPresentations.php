<?

class ClassPresentationsBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idPresentations;
	var $idClasses;
	var $title;
	var $lesson;
	var $status;
	var $author;
	var $createdOn;
	var $approvedOn;
	var $content;

	var $__attributes = array( 
	'idPresentations'=>'integer',
	'idClasses'=>'integer',
	'title'=>'varchar',
	'lesson'=>'integer',
	'status'=>'tinyint',
	'author'=>'varchar',
	'createdOn'=>'datetime',
	'approvedOn'=>'datetime',
	'content'=>'longvarchar');

	var $__nulls = array( 
	'idClasses'=>'idClasses',
	'title'=>'title',
	'lesson'=>'lesson',
	'status'=>'status',
	'author'=>'author',
	'createdOn'=>'createdOn',
	'approvedOn'=>'approvedOn',
	'content'=>'content');



	function getPrimaryKey() {
		return $this->idPresentations;
	}


	function setPrimaryKey($val) {
		$this->idPresentations = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassPresentationsPeer::doInsert($this,$dsn));
		} else {
			ClassPresentationsPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_presentations='".$key."'";
		}
		$array = ClassPresentationsPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassPresentationsPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassPresentationsPeer::doDelete($this,$deep,$dsn);
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


class ClassPresentationsPeerBase {

	var $tableName = 'class_presentations';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_presentations",$where);
		$st->fields['id_presentations'] = 'id_presentations';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['title'] = 'title';
		$st->fields['lesson'] = 'lesson';
		$st->fields['status'] = 'status';
		$st->fields['author'] = 'author';
		$st->fields['createdOn'] = 'createdOn';
		$st->fields['approvedOn'] = 'approvedOn';
		$st->fields['content'] = 'content';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassPresentationsPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_presentations");
		$st->fields['id_presentations'] = $this->idPresentations;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['title'] = $this->title;
		$st->fields['lesson'] = $this->lesson;
		$st->fields['status'] = $this->status;
		$st->fields['author'] = $this->author;
		$st->fields['createdOn'] = $this->createdOn;
		$st->fields['approvedOn'] = $this->approvedOn;
		$st->fields['content'] = $this->content;

		$st->nulls['id_classes'] = 'id_classes';
		$st->nulls['title'] = 'title';
		$st->nulls['lesson'] = 'lesson';
		$st->nulls['status'] = 'status';
		$st->nulls['author'] = 'author';
		$st->nulls['createdOn'] = 'createdOn';
		$st->nulls['approvedOn'] = 'approvedOn';
		$st->nulls['content'] = 'content';

		$st->key = 'id_presentations';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_presentations");
		$st->fields['id_presentations'] = $obj->idPresentations;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['title'] = $obj->title;
		$st->fields['lesson'] = $obj->lesson;
		$st->fields['status'] = $obj->status;
		$st->fields['author'] = $obj->author;
		$st->fields['createdOn'] = $obj->createdOn;
		$st->fields['approvedOn'] = $obj->approvedOn;
		$st->fields['content'] = $obj->content;

		$st->nulls['id_classes'] = 'id_classes';
		$st->nulls['title'] = 'title';
		$st->nulls['lesson'] = 'lesson';
		$st->nulls['status'] = 'status';
		$st->nulls['author'] = 'author';
		$st->nulls['createdOn'] = 'createdOn';
		$st->nulls['approvedOn'] = 'approvedOn';
		$st->nulls['content'] = 'content';

		$st->key = 'id_presentations';
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
		$st = new PBDO_DeleteStatement("class_presentations","id_presentations = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassPresentations();
		$x->idPresentations = $row['id_presentations'];
		$x->idClasses = $row['id_classes'];
		$x->title = $row['title'];
		$x->lesson = $row['lesson'];
		$x->status = $row['status'];
		$x->author = $row['author'];
		$x->createdOn = $row['createdOn'];
		$x->approvedOn = $row['approvedOn'];
		$x->content = $row['content'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassPresentations extends ClassPresentationsBase {



}



class ClassPresentationsPeer extends ClassPresentationsPeerBase {

}

?>