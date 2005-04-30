<?PHP

class PBDO_GraphManager2 extends PBDO_GraphManager {

	var $grid = array ('x'=>30,'y'=>30);


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

			$targetNode = $this->model->nodes[$edge->target];
			$sourceNode = $this->model->nodes[$edge->source];
			$sport = $this->model->ports[$edge->sourcePort];
			$tport = $this->model->ports[$edge->targetPort];

			//A* algorithm
			$this->nodeList= new AStar_NodeList();
			$this->setupGrid();

			$coords = $this->getNodeIntersect($targetNode->x,$targetNode->y);
			$nodeX = $coords['x']-1;
			$nodeY = $coords['y']-1;
			$start = $this->nodeList->nodes[$nodeX][$nodeY];
			$this->nodeList->nodes[$nodeX][$nodeY]->isStart = true;

//print_r($nodeX);print "\n";
//print_r($nodeY);print "\n";

			$coords = $this->getNodeIntersect($sourceNode->x,$sourceNode->y);
			$nodeX = $coords['x']-1;
			$nodeY = $coords['y']-1;
			$end   = $this->nodeList->nodes[$nodeX][$nodeY];
			$this->nodeList->nodes[$nodeX][$nodeY]->isEnd = true;

//print_r($nodeX);print "\n";
//print_r($nodeY);print "\n";
//exit();
			$astar = new AStar_PathFinder($start,$end);
			$astar->g = $this;
			$truePath = $astar->findPath();
			$this->paintPath($truePath,$targetNode,$tport,$sourceNode,$sport);
		}

	}


	/**
	 * gets the node coords of the x and y value
	 * this function translates between two coordinate systems
	 */
	function getNodeIntersect($x,$y,$w=0,$h=0) {
		if ($w ==0 || $h == 0 ) {
			return array (
			'x'=>floor(($x/$this->grid['x'])),
			'y'=>floor(($y/$this->grid['y']))
			);
		}
		$ret = array();
		$ret[0] = array (
			'x'=>floor(($x/$this->grid['x'])),
			'y'=>floor(( $y/$this->grid['y']))
			);
		$ret[1]  = array(
			'x'=>floor(( ($x+$w) /$this->grid['x'])),
			'y'=>floor(( ($y+$h) /$this->grid['y']))
			);
		return $ret;
	}


	/**
	 * paint a line between the start and end using the path
	 */
	function paintPath($path,$end,$eport,$start,$sport) {
		$fontSize = 13;

		while  ( list($blank,$node) = @each($path) ) {
			if (! is_object($node) ) continue;
			$x = $node->index[0];
			$y = $node->index[1];
			$nextNode = @next($path);
			$x2 = $nextNode->index[0];
			$y2 = $nextNode->index[1];
			
			$foobar = $node->getF();
			if ($foobar > 0 ) {

			imageline($this->canvas, 
					($x * $this->grid['x'] ),
					($y * $this->grid['y'] ),
					($x2 * $this->grid['x']),
					($y2 * $this->grid['y'] ),
					$this->gdColors['manyToMany']
				);

			}
			//use outside this loop
			$lastPath = $node;
		}

		//connect start with start port
		$startNode = $path[0];
		$x = $startNode->index[0];
		$y = $startNode->index[1];
		print_r($sport);
		$x2 = $start->x;
		$y2 = $start->y + ($sport->z * $fontSize) + $fontSize;

			imageline($this->canvas, 
					($x * $this->grid['x'] ),
					($y * $this->grid['y'] ),
					($x * $this->grid['x'] ),
					($y2),
					$this->gdColors['manyToMany']
				);
			imageline($this->canvas, 
					($x * $this->grid['x']),
					($y2),
					($x2),
					($y2),
					$this->gdColors['manyToMany']
				);


		//connect end with end port
		$x = $lastPath->index[0];
		$y = $lastPath->index[1];
//		print_r($sport);
		$x2 = $end->x;
		$y2 = $end->y + ($eport->z * $fontSize) + $fontSize;

			imageline($this->canvas, 
					($x * $this->grid['x'] ),
					($y * $this->grid['y'] ),
					($x * $this->grid['x']),
					($y2),
					$this->gdColors['manyToMany']
				);
			imageline($this->canvas, 
					($x * $this->grid['x']),
					($y2),
					($x2),
					($y2),
					$this->gdColors['manyToMany']
				);

	}



	/**
	* Create a list of Nodes
	*/
	function setupGrid() {
		for ($x = 0; $x < $this->bounds[0]; $x += $this->grid['x'] ) {

			for ($y =0; $y < $this->bounds[1]; $y+= $this->grid['y']) {
				$xprime = floor($x/$this->grid['x']);
				$yprime = floor($y/$this->grid['y']);

				$n = new AStar_Node($this->nodeList);

				$this->nodeList->addNewNodeAt($n,$xprime,$yprime);
			}
		}

		//setup obstacles
		foreach ($this->model->nodes as $blank=>$graphNode) {
			$coords = $this->getNodeIntersect($graphNode->x,
							$graphNode->y,
							$graphNode->w,
							$graphNode->h);
	
			//give a padding all the way around each table
			$coords[0]['x'] = $coords[0]['x'] - 2;
			$coords[0]['y'] = $coords[0]['y'] - 2;
			$coords[1]['x'] = $coords[1]['x'] + 2;
			$coords[1]['y'] = $coords[1]['y'] + 2;
		//	print_r($coords);exit();
		//}
			for ($zz=$coords[0]['x']; $zz < $coords[1]['x']; ++$zz) {
				for ($jj=$coords[0]['y']; $jj < $coords[1]['y']; ++$jj) {
					$this->nodeList->nodes[$zz][$jj]->isObstacle = true;
					//echo "$zz, $jj \n";
				}
			}
		}
	}


















	function debugPrintNodes() {

		foreach ($this->nodeList->nodes as $x => $ynodes ) {
			foreach ($ynodes as $y => $node ) {
				if (! is_object($node) ) continue;


				$foobar = $node->getF();
				if ($foobar > 0 ) {

				imagefilledrectangle($this->canvas, 
						($x * $this->grid['x']+1),
						($y * $this->grid['y']+1),
						($x * $this->grid['x'] + $this->grid['x'] - 1),
						($y * $this->grid['y'] + $this->grid['y'] - 1),
						$this->gdColors['oneToOne']
					);

				}

				if ($node->isPath) {
				imagefilledrectangle($this->canvas, 
						($x * $this->grid['x']+1),
						($y * $this->grid['y']+1),
						($x * $this->grid['x'] + $this->grid['x'] - 1),
						($y * $this->grid['y'] + $this->grid['y'] - 1),
						$this->gdColors['manyToMany']
					);
				}


				//
				if ($node->isObstacle) {

				imagefilledellipse($this->canvas, 
						($x * $this->grid['x']+20),
						($y * $this->grid['y']+20),
						20,20,
						$this->gdColors['widgetBorder']
					);

				}
				//*/

/*
				if ($foobar > 0 ) {
				imagestring($this->canvas, 
						2,
						($x * $this->grid['x']),
						($y * $this->grid['y'])+10,
						sprintf("%.2f",$node->getF()),
						$this->gdColors['black']
					);
				}

				imagestring($this->canvas, 
						2,
						($x * $this->grid['x']),
						($y * $this->grid['y']),
						"$x,$y",
						$this->gdColors['black']
					);
*/
			}
		}
	}


	function printStartEndNodes() {

		foreach ($this->nodeList->nodes as $x => $ynodes ) {
			foreach ($ynodes as $y => $node ) {
				if ($node->isStart ) {

//					echo "start found at $x,$y \n\n";
				imagefilledellipse($this->canvas, 
						($x * $this->grid['x']+20),
						($y * $this->grid['y']+20),
						20,20,
						$this->gdColors['widgetBG']
					);

				}

				if ($node->isEnd ) {

//					echo "end found at $x,$y \n\n";
				imagefilledellipse($this->canvas, 
						($x * $this->grid['x']+20),
						($y * $this->grid['y']+20),
						20,20,
						$this->gdColors['widgetBG']
					);

				}

			}
		}
	}

	function saveFrame() {
		static $frame;
		imagePng($this->canvas,"./images/graph".sprintf("%05d",$frame).".png");
		++$frame;
	}









}










