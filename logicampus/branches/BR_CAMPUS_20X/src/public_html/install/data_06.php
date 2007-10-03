<?
$installTableSchemas = array();
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483696, 2147483653, 'select', 'htmltype', 'HTML Type', 'Normal', '', 'select', 'Use SmartHTML to convert returns to html newlines.', 'N', '', 1, 1, 'N', 2, 1, 0, '0=Normal,1=SmartHTML', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 5, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483697, 2147483655, 'text', 'title', 'Title', '', '', 'default', '', 'Y', '', 1, 255, 'Y', 1, 50, 255, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483698, 2147483655, 'select', 'status', 'Status', '', '', 'select', '', 'N', '', 1, 1, 'N', 2, 1, 0, '0=pending,1=approved', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483699, 2147483655, 'submit', 'submit', '', 'Update Presentation', '', '', '', '', '', 0, 0, '', 4, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483700, 2147483655, 'textarea', 'content', 'Presentation', '', '', 'default', '', 'N', '', 1, 65535, 'Y', 3, 0, 0, '', '', '', '', 50, 20, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 4, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483701, 2147483657, 'text', 'txTitle', 'Enter a new category name', '', '', 'default', '', 'Y', '', 3, 50, 'Y', 1, 50, 255, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483702, 2147483657, 'submit', 'submit', '', 'Add Category', '', '', '', '', '', 0, 0, '', 4, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483703, 2147483656, 'submit', 'removecatsubmit', '', 'Remove Category', '', '', '', '', '', 0, 0, '', 3, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483704, 2147483656, 'customField', 'categoryRem', 'Select category to remove', '', '', 'select', 'Any links that are attached to this category will be removed? (????) i need to know what to do with the orphan links.', '', '', 1, 1, 'Y', 1, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', 'linkCategories')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483705, 2147483658, 'text', 'objective', 'Objective', '', '', 'default', '', 'N', '', 1, 65535, 'Y', 1, 40, 65535, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483706, 2147483658, 'submit', 'submit', '', 'Add Objective', '', '', '', '', '', 0, 0, '', 3, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483707, 2147483656, 'hidden', 'event', '', 'removecat', '', '', '', '', '', 0, 0, '', 2, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483708, 2147483657, 'hidden', 'event', '', 'addcat', '', '', '', '', '', 0, 0, '', 3, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483709, 2147483659, 'text', 'title', 'Link text', '', '', 'default', '', 'N', '', 3, 255, 'Y', 1, 15, 255, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483711, 2147483659, 'text', 'url', 'Link (http://www.domain.com)', 'http://', '', 'default', '', 'Y', '', 6, 150, 'Y', 2, 40, 150, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483712, 2147483659, 'textarea', 'description', 'Link description', '', '', 'default', '', 'N', '', 1, 65535, 'N', 3, 0, 0, '', '', '', '', 40, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', 'E')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483713, 2147483659, 'customField', 'id_class_links_categories', 'Select category', '', '', 'select', '', '', '', 1, 1, 'N', 4, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 4, '', '', '', 'LinkCategoriesWithTop')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483714, 2147483659, 'hidden', 'event', '', 'process', '', '', '', '', '', 0, 0, '', 5, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 5, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483715, 2147483659, 'submit', 'submit', '', 'Add Web Link', '', '', '', '', '', 0, 0, '', 6, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 6, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483716, 5, 'select', 'extra', 'Use WYSIWYG Editor Type', 'N', '', 'select', '(None: normal textarea.)', 'N', '', 1, 1, 'Y', 7, 1, 0, 'N=None,S=Standard,L=Limited,E=Extended', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 19, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483833, 120005601, 'textarea', 'emailGuidelines', 'Email Guidelines', '', '', 'default', '', 'N', '', 1, 65535, 'Y', 19, 0, 0, '', '', '', '', 40, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 22, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483722, 2147483660, 'textarea', 'other', 'Other Special Information', 'Enter other special information here.', '', 'default', '', 'N', '', 1, 65535, 'N', 10, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '', '', '', 'L')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483724, 2147483660, 'textarea', 'courseObjectives', 'Course Objectives', '', '', 'default', 'Enter Course Objectives, one per line.', 'N', '', 1, 65535, 'N', 1, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 5, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483725, 2147483660, 'textarea', 'courseReqs', 'Course Requirements', 'Use WYSIWYG editor.', '', 'default', '', 'N', '', 1, 65535, 'Y', 5, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 6, '', '', '', 'L')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483726, 2147483660, 'textarea', 'gradingScale', 'Point Allocation of Grades', '', '', 'default', 'This field will be rendered as a table on the syllabus. The columns go in this order: Activity, Points, Total Points. Separate table cells with pipe symbols (|) and each row with a return. Example: Exams|3 @ 200 points each|600 points', 'N', '', 1, 65535, 'Y', 6, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 7, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483730, 2147483657, 'customField', 'id_class_links_categories_parent', 'Select parent category', '', '', 'select', '', '', '', 1, 1, 'N', 2, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 4, '', '', '', 'LinkCategoriesWithTop')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483731, 100047, 'hidden', 'event', '', 'update', '', '', '', '', '', 0, 0, '', 35, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 25, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483732, 2147483660, 'hidden', 'event', '', 'update', '', '', '', '', '', 0, 0, '', 12, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 9, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483733, 2147483660, 'submit', 'submit', '', 'Update Syllabus', '', '', '', '', '', 0, 0, '', 13, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 10, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483734, 100047, 'row', '', '', 'Office Hours', '', '', '', '', '', 0, 0, '', 28, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 26, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483736, 100047, 'text', 'offHrsTuesday', 'Tuesday', '', '', 'default', '', 'Y', '', 1, 255, 'N', 31, 30, 255, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 28, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483737, 100047, 'text', 'offHrsWednesday', 'Wednesday', '', '', 'default', '', 'Y', '', 1, 255, 'N', 32, 30, 255, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 29, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483738, 100047, 'text', 'offHrsThursday', 'Thursday', '', '', 'default', '', 'Y', '', 1, 255, 'N', 33, 30, 255, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 30, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483739, 100047, 'text', 'offHrsFriday', 'Friday', '', '', 'default', '', 'Y', '', 1, 255, 'N', 34, 30, 255, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 31, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483740, 100047, 'row', '', '', 'Please enter a comma separated list of time ranges. Example: "8:00am - 11:00am, 1:00pm - 5:00pm"', '', '', '', '', '', 0, 0, '', 29, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 32, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483748, 2147483661, 'text', 'title', 'Title', '', '', 'default', '', 'N', '', 1, 255, 'Y', 1, 35, 255, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483745, 100055, 'row', '', '', 'Personal Information', '', '', '', '', '', 0, 0, '', 5, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 15, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483752, 2147483661, 'customField', 'assignments', 'Assignments', '', '', 'select', '', '', '', 1, 1, 'N', 8, 5, 0, '', '', 'Y', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 5, '', '', '', 'selectClassAssignments')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483753, 2147483661, 'customField', 'links', 'Webliography', '', '', 'default', '', '', '', 1, 1, 'N', 9, 5, 0, '', '', 'Y', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 6, '', '', '', 'selectClassLinks')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483754, 2147483661, 'submit', 'submit', '', 'Create Lesson', '', '', '', '', '', 0, 0, '', 10, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 7, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483755, 2147483661, 'hidden', 'event', '', 'update', '', '', '', '', '', 0, 0, '', 11, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 8, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483801, 2147483663, 'text', 'emergencyContact', 'Emergency Contact', '', '', 'default', '', 'Y', '', 1, 50, 'Y', 20, 50, 50, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:7:"faculty";}', '', 9, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483791, 2147483663, 'text', 'address2', 'Address line two', '', '', 'default', '', 'Y', '', 1, 70, 'N', 5, 25, 70, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 10, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483788, 2147483663, 'customField', 'cellPhone', 'Cell phone', '', '', 'phoneNumber', '', '', '', 1, 1, 'N', 14, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 11, '', '', '', 'phoneNumber')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483784, 2147483663, 'text', 'zip', 'Zip', '', '', 'numericChars', '', 'Y', '', 5, 5, 'Y', 8, 5, 5, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 12, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483756, 1, 'submit', 'submit', '', 'Enter', '', '', '', '', '', 0, 0, '', 14, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 14, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483759, 2147483662, 'text', 'tx_title', 'Title', '', '', 'default', '', 'Y', '', 1, 255, 'Y', 1, 50, 255, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 1, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483760, 2147483662, 'textarea', 'tx_description', 'Description', '', '', 'default', '', 'N', '', 1, 65535, 'Y', 2, 0, 0, '', '', '', '', 55, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 2, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483761, 2147483662, 'dateDropDown', 'dt_display', 'Display Date', '', '', '', '', '', '', 0, 0, 'N', 3, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 3, '0', '+2', '7', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483762, 2147483662, 'submit', 'submit', '', 'Add Announcement', '', '', '', '', '', 0, 0, '', 5, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 4, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483763, 2147483662, 'hidden', 'event', '', 'add', '', '', '', '', '', 0, 0, '', 4, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 5, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483764, 3, 'customField', 'groups', 'Select groups', 'public', '', 'select', '(press ctrl to select multiple groups that are allowed to view this field)', '', '', 1, 1, 'Y', 7, 7, 0, '', '', 'Y', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 19, '', '', '', 'groups')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483790, 2147483663, 'text', 'address', 'Address line one', '', '', 'default', '', 'Y', '', 1, 70, 'Y', 4, 25, 70, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 13, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483800, 2147483663, 'row', '', '', 'Addtional Contact Information', '', '', '', '', '', 0, 0, '', 18, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:5:"admin";}', '', 14, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483797, 2147483663, 'text', 'yim', 'Yahoo Instant Messenger ID', '', '', 'default', '', 'Y', '', 0, 0, 'N', 47, 20, 30, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 15, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483796, 2147483663, 'text', 'aim', 'Aol Instant Messenger handle', '', '', 'default', '', 'Y', '', 0, 0, 'N', 46, 20, 20, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 16, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483795, 2147483663, 'text', 'icq', 'ICQ Number', '', '', 'default', '', 'Y', '', 0, 0, 'N', 45, 20, 20, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 17, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483792, 2147483663, 'radio', 'showaddinfo', 'Show personal info?', 'N', '', 'radio', '', '', '', 0, 0, 'Y', 16, 0, 0, 'N=No,Y=Yes', 'Y', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 18, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483787, 2147483663, 'customField', 'faxPhone', 'Fax', '', '', 'phoneNumber', '', '', '', 1, 1, 'N', 13, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 19, '', '', '', 'phoneNumber')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483783, 2147483663, 'text', 'state', 'State', 'TX', '', 'alphaChars', '', 'Y', '', 2, 20, 'Y', 7, 2, 2, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 20, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483781, 2147483663, 'text', 'emailAlternate', 'Alternate email address', '', '', 'email', '', 'Y', '', 5, 50, 'N', 9, 25, 50, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 21, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483780, 2147483663, 'text', 'lastname', 'Last name', '', '', 'default', '', 'Y', '', 1, 30, 'Y', 3, 25, 30, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 22, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2147483819, 2147483661, 'dateDropDown', 'inactiveOn', 'Deactivate On', '', '', '', '', '', '', 0, 0, 'N', 3, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:7:"faculty";}', '', 10, '0', '+2', '7', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1055940709, 1055940690, 'dateDropDown', 'activeOn', 'Activate On', '', '', '', '', '', '', 0, 0, 'N', 2, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:7:"faculty";}', '', 9, '0', '+2', '7', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1055940708, 1055940690, 'dateDropDown', 'inactiveOn', 'Deactivate On', '', '', '', '', '', '', 0, 0, 'N', 3, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:7:"faculty";}', '', 10, '0', '+2', '7', '')
campusdelimeter;
$installTableSchemas[] = $table;

?>