<?

/*
 * class baseObject
 * provides basic object to SQL mappings
 */
/*
 * has been replaced by PersistantObject
 * only included in some places as 
 * stopgap until specific modules are upgraded to use PO
 */



class baseObject {


        function _get($pkey) {

                $db = DB::getHandle();
                        $sql = "select * from ".$this->_tableName." where pkey='$pkey'";
                $db->query($sql);

                while($db->nextRecord()) {
                        arrayIntoObject($this,$db->record);
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


                while($db->nextRecord()) {
                        $idarray[] = $db->record;
                }
                $this->_Array = $idarray;
        }

        function _getPkeyName($username,$orderby="") {
                $db = DB::getHandle();
                if ($orderby) { $o = " order by  ".$this->_tablePrefix."$orderby"; }
                $sql = "select pkey,".$this->_name." from ".$this->_tableName." where  ".$this->_tablePrefix."username = '$username' $o";
                $db->query($sql);
                while($db->nextRecord()) {
                        $idarray[$db->record[0]] = $db->record[1];
                }
                $this->_Array = $idarray;
        }

        function _getPkeySchoolID($schoolID,$orderby="") {
                $db = DB::getHandle();
                if ($orderby) { $o = " order by  $orderby"; }
                $sql = "select pkey,".$this->_name." from ".$this->_tableName." where  schoolID = '$schoolID' $o";
                $db->query($sql);
                while($db->nextRecord()) {
                        $idarray[$db->record[0]] = $db->record[1];
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

                while($db->nextRecord()) {
                        $idarray[] = $db->record;
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
                while($db->nextRecord()) {
                        $idarray[] = $db->record;
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
                $sql = objectToSQL($this,$this->_tableName,"pkey","update");
                $db->query($sql);

        }

        function _delete($pkey="") {
                $db = DB::getHandle();
                if ($pkey=="") { $pkey=$this->pkey; }
                $sql = "delete from $this->_tableName where pkey = '$pkey'";
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



?>
