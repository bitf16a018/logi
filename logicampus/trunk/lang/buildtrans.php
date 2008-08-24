#!/usr/bin/php4
<?
//STEP 1: parse arguments
$argv = $_SERVER['argv'];
$argc = $_SERVER['argc'];

if (!isset($filename) || $filename == '') {
	if (count($argv) <= 1 ) {
		printHelp();
		exit(1);
	}
	$filename = $argv[1];
	if (isset($argv[2]))
	$locale = $argv[2];
}
if (!isset($locale) || $locale == '') {
	$locale = $filename;
}

function printHelp() {
echo <<<END
Usage php ./buildtrans.php [ja_JP]


END;

}


//STEP 2: Initialize variables
$document = simplexml_load_string(  file_get_contents('messages.'.$filename.'.xml'), 'SimpleXMLElement', LIBXML_NOCDATA);


//STEP 4: Add translations to the proper node
/*
foreach ($document->file->body->{"trans-unit"} as $node) {

	//if the node is a #text node, add it's contents to the
	// previous message node
	if ($node->name == "#text") {
		$staticNodes[$lastid]->translation = trim($node->content);
		unset($staticNodes[$id]);
	}
	$lastid = $id;
}
 */


//STEP 5: print nodes as switch function
ob_start();
echo '<?

header("Content-type:text/html; charset='.$document->language['charset'].'");

function lct($key,$args = "") {

	extract($args);
	switch($key) {
';
	foreach ($document->file->body->{"trans-unit"} as $node) {
		echo '
		case \''.addslashes(trim($node->source)).'\':
			return "'.trim($node->target).'";
			break;
';

	}
echo '

		default:
			return $key;

	}
}

?>';

$contents = ob_get_contents();
ob_end_clean();

$xml = fopen("./lct.$locale.php",'w+');
fwrite($xml,$contents,strlen($contents));
fclose($xml);


//STEP 6: print message to user
?>
Good, now you can move the file '<?="lct.$locale.php";?>'
to the logicreate/lang/ directory.
<?
?>
