-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 08.08.2005

DROP TABLE IF EXISTS `assessment_lesson_link`;
CREATE TABLE `assessment_lesson_link` (

	`assessment_lesson_link_id` integer (11) NOT NULL auto_increment,  --

	`assessment_id` integer (11),  --

	`lesson_id` integer (11),  --

	PRIMARY KEY (assessment_lesson_link_id)
)TYPE=InnoDB;

CREATE INDEX assessment_id ON assessment_lesson_link (assessment_id);
CREATE INDEX lesson_id ON assessment_lesson_link (lesson_id);

