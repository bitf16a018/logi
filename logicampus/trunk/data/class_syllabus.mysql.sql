-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 04.14.2007


DROP TABLE IF EXISTS `class_syllabus`;
CREATE TABLE `class_syllabus` (
		
	`id_class_syllabus` integer (11) NOT NULL auto_increment, 
	`id_classes` integer (11) NOT NULL, 
	`section_title` varchar (255) NOT NULL, 
	`section_content` text NOT NULL,
	PRIMARY KEY (id_class_syllabus) 
);
