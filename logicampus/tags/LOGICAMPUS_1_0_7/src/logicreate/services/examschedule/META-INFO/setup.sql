CREATE TABLE exam_schedule_classes (
  id_exam_schedule_classes int(11) NOT NULL auto_increment,
  id_classes int(11) unsigned NOT NULL default '0',
  id_semester int(11) unsigned NOT NULL default '0',
  status int(1) NOT NULL default '1',
  received_date datetime NOT NULL default '0000-00-00 00:00:00',
  south_campus int(1) NOT NULL default '0',
  southeast_campus int(1) NOT NULL default '0',
  northeast_campus int(1) NOT NULL default '0',
  northwest_campus int(1) NOT NULL default '0',
  note text NOT NULL,
  PRIMARY KEY  (id_exam_schedule_classes),
  KEY id_semester (id_semester),
  KEY id_classes (id_classes)
) TYPE=MyISAM;


CREATE TABLE exam_schedule_classes_dates (
  id_exam_schedule_classes_dates int(11) NOT NULL auto_increment,
  id_classes bigint(20) unsigned NOT NULL default '0',
  id_exam_schedule_dates bigint(20) unsigned NOT NULL default '0',
  new_exam int(1) NOT NULL default '0',
  title varchar(255) NOT NULL default '',
  instructions text NOT NULL,
  south_copies int(1) default '0',
  southeast_copies int(1) default '0',
  northeast_copies int(1) default '0',
  northwest_copies int(1) default '0',
  num_of_copies int(11) default '0',
  note text,
  status tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (id_exam_schedule_classes_dates),
  KEY id_exam_schedule_dates (id_exam_schedule_dates),
  KEY id_classes (id_classes)
) TYPE=MyISAM;


CREATE TABLE exam_schedule_dates (
  id_exam_schedule_dates bigint(20) unsigned NOT NULL auto_increment,
  id_semester bigint(20) unsigned NOT NULL default '0',
  date_start datetime NOT NULL default '0000-00-00 00:00:00',
  date_end datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (id_exam_schedule_dates)
) TYPE=MyISAM;

