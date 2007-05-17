<?
$installTableSchemas = array();
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483842, 2147483666, 'row', '', '', 'Please check the campuses on which these exams will take place, if any.', '', '', '', '', '', 0, 0, '', 3, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:7:"exammgr";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483843, 2147483666, 'checkbox', 'southeastCampus', 'Southeast campus', '', '', '', '', '', '', 0, 0, 'N', 6, 0, 0, '', 'N', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"exammgr";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483844, 2147483666, 'checkbox', 'northeastCampus', 'Northeast campus', '', '', '', '', '', '', 0, 0, 'N', 7, 0, 0, '', 'N', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"exammgr";}', '', 5, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483845, 2147483666, 'checkbox', 'northwestCampus', 'Northwest campus', '', '', '', '', '', '', 0, 0, 'N', 8, 0, 0, '', 'N', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"exammgr";}', '', 6, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483846, 2147483666, 'customField', 'emClassDates', 'Exam Dates and Info', '', '', 'emClassDates', '', '', '', 0, 1, 'Y', 10, 1, 0, '', '', 'Y', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 7, '', '', '', 'emClassDates')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483847, 2147483667, 'row', '', '', 'First Orientation Date', '', '', '', '', '', 0, 0, '', 1, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:7:"faculty";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483848, 2147483668, 'row', '', '', 'Add Semester Dates', '', '', '', '', '', 0, 0, '', 1, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:6:"semmgr";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483849, 2147483668, 'dateDropDown', 'date', 'Enter Date', '', '', '', '', '', '', 0, 0, 'N', 2, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:6:"semmgr";}', '', 2, '0', '+6', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483855, 2147483668, 'submit', 'submit', '', 'Enter', '', '', '', '', '', 0, 0, '', 3, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:6:"semmgr";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483856, 2147483668, 'hidden', 'event', '', 'update', '', '', '', '', '', 0, 0, '', 4, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:6:"semmgr";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483851, 2147483666, 'hidden', 'event', '', 'update', '', '', '', '', '', 0, 0, '', 11, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 8, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483852, 2147483666, 'submit', 'submit', '', 'Submit', '', '', '', '', '', 0, 0, '', 12, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 9, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483853, 2147483666, 'row', '', '', 'Exam Dates', '', '', '', '', '', 0, 0, '', 9, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 10, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483993, 1059934774, 'customField', 'category', 'Category', '', '', 'select', '', '', '', 1, 1, 'Y', 5, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 6, '', '', '', 'helpdeskCategories')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483937, 2147483672, 'textarea', 'note', 'Note', '', '', 'default', '', 'Y', '', 1, 65535, 'N', 16, 0, 0, '', '', '', '', 40, 15, '', 0, '', 'a:2:{i:0;s:5:"admin";i:1;s:7:"tbadmin";}', '', 18, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483944, 1054222970, 'row', '', '', 'instructions: Enter the dates that teachers may enter examination scheduling requests.', '', '', '', '', '', 0, 0, '', 39, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 45, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483857, 2147483666, 'textarea', 'note', 'Personal Note', '', '', 'default', '', 'N', '', 1, 65535, 'N', 2, 0, 0, '', '', '', '', 40, 5, '', 0, '', 'a:1:{i:0;s:7:"exammgr";}', '', 12, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483858, 2147483669, 'row', '', '', 'Select Date / Time', '', '', '', '', '', 0, 0, '', 1, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483859, 2147483669, 'dateDropDown', 'southDate', 'South Campus', '', '', '', '', '', '', 0, 0, 'N', 2, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 2, '0', '+1', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483872, 2147483669, 'dateDropDown', 'northwestDate', 'Northwest Campus', '', '', '', '', '', '', 0, 0, 'N', 4, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 4, '0', '+1', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483867, 2147483671, 'select', 'firstAllottedMinutes', 'Session Length', '', '', 'select', '', 'N', '', 1, 1, 'N', 3, 1, 0, '50=50 minute session,80=80 minute session', '', 'N', 'N', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483871, 2147483669, 'dateDropDown', 'northeastDate', 'Northeast Campus', '', '', '', '', '', '', 0, 0, 'N', 3, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 3, '0', '+1', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483863, 2147483670, 'dateDropDown', 'dateStart', 'Start Date', '', '', '', '', '', '', 0, 0, 'N', 1, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 1, '0', '+2', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483864, 2147483670, 'dateDropDown', 'dateEnd', 'End Date', '', '', '', '', '', '', 0, 0, 'N', 2, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '0', '+2', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483865, 2147483670, 'hidden', 'event', '', 'update', '', '', '', '', '', 0, 0, '', 3, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483866, 2147483670, 'submit', 'submit', '', 'Create Testing Period', '', '', '', '', '', 0, 0, '', 4, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483874, 2147483669, 'row', '', '', 'Select an alternate time range for the South Campus.', '', '', '', '', '', 0, 0, '', 6, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 6, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483869, 2147483671, 'textarea', 'instructions', 'Special Instructions', '', '', 'default', '', 'N', '', 1, 65535, 'N', 17, 0, 0, '', '', '', '', 50, 10, '', 0, '', 'a:3:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:6:"semmgr";}', '', 2, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483873, 2147483669, 'dateDropDown', 'southeastDate', 'Southeast Date', '', '', '', '', '', '', 0, 0, 'N', 5, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 5, '0', '+1', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483875, 2147483669, 'dateDropDown', 'southTimeStart', 'South Start Time', '', '', '', '', '', '', 0, 0, 'N', 7, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 7, '0', '0', '56', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483876, 2147483669, 'dateDropDown', 'southTimeEnd', 'South End Time', '', '', '', '', '', '', 0, 0, 'N', 8, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 8, '0', '0', '56', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483877, 2147483669, 'row', '', '', 'Select and alternate time range for the Northeast Campus', '', '', '', '', '', 0, 0, '', 9, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 9, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483878, 2147483671, 'select', 'firstCampusLocation', 'Campus', '', '', 'select', '', 'N', '', 1, 1, 'N', 4, 1, 0, 'SO=South Campus,SE=Southeast Campus,NE=Northeast Campus,NW=Northwest Campus', '', 'N', 'N', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483879, 2147483669, 'dateDropDown', 'northeastTimeStart', 'Northeast Start Time', '', '', '', '', '', '', 0, 0, 'N', 10, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 10, '0', '0', '56', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483880, 2147483669, 'dateDropDown', 'northeastTimeEnd', 'Northeast End Time', '', '', '', '', '', '', 0, 0, 'N', 11, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 11, '0', '0', '56', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483881, 2147483671, 'dateDropDown', 'firstPreferredTime', 'Preferred Time', '', '', '', '', '', '', 0, 0, 'N', 6, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 4, '0', '0', '56', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483882, 2147483669, 'row', '', '', 'Select an alternate time for the Northwest Campus', '', '', '', '', '', 0, 0, '', 12, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 12, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483883, 2147483669, 'dateDropDown', 'northwestTimeStart', 'Northwest Start Time', '', '', '', '', '', '', 0, 0, 'N', 13, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 13, '0', '0', '56', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483884, 2147483669, 'dateDropDown', 'northwestTimeEnd', 'Northwest End Time', '', '', '', '', '', '', 0, 0, 'N', 14, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 14, '0', '0', '56', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483885, 2147483671, 'dateDropDown', 'firstTimeRangeStart', 'Acceptable Time Start:', '', '', '', '', '', '', 0, 0, 'N', 7, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 5, '0', '0', '56', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483886, 2147483669, 'row', '', '', 'Select an alternate time range for the Southeast Campus', '', '', '', '', '', 0, 0, '', 15, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 15, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1067288454, 1067288444, 'row', '', '', 'Course Information', '', '', '', '', '', 0, 0, '', 1, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483888, 2147483669, 'dateDropDown', 'southeastTimeStart', 'Southeast Start Time', '', '', '', '', '', '', 0, 0, 'N', 16, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 16, '0', '0', '56', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483889, 2147483669, 'dateDropDown', 'southeastTimeEnd', 'Southeast End Time', '', '', '', '', '', '', 0, 0, 'N', 17, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:6:"semmgr";}', '', 17, '0', '0', '56', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483890, 2147483669, 'hidden', 'event', '', 'update', '', '', '', '', '', 0, 0, '', 18, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 18, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483891, 2147483669, 'submit', 'submit', '', 'Enter', '', '', '', '', '', 0, 0, '', 21, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 19, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483892, 2147483671, 'row', '', '', '<center>\r\n<Br>\r\n<b>\r\nSecondary Choices (if all else fails)\r\n</b>\r\n<BR>Note:  This relates to the above selection - this is not your second orientation choice.\r\n</center>', '', '', '', '', '', 0, 0, '', 9, 0, 0, '', '', '', '', 0, 0, '', 0, 'frmSectionIndicator', 'a:4:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:6:"semmgr";i:3;s:8:"semrmsch";}', '', 7, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483893, 2147483671, 'select', 'secondAllottedMinutes', 'Session Length', '', '', 'select', '', 'N', '', 1, 1, 'N', 10, 1, 0, '50=50 minute session,80=80 minute session', '', 'N', 'N', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 8, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483894, 2147483671, 'select', 'secondCampusLocation', 'Campus Location', '', '', 'select', '', 'N', '', 1, 1, 'N', 11, 1, 0, 'SO=South Campus,SE=Southeast Campus,NE=Northeast Campus,NW=Northwest Campus', '', 'N', 'N', 0, 0, '', 0, '', 'a:4:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:6:"semmgr";i:3;s:8:"semrmsch";}', '', 9, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483895, 2147483671, 'dateDropDown', 'secondPreferredTime', 'Preferred Time', '', '', '', '', '', '', 0, 0, 'N', 13, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:4:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:6:"semmgr";i:3;s:8:"semrmsch";}', '', 10, '0', '0', '56', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483896, 2147483671, 'dateDropDown', 'secondTimeRangeStart', 'Acceptable Time Start', '', '', '', '', '', '', 0, 0, 'N', 14, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:4:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:6:"semmgr";i:3;s:8:"semrmsch";}', '', 11, '0', '0', '56', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147484002, 120005599, 'select', 'req', 'Is this a required field?', 'Y', '', 'select', '', 'N', '', 1, 1, 'Y', 4, 1, 0, 'Y=Yes,N=No', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:6:"public";}', '', 10, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483898, 2147483671, 'row', '', '', '<Br><h5>Special Instructions</h5>\r\nPlease enter anything special you need for this orientation.', '', '', '', '', '', 0, 0, '', 16, 0, 0, '', '', '', '', 0, 0, '', 0, 'frmRowSpecial', 'a:4:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:6:"semmgr";i:3;s:8:"semrmsch";}', '', 13, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483899, 2147483671, 'customField', 'firstDateId', 'Preferred Date', '', '', 'select', '', '', '', 1, 1, 'Y', 5, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 14, '', '', '', 'orientationDates')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483929, 1054222970, 'dateDropDown', 'dateStartOrientation', 'Orientation start sched.', '', '', '', '', '', '', 0, 0, 'N', 36, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:5:"admin";}', '', 33, '0', '0', '63', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483900, 2147483671, 'customField', 'secondDateId', 'Secondary Preferred Date', '', '', 'select', '', '', '', 1, 1, 'Y', 12, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:2:{i:0;s:7:"faculty";i:1;s:6:"semmgr";}', '', 15, '', '', '', 'orientationDates')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483901, 2147483671, 'hidden', 'idOrientationClasses', '', '0', '', '', '', '', '', 0, 0, '', 19, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:4:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:6:"semmgr";i:3;s:8:"semrmsch";}', '', 16, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483902, 2147483671, 'submit', 'submit', '', 'Submit', '', '', '', '', '', 0, 0, '', 20, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:4:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:6:"semmgr";i:3;s:8:"semrmsch";}', '', 17, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483903, 2147483669, 'textarea', 'note', 'Note', '', '', 'default', '', 'Y', '', 1, 65535, 'N', 19, 0, 0, '', '', '', '', 40, 15, '', 0, '', 'a:1:{i:0;s:6:"semmgr";}', '', 20, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483904, 2147483669, 'select', 'entryStatus', 'Change Status', '', '', 'select', '', 'N', '', 1, 1, 'Y', 20, 1, 0, '=Select One,1=New,2=Pending,3=Approved,4=Waiting       On Instructor', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:6:"semmgr";}', '', 21, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483905, 2147483671, 'customField', 'status', 'Status', '', '', 'select', '', '', '', 1, 1, 'Y', 2, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:6:"semmgr";}', '', 18, '', '', '', 'orientationStatus')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483906, 2147483674, 'dateDropDown', 'date', 'Date', '', '', '', '', '', '', 0, 0, 'N', 1, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:4:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:6:"semmgr";i:3;s:8:"semrmsch";}', '', 1, '0', '+4', '7', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483907, 2147483672, 'text', 'title', 'Title', '', '', 'default', '', 'N', '', 1, 255, 'Y', 4, 40, 255, '', '', '', '', 0, 0, '', 0, '', 'a:3:{i:0;s:5:"admin";i:1;s:7:"faculty";i:2;s:7:"tbadmin";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;

?>