<?php
include_once ('lib_lct_parse.php');

//find all modules
$dir = dir('../src/logicreate/services');
$modules = array();
while ($file = $dir->read()) {
	if ($file == '.') continue;
	if ($file == '..') continue;
	if ($file == 'CVS') continue;
	$modules[] = $file;
}
$dir->close();

$lctStats = array();
$totalFiles = 0;
$lctFiles = 0;
$lctCounts = 0;

echo "*** openening messages.en_US.xml\n";
$msgDoc = new DomDocument('1.0', 'UTF-8');
$msgDoc->substituteEntities=false;
$msgDoc->resolveExternals=false;
$msgDoc->preserveWhiteSpace=true;
$msgDoc->validateOnParse=false;
if (!@$msgDoc->load( "./messages.en_US.xml") ) {
	
	//create a new XML envelope
	$msgDoc->encoding = 'UTF-8';
	$msgDoc->version  = '1.0';
	$root = $msgDoc->createElement('xliff');
	$root->setAttribute('version','1.1');

	$file = $msgDoc->createElement('file');
	$file->setAttribute('source-language', 'en_US');
	$file->setAttribute('target-language', 'en_US');
	$file->setAttribute('original', 'logicampus modules');
	$file->setAttribute('tool', 'logicampus lct extractor');
	$file->setAttribute('datatype', 'text/x-php');

	$msgDoc->appendChild($root);

	$root->appendChild($msgDoc->createTextNode("\n"));
	$root->appendChild($file);

	$body = $msgDoc->createElement('body');
	$file->appendChild($msgDoc->createTextNode("\n"));
	$file->appendChild($body);
	$file->appendChild($msgDoc->createTextNode("\n"));
} else {
	//extract the body node so code can attach to it

	$xliffTag =& $msgDoc->documentElement;
	$list = $xliffTag->getElementsByTagName('body');
	//there can be only one... body tag
	$body =& $list->item(0);
}

//now the $body tag can be used to add trans-unit nodes into



$currentId = 1;
//find the max ID
$xpath = new DomXPath($msgDoc);
$maxIdQuery = "//trans-unit/@id[not(. <= ../preceding-sibling::trans-unit/@id) and not(. <= ../following-sibling::trans-unit/@id)]";
$elements = $xpath->query($maxIdQuery);
foreach ($elements as $ele) {
	$currentId = $ele->nodeValue;
	$currentId++;
	echo "*** Found previous nodes, starting ID is ".$currentId."\n";
}