class AStar_Node {
	private $f;
	private $g;
	private $h;

	public $isStart;
	public $isEnd;
	public $isObstacle;

	public $bounding = array();
	public $index = array();

	private $listContainer;

	public $parent;
	public $isPath = false;

	function AStar_Node(&$list) {
		$this->listContainer =& $list;
	}

	function setH($h) {
		$this->h = $h;
	}

	function setG($g) {
		$this->g = $g;
	}

	function getF() {
		return $this->g + $this->h;
	}

	function getG($g) {
		return $this->g;
	}

	function getH($h) {
		return $this->h;
	}


	/**
	* just pass up requests for neighboring nodes to the
	* node container, it makes it easier on the
	* sorting algorithm not to have to worry about the container
	* as well as all the nodes
	*/
	function & getSurrounding() {
		return $this->listContainer->getSurrounding($this);
	}


	/**
	* any two nodes that share the same index are "equal"
	*/
	function equals($node) {
		if ($node->index[0] == $this->index[0]
		&& $node->index[1] == $this->index[1]) {
			return true;
		} else {
			return false;
		}
	}
}


class AStar_PathFinder {
	private $open = array();
	private $closed = array();

	private $start;
	private $end;

	function AStar_PathFinder(&$startNode, &$endNode) {
		$startNode->setG(0);
		$startNode->setH(0);

		$this->start =& $startNode;
		$this->end =& $endNode;

		$this->open[] =& $startNode;
		$this->closed = array();
	}


