<?
$installTableSchemas = array();
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `lob_class_repo`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `lob_class_repo` (
	`lob_class_repo_id` integer (11) NOT NULL auto_increment, 
	`class_id` integer (11) NOT NULL, 
	`lob_repo_entry_id` integer (11) NOT NULL, 
	`lob_guid` varchar (255) NOT NULL, 
	`lob_title` varchar (255) NOT NULL, 
	`lob_urltitle` varchar (255) NOT NULL, 
	`lob_copy_style` char (1) NOT NULL, 
	`lob_type` varchar (100) NOT NULL, 
	`lob_sub_type` varchar (100) NOT NULL, 
	`lob_mime` varchar (100) NOT NULL, 
	`lob_description` text, 
	`lob_version` integer (11) NOT NULL, 
	`lob_bytes` integer (11) NOT NULL,
	PRIMARY KEY (lob_class_repo_id) 
)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `lob_version_idx` ON `lob_class_repo` (`lob_version`)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `lob_repo_entry_idx` ON `lob_class_repo` (`lob_repo_entry_id`)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `lob_type_idx` ON `lob_class_repo` (`lob_type`)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `class_idx` ON `lob_class_repo` (`class_id`)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `lob_guid_idx` ON `lob_class_repo` (`lob_guid`);
campusdelimeter;
$installTableSchemas[] = $table;

?>