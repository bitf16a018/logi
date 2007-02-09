<?
$installTableSchemas = array();
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (188, 12, 'select', 'checked', 'Is this element checked?', 'N', '', 'select', '', 'N', '', 1, 1, '\r', 7, 1, 0, 'N=No,Y=Yes', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (189, 12, 'hidden', 'event', '', 'addModifyFormFieldPost', '', '', '', '', '', 0, 0, '', 8, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (190, 12, 'hidden', 'type', '', 'checkbox', '', '', '', '', '', 0, 0, '', 9, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (206, 9, 'text', 'min', 'Minimum length', '1', '', 'default', '', 'Y', '', 1, 5, 'N', 6, 15, 25, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (207, 9, 'text', 'max', 'Maximum Length', '25', '', 'default', '', 'Y', '', 1, 25, 'N', 7, 15, 25, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000160, 100020, 'select', 'course', 'Select a Course', 'All', '', 'select', '(Press the CTRL  key to select multiple courses)', 'N', '', 1, 1, 'N', 6, 5, 0, '=All,1=ACCT2301,2=ACCT2302,3=ENGL1301,4=MATH0301,5=MATH1315', '', 'Y', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000159, 100020, 'submit', 'submit', '', 'Search', '', '', '', '', '', 0, 0, '', 7, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000158, 100020, 'text', 'lastname', 'Enter last name', '', '', 'default', '', 'Y', '', 1, 100, 'N', 5, 15, 100, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000156, 100020, 'text', 'studentEmail', 'Enter email address', '', '', ' email', '', 'Y', '', 5, 100, 'N', 3, 15, 100, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000157, 100020, 'text', 'firstname', 'Enter first name', '', '', 'default', '', 'Y', '', 1, 100, 'N', 4, 15, 100, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000391, 100047, 'submit', 'submit', '', 'Publish', '', '', '', '', '', 0, 0, '', 36, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000536, 100047, 'file', 'photo', 'Attach Photo', '', '', '', '', '', '', 0, 0, '', 26, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000498, 100047, 'row', '', '', 'Upload a personal photo.  We will automatically resize the image for you.  Please only upload JPG or PNG file formats.', '', '', '', '', '', 0, 0, '', 25, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483728, 100047, 'customField', 'officePhone', 'Office Phone', '', '', 'phoneNumber', '', '', '', 1, 1, 'Y', 7, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 24, '', '', '', 'phoneNumber')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2000569, 200053, 'text', 'coReq1', '1:', '', '', 'default', '', 'Y', '', 1, 100, 'N', 16, 25, 100, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 14, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483750, 2147483661, 'customField', 'objectives', 'Objectives', '', '', 'select', '** denotes this objective has been applied to a lesson already.', '', '', 1, 1, 'Y', 7, 5, 0, '', '', 'Y', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', 'selectClassObjectives')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483749, 2147483661, 'textarea', 'description', 'Description', '', '', 'default', 'Enter a paragraph or two describing this lesson.', 'N', '', 1, 65535, 'Y', 5, 0, 0, '', '', '', '', 30, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483747, 100047, 'customField', 'emergencyPhone', 'Emergency Phone', '', '', 'phoneNumber', '', '', '', 1, 1, 'N', 21, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 36, '', '', '', 'phoneNumber')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2000537, 200053, 'text', 'courseName', 'Enter the course name:', '', '', 'default', '(Example: Principles of Management)', 'Y', '', 1, 100, 'Y', 5, 20, 100, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2000562, 200053, 'row', '', '', '', '', '', '', '', '', 0, 0, '', 6, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 8, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2000565, 200053, 'text', 'preReq3', '3:', '', '', 'default', '', 'Y', '', 1, 100, 'N', 12, 25, 100, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 11, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2000576, 200053, 'text', 'courseNumber', 'Enter the course number', '', '', 'numericChars', '(Example:  1401)', 'Y', '', 4, 4, 'Y', 2, 4, 4, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 21, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2000539, 200053, 'textarea', 'courseDescription', 'Enter the\r\ncourse description', '', '', 'default', '', 'Y', '', 1, 65535, 'Y', 7, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 4, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2000538, 200053, 'text', 'courseFamily', 'Enter the course family', '', '', 'alphaChars', '(Example:  ENGL)', 'Y', '', 4, 4, 'Y', 1, 4, 4, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000555, 100054, 'select', 'classType', 'Type:', '', '', 'select', '', 'N', '', 1, 1, 'Y', 4, 1, 0, 'ITV=ITV,Internet=Internet,2WayAudioVideo=2WayAudioVideo', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483655, 100054, 'customField', 'facultyId', 'Select the Faculty', '', '', 'select', '', '', '', 1, 1, 'Y', 3, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 9, '', '', '', 'faculty')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000540, 100054, 'row', '', '', 'Please complete the following fields to add a course to the site.', '', '', '', '', '', 0, 0, '', 1, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000559, 100055, 'text', 'username', 'Enter the Username', '', '', 'default', '(spaces are not allowed)', 'Y', '', 1, 32, 'Y', 2, 15, 32, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000557, 100054, 'textarea', 'sectionNumbers', 'Class Section Number(s)', '', '', 'default', '(ENTER ONE ENTRY PER LINE)', 'Y', '', 1, 65535, 'N', 10, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 5, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483660, 100054, 'customField', 'id_semesters', 'Select a Semester', '', '', 'select', '', '', '', 1, 1, 'Y', 8, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 10, '', '', '', 'semester')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1054222981, 1054222970, 'row', '', '', 'Select the semester term and year below.', '', '', '', '', '', 0, 0, '', 2, 0, 0, '', '', '', '', 0, 0, '', 0, 'instructions', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000548, 100054, 'submit', 'submit', '', 'Add Class', '', '', '', '', '', 0, 0, '', 11, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 7, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2000610, 100056, 'text', 'title', 'Entry Title', '', '', 'default', '', 'N', '', 1, 255, 'Y', 1, 15, 25, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 5, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000558, 100055, 'row', '', '', 'Account Information', '', '', '', '', '', 0, 0, '', 1, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000560, 100055, 'password', 'password', 'Enter the password', '', '', '', '', '', '', 1, 32, 'Y', 3, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000561, 100055, 'password', 'password2', 'Enter your password', '', '', '', '', '', '', 1, 32, 'Y', 4, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000562, 100055, 'text', 'email', 'Email Address', '', '', 'email', '(must be a valid email address)', 'Y', '', 6, 50, 'Y', 8, 25, 50, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 5, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000563, 100055, 'checkbox', 'sendemail', 'Check to notify this user of their new account by email.', '', '', '', '', '', '', 0, 0, 'N', 9, 0, 0, '', 'N', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 6, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000564, 100055, 'submit', 'submit', '', 'Add User', '', '', '', '', '', 0, 0, '', 15, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 7, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000565, 100055, 'hidden', 'event', '', 'createaccount', '', '', '', '', '', 0, 0, '', 16, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 8, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000566, 100056, 'text', 'gradebookCode', 'Gradebook Code', '', '', 'default', '', 'Y', '', 1, 10, 'Y', 2, 10, 10, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000567, 100056, 'text', 'totalPoints', 'Total Possible Points', '', '', 'default', '(numbers only)', 'Y', '', 1, 10, 'Y', 3, 10, 10, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000568, 100056, 'hidden', 'event', '', 'update', '', '', '', '', '', 0, 0, '', 6, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000569, 100056, 'submit', 'submit', '', 'Add Entry', '', '', '', '', '', 0, 0, '', 7, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000570, 100057, 'radio', 'calculationType', 'Select your grading type:', '1', '', 'radio', '', '', '', 0, 0, 'Y', 1, 0, 0, '1=Percentage,2=Points', 'Y', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000571, 100057, 'hidden', 'event', '', 'chooseGradeOptionUpdate', '', '', '', '', '', 0, 0, '', 4, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000572, 100057, 'submit', 'submit', '', 'Save', '', '', '', '', '', 0, 0, '', 15, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000573, 100058, 'select', 'dropped', 'Student Dropped', '', '', 'select', '', 'N', '', 1, 1, 'N', 1, 1, 0, '#FFFFFF=White,#FFCCCC=Blue,#FFFFCC=Red', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000574, 100058, 'select', 'incomplete', 'Incomplete Grade', '', '', 'select', '', 'N', '', 1, 1, 'N', 2, 1, 0, '#FFFFFF=White,#FFCCCC=Blue,#FFFFCC=Red', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000575, 100058, 'select', 'nograde', 'Missing Grade', '', '', 'select', '', 'N', '', 1, 1, 'N', 3, 1, 0, '#FFFFFF=White,#FFCCCC=Blue,#FFFFCC=Red', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000576, 100058, 'select', 'fail', 'Failing Grade', '', '', 'select', '', 'N', '', 1, 1, 'N', 4, 1, 0, '#FFFFFF=White,#FFCCCC=Blue,#FFFFCC=Red', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000577, 100058, 'hidden', 'event', '', 'chooseColorOptionSave', '', '', '', '', '', 0, 0, '', 5, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 5, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000580, 100059, 'select', 'list', 'Select the options you wish to export:', '', '', 'select', '', 'N', '', 1, 1, '\r', 1, 10, 0, 'assmt=Assessments,files=File Manager,webfiles=Web Files,lessons=Lesson Plans,faq=FAQs', '', 'Y', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000579, 100058, 'submit', 'submit', '', 'Save', '', '', '', '', '', 0, 0, '', 7, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 7, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000581, 100059, 'hidden', 'event', '', 'exportClass', '', '', '', '', '', 0, 0, '', 2, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1000582, 100059, 'submit', 'submit', '', 'Export', '', '', '', '', '', 0, 0, '', 3, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2000570, 200053, 'text', 'coReq2', '2:', '', '', 'default', '', 'Y', '', 1, 100, 'N', 17, 25, 100, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 15, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2000561, 200053, 'row', '', '', '', '', '', '', '', '', 0, 0, '', 3, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 7, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2000564, 200053, 'text', 'preReq2', '2:', '', '', 'default', '', 'Y', '', 1, 100, 'N', 11, 25, 100, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 10, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2000575, 200053, 'row', '', '', 'Corequisites:', '', '', '', '', '', 0, 0, '', 15, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 20, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2000563, 200053, 'text', 'preReq1', '1:', '', '', 'default', '', 'Y', '', 1, 100, 'N', 10, 25, 100, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 9, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2000566, 200053, 'text', 'preReq4', '4:', '', '', 'default', '', 'Y', '', 1, 100, 'N', 13, 25, 100, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 12, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2000567, 200053, 'row', '', '', 'Prerequisites', '', '', '', '', '', 0, 0, '', 9, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 13, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2000571, 200053, 'text', 'coReq3', '3:', '', '', 'default', '', 'Y', '', 1, 100, 'N', 18, 25, 100, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 16, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2000572, 200053, 'text', 'coReq4', '4:', '', '', 'default', '', 'Y', '', 1, 100, 'N', 19, 25, 100, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 17, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2000574, 200053, 'submit', 'addcourse', '', 'Add Course!', '', '', '', '', '', 0, 0, '', 21, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 19, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;

?>