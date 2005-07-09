<?
// +----------------------------------------------------------------------
// | PHP Source                                                           
// +----------------------------------------------------------------------
// | Copyright (C) 2005 by mark <mark@kimsal.com>
// +----------------------------------------------------------------------
// |
// | Copyright: See COPYING file that comes with this distribution
// +----------------------------------------------------------------------
//

class PBDO_Plugin_Code extends PBDO_Plugin {

	public $displayName = 'PBDO Code Generator';

	private $codeStack = array();

	/**
	 * create directories for storing the code
	 * turn internal data model into parsed code objects
	 */
	function initPlugin() {
		$projectName = $this->dataModel->projectName;
		$codeExt = 'php';
		$codePath = 'projects/'.$projectName.'/'.$codeExt.'/';

		echo "Starting Code Generation Plugin\n";
		echo "Grabbing global data model...\n";
		if (! file_exists($codePath) ) {
			echo "Creating Code Directory ... (".$codePath.") \n";
			@mkdir($codePath);
		} else {
			echo "Using Code Directory ... (".$codePath.") \n";
		}

		//echo "Found ". count($this->dataModel->entities)." Entities\n";
		echo "Converting ". count($this->dataModel->entities)." Entities to internal code objects...\n";
		
		foreach($this->dataModel->entities as $v) { 
			 $x = ParsedClass::createFromEntity($v);
			
			 $this->codeStack[] = $x;
			
		}
	}


	/**
	 * perform the physcal writing of the code objects to files
	 */
	function startPlugin() {
		$projectName = $this->dataModel->projectName;
		$codeExt = 'php';
		$codePath = 'projects/'.$projectName.'/'.$codeExt.'/';
		foreach($this->codeStack as $v) {
			//find out if file already exists
			unset($saved);
			if ( @file_exists($codePath.$v->codeName.".".$v->codeExt) ) {
				$file = 	fopen($codePath.$v->codeName.".".$v->codeExt,'r+');
				//search for line that defines custom class
				while ($line = fgets($file,4096) ) {
					if ( strpos($line, $v->codeName." extends ".$v->codeName."Base {\n")  ) {
						//save from here to end
						while ( $line = fgets($file,4096) ) 
						$saved .= $line;
					}
				}
				//write out everything but custom class
				print "Re-Writing '".$codePath.$v->codeName.".".$v->codeExt."'...\n";
	
				//append found custom class definition to end of $file
				$output = $v->toCode(false);
				$output .=  $saved;
				fclose($file);
				$file = fopen($codePath.$v->codeName.'.'.$v->codeExt,'w+');
				fputs($file,$output,strlen($output));
				fclose($file);
			} else {
				if ($v->codeExt != 'java') {
				  $file = fopen($codePath.$v->codeName.'.'.$v->codeExt,'w+');
				  print "Writing '".$codePath.$v->codeName.".".$v->codeExt."'...\n";
				  $output = $v->toCode();
				  fputs($file,$output,strlen($output));
				  fclose($file);
				} else {
				  //do all 4 parts in one call, store internal to the object
				  $v->toCode();
	
				  $file = fopen($codePath.$v->codeName.'Base.'.$v->codeExt,'w+');
				  print "Writing '".$codePath.$v->codeName."Base.".$v->codeExt."'...\n";
				  $output = $v->baseClass;
				  fputs($file,$output,strlen($output));
				  fclose($file);
	
				  $file = fopen($codePath.$v->codeName.'PeerBase.'.$v->codeExt,'w+');
				  print "Writing '".$codePath.$v->codeName."PeerBase.".$v->codeExt."'...\n";
				  $output = $v->basePeer;
				  fputs($file,$output,strlen($output));
				  fclose($file);
	
				  $file = fopen($codePath.$v->codeName.'Peer.'.$v->codeExt,'w+');
				  print "Writing '".$codePath.$v->codeName."Peer.".$v->codeExt."'...\n";
				  $output = $v->peer;
				  fputs($file,$output,strlen($output));
				  fclose($file);
	
				  $file = fopen($codePath.$v->codeName.'.'.$v->codeExt,'w+');
				  print "Writing '".$codePath.$v->codeName.".".$v->codeExt."'...\n";
				  $output = $v->class;
				  fputs($file,$output,strlen($output));
				  fclose($file);

				}
			}
		}
	}



