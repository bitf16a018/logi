<?

class TextbookClassesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idTextbookClasses;
	var $idClasses;
	var $author;
	var $title;
	var $publisher;
	var $edition;
	var $copyright;
	var $isbn;
	var $required;
	var $bundled;
	var $bundledItems;
	var $type;
	var $status;
	var $note;

	var $__attributes = array( 
	'idTextbookClasses'=>'integer',
	'idClasses'=>'bigint',
	'author'=>'varchar',
	'title'=>'varchar',
	'publisher'=>'varchar',
	'edition'=>'varchar',
	'copyright'=>'year',
	'isbn'=>'varchar',
	'required'=>'integer',
	'bundled'=>'integer',
	'bundledItems'=>'longvarchar',
	'type'=>'varchar',
	'status'=>'tinyint',
	'note'=>'longvarchar');

	var $__nulls = array( 
	'edition'=>'edition',
	'copyright'=>'copyright',
	'required'=>'required',
	'bundled'=>'bundled',
	'bundledItems'=>'bundledItems',
	'note'=>'note');



	function getPrimaryKey() {
		return $this->idTextbookClasses;
	}


	function setPrimaryKey($val) {
		$this->idTextbookClasses = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(TextbookClassesPeer::doInsert($this,$dsn));
		} else {
			TextbookClassesPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_textbook_classes='".$key."'";
		}
		$array = TextbookClassesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = TextbookClassesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		TextbookClassesPeer::doDelete($this,$deep,$dsn);
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


class TextbookClassesPeerBase {

	var $tableName = 'textbook_classes';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("textbook_classes",$where);
		$st->fields['id_textbook_classes'] = 'id_textbook_classes';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['author'] = 'author';
		$st->fields['title'] = 'title';
		$st->fields['publisher'] = 'publisher';
		$st->fields['edition'] = 'edition';
		$st->fields['copyright'] = 'copyright';
		$st->fields['isbn'] = 'isbn';
		$st->fields['required'] = 'required';
		$st->fields['bundled'] = 'bundled';
		$st->fields['bundled_items'] = 'bundled_items';
		$st->fields['type'] = 'type';
		$st->fields['status'] = 'status';
		$st->fields['note'] = 'note';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = TextbookClassesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("textbook_classes");
		$st->fields['id_textbook_classes'] = $this->idTextbookClasses;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['author'] = $this->author;
		$st->fields['title'] = $this->title;
		$st->fields['publisher'] = $this->publisher;
		$st->fields['edition'] = $this->edition;
		$st->fields['copyright'] = $this->copyright;
		$st->fields['isbn'] = $this->isbn;
		$st->fields['required'] = $this->required;
		$st->fields['bundled'] = $this->bundled;
		$st->fields['bundled_items'] = $this->bundledItems;
		$st->fields['type'] = $this->type;
		$st->fields['status'] = $this->status;
		$st->fields['note'] = $this->note;

		$st->nulls['edition'] = 'edition';
		$st->nulls['copyright'] = 'copyright';
		$st->nulls['required'] = 'required';
		$st->nulls['bundled'] = 'bundled';
		$st->nulls['bundled_items'] = 'bundled_items';
		$st->nulls['note'] = 'note';

		$st->key = 'id_textbook_classes';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("textbook_classes");
		$st->fields['id_textbook_classes'] = $obj->idTextbookClasses;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['author'] = $obj->author;
		$st->fields['title'] = $obj->title;
		$st->fields['publisher'] = $obj->publisher;
		$st->fields['edition'] = $obj->edition;
		$st->fields['copyright'] = $obj->copyright;
		$st->fields['isbn'] = $obj->isbn;
		$st->fields['required'] = $obj->required;
		$st->fields['bundled'] = $obj->bundled;
		$st->fields['bundled_items'] = $obj->bundledItems;
		$st->fields['type'] = $obj->type;
		$st->fields['status'] = $obj->status;
		$st->fields['note'] = $obj->note;

		$st->nulls['edition'] = 'edition';
		$st->nulls['copyright'] = 'copyright';
		$st->nulls['required'] = 'required';
		$st->nulls['bundled'] = 'bundled';
		$st->nulls['bundled_items'] = 'bundled_items';
		$st->nulls['note'] = 'note';

		$st->key = 'id_textbook_classes';
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
		$st = new PBDO_DeleteStatement("textbook_classes","id_textbook_classes = '".$obj->getPrimaryKey()."'");

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
		$x = new TextbookClasses();
		$x->idTextbookClasses = $row['id_textbook_classes'];
		$x->idClasses = $row['id_classes'];
		$x->author = $row['author'];
		$x->title = $row['title'];
		$x->publisher = $row['publisher'];
		$x->edition = $row['edition'];
		$x->copyright = $row['copyright'];
		$x->isbn = $row['isbn'];
		$x->required = $row['required'];
		$x->bundled = $row['bundled'];
		$x->bundledItems = $row['bundled_items'];
		$x->type = $row['type'];
		$x->status = $row['status'];
		$x->note = $row['note'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class TextbookClasses extends TextbookClassesBase {

	# Finds all user accounts in system in the seminar
	# manager group and emails them.
	function  mailAdmin($msg) {
		$db = DB::getHandle();
		$sql = "SELECT email FROM lcUsers where groups LIKE
		'%|tbadmin|%'";
		$db->query($sql);
		while($db->next_record() )
		{
			$emailTo .= $db->Record['email'].',';	
		}
		$emailTo = substr($emailTo, 0, -1);
		mail($emailTo, "Textbook Added / Modifed", $msg, "From: ".WEBMASTER_EMAIL."\r\n");
	}


	function getStatus($x) {
		switch($x) {
			case 1;
			return 'New';

			case 0;
			return 'N/A';

			case 2;
			return 'Pending';

			case 3;
			return 'Approved';

			case 4;
			return 'Waiting on Instructor';
			
			default:
			return 'N/A';
		}
			
	}
	

	function printyesno($x) {
		if ($x)
		{
			return 'Yes';
		}
		return 'No';
	}
}



class TextbookClassesPeer extends TextbookClassesPeerBase {

}

?>
