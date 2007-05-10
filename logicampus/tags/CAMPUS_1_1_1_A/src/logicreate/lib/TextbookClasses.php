<?

class TextbookClassesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
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
	'idTextbookClasses'=>'int',
	'idClasses'=>'bigint',
	'author'=>'varchar',
	'title'=>'varchar',
	'publisher'=>'varchar',
	'edition'=>'varchar',
	'copyright'=>'year',
	'isbn'=>'varchar',
	'required'=>'int',
	'bundled'=>'int',
	'bundledItems'=>'text',
	'type'=>'varchar',
	'status'=>'tinyint',
	'note'=>'text');



	function getPrimaryKey() {
		return $this->idTextbookClasses;
	}

	function setPrimaryKey($val) {
		$this->idTextbookClasses = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(TextbookClassesPeer::doInsert($this));
		} else {
			TextbookClassesPeer::doUpdate($this);
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
			$where = "id_textbook_classes='".$key."'";
		}
		$array = TextbookClassesPeer::doSelect($where);
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
		if ($array['author'])
			$this->author = $array['author'];
		if ($array['title'])
			$this->title = $array['title'];
		if ($array['publisher'])
			$this->publisher = $array['publisher'];
		if ($array['edition'])
			$this->edition = $array['edition'];
		if ($array['copyright'])
			$this->copyright = $array['copyright'];
		if ($array['isbn'])
			$this->isbn = $array['isbn'];
		if ($array['required'])
			$this->required = $array['required'];
		if ($array['bundled'])
			$this->bundled = $array['bundled'];
		if ($array['bundledItems'])
			$this->bundledItems = $array['bundledItems'];
		if ($array['type'])
			$this->type = $array['type'];
		if ($array['status'])
			$this->status = $array['status'];
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


class TextbookClassesPeer {

	var $tableName = 'textbook_classes';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("textbook_classes",$where);
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

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = TextbookClassesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("textbook_classes");
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

		$st->key = 'id_textbook_classes';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("textbook_classes");
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

		$st->key = 'id_textbook_classes';
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
		$st = new LC_DeleteStatement("textbook_classes","id_textbook_classes = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

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
	function  mailAdmin($msg)
	{
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
			return 'Waiting on Instructor';
			
			default:
			return 'N/A';
		}
			
	}
	
function printyesno($x)
{
	if ($x)
	{
		return 'Yes';
	}
	return 'No';
}


?>
