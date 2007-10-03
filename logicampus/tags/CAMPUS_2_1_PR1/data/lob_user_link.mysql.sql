-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 05.13.2007


DROP TABLE IF EXISTS `lob_user_link`;
CREATE TABLE `lob_user_link` (
		
	`lob_user_link_id` integer (11) NOT NULL auto_increment, 
	`lob_id` integer (11) NOT NULL, 
	`lob_kind` varchar (255) NOT NULL, 
	`user_id` integer (11) NOT NULL,
	PRIMARY KEY (lob_user_link_id) 
);

CREATE INDEX lob_idx ON lob_user_link (lob_id);
CREATE INDEX lob_kind_idx ON lob_user_link (lob_kind);
CREATE INDEX user_idx ON lob_user_link (user_id);

