-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 04.14.2007


DROP TABLE IF EXISTS `class_syllabus`;
CREATE TABLE `class_syllabus` (
		
	`class_syllabus_id` integer (11) NOT NULL auto_increment, 
	`class_id` integer (11) NOT NULL, 
	`section_title` varchar (255) NOT NULL, 
	`section_content` text NOT NULL,
	`rank` integer (11) NOT NULL,
	PRIMARY KEY (`class_syllabus_id`) 
);

ALTER TABLE `class_syllabus` ADD INDEX `class_idx` (`class_id`);

