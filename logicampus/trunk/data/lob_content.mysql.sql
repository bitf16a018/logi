-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 09.26.2007


DROP TABLE IF EXISTS `lob_content`;
CREATE TABLE `lob_content` (
		
	`lob_content_id` integer (11) NOT NULL auto_increment, 
	`lob_text` text, 
	`lob_binary` longblob, 
	`lob_filename` varchar (255) NOT NULL, 
	`lob_caption` varchar (255) NOT NULL,
	PRIMARY KEY (lob_content_id) 
);
