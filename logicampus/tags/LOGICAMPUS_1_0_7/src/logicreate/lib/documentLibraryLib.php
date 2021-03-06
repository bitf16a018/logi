<?
/*************************************************** 
 *
 * This file is under the LogiCreate Public License
 *
 * A copy of the license is in your LC distribution
 * called license.txt.  If you are missing this
 * file you can obtain the latest version from
 * http://logicreate.com/license.html
 *
 * LogiCreate is copyright by Tap Internet, Inc.
 * http://www.tapinternet.com/
 ***************************************************/


include_once(LIB_PATH."LC_Categories.php");

define (FOLDER_EDIT,2);
define (FOLDER_BROWSE,1);
define(LC_CLASSLIB_REP,DOCUMENT_ROOT."../logicreate/classLibrary/");



class classdoclibService extends FacultyService {


	var $presentor = 'htmlPresentation';
	var $authorizer = 'facultyAuth';
	var $navlinks = array (
		'Classroom Manager' => 'main/event=displayClass',
		'Lessons' => 'lessonManager/',
		'Objectives' => 'lessonObjectives/',
		'Webliography' => 'lessonWebliography/',
		'Assignments' => 'assignmentManage/',
		'Content' => 'lessonContent/',
		'Presentations' => 'studentPresentation/'
	);

	function classdoclibService () {
		global $lcObj;
		parent::FacultyService();
		$lcObj->templateStyle = 'private';
	}


	function preTemplate(&$obj,&$t) {
		//handle trash display
		$db = DB::getHandle();
		
		// __FIXME__ - mgk 8/18/04 -
		// need to remove references to class_id - 
		// doclib stuff should be teacher-based, not class-based.
		$db->query('select count(class_id) from classdoclib_Trash where owner = \''.$obj->user->username.'\'
		and class_id = '.$obj->user->activeClassTaught->id_classes);
		$db->next_record();
		$t['trashcount'] = sprintf('%d',$db->Record[0]);

			if ( in_array('manager',$obj->user->perms) ) {
				$t['sectionheader'] =' 
<div id="sectionheader">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
	<tr>
		<TH nowrap>File Resources Manager - '.$obj->user->activeClassTaught->courseName.' ('.$obj->user->activeClassTaught->courseFamilyNumber.')</TH>
	</tr>
	<tr>
	<td align="left">
		<a href="'.APP_URL.'classdoclib/addFolder/main"><img src="'.IMAGES_URL.'folder-new.gif" border="0" height="24" width="24" alt="new folder" title="new folder">New Folder</a> &bull;
		<a href="'.APP_URL.'classdoclib/addFile/event=SelectFolder"><img src="'.IMAGES_URL.'file-new.gif" border="0" width="24" height="24" alt="new file" title="new file">New Document</a> &bull;
<!--		<a href="'.APP_URL.'classdoclib/trash/"><img src="'.IMAGES_URL.'file-trash.png" border="0" width="24" height="24" alt="new file" title="Trash">Trash ('.$t['trashcount'].')</a> &bull; -->
		<a href="'.APP_URL.'classdoclib/main"><img src="'.IMAGES_URL.'back.png" border="0" width="24" height="24" alt="back" title="back">Beginning</a> &bull;
		<a href="'.appurl('classmgr/display/').'"><img src="'.IMAGES_URL.'exit.png" border="0" width="24" height="24" alt="exit" title="exit">Exit</a>
	</td>
	</tr>
</table>
</div>
	<span style="color:red;">'.$t["error"].'</span>
';


			} else {
				$t['sectionheader'] = file_get_contents($obj->module_root."templates/viewer-header.html");
			}
	}

}


class LC_file extends PersistantObject{

	var $file;
	var $displayname;
	var $description;
	var $size;
	var $filedate;
	var $mime;
	var $owner;
	var $folder;


	function getFromFolder($folder,$order='') {
		$ret = array();
		$db = DB::getHandle();
		$sql = "select * from classdoclib_Files where folder='$folder' order by file";

		if ($order) 
			$sql .= "order by $order";
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$db->query($sql);
		while($db->next_record()) { 
			$x = PersistantObject::createFromArray('LC_file',$db->Record);
			$ret[$x->pkey] = $x;
		}

	return $ret;
	}