	function destroyPlugin() {
		unset($this->codeStack);
	}
}




/**
 * Contains a definition of a class in memory
 *
 */
class ParsedClass {

	var $codeName;
	var $name;
	var $methods = array();
	var $attributes = array();
	var $relations = array();
	var $localRelations = array();
	var $oid = '';
	var $pkey = '';
	var $sourceVersion;
	var $package;

	var $codeExt = 'php';


	function ParsedClass($name,$package='') {
		$this->codeName = convertTableName($name);
		$this->tableName = $name;

		if ($package != '') {
			$this->package = ucfirst($package);
			$this->codeName = $this->package.'_'.$this->codeName;
//			$this->tableName = $this->tableName;
		}
	}

	function setVersion($v) {
		$this->sourceVersion = $v;
	}


	//code related
	function setOID($name) {
		$this->oid = convertColName($name);
	}


	//code related
	function getOID() {
		return $this->oid;
	}


	//DB related
	function setPkey($name) {
		return $this->pkey = $name;
	}


	//DB related
	function getPkey() {
		return $this->pkey;
	}



	/**
	 * create a code object for use by the code plugin
	 * from the PBDO internal data model
	 */
	function createFromEntity($entity) {

		switch ($entity->language) {
			case 'java':
			include_once('objtemplates/java.php');
			$class = new PlainJavaParsedClass( 
						$entity->displayName, 
						$entity->package 
						);
			break;
			default:
			$class = new ParsedClass( 
						$entity->displayName, 
						$entity->package 
						);
		}
		
		foreach ($entity->getAttributes() as $a) {
			$class->addAttribute( new ParsedAttribute($a->name, $a->type, $a->isPrimary() ));
			if ( $a->isPrimary() ) {
				$class->setPkey($a->name);
			}
		}
	return $class;
	}



	function addAttribute($a) {
		if ( $a->isPrimary() ) {
			$this->setOID($a->colName);
		}
		$this->attributes[$a->colName] =  $a;
	}


	function  printAttribs() {
		reset ($this->attributes);
		while ( list ($k,$v) = @each($this->attributes) ) {
			$ret .= "\t".$v->toPHP().";\n";
		}
		return $ret;
	}


	function  printAttribArray() {
		$ret .="\tvar \$__attributes = array(\n";
		reset ($this->attributes);
		while ( list ($k,$v) = @each($this->attributes) ) {
			if ($v->complex) {
			$ret .= "\t'".$v->codeName."'=>'".$v->type."',\n";
			} else {
			$ret .= "\t'".$v->codeName."'=>'".$v->type."',\n";
			}
		}
		$ret = substr($ret,0,-2);
		$ret .= ");\n";
		return $ret;
	}


	function setForeignKey($att,$table) {
		print " *** set for $att\n";
		print_r($this->attributes) ; 
		print "\n\n";
		if ( ! is_object($this->attributes[$att]) ) { die("$this->codeName $att is not an object\n"); }
		$this->attributes[$att]->type = convertTableName($table);
		$this->attributes[$att]->complex = true;
	}


	function setForeignRelation($table,$fcol,$lcol) {
		$this->relations[$table] = array($fcol,$lcol);
	}


	function setLocalRelation($table,$lcol,$fcol) {
		$this->localRelations[$lcol] = array($table,$fcol);
	}


