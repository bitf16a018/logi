<?
$installTableSchemas = array();
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `lob_user_link`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `lob_user_link` (
	`lob_user_link_id` integer (11) NOT NULL auto_increment, 
	`lob_id` integer (11) NOT NULL, 
	`lob_kind` varchar (255) NOT NULL, 
	`user_id` integer (11) NOT NULL,
	PRIMARY KEY (lob_user_link_id) 
)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX lob_idx ON lob_user_link (lob_id)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX lob_kind_idx ON lob_user_link (lob_kind)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX user_idx ON lob_user_link (user_id);
campusdelimeter;
$installTableSchemas[] = $table;

?>