//get list of files in one module
//
foreach($modules as $mod) {

	echo "*** Parsing module $mod...\n";

	if (! is_dir('../src/logicreate/services/'.$mod.'/templates/') ) {continue;}
	$modFiles = array();
	$tdir = dir('../src/logicreate/services/'.$mod.'/templates/');
	while ($file = $tdir->read()) {
		if ($file == '.') continue;
		if ($file == '..') continue;
		if ($file == 'CVS') continue;
		if ( strstr($file, '~') ) { continue; }
		if (! strstr($file, '.html') ) { continue; }
		$modFiles[] = $file;
	}
	$tdir->close();


	echo "*** Module: $mod: found (".count($modFiles).") template files\n";

	foreach ($modFiles as $tfile) {

//		echo "*** Module: $mod: parsing file ".$tfile."...\n";
		//get list of LCTs in one file
		$lctFuncs = findLctInFile('../src/logicreate/services/'.$mod.'/templates/'.$tfile);
//		echo "*** Module: $mod: lct count (".count($lctFuncs).") \n";

		$lctStats[$mod] = array();
		$lctStats[$mod][$tfile] = array();
		$lctStats[$mod][$tfile]['lctCount'] = count($lctFuncs);
		$totalFiles++;
		if (count($lctFuncs)) {
			$lctFiles++;
			$lctCounts += count($lctFuncs);
		}

		foreach ($lctFuncs as $lctObj) {
			$untrans = substr($lctObj->params[0],1,-1);
//			echo "*** got this key: ".$untrans."\n";

			//search the message document first to find a source tag with this value already
			$sameTuQuery = "/xliff/file/body/trans-unit[source='\n\t\t\t".$untrans."\n\t\t']";
			$elements = $xpath->query($sameTuQuery);
//			echo "*** XPath looking for duplicates of '".$untrans."'\n";
//			print_r($sameTuQuery);// = "/language/trans-unit[source=\"".$untrans."\"]";
			if ($elements->length) {
				//already got this TU
				//let's add another context to it
				
				$sourcefile = substr($lctObj->file,7);
				$sourceline = $lctObj->line;
				$tu = $elements->item(0);
				$ctxg = $tu->getElementsByTagName('context-group');
				$found = false;
				for ($xi=0; $xi < $ctxg->length; $xi++) {
					if ($found) {continue;}
					$ctxg_node = $ctxg->item($xi);

					if ($ctxg_node->getAttribute('name') == 'x-php-reference-'.crc32($sourcefile.'a'.$sourceline)) {
						$found = true;
						continue;
					}
				}
				if ( !$found ) {
					$context_group = makeContextFileLine($msgDoc, $sourcefile, $sourceline);

					$tu->appendChild($msgDoc->createTextNode("\n\t\t"));
					$tu->appendChild($context_group);
					$tu->appendChild($msgDoc->createTextNode("\n\t\t"));
				}
				continue;
			}



			$nltab    = $msgDoc->createTextNode("\n\t");
			$tabtab   = $msgDoc->createTextNode("\t\t");
			$tab      = $msgDoc->createTextNode("\t");
			$nl       = $msgDoc->createTextNode("\n");

			$tu = $msgDoc->createElement('trans-unit');
			$tu->setAttribute('id',$currentId);
			$currentId++;

			//there is no need to encode entities in an xpath query.. weird
			// but you do want it encoded before it goes into the actual XML
			$untrans = htmlentities($untrans,ENT_QUOTES, 'UTF-8');


			$source = $msgDoc->createElement('source', "\n\t\t\t".$untrans."\n\t\t");
			//$source = $msgDoc->createElement('source', $untrans);
			$source->setAttribute('xml:lang','en_US');

			$target = $msgDoc->createElement('target', "\n\t\t\t".$untrans."\n\t\t");
			$target->setAttribute('xml:lang','en_US');

			//remove the "../src/" from the filename

			$sourcefile = substr($lctObj->file,7);
			$sourceline = $lctObj->line;
			$context_group = makeContextFileLine($msgDoc, $sourcefile, $sourceline);

/*			$context_group->appendChild($msgDoc->createTextNode("\n\t\t\t"));
			$context_group->appendChild($context_group);
			$context_group->appendChild($msgDoc->createTextNode("\n\t\t"));
 */

			$tu->appendChild($msgDoc->createTextNode("\n\t\t"));
			$tu->appendChild($source);

			$tu->appendChild($msgDoc->createTextNode("\n\t\t"));
			$tu->appendChild($target);

			$tu->appendChild($msgDoc->createTextNode("\n\t\t"));
			$tu->appendChild($context_group);
			$tu->appendChild($msgDoc->createTextNode("\n\t"));

			$body->appendChild($nl);
			$body->appendChild($tab);
			$body->appendChild($tu);
			$body->appendChild($msgDoc->createTextNode("\n"));


		}
		/**
		 *  <trans-unit>
		 *    <source xml:lang="en-US">We are testing XLIFF.</source>
		 *    <target state="translated" xml:lang="fr">Nous testons XLIFF.</target>
		 *  </trans-unit>
		 */
	}

}


echo "*** SAVING messages.en_US.xml...\n";
$msgDoc->save('messages.en_US.xml');
//print_r($msgDoc->saveXML());


echo "**** STATS:\n";
echo "***  Files found ".$totalFiles."\n";
echo "***     with lct ".$lctFiles."\n";
echo "***  pct trnsltd ".sprintf("%.2f",(($lctFiles/$totalFiles)*100))." %\n";
//print_r($lctStats);




//update XML for these lcts



//next file in module
//next module in list
//
//
//
function makeContextFileLine(&$doc, $f, $l) {
	$context_group = $doc->createElement('context-group');
	$context_group->setAttribute('name','x-php-reference-'.crc32($f.'a'.$l));
	$context_group->setAttribute('purpose','location');
	$file = $doc->createElement('context', $f);
	$file->setAttribute('context-type','sourcefile');


	$line = $doc->createElement('context', $l);
	$line->setAttribute('context-type','linenumber');

	$context_group->appendChild($doc->createTextNode("\n\t\t\t"));
	$context_group->appendChild($file);
	$context_group->appendChild($doc->createTextNode("\n\t\t\t"));
	$context_group->appendChild($line);
	$context_group->appendChild($doc->createTextNode("\n\t\t"));

	return $context_group;
}
?>