	function printRelations() {
		$model = PBDO_Compiler::getDataModel();
		//foreign (assume one to many)
		@reset($model->relationships);
		while ( list ($q,$rel) = @each($model->relationships) ) {
			//not a foreign key
			if ( $rel->getEntityA() != $this->tableName ) { 
				continue;
			}
			$fcol = $rel->getAttribB();
			$lcol = $rel->getAttribA();

			$q = convertTableName($rel->getEntityB() ."By".ucfirst($lcol));
			$fCodeName = convertTableName($rel->getEntityB());

			$ret .= "\tfunction get".$q."(\$dsn='default') {\n";
			$ret .= "\t\tif ( \$this->".convertColName($lcol)." == '' ) { trigger_error('Peer doSelect with empty key'); return false; }\n";
			$ret .= "\t\t\$array = ".$fCodeName."Peer::doSelect('".$fcol." = \''.\$this->".convertColName($lcol).".'\'',\$dsn);\n";
			$ret .= "\t\tif ( count(\$array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }\n";
			//$ret .= "\t\treturn \$array;\n";
			$ret .= "\t\treturn \$array[0];\n";
			$ret .= "\t}\n\n";
		}

		//local (assume one to one)
		@reset($model->relationships);
		while ( list ($q,$rel) = @each($model->relationships) ) {
			//is a foreign key
			if ( $rel->getEntityB() != $this->tableName ) { 
				continue;
			}
			$lcol = $rel->getAttribB();
			$fcol = $rel->getAttribA();

			if ( substr($q,-1) == 's' ) { $s = ''; } else { $s ='s'; }
			$q = convertTableName($rel->getEntityA().$s."By".ucfirst($fcol));
			$fCodeName = convertTableName($rel->getEntityA());

			$ret .= "\tfunction get".$q."(\$dsn='default') {\n";
			$ret .= "\t\tif ( \$this->".convertColName($lcol)." == '' ) { trigger_error('Peer doSelect with empty key'); return false; }\n";
			$ret .= "\t\t\$array = ".$fCodeName."Peer::doSelect('".$fcol." = \''.\$this->".convertColName($lcol).".'\'',\$dsn);\n";
			$ret .= "\t\treturn \$array;\n";
			//$ret .= "\t\treturn \$array[0];\n";
			$ret .= "\t}\n\n";
		}

		return $ret;
	}

	function toPHP($extended = true) {
		while ( list ($k,$v) = @each($this->attributes) ) {
			if ( $v->complex ) {
				$complex[] = $v;
			}
		}
		@reset($this->attributes);



		$ret = '
class '.$this->codeName.'Base {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = \''.PBDO_VERSION.'\';	//PBDO version number
	var $_entityVersion = \''.$this->sourceVersion.'\';	//Source version number
'.$this->printAttribs().'
'.$this->printAttribArray().'
'.$this->printRelations().'

	function getPrimaryKey() {
		return $this->'.$this->getOID().';
	}

	function setPrimaryKey($val) {
		$this->'.$this->getOID().' = $val;
	}
	
	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey('.$this->codeName.'Peer::doInsert($this,$dsn));
		} else {
			'.$this->codeName.'Peer::doUpdate($this,$dsn);
		}
	}

	function load($key,$dsn="default") {
		if (is_array($key) ) {
			while (list ($k,$v) = @each($key) ) {
			$where .= "$k=\'$v\' and ";
			}
			$where = substr($where,0,-5);
		} else {
			$where = "'.$this->getPkey().'=\'".$key."\'";
		}
		$array = '.$this->codeName.'Peer::doSelect($where,$dsn);
		return $array[0];
	}

	function delete($deep=false,$dsn="default") {
		'.$this->codeName.'Peer::doDelete($this,$deep,$dsn);
	}


	function isNew() {
		return $this->_new;
	}

	function isModified() {
		return $this->_modified;

	}

	function get($key) {
		return $this->{$key};
	}

	function set($key,$val) {
		$this->_modified = true;
		$this->{$key} = $val;

	}

}


class '.$this->codeName.'PeerBase {

	var $tableName = \''.$this->tableName.'\';

	function doSelect($where,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_SelectStatement("'.$this->tableName.'",$where);
';
		@reset($this->attributes);
		while ( list ($k,$v) = @each($this->attributes) ) {
			$ret .="\t\t";
			$ret .= '$st->fields[\''.$v->colName.'\'] = \''.$v->colName.'\';';
			$ret .="\n";
		}

		$ret .='
		$st->key = $this->key;

		$array = array();
		$db->executeQuery($st);
		while($db->nextRecord() ) {
			$array[] = '.$this->codeName.'Peer::row2Obj($db->record);
		}
		return $array;
	}

	function doInsert(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_InsertStatement("'.$this->tableName.'");
';
		@reset($this->attributes);
		while ( list ($k,$v) = @each($this->attributes) ) {
			$ret .="\t\t";
			$ret .= '$st->fields[\''.$v->colName.'\'] = $this->'.$v->codeName.';';
			$ret .="\n";
		}


		$ret .='
		$st->key = \''.$this->getPkey().'\';
		$db->executeQuery($st);

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}

