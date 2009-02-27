<?
$installTableSchemas = array();
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `lob_test`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `lob_test` (
	`lob_test_id` integer (11) NOT NULL auto_increment, 
	`lob_repo_entry_id` integer (11) NOT NULL, 
	`num_retry` integer (11) NOT NULL, 
	`is_practice` tinyint (2) NOT NULL,
	PRIMARY KEY (lob_test_id) 
)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `lob_repo_entry_idx` ON `lob_test` (`lob_repo_entry_id`);
campusdelimeter;
$installTableSchemas[] = $table;

?>