<?php

class PBDO_PluginManager {
	private $pluginList = array();
	
	function createNewPlugin ($className,$dir='') {
		if (! class_exists($className) ) {
			include($dir.$className.'.php');
		}

		$this->pluginList[] = new $className();
	}
	
	function runPlugins() {
		foreach($this->pluginList as $plugin) {
			ob_end_flush();
			flush();
			flush();
			echo "Plugin Manager: Initializing Plugin (".$plugin->displayName.")\n";
			$plugin->initPlugin();
			echo "Plugin Manager: Starting Plugin (".$plugin->displayName.")\n";
			$plugin->startPlugin();
			echo "Plugin Manager: Destroying Plugin (".$plugin->displayName.")\n";
			$plugin->destroyPlugin();
		}
	}
}


class PBDO_Plugin {

	var $displayName;
	protected $dataModel;

	

	function PBDO_Plugin () {
		$this->dataModel =& PBDO_Compiler::getDataModel();
	}


	function initPlugin() {

	}


	function startPlugin() {

	}


	function destroyPlugin() {

	}
}



class PBDO_Plugin_DataExport extends PBDO_Plugin {

	var $displayName;
	var $class;
	

	function initPlugin() {

	}


	function startPlugin() {

	}


	function destroyPlugin() {

	}
}
