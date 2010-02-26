-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 02.26.2010


DROP TABLE IF EXISTS `evaluation_form`;
CREATE TABLE `evaluation_form` (
		
	`serial_no` integer (11) NOT NULL auto_increment, 
	`question` varchar (255) NOT NULL, 
	`visible` tinyint (1) NOT NULL, 
	`excellent` tinyint (1) NOT NULL, 
	`very_good` tinyint (1) NOT NULL, 
	`good` tinyint (1) NOT NULL, 
	`satisfactory` tinyint (1) NOT NULL, 
	`unsatisfactory` tinyint (1) NOT NULL, 
	`date_created` datetime NOT NULL, 
	`weightage` integer NOT NULL,
	PRIMARY KEY (serial_no) 
);
