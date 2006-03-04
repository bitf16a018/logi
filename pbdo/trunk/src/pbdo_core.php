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



function pbdocore($filename,$argv='',$settings='') { 

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

define('OUTPUT_DIR', $settings['OUTPUT_DIR']);


if ( OLD_STYLE ) {
	include(PBDO_PATH.'compiler-jakarta.php');
} else {
	include(PBDO_PATH.'compiler.php');
}

	include(PBDO_PATH.'graphdef.php');
	include(PBDO_PATH.'graphdef_astar.php');
	//include(PBDO_PATH.'graph/dot.php');
	include(PBDO_PATH.'htmldef.php');
	include(PBDO_PATH.'pbdo_plugin.php');
	@include (PBDO_PATH.'./domhtmlphp.php');




$engine = new PBDO_Compiler();
$engine->setFilename($filename);
$staticNodes = $engine->compile();

$projectName = PBDO_Compiler::$model->getProjectName();

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

//print output
print "\n";
//print_r(PBDO_Compiler::$model->relationships);


/*
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
*/
if ( !OLD_STYLE ) {
	foreach($engine->forms as $k=>$v) {
		if ( count($v->widgets) < 1 ) {
			continue;
		}
		$file = fopen(OUTPUT_DIR.$projectName.'/forms/'.$k.'.html','w+');
		print "Writing ".OUTPUT_DIR."projectName/forms/".$k.".html'...\n";
		$form = $v->toString();
		fputs($file,$form,strlen($form));
		fclose($file);
	}
}

//	$graph = new PBDO_GraphManager2($engine);
//	$graph->strokeGraph();
//	print "Writing 'projects/$projectName/graph/schema.png'...\n";
//	$graph->saveGraph();

//	$graph = new PBDO_HTMLManager($engine);
//	$graph->generateHTML();
//	print "Writing 'projects/$projectName/html/'...\n";
//	$graph->saveHTML();

	$pluginManager = new PBDO_PluginManager();
	
	$pluginManager->createNewPlugin('pbdo_plugin_code');
	$pluginManager->createNewPlugin('pbdo_plugin_sql');
	
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
	$sqlpath = (OUTPUT_DIR."$projectName/sql/");
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

		if (! file_exists(OUTPUT_DIR.$projectName) ) {
			echo "making php dir\n";
			mkdir (OUTPUT_DIR.$projectName);
		} else {
			print "Project directory already exists (".OUTPUT_DIR.$projectName.")\n";
		}
		print "Making graph dir\n";
		@mkdir (OUTPUT_DIR.$projectName."/graph/");

/* deprecated
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
