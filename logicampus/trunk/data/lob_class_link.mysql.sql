-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 05.15.2007


DROP TABLE IF EXISTS `lob_class_link`;
CREATE TABLE `lob_class_link` (
		
	`lob_class_link_id` integer (11) NOT NULL auto_increment, 
	`lob_id` integer (11) NOT NULL, 
	`lob_kind` varchar (255) NOT NULL, 
	`class_id` integer (11) NOT NULL,
	PRIMARY KEY (lob_class_link_id) 
);

CREATE INDEX lob_idx ON lob_class_link (lob_id);
CREATE INDEX lob_kind_idx ON lob_class_link (lob_kind);
CREATE INDEX class_idx ON lob_class_link (class_id);

