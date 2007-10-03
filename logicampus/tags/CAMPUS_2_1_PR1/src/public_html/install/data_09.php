<?
$installTableSchemas = array();
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483908, 2147483672, 'text', 'author', 'Author', '', '', 'default', '', 'N', '', 1, 100, 'Y', 5, 40, 100, '', '', '', '', 0, 0, '', 0, '', 'a:3:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:7:"tbadmin";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483909, 2147483674, 'dateDropDown', 'timeStart', 'Start time', '', '', '', '', '', '', 0, 0, 'N', 2, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:4:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:6:"semmgr";i:3;s:8:"semrmsch";}', '', 2, '0', '0', '56', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483910, 2147483674, 'dateDropDown', 'timeEnd', 'End Time', '', '', '', '', '', '', 0, 0, 'N', 3, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:4:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:6:"semmgr";i:3;s:8:"semrmsch";}', '', 3, '0', '0', '56', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483911, 2147483672, 'text', 'publisher', 'Publisher', '', '', 'default', '', 'N', '', 1, 255, 'Y', 6, 40, 255, '', '', '', '', 0, 0, '', 0, '', 'a:3:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:7:"tbadmin";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483912, 2147483674, 'submit', 'Submit', '', 'Submit', '', '', '', '', '', 0, 0, '', 4, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:4:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:6:"semmgr";i:3;s:8:"semrmsch";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483913, 2147483672, 'text', 'edition', 'Edition', '', '', 'default', '', 'N', '', 1, 255, 'N', 8, 25, 255, '', '', '', '', 0, 0, '', 0, '', 'a:3:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:7:"tbadmin";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483915, 2147483672, 'text', 'isbn', 'ISBN', '', '', 'default', 'If your item is in a bundle, enter the complete bundle ISBN here.', 'Y', '', 1, 25, 'Y', 7, 15, 25, '', '', '', '', 0, 0, '', 0, '', 'a:3:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:7:"tbadmin";}', '', 6, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483932, 1054222970, 'row', '', '', 'Seminar Scheduling Dates', '', '', '', '', '', 0, 0, '', 30, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 35, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483916, 2147483672, 'radio', 'required', 'Required Item?', 'on', '', 'radio', '', '', '', 0, 0, 'N', 11, 0, 0, '1=Yes,0=No', 'N', '', '', 0, 0, '', 0, '', 'a:3:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:7:"tbadmin";}', '', 7, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483917, 2147483672, 'radio', 'bundled', 'Bundled?', 'on', '', 'radio', '', '', '', 0, 0, 'N', 12, 0, 0, '1=Yes,0=No', 'N', '', '', 0, 0, '', 0, '', 'a:3:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:7:"tbadmin";}', '', 8, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483918, 2147483672, 'textarea', 'bundledItems', 'Bundled Items', '', '', 'default', '', 'N', '', 1, 65535, 'N', 13, 0, 0, '', '', '', '', 40, 5, '', 0, '', 'a:3:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:7:"tbadmin";}', '', 9, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483919, 2147483674, 'hidden', 'event', '', 'scheduleUpdate', '', '', '', '', '', 0, 0, '', 5, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:4:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:6:"semmgr";i:3;s:8:"semrmsch";}', '', 5, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483994, 2147483680, 'customField', 'category', 'Category', '', '', 'select', '', '', '', 1, 1, 'Y', 3, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 5, '', '', '', 'helpdeskCategories')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483931, 2147483672, 'select', 'type', 'Select Type', '', '', 'select', '', 'N', '', 1, 1, 'Y', 3, 1, 0, 'Textbook=Textbook,Software=Software', '', 'N', 'N', 0, 0, '', 0, '', 'a:3:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:7:"tbadmin";}', '', 16, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483923, 2147483672, 'select', 'status', 'Status', '', '', 'select', '', 'N', '', 1, 1, 'N', 1, 1, 0, '1=New,2=Pending,3=Approved,4=Waiting on Instructor', '', 'N', 'N', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"tbadmin";}', '', 13, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483924, 2147483672, 'submit', 'submit', '', 'Submit', '', '', '', '', '', 0, 0, '', 17, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:3:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:7:"tbadmin";}', '', 14, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483925, 2147483672, 'hidden', 'event', '', 'update', '', '', '', '', '', 0, 0, '', 18, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:3:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:7:"tbadmin";}', '', 15, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483927, 1054222970, 'dateDropDown', 'dateStartITVseminar', 'ITV Seminar Start Sched.', '', '', '', '', '', '', 0, 0, 'N', 32, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:5:"admin";}', '', 31, '0', '0', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483928, 1054222970, 'dateDropDown', 'dateEndITVseminar', 'ITV Seminar End Sched.', '', '', '', '', '', '', 0, 0, 'N', 33, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:5:"admin";}', '', 32, '0', '0', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483930, 1054222970, 'dateDropDown', 'dateEndOrientation', 'Orientation end sched.', '', '', '', '', '', '', 0, 0, 'N', 37, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:5:"admin";}', '', 34, '0', '0', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483933, 1054222970, 'row', '', '', 'instructions: These are the dates that will allow faculty to start scheduling seminars for there classrooms.', '', '', '', '', '', 0, 0, '', 31, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 36, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483934, 1054222970, 'row', '', '', 'Orientation Scheduling', '', '', '', '', '', 0, 0, '', 34, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 37, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483935, 1054222970, 'row', '', '', 'instructions: Enter the dates that faculty may start scheduling their orientation. (Internet classes only!)', '', '', '', '', '', 0, 0, '', 35, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 38, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483936, 2147483672, 'text', 'copyright', 'Copyright Year', '', '', 'numericChars', '', 'Y', '', 4, 4, 'N', 10, 4, 4, '', '', '', '', 0, 0, '', 0, '', 'a:3:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:7:"tbadmin";}', '', 17, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483938, 1054222970, 'dateDropDown', 'dateStartExam', 'Exam Start', '', '', '', '', '', '', 0, 0, 'N', 40, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 39, '0', '0', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483939, 1054222970, 'dateDropDown', 'dateEndExam', 'Date exam scheduling ends', '', '', '', '', '', '', 0, 0, 'N', 41, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 40, '0', '0', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483943, 1054222970, 'row', '', '', 'Exam Scheduling', '', '', '', '', '', 0, 0, '', 38, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 44, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483941, 1054222970, 'dateDropDown', 'dateStartTextbook', 'Date start textbook sched', '', '', '', '', '', '', 0, 0, 'N', 44, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 42, '0', '0', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483942, 1054222970, 'dateDropDown', 'dateEndTextbook', 'Date end textbook sched', '', '', '', '', '', '', 0, 0, 'N', 45, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 43, '0', '0', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483945, 1054222970, 'row', '', '', 'Textbook Scheduling Dates', '', '', '', '', '', 0, 0, '', 43, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 46, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483946, 1054222970, 'row', '', '', 'instructions: Enter the dates at which you want the teachers to start scheduling textbook requests', '', '', '', '', '', 0, 0, '', 46, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 47, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483947, 2147483671, 'textarea', 'notes', 'Notes', '', '', 'default', '', 'Y', '', 1, 65535, 'N', 18, 0, 0, '', '', '', '', 50, 5, '', 0, '', 'a:1:{i:0;s:6:"semmgr";}', '', 19, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483948, 2147483671, 'row', '', '', '<b>Primary Scheduling Information</b>\r\n<br><br>', '', '', '', '', '', 0, 0, '', 1, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 20, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483949, 2147483675, 'row', '', '', 'Campus Options', '', '', '', '', '', 0, 0, '', 1, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:2:{i:0;s:5:"admin";i:1;s:7:"tbadmin";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483950, 2147483675, 'select', 'southCampus', 'South Campus', '', '', 'select', '', 'N', '', 1, 1, 'Y', 2, 1, 0, '0=No,1=Yes', '', 'N', 'N', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"tbadmin";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483951, 2147483675, 'select', 'southeastCampus', 'Southeast Campus', '', '', 'select', '', 'N', '', 1, 1, 'Y', 3, 1, 0, '0=No,1=Yes', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:7:"tbadmin";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483952, 2147483675, 'select', 'northeastCampus', 'Northeast Campus', '', '', 'select', '', 'N', '', 1, 1, 'Y', 4, 1, 0, '0=No,1=Yes', '', 'N', 'N', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"tbadmin";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483953, 2147483675, 'select', 'northwestCampus', 'Northwest Campus', '', '', 'select', '', 'N', '', 1, 1, 'Y', 5, 1, 0, '0=No,1=Yes', '', 'N', 'N', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"tbadmin";}', '', 5, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483954, 2147483675, 'submit', 'submit', '', 'Enter', '', '', '', '', '', 0, 0, '', 6, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"tbadmin";}', '', 6, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483955, 2147483675, 'hidden', 'event', '', 'updatecampuses', '', '', '', '', '', 0, 0, '', 7, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"tbadmin";}', '', 7, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483962, 2147483677, 'row', '', '', 'Assessment Information', '', '', '', '', '', 0, 0, '', 1, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483957, 2147483676, 'dateDropDown', 'finalDateTime', 'Enter Date and Time', '', '', '', '', '', '', 0, 0, 'N', 2, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:6:"semmgr";}', '', 2, '0', '+2', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483958, 2147483676, 'radio', 'finalSessionLength', 'Session Length', '50', '', 'radio', '', '', '', 0, 0, 'Y', 3, 0, 0, '50=50 Minutes,80=80 Minutes', 'N', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:6:"semmgr";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483959, 2147483676, 'select', 'finalCampus', 'Select Campus Location', '', '', 'select', '', 'N', '', 1, 1, 'Y', 4, 1, 0, 'SO=South Campus,SE=Southeast Campus,NE=Northeast Campus,NW=Northwest Campus', '', 'N', 'N', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"tbadmin";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483960, 2147483676, 'hidden', 'event', '', 'view', '', '', '', '', '', 0, 0, '', 5, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:6:"semmgr";}', '', 5, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483961, 2147483676, 'submit', 'submit', '', 'Schedule', '', '', '', '', '', 0, 0, '', 6, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:6:"semmgr";}', '', 6, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483963, 2147483677, 'text', 'displayName', 'Enter Assessment Name', '', '', 'default', '', 'Y', '', 1, 255, 'Y', 2, 25, 255, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483964, 2147483677, 'textarea', 'description', 'Description', '', '', 'default', '', 'Y', '', 1, 65535, 'N', 3, 0, 0, '', '', '', '', 40, 15, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 3, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483965, 2147483677, 'textarea', 'instructions', 'Enter Instructions', '', '', 'default', '', 'Y', '', 1, 65535, 'N', 4, 0, 0, '', '', '', '', 40, 15, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 4, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483984, 2147483680, 'textarea', 'details', 'Detailed description', '', '', 'default', 'Give us a detailed description of your problem.', 'N', '', 1, 65535, 'Y', 2, 0, 0, '', '', '', '', 50, 6, '', 0, '', 'a:2:{i:0;s:3:"reg";i:1;s:7:"student";}', '', 2, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483968, 2147483677, 'hidden', 'event', '', 'insert', '', '', '', '', '', 0, 0, '', 10, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 7, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483969, 2147483677, 'submit', 'submit', '', 'Enter', '', '', '', '', '', 0, 0, '', 11, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 8, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483970, 2147483678, 'row', '', '', 'Date Range', '', '', '', '', '', 0, 0, '', 1, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483971, 2147483678, 'dateDropDown', 'dateAvailable', 'Date Available', '', '', '', '', '', '', 0, 0, 'N', 3, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 2, '0', '+1', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483972, 2147483678, 'dateDropDown', 'dateUnavailable', 'Date Unavailable', '', '', '', '', '', '', 0, 0, 'N', 4, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 3, '0', '+1', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483973, 2147483678, 'select', 'numRetries', 'Number of attempts allowed?', '', '', 'select', '', 'N', '', 1, 1, 'Y', 6, 1, 0, '1=1,2=2,3=3,4=4,5=5', '', 'N', 'N', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483974, 2147483678, 'select', 'minuteLimit', 'Time Limit', '', '', 'select', '', 'N', '', 1, 1, 'Y', 7, 1, 0, '15=15 Minutes,30=30 Minutes,45=45 Minutes,60=1 Hour,75=1 hour 15 minutes,90=1 hour 30 minutes,105=1 hour 45 minutes,120=2 Hours,135=2 hours 15 minutes,150=2 hours 30 minutes,165=2 hours 45 minutes,180=3 Hours,9999=Unlimited', '', 'N', 'N', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 5, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483979, 2147483678, 'row', '', '', 'Grades and Email', '', '', '', '', '', 0, 0, '', 8, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 10, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483975, 2147483678, 'row', '', '', 'Other information', '', '', '', '', '', 0, 0, '', 5, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 6, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483976, 2147483678, 'hidden', 'event', '', 'processAvailability', '', '', '', '', '', 0, 0, '', 16, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 7, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483977, 2147483678, 'submit', 'submit', '', 'Enter', '', '', '', '', '', 0, 0, '', 17, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 8, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483978, 2147483678, 'row', '', '', 'Select the date and time to make your assessment available and unavailable to students below.  The dates selected below are *concrete* dates meaning a student will not be able to start an assessment until this time is reached.  They will also be stopped if they are taking an assessment when the unavailable date is reached.  <br><br>', '', '', '', '', '', 0, 0, '', 2, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 9, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483983, 2147483680, 'text', 'summary', 'Summary', '', '', 'default', '', 'N', '', 2, 5000, 'Y', 1, 50, 100, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:3:"reg";i:1;s:7:"student";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;

?>