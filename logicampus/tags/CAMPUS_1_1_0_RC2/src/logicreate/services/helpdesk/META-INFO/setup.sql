CREATE TABLE helpdesk_categories (
  helpdesk_category_id int(11) NOT NULL auto_increment,
  helpdesk_category_label varchar(30) NOT NULL default '',
  PRIMARY KEY  (helpdesk_category_id)
) TYPE=MyISAM;


CREATE TABLE helpdesk_comments (
  helpdesk_comments_id int(11) NOT NULL auto_increment,
  userid varchar(32) NOT NULL default '',
  comment text NOT NULL,
  PRIMARY KEY  (helpdesk_comments_id)
) TYPE=MyISAM;


CREATE TABLE helpdesk_status (
  helpdesk_status_id int(11) NOT NULL auto_increment,
  helpdesk_status_label varchar(30) NOT NULL default '',
  PRIMARY KEY  (helpdesk_status_id)
) TYPE=MyISAM;


CREATE TABLE helpdesk_incident (
  helpdesk_id int(11) NOT NULL auto_increment,
  timedate_open int(11) NOT NULL default '0',
  timedate_close int(11) NOT NULL default '0',
  status int(11) NOT NULL default '0',
  summary text NOT NULL,
  userid varchar(32) NOT NULL default '',
  category int(11) NOT NULL default '0',
  assigned_to varchar(32) NOT NULL default '',
  PRIMARY KEY  (helpdesk_id)
) TYPE=MyISAM;


CREATE TABLE helpdesk_incident_log (
  helpdesk_incident_log_id int(11) NOT NULL auto_increment,
  helpdesk_id int(11) NOT NULL default '0',
  action varchar(15) NOT NULL default '',
  timedate int(11) NOT NULL default '0',
  comment text NOT NULL,
  userid varchar(32) NOT NULL default '',
  PRIMARY KEY  (helpdesk_incident_log_id)
) TYPE=MyISAM;


CREATE TABLE helpdesk_faq (
  id_faq int(10) unsigned NOT NULL auto_increment,
  id_faq_category int(10) unsigned NOT NULL default '0',
  tx_username varchar(32) NOT NULL default '',
  tx_question varchar(255) NOT NULL default '',
  tx_answer text NOT NULL,
  dt_submitted datetime NOT NULL default '0000-00-00 00:00:00',
  fl_approved int(11) NOT NULL default '0',
  ic_viewed int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (id_faq),
  KEY id_faq_category (id_faq_category)
) TYPE=MyISAM;


CREATE TABLE helpdesk_faq_category (
  id_faq_category int(10) unsigned NOT NULL auto_increment,
  tx_category varchar(100) NOT NULL default '',
  PRIMARY KEY  (id_faq_category)
) TYPE=MyISAM;


CREATE TABLE helpdesk_faq_vote (
  username varchar(32) NOT NULL default '',
  id_faq int(10) unsigned NOT NULL default '0',
  ii_vote int(11) NOT NULL default '0',
  KEY username (username),
  KEY id_faq (id_faq)
) TYPE=MyISAM COMMENT='tracks users to their votes.';


INSERT INTO helpdesk_status VALUES (1,'New');
INSERT INTO helpdesk_status VALUES (2,'Pending');
INSERT INTO helpdesk_status VALUES (3,'In progress');
INSERT INTO helpdesk_status VALUES (4,'Closed');

INSERT INTO helpdesk_categories (helpdesk_category_id, helpdesk_category_label) VALUES (1, 'General Help');
INSERT INTO helpdesk_categories (helpdesk_category_id, helpdesk_category_label) VALUES (2, 'E-mail');