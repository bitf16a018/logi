<?

class PBDO_GraphManager {

	var $magnify = 5;
	var $_imageColWidth = 11;
	var $_imageRowHeight = 9;
	var $_yoffset = 10;
	var $engine;			//pointer to engine
	var $canvas;			//GD pointer
	var $widgets = array();		//array of points for each "class" or "table"
	var $layoutDirty = true;
	var $colors = array();		//set of colors for the graph
					// name = array(r,g,b); 0-255
	var $bounds = array(1024,580);	//boundries of final image

	var $carret = array('x'=>0,
			    'y'=>0);	//point for next widget placement
	var $fontRatio = 7;		//multiplier for font metrics

	var $x_padding = 140;
	var $y_padding = 100;
	var $widget_border = 3;

	/**
	 * take a PBDO_Compiler object as the definition
	 * of our resultant graph.
	 */
	function PBDO_GraphManager(&$e) {
		if (!$e) {
			print("* You can't start the graph manager w/o a compiler object.\n");
		}
		$this->engine =& $e;
		$this->colors = array(
			"background"=>array(255,255,255),
			"oneToOne"=>array(255,0,0),
			"oneToMany"=>array(0,184,16),
			"manyToMany"=>array(0,0,255),
			"widgetBG"=>array(255,180,90),
			"widgetBorder"=>array(0,0,0),
			"font"=>array(0,0,0)
		);


		$this->createModel();
		$this->layout = new PBDO_SugiyamaLayout();
	}


	/**
	 * Do I need to adjust the layout again?
	 */
	function needsLayout() {
		return $this->layoutDirty;
	}

	/**
	 * cycle through all available tables, set an array of points in 
	 * this -> widgets
	 */
	function doLayout() {

		$this->layout->doLayout($this->model);

		$next_offset_x = $this->widget_border + 20;
		$next_offset_y = $this->widget_border + 20;

		//translate the layouts array of arrays
		// into x & y coordinates
		foreach($this->layout->levels as $kl=>$l) {
			$gridx=0;
			if (is_array($l)) { 
			foreach($l as $kn=>$n) {

				//find out how long the longest name is
				// truncate long names to some sane measurement
				unset($longest);
				unset($num_cols);
				@reset($n->ports);
				while (list($k,$v) = @each($n->ports) ) {
					$portName = $this->model->ports[$k]->name." ".$this->model->ports[$k]->type;
					$longest = strlen($portName) > $longest? strlen($portName):$longest;
//					print 'is '.strlen($portName) .' longer than ' .$longest ."\n";
					$num_cols++;
				}
				$longest = strlen($n->tableName) > $longest? strlen($n->tableName):$longest;
				$n->w = ($longest*$this->fontRatio*2);


				//find out how many attribs there are
				// make as long as necassary
				$n->h = ($num_cols * $this->fontRatio)*2 + 30;
				
				/*
				if ($this->widgets[$name]['h']> $rowHeight) { 
					$rowHeight = $this->widgets[$n->tableName]->h;
				}
				*/

				$n->x = ($this->x_padding * $gridx) + $next_offset_x;
				$n->y = ($this->y_padding * $gridy) + $next_offset_y;
				$this->widgets[$n->tableName] = $n;

				$tallest = $n->h > $tallest ? $n->h:$tallest;

				$next_offset_x += $n->w + 20;


				$ImageWidth = $ImageWidth > $longest+$n->x+$n->w ? $ImageWidth:$longest+$n->x+$n->w;
				$ImageHeight = $ImageHeight > $longest+$n->y+$n->h ? $ImageHeight:$longest+$n->y+$n->h;

				++$gridx;
			}
			}
			++$gridy;
			$next_offset_y += $tallest;
			$next_offset_x = $this->widget_border + 20;
			$tallest = 0;
		}


		//__FIXME__ this should have a better function
		$this->bounds[0] = $ImageWidth + 20;
		$this->bounds[1] = $ImageHeight;

	}


	/**
	 * only adjust the veritcal right now
	 */
	function adjustBounds($size=400) {
		echo "adjusting $size down\n=====\n";
		$this->bounds[1] += $size;
	}


	function strokeGraph() {
		if ($this->needsLayout() ) {
			$this->doLayout();
		}

		//setup resources for GD
		$this->canvas =& imageCreate($this->bounds[0],$this->bounds[1]);
		$this->gdColors = array();
		while (list($cname,$rgb) = @each($this->colors) ) {
			$this->gdColors[$cname] = imageColorAllocate($this->canvas,$rgb[0],$rgb[1],$rgb[2]);
		}

		$tableList = PBDO_Compiler::$model->entities;
//print_r($this->widgets);exit();
	
		foreach($this->widgets as $name=>$w) { 
			if (!$name) {continue;}
			$this->drawWidget($name,$w,
				$this->model->getNodeByName($name)
			);
		}

		$this->drawEdges();

		//print_r($this->model->nodes['client_info']);

	}



