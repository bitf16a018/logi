<? 
include("./defines.php");
include(LIB_PATH."/LC_db.php");

?>
<html>

<body>

<?
if ($_GET['filename']!='') {
	global $projectName;
	ob_start();
	include('pbdo_core.php');
	pbdocore(PBDO_PATH."/sourcefiles/".$_GET['filename']);
	ob_end_clean();
	?>
	Processing complete.  Visit <a href="projects/<?=$projectName;?>/html/">here</a> to see the output.
<? } ?>
</body>
</html>
