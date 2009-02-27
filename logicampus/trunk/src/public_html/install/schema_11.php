<?
$installTableSchemas = array();
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `lob_class_metadata`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `lob_class_metadata` (
	`lob_class_metadata_id` integer (11) NOT NULL auto_increment, 
	`lob_class_repo_id` integer (11) NOT NULL, 
	`subject` varchar (255) NOT NULL, 
	`subdisc` varchar (255) NOT NULL, 
	`author` varchar (255) NOT NULL, 
	`source` varchar (255) NOT NULL, 
	`copyright` varchar (255) NOT NULL, 
	`license` varchar (255) NOT NULL, 
	`user_version` varchar (255) NOT NULL, 
	`status` varchar (255) NOT NULL, 
	`updated_on` integer (11) NOT NULL, 
	`created_on` integer (11) NOT NULL,
	PRIMARY KEY (lob_class_metadata_id) 
)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `lob_class_repo_idx` ON `lob_class_metadata` (`lob_class_repo_id`);
campusdelimeter;
$installTableSchemas[] = $table;

?>