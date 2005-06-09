ALTER TABLE `helpdesk_incident` ADD `timedate_reply` INT NOT NULL AFTER `timedate_close` ,
 ADD `timedate_update` INT NOT NULL AFTER `timedate_reply` ;
