<?

require_once(LIB_PATH.'classObj.php');

class gradebookTest extends UnitTestCase {

	var $tests = array (
		'Future Entry Vals'=> array ('name'=>'future','expected'=>0),
		'Homework link error'=> array ('name'=>'hwlink','expected'=>1),
		'Quiz link error'=> array ('name'=>'testlink','expected'=>1)
		);

	var $description = "Tests some aspects of the gradebook.";

	/**
	 *  This test should fail,
	 * we don't want vals linked to entries that don't exist
	 * for the current semester.
	 */
	function futureTest() {

	$sql = "
SELECT DISTINCT(class_gradebook_val.id_class_gradebook_entries)
 FROM `class_gradebook_val`
 LEFT JOIN `class_gradebook_entries` as B
 ON B.id_class_gradebook_entries = class_gradebook_val.id_class_gradebook_entries
 WHERE CONCAT(class_gradebook_val.id_class_gradebook_entries,class_gradebook_val.id_classes)
 <>
 CONCAT(B.id_class_gradebook_entries,B.id_classes)";

		$db = DB::getHandle();
		$db->query($sql);
		$db->next_record();
		return count($db->record);
	}



	/**
	 */
	function testlinkTest() {

	$sql = "
SELECT COUNT(class_gradebook_entries.id_class_gradebook_entries) as c,assessment_id, id_classes 
 FROM `class_gradebook_entries`
WHERE assessment_id > 0
GROUP BY assessment_id";

		$db = DB::getHandle();
		$db2 = DB::getHandle();
		$db->query($sql);
		$flag = true;		//assume positive outcome
		$x = 0;

		while ($db->next_record() ) {
			if ($db->Record['c'] > 1 ) {$flag = false; debug($db->Record); ++$x;
$db2->query('select id_classes from class_gradebook_entries where assessment_id = '.$db->Record['assessment_id']);
while ($db2->next_record() ) {
debug($db2->Record);
			}
}
#			if ($db->Record['c'] > 1 ) {$flag = false;  ++$x;}
		}
		print "<hr>\n";
		print "$x\n";
		print "<hr>\n";
		return $flag;
	}


	/**
	 */
	function hwlinkTest() {
	$sql = "
SELECT COUNT(class_gradebook_entries.id_class_gradebook_entries) as c, assignment_id, id_classes 
 FROM `class_gradebook_entries`
WHERE assignment_id > 0
GROUP BY assignment_id";

		$db = DB::getHandle();
		$db->query($sql);
		$flag = true;		//assume positive outcome

		while ($db->next_record() ) {
			#$if ($db->Record['c'] > 1 ) {$flag = false; debug($db->Record); ++$x;}
			if ($db->Record['c'] > 1 ) {$flag = false; ++$x;}
		}
		print "<hr>\n";
		print "$x\n";
		print "<hr>\n";
		return $flag;
	}


}


?>
