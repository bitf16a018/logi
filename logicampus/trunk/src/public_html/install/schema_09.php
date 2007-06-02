<?
$installTableSchemas = array();
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `lob_class_link`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `lob_class_link` (
	`lob_class_link_id` integer (11) NOT NULL auto_increment, 
	`lob_id` integer (11) NOT NULL, 
	`lob_kind` varchar (255) NOT NULL, 
	`class_id` integer (11) NOT NULL,
	PRIMARY KEY (lob_class_link_id) 
)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX lob_idx ON lob_class_link (lob_id)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX lob_kind_idx ON lob_class_link (lob_kind)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX class_idx ON lob_class_link (class_id);
campusdelimeter;
$installTableSchemas[] = $table;

?>