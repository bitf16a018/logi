<?
$installTableSchemas = array();
$table = <<<campusdelimeter
CREATE TABLE class_student_sections (
  sectionNumber int(11) NOT NULL default '0',
  id_student varchar(75) NOT NULL default '',
  semester_id int(11) unsigned NOT NULL default '0',
  active tinyint(1) NOT NULL default '0',
  dateWithdrawn date default NULL,
  UNIQUE KEY section_student_semester (sectionNumber,id_student,semester_id),
  KEY id_student (id_student),
  KEY semester_id (semester_id),
  KEY active (active)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE class_sections (
  sectionNumber int(11) NOT NULL default '0',
  id_classes int(11) NOT NULL default '0',
  KEY sectionNumber (sectionNumber),
  KEY id_classes (id_classes)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE class_extra_faculty (
  pkey int(11) NOT NULL auto_increment,
  id_classes int(11) default NULL,
  facultyId varchar(30) default NULL,
  facultyType char(1) default 'e',
  PRIMARY KEY  (pkey)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE classes (
  id_classes int(10) unsigned NOT NULL auto_increment,
  id_courses int(10) unsigned NOT NULL default '0',
  id_semesters int(10) unsigned NOT NULL default '0',
  sectionNumbers text NOT NULL,
  classType varchar(25) NOT NULL default '',
  facultyId varchar(32) NOT NULL default '',
  courseFamily varchar(25) NOT NULL default '',
  courseNumber int(4) unsigned zerofill NOT NULL default '0000',
  courseFamilyNumber varchar(50) NOT NULL default '',
  stylesheet varchar(25) NOT NULL default '',
  id_class_resource int(10) unsigned NOT NULL default '0',
  noexam tinyint(4) default '0',
  PRIMARY KEY  (id_classes)
) TYPE=MyISAM PACK_KEYS=0
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE courses (
  id_courses int(10) unsigned NOT NULL auto_increment,
  courseFamily varchar(25) NOT NULL default '',
  courseNumber int(4) unsigned zerofill NOT NULL default '0000',
  courseName varchar(100) NOT NULL default '',
  courseDescription text NOT NULL,
  preReq1 varchar(100) NOT NULL default '',
  preReq2 varchar(100) NOT NULL default '',
  preReq3 varchar(100) NOT NULL default '',
  preReq4 varchar(100) NOT NULL default '',
  coReq1 varchar(100) NOT NULL default '',
  coReq2 varchar(100) NOT NULL default '',
  coReq3 varchar(100) NOT NULL default '',
  coReq4 varchar(100) NOT NULL default '',
  PRIMARY KEY  (id_courses)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE remote_test_files (
  pkey int(11) NOT NULL auto_increment,
  email varchar(60) NOT NULL default '',
  hash varchar(32) NOT NULL default '',
  FILE varchar(100) NOT NULL default '',
  displayname varchar(255) NOT NULL default '',
  description varchar(255) NOT NULL default '',
  mime varchar(100) NOT NULL default '',
  filedate datetime NOT NULL default '0000-00-00 00:00:00',
  size int(11) NOT NULL default '0',
  clicks int(11) NOT NULL default '0',
  PRIMARY KEY  (pkey)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE semesters (
  id_semesters int(10) unsigned NOT NULL auto_increment,
  semesterId varchar(6) NOT NULL default '',
  semesterTerm varchar(255) NOT NULL default '',
  dateCensus date NOT NULL default '0000-00-00',
  dateFinalDrop datetime NOT NULL default '0000-00-00 00:00:00',
  dateDeactivation date NOT NULL default '0000-00-00',
  dateStart date NOT NULL default '0000-00-00',
  dateEnd date NOT NULL default '0000-00-00',
  dateRegistrationStart date NOT NULL default '0000-00-00',
  dateRegistrationEnd date NOT NULL default '0000-00-00',
  dateAccountActivation datetime NOT NULL default '0000-00-00 00:00:00',
  dateStudentActivation datetime NOT NULL default '0000-00-00 00:00:00',
  semesterYear int(10) unsigned NOT NULL default '0',
  dateStartITVseminar datetime NOT NULL default '0000-00-00 00:00:00',
  dateEndITVseminar datetime NOT NULL default '0000-00-00 00:00:00',
  dateStartOrientation datetime NOT NULL default '0000-00-00 00:00:00',
  dateEndOrientation datetime NOT NULL default '0000-00-00 00:00:00',
  dateStartTextbook datetime NOT NULL default '0000-00-00 00:00:00',
  dateEndTextbook datetime NOT NULL default '0000-00-00 00:00:00',
  dateStartExam datetime NOT NULL default '0000-00-00 00:00:00',
  dateEndExam datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (id_semesters)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE semesters_course_info (
  id_semesters int(10) unsigned NOT NULL default '0',
  campusClosings text,
  lateGuidelines text,
  noChildren text,
  withdrawalPolicy text,
  gradeVerify text,
  examInfo text,
  gradeChallenge text,
  leaseKit text,
  campusViewing text,
  testingLocations text,
  itvGrades text,
  cable text,
  textbooks text,
  helpdesk text,
  syllabusDisclaimer text,
  specialInfo text,
  testHours text,
  accessClassSite text,
  emailGuidelines text,
  studentConduct text,
  PRIMARY KEY  (id_semesters)
) TYPE=MyISAM;
campusdelimeter;
$installTableSchemas[] = $table;

?>