<?
// get parameters
$host = $argv[1];
$user = $argv[2];
$pass = $argv[3];
$db = $argv[4];
$project = $argv[5];

if (count($argv)<6) { 
	echo "\nUSE: php mysql_import.php host username password database projectname\n\n";
	exit();
}
// connect to 
$link = mysql_connect($host,$user,$pass);
mysql_select_db($db,$link);

$path = "./projects/$project/sql/";
$dir = dir($path);
while($file = $dir->read()) {
	if (substr($file,-10)!='.mysql.sql') { 
		continue;
	}
	$data = file_get_contents($path.$file);
	$table = str_replace(".mysql.sql","",$file);
	mysql_query("drop table if exists $table",$link);
	mysql_query($data,$link);
	echo "query\n-----\n$data\n===============\n";
}



mysql_close($link);

?>

