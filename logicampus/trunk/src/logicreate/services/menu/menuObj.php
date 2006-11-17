<?

include_once (LIB_PATH."Tree.php");


class MenuObj extends PersistantObject {
	var $title;
	var $menuid = '';
	var $layout = 0;

	var $VERTICAL = 0;
	var $HORIZONTAL = 1;
	var $CUSTOM = 2;


	/**
	 * draws the menu
	 */
	function toHTML() {

		MenuObj::checkItemOpen($this->treeList,$blah);


		if ($this->layout == '') {
			//legacy code
			$ret = '<table border="0" width="100%" cellpadding="0" cellspacing="0">';
			if ($this->hideMenu !== true)
			{	//$ret .='<tr><td class="menu_head" colspan="2">'. $this->title .'</td></tr>';
			}	
			$ret .="\n\t\t";
			$ret .= MenuObj::renderItems ($this->treeList);
			$ret .= "</table>\n<p>\n\n";
		} else {

			$view = new MenuView($this->treeList);
			$view->title = $this->title;	//xxx wierd, left over from renderItems()
			$view->hideMenu = $this->hideMenu;	//xxx wierd, left over from renderItems()
			$ret = $view->{$this->layout.'Menu'}();

		}
	return $ret;
	}

	function renderItems(&$tree) {

		while ($tree->traverse() ) {
		if ($tree->p_CurrentNode->expanded !== true) { $tree->p_CurrentNode->expanded = false; }
		unset($break);
		for ($l=0; $l < $tree->p_CurrentNode->indent; ++$l) { $break .= "&nbsp;&nbsp;"; }
			$v = $tree->p_CurrentNode->contents;

			$ret .= "<tr><td NOWRAP class=\"menu_item\">".$break.$v->toHTML()."</td></tr>\n\t";

		}
	return $ret;
	}

	function checkItemOpen(&$tree,&$ws) {
		global $REQUEST_URI;
		while ($tree->traverse() ) {
                        if ( @strpos($REQUEST_URI,$tree->p_CurrentNode->contents->location) ) {
                                $tree->p_CurrentNode->expanded = true;
                                $tree->setStackExpanded(true);
                        }
                }
		$tree->reset();
	}


	function update() {
		unset($this->treeList);
		$this->groups = '|'.join('|',$this->groups).'|';
		$this->notgroups = '|'.join('|',$this->notgroups).'|';
		$this->_save("menu");
	}


	function updateMenuItems() {
		for ($x=0; $x < count($this->menuItems); ++$x) {
			$l = $this->menuItems[$x];
			$l->rank = $x;
			$l->update();
		}
	}

	function _getTransient() {
		return array("VERTICAL","HORIZONTAL","CUSTOM","menuItems","linkCount","treeList");
	}


	function get($id) {
		//select menu.*,menuItems.* from menu left join menuItems on menu.pkey = menuItems.menuID where menu.groups  like '%public%'
		//select menu.pkey as mpkey, menu.title, menu.layout, menu.groups as mgroups, menu.notgroups as mnotgroups, menuItems.* from menu left join menuItems on menu.pkey = menuItems.menuID where menu.pkey = '.$id.' order by parentID, rank
		$db = DB::getHandle();
		$getSQL = 'select menu.pkey as mpkey, menu.menuid, menu.title, menu.layout, menu.groups as mgroups, menu.notgroups as mnotgroups, menu.rank as mrank, menuItems.* from menu left join menuItems on menu.pkey = menuItems.menuID where menu.pkey = '.$id.' order by parentID, rank';
		$db->query($getSQL,false);
		$db->RESULT_TYPE=MYSQL_ASSOC;
		$tree = new TreeList();

		while ($db->next_record() ) {
			$menuItems[] = new MenuItem($db->Record);
			$lastrec = $db->Record;
		}
		$tree->loadObjects($menuItems);

		//join statement requires keeping track of the last menu
		// item in order to get the menu properties
		$x = new MenuObj();
		$x->treeList = &$tree;
		$x->pkey = $lastrec['mpkey'];
		$x->menuid = $lastrec['menuid'];
		$x->title = $lastrec['title'];
		$x->layout = $lastrec['layout'];
		$x->linkCount = count($menuItems);
		$x->rank = $lastrec['mrank'];
		if ( substr($lastrec['mgroups'],0,1) == '|' ) {
			$x->groups = explode('|',substr($lastrec['mgroups'],1,-1));
			$x->notgroups = explode('|',substr($lastrec['mnotgroups'],1,-1));
		} else {
			$x->groups = explode('|',$lastrec['mgroups']);
			$x->notgroups = explode('|',$lastrec['mnotgroups']);
		}
		return $x;
	}



