<?
include_once(LIB_PATH."Tree.php");
class ForumTreeList extends TreeList {

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
		$cd = count($data)+1;

		for ($x=0; $x < count($data); ++$x) {
#		for ($x=0; $x <=($cd+1); ++$x) {
			$currentData =& $data[$x];

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
			#if ($currentData->pkey == $currentData->parentID) { continue;}
			if ($currentData->{$this->keyName} === $currentData->{$this->keyParentName} ) { continue;}
			
			$found = 0;
			while ( $this->traverse() ) {
//if ( ++$kill > 500 ) { print "500 limit exceeded"; return false;}
				if ($currentData->{$this->keyParentName} == 0  or $currentData->{$this->keyParentName}==$this->rootNode->contents->{$this->keyParentName}) {
				$k = $currentData->{$this->keyName};
					if (!$done[$k]) {
						$temp =& new TreeListNode($currentData);
						$this->count++;
						$this->rootNode->addSiblingNode($temp);

						$blank = "";
						$this->p_CurrentNode =& new TreeListNode($blank); 
						$found = 1;
						$done[$k] = true;
					}
					break;

				}
				if ($this->p_CurrentNode->contents->{$this->keyName} == $currentData->{$this->keyParentName}) {
				$k = $currentData->{$this->keyName};
					if (!$done[$k]) { 
						$temp =& new TreeListNode($currentData);
						$this->count++;
						$this->p_CurrentNode->addChildNode($temp);
						
						$blank = "";
						$this->p_CurrentNode =& new TreeListNode($blank); 
						$done[$k] = true;
						$found = 1;
					}
					break;
				}
			}
			#if (!$found) { $data[] = $currentData; }
			$this->reset();
		}
	$this->reset();
	}
}

class ForumAdminView extends ListView {


	function renderAsTable($w="100%") {
		
		$ret = "<table width=\"$w\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
		global $open;
		while ($this->tree->traverse() ) {
			if ($this->tree->p_CurrentNode->contents->{$this->tree->keyName} == $open ) {
				$this->tree->p_CurrentNode->expanded = true;
				$this->tree->setStackExpanded(true);
			}
		}
		$this->tree->reset();
		while ($this->tree->traverse() ) {
			if ($this->tree->p_CurrentNode->expanded !== true) { $this->tree->p_CurrentNode->expanded = false; }
			if ($row=='#dddddd') { $row='#cccccc'; } else { $row='#dddddd'; }
			$ret .= "\t<tr style='background-color: $row'><td>";
			// print all types of pipes as you cycle through each level of indent
//print $this->tree->p_CurrentNode->indent ."- ";
			$indent ='';
			for ($q=0; $q < $this->tree->p_CurrentNode->indent; ++$q) {
				if ($this->tree->stack[$q]->hasSibling()) {
				#	$ret .= "<img src=\"path-pipe.png\" align=\"center\" height=\"18\" width=\"15\">";
					$indent.= "-----";
				} else {
				#	$ret .= "&nbsp;&nbsp;";
					$indent.= "-----";
				}
			}

			if ($this->tree->p_CurrentNode->hasChild() && $this->tree->p_CurrentNode->hasSibling()){
	#			$ret .= "<img src=\"sibling-child-pipe.png\"border=\"0\" align=\"center\" height=\"18\" width=\"15\">";
	}
			else if ($this->tree->p_CurrentNode->hasChild()){
	#			$ret .= "<img src=\"child-close-pipe.png\"border=\"0\" align=\"center\" height=\"18\" width=\"15\">";
	}
			else if ($this->tree->p_CurrentNode->hasSibling()) {
	#			$ret .= "<img src=\"sibling-pipe.png\"border=\"0\" align=\"center\" height=\"18\" width=\"15\">";
	}
			else {
	#			$ret .= "<img src=\"child-pipe.png\" border=\"0\" align=\"center\" height=\"18\" width=\"15\">";
	}
			$ret .= "<a href=\"".$this->deleteurl."/key=".$this->tree->p_CurrentNode->contents->{$this->tree->keyName}."\">del</a></td><td>";
			$ret .= "<a href=\"".$this->editurl."/key=".$this->tree->p_CurrentNode->contents->{$this->tree->keyName}."\">edit</a></td><td>";
			$ret .= "$indent<a href=\"".$this->url."/key=".$this->tree->p_CurrentNode->contents->{$this->tree->keyName}."\">";
			$ret .= $this->tree->p_CurrentNode->contents->lcForumName."</a>\n";
			$ret .= "</td><td>".$this->tree->p_CurrentNode->contents->lcForumDescription;
			$ret .= "</td>";
			$ret .= "</tr>\n";
		}
		$ret .= "</table>\n";
	return $ret;
	}
	function renderAsOptions($sel='') {
		@reset($this->tree);
		while ($this->tree->traverse() ) {
			$ret .= '<option value="'.$this->tree->p_CurrentNode->contents->{$this->tree->keyName}.'"';
			if ( is_array($sel) && (in_array($sel,$this->tree->p_CurrentNode->contents->{$this->tree->keyName}) ) )
				$ret .= ' SELECTED ';
			if ( $sel == $this->tree->p_CurrentNode->contents->{$this->tree->keyName} )
			{	$ret .= ' SELECTED ';
			}
			$ret .= '>';
			$ret .= str_repeat("----",$this->tree->p_CurrentNode->indent);
			$ret .= $this->tree->p_CurrentNode->contents->lcForumName."</option>\n";
		}
	return $ret;
	}
}

