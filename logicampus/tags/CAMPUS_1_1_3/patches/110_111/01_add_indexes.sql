ALTER TABLE `class_links` ADD INDEX `id_class_links_categories` ( `id_class_links_categories` );
ALTER TABLE `class_links` ADD INDEX `id_classes` ( `id_classes` );

ALTER TABLE `class_group` ADD INDEX `class_id` ( `class_id` );

ALTER TABLE `class_presentations` ADD INDEX `id_classes` ( `id_classes` );

ALTER TABLE `class_assignments_grades` ADD INDEX `id_class_assignments` ( `id_class_assignments` );
ALTER TABLE `class_assignments_link` ADD INDEX `id_class_lessons` ( `id_class_lessons` );
ALTER TABLE `class_assignments_link` ADD INDEX `id_class_assignments` ( `id_class_assignments` );

ALTER TABLE `assessment` ADD INDEX ( `class_id` );
ALTER TABLE `assessment` ADD INDEX ( `date_available` );
ALTER TABLE `assessment` ADD INDEX ( `date_unavailable` );
