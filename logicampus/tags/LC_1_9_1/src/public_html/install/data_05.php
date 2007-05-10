<?
$installTableSchemas = array();
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1053795653, 1053795638, 'text', 'size', 'Field size', '1', '', 'default', '(should be 1 unless multple select is chosen)', 'Y', '', 1, 2, 'Y', 6, 2, 2, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 6, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1053795651, 1053795638, 'select', 'req', 'Is this a required field?', 'Y', '', 'select', '', 'N', '', 1, 1, '', 4, 1, 0, 'Y=Yes,N=No', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1053795649, 1053795638, 'text', 'fieldName', 'Enter the field name', '', '', 'default', '', 'Y', '', 1, 50, 'Y', 2, 15, 50, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1053795650, 1053795638, 'text', 'displayName', 'Enter the display Name', '', '', 'default', '', 'Y', '', 1, 25, 'Y', 3, 15, 25, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1053795648, 1053795638, 'row', '', '', 'Step One - Select which specific course field you wish to add to a form. All form fields are presented as drop downs.', '', '', '', '', '', 0, 0, '', 1, 0, 0, '', '', '', '', 0, 0, '', 0, 'formHeading', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1053795655, 1053795638, 'textarea', 'defaultValue', 'Enter the default value', '', '', 'default', '', 'Y', '', 1, 65535, 'N', 9, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 8, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1053795656, 1053795638, 'textarea', 'message', 'Enter help or instructions', '', '', 'default', '', 'N', '', 1, 65535, 'N', 10, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 9, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1053795657, 1053795638, 'hidden', 'min', '', '1', '', '', '', '', '', 0, 0, '', 13, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 10, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1053795658, 1053795638, 'hidden', 'max', '', '1', '', '', '', '', '', 0, 0, '', 14, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 11, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1053795659, 1053795638, 'hidden', 'event', '', 'addModifyFormFieldPost', '', '', '', '', '', 0, 0, '', 16, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 12, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1053795660, 1053795638, 'hidden', 'type', '', 'customField', '', '', '', '', '', 0, 0, '', 15, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 13, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1053795661, 1053795638, 'select', 'extra', 'Select field type', '', '', 'select', '', 'N', '', 1, 1, 'N', 12, 1, 0, 'groups=System Groups,courseFamily=Course Family,courseNumber=Course Number,courseFamilyNumber=Course Family and Number,allCourses=All Courses,semester=All Semesters,faqCategories=FAQ Categories,faculty=All Faculty,linkCategories=Class Link Categories,phoneNumber=US Phone Number,LinkCategoriesWithTop=Link Categories With Top Parent,selectClassObjectives=Class Objectives,selectClassContent=Class Content,selectClassAssignments=Class Assignments,selectClassLinks=Class Links,semesterFaculty=Faculty Semesters,gbCategories=Gradebook Categories,emClassDates=Exam Manager\'s Class Dates,orientationDates=Orientation Dates,orientationStatus=Orientation Status,helpdeskCategories=Helpdesk  Categories', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 14, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483652, 200054, 'hidden', 'event', '', 'courseFamilyInfoPost', '', '', '', '', '', 0, 0, '', 3, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483653, 200054, 'submit', 'submit', '', 'Enter', '', '', '', '', '', 0, 0, '', 4, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483654, 100054, 'customField', 'id_courses', 'Select the Course', '', '', 'select', '', '', '', 1, 1, 'Y', 2, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 8, '', '', '', 'allCourses')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483659, 1053795638, 'select', 'validationType', 'Select validation', '', '', 'select', '', 'N', '', 1, 1, 'N', 11, 1, 0, 'default=Default,email=Email Address,select=Select Drop Down,alphaChars=Only allow Alpha Characters,numericChars=Only allow Numbers,alphaNumeric=Alpha and Numeric,phoneNumber=US Phone Number,emClassDates=Exam Manager\'s Class Dates', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 15, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222980, 1054222970, 'row', '', '', 'Semester Term / Year', '', '', '', '', '', 0, 0, '', 1, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147484003, 120005599, 'hidden', 'validationType', '', 'DateDropDown', '', '', '', '', '', 0, 0, '', 10, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:6:"public";}', '', 10, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483667, 2, 'text', 'formCode', 'Enter the form code', '', '', 'alphaNumeric', '(the form code is used to uniquely identify a form)', 'Y', '', 1, 20, 'Y', 8, 20, 20, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 20, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222982, 1054222970, 'dateDropDown', 'semesterYear', 'Semester Year', '', '', '', '', '', '', 0, 0, '', 4, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 25, '0', '+5', '1', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222983, 1054222970, 'row', '', '', 'Semester Dates', '', '', '', '', '', 0, 0, '', 6, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222984, 1054222970, 'row', '', '', 'instructions: Enter the begining and end of this semester.\r\n\r\n', '', '', '', '', '', 0, 0, '', 7, 0, 0, '', '', '', '', 0, 0, '', 0, 'instructions', 'a:1:{i:0;s:3:"reg";}', '', 5, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222985, 1054222970, 'dateDropDown', 'dateStart', 'Semester Start Date', '', '', '', '', '', '', 0, 0, '', 8, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 6, '0', '+5', '7', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222986, 1054222970, 'dateDropDown', 'dateEnd', 'Semester End Date', '', '', '', '', '', '', 0, 0, '', 9, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 7, '0', '+5', '7', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222987, 1054222970, 'row', '', '', 'Student Registration Dates', '', '', '', '', '', 0, 0, '', 10, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 8, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222988, 1054222970, 'row', '', '', 'instructions: Enter the dates that students can start to register and the end of registration.\r\n\r\n', '', '', '', '', '', 0, 0, '', 11, 0, 0, '', '', '', '', 0, 0, '', 0, 'instructions', 'a:1:{i:0;s:3:"reg";}', '', 9, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222989, 1054222970, 'dateDropDown', 'dateRegistrationStart', 'Regisration Start Date', '', '', '', '', '', '', 0, 0, '', 12, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 10, '0', '+5', '7', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222990, 1054222970, 'dateDropDown', 'dateRegistrationEnd', 'Registration End Date', '', '', '', '', '', '', 0, 0, '', 13, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 11, '0', '+5', '7', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222991, 1054222970, 'row', '', '', 'Census Date', '', '', '', '', '', 0, 0, '', 14, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 12, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222992, 1054222970, 'row', '', '', 'instructions: Enter the census date for this semester.\r\n\r\n', '', '', '', '', '', 0, 0, '', 15, 0, 0, '', '', '', '', 0, 0, '', 0, 'instructions', 'a:1:{i:0;s:3:"reg";}', '', 13, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222993, 1054222970, 'dateDropDown', 'dateCensus', 'Census Date', '', '', '', '', '', '', 0, 0, '', 16, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 14, '0', '+5', '7', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222994, 1054222970, 'row', '', '', 'Drop Date', '', '', '', '', '', 0, 0, '', 17, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 15, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222995, 1054222970, 'row', '', '', 'instructions: Enter the final drop date for this semester.', '', '', '', '', '', 0, 0, '', 18, 0, 0, '', '', '', '', 0, 0, '', 0, 'instructions', 'a:1:{i:0;s:3:"reg";}', '', 16, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222996, 1054222970, 'dateDropDown', 'dateFinalDrop', 'Drop Date', '', '', '', '', '', '', 0, 0, 'N', 19, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 17, '0', '+5', '7', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222997, 1054222970, 'row', '', '', 'Account Activation Dates', '', '', '', '', '', 0, 0, '', 20, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 18, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222998, 1054222970, 'row', '', '', 'instructions: Enter the date and time we should activate accounts for faculty for this semester.', '', '', '', '', '', 0, 0, '', 21, 0, 0, '', '', '', '', 0, 0, '', 0, 'instructions', 'a:1:{i:0;s:3:"reg";}', '', 19, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222999, 1054222970, 'dateDropDown', 'dateAccountActivation', 'Account Activation Date', '', '', '', '', '', '', 0, 0, '', 22, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 20, '0', '+5', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054223000, 1054222970, 'row', '', '', 'Account De-activation', '', '', '', '', '', 0, 0, '', 23, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 21, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054223001, 1054222970, 'row', '', '', 'instructions: Enter the date we are to de-activate accounts for this semester.', '', '', '', '', '', 0, 0, '', 24, 0, 0, '', '', '', '', 0, 0, '', 0, 'instructions', 'a:1:{i:0;s:3:"reg";}', '', 22, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054223002, 1054222970, 'dateDropDown', 'dateDeactivation', 'Account De-activation Date', '', '', '', '', '', '', 0, 0, '', 25, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 23, '0', '+5', '7', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054223003, 1054222970, 'select', 'semesterTerm', 'Select the term', '', '', 'select', '', 'N', '', 1, 1, 'N', 3, 1, 0, 'SP=Spring,SM=Spring Mini,FA=Fall,FM=Fall Mini,SU=Summer,SM=Summer Mini,S1=Summer I, S2=Summer II,WI=Winter,WM=Winter Mini', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 24, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054223004, 1054222970, 'submit', 'submit', '', 'Enter', '', '', '', '', '', 0, 0, '', 47, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 26, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054223005, 1054222970, 'hidden', 'event', '', 'update', '', '', '', '', '', 0, 0, '', 26, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 27, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483668, 2147483651, 'customField', 'groups', 'Groups', '', '', 'default', '', '', '', 1, 1, 'Y', 5, 10, 0, '', '', 'Y', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', 'groups')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483669, 2147483651, 'submit', 'submit', '', 'Grant Permissions', '', '', '', '', '', 0, 0, '', 6, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483672, 2147483652, 'customField', 'semester', 'Select a Semester', '', '', 'select', '', '', '', 1, 1, 'Y', 1, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', 'semester')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483671, 2147483651, 'radio', 'service', 'Service', 'classes', '', 'radio', '', '', '', 0, 0, 'Y', 3, 0, 0, 'classes=Classes Administration,courses=Courses Administration,groups=Group Administration,mod=Message of the Day,semesters=Manage Semesters,servicePermissions=Manage group permissions,users=User Administration', 'N', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483673, 2147483652, 'submit', 'submit', '', 'Choose Semester', '', '', '', '', '', 0, 0, '', 2, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483674, 2147483651, 'row', '', '', 'Step 1: Select the service you wold like to grant access to.', '', '', '', '', '', 0, 0, '', 2, 0, 0, '', '', '', '', 0, 0, '', 0, 'colorbar', 'a:1:{i:0;s:3:"reg";}', '', 5, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483675, 2147483651, 'row', '', '', 'Step 2: Select the group(s) to be granted access to the indicated service.', '', '', '', '', '', 0, 0, '', 4, 0, 0, '', '', '', '', 0, 0, '', 0, 'colorbar', 'a:1:{i:0;s:3:"reg";}', '', 6, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483677, 100054, 'row', '', '', 'Enter your section numbers below one per line.  ', '', '', '', '', '', 0, 0, '', 9, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 11, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483678, 1054222970, 'row', '', '', 'Student Activation Account Date', '', '', '', '', '', 0, 0, '', 27, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 28, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483679, 1054222970, 'row', '', '', 'Instructions:  ', '', '', '', '', '', 0, 0, '', 28, 0, 0, '', '', '', '', 0, 0, '', 0, 'instructions', 'a:1:{i:0;s:3:"reg";}', '', 29, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483680, 1054222970, 'dateDropDown', 'dateStudentActivation', 'Student Activation Date', '', '', '', '', '', '', 0, 0, 'N', 29, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 30, '0', '+5', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483682, 1, 'dateDropDown', 'foobar', 'Select your birthdate', '', '', '', '', '', '', 0, 0, 'N', 13, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 13, '-10', '+10', '44', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483687, 2147483654, 'text', 'txTitle', 'Enter content title.', '', '', 'default', '', 'N', '', 2, 255, 'Y', 1, 50, 255, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483688, 2147483654, 'textarea', 'txText', 'Page content', '', '', 'default', '', 'N', '', 1, 65535, 'Y', 2, 0, 0, '', '', '', '', 60, 30, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', 'E')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483689, 2147483654, 'row', '', '', '&nbsp;', '', '', '', '', '', 0, 0, '', 3, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483690, 2147483654, 'submit', 'submit', '', 'Add Page', '', '', '', '', '', 0, 0, '', 4, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483691, 2147483653, 'textarea', 'content', 'Presentation', '', '', 'default', '', 'N', '', 1, 65535, 'Y', 3, 0, 0, '', '', '', '', 50, 20, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483692, 2147483654, 'hidden', 'id_class_lesson_content', '', '0', '', '', '', '', '', 0, 0, '', 5, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 5, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483693, 2147483653, 'submit', 'submit', '', 'Submit Presentation', '', '', '', '', '', 0, 0, '', 5, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483694, 2147483654, 'hidden', 'event', '', 'process', '', '', '', '', '', 0, 0, '', 6, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 6, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483695, 2147483653, 'submit', 'preview', '', 'Preview Presentation', '', '', '', '', '', 0, 0, '', 4, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;

?>