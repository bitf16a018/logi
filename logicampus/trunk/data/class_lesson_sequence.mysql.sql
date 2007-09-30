-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 09.30.2007


DROP TABLE IF EXISTS `class_lesson_sequence`;
CREATE TABLE `class_lesson_sequence` (
		
	`class_lesson_sequence_id` integer (11) NOT NULL auto_increment, 
	`lesson_id` integer (11) NOT NULL, 
	`class_id` integer (11) NOT NULL, 
	`lob_class_repo_id` integer (11) NOT NULL, 
	`lob_type` varchar (100) NOT NULL, 
	`lob_sub_type` varchar (100) NOT NULL, 
	`lob_title` varchar (255) NOT NULL, 
	`link_text` varchar (255) NOT NULL, 
	`not_before_seq_id` int (11), 
	`start_offset` int (11), 
	`end_offset` int (11), 
	`due_offset` int (11), 
	`grace_period_days` int (11), 
	`rank` integer (11) NOT NULL, 
	`hide_until_start` int (2) NOT NULL, 
	`hide_after_end` int (2) NOT NULL,
	PRIMARY KEY (class_lesson_sequence_id) 
);

CREATE INDEX class_idx ON class_lesson_sequence (class_id);
CREATE INDEX lesson_idx ON class_lesson_sequence (lesson_id);
CREATE INDEX lob_class_repo_idx ON class_lesson_sequence (lob_class_repo_id);
CREATE INDEX rank_idx ON class_lesson_sequence (rank);
CREATE INDEX link_text_idx ON class_lesson_sequence (link_text);

