<?php

/**
 * Provide a consisten way to keep track
 * of internal IDs and version numbers
 */
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
	public $relationships = array();
	public $projectName = 'PBDO-Unnamed Project';
	private $projectVersion;
	private $currentId = 0;


	function PBDO_ParsedDataModel() {
	}
	
	
	function setProjectName($n) {
		$this->displayName = $n;
		$this->projectName = $n;
	}


	function getProjectName() {
		return $this->projectName;
	}


	function addEntity($e) {
		++$this->currentId;
		$e->setInternalId($this->currentId);

		$this->entities[$this->currentId] = $e;
	}


	function addRelationship(&$r) {
		++$this->currentId;
		$r->setInternalId($this->currentId);

		$this->relationships[$this->currentId] = $r;
	}


	function setVersion($v) {
		$this->projectVersion = $v;
	}


	function getVersion() {
		return $this->projectVersion;
	}
}


/**
 * Represent an Entity of a Data Model
 */
class PBDO_ParsedEntity extends PBDO_InternalModel {
	public $displayName;
	public $name;
	private $attributes = array();
	public $package;
	public $language = 'php';
	private $generateFlag = 'all';

	function PBDO_ParsedEntity($n) {
		$this->displayName = $n;
		$this->name = $n;
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


/**
 * Represent an Attribute of an Entity
 */
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



/**
 * Represent a Relationship of one Entity to another
 *
 * Refer to entities as A and B instead of Primary and Secondary
 * or parent and child.
 */
class PBDO_ParsedRelationship extends PBDO_InternalModel {


	public $type = 2;
	private $entityA;
	private $entityB;
	private $attribA;
	private $attribB;

	public static $PBDO_ONE_TO_ONE = 1;
	public static $PBDO_ONE_TO_MANY = 2;
	public static $PBDO_MANY_TO_MANY = 3;

	function PBDO_ParsedRelationship($a,$b) {
		$this->setEntityA($a);
		$this->setEntityB($b);
	}


	/**
	 * Don't try to make a distinction like first or second
	 * between the entities, because the relationship might
	 * not give the same distinction (many to many)
	 */
	function setEntityA($ea) {
		$this->entityA = $ea;
	}


	/**
	 * Don't try to make a distinction like first or second
	 * between the entities, because the relationship might
	 * not give the same distinction (many to many)
	 */
	function setEntityB($eb) {
		$this->entityB = $eb;
	}


	/**
	 * Don't try to make a distinction like first or second
	 * between the entities, because the relationship might
	 * not give the same distinction (many to many)
	 */
	function setAttribA($aa) {
		$this->attribA = $aa;
	}


	/**
	 * Don't try to make a distinction like first or second
	 * between the entities, because the relationship might
	 * not give the same distinction (many to many)
	 */
	function setAttribB($ab) {
		$this->attribB = $ab;
	}



	function getEntityA() {
		return $this->entityA;
	}


	function getEntityB() {
		return $this->entityB;
	}


	function getAttribA() {
		return $this->attribA;
	}


	function getAttribB() {
		return $this->attribB;
	}

}

?>