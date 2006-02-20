<?php
// +----------------------------------------------------------------------
// | PHP Source                                                           
// +----------------------------------------------------------------------
// | Copyright (C) 2005 by mark <mark@kimsal.com>
// +----------------------------------------------------------------------
// |
// | Copyright: See COPYING file that comes with this distribution
// +----------------------------------------------------------------------
//



class PBDO_Plugin_Sql extends PBDO_Plugin {

	public $displayName = 'PBDO Sql Generator';
	
	private $database;
	private $type = 'mysql';
	private $outputDir = '';

	/**
	 * create directories for storing the code
	 * turn internal data model into parsed code objects
	 */
	function initPlugin($outputDir) {
		include('plugins/pbdo_plugin_sql/sqldef.php');
		$projectName = $this->dataModel->projectName;
		$sqlExt = 'sql';
		$this->outputDir = $outputDir;
		$codePath = $this->outputDir.$projectName.'/'.$sqlExt.'/';

		echo "Starting Sql Generation Plugin\n";
		echo "Grabbing global data model...\n";
		if (! file_exists($codePath) ) {
			echo "Creating Sql Directory ... (".$codePath.") \n";
			@mkdir($codePath);
		} else {
			echo "Using Sql Directory ... (".$codePath.") \n";
		}

		//echo "Found ". count($this->dataModel->entities)." Entities\n";
		echo "Converting ". count($this->dataModel->entities)." Entities to internal SQL objects...\n";


		$this->database = new PBDO_ParsedDatabase($this->dataModel->projectName);
		$this->database->setVersion( $this->dataModel->getVersion() );
		foreach($this->dataModel->entities as $v) { 
			unset($x);
			$x = new PBDO_ParsedTable($v->name);
			foreach($v->attributes as $attr) {
				unset($a);
				$a = PBDO_ParsedColumn::createFromAttribute('mysql',$attr);
				$x->addColumn($a);
			}


			foreach($this->dataModel->keys as $j) { 
				if ($j->belongsToTable($v->name)) {
					unset($y);
					$y = PBDO_ParsedIndex::parsedIndexFactory($this->type,$j->getAttribute(),$j->getName(),$j->getEntity());
					$x->addIndex($y);
					echo "*** adding index (".$y->name. ") to table (". $x->name .") on attribute (".$j->getAttribute().") \n";
				}
			}

			$this->database->addTable($x);
		}
	}


	function startPlugin() {
		$projectName = $this->dataModel->projectName;
		$type = $this->type;
		foreach($this->database->tables as $k=>$v) {
			$file = fopen($this->outputDir.$projectName.'/sql/'.$v->name.'.'.$type.'.sql','w+');
			print "Writing '".$this->outputDir."$projectName/sql/".$v->name.'.'.$type.".sql'...\n";
			$sql = $v->toSQL();
			fputs($file,$sql,strlen($sql) );
			fclose($file);
		}
	}


	function destroyPlugin() {
		unset($this->database);
	}

}
?>
