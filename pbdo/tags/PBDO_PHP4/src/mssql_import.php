<?
// get parameters
$host = $argv[1];
$user = $argv[2];
$pass = $argv[3];
$db = $argv[4];
$project = $argv[5];

if (count($argv)<6) { 
	echo "\nUSE: php mssql_import.php host username password database projectname\n\n";
	exit();
}
// connect to 
$link = mssql_connect($host,$user,$pass);
mssql_select_db($db,$link);

$path = "./projects/$project/sql/";
$dir = dir($path);
while($file = $dir->read()) {
	if (substr($file,-10)!='.mssql.sql') { 
		continue;
	}
	$data = file_get_contents($path.$file);
	$table = str_replace(".mssql.sql","",$file);
	@mssql_query("if exists (select * from sysobjects where id=object_id(N'[dbo].[$table]') and OBJECTPROPERTY(id, N'IsUserTable') = 1) drop table [dbo].[$table] ",$link);
	@mssql_query("drop table $table",$link);
	mssql_query($data,$link);
	#echo "query\n-----\n$data\n===============\n";
}

$path = "./projects/$project/sql/";
$dir = dir($path);
while($file = $dir->read()) {
	if (substr($file,-15)!='.mssql.data.sql') { 
		continue;
	}
	$table = str_replace(".mssql.data.sql","",$file);
	$data = file_get_contents($path.$file);
	@mssql_query("SET IDENTITY_INSERT $table ON",$link);
	@mssql_query($data,$link);
	@mssql_query("SET IDENTITY_INSERT $table OFF",$link);
	echo "table=$table\n";
	#echo "query\n-----\n$data\n===============\n";
}

mssql_close($link);

?>
----------
Note: data may not be 100% imported successfully at this point.  Known issues 
include mysql 'timestamps' being converted to 'datetime' fields in mssql - 
timestamp in mysql is considered a string of varchar characters in mssql, 
and it disallows the implicit conversion.

Check that your data was imported successfully, or as close as possible.

