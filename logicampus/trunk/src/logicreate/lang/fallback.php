<?

function lct($key, $args="") {
	extract($args);

	$newArgs = array();
	$newArgs[] = $key;
	$format = "%s";
	//only support 3 args by default.
	for ($x=0; $x<4;$x++) {
		$qq = current($args);
		if (! strlen($qq) ) {
			break;
		}
		$newArgs[] = current($args);
		next($args);
		$format .= " %s";
	}
	return vsprintf($format, $newArgs);
}
?>
