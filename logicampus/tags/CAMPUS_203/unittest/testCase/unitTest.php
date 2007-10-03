<?

class unitTest extends NoAuth {

	var $test = array();
	var $results = array();
	var $presentor = 'EmptyPresentation';
	var $authorizer = 'noAuth';

	function run(&$db, &$u, &$lc, &$t) {

		$lc->templateName = 'unitTest';
		while ( list($k,$v ) = @each($this->tests) ) {
			$test = '$this->results[\''.$k.'\'] = $this->'.$v['name'].'Test();';
			eval($test);
			//print "testing $k $v <br>";
		}


		while ( list($k,$v ) = @each($this->results) ) {
			$t['results'][$k] = $v == $this->tests[$k]['expected']? 'PASS':'FAIL';
		}

		$t['s'] = $lc->getvars[0];
		$t['m'] = 'testCase';
	}

	/**
	 * show details about one particular test case
	 */
	/*
	function inspectRun(&$db, &$u, &$lc, &$t) {

		$testName = $lc->getvars['t'];
		$moduleName = $lc->getvars['m'];
		$serviceName = $lc->getvars['s'];
		$file = fopen(SERVICES_PATH.$moduleName.'/'.$serviceNames,'r+');
		print "<pre>\n";
		while (!feof($file) ) {
			$line = fgets($file);
			while(list($k,$v) = each($this->tests) ) {
				if ( strpos($line,$v['name']) ) {
					echo '<a name="'.$k.'"/>';
				}
			}
			echo $line . " == ";
		}
		print "</pre>\n";
	}
//	*/
}
?>
