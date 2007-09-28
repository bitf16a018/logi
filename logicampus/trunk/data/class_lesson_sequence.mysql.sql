-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 09.28.2007


DROP TABLE IF EXISTS `class_lesson_sequence`;
CREATE TABLE `class_lesson_sequence` (
		
	`class_lesson_sequence_id` integer (11) NOT NULL auto_increment, 
	`lesson_id` integer (11) NOT NULL, 
	`class_id` integer (11) NOT NULL, 
	`lob_id` integer (11) NOT NULL, 
	`lob_type` varchar (100) NOT NULL, 
	`lob_sub_type` varchar (100) NOT NULL, 
	`lob_mime` varchar (100) NOT NULL, 
	`lob_title` varchar (255) NOT NULL, 
	`link_text` varchar (255) NOT NULL, 
	`visible` int (4) NOT NULL, 
	`not_before_seq_id` int (11), 
	`allow_after_days` int (11), 
	`allow_on` int (11), 
	`rank` integer (11) NOT NULL,
	PRIMARY KEY (class_lesson_sequence_id) 
);

CREATE INDEX class_idx ON class_lesson_sequence (class_id);
CREATE INDEX lesson_idx ON class_lesson_sequence (lesson_id);
CREATE INDEX lob_idx ON class_lesson_sequence (lob_id);
CREATE INDEX rank_idx ON class_lesson_sequence (rank);
CREATE INDEX link_text_idx ON class_lesson_sequence (link_text);