	function getCached($key) {
		$db = DB::getHandle();
		$sql = "select menuObj from menuCache where pkey = $key";
		$db->query($sql,false);
		$db->next_record();
		$menu = unserialize($db->Record[0]);
	return $menu;
	}

    function getCachedByID($key, $groups, $fl_hidemenu=false) {
        $notgroups = createGroupCheck($groups, "notgroups");
        $groups = createGroupCheck($groups, "groups");
        $db = DB::getHandle();
        $sql = "select menuObj from menuCache where (menuid= '$key' and (($groups) and not ($notgroups)))"; 
		$db->query($sql,false);
        $db->next_record();
        $menu = unserialize($db->Record[0]);
        if (is_object($menu) )
        {
            $menu->hideMenu = (boolean)$fl_hidemenu;
            print $menu->toHTML();
        }
        unset($menu);
    }

	function addItem($i) {
		$this->menuItems[] = $i;
	}


	function getVisibleCached(&$groups) {
		$db = DB::getHandle();
		$where = "where ( (". createGroupCheck($groups) ." ) ";

		$where .= " and not (". createGroupCheck($groups,"notgroups")   .") )";

		$db->query("select menuObj from menuCache $where order by rank",false);
		$db->RESULT_TYPE= MYSQL_BOTH;
		while($db->next_record() )
			$menus[$db->Record[0]['pkey']] = unserialize($db->Record[0]);
			$menus[$db->Record[0]['menuid']] = unserialize($db->Record[0]);
#		print_r($menus);
	return $menus;
	}



	function getAll() {
		$db = DB::getHandle();
		$sql = "select pkey from menu order by rank";
		$db->query($sql,false);
		$db->RESULT_TYPE= MYSQL_BOTH;
		while ($db->next_record()) {
			$ids[] = $db->Record[0];
		}
		$db = null;
		while ( list ($k,$v) = @each ($ids) ) {
			$ret[] = MenuObj::get($v);
		}

	return $ret;
	}

	/***
	 *  This function returns a chunk of html that is a list of the user's
	 *  classes that they are TAKING, and a Classroom Portal link.
	 **/
	function getStudentMenu($userObj) {

		if (count($userObj->classesTaken) > 0 )
		{
		$ret = '<a class="menuitem" href="'.appurl('classroom/').'">Classroom Portal</a><br/><br/>';
		while ( list(,$v) = @each($userObj->classesTaken) ) {
			if ($v->semesterID) { 
			$ret .= '<a class="menuitem"
			href="'.APP_URL.'classroom/details/id_classes='.$v->id_classes.'">'.$v->courseFamily.$v->courseNumber.' ('.$v->semesterID.')</a><br>';
			} else { 
			$ret .= '<a class="menuitem"
			href="'.APP_URL.'classroom/details/id_classes='.$v->id_classes.'">'.$v->courseFamily.$v->courseNumber.'</a><br>';
			}
			$ret .= '&nbsp;&nbsp;&bull;<a class="menuitem"
			href="'.APP_URL.'classroom/gradebook/id_classes='.$v->id_classes.'">'.lct('Gradebook').'</a><hr>';

		}

		$ret = substr($ret,0,-4);
		return $ret;
		}
	}


