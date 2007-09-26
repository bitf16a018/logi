-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 09.26.2007


DROP TABLE IF EXISTS `lob_class_repo`;
CREATE TABLE `lob_class_repo` (
		
	`lob_class_repo_id` integer (11) NOT NULL auto_increment, 
	`lob_repo_entry_id` integer (11) NOT NULL, 
	`lob_copy_style` char (1) NOT NULL, 
	`lob_type` varchar (100) NOT NULL, 
	`class_id` integer (11) NOT NULL, 
	`lob_version` integer (11) NOT NULL,
	PRIMARY KEY (lob_class_repo_id) 
);

CREATE INDEX lob_version_idx ON lob_class_repo (lob_version);
CREATE INDEX lob_repo_entry_idx ON lob_class_repo (lob_repo_entry_id);
CREATE INDEX lob_type_idx ON lob_class_repo (lob_type);
CREATE INDEX class_idx ON lob_class_repo (class_id);

