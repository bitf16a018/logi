#
# Table structure for table `lc_forum`
#

DROP TABLE IF EXISTS `lc_forum`;
CREATE TABLE `lc_forum` (
  `lc_forum_id` int(11) NOT NULL auto_increment,
  `lc_forum_parent_id` int(11) default NULL,
  `lc_forum_name` varchar(30) default NULL,
  `lc_forum_description` varchar(255) default NULL,
  `lc_forum_recent_post_id` int(11) default '0',
  `lc_forum_recent_post_timedate` int(11) default '0',
  `lc_forum_recent_poster` varchar(30) default NULL,
  `lc_forum_thread_count` int(11) default '0',
  `lc_forum_post_count` int(11) default '0',
  `lc_forum_unanswered_count` int(11) default '0',
  `lc_forum_section_id` int(11) default '0',
  `lc_forum_numeric_link` int(11) default NULL,
  `lc_forum_char_link` varchar(10) default NULL,
  PRIMARY KEY  (`lc_forum_id`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

#
# Dumping data for table `lc_forum`
#

INSERT INTO `lc_forum` (`lc_forum_id`, `lc_forum_parent_id`, `lc_forum_name`, `lc_forum_description`, `lc_forum_recent_post_id`, `lc_forum_recent_post_timedate`, `lc_forum_recent_poster`, `lc_forum_thread_count`, `lc_forum_post_count`, `lc_forum_unanswered_count`, `lc_forum_section_id`, `lc_forum_numeric_link`, `lc_forum_char_link`) VALUES (1, 0, 'General discussion', 'Talk about the latest happenings', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO `lc_forum` (`lc_forum_id`, `lc_forum_parent_id`, `lc_forum_name`, `lc_forum_description`, `lc_forum_recent_post_id`, `lc_forum_recent_post_timedate`, `lc_forum_recent_poster`, `lc_forum_thread_count`, `lc_forum_post_count`, `lc_forum_unanswered_count`, `lc_forum_section_id`, `lc_forum_numeric_link`, `lc_forum_char_link`) VALUES (2, 0, 'Relaxing', 'Talk about non-school stuff here - sports, movies and more', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL);

# --------------------------------------------------------

#
# Table structure for table `lc_forum_moderator`
#

DROP TABLE IF EXISTS `lc_forum_moderator`;
CREATE TABLE `lc_forum_moderator` (
  `lc_forum_moderator_id` int(11) NOT NULL auto_increment,
  `lc_forum_id` int(11) default '0',
  `lc_forum_moderator_username` varchar(32) default NULL,
  PRIMARY KEY  (`lc_forum_moderator_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `lc_forum_moderator`
#


# --------------------------------------------------------

#
# Table structure for table `lc_forum_perm`
#

DROP TABLE IF EXISTS `lc_forum_perm`;
CREATE TABLE `lc_forum_perm` (
  `lc_forum_perm_id` int(10) unsigned NOT NULL auto_increment,
  `lc_forum_id` int(11) default '0',
  `lc_forum_perm_action` varchar(4) default NULL,
  `lc_forum_perm_label` varchar(32) default NULL,
  `lc_forum_perm_group` varchar(10) default NULL,
  PRIMARY KEY  (`lc_forum_perm_id`)
) TYPE=MyISAM AUTO_INCREMENT=13 ;

#
# Dumping data for table `lc_forum_perm`
#

INSERT INTO `lc_forum_perm` (`lc_forum_perm_id`, `lc_forum_id`, `lc_forum_perm_action`, `lc_forum_perm_label`, `lc_forum_perm_group`) VALUES (1, 1, 'read', 'You can read', 'reg');
INSERT INTO `lc_forum_perm` (`lc_forum_perm_id`, `lc_forum_id`, `lc_forum_perm_action`, `lc_forum_perm_label`, `lc_forum_perm_group`) VALUES (2, 1, 'read', 'You can read', 'admin');
INSERT INTO `lc_forum_perm` (`lc_forum_perm_id`, `lc_forum_id`, `lc_forum_perm_action`, `lc_forum_perm_label`, `lc_forum_perm_group`) VALUES (3, 1, 'read', 'You can read', 'public');
INSERT INTO `lc_forum_perm` (`lc_forum_perm_id`, `lc_forum_id`, `lc_forum_perm_action`, `lc_forum_perm_label`, `lc_forum_perm_group`) VALUES (4, 1, 'post', 'You may post a message', 'reg');
INSERT INTO `lc_forum_perm` (`lc_forum_perm_id`, `lc_forum_id`, `lc_forum_perm_action`, `lc_forum_perm_label`, `lc_forum_perm_group`) VALUES (5, 1, 'dele', 'You may delete a message', 'admin');
INSERT INTO `lc_forum_perm` (`lc_forum_perm_id`, `lc_forum_id`, `lc_forum_perm_action`, `lc_forum_perm_label`, `lc_forum_perm_group`) VALUES (6, 2, 'read', 'You can read', 'reg');
INSERT INTO `lc_forum_perm` (`lc_forum_perm_id`, `lc_forum_id`, `lc_forum_perm_action`, `lc_forum_perm_label`, `lc_forum_perm_group`) VALUES (7, 2, 'read', 'You can read', 'admin');
INSERT INTO `lc_forum_perm` (`lc_forum_perm_id`, `lc_forum_id`, `lc_forum_perm_action`, `lc_forum_perm_label`, `lc_forum_perm_group`) VALUES (8, 2, 'read', 'You can read', 'public');
INSERT INTO `lc_forum_perm` (`lc_forum_perm_id`, `lc_forum_id`, `lc_forum_perm_action`, `lc_forum_perm_label`, `lc_forum_perm_group`) VALUES (9, 2, 'post', 'You may post a message', 'reg');
INSERT INTO `lc_forum_perm` (`lc_forum_perm_id`, `lc_forum_id`, `lc_forum_perm_action`, `lc_forum_perm_label`, `lc_forum_perm_group`) VALUES (10, 2, 'post', 'You may post a message', 'admin');
INSERT INTO `lc_forum_perm` (`lc_forum_perm_id`, `lc_forum_id`, `lc_forum_perm_action`, `lc_forum_perm_label`, `lc_forum_perm_group`) VALUES (11, 2, 'post', 'You may post a message', 'public');
INSERT INTO `lc_forum_perm` (`lc_forum_perm_id`, `lc_forum_id`, `lc_forum_perm_action`, `lc_forum_perm_label`, `lc_forum_perm_group`) VALUES (12, 2, 'dele', 'You may delete a message', 'fadmin');

# --------------------------------------------------------

#
# Table structure for table `lc_forum_post`
#

DROP TABLE IF EXISTS `lc_forum_post`;
CREATE TABLE `lc_forum_post` (
  `lc_forum_post_id` int(11) NOT NULL auto_increment,
  `lc_forum_id` int(11) NOT NULL default '0',
  `lc_forum_post_parent_id` int(11) default NULL,
  `lc_forum_post_thread_id` int(11) default NULL,
  `lc_forum_post_title` varchar(255) default NULL,
  `lc_forum_post_message` text,
  `lc_forum_post_username` varchar(32) default NULL,
  `lc_forum_post_timedate` int(11) default '0',
  `lc_forum_post_status` int(11) default '0',
  `lc_forum_reply_count` int(11) default '0',
  `lc_forum_recent_post_id` int(11) default '0',
  `lc_forum_recent_post_timedate` int(11) default '0',
  `lc_forum_recent_poster` varchar(30) default NULL,
  `lc_forum_file1_name` varchar(100) default NULL,
  `lc_forum_file1_sys_name` varchar(100) NOT NULL default '',
  `lc_forum_file1_size` varchar(100) default NULL,
  `lc_forum_file1_mime` varchar(100) default NULL,
  `lc_forum_file1_count` int(11) default '0',
  `lc_forum_file2_name` varchar(100) default NULL,
  `lc_forum_file2_sys_name` varchar(100) default NULL,
  `lc_forum_file2_size` varchar(100) default NULL,
  `lc_forum_file2_mime` varchar(100) default NULL,
  `lc_forum_file2_count` int(11) default '0',
) TYPE=MyISAM AUTO_INCREMENT=1 ;

#
# Dumping data for table `lc_forum_post`
#


# --------------------------------------------------------

#
# Table structure for table `lc_forum_section`
#

DROP TABLE IF EXISTS `lc_forum_section`;
CREATE TABLE `lc_forum_section` (
  `lc_forum_section_id` int(11) NOT NULL auto_increment,
  `lc_forum_section_name` varchar(50) default NULL,
  `lc_forum_section_parent_id` int(11) default '0',
  PRIMARY KEY  (`lc_forum_section_id`),
  KEY `lc_forum_section_parent_id` (`lc_forum_section_parent_id`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

#
# Dumping data for table `lc_forum_section`
#

INSERT INTO `lc_forum_section` (`lc_forum_section_id`, `lc_forum_section_name`, `lc_forum_section_parent_id`) VALUES (1, 'General', NULL);
  
