<?php

class PBDO_SQLStatement {

	var $type;
	var $fields = array();
	var $nulls = array();
	var $values;
	var $key;
	var $keyValue;
	var $where;
	var $limit;
	var $offset;
	var $tableName = ' ';
	var $database;
	var $join     = '';

	function PBDO_SQLStatement($table,$where='') {
		$this->tableName = $table;
		$this->where = $where;
	}


	function andWhere(&$vals, $join = 'and') {
		$this->where .= $join ." ( ";
		while ( list($k,$v) = @each($vals) ) {
			if (gettype($v) == "string") {$v = "'$v'";}

			$this->where .= " $k = $v $join ";
		next($vals);
		}
		$this->where .= " ) ";
	}

	function toString() {
		return;
	}
}


class PBDO_SelectStatement extends PBDO_SQLStatement {

	var $type = "select";


	function toString() {
		$ret = "select ";
		$ret .= implode(",",$this->fields);
		$ret .=" from ".$this->tableName ." ";
		if ($this->join != "" ) {
			$ret .= $this->join;
		}
		if ($this->where != "" ) {
			$ret .= "where $this->where";
		}
	return $ret;
	}
}

class PBDO_UpdateStatement extends PBDO_SQLStatement {

	var $type = "update";

	function toString() {

		reset ($this->fields);
		if ( $this->key != '' ) {
			foreach ($this->fields as $k=>$v) {

				$v = addslashes($v);
				$set = '';
				if ( $this->key != $k) {
					//allow nulls
					if (isset($this->nulls[$k]) && $v == null) {
						$set .= "$k = NULL, ";
					} else {
						$set .= "$k = '$v', ";
					}
				} else {
					$keyName = $k;
					$keyValue = $v;
				}
			}
		}
		reset ($this->fields);

		$ret = "UPDATE " .$this->tableName;
		$ret .="\nSET ";
		$ret .= substr($set,0,-2) ." \n";
		$ret .= "WHERE $keyName = '$keyValue'";
	return $ret;
	}
}

class PBDO_InsertStatement extends PBDO_SQLStatement {

	var $type = "insert";

	function toString() {
		reset ($this->fields);
		if ( $this->key != '' ) {
			foreach ($this->fields as $k=>$v) {
				$v = addslashes($v);
				if ( $this->key != $k) {
					//allow nulls
					if (isset($this->nulls[$k]) && $v == null) {
						$newfields[$k] = "NULL";
					} else {
						$newfields[$k] = "'".$v."'";
					}
				}
			}
			reset ($this->fields);
			$fieldKeys = array_keys($newfields);
			$fieldVals = $newfields;
		} else {
			$fieldKeys = array_keys($this->fields);
			$fieldVals = $this->fields;
		}
		$ret = "INSERT INTO " .$this->tableName;
		$ret .="\n(`";
		$ret .= @implode("`,`",$fieldKeys);
		$ret .="`)\n";
		$ret .="VALUES\n(";
		$ret .= @implode(",",$fieldVals);
		$ret .=")\n";
		if ($this->where != "" ) {
			$ret .= "where $this->where";
		}
	return $ret;
	}
}

class PBDO_DeleteStatement extends PBDO_SQLStatement {

	var $type = "delete";

	function toString() {
		reset ($this->fields);
		if ( $this->key != '' ) {
			foreach ($this->fields as $k=>$v) {
				$v = addslashes($v);
				if ( $this->key != $k) {
					$newfields[$k] = $v;
				}
			}
		}
		reset ($this->fields);
		$ret = "DELETE FROM " .$this->tableName;
		if ($this->where != "" ) {
			$ret .= " where $this->where";
		} else {
			trigger_error("Delete called with no key");
			return false;
		}
	return $ret;
	}
}
?>
