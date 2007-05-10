<?

include_once(LIB_PATH."LC_sql.php");

class lcHtml extends PersistantObject {

	function _save($table="lcHtml") {
		$db = DB::getHandle();
		$sql = "filename='".addslashes($this->filename)."',title='".addslashes($this->title)."',";
		$sql .= "author='".addslashes($this->author)."',keywords='".addslashes($this->keywords)."',";
		$sql .= "updated=".time().",description='".addslashes($this->description)."',other='".addslashes($this->other)."',";
		if (  is_array($this->groups) ) {
			$this->groups = join("|",$this->groups);
		}
		if (  is_array($this->notgroups) ) {
			$this->notgroups = join("|",$this->notgroups);
		}

		$sql .= "groups='|$this->groups|',notgroups='|$this->notgroups|'";

		$db->query("insert into $table SET $sql");

		//save content into file
		$file = stripslashes($this->file);
		$f = fopen(CONTENT_PATH."$this->filename","w+");
		$s = fwrite($f,$file,50000000);
		fclose($f);
	}


	function _update($table="lcHtml") {
		$db = DB::getHandle();
		$sql = "filename='".addslashes($this->filename)."',title='".addslashes($this->title)."',";
		$sql .= "author='".addslashes($this->author)."',keywords='".addslashes($this->keywords)."',";
		$sql .= "updated=".time().",description='".addslashes($this->description)."',other='".addslashes($this->other)."',";
 		if (is_array($this->groups) ) {
                	$this->groups = join("|",$this->groups);
			$this->groups = '|'.$this->groups.'|';
			$this->groups = str_replace('||','|',$this->groups);
		}
		if (  is_array($this->notgroups) ) {
			$this->notgroups = join("|",$this->notgroups);
			$this->notgroups = '|'.$this->notgroups.'|';
			$this->notgroups = str_replace('||','|',$this->notgroups);
		}

		$sql .= "groups='$this->groups',notgroups='$this->notgroups'";

		$db->query("update $table SET $sql where pkey = $this->pkey");

		//save content into file
		$file = stripslashes($this->file);
		$f = fopen(CONTENT_PATH.$this->filename,"w+");
		$s = fwrite($f,$file,strlen($file));
		fclose($f);
	}

	function _load($id) {
		$obj = PersistantObject::_load("lcHtml","lcHtml",$id);
		$f = fopen(CONTENT_PATH.$obj->filename,"r");
		$obj->file = fread($f,filesize(CONTENT_PATH.$obj->filename));
		fclose($f);
		$obj->file = str_replace("<","&lt;",$obj->file);
	return $obj;
	}


	function _delete($id) {
		$obj = PersistantObject::_load("lcHtml","lcHtml",$id);
		if ( ! rename(CONTENT_PATH.$obj->filename,CONTENT_PATH.$obj->filename.".unlink") ) {
			unlink(CONTENT_PATH.$obj->filename.".unlink");
			rename(CONTENT_PATH.$obj->filename,CONTENT_PATH.$obj->filename.".unlink");
		}
		PersistantObject::_delete("lcHtml",$id);
	}	
}
?>