	function drawWidget($name,$w) {

		imagefilledrectangle($this->canvas,$w->x-$this->widget_border,$w->y-$this->widget_border,
				$w->x+$w->w+$this->widget_border,$w->y+$w->h+$this->widget_border,$this->gdColors['widgetBorder']);
		imagefilledrectangle($this->canvas,$w->x,$w->y,
				$w->x+$w->w,$w->y+$w->h,$this->gdColors['widgetBG']);

		$xdelta = ($w->w - strlen($name)*$this->fontRatio) / 2;

		imagestring($this->canvas,3,$w->x+$xdelta,$w->y,$name,$this->gdColors['font']);
//		imagestring($this->canvas,3,$w->x+$xdelta,$w->y,$w->tablePos,$this->gdColors['font']);

		imageline($this->canvas,$w->x,$w->y+$this->widget_border+$this->fontRatio*2,
					$w->x+$w->w,
					$w->y+$this->widget_border+$this->fontRatio*2,$this->gdColors['font']);


		reset($w->ports);
		while (list($k,$portId) = @each($w->ports) ) {
			$port = $this->model->ports[$portId];

			$z = 2 * ($k+1);
			imagestring($this->canvas,3,
					$w->x+$this->widget_border,$w->y + $this->fontRatio*($z)+$this->widget_border,
					$port->name,$this->gdColors['font']);

			imagestring($this->canvas,3,
					$w->x + $w->w - ($this->fontRatio * (strlen($port->type))),
					$w->y +($this->fontRatio*($z)+$this->widget_border),
					$port->type,$this->gdColors['font']);

		}
	}


	function drawEdges() {
		while (list($k,$edge) = @each($this->model->edges) ) {

			//choose a color
		    $linecount++;

			if($linecount % 3) {
				$this->gdColors['lineColor'] = $this->gdColors['manyToMany'];
			} else 
			if($linecount % 2) {
				$this->gdColors['lineColor'] = $this->gdColors['oneToMany'];
			}
			else {
				$this->gdColors['lineColor'] = $this->gdColors['oneToOne'];
			}




			//draw the line
//			if (! $edge->targetPort ) { continue; }


			$targetNode = $this->model->nodes[$edge->target];
			$target = $this->widgets[$targetNode->tableName];
			$sourceNode = $this->model->nodes[$edge->source];
			$source = $this->widgets[$sourceNode->tableName];
			$sport = $this->model->ports[$edge->sourcePort];
			$tport = $this->model->ports[$edge->targetPort];
			//print_r($tport);

			//find which way to stick the lines
			// if the source's left side is to the right of the target's right side, flip variables
			if ($source->x > $target->x+ $target->w) {
				$line_t_x = $target->x + $target->w;
				$line_t_y = $target->y +  ($this->fontRatio*($tport->z))*2 + $this->fontRatio;

				$line_s_x = $source->x;
				$line_s_y = $source->y +  ($this->fontRatio*($sport->z))*2 + $this->widget_border + $this->fontRatio;
				$leftToRight = 1;

			} else {

				$line_t_x = $target->x;
				$line_t_y = $target->y +  ($this->fontRatio*($tport->z))*2 + $this->fontRatio;

				$line_s_x = $source->x + $source->w;
				$line_s_y = $source->y +  ($this->fontRatio*($sport->z))*2 + $this->widget_border + $this->fontRatio;
				$leftToRight = 0;
			}


			if ($leftToRight) {
				//draw a triangle pointing to the port
				$points = array (
						0=>$line_s_x,		//x1
						1=>$line_s_y,		//y1
						2=>$line_s_x-8,		//x2
						3=>$line_s_y-6,		//y2
						4=>$line_s_x-8,		//x3
						5=>$line_s_y+6		//y3
					);
				imagefilledpolygon($this->canvas, $points, 3, $this->gdColors['lineColor']);

				//line across for debugging
	//			imageline($this->canvas,$line_s_x , $line_s_y, $line_s_x -100 , $line_s_y, $this->gdColors['lineColor']);
	//			imageellipse($this->canvas,$line_s_x, $line_s_y, 6,6, $this->gdColors['lineColor']);


				//draw two small lines sticking out of target and source
				imageline($this->canvas,$line_s_x , $line_s_y, 
						$line_s_x - 15, $line_s_y, $this->gdColors['lineColor']);
				imageline($this->canvas,$line_t_x , $line_t_y, 
						$line_t_x + 15, $line_t_y, $this->gdColors['lineColor']);

				$line_s_x -=15;
				$line_t_x +=15;
				imageline($this->canvas,$line_s_x , $line_s_y, $line_t_x, $line_t_y, $this->gdColors['lineColor']);
			} else {

				//draw a triangle pointing to the port
				$points = array (
						0=>$line_s_x,		//x1
						1=>$line_s_y,		//y1
						2=>$line_s_x+8,		//x2
						3=>$line_s_y-6,		//y2
						4=>$line_s_x+8,		//x3
						5=>$line_s_y+6		//y3
					);
				imagefilledpolygon($this->canvas, $points, 3, $this->gdColors['lineColor']);

imagestring($this->canvas,3,$line_t_x-20,$line_t_y+20,$tport->z,$this->gdColors['font']);

				//line across for debugging
	//			imageline($this->canvas,$line_s_x , $line_s_y, $line_s_x -100 , $line_s_y, $this->gdColors['lineColor']);
	//			imageellipse($this->canvas,$line_s_x, $line_s_y, 6,6, $this->gdColors['lineColor']);


				//draw two small lines sticking out of target and source
				imageline($this->canvas,$line_s_x , $line_s_y, 
						$line_s_x + 15, $line_s_y, $this->gdColors['lineColor']);
				imageline($this->canvas,$line_t_x , $line_t_y, 
						$line_t_x - 15, $line_t_y, $this->gdColors['lineColor']);

				$line_s_x +=15;
				$line_t_x -=15;
				imageline($this->canvas,$line_s_x , $line_s_y, $line_t_x, $line_t_y, $this->gdColors['lineColor']);
			}
		}
	}


