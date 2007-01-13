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

$setupFile = trim(file_get_contents('../data/lcForms_and_lcFormInfo.sql'));
$schemas['forms'] = explode(";\n",$setupFile);

$setupFile = trim(file_get_contents('../data/lcPerms.sql'));
$schemas['perms'] = explode(";\n",$setupFile);

$setupFile = trim(file_get_contents('../data/lcConfig.sql'));
$schemas['config'] = explode(";\n",$setupFile);

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

//			if (strstr($line, '-- ') ) {
//				continue;
//			}
			$cleaner .= $line."\n";
		}
		$cleanSchemas[$filename][] = trim($cleaner).";\n";
	}
}
echo "<?\n";
foreach ($cleanSchemas as $secionName => $section) {
	foreach ($section as $def) {
		if (trim ($def) == '') { continue; }
		echo "\$table = <<<campusdelimeter\n";
		echo $def;
		echo "campusdelimeter;\n";
		echo "\$installTableSchemas[] = \$table;\n";
	}
}
echo "\n?>";
/*
 *
 *
 *

if [ ! $3 ]
then
	db='logicampus';
else
	db=$3;
fi

if [ -d '../src/' ] 
then
	location='../src/logicreate/services/'
fi


if [ -d '../services/' ] 
then
	location='../services/'
fi

if [ ! $location ]
then
	echo 'you need to run this from either the cvs/data dir or'
	echo 'src/logicreate/scripts/'
	exit 1
fi


for x in `find $location -name 'META-INFO'`
do
	echo 'installing setup.sql in '$x;
	mysql -u $1 -p$2 $db < $x/setup.sql;
done











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
