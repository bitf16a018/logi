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
//$msgDoc = new DomDocument( file_get_contents("messages.en_US.xml") );
$msgDoc->substituteEntities=false;
$msgDoc->preserveWhiteSpace=true;
$msgDoc->load( "./messages.en_US.xml");


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
			$untrans = htmlentities($untrans,ENT_QUOTES, 'UTF-8');
			echo "*** got this key: ".$lctObj->params[0]."\n";

			$nltab    = $msgDoc->createTextNode("\n\t");
			$tabtab   = $msgDoc->createTextNode("\t\t");
			$tab      = $msgDoc->createTextNode("\t");
			$nl       = $msgDoc->createTextNode("\n");

			$tu = $msgDoc->createElement('tu');

			$source = $msgDoc->createElement('source', "\n\t\t\t".$untrans."\n\t\t");
			$source->setAttribute('xml:lang','en_US');

			$target = $msgDoc->createElement('target', "\n\t\t\t".$untrans."\n\t\t");
			$target->setAttribute('xml:lang','en_US');

			//remove the "../src/" from the filename
			$context = $msgDoc->createElement('context', substr($lctObj->file,7).':'.$lctObj->line);

			$tu->appendChild($msgDoc->createTextNode("\n\t\t"));
			$tu->appendChild($source);

			$tu->appendChild($msgDoc->createTextNode("\n\t\t"));
			$tu->appendChild($target);

			$tu->appendChild($msgDoc->createTextNode("\n\t\t"));
			$tu->appendChild($context);
			$tu->appendChild($msgDoc->createTextNode("\n\t"));

			$msgDoc->firstChild->appendChild($nl);
			$msgDoc->firstChild->appendChild($tab);
			$msgDoc->firstChild->appendChild($tu);
			$msgDoc->firstChild->appendChild($msgDoc->createTextNode("\n"));


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
print_r($msgDoc->saveXML());


echo "**** STATS:\n";
echo "***  Files found ".$totalFiles."\n";
echo "***     with lct ".$lctFiles."\n";
echo "***  pct trnsltd ".sprintf("%.2f",(($lctFiles/$totalFiles)*100))." %\n";
//print_r($lctStats);




//update XML for these lcts



//next file in module
//next module in list
//
?>