	function getSingle($pkey,$class,$action=1) {
		
		$db = DB::getHandle();
		$sql = '

SELECT 
	classdoclib_Files.*, classdoclib_Folders.*
FROM 
	classdoclib_Files 
LEFT JOIN 
	classdoclib_Folders ON (classdoclib_Folders.pkey = classdoclib_Files.folder) 
WHERE 
	(classdoclib_Files.pkey = '.$pkey.')
';
#	AND class_id = '.sprintf('%d',$class).')

		$db->RESULT_TYPE = MYSQL_ASSOC;
		$db->queryOne($sql);
		if (is_array($db->Record)) {
			unset($db->Record['total']);
			$x = PersistantObject::createFromArray('LC_file',$db->Record);
			return $x;
		} else {
			// xxx new ErrorStack
			trigger_error('no permission to view file '.$pkey);
			return null;
		}
	}

	function update() {
		$this->_save('classdoclib_Files');
	}
	function _getTransient() {
	return array('tmpname');
	}

	function save() {
		if ($this->displayname == '' )
			$this->displayname = $this->file;
		//write tmp files to documentLibrary directory.

		$rep = new LC_DiskRepository(LC_CLASSLIB_REP);
		$keys = array($this->owner,$this->file,$this->fileSize,$this->filedate);
		if ($this->diskName) { 
			$this->tmpname = LC_DiskRepository::getFullPath($this->diskName);
		} else { 
			$this->diskName = $rep->saveFile($keys,$this->tmpfile);
		}
		if ( !$this->diskName ) {
			return false;
		}
		$this->tmpfile ='';
		// UNSET DOESN'T ALWAYS WORK
		unset($this->tmpfile);
		$this->_save("classdoclib_Files");
		return true;
	}


	function delete() { 
		$db = DB::getHandle();
		$sql = "select * from classdoclib_Files where owner='".$this->owner."'";
		$sql .= " and pkey=".$this->pkey;
		$db->queryOne($sql);
		$filename = $db->Record["filename"];
		@unlink(FILES_PATH.$filename);
		$db->query("delete from classdoclib_Files where owner='".$this->owner."' and pkey=".$this->pkey);
	}


	/**
	 * use a standard set of keys from this class to save to a repository
	 * @DEPRECATED		Use save(), this function does not allow for 
	 * two files from the same owner of the same name and size (copies)
	 */
	function saveToRepository() {
		$rep = LC_DiskRepository::getSingleton();
		$keys = array($this->owner,$this->filename,$this->fileSize,$this->filedate);
		$this->diskName = $rep->saveFile($keys,$this->tmpname);
	return $this->diskName;
	}


	/**
	 * use a standard set of keys from this class to save to a repository
	 */
	function copyFile($newfid) {
		$this->folder = (int)$newfid;
		$this->filedate =  date("Y-m-d h:i:s");
		unset($this->pkey);
		$this->description = addslashes(stripslashes($this->description));
		$this->displayname = addslashes(stripslashes($this->displayname));
		$this->tmpname = LC_DiskRepository::getFullPath($this->diskName);
		$this->diskName = $this->saveToRepository();
		$this->daHasha = md5($this->size.microtime().$this->file); // da hasha.. it loves you. you should love it back! LOVE IT DAMNIT!
		unset($this->tmpname);
		$this->_save('classdoclib_Files');
	}


	/**
	 * use a standard set of keys from this class to save to a repository
	 */
	function moveFile($newfid) {
		$this->folder = $newfid;
		$this->_save('classdoclib_Files');
	}


}



/**
 * represent one folder in the file manager
 */
class LC_folder extends PersistantObject {

	var $name;
	var $pkey;
	var $contents;
	var $owner;
	var $class_id = 0;
	var $sharedGroups;
	var $managerGroups;


	function &load ($id,$class,$action=1) {
		$u = lcUser::getCurrentUser();
		$groups = $u->groups;
$sql = '
SELECT
	classdoclib_Folders.* 
 FROM
	classdoclib_Folders
 WHERE
 	pkey = '.sprintf('%d',$id).'
	AND
	(classdoclib_Folders.owner = "'.$u->username.'"
 	or classdoclib_Folders.class_id = '.$class.'
	)
 ORDER BY
 	pkey';
//debug($sql,1);
//print $sql;exit();
		$db = DB::getHandle();
		$db->query($sql);
		$db->RESULT_TYPE=MYSQL_ASSOC;
		if (!$db->next_record()) 
			return null;

		$x = PersistantObject::createFromArray('LC_folder',$db->Record);
		unset($x->total);
		return $x;
	}


