-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 09.29.2007


DROP TABLE IF EXISTS `lob_class_test`;
CREATE TABLE `lob_class_test` (
		
	`lob_class_test_id` integer (11) NOT NULL auto_increment, 
	`lob_class_repo_id` integer (11) NOT NULL, 
	`num_retry` integer (11) NOT NULL, 
	`is_practice` tinyint (2) NOT NULL,
	PRIMARY KEY (lob_class_test_id) 
);

CREATE INDEX lob_class_repo_idx ON lob_class_test (lob_class_repo_id);