	function doUpdate(&$obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_UpdateStatement("'.$this->tableName.'");
';
		reset($this->attributes);
		while ( list ($k,$v) = @each($this->attributes) ) {
			$ret .="\t\t";
			$ret .= '$st->fields[\''.$v->colName.'\'] = $obj->'.$v->codeName.';';
			$ret .="\n";
		}

		$ret .='
		$st->key = \''.$this->getPkey().'\';
		$db->executeQuery($st);
		$obj->_modified = false;

	}

	function doReplace($obj,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		if ($this->isNew() ) {
			$db->executeQuery(new LC_InsertStatement($criteria));
		} else {
			$db->executeQuery(new LC_UpdateStatement($criteria));
		}
	}


	/**
	 * remove an object
	 */
	function doDelete(&$obj,$deep=false,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
		$st = new LC_DeleteStatement("'.$this->tableName.'","'.$this->getPkey().' = \'".$obj->getPrimaryKey()."\'");
';
		$ret .='
		$db->executeQuery($st);

		if ( $deep ) {
';

		@reset($this->relations);
		while ( list ($k,$v) = @each($this->relations) ) {
		$ret .='
			$st = new LC_DeleteStatement("'.$k.'","'.$v[1].' = \'".$obj->getPrimaryKey()."\'");
			$db->executeQuery($st);';
		}
		$ret .='
		}

		$obj->_new = false;
		$obj->_modified = false;
		$id =  $db->getInsertID();
		return $id;

	}



	/**
	 * send a raw query
	 */
	function doQuery(&$sql,$dsn="default") {
		//use this tableName
		$db = lcDB::getHandle($dsn);
';
		$ret .='
		$db->query($sql);

	  	return;
	}



	function row2Obj($row) {
		$x = new '.$this->codeName.'();
';
		reset($this->attributes);
		while ( list ($k,$v) = @each($this->attributes) ) {
			$ret .="\t\t";
			$ret .= '$x->'.$v->codeName.' = $row[\''.$v->colName.'\'];';
			$ret .="\n";
		}
		$ret .='
		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class '.$this->codeName.' extends '.$this->codeName.'Base {
';
if ($extended) {
$ret .= '


}



class '.$this->codeName.'Peer extends '.$this->codeName.'PeerBase {

}
';
}
		return $ret;
	}



	/**
	 * facade to get the proper language
	 */
	function toCode($extended = true) {
	  return "<?\n".$this->toPHP($extended). ($extended ? "\n?>" : "");
	}
}


/**
 * Contains a definition of a class method in memory
 *
 */
class ParsedMethod {

	var $name;
	var $return;
	var $arguments = array();
	var $description;

	function ParsedMethod($n) {
		$this->codeName = $n;
	}
}



/**
 * Contains a definition of a class attribute in memory
 *
 */
class ParsedAttribute {

	var $name;
	var $colName;
	var $type;
	var $value;
	var $complex = false;
	var $possibleValues;
	var $codeType;
	private $isPrimary = false;


	function ParsedAttribute($n, $t, $pk=false) {
		$t = strtolower($t);
		$this->codeName = convertColName($n);
		$this->colName = $n;
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

		$this->setPrimary($pk);
	}



	function setPrimary($pk) {
		$this->isPrimary = $pk;
	}


	function isPrimary() {
		return $this->isPrimary;
	}


	function toPHP() {
		return 'var $'.$this->codeName;
	}


	function toJava() {
		return 'public '.$this->codeType.' '.$this->codeName;
	}
}


function convertTableName($n, $package = '') {
	$n = ucfirst($n);
	//find all _s
	$undPos = strpos($n,'_');
	if ($undPos === false) {
		return $n;
	}

	//break apart word on the underscore
	$pieces = explode('_',$n);
	$n = null;
	foreach($pieces as $k=>$v) {
		$n .= ucfirst($v);
	}
	
	return $n;
}


function convertColName($n) {
	//find all _s
	$undPos = strpos($n,'_');
	if ($undPos === false) {
		return $n;
	}

	//break apart word on the underscore
	$pieces = explode('_',$n);
	$n = null;
	foreach($pieces as $k=>$v) {
		if ($k == 0 ) {
			$n .= $v;
		} else {
			$n .= ucfirst($v);
		}
	}
	
	return $n;
}
?>
