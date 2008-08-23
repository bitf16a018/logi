<?
$installTableSchemas = array();
$table = <<<campusdelimeter
CREATE TABLE chat (
  pkey int(11) NOT NULL auto_increment,
  chat_id varchar(50) NOT NULL default '',
  username varchar(25) NOT NULL default '',
  userpkey int(11) NOT NULL default '0',
  usertype int(11) NOT NULL default '0',
  timeint int(11) NOT NULL default '0',
  timedate date NOT NULL default '0000-00-00',
  message text NOT NULL,
  entry_type int(11) default NULL,
  PRIMARY KEY  (pkey),
  KEY pkey (pkey)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE chat_queue (
  pkey int(11) NOT NULL auto_increment,
  username varchar(25) NOT NULL default '',
  userpkey int(11) NOT NULL default '0',
  usertype int(11) NOT NULL default '0',
  timeint int(11) NOT NULL default '0',
  timedate date NOT NULL default '0000-00-00',
  message text NOT NULL,
  PRIMARY KEY  (pkey),
  KEY pkey (pkey)
) TYPE=MyISAM;
campusdelimeter;
$installTableSchemas[] = $table;

?>