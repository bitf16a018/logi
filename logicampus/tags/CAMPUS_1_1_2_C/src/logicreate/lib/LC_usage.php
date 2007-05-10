<?

class usagelog extends PersistantObject {

	function  usagelog() {

	}

	function add() {
		$db = DB::getHandle();
		$db->query("insert into lcLogging set  exectime = ".$this->exectime.",  user = '".$this->user."',  ip = '".$this->ip."',  moduleName = '".$this->moduleName."',  serviceName = '".$this->serviceName."',  refer = '".$this->refer."',  sesskey = '".$this->sesskey."'",false);
	}
}
?>
