<?
$installTableSchemas = array();
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `lob_user_link`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `lob_user_link` (
	`lob_user_link_id` integer (11) NOT NULL auto_increment, 
	`lob_repo_entry_id` integer (11) NOT NULL, 
	`user_id` integer (11) NOT NULL, 
	`is_owner` integer (11),
	PRIMARY KEY (lob_user_link_id) 
)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `lob_repo_entry_idx` ON `lob_user_link` (`lob_repo_entry_id`)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `user_id` ON `lob_user_link` (`user_id`)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `is_owner_idx` ON `lob_user_link` (`is_owner`);
campusdelimeter;
$installTableSchemas[] = $table;

?>