<?php
 
/**
 * class TreeList
 * encapsulate nested list data
 */
class TreeList {
	var $p_CurrentNode = null;
	var $stack;
	var $indent;
	var $rootNode;
	var $defaultExpanded = true;
	var $count = 0;
	 
	var $keyName = 'pkey';
	var $keyParentName = 'parentKey';
	 
	/**
	 * default constructor
	 */
	function TreeList() {
	}
	 
	 
	/**
	 * returns the next node in the tree, or false
	 *
	 * rules for traversing:  if the currentNode has a child,
	 * return it.  If the currentNode does not have a child,
	 * return the sibling.  If the currentNode does not have
	 * a sibling, set the currentNode to the top of the stack.
	 * If the stack is emtpy, return false
	 */
	function traverse() {
		 
		if (($this->p_CurrentNode == "") or ($this->p_CurrentNode->contents == "_blank") ) {
			$this->p_CurrentNode = & $this->rootNode;
			return true;
		}
		 
		if (($this->p_CurrentNode->hasChild()) and ($this->p_CurrentNode->expanded !== false) ) {
			$this->stack[] = & $this->p_CurrentNode;
			$this->p_CurrentNode = & $this->p_CurrentNode->child;
			return true;
		}
		 
		if ($this->p_CurrentNode->hasSibling() ) {
			$this->p_CurrentNode = & $this->p_CurrentNode->sibling;
			return true;
		}
		 
		//no siblings nor children, go back up
		while ($this->goUp() ) {
			if ($this->p_CurrentNode->hasSibling() ) {
				$this->p_CurrentNode = & $this->p_CurrentNode->sibling;
				return true;
			}
		}
		 
	}
	 
	 
	/**
	 * Used internally by traverse() to travel back up the stack and grab a new node
	 */
	function goUp() {
		 
		$p_index = count($this->stack) - 1;
		if ($p_index >= 0 ) {
			$this->p_CurrentNode = & $this->stack[$p_index];
			array_pop($this->stack);
			return true;
		} else {
			return false;
		}
	}
	 
	 
	/**
	 * tries to initialize the nodes based on the data array
	 *
	 * this function is very LC specific, it uses parentKey and
	 * pkey from LC database tables
	 */
	function loadData(&$data) {
		$c = count ($data);
		 
		$this->rootNode = new TreeListNode($data[0]);
		$this->rootNode->root = 1;
		for ($x = 1; $x < count($data); ++$x) {
			$currentData = & $data[$x];
			 
			//fix for 500 max limit exceeded
			// if a node flies by more than 10 times
			// it probably doesn't have a parent
			// the SQL ordering should get related nodes close to each other
			if ($currentData['missed'] > 10 ) {
				$this->count++;
				$this->rootNode->addChild($currentData);
				continue;
			}
			 
			//xxx why is this here?
			if ($currentData[$this->keyName] == $currentData[$this->keyParentName]) {
				continue;
			}
			 
			$found = 0;
			 
			//if ( ++$kill > 200 ) { print "500 limit exceeded"; return false;}
			//print_r($currentData);
			//print "<hr width='50%'>\n";
			while ($this->traverse() ) {
				//print "<<<<<<<<<< curnode >>>>>>>>>>\n";
				//print_r($this->p_CurrentNode);
				//print "<<<<<<<<<< stack >>>>>>>>>>\n";
				//print_r($this->stack);
				if ($currentData[$this->keyParentName] == 0 ) {
					//print ">>>>>>>>>> adding child (".$currentData['parentKey'].")  to root  >>>>>>>>>\n";
					$temp = & new TreeListNode($currentData);
					$this->count++;
					$this->rootNode->addSiblingNode($temp);
					 
					$blank = "";
					$this->p_CurrentNode = & new TreeListNode($blank);
					$found = 1;
					break;
				}
				if ($this->p_CurrentNode->contents[$this->keyName] == $currentData[$this->keyParentName]) {
					//print ">>>>>>>>>> adding child (".$currentData['parentKey'].")  to parent (".$this->p_CurrentNode->contents['pkey'].")  >>>>>>>>>\n";
					$temp = & new TreeListNode($currentData);
					$this->count++;
					$this->p_CurrentNode->addChildNode($temp);
					 
					$blank = "";
					$this->p_CurrentNode = & new TreeListNode($blank);
					//print "<hr> ";flush();
					$found = 1;
					break;
				}
			}
			if (!$found) {
				$currentData['missed']++;
				$data[] = $currentData;
			}
			$this->reset();
		}
		 
		$this->reset();
	}
	 
	 
	/**
	 * tries to initialize the nodes based on the array of objects
	 *
	 * this function is very LC specific, it uses $obj->parentID and
	 * $obj->pkey from LC database tables
	 */
	function loadObjects(&$data) {
		$c = count ($data);
		$this->rootNode = new TreeListNode($data[0]);
		$this->rootNode->root = 1;
		for ($x = 1; $x < count($data); ++$x) {
			$currentData = & $data[$x];

			//xxx why is this here?
			if ($currentData->pkey == $currentData->parentID) {
				continue;
			}
			 
			$found = 0;
			while ($this->traverse() ) {
				//if ( ++$kill > 500 ) { print "500 limit exceeded"; return false;}
				if ($currentData->parentID == 0 ) {
					$temp = & new TreeListNode($currentData);
					$this->count++;
					$this->rootNode->addSiblingNode($temp);
					 
					$blank = "";
					$this->p_CurrentNode = & new TreeListNode($blank);
					$found = 1;
					break;
				}
				if ($this->p_CurrentNode->contents->pkey == $currentData->parentID) {
					$temp = & new TreeListNode($currentData);
					$this->count++;
					$this->p_CurrentNode->addChildNode($temp);
					 
					$blank = "";
					$this->p_CurrentNode = & new TreeListNode($blank);
					$found = 1;
					break;
				}
			}
			if (!$found) {
				$data[] = $currentData;
			}
			$this->reset();
		}
		 
		$this->reset();
	}
	 
	 
	 
