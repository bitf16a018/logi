<?

include_once (LIB_PATH."Tree.php");

/**
 * system wide categories.
 *
 * Recursive, nested labels managed in one spot.
 * A <i>category system</i> is a group of categories generally
 * tied to one module.  For example, the article management
 * module could use an 'article' system for its news, howtos,
 * press releases and anouncement categories.
 *
 * call getAllCategories() with the name of your system.
 * ex: $cats = getAllCategoreies("article");
 * To get a list of <option> tags call Category::renderItems();
 * $t[catOpts] = Category::renderItems($cats);
 * Custom rendering functions can be added as needed.
 */
class Category extends PersistantObject {

	# Default table categories are stored in
	
	/**
	 * Get a category Tree object
	 *
	 * Returns a tree object with all top level categories.
	 * any subcategories will be in $tree->subItems[] array.
	 * 
	 * @return object Tree
	 * @see Tree
	 * @param string $system	System name
	 * @param bool   $notes		Return category notes
	 * @static
	 */
	function getAllCategories($system,$notes=0, $table='lcCategories') {
//print "<pre>\n\n";
		
		$tree = new TreeList();

		$db = DB::getHandle();
		$sql = "select pkey,parentKey,name,sortorder";
		if ($notes) $sql .= ",notes";
		$sql .=" from $table where system = '$system' order by parentKey, sortorder";
		$db->query($sql);
		$db->RESULT_TYPE = MYSQL_ASSOC;
		while ($db->nextRecord() ) {

			$cats[] = $db->record;
		}
		
		$tree->loadData($cats);
/*			$l = PersistantObject::createFromArray("Category",$db->record);
			$node = new TreeListNode($l);
//print "<hr> got this from db:";
//print_r($l);
//print "<hr>";
			if ($node->contents->parentKey == 0 ) {
				$node->parent = null;
				$tree->addChildNode($node);
			} else {
				$found = 0;
				$tree->resetTree();


//--------------------------------- begin algorithm
//					reworked w/tree object
				do  {

//print "\n\n----======= Comparing Contents (".$l->parentKey.") with (".$tree->node_ptr->contents->pkey.") =======-----\n\n";
//print "l= ";//print_r($l);//print_r($tree->node_ptr->contents);
					if ($l->parentKey == $tree->node_ptr->contents->pkey) {
						$tree->node_ptr->addChildNode($node,$tree->node_ptr);
//print "\n\n----======= FOUND ".$node->contents->name." (".$l->parentKey.") with ".$tree->node_ptr->contents->name." (".$tree->node_ptr->contents->pkey.") =======-----\n\n";
//print_r($tree->node_ptr->nodes);
						$found = 1;
						break;
					}
				} while ( $tree->traverseNodes() );
				
				//lost & found
				if (!$found) $lostfound[] = $l;

//---------------------------------  end algorithm
			}
		}

//print "<h1>Done</h1></pre><br>\n\n\n\n";

		//lost  &  found
		while ( list ($k,$l) = @each($lostfound) ) {
			$node = new TreeListNode($l);
			$found = 0;
			$tree->resetTree();

			do  {
				if ($l->parentKey == $tree->node_ptr->contents->pkey) {
					$tree->node_ptr->addChildNode($node,$tree->node_ptr);
					$found = 1;
					print "----------".$tree->node_ptr->contents->pkey . "<hr>";
					break;
				} else { 
					print $tree->node_ptr->contents->pkey . "<hr>";
					}
			} while ( $tree->traverseNodes() );
			//lost & found
			if (!$found) { print "Still lost <hr>"; print_r($l);print_r($tree);exit();$lostfound[] = $l; }
		}

*/

	return $tree;
	}


	/**
	 * Get the sub categories of a given category
	 *
	 * @return	array	Array of Category objects
	 * @param	string	$id	Database key of parent category 
	 * @static
	 */
	function getChildren($id, $table='lcCategories') {
		
		$db = DB::getHandle();
		$db->query("select * from $table where parentKey = $id");
		while($db->nextRecord() ) {
			$cats[] = PersistantObject::createFromArray("Category",$db->record);
		}
	return $cats;
	}


	/**
	 * Get the sub categoreies of a give category
	 * 
	 * @return	array	Array of Category objects
	 * @param	string	$name	Name of parent category
	 * @param	string	$system	Name of category system 
	 * @static
	 */
	function getChildrenByName ($name,$system, $table='lcCategories') {
		$db = DB::getHandle();
		$db->query("select pkey from $table where name = '$name' and system = '$system'");
		$db->nextRecord();
		$k = $db->record[0];
	return Category::getChildren($k);
	}


	/**
	 * Returns an array of system names
	 * 
	 * @return	array	Array of system names
	 * @static
	 */
	function getSystemList($table = 'lcCategories') {
		$db = DB::getHandle();
		if ($this->table)
		{	$table = $this->table;
		}
		$db->query("select distinct(system) from ".$table);
		while($db->nextRecord() ) {
			$sys[$db->record[0]] = $db->record[0];
		}
	return $sys;
	}





	/**
	 * Puts the categories in <option> tags
	 * 
	 * Calls itself with recursion.
	 * @return	string	List of option tags
	 * @param	array	$nodes	nodes from $tree->nodes
	 * @param	int	$loop	starting indentation
	 * @param	mixed	$sel	array key of option tag that is to be selected
	 * @static
	 */
	function renderCats($nodes,$loop=0,$sel=false) {

		for ($l=0; $l < $loop; ++$l) { $break .= "---"; }

		for($x=0;$x < count($nodes); ++$x) {
			$v = &$nodes[$x]->contents;

			if ( $sel == $v->pkey ) {			
				$ret .= '			<option value="'.$v->pkey.'" SELECTED>'.$break.$v->name.'</option>
';
			} else {
				$ret .= '			<option value="'.$v->pkey.'">'.$break.$v->name.'</option>
';
			}

			if ( count($nodes[$x]->nodes) > 0) {
				$ret .= Category::renderCats($nodes[$x]->nodes,$loop+1,$sel);
			}
			

		}
	return $ret;
	} 

}

?>
