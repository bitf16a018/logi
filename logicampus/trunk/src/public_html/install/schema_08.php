<?
$installTableSchemas = array();
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `lob_class_activity`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `lob_class_activity` (
	`lob_class_activity_id` integer (11) NOT NULL auto_increment, 
	`lob_class_repo_id` integer (11) NOT NULL, 
	`response_type_id` tinyint (4) NOT NULL,
	PRIMARY KEY (lob_class_activity_id) 
)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `lob_class_repo_idx` ON `lob_class_activity` (`lob_class_repo_id`);
campusdelimeter;
$installTableSchemas[] = $table;

?>