	/**
	 * retrieve bread crumb list for the current p_CurrentNode pointer
	 *
	 * @return array List of parent keys and names
	 */
	function getCurrentBreadCrumbs() {
		while (list($q, $r) = @each($this->stack) ) {
			$s[$r->contents[$this->keyName]] = $r->contents['name'];
		}
		$s[$this->p_CurrentNode->contents[$this->keyName]] = $this->p_CurrentNode->contents['name'];
		return $s;
	}
	 
	/**
	 * retrieve bread crumb list for the given node
	 *
	 * @return array List of parent keys and names
	 * @argument $n NodeID for desired bread crumbs
	 */
	function getBreadCrumbs($n) {
		$this->reset();
		while ($this->traverse() ) {
			if ($this->p_currentNode->contents[$this->keyName] == $n) {
				$s = $this->getCurrentBreadCrumbs();
				$this->reset();
				return $s;
			}
		}
		return null;
	}
	 
	 
	/**
	 * reset the tree to the beginning
	 */
	function reset() {
		$blank = "_blank";
		$this->p_CurrentNode = & new TreeListNode($blank);
		$this->stack = array();
	}
	 
	 
	/**
	 * change the expanded attribute of every node on the stack
	 * Use this function when you are traversing a tree and discover a node
	 * needs to be open, All it's parents must be open too for it to be shown.
	 * @param $bool  Expanded status of all the nodes on the stack
	 * @return void
	 */
	function setStackExpanded($bool) {
		for ($z = 0; $z < count($this->stack); ++$z) {
			$this->stack[$z]->expanded = $bool;
		}
	}
}
 
 
/**
 * one node of a tree list
 * each node will have a pointer to
 * zero to two (2) other nodes.
 * A sibling node denotes a node that is on the same
 * indentation level as this node, a childe node
 * indicates a node that is one indentation level
 * below this node.  A node with a child node will
 * have to be saved to a stck in the TreeList when rendering.
 */
class TreeListNode {
	var $sibling = 0;
	var $child = 0;
	var $parent;
	var $expanded;
	var $contents;
	 
	 
	/**
	 * wrap an arbitrary piece of data in a tree node
	 */
	function & TreeListNode(&$d) {
		$this->contents = $d;
	}
	 
	/**
	 * Accessor for sibling
	 * @return boolean  True for has a sibling node
	 */
	function hasSibling() {
		return $this->sibling != 0;
	}
	 
	/**
	 * Accessor for child
	 * @return boolean  True for has a child node
	 */
	function hasChild() {
		return $this->child != 0;
	}
	 
	 
	/**
	 * open this node
	 * @return void
	 */
	function setOpen() {
		$this->expanded = true;
	}
	 
