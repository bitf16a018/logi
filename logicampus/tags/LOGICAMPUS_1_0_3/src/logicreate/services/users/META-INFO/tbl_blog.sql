-- Dumping SQL for project tbl_blog
-- entity version: 0.0
-- generated on: 12.15.2003

CREATE TABLE `tbl_blog` (
		
	`blog_id` integer NOT NULL auto_increment, 

	`blog_name` varchar (30) NOT NULL, 

	`blog_description` varchar (255) NOT NULL, 

	`blog_owner` varchar (32) NOT NULL, 

	`blog_email_notify` varchar (100) NOT NULL, 

	`blog_allow_viewing` char (1) NOT NULL, 

	`blog_allow_posting` char (1) NOT NULL, 

	PRIMARY KEY (blog_id)
);
