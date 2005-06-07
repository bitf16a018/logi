ALTER TABLE `semesters` ADD `dateStudentDeactivation` DATETIME NOT NULL AFTER `dateDeactivation` ;
ALTER TABLE `semesters` CHANGE `dateDeactivation` `dateDeactivation` DATETIME NOT NULL DEFAULT '0000-00-00'