	function getFacultyMenu($userObj)
	{
	if ($userObj->isFaculty() ) {
//	debug($userObj,1);
		$ret = '<a class="menuitem" href="'.APP_URL.'classmgr">'.lct('Classroom Overview').'</a><br/><br/>';
		while (list ($k, $v)  = @each($userObj->classesTaught) )
		{
			$ret .= '<a class="menuitem"
			href="'.APP_URL.'classmgr/display/id_classes='.$v->id_classes.'">'.$v->courseFamily.$v->courseNumber.' ('.$v->semesterID.')</a><br>';
			$ret .= '&nbsp;&nbsp;&bull;<a class="menuitem"
			href="'.APP_URL.'gradebook/main/id_classes='.$v->id_classes.'">'.lct('Gradebook').'</a><hr>';
		}
		if (substr($ret,0,-4)=='<hr>') { 	
			$ret = substr($ret,0,-4);
		}
		return $ret;
	}
	}
}


/**
 * render the menu in different ways
 */
class MenuView extends ListView {



	function horizontalMenu() {
		static $tableRows = array();
		while ($this->tree->traverse() ) {
			if ($this->tree->p_CurrentNode->expanded !== true) { $this->tree->p_CurrentNode->expanded = false; }
			unset($break);
			$i = $this->tree->p_CurrentNode->indent;
				$v = $this->tree->p_CurrentNode->contents;
				if ($this->tree->p_CurrentNode->expanded) {
				$tableRows[$i] .= '<font class="menu_head">'.$break.$v->toHTML()."</font> | \n\t";
				} else {
				$tableRows[$i] .= $break.$v->toHTML()." | \n\t";
				}
		}

		return '<table border="0"><tr><td NOWRAP class="menu_item" align="center"> | '.join('</td></tr><tr><td NOWRAP class="menu_item" align="center"> | ',$tableRows).'</td></tr></table>';
	}


	function verticalMenu() {
		$ret = '<table border="0" width="100%" class="menutable" cellpadding="0" cellspacing="0">';
		if ($this->hideMenu !== true)
		{	$ret .='<tr><td class="menu_head" colspan="2">'. $this->title .'</td></tr>';
			//$ret .='<tr><td class="menu_head" colspan="2">&nbsp;</td></tr>';
		}
		
		$ret .="\n\t\t";
		while ($this->tree->traverse() ) {
			if ($this->tree->p_CurrentNode->expanded !== true) { $this->tree->p_CurrentNode->expanded = false; }
			unset($break);
			
			if ($this->tree->p_CurrentNode->expanded == true)
			{	$parent_expanded = true;
			}
			
			// run through children //
			for ($l=0; $l < $this->tree->p_CurrentNode->indent; ++$l) { $break .= "&nbsp;&nbsp;&nbsp;&nbsp;"; }
				$v = $this->tree->p_CurrentNode->contents;
				
				/**
					The problem with this is that it's ment for only a single level down
				 */
				$img = '<img src="'.IMAGES_URL.'t_close.gif" border="0" alt="This is a parent menu item" class="menuimg">';
				
				if ($parent_expanded == true)
				{	$img = '<img src="'.IMAGES_URL.'t_open.gif" border="0" alt="This item has subitems" class="menuimg">';
				}
				
				$v->linkText = str_replace('[img]', $img, $v->linkText);
				$ret .= "<tr><td NOWRAP class=\"menu_item\">".$break.$v->toHTML()."</td></tr>\n\t";
				
			$parent_expanded = false;
		}
		//$ret .= '<tr><td class="menu_head" colspan="2">&nbsp;</td></tr>';
		$ret .= "</table>\n<p>\n\n";
	return $ret;
	}



