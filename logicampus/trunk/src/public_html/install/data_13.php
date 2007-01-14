<?
$installTableSchemas = array();
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('html', '_ToEmail', 'ENTER THE DEFAULT EMAIL ADDRESS', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('pm', '_displayPerPage', '10', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('pm', '_SystemAdmin', 'zorka', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('html', '_ToEmail', '', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('news', '_useComments', 'Y\r', 'options', 'Y\r\nN')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('news', '_ActiveArticleMessage', '', 'textarea', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('news', '_EmailNewNewsTo', '', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('news', '_FrontPageLimit', '5\r', 'options', '1\r\n2\r\n3\r\n4\r\n5\r\n6\r\n7\r\n8\r\n9\r\n10\r\n11\r\n12\r\n13\r\n14\r\n15\r\n16\r\n17\r\n18\r\n19\r\n20')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('shop', 'PRODUCT_IMG_MAX_WIDTH_THUMB', '100', 'options', '50\r\n75\r\n100\r\n125\r\n150\r\n175\r\n200')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('shop', 'PRODUCT_IMG_MAX_WIDTH', '300', 'options', '100\r\n150\r\n200\r\n250\r\n300\r\n350\r\n400')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('shop', 'PRODUCT_IMG_ALIGN_THUMB', 'center', 'options', 'left\r\nright\r\ncenter')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('shop', 'DEFAULT_GIFT_WRAP_CHARGE', '0', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('shop', 'PRODUCT_IMG_ALIGN', 'center', 'options', 'left\r\nright\r\ncenter')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('shop', 'ADMIN_AUTO_THUMB', 'yes', 'options', 'yes\r\nno')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('forum', '_postsPerPage', '20', 'text', '20')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('forum', '_FromEmail', 'LCForums', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('forum', '_emailPrepend', '', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('login', '_registerThanksURL', 'html/main/registerthanks.html', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('login', '_loginThanksURL', 'html/main/loginthanks.html', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('login', '_allowRegister', 'n', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('photo', 'THUMB_MAX_Y', '150', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('photo', 'THUMB_MAX_X', '100', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('photo', 'THUMB_DIR', 'photos/thumb/', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('photo', 'PHOTO_DIR', 'photos/', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('photo', 'PHOTOS_ROW', '4', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('photo', 'PHOTOS_COL', '4', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('users', '_THUMB_DIR', 'photos/thumb/', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('users', '_PHOTO_DIR', 'photos/', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('users', '_NumberOfUsersPerPage', '20', 'options', '10\r\n20\r\n30\r\n40\r\n50\r\n60\r\n70\r\n80\r\n90\r\n100')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('users', '_DisplayUserInformation', 'Y', 'options', 'Y\r\nN')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('users', '_DisplayPhotoInformation', 'Y', 'options', 'Y\r\nN')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('users', '_DisplayCommentInformation', 'Y', 'options', 'Y\r\nN')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('users', '_DisplayArticleInformation', 'Y', 'options', 'Y\r\nN')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('users', '_AllowedNumOfUserPhotos', '5', 'options', '1\r\n2\r\n3\r\n4\r\n5\r\n6\r\n7\r\n8\r\n9\r\n10')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('maillist', 'emailsPerPage', '5', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('events', '_START_TIME', '8', 'options', '1\r\n2\r\n3\r\n4\r\n5\r\n6\r\n7\r\n8\r\n9\r\n10\r\n11\r\n12\r\n13\r\n14\r\n15\r\n16\r\n17\r\n18\r\n19\r\n20\r\n21\r\n22\r\n23\r\n24')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('events', '_END_TIME', '18', 'options', '1\r\n2\r\n3\r\n4\r\n5\r\n6\r\n7\r\n8\r\n9\r\n10\r\n11\r\n12\r\n13\r\n14\r\n15\r\n16\r\n17\r\n18\r\n19\r\n20\r\n21\r\n22\r\n23\r\n24')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('events', '_emailNotices', 'keith@tapinternet.com', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('search', '_CacheResults', '25', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('search', '_ReturnedResultsPerPage', '10', 'options', '10\r\n20\r\n25\r\n30\r\n35\r\n40\r\n45\r\n50\r\n75\r\n100')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('banners', 'DANGER_CLICK_PERCENT', '10', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('banners', 'DANGER_DAY_NUMBER', '14', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('forum', '_ReplyTo', 'NO REPLY', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('forum', '_allowTags', '<hr><b></b><i></i><em></em>', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('forum', '_ReturnPath', 'webmaster', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('forum', '_wordWrap', '60', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('classmgr', '_postsPerPage', '20', 'text', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('administration', '_serviceFiles', 'classes.lcp=Classes Administration,courses.lcp=Courses Administration,groups.lcp=Group Administration,mod.lcp=Message of the Day,semesters.lcp=Manage Semesters,servicePermissions.lcp=Manage group permissions,users.lcp=User Administration', 'textarea', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('classmgr', '_default_datagrid_num_rows', '', 'options', '5\r\n10\r\n15\r\n20\r\n25\r\n30\r\n35\r\n40\r\n45\r\n50')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('administration', '_servicesAdministration', 'groups=Group Administration,classes=Manage Classes,enrollment=Manage Class Enrollment,courses=Manage Courses,servicePermissions=Manage Group Permissions,mod=Message of the Day,semesters=Manage Semesters,users=Manage Users', 'textarea', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('classroom', '_PortalNumOfLessons', '5', 'options', '5\r\n10\r\n15\r\n20')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('classroom', '_PortalNumOfAssignments', '5', 'options', '5\r\n10\r\n15\r\n20')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('c6b29012536501c29bc35376b773498a', '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcConfig VALUES ('cd27669746cfd1d4dd49cf5f007213ec', '', '', '', '');
campusdelimeter;
$installTableSchemas[] = $table;

?>