#!/usr/bin/php
<?
//STEP 1: parse arguments
$argv = $_SERVER['argv'];
$argc = $_SERVER['argc'];

if ($filename == '') {
	if (count($argv) <= 1 ) {
		printHelp();
		exit(1);
	}
	$filename = $argv[1];
	$locale = $argv[2];
}
if ($locale == '') {
	$locale = $filename;
}

function printHelp() {
echo <<<END
Usage php ./buildtrans.php [ja_JP]


END;

}

//STEP 2: Initialize variables
$document = domxml_open_file('messages.'.$filename.'.xml');


$root = $document->document_element();
$staticNodes = array();


//STEP 3: Convert XML to PHP array structure
extractNodes($root,$staticNodes);


function extractNodes($node,&$struct) {

//safeguard
static $loop = 0;
if ($loop > 1003 ) {print_r($struct); exit();}


	if ($node->type ==3  && ! trim($node->content)) return;
	$attr = $node->attributes();
	while ( list (,$v)  = @each($attr) ){
		$node->attributes[$v->name] = $v;
	}
	$struct[$loop] = $node;
$loop++;

	$kids = $node->child_nodes();

	while ( list($k,$v) = each($kids) ) {
		extractNodes($v,$struct);

	}
}


//STEP 4: Add translations to the proper node
foreach ($staticNodes as $id=>$node) {

	//if the node is a #text node, add it's contents to the
	// previous message node
	if ($node->name == "#text") {
		$staticNodes[$lastid]->translation = trim($node->content);
		unset($staticNodes[$id]);
	}
	$lastid = $id;
}


//STEP 5: print nodes as switch function
ob_start();
echo '<?

header("Content-type:text/html; charset='.$staticNodes[0]->attributes['charset']->value.'");

function lct($key,$args = "") {

	extract($args);
	switch($key) {
';
	foreach ($staticNodes as $id=>$node) {
		if ( 'message' != $node->tagname ) {
			continue;
		}
		if ( '' == $node->attributes['id']->value ) {
			continue;
		}

		echo '
		case \''.htmlspecialchars($node->attributes['id']->value).'\':
			return "'.htmlspecialchars($node->translation).'";
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
