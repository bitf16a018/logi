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
) TYPE=MyISAM;


CREATE TABLE class_gradebook_categories (
  id_class_gradebook_categories int(10) unsigned NOT NULL auto_increment,
  id_classes int(10) unsigned NOT NULL default '0',
  label varchar(255) NOT NULL default '',
  weight float default NULL,
  drop_count tinyint(4) default NULL,
  PRIMARY KEY  (id_class_gradebook_categories),
  KEY id_classes (id_classes)
) TYPE=MyISAM;


CREATE TABLE class_gradebook_entries (
  id_class_gradebook_entries int(10) unsigned NOT NULL auto_increment,
  id_classes int(10) unsigned NOT NULL default '0',
  id_class_gradebook_categories int(10) unsigned NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  gradebook_code varchar(100) NOT NULL default '',
  total_points float NOT NULL default '0',
  publish_flag tinyint(1) NOT NULL default '0',
  date_due int(10) unsigned NOT NULL default '0',
  notes text,
  assessment_id int(11) unsigned NOT NULL default '0',
  assignment_id int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id_class_gradebook_entries),
  KEY id_classes (id_classes),
  KEY id_class_gradebook_categories (id_class_gradebook_categories),
  KEY assignment_id (assignment_id),
  KEY date_due (date_due)
) TYPE=MyISAM;


CREATE TABLE class_gradebook_val (
  id_class_gradebook_val int(10) unsigned NOT NULL auto_increment,
  id_class_gradebook_entries int(11) unsigned NOT NULL default '0',
  id_classes int(10) unsigned NOT NULL default '0',
  username varchar(30) NOT NULL default '',
  score float default NULL,
  comments text,
  date_created int(10) unsigned NOT NULL default '0',
  date_modified int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id_class_gradebook_val),
  KEY username (username),
  KEY id_classes (id_classes),
  KEY id_class_gradebook_entries (id_class_gradebook_entries),
  KEY date_modified (date_modified)
) TYPE=MyISAM;
