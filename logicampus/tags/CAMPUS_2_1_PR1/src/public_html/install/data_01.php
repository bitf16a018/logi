<?
$installTableSchemas = array();
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (1, 1, 'text', 'name', 'Enter your name', '', '', 'default', '', 'Y', '', 3, 15, 'Y', 1, 15, 25, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (2, 1, 'textarea', 'body', 'Enter your\nmessage', '', '', 'default', '', 'Y', '&lt;h3&gt;', 1, 65535, 'Y', 2, 0, 25, '', '', '', '', 25, 15, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (3, 1, 'text', 'email', 'Enter your\nemail\naddress', '', '', 'email', '(email must be a valid email\naddress)', 'Y', '', 5, 100, 'Y', 3, 15, 100, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (4, 1, 'hidden', 'formId', '', '1', '', '', '', '', '', 0, 0, 'N', 4, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (7, 1, 'row', '', '', 'Enter your message\nbelow.\nSomeone will contact you shortly.', '', '', '', '', '', 0, 0, '', 5, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (6, 1, 'text', 'subject', 'Enter your Subject', '', '', 'default', '', 'Y', '', 3, 25, 'Y', 6, 15, 25, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (8, 2, 'text', 'name', 'Enter a name for\nyour\nform', '', '', 'default', '(Example:  &quot;User\nProfile&quot;)', 'Y', '', 5, 75, 'Y', 2, 25, 75, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (9, 2, 'textarea', 'description', 'Enter\na\ndescription', '', '', 'default', '', 'Y', '', 1, 65535, 'Y', 3, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (10, 2, 'text', 'action', 'What is\nthe\n&quot;action&quot; of your form?', '', '', 'default', 'Example:\nhttp://www.site.com/form.php', 'Y', '', 3, 100, 'N', 16, 25, 100, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (149, 2, 'select', 'method', 'Enter the\nform\nmethod', 'POST', '', 'select', 'There are two types of\nmethods, GET\nand POST.  Select one.', 'N', '', 1, 1, 'Y', 5, 1, 0, 'POST=POST,GET=GET', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (12, 2, 'text', 'target', 'Enter the target\nof\nyour form', '', '', 'default', '(normally used with frames)', 'Y', '', 3, 25, 'N', 15, 25, 25, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (13, 2, 'select', 'enctype', 'Form encoding\ntype', 'application/x-www-form-urlencoded', '', 'default', '(select\nmultipart/form-data if you are building a form to handle file\nuploads)', 'N', '', 1, 25, 'N', 17, 1, 2, 'application/x-www-form-urlencoded=application/x-www-form-urlencoded,multipart/form-data=multipart/form-data\n', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (14, 2, 'select', 'border', 'Table border\nwidth', '0', '', 'default', '', 'N', '', 1, 2, 'Y', 11, 1, 2, '0=None,1=1,2=2,3=3,4=4,5=5', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (15, 2, 'select', 'cellpadding', 'Table\ncellpadding', '0', '', 'default', '', 'Y', '', 1, 2, 'Y', 13, 1, 2, '0=None,1=1,2=2,3=3,4=4,5=5', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (16, 2, 'select', 'cellspacing', 'Table\ncellspacing', '0', '', 'default', '', 'Y', '', 1, 2, 'Y', 12, 1, 2, '0=None,1=1,2=2,3=3,4=4,5=5', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (17, 2, 'text', 'width', 'Table width', '75%', '', 'default', '', 'Y', '', 1, 4, 'Y', 10, 2, 4, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (18, 2, 'hidden', 'event', '', 'addModifyFormPost', '', 'default', '', '', '', 0, 0, '', 18, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (19, 2, 'submit', 'submit', '', 'Enter', '', 'default', '', '', '', 0, 0, '', 20, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (20, 2, 'row', '', '', 'Step 1 - Required\nFields', '', 'default', '', '', '', 0, 0, '', 1, 0, 0, '', '', '', '', 0, 0, '', 0, 'formHeading', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (21, 2, 'hidden', 'formId', '', '2', '', '', '', '', '', 0, 0, 'N', 19, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (163, 2, 'text', 'type', 'Form Type', 'site', '', 'default', 'The type of form should be left to \'site\' unless you are developing new types of form elements.', 'Y', '', 1, 25, 'Y', 7, 25, 25, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (23, 3, 'text', 'fieldName', 'Enter the\nfield\nname', '', '', 'default', '', 'Y', '', 1, 100, 'Y', 2, 15, 100, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (24, 3, 'text', 'displayName', 'Display Name', '', '', 'default', '(this is what people will read to know what to\nfill\nin, example: Phone Number)', 'N', '&lt;b&gt;&lt;/b&gt;&lt;i&gt;&lt;/i&gt;&lt;a&gt;&lt;/a&gt;', 1, 255, 'Y', 3, 15, 255, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (25, 3, 'textarea', 'defaultValue', 'Enter\nthe\ndefault value for this form field', '', '', 'default', '', 'Y', '', 1, 65535, 'N', 9, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (26, 3, 'textarea', 'exp', 'Regular\nExpression', '', '', 'default', '(enter a regular expression for\nthis data)', 'Y', '', 1, 65535, 'N', 10, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (27, 3, 'select', 'validationType', 'Chooseformvalidation type', 'default', '', 'select', '(default checks\r\nagainst\r\nany regular expressions enter as well as min/max\r\nlengths)', 'N', '', 1, 1, 'N', 11, 0, 0, 'default=Default,email=Email Address,select=Select Drop Down,alphaChars=Only allow Alpha Characters,numericChars=Only allow Numbers,alphaNumeric=Alpha and Numeric', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (28, 3, 'textarea', 'message', 'Instructions\nor\nhelp', '', '', 'default', '(messages are displayed where this\ntext is,\nunderneath the form as help)', 'N', '', 1, 65535, 'N', 12, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (29, 3, 'select', 'stripTags', 'Strip HTML\nTags?', 'N', '', 'default', '', 'N', '', 1, 1, 'N', 13, 1, 0, 'N=No, Y=Yes', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (30, 3, 'text', 'allowedTags', 'Allowed\nHTML\nTags', '', '', 'default', '(Optional if you say yes above.\nEnter HTML\ntags you will allow, example: &amp;lt;b&amp;gt;', 'N', '', 1, 255, 'N', 14, 15, 255, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (31, 3, 'row', '', '', 'Step 3 - Form\nValidation', '', '', '', '', '', 0, 0, '', 15, 0, 0, '', '', '', '', 0, 0, '', 0, 'formHeading', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (32, 3, 'text', 'min', 'Minimum Input Length', '1', '', 'default', '(numbers only)', 'Y', '', 1, 7, 'N', 16, 4, 7, '', '', '', '', 0, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (33, 3, 'text', 'max', 'Maximum Length\nAllowed', '1', '', 'default', '(numbers only)', 'Y', '', 1, 7, 'N', 17, 4, 7, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (34, 3, 'select', 'req', 'Is this a required field?', '', '', 'select', '', 'N', '', 1, 1, 'Y', 4, 1, 0, 'N=No,Y=Yes', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (35, 3, 'text', 'size', 'Field Size', '15', '', 'default', '(numbers only)', 'Y', '', 1, 5, 'Y', 5, 5, 5, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (36, 3, 'text', 'maxlength', 'Maximum\nField\nLength', '25', '', 'default', '(numbers only)', 'Y', '', 1, 5, 'Y', 6, 5, 5, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (37, 3, 'hidden', 'event', '', 'addModifyFormFieldPost', '', '', '', '', '', 0, 0, '', 18, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (39, 3, 'hidden', 'type', '', 'text', '', '', '', '', '', 0, 0, '', 19, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (46, 4, 'text', 'fieldName', 'Enter the\r\nfield\r\nname', '', '', 'default', '', 'Y', '', 1, 100, 'Y', 2, 50, 100, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (47, 4, 'text', 'displayName', 'Display Name', '', '', 'default', '(this is what people will read to know what to\nfill\nin, example: Phone Number)', 'N', '&lt;b&gt;&lt;/b&gt;&lt;i&gt;&lt;/i&gt;&lt;a&gt;&lt;/a&gt;', 1, 255, 'Y', 3, 15, 255, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (48, 4, 'textarea', 'defaultValue', 'Enter\nthe\ndefault value for this form field', '', '', 'default', '', 'Y', '', 1, 65535, 'N', 9, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (49, 4, 'textarea', 'message', 'Instructions\nor\nhelp', '', '', 'default', '(messages are displayed where this\ntext is,\nunderneath the form as help)', 'N', '', 1, 65535, 'N', 10, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (60, 4, 'select', 'multiple', 'Is this a\nmutiple\nselect form?', 'N', '', 'default', '', 'N', '', 1, 1, 'Y', 5, 1, 0, 'N=No,Y=Yes', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (51, 4, 'hidden', 'min', '', '1', '', 'default', '', 'Y', '', 1, 7, 'N', 14, 4, 7, '', '', '', '', 0, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (52, 4, 'hidden', 'max', '', '1', '', 'default', '', 'Y', '', 1, 7, 'N', 15, 4, 7, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (53, 4, 'select', 'req', 'Is this arequiredfield?', '', '', 'select', '', 'N', '', 1, 1, 'N', 4, 1, 0, 'N=No,Y=Yes', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (54, 4, 'text', 'size', 'Field Size', '1', '', 'default', 'If you are creating a mutiple select form, set the\nsize\nlarger to see more values.', 'Y', '', 1, 5, 'Y', 6, 5, 5, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (55, 4, 'hidden', 'event', '', 'addModifyFormFieldPost', '', '', '', '', '', 0, 0, '', 16, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (56, 4, 'hidden', 'type', '', 'select', '', '', '', '', '', 0, 0, '', 17, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (57, 4, 'hidden', 'stripTags', '', 'N', '', 'default', '', 'N', '', 1, 1, 'N', 18, 1, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (58, 4, 'hidden', 'validationType', '', 'select', '', '', '', 'N', '', 1, 1, '', 19, 0, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (59, 4, 'textarea', 'selectOptions', 'Enter\nyour\ndrop down options', '', '', 'default', 'Note:  enter drop\ndown options\nas follows with NO spaces between them.  Example:\n1=Name,2=Phone', 'Y', '', 1, 65535, 'N', 13, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (61, 4, 'select', 'useValue', 'Use value\ninstead\nof key (advanced option)?', 'N', '', 'default', '', 'N', '', 1, 1, 'N', 11, 1, 0, 'N=No,Y=Yes', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (62, 5, 'text', 'fieldName', 'Enter the\nfield\nname', '', '', 'default', '', 'Y', '', 1, 100, 'Y', 2, 15, 100, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (63, 5, 'text', 'displayName', 'Display Name', '', '', 'default', '(this is what people will read to know what to\nfill\nin, example: Phone Number)', 'N', '&lt;b&gt;&lt;/b&gt;&lt;i&gt;&lt;/i&gt;&lt;a&gt;&lt;/a&gt;', 1, 255, 'Y', 3, 15, 255, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (64, 5, 'textarea', 'defaultValue', 'Enter\nthe\ndefault value for this form field', '', '', 'default', '', 'Y', '', 1, 65535, 'N', 10, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (65, 5, 'textarea', 'message', 'Instructions\nor\nhelp', '', '', 'default', '(messages are displayed where this\ntext is,\nunderneath the form as help)', 'N', '', 1, 65535, 'N', 11, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (66, 5, 'hidden', 'min', '', '1', '', 'default', '', 'Y', '', 1, 7, 'N', 15, 4, 7, '', '', '', '', 0, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (67, 5, 'hidden', 'max', '', '65535', '', 'default', '', 'Y', '', 1, 7, 'N', 16, 4, 7, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (68, 5, 'select', 'req', 'Is this a required field?', '', '', 'select', '', 'N', '', 1, 1, 'N', 4, 1, 0, 'N=No,Y=Yes', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (69, 5, 'hidden', 'size', '', '0', '', 'default', '', 'Y', '', 1, 5, 'Y', 20, 5, 5, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (70, 5, 'hidden', 'event', '', 'addModifyFormFieldPost', '', '', '', '', '', 0, 0, '', 18, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (71, 5, 'hidden', 'type', '', 'textarea', '', '', '', '', '', 0, 0, '', 19, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (72, 5, 'hidden', 'validationType', '', 'default', '', '', '', 'N', '', 1, 1, '', 17, 0, 0, '', '', 'N', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (73, 5, 'textarea', 'exp', 'Regular\nExpression(s)', '', '', 'default', '(enter regular\nexpressions to\nmatch against data)', 'N', '', 1, 65535, 'N', 12, 0, 0, '', '', '', '', 25, 10, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', 'N')
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
INSERT INTO lcForms (pkey, formId, type, fieldName, displayName, defaultValue, exp, validationType, message, stripTags, allowedTags, min, max, req, sort, size, maxlength, selectOptions, checked, multiple, useValue, cols, rows, image, parentPkey, rowStyle, groups, notgroups, row, startYear, endYear, dateTimeBit, extra) VALUES (118, 5, 'select', 'stripTags', 'Strip\nHTML\nTags?', 'N', '', '', '', '', '', 0, 0, 'N', 13, 1, 0, 'N=No,Y=Yes', '', 'N', 'N', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 0, '', '', '', '')
campusdelimeter;
$installTableSchemas[] = $table;

?>