<?php

class PBDO_ParsedDatabase {
	var $name = '';
	var $tables = array();
	var $create = false;
	var $version;

	function PBDO_ParsedDatabase($n) {
		$this->name = $n;
	}

	function setVersion($v) {
		$this->version = $v;
		if (!$this->version) $this->version = '0.0';
	}


	function addTable(&$t) {
		$t->projectName = $this->name;
		$t->version = $this->version;
		$this->tables[$t->name] = &$t;
	}


	function toSQL() {
		foreach($this->tables as $tname=>$table) {
			$table->projectName = $this->name;
			$ret .= "\n".$table->toSQL();
		}
	return $ret;
	}


	/**
	 * @static
	 */
	function parsedDatabaseFactory($type,$name) {

		switch($type) {
			case 'pg':
				return new PBDO_ParsedDatabase_PG($name);
				break;
			case 'ms':
				$j = new PBDO_ParsedDatabase_MS($name);
				return $j;
				break;
			default:
				return new PBDO_ParsedDatabase($name);
		}
	}


}


class PBDO_ParsedTable {

	var $name = '';
	var $comment = '';
	var $columns = array();
	var $indexes = array();
	var $primaryKey = '';
	var $version;
	var $constraints = array();
	var $projectName = '';


	function PBDO_ParsedTable($n,$package='') {
		if ($package != '') {
			$this->name = $package.'_'.$n;
		} else {
			$this->name = $n;
		}
		//print_r($this);
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


	function addConstraint(&$c) {
		if ($c) 
		$this->constraints[$c->name] = &$c;
	}


	function toSQL() {
		$ret = "-- Dumping SQL for project ".$this->projectName."\n-- entity version: ".$this->version."\n";
		$ret .= "-- DB type: mysql\n";
		$ret .="-- generated on: ".date('m.d.Y')."\n\n";
		$ret .= 'DROP TABLE IF EXISTS `'.$this->name.'`;
';
		$ret .= 'CREATE TABLE `'.$this->name.'` (
		';
		foreach($this->columns as $cname=>$column) {
			$ret .= "\n".$column->toSQL();
		}


		//add the primary key if it exists, treat differently than
		// other indexes (SQLite)
		if ( $this->primaryKey != '' ) {
			$ret .= "\n\tPRIMARY KEY (".$this->primaryKey."),  ";
		}

		$ret = substr($ret,0,-3);
		$ret .= "\n)TYPE=InnoDB;\n";

		//add indexes at the end of the table,
		// works with more databases (SQLite)
		foreach($this->indexes as $iname=>$index) {
			$ret .= "\n".$index->toSQL();
		}

		if ( is_array($this->indexes) && count($this->indexes) > 0) {
			$ret = substr($ret,0,-2);
			$ret .= "\n\n";
		}

	return $ret;
	}


	function parsedTableFactory($type,$n,$p) {
		switch($type) {
			case 'pg':
				return new PBDO_ParsedTable_PG($n,$p);
				break;
			case 'ms':
				return new PBDO_ParsedTable_MS($n,$p);
				break;
			default:
				return new PBDO_ParsedTable($n,$p);
		}
	}

}


class PBDO_ParsedColumn {

	var $name = '';
	var $index = false;
	var $type = 'INTEGER';
	var $size = 0;
	var $null = true;
	var $auto = false;
	var $primary = false;
	var $xtra = '';
	var $description = '';


	function PBDO_ParsedColumn($n) {
		$this->name = $n;
	}


	function toSQL() {
		$ret = "\t`".$this->name."` ".$this->type;
		if ($this->size > 0 ) {
			$ret .= " (".$this->size.")";
		}
		if ( $this->extra ) {
			$ret .= " ".$this->extra;
		}
		if ( !$this->null ) {
			$ret .= " NOT NULL";
		}
		if ( $this->auto ) {
			$ret .= " auto_increment";
		}
		$ret .= ", ";
		$ret .= " -- ".$this->description;
		$ret .= "\n";
	return $ret;
	}


	function createFromAttribute($type,$attrib) {
		$x = PBDO_ParsedColumn::parsedColumnFactory( $type,$attrib->name );
		$x->type = trim( $attrib->type );
		$x->size = $attrib->getSize();
		$x->description = $attrib->description;
		$x->extra = $attrib->extra;


		print_r($attrib);
		if ($attrib->required == 'true') {
			$x->null = false;
		} else {
			$x->null = true;
		}

		if ( $attrib->isPrimary() ) {
			$x->primary = true;
			$x->null = false;
			if (eregi("int",$x->type)) { 
			$x->auto = true;
			}
		}


		if ($x->type=='longvarchar') { 
			$x->type='text';
			$x->size='';
		}
		if ($x->type=='longtext') { 
			$x->type='text';
			$x->size='';
		}
		if ($x->type=='tinytext') { 
			$x->type='varchar';
			$x->size=255;
		}
		if ($x->type=='mediumtext') { 
			$x->type='varchar';
			$x->size=255;
		}
		if ($x->type=='date') { 
			$x->type='datetime';
		}
		if ($x->type=='blob') { 
			$x->type='text';
		}
		if ($x->type=='mediumint') { 
			$x->type='int';
		}
		if ($x->type=='String') {
			$x->type='varchar';

		}
		// __FIXME__
		// Making SIZE to empty for MySQL -
		// we need to override this method for MS and PG
		if ($x->type=='datetime') { 
			$x->size='';
		}

	return $x;
	}


	function parsedColumnFactory($type,$n) {
		switch($type) {
			case 'pg':
				return new PBDO_ParsedColumn_PG($n);
				break;
			case 'ms':
				return new PBDO_ParsedColumn_MS($n);
				break;
			default:
				return new PBDO_ParsedColumn($n);
		}
	}

}



class PBDO_ParsedIndex {

	var $name = '';
	var $columns = array();
	var $table = '';
	var $unique;

	function PBDO_ParsedIndex($c,$n,$t) {
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
			return "CREATE UNIQUE INDEX ".$this->name." ON ".$this->table." (".$this->columns[0].");  ";
		}

		return "CREATE INDEX ".$this->name." ON ".$this->table." (".$this->columns[0].");  ";
	}



	/**
	 * @staic
	 */
	function parsedIndexFactory($type,$c,$n,$t) {

		switch($type) {
			case 'pg':
				return new PBDO_ParsedIndex_PG($c,$n,$t);
				break;
			case 'ms':
				return new PBDO_ParsedIndex_MS($c,$n,$t);
				break;
			default:
				return new PBDO_ParsedIndex($c,$n,$t);
		}
	}
}


/**
 * foreign-keys
 */
class PBDO_ParsedConstraint {
	var $name          = '';
	var $localTable    = '';
	var $localColumn   = '';
	var $foreignTable  = '';
	var $foreignColumn = '';

	function toSQL() {

	}

  	function generateName() {
		$this->name = 'FK_'.$this->localTable.'_'.$this->foreignTable;
	}

  	function PBDO_ParsedConstraint($l,$f,$n='') {
	  $this->localTable   = $l;
	  $this->foreignTable = $f;
	  if ($n == '') {
		$this->generateName();
	  } else {
		$this->name = $n;
	  }
	}


	/**
	 * @staic
	 */
	function parsedConstraintFactory($type,$l,$f,$n='') {

		switch($type) {
			case 'pg':
				return new PBDO_ParsedConstraint_PG($l,$f,$n);
				break;
			case 'ms':
				return new PBDO_ParsedConstraint_MS($l,$f,$n);
				break;
			default:
				return new PBDO_ParsedConstraint($l,$f,$n);
		}
	}
}

?>
