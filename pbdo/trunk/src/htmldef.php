<?

class PBDO_HTMLManager {

	var $magnify = 5;
	var $_imageColWidth = 11;
	var $_imageRowHeight = 9;
	var $_yoffset = 10;
	var $engine;			//pointer to engine
	var $widgets = array();		//array of points for each "class" or "table"


	/**
	 * take a PBDO_Compiler object as the definition
	 * of our resultant set of HTML pages.
	 */
	function PBDO_HTMLManager(&$e) {
		if (!$e) {
			print("* You can't start the HTML manager w/o a compiler object.\n");
		}
		$this->engine =& $e;
	}




	function generateHTML() {
		$tableList = $this->engine->database->tables;

	
	/*
print_r($this->engine->foreignKeys);exit();
foreach($this->engine->foreignKeys as $k => $v) {
	$foreignTable = $v[0]->attributes['foreignTable']->value;
	$localTable = $v[2];
	$localColumn = $v[1]->attributes['local']->value;
	$foreignColumn = $v[1]->attributes['foreign']->value;
	print "found FOREIGN table \t\t". $foreignTable . " ($foreignColumn)\n";
	print "relates to LOCAL table \t\t". $localTable . "\n";
	print "via LOCAL column \t\t". $localColumn . "\n\n";

	if ( is_object($engine->classes[$localTable]) ) {
		$engine->classes[$localTable]->setForeignKey($localColumn,$foreignTable);
	}
	if ( is_object ($engine->classes[$foreignTable]) ) {	//sometimes we reference DBs not in the XML
		$engine->classes[$foreignTable]->setForeignRelation($localTable,$foreignColumn,$localColumn);
	}

	if ( is_object($engine->classes[$localTable]) ) {
		$engine->classes[$localTable]->setLocalRelation($foreignTable,$localColumn,$foreignColumn);
	}
	print "\n";
}
	*/
echo "========================================-----------------------\n";
		foreach($this->engine->database->tables as $name=>$tableObj) { 
			$comment= $tableObj->comment;
			if ($comment!='') { 
				echo "comm=$comment<BR>";exit();
			}


		$yn[0]='N'; $yn[1] = 'Y';
			$page = "<a name='$name'></a><h3 align='center'>Data definition for $name</h3>";
			$page .= "<a href='#top'>top</a><br/>";
			$page .= "<table>";
			$page .="<tr>";
			$page .= "<td>Name</td>";
			$page .="<td>Type</td>";
			$page .="<td>Size</td>";
			$page .="<td>NULL?</td>";
			$page .="<td>AutoInc?</td>";
			$page .="<td>Primary?</td>";
			$page .= "</tr>";
			foreach($tableObj->columns as $colName=>$column) { 
				$col++;
				if ($col==2) { 
					$class=" style='background-color: #CCC;'"; $col=0; 
				} else { 
				 $class=" style='background-color: #DDD;'"; } 
				$page .="<tr$class>";
				$page .= "<td>$colName</td>";
				$page .="<td>".$column->type."</td>";
				$page .="<td>".$column->size."</td>";
				$page .="<td>".$yn[$column->null]."</td>";
				$page .="<td>".$yn[$column->auto]."</td>";
				$page .="<td>".$yn[$column->primary]."</td>";
				$page .= "</tr>";
			}
			$page .= "</table>";
			if (is_array($this->engine->foreignKeys)) { 
				foreach($this->engine->foreignKeys as $k=>$array) {
					$foreign = $array[0];
					$joint = $array[1];
					$j = $foreign->ownerElement;
					$tableName = $j->getAttribute("name");
					$foreignTable = $foreign->attributes['foreignTable']->value;
					$localColumn = $joint->attributes['local']->value;
					$foreignColumn = $joint->attributes['foreign']->value;

// also, need to check for other entities which have THIS table as a foreign relation
					$t1 = $tableName;
					$t2 = $foreignTable;
					if ($tableName == $name) { // we have matching stuff
						$relations[$t2] .= "<tr>";
						$relations[$t2] .= "<td><i>$localColumn</i> is related to <i>$foreignColumn</i> in the <i><a href='#$t1'>$t1</a></i> table/entity</td>";
						$relations[$t2] .= "</tr>";
						$relations[$t1] .= "<tr>";
						$relations[$t1] .= "<td><i>$localColumn</i> is related to <i>$localColumn</i> in  <i><a href='#$t2'>$t2</a></i></td>";
						$relations[$t1] .= "</tr>";
					}

					if ($foreignTable == $name) { // we have matching stuff
						$frelations[$t2] .= "<tr>";
						$frelations[$t2] .= "<td><i>$foreignColumn</i> in <i><a href='#$t1'>$t1</a></i> is related to <i>$localColumn</i></td>";
						$frelations[$t2] .= "</tr>";

						$frelations[$t1] .= "<tr>";
						$frelations[$t1] .= "<td><i>$foreignColumn</i> in <i><a href='#$t2'>$t2</a></i> is related to <i>$localColumn</i></td>";
						$frelations[$t1] .= "</tr>";
					#	$frelations[$tableName] .= "<tr>";
					#	$frelations[$tableName] .= "<td><i>$foreignColumn</i> in <i><a href='$foreignTable.html'>$foreignTable</a></i> is related to <i>$localColumn</i></td>";
					#	$frelations[$tableName] .= "</tr>";
					}
				}
			}
			$this->pages[$name] = $page;
		}
		foreacH($this->pages as $k=>$v) { 
			if ($relations[$k]!='' ) {
				$this->pages[$k] .= "<h3>Relations</h3><table>".$relations[$k]."</table>";
			}
			if ($frelations[$k]!='' ) {
				#$this->pages[$k] .= "<h3>Inbound relations</h3><table>".$frelations[$k]."</table>";
			}
		}



/*
		foreach($this->engine->classes as $name=>$tableObj) { 


			//do edges
			$relations = $tableObj->localRelations;

		    foreach($relations as $localCol=>$columns) { 
				$relatedName = $columns[0];
				$relatedCol = $columns[1];

				//ports
				unset($source);
				unset($sourcePort);
				$source = $this->model->getNodeByName($name);
				$sourcePort = $source->getPortByName($localCol,$this->model);


				//target port
				unset($target);
				unset($targetPort);
				$target = $this->model->getNodeByName($relatedName);
				if(!$target)continue;
				$targetPort = $target->getPortByName($relatedCol,$this->model);


				//edges
				unset($e);
				$e = new PBDO_GraphEdge();
				$e->source = $source->id;
				$e->target = $target->id;
				$e->targetPort = $targetPort->id;
				$e->sourcePort = $sourcePort->id;
				$this->model->addEdge($e);

		    }
		}
		*/

	}


