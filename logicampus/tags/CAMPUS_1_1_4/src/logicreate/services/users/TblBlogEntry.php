<?

class TblBlogEntryBase {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = '1.3';	//PBDO version number
	var $_entityVersion = '0.0';	//Source version number
	var $blogEntryId;
	var $blogId;
	var $blogParentId;
	var $blogEntryTitle;
	var $blogEntryDescription;
	var $blogEntryText;
	var $blogEntryTimedate;
	var $blogEntryPosterId;
	var $blogEntryPosterEmail;
	var $blogEntryPosterNotify;
	var $blogEntryPosterUrl;

	var $__attributes = array(
	'blogEntryId'=>'integer',
	'blogId'=>'TblBlog',
	'blogParentId'=>'TblBlogEntry',
	'blogEntryTitle'=>'varchar',
	'blogEntryDescription'=>'varchar',
	'blogEntryText'=>'text',
	'blogEntryTimedate'=>'int',
	'blogEntryPosterId'=>'varchar',
	'blogEntryPosterEmail'=>'varchar',
	'blogEntryPosterNotify'=>'char',
	'blogEntryPosterUrl'=>'varchar');

	function getTblBlogEntrys() {
		$array = TblBlogEntryPeer::doSelect('blog_parent_id = \''.$this->getPrimaryKey().'\'');
		return $array;
	}

	function getTblBlogEntry() {
		if ( $this->blogId == '' ) { trigger_error('Peer doSelect with empty key'); return false; }
		$array = TblBlogEntryPeer::doSelect('blog_id = \''.$this->blogParentId.'\'');
		if ( count($array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }
		return $array[0];
	}



	function getPrimaryKey() {
		return $this->blogEntryId;
	}

	function setPrimaryKey($val) {
		$this->blogEntryId = $val;
	}
	
	function save() {
		if ( $this->isNew() ) {
			$this->setPrimaryKey(TblBlogEntryPeer::doInsert($this));
		} else {
			TblBlogEntryPeer::doUpdate($this);
		}
	}

	function load($key) {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k='$v' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "blog_entry_id='".$key."'";
		}
		$array = TblBlogEntryPeer::doSelect($where);
		return $array[0];
	}

