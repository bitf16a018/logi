<?php

/*************************************************
  * PHP Data Object compiler
  *************************************************/

#define ( "PHPDOM_INCLUDE_DIR", "./phpdom/" );
#include(PHPDOM_INCLUDE_DIR.'domhtml_document.php');

$argv = $_SERVER['argv'];
$argc = $_SERVER['argc'];

if ($filename == '') {
	if (count($argv) <= 1 ) {
		printHelp();
		exit(1);
	}
	$filename = $argv[1];
}



function printHelp() {
?>
You must pass the name of an argument to this function.
Here are the arguments that were passed this time.

<?php
global $argv;
print_r($argv);

}



//requirements
include ('codedef.php');
include ('sqldef.php');

list ($name,$ext) = explode(".",$filename);
$name = ucfirst($name);
$document = domxml_open_file($filename);



$root = $document->document_element();
$staticNodes = array();

extractNodes($root,$staticNodes);





function extractNodes($node,&$struct) {

static $loop = 0;

if ($loop > 1003 ) {print_r($struct); exit();}

	if ($node->type ==3 ) return;
	$attr = $node->attributes();
	while ( list (,$v)  = @each($attr) ){
		$node->attributes[$v->name] = $v;
	}
	$struct[$loop] = PBDO_NodeFactory::wrapNode($node);
$loop++;

	$kids = $node->child_nodes();

	while ( list($k,$v) = each($kids) ) {
		extractNodes($v,$struct);

	}
}



class PBDO_Compiler {
	var $version = 1.1;
	var $projectName = 'PBDO-Project';
	var $classes = array();
	var $foreignKeys = array();
	var $database;
	var $workingTable;
	var $workingIndex;
	var $workingColumn;
	var $workingClass;

	function PBDO_Compiler($projectName) {
		$this->projectName = $projectName;
	}


	function visitTableNode(&$table) {
		//php stuff
		unset($this->workingClass);
		$this->workingClass = ParsedClass::createFromXMLObj($table->xmlnode);
		$this->classes[$this->workingClass->tableName] =& $this->workingClass;
		print "Found one table ({$this->workingClass->name})...\n";

		//sql stuff
		unset($this->workingTable);
		$this->workingTable = new ParsedTable($table->xmlnode->attributes['name']->value);
		$this->database->addTable($this->workingTable);
	}



	function visitColumnNode(&$col) {
		//php stuff
		$att = ParsedAttribute::createFromXMLObj($col->xmlnode);
		$this->workingClass->addAttribute($att);
		if ($col->xmlnode->attributes['primaryKey']->value == 'true') {
			$this->workingClass->setOID($col->xmlnode->attributes['name']->value);
			$this->workingClass->setPkey($col->xmlnode->attributes['name']->value);
		}

		//sql stuff
		unset($this->workingColumn);
		unset($this->workingIndex);
		$this->workingColumn = '';
		$this->workingIndex = ParsedColumn::createFromXMLObj($col->xmlnode,$this->workingColumn);
		$this->workingTable->addColumn($this->workingColumn);
		$this->workingTable->addIndex($this->workingIndex);
	}

	function visitForiegnKeyNode(&$fkey) {
		$this->foreignKeys[] = array($fkey->xmlnode,$staticNodes[++$x],$this->workingClass->tableName);
	}

	function visitKeyNode(&$key) {
		unset($this->workingIndex);
		$this->workingIndex = new ParsedIndex($key->xmlnode->attributes['column']->value,$key->xmlnode->attributes['name']->value);

		if ($key->xmlnode->attributes['unique']->value == 'true') {
			$this->workingIndex->unique = true;
		}
		$this->workingTable->addIndex($this->workingIndex);
	}


	function visitDatabaseNode(&$db) {
		$this->database = new ParsedDatabase($this->projectName);
	}


	function visitReferenceNode(&$ref) {
		$top = count($this->foreignKeys)-1;
		$this->foreignKeys[$top][1] = $ref->xmlnode;
	}
}



class PBDO_NodeFactory {

	function wrapNode($n) {

		switch ($n->tagname) {
			case 'table':
				$v = new PBDO_TableNode($n);
				break;
			case 'column':
				$v = new PBDO_ColumnNode($n);
				break;
			case 'foreign-key':
				$v = new PBDO_ForeignKeyNode($n);
				break;
			case 'key':
				$v = new PBDO_KeyNode($n);
				break;
			case 'database':
				$v = new PBDO_DatabaseNode($n);
				break;
			case 'reference':
				$v = new PBDO_ReferenceNode($n);
				break;
			default:
				$v = new PBDO_NodeBase($n);
		}
	return $v;
	}
}


class PBDO_NodeBase {

	var $xmlnode;

	function PBDO_NodeBase($n) {
		$this->xmlnode = $n;
	}

	function accept($v) {
		print "* XXX\n";
		print "Cannot accept this visitor.\n";
		print_r($v);
		print "* XXX\n";
	}
}

class PBDO_TableNode extends PBDO_NodeBase {


	function accept(&$v) {
		$v->visitTableNode($this);
	}
}


class PBDO_ColumnNode extends PBDO_NodeBase {


	function accept(&$v) {
		$v->visitColumnNode($this);
	}
}

class PBDO_ForeignKeyNode extends PBDO_NodeBase {


	function accept(&$v) {
		$v->visitForiegnKeyNode($this);
	}
}

class PBDO_KeyNode extends PBDO_NodeBase {


	function accept(&$v) {
		$v->visitKeyNode($this);
	}
}

class PBDO_DatabaseNode extends PBDO_NodeBase {


	function accept(&$v) {
		$v->visitDatabaseNode($this);
	}
}

class PBDO_ReferenceNode extends PBDO_NodeBase {


	function accept(&$v) {
		$v->visitReferenceNode($this);
	}
}


?>
