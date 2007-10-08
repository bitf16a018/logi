<?
/*
* package class
*
* need methods to
* 
* install new app
* delete app
* upgrade app
* create package
*
* this is functional, just not pretty yet
*
* see herc/moduleadmin.php for sample code to install
* don't like this approach - using execs to tar and cp and rm
* probably cleaner ways of doing this, or way of creating 
* proprietary package format to not rely on having gzip 
*
* example:
* to install $newfile package (file.tgz filename format)
*
* $p = new LC_Package();
* #$p->debug = true;
* $p->open($newfile);
* $p->installFile($newfile);
*
* to package a module
*
* LC_package::make($module,SERVICE_PATH,$tables,$datadump);
*
* $module is name of module (faq, banners, etc)
* SERVICE_PATH is the path to store the file (faq.tgz, banners.tgz, etc)
* $tables is an array of db tables to include
* $datadump (true/false) indicates whether or not the data in those tables 
* should be dumped and included in the db.xml package file or not.
*
*
* NOTE that this is still a bit buggy - I'll include the other files needed
* from herc a bit later for the control panel version of this
* something's not quite right and it needs a bit more testing before the 
* control panel version will work right
*
*/

include_once(LIB_PATH."/LC_registry.php");

class LC_package {

	function open($targzFile) {
		$dir = md5(time());
		$this->dir = CONTENT_PATH."$dir/";
		@mkdir($this->dir,0700);
			if ($this->debug) { echo "preparing package file<BR>\n"; }
		exec("cp $targzFile ".$this->dir);
			if ($this->debug) { echo "preparing package file (step 2)<BR>\n"; }
		$cwd = getcwd();
		chdir($this->dir);
		exec("cd $this->dir");
		exec("tar -xvzf *");
			if ($this->debug) { echo "preparing package file (step 3)<BR>\n"; }
		$parts = explode("/",strrev($targzFile));
		exec("rm ".strrev($parts[0]));
			if ($this->debug) { echo "preparing package file (step 4)<BR>\n"; }
		$file = str_replace(".tar.gz","",strrev($parts[0]));
		$file = str_replace(".tgz","",$file);
		#$this->dir .=$file."/";
		#$this->dir .=$file."/";
		$this->moduleName = $file;
	}

	function installFile($file,$removeOldModule = true) {
		$this->open($file);
			if ($this->debug) { echo "analyzing package.xml<BR>\n"; }
		$this->getTreeFromFile('META_INFO/package.xml');
			if ($this->debug) { echo "processing package.xml<BR>\n"; }
		$this->installTreeToPackage();
			if ($this->debug) { echo "analyzing db.xml<BR>\n"; }
		$this->getTreeFromFile('META_INFO/db.xml');
		if ($removeOldModule) { 
			exec("rm -fr ".SERVICE_PATH.$this->moduleName);	
		}
		@mkdir(SERVICE_PATH."/".$this->moduleName,0700);
		exec("cp ".$this->dir."* ".SERVICE_PATH."".$this->moduleName." -R");
		#exec ("rm -fr ".$this->dir."/");
			if ($this->debug) { echo "processing db.xml<BR>\n"; }
		$this->tree2sql();
		$db = DB::getHandle();
			if ($this->debug) {  $db->debug=true; }
			if ($this->debug) { echo "processing db.xml (step 2)<BR>\n"; }
		if (is_array($this->sql)) { 
			while(list($k,$v) = each($this->sql)) {
				$db->query($v);
			}
		}
			if ($this->debug) { echo "processing db.xml (step 3)<BR>\n"; }
		if (is_array($this->datasql)) { 
			while(list($k,$v) = each($this->datasql)) {
				$db->query($v);
			}
		}
	}

	function make($module,$path,$tables='',$useTableData=false) {
		$dir = md5(time());
		$this->dir = CONTENT_PATH."$dir/";
		@mkdir($this->dir,0700);
		exec('cp '.SERVICE_PATH."/".$module."/* " .$this->dir."/ -R");
		@mkdir($this->dir."/META_INFO",0700);

		LC_package::def2XML($module,$this->dir."/META_INFO/"."package.xml");
		if (!is_array($tables)) { 
			if ($tables) { 
				$newtables[] = $tables;
			}
		} else { $newtables = $tables; }
		if (is_array($newtables)) { 
			LC_package::sqldef2XML($newtables,$this->dir."/META_INFO/"."db.xml",$useTableData);
		}
		chdir($this->dir);
		exec("cd $this->dir");
		exec("tar -cvzf $path/$module.tgz ./");
		exec ("rm -fr ".$this->dir."/");
	}


