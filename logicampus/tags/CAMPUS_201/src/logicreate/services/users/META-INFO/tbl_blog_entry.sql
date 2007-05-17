-- Dumping SQL for project tbl_blog_entry
-- entity version: 0.0
-- generated on: 12.15.2003

CREATE TABLE `tbl_blog_entry` (
		
	`blog_entry_id` integer NOT NULL auto_increment, 

	`blog_id` integer NOT NULL, 

	`blog_parent_id` integer NOT NULL, 

	`blog_entry_title` varchar (255) NOT NULL, 

	`blog_entry_description` varchar (255) NOT NULL, 

	`blog_entry_text` text, 

	`blog_entry_timedate` int NOT NULL, 

	`blog_entry_poster_id` varchar (25) NOT NULL, 

	`blog_entry_poster_email` varchar (25) NOT NULL, 

	`blog_entry_poster_notify` char (1) NOT NULL, 

	`blog_entry_poster_url` varchar (25) NOT NULL, 

	PRIMARY KEY (blog_entry_id)
);
