-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 09.26.2007


DROP TABLE IF EXISTS `lob_test_qst`;
CREATE TABLE `lob_test_qst` (
		
	`lob_test_qst_id` integer (11) NOT NULL auto_increment, 
	`lob_test_id` integer (11) NOT NULL,
	PRIMARY KEY (lob_test_qst_id) 
);

CREATE INDEX lob_test_idx ON lob_test_qst (lob_test_id);

