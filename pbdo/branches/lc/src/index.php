<? 
include("./defines.php");
include(LIB_PATH."/LC_db.php");
include("pbdo_core.php");

?>
<html>
<body>
<?
$bad = array("CVS","..",".");
$d = opendir(PBDO_PATH."/projects/");
while($file= readdir($d)) { 
	if (!in_array($file,$bad)) { 
		$projects[] = $file;
	}
}
$bad = array("CVS","..",".");
$d = opendir(PBDO_PATH."/sourcefiles/");
while($file= readdir($d)) { 
	if (!in_array($file,$bad)) { 
		if (strpos($file,"xml")>0) { 
			$sourcefiles[] = $file;
		}
	}
}
?>
<h3>Generated projects</h3>
<? while(list($k,$v) = @each($projects)) { ?>
<a href="projects/<?=$v;?>/html/"><?=$v;?></a></br>
<? } 
if(@count($projects)==0) { ?>
NO GENERATED PROJECTS
<? } ?>

<h3>Sourcefiles</h3>
<table>
<? while(list($k,$v) = @each($sourcefiles)) { ?>
<tr>
<td><?=$v;?></td>
<td><a href="gen.php?filename=<?=$v;?>">generate</a></td>
</tr>
<? } 
if(@count($projects)==0) { ?>
NO SOURCEFILES 
<? } ?>
</body>
</html>
