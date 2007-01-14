<?php
//echo "trying to gather sql files to create PHP schema...\n";

//echo "*******************************************************************************\n";
//echo "INSTALLING base LC data\n";
$schemas = array();
$cleanSchemas = array();
$filesToProcess = array();

$setupFile = trim(file_get_contents('../data/setup.sql'));
$schemas['setup'] = explode(";\n",$setupFile);

$setupFile = trim(file_get_contents('../data/lcRegistry.sql'));
$schemas['registry'] = explode(";\n",$setupFile);

$setupFile = trim(file_get_contents('../data/lcUsers.sql'));
$schemas['users'] = explode(";\n",$setupFile);

$setupFile = trim(file_get_contents('../data/lcForms.sql'));
$data['forms'] = explode(";\n",$setupFile);

$setupFile = trim(file_get_contents('../data/lcFormInfo.sql'));
$data['forminfo'] = explode(";\n",$setupFile);


$setupFile = trim(file_get_contents('../data/lcPerms.sql'));
$data['perms'] = explode(";\n",$setupFile);

$setupFile = trim(file_get_contents('../data/lcConfig.sql'));
$data['config'] = explode(";\n",$setupFile);

$setupFile = trim(file_get_contents('../data/lcGroups.sql'));
$schemas['groups'] = explode(";\n",$setupFile);

$location = '../src/logicreate/services/';
$d = dir($location);
while ($entry =  $d->read() ) {
	if ($entry == '.' || $entry == '..') continue;
	$file = $location.$entry.'/META-INFO/setup.sql';
	if (file_exists($file) ) {
		$filesToProcess['serv_'.$entry] = $file;
	}
}
$d->close();

foreach ($filesToProcess as $service => $file) {
	$setupFile = trim(file_get_contents($file));
	$schemas[$service] = explode(";\n",$setupFile);
}
/*
for x in `find $location -name 'META-INFO'`
do
	echo 'installing setup.sql in '$x;
	mysql -u $1 -p$2 $db < $x/setup.sql;
done
 */



foreach ($schemas as $filename => $manyDefs) {
	foreach ($manyDefs as $fullDef) {
		$lines = explode("\n",$fullDef);
		$cleaner = '';
		foreach ($lines as $line) {

			if (trim($line) == '') {continue;}
			if (trim($line) == '--') {continue;}
			if (trim($line) == '#') {continue;}
			if (trim($line) == '# ') {continue;}
			if (preg_match("/^#/",trim($line))) {continue;}
			if (preg_match("/^--/",trim($line))) {continue;}

			$cleaner .= $line."\n";
		}
		$cleanSchemas[$filename][] = trim($cleaner)."\n";
	}
}

foreach ($data as $filename => $manyDefs) {
	foreach ($manyDefs as $fullDef) {
		$lines = explode("\n",$fullDef);
		$cleaner = '';
		foreach ($lines as $line) {

			if (trim($line) == '') {continue;}
			if (trim($line) == '--') {continue;}
			if (trim($line) == '#') {continue;}
			if (trim($line) == '# ') {continue;}
			if (preg_match("/^#/",trim($line))) {continue;}
			if (preg_match("/^--/",trim($line))) {continue;}

			$cleaner .= $line."\n";
		}
		$cleanData[$filename][] = trim($cleaner)."\n";
	}
}

foreach ($cleanSchemas as $secionName => $section) {
	$fileContents = '';
	foreach ($section as $def) {
		if (trim ($def) == '') { continue; }
		$fileContents .= "\$table = <<<campusdelimeter\n";
		$fileContents .= $def;
		$fileContents .= "campusdelimeter;\n";
		$fileContents .= "\$installTableSchemas[] = \$table;\n";
		if (strlen($fileContents) > 40000) {
			writeOutSchemas($fileContents,++$c);
			$fileContents = '';
		}
	}
	writeOutSchemas($fileContents,++$c);
}

$c = 0;
foreach ($cleanData as $secionName => $section) {
	$fileContents = '';
	foreach ($section as $def) {
		if (trim ($def) == '') { continue; }
		$fileContents .= "\$table = <<<campusdelimeter\n";
		$fileContents .= $def;
		$fileContents .= "campusdelimeter;\n";
		$fileContents .= "\$installTableSchemas[] = \$table;\n";
		if (strlen($fileContents) > 40000) {
			writeOutSchemas($fileContents,++$c,'data_');
			$fileContents = '';
		}
	}
	writeOutSchemas($fileContents,++$c,'data_');
}




function writeOutSchemas($contents, $c, $prefix='schema_') {
	$fileContents = '';
	$fileContents = "<?\n";
	$fileContents .= "\$installTableSchemas = array();\n";
	$fileContents .= $contents;

	$fileContents .= "\n?>";
	$f = fopen('../src/public_html/install/'.$prefix.sprintf('%02d',$c).'.php','w');
	fputs($f,$fileContents);
	fclose($f);
}


/*
 *
for x in `echo 'SHOW TABLES' | mysql -u $1 -p$2 $db | tail +2`
do
	echo 'DROPPING '$x' from '$db
	echo 'DROP TABLE '$x | mysql -u $1 -p$2 $db
done



echo '***********************'
echo 'Custom profile data'
mysql -u $1 -p$2 $db < ../data/profile.sql 


echo '*********************************'
echo 'NOT INSERTING DUMMY DATA, (see webtest)'
 */
