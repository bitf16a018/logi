<?
$installTableSchemas = array();
$table = <<<campusdelimeter
CREATE TABLE lcCategories (
  pkey int(11) NOT NULL auto_increment,
  system varchar(15) NOT NULL default '',
  name varchar(50) NOT NULL default '',
  parentKey int(11) NOT NULL default '0',
  notes text,
  sortorder tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (pkey),
  KEY parentKey (parentKey)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE lcConfig (
  mid varchar(32) NOT NULL default '',
  k varchar(60) NOT NULL default '',
  v text NOT NULL,
  type varchar(12) NOT NULL default '',
  extra text NOT NULL
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE lcConfigUser (
  userPkey varchar(32) NOT NULL default '',
  module varchar(32) NOT NULL default '',
  config text NOT NULL,
  PRIMARY KEY  (userPkey,module)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE lcEvents (
  pkey int(11) NOT NULL auto_increment,
  calendarID varchar(15) NOT NULL default '',
  calendarType varchar(64) NOT NULL default '',
  username varchar(15) NOT NULL default '',
  title varchar(255) NOT NULL default '',
  description text NOT NULL,
  location varchar(255) NOT NULL default '',
  startdate int(11) NOT NULL default '0',
  enddate int(11) NOT NULL default '0',
  groups text NOT NULL,
  notgroups text NOT NULL,
  lastmodified timestamp(14) NOT NULL,
  repeatType int(11) NOT NULL default '0',
  repeatCount int(11) NOT NULL default '0',
  repeatData text NOT NULL,
  repeatExclude text NOT NULL,
  repeatUntil int(11) NOT NULL default '0',
  id_item int(10) unsigned NOT NULL default '0',
  id_item_sub int(10) unsigned NOT NULL default '0',
  id_classes int(10) unsigned NOT NULL default '0',
  f_allday int(10) unsigned NOT NULL default '0',
  f_showwhenactive int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (pkey),
  KEY id_classes (id_classes)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE lcFaqs (
  pkey int(11) NOT NULL auto_increment,
  category varchar(50) NOT NULL default '',
  question varchar(200) NOT NULL default '',
  answer text NOT NULL,
  clicks int(11) NOT NULL default '0',
  groups text NOT NULL,
  priority tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (pkey)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE lcFiles (
  pkey int(11) NOT NULL auto_increment,
  file varchar(100) NOT NULL default '',
  displayname varchar(255) NOT NULL default '',
  description varchar(255) NOT NULL default '',
  mime varchar(100) NOT NULL default '',
  filename varchar(100) NOT NULL default '',
  folder int(10) unsigned NOT NULL default '0',
  owner varchar(32) NOT NULL default '',
  filedate datetime NOT NULL default '0000-00-00 00:00:00',
  size int(11) NOT NULL default '0',
  PRIMARY KEY  (pkey)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE lcFormInfo (
  pkey int(11) unsigned NOT NULL auto_increment,
  formCode varchar(20) NOT NULL default '',
  name varchar(75) NOT NULL default '',
  description text NOT NULL,
  action varchar(100) NOT NULL default '',
  method varchar(4) NOT NULL default '',
  target varchar(25) NOT NULL default '',
  enctype varchar(50) NOT NULL default '',
  border int(2) NOT NULL default '0',
  cellpadding int(3) NOT NULL default '0',
  cellspacing int(3) NOT NULL default '0',
  width varchar(4) NOT NULL default '',
  groups text NOT NULL,
  notgroups text NOT NULL,
  type varchar(25) NOT NULL default '',
  PRIMARY KEY  (pkey),
  UNIQUE KEY formCode (formCode),
  UNIQUE KEY name (name)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE lcForms (
  pkey int(11) unsigned NOT NULL auto_increment,
  formId int(11) unsigned NOT NULL default '0',
  type varchar(50) NOT NULL default '',
  fieldName varchar(50) NOT NULL default '',
  displayName varchar(255) NOT NULL default '',
  defaultValue text NOT NULL,
  exp text NOT NULL,
  validationType varchar(50) NOT NULL default '',
  message text NOT NULL,
  stripTags char(1) NOT NULL default '',
  allowedTags varchar(255) NOT NULL default '',
  min int(3) NOT NULL default '0',
  max int(3) NOT NULL default '0',
  req char(1) NOT NULL default '',
  sort int(11) NOT NULL default '0',
  size int(11) NOT NULL default '0',
  maxlength int(11) NOT NULL default '0',
  selectOptions text NOT NULL,
  checked char(1) NOT NULL default '',
  multiple char(1) NOT NULL default '',
  useValue char(1) NOT NULL default '',
  cols int(11) NOT NULL default '0',
  rows int(11) NOT NULL default '0',
  image varchar(100) NOT NULL default '',
  parentPkey int(11) NOT NULL default '0',
  rowStyle varchar(35) NOT NULL default '',
  groups text NOT NULL,
  notgroups text NOT NULL,
  row int(11) NOT NULL default '0',
  startYear char(3) NOT NULL default '',
  endYear char(3) NOT NULL default '',
  dateTimeBit char(2) NOT NULL default '',
  extra varchar(255) NOT NULL default '',
  PRIMARY KEY  (pkey),
  KEY formId (formId),
  KEY pkey (pkey)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE lcGroups (
  pkey int(11) NOT NULL auto_increment,
  gid varchar(10) NOT NULL default '0',
  groupName varchar(30) NOT NULL default '',
  created int(11) NOT NULL default '0',
  KEY pkey (pkey,gid)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE lcHtml (
  pkey int(11) NOT NULL auto_increment,
  filename varchar(50) NOT NULL default '',
  title varchar(85) NOT NULL default '',
  author varchar(50) NOT NULL default '',
  keywords text NOT NULL,
  description text NOT NULL,
  other text NOT NULL,
  updated int(11) NOT NULL default '0',
  groups text NOT NULL,
  notgroups text NOT NULL,
  PRIMARY KEY  (pkey),
  KEY pkey (pkey)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE lcLogging (
  pkey int(11) NOT NULL auto_increment,
  user varchar(30) NOT NULL default '0',
  ip varchar(24) NOT NULL default '',
  moduleName varchar(50) NOT NULL default '',
  serviceName varchar(50) NOT NULL default '',
  accesstime timestamp(14) NOT NULL,
  refer text NOT NULL,
  sesskey varchar(32) NOT NULL default '',
  exectime float NOT NULL default '0',
  output longtext NOT NULL,
  PRIMARY KEY  (pkey),
  KEY pkey (pkey)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE lcNotes (
  pkey int(11) NOT NULL auto_increment,
  userinit char(3) NOT NULL default '',
  page varchar(100) NOT NULL default '',
  comments text NOT NULL,
  timedate int(11) NOT NULL default '0',
  hide tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (pkey),
  KEY pkey (pkey)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE lcPerms (
  groupID varchar(10) NOT NULL default '',
  moduleID varchar(32) NOT NULL default '',
  action varchar(20) NOT NULL default ''
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE lcRegistry (
  mid varchar(32) NOT NULL default '',
  moduleName varchar(40) NOT NULL default '',
  displayName varchar(50) NOT NULL default '',
  author varchar(100) NOT NULL default '',
  copyright varchar(30) NOT NULL default '',
  perms text NOT NULL,
  lastModified datetime default NULL,
  showInMenu tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (mid)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE lcSearch (
  mkey int(11) NOT NULL default '0',
  modID varchar(32) NOT NULL default '',
  title varchar(100) NOT NULL default '',
  type varchar(50) NOT NULL default '',
  link varchar(100) NOT NULL default '',
  groups text NOT NULL,
  notgroups text NOT NULL,
  searchdata mediumtext NOT NULL,
  PRIMARY KEY  (mkey,modID),
  FULLTEXT KEY data (searchdata)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE lcSessionTrack (
  pkey int(11) unsigned NOT NULL auto_increment,
  username varchar(32) NOT NULL default '',
  time int(11) NOT NULL default '0',
  sessionKey varchar(32) NOT NULL default '',
  lcSystem text NOT NULL,
  screen text NOT NULL,
  PRIMARY KEY  (pkey),
  KEY time (time,sessionKey)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE lcSessions (
  sesskey varchar(32) NOT NULL default '',
  gc timestamp(14) NOT NULL,
  sessdata longtext,
  username varchar(50) default NULL,
  PRIMARY KEY  (sesskey),
  UNIQUE KEY username (username),
  KEY gc (gc)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE lcUsers (
  pkey int(11) NOT NULL auto_increment,
  username varchar(32) NOT NULL default '',
  password varchar(32) NOT NULL default '',
  email varchar(50) NOT NULL default '',
  groups varchar(255) NOT NULL default '',
  createdOn datetime NOT NULL default '0000-00-00 00:00:00',
  userType int(11) NOT NULL default '0',
  PRIMARY KEY  (pkey),
  UNIQUE KEY email (email),
  UNIQUE KEY username (username),
  KEY uid (username)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE searchCache (
  username varchar(15) NOT NULL default '',
  text varchar(255) NOT NULL default '',
  timestamp int(11) NOT NULL default '0'
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE profile (
  username varchar(32) NOT NULL default '0',
  firstname varchar(30) NOT NULL default '',
  lastname varchar(30) NOT NULL default '',
  emailAlternate varchar(50) NOT NULL default '',
  homePhone varchar(17) NOT NULL default '',
  workPhone varchar(17) NOT NULL default '',
  faxPhone varchar(17) NOT NULL default '',
  cellPhone varchar(17) NOT NULL default '',
  pagerPhone varchar(17) NOT NULL default '',
  address varchar(70) NOT NULL default '',
  address2 varchar(70) NOT NULL default '',
  city varchar(50) NOT NULL default '',
  state char(2) NOT NULL default '',
  zip varchar(10) NOT NULL default '',
  showaddinfo char(1) NOT NULL default 'N',
  url varchar(100) NOT NULL default '',
  icq varchar(20) NOT NULL default '',
  aim varchar(20) NOT NULL default '',
  yim varchar(30) NOT NULL default '',
  msn varchar(50) NOT NULL default '',
  showonlineinfo char(1) NOT NULL default 'N',
  occupation varchar(50) NOT NULL default '',
  gender varchar(6) NOT NULL default '',
  sig text NOT NULL,
  bio text NOT NULL,
  showbioinfo char(1) NOT NULL default 'N',
  counter int(11) NOT NULL default '0',
  emailNotify char(1) NOT NULL default 'Y',
  photo varchar(50) NOT NULL default '',
  PRIMARY KEY  (username),
  UNIQUE KEY username (username)
) TYPE=MyISAM;
campusdelimeter;
$installTableSchemas[] = $table;

?>