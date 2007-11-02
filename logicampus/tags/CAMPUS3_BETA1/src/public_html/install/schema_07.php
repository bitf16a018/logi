<?
$installTableSchemas = array();
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `lob_class_test`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `lob_class_test` (
	`lob_class_test_id` integer (11) NOT NULL auto_increment, 
	`lob_class_repo_id` integer (11) NOT NULL, 
	`num_retry` integer (11) NOT NULL, 
	`is_practice` tinyint (2) NOT NULL,
	PRIMARY KEY (lob_class_test_id) 
)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX lob_class_repo_idx ON lob_class_test (lob_class_repo_id);
campusdelimeter;
$installTableSchemas[] = $table;

?>