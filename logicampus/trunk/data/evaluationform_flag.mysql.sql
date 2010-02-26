-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 02.26.2010


DROP TABLE IF EXISTS `evaluationform_flag`;
CREATE TABLE `evaluationform_flag` (
		
	`eval_form` varchar (20) NOT NULL, 
	`flag` binary (1) NOT NULL, 
	`start` datetime NOT NULL, 
	`end` datetime NOT NULL
);
