<?
/*************************************************** 
 *
 * This file is under the LogiCreate Public License
 *
 * A copy of the license is in your LC distribution
 * called license.txt.  If you are missing this
 * file you can obtain the latest version from
 * http://logicreate.com/license.html
 *
 * LogiCreate is copyright by Tap Internet, Inc.
 * http://www.tapinternet.com/
 ***************************************************/


/* 
 * categories section
 * add/edit/delete category definitions
 * 
 * MGK
 */

include_once(LIB_PATH."lc_categories.php");
include_once(LIB_PATH."LC_html.php");


class cat extends HercAuth {

	var $presentor = "configurePresentation";


	function Run(&$db,&$u,&$arg,&$t) {
		$t[systems] = Category::getSystemList();
	}


	function showCatRun(&$db,&$u,&$arg,&$t) {

		if ($arg->postvars[systemName] =="") {
			$sysName = $arg->getvars[systemName];
			if ($sysName == '') $sysName = $arg->getvars[1];
		} else {
			$sysName = $arg->postvars[systemName];
		}

		// ** Must pass in catname (ie system=catname to view
		if (trim($sysName) == '')
		{	$t['systems'] = Category::getSystemList();
			$t['errormessage'] = 'You must highlight a category to edit';
		} else
		{			
			$catTreeList = Category::getAllCategories($sysName);
	
			//new list view objects
			$view = new ListView($catTreeList);
			$t[treeOpts] = $view->renderAsOptions();
	
			$t[menu] = renderCatsMenu($catTreeList,$sysName);
			$t[systemName] = ucfirst($sysName);
	
			$arg->templateName = "cat_edit";
		
		}
		
	}





	function insertRun(&$db,&$u,&$lcObj,&$t) {
		$cat = PersistantObject::createFromArray("Category",$lcObj->postvars["new"]);
		$cat->_save("lcCategories");
		header("Location: "._APP_URL."cat/".$lcObj->postvars["new"]["system"]."/event=showCat");
		exit();
	}


	function showEditRun($db,&$u,&$arg,&$t) {

		$id = $arg->getvars['catID'];
		$cat = PersistantObject::_load("Category","lcCategories",$id);
		$t[cat] = &$cat;
		$sysName = $cat->system;

		$catTreeList = Category::getAllCategories($sysName);

		//new list view objects
		$view = new ListView($catTreeList);
		$t[treeOpts] = $view->renderAsOptions($cat->parentKey);

		$t[systemName]= $sysName;
		$t[catName] = $cat->name;

		$arg->templateName = "cat_show_edit";
	}


	function updateRun(&$db, &$u, &$arg, &$t) {

		extract ($arg->postvars['new']);

		$sql = "update lcCategories set ";
		$sql .="name = '$name',";
		$sql .="sortorder = $sortorder,";
		$sql .="notes = '$notes',";
		$sql .="parentKey = $parentKey ";
		$sql .= "where pkey = $pkey";

		$db->query($sql);

		header("Location: "._APP_URL."cat/".$arg->postvars["new"]["system"]."/event=showCat");
		exit();
	}


	/**
	 * either remove a cat and all its subcats
	 * completely, or move the remaining subcats
	 * up a position to where it used to be
	 */
	function deleteRun(&$db, &$u, &$arg, &$t) {

		$oldKey = $arg->postvars[pkey];
		$sysName = $arg->postvars[sysName];

		if($arg->postvars['del'] == 'keep') {
			//find new parent from old pkey
			$db->queryOne("select * from lcCategories where pkey = $oldKey");
			$old = $db->Record;
			
			//update to new parent where parent = old pkey
			$db->query("update lcCategories set parentKey = ".$old[parentKey]." where parentKey = $oldKey and system = '$sysName'");

			//remove old cat
			$db->query("delete from lcCategories where pkey = $oldKey and system = '$sysName'");
		}


		if($arg->postvars['del'] == 'destroy') {


			$parents[] = $oldKey;
			$removeKeys[] = $oldKey;

			$findSQL = "select pkey from lcCategories where %s and system = '$sysName'";

			//while not done
			while ( ! $done ) {

				unset($where);
			//	find subs where parent = any of the subs pkey
				for ($x=0; $x <count($parents); ++$x) {
					$where .= ' parentKey = '.$parents[$x].'  or ';
				}
				$where = substr($where,0, -5);

				$db->query(sprintf($findSQL,$where) );
				$parents = array();
				while ($db->next_record() ) {
					$parents[] = $db->Record[0];
					$removeKeys[] = $db->Record[0];
				}

			//	done if none returned
				if (count($parents) == 0) {
					$done = 1;
				}
			}
			//remove all collected keys
				unset($where);
				for ($x=0; $x <count($removeKeys); ++$x) {
					$where .= ' pkey = '.$removeKeys[$x].'  or ';
				}
				$where = substr($where,0, -5);
			if ( count($removeKeys) > 0 ) {
				$db->query("delete from lcCategories where $where and system = '$sysName'");
			}
		}

		header("Location: "._APP_URL."cat/".$sysName."/event=showCat");
		exit();
	}


	/**
	 * adjust the rank of this item
	 */
	function upRun (&$db, &$u, &$arg, &$t) {

		$link = PersistantObject::_load("Category","lcCategories",$arg->getvars[catID]);
		if ($link->sortorder > 0) {
			$link->sortorder = $link->sortorder -1;
			$link->name = addslashes($link->name);
			$link->_save("lcCategories");
		}

		header("Location: "._APP_URL."cat/".$link->system."/event=showCat");
		exit();
	}


	/**
	 * adjust the rank of this item
	 */
	function downRun (&$db, &$u, &$arg, &$t) {

		$link = PersistantObject::_load("Category","lcCategories",$arg->getvars[catID]);
			$link->sortorder = $link->sortorder + 1;
			$link->name = addslashes($link->name);
			$link->_save("lcCategories");

		header("Location: "._APP_URL."cat/".$link->system."/event=showCat");
		exit();
	}
}


	// no recursion
	function renderCatsMenu ($tree,$title) {

		$tree->reset();
		$ret = '<table border="1" align="center" width="85%" onMouseover="changeto(\'lightblue\')" onMouseout="changeback(\'white\')"><tr><td class="selectedTab" id="ignore" colspan="2">'.$title.'</td></tr>
		';

		while ($tree->traverse() ) {

		unset($break);
		for ($l=0; $l < $tree->p_CurrentNode->indent; ++$l) { $break .= "----"; }
		$v = $tree->p_CurrentNode->contents;
		$ret .= '<tr><td NOWRAP width="65%">'.$break.$v[name].'</td><td width="35%" align="center"> 
				('.sprintf("%d",$v[sortorder]).') 
				<a href="'._APP_URL.'cat/main/catID='.$v[pkey].'/event=up"><img border="0" src="'._PICS_URL.'up_arrow.gif" alt="move up"></a> 
				<a href="'._APP_URL.'cat/main/catID='.$v[pkey].'/event=down"><img border="0" src="'._PICS_URL.'down_arrow.gif" alt="move down"></a> &nbsp;&nbsp;
				<a href="'._APP_URL.'cat/main/catID='.$v[pkey].'/event=showEdit">[edit]</a> ';
		}
		$ret .= '</table>';
	return $ret;
	}


?>
