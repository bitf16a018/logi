<?php

/*************************************************
  * PHP Data Object compiler
  *************************************************/

#define ( "PHPDOM_INCLUDE_DIR", "./phpdom/" );
#include(PHPDOM_INCLUDE_DIR.'domhtml_document.php');


//requirements
include ('codedef.php');
include ('sqldef.php');

list ($name,$ext) = explode(".",$filename);
$name = ucfirst($name);
$document = domxml_open_file($filename);
if (!$document) {
	die("ERROR: cannot parse $filename\n");
}



$root = $document->document_element();
$staticNodes = array();

extractNodes($root,$staticNodes);


define('PBDO_VERSION',1.4);

function extractNodes($node,&$struct) {

static $loop = 0;

if ($loop > 2003 ) {print_r($struct); exit();}

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
	var $version 		= 1.3;
	var $projectName	= 'PBDO-Project';
	var $classes 		= array();
	var $foreignKeys 	= array();
	var $forms 		= array();
	var $database;
	var $workingTable;
	var $workingIndex;
	var $workingColumn;
	var $workingClass;
	var $workingForm;
	var $workingConstraint;
	var $hasPDOM 		= false;
	var $dbtype 		= '';
	var $filename 		= '';
	var $generateCode 	= true;
	var $generateSQL 	= true;
	var $generateGraph 	= true;


	/**
	 * Ctor
	 */
	function PBDO_Compiler($projectName='PBDO-Project') {
		$this->projectName = $projectName;
		if ( function_exists('domxml_open_file') ){
		//	$this->hasPDOM = true;
		}
	}

	/**
	 * XML file to parse
	 */
	function setFilename($f) {
		$this->filename = $f;
	}


	/**
	 * Do the actual compilation
	 */
	function compile() {

		list ($name,$ext) = explode(".",$this->filename);
		$name = ucfirst($name);
		$document = domxml_open_file($this->filename);
		if (!$document) {
			echo ("ERROR: cannot parse $this->filename\n");
			return false;
		}


		$root = $document->document_element();
		$staticNodes = array();

		extractNodes($root,$staticNodes);


		reset($staticNodes);
		foreach($staticNodes as $k=>$v) { 
			$x[(int)$count] = $v;
			++$count;
		}
		$staticNodes = $x;
		$projectNode = $staticNodes[0];

		$this->projectName = $projectNode->xmlnode->attributes['name']->value;
		print "*****************".str_repeat('*',strlen($this->projectName))."**\n";
		print "* Project Name = $this->projectName *\n";
		print "*****************".str_repeat('*',strlen($this->projectName))."**\n";

		$this->createDirs();

		return $staticNodes;
	}


	/**
	 * Create necassary directories
	 */
	function createDirs() { 

		if (! file_exists("projects/".$this->projectName) ) {
			echo "making php dir\n";
			mkdir ("projects/".$this->projectName);
		} else {
			print "Project directory already exists (projects/".$this->projectName.")\n";
		}

		if ($this->generateCode
			&& ! file_exists("projects/".$this->projectName."/php") ) {

			echo "making php dir\n";
			mkdir ("projects/".$this->projectName."/php/");

			echo "making java dir\n";
			mkdir ("projects/".$this->projectName."/java/");
		}

		if ($this->generateSQL 
			&& ! file_exists("projects/".$this->projectName."/sql") ) {

			echo "making sql dir\n";
			mkdir ("projects/".$this->projectName."/sql/");
		}

		if ($this->generateSQL 
			&& ! file_exists("projects/".$this->projectName."/graph") ) {

			print "Making graph dir\n";
			mkdir ("projects/".$this->projectName."/graph/");
		}
	}


	/**
	 * Visitor pattern
	 */
	function visitEntityNode(&$table) {
		//php stuff
		unset($this->workingClass);
		unset($this->workingForm);
		unset($this->workingTable);

		//php stuff
		if ( strstr($table->xmlnode->attributes['generate']->value,'code') ||
		     strstr($table->xmlnode->attributes['generate']->value, 'all') ) {
			$this->workingClass = ParsedClass::createFromXMLObj($table->xmlnode);
			$this->workingClass->setVersion($this->database->version);
			$this->classes[$this->workingClass->tableName] =& $this->workingClass;
			print "Found one table (".$this->workingClass->name.")...\n";
		}

		//form stuff
		if ($this->hasPDOM) {
			if ( strstr($table->xmlnode->attributes['generate']->value,'form') ||
			     strstr($table->xmlnode->attributes['generate']->value, 'all') ) {
				$this->workingForm = new PDOM_Form();
				$this->forms[$this->workingClass->tableName] =& $this->workingForm;
			}
		}

		//sql stuff
		if ( strstr($table->xmlnode->attributes['generate']->value, 'sql') ||
		     strstr($table->xmlnode->attributes['generate']->value, 'all') ) {
			$this->workingTable = PBDO_ParsedTable::parsedTableFactory(
						$this->dbtype,
						$table->xmlnode->attributes['name']->value,
						$table->xmlnode->attributes['package']->value
						);

			$this->database->addTable($this->workingTable);
		}
	}



	function visitAttributeNode(&$col) {
		//php stuff
		if ($this->workingClass) {
			$att = ParsedAttribute::createFromXMLObj($col->xmlnode);
			$this->workingClass->addAttribute($att);
			if ($col->xmlnode->attributes['primaryKey']->value == 'true') {
				$this->workingClass->setOID($col->xmlnode->attributes['name']->value);
				$this->workingClass->setPkey($col->xmlnode->attributes['name']->value);
			}
		}

		//sql stuff
		if ($this->workingTable) {
			unset($this->workingColumn);
			unset($this->workingIndex);
//			$this->workingColumn = '';
			$this->workingIndex = PBDO_ParsedColumn::createFromXMLObj(
						$this->dbtype,
						$col->xmlnode,
						$this->workingColumn);
			$this->workingTable->addColumn($this->workingColumn);
			$this->workingTable->addIndex($this->workingIndex);
		}


		//form stuff

		if ($this->hasPDOM) {
			if ($this->workingForm) {
				if ($col->xmlnode->attributes['editable']->value == "true" ) {
					$panel = new PDOM_Panel();
					$label = new PDOM_Label($col->xmlnode->attributes['name']->value);
					$label->setAttribute('name',$col->xmlnode->attributes['name']->value);
					$panel->appendChild($label);

					$input = new PDOM_TextInput();
					$input->setAttribute('name',$col->xmlnode->attributes['name']->value);
					$panel->appendChild($input);
					$this->workingForm->appendChild($panel);
				}
			}
		}
	}


	function visitForeignKeyNode(&$fkey) {
		$this->foreignKeys[] = array($fkey->xmlnode,$staticNodes[++$x],$this->workingTable->name);
		//the code above is a little old, it just passes the dom node
		// along to the class
		unset($this->workingConstraint);
		$this->workingConstraint = 
			PBDO_ParsedConstraint::ParsedConstraintFactory(
					$this->dbtype,
					$this->workingTable->name,
					$fkey->xmlnode->attributes['foreignTable']->value
					);
		$this->workingTable->addConstraint($this->workingConstraint);
	}


	function visitKeyNode(&$key) {
		unset($this->workingIndex);
		$this->workingIndex = PBDO_ParsedIndex::parsedIndexFactory(
					$this->dbtype,
					$key->xmlnode->attributes['attribute']->value,
					$key->xmlnode->attributes['name']->value,
					$this->workingTable->name);

		if ($key->xmlnode->attributes['unique']->value == 'true') {
			$this->workingIndex->unique = true;
		}
		if ($this->workingTable) {
			$this->workingTable->addIndex($this->workingIndex);
		}
	}


	function visitProjectNode(&$p) {
		$this->database = PBDO_ParsedDatabase::parsedDatabaseFactory($this->dbtype,$this->projectName);
		$this->database->setVersion($p->xmlnode->attributes['version']->value);
	}


	function visitReferenceNode(&$ref) {
		$top = count($this->foreignKeys)-1;
		$this->foreignKeys[$top][1] = $ref->xmlnode;
		$this->workingConstraint->localColumn = 
			$ref->xmlnode->attributes['local']->value;
		$this->workingConstraint->foreignColumn = 
			$ref->xmlnode->attributes['foreign']->value;
//		print_r($ref);
	}


	function visitFormNode(&$form) {
		$panel = new PDOM_Panel();
		$panel->appendChild(new PDOM_Label($form->xmlnode->attributes['name']->value));
		$panel->appendChild(new PDOM_TextInput());
		$this->workingForm->appendChild($panel);
	}

}



