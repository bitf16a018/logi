<?
$installTableSchemas = array();
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `class_syllabus`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `class_syllabus` (
	`class_syllabus_id` integer (11) NOT NULL auto_increment, 
	`class_id` integer (11) NOT NULL, 
	`section_title` varchar (255) NOT NULL, 
	`section_content` text NOT NULL,
	`rank` integer (11) NOT NULL,
	PRIMARY KEY (`class_syllabus_id`) 
)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
ALTER TABLE `class_syllabus` ADD INDEX `class_idx` (`class_id`);
campusdelimeter;
$installTableSchemas[] = $table;

?>