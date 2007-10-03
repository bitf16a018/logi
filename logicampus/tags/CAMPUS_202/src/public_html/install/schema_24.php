<?
$installTableSchemas = array();
$table = <<<campusdelimeter
CREATE TABLE textbook (
  id_textbook int(11) unsigned NOT NULL auto_increment,
  id_classes int(10) unsigned NOT NULL default '0',
  south_campus int(1) default '0',
  southeast_campus int(1) default '0',
  northeast_campus int(1) default '0',
  northwest_campus int(1) default '0',
  noTextbooks tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (id_textbook),
  UNIQUE KEY id_classes (id_classes),
  KEY id_classes_2 (id_classes)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE textbook_classes (
  id_textbook_classes int(11) unsigned NOT NULL auto_increment,
  id_classes bigint(11) unsigned NOT NULL default '0',
  author varchar(100) NOT NULL default '',
  title varchar(255) NOT NULL default '',
  publisher varchar(255) NOT NULL default '',
  edition varchar(255) default NULL,
  copyright year(4) default NULL,
  isbn varchar(25) NOT NULL default '',
  required int(1) default '0',
  bundled int(1) default '0',
  bundled_items text,
  type varchar(25) NOT NULL default '',
  status tinyint(1) NOT NULL default '1',
  note text,
  PRIMARY KEY  (id_textbook_classes),
  KEY id_classes (id_classes)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE textbook_estimates (
  textbook_estimates_key int(11) NOT NULL auto_increment,
  textbook_estimates_name varchar(30) NOT NULL default '',
  PRIMARY KEY  (textbook_estimates_key)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE textbook_estimates_data (
  textbook_estimates_data_key int(11) NOT NULL auto_increment,
  textbook_estimates_key int(11) NOT NULL default '0',
  id_original_textbook_classes int(10) unsigned NOT NULL default '0',
  bundled tinyint(4) NOT NULL default '0',
  courseFamily varchar(20) NOT NULL default '',
  courseNumber varchar(10) NOT NULL default '',
  isbn varchar(50) NOT NULL default '',
  edition varchar(50) NOT NULL default '',
  title varchar(100) NOT NULL default '',
  author varchar(100) NOT NULL default '',
  type varchar(20) NOT NULL default '',
  se int(11) NOT NULL default '0',
  so int(11) NOT NULL default '0',
  nw int(11) NOT NULL default '0',
  ne int(11) NOT NULL default '0',
  note text NOT NULL,
  instructor varchar(100) NOT NULL default '',
  PRIMARY KEY  (textbook_estimates_data_key)
) TYPE=MyISAM;
campusdelimeter;
$installTableSchemas[] = $table;

?>