<?
$installTableSchemas = array();
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `lob_metadata`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `lob_metadata` (
	`lob_metadata_id` integer (11) NOT NULL auto_increment, 
	`lob_id` integer (11) NOT NULL, 
	`lob_kind` varchar (255) NOT NULL, 
	`subject` varchar (255) NOT NULL, 
	`subdisc` varchar (255) NOT NULL, 
	`author` varchar (255) NOT NULL, 
	`copyright` varchar (255) NOT NULL, 
	`license` varchar (255) NOT NULL, 
	`version` varchar (255) NOT NULL, 
	`status` varchar (255) NOT NULL, 
	`updated_on` integer (11) NOT NULL, 
	`created_on` integer (11) NOT NULL,
	PRIMARY KEY (lob_metadata_id) 
);
campusdelimeter;
$installTableSchemas[] = $table;

?>