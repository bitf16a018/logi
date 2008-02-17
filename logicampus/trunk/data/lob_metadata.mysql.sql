-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 02.16.2008


DROP TABLE IF EXISTS `lob_metadata`;
CREATE TABLE `lob_metadata` (
		
	`lob_metadata_id` integer (11) NOT NULL auto_increment, 
	`lob_repo_entry_id` integer (11) NOT NULL, 
	`subject` varchar (255) NOT NULL, 
	`subdisc` varchar (255) NOT NULL, 
	`author` varchar (255) NOT NULL, 
	`source` varchar (255) NOT NULL, 
	`copyright` varchar (255) NOT NULL, 
	`license` varchar (255) NOT NULL, 
	`user_version` varchar (255) NOT NULL, 
	`status` varchar (255) NOT NULL, 
	`updated_on` integer (11) NOT NULL, 
	`created_on` integer (11) NOT NULL,
	PRIMARY KEY (lob_metadata_id) 
);

CREATE INDEX `lob_repo_entry_idx` ON `lob_metadata` (`lob_repo_entry_id`);

