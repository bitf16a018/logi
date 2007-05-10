ALTER TABLE `helpdesk_status` ADD `helpdesk_status_sort` INT UNSIGNED NOT NULL ;
UPDATE `helpdesk_status` set `helpdesk_status_sort` = 1 WHERE `helpdesk_status_label` = 'New';
UPDATE `helpdesk_status` set `helpdesk_status_sort` = 2 WHERE `helpdesk_status_label` = 'Replied';
UPDATE `helpdesk_status` set `helpdesk_status_sort` = 3 WHERE `helpdesk_status_label` = 'In Progress';
UPDATE `helpdesk_status` set `helpdesk_status_sort` = 4 WHERE `helpdesk_status_label` = 'Closed';