	function saveHTML() { 
		$path ="projects/".$this->engine->projectName."/html";
		@mkdir($path);
		foreach($this->pages as $name=>$page) { 
			$list .= "<a href='#$name'>$name</a><BR/>\n";
			#	$f = fopen($path."/$name".".html","w");
			#fputs($f,$page);
			#fclose($f);
			$final .= $page."<HR>";
		}
		#$f = fopen($path."/index.html","w");
		#$string = "<h2>Data object info</h2>$list<hr>Generated on: ".date("m/d/Y h:i:s A");
		#fputs($f,$string);
		#fclose($f);
		$list = "<a name='top'></a><h2>Data definitions</h2>$list";
		$string = "<frameset cols='30%,*'>
		<frame name='col' src='col.html'>
		<frame name='main' src='final.html'>
		</frameset>";
		$col= "
		<h2>Data Objects</h2>
		<a href='final.html' target='main'>Data definitions</a>
		<br/>
		<a href='schema.html' target='main'>Schema</a>
		";

		$f = fopen($path."/col.html","w");
		fputs($f,$col);
		fclose($f);
		$f = fopen($path."/schema.html","w");
		fputs($f,"<img src='../graph/schema.png'>");
		fclose($f);
		$f = fopen($path."/index.html","w");
		fputs($f,$string);
		fclose($f);
		$f = fopen($path."/final.html","w");
		fputs($f,$list.$final);
		fclose($f);
	}


	function createModel() {

		$this->model = new PBDO_GraphModel();

		$tableList = $this->engine->database->tables;
		foreach($tableList as $name=>$tableObj) { 
			unset($n);
			$n = new PBDO_GraphNode();
			$n->tableName = $name;
			$this->model->addNode($n);
		}

		foreach($this->engine->database->tables as $name=>$tableObj) { 
			foreach($tableObj->columns as $colName=>$column) { 
			print_r($column);
			echo "\n\n============\n\n";
			}
		}
/*
		foreach($this->engine->classes as $name=>$tableObj) { 


			//do edges
			$relations = $tableObj->localRelations;

		    foreach($relations as $localCol=>$columns) { 
				$relatedName = $columns[0];
				$relatedCol = $columns[1];

				//ports
				unset($source);
				unset($sourcePort);
				$source = $this->model->getNodeByName($name);
				$sourcePort = $source->getPortByName($localCol,$this->model);


				//target port
				unset($target);
				unset($targetPort);
				$target = $this->model->getNodeByName($relatedName);
				if(!$target)continue;
				$targetPort = $target->getPortByName($relatedCol,$this->model);


				//edges
				unset($e);
				$e = new PBDO_GraphEdge();
				$e->source = $source->id;
				$e->target = $target->id;
				$e->targetPort = $targetPort->id;
				$e->sourcePort = $sourcePort->id;
				$this->model->addEdge($e);

		    }
		}
		*/
	}
}

