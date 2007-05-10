<?


/**
 * Manipulate the registry table, access current module parameters
 *
 * EXAMPLES:
 * $reg = new registry(); // suitable for creating a blank entry (adding a new entry?)
 * $reg = registry::load("app"); // $reg is now an object with detail on registry entry for "app"
 * $reg->delete(); // deletes the current registry entry
 * lcRegistry::delete("app"); // deletes registry entry to  mid='app'
 * $reg->save(); // saves current entry
 */

class lcRegistry extends PersistantObject {

	var $config = array();

	/**
	 * Returns all modules that are currently registered
	 *
	 * @return 	array 	List of lcRegistry objects
	 */
	function getAll() { 
		$db = DB::getHandle();
		$db->query("select mid  from lcRegistry order by k",false); 
		while($db->next_record()) { 
			$ar[] = lcRegistry::load($db->Record[0]);
		}
		return $ar;
	}


	/**
	 * Fetches on lcRegistry object of the given ID 
	 *
	 * @param	string	$mid	ModuleID to load
	 * @return 	object 	lcRegistry object
	 * @static
	 */
	function load($mid) { 
		$x =  PersistantObject::_load("lcRegistry","lcRegistry",$mid,"*","mid");
		if ($mid) { 
			$db = DB::getHandle();
			$db->query("select k,v,type,extra from lcConfig where mid='".$x->mid."' order by k",false);
			while($db->next_record()) { 
				$x->config[$db->Record['k']] = $db->Record['v'];
				$x->type[$db->Record['k']] = $db->Record['type'];
				$x->extra[$db->Record['k']] = $db->Record['extra'];
			}

			lcRegistry::singleton($x);
		}
		return $x;
	}


	/**
	 * Deletes the object
	 *
	 * Can be called with or without a module id
	 *
	 * @see PersistantObject
	 * @return void
	 */
	function delete($mid="") {
		if ($mid!="") { 
			PersistantObject::_delete('lcRegistry',$mid,"mid");
		} else {
			$this->_delete('lcRegistry',$this->mid,"mid");
		}
	}


	/**
	 * Saves the object
	 *
	 * @see PersistantObject
	 * @return void
	 */
	function save() {
		$this->_save('lcRegistry');
	}


	/**
	 * returns the currently loaded module
	 *
	 * @return	object	lcRegistry object representing the current module
	 * @static
	 */
	function getCurrentModule() {
		return lcRegistry::singleton();
	}


	/**
	 * returns the currently loaded module's display name
	 *
	 * @return	string	display name of the current module
	 * @static
	 */
	function getModuleDisplayName() {
		$temp = lcRegistry::singleton();
		return $temp->displayName;
	}


	/**
	 * returns the currently loaded module's config variables
	 *
	 * @return	array	hash of the current module's configs
	 * @static
	 */
	function getModuleConfig() {
		$temp = lcRegistry::singleton();
		return $temp->config;
	}


	/**
	 * returns the currently loaded module's unique id
	 *
	 * @return	string	the current module's id
	 * @static
	 */
	function getModuleID() {
		$temp = lcRegistry::singleton();
		return $temp->mid;
	}


	/**
	 * internal function used to emulate a singleton class in php
	 *
	 * @private
	 */
	function singleton($s='') {
		static $singleton;
		if (isset($singleton)) {
			return $singleton;
		}
		else {
			if ($s) {
				$singleton = $s;
			}
		}
	}


	/**
	 * Updates the lcConfig table with new values
	 *
	 * @return void
	 */
	function saveConfig() {
		$db = DB::getHandle();
		$db->query("delete from lcConfig where mid='".$this->mid."'",false);
		while ( list($k,$v) = @each($this->config) ) {
			$type = $this->type[$k];
			$extra = $this->extra[$k];
			if ($type!='') { 
				$db->query("update lcConfig set extra='$extra',type='$type', v = '".$v."' where mid = '".$this->mid."' and k='".$k."'",false);
				if (! $db->getNumRows() )  {
					$db->query("insert into lcConfig (mid,k,v,type,extra)  VALUES('".$this->mid."','$k','$v','$type','$extra')",false);
				}
			}
		}
	}


	/**
	 * Members not to be saved
	 *
	 * @see PersistantObject
	 */
	function _getTransient() { 
		return array("insertID","config");
	}
}
?>
