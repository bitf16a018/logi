<?

# where id ADODB?
$pathToADODB = "./adodb/";

if ($pathToADODB=='') { 
	die("Can't find path to ADODB\n");
}

# load the adodb library file

if(!@include_once($pathToADODB."/adodb.inc.php")) { 
	die("Sorry - I can't find ADODB\n");
}


$type = $argv[1];
$host = $argv[2];
$user = $argv[3];
$pass = $argv[4];
$database = $argv[5];
$project = $argv[6];

if (count($argv)<7) { 
	echo "\nUSE: php export2xml.php dbtype host username password database projectname > outputfile.xml \n\n";
	exit();
}


$db =&ADONewConnection($type);
$db->pconnect($host, $user, $pass, $database);

echo '<?xml version="1.0" encoding="ISO-8859-1" standalone="no"?>
<!DOCTYPE database SYSTEM
 "http://jakarta.apache.org/turbine/dtd/database_3_1.dtd">
';
?>

<project 
  name="<?=$project;?>"
  defaultIdMethod="idbroker">
<?

$tables = $db->MetaTables('TABLES');


while ( list($k,$table) = @each($tables) ) {

	echo '   <entity name="'.$table.'" generate="all">';
	echo "\n";
	
	$columns = $db->MetaColumns($table);

/*
ADODB column values - should we use all of them?
            [name] => mydata
            [max_length] => 100
            [type] => varchar
            [not_null] => 1
            [has_default] =>
            [default_value] =>
            [scale] =>
            [primary_key] =>
            [auto_increment] =>
            [binary] =>
            [unsigned] =>
*/
	foreach($columns as $col) { 
		$type = $col->type;
		$primary_key = $col->primary_key;
		$size = $col->max_length;
		$name = $col->name;

		if ($type=='text') { $size=''; }

		echo '	   <attribute 
	      name = "'.strtolower($name).'"
	      type = "'.strtolower($type).'"
	      required="true"';
	      if ($size ) { echo "\n"; echo '	      size = "'.$size.'" '; }
	      if ($primary_key) { echo "\n"; echo '	      primaryKey  = "true" ';}
	      echo '/>';
		echo "\n";
	}
	echo '   </entity>';
	echo "\n";

/*
# do the data dump??? - taken from adodb-xmlschema file
	$rs = $this->db->Execute( 'SELECT * FROM ' . $table );
	
	if( is_object( $rs ) ) {
		$schema .= '		<data>' . "\n";
		while( $row = $rs->FetchRow() ) {
			foreach( $row as $key => $val ) {
				$row[$key] = htmlentities($val);
			}
			$schema .= '	<row><f>' . implode( '</f><f>', $row ) . '</f></row>' . "\n";
		}
		$schema .= '		</data>' . "\n";
	}
*/
	$t[$table] =$temp;

}
	
?>
</project>
<?
/*
Array
(
    [Field] => ws_from
    [Type] => varchar(25)
    [Null] => YES
    [Key] =>
    [Default] =>
    [Extra] =>
)
 

<?xml version="1.0" encoding="ISO-8859-1" standalone="no"?>
<!DOCTYPE database SYSTEM
 "http://jakarta.apache.org/turbine/dtd/database_3_1.dtd">

<database
  name="bookstore"
  defaultIdMethod="idbroker">

  <table name="book" description="Book Table">
    <column
      name="book_id"
      required="true"
      primaryKey="true"
      type="INTEGER"
      description="Book Id"/>
    <column
      name="title"
      required="true"
      type="VARCHAR"
      size="255"
      description="Book Title"/>
    <column
      name="isbn"
      required="true"
      type="VARCHAR"
      size="24"
      javaName="ISBN"
      description="ISBN Number"/>
    <column
      name="publisher_id"
      required="true"
      type="INTEGER"
      description="Foreign Key Publisher"/>
    <column
      name="author_id"
      required="true"
      type="INTEGER"
      description="Foreign Key Author"/>
    <foreign-key foreignTable="publisher">
      <reference
        local="publisher_id"
        foreign="publisher_id"/>
    </foreign-key>
    <foreign-key foreignTable="author">
      <reference
        local="author_id"
        foreign="author_id"/>
    </foreign-key>
  </table>
  <table name="publisher" description="Publisher Table">
    <column
      name="publisher_id"
      required="true"
      primaryKey="true"
      type="INTEGER"
      description="Publisher Id"/>
    <column
      name="name"
      required="true"
      type="VARCHAR"
      size="128"
      description="Publisher Name"/>
  </table>
  <table name="author" description="Author Table">
    <column
      name="author_id"
      required="true"
      primaryKey="true"
      type="INTEGER"
      description="Author Id"/>
    <column
      name="first_name"
      required="true"
      type="VARCHAR"
      size="128"
      description="First Name"/>
    <column
      name="last_name"
      required="true"
      type="VARCHAR"
      size="128"
      description="Last Name"/>
  </table>
  <foo>
	  <bar>
		  <baz>
		  </baz>
	  </bar>
  </foo>
</database>
*/
?>
