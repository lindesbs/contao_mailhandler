

CREATE TABLE `tl_mailhandler_incomingmail` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `date` varchar(255) NOT NULL default '',
  
  `message_id` varchar(128) NOT NULL default '',
  `mail_to` varchar(255) NOT NULL default '',
  `mail_from` text NULL,
  `mail_subject` varchar(255) NOT NULL default '',
   `mail_date` varchar(255) NOT NULL default '',
   `mail_useragent` varchar(255) NOT NULL default '',
  
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE `tl_mailhandler_actor` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `provider` varchar(255) NOT NULL default '',
  `provider_config` text NULL,
  `active` varchar(1) NOT NULL default '',
  
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE `tl_mailhandler_action` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `actors` text NULL,
  
  `active` varchar(1) NOT NULL default '',
  
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE `tl_mailhandler_action_item` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `active` varchar(1) NOT NULL default '',
  `type` varchar(255) NOT NULL default '',
  `handler_config` text NULL,
  
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