	function & getVisibleFolders(&$u,$class,$action=1, $id_specific_folder=0) {
		$sql = '

SELECT
	classdoclib_Folders.* 
 FROM
 	classdoclib_Folders
 WHERE 1
	AND (classdoclib_Folders.owner = "'.$u->username.'"'.
		(((int)$id_specific_folder > 0) ? ' and pkey='.(int)$id_specific_folder : '')
		.')
 ORDER BY
	parentKey,
 	name';
	
	// mgk 8/18/04 - getting rid of class-specific content folders
	// will be only teacher-based
//	class_id = '.sprintf('%d',$class).'
		
		$db = DB::getHandle();
		$db->query($sql);
		$db->RESULT_TYPE=MYSQL_ASSOC;

		while($db->next_record()) {
			$temp = $db->Record['folderType'];
			if ($temp==0) { $temp=99; }
			$x[$temp][] = $db->Record;
		}
		ksort($x);
		while(list($k,$v) = each($x)) {
			while(list($key,$val) = each($v)) {

				// feature request - this may not be the best way to do this right now - too many queries?
				// also, would queryOne work here?  Do we have that in this version?
				$db->query("select count(folder) as filecount from classdoclib_Files where folder=".$val['pkey']);
				$db->next_record();
				$val['fullname'] = $val['name']." (".intval($db->Record['filecount']).") ";
				$data[] = $val;

			}
		}
		$tree = new TreeList();
		$tree->loadData($data);
	return $tree;
	}


	function & getContents() {
//		if ( is_array($this->contents) ) {
//			return $this->contents;
//		}
		$this->contents = LC_file::getFromFolder($this->pkey);
	}

	function _getTransient() {
		return array('contents','notgroups','managerGroups','sharedGroups');
	}


	function getOwner() {
		return $this->owner;
	}

	function isOwner($uname) {
		return strtolower($this->owner) == strtolower($uname);
	}

	function getClass() {
		return $this->class;
	}

	/**
	 * checks to see if the owner is the $user of if the $user,
	 * has edit permissions
	 */
	function canEdit(&$user) {
		if ( $this->isOwner($user->username) ) {
			return true;
		} else {
			if (! LC_Folder::load($this->pkey,FOLDER_EDIT) ) {
				return false;
			} else {
				return true;
			}
		}
	}
	
	
	/**
	 * copy a folder, and all its contents to a new folder id
	 * updated to include copying sharing values
	 */
	function copyFolder($newfid) {

		$db = DB::getHandle();
		$db->query("insert into classdoclib_Folders (name,parentKey,owner,notes) VALUES ('$this->name','$newfid','$this->owner','$this->notes')");
		$newFolderID = $db->getInsertID();

		$this->getContents();
		while ( list(,$v) = @each($this->contents) ) {
			$v->copyFile($newFolderID);
		}

		$db->query("select * from classdoclib_Sharing where folderKey = ".$this->pkey);
		$sql = 'insert into classdoclib_Sharing (folderKey,action,exclude,gid) VALUES ('.$newFolderID.',%d,%d,\'%s\')';
		while ( $db->next_record() ) {
			$db->query(sprintf($sql,$db->Record['action'],$db->Record['exclude'],$db->Record['gid']) );
		}

	}

	function moveFolder($newfid) {

		$db = DB::getHandle();
		$db->query("update classdoclib_Folders set parentKey = $newfid where pkey = $this->pkey");
		$newFolderID = $db->getInsertID();


	}



	function loadSharing() {
		if ( !$this->pkey || $this->pkey ==0 ) {
			return false;
		}

		$db = DB::getHandle();
		$db->query('select groupName,lcGroups.gid from lcGroups,
				classdoclib_Sharing
				WHERE classdoclib_Sharing.gid = 
				lcGroups.gid
				and classdoclib_Sharing.folderKey = 
				'. $this->pkey.'
				and action = 1');

		while ($db->next_record() ){
			$this->sharedGroups[$db->Record[1]] = $db->Record[0];
		}

		$db->query('select groupName,lcGroups.gid from lcGroups,
				classdoclib_Sharing
				WHERE classdoclib_Sharing.gid = 
				lcGroups.gid
				and classdoclib_Sharing.folderKey = 
				'. $this->pkey.'
				and action = 2');

		while ($db->next_record() ){
			$this->managerGroups[$db->Record[1]] = $db->Record[0];
		}
	}


	function delete() {
		//__FIXME__ guarantee that folder contents are removed too (first?)
		$db = DB::getHandle();
		if (!$this->pkey) return false;

		$db->query('delete from classdoclib_Folders where pkey = '.$this->pkey);

		return true;
	}
}






/**
 * class to save files to a directory tree on the server disk
 */
class LC_DiskRepository {

	var $baseDir;
	var $seperator = ':';

	function LC_DiskRepository($base) {

		$this->baseDir = $base;
		if ( ! is_writable($this->baseDir) ) {
			trigger_error ("cannot write to rep $this->baseDir",E_USER_ERROR);
			lcError::throwError(9,'cannot write to rep '.$this->baseDir);
		}
	}



	/*
	 * takes an array of keys which will make a unique ID for this file
	 * hashes them and saves them in the repository
	 */
	function saveFile($keys,$filename){

		$seed = join($this->seperator,$keys);
		$diskname = md5($seed);
		//use a two tier directory structure
		//first two chars of md5 and last two
		$dir1 = substr($diskname,0,2);
		$dir2 = substr($diskname,-2,2);
		if (! $this->isDir($dir1) ) {
			$this->makeDir($dir1);
			$this->makeDir($dir1.'/'.$dir2);
		} else if ( ! $this->isDir($dir1.'/'.$dir2) ) {
			$this->makeDir($dir1.'/'.$dir2);
		}
		if (! move_uploaded_file($filename,$this->baseDir.$dir1.'/'.$dir2.'/'.$diskname) ) {
			if (! copy($filename,$this->baseDir.$dir1.'/'.$dir2.'/'.$diskname) ) {
				trigger_error("cannot save file to disk: \nFailed to copy ". $filename. " \n to  ".$this->baseDir.$dir1.'/'.$dir2.'/'.$diskname);
				return false;
			}
		}
		return $diskname;

	return false;
	}



	/*
	 * saves a sring, object, or array
	 */
	function saveData($keys,$val) {
		$seed = join($this->seperator,$keys);
		$filename = md5($seed);
		//use a two tier directory structure
		//first two chars of md5 and last two
                $dir1 = substr($filename,0,2);
                $dir2 = substr($filename,-2,2);
                if (! $this->isDir($dir1) ) {
                        $this->makeDir($dir1);
                        $this->makeDir($dir1.'/'.$dir2);
                } else if ( ! $this->isDir($dir1.'/'.$dir2) ) {
                        $this->makeDir($dir1.'/'.$dir2);
                }
                $f = fopen($this->baseDir.$dir1.'/'.$dir2.'/'.$filename,'w+');
                if ( !$f ) return false;

                fwrite($f,$val,strlen($val));
                fclose($f);

                return $filename;
		}


        /*
         * saves a gb images handle
         */
        function saveGDImage($keys,$gdhandle) {

			$seed = join($this->seperator,$keys);
			$filename = md5($seed);
			//use a two tier directory structure
			//first two chars of md5 and last two
			$dir1 = substr($filename,0,2);
			$dir2 = substr($filename,-2,2);
			if (! $this->isDir($dir1) ) {
				$this->makeDir($dir1);
				$this->makeDir($dir1.'/'.$dir2);
			} else if ( ! $this->isDir($dir1.'/'.$dir2) ) {
				$this->makeDir($dir1.'/'.$dir2);
			}

			ImageJpeg($gdhandle,$this->baseDir.$dir1.'/'.$dir2.'/'.$filename);

			return $filename;

        }


        function getFullPath($diskname, $givebase=true) {
                if ($this->baseDir == '') {
                        $x = LC_DiskRepository::getSingleton();
                        $b = $x->baseDir;
                } else {
                        $b = $this->baseDir;
                }

                $dir1 = substr($diskname,0,2);
                $dir2 = substr($diskname,-2,2);
                return ($givebase ? $b : '').$dir1.'/'.$dir2.'/'.$diskname;
        }


        function isDir($name) {
                return is_dir($this->baseDir.$name);
        }


        function makeDir($name) {
		umask (002);
		//took out mode
                mkdir($this->baseDir.$name.'/');
        }


        function & getSingleton() {
                static $single;
                if (!isset($single) ) {
                        $single = new LC_DiskRepository(LC_CLASSLIB_REP);
                }
        return $single;
        }
}



class FileMGTView extends ListView{



	/**
	 * render a TreeList as an Explorer Tree
	 *
	 * @return	String	HTML output
	 */
	function renderAsExplorer($open='',$withControls=0) {
		$ret = "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
		$this->tree->reset();
		
		while ($this->tree->traverse() ) {
			//keep folders closed by default
			if ($this->tree->p_CurrentNode->expanded != true) { $this->tree->p_CurrentNode->expanded = false; }


			$folderOpenImage ='folder-open.gif';
			$folderImage = 'folder.gif';
			if ($this->tree->p_CurrentNode->contents['folderType']==0) { 
			$folderOpenImage ='file-trash.png';
			$folderImage = 'file-trash.png';

			}

			//colors
			++$c %2 ==0 ? $color="even": $color="odd";

			if ($open == $this->tree->p_CurrentNode->contents['pkey'] ) {
				$color="open";
			}



			$ret .= "\n\t\t<tr><td>\n\n\t\t<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td NOWRAP>\n\n\t";


			// print all types of pipes as you cycle through each level of indent
			for ($q=0; $q < $this->tree->p_CurrentNode->indent; ++$q) {
				if ($this->tree->stack[$q]->hasSibling()) {
					$ret .= "<img src=\"".IMAGES_URL."path-pipe.gif\" height=\"18px\" align=\"center\" width=\"20\" border=0>";
				} else {
					$w = count($this->tree->p_CurrentNode->indent) * 18;
					$ret .= "<img src=\"".IMAGES_URL."spacer.gif\" height=\"18px\" align=\"center\" width=\"$w\" border=0>";
				}
			}

			//wrap link around folder icons
			$ret .= "<a href=\"".APP_URL."classdoclib/main/".$this->tree->p_CurrentNode->contents['pkey']."\">";

			//find out which image to print (connecting lines)
			if ($this->tree->p_CurrentNode->hasChild() && $this->tree->p_CurrentNode->hasSibling()){
				$ret .= "<img src=\"".IMAGES_URL."sibling-child-pipe.gif?S\" border=\"0\" align=\"center\" height=\"18\" width=\"20\">";}
			else if ($this->tree->p_CurrentNode->hasChild()){
				$ret .= "<img src=\"".IMAGES_URL."child-close-pipe.gif\" border=\"0\" align=\"center\" height=\"18\" width=\"20\">";}
			else if ($this->tree->p_CurrentNode->hasSibling()) {
				$ret .= "<img src=\"".IMAGES_URL."sibling-pipe.gif\" border=\"0\" align=\"center\" height=\"18\" width=\"20\">";}
			else {
				$ret .= "<img src=\"".IMAGES_URL."child-pipe.gif\" border=\"0\" align=\"center\" height=\"18\" width=\"20\">";}
			$ret .= "</a></td>";


			//print a folder
				//print a normal folder
				$ret .= "<td align=\"left\" height=\"15\" width=\"98%\" class=\"classdoclibrary_$color\">";
				$ret .= "<a href=\"".APP_URL."classdoclib/main/".$this->tree->p_CurrentNode->contents['pkey']."\">";
				//open folder
				if ($open == $this->tree->p_CurrentNode->contents['pkey'] ) {
					$ret .= "<img src=\"".IMAGES_URL."$folderOpenImage\" border=\"0\" align=\"center\" height=\"15\" width=\"17\">";
				} else {
					$ret .= "<img src=\"".IMAGES_URL."$folderImage\" border=\"0\" align=\"center\" height=\"15\" width=\"17\">";
				}
				$ret .= "</a> ";
				$ret .= "<a href=\"".APP_URL."classdoclib/main/".$this->tree->p_CurrentNode->contents['pkey']."\">";
				$ret .= $this->tree->p_CurrentNode->contents['name'];
				$ret .= "</a>";
				$ret .= "</td>";
				
				//print one cell of icons or not
/*				if ( $withControls) {
					$ret .= "<td class=\"classdoclibrary_$color\" align=\"center\" NOWRAP>\n";
					$ret .= "\n\t\t<a href=\"".APP_URL."classdoclib/main/event=showFolderInfo/fid=".$this->tree->p_CurrentNode->contents['pkey']."\" onclick=\"window.open('".APP_URL."classdoclib/main/event=showFolderInfo/fid=".$this->tree->p_CurrentNode->contents['pkey']."','small','width=600,height=270');return false;\">";
					$ret .= "<img src=\"".IMAGES_URL."help.png\" border=0 height=\"16\" width=\"16\" alt=\"info\" title=\"info\"></a>";
					$ret .= "<img src=\"".IMAGES_URL."spacer.gif\" border=\"0\" width=\"10\" height=\"3px\">";
					$ret .= "<a href=\"".APP_URL."classdoclib/editFolder/".$this->tree->p_CurrentNode->contents['pkey']."\"><img src=\"".IMAGES_URL."folder_blue_open.png\" border=0 height=\"16\" width=\"16\" alt=\"edit\" title=\"edit\"></a></td></tr>\n";

				}
//*/
		$ret .= "</tr></table>\n\n\t";

		$ret .= "\n\t\t</td></tr>\n\n\t\t";
		}
		$ret .= "\n\t\t</table>\n";
	return $ret;
	}

	/**
	 * Short cut for remembering arguments
	 */
	function renderAsExplorerWithControls($open = '') {
		return $this->renderAsExplorer($open,1);
	}



	function renderWithRadio() {
		$ret .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">\n";
		$this->tree->reset();


		while ($this->tree->traverse() ) {
			$folderOpenImage ='folder-open.gif';
			$folderImage = 'folder.gif';
			if ($this->tree->p_CurrentNode->contents['folderType']==0) { 
				$folderOpenImage ='file-trash.png';
				$folderImage = 'file-trash.png';
			}

			$ret .= "\t\t<tr><td width=\"20\"><input type=\"radio\" name=\"fid\" value=\"".$this->tree->p_CurrentNode->contents['pkey']."\"></td><td>";

			//start inner table for pipes and folders
			$ret .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td NOWRAP>\n\t";


			// print all types of pipes as you cycle through each level of indent
			for ($q=0; $q < $this->tree->p_CurrentNode->indent; ++$q) {
				if ($this->tree->stack[$q]->hasSibling()) {
					$ret .= "<img src=\"".IMAGES_URL."path-pipe.gif\" height=\"18px\" align=\"center\" width=\"20\" border=0>";
				} else {
					$w = count($this->tree->p_CurrentNode->indent) * 18;
					$ret .= "<img src=\"".IMAGES_URL."spacer.gif\" height=\"18px\" align=\"center\" width=\"$w\" border=0>";
				}
			}

			//wrap link around folder icons

			//find out which image to print (connecting lines)
			if ($this->tree->p_CurrentNode->hasChild() && $this->tree->p_CurrentNode->hasSibling()){
				$ret .= "<img src=\"".IMAGES_URL."sibling-child-pipe.gif?S\" border=\"0\" align=\"center\" height=\"18\" width=\"20\">";}
			else if ($this->tree->p_CurrentNode->hasChild()){
				$ret .= "<img src=\"".IMAGES_URL."child-close-pipe.gif\" border=\"0\" align=\"center\" height=\"18\" width=\"20\">";}
			else if ($this->tree->p_CurrentNode->hasSibling()) {
				$ret .= "<img src=\"".IMAGES_URL."sibling-pipe.gif\" border=\"0\" align=\"center\" height=\"18\" width=\"20\">";}
			else {
				$ret .= "<img src=\"".IMAGES_URL."child-pipe.gif\" border=\"0\" align=\"center\" height=\"18\" width=\"20\">";}
			$ret .= "</td>";


				//print a normal folder
				$ret .= "<td height=\"15\" width=\"98%\" style=\"font-size:10pt;\" align=\"left\">";
				$ret .= "<img src=\"".IMAGES_URL."$folderImage\" border=\"0\" align=\"center\" height=\"15\" width=\"17\">&nbsp;";
				$ret .= $this->tree->p_CurrentNode->contents['name'];
				$ret .= "</td></tr></table></td>\n\t\t";
		}
		$ret .= "\t</table>\n";
	return $ret;
	}



	function renderLinksAsOptions($sel='') {
		while ($this->tree->traverse() ) {
			$ret .= '<option value="'.$this->tree->p_CurrentNode->contents->pkey.'"';
			if ( is_array($sel) && (in_array($sel,$this->tree->p_CurrentNode->contents->pkey) ) )
				$ret .= ' SELECTED ';
			if ( $sel == $this->tree->p_CurrentNode->contents->pkey )
				$ret .= ' SELECTED ';
			$ret .= '>';
			$ret .= str_repeat("---",$this->tree->p_CurrentNode->indent);
			$ret .= $this->tree->p_CurrentNode->contents->linkText."</option>\n";
		}
	return $ret;
	}


}
?>