	function def2XML($module,$file='') {
		$db= DB::getHandle();
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$db->queryOne("select * from lcRegistry where mid='$module'");
		echo("select * from lcRegistry where mid='$module'");
		$xml .= "<info>\n";
		$array = $db->record;
		while(list($k,$v) = each($array)) {
			if ($k=='mid') { continue; }
			if ($k=='moduleName') { $k='name'; }
			$xml .= "<$k>$v</$k>\n";
		}
		$xml .= "</info>\n";
		$xml .= "<configs>\n";
		$db->query("select * from lcConfig where mid='$module'");
		while($db->nextRecord()){ 
			$xml .= "<config>\n";
			$xml .= "<key>".$db->record['k']."</key>\n";
			$xml .= "<type>".$db->record['type']."</type>\n";
			$xml .= "<default>".$db->record['value']."</default>\n";
			if ($db->record['type']=='options') { 
				$xml .= "<options>\n";
				$xml .= "<option>".implode("</option>\n<option>",$db->record['extra'])."</option>\n";
				$xml .= "</options>\n";
			}
			$xml .= "</config>\n";
		}
		$xml .= "</configs>\n";
		$xml = "<package>$xml</package>";
		if ($file) { 
			$f = fopen($file,"w");
			fputs($f,$xml);
			fclose($f);
		} else { 
			return $xml;
		}

	}


/*
 * installPackage
 *
 * requires the LC_registry library to install the package into the registry
 *
 * use
 *
 * $p = new LC_Package();
 * $p->open('/path/to/banners.tgz');
 * $p->getTreeFromFile('package.xml');
 * $p->installTreeToPackage();
 * $p->getTreeFromFile('db.xml');
 * $sql = $p->tree2sql();
 * $db->query($sql): 
 *
 */
	function installTreeToPackage() {
		if (!is_array($this->packageInfo)) {  
			if ($this->debug) { echo "ERROR - no package info found<BR>\n"; }
exit();
			return; 
		}
		$info = $this->packageInfo['info'];
		$configs = $this->packageInfo['configs'];
		$mid = $info['name'];
		lcRegistry::delete($mid);
		$reg = lcRegistry::load($mid);
		$reg->mid = $mid;
		$reg->moduleName = $mid;
		$reg->displayName = $info['displayName'];
		$reg->version = $info['version'];
		$reg->author = $info['author'];
		$reg->copyright = $info['copyright'];
		$reg->lastModified = date("Y-m-d h:i:s");
		$reg->save();
		while(list($k,$v) = @each($configs['config'])) {
			extract($v);
			$reg->config[$key] = $default;
			$reg->type[$key] = $type;
			$reg->extra[$key] = @implode("\n",$options);
		}
		$reg->saveConfig();
		exec("cp ".$this->dir." ".SERVICE_PATH."/".$this->moduleName."/ -R");
	}

	function getTreeFromFile($file) {
		echo($this->dir.$file);
		$x = getxmltree($this->dir.$file);
		$this->getPackageInfoFromTree($x);
	}

	function getTreeFromData($data) {
		$x = getxmltree($data);
		$this->getPackageInfoFromTree($x);
	}

	function getPackageInfoFromTree($x) {
		$x = $x[0];
		while(list($key,$val) = @each($x['children'])) {
			if ($val['tag']=='info') {
				$info = infoParse($val['children']);
			}
			if ($val['tag']=='configs') {
				$configs = configsParse($val['children']);
			}
			if ($val['tag']=='data') {
				$data= dataParse($val['children']);
			}
			if ($val['tag']=='indexes') {
				$indexes= indexesParse($val['children']);
			}
			if ($val['tag']=='table') {
				$temps = "";
				$temps['attributes'] = $val['attributes'];
				$temps = array_merge(tableParse($val['children']),$temps);
				$tables[] = $temps;
			}
			if ($val['tag']=='column') {
				$columns[] = columnsParse($val['children']);
			}
		}
		if ($info) {	$this->packageInfo['info'] = $info; }
		if ($data) {	$this->packageInfo['data'] = $data; }
		if ($indexes) {	$this->packageInfo['indexes'] = $info; }
		if ($tables) { $this->packageInfo['table'] = $tables; }
		if ($columns) { $this->packageInfo['columns'] = $columns; }
		if ($configs) { $this->packageInfo['configs'] = $configs; }
	}



/*
 * tree2sql
 * 
 * takes xml database schema and returns SQL statement to recreate that table
 * currently only supports mysql
 * should eventually move into DB class itself if necessary
 * does currently handle indexes as well as table definition
 *
 *
 * @param $xml string XML string of the DB schema 
 * @returns string SQL string to recreate database table
 */