	function saveGraph() {
		@mkdir("projects/".PBDO_Compiler::$model->projectName."/graph");
		imagePng($this->canvas,"projects/".PBDO_Compiler::$model->projectName."/graph/schema.png");
	}


	function createModel() {

		$this->model = new PBDO_GraphModel();

		$tableList = PBDO_Compiler::$model->entities;

		foreach($tableList as $tableObj) { 
			unset($n);
			$n = new PBDO_GraphNode();
			$n->tableName = $tableObj->name;
			$this->model->addNode($n);
		}


		reset($tableList);
		foreach($tableList as $tableObj) { 
			$name = $tableObj->name;
			foreach($tableObj->attributes as $column) { 

				$colName = $column->name;
//				$source = $this->model->getNodeByName($tableObj->name);
				unset($p);
				$p = new PBDO_GraphPort();
				$source = $this->model->getNodeByName($name);
				if (!$source) continue;
				$p->parent = $source->id;
				$p->name = $colName;
				$p->type = $column->type;
				$p->z = count($this->model->nodes[$source->id]->ports)+1;

				$this->model->addPort($p);
				$this->model->nodes[$source->id]->addPort($p);
			}
		}


	    $relations = PBDO_Compiler::$model->relationships;
	    foreach($relations as $blank=>$columns) { 
			$localName = $columns->getEntityA();
			$localCol = $columns->getAttribA();
			$relatedName = $columns->getEntityB();
			$relatedCol = $columns->getAttribB();

			//ports
			unset($source);
			unset($sourcePort);
			$source = $this->model->getNodeByName($localName);
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
}

class PBDO_GraphNode {
	var $id;
	var $ports = array();
	var $tableName;

	function addPort($p) {
		foreach($this->ports as $k=>$port)  {
			if ( $port->name == $p) return;
		}
		$this->ports[] = $p->id;
	}


	function &getPortByName($name,$m) {

		foreach($this->ports as $blank=>$id) {

			if ($m->ports[$id]->name == $name) {
				return $m->ports[$id];
			}
		}
		return null;
	}

}

class PBDO_GraphPort {

	var $id;
	var $parent;		//node

}


class PBDO_GraphEdge {

	var $id;
	var $source;		//node
	var $target;		//node
	var $sourcePort;	//port
	var $targetPort;	//port
}


class PBDO_GraphModel {
	var $nodes;
	var $edges;
	var $ports;

	function addPort(&$p) {
		static $c;
		++$c;
		$p->id = $c;
		$this->ports[$p->id] =& $p;
	}


	function addEdge(&$e) {
		static $c;
		++$c;
		$e->id = $c;
		$this->edges[$e->id] =& $e;
	}


	function addNode(&$n) {
		static $c;
		++$c;
		$n->id = $c;
		$this->nodes[$n->id] =& $n;
	}


	function &getNodeByName($name) {

		foreach($this->nodes as $id=>$node) {
			if ($node->tableName == $name) {
				return $this->nodes[$id];
			}
		}
		return null;
	}

}


class PBDO_LayoutManager {

	/**
	 * @abstract
	 */
	function doLayout() { }
}


class PBDO_SugiyamaLayout extends PBDO_LayoutManager {


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
		$currentLevel = array();
		$level = $this->levels[$y];

		for ($x=0; $x < count($level); ++$x) {
			$node = $level[$x];
			$portCount = count($node->ports);
			$currentLevel[$node->id] = $portCount;
			$nodeStore[$node->id] = $node;
		}

		//sort the level based on the node count
		@arsort($currentLevel);
		unset($newLevel);
		unset($count);
		$lsize = count($currentLevel);
		$insertAt = ceil($lsize/2);
		$middle = ceil($lsize/2);
		$newLevel = array();
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
class PBDO_WidgetWrapper {

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
?>
