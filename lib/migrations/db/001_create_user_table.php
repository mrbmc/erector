<?php

class Migration_2009_09_18_15_16_24 extends MpmMysqliMigration
{

	public function up(ExceptionalMysqli &$mysqli)
	{
		$mysqli->exec('DROP TABLE IF EXISTS `user`');
		$mysqli->exec("CREATE TABLE `user` (
		  `userid` int(10) unsigned NOT NULL auto_increment,
		  `status` varchar(10) character set latin1 collate latin1_bin default 'pending',
		  `date_created` timestamp NOT NULL default '0000-00-00 00:00:00',
		  `date_modified` timestamp NOT NULL default CURRENT_TIMESTAMP,
		  `username` varchar(50) default NULL,
		  `password` varchar(50) default NULL,
		  `email` varchar(200) default NULL,
		  `phone` varchar(45) default NULL,
		  `address` varchar(200) default NULL,
		  `address_2` varchar(200) default NULL,
		  `city` varchar(200) default NULL,
		  `state` varchar(200) default NULL,
		  `zipcode` varchar(15) default NULL,
		  `first_name` varchar(50) default NULL,
		  `last_name` varchar(100) default NULL,
		  `confirmation` varchar(50) default NULL,
		  PRIMARY KEY  USING BTREE (`userid`)
		) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
		");
		$mysqli->exec("INSERT INTO `user` VALUES (1,'admin','0000-00-00 00:00:00','2008-10-28 16:03:17','admin','qwerty','admin@kageki.com','','','','','','','','','')");
	}

	public function down(ExceptionalMysqli &$mysqli)
	{
		$mysqli->exec('DROP TABLE IF EXISTS `user`');
	}

}

?>