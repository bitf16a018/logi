<?
$installTableSchemas = array();
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483981, 2147483678, 'radio', 'autoPublish', 'Display grade in gradebook?', '0', '', 'radio', '', '', '', 0, 0, 'Y', 10, 0, 0, '0=No,1=Yes', 'Y', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 12, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483982, 2147483678, 'radio', 'mailResponses', 'Email test with responses to instructor?', '0', '', 'radio', '', '', '', 0, 0, 'Y', 12, 0, 0, '0=No,1=Yes', 'Y', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 13, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483991, 2147483677, 'text', 'gradebookCode', 'Gradebook Code', '', '', 'default', '', 'Y', '', 1, 10, 'Y', 9, 10, 10, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 11, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483986, 2147483680, 'submit', 'submit', '', 'Post your issue', '', '', '', '', '', 0, 0, '', 4, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:3:"reg";i:1;s:7:"student";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1059934783, 1059934773, 'textarea', 'details', 'Detailed description', '', '', 'default', 'Give us a detailed description of your problem.', 'N', '', 1, 65535, 'Y', 2, 0, 0, '', '', '', '', 50, 6, '', 0, '', 'a:2:{i:0;s:3:"reg";i:1;s:7:"student";}', '', 2, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1059934791, 1059934774, 'text', 'summary', 'Summary', '', '', 'default', '', 'N', '', 2, 5000, 'Y', 2, 50, 100, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:3:"reg";i:1;s:7:"student";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483989, 2147483677, 'row', '', '', 'Gradebook Information', '', '', '', '', '', 0, 0, '', 7, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 9, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1059934789, 1059934774, 'textarea', 'details', 'Detailed description', '', '', 'default', 'Give us a detailed description of your problem.', 'N', '', 1, 65535, 'Y', 3, 0, 0, '', '', '', '', 50, 6, '', 0, '', 'a:2:{i:0;s:3:"reg";i:1;s:7:"student";}', '', 2, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1059934792, 1059934774, 'submit', 'submit', '', 'Post your issue', '', '', '', '', '', 0, 0, '', 6, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:3:"reg";i:1;s:7:"student";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483988, 1059934774, 'text', 'username', 'Username', '', '', 'default', '', 'Y', '', 3, 32, 'Y', 1, 32, 32, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:7:"hdadmin";}', '', 5, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483992, 2147483678, 'select', 'showResultType', 'When a student is finished with the test we will...', '', '', 'select', '', 'N', '', 1, 1, 'Y', 14, 1, 0, '0=Show thank you page,1=Show grade of test,2=Show grade and list correct/incorrect questions', '', 'N', 'N', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"faculty";}', '', 14, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483995, 2147483682, 'text', 'email', 'Email', '', '', 'email', '', 'Y', '', 3, 80, 'Y', 1, 30, 80, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483996, 2147483682, 'submit', 'submit', '', 'Submit', '', '', '', '', '', 0, 0, '', 2, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483997, 100057, 'text', 'totalPoints', 'Enter total points', '', '', 'numericChars', 'Only use this field if you are setting up your gradebook as points based.', 'N', '', 0, 5, 'N', 3, 5, 5, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 15, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483998, 2147483663, 'checkbox', 'removePhoto', 'Remove Photo', '', '', '', '', '', '', 0, 0, 'N', 29, 0, 0, '', 'N', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 59, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147484000, 2147483678, 'row', '', '', '<hr>', '', '', '', '', '', 0, 0, '', 13, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:3:"reg";i:1;s:7:"faculty";}', '', 16, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1063377991, 1063377980, 'textarea', 'details', 'Detailed description', '', '', 'default', 'Give us a detailed description of your problem.', 'N', '', 1, 65535, 'Y', 2, 0, 0, '', '', '', '', 50, 6, '', 0, '', 'a:2:{i:0;s:3:"reg";i:1;s:7:"student";}', '', 2, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1063377992, 1063377980, 'text', 'summary', 'Summary', '', '', 'default', '', 'N', '', 2, 5000, 'Y', 1, 50, 100, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:3:"reg";i:1;s:7:"student";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1063377993, 1063377980, 'submit', 'submit', '', 'Post your issue', '', '', '', '', '', 0, 0, '', 4, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:3:"reg";i:1;s:7:"student";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483999, 2147483678, 'row', '', '', '<hr>', '', '', '', '', '', 0, 0, '', 11, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:3:"reg";i:1;s:7:"faculty";}', '', 15, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1063378108, 1063378097, 'text', 'summary', 'Summary', '', '', 'default', '', 'N', '', 2, 5000, 'Y', 2, 50, 100, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:3:"reg";i:1;s:7:"student";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1063378109, 1063378097, 'textarea', 'details', 'Detailed description', '', '', 'default', 'Give us a detailed description of your problem.', 'N', '', 1, 65535, 'Y', 3, 0, 0, '', '', '', '', 50, 6, '', 0, '', 'a:2:{i:0;s:3:"reg";i:1;s:7:"student";}', '', 2, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1063378110, 1063378097, 'submit', 'submit', '', 'Post your issue', '', '', '', '', '', 0, 0, '', 6, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:3:"reg";i:1;s:7:"student";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1063378111, 1063378097, 'text', 'username', 'Username', '', '', 'default', '', 'Y', '', 3, 32, 'Y', 1, 32, 32, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:7:"hdadmin";}', '', 5, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147484001, 2147483678, 'row', '', '', '<br/>', '', '', '', '', '', 0, 0, '', 15, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:3:"reg";i:1;s:7:"faculty";}', '', 17, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288455, 1067288444, 'customField', 'idCourse', 'Course', '', '', 'select', '', '', '', 1, 1, 'Y', 3, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', 'allCourses')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288456, 1067288444, 'select', 'semesterTerm', 'Semester change is to be effective', '', '', 'select', '', 'N', '', 1, 1, 'Y', 4, 1, 0, 'Fall=Fall,Spring=Spring,Summer=Summer', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288457, 1067288444, 'dateDropDown', 'semesterYear', 'Year change is to be effective', '', '', 'DateDropDown', '', '', '', 0, 0, 'Y', 5, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 4, '0', '+5', '1', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288458, 1067288444, 'select', 'instructionType', 'Mode of Instruction', '', '', 'select', '', 'N', '', 1, 1, 'Y', 6, 1, 0, 'Instructional Television=Instruction Television,Internet=Internet,Interactive Television=Interactive Television', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 5, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288459, 1067288444, 'customField', 'currentFacultyId', 'Current Faculty', '', '', 'select', '', '', '', 1, 1, 'Y', 7, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 6, '', '', '', 'faculty')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288460, 1067288444, 'text', 'newFacultyName', 'Proposed Faculty', '', '', 'default', '(example: John Smith)', 'Y', '', 1, 255, 'Y', 9, 25, 255, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 7, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288461, 1067288444, 'customField', 'newFacultyPhone', 'Proposed Faculty Phone', '', '', 'phoneNumber', '', '', '', 1, 1, 'Y', 10, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 8, '', '', '', 'phoneNumber')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288462, 1067288444, 'select', 'changeType', 'Change is', '', '', 'select', '', 'N', '', 1, 1, 'Y', 11, 1, 0, '=Select one,Permanent=Permanent,Temporary=Temporary', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 9, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288463, 1067288444, 'text', 'changeDuration', 'If temporary for how long?', '', '', 'default', '', 'Y', '', 1, 255, 'N', 12, 25, 255, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 10, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288464, 1067288444, 'row', '', '', 'Other Information', '', '', '', '', '', 0, 0, '', 13, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 11, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288465, 1067288444, 'textarea', 'changeReason', 'Reason for change', '', '', 'default', '', 'Y', '', 1, 65535, 'Y', 14, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 12, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288466, 1067288444, 'select', 'facultyNotified', 'Has the current faculty member affected by this request been notified?', '', '', 'select', '', 'N', '', 1, 1, 'Y', 15, 1, 0, '=Select One,No=No,Yes=Yes', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 13, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288467, 1067288444, 'select', 'facultyCompletedTraining', 'Has the proposed faculty member completed DL On-line training?', '', '', 'select', '', 'N', '', 1, 1, 'Y', 16, 1, 0, '=Select one,No=No,Yes=Yes', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 14, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288468, 1067288444, 'submit', 'submit', '', 'Enter', '', '', '', '', '', 0, 0, '', 17, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 15, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288469, 1067288444, 'text', 'newFacultyEmail', 'Proposed Faculty Email Address', '', '', 'email', '', 'Y', '', 5, 50, 'Y', 8, 25, 50, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 16, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288470, 1067288444, 'select', 'requestType', 'Type of Request', '', '', 'select', '', 'N', '', 1, 1, 'Y', 2, 1, 0, 'Change in Faculty=Change in Faculty,Addition of Faculty=Addition of Faculty', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 17, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288532, 1067288522, 'row', '', '', 'Course Information', '', '', '', '', '', 0, 0, '', 1, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288533, 1067288522, 'text', 'proposedCourse', 'Proposed Course Name', '', '', 'default', '', 'Y', '', 1, 255, 'Y', 2, 50, 255, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288534, 1067288522, 'select', 'instructionMode', 'Proposed mode of instruction', '', '', 'select', '', 'N', '', 1, 1, 'Y', 3, 1, 0, 'Instructional Television=Instructional Television,Internet=Internet,Interactive Television=Interactive Television', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288535, 1067288522, 'select', 'semesterDeveloped', 'Semester to be developed', '', '', 'select', '', 'N', '', 1, 1, 'Y', 4, 1, 0, 'Spring=Spring,Summer=Summer,Fall=Fall', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288536, 1067288522, 'dateDropDown', 'yearDeveloped', 'Year course to be developed', '', '', 'DateDropDown', '', '', '', 0, 0, 'Y', 5, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 5, '0', '+5', '1', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288537, 1067288522, 'select', 'semesterOffered', 'Semester course is to be offered', '', '', 'select', '', 'N', '', 1, 1, 'Y', 6, 1, 0, 'Spring=Spring,Summer=Summer,Fall=Fall', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 6, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288538, 1067288522, 'dateDropDown', 'yearOffered', 'Year course is to be offered', '', '', 'DateDropDown', '', '', '', 0, 0, 'Y', 7, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 7, '0', '+5', '1', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288539, 1067288522, 'textarea', 'courseOfferedWhen', 'When will the course be offered?', '', '', 'default', '(Example: only in the spring terms)', 'Y', '', 1, 65535, 'Y', 8, 0, 0, '', '', '', '', 25, 15, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 8, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288540, 1067288522, 'textarea', 'courseDevelopedBy', 'List the faculty member(s) to develop the course', '', '', 'default', '', 'Y', '', 1, 65535, 'Y', 9, 0, 0, '', '', '', '', 25, 15, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 9, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288541, 1067288522, 'textarea', 'developmentOfficePhone', 'Enter the phone number(s) of the faculty member(s) developing the course', '', '', 'default', '(enter one per line)', 'Y', '', 1, 65535, 'Y', 10, 0, 0, '', '', '', '', 25, 15, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 10, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288542, 1067288522, 'textarea', 'facultyToTeach', 'List the faculty member(s) to teach the course', '', '', 'default', '', 'Y', '', 1, 65535, 'Y', 11, 0, 0, '', '', '', '', 25, 15, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 11, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288543, 1067288522, 'textarea', 'facultyOfficePhone', 'Enter the phone number(s) of the faculty member(s) teaching the course', '', '', 'default', '(enter one per line)', 'Y', '', 1, 65535, 'Y', 12, 0, 0, '', '', '', '', 25, 15, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 12, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288544, 1067288522, 'textarea', 'periodsOffered', 'Provide the semester and the year the course will run', '', '', 'default', '(Example: Fall 2005, Summer 2004)', 'Y', '', 1, 65535, 'Y', 13, 0, 0, '', '', '', '', 25, 15, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 13, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288545, 1067288522, 'row', '', '', 'Rationale for Proposal Section', '', '', '', '', '', 0, 0, '', 14, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 14, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288546, 1067288522, 'textarea', 'courseOutline', 'Enter the course outline', '', '', 'default', '', 'Y', '', 1, 65535, 'Y', 15, 0, 0, '', '', '', '', 25, 15, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 15, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288547, 1067288522, 'textarea', 'justification', 'Justifciation for course', '', '', 'default', '', 'Y', '', 1, 65535, 'Y', 16, 0, 0, '', '', '', '', 25, 15, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 16, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288548, 1067288522, 'textarea', 'projectedEnrollment', 'What are your projected enrollments for this course?', '', '', 'default', '', 'Y', '', 1, 65535, 'Y', 17, 0, 0, '', '', '', '', 25, 15, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 17, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288549, 1067288522, 'textarea', 'otherInfo', 'Please list of things such as equipment and expenses needed to develop or teach course.', '', '', 'default', '', 'Y', '', 1, 65535, 'Y', 18, 0, 0, '', '', '', '', 25, 15, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 18, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288550, 1067288522, 'submit', 'submit', '', 'Enter', '', '', '', '', '', 0, 0, '', 19, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 19, '', '', '', '');
campusdelimeter;
$installTableSchemas[] = $table;

?>