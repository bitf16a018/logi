<?php

	//use a DOMXML function first to load libxml2, not libxml1
	@domxml_open_file();

	$glade = new GladeXML('./gui/pbdo.glade');

	$window = $glade->get_widget('window1');
	$window->connect('destroy','shutdown');

	$entry1 = $glade->get_widget('entry1');
	$win_output = $glade->get_widget('win_output');
	$text_output = $glade->get_widget('text_output');

	$go = $glade->get_widget('go_button');

	//attach file dialog to button
	$browse_button = $glade->get_widget('button1');
	$browse_button->connect('clicked','showdialog',$entry1);


	$go->connect('clicked','processXML');


	ob_start();
	gtk::main();

	//show file dialog
	function showdialog(&$button,&$entry) {
		$dialog = new GtkFileSelection();
		$dialog->show();
		$ok = $dialog->ok_button;
		$ok->connect('clicked','getfilename', $dialog);
	}


	function shutdown() {
		echo "caught shutdown...\n";
		gtk::main_quit();
		exit();
	}


	function getfilename($button,$d) {
		global $entry1;
		$entry1->set_text( $d->get_filename() );
		$d->hide();
	}


	function processXML() {
		global $entry1,$go,$win_output,$text_output;
		//for testing

		include_once('./compiler.php');
		include_once('./graphdef.php');
		$engine = new PBDO_Compiler();
		$engine->setFilename($entry1->get_text());
//		$engine->setFilename('/home/mkimsal1/cvs/PBDO/sampledata/table-schema.xml');

if (!defined('NO_PHP') ) define('NO_PHP',false);
if (!defined('NO_SQL') ) define('NO_SQL',false);
if (!defined('OLD_STYLE') ) define('OLD_STYLE',false);
if (!defined('PGSQL') ) define('PGSQL',false);
if (!defined('MSSQL') ) define('MSSQL',false);

		$staticNodes = $engine->compile();
		$projectName = $engine->projectName;



//do the parsing and compiling
if (PGSQL) {
	$engine->dbtype = 'pg';
	include('./sql_postgres.php');
}

if (MSSQL) {
	$engine->dbtype = 'ms';
	include('./sql_mssql.php');
}

for ($x=0; $x<count($staticNodes); ++$x) {
	$node = $staticNodes[$x];
	$node->xmlnode->tagname =  strtolower($node->xmlnode->tagname);
	$node->accept($engine);
}

//done parsing and compiling

//print output
print "\n";



//set foreign keys and one-to-many relations
foreach($engine->foreignKeys as $k => $v) {
	$foreignTable = $v[0]->attributes['foreignTable']->value;
	$localTable = $v[2];
	$localColumn = $v[1]->attributes['local']->value;
	$foreignColumn = $v[1]->attributes['foreign']->value;
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


	//print to files
	foreach($engine->classes as $k=>$v) {
		//find out if file already exists
		unset($saved);
		if ( file_exists('projects/'.$projectName.'/php/'.$v->name.'.php') ) {
			$file = fopen('projects/'.$projectName.'/php/'.$v->name.'.php','r+');
			//search for line that defines custom class
			while ($line = fgets($file,4096) ) {
				if ( $line == "class ".$v->name." extends ".$v->name."Base {\n"  ) {
					//save from here to end
					while ( $line = fgets($file,4096) ) 
					$saved .= $line;
				}
			}
			//write out everything but custom class
			print "Re-Writing 'projects/$projectName/php/".$v->name.".php'...\n";

			//append found custom class definition to end of $file
			$output = $v->toPHP(false);
			$output .=  $saved;
			fclose($file);
			$file = fopen('projects/'.$projectName.'/php/'.$v->name.'.php','w+');
			$output = "<?\n".$output;
			fputs($file,$output,strlen($output));
		} else {
			$file = fopen('projects/'.$projectName.'/php/'.$v->name.'.php','w+');
			print "Writing 'projects/$projectName/php/".$v->name.".php'...\n";
			$output = $v->toPHP();
			$output = "<?\n".$output."\n?>";
			fputs($file,$output,strlen($output));
			fclose($file);
		}
	}



	$graph = new PBDO_GraphManager($engine);
	$graph->strokeGraph();
	print "Writing 'projects/".$projectName."/graph/schema.png'...\n";
	$graph->saveGraph();

	$xxx = ob_get_contents();
	flush();
	flush();
	ob_end_clean();
	$text_output->insert(null,null,null,$xxx);
	$win_output->show_all();


	$label =& $go->children();// = 'Done';
	$label[0]->set_text('Done!');
}


?>
