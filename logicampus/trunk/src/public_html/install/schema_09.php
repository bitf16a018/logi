<?
$installTableSchemas = array();
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `lob_class_content`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `lob_class_content` (
	`lob_class_content_id` integer (11) NOT NULL auto_increment, 
	`lob_class_repo_id` integer (11) NOT NULL, 
	`lob_text` text, 
	`lob_binary` longblob, 
	`lob_filename` varchar (255) NOT NULL, 
	`lob_caption` varchar (255) NOT NULL,
	PRIMARY KEY (lob_class_content_id) 
)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `lob_class_repo_idx` ON `lob_class_content` (`lob_class_repo_id`);
campusdelimeter;
$installTableSchemas[] = $table;

?>