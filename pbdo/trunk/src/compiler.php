<?php

/*************************************************
  * PHP Data Object compiler
  *************************************************/

#define ( "PHPDOM_INCLUDE_DIR", "./phpdom/" );
#include(PHPDOM_INCLUDE_DIR.'domhtml_document.php');


//requirements
//include ('codedef.php');
//include ('sqldef.php');

list ($name,$ext) = explode(".",$filename);
$name = ucfirst($name);
$document = DOMDocument::load($filename);
if (!$document) {
	die("ERROR: cannot parse $filename\n");
}


/*
$root = $document->firstChild;
$staticNodes = array();

extractNodes($root,$staticNodes);
*/


define('PBDO_VERSION',1.6);

function extractNodes($node,&$struct) {

static $loop = 0;

if ($loop > 2004 ) {print_r($struct); echo "Exceeded internal memory limit in compiler.php\n"; exit();}

	if ( strtolower(get_class($node)) != 'domelement'  ) return;

	$struct[$loop] = PBDO_NodeFactory::wrapNode($node);
$loop++;

	$kids = $node->childNodes;

	//foreach( $kids as $k=>$v ) {
	foreach( $kids as $v ) {
		extractNodes($v,$struct);
	}
}


class PBDO_Compiler {
	public $version 	= 1.3;


	///deprecated
	public $classes 		= array();
	public $foreignKeys 	= array();
	public $forms 		= array();
	public $database;
	///deprecated

	public $workingIndex;
	public $workingColumn;
	public $workingEntity;
	public $workingForm;
	public $workingRelationship;

	public $hasPDOM 		= false;
	public $dbtype 		= '';
	public $filename 		= '';
	public $generateCode 	= true;
	public $generateSQL 	= true;
	public $generateGraph 	= true;
	
	static public $model;


	/**
	 * Make singleton data model available to other parts of the code
	 */
	function getDataModel() {
		return PBDO_Compiler::$model;
	}



	/**
	 * XML file to parse
	 */
	function setFilename($f) {
		$this->filename = $f;
	}


	/**
	 * Parse the XML nodes into Node Wrappers (PBDO concept)
	 */
	function parse() {

		list ($name,$ext) = explode(".",$this->filename);
		$name = ucfirst($name);
		$document = DOMDocument::load($this->filename);
		if (!$document) {
			echo ("ERROR: cannot parse $this->filename\n");
			return false;
		}


		$root = $document->documentElement;
		$staticNodes = array();

		extractNodes($root,$staticNodes);


		reset($staticNodes);
		$count = 0;
		foreach($staticNodes as $k=>$v) { 
			$x[(int)$count] = $v;
			++$count;
		}

		return $x;
	}


	/**
	 * Run a visitor pattern on the PBDO Node Wrappers
	 */
	function compile() {
	
		$staticNodes = $this->parse();
		foreach($staticNodes as $k=>$v) { 
			$node = $staticNodes[$k];
			$node->accept($this);
		}
	
		//done parsing and compiling

		return $staticNodes;
	}















	/**
	 * Visitor pattern
	 */
	function visitEntityNode(&$table) {
		//php stuff
		unset($this->workingEntity);
		unset($this->workingForm);
//		$this->workingEntity = null;
//		$this->workingForm = null;
//unset($this->workingTable);

		//php stuff
		if ( strstr($table->xmlnode->getAttribute('generate'),'code') ||
		     strstr($table->xmlnode->getAttribute('generate'), 'all') ) {
			$this->workingEntity = PBDO_ParsedEntity::createFromXMLObj($table->xmlnode);
			$this->workingEntity->setVersion(PBDO_Compiler::$model->getVersion());
			PBDO_Compiler::$model->addEntity($this->workingEntity);
		}


//sql stuff
/*
if ( strstr($table->xmlnode->getAttribute('generate'), 'sql') ||
     strstr($table->xmlnode->getAttribute('generate'), 'all') ) {
	$this->workingTable = PBDO_ParsedTable::parsedTableFactory(
				$this->dbtype,
				$table->xmlnode->getAttribute('name'),
				$table->xmlnode->getAttribute('package')
				);

	$this->database->addTable($this->workingTable);
}
//*/
	}



	function visitAttributeNode(&$col) {
		//php stuff
		if ($this->workingEntity) {
			$att = PBDO_ParsedAttribute::createFromXMLObj($col->xmlnode);
			$this->workingEntity->addAttribute($att);
		}

		//sql stuff
/* DEPRECATED
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
		*/

		//form stuff

		/* TODO: NEED TO MAKE PLUGIN FOR THIS
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
		*/
	}


	function visitForeignKeyNode(&$fkey) {
		unset($this->workingRelationship);
		$this->workingRelationship = new PBDO_ParsedRelationship(
						@$this->workingEntity->name,
						$fkey->xmlnode->getAttribute('foreignTable')
					);
		PBDO_Compiler::$model->addRelationship($this->workingRelationship);
	}


	function visitReferenceNode(&$ref) {
		$this->workingRelationship->setAttribA( 
			$ref->xmlnode->getAttribute('local')
			);
		$this->workingRelationship->setAttribB( 
			$ref->xmlnode->getAttribute('foreign')
			);
	}


	function visitKeyNode(&$key) {
		//*
		unset($this->workingIndex);
		$this->workingIndex = new PBDO_ParsedKey(
					@$this->workingEntity->name.':'.
					$key->xmlnode->getAttribute('attribute'),
					$key->xmlnode->getAttribute('name')
				);

		if ($key->xmlnode->getAttribute('unique') == 'true') {
			$this->workingIndex->setUnique( true );
		}
		PBDO_Compiler::$model->addKey($this->workingIndex);
		/*
		if ($this->workingTable) {
			$this->workingTable->addIndex($this->workingIndex);
		}
		//*/
	}


	function visitProjectNode(&$p) {
	
		$dataModel = new PBDO_ParsedDataModel();
		$dataModel->projectName = $p->xmlnode->getAttribute('name');
		$dataModel->setVersion( $p->xmlnode->getAttribute('version') );

		PBDO_Compiler::$model =& $dataModel;
	}


	/*
	Move to a form plugin?
	TODO: Decide if this should be part of the XML
	
	function visitFormNode(&$form) {
		$panel = new PDOM_Panel();
		$panel->appendChild(new PDOM_Label($form->xmlnode->attributes['name']->value));
		$panel->appendChild(new PDOM_TextInput());
		$this->workingForm->appendChild($panel);
	}
	*/

}



class PBDO_NodeFactory {

	function wrapNode($n) {

		$nodeName = strtolower($n->localName);
		switch ($nodeName) {
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

	public $xmlnode;

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
		//set the default generate tag to 'all'
		$attrs =& $this->xmlnode->attributes->getNamedItem('generate');
		if ( !@strlen($attrs->nodeValue) ) { 
			//$owner = $this->xmlnode->ownerDocument;
			$this->xmlnode->setAttribute('generate', 'all' );
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
