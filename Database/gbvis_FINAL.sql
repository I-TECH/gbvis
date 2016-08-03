CREATE DATABASE  IF NOT EXISTS `gbvis` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `gbvis`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: gbvis
-- ------------------------------------------------------
-- Server version	5.6.17

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
-- Table structure for table `police_aggregates`
--

DROP TABLE IF EXISTS `police_aggregates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `police_aggregates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `county_id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `indicator_id` int(10) NOT NULL,
  `aggregate` int(100) NOT NULL,
  `timestamp_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `police_aggregates`
--

LOCK TABLES `police_aggregates` WRITE;
/*!40000 ALTER TABLE `police_aggregates` DISABLE KEYS */;
/*!40000 ALTER TABLE `police_aggregates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `health_aggregates`
--

DROP TABLE IF EXISTS `health_aggregates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `health_aggregates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `county_id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `indicator_id` int(10) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `age_range` varchar(100) NOT NULL,
  `aggregate` int(100) NOT NULL,
  `timestamp_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `ownership_id` int(11) DEFAULT NULL,
  `cadre_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=622 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `health_aggregates`
--

LOCK TABLES `health_aggregates` WRITE;
/*!40000 ALTER TABLE `health_aggregates` DISABLE KEYS */;
/*!40000 ALTER TABLE `health_aggregates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surveys`
--

DROP TABLE IF EXISTS `surveys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surveys` (
  `survey_id` int(10) NOT NULL AUTO_INCREMENT,
  `survey` varchar(100) NOT NULL,
  PRIMARY KEY (`survey_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surveys`
--

LOCK TABLES `surveys` WRITE;
/*!40000 ALTER TABLE `surveys` DISABLE KEYS */;
INSERT INTO `surveys` VALUES (1,'Jan to March'),(2,'April to June'),(3,'July to September'),(5,'October to December');
/*!40000 ALTER TABLE `surveys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ownerships`
--

DROP TABLE IF EXISTS `ownerships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ownerships` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ownership` varchar(100) NOT NULL,
  `sector_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ownerships`
--

LOCK TABLES `ownerships` WRITE;
/*!40000 ALTER TABLE `ownerships` DISABLE KEYS */;
INSERT INTO `ownerships` VALUES (1,'Academic',2),(2,'Armed forces',2),(3,'Christian Health Association of Kenya',2),(4,'Community',2),(5,'Community Development Fund',2),(6,'Company Medical Services',2),(7,'Humanitarian agencies',2),(8,'Kenya Episcopal Conference-Catholic Secretariat',2),(9,'Local Authority',2),(10,'Local authority T fund',2),(11,'Ministry of Health',2),(12,'Non-Governmental Organizations',2),(13,'Other Faith Based',2),(14,'Other Public Institutions',2),(15,'Parastatal',2),(16,'Private Enterprise (Institution)',2),(17,'Private Practice-Clinical Officer',2),(18,'Private Practice-General Practitioner',2),(19,'Private Practice-Medical Specialist',2),(20,'Private Practice-Nurse/Midwife',2),(21,'Private Practice-Unspecified',2),(22,'State Corporation',2),(23,'Supreme Council for Kenya Muslims',2),(24,'Private',5),(25,'Public',5);
/*!40000 ALTER TABLE `ownerships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `identity_of_perpetrator`
--

DROP TABLE IF EXISTS `identity_of_perpetrator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `identity_of_perpetrator` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `identity` varchar(100) NOT NULL,
  `sector_id` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `identity_of_perpetrator`
--

LOCK TABLES `identity_of_perpetrator` WRITE;
/*!40000 ALTER TABLE `identity_of_perpetrator` DISABLE KEYS */;
INSERT INTO `identity_of_perpetrator` VALUES (1,'Parent',5,NULL),(2,'Guardian',5,NULL),(3,'Teacher',5,2),(4,'Sibling',5,NULL),(5,'Relative',5,NULL),(6,'Religious official',5,NULL),(7,'Stranger',5,NULL),(8,'Operator',5,NULL);
/*!40000 ALTER TABLE `identity_of_perpetrator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `indicators`
--

DROP TABLE IF EXISTS `indicators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `indicators` (
  `survey_id` int(11) NOT NULL DEFAULT '0',
  `sector_id` int(11) NOT NULL DEFAULT '0',
  `indicator_id` int(11) NOT NULL DEFAULT '0',
  `indicator_code` varchar(45) DEFAULT NULL,
  `indicator` varchar(255) DEFAULT NULL,
  `date_recorded` date NOT NULL,
  `date_modified` date NOT NULL,
  PRIMARY KEY (`survey_id`,`sector_id`,`indicator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `indicators`
--

LOCK TABLES `indicators` WRITE;
/*!40000 ALTER TABLE `indicators` DISABLE KEYS */;
INSERT INTO `indicators` VALUES (0,1,28,'7.1','Number of judges/magistrates trained in SGBV','0000-00-00','0000-00-00'),(0,2,11,'4.5','Number completed PEP','0000-00-00','0000-00-00'),(0,2,37,'4.1.a','Number of health facilities surveyed','0000-00-00','0000-00-00'),(0,2,38,'4.3.b','Number presenting within 72 hours','0000-00-00','0000-00-00'),(0,2,39,'4.6.c','Number completed trauma counseling','0000-00-00','0000-00-00'),(0,3,22,'5.1.a','Number of police stations surveyed','0000-00-00','0000-00-00'),(0,3,23,'5.1.b','Number of police stations that have a functional gender desk','0000-00-00','0000-00-00'),(0,3,24,'5.3','Number of SGBV cases reported to national police service (NPS)','0000-00-00','0000-00-00'),(0,3,25,'5.4','Number of SGBV cases investigated by the National Police','0000-00-00','0000-00-00'),(0,3,27,'5.2','Number of police who have been trained to respond and investigate cases of SGBV','0000-00-00','0000-00-00'),(0,5,29,'8.2.b','Number of schools implementing life skills curriculum that teaches students on what to do in case of victimization','0000-00-00','0000-00-00'),(0,5,30,'8.2.a','Total number of schools surveyed','0000-00-00','0000-00-00'),(0,5,31,'8.3.a','Total number of children in the sample','0000-00-00','0000-00-00'),(0,5,32,'8.3.b','Number of children who possess life skills','0000-00-00','0000-00-00'),(0,5,33,'8.1.b','Number of MOEST staff trained in SGBV','0000-00-00','0000-00-00'),(0,5,34,'8.4','Number of children who report being victims of violence in the last 12 months','0000-00-00','0000-00-00'),(0,5,36,'8.1.a','Number of teachers or secretarial staff trained in SGBV','0000-00-00','0000-00-00'),(1,1,7,'7.2.a','Number of prosecuted SGBV cases','0000-00-00','0000-00-00'),(1,1,8,'7.2.b','Number of prosecuted SGBV cases withdrawn','0000-00-00','0000-00-00'),(1,1,9,'7.3','Number of prosecuted SGBV  cases that resulted in a  conviction','0000-00-00','0000-00-00'),(1,1,10,'7.4','Average time to conclude a SGBV case','0000-00-00','0000-00-00'),(1,2,1,'4.1.b','Number of health facilities providing comprehensive clinical management services for survivors of sexual violence','0000-00-00','0000-00-00'),(1,2,2,'4.2','Number of service providers trained on management of SGBV survivors','0000-00-00','0000-00-00'),(1,2,3,'4.3.a','Number of rape survivors','0000-00-00','0000-00-00'),(1,2,4,'4.4','Number initiated PEP','0000-00-00','0000-00-00'),(1,2,5,'4.6.a','Number given STI treatment','0000-00-00','0000-00-00'),(1,2,6,'4.6.b','Number given Emergency Contraceptive Pill','0000-00-00','0000-00-00'),(1,4,15,'6.1','Number of prosecutors who have been trained in SGBV using SGBV prosecutors manual','0000-00-00','0000-00-00'),(1,4,16,'6.2.b','Total number of SGBV cases reported to the police','0000-00-00','0000-00-00'),(1,4,17,'6.2.a','Number of SGBV cases that were prosecuted during the specified time period','0000-00-00','0000-00-00'),(1,7,18,NULL,'number of teachers who have been trained in sgbv','0000-00-00','0000-00-00'),(1,7,19,NULL,'number of schools implementing life skills curriculum','0000-00-00','0000-00-00'),(1,7,20,NULL,'number of children possessing life skills','0000-00-00','0000-00-00'),(2,7,21,NULL,'number of children who have indicated sgbv','0000-00-00','0000-00-00');
/*!40000 ALTER TABLE `indicators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `place_of_victimization`
--

DROP TABLE IF EXISTS `place_of_victimization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `place_of_victimization` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `place` varchar(100) NOT NULL,
  `sector_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `place_of_victimization`
--

LOCK TABLES `place_of_victimization` WRITE;
/*!40000 ALTER TABLE `place_of_victimization` DISABLE KEYS */;
INSERT INTO `place_of_victimization` VALUES (1,'Home',5),(2,'School',5),(3,'Outside the home',5),(4,'Place of worship',5),(5,'Means of transport',5);
/*!40000 ALTER TABLE `place_of_victimization` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `violence_types`
--

DROP TABLE IF EXISTS `violence_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `violence_types` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `violence_type` varchar(100) NOT NULL,
  `sector_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `violence_types`
--

LOCK TABLES `violence_types` WRITE;
/*!40000 ALTER TABLE `violence_types` DISABLE KEYS */;
INSERT INTO `violence_types` VALUES (1,'Rape',5),(2,'Molestation',5),(3,'Sexual slavery',5),(4,'Forced marriage',5),(5,'Forced sexual acts',5);
/*!40000 ALTER TABLE `violence_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prosecution_aggregates`
--

DROP TABLE IF EXISTS `prosecution_aggregates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prosecution_aggregates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `county_id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `indicator_id` int(10) NOT NULL,
  `aggregate` int(100) NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `timestamp_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prosecution_aggregates`
--

LOCK TABLES `prosecution_aggregates` WRITE;
/*!40000 ALTER TABLE `prosecution_aggregates` DISABLE KEYS */;
/*!40000 ALTER TABLE `prosecution_aggregates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `judiciary_aggregates`
--

DROP TABLE IF EXISTS `judiciary_aggregates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `judiciary_aggregates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `county_id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `indicator_id` int(10) NOT NULL,
  `aggregate` int(100) NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `timestamp_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `cadre` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `judiciary_aggregates`
--

LOCK TABLES `judiciary_aggregates` WRITE;
/*!40000 ALTER TABLE `judiciary_aggregates` DISABLE KEYS */;
/*!40000 ALTER TABLE `judiciary_aggregates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prosecution_aggregates2`
--

DROP TABLE IF EXISTS `prosecution_aggregates2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prosecution_aggregates2` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `county_id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `indicator_id` int(10) NOT NULL,
  `aggregate` int(100) NOT NULL,
  PRIMARY KEY (`county_id`,`survey_id`,`indicator_id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prosecution_aggregates2`
--

LOCK TABLES `prosecution_aggregates2` WRITE;
/*!40000 ALTER TABLE `prosecution_aggregates2` DISABLE KEYS */;
INSERT INTO `prosecution_aggregates2` VALUES (1,1,1,15,6),(2,2,1,15,4),(3,3,1,15,20),(4,4,1,15,10),(5,5,1,15,26),(6,6,1,15,55),(7,7,1,15,26),(8,8,1,15,40),(9,9,1,15,50),(10,10,1,15,92),(11,11,1,15,102),(12,12,1,15,159),(13,13,1,15,211),(14,14,1,15,210),(15,15,1,15,185),(16,16,1,15,123),(17,17,1,15,63),(18,18,1,15,50),(19,19,1,15,68),(20,20,1,15,95),(21,21,1,15,187),(22,22,1,15,92),(23,23,1,15,93),(24,24,1,15,128),(25,25,1,15,215),(26,26,1,15,61),(27,27,1,15,378),(28,28,1,15,88),(29,29,1,15,153),(30,30,1,15,27),(31,31,1,15,56),(32,32,1,15,55),(33,33,1,15,188),(34,34,1,15,270),(35,35,1,15,157),(36,36,1,15,25),(37,37,1,15,126),(38,38,1,15,66),(39,39,1,15,195),(40,40,1,15,158),(41,41,1,15,105),(42,42,1,15,72),(43,43,1,15,157),(44,44,1,15,72),(45,45,1,15,64),(46,46,1,15,27),(47,47,1,15,12);
/*!40000 ALTER TABLE `prosecution_aggregates2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `indicators_titles`
--

DROP TABLE IF EXISTS `indicators_titles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `indicators_titles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `titleid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `indicators_titles`
--

LOCK TABLES `indicators_titles` WRITE;
/*!40000 ALTER TABLE `indicators_titles` DISABLE KEYS */;
INSERT INTO `indicators_titles` VALUES (1,'number of judges trained in SGBV',7),(2,'proportion of convicted prosecuted  cases ',9),(3,'proportion of withdrawn prosecuted cases',8),(4,'average time to conclude cases',0),(5,'proportion of prosecuted sgbv cases',17),(6,'number of prosecutors  trained using sgbv manual',15),(7,'number of sgbv cases received',16),(8,'number of sgbv cases reported to national police ',13),(9,'number of service providers trained ',2),(10,'number of cases reported to health facilities',3),(11,'proportion of survivors initiated on PEP',4),(12,'proportion of survivors who have completed PEP',5),(13,'proportion of survivors who have received comprehe',6);
/*!40000 ALTER TABLE `indicators_titles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `age_range`
--

DROP TABLE IF EXISTS `age_range`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `age_range` (
  `age_range_id` int(11) NOT NULL AUTO_INCREMENT,
  `age_range` varchar(100) NOT NULL,
  PRIMARY KEY (`age_range_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `age_range`
--

LOCK TABLES `age_range` WRITE;
/*!40000 ALTER TABLE `age_range` DISABLE KEYS */;
INSERT INTO `age_range` VALUES (1,'0-11 Yrs'),(2,'12-17 Yrs'),(3,'18-49 Yrs'),(4,'50 yrs+');
/*!40000 ALTER TABLE `age_range` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `community_aggregates`
--

DROP TABLE IF EXISTS `community_aggregates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `community_aggregates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `county_id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `indicator_id` int(10) NOT NULL,
  `aggregate` int(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `community_aggregates`
--

LOCK TABLES `community_aggregates` WRITE;
/*!40000 ALTER TABLE `community_aggregates` DISABLE KEYS */;
/*!40000 ALTER TABLE `community_aggregates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(20) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_groups`
--

LOCK TABLES `user_groups` WRITE;
/*!40000 ALTER TABLE `user_groups` DISABLE KEYS */;
INSERT INTO `user_groups` VALUES (1,'Super Admin','General access','2015-03-25 00:00:00'),(2,'Admin','Only reports aceess of sector 2','2015-03-26 00:00:00'),(3,'Guest','Normal user','2015-01-23 00:00:00');
/*!40000 ALTER TABLE `user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `education_aggregates`
--

DROP TABLE IF EXISTS `education_aggregates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `education_aggregates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `county_id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `indicator_id` int(10) NOT NULL,
  `aggregate` int(100) NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `timestamp_created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `ownership` int(11) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `violence_type` int(11) DEFAULT NULL,
  `identity_of_perpetrator` int(11) DEFAULT NULL,
  `place_of_victimization` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `education_aggregates`
--

LOCK TABLES `education_aggregates` WRITE;
/*!40000 ALTER TABLE `education_aggregates` DISABLE KEYS */;
/*!40000 ALTER TABLE `education_aggregates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `mobile_phone` varchar(100) NOT NULL,
  `sector` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user_group` int(11) NOT NULL,
  `join_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (3,'Guest','user','','0','guest','62ef34f4e7b271b4ccdb5cbeb1546fd5','mainasteve@gmail.com',3,'2015-02-03 08:31:59'),(11,'super','Admin','','0','superadmin','62ef34f4e7b271b4ccdb5cbeb1546fd5','benardkkoech@gmail.com',1,'2015-02-19 11:54:31'),(30,'Judiciary','Admin','','1','jadmin','62ef34f4e7b271b4ccdb5cbeb1546fd5','',2,'2016-01-28 07:58:19'),(37,'Test','Admin Police','123','3','test_admin_police','81dc9bdb52d04dc20036dbd8313ed055','a@a',2,'2016-01-28 20:28:36'),(38,'Test','Admin Judiciary','123','1','test_admin_judiciary','81dc9bdb52d04dc20036dbd8313ed055','a@a',2,'2016-01-28 20:30:29'),(36,'Test','Admin Health','123456','2','test_admin_health','81dc9bdb52d04dc20036dbd8313ed055','a@a',2,'2016-01-28 20:27:08'),(35,'Test','Super Admin','1234','0','test_super_admin','81dc9bdb52d04dc20036dbd8313ed055','a@a',1,'2016-01-28 20:25:04'),(24,'Community','User','','8','cuser','14d47aa6b34706e18fcde2edea266622','nzisa.liku@gmail.com',3,'2016-01-28 05:42:18'),(32,'Amin','Health','','2','ahealth','81dc9bdb52d04dc20036dbd8313ed055','',2,'2016-01-28 10:06:04'),(31,'Health','Admin','','2','hadmin','62ef34f4e7b271b4ccdb5cbeb1546fd5','',2,'2016-01-28 10:04:05'),(27,'Police','Admin','','3','padmin','62ef34f4e7b271b4ccdb5cbeb1546fd5','',2,'2016-01-28 06:24:55'),(28,'Prosecution','Admin','','4','pradmin','62ef34f4e7b271b4ccdb5cbeb1546fd5','',2,'2016-01-28 06:25:48'),(29,'Education','Admin','','5','eadmin','62ef34f4e7b271b4ccdb5cbeb1546fd5','',2,'2016-01-28 06:26:37'),(39,'Test','Admin Prosecution','123','4','test_admin_prosecution','81dc9bdb52d04dc20036dbd8313ed055','a@a',2,'2016-01-28 20:32:19'),(40,'Test','Admin Education','123','5','test_admin_education','81dc9bdb52d04dc20036dbd8313ed055','a@a',2,'2016-01-28 20:33:18'),(41,'Test','Guest','123','8','test_guest','81dc9bdb52d04dc20036dbd8313ed055','a@a',3,'2016-01-28 20:34:18'),(42,'t','t','','2','t','c20ad4d76fe97759aa27a0c99bff6710','t@t.net',3,'2016-02-05 20:39:30'),(43,'y','y','','2','y','c20ad4d76fe97759aa27a0c99bff6710','t@w.edu',3,'2016-02-05 20:48:46');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cadres`
--

DROP TABLE IF EXISTS `cadres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cadres` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cadre` varchar(100) NOT NULL,
  `sector_id` int(11) NOT NULL DEFAULT '0',
  `gender` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cadres`
--

LOCK TABLES `cadres` WRITE;
/*!40000 ALTER TABLE `cadres` DISABLE KEYS */;
INSERT INTO `cadres` VALUES (1,'Medical officer',2,NULL),(2,'Nursing officer',2,NULL),(3,'Clinical officer',2,NULL),(4,'Supreme Court Judges',1,'male,female'),(5,'Court of Appeal Judges',1,'male,female'),(6,'High Court Judges',1,'male,female'),(7,'Chief Magistrate',1,'male,female'),(8,'Senior Principal Magistrate',1,'male,female'),(9,'Principal Magistrate',1,'male,female'),(10,'Senior Resident Magistrate',1,'male,female'),(11,'Resident Magistrate',1,'male,female'),(12,'Chief Kadhi',1,'male'),(13,'Deputy Chief Kadhi',1,'male'),(14,'Kadhi',1,'male'),(15,'Counsellor',2,NULL),(16,'Laboratory technologist',2,NULL);
/*!40000 ALTER TABLE `cadres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `counties`
--

DROP TABLE IF EXISTS `counties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `counties` (
  `county_id` int(2) NOT NULL DEFAULT '0',
  `county_name` varchar(15) NOT NULL,
  PRIMARY KEY (`county_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `counties`
--

LOCK TABLES `counties` WRITE;
/*!40000 ALTER TABLE `counties` DISABLE KEYS */;
INSERT INTO `counties` VALUES (1,'Mombasa'),(2,'Kwale'),(3,'Kilifi'),(4,'Tana River'),(5,'Lamu'),(6,'Taita-Taveta'),(7,'Garissa'),(8,'Wajir'),(9,'Mandera'),(10,'Marsabit'),(11,'Isiolo'),(12,'Meru'),(13,'Tharaka-Nithi'),(14,'Embu'),(15,'Kitui'),(16,'Machakos'),(17,'Makueni'),(18,'Nyandarua'),(19,'Nyeri'),(20,'Kirinyaga'),(21,'Murang\'a'),(22,'Kiambu'),(23,'Turkana'),(24,'West Pokot'),(25,'Samburu'),(26,'Trans Nzoia'),(27,'Uasin Gishu'),(28,'Elgeyo-Marakwet'),(29,'Nandi'),(30,'Baringo'),(31,'Laikipia'),(32,'Nakuru'),(33,'Narok'),(34,'Kajiado'),(35,'Kericho'),(36,'Bomet'),(37,'Kakamega'),(38,'Vihiga'),(39,'Bungoma'),(40,'Busia'),(41,'Siaya'),(42,'Kisumu'),(43,'Homa Bay'),(44,'Migori'),(45,'Kisii'),(46,'Nyamira'),(47,'Nairobi County');
/*!40000 ALTER TABLE `counties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_uploads`
--

DROP TABLE IF EXISTS `file_uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file_uploads` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `size` varchar(100) NOT NULL,
  `path` varchar(200) NOT NULL,
  `status` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `uploadedby` varchar(20) NOT NULL,
  `sector` varchar(20) NOT NULL,
  `useremail` varchar(20) NOT NULL,
  `rejection_reason` varchar(200) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_uploads`
--

LOCK TABLES `file_uploads` WRITE;
/*!40000 ALTER TABLE `file_uploads` DISABLE KEYS */;
INSERT INTO `file_uploads` VALUES (1,'judiciary_aggregates_database_format_demo.xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','10907','../../Uploaded_files/judiciary_aggregates_database_format_demo.xlsx','Approved','Judiciary Aggregates January 2015','judiciary','Judiciary','benardkkoech@gmail.c','','2015-03-17 16:42:55'),(3,'health_aggregates_database_format _demo.xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','18249','../../Uploaded_files/.health_aggregates_database_format _demo.xlsx','Rejected','Health Aggregates','health','Health','martinge@gmail.com','file not found in the system','2015-03-17 15:41:51'),(5,'police_aggregates_database_format_demo.xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','18449','../../Uploaded_files/police_aggregates_database_format_demo.xlsx','Approved','Police aggregates','police','Police','police@gmail.com','','2015-03-17 16:41:47'),(7,'prosecution_aggregates_database_format_demo.xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','14565','../../Uploaded_files/.prosecution_aggregates_database_format_demo.xlsx','Rejected','prosecution','prosecution','Prosecution','info@ardech.co.ke','File not correct','2015-03-17 16:31:02'),(12,'health_aggregates_cases_reported.xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','17237','../Uploaded_files/health_aggregates_cases_reported.xlsx','Rejected','test','health','Health ','martinge@gmail.com','Incorrect data','2015-03-31 17:23:40'),(14,'health_aggregates_database_desegrated.xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','8568','../Uploaded_files/health_aggregates_database_desegrated.xlsx','Approved','Desegrated','health','Health ','martinge@gmail.com',NULL,'2015-03-31 17:31:31'),(16,'health_aggregates_cases_reported_survey2.xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','17241','../Uploaded_files/health_aggregates_cases_reported_survey2.xlsx','Not Approved','test','health','Health ','martinge@gmail.com',NULL,'2015-03-31 17:50:04');
/*!40000 ALTER TABLE `file_uploads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sectors`
--

DROP TABLE IF EXISTS `sectors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sectors` (
  `sector_id` int(10) NOT NULL AUTO_INCREMENT,
  `sector` varchar(100) NOT NULL,
  PRIMARY KEY (`sector_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sectors`
--

LOCK TABLES `sectors` WRITE;
/*!40000 ALTER TABLE `sectors` DISABLE KEYS */;
INSERT INTO `sectors` VALUES (1,'Judiciary'),(2,'Health '),(3,'Police'),(4,'Prosecution'),(5,'Education');
/*!40000 ALTER TABLE `sectors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ranks`
--

DROP TABLE IF EXISTS `ranks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ranks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rank` varchar(100) NOT NULL,
  `sector_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ranks`
--

LOCK TABLES `ranks` WRITE;
/*!40000 ALTER TABLE `ranks` DISABLE KEYS */;
INSERT INTO `ranks` VALUES (1,'Inspector-General',3),(2,'Deputy Inspector-General',3),(3,'Senior Assistant Inspector General',3),(4,'Assistant Inspector-General',3),(5,'Senior Superintendent',3),(6,'Superintendent',3),(7,'Assistant Superintendent',3),(8,'Chief Inspector',3),(9,'Inspector',3),(10,'Senior Sergeant',3),(11,'Sergeant',3),(12,'Constable',3),(14,'Commissioner',3),(15,'Attorney General',4),(16,'Solicitor General',4),(17,'Director of Public Prosecutions',4),(18,'Assistant Director of Public Prosecutions',4),(19,'Senior Principal State Counsel',4),(20,'Senior State Counsel',4),(21,'State Counsel One',4),(22,'State Counsel Two',4),(23,'Corporal',3);
/*!40000 ALTER TABLE `ranks` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-22 11:34:36