	function jshorizontalMenu() {
		static $count;
		$nest = array();
		$top = 1;
		$count++;

$nest[0] .='
<div id="menu'.$count.'" class="menu"
     onmouseover="menuMouseover(event)">
';
		while ($this->tree->traverse() ) {
			$this->tree->p_CurrentNode->expanded = true; 
			$v = $this->tree->p_CurrentNode->contents;
			$indent = $this->tree->p_CurrentNode->indent;

			if ( $this->tree->p_CurrentNode->hasChild() ) {
				$js = 'onmouseover="menuItemMouseover(event,\'menu'.($top+2).'\');"';
				$sep = ">";
			} else {
				$js = '';
				$sep = "";
			}

			$nest[$top] .='<a class="menuitem" href="#" '.$js.'>'.$v->linkText.' '.$sep.'</a>';
			$nest[$top] .= "\n\t\t";
			if ( $this->tree->p_CurrentNode->hasChild() ) {
				$top++;
				if ($nest[$top] == '') {
					$nest[$top] .='<div id="menu'.($top+1).'" class="menu"
					     onmouseover="menuMouseover(event)">
					';
				}
			} else if ( ! $this->tree->p_CurrentNode->hasSibling() ) {
				$nest[$top] .= "</div>\n";
				$top--;
			}

		}
		$ret .= join("\n",$nest);
	return $ret;
	}



	function optionMenu($sel='') {
		while ($this->tree->traverse() ) {
			$ret .= '<option value="'.$this->tree->p_CurrentNode->contents->pkey.'"';
			if ( is_array($sel) && (in_array($sel,$this->tree->p_CurrentNode->contents->pkey) ) )
				$ret .= ' SELECTED ';
			if ( $sel == $this->tree->p_CurrentNode->contents->pkey )
				$ret .= ' SELECTED ';
			$ret .= '>';
			$ret .= str_repeat("---",$this->tree->p_CurrentNode->indent);
			$ret .= $this->tree->p_CurrentNode->contents->linkText."</option>\n";
		}
	return $ret;
	}

}




class MenuItem extends PersistantObject {
	var $type;
	var $location;
	var $linkText;
	var $editPage;


	function MenuItem($attrs="") {
		if ($attrs == "") { return; }

		switch($attrs[type]) {
			case "htm":
				$x = PersistantObject::createFromArray("HTMLMenuItem",$attrs);
				break;
			case "hr":
				$x = PersistantObject::createFromArray("BreakMenuItem",$attrs);
				break;
			case "ext":
				$x = PersistantObject::createFromArray("URLMenuItem",$attrs);
				break;
			case "app":
				$x = PersistantObject::createFromArray("APPMenuItem",$attrs);
				break;
			}

	return $x;
	}



	function toHTML() {

	return $this->title;
	}



	function get($id) {
		$db = DB::getHandle();
		$db->query("select * from menuItems where pkey = $id",false);
		$db->RESULT_TYPE = MYSQL_ASSOC;
		$db->next_record();

		switch ($db->Record[type]) {
			case "htm": $name = "HTMLMenuItem";break;
			case "app": $name = "APPMenuItem";break;
			case "ext": $name = "URLMenuItem";break;
			case "hr": $name = "BreakMenuItem";break;
		}

		$x = PersistantObject::createFromArray($name,$db->Record);
//print_r($x);exit();
		$x->groups = substr($x->groups,1,-1);
		$x->groups = @explode("|",$x->groups);
		return $x;
	}

	function update() {
		$this->groups = join("|",$this->groups);
		$this->_save("menuItems");
	}

	function _getTransient() {
		return array("editPage");
	}

}

class HTMLMenuItem extends MenuItem {

	var $editPage = "itemEditor_html";
	var $type = "htm";

	function toHTML() {
//
// check imgOff (first image)
// and work with that - worry about rollovers later
// if there's an image defined, use it for the linkText
//
		$this->linkText = lct($this->linkText);
		if ($this->imgOff) {
			$this->linkText = "<img alt=\"\" src=\"".$this->imgOff."\" alt=\"".$this->linkText."\" border=\"0\">";
		}
	return '<a class="menuitem" href="'.APP_URL.'html/main/'.$this->location.'">'.$this->linkText.'</a>';
	}
}

class APPMenuItem extends MenuItem {

	var $editPage = "itemEditor_app";
	var $type = "app";

	function toHTML() {
//
// check imgOff (first image)
// and work with that - worry about rollovers later
// if there's an image defined, use it for the linkText
//

		$this->linkText = lct($this->linkText);
		if ($this->imgOff) {
			$this->linkText = "<img alt=\"\" src=\"".$this->imgOff."\" alt=\"".$this->linkText."\" border=\"0\">";
		}
	return '<a class="menuitem" href="'.APP_URL.$this->location.'/'.$this->appOption.'">'.$this->linkText.'</a>';
	}
}