	function tree2sql() {
		$table = $this->packageInfo['table'];
		while(list($tableNum,$tableData) = @each($table)) {
			unset($sql);
			$cols = $tableData['column'];
			$thistablename = $tableData['attributes']['name'];
			while(list($colNum,$col) = @each($cols)) {
				$_string = "";
				$len = "";
				extract($col);
				$_string .= "$field $type ";
				if ($len) { $_string .= "($len) "; }
				if ($null) { $_string .=" NULL "; } else { $_string .= " NOT NULL "; }
				$_string .= " default '$default' ";
				if ($extra) { $_string .= " $extra "; }
				$sql[] = $_string;
			}
			$idx = $tableData['indexes'];
			$col = "";
			while(list($num,$indx) = @each($idx)) {
				while(list($numpos,$cols) = each($indx['index'])) {
					extract($indx['attributes'][$numpos]);
					$col[$name]= @implode(",",$cols['columns']);
				}
			}
			$sqlindex = "";
			$sqlindexes = "";
			while(list($key,$val) = @each($col)) {
				if (strtoupper($key)=='PRIMARY') { $key = " PRIMARY KEY "; } else { $key = " KEY $key "; }
				$sqlindex[] = "$key ($val)";
			}
			$sqlindexes = @implode(",",$sqlindex);
			if ($sqlindexes) { $sqlindexes =" , $sqlindexes"; }
			$finalsql[] = "drop table if exists $thistablename";
			$finalsql[] = " create table $thistablename ( ".@implode(",",$sql)." $sqlindexes ) ";

			$rows = $tableData['data'][$tableNum]['row'];
			while(list($rownum,$rowdata) = @each($rows)) { 
				$keys = "";
				$vals = "";
				while(list($k,$v) = each($rowdata)) { 
					$keys[]=$k;
					$vals[]=$v;
				}
				$datasql[] =  "insert into $thistablename (".implode(",",$keys).") values ('".implode("','",$vals)."')";
			}
		}
		$this->datasql = $datasql;
		$this->sql = $finalsql;
		return $finalsql;
	}


	function getTablesFromTree() {
		$table = $this->packageInfo['table'];
		while(list($tableNum,$tableData) = @each($table)) {
			$tableNames[] = $tableData['attributes']['name'];
		}
		return $tableNames;
	}



/*
 * basic functions to take MySQL table defs and make schema
 * or take XML schema and make MySQL SQL create table statements
 */


	function sqldef2XML($dbtables,$file='',$storeData=false) {
		$db = DB::getHandle();
if (!is_array($dbtables)) { 
	$tablelist[] =$dbtables;
} else { $tablelist = $dbtables; } 
while(list($k,$dbtable) = @each($tablelist)) { 

		$xml = "";
		
		$def = $db->getTableIndexes($dbtable);
		while(list($k,$v) = each($def)) {
			extract($v);
			$in[$Table][$Key_name][] = $Column_name;
		}
		while(list($table,$key) = each($in)) {
			while(list($keyname,$cols) = each($key)) {
				$xml .="<index name='$keyname'>\n";
				while(list($junk,$col) = each($cols)) {
					$xml .= "<column>$col</column>\n";
				}
				$xml .= "</index>\n";
			}
		}
		$idx =$xml;

		$xml = "";
		$def = $db->getTableDef($dbtable);
		while(list($k,$v) = each($def)) {
			$xml .= "<column>\n";
			while(list($key,$val) = each($v)) {
				$key = strtolower($key);
				if (strpos($val,'(')) {
					$val = str_replace(")","",$val);
					list($val,$len) = split("\(",$val);
					$v['len'] = $len;
				}
				$xml .= "\t<$key>$val</$key>\n";
			}
			$xml .= "</column>\n";
		}

		$colData = "";
		if ($storeData) { 
			$db->query("select * from $dbtable");
			$db->RESULT_TYPE = MYSQL_ASSOC;
			while($db->nextRecord()) { 
			print_r($db->record);
				$j = $db->record;
				$colData .="<row>\n";
				while(list($k,$v) = each($j)) { 
					$colData .= "<$k>$v</$k>\n";
				}
				$colData .="</row>\n";
			}
		}
		if ($colData) { $colData = "<data>\n$colData\n</data>\n"; }


		$sqlxml .= "<table name='$dbtable'>\n$xml\n<indexes>\n$idx\n</indexes>\n$colData\n</table>\n";

} // end table array looping
		$sqlxml = "<database>\n$sqlxml\n</database>";
#		$xml = "<database>\n<table name='$dbtable'>\n$xml\n<indexes>\n$idx\n</indexes>\n$colData\n</table>\n</database>";
		if ($file=='') {
			$this->dbXML = $sqlxml;
			return $sqlxml;
		} else {
			$f = fopen($file,"w");
			fputs($f,$sqlxml);
			fclose($f);
			return true;
		}



	}




}






