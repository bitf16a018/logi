-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 05.17.2007


DROP TABLE IF EXISTS `lob_content`;
CREATE TABLE `lob_content` (
		
	`lob_content_id` integer (11) NOT NULL auto_increment, 
	`lob_guid` varchar (255) NOT NULL, 
	`lob_title` varchar (255) NOT NULL, 
	`lob_type` varchar (255) NOT NULL, 
	`lob_sub_type` varchar (255) NOT NULL, 
	`lob_mime` varchar (255) NOT NULL, 
	`lob_caption` varchar (255) NOT NULL, 
	`lob_description` text NOT NULL, 
	`lob_notes` longtext NOT NULL, 
	`lob_content` longtext NOT NULL, 
	`lob_binary` longblob NOT NULL, 
	`lob_filename` varchar (255) NOT NULL, 
	`lob_urltitle` varchar (255) NOT NULL,
	PRIMARY KEY (lob_content_id) 
);