class PBDO_NodeFactory {

	function wrapNode($n) {

		$n->tagname = strtolower($n->tagname);
		switch ($n->tagname) {
			case 'entity':
			case 'table':
				$v = new PBDO_EntityNode($n);
				break;
			case 'attribute':
			case 'column':
				$v = new PBDO_AttributeNode($n);
				break;
			case 'foreign-key':
				$v = new PBDO_ForeignKeyNode($n);
				break;
			case 'key':
				$v = new PBDO_KeyNode($n);
				break;
			case 'project':
				$v = new PBDO_ProjectNode($n);
				break;
			case 'database':
				$v = new PBDO_ProjectNode($n);
				break;
			case 'reference':
				$v = new PBDO_ReferenceNode($n);
				break;
			case 'form':
				$v = new PBDO_FormNode($n);
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

class PBDO_EntityNode extends PBDO_NodeBase {


	function PBDO_EntityNode($n) {
		$this->PBDO_NodeBase($n);
//		print get_class($this);exit();
		//set the default generate tag to 'all'
		if ( ! strlen($this->xmlnode->attributes['generate']) ) { 
			$owner = $this->xmlnode->owner_document();
			$this->xmlnode->attributes['generate'] = $owner->create_attribute('generate','all');
		}
	}
	
	function accept(&$v) {
		$v->visitEntityNode($this);
	}
}


class PBDO_AttributeNode extends PBDO_NodeBase {


	function accept(&$v) {
		$v->visitAttributeNode($this);
	}
}

class PBDO_ForeignKeyNode extends PBDO_NodeBase {


	function accept(&$v) {
		$v->visitForeignKeyNode($this);
	}
}

class PBDO_KeyNode extends PBDO_NodeBase {


	function accept(&$v) {
		$v->visitKeyNode($this);
	}
}

class PBDO_ProjectNode extends PBDO_NodeBase {


	function accept(&$v) {
		$v->visitProjectNode($this);
	}
}

class PBDO_ReferenceNode extends PBDO_NodeBase {


	function accept(&$v) {
		$v->visitReferenceNode($this);
	}
}

class PBDO_FormNode extends PBDO_NodeBase {


	function accept(&$v) {
		$v->visitFormNode($this);
	}
}
?>
