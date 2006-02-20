<?
include('pbdo_core.php');
ob_start();



$argv = $_SERVER['argv'];
$argc = $_SERVER['argc'];

if ($filename == '') {
	if (count($argv) <= 1 ) {
		printHelp();
		exit(1);
	}
	$filename = $argv[$argc-1];
}

//default values
$settings = array (
	'OUTPUT_DIR'=>'./projects/'
);
$bad_opt = false;

for ($k = 1; $k < $argc; $k++ ) {
	$v = $argv[$k];
	list ($opt_name, $opt_val) = split('=',$v);

	switch($opt_name) {
		case '--output-dir':
			if (substr($opt_val,-1) != '/') {
				$opt_val .= '/';
			}
			$settings['OUTPUT_DIR'] = $opt_val;
			break;

		default:
			if ($k != $argc-1) {
				echo "unknown option: ".$opt_name."\n";
				$bad_opt = true;
				break;
			}

	}

}
if ($bad_opt) {
	printHelp();
	exit();
}

	echo "*** Current settings: \n";
	print_r($settings);
	echo "\n";

pbdocore($filename,$argv,$settings);

?>
