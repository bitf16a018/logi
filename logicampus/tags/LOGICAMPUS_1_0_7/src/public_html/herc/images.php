<?php
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

/**
 *	Image Manager
 *
 *	@version 1.1
 *	@status beta
 *	@createdby Ryan Sexton
 *	@contact ryan@tapinternet.com
 *
 *	@updates	Submit all updates to me through
 *			email see @contact
 *
 *	@todo
 *			2] add better directory checking before performing events
 *			3] add better file checking before performing events
 *
 */

	// converting these to configs
	define("ICON_CLOSED", "closed.gif");
	define("ICON_INDENT", "indent.gif");
	define("ICON_OPENED", "opened.gif");

	define("TEXT_DELETE", "[delete]");
	define("TEXT_ROOT", "Images Directory");
	
	define("IMAGE_DIR", "../images/");


class images extends HercAuth
{
	
	var $presentor = "configurePresentation";
	
	var $base;
	
	var $path; 
	
	var $dirs;
	
	var $a_img_dirs;		// array of directories within selected $img_path_current
	var $a_img_files;		// array of files within selected $img_path_current
	var $img_path_current;
	
	
	/**	Preloader
	 *	@setup for various data, Actions, File
	 */
	function images()
	{	
		global $lcObj;
		
		
		$this->path = base64_decode($lcObj->getvars["path"]);
		
		
		$this->img_path_current = $this->path;
		$nodes = 0;	$clean = "";

		$this->a_img_dirs = split('[/\\]', $this->img_path_current);
		$clean = '';

		foreach($this->a_img_dirs as $dkey=>$dir) 
		{
			if(strlen($dir) > 0 && ($dir != '.' || $dir != '..')) 
			{	
				switch($nodes++) 
				{	default:
					$clean .= "/";
					case 0:
					if (is_dir(IMAGE_DIR.$clean.'/'. $dir))
					{  $clean .= $dir;
					}
					break;
				}
				
			}

		}

		$this->a_img_dirs = split('[/\\]', "$clean");
		$this->img_path_current = implode("/", $this->a_img_dirs);
		
	}

	
	/**
	 *	Loads up main interface for singular image viewing
	 *
	 *	@template images_viewer.html
	 */
	function imageviewerRun($db, &$u, &$lc, &$t)
	{
		$filepath_server = IMAGE_DIR.$this->img_path_current.'/'.$lc->getvars['file'];

		$size = @getImageSize(IMAGE_DIR.$this->img_path_current.'/'.$lc->getvars['file']);

		$t['filewidth'] = $size[0];
		$t['fileheight'] = $size[1];
		
		$t['filename'] = $lc->getvars['file'];
		$t['filesize'] = filesize($filepath_server);
		$t['imgtag'] = '<img '. $size[3]. ' src="'. IMAGES_URL.$this->img_path_current.'/'.$lc->getvars['file'].'">';
		
		// look for thumbnail
		$tmpf = explode('.',$lc->getvars['file']);
		// gimme extension
		$tmp_ext = array_pop($tmpf);
		//create my new thumbnail filename
		$filename_thumb = @implode($tmpf, ''). '_thumb.'.$tmp_ext;
		
		if (file_exists(IMAGE_DIR.$this->img_path_current.'/'.$filename_thumb))
		{	
			$sizethumb = @getImageSize(IMAGE_DIR.$this->img_path_current.'/'.$filename_thumb);
			$t['filenamethumb'] = $filename_thumb;
			$t['filesizethumb'] = filesize(IMAGE_DIR.$this->img_path_current.'/'.$filename_thumb);
			$t['imgtagthumb'] = '<img '. $sizethumb[3]. ' src="'. IMAGES_URL.$this->img_path_current.'/'.$filename_thumb.'">';
			
		}
		
		$t['thumbnailformaction'] = modurl('/images/path='.urlencode(base64_encode($this->img_path_current)).'/file='.urlencode($lc->getvars['file']). '/event=imagethumbit/');
		$lc->templateName = 'images_viewer';
		
	}
	
