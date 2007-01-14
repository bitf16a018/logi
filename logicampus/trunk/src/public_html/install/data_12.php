<?
$installTableSchemas = array();
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('reg', 'menu', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'menu', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('public', 'menu', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('reg', 'login', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'login', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('public', 'login', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('reg', 'html', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'html', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('public', 'html', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('reg', 'search', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'search', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('public', 'search', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'faq', 'ask')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('reg', 'forum', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'forum', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('public', 'forum', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('reg', 'welcome', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'welcome', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('public', 'welcome', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('reg', 'news', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'news', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('public', 'news', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('reg', 'pm', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('public', 'faq', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'faq', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('reg', 'faq', 'ask')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('reg', 'faq', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('public', 'seminarmgr', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'textbookmgr', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('public', 'classmgr', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('public', 'gradebook', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('public', 'events', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('public', 'classdoclib', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('public', 'classdoclib', 'manager')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('public', 'classroom', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'seminarmgr', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'pm', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'maillist', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'gradebook', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'evt', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'events', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'classdoclib', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'classmgr', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('hdstaff', 'administration', 'users')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('hdadmin', 'administration', 'faculty')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('hdadmin', 'administration', 'users')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('exammgr', 'administration', 'faculty')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('semrmsch', 'administration', 'faculty')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('semmgr', 'administration', 'faculty')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'classroom', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('faculty', 'users', 'online')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('tbsadmin', 'administration', 'faculty')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'users', 'online')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'users', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('reg', 'users', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'mastercalendar', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('reg', 'mastercalendar', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('public', 'mastercalendar', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('tbadmin', 'textbookmgr', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('tbsadmin', 'textbookmgr', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'seminarorientation', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('semmgr', 'seminarorientation', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('semrmsch', 'seminarorientation', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'examschedule', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('exammgr', 'examschedule', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('reg', 'helpdesk', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('public', 'helpdesk', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('tbadmin', 'administration', 'faculty')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'administration', 'cal')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('new', 'faq', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'remotetest', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'doclib', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'administration', 'servicePermissions')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'administration', 'mod')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'administration', 'users')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'administration', 'groups')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'administration', 'semesters')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'administration', 'courses')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'administration', 'classes')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'administration', 'main')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'administration', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('hdstaff', 'administration', 'faculty')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('fadmin', 'administration', 'faculty')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'administration', 'courses')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('dlstaff', 'administration', 'main')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('dlstaff', 'administration', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('dlstaff', 'login', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('dlstaff', 'menu', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('dlstaff', 'classroom', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'administration', 'groups')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'administration', 'servicePermissions')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'administration', 'mod')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'administration', 'enrollment')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'administration', 'semesters')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'administration', 'users')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('dlstaff', 'administration', 'cal')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('dlstaff', 'administration', 'faculty')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('dlstaff', 'banners', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('dlstaff', 'banners', 'view')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('dlstaff', 'classmgr', 'access')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('dlstaff', 'classmgr', 'reg')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('admin', 'administration', 'classes')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('hdadmin', 'administration', 'users')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcPerms VALUES ('hdstaff', 'administration', 'users');
campusdelimeter;
$installTableSchemas[] = $table;

?>