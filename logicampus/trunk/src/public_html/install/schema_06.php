<?
$installTableSchemas = array();
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `class_forum`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `class_forum` (
	`class_forum_id` integer (11) NOT NULL auto_increment,  -- 
	`name` varchar (255),  -- 
	`class_id` integer (11),  -- 
	`is_locked` tinyint (1),  -- 
	`is_visible` tinyint (1),  -- 
	`is_moderated` tinyint (1),  -- 
	`allow_uploads` tinyint (1),  -- 
	`description` varchar (255),  -- 
	`recent_post_datetime` integer (11),  -- 
	`recent_poster` varchar (32),  -- 
	`thread_count` integer (11),  -- 
	`post_count` integer (11),  -- 
	`unanswered_count` integer (11),  -- 
	`class_forum_category_id` integer (11),  -- 
	PRIMARY KEY (class_forum_id)
)TYPE=InnoDB
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX class_forum_category_idx ON class_forum (class_forum_category_id)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX class_idx ON class_forum (class_id)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `class_forum_post`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `class_forum_post` (
	`class_forum_post_id` integer (11) NOT NULL auto_increment,  -- 
	`class_forum_id` integer (11),  -- 
	`is_sticky` tinyint (1),  -- 
	`is_hidden` tinyint (1),  -- 
	`reply_id` integer (11),  -- 
	`thread_id` integer (11),  -- 
	`subject` varchar (255),  -- 
	`message` text,  -- 
	`user_id` varchar (32),  -- 
	`post_datetime` integer (11),  -- 
	`last_edit_username` varchar (32),  -- 
	`last_edit_datetime` integer (11),  -- 
	PRIMARY KEY (class_forum_post_id)
)TYPE=InnoDB
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX is_sticky_idx ON class_forum_post (is_sticky)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX user_idx ON class_forum_post (user_id)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX thread_id ON class_forum_post (thread_id)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX reply_id ON class_forum_post (reply_id)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX class_forum_id ON class_forum_post (class_forum_id)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX post_datetime ON class_forum_post (post_datetime)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `class_forum_category`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `class_forum_category` (
	`class_forum_category_id` integer (11) NOT NULL auto_increment,  -- 
	`name` varchar (255),  -- 
	`class_id` integer (11),  -- 
	PRIMARY KEY (class_forum_category_id)
)TYPE=InnoDB
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX class_idx ON class_forum_category (class_id)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `class_forum_user_activity`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `class_forum_user_activity` (
	`class_forum_user_activity_id` integer (11) NOT NULL auto_increment,  -- 
	`class_forum_id` integer (11),  -- 
	`user_id` integer (11),  -- 
	`views` text,  -- 
	PRIMARY KEY (class_forum_user_activity_id)
)TYPE=InnoDB
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX class_forum_idx ON class_forum_user_activity (class_forum_id)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX user_idx ON class_forum_user_activity (user_id)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
DROP TABLE IF EXISTS `class_forum_trash_post`
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE TABLE `class_forum_trash_post` (
	`class_forum_trash_post_id` integer (11) NOT NULL auto_increment,  -- 
	`class_forum_id` integer (11),  -- 
	`is_sticky` tinyint (1),  -- 
	`is_hidden` tinyint (1),  -- 
	`reply_id` integer (11),  -- 
	`thread_id` integer (11),  -- 
	`subject` varchar (255),  -- 
	`message` text,  -- 
	`user_id` varchar (32),  -- 
	`post_datetime` integer (11),  -- 
	`last_edit_username` varchar (32),  -- 
	`last_edit_datetime` integer (11),  -- 
	PRIMARY KEY (class_forum_trash_post_id)
)TYPE=InnoDB
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX is_sticky_idx ON class_forum_trash_post (is_sticky)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX user_idx ON class_forum_trash_post (user_id)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX thread_id ON class_forum_trash_post (thread_id)
campusdelimeter;
$installTableSchemas[] = $table;
$table = <<<campusdelimeter
CREATE INDEX reply_id ON class_forum_trash_post (reply_id);
campusdelimeter;
$installTableSchemas[] = $table;

?>