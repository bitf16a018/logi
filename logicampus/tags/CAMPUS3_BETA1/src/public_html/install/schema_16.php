<?
$installTableSchemas = array();
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `lob_test_qst`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `lob_test_qst` (
	`lob_test_qst_id` integer (11) NOT NULL auto_increment, 
	`lob_test_id` integer (11) NOT NULL,
	PRIMARY KEY (lob_test_qst_id) 
)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX lob_test_idx ON lob_test_qst (lob_test_id);
campusdelimeter;
$installTableSchemas[] = $table;

?>