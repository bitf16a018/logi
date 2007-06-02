<?
$installTableSchemas = array();
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `lob_content`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `lob_content` (
	`lob_content_id` integer (11) NOT NULL auto_increment, 
	`lob_guid` varchar (255) NOT NULL, 
	`lob_title` varchar (255) NOT NULL, 
	`lob_type` varchar (255) NOT NULL, 
	`lob_sub_type` varchar (255) NOT NULL, 
	`lob_mime` varchar (255) NOT NULL, 
	`lob_caption` varchar (255) NOT NULL, 
	`lob_description` text NOT NULL, 
	`lob_notes` text NOT NULL, 
	`lob_content` text NOT NULL, 
	`lob_binary` text NOT NULL, 
	`lob_filename` varchar (255) NOT NULL, 
	`lob_urltitle` varchar (255) NOT NULL,
	PRIMARY KEY (lob_content_id) 
);
campusdelimeter;
$installTableSchemas[] = $table;

?>