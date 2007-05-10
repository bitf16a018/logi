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


include_once(LIB_PATH. "LC_registry.php");

class moduleadmin extends HercAuth {

	var $presentor = "configurePresentation";
	
	function run (&$db,&$u,&$arg,&$t) {
		$arg->templateName = "mod_add";
	}

	function addrun (&$db,&$u,&$arg,&$t) {
		$reg = new lcRegistry();
		$config = explode("\n",$arg->postvars["config"]);
		$modulename = $arg->postvars["modulename"];

		$mid = md5($modulename.time());
		$reg->mid = $arg->postvars["modulename"];
		$reg->moduleName = $arg->postvars["modulename"];
		$reg->displayName = $arg->postvars["displayname"];
		$reg->author = $arg->postvars["author"];
		$reg->copyright = $arg->postvars["copyright"];
		$reg->lastModified = date("Y-m-d H:i:s");
		while(list($k,$v) = each($config)) {
			$ar[$v]= "";
		}
		$reg->config = $ar;
		$reg->save();

@reset($reg->config);
while(list($k,$v) = @each($reg->config)) { 
$sql = "insert into lcConfig (mid,k,v) values ('$mid','$k','')";
$db->query($sql);
}




		$find[] = "MODULENAME";
		$find[] = "MODULEDATE";
		$replace[] = $modulename;
		$replace[] = date("m/d/Y");

		$thispath =getcwd();
		rec_copy(SERVICE_PATH."skel/",INSTALLED_SERVICE_PATH."$modulename/",$find,$replace);
		chdir($thispath);
		$t["added"] = true;
		$t["message"] = "Module \"$modulename\" added";
		$this->run($db,$u,$arg,$t);
	
	}

	/*
	 * double check that they really want to delete
	 */
	function confirmDelrun($db,&$u,&$arg,&$t) {
		$mid = $arg->getvars["mid"];
		$reg = lcRegistry::load($mid);
		$t["mid"] = $mid;
		$t["moduleName"] = $reg->moduleName;
		$t["displayName"] = $reg->displayName;
		$arg->templateName = "mod_del";
	}



	/**
	 * do the deleteion
	 */
	function delRun ($db,&$u,&$arg,&$t) {
		$mid = $arg->postvars["mid"];
		$files = $arg->postvars["files"];

		$reg =  lcRegistry::load($mid);
		$moduleName = $reg->moduleName;
		$reg->delete($mid);

		if ($files) { 
			$thispath = getcwd(); 
			rec_del(INSTALLED_SERVICE_PATH."$moduleName/");
			@rmdir(INSTALLED_SERVICE_PATH."$moduleName/");

			chdir($thispath); 
		}


		$t["moduleName"] = $reg->moduleName;
		$t["displayName"] = $reg->displayName;
		$t["deleted"] = true;
		$t["message"] = "Module \"$moduleName\" deleted!";
		$arg->templateName = "mod_del";
	}

}


function rec_copy ($from_path,$to_path,$find="",$replace="") { 

$this_path = getcwd(); 
@mkdir($to_path,0777); 
@chmod($to_path,0777); 
//echo $from_path."<BR>".$to_path."<HR>";
if (is_dir($from_path)) { 
	chdir($from_path); 

	$handle=opendir('.'); 
	while (($file = readdir($handle))!==false) { 
		if (($file != ".") && ($file != "..")) { 
			if (is_dir($file)) { 
				rec_copy ($from_path.$file."/",$to_path.$file."/",$find,$replace); 
				chdir($from_path); 
			} 
			if (is_file($file)){ 
				$fromfile = $from_path.$file;
				$tofile = $to_path.$file;

				$f = fopen($fromfile,"r");
				$x = fread($f,filesize($fromfile));
				fclose($f);

				if (is_array($find)) { 
					while(list($k,$v) = @each($find)) { 
						$x = str_replace($find[$k],$replace[$k],$x);
					}
				} else { 
					$x = str_replace($find,$replace,$x);
				}	

				$f = fopen($tofile,"w");
				fputs($f,$x);
				fclose($f);
				chmod ($tofile,0777);
			}
		}
	}
//@rmdir($to_path); 
	closedir($handle); 
} 
}

function rec_del ($to_path) { 


$this_path = getcwd(); 

if (is_dir($to_path)) { 
	chdir($to_path); 

	$handle=opendir('.'); 
	while (($file = readdir($handle))!==false) { 
		if (($file != ".") && ($file != "..")) { 
			if (is_dir($file)) { 
				rec_del ($to_path.$file."/"); 
				@chdir($to_path); 
			} 
			if (is_file($file)){ 
				//echo "<BR>unlink $to_path$file<BR>";
				@unlink($to_path.$file); 
			}
		}
	}
//echo "<BR>remove $to_path<BR>";
@rmdir($to_path); 
	closedir($handle); 
} 

}



$this_path = getcwd(); 

if (is_dir($to_path)) { 
	chdir($to_path); 

	$handle=opendir('.'); 
	while (($file = readdir($handle))!==false) { 
		if (($file != ".") && ($file != "..")) { 
			if (is_dir($file)) { 
				rec_del ($to_path.$file."/"); 
				@chdir($to_path); 
			} 
			if (is_file($file)){ 
				//echo "<BR>unlink $to_path$file<BR>";
				@unlink($to_path.$file); 
			}
		}
	}
//echo "<BR>remove $to_path<BR>";
@rmdir($to_path); 
	closedir($handle); 
} 

?>