	function delete($deep=false) {
		TblBlogEntryPeer::doDelete($this,$deep);
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
		if ($array['blogParentId'])
			$this->blogParentId = $array['blogParentId'];
		if ($array['blogEntryTitle'])
			$this->blogEntryTitle = $array['blogEntryTitle'];
		if ($array['blogEntryDescription'])
			$this->blogEntryDescription = $array['blogEntryDescription'];
		if ($array['blogEntryText'])
			$this->blogEntryText = $array['blogEntryText'];
		if ($array['blogEntryTimedate'])
			$this->blogEntryTimedate = $array['blogEntryTimedate'];
		if ($array['blogEntryPosterId'])
			$this->blogEntryPosterId = $array['blogEntryPosterId'];
		if ($array['blogEntryPosterEmail'])
			$this->blogEntryPosterEmail = $array['blogEntryPosterEmail'];
		if ($array['blogEntryPosterNotify'])
			$this->blogEntryPosterNotify = $array['blogEntryPosterNotify'];
		if ($array['blogEntryPosterUrl'])
			$this->blogEntryPosterUrl = $array['blogEntryPosterUrl'];

		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class TblBlogEntryPeerBase {

	var $tableName = 'tbl_blog_entry';

	function doSelect($where) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_SelectStatement("tbl_blog_entry",$where);
		$st->fields['blog_entry_id'] = 'blog_entry_id';
		$st->fields['blog_id'] = 'blog_id';
		$st->fields['blog_parent_id'] = 'blog_parent_id';
		$st->fields['blog_entry_title'] = 'blog_entry_title';
		$st->fields['blog_entry_description'] = 'blog_entry_description';
		$st->fields['blog_entry_text'] = 'blog_entry_text';
		$st->fields['blog_entry_timedate'] = 'blog_entry_timedate';
		$st->fields['blog_entry_poster_id'] = 'blog_entry_poster_id';
		$st->fields['blog_entry_poster_email'] = 'blog_entry_poster_email';
		$st->fields['blog_entry_poster_notify'] = 'blog_entry_poster_notify';
		$st->fields['blog_entry_poster_url'] = 'blog_entry_poster_url';

		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = TblBlogEntryPeer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_InsertStatement("tbl_blog_entry");
		$st->fields['blog_entry_id'] = $this->blogEntryId;
		$st->fields['blog_id'] = $this->blogId;
		$st->fields['blog_parent_id'] = $this->blogParentId;
		$st->fields['blog_entry_title'] = $this->blogEntryTitle;
		$st->fields['blog_entry_description'] = $this->blogEntryDescription;
		$st->fields['blog_entry_text'] = $this->blogEntryText;
		$st->fields['blog_entry_timedate'] = $this->blogEntryTimedate;
		$st->fields['blog_entry_poster_id'] = $this->blogEntryPosterId;
		$st->fields['blog_entry_poster_email'] = $this->blogEntryPosterEmail;
		$st->fields['blog_entry_poster_notify'] = $this->blogEntryPosterNotify;
		$st->fields['blog_entry_poster_url'] = $this->blogEntryPosterUrl;

		$st->key = 'blog_entry_id';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj) {
		//use this tableName
		$db = lcDB::getHandle();
		$st = new LC_UpdateStatement("tbl_blog_entry");
		$st->fields['blog_entry_id'] = $obj->blogEntryId;
		$st->fields['blog_id'] = $obj->blogId;
		$st->fields['blog_parent_id'] = $obj->blogParentId;
		$st->fields['blog_entry_title'] = $obj->blogEntryTitle;
		$st->fields['blog_entry_description'] = $obj->blogEntryDescription;
		$st->fields['blog_entry_text'] = $obj->blogEntryText;
		$st->fields['blog_entry_timedate'] = $obj->blogEntryTimedate;
		$st->fields['blog_entry_poster_id'] = $obj->blogEntryPosterId;
		$st->fields['blog_entry_poster_email'] = $obj->blogEntryPosterEmail;
		$st->fields['blog_entry_poster_notify'] = $obj->blogEntryPosterNotify;
		$st->fields['blog_entry_poster_url'] = $obj->blogEntryPosterUrl;

		$st->key = 'blog_entry_id';
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
		$st = new LC_DeleteStatement("tbl_blog_entry","blog_entry_id = '".$obj->getPrimaryKey()."'");

		$db->executeQuery($st);

		if ( $deep ) {

			$st = new LC_DeleteStatement("tbl_blog_entry","blog_entry_id = '".$obj->getPrimaryKey()."'");
			$db->executeQuery($st);
		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function row2Obj($row) {
		$x = new TblBlogEntry();
		$x->blogEntryId = $row['blog_entry_id'];
		$x->blogId = $row['blog_id'];
		$x->blogParentId = $row['blog_parent_id'];
		$x->blogEntryTitle = $row['blog_entry_title'];
		$x->blogEntryDescription = $row['blog_entry_description'];
		$x->blogEntryText = $row['blog_entry_text'];
		$x->blogEntryTimedate = $row['blog_entry_timedate'];
		$x->blogEntryPosterId = $row['blog_entry_poster_id'];
		$x->blogEntryPosterEmail = $row['blog_entry_poster_email'];
		$x->blogEntryPosterNotify = $row['blog_entry_poster_notify'];
		$x->blogEntryPosterUrl = $row['blog_entry_poster_url'];

		$x->_new = false;
		return $x;
	}

}


//You can edit this class, but do not change this next line!
class TblBlogEntry extends TblBlogEntryBase {



}



class TblBlogEntryPeer extends TblBlogEntryPeerBase {

}

?>