	function imagethumbitRun($db,  &$u, &$lc, &$t)
	{
		$userX = $lc->postvars['thumb']['x'];
		$userY = $lc->postvars['thumb']['y'];
		$filepath_server = IMAGE_DIR.$this->img_path_current.'/'.$lc->getvars['file'];
		$this->_thumbit($t, IMAGE_DIR.$this->img_path_current.'/', $lc->getvars['file'], $userX, $userY);
		clearstatcache();
		
		$this->imageviewerRun($db, $u, $lc, $t);
	}
	
	
	function run($db, &$u, &$lc, &$t)
	{
		$t['current_directory'] = str_replace('//', '/', @implode($this->a_img_dirs, '/'). '/');
		
		$nodes = 0;
		$current = (count($this->a_img_dirs) + 1);

		$t['html'] .= '<table border="0" cellspacing="0" cellpadding="0" width="100%">';
		
		// base dir showing (always)
		$t['html'] .= $this->dirTag(TEXT_ROOT, "", $nodes++, ICON_OPENED);
		
		foreach($this->a_img_dirs as $kdir=>$dir) 
		{
			if(strlen($dir) > 0)
			{	$t['html'] .= $this->dirTag($dir, "", $nodes++, ICON_OPENED, ($nodes != $current));
			}
		}

		$list = $this->listDirs();

		foreach ($list as $klist=>$vlist)
		{	$t['html'] .= $this->dirTag($vlist, $klist, $nodes);	
		}

		$list = $this->listFiles(array("gif", "jpg", "jpeg", "png"));
		sort($list);

		foreach($list as $kfile=>$vfile)
		{	$t['html'] .= $this->fileTag($vfile, $kfile, $nodes);
		}

		$t['file_count'] = count($list);
		$t['html'] .= "</table>\n";
		
	}
	
	function deleteDirRun($db, &$u, &$lc, &$t)
	{
		$found=0;
		foreach($this->a_img_dirs as $dkey=>$dir) 
		{
			if(strlen($dir) > 0 && ($dir != '.' || $dir != '..')) 
			{	switch($nodes++) 
				{	default:
					$clean .= "/";
					case 0:
					if (is_dir(IMAGE_DIR.$clean.'/'. $dir))
					{  $clean .= $dir;
					}
					break;
				}
				$found++;
			}
		}

		if($found == count($this->a_img_dirs))
		{	unset($this->a_img_dirs[($found-1)]);
			$this->img_path_current = implode("/", $this->a_img_dirs);
			if (is_dir(IMAGE_DIR.$clean) && $this->isEmpty($clean))
			{	
				if (rmdir(IMAGE_DIR.$clean))
				{	$t['status'] = 'Directory removed';
				}else 
				{	$t['status'] = 'Directory failed to be removed.';
				}			
			}
		}
		
		
		$this->run($db, $u, $lc, $t);
	}
	
	
	
	function deleteFileRun($db, &$u, &$lc, &$t)
	{	
		$file = ereg_replace('[^0-9a-zA-Z_.-]', '', $lc->getvars['file']);// cleaning. no NO absolutely no odd characters, keeping it real
		$filedir = str_replace('//', '/', IMAGE_DIR.$this->img_path_current.'/'.$file);
		
		if (is_file($filedir))
		{	if (unlink($filedir))
			{	$t['status'] = 'File removed';
			}else 
			{	$t['status'] = 'File failed to be removed.';
			}
		} else 
		{	$t['status'] = 'Unknown file';
		}
		
		$this->run($db, $u, $lc, $t);
	}
	
