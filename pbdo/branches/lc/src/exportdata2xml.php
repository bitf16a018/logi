<?
$host = $argv[1];
$user = $argv[2];
$pass = $argv[3];
$db = $argv[4];
$project = $argv[5];

if (count($argv)<6) { 
	echo "\nUSE: php exportdata2xml.php host username password database projectname > outputfile.xml \n\n";
	exit();
}

echo '<?xml version="1.0" encoding="ISO-8859-1" standalone="no"?>
<!DOCTYPE database SYSTEM
 "http://jakarta.apache.org/turbine/dtd/database_3_1.dtd">
';

$link = mysql_connect($host, $user, $pass);


mysql_select_db($db,$link);

?>
<database
  name="<?=$project;?>"
  defaultIdMethod="idbroker">
<?

$key = "Tables_in_".$db;
$res = mysql_query('show tables');
while ( $row = mysql_fetch_assoc($res) ){

	$tables[] = $row[$key];
}

while ( list($k,$table) = @each($tables) ) {

	$res = mysql_query("select * from $table");
	$temp = "";
	while($row=mysql_fetch_assoc($res)) { 
		$temp.="<row>\n";
		foreach($row as $rkey=>$rval) { 
			if (eregi("<?",$rval) or eregi("</",$rval)) { 
				#$rval = base64_encode($rval);
			}
			$temp.= "\t<$rkey>$rval</$rkey>\n";
		}
		$temp.="</row>\n";
	}
	$t[$table] =$temp;

}
?>
<data>
<?
foreach($t as $table=>$rows) { 
	echo "<table name='$table'>\n";
	echo $rows."\n";
	echo "</table>\n";
}
?>
</data>
