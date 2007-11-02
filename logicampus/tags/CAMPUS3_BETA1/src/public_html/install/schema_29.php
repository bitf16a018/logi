<?
$installTableSchemas = array();
$table = <<<campusdelimeter
CREATE TABLE menu (
  pkey int(11) NOT NULL auto_increment,
  title varchar(60) NOT NULL default '',
  layout varchar(15) NOT NULL default '0',
  rank int(11) NOT NULL default '0',
  groups text NOT NULL,
  notgroups text NOT NULL,
  menuid varchar(50) NOT NULL default '',
  PRIMARY KEY  (pkey),
  KEY menuid (menuid)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO menu VALUES (1, 'Main Menu', 'vertical', 2, '|public|reg|', '||', 'main')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO menu VALUES (5, 'Administration', 'vertical', 0, '|admin|', '||', 'administration')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO menu VALUES (4, 'Member Services', 'vertical', 0, '|reg|', '||', 'memberservices')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE menuCache (
  pkey int(11) NOT NULL default '0',
  menuObj text NOT NULL,
  menuid varchar(20) NOT NULL default '',
  rank int(11) NOT NULL default '0',
  groups text NOT NULL,
  notgroups text NOT NULL,
  PRIMARY KEY  (pkey),
  KEY menuid (menuid)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO menuCache VALUES (1, 'O:7:"menuobj":12:{s:5:"title";s:9:"Main Menu";s:6:"menuid";s:4:"main";s:6:"layout";s:8:"vertical";s:8:"VERTICAL";i:0;s:10:"HORIZONTAL";i:1;s:6:"CUSTOM";i:2;s:8:"treeList";O:8:"treelist":8:{s:13:"p_CurrentNode";O:12:"treelistnode":5:{s:7:"sibling";i:0;s:5:"child";i:0;s:6:"parent";N;s:8:"expanded";N;s:8:"contents";s:6:"_blank";}s:5:"stack";a:0:{}s:6:"indent";N;s:8:"rootNode";O:12:"treelistnode":6:{s:7:"sibling";O:12:"treelistnode":6:{s:7:"sibling";O:12:"treelistnode":6:{s:7:"sibling";i:0;s:5:"child";i:0;s:6:"parent";N;s:8:"expanded";N;s:8:"contents";O:11:"appmenuitem":19:{s:4:"type";s:3:"app";s:8:"location";s:3:"faq";s:8:"linkText";s:4:"FAQs";s:8:"editPage";s:14:"itemEditor_app";s:5:"mpkey";s:1:"1";s:6:"menuid";s:4:"main";s:5:"title";s:9:"Main Menu";s:6:"layout";s:8:"vertical";s:7:"mgroups";s:12:"|public|reg|";s:10:"mnotgroups";s:2:"||";s:5:"mrank";s:1:"2";s:4:"pkey";s:1:"3";s:6:"menuID";s:1:"1";s:4:"rank";s:1:"3";s:5:"imgOn";s:0:"";s:6:"imgOff";s:0:"";s:8:"parentID";s:1:"0";s:6:"groups";s:0:"";s:9:"appOption";s:0:"";}s:6:"indent";N;}s:5:"child";i:0;s:6:"parent";N;s:8:"expanded";N;s:8:"contents";O:11:"appmenuitem":19:{s:4:"type";s:3:"app";s:8:"location";s:6:"search";s:8:"linkText";s:6:"Search";s:8:"editPage";s:14:"itemEditor_app";s:5:"mpkey";s:1:"1";s:6:"menuid";s:4:"main";s:5:"title";s:9:"Main Menu";s:6:"layout";s:8:"vertical";s:7:"mgroups";s:12:"|public|reg|";s:10:"mnotgroups";s:2:"||";s:5:"mrank";s:1:"2";s:4:"pkey";s:2:"28";s:6:"menuID";s:1:"1";s:4:"rank";s:1:"0";s:5:"imgOn";s:0:"";s:6:"imgOff";s:0:"";s:8:"parentID";s:1:"0";s:6:"groups";s:0:"";s:9:"appOption";s:0:"";}s:6:"indent";N;}s:5:"child";i:0;s:6:"parent";N;s:8:"expanded";N;s:8:"contents";O:11:"appmenuitem":19:{s:4:"type";s:3:"app";s:8:"location";s:7:"welcome";s:8:"linkText";s:4:"Home";s:8:"editPage";s:14:"itemEditor_app";s:5:"mpkey";s:1:"1";s:6:"menuid";s:4:"main";s:5:"title";s:9:"Main Menu";s:6:"layout";s:8:"vertical";s:7:"mgroups";s:12:"|public|reg|";s:10:"mnotgroups";s:2:"||";s:5:"mrank";s:1:"2";s:4:"pkey";s:2:"26";s:6:"menuID";s:1:"1";s:4:"rank";s:1:"0";s:5:"imgOn";s:0:"";s:6:"imgOff";s:0:"";s:8:"parentID";s:1:"0";s:6:"groups";s:0:"";s:9:"appOption";s:0:"";}s:4:"root";i:1;}s:15:"defaultExpanded";b:1;s:5:"count";i:2;s:7:"keyName";s:4:"pkey";s:13:"keyParentName";s:9:"parentKey";}s:4:"pkey";s:1:"1";s:9:"linkCount";i:3;s:4:"rank";s:1:"2";s:6:"groups";a:2:{i:0;s:6:"public";i:1;s:3:"reg";}s:9:"notgroups";a:1:{i:0;s:0:"";}}', 'main', 2, '|public|reg|', '||')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO menuCache VALUES (5, 'O:7:"menuobj":12:{s:5:"title";s:14:"Administration";s:6:"menuid";s:14:"administration";s:6:"layout";s:8:"vertical";s:8:"VERTICAL";i:0;s:10:"HORIZONTAL";i:1;s:6:"CUSTOM";i:2;s:8:"treeList";O:8:"treelist":8:{s:13:"p_CurrentNode";O:12:"treelistnode":5:{s:7:"sibling";i:0;s:5:"child";i:0;s:6:"parent";N;s:8:"expanded";N;s:8:"contents";s:6:"_blank";}s:5:"stack";a:0:{}s:6:"indent";N;s:8:"rootNode";O:12:"treelistnode":6:{s:7:"sibling";O:12:"treelistnode":6:{s:7:"sibling";O:12:"treelistnode":6:{s:7:"sibling";O:12:"treelistnode":6:{s:7:"sibling";i:0;s:5:"child";i:0;s:6:"parent";N;s:8:"expanded";N;s:8:"contents";O:11:"appmenuitem":19:{s:4:"type";s:3:"app";s:8:"location";s:14:"administration";s:8:"linkText";s:12:"Manage Users";s:8:"editPage";s:14:"itemEditor_app";s:5:"mpkey";s:1:"5";s:6:"menuid";s:14:"administration";s:5:"title";s:14:"Administration";s:6:"layout";s:8:"vertical";s:7:"mgroups";s:7:"|admin|";s:10:"mnotgroups";s:2:"||";s:5:"mrank";s:1:"0";s:4:"pkey";s:2:"51";s:6:"menuID";s:1:"5";s:4:"rank";s:1:"2";s:5:"imgOn";s:0:"";s:6:"imgOff";s:0:"";s:8:"parentID";s:1:"0";s:6:"groups";s:0:"";s:9:"appOption";s:5:"users";}s:6:"indent";N;}s:5:"child";i:0;s:6:"parent";N;s:8:"expanded";N;s:8:"contents";O:11:"appmenuitem":19:{s:4:"type";s:3:"app";s:8:"location";s:14:"administration";s:8:"linkText";s:14:"Manage Classes";s:8:"editPage";s:14:"itemEditor_app";s:5:"mpkey";s:1:"5";s:6:"menuid";s:14:"administration";s:5:"title";s:14:"Administration";s:6:"layout";s:8:"vertical";s:7:"mgroups";s:7:"|admin|";s:10:"mnotgroups";s:2:"||";s:5:"mrank";s:1:"0";s:4:"pkey";s:2:"50";s:6:"menuID";s:1:"5";s:4:"rank";s:1:"1";s:5:"imgOn";s:0:"";s:6:"imgOff";s:0:"";s:8:"parentID";s:1:"0";s:6:"groups";s:0:"";s:9:"appOption";s:7:"classes";}s:6:"indent";N;}s:5:"child";i:0;s:6:"parent";N;s:8:"expanded";N;s:8:"contents";O:11:"appmenuitem":19:{s:4:"type";s:3:"app";s:8:"location";s:14:"administration";s:8:"linkText";s:14:"Manage Courses";s:8:"editPage";s:14:"itemEditor_app";s:5:"mpkey";s:1:"5";s:6:"menuid";s:14:"administration";s:5:"title";s:14:"Administration";s:6:"layout";s:8:"vertical";s:7:"mgroups";s:7:"|admin|";s:10:"mnotgroups";s:2:"||";s:5:"mrank";s:1:"0";s:4:"pkey";s:2:"49";s:6:"menuID";s:1:"5";s:4:"rank";s:1:"0";s:5:"imgOn";s:0:"";s:6:"imgOff";s:0:"";s:8:"parentID";s:1:"0";s:6:"groups";s:0:"";s:9:"appOption";s:7:"courses";}s:6:"indent";N;}s:5:"child";i:0;s:6:"parent";N;s:8:"expanded";N;s:8:"contents";O:11:"appmenuitem":19:{s:4:"type";s:3:"app";s:8:"location";s:14:"administration";s:8:"linkText";s:13:"Control Panel";s:8:"editPage";s:14:"itemEditor_app";s:5:"mpkey";s:1:"5";s:6:"menuid";s:14:"administration";s:5:"title";s:14:"Administration";s:6:"layout";s:8:"vertical";s:7:"mgroups";s:7:"|admin|";s:10:"mnotgroups";s:2:"||";s:5:"mrank";s:1:"0";s:4:"pkey";s:2:"48";s:6:"menuID";s:1:"5";s:4:"rank";s:1:"0";s:5:"imgOn";s:0:"";s:6:"imgOff";s:0:"";s:8:"parentID";s:1:"0";s:6:"groups";s:0:"";s:9:"appOption";s:0:"";}s:4:"root";i:1;}s:15:"defaultExpanded";b:1;s:5:"count";i:3;s:7:"keyName";s:4:"pkey";s:13:"keyParentName";s:9:"parentKey";}s:4:"pkey";s:1:"5";s:9:"linkCount";i:4;s:4:"rank";s:1:"0";s:6:"groups";a:1:{i:0;s:5:"admin";}s:9:"notgroups";a:1:{i:0;s:0:"";}}', 'administration', 0, '|admin|', '||')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO menuCache VALUES (4, 'O:7:"menuobj":12:{s:5:"title";s:15:"Member Services";s:6:"menuid";s:14:"memberservices";s:6:"layout";s:8:"vertical";s:8:"VERTICAL";i:0;s:10:"HORIZONTAL";i:1;s:6:"CUSTOM";i:2;s:8:"treeList";O:8:"treelist":8:{s:13:"p_CurrentNode";O:12:"treelistnode":5:{s:7:"sibling";i:0;s:5:"child";i:0;s:6:"parent";N;s:8:"expanded";N;s:8:"contents";s:6:"_blank";}s:5:"stack";a:0:{}s:6:"indent";N;s:8:"rootNode";O:12:"treelistnode":6:{s:7:"sibling";O:12:"treelistnode":6:{s:7:"sibling";O:12:"treelistnode":6:{s:7:"sibling";O:12:"treelistnode":6:{s:7:"sibling";O:12:"treelistnode":6:{s:7:"sibling";i:0;s:5:"child";i:0;s:6:"parent";N;s:8:"expanded";N;s:8:"contents";O:11:"appmenuitem":19:{s:4:"type";s:3:"app";s:8:"location";s:5:"users";s:8:"linkText";s:12:"Who\'s Online";s:8:"editPage";s:14:"itemEditor_app";s:5:"mpkey";s:1:"4";s:6:"menuid";s:14:"memberservices";s:5:"title";s:15:"Member Services";s:6:"layout";s:8:"vertical";s:7:"mgroups";s:5:"|reg|";s:10:"mnotgroups";s:2:"||";s:5:"mrank";s:1:"0";s:4:"pkey";s:2:"43";s:6:"menuID";s:1:"4";s:4:"rank";s:1:"3";s:5:"imgOn";s:0:"";s:6:"imgOff";s:0:"";s:8:"parentID";s:1:"0";s:6:"groups";s:0:"";s:9:"appOption";s:6:"online";}s:6:"indent";N;}s:5:"child";i:0;s:6:"parent";N;s:8:"expanded";N;s:8:"contents";O:11:"appmenuitem":19:{s:4:"type";s:3:"app";s:8:"location";s:2:"pm";s:8:"linkText";s:16:"Private Messages";s:8:"editPage";s:14:"itemEditor_app";s:5:"mpkey";s:1:"4";s:6:"menuid";s:14:"memberservices";s:5:"title";s:15:"Member Services";s:6:"layout";s:8:"vertical";s:7:"mgroups";s:5:"|reg|";s:10:"mnotgroups";s:2:"||";s:5:"mrank";s:1:"0";s:4:"pkey";s:2:"47";s:6:"menuID";s:1:"4";s:4:"rank";s:1:"2";s:5:"imgOn";s:0:"";s:6:"imgOff";s:0:"";s:8:"parentID";s:1:"0";s:6:"groups";s:0:"";s:9:"appOption";s:0:"";}s:6:"indent";N;}s:5:"child";i:0;s:6:"parent";N;s:8:"expanded";N;s:8:"contents";O:11:"appmenuitem":19:{s:4:"type";s:3:"app";s:8:"location";s:5:"users";s:8:"linkText";s:11:"Online Chat";s:8:"editPage";s:14:"itemEditor_app";s:5:"mpkey";s:1:"4";s:6:"menuid";s:14:"memberservices";s:5:"title";s:15:"Member Services";s:6:"layout";s:8:"vertical";s:7:"mgroups";s:5:"|reg|";s:10:"mnotgroups";s:2:"||";s:5:"mrank";s:1:"0";s:4:"pkey";s:2:"53";s:6:"menuID";s:1:"4";s:4:"rank";s:1:"2";s:5:"imgOn";s:0:"";s:6:"imgOff";s:0:"";s:8:"parentID";s:1:"0";s:6:"groups";s:0:"";s:9:"appOption";s:4:"chat";}s:6:"indent";N;}s:5:"child";i:0;s:6:"parent";N;s:8:"expanded";N;s:8:"contents";O:11:"appmenuitem":19:{s:4:"type";s:3:"app";s:8:"location";s:5:"forum";s:8:"linkText";s:17:"Discussion Forums";s:8:"editPage";s:14:"itemEditor_app";s:5:"mpkey";s:1:"4";s:6:"menuid";s:14:"memberservices";s:5:"title";s:15:"Member Services";s:6:"layout";s:8:"vertical";s:7:"mgroups";s:5:"|reg|";s:10:"mnotgroups";s:2:"||";s:5:"mrank";s:1:"0";s:4:"pkey";s:2:"46";s:6:"menuID";s:1:"4";s:4:"rank";s:1:"1";s:5:"imgOn";s:0:"";s:6:"imgOff";s:0:"";s:8:"parentID";s:1:"0";s:6:"groups";s:0:"";s:9:"appOption";s:0:"";}s:6:"indent";N;}s:5:"child";i:0;s:6:"parent";N;s:8:"expanded";N;s:8:"contents";O:11:"appmenuitem":19:{s:4:"type";s:3:"app";s:8:"location";s:5:"users";s:8:"linkText";s:12:"Edit Profile";s:8:"editPage";s:14:"itemEditor_app";s:5:"mpkey";s:1:"4";s:6:"menuid";s:14:"memberservices";s:5:"title";s:15:"Member Services";s:6:"layout";s:8:"vertical";s:7:"mgroups";s:5:"|reg|";s:10:"mnotgroups";s:2:"||";s:5:"mrank";s:1:"0";s:4:"pkey";s:2:"52";s:6:"menuID";s:1:"4";s:4:"rank";s:1:"0";s:5:"imgOn";s:0:"";s:6:"imgOff";s:0:"";s:8:"parentID";s:1:"0";s:6:"groups";s:0:"";s:9:"appOption";s:11:"editProfile";}s:4:"root";i:1;}s:15:"defaultExpanded";b:1;s:5:"count";i:4;s:7:"keyName";s:4:"pkey";s:13:"keyParentName";s:9:"parentKey";}s:4:"pkey";s:1:"4";s:9:"linkCount";i:5;s:4:"rank";s:1:"0";s:6:"groups";a:1:{i:0;s:3:"reg";}s:9:"notgroups";a:1:{i:0;s:0:"";}}', 'memberservices', 0, '|reg|', '||')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE menuItems (
  pkey int(11) NOT NULL auto_increment,
  menuID int(11) NOT NULL default '0',
  rank tinyint(4) NOT NULL default '0',
  linkText varchar(120) NOT NULL default '',
  imgOn varchar(75) NOT NULL default '',
  imgOff varchar(75) NOT NULL default '',
  location varchar(120) NOT NULL default '',
  type char(3) NOT NULL default '',
  parentID int(11) NOT NULL default '0',
  groups tinytext NOT NULL,
  appOption varchar(50) NOT NULL default '',
  PRIMARY KEY  (pkey)
) TYPE=MyISAM
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO menuItems VALUES (3, 1, 3, 'FAQs', '', '', 'faq', 'app', 0, '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO menuItems VALUES (48, 5, 0, 'Control Panel', '', '', 'administration', 'app', 0, '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO menuItems VALUES (26, 1, 0, 'Home', '', '', 'welcome', 'app', 0, '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO menuItems VALUES (28, 1, 0, 'Search', '', '', 'search', 'app', 0, '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO menuItems VALUES (51, 5, 2, 'Manage Users', '', '', 'administration', 'app', 0, '', 'users')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO menuItems VALUES (50, 5, 1, 'Manage Classes', '', '', 'administration', 'app', 0, '', 'classes')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO menuItems VALUES (49, 5, 0, 'Manage Courses', '', '', 'administration', 'app', 0, '', 'courses')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO menuItems VALUES (43, 4, 3, 'Who\'s Online', '', '', 'users', 'app', 0, '', 'online')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO menuItems VALUES (53, 4, 2, 'Online Chat', '', '', 'users', 'app', 0, '', 'chat')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO menuItems VALUES (46, 4, 1, 'Discussion Forums', '', '', 'forum', 'app', 0, '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO menuItems VALUES (47, 4, 2, 'Private Messages', '', '', 'pm', 'app', 0, '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO menuItems VALUES (52, 4, 0, 'Edit Profile', '', '', 'users', 'app', 0, '', 'editProfile');
campusdelimeter;
$installTableSchemas[] = $table;

?>