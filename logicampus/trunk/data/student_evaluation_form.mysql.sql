-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 02.26.2010


DROP TABLE IF EXISTS `student_evaluation_form`;
CREATE TABLE `student_evaluation_form` (
		
	`id` integer (10) NOT NULL, 
	`student_id` integer (11) NOT NULL, 
	`id_classes` integer (11) NOT NULL, 
	`serial_no` integer (5) NOT NULL, 
	`rank` integer (5) NOT NULL
);
