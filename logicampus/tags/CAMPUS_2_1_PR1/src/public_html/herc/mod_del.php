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

class mod_del extends HercAuth {

//	var $presentor = "plainPresentation";
	var $presentor = "configurePresentation";

	function run($db,&$u,&$arg,&$t) {

		$mid = $arg->getvars["mid"];
		$reg =  lcRegistry::load($mid);
		print_r($reg);exit();
		$reg->mid = $mid;

		$t["mid"] = $mid;
		$t["moduleName"] = $reg->moduleName;
		$t["diplayName"] = $reg->displayName;
		$arg->templateName = "mod_del";
	}

	function delRun ($db,&$u,&$arg,&$t) {
		$mid = $arg->postvars["mid"];
		$files = $arg->postvars["files"];

		$reg = new registry("lcRegistry","mid");
		$reg->mid = $mid;
		$reg->_get($mid);
		$moduleName = $reg->moduleName;
		$reg->_delete($mid);

		$c = new config();
		$c->mid = $mid;
		$c->_delete();


		if ($files) { 
			$thispath = getcwd(); 
			rec_del(INSTALLED_SERVICE_PATH."$moduleName/");
			@rmdir(INSTALLED_SERVICE_PATH."$moduleName/");

			chdir($thispath); 
		}

		$t["message"] = "Module \"$moduleName\" deleted!";
		$this->Run($db,$u,$arg,$t);
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


/*
 * class baseObject
 * provides basic object to SQL mappings
 */



class baseObject {

		function baseObject($pkey="") { 
			$this->_pkey="pkey";
		}

        function _get($pkey) {

                $db = DB::getHandle();
                $sql = "select * from ".$this->_tableName." where ".$this->_key."='$pkey'";
				$db->query($sql);
				while($db->next_record()) {
                        arrayIntoObject($this,$db->Record);
                }
        }


        function _getbyVal($val="pkey",$valToGet,$orderby="",$how="=") {
                $db = DB::getHandle();
                if ($orderby) { $orderby = " order by $orderby"; }
                if ($how=="like") {
                        $sql = "select * from ".$this->_tableName." where $val like '%$valToGet%' $orderby";
                } else {
                        $sql = "select * from ".$this->_tableName." where $val='$valToGet' $orderby";
                }

                $db->query($sql);


                while($db->next_record()) {
                        $idarray[] = $db->Record;
                }
                $this->_Array = $idarray;
        }

        function _getPkeyName($username,$orderby="") {
                $db = DB::getHandle();
                if ($orderby) { $o = " order by  ".$this->_tablePrefix."$orderby"; }
                $sql = "select pkey,".$this->_name." from ".$this->_tableName." where  ".$this->_tablePrefix."username = '$username' $o";
                $db->query($sql);
                while($db->next_record()) {
                        $idarray[$db->Record[0]] = $db->Record[1];
                }
                $this->_Array = $idarray;
        }

        function _getPkeySchoolID($schoolID,$orderby="") {
                $db = DB::getHandle();
                if ($orderby) { $o = " order by  $orderby"; }
                $sql = "select pkey,".$this->_name." from ".$this->_tableName." where  schoolID = '$schoolID' $o";
                $db->query($sql);
                while($db->next_record()) {
                        $idarray[$db->Record[0]] = $db->Record[1];
                }

                $this->_Array = $idarray;
        }


        function _getAll($username="",$orderby="",$clause="") {

                $db = DB::getHandle();
                $where = " where 1=1 ";
                if ($username) { $where .= " and ".$this->_tablePrefix."username='$username'"; }
                if ($clause) { $where .= " and $clause "; }
                if ($orderby) { $o = " order by  ".$this->_tablePrefix."$orderby"; }
                $sql = $this->_getAllSQL." $where ".$this->_extrawhere." $o";
                $db->query($sql);

                while($db->next_record()) {
                        $idarray[] = $db->Record;
                }
                $this->_Array = $idarray;
        }



        function _getAllSchoolID($schoolID="",$orderby="",$clause="") {

                $db = DB::getHandle();
                $where = " where 1=1 ";
                if ($schoolID) { $where .= " and schoolID = $schoolID"; }
                if ($clause) { $where .= " and $clause "; }
                if ($orderby) { $o = " order by $orderby"; }
                $sql = $this->_getAllSQL." $where ".$this->_extrawhere." $o";
                $db->query($sql);
                while($db->next_record()) {
                        $idarray[] = $db->Record;
                }
                $this->_Array = $idarray;
        }


        function _add() {
                $db = DB::getHandle();
                $sql = objectToSQL($this,$this->_tableName);
				$db->query($sql);
                $this->insertID =  $db->getInsertID();
        }

        function _update() {
                $db = DB::getHandle();
                $sql = objectToSQL($this,$this->_tableName,$this->_key,"update");
                $db->query($sql);

        }

        function _delete($pkey="") {
                $db = DB::getHandle();
                if ($pkey=="") { $pkey=$this->pkey; }
                $sql = "delete from $this->_tableName where ".$this->_key." = '$pkey'";
                $db->query($sql);

        }

}





/*
 * array to Object
 * no return = object is passed by reference
 *
 */

function arrayIntoObject (&$object,$array) {
while(list($key,$val)=@each($array)) {
        if (!is_numeric($key)) {
                if ($v2 = @unserialize($val)) { $val = $v2; }
                $object->$key = $val;
        }
}
}

/*
 * put values from array2 into array1
 * (array merge?) - but not
 * array1 is overwritten by array2 if there are conflicts
 * RETURNS an array
 */
function arrayIntoArray ($array1,$array2) {
while(list($key,$val)=@each($array2)) {
        $array1[$key] = $val;
}
return $array1;
}

/*
 * put key values from object into an array
 * no return = array is passed by reference
 */
function objectIntoArray ($object,&$array) {
        $oarray = get_object_vars($object);
        while(list($key,$val)=each($oarray)) {
                $array[$key] = $val;
        }
}


/*
 * objectToSQL
 * take an object ($school, $user) (or array)
 * and create SQL call to insert or update
 * inserts can be based on a field ($field)
 * (where clause)
 *
 * $object is object, $table is tablename, $field is fieldname for whereclause
 * update is "add"  or "update"
 */

function objectToSQL($object,$table,$field="",$update="add") {
        if (is_array($object)) {
                while(list($k,$v) = each($object)) {
                        if (!is_numeric($k)) {
                                $array[$k] = $v;
                        }
                }
        } else {
                $array = get_object_vars($object);
        }
        while(list($key,$val) = @each($array)) {
          if (substr($key,0,1)!="_") {
                if ($k1) { $k1 .= ","; }
                if ($v1) { $v1 .= ","; }
                if ($k2) { $k2 .= ","; }
                $q = "'";
                if (is_numeric($val)) {
                        $q="";
                }
                if (is_array($val) || is_object($val)) {
                        $val = @serialize($val);
                } else { 
			$val = addslashes(stripslashes($val));
		}
                $k1 .= $key;
                $v1 .= "$q$val$q";
                $k2 .= "$key=$q$val$q";
                if ($key==$field) {
                        $fieldval="$q$val$q";
                }
          }
        }
        if ($update=="add") {
                $sql = "insert into $table ($k1) values ($v1)";
        }
        if ($update=="update") {
                $sql = "update $table set $k2 where $field=$fieldval";
        }
        return $sql;
}

class registry extends baseObject {

	function registry($tablename="lcRegistry",$key="mid") {
		$this->_tableName = $tablename;
		$this->_key = $key;
	}

	function _getTrans() { 
		return array("insertID");
	}
}
class config extends baseObject {

	function config($tablename="lcConfig",$key="mid") {
		$this->_tableName = $tablename;
		$this->_key = $key;
	}

	function _getTrans() { 
		return array("insertID");
	}
}
?>
