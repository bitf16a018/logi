<?php

class LC_SQLStatement {

	var $type;
	var $fields;
	var $values;
	var $key;
	var $keyValue;
	var $where;
	var $limit;
	var $offset;
	var $tableName = ' ';
	var $database;

	function LC_SQLStatement($table,$where='') {
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


class LC_SelectStatement extends LC_SQLStatement {

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

class LC_UpdateStatement extends LC_SQLStatement {

	var $type = "update";

	function toString() {

		reset ($this->fields);
		if ( $this->key != '' ) {
			foreach ($this->fields as $k=>$v) {
				$v = addslashes($v);
				if ( $this->key != $k) {
					$newfields[$k] = $v;
					$set .= "$k = '$v', ";
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

class LC_InsertStatement extends LC_SQLStatement {

	var $type = "insert";

	function toString() {
		reset ($this->fields);
		if ( $this->key != '' ) {
			foreach ($this->fields as $k=>$v) {
				$v = addslashes($v);
				if ( $this->key != $k) {
					$newfields[$k] = $v;
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
		$ret .="\n(";
		$ret .= @implode(",",$fieldKeys);
		$ret .=")\n";
		$ret .="VALUES\n('";
		$ret .= @implode("','",$fieldVals);
		$ret .="')\n";
		if ($this->where != "" ) {
			$ret .= "where $this->where";
		}
	return $ret;
	}
}

class LC_DeleteStatement extends LC_SQLStatement {

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
