<?
$installTableSchemas = array();
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `lob_repo_entry`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `lob_repo_entry` (
	`lob_repo_entry_id` integer (11) NOT NULL auto_increment, 
	`lob_guid` varchar (255) NOT NULL, 
	`lob_title` varchar (255) NOT NULL, 
	`lob_type` varchar (100) NOT NULL, 
	`lob_sub_type` varchar (100) NOT NULL, 
	`lob_mime` varchar (100) NOT NULL, 
	`lob_description` text, 
	`lob_notes` text, 
	`lob_urltitle` varchar (255) NOT NULL, 
	`lob_version` integer (11) NOT NULL, 
	`lob_bytes` integer (11) NOT NULL,
	PRIMARY KEY (lob_repo_entry_id) 
)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `lob_guid_idx` ON `lob_repo_entry` (`lob_guid`);
campusdelimeter;
$installTableSchemas[] = $table;

?>