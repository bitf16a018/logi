<?
$installTableSchemas = array();
$table = <<<campusdelimeter
CREATE TABLE assessment_answer (
  assessment_answer_id int(11) NOT NULL auto_increment,
  assessment_id int(11) default NULL,
  assessment_question_id int(11) default NULL,
  student_id varchar(32) default NULL,
  assessment_answer_values text,
  id_classes int(11) unsigned NOT NULL default '0',
  points_earned float default NULL,
  points_given float default NULL,
  PRIMARY KEY  (assessment_answer_id),
  KEY id_classes (id_classes),
  KEY assessment_id (assessment_id),
  KEY assessment_question_id (assessment_question_id),
  KEY student_id (student_id)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE assessment_log (
  id_assessment_log int(10) unsigned NOT NULL auto_increment,
  assessment_id int(11) unsigned NOT NULL default '0',
  id_student varchar(32) NOT NULL default '',
  start_date int(11) NOT NULL default '0',
  end_date int(11) NOT NULL default '0',
  id_classes int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id_assessment_log),
  KEY assessment_id (assessment_id)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE assessment_grade (
  assessment_grade_id int(11) NOT NULL auto_increment,
  assessment_id int(11) default NULL,
  student_id varchar(32) NOT NULL,
  comments text default NULL,
  points float(10,2) default NULL,
  points_override float(10,2) default NULL,
  PRIMARY KEY  (assessment_grade_id)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;

?>