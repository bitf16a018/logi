<?php

//consistent way to use IDs
class PBDO_InternalModel {
	private $internalId;
	private $sourceVersion;
	private $internalVersion = 4.5;

	function setInternalId($i) {
		$this->internalId = $i;
	}

	function setVersion($v) {
		$this->sourceVersion = $v;
	}

}


class PBDO_ParsedDataModel extends PBDO_InternalModel {
	public $displayName = '';
	public $entities = array();
	private $version;
	private $currentId = 0;
	public $projectName = '';

	function PBDO_ParsedDataModel() {
	}
	
	
	function setProjectName($n) {
		$this->displayName = $n;
		$this->projectName = $n;
	}


	function addEntity($e) {
		++$this->currentId;
		$e->setInternalId($this->currentId);

		$this->entities[$this->currentId] = $e;
	}


}


class PBDO_ParsedEntity extends PBDO_InternalModel {
	public $displayName;
	private $attributes = array();
	public $package;
	public $language = 'php';
	private $generateFlag = 'all';

	function PBDO_ParsedEntity($n) {
		$this->displayName = $n;
	}


	function setPackage($p) {
		if ($p != '') {
			$this->package = ucfirst($p);
		}
	}


	function setLanguage($l) {
		if ($l != '') {
			$this->language = $l;
		}
	}


	function setGenerateFlag($f) {
		if ($f != '') {
			$this->generateFlag = $f;
		}
	}


	/**
	 * return a copy of the private attribs
	 */
	function getAttributes() {
		return $this->attributes;
	}


	/**
	 * Add an attribute to the current Entity
	 */
	function addAttribute($a) {
		++$this->currentId;
		$a->setInternalId($this->currentId);

		$this->attributes[$this->currentId] = $a;
	}

	/**
	 * Add a constraint to the current Entity
	 */
	function addConstraint(&$c) {
		if ($c) 
		$this->constraints[$c->name] = &$c;
	}



	function createFromXMLObj($obj) {
		$entity = new PBDO_ParsedEntity( 
						$obj->getAttribute('name')
						);
		$entity->setPackage( $obj->getAttribute('package') );
		$entity->setLanguage( $obj->getAttribute('language') );
		$entity->setGenerateFlag( $obj->getAttribute('generate') );

		return $entity;
	}

}



class PBDO_ParsedAttribute extends PBDO_InternalModel {

	public $name;
	public $colName;
	public $type;
	private $value;
	public $complex = false;
	private $possibleValues;
	private $codeType;
	private $isPrimary = false;


	function PBDO_ParsedAttribute($n,$t) {
		$t = strtolower($t);
		$this->name = $n;
		$this->type = $t;

		switch($t) {
		  case 'image':
		  case 'text':
		  case 'medtext':
		  case 'char':
		  case 'varchar':
		  	$this->codeType = 'String';
			break;
		  case 'int':
		  case 'identity':
		  case 'integer':
		  case 'date':
		  case 'datetime':
		  case 'timestamp':
		  	$this->codeType = 'int';
			break;
		}
	}


	function setPrimary($pk) {
		$this->isPrimary = $pk;
	}


	function isPrimary() {
		return $this->isPrimary;
	}


	function createFromXMLObj($obj) {
		foreach( $obj->attributes as $k=>$v) {
			if ($v->name == 'name') {
				$n = ( $obj->getAttribute($k) );
			}
			if ($v->name == 'type') {
				$t = ( $obj->getAttribute($k) );
			}
		}

		$x = new PBDO_ParsedAttribute($n,$t);

		$pk = $obj->getAttribute('primaryKey');
		if ( $pk ) {
			$x->setPrimary(true);
		}

		return $x;
	}

}


?>