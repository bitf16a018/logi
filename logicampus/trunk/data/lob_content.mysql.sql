-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 05.12.2007


DROP TABLE IF EXISTS `lob_content`;
CREATE TABLE `lob_content` (
		
	`lob_content_id` integer (11) NOT NULL auto_increment, 
	`lob_title` varchar (255) NOT NULL, 
	`lob_type` varchar (255) NOT NULL, 
	`lob_sub_type` varchar (255) NOT NULL, 
	`lob_caption` varchar (255) NOT NULL, 
	`lob_description` text NOT NULL, 
	`lob_notes` text NOT NULL, 
	`lob_content` text NOT NULL, 
	`lob_binary` text NOT NULL, 
	`lob_filename` varchar (255) NOT NULL, 
	`lob_urltitle` varchar (255) NOT NULL,
	PRIMARY KEY (lob_content_id) 
);