	/**
	 * close this node
	 * @return void
	 */
	function setClosed() {
		$this->expanded = true;
	}
	 
	 
	/**
	 * Add a node as a child of this node
	 * if the node in question already has a child
	 * it will add it as a sibling of the last sibling
	 * of its child.
	 * @param $n TreeListNode object to add
	 * @return void
	 */
	function addChildNode(&$n) {
		$n->indent = $this->indent +1;
		if ($this->hasChild() ) {
			$kid = & $this->child;
			while ($kid->hasSibling() ) {
				$kid = & $kid->sibling;
			}
			$kid->sibling = &$n;
		} else {
			$this->child = &$n;
		}
	}
	 
	 
	/**
	 * Add a piece of data as a child of this node
	 * if the node in question already has a child
	 * it will add it as a sibling of the last sibling
	 * of its child.
	 * @param $d Data to be wrapped in a new TreeListNode object
	 * @return void
	 */
	function addChild($d) {
		$temp = new TreeListNode($d);
		$temp->indent = $this->indent +1;
		if ($this->hasChild() ) {
			$kid = & $this->child;
			while ($kid->hasSibling() ) {
				$kid = & $kid->sibling;
			}
			$kid->sibling = &$temp;
		} else {
			$this->child = &$temp;
		}
	}
	 
	 
	/**
	 * Add a piece of data as a sibling of this node
	 * if the node in question already has a sibling
	 * it will add it as a sibling of the last sibling
	 * @param $d Data to be wrapped in a new TreeListNode object
	 * @return void
	 */
	function addSibling($d) {
		$temp = new TreeListNode($d);
		$temp->indent = $this->indent;
		if ($this->hasSibling() ) {
			$kid = & $this->sibling;
			while ($kid->hasSibling() ) {
				$kid = & $kid->sibling;
			}
			$kid->sibling = &$temp;
		} else {
			$this->sibling = &$temp;
		}
	}
	 
	 
	/**
	 * Add a TreeListNode as a sibling of this node
	 * if the node in question already has a sibling
	 * it will add it as a sibling of the last sibling
	 * @param $n TreeListNode to be as a new sibling
	 * @return void
	 */
	function addSiblingNode(&$n) {
		$n->indent = $this->indent;
		if ($this->hasSibling() ) {
			$kid = & $this->sibling;
			while ($kid->hasSibling() ) {
				$kid = & $kid->sibling;
			}
			$kid->sibling = &$n;
		} else {
			$this->sibling = &$n;
		}
	}
}
 
 
 
class ListView {
	 
	function ListView (&$t) {
		$this->tree = & $t;
	}
	 
	 
	function renderAsOptions($sel = '') {
		while ($this->tree->traverse() ) {
			$ret .= '<option value="'.$this->tree->p_CurrentNode->contents[$this->tree->keyName].'"';
			if (is_array($sel) && (in_array($sel, $this->tree->p_CurrentNode->contents[$this->tree->keyName]) ) )
				$ret .= ' SELECTED ';
			if ($sel == $this->tree->p_CurrentNode->contents[$this->tree->keyName] ) {
				$ret .= ' SELECTED ';
			}
			$ret .= '>';
			$ret .= str_repeat("----", $this->tree->p_CurrentNode->indent);
			$ret .= $this->tree->p_CurrentNode->contents['name']."</option>\n";
		}
		return $ret;
	}
	 
	 
	function renderAsTable($w = "100%") {
		$ret = "<table width=\"$w\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		global $open;
		while ($this->tree->traverse() ) {
			if ($this->tree->p_CurrentNode->contents[$this->tree->keyName] == $open ) {
				$this->tree->p_CurrentNode->expanded = true;
				$this->tree->setStackExpanded(true);
			}
		}
		$this->tree->reset();
		while ($this->tree->traverse() ) {
			if ($this->tree->p_CurrentNode->expanded !== true) {
				$this->tree->p_CurrentNode->expanded = false;
			}
			//if ($this->tree->p_CurrentNode->contents['pkey'] == $open) {$this->tree->p_CurrentNode->expanded = true; }
			$ret .= "\t<tr><td>";
			// print all types of pipes as you cycle through each level of indent
			//print $this->tree->p_CurrentNode->indent ."- ";
			for ($q = 0; $q < $this->tree->p_CurrentNode->indent; ++$q) {
				if ($this->tree->stack[$q]->hasSibling()) {
					$ret .= "<img src=\"path-pipe.png\" align=\"center\" height=\"18\" width=\"15\">";
				} else {
					$ret .= "&nbsp;&nbsp;";
				}
			}
			 
			//   $ret .= str_repeat("&nbsp;&nbsp;&nbsp;",$this->tree->p_CurrentNode->indent);
			if ($this->tree->p_CurrentNode->hasChild() && $this->tree->p_CurrentNode->hasSibling()) {
				$ret .= "<img src=\"sibling-child-pipe.png\"border=\"0\" align=\"center\" height=\"18\" width=\"15\">";
			}
			else if ($this->tree->p_CurrentNode->hasChild()) {
				$ret .= "<img src=\"child-close-pipe.png\"border=\"0\" align=\"center\" height=\"18\" width=\"15\">";
			}
			else if ($this->tree->p_CurrentNode->hasSibling()) {
				$ret .= "<img src=\"sibling-pipe.png\"border=\"0\" align=\"center\" height=\"18\" width=\"15\">";
			} else {
				$ret .= "<img src=\"child-pipe.png\" border=\"0\" align=\"center\" height=\"18\" width=\"15\">";
			}
			$ret .= "<a href=\"testthetree.php?open=".$this->tree->p_CurrentNode->contents[$this->tree->keyName]."\">";
			$ret .= $this->tree->p_CurrentNode->contents['title']."</option>\n";
			$ret .= "</a>\n";
			$ret .= "</td></tr>\n";
		}
		$ret .= "</table>\n";
		return $ret;
	}
}
?>
