<?
$installTableSchemas = array();
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `class_enrollment`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
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
)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX student_idx ON class_enrollment (student_id)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX semester_idx ON class_enrollment (semester_id)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX class_idx ON class_enrollment (class_id)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX active_idx ON class_enrollment (active);
campusdelimeter;
$installTableSchemas[] = $table;

?>