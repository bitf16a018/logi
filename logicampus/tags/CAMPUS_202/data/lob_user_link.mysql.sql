-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 09.27.2007


DROP TABLE IF EXISTS `lob_user_link`;
CREATE TABLE `lob_user_link` (
		
	`lob_user_link_id` integer (11) NOT NULL auto_increment, 
	`lob_repo_entry_id` integer (11) NOT NULL, 
	`user_id` integer (11) NOT NULL, 
	`is_owner` integer (11),
	PRIMARY KEY (lob_user_link_id) 
);

CREATE INDEX lob_repo_entry_idx ON lob_user_link (lob_repo_entry_id);
CREATE INDEX user_id ON lob_user_link (user_id);
CREATE INDEX is_owner_idx ON lob_user_link (is_owner);

