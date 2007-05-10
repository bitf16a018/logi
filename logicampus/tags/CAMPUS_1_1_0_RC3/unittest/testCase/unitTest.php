<?

class unitTest {

	var $test = array();
	var $results = array();

	function run(&$db, &$u, &$lc, &$t) {

		$lc->templateName = 'unitTest';
		while ( list($k,$v ) = @each($this->tests) ) {
			$test = '$this->results[\''.$k.'\'] = $this->'.$v['name'].'Test();';
			//print "testing $k $v <br>";
			//eval($test);
		}


		while ( list($k,$v ) = @each($this->results) ) {
			$t['results'][$k] = $v == $this->tests[$k]['expected']? 'PASS':'FAIL';
		}

		$t['s'] = $lc->getvars[0];
		$t['m'] = 'testCase';
	}

}
?>
