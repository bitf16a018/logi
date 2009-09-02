<?
$installTableSchemas = array();
$table = <<<campusdelimeter
CREATE TABLE class_gradebook (
  id_class_gradebook int(10) unsigned NOT NULL auto_increment,
  id_classes int(10) unsigned NOT NULL default '0',
  a_upper float NOT NULL default '0',
  a_lower float NOT NULL default '0',
  b_lower float NOT NULL default '0',
  c_lower float NOT NULL default '0',
  d_lower float NOT NULL default '0',
  calculation_type int(1) NOT NULL default '0',
  color_missing_grade char(10) NOT NULL default 'FFC2CD',
  roundScoresUp tinyint(1) NOT NULL default '0',
  total_points int(11) NOT NULL default '0',
  PRIMARY KEY  (id_class_gradebook),
  UNIQUE KEY id_classes (id_classes)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE class_gradebook_categories (
  id_class_gradebook_categories int(10) unsigned NOT NULL auto_increment,
  id_classes int(10) unsigned NOT NULL default '0',
  label varchar(255) NOT NULL default '',
  weight float default NULL,
  drop_count tinyint(4) default NULL,
  PRIMARY KEY  (id_class_gradebook_categories),
  KEY id_classes (id_classes)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `class_gradebook_entries` (
	`id_class_gradebook_entries` integer (10) NOT NULL auto_increment, 
	`id_classes` integer (10) NOT NULL, 
	`id_class_gradebook_categories` integer (10) NOT NULL, 
	`title` varchar (100) NOT NULL, 
	`gradebook_code` varchar (100) NOT NULL, 
	`total_points` float NOT NULL, 
	`publish_flag` tinyint (1) NOT NULL, 
	`notes` text, 
	`class_lesson_sequence_id` integer (11) NOT NULL,
	'rank' integer (10) NOT NULL,
	PRIMARY KEY (id_class_gradebook_entries) 
)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `class_lesson_sequence_idx` ON `class_gradebook_entries` (`class_lesson_sequence_id`)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `id_classes_idx` ON `class_gradebook_entries` (`id_classes`)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `id_class_gradebook_categories_idx` ON `class_gradebook_entries` (`id_class_gradebook_categories`)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `class_gradebook_val` (
	`id_class_gradebook_val` integer (10) NOT NULL auto_increment, 
	`id_class_gradebook_entries` integer (11) NOT NULL, 
	`id_classes` integer (10) NOT NULL, 
	`student_id` integer (11) NOT NULL, 
	`absent` tinyint (2) NOT NULL, 
	`score` float, 
	`comments` text, 
	`date_created` integer (10) NOT NULL, 
	`date_modified` integer (10) NOT NULL,
	PRIMARY KEY (id_class_gradebook_val) 
)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `id_class_gradebook_entries_idx` ON `class_gradebook_val` (`id_class_gradebook_entries`)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `id_classes_idx` ON `class_gradebook_val` (`id_classes`)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX `student_idx` ON `class_gradebook_val` (`student_id`);
campusdelimeter;
$installTableSchemas[] = $table;

?>