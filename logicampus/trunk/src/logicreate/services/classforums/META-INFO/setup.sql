-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 08.13.2005

DROP TABLE IF EXISTS `class_forum`;
CREATE TABLE `class_forum` (
		
	`class_forum_id` integer (11) NOT NULL auto_increment,  -- 

	`name` varchar (255),  -- 

	`class_id` integer (11),  -- 

	`is_locked` tinyint (1),  -- 

	`is_visible` tinyint (1),  -- 

	`is_moderated` tinyint (1),  -- 

	`allow_uploads` tinyint (1),  -- 

	`description` varchar (255),  -- 

	`class_forum_recent_post_timedate` integer (11),  -- 

	`class_forum_recent_poster` varchar (32),  -- 

	`class_forum_thread_count` integer (11),  -- 

	`class_forum_post_count` integer (11),  -- 

	`class_forum_unanswered_count` integer (11),  -- 

	`class_forum_category_id` integer (11),  -- 

	PRIMARY KEY (class_forum_id)
)TYPE=InnoDB;

CREATE INDEX class_forum_category_idx ON class_forum (class_forum_category_id);  
CREATE INDEX class_idx ON class_forum (class_id);

-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 08.13.2005

DROP TABLE IF EXISTS `class_forum_post`;
CREATE TABLE `class_forum_post` (
		
	`class_forum_post_id` integer (11) NOT NULL auto_increment,  -- 

	`class_forum_id` integer (11),  -- 

	`is_sticky` tinyint (1),  -- 

	`reply_id` integer (11),  -- 

	`thread_id` integer (11),  -- 

	`subject` varchar (255),  -- 

	`message` text,  -- 

	`user_id` varchar (32),  -- 

	`post_timedate` integer (11),  -- 

	`class_forum_post_status` integer (11),  -- 

	PRIMARY KEY (class_forum_post_id)
)TYPE=InnoDB;

CREATE INDEX is_sticky_idx ON class_forum_post (is_sticky);  
CREATE INDEX user_idx ON class_forum_post (user_id);  
CREATE INDEX thread_id ON class_forum_post (thread_id);  
CREATE INDEX reply_id ON class_forum_post (reply_id);

-- Dumping SQL for project logicampus
-- entity version: 0.0
-- DB type: mysql
-- generated on: 08.13.2005

DROP TABLE IF EXISTS `class_forum_category`;
CREATE TABLE `class_forum_category` (
		
	`class_forum_category_id` integer (11) NOT NULL auto_increment,  -- 

	`name` varchar (255),  -- 

	`class_id` integer (11),  -- 

	PRIMARY KEY (class_forum_category_id)
)TYPE=InnoDB;

CREATE INDEX class_idx ON class_forum_category (class_id);

