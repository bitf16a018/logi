
DROP TABLE IF EXISTS `class_syllabus`;
CREATE TABLE `class_syllabus` (
		
	`class_syllabus_id` integer (11) NOT NULL auto_increment, 
	`class_id` integer (11) NOT NULL, 
	`section_title` varchar (255) NOT NULL, 
	`section_content` text NOT NULL,
	`rank` integer (11) NOT NULL,
	PRIMARY KEY (`class_syllabus_id`) 
);

ALTER TABLE `class_syllabus` ADD INDEX `class_idx` (`class_id`);


INSERT INTO `class_syllabus` (`class_id`, `section_content`, `section_title`) 
SELECT  id_classes, other, "Other Information" FROM `class_syllabuses` 
WHERE other != '';

INSERT INTO `class_syllabus` (`class_id`, `section_content`, `section_title`) 
SELECT  id_classes, courseObjectives, "Course Objectives" FROM `class_syllabuses`
WHERE courseObjectives != '';

INSERT INTO `class_syllabus` (`class_id`, `section_content`, `section_title`) 
SELECT  id_classes, courseReqs, "Course Requirements" FROM `class_syllabuses`
WHERE courseReqs != '';

INSERT INTO `class_syllabus` (`class_id`, `section_content`, `section_title`) 
SELECT  id_classes, gradingScale, "Grading Scale" FROM `class_syllabuses`
WHERE gradingScale != '';

INSERT INTO `class_syllabus` (`class_id`, `section_content`, `section_title`) 
SELECT  id_classes, instructionMethods, "Method of Instruction" FROM `class_syllabuses`
WHERE instructionMethods != '';

INSERT INTO `class_syllabus` (`class_id`, `section_content`, `section_title`) 
SELECT  id_classes, emailPolicy, "Email Policy" FROM `class_syllabuses`
WHERE emailPolicy != '';

INSERT INTO `class_syllabus` (`class_id`, `section_content`, `section_title`) 
SELECT  id_classes, noExam, "Exam Policy" FROM `class_syllabuses`
WHERE noExam != '';
