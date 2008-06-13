

DROP TABLE IF EXISTS `asset`;
CREATE TABLE IF NOT EXISTS `asset` (
  `asset_id` int(10) unsigned NOT NULL auto_increment,
  `asset_fk_user_id` int(10) unsigned NOT NULL,
  `asset_path` varchar(250) default NULL,
  `asset_filename` varchar(100) default NULL,
  `asset_filetype` varchar(50) default NULL,
  `asset_width` int(10) unsigned default NULL,
  `asset_height` int(10) unsigned default NULL,
  `asset_length` varchar(50) default NULL,
  PRIMARY KEY  (`asset_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `asset_link`;
CREATE TABLE IF NOT EXISTS `asset_link` (
  `link_id` int(10) unsigned NOT NULL auto_increment,
  `link_asset_id` int(10) unsigned NOT NULL,
  `link_object_id` int(10) unsigned NOT NULL,
  `link_object_type` varchar(45) NOT NULL,
  PRIMARY KEY  (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL auto_increment,
  `user_status` varchar(10) default NULL,
  `user_date_created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `user_date_modified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `user_username` varchar(50) default NULL,
  `user_password` varchar(50) default NULL,
  `user_email` varchar(200) default NULL,
  `user_phone` varchar(45) default NULL,
  `user_address` varchar(200) default NULL,
  `user_address_2` varchar(200) default NULL,
  `user_city` varchar(200) default NULL,
  `user_state` varchar(200) default NULL,
  `user_zipcode` varchar(15) default NULL,
  `user_first_name` varchar(50) default NULL,
  `user_last_name` varchar(100) default NULL,
  `user_confirmation` varchar(50) default NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `user` (`user_id`, `user_status`, `user_username`, `user_password`, `user_email`, `user_phone`, `user_address`, `user_address_2`, `user_city`, `user_state`, `user_zipcode`, `user_first_name`, `user_last_name`, `user_confirmation`) VALUES (1, 'admin', 'admin', 'studios', 'info@edelmanstudios.com', '212-299-4036', '215 Park Ave. South', '16th Floor', 'New York', 'NY', '10003', 'Edelman', 'Studios', NULL);
