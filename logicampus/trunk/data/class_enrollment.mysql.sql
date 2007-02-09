-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 12.15.2006


DROP TABLE IF EXISTS `class_enrollment`;
CREATE TABLE `class_enrollment` (
		
	`class_enrollment_id` int (11) NOT NULL auto_increment, 
	`student_id` int (11) NOT NULL, 
	`semester_id` int (11) NOT NULL, 
	`class_id` int (11) NOT NULL, 
	`section_number` int (11) NOT NULL, 
	`enrolled_on` int (11) NOT NULL, 
	`active` int (11) NOT NULL, 
	`withdrew_on` int (11) NOT NULL,
	PRIMARY KEY (class_enrollment_id) 
);

CREATE INDEX student_idx ON class_enrollment (student_id);
CREATE INDEX semester_idx ON class_enrollment (semester_id);
CREATE INDEX class_idx ON class_enrollment (class_id);
CREATE INDEX active_idx ON class_enrollment (active);

