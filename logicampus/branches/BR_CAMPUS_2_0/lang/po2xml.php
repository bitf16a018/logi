<?
//do a "dumb" copy of the .po file format to an LC xml format

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
	$locale = 'en_US';
}

function printHelp() {
echo <<<END
Usage php ./po2xml.php messages.po  [ja_JP]

END;

}

//STEP 2: flow through file and print XML
$commentStack = array();
$messages = fopen($filename,"r+");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<language locale=\"$locale\" charset=\"UTF-8\">\n";
while ( !feof($messages) ) {
	$line = fgets($messages,4096);

	switch(substr($line,0,1)) {

		case '#':
			$commentStack[] = analyzeComment($line);
			break;
		case '"':
			//handle the meta data
	}

	if ( 0 === strpos($line,'msgid') ) {
		$message->id = substr($line, strpos($line,'"')+1, -2);
		$line = fgets($messages,4096);
		$message->value = substr($line, strpos($line,'"')+1, -2);
		if ( ! $message->value ) {
			$message->value = $message->id;
		}
		$message->attributes = $commentStack;


		message2XML($message);
		unset($commentStack);
		unset($message);
	}

}

echo "</language>\n";

fclose($messages);



/**
 * parse a .po comment and return a nice data structure
 */
function analyzeComment($c) {

	$marker = substr($c,1,1);
	$c = trim($c);
	if ( $marker != ',' && $marker != ':' ) {
		return null;
	}
	switch ($marker) {
		case ":":
			$comment->type = 'usage';
			$c = substr($c,2);
			$semi = strpos($c,':');
			$comment->file = substr($c,1,$semi-1);
			$comment->line = substr($c,$semi+1);
			break;
		case ",":
			$comment->type = 'attribute';
			$comment->value = trim(substr($c,2));
			break;
	}
	return $comment;
}


function message2XML($m) {

	if ($m->id == '') { return; }

	echo "\n";
	echo "\t";
	echo '<message id ="'.$m->id.'" domain="system">';
	echo "\n";
	echo "\t\t";
	echo $m->value;
	echo "\n";
	echo "\t";
	echo '</message>';
	echo "\n";
	echo "\t";
	echo "<!--".$m->value."-->";

	foreach ($m->attributes as $blank=>$att) {
		if ($att->type == 'usage' ) {
			echo "\n";
			echo "\t";
			echo '<usage id ="'.$m->id.'" file="'.$att->file.'" line="'.$att->line.'"/>';
		}
	}
	echo "\n";
	echo "\n";
	
}
?>
