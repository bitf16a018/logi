<?
$user = $argv[1];
$pass = $argv[2];
$db = $argv[3];
$host = $argv[4];
$project = $argv[5];

if (count($argv)<6) { 
	echo "\nUSE: php export2xml.php username password database host projectname > outputfile.xml \n\n";
	exit();
}


$link = mssql_connect($host,$user,$pass);

mssql_select_db($db,$link);


echo '<?xml version="1.0" encoding="ISO-8859-1" standalone="no"?>
<!DOCTYPE database SYSTEM
 "http://jakarta.apache.org/turbine/dtd/database_3_1.dtd">
';
?>
<project
  name="<?=$project;?>"
  defaultIdMethod="idbroker">
<?


$res = mssql_query("SELECT name FROM sysobjects WHERE Type = 'U' ORDER BY name");

while ( $row = mssql_fetch_array($res) ){
	$tables[] = $row['name'];
}


while ( list($k,$table) = @each($tables) ) {

	//get column definitions
	$res = mssql_query("exec sp_columns @table_name ='".$table."'");
	while ( $row = mssql_fetch_array($res) ){
		$table_array[$table]['cols'][] = $row;
	}

	//get pkey definitions
	$res = mssql_query("exec sp_pkeys ".$table);
	while ( $row = mssql_fetch_array($res) ){
		$table_array[$table]['pkeys'][] = $row;
	}

	//get fkey definitions
	$res = mssql_query("exec sp_fkeys ".$table);
	while ( $row = mssql_fetch_array($res) ){
		$table_array[$row['FKTABLE_NAME']]['fkeys'][] = $row;
	}

}
	foreach ( $table_array as $table_name => $table_info ) {
		//split out size from Type field; integer(11), or varchar(25)
		$cols = @$table_info['cols'];
		$fkeys = @$table_info['fkeys'];
		$pkey = @$table_info['pkeys'][0];

	echo '    <entity name="'.$table_name.'">';
	echo "\n";


		foreach ($cols as $idx => $col) {
		  $type = $col['TYPE_NAME'];
		  $size = $col['LENGTH'];
		  $primaryKey = false;
		  if ( $col['COLUMN_NAME'] == $pkey['COLUMN_NAME'] ) {
			  //$type = substr($type,0, strpos($type,' '));
			  $primaryKey = true;
		  } else {
			  $primaryKey = false;
		  }


		  echo '	<attribute
		name = "'.$col['COLUMN_NAME'].'"
		type = "'.$type.'"';
			if ($size ) { echo "\n"; echo '		size = "'.$size.'" '; }
			if ($primaryKey) { echo "\n"; echo '		primaryKey  = "true" ';}
			echo '/>';
		  echo "\n";
		}


		//foreign-keys
		if ( is_array($fkeys) ) {
		foreach ($fkeys as $idx=>$fkey) {
			echo '
	<foreign-key foreignTable="'.$fkey['PKTABLE_NAME'].'">
		<reference
			local="'.$fkey['FKCOLUMN_NAME'].'"
			foreign="'.$fkey['PKCOLUMN_NAME'].'"/>
	</foreign-key>
';

		}
		}

	echo '    </entity>';
	echo "\n";

	}

?>
</project>

