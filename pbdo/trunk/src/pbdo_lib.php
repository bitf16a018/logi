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
	public $keys = array();
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


	function addKey(&$k) {
		++$this->currentId;
		$k->setInternalId($this->currentId);

		$this->keys[$this->currentId] = $k;
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
	public $attributes = array();
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
	public $size;
	private $value;
	public $complex = false;
	private $possibleValues;
	private $codeType;
	private $isPrimary = false;
	private $isRequired = false;
	public $description = '';


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


	/**
	 * desired size of this attribute
	 * Directly translates into SQL column size for now
	 */
	function setSize($s) {
		$this->size = $s;
	}


	function getSize() {
		return $this->size;
	}


	/**
	 * Can the attribute hold a NULL value?
	 */
	function setRequired($r) {
		if ( strtolower($r) == 'false') {
			$this->isRequired = false;
		} else {
			$this->isRequired = true;
		}
	}


	function getRequired() {
		return $this->isRequired;
	}


	function setPrimary($pk) {
		$this->isPrimary = $pk;
	}


	function isPrimary() {
		return $this->isPrimary;
	}


	/**
	 * Sets things like UNSIGNED
	 */
	function setExtra($e) {
		$this->extra = $e;
	}


	function getExtra() {
		return $this->extra;
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
		$x->setSize( $obj->getAttribute('size') );
		$x->description = $obj->getAttribute('description');
		$x->setExtra($obj->getAttribute('extra'));
		$x->setRequired($obj->getAttribute('required'));

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


/**
 * Represents an index on one or more attributes
 * Internal representations of an attribute use 
 * the string format of 'table:attribute'
 */
class PBDO_ParsedKey extends PBDO_InternalModel {

	private $name;
	private $attributes = array();
	private $isUnique = false;


	/**
	 * Attribute uses the string format of 'table:attribute'
	 */
	function PBDO_ParsedKey($a,$n=null) {
		$this->setAttribute($a);
		$this->setName($n);
	}


	function setName($n) {
		$this->name = $n;
	}


	function getName() {
		return $this->name;
	}


	function setAttribute($c,$i=0) {
		$this->attributes[$i] = $c;
	}


	function getEntity($i=0) {
		list($table,$col) = split(':',$this->attributes[$i]);
		return $table;
	}


	function getAttribute($i=0) {
		list($table,$col) = split(':',$this->attributes[$i]);
		return $col;
	}


	/**
	 * Return true or false if this index
	 * relies on an attribute of a given table
	 */
	function belongsToTable($t) {
		foreach ($this->attributes as $k=>$v) {
			list($table,$col) = split(':',$v);
			if ($t== $table)
				return true;
		}
		return false;
	}
}

?>