	/**
	* main algorithm
	*/
	function findPath() {
		$foundEnd = false;

		while (!$foundEnd ) {

			unset($currentNode);
			//find lowest F(n)
			$currentNode = $this->findLowestF();
			if ($currentNode == null ) {
				$foundEnd = true;
				break;
			}

			//are we at the end?
			if ($currentNode->isEnd) {
				//return array($currentNode);
				$foundEnd= true;
				break;
			}

			/*
			//check to make sure current node is not in "closed"
			for ($xx=0; $xx < count($this->closed); ++$xx) {
				if ($this->closed[$xx] == $currentNode) {
					continue;
				}
			}
			*/
/*
			//check to make sure current node is not in "open"
			for ($xx=0; $xx < count($this->open); ++$xx) {
				if (! is_object($this->open[$xx]) ) { continue;}
				if ($this->open[$xx]->equals($currentNode) ) {
					continue;
				}
			}
*/

			//add neighbors to the open stack
			$neighbors = $currentNode->getSurrounding();
			for ($xx=0; $xx < count($neighbors); ++$xx) {

				/*/is the neighbor the end?
				if ($neighbors[$xx]->isEnd) {
					$this->open[] = $neighbors[$xx];
					$foundEnd = true;
					break;
				}
				//*/

				//print "neighbors xx = ".$neighbors[$xx]->index[0]. ', '.$neighbors[$xx]->index[1]."\n\n";
				//check to make sure none of the neighbor nodes are not in "closed"
				for ($yy=0; $yy < count($this->closed); ++$yy) {
					if ($this->closed[$yy]->equals( $neighbors[$xx]) ) {
						//$this->closed[$yy]->parent =& $currentNode;
						unset($neighbors[$xx]);
						//die("closed is also a neighbor");
						continue;
					}
				}

				//check to make sure none of the neighbor nodes are not in "open"
				for ($yy=0; $yy < count($this->open); ++$yy) {
					if (! is_object($this->open[$yy]) ) { continue;}
					if ($this->open[$yy]->equals( $neighbors[$xx]) ) {
//						$this->open[$yy]->parent =& $currentNode;
						unset($neighbors[$xx]);
					}
				}


				if ( ! is_object($neighbors[$xx]) ) {continue;}

				if ( $neighbors[$xx] ->equals($currentNode->parent) ) {
					die ('corruption');
					continue;
				}

				if (! isset($neighbors[$xx]->parent) )
				$neighbors[$xx]->parent = &$currentNode;
				//print "setting parent of neighbors xx = ".$neighbors[$xx]. ' to  '.$currentNode."\n\n";

				if ($neighbors[$xx]  ==  $currentNode) {
					die ('corruption');
				}

				//H(n) is always Euclidian distance to end point
				//only goes south east
				$neighbors[$xx]->setH(
				sqrt( (
				//a squared
				pow ( $this->end->index[0] - $neighbors[$xx]->index[0],2 )
				// plus b squared
				+
				pow ( $this->end->index[1] - $neighbors[$xx]->index[1],2 )
				)
				)
				);
				//F(n) = G(n) + H(n);
				if ($neighbors[$xx]->isObstacle) {
					$neighbors[$xx]->setG(1);
				} else {
					$neighbors[$xx]->setG(0);
				}

				//print $neighbors[$xx]."\n";
				//print $neighbors[$xx]->getF()."\n\n";
				$this->open[] =& $neighbors[$xx];


				//
				//animation block
				if (++$thread % 20 == 0) {
					//$this->g->debugPrintNodes(); //with color
					//$this->g->printStartEndNodes();
					$this->g->saveFrame();

					sleep(0);
				}
				//*/

			}


			//we've found an scored all adjacent nodes
			//remove this one
			for ($xx=0; $xx < count($this->open); ++$xx) {
				if ($this->open[$xx] == $currentNode) {
					$this->closed[] =& $currentNode;
					unset($this->open[$xx]);
					break;
				}
			}

			
			///safety measure
			if (++$kill > 200 ) {
				$foundEnd = true;
				echo "*** safety measure tripped: can't find endpoint after 200 passes.\n\n";
			}
			//*/
		}

		//
		//collect parent nodes from end to back
		//currentNode is the end...
		$path = array();
		$backToStart = false;

		while (!$backToStart) {
			$currentNode->parent->isPath = true;
			$foo = &$currentNode->parent;
			unset($currentNode); //php reference hack

			$path[] = & $foo;
			$currentNode = $foo;

			if (! is_object($currentNode) ) {
				$backToStart = true;
			}
			if ($currentNode == $this->start ) {
				$backToStart = true;
			}
			//safety measure
			if (++$kill2 > 200 ) {
				$backToStart = true;
				echo "*** safety 2 measure tripped: can't find path back to start!\n\n";
				return ;
			}
			//*/
		}
		//*/
		return $path;

	}


