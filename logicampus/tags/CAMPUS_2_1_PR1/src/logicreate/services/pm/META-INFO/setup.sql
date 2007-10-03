DROP TABLE IF EXISTS privateMessages;
CREATE TABLE privateMessages (
  pkey int(11) NOT NULL auto_increment,
  messageFrom varchar(25) NOT NULL default '',
  messageTo varchar(25) NOT NULL default '',
  message text NOT NULL,
  sentTime int(11) NOT NULL default '0',
  receivedTime int(11) NOT NULL default '0',
  subject varchar(75) NOT NULL default '',
  repliedTime int(11) NOT NULL default '0',
  sentReceived int(11) NOT NULL default '0',
  emailNotify VARCHAR(5) NOT NULL,
  PRIMARY KEY  (pkey)
) TYPE=MyISAM;

INSERT INTO lcConfig VALUES ('pm', '_displayPerPage', '10', 'text','');

INSERT INTO lcRegistry VALUES ('pm', 'pm', 'Private Messaging', 'MGK', '2002', '||', ".DB::getFuncName('NOW()')." , 1);
INSERT INTO lcConfig VALUES ('pm', '_SystemAdmin', 'zorka', 'text', '');
INSERT INTO lcPerms VALUES ('reg', 'pm', 'access');
