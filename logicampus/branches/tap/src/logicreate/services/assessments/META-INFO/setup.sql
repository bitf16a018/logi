CREATE TABLE assessment (
  assessment_id int(11) NOT NULL auto_increment,
  display_name varchar(255) default NULL,
  class_id int(11) default NULL,
  date_available int(14) default NULL,
  date_unavailable int(11) default NULL,
  mail_responses tinyint(1) default NULL,
  auto_publish tinyint(1) default NULL,
  num_retries tinyint(4) default NULL,
  minute_limit int(11) default NULL,
  description text,
  instructions text,
  show_result_type tinyint(1) NOT NULL default '0',
  possible_points float NOT NULL default '0',
  PRIMARY KEY  (assessment_id)
) TYPE=MyISAM;


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
) TYPE=MyISAM;


CREATE TABLE assessment_log (
  id_assessment_log int(10) unsigned NOT NULL auto_increment,
  assessment_id int(11) unsigned NOT NULL default '0',
  id_student varchar(32) NOT NULL default '',
  start_date int(11) NOT NULL default '0',
  end_date int(11) NOT NULL default '0',
  id_classes int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id_assessment_log),
  KEY assessment_id (assessment_id)
) TYPE=MyISAM;


CREATE TABLE assessment_question (
  assessment_question_id int(11) NOT NULL auto_increment,
  assessment_id int(11) default NULL,
  question_type int(11) default NULL,
  question_sort tinyint(4) unsigned NOT NULL default '0',
  question_points float NOT NULL default '0',
  question_display varchar(255) default NULL,
  question_text mediumtext,
  question_choices text,
  question_input text NOT NULL,
  file_hash varchar(32) NOT NULL default '',
  PRIMARY KEY  (assessment_question_id)
) TYPE=MyISAM;