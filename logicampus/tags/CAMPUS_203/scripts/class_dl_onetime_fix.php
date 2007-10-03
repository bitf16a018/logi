<?
// run one time only
// this will append the class short name and semester code (ex: ECON102 SP2004)
// to each folder name
define("LIB_PATH", "../lib/");
include("../../public_html/defines.php");
include(LIB_PATH."LC_db.php");
$db = DB::GetHandle();
$db2 = DB::GetHandle();
$db->query("select * from classdoclib_Folders");
while($db->next_record()) {

	$class_id = $db->Record['class_id'];
	$db2->queryOne("select * from classes where id_classes = $class_id");
	$shortName = $db2->Record['courseFamilyNumber']; // ex: BUSG1315
		
	$db2->queryOne("select * from semesters where id_semesters= ".$db2->Record['id_semesters']);
	$semesterName= $db2->Record['semesterId']; // ex: SP2004

	$sql = "update classdoclib_Folders set name='".$db->Record['name']." ($shortName - $semesterName)' 
	where pkey= ".$db->Record['pkey'];
	$db2->query($sql);

}


?>

