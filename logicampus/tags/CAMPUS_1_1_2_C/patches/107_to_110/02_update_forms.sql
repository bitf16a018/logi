UPDATE `lcForms` set dateTimeBit = 63 WHERE fieldName = 'dateDeactivation' LIMIT 1;
UPDATE `lcForms` set sort  = sort+3 WHERE formId = 1054222970 and sort > 29;
UPDATE `lcForms` set row  = row+3 WHERE formId = 1054222970 and row > 30;

INSERT INTO `lcForms` 
	(`formId`, `type`, `fieldName`, `displayName`, `defaultValue`, `exp`, `validationType`, `message`, `stripTags`, `allowedTags`, `min`, `max`, `req`, `sort`, `size`, `maxlength`, `selectOptions`, `checked`, `multiple`, `useValue`, `cols`, `rows`, `image`, `parentPkey`, `rowStyle`, `groups`, `notgroups`, `row`, `startYear`, `endYear`, `dateTimeBit`, `extra`) 
	VALUES (1054222970, 'row', '', '', 'Student Account Deactivation Date', '', '', '', '', '', 0, 0, '', 30, 0, 0, '', '', '', '', 0, 0, '', 0, 'tabletitle', 'a:1:{i:0;s:3:"reg";}', '', 31, '', '', '', '');

INSERT INTO `lcForms` 
	( `formId`, `type`, `fieldName`, `displayName`, `defaultValue`, `exp`, `validationType`, `message`, `stripTags`, `allowedTags`, `min`, `max`, `req`, `sort`, `size`, `maxlength`, `selectOptions`, `checked`, `multiple`, `useValue`, `cols`, `rows`, `image`, `parentPkey`, `rowStyle`, `groups`, `notgroups`, `row`, `startYear`, `endYear`, `dateTimeBit`, `extra`) 
	VALUES (1054222970, 'row', '', '', 'Instructions:  ', '', '', '', '', '', 0, 0, '', 31, 0, 0, '', '', '', '', 0, 0, '', 0, 'instructions', 'a:1:{i:0;s:3:"reg";}', '', 32, '', '', '', '');


INSERT INTO `lcForms` 
	(`formId`, `type`, `fieldName`, `displayName`, `defaultValue`, `exp`, `validationType`, `message`, `stripTags`, `allowedTags`, `min`, `max`, `req`, `sort`, `size`, `maxlength`, `selectOptions`, `checked`, `multiple`, `useValue`, `cols`, `rows`, `image`, `parentPkey`, `rowStyle`, `groups`, `notgroups`, `row`, `startYear`, `endYear`, `dateTimeBit`, `extra`) 
	VALUES (1054222970, 'dateDropDown', 'dateStudentDeactivation', 'Student Account Deactivation Date', '', '', 'DateDropDown', '', '', '', 0, 0, 'Y', 32, 0, 0, '', '', '', '', 0, 0, '', 0, '', 'a:1:{i:0;s:3:"reg";}', '', 33, '0', '+5', '63', '');


UPDATE `lcForms` set `defaultValue` = 'Student Account Activation Date' where defaultValue = 'Student Activation Account Date';


UPDATE `lcForms` set `defaultValue` = 'Account Deactivation Date' where defaultValue = 'Account De-activation';
