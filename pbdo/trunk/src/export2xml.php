<?
$host = $argv[1];
$user = $argv[2];
$pass = $argv[3];
$db = $argv[4];
$project = $argv[5];

if (count($argv)<6) { 
	echo "\nUSE: php export2xml.php host username password database projectname > outputfile.xml \n\n";
	exit();
}

echo '<?xml version="1.0" encoding="ISO-8859-1" standalone="no"?>
<!DOCTYPE database SYSTEM
 "http://jakarta.apache.org/turbine/dtd/database_3_1.dtd">
';

$link = mysql_connect($host, $user, $pass);


mysql_select_db($db,$link);

?>
WARNING!
YOU NEED TO ADD RELATIONS AND PRIMARY KEYS TO THIS XML.
THIS SHOULD ONLY BE USED ONCE PER TABLE.
<project 
  name="<?=$project;?>"
  defaultIdMethod="idbroker">
<?

$key = "Tables_in_".$db;
$res = mysql_query('show tables');
while ( $row = mysql_fetch_assoc($res) ){

	//if (stristr($row[$key],'ck_') ) 
	$tables[] = $row[$key];
}
echo mysql_error()."\n";

/*
$tables = array ( 'class_assignments', 'class_assignments_grades', 'class_assignments_link',
		  'class_gradebook', 'class_gradebook_categories', 'class_gradebook_entries',
                  'class_lessons', 'class_lesson_links', 'class_lesson_content',
		  'class_links', 'class_links_categories', 'class_objectives', 'class_syllabuses');
		  */


while ( list($k,$table) = @each($tables) ) {

	echo '   <entity name="'.$table.'">';
	echo "\n";

	//echo("describe ".$table."\n");
	$res = mysql_query('describe '.$table);

	while ( $row = mysql_fetch_assoc($res) ){
		//split out size from Type field; integer(11), or varchar(25)
		$type = $row['Type'];
		$firstP = strpos($type,'(');
		$lastP = strpos($type,')');
		$diffP = $lastP - $firstP -1;

		if ($firstP) {
			$size = substr($type,$firstP+1,$diffP);
			$type = substr($type,0,$firstP);
		}

		echo '	   <attribute 
	      name = "'.$row['Field'].'"
	      type = "'.$type.'"';
	      if ($size ) { echo "\n"; echo '	      size = "'.$size.'" '; }
	      if ($row['Key'] == 'PRI') { echo "\n"; echo '	      primaryKey  = "true" ';}
	      echo '/>';
		echo "\n";
	}
	echo '   </entity>';
	echo "\n";

	/*
	$res = mysql_query("select * from $table");
	$temp = "";
	while($row=mysql_fetch_assoc($res)) { 
	#	$temp.="insert into $table (";
	#	$keys = implode(",",array_keys($row));
	#	$vals=array();
		$temp.="<row>\n";
		foreach($row as $rkey=>$rval) { 
			$temp.= "\t<$rkey>$rval</$rkey>\n";
	#		$vals[] = "'".addslashes(stripslashes($rval))."'";
		}
	#	$vals = implode(',',$vals);
	#	$temp.= $keys.") values ($vals)\n";
		$temp.="</row>\n";
	}
	$t[$table] =$temp;
	*/

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
