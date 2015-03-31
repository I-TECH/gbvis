CREATE DATABASE  IF NOT EXISTS `test` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `test`;
-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (i686)
--
-- Host: 127.0.0.1    Database: test
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.14.04.1

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
-- Temporary table structure for view `viewtop5healthcasesreported`
--

DROP TABLE IF EXISTS `viewtop5healthcasesreported`;
/*!50001 DROP VIEW IF EXISTS `viewtop5healthcasesreported`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewtop5healthcasesreported` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `initiatedPEPTotal` tinyint NOT NULL,
  `completedPEPTotal` tinyint NOT NULL,
  `receivedcareTotal` tinyint NOT NULL,
  `casesReportedTotal` tinyint NOT NULL,
  `countycasesReportedPercentage` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewtop5receivedcomprehensivecare`
--

DROP TABLE IF EXISTS `viewtop5receivedcomprehensivecare`;
/*!50001 DROP VIEW IF EXISTS `viewtop5receivedcomprehensivecare`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewtop5receivedcomprehensivecare` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `initiatedPEPTotal` tinyint NOT NULL,
  `completedPEPTotal` tinyint NOT NULL,
  `receivedcareTotal` tinyint NOT NULL,
  `casesReportedTotal` tinyint NOT NULL,
  `countycasesReportedPercentage` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v12`
--

DROP TABLE IF EXISTS `v12`;
/*!50001 DROP VIEW IF EXISTS `v12`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v12` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `aggregate` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL,
  `county_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v13`
--

DROP TABLE IF EXISTS `v13`;
/*!50001 DROP VIEW IF EXISTS `v13`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v13` (
  `survey_id` tinyint NOT NULL,
  `county_id` tinyint NOT NULL,
  `county_name` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v10`
--

DROP TABLE IF EXISTS `v10`;
/*!50001 DROP VIEW IF EXISTS `v10`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v10` (
  `survey_id` tinyint NOT NULL,
  `county_id` tinyint NOT NULL,
  `county_name` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v11`
--

DROP TABLE IF EXISTS `v11`;
/*!50001 DROP VIEW IF EXISTS `v11`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v11` (
  `nationalTotal` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v16`
--

DROP TABLE IF EXISTS `v16`;
/*!50001 DROP VIEW IF EXISTS `v16`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v16` (
  `completedPEPTotal` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v17`
--

DROP TABLE IF EXISTS `v17`;
/*!50001 DROP VIEW IF EXISTS `v17`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v17` (
  `receivedcareTotal` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v14`
--

DROP TABLE IF EXISTS `v14`;
/*!50001 DROP VIEW IF EXISTS `v14`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v14` (
  `casesReportedTotal` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v15`
--

DROP TABLE IF EXISTS `v15`;
/*!50001 DROP VIEW IF EXISTS `v15`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v15` (
  `initiatedPEPTotal` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewsummarytriedcases`
--

DROP TABLE IF EXISTS `viewsummarytriedcases`;
/*!50001 DROP VIEW IF EXISTS `viewsummarytriedcases`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewsummarytriedcases` (
  `indicator` tinyint NOT NULL,
  `nationalTriedTotal` tinyint NOT NULL,
  `nationalProsecutionTotal` tinyint NOT NULL,
  `IndicatorPercentage` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v9`
--

DROP TABLE IF EXISTS `v9`;
/*!50001 DROP VIEW IF EXISTS `v9`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v9` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `aggregate` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL,
  `county_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewunresolvedcases`
--

DROP TABLE IF EXISTS `viewunresolvedcases`;
/*!50001 DROP VIEW IF EXISTS `viewunresolvedcases`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewunresolvedcases` (
  `survey_id` tinyint NOT NULL,
  `nationalTriedTotal` tinyint NOT NULL,
  `nationalProsecutionTotal` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewhealthaggregates`
--

DROP TABLE IF EXISTS `viewhealthaggregates`;
/*!50001 DROP VIEW IF EXISTS `viewhealthaggregates`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewhealthaggregates` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `initiatedPEPTotal` tinyint NOT NULL,
  `completedPEPTotal` tinyint NOT NULL,
  `receivedcareTotal` tinyint NOT NULL,
  `casesReportedTotal` tinyint NOT NULL,
  `countycasesReportedPercentage` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewprosecutedcases`
--

DROP TABLE IF EXISTS `viewprosecutedcases`;
/*!50001 DROP VIEW IF EXISTS `viewprosecutedcases`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewprosecutedcases` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county_name` tinyint NOT NULL,
  `countyPercentage1` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `countyPercentage` tinyint NOT NULL,
  `nationalProsecutionTotal` tinyint NOT NULL,
  `nationalPercentage` tinyint NOT NULL,
  `nationalPoliceTotal` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewprosecutionaggregates`
--

DROP TABLE IF EXISTS `viewprosecutionaggregates`;
/*!50001 DROP VIEW IF EXISTS `viewprosecutionaggregates`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewprosecutionaggregates` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county_name` tinyint NOT NULL,
  `county_id` tinyint NOT NULL,
  `countyPercentage1` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `countyPercentage` tinyint NOT NULL,
  `nationalProsecutionTotal` tinyint NOT NULL,
  `nationalPercentage` tinyint NOT NULL,
  `nationalPoliceTotal` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewtop5serviceproviderstrained`
--

DROP TABLE IF EXISTS `viewtop5serviceproviderstrained`;
/*!50001 DROP VIEW IF EXISTS `viewtop5serviceproviderstrained`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewtop5serviceproviderstrained` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `initiatedPEPTotal` tinyint NOT NULL,
  `completedPEPTotal` tinyint NOT NULL,
  `receivedcareTotal` tinyint NOT NULL,
  `casesReportedTotal` tinyint NOT NULL,
  `countycasesReportedPercentage` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewprosecutorstrained`
--

DROP TABLE IF EXISTS `viewprosecutorstrained`;
/*!50001 DROP VIEW IF EXISTS `viewprosecutorstrained`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewprosecutorstrained` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county_name` tinyint NOT NULL,
  `county_id` tinyint NOT NULL,
  `countyPercentage1` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `countyPercentage` tinyint NOT NULL,
  `nationalProsecutionTotal` tinyint NOT NULL,
  `nationalPercentage` tinyint NOT NULL,
  `nationalPoliceTotal` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewpoliceaggregates`
--

DROP TABLE IF EXISTS `viewpoliceaggregates`;
/*!50001 DROP VIEW IF EXISTS `viewpoliceaggregates`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewpoliceaggregates` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county` tinyint NOT NULL,
  `countyTotal` tinyint NOT NULL,
  `nationalTotal` tinyint NOT NULL,
  `percentage` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewhealthcasesreported`
--

DROP TABLE IF EXISTS `viewhealthcasesreported`;
/*!50001 DROP VIEW IF EXISTS `viewhealthcasesreported`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewhealthcasesreported` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `initiatedPEPTotal` tinyint NOT NULL,
  `completedPEPTotal` tinyint NOT NULL,
  `receivedcareTotal` tinyint NOT NULL,
  `casesReportedTotal` tinyint NOT NULL,
  `countycasesReportedPercentage` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewpolicesummary`
--

DROP TABLE IF EXISTS `viewpolicesummary`;
/*!50001 DROP VIEW IF EXISTS `viewpolicesummary`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewpolicesummary` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `Aggregates` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewtop5receivedcases`
--

DROP TABLE IF EXISTS `viewtop5receivedcases`;
/*!50001 DROP VIEW IF EXISTS `viewtop5receivedcases`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewtop5receivedcases` (
  `county_name` tinyint NOT NULL,
  `Aggregate` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewserviceproviderstrained`
--

DROP TABLE IF EXISTS `viewserviceproviderstrained`;
/*!50001 DROP VIEW IF EXISTS `viewserviceproviderstrained`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewserviceproviderstrained` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `initiatedPEPTotal` tinyint NOT NULL,
  `completedPEPTotal` tinyint NOT NULL,
  `receivedcareTotal` tinyint NOT NULL,
  `casesReportedTotal` tinyint NOT NULL,
  `countycasesReportedPercentage` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewconvictedcases`
--

DROP TABLE IF EXISTS `viewconvictedcases`;
/*!50001 DROP VIEW IF EXISTS `viewconvictedcases`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewconvictedcases` (
  `indicator` tinyint NOT NULL,
  `county_name` tinyint NOT NULL,
  `county_id` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `countyPercentage` tinyint NOT NULL,
  `nationalAggregate` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewhealthsummary`
--

DROP TABLE IF EXISTS `viewhealthsummary`;
/*!50001 DROP VIEW IF EXISTS `viewhealthsummary`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewhealthsummary` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `Aggregates` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewtop5prosecutedcases`
--

DROP TABLE IF EXISTS `viewtop5prosecutedcases`;
/*!50001 DROP VIEW IF EXISTS `viewtop5prosecutedcases`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewtop5prosecutedcases` (
  `county_name` tinyint NOT NULL,
  `countyPercentage` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewpepcompleted`
--

DROP TABLE IF EXISTS `viewpepcompleted`;
/*!50001 DROP VIEW IF EXISTS `viewpepcompleted`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewpepcompleted` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `initiatedPEPTotal` tinyint NOT NULL,
  `completedPEPTotal` tinyint NOT NULL,
  `receivedcareTotal` tinyint NOT NULL,
  `casesReportedTotal` tinyint NOT NULL,
  `countycasesReportedPercentage` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewtriedcases`
--

DROP TABLE IF EXISTS `viewtriedcases`;
/*!50001 DROP VIEW IF EXISTS `viewtriedcases`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewtriedcases` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county_name` tinyint NOT NULL,
  `county_id` tinyint NOT NULL,
  `countyPercentage` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `nationalTriedTotal` tinyint NOT NULL,
  `nationalPercentage` tinyint NOT NULL,
  `nationalProsecutionTotal` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewjudiciarysummary`
--

DROP TABLE IF EXISTS `viewjudiciarysummary`;
/*!50001 DROP VIEW IF EXISTS `viewjudiciarysummary`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewjudiciarysummary` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `Aggregates` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewprosecutionsummary`
--

DROP TABLE IF EXISTS `viewprosecutionsummary`;
/*!50001 DROP VIEW IF EXISTS `viewprosecutionsummary`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewprosecutionsummary` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `Aggregates` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewtop5casesreported`
--

DROP TABLE IF EXISTS `viewtop5casesreported`;
/*!50001 DROP VIEW IF EXISTS `viewtop5casesreported`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewtop5casesreported` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county` tinyint NOT NULL,
  `countyTotal` tinyint NOT NULL,
  `nationalTotal` tinyint NOT NULL,
  `percentage` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewtop5pepcompleted`
--

DROP TABLE IF EXISTS `viewtop5pepcompleted`;
/*!50001 DROP VIEW IF EXISTS `viewtop5pepcompleted`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewtop5pepcompleted` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `initiatedPEPTotal` tinyint NOT NULL,
  `completedPEPTotal` tinyint NOT NULL,
  `receivedcareTotal` tinyint NOT NULL,
  `casesReportedTotal` tinyint NOT NULL,
  `countycasesReportedPercentage` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewtop5withdrawncases`
--

DROP TABLE IF EXISTS `viewtop5withdrawncases`;
/*!50001 DROP VIEW IF EXISTS `viewtop5withdrawncases`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewtop5withdrawncases` (
  `county_name` tinyint NOT NULL,
  `county_id` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL,
  `Withdrawn` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewcasesreported`
--

DROP TABLE IF EXISTS `viewcasesreported`;
/*!50001 DROP VIEW IF EXISTS `viewcasesreported`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewcasesreported` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county` tinyint NOT NULL,
  `countyTotal` tinyint NOT NULL,
  `nationalTotal` tinyint NOT NULL,
  `percentage` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewtop5prosecutorstrained`
--

DROP TABLE IF EXISTS `viewtop5prosecutorstrained`;
/*!50001 DROP VIEW IF EXISTS `viewtop5prosecutorstrained`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewtop5prosecutorstrained` (
  `county_name` tinyint NOT NULL,
  `county_id` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL,
  `Trained` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewreceivedcases`
--

DROP TABLE IF EXISTS `viewreceivedcases`;
/*!50001 DROP VIEW IF EXISTS `viewreceivedcases`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewreceivedcases` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county_name` tinyint NOT NULL,
  `countyPercentage1` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `countyPercentage` tinyint NOT NULL,
  `nationalProsecutionTotal` tinyint NOT NULL,
  `nationalPercentage` tinyint NOT NULL,
  `nationalPoliceTotal` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewtop5pepinitiated`
--

DROP TABLE IF EXISTS `viewtop5pepinitiated`;
/*!50001 DROP VIEW IF EXISTS `viewtop5pepinitiated`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewtop5pepinitiated` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `initiatedPEPTotal` tinyint NOT NULL,
  `completedPEPTotal` tinyint NOT NULL,
  `receivedcareTotal` tinyint NOT NULL,
  `casesReportedTotal` tinyint NOT NULL,
  `countycasesReportedPercentage` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewtop5convictedcases`
--

DROP TABLE IF EXISTS `viewtop5convictedcases`;
/*!50001 DROP VIEW IF EXISTS `viewtop5convictedcases`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewtop5convictedcases` (
  `county_name` tinyint NOT NULL,
  `county_id` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL,
  `Convicted` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewreceivedcomprehensivecare`
--

DROP TABLE IF EXISTS `viewreceivedcomprehensivecare`;
/*!50001 DROP VIEW IF EXISTS `viewreceivedcomprehensivecare`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewreceivedcomprehensivecare` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `initiatedPEPTotal` tinyint NOT NULL,
  `completedPEPTotal` tinyint NOT NULL,
  `receivedcareTotal` tinyint NOT NULL,
  `casesReportedTotal` tinyint NOT NULL,
  `countycasesReportedPercentage` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewjudgestrained`
--

DROP TABLE IF EXISTS `viewjudgestrained`;
/*!50001 DROP VIEW IF EXISTS `viewjudgestrained`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewjudgestrained` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL,
  `county_name` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v1`
--

DROP TABLE IF EXISTS `v1`;
/*!50001 DROP VIEW IF EXISTS `v1`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v1` (
  `indicator_id` tinyint NOT NULL,
  `indicator` tinyint NOT NULL,
  `county_id` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v2`
--

DROP TABLE IF EXISTS `v2`;
/*!50001 DROP VIEW IF EXISTS `v2`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v2` (
  `survey_id` tinyint NOT NULL,
  `county_id` tinyint NOT NULL,
  `county_name` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v3`
--

DROP TABLE IF EXISTS `v3`;
/*!50001 DROP VIEW IF EXISTS `v3`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v3` (
  `nationalTriedTotal` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v4`
--

DROP TABLE IF EXISTS `v4`;
/*!50001 DROP VIEW IF EXISTS `v4`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v4` (
  `nationalProsecutionTotal` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v5`
--

DROP TABLE IF EXISTS `v5`;
/*!50001 DROP VIEW IF EXISTS `v5`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v5` (
  `indicator_id` tinyint NOT NULL,
  `indicator` tinyint NOT NULL,
  `county_id` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v6`
--

DROP TABLE IF EXISTS `v6`;
/*!50001 DROP VIEW IF EXISTS `v6`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v6` (
  `survey_id` tinyint NOT NULL,
  `county_id` tinyint NOT NULL,
  `county_name` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v7`
--

DROP TABLE IF EXISTS `v7`;
/*!50001 DROP VIEW IF EXISTS `v7`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v7` (
  `nationalProsecutionTotal` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `v8`
--

DROP TABLE IF EXISTS `v8`;
/*!50001 DROP VIEW IF EXISTS `v8`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `v8` (
  `nationalPoliceTotal` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewpepinitiated`
--

DROP TABLE IF EXISTS `viewpepinitiated`;
/*!50001 DROP VIEW IF EXISTS `viewpepinitiated`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewpepinitiated` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `initiatedPEPTotal` tinyint NOT NULL,
  `completedPEPTotal` tinyint NOT NULL,
  `receivedcareTotal` tinyint NOT NULL,
  `casesReportedTotal` tinyint NOT NULL,
  `countycasesReportedPercentage` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewwithdrawncases`
--

DROP TABLE IF EXISTS `viewwithdrawncases`;
/*!50001 DROP VIEW IF EXISTS `viewwithdrawncases`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewwithdrawncases` (
  `indicator` tinyint NOT NULL,
  `county_name` tinyint NOT NULL,
  `county_id` tinyint NOT NULL,
  `countyPercentage` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `nationalTriedTotal` tinyint NOT NULL,
  `nationalPercentage` tinyint NOT NULL,
  `nationalProsecutionTotal` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewtop5judgestrained`
--

DROP TABLE IF EXISTS `viewtop5judgestrained`;
/*!50001 DROP VIEW IF EXISTS `viewtop5judgestrained`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewtop5judgestrained` (
  `county_name` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `viewjudiciaryaggregates`
--

DROP TABLE IF EXISTS `viewjudiciaryaggregates`;
/*!50001 DROP VIEW IF EXISTS `viewjudiciaryaggregates`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `viewjudiciaryaggregates` (
  `indicator` tinyint NOT NULL,
  `indicator_id` tinyint NOT NULL,
  `county_name` tinyint NOT NULL,
  `county_id` tinyint NOT NULL,
  `countyPercentage` tinyint NOT NULL,
  `survey_id` tinyint NOT NULL,
  `countyAggregate` tinyint NOT NULL,
  `nationalTriedTotal` tinyint NOT NULL,
  `nationalPercentage` tinyint NOT NULL,
  `nationalProsecutionTotal` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `viewtop5healthcasesreported`
--

/*!50001 DROP TABLE IF EXISTS `viewtop5healthcasesreported`*/;
/*!50001 DROP VIEW IF EXISTS `viewtop5healthcasesreported`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewtop5healthcasesreported` AS select `viewhealthcasesreported`.`indicator` AS `indicator`,`viewhealthcasesreported`.`indicator_id` AS `indicator_id`,`viewhealthcasesreported`.`county` AS `county`,`viewhealthcasesreported`.`countyAggregate` AS `countyAggregate`,`viewhealthcasesreported`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewhealthcasesreported`.`completedPEPTotal` AS `completedPEPTotal`,`viewhealthcasesreported`.`receivedcareTotal` AS `receivedcareTotal`,`viewhealthcasesreported`.`casesReportedTotal` AS `casesReportedTotal`,`viewhealthcasesreported`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewhealthcasesreported` order by `viewhealthcasesreported`.`countyAggregate` desc limit 5 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewtop5receivedcomprehensivecare`
--

/*!50001 DROP TABLE IF EXISTS `viewtop5receivedcomprehensivecare`*/;
/*!50001 DROP VIEW IF EXISTS `viewtop5receivedcomprehensivecare`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewtop5receivedcomprehensivecare` AS select `viewreceivedcomprehensivecare`.`indicator` AS `indicator`,`viewreceivedcomprehensivecare`.`indicator_id` AS `indicator_id`,`viewreceivedcomprehensivecare`.`county` AS `county`,`viewreceivedcomprehensivecare`.`countyAggregate` AS `countyAggregate`,`viewreceivedcomprehensivecare`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewreceivedcomprehensivecare`.`completedPEPTotal` AS `completedPEPTotal`,`viewreceivedcomprehensivecare`.`receivedcareTotal` AS `receivedcareTotal`,`viewreceivedcomprehensivecare`.`casesReportedTotal` AS `casesReportedTotal`,`viewreceivedcomprehensivecare`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewreceivedcomprehensivecare` order by `viewreceivedcomprehensivecare`.`countycasesReportedPercentage` desc limit 5 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v12`
--

/*!50001 DROP TABLE IF EXISTS `v12`*/;
/*!50001 DROP VIEW IF EXISTS `v12`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v12` AS select `i`.`indicator` AS `indicator`,`i`.`indicator_id` AS `indicator_id`,`a`.`aggregate` AS `aggregate`,`i`.`survey_id` AS `survey_id`,`a`.`county_id` AS `county_id` from (`indicators` `i` join `health_aggregates` `a` on((`i`.`indicator_id` = `a`.`indicator_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v13`
--

/*!50001 DROP TABLE IF EXISTS `v13`*/;
/*!50001 DROP VIEW IF EXISTS `v13`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v13` AS select `a`.`survey_id` AS `survey_id`,`c`.`county_id` AS `county_id`,`c`.`county_name` AS `county_name` from (`health_aggregates` `a` join `counties` `c` on((`c`.`county_id` = `a`.`county_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v10`
--

/*!50001 DROP TABLE IF EXISTS `v10`*/;
/*!50001 DROP VIEW IF EXISTS `v10`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v10` AS select `a`.`survey_id` AS `survey_id`,`c`.`county_id` AS `county_id`,`c`.`county_name` AS `county_name` from (`police_aggregates` `a` join `counties` `c` on((`c`.`county_id` = `a`.`county_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v11`
--

/*!50001 DROP TABLE IF EXISTS `v11`*/;
/*!50001 DROP VIEW IF EXISTS `v11`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v11` AS select sum(`p`.`aggregate`) AS `nationalTotal`,`p`.`survey_id` AS `survey_id` from (`police_aggregates` `p` join `surveys` `s` on((`p`.`survey_id` = `s`.`survey_id`))) group by `p`.`survey_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v16`
--

/*!50001 DROP TABLE IF EXISTS `v16`*/;
/*!50001 DROP VIEW IF EXISTS `v16`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v16` AS select sum(`p`.`aggregate`) AS `completedPEPTotal`,`p`.`survey_id` AS `survey_id` from (`health_aggregates` `p` join `surveys` `s` on((`p`.`survey_id` = `s`.`survey_id`))) where (`p`.`indicator_id` = 5) group by `p`.`survey_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v17`
--

/*!50001 DROP TABLE IF EXISTS `v17`*/;
/*!50001 DROP VIEW IF EXISTS `v17`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v17` AS select sum(`p`.`aggregate`) AS `receivedcareTotal`,`p`.`survey_id` AS `survey_id` from (`health_aggregates` `p` join `surveys` `s` on((`p`.`survey_id` = `s`.`survey_id`))) where (`p`.`indicator_id` = 6) group by `p`.`survey_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v14`
--

/*!50001 DROP TABLE IF EXISTS `v14`*/;
/*!50001 DROP VIEW IF EXISTS `v14`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v14` AS select sum(`p`.`aggregate`) AS `casesReportedTotal`,`p`.`survey_id` AS `survey_id` from (`health_aggregates` `p` join `surveys` `s` on((`p`.`survey_id` = `s`.`survey_id`))) where (`p`.`indicator_id` = 3) group by `p`.`survey_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v15`
--

/*!50001 DROP TABLE IF EXISTS `v15`*/;
/*!50001 DROP VIEW IF EXISTS `v15`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v15` AS select sum(`p`.`aggregate`) AS `initiatedPEPTotal`,`p`.`survey_id` AS `survey_id` from (`health_aggregates` `p` join `surveys` `s` on((`p`.`survey_id` = `s`.`survey_id`))) where (`p`.`indicator_id` = 4) group by `p`.`survey_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewsummarytriedcases`
--

/*!50001 DROP TABLE IF EXISTS `viewsummarytriedcases`*/;
/*!50001 DROP VIEW IF EXISTS `viewsummarytriedcases`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewsummarytriedcases` AS select `viewtriedcases`.`indicator` AS `indicator`,`viewtriedcases`.`nationalTriedTotal` AS `nationalTriedTotal`,`viewtriedcases`.`nationalProsecutionTotal` AS `nationalProsecutionTotal`,sum(`viewtriedcases`.`countyPercentage`) AS `IndicatorPercentage` from `viewtriedcases` group by `viewtriedcases`.`indicator` union select 'number of unresolved cases' AS `Indicator`,sum(`viewunresolvedcases`.`nationalTriedTotal`) AS `nationalTriedTotal`,`viewunresolvedcases`.`nationalProsecutionTotal` AS `nationalProsecutionTotal`,(((`viewunresolvedcases`.`nationalProsecutionTotal` - sum(`viewunresolvedcases`.`nationalTriedTotal`)) / `viewunresolvedcases`.`nationalProsecutionTotal`) * 100) AS `IndicatorPercentage` from `viewunresolvedcases` group by `viewunresolvedcases`.`survey_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v9`
--

/*!50001 DROP TABLE IF EXISTS `v9`*/;
/*!50001 DROP VIEW IF EXISTS `v9`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v9` AS select `i`.`indicator` AS `indicator`,`i`.`indicator_id` AS `indicator_id`,`a`.`aggregate` AS `aggregate`,`i`.`survey_id` AS `survey_id`,`a`.`county_id` AS `county_id` from (`indicators` `i` join `police_aggregates` `a` on((`i`.`indicator_id` = `a`.`indicator_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewunresolvedcases`
--

/*!50001 DROP TABLE IF EXISTS `viewunresolvedcases`*/;
/*!50001 DROP VIEW IF EXISTS `viewunresolvedcases`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewunresolvedcases` AS select `viewtriedcases`.`survey_id` AS `survey_id`,`viewtriedcases`.`nationalTriedTotal` AS `nationalTriedTotal`,`viewtriedcases`.`nationalProsecutionTotal` AS `nationalProsecutionTotal` from `viewtriedcases` group by `viewtriedcases`.`indicator` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewhealthaggregates`
--

/*!50001 DROP TABLE IF EXISTS `viewhealthaggregates`*/;
/*!50001 DROP VIEW IF EXISTS `viewhealthaggregates`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewhealthaggregates` AS select `x`.`indicator` AS `indicator`,`x`.`indicator_id` AS `indicator_id`,`y`.`county_name` AS `county`,`x`.`aggregate` AS `countyAggregate`,`j`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`k`.`completedPEPTotal` AS `completedPEPTotal`,`l`.`receivedcareTotal` AS `receivedcareTotal`,`z`.`casesReportedTotal` AS `casesReportedTotal`,((`x`.`aggregate` / `z`.`casesReportedTotal`) * 100) AS `countycasesReportedPercentage` from (((((`v12` `x` join `v13` `y`) join `v14` `z`) join `v15` `j`) join `v16` `k`) join `v17` `l` on(((`x`.`county_id` = `y`.`county_id`) and (`y`.`survey_id` = `z`.`survey_id`) and (`j`.`survey_id` = `z`.`survey_id`) and (`j`.`survey_id` = `k`.`survey_id`) and (`l`.`survey_id` = `k`.`survey_id`)))) group by `x`.`indicator`,`x`.`survey_id`,`y`.`county_name` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewprosecutedcases`
--

/*!50001 DROP TABLE IF EXISTS `viewprosecutedcases`*/;
/*!50001 DROP VIEW IF EXISTS `viewprosecutedcases`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewprosecutedcases` AS select `viewprosecutionaggregates`.`indicator` AS `indicator`,`viewprosecutionaggregates`.`indicator_id` AS `indicator_id`,`viewprosecutionaggregates`.`county_name` AS `county_name`,`viewprosecutionaggregates`.`countyPercentage1` AS `countyPercentage1`,`viewprosecutionaggregates`.`survey_id` AS `survey_id`,`viewprosecutionaggregates`.`countyAggregate` AS `countyAggregate`,`viewprosecutionaggregates`.`countyPercentage` AS `countyPercentage`,`viewprosecutionaggregates`.`nationalProsecutionTotal` AS `nationalProsecutionTotal`,`viewprosecutionaggregates`.`nationalPercentage` AS `nationalPercentage`,`viewprosecutionaggregates`.`nationalPoliceTotal` AS `nationalPoliceTotal` from `viewprosecutionaggregates` where (`viewprosecutionaggregates`.`indicator_id` = 17) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewprosecutionaggregates`
--

/*!50001 DROP TABLE IF EXISTS `viewprosecutionaggregates`*/;
/*!50001 DROP VIEW IF EXISTS `viewprosecutionaggregates`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewprosecutionaggregates` AS select `x`.`indicator` AS `indicator`,`x`.`indicator_id` AS `indicator_id`,`y`.`county_name` AS `county_name`,`y`.`county_id` AS `county_id`,((`x`.`countyAggregate` / `z`.`nationalPoliceTotal`) * 100) AS `countyPercentage1`,`y`.`survey_id` AS `survey_id`,`x`.`countyAggregate` AS `countyAggregate`,((`x`.`countyAggregate` / `z`.`nationalPoliceTotal`) * 100) AS `countyPercentage`,`j`.`nationalProsecutionTotal` AS `nationalProsecutionTotal`,((`j`.`nationalProsecutionTotal` / `z`.`nationalPoliceTotal`) * 100) AS `nationalPercentage`,`z`.`nationalPoliceTotal` AS `nationalPoliceTotal` from (((`v5` `x` join `v6` `y`) join `v7` `j`) join `v8` `z` on(((`x`.`county_id` = `y`.`county_id`) and (`y`.`survey_id` = `j`.`survey_id`) and (`z`.`survey_id` = `j`.`survey_id`) and (`x`.`indicator_id` = `j`.`indicator_id`)))) group by `x`.`indicator`,`x`.`survey_id`,`y`.`county_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewtop5serviceproviderstrained`
--

/*!50001 DROP TABLE IF EXISTS `viewtop5serviceproviderstrained`*/;
/*!50001 DROP VIEW IF EXISTS `viewtop5serviceproviderstrained`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewtop5serviceproviderstrained` AS select `viewserviceproviderstrained`.`indicator` AS `indicator`,`viewserviceproviderstrained`.`indicator_id` AS `indicator_id`,`viewserviceproviderstrained`.`county` AS `county`,`viewserviceproviderstrained`.`countyAggregate` AS `countyAggregate`,`viewserviceproviderstrained`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewserviceproviderstrained`.`completedPEPTotal` AS `completedPEPTotal`,`viewserviceproviderstrained`.`receivedcareTotal` AS `receivedcareTotal`,`viewserviceproviderstrained`.`casesReportedTotal` AS `casesReportedTotal`,`viewserviceproviderstrained`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewserviceproviderstrained` order by `viewserviceproviderstrained`.`countyAggregate` desc limit 5 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewprosecutorstrained`
--

/*!50001 DROP TABLE IF EXISTS `viewprosecutorstrained`*/;
/*!50001 DROP VIEW IF EXISTS `viewprosecutorstrained`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewprosecutorstrained` AS select `viewprosecutionaggregates`.`indicator` AS `indicator`,`viewprosecutionaggregates`.`indicator_id` AS `indicator_id`,`viewprosecutionaggregates`.`county_name` AS `county_name`,`viewprosecutionaggregates`.`county_id` AS `county_id`,`viewprosecutionaggregates`.`countyPercentage1` AS `countyPercentage1`,`viewprosecutionaggregates`.`survey_id` AS `survey_id`,`viewprosecutionaggregates`.`countyAggregate` AS `countyAggregate`,`viewprosecutionaggregates`.`countyPercentage` AS `countyPercentage`,`viewprosecutionaggregates`.`nationalProsecutionTotal` AS `nationalProsecutionTotal`,`viewprosecutionaggregates`.`nationalPercentage` AS `nationalPercentage`,`viewprosecutionaggregates`.`nationalPoliceTotal` AS `nationalPoliceTotal` from `viewprosecutionaggregates` where (`viewprosecutionaggregates`.`indicator_id` = 15) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewpoliceaggregates`
--

/*!50001 DROP TABLE IF EXISTS `viewpoliceaggregates`*/;
/*!50001 DROP VIEW IF EXISTS `viewpoliceaggregates`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewpoliceaggregates` AS select `x`.`indicator` AS `indicator`,`x`.`indicator_id` AS `indicator_id`,`y`.`county_name` AS `county`,sum(`x`.`aggregate`) AS `countyTotal`,`z`.`nationalTotal` AS `nationalTotal`,((sum(`x`.`aggregate`) / `z`.`nationalTotal`) * 100) AS `percentage` from ((`v9` `x` join `v10` `y`) join `v11` `z` on(((`x`.`county_id` = `y`.`county_id`) and (`y`.`survey_id` = `z`.`survey_id`)))) group by `x`.`indicator`,`x`.`survey_id`,`y`.`county_name` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewhealthcasesreported`
--

/*!50001 DROP TABLE IF EXISTS `viewhealthcasesreported`*/;
/*!50001 DROP VIEW IF EXISTS `viewhealthcasesreported`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewhealthcasesreported` AS select `viewhealthaggregates`.`indicator` AS `indicator`,`viewhealthaggregates`.`indicator_id` AS `indicator_id`,`viewhealthaggregates`.`county` AS `county`,`viewhealthaggregates`.`countyAggregate` AS `countyAggregate`,`viewhealthaggregates`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewhealthaggregates`.`completedPEPTotal` AS `completedPEPTotal`,`viewhealthaggregates`.`receivedcareTotal` AS `receivedcareTotal`,`viewhealthaggregates`.`casesReportedTotal` AS `casesReportedTotal`,`viewhealthaggregates`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewhealthaggregates` where (`viewhealthaggregates`.`indicator_id` = 3) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewpolicesummary`
--

/*!50001 DROP TABLE IF EXISTS `viewpolicesummary`*/;
/*!50001 DROP VIEW IF EXISTS `viewpolicesummary`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewpolicesummary` AS select `viewcasesreported`.`indicator` AS `indicator`,`viewcasesreported`.`indicator_id` AS `indicator_id`,sum(`viewcasesreported`.`countyTotal`) AS `Aggregates` from `viewcasesreported` group by `viewcasesreported`.`indicator` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewtop5receivedcases`
--

/*!50001 DROP TABLE IF EXISTS `viewtop5receivedcases`*/;
/*!50001 DROP VIEW IF EXISTS `viewtop5receivedcases`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewtop5receivedcases` AS select `viewreceivedcases`.`county_name` AS `county_name`,`viewreceivedcases`.`countyAggregate` AS `Aggregate` from `viewreceivedcases` order by `viewreceivedcases`.`countyAggregate` desc limit 5 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewserviceproviderstrained`
--

/*!50001 DROP TABLE IF EXISTS `viewserviceproviderstrained`*/;
/*!50001 DROP VIEW IF EXISTS `viewserviceproviderstrained`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewserviceproviderstrained` AS select `viewhealthaggregates`.`indicator` AS `indicator`,`viewhealthaggregates`.`indicator_id` AS `indicator_id`,`viewhealthaggregates`.`county` AS `county`,`viewhealthaggregates`.`countyAggregate` AS `countyAggregate`,`viewhealthaggregates`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewhealthaggregates`.`completedPEPTotal` AS `completedPEPTotal`,`viewhealthaggregates`.`receivedcareTotal` AS `receivedcareTotal`,`viewhealthaggregates`.`casesReportedTotal` AS `casesReportedTotal`,`viewhealthaggregates`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewhealthaggregates` where (`viewhealthaggregates`.`indicator_id` = 2) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewconvictedcases`
--

/*!50001 DROP TABLE IF EXISTS `viewconvictedcases`*/;
/*!50001 DROP VIEW IF EXISTS `viewconvictedcases`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewconvictedcases` AS select `viewjudiciaryaggregates`.`indicator` AS `indicator`,`viewjudiciaryaggregates`.`county_name` AS `county_name`,`viewjudiciaryaggregates`.`county_id` AS `county_id`,`viewjudiciaryaggregates`.`survey_id` AS `survey_id`,`viewjudiciaryaggregates`.`countyAggregate` AS `countyAggregate`,`viewjudiciaryaggregates`.`countyPercentage` AS `countyPercentage`,`viewjudiciaryaggregates`.`nationalTriedTotal` AS `nationalAggregate` from `viewjudiciaryaggregates` where (`viewjudiciaryaggregates`.`indicator_id` = 9) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewhealthsummary`
--

/*!50001 DROP TABLE IF EXISTS `viewhealthsummary`*/;
/*!50001 DROP VIEW IF EXISTS `viewhealthsummary`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewhealthsummary` AS select `viewserviceproviderstrained`.`indicator` AS `indicator`,`viewserviceproviderstrained`.`indicator_id` AS `indicator_id`,sum(`viewserviceproviderstrained`.`countyAggregate`) AS `Aggregates` from `viewserviceproviderstrained` group by `viewserviceproviderstrained`.`indicator` union select `viewhealthcasesreported`.`indicator` AS `indicator`,`viewhealthcasesreported`.`indicator_id` AS `indicator_id`,sum(`viewhealthcasesreported`.`countyAggregate`) AS `Aggregates` from `viewhealthcasesreported` group by `viewhealthcasesreported`.`indicator` union select `viewpepinitiated`.`indicator` AS `indicator`,`viewpepinitiated`.`indicator_id` AS `indicator_id`,sum(`viewpepinitiated`.`countycasesReportedPercentage`) AS `Aggregates` from `viewpepinitiated` group by `viewpepinitiated`.`indicator` union select `viewpepcompleted`.`indicator` AS `indicator`,`viewpepcompleted`.`indicator_id` AS `indicator_id`,sum(`viewpepcompleted`.`countycasesReportedPercentage`) AS `Aggregates` from `viewpepcompleted` group by `viewpepcompleted`.`indicator` union select `viewreceivedcomprehensivecare`.`indicator` AS `indicator`,`viewreceivedcomprehensivecare`.`indicator_id` AS `indicator_id`,sum(`viewreceivedcomprehensivecare`.`countycasesReportedPercentage`) AS `Aggregates` from `viewreceivedcomprehensivecare` group by `viewreceivedcomprehensivecare`.`indicator` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewtop5prosecutedcases`
--

/*!50001 DROP TABLE IF EXISTS `viewtop5prosecutedcases`*/;
/*!50001 DROP VIEW IF EXISTS `viewtop5prosecutedcases`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewtop5prosecutedcases` AS select `viewprosecutedcases`.`county_name` AS `county_name`,`viewprosecutedcases`.`countyPercentage` AS `countyPercentage` from `viewprosecutedcases` order by `viewprosecutedcases`.`countyPercentage` desc limit 5 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewpepcompleted`
--

/*!50001 DROP TABLE IF EXISTS `viewpepcompleted`*/;
/*!50001 DROP VIEW IF EXISTS `viewpepcompleted`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewpepcompleted` AS select `viewhealthaggregates`.`indicator` AS `indicator`,`viewhealthaggregates`.`indicator_id` AS `indicator_id`,`viewhealthaggregates`.`county` AS `county`,`viewhealthaggregates`.`countyAggregate` AS `countyAggregate`,`viewhealthaggregates`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewhealthaggregates`.`completedPEPTotal` AS `completedPEPTotal`,`viewhealthaggregates`.`receivedcareTotal` AS `receivedcareTotal`,`viewhealthaggregates`.`casesReportedTotal` AS `casesReportedTotal`,`viewhealthaggregates`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewhealthaggregates` where (`viewhealthaggregates`.`indicator_id` = 5) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewtriedcases`
--

/*!50001 DROP TABLE IF EXISTS `viewtriedcases`*/;
/*!50001 DROP VIEW IF EXISTS `viewtriedcases`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewtriedcases` AS select `viewjudiciaryaggregates`.`indicator` AS `indicator`,`viewjudiciaryaggregates`.`indicator_id` AS `indicator_id`,`viewjudiciaryaggregates`.`county_name` AS `county_name`,`viewjudiciaryaggregates`.`county_id` AS `county_id`,`viewjudiciaryaggregates`.`countyPercentage` AS `countyPercentage`,`viewjudiciaryaggregates`.`survey_id` AS `survey_id`,`viewjudiciaryaggregates`.`countyAggregate` AS `countyAggregate`,`viewjudiciaryaggregates`.`nationalTriedTotal` AS `nationalTriedTotal`,`viewjudiciaryaggregates`.`nationalPercentage` AS `nationalPercentage`,`viewjudiciaryaggregates`.`nationalProsecutionTotal` AS `nationalProsecutionTotal` from `viewjudiciaryaggregates` where ((`viewjudiciaryaggregates`.`indicator_id` = 8) or (`viewjudiciaryaggregates`.`indicator_id` = 9)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewjudiciarysummary`
--

/*!50001 DROP TABLE IF EXISTS `viewjudiciarysummary`*/;
/*!50001 DROP VIEW IF EXISTS `viewjudiciarysummary`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewjudiciarysummary` AS select `viewjudgestrained`.`indicator` AS `indicator`,`viewjudgestrained`.`indicator_id` AS `indicator_id`,sum(`viewjudgestrained`.`countyAggregate`) AS `Aggregates` from `viewjudgestrained` group by `viewjudgestrained`.`indicator` union select `viewtriedcases`.`indicator` AS `indicator`,`viewtriedcases`.`indicator_id` AS `indicator_id`,sum(`viewtriedcases`.`countyPercentage`) AS `Aggregates` from `viewtriedcases` group by `viewtriedcases`.`indicator` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewprosecutionsummary`
--

/*!50001 DROP TABLE IF EXISTS `viewprosecutionsummary`*/;
/*!50001 DROP VIEW IF EXISTS `viewprosecutionsummary`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewprosecutionsummary` AS select `viewprosecutorstrained`.`indicator` AS `indicator`,`viewprosecutorstrained`.`indicator_id` AS `indicator_id`,sum(`viewprosecutorstrained`.`countyAggregate`) AS `Aggregates` from `viewprosecutorstrained` group by `viewprosecutorstrained`.`indicator` union select `viewreceivedcases`.`indicator` AS `indicator`,`viewreceivedcases`.`indicator_id` AS `indicator_id`,sum(`viewreceivedcases`.`countyAggregate`) AS `Aggregates` from `viewreceivedcases` group by `viewreceivedcases`.`indicator` union select `viewprosecutedcases`.`indicator` AS `indicator`,`viewprosecutedcases`.`indicator_id` AS `indicator_id`,sum(`viewprosecutedcases`.`countyPercentage`) AS `Aggregates` from `viewprosecutedcases` group by `viewprosecutedcases`.`indicator` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewtop5casesreported`
--

/*!50001 DROP TABLE IF EXISTS `viewtop5casesreported`*/;
/*!50001 DROP VIEW IF EXISTS `viewtop5casesreported`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewtop5casesreported` AS select `viewcasesreported`.`indicator` AS `indicator`,`viewcasesreported`.`indicator_id` AS `indicator_id`,`viewcasesreported`.`county` AS `county`,`viewcasesreported`.`countyTotal` AS `countyTotal`,`viewcasesreported`.`nationalTotal` AS `nationalTotal`,`viewcasesreported`.`percentage` AS `percentage` from `viewcasesreported` order by `viewcasesreported`.`countyTotal` desc limit 5 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewtop5pepcompleted`
--

/*!50001 DROP TABLE IF EXISTS `viewtop5pepcompleted`*/;
/*!50001 DROP VIEW IF EXISTS `viewtop5pepcompleted`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewtop5pepcompleted` AS select `viewpepcompleted`.`indicator` AS `indicator`,`viewpepcompleted`.`indicator_id` AS `indicator_id`,`viewpepcompleted`.`county` AS `county`,`viewpepcompleted`.`countyAggregate` AS `countyAggregate`,`viewpepcompleted`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewpepcompleted`.`completedPEPTotal` AS `completedPEPTotal`,`viewpepcompleted`.`receivedcareTotal` AS `receivedcareTotal`,`viewpepcompleted`.`casesReportedTotal` AS `casesReportedTotal`,`viewpepcompleted`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewpepcompleted` order by `viewpepcompleted`.`countycasesReportedPercentage` desc limit 5 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewtop5withdrawncases`
--

/*!50001 DROP TABLE IF EXISTS `viewtop5withdrawncases`*/;
/*!50001 DROP VIEW IF EXISTS `viewtop5withdrawncases`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewtop5withdrawncases` AS select `viewwithdrawncases`.`county_name` AS `county_name`,`viewwithdrawncases`.`county_id` AS `county_id`,`viewwithdrawncases`.`survey_id` AS `survey_id`,sum(`viewwithdrawncases`.`countyPercentage`) AS `Withdrawn` from `viewwithdrawncases` group by `viewwithdrawncases`.`survey_id`,`viewwithdrawncases`.`county_id` order by sum(`viewwithdrawncases`.`countyPercentage`) desc limit 5 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewcasesreported`
--

/*!50001 DROP TABLE IF EXISTS `viewcasesreported`*/;
/*!50001 DROP VIEW IF EXISTS `viewcasesreported`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewcasesreported` AS select `viewpoliceaggregates`.`indicator` AS `indicator`,`viewpoliceaggregates`.`indicator_id` AS `indicator_id`,`viewpoliceaggregates`.`county` AS `county`,`viewpoliceaggregates`.`countyTotal` AS `countyTotal`,`viewpoliceaggregates`.`nationalTotal` AS `nationalTotal`,`viewpoliceaggregates`.`percentage` AS `percentage` from `viewpoliceaggregates` where (`viewpoliceaggregates`.`indicator_id` = 13) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewtop5prosecutorstrained`
--

/*!50001 DROP TABLE IF EXISTS `viewtop5prosecutorstrained`*/;
/*!50001 DROP VIEW IF EXISTS `viewtop5prosecutorstrained`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewtop5prosecutorstrained` AS select `viewprosecutorstrained`.`county_name` AS `county_name`,`viewprosecutorstrained`.`county_id` AS `county_id`,`viewprosecutorstrained`.`survey_id` AS `survey_id`,sum(`viewprosecutorstrained`.`countyAggregate`) AS `Trained` from `viewprosecutorstrained` group by `viewprosecutorstrained`.`survey_id`,`viewprosecutorstrained`.`county_id` order by sum(`viewprosecutorstrained`.`countyPercentage`) desc limit 5 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewreceivedcases`
--

/*!50001 DROP TABLE IF EXISTS `viewreceivedcases`*/;
/*!50001 DROP VIEW IF EXISTS `viewreceivedcases`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewreceivedcases` AS select `viewprosecutionaggregates`.`indicator` AS `indicator`,`viewprosecutionaggregates`.`indicator_id` AS `indicator_id`,`viewprosecutionaggregates`.`county_name` AS `county_name`,`viewprosecutionaggregates`.`countyPercentage1` AS `countyPercentage1`,`viewprosecutionaggregates`.`survey_id` AS `survey_id`,`viewprosecutionaggregates`.`countyAggregate` AS `countyAggregate`,`viewprosecutionaggregates`.`countyPercentage` AS `countyPercentage`,`viewprosecutionaggregates`.`nationalProsecutionTotal` AS `nationalProsecutionTotal`,`viewprosecutionaggregates`.`nationalPercentage` AS `nationalPercentage`,`viewprosecutionaggregates`.`nationalPoliceTotal` AS `nationalPoliceTotal` from `viewprosecutionaggregates` where (`viewprosecutionaggregates`.`indicator_id` = 16) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewtop5pepinitiated`
--

/*!50001 DROP TABLE IF EXISTS `viewtop5pepinitiated`*/;
/*!50001 DROP VIEW IF EXISTS `viewtop5pepinitiated`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewtop5pepinitiated` AS select `viewpepinitiated`.`indicator` AS `indicator`,`viewpepinitiated`.`indicator_id` AS `indicator_id`,`viewpepinitiated`.`county` AS `county`,`viewpepinitiated`.`countyAggregate` AS `countyAggregate`,`viewpepinitiated`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewpepinitiated`.`completedPEPTotal` AS `completedPEPTotal`,`viewpepinitiated`.`receivedcareTotal` AS `receivedcareTotal`,`viewpepinitiated`.`casesReportedTotal` AS `casesReportedTotal`,`viewpepinitiated`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewpepinitiated` order by `viewpepinitiated`.`countycasesReportedPercentage` desc limit 5 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewtop5convictedcases`
--

/*!50001 DROP TABLE IF EXISTS `viewtop5convictedcases`*/;
/*!50001 DROP VIEW IF EXISTS `viewtop5convictedcases`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewtop5convictedcases` AS select `viewconvictedcases`.`county_name` AS `county_name`,`viewconvictedcases`.`county_id` AS `county_id`,`viewconvictedcases`.`survey_id` AS `survey_id`,sum(`viewconvictedcases`.`countyPercentage`) AS `Convicted` from `viewconvictedcases` group by `viewconvictedcases`.`survey_id`,`viewconvictedcases`.`county_id` order by sum(`viewconvictedcases`.`countyPercentage`) desc limit 5 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewreceivedcomprehensivecare`
--

/*!50001 DROP TABLE IF EXISTS `viewreceivedcomprehensivecare`*/;
/*!50001 DROP VIEW IF EXISTS `viewreceivedcomprehensivecare`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewreceivedcomprehensivecare` AS select `viewhealthaggregates`.`indicator` AS `indicator`,`viewhealthaggregates`.`indicator_id` AS `indicator_id`,`viewhealthaggregates`.`county` AS `county`,`viewhealthaggregates`.`countyAggregate` AS `countyAggregate`,`viewhealthaggregates`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewhealthaggregates`.`completedPEPTotal` AS `completedPEPTotal`,`viewhealthaggregates`.`receivedcareTotal` AS `receivedcareTotal`,`viewhealthaggregates`.`casesReportedTotal` AS `casesReportedTotal`,`viewhealthaggregates`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewhealthaggregates` where (`viewhealthaggregates`.`indicator_id` = 6) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewjudgestrained`
--

/*!50001 DROP TABLE IF EXISTS `viewjudgestrained`*/;
/*!50001 DROP VIEW IF EXISTS `viewjudgestrained`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewjudgestrained` AS select `viewjudiciaryaggregates`.`indicator` AS `indicator`,`viewjudiciaryaggregates`.`indicator_id` AS `indicator_id`,`viewjudiciaryaggregates`.`survey_id` AS `survey_id`,`viewjudiciaryaggregates`.`county_name` AS `county_name`,`viewjudiciaryaggregates`.`countyAggregate` AS `countyAggregate` from `viewjudiciaryaggregates` where (`viewjudiciaryaggregates`.`indicator_id` = 7) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v1`
--

/*!50001 DROP TABLE IF EXISTS `v1`*/;
/*!50001 DROP VIEW IF EXISTS `v1`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v1` AS select `a`.`indicator_id` AS `indicator_id`,`i`.`indicator` AS `indicator`,`a`.`county_id` AS `county_id`,sum(`a`.`aggregate`) AS `countyAggregate`,`i`.`survey_id` AS `survey_id` from (`indicators` `i` join `judiciary_aggregates` `a` on((`i`.`indicator_id` = `a`.`indicator_id`))) group by `i`.`indicator`,`a`.`county_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v2`
--

/*!50001 DROP TABLE IF EXISTS `v2`*/;
/*!50001 DROP VIEW IF EXISTS `v2`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v2` AS select `a`.`survey_id` AS `survey_id`,`c`.`county_id` AS `county_id`,`c`.`county_name` AS `county_name` from (`judiciary_aggregates` `a` join `counties` `c` on((`c`.`county_id` = `a`.`county_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v3`
--

/*!50001 DROP TABLE IF EXISTS `v3`*/;
/*!50001 DROP VIEW IF EXISTS `v3`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v3` AS select sum(`h`.`aggregate`) AS `nationalTriedTotal`,`h`.`indicator_id` AS `indicator_id`,`h`.`survey_id` AS `survey_id` from (`judiciary_aggregates` `h` join `surveys` `g` on((`h`.`survey_id` = `g`.`survey_id`))) group by `h`.`indicator_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v4`
--

/*!50001 DROP TABLE IF EXISTS `v4`*/;
/*!50001 DROP VIEW IF EXISTS `v4`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v4` AS select sum(`p`.`aggregate`) AS `nationalProsecutionTotal`,`p`.`survey_id` AS `survey_id`,`p`.`indicator_id` AS `indicator_id` from (`prosecution_aggregates` `p` join `surveys` `s` on((`p`.`survey_id` = `s`.`survey_id`))) group by `p`.`indicator_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v5`
--

/*!50001 DROP TABLE IF EXISTS `v5`*/;
/*!50001 DROP VIEW IF EXISTS `v5`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v5` AS select `a`.`indicator_id` AS `indicator_id`,`i`.`indicator` AS `indicator`,`a`.`county_id` AS `county_id`,sum(`a`.`aggregate`) AS `countyAggregate`,`i`.`survey_id` AS `survey_id` from (`indicators` `i` join `prosecution_aggregates` `a` on((`i`.`indicator_id` = `a`.`indicator_id`))) group by `i`.`indicator`,`a`.`county_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v6`
--

/*!50001 DROP TABLE IF EXISTS `v6`*/;
/*!50001 DROP VIEW IF EXISTS `v6`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v6` AS select `a`.`survey_id` AS `survey_id`,`c`.`county_id` AS `county_id`,`c`.`county_name` AS `county_name` from (`prosecution_aggregates` `a` join `counties` `c` on((`c`.`county_id` = `a`.`county_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v7`
--

/*!50001 DROP TABLE IF EXISTS `v7`*/;
/*!50001 DROP VIEW IF EXISTS `v7`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v7` AS select sum(`h`.`aggregate`) AS `nationalProsecutionTotal`,`h`.`indicator_id` AS `indicator_id`,`h`.`survey_id` AS `survey_id` from (`prosecution_aggregates` `h` join `surveys` `g` on((`h`.`survey_id` = `g`.`survey_id`))) group by `h`.`indicator_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v8`
--

/*!50001 DROP TABLE IF EXISTS `v8`*/;
/*!50001 DROP VIEW IF EXISTS `v8`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v8` AS select sum(`p`.`aggregate`) AS `nationalPoliceTotal`,`p`.`survey_id` AS `survey_id`,`p`.`indicator_id` AS `indicator_id` from (`police_aggregates` `p` join `surveys` `s` on((`p`.`survey_id` = `s`.`survey_id`))) group by `p`.`indicator_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewpepinitiated`
--

/*!50001 DROP TABLE IF EXISTS `viewpepinitiated`*/;
/*!50001 DROP VIEW IF EXISTS `viewpepinitiated`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewpepinitiated` AS select `viewhealthaggregates`.`indicator` AS `indicator`,`viewhealthaggregates`.`indicator_id` AS `indicator_id`,`viewhealthaggregates`.`county` AS `county`,`viewhealthaggregates`.`countyAggregate` AS `countyAggregate`,`viewhealthaggregates`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewhealthaggregates`.`completedPEPTotal` AS `completedPEPTotal`,`viewhealthaggregates`.`receivedcareTotal` AS `receivedcareTotal`,`viewhealthaggregates`.`casesReportedTotal` AS `casesReportedTotal`,`viewhealthaggregates`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewhealthaggregates` where (`viewhealthaggregates`.`indicator_id` = 4) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewwithdrawncases`
--

/*!50001 DROP TABLE IF EXISTS `viewwithdrawncases`*/;
/*!50001 DROP VIEW IF EXISTS `viewwithdrawncases`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewwithdrawncases` AS select `viewjudiciaryaggregates`.`indicator` AS `indicator`,`viewjudiciaryaggregates`.`county_name` AS `county_name`,`viewjudiciaryaggregates`.`county_id` AS `county_id`,`viewjudiciaryaggregates`.`countyPercentage` AS `countyPercentage`,`viewjudiciaryaggregates`.`survey_id` AS `survey_id`,`viewjudiciaryaggregates`.`countyAggregate` AS `countyAggregate`,`viewjudiciaryaggregates`.`nationalTriedTotal` AS `nationalTriedTotal`,`viewjudiciaryaggregates`.`nationalPercentage` AS `nationalPercentage`,`viewjudiciaryaggregates`.`nationalProsecutionTotal` AS `nationalProsecutionTotal` from `viewjudiciaryaggregates` where (`viewjudiciaryaggregates`.`indicator_id` = 8) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewtop5judgestrained`
--

/*!50001 DROP TABLE IF EXISTS `viewtop5judgestrained`*/;
/*!50001 DROP VIEW IF EXISTS `viewtop5judgestrained`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewtop5judgestrained` AS select `viewjudgestrained`.`county_name` AS `county_name`,`viewjudgestrained`.`countyAggregate` AS `countyAggregate` from `viewjudgestrained` order by `viewjudgestrained`.`countyAggregate` desc limit 5 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewjudiciaryaggregates`
--

/*!50001 DROP TABLE IF EXISTS `viewjudiciaryaggregates`*/;
/*!50001 DROP VIEW IF EXISTS `viewjudiciaryaggregates`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewjudiciaryaggregates` AS select `x`.`indicator` AS `indicator`,`x`.`indicator_id` AS `indicator_id`,`y`.`county_name` AS `county_name`,`y`.`county_id` AS `county_id`,((`x`.`countyAggregate` / `z`.`nationalProsecutionTotal`) * 100) AS `countyPercentage`,`y`.`survey_id` AS `survey_id`,`x`.`countyAggregate` AS `countyAggregate`,`j`.`nationalTriedTotal` AS `nationalTriedTotal`,((`j`.`nationalTriedTotal` / `z`.`nationalProsecutionTotal`) * 100) AS `nationalPercentage`,`z`.`nationalProsecutionTotal` AS `nationalProsecutionTotal` from (((`v1` `x` join `v2` `y`) join `v3` `j`) join `v4` `z` on(((`x`.`county_id` = `y`.`county_id`) and (`y`.`survey_id` = `j`.`survey_id`) and (`z`.`survey_id` = `j`.`survey_id`) and (`x`.`indicator_id` = `j`.`indicator_id`)))) group by `x`.`indicator`,`x`.`survey_id`,`y`.`county_id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-25 19:08:10