class ForumView extends ListView {
	
	function forumView($tree) {
		$this->tree = $tree;
	}
	function renderAsTable($w="100%") {
		reset($this->tree);
		$this->tree->reset();
		while ($this->tree->traverse() ) {
			// ugly hack - not sure why this is necessary, 
			// but adding objects without a toplevel parent may be the problem, 
			// as the first object also is the root and was/is rendered twice somehow??/
			$k = $this->tree->p_CurrentNode->contents->{$this->tree->keyName};
			if ($done[$k]) { continue;}
			$done[$k] = true;
// always expanded
			$this->tree->p_CurrentNode->expanded=true;
			if ($this->tree->p_CurrentNode->expanded !== true) { $this->tree->p_CurrentNode->expanded = false; }
			if ($row=='#dddddd') { $row='#cccccc'; } else { $row='#dddddd'; }
			// print all types of pipes as you cycle through each level of indent
//print $this->tree->p_CurrentNode->indent ."- ";
			$indent = 0;
			for ($q=0; $q < $this->tree->p_CurrentNode->indent; ++$q) {
				if ($this->tree->stack[$q]->hasSibling()) {
				#	$ret .= "<img src=\"path-pipe.png\" align=\"center\" height=\"18\" width=\"15\">";
					$indent += 40;
				} else {
					$indent += 40;
				#	$ret .= "&nbsp;&nbsp;";
				}
			}
			#if ($indent) $indent = "margin:{$indent}px;"; else $indent = '';

			if ($this->tree->p_CurrentNode->hasChild() && $this->tree->p_CurrentNode->hasSibling()){
	#			$ret .= "<img src=\"sibling-child-pipe.png\"border=\"0\" align=\"center\" height=\"18\" width=\"15\">";
	}
			else if ($this->tree->p_CurrentNode->hasChild()){
	#			$ret .= "<img src=\"child-close-pipe.png\"border=\"0\" align=\"center\" height=\"18\" width=\"15\">";
	}
			else if ($this->tree->p_CurrentNode->hasSibling()) {
	#			$ret .= "<img src=\"sibling-pipe.png\"border=\"0\" align=\"center\" height=\"18\" width=\"15\">";
	}
			else {
	#			$ret .= "<img src=\"child-pipe.png\" border=\"0\" align=\"center\" height=\"18\" width=\"15\">";
	}
			$ret .= '<table width="100%"><tr><td width="'.$indent.'">&nbsp;</td><td valign="top">';
			$this->tree->p_CurrentNode->contents->url = $this->url;
			$ret .= showPost($this->tree->p_CurrentNode->contents, $this->tree->perms, $this->tree->highlight);
			$ret .= '</td></tr></table>';
		}
	return $ret;
	}

}

function showPost($f, $perms, $highlight='') {
$bg='silver';
if ($f->lcForumPostThreadId==0) { 
	$f->lcForumPostThreadId = $f->lcForumPostId;
}
if ( $f->lcForumPostStatus==1) { 
if ( !($perms['dele'] || $perms['admi'])) { 
return;
} else {
	$bg='red';
		$isDeleted = true;
}
}
if ($f->url=='') { $f->url="forum/post"; }
ob_start();
?>
		<table width="100%" style="border:1px solid <?=$bg;?>;margin-bottom:5px;" border="0">
		<tr class="forumsection" style="text-align: left;">
			<td>
				<b>"<?=$f->lcForumPostTitle;?>"</b><br />
				<small>By: <a href="<?=appurl('pm/main/event=compose/sendto='.$f->lcForumPostUsername);?>"><?=$f->lcForumPostUsername;?></a> &nbsp;&nbsp;-&nbsp;&nbsp; On: <?=date('M j, Y @ g:i a', $f->lcForumPostTimedate);?></small>
			</td>
		</tr>
		<tr style="text-align: left;">
			<td>
				<?=nl2br(stripslashes($f->lcForumPostMessage));?>
			</td>
		</tr>
		<tr>
		<td  align="right">
		<? if ($perms['post']) { ?>

				<a href="<?=appurl($f->url."/".$f->lcForumId."/".$f->lcForumPostId."/".$f->lcForumPostThreadId."/event=reply");?>">Reply to this</a>
		<? } ?>
		<? if ($perms['dele']) { ?>
			<? if (!$isDeleted) { ?>
				<BR>
				<a href="<?=appurl($f->url."/".$f->lcForumId."/".$f->lcForumPostId."/".$f->lcForumPostThreadId."/event=delete");?>">Delete this post</a>
				<? } else { ?>
				<BR>
				<a href="<?=appurl($f->url."/".$f->lcForumId."/".$f->lcForumPostId."/".$f->lcForumPostThreadId."/event=undelete");?>">Undelete this post</a>
			<? } ?>
		<? } ?>
			</td>
		</tr>
		</table>
<?
$x = ob_get_contents();
ob_end_clean();
if ($highlight) {
	$x = preg_replace("/$highlight/i","<span style='background-color: red'>$0</span>",$x);
}
return $x;
}
	

?>