function columnsParse($section) {
	while(list($key,$val) = each($section)) {
		$info[$val['tag']] = $val['value'];
	}
	return $info;
}
function rowParse($section) {
	while(list($key,$val) = each($section)) {
		$info[$val['tag']] = $val['value'];
	}
	return $info;
}
function infoParse($section) {
	while(list($key,$val) = each($section)) {
		$info[$val['tag']] = $val['value'];
	}
	return $info;
}
function indexParse($section) {
	while(list($key,$val) = each($section)) {
		if ($val['tag']=='column') { 
			$info['columns'][] = $val['value'];
		} 
		if ($val['tag']=='type') { 
			$info['type'][] = $val['value'];
		} 
	}
	return $info;
}
function indexesParse($section) {
	while(list($key,$val) = each($section)) {
		if ($val['tag']=='index') { 
			$info['index'][] = indexParse($val['children']);
			$info['attributes'][] = $val['attributes'];
		} 
	}
	return $info;
}
function tableParse($section) {
	while(list($key,$val) = each($section)) {
		if ($val['tag']=='column') {
			$info['column'][] = columnsParse($val['children']);
		} elseif ($val['tag'] == 'indexes') {
			$info['indexes'][] = indexesParse($val['children']);
		} elseif ($val['tag'] == 'data') {
			$info['data'][] = dataParse($val['children']);
		} else {
			$info[$val['tag']] = $val['value'];
		}
		$info['attributes'] = $val['attributes'];
	}
	return $info;
}
function dataParse($section) {
	while(list($key,$val) = @each($section)) {
		if ($val['tag']=='row') {
			$info['row'][] = rowParse($val['children']);
		} 
	}
	return $info;
}
function configsParse($section) {
	while(list($key,$val) = @each($section)) {
		if ($val['tag']=='config') {
			$info['config'][] = configParse($val['children']);
		} else {
			$info[$val['tag']] = $val['value'];
		}
	}
	return $info;
}

function configParse($section) {
	while(list($key,$val) = @each($section)) {
		if ($val['tag']=='options') {
			$info['options'] = optionsParse($val['children']);
		} else {
			$info[$val['tag']] = $val['value'];
		}
	}
	return $info;
}
function optionsParse($section) {
	while(list($key,$val) = @each($section)) {
		if ($val['tag']=='option') {
			$info[] = $val['value'];
		}
	}
	return $info;
}




// XML tree parsing stuff
// sample data returned:
function GetChildren($vals, &$i) {
	$children = array();
	while (++$i < sizeof($vals)) {
		switch ($vals[$i]['type']) {
			case 'cdata':
				$children[] = $vals[$i]['value'];
				break;
			case 'complete':
				$temp = array(
				'tag' => $vals[$i]['tag'],
				'attributes' => $vals[$i]['attributes'],
				'value' => $vals[$i]['value']
				);
				$children[] = $temp;
				break;
			case 'open':
				$temp = array(
				'tag' => $vals[$i]['tag'],
				'attributes' => $vals[$i]['attributes'],
				'value' => $vals[$i]['value'],
				'children' => GetChildren($vals, $i)
				);
				$children[] = $temp;
				break;
			case 'close':
				return $children;
		}
	}
}


/*
 * GetXMLTree
 * 
 * takes file handle or data string
 * and returns a tree array
 * currently not LC tree array
 * perhaps should migrate to that later
 *
 * @param file string Full path to file OR simply a text string of XML data - system will determine if file exists and use that, else tries to use string data
 * @returns array Returns the array tree structure
 */
/* SAMPLE TREE ARRAY (PARTIAL)
Array
(
    [0] => Array
        (
            [tag] => package
            [attributes] => 
            [value] => 
            [children] => Array
                (
                    [0] => Array
                        (
                            [tag] => info
                            [attributes] => 
                            [value] => 
                            [children] => Array

*/


function GetXMLTree($file) {
	if (file_exists($file)) { 
		$data = implode('', file($file));
	} else {
		$data = $file;
	}
	$data = eregi_replace(">"."[[:space:]]+"."<","><",$data);
	$p = xml_parser_create();
	xml_parser_set_option($p, XML_OPTION_CASE_FOLDING, 0);
	xml_parse_into_struct($p, $data, &$vals, &$index);
	xml_parser_free($p);
	$i = 0;
	$tree = array();
	$tree[] = array(
		'tag' => $vals[$i]['tag'],
		'attributes' => $vals[$i]['attributes'],
		'value' => $vals[$i]['value'],
		'children' => GetChildren($vals, $i)
	);
	return $tree;
}

?>
