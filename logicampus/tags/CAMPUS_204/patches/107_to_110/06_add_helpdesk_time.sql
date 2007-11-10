ALTER TABLE `helpdesk_incident` ADD `timedate_reply` INT NULL AFTER `timedate_close` ,
 ADD `timedate_update` INT NULL AFTER `timedate_reply` ;
