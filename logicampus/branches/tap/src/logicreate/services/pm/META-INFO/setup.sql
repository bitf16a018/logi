CREATE TABLE privateMessages (
  pkey int(11) NOT NULL auto_increment,
  messageFrom varchar(25) NOT NULL default '',
  messageTo varchar(25) NOT NULL default '',
  message text NOT NULL,
  sentTime int(11) NOT NULL default '0',
  receivedTime int(11) NOT NULL default '0',
  subject varchar(75) NOT NULL default '',
  repliedTime int(11) NOT NULL default '0',
  PRIMARY KEY  (pkey),
  KEY messageTo (messageTo)
) TYPE=MyISAM;

