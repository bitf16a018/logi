<?

class HelpdeskCategoryBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $helpdeskCategoryId;
	var $helpdeskCategoryLabel;

	var $__attributes = array(
	'helpdeskCategoryId'=>'integer',
	'helpdeskCategoryLabel'=>'varchar');



	function getPrimaryKey() {
		return $this->helpdeskCategoryId;
	}

	function setPrimaryKey($val) {
		$this->helpdeskCategoryId = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(HelpdeskCategoryPeer::doInsert($this));
		} else {
			HelpdeskCategoryPeer::doUpdate($this);
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
			$where = "helpdesk_category_id='".$key."'";
		}
		$array = HelpdeskCategoryPeer::doSelect($where);
		return $array[0];
	}

	function loadAll($key) {
		$array = HelpdeskCategoryPeer::doSelect($where);
		return $array;
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
		if ($array['helpdeskCategoryLabel'])
			$this->helpdeskCategoryLabel = $array['helpdeskCategoryLabel'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class HelpdeskCategoryPeer {

	var $tableName = 'helpdesk_categories';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("helpdesk_categories",$where);
		$st->fields['helpdesk_category_id'] = 'helpdesk_category_id';
		$st->fields['helpdesk_category_label'] = 'helpdesk_category_label';

		$st->key = $this->key;

		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$x = HelpdeskCategoryPeer::row2Obj($db->record);
			$array[$x->helpdeskCategoryId] = $x;
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("helpdesk_categories");
		$st->fields['helpdesk_category_id'] = $this->helpdeskCategoryId;
		$st->fields['helpdesk_category_label'] = $this->helpdeskCategoryLabel;

		$st->key = 'helpdesk_category_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("helpdesk_categories");
		$st->fields['helpdesk_category_id'] = $obj->helpdeskCategoryId;
		$st->fields['helpdesk_category_label'] = $obj->helpdeskCategoryLabel;

		$st->key = 'helpdesk_category_id';
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
		$st = new LC_DeleteStatement("helpdesk_categories","helpdesk_category_id = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( !$shallow ) {

		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new HelpdeskCategory();
		$x->helpdeskCategoryId = $row['helpdesk_category_id'];
		$x->helpdeskCategoryLabel = $row['helpdesk_category_label'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class HelpdeskCategory extends HelpdeskCategoryBase {



}

?>