class PBDO_LayoutManager2 {

	/**
	 * @abstract
	 */
	function doLayout() { }
}


class PBDO_SugiyamaLayout2 extends PBDO_LayoutManager2 {


	var $levels;
	var $edges;
	var $nodes;
	var $nodesPerLevel =		3;


	/**
	 * Init. levels, organize, shuffle
	 *
	 */
	function doLayout($model) {
		$this->nodesPerLevel = ceil( pow(count($model->nodes),.5) );
		$levelCount = ceil( count($model->nodes)/$this->nodesPerLevel );
		$this->initializeLevels($levelCount,$model->nodes);


		//sort based on number of edges
		$this->shuffleLevels();

		//see what it looks like
		$this->debugLayout();
	}


	/**
	 * Show an ascii representation of the nodes & levels
	 *
	 */
	function debugLayout() {
		reset($this->levels);
		while ( list($blank,$row) = @each ($this->levels) ) {

			print "============================================================\n";
			while ( list($blank,$node) = @each ($row) ) {
				print "| ";
				print  $node->tableName ." \t\t";
				print "| ";
			}
			print "\n";
		}
		print "============================================================\n";
	}


	/**
	 * Create empty arrays, push nodes into arrays
	 *
	 */
	function shuffleLevels() {
		for ($y=0; $y < count($this->levels); ++$y) {
		unset($currentLevel);
		$level = $this->levels[$y];

		for ($x=0; $x < count($level); ++$x) {
			$node = $level[$x];
			$portCount = count($node->ports);
			$currentLevel[$node->id] = $portCount;
			$nodeStore[$node->id] = $node;
		}

		//sort the level based on the node count
		arsort($currentLevel);
		unset($newLevel);
		unset($count);
		$lsize = count($currentLevel);
		$insertAt = ceil($lsize/2);
		$middle = ceil($lsize/2);
		foreach ($currentLevel as $nid=>$pcount) {
//			print "insert at = $insertAt ".$nodeStore[$nid]->tableName ."\n";
			$newLevel[$insertAt] = $nodeStore[$nid];
			++$count;
			if ( $count % 2 ) {
				$insertAt = $middle - ceil($count/2);
			} else {
				$insertAt = $middle + ceil($count/2);
			}
		}
		ksort($newLevel);
		$this->levels[$y] = $newLevel;
//		print "newLevel \n\n";
		}
	}



	/**
	 * Create empty arrays, push nodes into arrays
	 *
	 */
	function initializeLevels($n,$nodes) {
		print "initializing ($n) levels...\n";
		for ($x=0; $x<$n; $x++) {
			$this->levels[$x] = array();
		}


		foreach($nodes as $nid=>$node) {
			$portCount = count($node->ports);
			$currentLevel[$node->id] = $portCount;
			$nodeStore[$node->id] = $node;
		}

		arsort($currentLevel);


		reset($nodes);
		$l=0;
		while ( list ($k,$nid) = @each($currentLevel) ) {
			for ($x=0; $x<$this->nodesPerLevel; $x++) {
				$n = $nodeStore[$k];
				$this->levels[$l][] = $n;
				list ($k,$nid) = @each($currentLevel);
			}
			++$l;
			$n = $nodeStore[$k];
			if ($n) {
				$this->levels[$l][] = $n;
			}
		}

		//levels are all sorted with the most connections at the top
		// move a few of the bottom rows on top so the most connections
		// are in the middle
		$count = count($this->levels);
		$middle = ceil($count/2);
		for ($z=$middle;  $z< $count; ++$z) {
			$tmp = array_pop($this->levels);
			array_unshift($this->levels,$tmp);
		}
	}

}





/*
class PBDO_WidgetWrapper2 {

	var $widget;
	var $node;
	var $widget;

	function PBDO_WidgetWrapper($w) {
		$this->widget = $w;
	}

	function addNode($n) {
		$this->node = $n;
		$this->node->wrapper = $this;
	}

}
*/

class htmlpage  {

}
class htmltable {

}

?>