	function createRun($db, &$u, &$lc, &$t)
	{	
		$directory = ereg_replace('[^0-9a-zA-Z-]', '', $lc->postvars['directory']);	// cleaning. no NO absolutely no odd characters, keeping it real
		$path = IMAGE_DIR .base64_decode($lc->getvars["path"]);
		if (strlen($directory) > 0)
		{
			if (mkdir($path.$directory, 0777))
			{	chmod($path.$directory, 0777);
				$t['status'] = 'Directory created';
			} else 
			{	$t['status'] = 'Creating directory failed';
			}
		} else 
		{	$t['status'] = 'You must specify a directory to create';
		}
		// @@deleteDir i need to run a directory check, but i'll do that later
		
		
		$this->run($db, $u, $lc, $t);
	}
	
	
	function uploadRun($db, &$u, &$lc, &$t)
	{
		$up = $lc->uploads['in'];
		
		if (@$up["name"]["file"] != '' && @$up['size']['file'] > 0) 
		{	
			$filename = $up["name"]["file"];
			$size = $up["size"]["file"];
			$uploadToPath = str_replace('//', '/',IMAGE_DIR .base64_decode($lc->getvars["path"]));
	
			
		    // no inforcement of size here
		    /*
		    if ($size > 200000)
		    {   $t['statusmessage'] = '*** Failed to upload file ('. $filenamereal. ') (size is larger than 200k)';
		    	$this->run($db,$u,$lc,$t);
			return false;
		    }
		    */
		    
    			$mime = $up["type"]["file"];
			$filenamereal = ereg_replace('[^0-9A-Za-z._-]', '',$filename);       # i see problems later on with this (rs)
			$location = $up["tmp_name"]["file"];
			
			
    			$itype = @getimagesize($location);
    			
    			//$t['status'] = 'TEST';
			//$this->run($db, $u, $lc, $t);
			//return;
			if ((int)$itype[2] >3 || (int)$itype[2] == 0)
			{	// bad image type
				$t['status'] = 'Upload failed: Wrong type, expecting .Jpg, .Gif, .Png';
				$this->run($db,$u,$lc,$t);
				return false;
			} else 
			{	            
				if (move_uploaded_file($location, $uploadToPath.$filenamereal))
				{	
					chmod($uploadToPath.$filenamereal, 0777);
					$t["status"] = 'File ('. $filenamereal. ') has been uploaded successfully';
					/*
					if ($this->_thumbit(IMAGES_PATH.'shop/'.$filenamereal) == false)
					{   	// remove larger file
						@unlink(IMAGES_PATH.'shop/'.$xpath.$filenamereal);
						$t['status'] = '*** Failed to upload file ('. $filenamereal. ') Invalid Format of Image';
					}
				
					*/
				
				} else 
				{   $t['status'] = 'Failed to upload file ('. $filenamereal. ')';
				}
	        	}
		
		} else 
		{   $t['status'] = 'No file was uploaded, please try again';
		}
		
		$this->run($db, $u, $lc, $t);
	}
	
	
	function isWindows() 
	{   return isset($_SERVER["WINDIR"]);
	}
	
	/**	Get List Of Directories
	 */
	function dirTag($value, $key, $depth, $icon = ICON_CLOSED, $link = TRUE)
	{
		// initialize context
		$path =$this->basePath($value, ($depth - 1));
		
		$ret = "<tr><td align=\"left\" valign=\"bottom\">\n";
	
		$ret .= $this->indentTag($depth);
	
		$ret .= '<img align="bottom" src="'._PICS_URL. $icon. '" alt="'.$value.'">';

		if($link) 
		{	
			//echo $this->basePath($value). '*'. $depth. '<br>';
			$ret .= "<a href=\"" . modurl('/images/');
			if($value != TEXT_ROOT)
			{	$ret .= "path=" . urlencode(base64_encode($this->basePath($value, $depth)));
			}
			$ret .= "\">";
		}
		
		$ret .= "<b>$value</b>";
		$ret .= "</a>";
		$ret .= "</td><td colspan=\"2\" class=\"delete\" align=\"right\" valign=\"bottom\">\n";

		if($icon == ICON_CLOSED && $this->isEmpty($path))
		{	$ret .= "<a onclick=\"if (!confirm('Delete This Item?')) {return false;}\"  href=\"".modurl('/images/path='.urlencode(base64_encode($this->basePath($value, $depth))). '/event=deleteDir/')."\">" . TEXT_DELETE . "</a>";
		}

		$ret .= "</td></tr>\n";
	return $ret;
	}

	function indentTag($depth)
	{
		if($depth > 0)
		{
			// Had to change this to a hardcoded dir becuase it sees to cause problems on diff versions of php.
			// I need to test this elsewhere.
   			$size = @getImageSize('./templates/images/'.ICON_INDENT);

			return "<img src=\"" ._PICS_URL.ICON_INDENT . "\" width=\"" . ($size[0] * $depth) . "\" height=\"" . $size[1] . "\">";
		}
	}
	
	function basePath($path, $nodes = 999) 
	{
		$result = "";
		$count = count($this->a_img_dirs);
		
		for($index = 0; $nodes > 0 && $index < $nodes && $index < $count; $index++)
		{	if(strlen($this->a_img_dirs[$index]) > 0)
			{	$result .= $this->a_img_dirs[$index] . "/";
			}
		}

		$result .= $path;
	
	return $result;
	}
	
	
	
	function isEmpty($path) 
	{	
		$empty = true;	
	
		if($fs_dir = @opendir(IMAGE_DIR. $path))
		{
			while($empty && false !== ($file = readdir($fs_dir))) 
			{	
				if($file != "." && $file != "..")
				{	$empty = false;
					break;
				}
				
			}
			
		closedir($fs_dir);
		}
	
	return $empty;
	}

	
	// list directories within the working dir
	function listDirs() 
	{	
		$result = array();
		//echo '['. $this->img_path_current.']';
		if(($dir = @opendir(IMAGE_DIR . $this->img_path_current)))
		{	
			while(false !== ($file = readdir($dir))) 
			{
				if($file != "." && $file != "..") 
				{
					if(is_dir(IMAGE_DIR.$this->img_path_current.'/'. $file))
					{   $result[] = $file;
					}
				}
			}
	
		closedir($dir);
		}
	
	return $result;
	}
	
