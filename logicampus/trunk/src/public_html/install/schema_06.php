<?
$installTableSchemas = array();
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `lob_activity`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `lob_activity` (
	`lob_activity_id` integer (11) NOT NULL auto_increment, 
	`lob_repo_entry_id` integer (11) NOT NULL, 
	`response_type_id` tinyint (4) NOT NULL,
	PRIMARY KEY (lob_activity_id) 
)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX lob_repo_entry_idx ON lob_activity (lob_repo_entry_id);
campusdelimeter;
$installTableSchemas[] = $table;

?>