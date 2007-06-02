<?
$installTableSchemas = array();
$table = <<<campusdelimeter
CREATE TABLE docs_directories (
  directoryID int(11) unsigned NOT NULL auto_increment,
  parentID int(11) unsigned NOT NULL default '0',
  username varchar(32) NOT NULL default '',
  name varchar(100) NOT NULL default '',
  posted int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (directoryID),
  KEY parentID (parentID),
  KEY username (username),
  KEY posted (posted),
  FULLTEXT KEY name (name)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO docs_directories VALUES (1,0,'root','Home',1068233407)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE docs_directories_files (
  directoryID int(11) unsigned NOT NULL default '0',
  fileID int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (directoryID,fileID)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE docs_directories_groups (
  directoryID int(11) unsigned NOT NULL default '0',
  gid varchar(10) NOT NULL default '',
  PRIMARY KEY  (directoryID,gid)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE docs_files (
  fileID int(11) unsigned NOT NULL auto_increment,
  username varchar(32) NOT NULL default '',
  name varchar(100) NOT NULL default '',
  TYPE varchar(4) NOT NULL default '',
  mime varchar(50) NOT NULL default '',
  title varchar(100) NOT NULL default '',
  abstract varchar(255) NOT NULL default '',
  posted int(11) unsigned NOT NULL default '0',
  hits int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (fileID),
  KEY posted (posted),
  KEY username (username),
  KEY name (name),
  KEY TYPE (TYPE),
  FULLTEXT KEY title (title,abstract)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE docs_files_groups (
  fileID int(11) unsigned NOT NULL default '0',
  gid varchar(10) NOT NULL default '',
  PRIMARY KEY  (fileID,gid)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE docs_filetypes (
  TYPE char(4) NOT NULL default '',
  icon char(50) NOT NULL default '',
  PRIMARY KEY  (TYPE)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO docs_filetypes VALUES ('gif','img.gif')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO docs_filetypes VALUES ('png','img.gif')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO docs_filetypes VALUES ('jpg','img.gif')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO docs_filetypes VALUES ('doc','doc.gif')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO docs_filetypes VALUES ('pdf','pdf.gif')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO docs_filetypes VALUES ('ppt','ppt.gif')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO docs_filetypes VALUES ('mov','mov.gif')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO docs_filetypes VALUES ('mpg','mov.gif')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO docs_filetypes VALUES ('mpeg','mov.gif')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO docs_filetypes VALUES ('avi','mov.gif')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO docs_filetypes VALUES ('html','html.gif')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO docs_filetypes VALUES ('htm','html.gif')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO docs_filetypes VALUES ('xls','xls.gif')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO docs_filetypes VALUES ('mdb','mdb.gif')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO docs_filetypes VALUES ('txt','')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO docs_filetypes VALUES ('rtf','');
campusdelimeter;
$installTableSchemas[] = $table;

?>