	function listFiles($filter = Array()) 
	{
		$result = Array();
			
		if(($dir = @opendir(IMAGE_DIR . $this->img_path_current)))
		{	
			$filters = count($filter);
			
			while(false !== ($file = readdir($dir))) 
			{
				if (is_dir(IMAGE_DIR.$this->img_path_current.'/'.$file) == false)
				{
					if($filters > 0) 
					{	
						$compare = ($this->isWindows() ? "strcasecmp" : "strcmp");
						
						$parts = pathinfo(IMAGE_DIR . $this->basePath($file));
						$ext = $parts["extension"];

						if (in_array($ext, $filter))
						{	$result[] = $file;
						}
						
					}
				
				}

			}

		closedir($dir);
		}

	return $result;
	}
	

	
	function fileTag($value, $key, $depth)
	{	
		$file = $this->basePath($value);

		$size = getImageSize(IMAGE_DIR . $file);

		if($size)
		{
			$ret = "<tr><td align=\"left\" valign=\"bottom\">\n";

			$ret .= $this->indentTag($depth, true);

			$ret .= "<img align=\"bottom\" src=\"";

			switch($size[2])
			{
				case 1:
					$ret .= _PICS_URL. "gif.gif";        break;
				case 2:
					$ret .= _PICS_URL. "jpg.gif";       break;
				case 3:
					$ret .= _PICS_URL. "png.gif";      break;
			}
	
			$ret .= "\" alt=\"" . $value . "\">";
			// @@@ use a popup for file
			$ret .= "<a onclick=\"window.open('".modurl('/images/path='.urlencode(base64_encode($this->img_path_current)).'/file='.urlencode($value). '/event=imageviewer/')."', 'imageviewer', 'width=480,height=425,location=no,status=no,scrollbars=yes,resizable=yes'); return false;\" href=\"#\">";
			$ret .= $value;
			$ret .= "</a>\n";
			
			//". $this->hbytes(filesize(IMAGE_DIR.$this->img_path_current.'/'.$value)). "
			$ret .= "</td>
				<td class=\"bytes\" align=\"left\" width=\"65\" valign=\"bottom\" nowrap>". $this->hbytes(filesize(IMAGE_DIR.$this->img_path_current.'/'.$value)). "</td>
				<td class=\"delete\" align=\"right\" width=\"45\" valign=\"bottom\" nowrap>\n";
			$ret .= "<a onclick=\"if (!confirm('Delete This Item?')) {return false;}\" href=\"".modurl('/images/path='.urlencode(base64_encode($this->img_path_current)). '/file='.urlencode($value).'/event=deleteFile/')."\">" . TEXT_DELETE . "</a>";

		$ret .= "</td></tr>\n";
		}

	return $ret;
	}


