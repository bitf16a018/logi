<?

class ClassFaqsBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $idClassFaqs;
	var $idClasses;
	var $category;
	var $question;
	var $answer;
	var $clicks;
	var $groups;

	var $__attributes = array( 
	'idClassFaqs'=>'integer',
	'idClasses'=>'integer',
	'category'=>'varchar',
	'question'=>'varchar',
	'answer'=>'longvarchar',
	'clicks'=>'integer',
	'groups'=>'longvarchar');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->idClassFaqs;
	}


	function setPrimaryKey($val) {
		$this->idClassFaqs = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(ClassFaqsPeer::doInsert($this,$dsn));
		} else {
			ClassFaqsPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "id_class_faqs='".$key."'";
		}
		$array = ClassFaqsPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = ClassFaqsPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		ClassFaqsPeer::doDelete($this,$deep,$dsn);
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


class ClassFaqsPeerBase {

	var $tableName = 'class_faqs';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("class_faqs",$where);
		$st->fields['id_class_faqs'] = 'id_class_faqs';
		$st->fields['id_classes'] = 'id_classes';
		$st->fields['category'] = 'category';
		$st->fields['question'] = 'question';
		$st->fields['answer'] = 'answer';
		$st->fields['clicks'] = 'clicks';
		$st->fields['groups'] = 'groups';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = ClassFaqsPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("class_faqs");
		$st->fields['id_class_faqs'] = $this->idClassFaqs;
		$st->fields['id_classes'] = $this->idClasses;
		$st->fields['category'] = $this->category;
		$st->fields['question'] = $this->question;
		$st->fields['answer'] = $this->answer;
		$st->fields['clicks'] = $this->clicks;
		$st->fields['groups'] = $this->groups;


		$st->key = 'id_class_faqs';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("class_faqs");
		$st->fields['id_class_faqs'] = $obj->idClassFaqs;
		$st->fields['id_classes'] = $obj->idClasses;
		$st->fields['category'] = $obj->category;
		$st->fields['question'] = $obj->question;
		$st->fields['answer'] = $obj->answer;
		$st->fields['clicks'] = $obj->clicks;
		$st->fields['groups'] = $obj->groups;


		$st->key = 'id_class_faqs';
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
		$st = new PBDO_DeleteStatement("class_faqs","id_class_faqs = '".$obj->getPrimaryKey()."'");

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
		$x = new ClassFaqs();
		$x->idClassFaqs = $row['id_class_faqs'];
		$x->idClasses = $row['id_classes'];
		$x->category = $row['category'];
		$x->question = $row['question'];
		$x->answer = $row['answer'];
		$x->clicks = $row['clicks'];
		$x->groups = $row['groups'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class ClassFaqs extends ClassFaqsBase {



}



class ClassFaqsPeer extends ClassFaqsPeerBase {

}

?>