class URLMenuItem extends MenuItem {

	var $editPage = "itemEditor_url";
	var $type = "ext";

	function toHTML() {
//
// check imgOff (first image) 
// and work with that - worry about rollovers later
// if there's an image defined, use it for the linkText
//
		$this->linkText = lct($this->linkText);
		if ($this->imgOff) { 
			$this->linkText = "<img alt=\"\" src=\"".$this->imgOff."\" alt=\"".$this->linkText."\" border=\"0\">";
		}
	return '<a class="menuitem" href="'.$this->location.'">'.$this->linkText.'</a>';
	}
}

class BreakMenuItem extends MenuItem {

	var $editPage = "itemEditor_hr";
	var $type = "hr";

	function BreakMenuItem() {
// 
// check imgOff (first image) 
// and work with that - worry about rollovers later
// if there's an image defined, use it for the linkText
//
		if ($this->imgOff) { 
			$this->linkText = "<img alt=\"\" src=\"".$this->imgOff."\" alt=\"".$this->linkText."\" border=\"0\">";
		} else { 
			$this->linkText = '<hr width="90%">';
		}
		$this->location ='<hr width="90%">';
	}

	function toHTML() {
		return $this->linkText;
	//return '<hr>';
	}
}



/**
 * Display class for menu objects
 * 
 * Two functions to turn menu tree's into html, one for the admin backend
 * and one for the user front end
 */
class MenuListView {

	function MenuListView(&$t) {
		$this->tree =& $t;
	}

	function toEditableTable($title,$pkey) {



		$ret = '<table border="1" width="85%" onMouseover="changeto(\'lightblue\')" onMouseout="changeback(\'white\')"><tr><td class="selectedTab" id="ignore" colspan="2">'. $title .'</td></tr>
		';

		while ($this->tree->traverse() ) {

		$node = $this->tree->p_CurrentNode;

		unset($break);
		for ($l=0; $l < $node->indent; ++$l) { $break .= "---"; }
			$link = $node->contents;
			$ret .= '<tr><td NOWRAP width="60%">'.$break.$link->linkText.'</td><td width="40%" align="center"> 
					('.$link->rank.') 
					<a href="'.MOD_URL.'menu/'.$link->pkey.'/event=itemUp/mid='.$pkey.'"><img border="0" src="'.IMAGES_URL.'up_arrow.gif" alt="move up"></a> 
					<a href="'.MOD_URL.'menu/'.$link->pkey.'/event=itemDown/mid='.$pkey.'"><img border="0" src="'.IMAGES_URL.'down_arrow.gif" alt="move down"></a> &nbsp;
					<a href="'.MOD_URL.'menu/'.$link->pkey.'/event=itemedit/mid='.$pkey.'">[edit]</a> 
					<a href="'.MOD_URL.'menu/'.$link->pkey.'/event=itemmove/mid='.$pkey.'">[move]</a> 
					<a onclick="if (!confirm(\'Delete This Item?\')) {return false;}" href="'.MOD_URL.'menu/'.$link->pkey.'/event=itemdelete/mid='.$pkey.'">[delete]</a></td></tr>';

		}



		$ret .= '</table>';
	return $ret;



	}

	
	function renderLinksAsOptions($sel='') {
		while ($this->tree->traverse() ) {
			$ret .= '<option value="'.$this->tree->p_CurrentNode->contents->pkey.'"';
			if ( is_array($sel) && (in_array($sel,$this->tree->p_CurrentNode->contents->pkey) ) )
				$ret .= ' SELECTED ';
			if ( $sel == $this->tree->p_CurrentNode->contents->pkey )
				$ret .= ' SELECTED ';
			$ret .= '>';
			$ret .= str_repeat("---",$this->tree->p_CurrentNode->indent);
			$ret .= $this->tree->p_CurrentNode->contents->linkText."</option>\n";
		}
	return $ret;
	}

}

?>