	function hbytes($bytes, $base10=false, $round=0,$labels=array('bytes', 'Kb', 'Mb', 'Gb')) 
	{

		if (($bytes <= 0) || (! is_array($labels)) || (count($labels) <= 0))
		{	return null;
		}

		$step = $base10 ? 3 : 10 ;
		$base = $base10 ? 10 : 2;

		$log = (int)(log10($bytes)/log10($base));

		krsort($labels);

		foreach ($labels as $p=>$lab) 
		{
			$pow = $p * $step;
			if ($log < $pow) continue;
			$text = round($bytes/pow($base,$pow),$round).' '. $lab;
			break;
		}

	return $text;
	}
	
	
	
	
	
	
	/**
	 * I assume the passed in param will be a valid path to a valid image file
	 *
	 *	@t		array[ref] pass in template array so we can update the status of this action
	 *	@path		string	fullpath to image (server path from script home (where this script is located), not HTTP://)
	 *				include leading /
	 *	@filename	string	name of file to thumb
	 */
	function _thumbit(&$t, $path, $filename, $_SIZE_W=0, $_SIZE_H=0)
	{
		
		// DIM
		$thumbable = false;
		$ext = '';
		
		if ( ($_SIZE_W >0) || ($_SIZE_H>0) ){
			$PRODUCT_IMG_MAX_WIDTH_THUMB = $_SIZE_W; 
			$PRODUCT_IMG_MAX_HEIGHT_THUMB = $_SIZE_H; 
		} else {
			$PRODUCT_IMG_MAX_WIDTH_THUMB = 100; 
		}
					
		$filename_thumb = '';
		
		$tmpf = explode('.',$filename);
		
		// gimme extension
		$tmp_ext = array_pop($tmpf);
		//create my new thumbnail filename
		$filename_thumb = @implode($tmpf, ''). '_thumb.'.$tmp_ext;
		
		
		
		// does file exist
		if (file_exists($path.$filename))
		{
		
		// Can we even create a new image (for thumbing)
		if (function_exists('ImageCreate'))
		{
			// checking type
			$itype = getimagesize($path.$filename);
			$t['itype'] = $itype;

			if ( ($_SIZE_W >0) || ($_SIZE_H>0) ){
				if (strpos($_SIZE_W,"%")>0) {
					$_SIZE_W = (intval($_SIZE_W) / 100) * $itype[0];
				}
				if (strpos($_SIZE_H, "%")>0) {
					$_SIZE_H = (intval($_SIZE_H) / 100) * $itype[1];
				}
			}
					
			if ($itype[2] >=1 && $itype[2] <=3)
			{
				// seeing if we have proper gd extension for thumbing exists for the requested image
				switch($itype[2])
				{	case 1:
						if (function_exists('imagegif'))  $thumbable =true; $ext = 'gif';    break;
					case 2:
						if (function_exists('imagejpeg')) $thumbable =true; $ext = 'jpeg';   break;
					case 3:
						if (function_exists('imagepng'))  $thumbable =true; $ext = 'png';    break;
				}
	            
				if ($thumbable)
				{
// changed from itype[1] to itype[0] (0='width') ???				
//					if ($itype[0] > $PRODUCT_IMG_MAX_WIDTH_THUMB)
//					{
						$imageCtor = 'ImageCreateFrom'.$ext;
						$largeImage = $imageCtor($path.$filename);
                        
						if ($largeImage) 
						{	$w = ImageSX($largeImage);
							$h = ImageSY($largeImage);
                            
							
							if (($_SIZE_W >0) && ($_SIZE_H==0) ) {
								$w2 = $_SIZE_W;  # check shop configurations 
								$h2 = $h / ($w/$w2);	
							}
							if (($_SIZE_W >0) && ($_SIZE_H>0)) {
								$h2 = $_SIZE_H;
								$w2 = $_SIZE_W;
							}
							if (($_SIZE_W == 0) && ($_SIZE_H==0)) {
								/* If width of larger file is greater than my defined var
								then i will scal. otherwise, i'm aborting this,
								i will only scale a 'wide' image to proper width
								*/
								if ($w > $h ) 
								{	$w2 = $PRODUCT_IMG_MAX_WIDTH_THUMB;  # check shop configurations 
									$h2 = $h / ($w/$w2);
								} else
								{	$h2 = $PRODUCT_IMG_MAX_WIDTH_THUMB;
									$w2 = $w / ($h/$PRODUCT_IMG_MAX_WIDTH_THUMB);
								}							
							
							}
							if (($_SIZE_W ==0) && ($_SIZE_H>0)) {
								$h2 = $_SIZE_H;
								$w2 = $w / ($h/$_SIZE_H);
							}
							$thumbImage = ImageCreate($w2,$h2);
							ImageCopyResized($thumbImage,$largeImage,0,0,0,0,$w2,$h2,$w,$h);
							$imageDtor = 'Image'.$ext;
							$imageDtor($thumbImage,$path.$filename_thumb);
							return true;
        	                
						} else
						{	$t['status'] = '*** Could not thumbnail your image, it is of the wrong type';
						}                    
//					} else {
//						$t['status'] = '*** Could not thumbnail the image.  Image is '.$itype[0]." pixels across, which is less than the requested ".$PRODUCT_IMG_MAX_WIDTH_THUMB;
//					}
				} else 
				{	$t['status'] = '*** Could not thumbnail your image, it is of the wrong type';
				}	            
			} else 
			{	$t['status'] = '*** Could not thumbnail your image, it is of the wrong type';
			}
		} else
		{	$t['status'] = '*** Could not thumbnail your image, please install GD to use auto thumbnailing.';
		}
		
		} else
		{	$t['status'] = 'Failed to find the file you are requesting to thumb';
		}

	return false;
	}
	
}

?>
