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
	$filename = $argv[1];
}

pbdocore($filename,$argv);

?>
