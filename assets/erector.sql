-- MySQL dump 10.11
--
-- Host: localhost    Database: erectordb
-- ------------------------------------------------------
-- Server version	5.0.67-community-nt

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `asset`
--

DROP TABLE IF EXISTS `asset`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `asset` (
  `asset_id` int(10) unsigned NOT NULL auto_increment,
  `asset_fk_user_id` int(10) unsigned NOT NULL,
  `asset_path` varchar(250) default NULL,
  `asset_filename` varchar(100) default NULL,
  `asset_filetype` varchar(50) default NULL,
  `asset_width` int(10) unsigned default NULL,
  `asset_height` int(10) unsigned default NULL,
  `asset_length` varchar(50) default NULL,
  PRIMARY KEY  (`asset_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `asset`
--

LOCK TABLES `asset` WRITE;
/*!40000 ALTER TABLE `asset` DISABLE KEYS */;
/*!40000 ALTER TABLE `asset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_link`
--

DROP TABLE IF EXISTS `asset_link`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `asset_link` (
  `link_id` int(10) unsigned NOT NULL auto_increment,
  `link_fk_asset_id` int(10) unsigned NOT NULL,
  `link_object_id` int(10) unsigned NOT NULL,
  `link_object_type` varchar(45) NOT NULL,
  PRIMARY KEY  (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `asset_link`
--

LOCK TABLES `asset_link` WRITE;
/*!40000 ALTER TABLE `asset_link` DISABLE KEYS */;
/*!40000 ALTER TABLE `asset_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `assets`
--

DROP TABLE IF EXISTS `assets`;
/*!50001 DROP VIEW IF EXISTS `assets`*/;
/*!50001 CREATE TABLE `assets` (
  `asset_id` int(10) unsigned,
  `asset_fk_user_id` int(10) unsigned,
  `asset_path` varchar(250),
  `asset_filename` varchar(100),
  `asset_filetype` varchar(50),
  `asset_width` int(10) unsigned,
  `asset_height` int(10) unsigned,
  `asset_length` varchar(50),
  `link_id` int(10) unsigned,
  `link_fk_asset_id` int(10) unsigned,
  `link_object_id` int(10) unsigned,
  `link_object_type` varchar(45)
) */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL auto_increment,
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
  PRIMARY KEY  USING BTREE (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','0000-00-00 00:00:00','2008-10-28 16:03:17','admin','qwerty','admin@kageki.com','917-744-7689','45-08 40TH STREET','APT. F43','SUNNYSIDE','NY','11104','Dive','Bug','fa1ae12eacb657b1a26c0a6cd53c157b'),(17,'pending','0000-00-00 00:00:00','2009-01-23 03:36:19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,'member','0000-00-00 00:00:00','2009-01-22 05:39:41','mrbmc','notadj','brian@mrbmc.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'6b60e8b5c6');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `assets`
--

/*!50001 DROP TABLE `assets`*/;
/*!50001 DROP VIEW IF EXISTS `assets`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`erector`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `assets` AS select `asset`.`asset_id` AS `asset_id`,`asset`.`asset_fk_user_id` AS `asset_fk_user_id`,`asset`.`asset_path` AS `asset_path`,`asset`.`asset_filename` AS `asset_filename`,`asset`.`asset_filetype` AS `asset_filetype`,`asset`.`asset_width` AS `asset_width`,`asset`.`asset_height` AS `asset_height`,`asset`.`asset_length` AS `asset_length`,`link`.`link_id` AS `link_id`,`link`.`link_fk_asset_id` AS `link_fk_asset_id`,`link`.`link_object_id` AS `link_object_id`,`link`.`link_object_type` AS `link_object_type` from (`asset` left join `asset_link` `link` on((`asset`.`asset_id` = `link`.`link_fk_asset_id`))) */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-01-23 16:51:12
