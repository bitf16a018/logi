<?
//STEP 1: parse arguments
$argv = $_SERVER['argv'];
$argc = $_SERVER['argc'];

if ($oldfile == '' || $newfile == '') {
	if (count($argv) <= 2 ) {
		printHelp();
		exit(1);
	}
	$oldfile = $argv[1];
	$newfile = $argv[2];
}


function printHelp() {
echo <<<END
Usage php ./mergetrans.php [old.xml] [new.xml]
END;

}

//STEP 2: Initialize variables
$olddoc = domxml_open_file($oldfile);
$newdoc = domxml_open_file($newfile);


$oldroot = $olddoc->document_element();
$newroot = $newdoc->document_element();


$oldNodes = array();
$newNodes = array();


//STEP 3: Convert XML to PHP array structure
extractNodes($oldroot,$oldNodes);
extractNodes($newroot,$newNodes);


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
foreach ($oldNodes as $id=>$node) {

	//if the node is a #text node, add it's contents to the
	// previous message node
	if ($node->name == "#text") {
		$oldNodes[$lastid]->translation = trim($node->content);
		unset($oldNodes[$id]);
		continue;
	}

	if ($node->tagname  == 'usage') { 
		unset($comment);
		$comment->type = 'usage';
		$comment->file = $node->attributes['file']->value;
		$comment->line = $node->attributes['line']->value; 
		$oldNodes[$lastid]->usages[] = $comment;
		unset($oldNodes[$id]);
		continue;
	}

	if ($node->name  == '#comment') { 
		$oldNodes[$lastid]->original = $node->content;
		unset($oldNodes[$id]);
		continue;
	}

	$lastid = $id;
}

unset($lastid);

foreach ($newNodes as $id=>$node) {

	//if the node is a #text node, add it's contents to the
	// previous message node
	if ($node->name == "#text") {
		$newNodes[$lastid]->translation = trim($node->content);
		unset($newNodes[$id]);
		continue;
	}

	if ($node->tagname  == 'usage') { 
		unset($comment);
		$comment->type = 'usage';
		$comment->file = $node->attributes['file']->value;
		$comment->line = $node->attributes['line']->value; 
		$newNodes[$lastid]->usages[] = $comment;
		unset($newNodes[$id]);
		continue;
	}

	if ($node->name  == '#comment') { 
		$newNodes[$lastid]->original = $node->content;
		unset($newNodes[$id]);
		continue;
	}

	$lastid = $id;
}



//STEP 5: Flow through new nodes, compare to old
foreach ($newNodes as $id=>$node) {

	//get the id that we specify in the XML, not the random number $id
	$nodeid = $node->attributes['id']->value;
	if (! $nodeid ) continue;
	if ( $node->tagname != 'message' ) continue;

	if ( ! $node->original ) { $node->original = $node->translation; }
	if ( ! is_array($node->usages) ) { $node->usages = array(); }
	foreach ($oldNodes as $oldid=>$oldnode) {
		$oldnodeid = $oldnode->attributes['id']->value;
		if ($oldnodeid == $nodeid ) {
//			print "We have matching nodes ...  $nodeid\n";
//			print "Old translation == ".$oldnode->translation ." | New translation == ".$node->translation."\n\n";
			continue 2;
		}
	}
	print "We have a new node ...  .$nodeid\n";
	$oldNodes[] = $node;
}




//STEP 6: Print old nodes as XML

ob_start();
$language = array_shift($oldNodes);
sort($oldNodes);

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo "\n";
echo '<language locale="'.$language->attributes['locale']->value.'" charset="'.$language->attributes['charset']->value.'">';
echo "\n";

foreach ($oldNodes as $oldid=>$oldnode) {
	node2xml($oldnode);
}

function node2XML($m) {


	echo "\n";
	echo "\t";
	echo '<message id ="'.htmlspecialchars($m->attributes['id']->value).'" domain="'.$m->attributes['domain']->value.'" status="'.$m->attributes['status']->value.'">';
	echo "\n";
	echo "\t\t";
	echo htmlspecialchars($m->translation);
	echo "\n";
	echo "\t";
	echo '</message>';
	echo "\n\t<!--".htmlspecialchars($m->original)."-->";

	if (!is_array($m->attributes) ) { echo "\n\n"; print_r($m);exit(); }
	foreach ($m->usages as $blank=>$att) {
		if ($att->type == 'usage' ) {
			echo "\n";
			echo "\t";
			echo '<usage id ="'.htmlspecialchars($m->attributes['id']->value).'" file="'.$att->file.'" line="'.$att->line.'"/>';
		}
	}
	echo "\n";
	echo "\n";
}
echo "</language>\n\n";

$xml = ob_get_contents();
ob_end_clean();
$file = fopen($oldfile,'w+');
fwrite($file,$xml,strlen($xml));
fclose($file);


//STEP 7: print message to user
?>

'<?=$newfile;?>' has been merged with  '<?=$oldfile;?>'.
New words were copied over, and old translations remain the same.

