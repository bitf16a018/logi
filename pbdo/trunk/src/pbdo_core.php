<?

$temp = pathinfo(__FILE__);
define('PBDO_PATH',$temp['dirname'].'/');

include('pbdo_lib.php');

// core processing for pbdo
// should be able to be included by any library
// whether it's a pbdo_cli or gui or anything else


// check for domxml extension
if (! class_exists('DOMDocument') ) {
	include (PBDO_PATH.'dom-error.txt');
	exit();
}

function printHelp() {
?>
You must pass the name of an argument to this function.
Here are the arguments that were passed this time.

<?php
global $argv;
print_r($argv);

?>

Possible arguments include:
	without-php
	without-sql
	jakarta
	pgsql
	mssql
<?php
}



function pbdocore($filename,$argv='') { 

for ($qq=0; $qq<@count($argv); ++$qq) {

	if ($argv[$qq] == 'help' ) {
		printHelp();
		exit(0);
	}

	if ($argv[$qq] == 'without-sql' ) {
		define ('NO_SQL',true);
	}
	if ($argv[$qq] == 'without-php' ) {
		define ('NO_PHP',true);
	}
	if ($argv[$qq] == 'jakarta' ) {
		define ('OLD_STYLE',true);
	}
	if ($argv[$qq] == 'pgsql' ) {
		define ('PGSQL',true);
	}
	if ($argv[$qq] == 'mssql' ) {
		define ('MSSQL',true);
	}

}
if (!defined('NO_PHP') ) define('NO_PHP',false);
if (!defined('NO_SQL') ) define('NO_SQL',false);
if (!defined('OLD_STYLE') ) define('OLD_STYLE',false);
if (!defined('PGSQL') ) define('PGSQL',false);
if (!defined('MSSQL') ) define('MSSQL',false);


if ( OLD_STYLE ) {
	include(PBDO_PATH.'compiler-jakarta.php');
} else {
	include(PBDO_PATH.'compiler.php');
}

	//include(PBDO_PATH.'graphdef.php');
	//include(PBDO_PATH.'graph/dot.php');
	include(PBDO_PATH.'htmldef.php');
	include(PBDO_PATH.'pbdo_plugin.php');
	@include (PBDO_PATH.'./domhtmlphp.php');




$engine = new PBDO_Compiler();
$engine->setFilename($filename);
$staticNodes = $engine->compile();

//deprecated
//global $projectName;
$projectName = $engine->getProjectName();
print "*****************".str_repeat('*',strlen($projectName))."**\n";
print "* Project Name = $projectName *\n";
print "*****************".str_repeat('*',strlen($projectName))."**\n";

createDirs($projectName);


//do the parsing and compiling
if (PGSQL) {
	$engine->dbtype = 'pg';
	include(PBDO_PATH.'./sql_postgres.php');
}

if (MSSQL) {
	$engine->dbtype = 'ms';
	include(PBDO_PATH.'./sql_mssql.php');
}
foreach($staticNodes as $k=>$v) { 
	#for ($x=0; $x<count($staticNodes); ++$x) {
	$node = $staticNodes[$k];
//	$node->xmlnode->tagname =  strtolower($node->xmlnode->tagname);
	$node->accept($engine);
}

//done parsing and compiling

//print output
print "\n";

//set foreign keys and one-to-many relations
foreach($engine->foreignKeys as $k => $v) {
	$foreignTable = $v[0]->getAttribute('foreignTable');
	$localTable = $v[2];
	$localColumn = $v[1]->getAttribute('local');
	$foreignColumn = $v[1]->getAttribute('foreign');
	print "found FOREIGN table \t\t". $foreignTable . " ($foreignColumn)\n";
	print "relates to LOCAL table \t\t". $localTable . "\n";
	print "via LOCAL column \t\t". $localColumn . "\n\n";

	if ( is_object($engine->classes[$localTable]) ) {
		$engine->classes[$localTable]->setForeignKey($localColumn,$foreignTable);
	}
	if ( is_object ($engine->classes[$foreignTable]) ) {	//sometimes we reference DBs not in the XML
		$engine->classes[$foreignTable]->setForeignRelation($localTable,$foreignColumn,$localColumn);
	}

	if ( is_object($engine->classes[$localTable]) ) {
		$engine->classes[$localTable]->setLocalRelation($foreignTable,$localColumn,$foreignColumn);
	}
	print "\n";
}


if (!NO_PHP) {
	//print to files
	foreach($engine->classes as $k=>$v) {
		//find out if file already exists
		unset($saved);
		if ( file_exists("projects/".$projectName."/".$v->codeName."/".$v->name.".".$v->codeName) ) {
			$file = fopen("projects/".$projectName."/".$v->codeName."/".$v->name.".".$v->codeName,'r+');
			//search for line that defines custom class
			while ($line = fgets($file,4096) ) {
				if ( strpos($line, $v->name." extends ".$v->name."Base {\n")  ) {
					//save from here to end
					while ( $line = fgets($file,4096) ) 
					$saved .= $line;
				}
			}
			//write out everything but custom class
			print "Re-Writing 'projects/$projectName/".$v->codeName."/".$v->name.".".$v->codeName."'...\n";

			//append found custom class definition to end of $file
			$output = $v->toCode(false);
			$output .=  $saved;
			fclose($file);
			$file = fopen('projects/'.$projectName.'/'.$v->codeName.'/'.$v->name.'.'.$v->codeName,'w+');
			fputs($file,$output,strlen($output));
			fclose($file);
		} else {
			if ($v->codeName != 'java') {
			  $file = fopen('projects/'.$projectName.'/'.$v->codeName.'/'.$v->name.'.'.$v->codeName,'w+');
			  print "Writing 'projects/$projectName/".$v->codeName."/".$v->name.".".$v->codeName."'...\n";
			  $output = $v->toCode();
			  fputs($file,$output,strlen($output));
			  fclose($file);
			} else {
			  //do all 4 parts in one call, store internal to the object
			  $v->toCode();

			  $file = fopen('projects/'.$projectName.'/'.$v->codeName.'/'.$v->name.'Base.'.$v->codeName,'w+');
			  print "Writing 'projects/$projectName/".$v->codeName."/".$v->name."Base.".$v->codeName."'...\n";
			  $output = $v->baseClass;
			  fputs($file,$output,strlen($output));
			  fclose($file);

			  $file = fopen('projects/'.$projectName.'/'.$v->codeName.'/'.$v->name.'PeerBase.'.$v->codeName,'w+');
			  print "Writing 'projects/$projectName/".$v->codeName."/".$v->name."PeerBase.".$v->codeName."'...\n";
			  $output = $v->basePeer;
			  fputs($file,$output,strlen($output));
			  fclose($file);

			  $file = fopen('projects/'.$projectName.'/'.$v->codeName.'/'.$v->name.'Peer.'.$v->codeName,'w+');
			  print "Writing 'projects/$projectName/".$v->codeName."/".$v->name."Peer.".$v->codeName."'...\n";
			  $output = $v->peer;
			  fputs($file,$output,strlen($output));
			  fclose($file);

			  $file = fopen('projects/'.$projectName.'/'.$v->codeName.'/'.$v->name.'.'.$v->codeName,'w+');
			  print "Writing 'projects/$projectName/".$v->codeName."/".$v->name.".".$v->codeName."'...\n";
			  $output = $v->class;
			  fputs($file,$output,strlen($output));
			  fclose($file);


			}
		}
	}
}

if (!NO_SQL) {
	$type = 'mysql';
	if (MSSQL) { 
		$type = "mssql";
	} 
	foreach($engine->database->tables as $k=>$v) {
		$file = fopen('projects/'.$projectName.'/sql/'.$v->name.'.'.$type.'.sql','w+');
		print "Writing 'projects/$projectName/sql/".$v->name.'.'.$type.".sql'...\n";
		$sql = $v->toSQL();
		fputs($file,$sql,strlen($sql) );
		fclose($file);
	}
}

if ( !OLD_STYLE ) {
	foreach($engine->forms as $k=>$v) {
		if ( count($v->widgets) < 1 ) {
			continue;
		}
		$file = fopen('projects/'.$projectName.'/forms/'.$k.'.html','w+');
		print "Writing 'projects/$projectName/forms/".$k.".html'...\n";
		$form = $v->toString();
		fputs($file,$form,strlen($form));
		fclose($file);
	}
}

	//$graph = new PBDO_DotGraphManager($engine);
	//$graph->strokeGraph();
	//print "Writing 'projects/$projectName/graph/schema.png'...\n";
	//$graph->saveGraph();

//	$graph = new PBDO_HTMLManager($engine);
//	$graph->generateHTML();
//	print "Writing 'projects/$projectName/html/'...\n";
//	$graph->saveHTML();

	$pluginManager = new PBDO_PluginManager();
	
	$pluginManager->createNewPlugin('pbdo_plugin_code');
	
	
	$pluginManager->runPlugins();

	/*
	try to do the same .data.xml file as well
	*/
	$type = 'mysql';
	if (MSSQL) { 
		$type = "mssql";
	} 
	echo "Importing data files\n--------\n";
	$datafile = str_replace(".xml",".data.xml",$filename);
	$sqlpath = ("projects/$projectName/sql/");
	if (!file_exists($datafile)) { 
		echo ("\nCan't load the corresponding data file for $filename \n(looking for $datafile)\n\n");
	} else { 

	include(PBDO_PATH."./lib/basicxml.php");
	$xmlparser = new basicxml($datafile);
	$data = $xmlparser->parse();
	$xmlparser->close();
	foreach($data->database->data->table as $name=>$table) { 
		$tablename = $table->name;		
		echo "processing table $tablename\n";
		$sql = '';
		if (is_array($table->row)) {
		foreach($table->row as $num=>$row) { 
			$keys =array();
			$vals = array();
			
			foreach($row as $k=>$v) { 
				$keys[] = $k;
				$nv = base64_decode($v);
				if (eregi("<?",$nv) or eregi("</",$nv)) {
					$v = $nv;
				}
				if (MSSQL) { 
					$v = str_replace("'","''",$v);
				} else { 
					$v = str_replace("'","\'",$v);
				}
				$vals[] = $v;
			}
			$sqlkeys = implode(",",$keys);	
			$sqlvals = "'".implode("','",$vals)."'";	
			$sql .= "insert into $tablename ($sqlkeys) values ($sqlvals)\n";
		}

		$f = fopen($sqlpath.$tablename.".$type.data.sql","w");
		fputs($f,$sql);
		fclose($f);
		}
	} // end the 'else if'	
	}



} // 6048199 - bill rice	





	/**
	 * Create necassary directories
	 */
	function createDirs($projectName) { 

		if (! file_exists("projects/".$projectName) ) {
			echo "making php dir\n";
			mkdir ("projects/".$projectName);
		} else {
			print "Project directory already exists (projects/".$projectName.")\n";
		}
/* deprecated
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
*/
	}
?>
