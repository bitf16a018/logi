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


	/**
	 * create directories for storing the code
	 * turn internal data model into parsed code objects
	 */
	function initPlugin() {
		$projectName = $this->dataModel->projectName;
		$sqlExt = 'sql';
		$codePath = 'projects/'.$projectName.'/'.$sqlExt.'/';

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
		
		foreach($this->dataModel->entities as $v) { 
			 $x = ParsedClass::createFromEntity($v);
			
			 $this->codeStack[] = $x;
			
		}
	}
}
?>