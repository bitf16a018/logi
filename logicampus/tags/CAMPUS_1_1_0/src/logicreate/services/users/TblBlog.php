<?

class TblBlogBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.3';	//PBDO version number
	var $_entityVersion = '0.0';	//Source version number
	var $blogId;
	var $blogName;
	var $blogDescription;
	var $blogOwner;
	var $blogEmailNotify;
	var $blogAllowViewing;
	var $blogAllowPosting;

	var $__attributes = array(
	'blogId'=>'integer',
	'blogName'=>'varchar',
	'blogDescription'=>'varchar',
	'blogOwner'=>'varchar',
	'blogEmailNotify'=>'varchar',
	'blogAllowViewing'=>'char',
	'blogAllowPosting'=>'char');

	function getTblBlogEntrys() {
		$array = TblBlogEntryPeer::doSelect('blog_id = \''.$this->getPrimaryKey().'\'');
		return $array;
	}



	function getPrimaryKey() {
		return $this->blogId;
	}

	function setPrimaryKey($val) {
		$this->blogId = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(TblBlogPeer::doInsert($this));
		} else {
			TblBlogPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "blog_id='".$key."'";
		}
		$array = TblBlogPeer::doSelect($where);
		return $array[0];
	}

	function delete($deep=false) {
		TblBlogPeer::doDelete($this,$deep);
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
		if ($array['blogName'])
			$this->blogName = $array['blogName'];
		if ($array['blogDescription'])
			$this->blogDescription = $array['blogDescription'];
		if ($array['blogOwner'])
			$this->blogOwner = $array['blogOwner'];
		if ($array['blogEmailNotify'])
			$this->blogEmailNotify = $array['blogEmailNotify'];
		if ($array['blogAllowViewing'])
			$this->blogAllowViewing = $array['blogAllowViewing'];
		if ($array['blogAllowPosting'])
			$this->blogAllowPosting = $array['blogAllowPosting'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class TblBlogPeerBase {

	var $tableName = 'tbl_blog';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("tbl_blog",$where);
		$st->fields['blog_id'] = 'blog_id';
		$st->fields['blog_name'] = 'blog_name';
		$st->fields['blog_description'] = 'blog_description';
		$st->fields['blog_owner'] = 'blog_owner';
		$st->fields['blog_email_notify'] = 'blog_email_notify';
		$st->fields['blog_allow_viewing'] = 'blog_allow_viewing';
		$st->fields['blog_allow_posting'] = 'blog_allow_posting';

		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = TblBlogPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("tbl_blog");
		$st->fields['blog_id'] = $this->blogId;
		$st->fields['blog_name'] = $this->blogName;
		$st->fields['blog_description'] = $this->blogDescription;
		$st->fields['blog_owner'] = $this->blogOwner;
		$st->fields['blog_email_notify'] = $this->blogEmailNotify;
		$st->fields['blog_allow_viewing'] = $this->blogAllowViewing;
		$st->fields['blog_allow_posting'] = $this->blogAllowPosting;

		$st->key = 'blog_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("tbl_blog");
		$st->fields['blog_id'] = $obj->blogId;
		$st->fields['blog_name'] = $obj->blogName;
		$st->fields['blog_description'] = $obj->blogDescription;
		$st->fields['blog_owner'] = $obj->blogOwner;
		$st->fields['blog_email_notify'] = $obj->blogEmailNotify;
		$st->fields['blog_allow_viewing'] = $obj->blogAllowViewing;
		$st->fields['blog_allow_posting'] = $obj->blogAllowPosting;

		$st->key = 'blog_id';
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



	function doDelete(&$obj,$deep=false) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_DeleteStatement("tbl_blog","blog_id = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( $deep ) {

			$st = new LC_DeleteStatement("tbl_blog_entry","blog_id = '".$obj->getPrimaryKey()."'");
			$db->executeQuery($st);
		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new TblBlog();
		$x->blogId = $row['blog_id'];
		$x->blogName = $row['blog_name'];
		$x->blogDescription = $row['blog_description'];
		$x->blogOwner = $row['blog_owner'];
		$x->blogEmailNotify = $row['blog_email_notify'];
		$x->blogAllowViewing = $row['blog_allow_viewing'];
		$x->blogAllowPosting = $row['blog_allow_posting'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class TblBlog extends TblBlogBase {



}



class TblBlogPeer extends TblBlogPeerBase {

}

?>