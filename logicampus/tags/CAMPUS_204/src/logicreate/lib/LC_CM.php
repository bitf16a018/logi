<?

/**
 * Content Management Services
 *
 * Legacy class, not sure if it is used anymore
 * @deprecated
 * @package CM
 */
class CM_Services {


	function getAvailableServices(&$u) {
		$db = DB::getHandle();
		$sql = "select moduleID from lcPerms left join lcRegistry.moduleName on lcPerms.moduleID = lcRegistry.mid where %s";
		for ($z=0; $z < count($u->groups); ++$z) {
			$where .= "groupID = '".$u->groups[$z]."' or ";
		}
		$where = substr($where,0,-3);
		$sql = sprintf($sql,$where);
		$db->query($sql);
		while ($db->next_record() ) {
			$ret[] = $db->Record;
		}

		return $ret;
	}

}


/**
 * Content Management Interface
 *
 * Legacy class, not sure if it is used anymore
 * @deprecated
 * @package CM
 */
class CM_Interface {


	function getDataItems($table,$fields="*",$start=0,$limit=30,$order="") {

		$sql = " select $fields from $table";
		if ($order != "") { $sql .=" order by $order "; }
		$sql .= " LIMIT $start,$limit ";

		$db = DB::getHandle();
		$db->query($sql);
		while ($db->next_record() ) {
			$ret[] = $db->Record;
		}
	return $ret;
	}


	function getActions(&$u,$mname) {	//user object and moduleName
		$db = DB::getHandle();

		$sql = "select mid from lcRegistry where moduleName = '$mname'";
		$db->query($sql);
		$db->next_record();		//get the moduleID from the registry
		$mid = $db->Record[0];
		
		$sql = "select DISTINCT action from lcPerms where moduleID = '$mid' and (%s)";
		for ($z=0; $z < count($u->groups); ++$z) {
			$where .= "groupID = '".$u->groups[$z]."' or ";
		}
		$where = substr($where,0,-3);

		$sql = sprintf($sql,$where);
		$db->query($sql);
		while ($db->next_record() ) {
			$ret[] = $db->Record[0];
		}

		return $ret;
	}
}



/**
 * Content Management Detail
 *
 * Legacy class, not sure if it is used anymore
 * @deprecated
 * @package CM
 * @abstract
 */
class CM_Detail {

	function showRead(&$do) {}

	function showWrite(&$do) {}

	function showDelete(&$do) {}

	function showModify(&$do) {}

	function showApprove(&$do) {}

}


/**
 * Content Management Actions
 *
 * Legacy class, not sure if it is used anymore
 * @deprecated
 * @package CM
 * @abstract
 */
class CM_Perform {

	function doRead(&$db,&$do) {}

	function doWrite(&$db,&$do) {}

	function doDelete(&$db,&$do) {}

	function doModify(&$db,&$do) {}

	function doApprove(&$db,&$do) {}
}

?>
