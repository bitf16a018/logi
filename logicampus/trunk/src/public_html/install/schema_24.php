<?
$installTableSchemas = array();
$table = <<<campusdelimeter
CREATE TABLE profile_faculty (
  username varchar(32) NOT NULL default '0',
  emergencyContact varchar(50) default NULL,
  emergencyPhone varchar(18) default NULL,
  title varchar(5) default NULL,
  degree text,
  jobtitle varchar(255) default NULL,
  officeLocation varchar(70) default NULL,
  campusLocation varchar(10) default NULL,
  relevantExp text,
  officePhone varchar(18) default NULL,
  offHrsMonday varchar(255) default NULL,
  offHrsTuesday varchar(255) default NULL,
  offHrsWednesday varchar(255) default NULL,
  offHrsThursday varchar(255) default NULL,
  offHrsFriday varchar(255) default NULL,
  PRIMARY KEY  (username),
  UNIQUE KEY username (username)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE profile_student (
  username varchar(32) NOT NULL default '0',
  operatingSystem varchar(50) default NULL,
  connectType varchar(100) default NULL,
  isp varchar(100) default NULL,
  PRIMARY KEY  (username),
  UNIQUE KEY username (username)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE photos (
  pkey int(11) NOT NULL auto_increment,
  filename varchar(60) NOT NULL default '',
  thumbname varchar(60) NOT NULL default '',
  width smallint(5) unsigned NOT NULL default '0',
  height smallint(5) unsigned NOT NULL default '0',
  t_width smallint(5) unsigned NOT NULL default '0',
  t_height smallint(5) unsigned NOT NULL default '0',
  catID int(11) NOT NULL default '0',
  caption varchar(255) NOT NULL default '',
  count int(11) NOT NULL default '0',
  PRIMARY KEY  (pkey),
  UNIQUE KEY filename (filename),
  KEY catID (catID)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE profile_faculty_coursefamily (
  username varchar(32) NOT NULL default '',
  id_profile_faculty_coursefamily varchar(4) NOT NULL default ''
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE userPhotos (
  pkey int(11) NOT NULL auto_increment,
  username varchar(32) NOT NULL default '',
  filename varchar(60) NOT NULL default '',
  thumbname varchar(60) NOT NULL default '',
  width smallint(5) unsigned NOT NULL default '0',
  height smallint(5) unsigned NOT NULL default '0',
  t_width smallint(5) unsigned NOT NULL default '0',
  t_height smallint(5) unsigned NOT NULL default '0',
  caption varchar(255) NOT NULL default '',
  count int(11) NOT NULL default '0',
  PRIMARY KEY  (pkey),
  UNIQUE KEY filename (filename)
) TYPE=MyISAM;
campusdelimeter;
$installTableSchemas[] = $table;

?>