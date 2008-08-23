<?
$installTableSchemas = array();
$table = <<<campusdelimeter
CREATE TABLE orientation_classes (
  id_orientation_classes int(10) unsigned NOT NULL auto_increment,
  id_classes int(11) unsigned NOT NULL default '0',
  status int(11) NOT NULL default '0',
  first_date_id int(11) unsigned NOT NULL default '0',
  first_campus_location varchar(15) NOT NULL default '',
  first_allotted_minutes int(11) unsigned NOT NULL default '0',
  first_preferred_time time NOT NULL default '00:00:00',
  first_time_range_start time NOT NULL default '00:00:00',
  first_time_range_end time NOT NULL default '00:00:00',
  second_date_id int(11) unsigned NOT NULL default '0',
  second_campus_location varchar(15) NOT NULL default '',
  second_allotted_minutes int(11) unsigned NOT NULL default '0',
  second_preferred_time time NOT NULL default '00:00:00',
  second_time_range_start time NOT NULL default '00:00:00',
  second_time_range_end time NOT NULL default '00:00:00',
  instructions text NOT NULL,
  notes text NOT NULL,
  finalDateTime datetime NOT NULL default '0000-00-00 00:00:00',
  finalSessionLength int(11) NOT NULL default '0',
  finalCampus char(2) NOT NULL default '',
  PRIMARY KEY  (id_orientation_classes)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE orientation_dates (
  id_orientation_dates int(10) unsigned NOT NULL auto_increment,
  id_semesters int(11) unsigned NOT NULL default '0',
  date date NOT NULL default '0000-00-00',
  time_start time NOT NULL default '00:00:00',
  time_end time NOT NULL default '00:00:00',
  PRIMARY KEY  (id_orientation_dates),
  KEY id_semester (id_semesters)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE seminar_classes_dates (
  id_seminar_classes_dates int(11) unsigned NOT NULL auto_increment,
  id_classes int(10) unsigned NOT NULL default '0',
  num_seminar int(1) NOT NULL default '0',
  south_date datetime default '0000-00-00 00:00:00',
  south_time_start time default '00:00:00',
  south_time_end time default '00:00:00',
  northeast_date datetime default '0000-00-00 00:00:00',
  northeast_time_start time default '00:00:00',
  northeast_time_end time default '00:00:00',
  northwest_date datetime default '0000-00-00 00:00:00',
  northwest_time_start time default '00:00:00',
  northwest_time_end time default '00:00:00',
  southeast_date datetime default '0000-00-00 00:00:00',
  southeast_time_start time default '00:00:00',
  southeast_time_end time default '00:00:00',
  entry_status int(1) NOT NULL default '0',
  note text,
  PRIMARY KEY  (id_seminar_classes_dates),
  KEY id_classes (id_classes)
) TYPE=MyISAM;
campusdelimeter;
$installTableSchemas[] = $table;

?>