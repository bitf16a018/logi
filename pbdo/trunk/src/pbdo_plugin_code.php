<?

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
			if ( @file_exists($codePath.$v->name.".".$v->codeName) ) {
				$file = 	fopen($codePath.$v->name.".".$v->codeName,'r+');
				//search for line that defines custom class
				while ($line = fgets($file,4096) ) {
					if ( strpos($line, $v->name." extends ".$v->name."Base {\n")  ) {
						//save from here to end
						while ( $line = fgets($file,4096) ) 
						$saved .= $line;
					}
				}
				//write out everything but custom class
				print "Re-Writing '".$codePath.$v->name.".".$v->codeName."'...\n";
	
				//append found custom class definition to end of $file
				$output = $v->toCode(false);
				$output .=  $saved;
				fclose($file);
				$file = fopen($codePath.$v->name.'.'.$v->codeName,'w+');
				fputs($file,$output,strlen($output));
				fclose($file);
			} else {
				if ($v->codeName != 'java') {
				  $file = fopen($codePath.$v->name.'.'.$v->codeName,'w+');
				  print "Writing '".$codePath.$v->name.".".$v->codeName."'...\n";
				  $output = $v->toCode();
				  fputs($file,$output,strlen($output));
				  fclose($file);
				} else {
				  //do all 4 parts in one call, store internal to the object
				  $v->toCode();
	
				  $file = fopen($codePath.$v->name.'Base.'.$v->codeName,'w+');
				  print "Writing '".$codePath.$v->name."Base.".$v->codeName."'...\n";
				  $output = $v->baseClass;
				  fputs($file,$output,strlen($output));
				  fclose($file);
	
				  $file = fopen($codePath.$v->name.'PeerBase.'.$v->codeName,'w+');
				  print "Writing '".$codePath.$v->name."PeerBase.".$v->codeName."'...\n";
				  $output = $v->basePeer;
				  fputs($file,$output,strlen($output));
				  fclose($file);
	
				  $file = fopen($codePath.$v->name.'Peer.'.$v->codeName,'w+');
				  print "Writing '".$codePath.$v->name."Peer.".$v->codeName."'...\n";
				  $output = $v->peer;
				  fputs($file,$output,strlen($output));
				  fclose($file);
	
				  $file = fopen($codePath.$v->name.'.'.$v->codeName,'w+');
				  print "Writing '".$codePath.$v->name.".".$v->codeName."'...\n";
				  $output = $v->class;
				  fputs($file,$output,strlen($output));
				  fclose($file);

				}
			}
		}
	}



	function destroyPlugin() {

	}
}

/**
 * Contains a definition of a class in memory
 *
 */
class ParsedClass {

	var $name;
	var $tableName;
	var $methods = array();
	var $attributes = array();
	var $relations = array();
	var $localRelations = array();
	var $oid = '';
	var $pkey = '';
	var $sourceVersion;
	var $package;

	var $codeName = 'php';


	function ParsedClass($name,$package='') {
		$this->name = convertTableName($name);
		$this->tableName = $name;

		if ($package != '') {
			$this->package = ucfirst($package);
			$this->name = $this->package.'_'.$this->name;
			$this->tableName = $package.'_'.$this->tableName;
		}
	}

	function setVersion($v) {
		$this->sourceVersion = $v;
	}