	/**
	* fix this algo
	*/
	function & findLowestF() {
		$lowestIndex = -1;
		$lastF = 9999;
		$lastN='';
		$lastK='';;
		foreach( $this->open as $k=>$n ) {
			if ($n->getF() < $lastF ) {
				$lowestIndex = $n->getF();
				$lastF = $n->getF();
				$lastN =& $this->open[$k];
				$lastK = $k;
			}
		}
		if ($lowestIndex >= 0 ) {
			$this->closed[] =& $lastN;
			unset($this->open[$lastK]);
			return $lastN;
		} else {
			return null;
		}
	}

}




	class AStar_NodeList {
		var $nodes = array();

		function addNewNodeAt($n,$a,$b) {
			$n->index = array ($a,$b);

			$this->nodes[$a][$b] = $n;
		}


		/**
		 * just find the basic N S E W nodes
		 * don't worry about diagonal
		 */
		function & getSurrounding(&$node) {
			$x = $node->index[0];
			$y = $node->index[1];

			$north =& $this->nodes[$x-1][$y];
			$south =& $this->nodes[$x+1][$y];
			$east =& $this->nodes[$x][$y+1];
			$west =& $this->nodes[$x][$y-1];

			$neighbors = array();
			if ($north) {
				$neighbors[] =& $north;
			}
			if ($south) {
				$neighbors[] =& $south;
			}
			if ($east) {
				$neighbors[] =& $east;
			}
			if ($west) {
				$neighbors[] =& $west;
			}

			return $neighbors;
		}

	}

?>
