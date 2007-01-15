<?

class HelpdeskCategoriesBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.6';	//PBDO version number
	var $_entityVersion = '';	//Source version number
	var $helpdeskCategoryId;
	var $helpdeskCategoryLabel;

	var $__attributes = array( 
	'helpdeskCategoryId'=>'integer',
	'helpdeskCategoryLabel'=>'varchar');

	var $__nulls = array();



	function getPrimaryKey() {
		return $this->helpdeskCategoryId;
	}


	function setPrimaryKey($val) {
		$this->helpdeskCategoryId = $val;
	}


	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(HelpdeskCategoriesPeer::doInsert($this,$dsn));
		} else {
			HelpdeskCategoriesPeer::doUpdate($this,$dsn);
		}
	}


	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "helpdesk_category_id='".$key."'";
		}
		$array = HelpdeskCategoriesPeer::doSelect($where,$dsn);
		return $array[0];
	}


	function loadAll($dsn="default") {
		$array = HelpdeskCategoriesPeer::doSelect('',$dsn);
		return $array;
	}


	function delete($deep=false,$dsn="default") {
		HelpdeskCategoriesPeer::doDelete($this,$deep,$dsn);
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


class HelpdeskCategoriesPeerBase {

	var $tableName = 'helpdesk_categories';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_SelectStatement("helpdesk_categories",$where);
		$st->fields['helpdesk_category_id'] = 'helpdesk_category_id';
		$st->fields['helpdesk_category_label'] = 'helpdesk_category_label';


		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = HelpdeskCategoriesPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_InsertStatement("helpdesk_categories");
		$st->fields['helpdesk_category_id'] = $this->helpdeskCategoryId;
		$st->fields['helpdesk_category_label'] = $this->helpdeskCategoryLabel;


		$st->key = 'helpdesk_category_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = DB::getHandle($dsn);
		$st = new PBDO_UpdateStatement("helpdesk_categories");
		$st->fields['helpdesk_category_id'] = $obj->helpdeskCategoryId;
		$st->fields['helpdesk_category_label'] = $obj->helpdeskCategoryLabel;


		$st->key = 'helpdesk_category_id';
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
		$st = new PBDO_DeleteStatement("helpdesk_categories","helpdesk_category_id = '".$obj->getPrimaryKey()."'");

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
		$x = new HelpdeskCategories();
		$x->helpdeskCategoryId = $row['helpdesk_category_id'];
		$x->helpdeskCategoryLabel = $row['helpdesk_category_label'];

		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class HelpdeskCategories extends HelpdeskCategoriesBase {



}



class HelpdeskCategoriesPeer extends HelpdeskCategoriesPeerBase {

}

?>