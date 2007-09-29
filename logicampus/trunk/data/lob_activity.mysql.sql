-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 09.29.2007


DROP TABLE IF EXISTS `lob_activity`;
CREATE TABLE `lob_activity` (
		
	`lob_activity_id` integer (11) NOT NULL auto_increment, 
	`lob_repo_entry_id` integer (11) NOT NULL, 
	`response_type_id` tinyint (4) NOT NULL,
	PRIMARY KEY (lob_activity_id) 
);

CREATE INDEX lob_repo_entry_idx ON lob_activity (lob_repo_entry_id);

