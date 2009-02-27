<?
$installTableSchemas = array();
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `lob_content`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `lob_content` (
	`lob_content_id` integer (11) NOT NULL auto_increment, 
	`lob_text` text, 
	`lob_binary` longblob, 
	`lob_filename` varchar (255) NOT NULL, 
	`lob_caption` varchar (255) NOT NULL, 
	`lob_repo_entry_id` integer (11) NOT NULL,
	PRIMARY KEY (lob_content_id) 
)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `lob_repo_entry_idx` ON `lob_content` (`lob_repo_entry_id`);
campusdelimeter;
$installTableSchemas[] = $table;

?>