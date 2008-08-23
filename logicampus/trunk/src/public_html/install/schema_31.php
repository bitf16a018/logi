<?
$installTableSchemas = array();
$table = <<<campusdelimeter
CREATE TABLE lc_users_last_login (
  username varchar(32) NOT NULL default '',
  last_login int(11) NOT NULL default '0',
  PRIMARY KEY  (username)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE lc_users_login_attempt (
  username varchar(32) default '',
  login_attempt int(11) default '0',
  login_status tinyint(1) default '0',
  os varchar(10) default '',
  browser varchar(10) default '',
  version varchar(10) default '',
  KEY username (username)
) TYPE=MyISAM;
campusdelimeter;
$installTableSchemas[] = $table;

?>