<?php


class PBDO_ParsedDatabase_MS  extends PBDO_ParsedDatabase {


}


class PBDO_ParsedTable_MS extends PBDO_ParsedTable {

	var $name = '';
	var $columns = array();
	var $indexes = array();
	var $primaryKey = '';
	var $version;


	function ParsedTable_MS($n) {
		$this->name = $n;
	}


	function addColumn(&$c) {
		if ($c->primary) {
			$this->primaryKey = $c->name;
		}
		$this->columns[$c->name] = &$c;
	}


	function addIndex(&$i) {
		if ($i)
		$this->indexes[$i->name] = &$i;
	}


	function toSQL() {
		$ret = "-- Dumping SQL for project ".$this->name."\n-- entity version: ".$this->version."\n";
		$ret .= "-- DB type: mssql\n";
		$ret .="-- generated on: ".date('m.d.Y')."\n\n";

		//for all primary keys we will make a sequence
		// should we check and make something identity()?
#		if ( $this->primaryKey != '' ) {
#			$ret .= "CREATE SEQUENCE ".$this->name."_pkey;\n";
#		}


		$ret .= 'CREATE TABLE '.$this->name.' (
		';

		foreach($this->columns as $cname=>$column) {
			$ret .= "\n".$column->toSQL($this->name);
		}


		//add the primary key if it exists, treat differently than
		// other indexes (SQLite)
		if ( $this->primaryKey != '' ) {
			$ret .= "\n\tPRIMARY KEY (".$this->primaryKey."),  ";
		}

		$ret = substr($ret,0,-3);
		$ret .= "\n);\n";

		//add indexes at the end of the table,
		// works with more databases (SQLite)
		foreach($this->indexes as $iname=>$index) {
			$ret .= "\n".$index->toSQL();
		}

		//add indexes at the end of the table,
		// works with more databases (SQLite)
		foreach($this->constraints as $fkeyname=>$fkey) {
			$ret .= "\n".$fkey->toSQL();
		}


		if ( is_array($this->indexes) && count($this->indexes) > 0) {
			$ret = substr($ret,0,-2);
			$ret .= "\n\n";
		}

	return $ret;
	}

}


class PBDO_ParsedColumn_MS extends PBDO_ParsedColumn {

	var $name = '';
	var $index = false;
	var $type = 'INTEGER';
	var $size = 0;
	var $null = true;
	var $auto = false;
	var $primary = false;


	function ParsedColumn_MS($n) {
		$this->name = $n;
	}


	function toSQL($table) {
		$ret = "\t".$this->name." ".$this->type;
		if ($this->size > 0 ) {
			if (
			(strtolower(trim($this->type)) =='int') or  
			(strtolower(trim($this->type)) =='tinyint') or  
			(strtolower(trim($this->type)) =='smallint') or  
			(strtolower(trim($this->type)) =='datetime') or  
			(strtolower(trim($this->type)) =='timestamp') or  
			(strtolower(trim($this->type)) =='text')   
			)	
			{  // sql server doesn't like () after int
			#echo 'www';exit();
			} else {
				$ret .= " (".$this->size.")";
			}
		}

		//make the primary key use the sequence for it's default value
		if ( $this->auto ) {
			$ret .= " IDENTITY(1,1), \n";
			#$ret .= " DEFAULT NEXTVAL('".$table."_pkey'), \n";
			return $ret;
		}



		if ( !$this->null ) {
			$ret .= " NOT NULL";
		}


		$ret .= ", \n";
	return $ret;
	}


	function createFromXMLObj($node,&$x) {
		$x = new ParsedColumn_MS($node->attributes['name']->value);
		$x->type = $node->attributes['type']->value;
		$x->size = $node->attributes['size']->value;

		if ($node->attributes['required']->value == 'true') {
			$x->null = false;
		} else {
			$x->null = true;
		}

echo 'www';exit();

		if ($node->attributes['primaryKey']->value) {
			$x->primary = true;
			$x->null = false;
			if (eregi("int",$x->type)) { 
				$x->auto = true;
			}
		}
		if (is_object($index) ) {
			return $index;
		} else {
			return false;
		}
	}
}



class PBDO_ParsedIndex_MS extends PBDO_ParsedIndex {

	var $name = '';
	var $columns = array();
	var $table = '';
	var $unique;

	function ParsedIndex_MS($c,$n,$t) {
		if ( is_array($c) ) {
			$this->columns = $c;
		} else {
			$this->columns[0] = $c;
		}
		$this->name = $n;
		$this->table = $t;
	}

	function isUnique() {
		return $this->unique;
	}


	function toSQL() {
		if ($this->isUnique() ) {
			return "--PG\nCREATE UNIQUE INDEX ".$this->name." ON ".$this->table." (".$this->columns[0].");  ";
		}

		return "CREATE INDEX ".$this->name." ON ".$this->table." (".$this->columns[0].");  ";
	}
}


/**
 * foreign-keys
 */
class PBDO_ParsedConstraint_MS extends PBDO_ParsedConstraint {

	function toSQL() {
		return "ALTER TABLE [dbo].[".$this->localTable."] WITH NOCHECK ADD
		CONSTRAINT [".$this->name."] FOREIGN KEY
		(
			[".$this->localColumn."]
		) REFERENCES [".$this->foreignTable."] (
			[".$this->foreignColumn."]
		}
GO
";
	}
}


?>
