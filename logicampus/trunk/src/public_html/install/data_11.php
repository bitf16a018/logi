<?
$installTableSchemas = array();
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (1, 'contactus', 'Contact Us', 'This is the default LogiCreate Contact Us form.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 3, 1, '95%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2, 'addform', 'Add a form', 'This form allows you to add a new form into the form manager.', '', 'POST', '', '', 0, 1, 4, '75%', '|public|reg|', '', 'add')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (3, 'textinput', 'Text Input', 'This form is used to add or modify a text input form field in the control center.', '', 'POST', '', 'application/x-www-form-ur', 0, 0, 0, '75%', '', '', 'text')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (4, 'select', 'Select', 'Used to add select drop downs to a form.', '', 'POST', '', '', 0, 0, 0, '75%', '', '', 'select')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (5, 'textarea', 'Text area', 'Text Area', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '75%', '', '', 'textarea')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (6, 'hidden', 'Hidden Field', 'Hidden form field', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '75%', '', '', 'hidden')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (7, 'submit', 'Submit Button', 'Used to make a submit button.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '75%', '', '', 'submit')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (8, 'row', 'Row', 'This adds a row to your form, it can be used for heading or other information.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '75%', '', '', 'row')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483663, 'userprofile', 'User Profile', 'Multiple purpose user profile form (handles all types of users except faculty)', '', 'POST', '', 'multipart/form-data', 0, 1, 1, '95%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (10, 'fileupload', 'File Upload', 'Allows you to upload files to a web server.', '', 'POST', '', 'multipart/form-data', 0, 0, 0, '95%', '', '', 'file')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (9, 'password', 'Password Field', 'Used to create password fields.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '75%', '', '', 'password')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (29, 'radio', 'Radio button', 'used to create radio buttons', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '95%', '', '', 'radio')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (12, 'check', 'Check box', 'Creates check boxes', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '95%', '', '', 'checkbox')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483661, 'lesson', 'Lesson', 'Lesson form. Basically just ties together several elements.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 3, '', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483662, 'classannouncements', 'Class Announcements Add/Edit', 'Add and edit classroom announcements', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 4, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (200053, 'admincourse', ' Admin - Course', 'Allows an admin to enter and edit a course.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '95%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (100054, 'adminclassinfo', 'Admin - Class Info', 'Allows an admin to create and modify classes (or sections) after semesters and courses are defined.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '95%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (100055, 'createaccount', 'Administration - Create Account', 'Allows site admins to create user accounts.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '75%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (100056, 'gbaddentry', 'Gradebook - Add Entry', 'Allows you to add new entries with the gradebook', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '95%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (100057, 'gboptions', 'Gradebook - Grading Options', 'Settings for the gradebook (percentage or points based grading).', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 2, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (100058, 'gbcolorprefs', 'Gradebook - Color Preferences', 'setups the different colors for the gradebook.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '95%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (100059, 'classmgrexportclass', 'Class Manager - Export Class', 'Allows a faculty member to export the class.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '50%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (200054, 'adminfacultyaccount', 'Administration - Course Family Info', 'Fields that are specific to creating faculty accounts.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '75%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (200055, 'addassignments', 'Assignment Manager - Add', 'Adding an assignment', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 2, 0, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (120005599, 'datedropdown', 'Date Drop Down', 'used to make date drop downs', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '95%', '', '', 'dateDropDown')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (120005602, 'classfaq', 'Class - FAQs', 'Frequently asked questions editing form', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 2, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (120005601, 'admincourseinfo', 'Admin - Course Semester Info', 'Handles course semester information.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '95%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (1053795638, 'customfields', 'Custom Fields', 'Provides various custom fields for the site. ', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '95%', '', '', 'customField')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (1054222970, 'adminsemesters', 'Admin - Add / Edit semesters', 'Allows an admin to manage semesters.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483652, 'semester', 'semester\r\n', 'Select a Semester', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 2, 2, '50%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483651, 'grouppermsadmin', 'Group Permissions - Administration', 'drop-down of administrative pages and multi-select listbox of available groups', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 4, 2, '', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483653, 'studentpresentation', 'Class Presentation', 'Presentation entry form for the student in the classroom module', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 3, 0, '', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483654, 'classcontentlesson', 'Class Lesson Content', 'Create lesson content for your class here.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 2, 2, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483655, 'facultypresentation', 'Faculty Presentation Edit', 'Presentation edit form for faculty. (Includes fields that the student one does not.)', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 3, 0, '', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483657, 'lessoncategoryadd', 'Add cateogry to webliography', 'Adding a category has never been so easy!', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 2, 2, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483656, 'lessoncategoryremove', 'Webliography (links) Category Remove', 'Remove a category from lesson webliography', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 2, 2, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483658, 'addobjective', 'Add Objective', 'Add an Objective', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 3, 0, '', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483659, 'classlinksprocess', 'Webliography Link Adding', 'Webliography (links) adding form', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 2, 2, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483660, 'classsyllabus', 'Class Manager - Syllabus', 'Provides fields for each class room\'s syllabus.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 1, 1, '95%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (100047, 'classmgrinstrbio', 'classmgr - Instructor Biography', 'Instructor Biography', '', 'POST', '', 'multipart/form-data', 0, 0, 3, '95%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483664, 'semestersfaculty', 'Faculty Semester Dropdown', 'Faculty Semester dropdown (view only which have classes w/ class count)', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 2, 2, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483665, 'gbcategory', 'Gradebook - Categories', 'Add and edit gradebook categories', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483666, 'examschedule', 'Exam Schedule', 'Allows teachers and exammanager members to edit exam schedule info.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 2, 0, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483667, 'orientation', 'Orientation', 'Faculty orientation', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 4, 1, '75%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483668, 'orientationdates', 'Orientation Dates', 'Adds dates to a given semester.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 4, 1, '75%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483669, 'seminar', 'Seminar - Edit', 'Allows an admin to edit the seminars', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 4, 1, '85%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483670, 'testdates', 'Test Dates', 'Allows an Exam Manager (group) to enter the start and end dates for a semester\'s testing period.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 2, 0, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483671, 'orientation_admin_ed', 'Orientation (scheduling)', 'I like beanie babies!', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 2, 2, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483672, 'book', 'Edit Book', 'Edit a book for the textbook manager', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 2, 0, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483674, 'orientation_admin_dt', 'orientation dates (scheduling)', 'I love ants. They are so tasty!', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 2, 2, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483675, 'textbookcampuses', 'Textbook Campuses', 'Modifies the campus settings for a class.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 4, 1, '75%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483676, 'orientationadmin', 'Orientation - Admin', 'Orientation admin sets the final date for the orienation and approves it.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 4, 1, '95%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483677, 'addassessment', 'Assessments - Add /Edit', 'Allows a teacher to create assessments.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 1, '75%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483678, 'setavailability', 'Assessments - Set Availability', 'Allows faculty to set the availability of a test.', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 1, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483680, 'helpdeskSubmit', 'Helpdesk - Site', 'None', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (1059934774, 'helpdeskSubmitAdmin', 'Helpdesk - Site Admin', 'None', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (2147483682, 'emailforward', 'emailforward', 'Email forward', '', 'GET', '', 'application/x-www-form-urlencoded', 0, 0, 0, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (1063377980, 'helpdeskstaff', 'Helpdesk - Staff', 'None', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '100%', '', '', 'site')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcFormInfo (pkey, formCode, name, description, action, method, target, enctype, border, cellpadding, cellspacing, width, groups, notgroups, type) VALUES (1063378097, 'helpdeskstaffadmin', 'Helpdesk - Staff Admin', 'None', '', 'POST', '', 'application/x-www-form-urlencoded', 0, 0, 0, '100%', '', '', 'site');
campusdelimeter;
$installTableSchemas[] = $table;

?>