	//code related
	function setOID($name) {
//		print "*** set oid = $name\n";
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
			$class->addAttribute( new ParsedAttribute($a->name,$a->type));
		}
//print_r($entity);exit();
		return $class;

	}


	/**
	 * @DEPRECATED
	 */
	function createFromXMLObj($obj) {
		switch ($obj->getAttribute('language')) {
			case 'java':
			include_once('objtemplates/java.php');
			$class = new PlainJavaParsedClass( 
						$obj->getAttribute('name'), 
						$obj->getAttribute('package') 
						);
			break;
			default:
			$class = new ParsedClass( 
						$obj->getAttribute('name'), 
						$obj->getAttribute('package') 
						);
		}
		return $class;
	}


	function addAttribute($a) {
		$this->attributes[$a->colName] =  $a;
	}


	function  printAttribs() {
		reset ($this->attributes);
		while ( list ($k,$v) = @each($this->attributes) ) {
			$ret .= "\t".$v->toPHP().";\n";
		}
		return $ret;
	}


	function  printPea() {
		$ret .="\tvar \$__attributes = array(\n";
		reset ($this->attributes);
		while ( list ($k,$v) = @each($this->attributes) ) {
			if ($v->complex) {
			$ret .= "\t'".$v->name."'=>'".$v->type."',\n";
			} else {
			$ret .= "\t'".$v->name."'=>'".$v->type."',\n";
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
		if ( ! is_object($this->attributes[$att]) ) { die("$this->name $att is not an object\n"); }
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
		//foreign (assume one to many)
		reset($this->relations);
		while ( list ($q,$col) = @each($this->relations) ) {
			$fcol = $col[0];
			$lcol = $col[1];

			$q = convertTableName($q);
			if ( substr($q,-1) == 's' ) { $s = ''; } else { $s ='s'; }
			$ret .= "\tfunction get".$q.$s."(\$dsn='default') {\n";
			$ret .= "\t\t\$array = ".$q."Peer::doSelect('".$fcol." = \''.\$this->getPrimaryKey().'\'',\$dsn);\n";
			$ret .= "\t\treturn \$array;\n";
			$ret .= "\t}\n\n";
		}

		//local (assume one to one)
		@reset($this->localRelations);
		while ( list ($col,$qs) = @each($this->localRelations) ) {
			$q = $qs[0];
			$fcol = $qs[1];
			$q = convertTableName($q);
			$ret .= "\tfunction get".$q."(\$dsn='default') {\n";
			$ret .= "\t\tif ( \$this->".convertColName($col)." == '' ) { trigger_error('Peer doSelect with empty key'); return false; }\n";
			$ret .= "\t\t\$array = ".$q."Peer::doSelect('".$col." = \''.\$this->".convertColName($fcol).".'\'',\$dsn);\n";
			$ret .= "\t\tif ( count(\$array) > 1 ) { trigger_error('multiple objects on one-to-one relationship'); }\n";
			$ret .= "\t\treturn \$array[0];\n";
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
class '.$this->name.'Base {

	var $_new = true;	//not pulled from DB
	var $_modified;		//set() called
	var $_version = \''.PBDO_VERSION.'\';	//PBDO version number
	var $_entityVersion = \''.$this->sourceVersion.'\';	//Source version number
'. $this->printAttribs().'
'.$this->printPea().'
'.$this->printRelations().'

	function getPrimaryKey() {
		return $this->'.$this->getOID().';
	}

	function setPrimaryKey($val) {
		$this->'.$this->getOID().' = $val;
	}
	
	function save($dsn="default") {
		if ( $this->isNew() ) {
			$this->setPrimaryKey('.$this->name.'Peer::doInsert($this,$dsn));
		} else {
			'.$this->name.'Peer::doUpdate($this,$dsn);
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
		$array = '.$this->name.'Peer::doSelect($where,$dsn);
		return $array[0];
	}

	function delete($deep=false,$dsn="default") {
		'.$this->name.'Peer::doDelete($this,$deep,$dsn);
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

	/**
	 * set all properties of an object that aren\'t
	 * keys.  Relation attributes must be set manually
	 * by the programmer to ensure security
	 */
	function setArray($array) {
';
		@reset($this->attributes);
		while ( list ($k,$v) = @each($this->attributes) ) {
			$skip = false;
			//don't print pkey
			if ($k == $this->getPkey() ) {
				$skip = true;
			}

			//don't one to manys
			reset($this->relations);
			while ( list ($kk,$vv) = each($this->relations) ) {
				if ($vv == $k) { 
					$skip = true;
				}
			}

			//don't one to ones
			reset($this->localRelations);
			while ( list ($kk,$vv) = each($this->localRelations) ) {
				if ($kk == $k) { 
					$skip = true;
				}
			}

			if (!$skip) {
			$ret .="\t\t";
			//this is the best way of checking for an empty value
			// if (empty($s) && strlen($s) == 0)
			$ret .= 'if ( empty($array[\''.$v->name.'\']) && strlen($array[\''.$v->name.'\']) == 0 )';
			$ret .="\n";
			$ret .="\t\t\t";
			$ret .= '$this->'.$v->name.' = $array[\''.$v->name.'\'];';
			$ret .="\n";
			}
		}
		$ret .='
		$this->_modified = true;
	}

	function getPea() {
		$p = new BasePea();
		$p->setAttributes($this->__attributes);
		return $p;
	}

}


class '.$this->name.'PeerBase {

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
			$array[] = '.$this->name.'Peer::row2Obj($db->record);
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
			$ret .= '$st->fields[\''.$v->colName.'\'] = $this->'.$v->name.';';
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
			$ret .= '$st->fields[\''.$v->colName.'\'] = $obj->'.$v->name.';';
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
		$x = new '.$this->name.'();
';
		reset($this->attributes);
		while ( list ($k,$v) = @each($this->attributes) ) {
			$ret .="\t\t";
			$ret .= '$x->'.$v->name.' = $row[\''.$v->colName.'\'];';
			$ret .="\n";
		}
		$ret .='
		$x->_new = false;
		return $x;
	}

		
}


//You can edit this class, but do not change this next line!
class '.$this->name.' extends '.$this->name.'Base {
';
if ($extended) {
$ret .= '


}



class '.$this->name.'Peer extends '.$this->name.'PeerBase {

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
		$this->name = $n;
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


	function ParsedAttribute($n,$t) {
		$t = strtolower($t);
		$this->name = convertColName($n);
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

		$x = new ParsedAttribute($n,$t);
		return $x;
	}


	function toPHP() {
		return 'var $'.$this->name;
	}


	function toJava() {
		return 'public '.$this->codeType.' '.$this->name;
	}
}


function convertTableName($n) {
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
