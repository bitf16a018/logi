<?
$installTableSchemas = array();
$table = <<<campusdelimeter
CREATE TABLE class_announcements (
  id_class_announcements int(10) unsigned NOT NULL auto_increment,
  id_classes int(10) unsigned NOT NULL default '0',
  dt_display datetime NOT NULL default '0000-00-00 00:00:00',
  tx_title varchar(255) NOT NULL default '',
  tx_description text NOT NULL,
  id_faculty_createdby varchar(50) NOT NULL default '0',
  dt_created datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (id_class_announcements),
  KEY class_date (id_classes,dt_created)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE class_assignments (
  id_class_assignments int(1) unsigned NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  instructions text NOT NULL,
  dueDate int(11) unsigned NOT NULL default '0',
  noDueDate tinyint(1) NOT NULL default '0',
  activeDate int(11) unsigned NOT NULL default '0',
  responseType tinyint(3) unsigned NOT NULL default '0',
  id_classes int(10) unsigned NOT NULL default '0',
  dateNoAccept datetime NOT NULL default '0000-00-00 00:00:00',
  id_forum int(10) unsigned NOT NULL default '0',
  id_forum_thread int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id_class_assignments),
  KEY id_classes (id_classes),
  KEY activeDate (activeDate),
  KEY class_date (id_classes,activeDate)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE class_assignments_grades (
  id_class_assignments_grades int(10) unsigned NOT NULL auto_increment,
  id_class_assignments int(10) unsigned NOT NULL default '0',
  id_student varchar(32) NOT NULL default '',
  comments text NOT NULL,
  grade float(10,2) default NULL,
  PRIMARY KEY  (id_class_assignments_grades),
  KEY id_class_assignments (id_class_assignments)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE class_assignments_link (
  id_class_lessons int(11) unsigned NOT NULL default '0',
  id_class_assignments int(11) unsigned NOT NULL default '0',
  KEY id_class_lessons (id_class_lessons),
  KEY id_class_assignments (id_class_assignments)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE class_assignments_turnin (
  id_class_assignments_turnin int(10) unsigned NOT NULL auto_increment,
  id_class_assignments int(10) unsigned NOT NULL default '0',
  id_student varchar(32) NOT NULL default '',
  dateTurnin datetime NOT NULL default '0000-00-00 00:00:00',
  assign_type int(10) unsigned NOT NULL default '0',
  assign_text longtext NOT NULL,
  assign_file_mime varchar(32) NOT NULL default '',
  assign_file_name varchar(50) NOT NULL default '',
  assign_file_size int(11) NOT NULL default '0',
  assign_file_blob longblob NOT NULL,
  PRIMARY KEY  (id_class_assignments_turnin),
  KEY id_class_assignments (id_class_assignments)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE class_faqs (
  id_class_faqs int(11) unsigned NOT NULL auto_increment,
  id_classes int(10) unsigned NOT NULL default '0',
  category varchar(50) NOT NULL default '',
  question varchar(200) NOT NULL default '',
  answer text NOT NULL,
  clicks int(11) NOT NULL default '0',
  groups text NOT NULL,
  PRIMARY KEY  (id_class_faqs),
  KEY id_class (id_classes)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE class_lesson_content (
  id_class_lesson_content int(10) unsigned NOT NULL auto_increment,
  id_classes int(10) unsigned NOT NULL default '0',
  id_class_lessons int(10) unsigned default NULL,
  txTitle varchar(255) NOT NULL default '',
  txText longtext NOT NULL,
  dateCreated date NOT NULL default '0000-00-00',
  PRIMARY KEY  (id_class_lesson_content),
  KEY id_class_lessons (id_class_lessons),
  KEY id_classes (id_classes)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE class_lesson_links (
  id_class_lessons int(11) default NULL,
  id_class_links int(11) default NULL,
  KEY id_class_lessons (id_class_lessons),
  KEY id_class_links (id_class_links)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE class_lesson_objectives (
  id_class_objectives int(11) NOT NULL default '0',
  id_class_lesson int(11) NOT NULL default '0',
  KEY id_class_lesson (id_class_lesson),
  KEY ic_class_objectives (id_class_objectives)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `class_lessons` (
        `id_class_lessons` integer (11) NOT NULL auto_increment,  --
        `id_classes` integer (10),  --
        `createdOn` integer (11),  --
        `title` varchar (255),  --
        `description` TEXT,  --
        `activeOn` integer (11),  --
        `inactiveOn` integer (11),  --
        `checkList` TEXT,  --
        PRIMARY KEY (id_class_lessons)
)TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX id_classes ON class_lessons (id_classes)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE class_links (
  id_class_links int(11) unsigned NOT NULL auto_increment,
  id_classes int(11) unsigned NOT NULL default '0',
  id_class_links_categories int(11) unsigned NOT NULL default '0',
  title varchar(100) NOT NULL default '',
  url varchar(100) NOT NULL default '',
  description text NOT NULL,
  dateCreated datetime default NULL,
  createdby varchar(32) NOT NULL default '',
  hits int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (id_class_links),
  KEY id_classes (id_classes),
  KEY id_class_links_categories (id_class_links_categories)
) TYPE=MyISAM PACK_KEYS=0
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE class_links_categories (
  id_class_links_categories int(11) unsigned NOT NULL auto_increment,
  id_class_links_categories_parent int(11) unsigned NOT NULL default '0',
  id_classes int(10) unsigned NOT NULL default '0',
  txTitle varchar(50) NOT NULL default '',
  sortOrder int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id_class_links_categories),
  KEY parentKey (id_class_links_categories_parent)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE class_objectives (
  id_class_objectives int(11) unsigned NOT NULL auto_increment,
  id_classes int(10) unsigned NOT NULL default '0',
  objective text NOT NULL,
  f_hide int(10) unsigned NOT NULL default '0',
  i_sort int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id_class_objectives),
  KEY f_hide (f_hide),
  KEY id_classes (id_classes)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE class_presentations (
  id_presentations int(11) NOT NULL auto_increment,
  id_classes int(11) default NULL,
  title varchar(255) default NULL,
  lesson int(11) default NULL,
  status tinyint(1) default NULL,
  author varchar(32) default NULL,
  createdOn datetime default NULL,
  approvedOn datetime default NULL,
  content text,
  PRIMARY KEY  (id_presentations),
  KEY id_classes (id_classes)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE class_syllabuses (
  id_class_syllabuses int(11) unsigned NOT NULL auto_increment,
  id_classes int(11) NOT NULL default '0',
  other text NOT NULL,
  courseObjectives text NOT NULL,
  courseReqs text NOT NULL,
  gradingScale text NOT NULL,
  instructionMethods text NOT NULL,
  emailPolicy text NOT NULL,
  noExam text NOT NULL,
  PRIMARY KEY  (id_class_syllabuses),
  UNIQUE KEY id_classes (id_classes)
) TYPE=MyISAM PACK_KEYS=0
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE classdoclib_Files (
  pkey int(11) NOT NULL auto_increment,
  daHasha varchar(32) NOT NULL default '',
  file varchar(100) NOT NULL default '',
  displayname varchar(255) NOT NULL default '',
  description varchar(255) NOT NULL default '',
  mime varchar(100) NOT NULL default '',
  folder int(10) unsigned NOT NULL default '0',
  owner varchar(32) NOT NULL default '',
  filedate datetime NOT NULL default '0000-00-00 00:00:00',
  size int(11) NOT NULL default '0',
  diskName varchar(32) NOT NULL default '',
  trashed char(1) NOT NULL default '',
  origfolder int(11) NOT NULL default '0',
  PRIMARY KEY  (pkey)
) TYPE=MyISAM AUTO_INCREMENT=13807
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE classdoclib_Folders (
  pkey int(10) unsigned NOT NULL auto_increment,
  name varchar(255) NOT NULL default '',
  parentKey int(10) unsigned NOT NULL default '0',
  owner varchar(32) NOT NULL default '',
  class_id int(10) unsigned NOT NULL default '0',
  notes text NOT NULL,
  trashed char(1) NOT NULL default '',
  origparent int(11) NOT NULL default '0',
  folderType int(11) NOT NULL default '0',
  PRIMARY KEY  (pkey),
  KEY class_id (class_id,owner)
) TYPE=MyISAM AUTO_INCREMENT=2526
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE classdoclib_Sharing (
  folderKey int(10) unsigned NOT NULL default '0',
  action int(10) unsigned NOT NULL default '0',
  exclude int(10) unsigned NOT NULL default '0',
  gid varchar(15) NOT NULL default '',
  PRIMARY KEY  (folderKey,action,exclude,gid)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE classdoclib_Trash (
  pkey int(11) NOT NULL default '0',
  owner varchar(32) NOT NULL default '',
  class_id int(11) NOT NULL default '0',
  name varchar(255) NOT NULL default '',
  data blob NOT NULL,
  KEY owner (owner),
  KEY class_id (class_id)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `class_group` (
  `class_group_id` int(10) unsigned NOT NULL auto_increment,
  `class_group_name` varchar(100) NOT NULL default '',
  `class_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`class_group_id`),
  KEY class_id (class_id)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `class_group_member` (
  `class_group_member_id` int(10) unsigned NOT NULL auto_increment,
  `class_group_id` int(11) NOT NULL default '0',
  `student_id` varchar(32) NOT NULL default '0',
  PRIMARY KEY  (`class_group_member_id`)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;

?>
