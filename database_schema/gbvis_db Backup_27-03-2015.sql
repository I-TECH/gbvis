-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 27, 2015 at 09:55 AM
-- Server version: 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `countyHealthAggregates`()
BEGIN
 select x.indicator AS indicator,y.county_name AS county,(SUM(x.aggregate)/z.nationalTotal) * 100 as percentage
 from 
 (select i.indicator,a.aggregate,i.survey_id,a.county_id
 from indicators as i inner join health_aggregates as a On i.indicator_id=a.indicator_id )
 as x inner join ( select a.survey_id,c.county_id,c.county_name from health_aggregates
 as a inner join counties as c on c.county_id=a.county_id)  as y 
 inner join
 ( select sum(aggregate) as nationalTotal,p.survey_id from health_aggregates
 as p inner join survey as s on p.survey_id=s.survey_id
 group by p.survey_id) as z
 
 on x.county_id = y.county_id and y.survey_id=z.survey_id
 group by x.indicator,x.survey_id,y.county_name; 

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countyJudiciaryAggregates`()
BEGIN

select x.indicator AS indicator,y.county_name,(countyAggregate/z.nationalProsecutionTotal) * 100 as countyPercentage, y.survey_id,
countyAggregate,(countyAggregate/z.nationalProsecutionTotal) * 100 as countyPercentage,nationalTriedTotal,(nationalTriedTotal/z.nationalProsecutionTotal) * 100 as nationalPercentage,z.nationalProsecutionTotal
from (select a.indicator_id, i.indicator,a.county_id, sum(a.aggregate) as countyAggregate,i.survey_id from indicators as i
 inner join judiciary_aggregates as a
 On i.indicator_id=a.indicator_id
 group by  i.indicator,a.county_id) as x inner join 
 ( select a.survey_id,c.county_id,c.county_name from judiciary_aggregates as a inner join
 counties as c on c.county_id=a.county_id) as y inner join 
  ( select sum(aggregate) as nationalTriedTotal,h.indicator_id,h.survey_id from judiciary_aggregates as h inner join
 survey as g on h.survey_id=g.survey_id group by h.indicator_id) as j inner join
 ( select sum(aggregate) as nationalProsecutionTotal,p.survey_id,p.indicator_id from prosecution_aggregates as p inner join
 survey as s on p.survey_id=s.survey_id group by p.indicator_id) as z 
 on x.county_id = y.county_id and y.survey_id=j.survey_id and z.survey_id=j.survey_id
 and x.indicator_id=j.indicator_id 
 
 group by x.indicator,x.survey_id,y.county_id; 

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countyPoliceAggregates`()
BEGIN
 select x.indicator AS indicator,y.county_name AS county,(SUM(x.aggregate)/z.nationalTotal) * 100 as percentage
 from 
 (select i.indicator,a.aggregate,i.survey_id,a.county_id
 from indicators as i inner join police_aggregates as a On i.indicator_id=a.indicator_id )
 as x inner join ( select a.survey_id,c.county_id,c.county_name from police_aggregates
 as a inner join counties as c on c.county_id=a.county_id)  as y 
 inner join
 ( select sum(aggregate) as nationalTotal,p.survey_id from police_aggregates
 as p inner join survey as s on p.survey_id=s.survey_id
 group by p.survey_id) as z
 
 on x.county_id = y.county_id and y.survey_id=z.survey_id
 group by x.indicator,x.survey_id,y.county_name; 

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countyPoliceAggregates2`()
BEGIN
select y.county_name AS county,SUM(x.aggregate) as countyTotal,(SUM(x.aggregate)/z.nationalTotal) * 100 as percentage
 from 
 (select i.indicator,a.aggregate,i.survey_id,a.county_id
 from indicators as i inner join police_aggregates as a On i.indicator_id=a.indicator_id )
 as x inner join ( select a.survey_id,c.county_id,c.county_name from police_aggregates
 as a inner join counties as c on c.county_id=a.county_id)  as y 
 inner join
 ( select sum(aggregate) as nationalTotal,p.survey_id from police_aggregates
 as p inner join surveys as s on p.survey_id=s.survey_id
 group by p.survey_id) as z
 
 on x.county_id = y.county_id and y.survey_id=z.survey_id
 group by x.indicator,x.survey_id,y.county_name;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countyProsecutionAggregates`()
BEGIN

select x.indicator AS indicator,y.county_name AS county,(SUM(x.aggregate)/z.nationalTotal) * 100 as 'Proportion (%)'
 from 
 (select i.indicator,a.aggregate,i.survey_id,a.county_id
 from indicators as i inner join prosecution_aggregates as a On i.indicator_id=a.indicator_id )
 as x inner join ( select a.survey_id,c.county_id,c.county_name from prosecution_aggregates
 as a inner join counties as c on c.county_id=a.county_id)  as y 
 inner join
 ( select sum(aggregate) as nationalTotal,p.survey_id from police_aggregates
 as p inner join survey as s on p.survey_id=s.survey_id
 group by p.survey_id) as z
 
 on x.county_id = y.county_id and y.survey_id=z.survey_id
 where x.indicator='number of cases prosecuted'
 group by x.indicator,x.survey_id,y.county_name; 

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countyProsecutionAggregates2`()
BEGIN

select y.survey_id,y.county_name, x.indicator AS indicator
,countyAggregate,nationalProsecutionTotal,z.nationalPoliceTotal 
from (select a.indicator_id, i.indicator,a.county_id, sum(a.aggregate) as countyAggregate,i.survey_id from indicators as i
 inner join prosecution_aggregates as a
 On i.indicator_id=a.indicator_id
 group by  i.indicator,a.county_id) as x inner join 
 ( select a.survey_id,c.county_id,c.county_name from prosecution_aggregates as a inner join
 counties as c on c.county_id=a.county_id) as y inner join 
  ( select sum(aggregate) as nationalProsecutionTotal,h.indicator_id,h.survey_id from prosecution_aggregates as h inner join
 survey as g on h.survey_id=g.survey_id group by h.indicator_id) as j inner join
 ( select sum(aggregate) as nationalPoliceTotal,p.survey_id from police_aggregates as p inner join
 survey as s on p.survey_id=s.survey_id group by p.survey_id) as z 
 on x.county_id = y.county_id and y.survey_id=j.survey_id and z.survey_id=j.survey_id
 and x.indicator_id=j.indicator_id 
 group by x.indicator,x.survey_id,y.county_id;  

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countyProsecutionAggregates3`()
BEGIN

 select y.survey_id,y.county_name, x.indicator AS indicator
,countyAggregate,(countyAggregate/z.nationalPoliceTotal) * 100 as countyPercentage,nationalProsecutionTotal,(nationalProsecutionTotal/z.nationalPoliceTotal) * 100 as nationalPercentage,z.nationalPoliceTotal 
from (select a.indicator_id, i.indicator,a.county_id, sum(a.aggregate) as countyAggregate,i.survey_id from indicators as i
 inner join prosecution_aggregates as a
 On i.indicator_id=a.indicator_id
 group by  i.indicator,a.county_id) as x inner join 
 ( select a.survey_id,c.county_id,c.county_name from prosecution_aggregates as a inner join
 counties as c on c.county_id=a.county_id) as y inner join 
  ( select sum(aggregate) as nationalProsecutionTotal,h.indicator_id,h.survey_id from prosecution_aggregates as h inner join
 survey as g on h.survey_id=g.survey_id group by h.indicator_id) as j inner join
 ( select sum(aggregate) as nationalPoliceTotal,p.survey_id,p.indicator_id from police_aggregates as p inner join
 survey as s on p.survey_id=s.survey_id group by p.indicator_id) as z 
 on x.county_id = y.county_id and y.survey_id=j.survey_id and z.survey_id=j.survey_id
 and x.indicator_id=j.indicator_id 
 where x.indicator='number of sgbv cases prosecuted by law' 
 group by x.indicator,x.survey_id,y.county_id; 

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `countyProsecutionAggregates4`()
BEGIN

select x.indicator AS indicator,y.county_name,(countyAggregate/z.nationalPoliceTotal) * 100 as countyPercentage, y.survey_id,
countyAggregate,(countyAggregate/z.nationalPoliceTotal) * 100 as countyPercentage,nationalProsecutionTotal,(nationalProsecutionTotal/z.nationalPoliceTotal) * 100 as nationalPercentage,z.nationalPoliceTotal 
from (select a.indicator_id, i.indicator,a.county_id, sum(a.aggregate) as countyAggregate,i.survey_id from indicators as i
 inner join prosecution_aggregates as a
 On i.indicator_id=a.indicator_id
 group by  i.indicator,a.county_id) as x inner join 
 ( select a.survey_id,c.county_id,c.county_name from prosecution_aggregates as a inner join
 counties as c on c.county_id=a.county_id) as y inner join 
  ( select sum(aggregate) as nationalProsecutionTotal,h.indicator_id,h.survey_id from prosecution_aggregates as h inner join
 survey as g on h.survey_id=g.survey_id group by h.indicator_id) as j inner join
 ( select sum(aggregate) as nationalPoliceTotal,p.survey_id,p.indicator_id from police_aggregates as p inner join
 survey as s on p.survey_id=s.survey_id group by p.indicator_id) as z 
 on x.county_id = y.county_id and y.survey_id=j.survey_id and z.survey_id=j.survey_id
 and x.indicator_id=j.indicator_id 
 where x.indicator='number of sgbv cases prosecuted by law' 
 group by x.indicator,x.survey_id,y.county_id; 

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCountyJudiciaryAggregates`()
BEGIN

select x.indicator AS indicator,y.county_name AS county,SUM(x.aggregate) as percentage  from
(select i.indicator,a.aggregate,i.survey_id,a.county_id from indicators as i inner join judiciary_aggregates as a
On i.indicator_id=a.indicator_id ) as x
inner join ( select c.county_id,c.county_name from judiciary_aggregates as a
inner join counties as c on c.county_id=a.county_id ) as y on x.county_id = y.county_id
group by  x.indicator,x.survey_id,y.county_name;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getDataFormatAsExcel`()
BEGIN

select a.county_id,c.county_name,a.aggregate,i.indicator_id,i.indicator,i.survey_id,su.survey,i.sector_id,s.sector from indicators i join sector s using (sector_id) join police_aggregates a using (survey_id,indicator_id) join counties c using(county_id) join survey su using (survey_id);


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getNationalJudiciaryAggregates`()
BEGIN

  select x.indicator AS indicator,SUM(x.aggregate) as percentage  from
(select i.indicator,a.aggregate,i.survey_id,a.county_id from indicators as i inner join judiciary_aggregates as a
On i.indicator_id=a.indicator_id ) as x
inner join ( select c.county_id,c.county_name from judiciary_aggregates as a
inner join counties as c on c.county_id=a.county_id ) as y on x.county_id = y.county_id
group by  x.indicator,x.survey_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUsers`()
BEGIN

SELECT id,fullname,firstname,lastname
FROM gbvis1.users;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_user`(
IN userId INT,
OUT firstName VARCHAR(100),
OUT lastName VARCHAR(100)
)
BEGIN
SELECT first_name, last_name
INTO firstName, lastName
FROM users
WHERE users_id = userId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_users`()
BEGIN
SELECT *
FROM users;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `nationalPoliceAggregates`()
BEGIN

 select  distinct x.indicator AS indicator,z.nationalTotal
 from 
 (select i.indicator,a.aggregate,i.survey_id,a.county_id
 from indicators as i inner join police_aggregates as a On i.indicator_id=a.indicator_id )
 as x inner join ( select a.survey_id,c.county_id,c.county_name from police_aggregates
 as a inner join counties as c on c.county_id=a.county_id)  as y 
 inner join
 ( select sum(aggregate) as nationalTotal,p.survey_id from police_aggregates
 as p inner join survey as s on p.survey_id=s.survey_id
 group by p.survey_id) as z
 
 on x.county_id = y.county_id and y.survey_id=z.survey_id
 group by x.indicator,x.survey_id,y.county_name; 

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prochealthaggregates`()
BEGIN
select x.indicator AS indicator,y.county_name AS county,x.aggregate as countyAggregate,j.initiatedPEPTotal,k.completedPEPTotal,receivedcareTotal,z.casesReportedTotal,(x.aggregate/z.casesReportedTotal) * 100 as countycasesReportedPercentage
 from 
 v12
 as x inner join v13  as y 
 inner join
 v14 as z
 inner join
 v15 as j
 inner join
 v16 as k
  inner join
 v17 as l
 
 on x.county_id = y.county_id and y.survey_id=z.survey_id and j.survey_id=z.survey_id  and j.survey_id=k.survey_id and l.survey_id=k.survey_id 

 group by x.indicator,x.survey_id,y.county_name; 

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `procJudiciarySummary`()
BEGIN
select result1.title,result2.Aggregates from 
  (select @i:=@i+1 AS rowId,title from indicators_titles,(SELECT @i:=0) a) as result1 , 
  (select @j:=@j+1 AS rowId,Aggregates from viewjudiciarysummary,(SELECT @j:=0) a ) as result2 
where 
  result1.rowId = result2.rowId;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `procSideBySide`()
BEGIN
select * from 
  (select @i:=@i+1 AS rowId,county_name,Convicted from viewtop5convictedcases,(SELECT @i:=0) a) as result1 , 
  (select @j:=@j+1 AS rowId,Withdrawn from viewtop5withdrawncases,(SELECT @j:=0) a ) as result2,
   (select @j:=@j+1 AS rowId,countyAggregate from viewtop5withdrawncases,(SELECT @j:=0) a ) as result3 
where 
  result1.rowId = result2.rowId AND result2.rowId = result3.rowId;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proctop5judgestrained`()
BEGIN

SELECT * FROM test.viewtop5judgestrained;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_aggregates`()
BEGIN
select a.county_id,i.indicator,a.aggregate,i.indicator_id,i.survey_id from indicator i join aggregate a using (survey_id,sector_id,indicator_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_aggregates3`()
BEGIN

select a.county_id,c.county_name,i.indicator,a.aggregate,i.indicator_id,i.survey_id
from indicator i 
join 
health_aggregates a using (survey_id,indicator_id)
join counties c using (county_id);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `proc_aggregates_database_format`()
BEGIN


select a.county_id,c.county_name,a.aggregate,i.indicator_id,i.indicator,i.survey_id,su.survey,i.sector_id,s.sector from indicator i join aggregate a using (survey_id,sector_id,indicator_id) join counties c using(county_id) join sector s using(sector_id) join survey su using (survey_id);

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `community_aggregates`
--

CREATE TABLE IF NOT EXISTS `community_aggregates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `county_id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `indicator_id` int(10) NOT NULL,
  `aggregate` int(100) NOT NULL,
  PRIMARY KEY (`county_id`,`survey_id`,`indicator_id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `counties`
--

CREATE TABLE IF NOT EXISTS `counties` (
  `county_id` int(2) NOT NULL DEFAULT '0',
  `county_name` varchar(15) NOT NULL,
  PRIMARY KEY (`county_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `counties`
--

INSERT INTO `counties` (`county_id`, `county_name`) VALUES
(1, 'MARSABIT'),
(2, 'ISIOLO'),
(3, 'MERU'),
(4, 'THARAKA'),
(5, 'EMBU'),
(6, 'KITUI'),
(7, 'MACHAKOS'),
(8, 'MAKUENI'),
(9, 'NYANDARUA'),
(10, 'NYERI'),
(11, 'KIRINYAGA'),
(12, 'MURANGA'),
(13, 'KIAMBU'),
(14, 'BUNGOMA'),
(15, 'KAKAMEGA'),
(16, 'BUSIA'),
(17, 'VIHIGA'),
(18, 'NAIROBI'),
(19, 'BARINGO '),
(20, 'BOMET'),
(21, 'UASINGISHU '),
(22, 'KAJIADO'),
(23, 'ELGEYOMARAKWET '),
(24, 'KERICHO'),
(25, 'TRANSNZOIA'),
(26, 'LAIKIPIA '),
(27, 'NAKURU '),
(28, 'NANDI '),
(29, 'NAROK '),
(30, 'SAMBURU '),
(31, 'TURKANA '),
(32, 'WESTPOKOT '),
(33, 'MOMBASA'),
(34, 'KILIFI'),
(35, 'KWALE'),
(36, 'LAMU'),
(37, 'TAITATAVETA'),
(38, 'TANARIVER'),
(39, 'KISUMU'),
(40, 'SIAYA'),
(41, 'HOMABAY'),
(42, 'MIGORI'),
(43, 'KISII'),
(44, 'NYAMIRA'),
(45, 'GARISSA'),
(46, 'WAJIR'),
(47, 'MANDERA');

-- --------------------------------------------------------

--
-- Table structure for table `education_aggregates`
--

CREATE TABLE IF NOT EXISTS `education_aggregates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `county_id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `indicator_id` int(10) NOT NULL,
  `aggregate` int(100) NOT NULL,
  PRIMARY KEY (`county_id`,`survey_id`,`indicator_id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `education_aggregates`
--

INSERT INTO `education_aggregates` (`id`, `county_id`, `survey_id`, `indicator_id`, `aggregate`) VALUES
(1, 1, 1, 18, 12),
(2, 2, 1, 18, 8),
(3, 3, 1, 18, 40),
(4, 4, 1, 18, 25),
(5, 5, 1, 18, 49),
(6, 6, 1, 18, 55),
(7, 7, 1, 18, 26),
(8, 8, 1, 18, 40),
(9, 9, 1, 18, 179),
(10, 10, 1, 18, 92),
(11, 11, 1, 18, 102),
(12, 12, 1, 18, 179),
(13, 13, 1, 18, 211),
(14, 14, 1, 18, 210),
(15, 15, 1, 18, 185),
(16, 16, 1, 18, 123),
(17, 17, 1, 18, 63),
(18, 18, 1, 18, 296),
(19, 19, 1, 18, 68),
(20, 20, 1, 18, 95),
(21, 21, 1, 18, 187),
(22, 22, 1, 18, 92),
(23, 23, 1, 18, 93),
(24, 24, 1, 18, 128),
(25, 25, 1, 18, 217),
(26, 26, 1, 18, 61),
(27, 27, 1, 18, 378),
(28, 28, 1, 18, 88),
(29, 29, 1, 18, 173),
(30, 30, 1, 18, 27),
(31, 31, 1, 18, 56),
(32, 32, 1, 18, 55),
(33, 33, 1, 18, 188),
(34, 34, 1, 18, 270),
(35, 35, 1, 18, 177),
(36, 36, 1, 18, 25),
(37, 37, 1, 18, 126),
(38, 38, 1, 18, 66),
(39, 39, 1, 18, 195),
(40, 40, 1, 18, 178),
(41, 41, 1, 18, 105),
(42, 42, 1, 18, 72),
(43, 43, 1, 18, 177),
(44, 44, 1, 18, 72),
(45, 45, 1, 18, 64),
(46, 46, 1, 18, 27),
(47, 47, 1, 18, 12);

-- --------------------------------------------------------

--
-- Table structure for table `file_uploads`
--

CREATE TABLE IF NOT EXISTS `file_uploads` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `file_uploads`
--

INSERT INTO `file_uploads` (`id`, `name`, `type`, `size`, `path`, `status`, `description`, `uploadedby`, `sector`, `useremail`, `rejection_reason`, `date`) VALUES
(1, 'judiciary_aggregates_database_format_demo.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '10907', '../../Uploaded_files/judiciary_aggregates_database_format_demo.xlsx', 'Approved', 'Judiciary Aggregates January 2015', 'judiciary', 'Judiciary', 'benardkkoech@gmail.c', '', '2015-03-17 16:42:55'),
(3, 'health_aggregates_database_format _demo.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '18249', '../../Uploaded_files/.health_aggregates_database_format _demo.xlsx', 'Rejected', 'Health Aggregates', 'health', 'Health', 'martinge@gmail.com', 'file not found in the system', '2015-03-17 15:41:51'),
(5, 'police_aggregates_database_format_demo.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '18449', '../../Uploaded_files/police_aggregates_database_format_demo.xlsx', 'Approved', 'Police aggregates', 'police', 'Police', 'police@gmail.com', '', '2015-03-17 16:41:47'),
(7, 'prosecution_aggregates_database_format_demo.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '14565', '../../Uploaded_files/.prosecution_aggregates_database_format_demo.xlsx', 'Rejected', 'prosecution', 'prosecution', 'Prosecution', 'info@ardech.co.ke', 'File not correct', '2015-03-17 16:31:02');

-- --------------------------------------------------------

--
-- Table structure for table `health_aggregates`
--

CREATE TABLE IF NOT EXISTS `health_aggregates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `county_id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `indicator_id` int(10) NOT NULL,
  `aggregate` int(100) NOT NULL,
  PRIMARY KEY (`county_id`,`survey_id`,`indicator_id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=236 ;

--
-- Dumping data for table `health_aggregates`
--

INSERT INTO `health_aggregates` (`id`, `county_id`, `survey_id`, `indicator_id`, `aggregate`) VALUES
(1, 1, 1, 2, 12),
(48, 1, 1, 3, 12),
(95, 1, 1, 4, 12),
(142, 1, 1, 5, 12),
(189, 1, 1, 6, 12),
(2, 2, 1, 2, 8),
(49, 2, 1, 3, 8),
(96, 2, 1, 4, 8),
(143, 2, 1, 5, 8),
(190, 2, 1, 6, 8),
(3, 3, 1, 2, 40),
(50, 3, 1, 3, 40),
(97, 3, 1, 4, 40),
(144, 3, 1, 5, 40),
(191, 3, 1, 6, 40),
(4, 4, 1, 2, 25),
(51, 4, 1, 3, 25),
(98, 4, 1, 4, 25),
(145, 4, 1, 5, 25),
(192, 4, 1, 6, 25),
(5, 5, 1, 2, 49),
(52, 5, 1, 3, 49),
(99, 5, 1, 4, 49),
(146, 5, 1, 5, 49),
(193, 5, 1, 6, 49),
(6, 6, 1, 2, 55),
(53, 6, 1, 3, 55),
(100, 6, 1, 4, 55),
(147, 6, 1, 5, 55),
(194, 6, 1, 6, 55),
(7, 7, 1, 2, 26),
(54, 7, 1, 3, 26),
(101, 7, 1, 4, 26),
(148, 7, 1, 5, 26),
(195, 7, 1, 6, 26),
(8, 8, 1, 2, 40),
(55, 8, 1, 3, 40),
(102, 8, 1, 4, 40),
(149, 8, 1, 5, 40),
(196, 8, 1, 6, 40),
(9, 9, 1, 2, 29),
(56, 9, 1, 3, 39),
(103, 9, 1, 4, 29),
(150, 9, 1, 5, 39),
(197, 9, 1, 6, 29),
(10, 10, 1, 2, 92),
(57, 10, 1, 3, 92),
(104, 10, 1, 4, 92),
(151, 10, 1, 5, 92),
(198, 10, 1, 6, 92),
(11, 11, 1, 2, 102),
(58, 11, 1, 3, 102),
(105, 11, 1, 4, 102),
(152, 11, 1, 5, 102),
(199, 11, 1, 6, 102),
(12, 12, 1, 2, 159),
(59, 12, 1, 3, 159),
(106, 12, 1, 4, 159),
(153, 12, 1, 5, 159),
(200, 12, 1, 6, 159),
(13, 13, 1, 2, 211),
(60, 13, 1, 3, 211),
(107, 13, 1, 4, 211),
(154, 13, 1, 5, 211),
(201, 13, 1, 6, 211),
(14, 14, 1, 2, 210),
(61, 14, 1, 3, 210),
(108, 14, 1, 4, 210),
(155, 14, 1, 5, 210),
(202, 14, 1, 6, 210),
(15, 15, 1, 2, 185),
(62, 15, 1, 3, 185),
(109, 15, 1, 4, 185),
(156, 15, 1, 5, 185),
(203, 15, 1, 6, 185),
(16, 16, 1, 2, 123),
(63, 16, 1, 3, 123),
(110, 16, 1, 4, 123),
(157, 16, 1, 5, 123),
(204, 16, 1, 6, 123),
(17, 17, 1, 2, 63),
(64, 17, 1, 3, 63),
(111, 17, 1, 4, 63),
(158, 17, 1, 5, 63),
(205, 17, 1, 6, 63),
(18, 18, 1, 2, 296),
(65, 18, 1, 3, 296),
(112, 18, 1, 4, 296),
(159, 18, 1, 5, 296),
(206, 18, 1, 6, 296),
(19, 19, 1, 2, 68),
(66, 19, 1, 3, 68),
(113, 19, 1, 4, 68),
(160, 19, 1, 5, 68),
(207, 19, 1, 6, 68),
(20, 20, 1, 2, 95),
(67, 20, 1, 3, 95),
(114, 20, 1, 4, 95),
(161, 20, 1, 5, 95),
(208, 20, 1, 6, 95),
(21, 21, 1, 2, 187),
(68, 21, 1, 3, 187),
(115, 21, 1, 4, 187),
(162, 21, 1, 5, 187),
(209, 21, 1, 6, 187),
(22, 22, 1, 2, 92),
(69, 22, 1, 3, 92),
(116, 22, 1, 4, 92),
(163, 22, 1, 5, 92),
(210, 22, 1, 6, 92),
(23, 23, 1, 2, 93),
(70, 23, 1, 3, 93),
(117, 23, 1, 4, 93),
(164, 23, 1, 5, 93),
(211, 23, 1, 6, 93),
(24, 24, 1, 2, 128),
(71, 24, 1, 3, 128),
(118, 24, 1, 4, 128),
(165, 24, 1, 5, 128),
(212, 24, 1, 6, 128),
(25, 25, 1, 2, 22),
(72, 25, 1, 3, 23),
(119, 25, 1, 4, 22),
(166, 25, 1, 5, 23),
(213, 25, 1, 6, 22),
(26, 26, 1, 2, 61),
(73, 26, 1, 3, 61),
(120, 26, 1, 4, 61),
(167, 26, 1, 5, 61),
(214, 26, 1, 6, 61),
(27, 27, 1, 2, 378),
(74, 27, 1, 3, 378),
(121, 27, 1, 4, 378),
(168, 27, 1, 5, 378),
(215, 27, 1, 6, 378),
(28, 28, 1, 2, 88),
(75, 28, 1, 3, 88),
(122, 28, 1, 4, 88),
(169, 28, 1, 5, 88),
(216, 28, 1, 6, 88),
(29, 29, 1, 2, 153),
(76, 29, 1, 3, 153),
(123, 29, 1, 4, 153),
(170, 29, 1, 5, 153),
(217, 29, 1, 6, 153),
(30, 30, 1, 2, 27),
(77, 30, 1, 3, 27),
(124, 30, 1, 4, 27),
(171, 30, 1, 5, 27),
(218, 30, 1, 6, 27),
(31, 31, 1, 2, 56),
(78, 31, 1, 3, 56),
(125, 31, 1, 4, 56),
(172, 31, 1, 5, 56),
(219, 31, 1, 6, 56),
(32, 32, 1, 2, 55),
(79, 32, 1, 3, 55),
(126, 32, 1, 4, 55),
(173, 32, 1, 5, 55),
(220, 32, 1, 6, 55),
(33, 33, 1, 2, 188),
(80, 33, 1, 3, 188),
(127, 33, 1, 4, 188),
(174, 33, 1, 5, 188),
(221, 33, 1, 6, 188),
(34, 34, 1, 2, 270),
(81, 34, 1, 3, 270),
(128, 34, 1, 4, 270),
(175, 34, 1, 5, 270),
(222, 34, 1, 6, 270),
(35, 35, 1, 2, 27),
(82, 35, 1, 3, 37),
(129, 35, 1, 4, 27),
(176, 35, 1, 5, 37),
(223, 35, 1, 6, 27),
(36, 36, 1, 2, 25),
(83, 36, 1, 3, 25),
(130, 36, 1, 4, 25),
(177, 36, 1, 5, 25),
(224, 36, 1, 6, 25),
(37, 37, 1, 2, 126),
(84, 37, 1, 3, 126),
(131, 37, 1, 4, 126),
(178, 37, 1, 5, 126),
(225, 37, 1, 6, 126),
(38, 38, 1, 2, 66),
(85, 38, 1, 3, 66),
(132, 38, 1, 4, 66),
(179, 38, 1, 5, 66),
(226, 38, 1, 6, 66),
(39, 39, 1, 2, 195),
(86, 39, 1, 3, 195),
(133, 39, 1, 4, 195),
(180, 39, 1, 5, 195),
(227, 39, 1, 6, 195),
(40, 40, 1, 2, 28),
(87, 40, 1, 3, 38),
(134, 40, 1, 4, 28),
(181, 40, 1, 5, 38),
(228, 40, 1, 6, 28),
(41, 41, 1, 2, 105),
(88, 41, 1, 3, 105),
(135, 41, 1, 4, 105),
(182, 41, 1, 5, 105),
(229, 41, 1, 6, 105),
(42, 42, 1, 2, 72),
(89, 42, 1, 3, 72),
(136, 42, 1, 4, 72),
(183, 42, 1, 5, 72),
(230, 42, 1, 6, 72),
(43, 43, 1, 2, 157),
(90, 43, 1, 3, 157),
(137, 43, 1, 4, 157),
(184, 43, 1, 5, 157),
(231, 43, 1, 6, 157),
(44, 44, 1, 2, 72),
(91, 44, 1, 3, 72),
(138, 44, 1, 4, 72),
(185, 44, 1, 5, 72),
(232, 44, 1, 6, 72),
(45, 45, 1, 2, 64),
(92, 45, 1, 3, 64),
(139, 45, 1, 4, 64),
(186, 45, 1, 5, 64),
(233, 45, 1, 6, 64),
(46, 46, 1, 2, 27),
(93, 46, 1, 3, 27),
(140, 46, 1, 4, 27),
(187, 46, 1, 5, 27),
(234, 46, 1, 6, 27),
(47, 47, 1, 2, 12),
(94, 47, 1, 3, 12),
(141, 47, 1, 4, 12),
(188, 47, 1, 5, 12),
(235, 47, 1, 6, 12);

-- --------------------------------------------------------

--
-- Table structure for table `indicators`
--

CREATE TABLE IF NOT EXISTS `indicators` (
  `survey_id` int(11) NOT NULL DEFAULT '0',
  `sector_id` int(11) NOT NULL DEFAULT '0',
  `indicator_id` int(11) NOT NULL DEFAULT '0',
  `indicator` varchar(255) DEFAULT NULL,
  `date_recorded` date NOT NULL,
  `date_modified` date NOT NULL,
  PRIMARY KEY (`survey_id`,`sector_id`,`indicator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `indicators`
--

INSERT INTO `indicators` (`survey_id`, `sector_id`, `indicator_id`, `indicator`, `date_recorded`, `date_modified`) VALUES
(1, 1, 7, 'number of judges trained on sgbv', '0000-00-00', '0000-00-00'),
(1, 1, 8, 'number of withdrawn sgbv cases', '0000-00-00', '0000-00-00'),
(1, 1, 9, 'number of convicted sgbv cases', '0000-00-00', '0000-00-00'),
(1, 1, 10, 'average time to conclude cases', '0000-00-00', '0000-00-00'),
(1, 2, 1, 'number of health facilities providing services for survivors', '0000-00-00', '0000-00-00'),
(1, 2, 2, 'number of service  providers trained', '0000-00-00', '0000-00-00'),
(1, 2, 3, 'number of sgbv cases reported to health facilities', '0000-00-00', '0000-00-00'),
(1, 2, 4, 'number of survivors initiated on pep', '0000-00-00', '0000-00-00'),
(1, 2, 5, 'number of  survivors completed pep', '0000-00-00', '0000-00-00'),
(1, 2, 6, 'number of  survivors received comprehensive care', '0000-00-00', '0000-00-00'),
(1, 3, 11, 'number of police stations with functional gender desk', '0000-00-00', '0000-00-00'),
(1, 3, 12, 'number of police trained on sgbv', '0000-00-00', '0000-00-00'),
(1, 3, 13, 'number of sgbv cases reported to police', '0000-00-00', '0000-00-00'),
(1, 4, 15, 'number of prosecutors trained on sgbv', '0000-00-00', '0000-00-00'),
(1, 4, 16, 'number of sgbv cases received for prosecution', '0000-00-00', '0000-00-00'),
(1, 4, 17, 'number of sgbv cases prosecuted by law', '0000-00-00', '0000-00-00'),
(1, 7, 18, 'number of teachers who have been trained in sgbv', '0000-00-00', '0000-00-00'),
(1, 7, 19, 'number of schools implementing life skills curriculum', '0000-00-00', '0000-00-00'),
(1, 7, 20, 'number of children possessing life skills', '0000-00-00', '0000-00-00'),
(2, 7, 21, 'number of children who have indicated sgbv', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `indicators_titles`
--

CREATE TABLE IF NOT EXISTS `indicators_titles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `titleid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `indicators_titles`
--

INSERT INTO `indicators_titles` (`id`, `title`, `titleid`) VALUES
(1, 'number of judges trained in SGBV', 7),
(2, 'proportion of convicted prosecuted  cases ', 9),
(3, 'proportion of withdrawn prosecuted cases', 8),
(4, 'average time to conclude cases', 0),
(5, 'proportion of prosecuted sgbv cases', 17),
(6, 'number of prosecutors  trained using sgbv manual', 15),
(7, 'number of sgbv cases received', 16),
(8, 'number of sgbv cases reported to national police ', 13),
(9, 'number of service providers trained ', 2),
(10, 'number of cases reported to health facilities', 3),
(11, 'proportion of survivors initiated on PEP', 4),
(12, 'proportion of survivors who have completed PEP', 5),
(13, 'proportion of survivors who have received comprehe', 6);

-- --------------------------------------------------------

--
-- Table structure for table `judiciary_aggregates`
--

CREATE TABLE IF NOT EXISTS `judiciary_aggregates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `county_id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `indicator_id` int(10) NOT NULL,
  `aggregate` int(100) NOT NULL,
  PRIMARY KEY (`county_id`,`survey_id`,`indicator_id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=142 ;

--
-- Dumping data for table `judiciary_aggregates`
--

INSERT INTO `judiciary_aggregates` (`id`, `county_id`, `survey_id`, `indicator_id`, `aggregate`) VALUES
(95, 1, 1, 7, 12),
(1, 1, 1, 8, 50),
(48, 1, 1, 9, 5),
(96, 2, 1, 7, 8),
(2, 2, 1, 8, 89),
(49, 2, 1, 9, 7),
(97, 3, 1, 7, 40),
(3, 3, 1, 8, 98),
(50, 3, 1, 9, 100),
(98, 4, 1, 7, 25),
(4, 4, 1, 8, 107),
(51, 4, 1, 9, 9),
(99, 5, 1, 7, 49),
(5, 5, 1, 8, 10),
(52, 5, 1, 9, 10),
(100, 6, 1, 7, 55),
(6, 6, 1, 8, 15),
(53, 6, 1, 9, 15),
(101, 7, 1, 7, 26),
(7, 7, 1, 8, 5),
(54, 7, 1, 9, 5),
(102, 8, 1, 7, 40),
(8, 8, 1, 8, 7),
(55, 8, 1, 9, 7),
(103, 9, 1, 7, 79),
(9, 9, 1, 8, 8),
(56, 9, 1, 9, 9),
(104, 10, 1, 7, 92),
(10, 10, 1, 8, 9),
(57, 10, 1, 9, 9),
(105, 11, 1, 7, 102),
(11, 11, 1, 8, 10),
(58, 11, 1, 9, 10),
(106, 12, 1, 7, 159),
(12, 12, 1, 8, 15),
(59, 12, 1, 9, 15),
(107, 13, 1, 7, 211),
(13, 13, 1, 8, 90),
(60, 13, 1, 9, 5),
(108, 14, 1, 7, 210),
(14, 14, 1, 8, 90),
(61, 14, 1, 9, 7),
(109, 15, 1, 7, 185),
(15, 15, 1, 8, 8),
(62, 15, 1, 9, 9),
(110, 16, 1, 7, 123),
(16, 16, 1, 8, 9),
(63, 16, 1, 9, 9),
(111, 17, 1, 7, 63),
(17, 17, 1, 8, 10),
(64, 17, 1, 9, 10),
(112, 18, 1, 7, 296),
(18, 18, 1, 8, 15),
(65, 18, 1, 9, 15),
(113, 19, 1, 7, 68),
(19, 19, 1, 8, 109),
(66, 19, 1, 9, 5),
(114, 20, 1, 7, 95),
(20, 20, 1, 8, 98),
(67, 20, 1, 9, 7),
(115, 21, 1, 7, 187),
(21, 21, 1, 8, 8),
(68, 21, 1, 9, 9),
(116, 22, 1, 7, 92),
(22, 22, 1, 8, 9),
(69, 22, 1, 9, 9),
(117, 23, 1, 7, 93),
(23, 23, 1, 8, 10),
(70, 23, 1, 9, 10),
(118, 24, 1, 7, 128),
(24, 24, 1, 8, 108),
(71, 24, 1, 9, 15),
(119, 25, 1, 7, 27),
(25, 25, 1, 8, 5),
(72, 25, 1, 9, 5),
(120, 26, 1, 7, 61),
(26, 26, 1, 8, 7),
(73, 26, 1, 9, 7),
(121, 27, 1, 7, 378),
(27, 27, 1, 8, 200),
(74, 27, 1, 9, 9),
(122, 28, 1, 7, 88),
(28, 28, 1, 8, 9),
(75, 28, 1, 9, 9),
(123, 29, 1, 7, 153),
(29, 29, 1, 8, 10),
(76, 29, 1, 9, 10),
(124, 30, 1, 7, 27),
(30, 30, 1, 8, 60),
(77, 30, 1, 9, 15),
(125, 31, 1, 7, 56),
(31, 31, 1, 8, 5),
(78, 31, 1, 9, 5),
(126, 32, 1, 7, 55),
(32, 32, 1, 8, 80),
(79, 32, 1, 9, 7),
(127, 33, 1, 7, 188),
(33, 33, 1, 8, 8),
(80, 33, 1, 9, 9),
(128, 34, 1, 7, 270),
(34, 34, 1, 8, 9),
(81, 34, 1, 9, 9),
(129, 35, 1, 7, 77),
(35, 35, 1, 8, 100),
(82, 35, 1, 9, 10),
(130, 36, 1, 7, 25),
(36, 36, 1, 8, 15),
(83, 36, 1, 9, 100),
(131, 37, 1, 7, 126),
(37, 37, 1, 8, 5),
(84, 37, 1, 9, 5),
(132, 38, 1, 7, 66),
(38, 38, 1, 8, 7),
(85, 38, 1, 9, 7),
(133, 39, 1, 7, 195),
(39, 39, 1, 8, 8),
(86, 39, 1, 9, 9),
(134, 40, 1, 7, 78),
(40, 40, 1, 8, 9),
(87, 40, 1, 9, 9),
(135, 41, 1, 7, 105),
(41, 41, 1, 8, 10),
(88, 41, 1, 9, 100),
(136, 42, 1, 7, 72),
(42, 42, 1, 8, 15),
(89, 42, 1, 9, 15),
(137, 43, 1, 7, 157),
(43, 43, 1, 8, 5),
(90, 43, 1, 9, 5),
(138, 44, 1, 7, 72),
(44, 44, 1, 8, 7),
(91, 44, 1, 9, 7),
(139, 45, 1, 7, 64),
(45, 45, 1, 8, 8),
(92, 45, 1, 9, 9),
(140, 46, 1, 7, 27),
(46, 46, 1, 8, 9),
(93, 46, 1, 9, 9),
(141, 47, 1, 7, 12),
(47, 47, 1, 8, 10),
(94, 47, 1, 9, 10);

-- --------------------------------------------------------

--
-- Table structure for table `police_aggregates`
--

CREATE TABLE IF NOT EXISTS `police_aggregates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `county_id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `indicator_id` int(10) NOT NULL,
  `aggregate` int(100) NOT NULL,
  PRIMARY KEY (`county_id`,`survey_id`,`indicator_id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `police_aggregates`
--

INSERT INTO `police_aggregates` (`id`, `county_id`, `survey_id`, `indicator_id`, `aggregate`) VALUES
(1, 1, 1, 13, 12),
(2, 2, 1, 13, 8),
(3, 3, 1, 13, 40),
(4, 4, 1, 13, 25),
(5, 5, 1, 13, 49),
(6, 6, 1, 13, 55),
(7, 7, 1, 13, 26),
(8, 8, 1, 13, 40),
(9, 9, 1, 13, 179),
(10, 10, 1, 13, 92),
(11, 11, 1, 13, 102),
(12, 12, 1, 13, 179),
(13, 13, 1, 13, 211),
(14, 14, 1, 13, 210),
(15, 15, 1, 13, 185),
(16, 16, 1, 13, 123),
(17, 17, 1, 13, 63),
(18, 18, 1, 13, 296),
(19, 19, 1, 13, 68),
(20, 20, 1, 13, 95),
(21, 21, 1, 13, 187),
(22, 22, 1, 13, 92),
(23, 23, 1, 13, 93),
(24, 24, 1, 13, 128),
(25, 25, 1, 13, 217),
(26, 26, 1, 13, 61),
(27, 27, 1, 13, 378),
(28, 28, 1, 13, 88),
(29, 29, 1, 13, 173),
(30, 30, 1, 13, 27),
(31, 31, 1, 13, 56),
(32, 32, 1, 13, 55),
(33, 33, 1, 13, 188),
(34, 34, 1, 13, 270),
(35, 35, 1, 13, 177),
(36, 36, 1, 13, 25),
(37, 37, 1, 13, 126),
(38, 38, 1, 13, 66),
(39, 39, 1, 13, 195),
(40, 40, 1, 13, 178),
(41, 41, 1, 13, 105),
(42, 42, 1, 13, 72),
(43, 43, 1, 13, 177),
(44, 44, 1, 13, 72),
(45, 45, 1, 13, 64),
(46, 46, 1, 13, 27),
(47, 47, 1, 13, 12);

-- --------------------------------------------------------

--
-- Table structure for table `prosecution_aggregates`
--

CREATE TABLE IF NOT EXISTS `prosecution_aggregates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `county_id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `indicator_id` int(10) NOT NULL,
  `aggregate` int(100) NOT NULL,
  PRIMARY KEY (`county_id`,`survey_id`,`indicator_id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=142 ;

--
-- Dumping data for table `prosecution_aggregates`
--

INSERT INTO `prosecution_aggregates` (`id`, `county_id`, `survey_id`, `indicator_id`, `aggregate`) VALUES
(48, 1, 1, 15, 6),
(95, 1, 1, 16, 4),
(1, 1, 1, 17, 4),
(49, 2, 1, 15, 4),
(96, 2, 1, 16, 8),
(2, 2, 1, 17, 8),
(50, 3, 1, 15, 20),
(97, 3, 1, 16, 40),
(3, 3, 1, 17, 40),
(51, 4, 1, 15, 10),
(98, 4, 1, 16, 25),
(4, 4, 1, 17, 25),
(52, 5, 1, 15, 26),
(99, 5, 1, 16, 49),
(5, 5, 1, 17, 49),
(53, 6, 1, 15, 55),
(100, 6, 1, 16, 55),
(6, 6, 1, 17, 55),
(54, 7, 1, 15, 26),
(101, 7, 1, 16, 26),
(7, 7, 1, 17, 26),
(55, 8, 1, 15, 40),
(102, 8, 1, 16, 40),
(8, 8, 1, 17, 40),
(56, 9, 1, 15, 50),
(103, 9, 1, 16, 50),
(9, 9, 1, 17, 50),
(57, 10, 1, 15, 92),
(104, 10, 1, 16, 92),
(10, 10, 1, 17, 92),
(58, 11, 1, 15, 102),
(105, 11, 1, 16, 60),
(11, 11, 1, 17, 60),
(59, 12, 1, 15, 159),
(106, 12, 1, 16, 40),
(12, 12, 1, 17, 40),
(60, 13, 1, 15, 211),
(107, 13, 1, 16, 211),
(13, 13, 1, 17, 211),
(61, 14, 1, 15, 210),
(108, 14, 1, 16, 105),
(14, 14, 1, 17, 105),
(62, 15, 1, 15, 185),
(109, 15, 1, 16, 185),
(15, 15, 1, 17, 185),
(63, 16, 1, 15, 123),
(110, 16, 1, 16, 123),
(16, 16, 1, 17, 123),
(64, 17, 1, 15, 63),
(111, 17, 1, 16, 63),
(17, 17, 1, 17, 63),
(65, 18, 1, 15, 50),
(112, 18, 1, 16, 296),
(18, 18, 1, 17, 296),
(66, 19, 1, 15, 68),
(113, 19, 1, 16, 68),
(19, 19, 1, 17, 68),
(67, 20, 1, 15, 95),
(114, 20, 1, 16, 95),
(20, 20, 1, 17, 95),
(68, 21, 1, 15, 187),
(115, 21, 1, 16, 187),
(21, 21, 1, 17, 187),
(69, 22, 1, 15, 92),
(116, 22, 1, 16, 92),
(22, 22, 1, 17, 92),
(70, 23, 1, 15, 93),
(117, 23, 1, 16, 93),
(23, 23, 1, 17, 93),
(71, 24, 1, 15, 128),
(118, 24, 1, 16, 128),
(24, 24, 1, 17, 128),
(72, 25, 1, 15, 215),
(119, 25, 1, 16, 216),
(25, 25, 1, 17, 217),
(73, 26, 1, 15, 61),
(120, 26, 1, 16, 61),
(26, 26, 1, 17, 61),
(74, 27, 1, 15, 378),
(121, 27, 1, 16, 378),
(27, 27, 1, 17, 378),
(75, 28, 1, 15, 88),
(122, 28, 1, 16, 88),
(28, 28, 1, 17, 88),
(76, 29, 1, 15, 153),
(123, 29, 1, 16, 163),
(29, 29, 1, 17, 173),
(77, 30, 1, 15, 27),
(124, 30, 1, 16, 27),
(30, 30, 1, 17, 27),
(78, 31, 1, 15, 56),
(125, 31, 1, 16, 56),
(31, 31, 1, 17, 56),
(79, 32, 1, 15, 55),
(126, 32, 1, 16, 55),
(32, 32, 1, 17, 55),
(80, 33, 1, 15, 188),
(127, 33, 1, 16, 10),
(33, 33, 1, 17, 10),
(81, 34, 1, 15, 270),
(128, 34, 1, 16, 270),
(34, 34, 1, 17, 270),
(82, 35, 1, 15, 157),
(129, 35, 1, 16, 167),
(35, 35, 1, 17, 177),
(83, 36, 1, 15, 25),
(130, 36, 1, 16, 25),
(36, 36, 1, 17, 25),
(84, 37, 1, 15, 126),
(131, 37, 1, 16, 126),
(37, 37, 1, 17, 126),
(85, 38, 1, 15, 66),
(132, 38, 1, 16, 66),
(38, 38, 1, 17, 66),
(86, 39, 1, 15, 195),
(133, 39, 1, 16, 195),
(39, 39, 1, 17, 195),
(87, 40, 1, 15, 158),
(134, 40, 1, 16, 168),
(40, 40, 1, 17, 178),
(88, 41, 1, 15, 105),
(135, 41, 1, 16, 50),
(41, 41, 1, 17, 50),
(89, 42, 1, 15, 72),
(136, 42, 1, 16, 72),
(42, 42, 1, 17, 72),
(90, 43, 1, 15, 157),
(137, 43, 1, 16, 167),
(43, 43, 1, 17, 177),
(91, 44, 1, 15, 72),
(138, 44, 1, 16, 12),
(44, 44, 1, 17, 12),
(92, 45, 1, 15, 64),
(139, 45, 1, 16, 64),
(45, 45, 1, 17, 64),
(93, 46, 1, 15, 27),
(140, 46, 1, 16, 27),
(46, 46, 1, 17, 27),
(94, 47, 1, 15, 12),
(141, 47, 1, 16, 12),
(47, 47, 1, 17, 12);

-- --------------------------------------------------------

--
-- Table structure for table `prosecution_aggregates2`
--

CREATE TABLE IF NOT EXISTS `prosecution_aggregates2` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `county_id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `indicator_id` int(10) NOT NULL,
  `aggregate` int(100) NOT NULL,
  PRIMARY KEY (`county_id`,`survey_id`,`indicator_id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `prosecution_aggregates2`
--

INSERT INTO `prosecution_aggregates2` (`id`, `county_id`, `survey_id`, `indicator_id`, `aggregate`) VALUES
(1, 1, 1, 15, 6),
(2, 2, 1, 15, 4),
(3, 3, 1, 15, 20),
(4, 4, 1, 15, 10),
(5, 5, 1, 15, 26),
(6, 6, 1, 15, 55),
(7, 7, 1, 15, 26),
(8, 8, 1, 15, 40),
(9, 9, 1, 15, 50),
(10, 10, 1, 15, 92),
(11, 11, 1, 15, 102),
(12, 12, 1, 15, 159),
(13, 13, 1, 15, 211),
(14, 14, 1, 15, 210),
(15, 15, 1, 15, 185),
(16, 16, 1, 15, 123),
(17, 17, 1, 15, 63),
(18, 18, 1, 15, 50),
(19, 19, 1, 15, 68),
(20, 20, 1, 15, 95),
(21, 21, 1, 15, 187),
(22, 22, 1, 15, 92),
(23, 23, 1, 15, 93),
(24, 24, 1, 15, 128),
(25, 25, 1, 15, 215),
(26, 26, 1, 15, 61),
(27, 27, 1, 15, 378),
(28, 28, 1, 15, 88),
(29, 29, 1, 15, 153),
(30, 30, 1, 15, 27),
(31, 31, 1, 15, 56),
(32, 32, 1, 15, 55),
(33, 33, 1, 15, 188),
(34, 34, 1, 15, 270),
(35, 35, 1, 15, 157),
(36, 36, 1, 15, 25),
(37, 37, 1, 15, 126),
(38, 38, 1, 15, 66),
(39, 39, 1, 15, 195),
(40, 40, 1, 15, 158),
(41, 41, 1, 15, 105),
(42, 42, 1, 15, 72),
(43, 43, 1, 15, 157),
(44, 44, 1, 15, 72),
(45, 45, 1, 15, 64),
(46, 46, 1, 15, 27),
(47, 47, 1, 15, 12);

-- --------------------------------------------------------

--
-- Table structure for table `sectors`
--

CREATE TABLE IF NOT EXISTS `sectors` (
  `sector_id` int(10) NOT NULL AUTO_INCREMENT,
  `sector` varchar(100) NOT NULL,
  PRIMARY KEY (`sector_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `sectors`
--

INSERT INTO `sectors` (`sector_id`, `sector`) VALUES
(0, 'NGEC'),
(1, 'Judiciary'),
(2, 'Health '),
(3, 'Police'),
(4, 'Prosecutions'),
(5, 'education'),
(6, 'social services'),
(7, 'community');

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE IF NOT EXISTS `surveys` (
  `survey_id` int(10) NOT NULL AUTO_INCREMENT,
  `survey` varchar(100) NOT NULL,
  PRIMARY KEY (`survey_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`survey_id`, `survey`) VALUES
(1, 'Jan to March'),
(2, 'July to Aug');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `mobile_phone`, `sector`, `username`, `password`, `email`, `user_group`, `join_date`) VALUES
(3, 'Guest', 'user', '', '0', 'guest', '62ef34f4e7b271b4ccdb5cbeb1546fd5', 'mainasteve@gmail.com', 3, '2015-02-03 08:31:59'),
(12, 'Judiciary', 'Admin', '', '1', 'admin', '62ef34f4e7b271b4ccdb5cbeb1546fd5', 'info@ardech.co.ke', 2, '2015-02-20 14:27:41'),
(11, 'super', 'Admin', '', '0', 'superadmin', '62ef34f4e7b271b4ccdb5cbeb1546fd5', 'benardkkoech@gmail.com', 1, '2015-02-19 11:54:31'),
(14, 'test ', 'user', '', '1', 'judiciary', '62ef34f4e7b271b4ccdb5cbeb1546fd5', 'benardkkoech@gmail.com', 2, '2015-01-29 14:29:29'),
(15, 'test ', 'user', '', '4', 'prosecution', '62ef34f4e7b271b4ccdb5cbeb1546fd5', 'info@ardech.co.ke', 2, '2015-02-20 14:27:41'),
(20, 'Admin', 'Admin', '0723676845', '1', 'police', 'abc.123', 'police@gmail.com', 2, '2015-03-13 11:15:27'),
(19, 'Caroline', 'Ngetich', '0723676845', '2', 'health', 'abc.123', 'martinge@gmail.com', 2, '2015-03-12 14:34:23');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(20) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `description`, `created`) VALUES
(1, 'Super Admin', 'General access', '2015-03-25 00:00:00'),
(2, 'Admin', 'Only reports aceess of sector 2', '2015-03-26 00:00:00'),
(3, 'Guest', 'Normal user', '2015-01-23 00:00:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v1`
--
CREATE TABLE IF NOT EXISTS `v1` (
`indicator_id` int(10)
,`indicator` varchar(255)
,`county_id` int(10)
,`countyAggregate` decimal(65,0)
,`survey_id` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v2`
--
CREATE TABLE IF NOT EXISTS `v2` (
`survey_id` int(10)
,`county_id` int(2)
,`county_name` varchar(15)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v3`
--
CREATE TABLE IF NOT EXISTS `v3` (
`nationalTriedTotal` decimal(65,0)
,`indicator_id` int(10)
,`survey_id` int(10)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v4`
--
CREATE TABLE IF NOT EXISTS `v4` (
`nationalProsecutionTotal` decimal(65,0)
,`survey_id` int(10)
,`indicator_id` int(10)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v5`
--
CREATE TABLE IF NOT EXISTS `v5` (
`indicator_id` int(10)
,`indicator` varchar(255)
,`county_id` int(10)
,`countyAggregate` decimal(65,0)
,`survey_id` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v6`
--
CREATE TABLE IF NOT EXISTS `v6` (
`survey_id` int(10)
,`county_id` int(2)
,`county_name` varchar(15)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v7`
--
CREATE TABLE IF NOT EXISTS `v7` (
`nationalProsecutionTotal` decimal(65,0)
,`indicator_id` int(10)
,`survey_id` int(10)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v8`
--
CREATE TABLE IF NOT EXISTS `v8` (
`nationalPoliceTotal` decimal(65,0)
,`survey_id` int(10)
,`indicator_id` int(10)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v9`
--
CREATE TABLE IF NOT EXISTS `v9` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`aggregate` int(100)
,`survey_id` int(11)
,`county_id` int(10)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v10`
--
CREATE TABLE IF NOT EXISTS `v10` (
`survey_id` int(10)
,`county_id` int(2)
,`county_name` varchar(15)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v11`
--
CREATE TABLE IF NOT EXISTS `v11` (
`nationalTotal` decimal(65,0)
,`survey_id` int(10)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v12`
--
CREATE TABLE IF NOT EXISTS `v12` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`aggregate` int(100)
,`survey_id` int(11)
,`county_id` int(10)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v13`
--
CREATE TABLE IF NOT EXISTS `v13` (
`survey_id` int(10)
,`county_id` int(2)
,`county_name` varchar(15)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v14`
--
CREATE TABLE IF NOT EXISTS `v14` (
`casesReportedTotal` decimal(65,0)
,`survey_id` int(10)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v15`
--
CREATE TABLE IF NOT EXISTS `v15` (
`initiatedPEPTotal` decimal(65,0)
,`survey_id` int(10)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v16`
--
CREATE TABLE IF NOT EXISTS `v16` (
`completedPEPTotal` decimal(65,0)
,`survey_id` int(10)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v17`
--
CREATE TABLE IF NOT EXISTS `v17` (
`receivedcareTotal` decimal(65,0)
,`survey_id` int(10)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewcasesreported`
--
CREATE TABLE IF NOT EXISTS `viewcasesreported` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`county` varchar(15)
,`countyTotal` decimal(65,0)
,`nationalTotal` decimal(65,0)
,`percentage` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewconvictedcases`
--
CREATE TABLE IF NOT EXISTS `viewconvictedcases` (
`indicator` varchar(255)
,`county_name` varchar(15)
,`county_id` int(2)
,`survey_id` int(10)
,`countyAggregate` decimal(65,0)
,`countyPercentage` decimal(65,4)
,`nationalAggregate` decimal(65,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewhealthaggregates`
--
CREATE TABLE IF NOT EXISTS `viewhealthaggregates` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`county` varchar(15)
,`countyAggregate` int(100)
,`initiatedPEPTotal` decimal(65,0)
,`completedPEPTotal` decimal(65,0)
,`receivedcareTotal` decimal(65,0)
,`casesReportedTotal` decimal(65,0)
,`countycasesReportedPercentage` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewhealthcasesreported`
--
CREATE TABLE IF NOT EXISTS `viewhealthcasesreported` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`county` varchar(15)
,`countyAggregate` int(100)
,`initiatedPEPTotal` decimal(65,0)
,`completedPEPTotal` decimal(65,0)
,`receivedcareTotal` decimal(65,0)
,`casesReportedTotal` decimal(65,0)
,`countycasesReportedPercentage` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewhealthsummary`
--
CREATE TABLE IF NOT EXISTS `viewhealthsummary` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`Aggregates` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewjudgestrained`
--
CREATE TABLE IF NOT EXISTS `viewjudgestrained` (
`indicator` varchar(255)
,`indicator_id` int(10)
,`survey_id` int(10)
,`county_name` varchar(15)
,`countyAggregate` decimal(65,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewjudiciaryaggregates`
--
CREATE TABLE IF NOT EXISTS `viewjudiciaryaggregates` (
`indicator` varchar(255)
,`indicator_id` int(10)
,`county_name` varchar(15)
,`county_id` int(2)
,`countyPercentage` decimal(65,4)
,`survey_id` int(10)
,`countyAggregate` decimal(65,0)
,`nationalTriedTotal` decimal(65,0)
,`nationalPercentage` decimal(65,4)
,`nationalProsecutionTotal` decimal(65,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewjudiciarysummary`
--
CREATE TABLE IF NOT EXISTS `viewjudiciarysummary` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`Aggregates` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewpepcompleted`
--
CREATE TABLE IF NOT EXISTS `viewpepcompleted` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`county` varchar(15)
,`countyAggregate` int(100)
,`initiatedPEPTotal` decimal(65,0)
,`completedPEPTotal` decimal(65,0)
,`receivedcareTotal` decimal(65,0)
,`casesReportedTotal` decimal(65,0)
,`countycasesReportedPercentage` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewpepinitiated`
--
CREATE TABLE IF NOT EXISTS `viewpepinitiated` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`county` varchar(15)
,`countyAggregate` int(100)
,`initiatedPEPTotal` decimal(65,0)
,`completedPEPTotal` decimal(65,0)
,`receivedcareTotal` decimal(65,0)
,`casesReportedTotal` decimal(65,0)
,`countycasesReportedPercentage` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewpoliceaggregates`
--
CREATE TABLE IF NOT EXISTS `viewpoliceaggregates` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`county` varchar(15)
,`countyTotal` decimal(65,0)
,`nationalTotal` decimal(65,0)
,`percentage` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewpolicesummary`
--
CREATE TABLE IF NOT EXISTS `viewpolicesummary` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`Aggregates` decimal(65,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewprosecutedcases`
--
CREATE TABLE IF NOT EXISTS `viewprosecutedcases` (
`indicator` varchar(255)
,`indicator_id` int(10)
,`county_name` varchar(15)
,`countyPercentage1` decimal(65,4)
,`survey_id` int(10)
,`countyAggregate` decimal(65,0)
,`countyPercentage` decimal(65,4)
,`nationalProsecutionTotal` decimal(65,0)
,`nationalPercentage` decimal(65,4)
,`nationalPoliceTotal` decimal(65,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewprosecutionaggregates`
--
CREATE TABLE IF NOT EXISTS `viewprosecutionaggregates` (
`indicator` varchar(255)
,`indicator_id` int(10)
,`county_name` varchar(15)
,`county_id` int(2)
,`countyPercentage1` decimal(65,4)
,`survey_id` int(10)
,`countyAggregate` decimal(65,0)
,`countyPercentage` decimal(65,4)
,`nationalProsecutionTotal` decimal(65,0)
,`nationalPercentage` decimal(65,4)
,`nationalPoliceTotal` decimal(65,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewprosecutionsummary`
--
CREATE TABLE IF NOT EXISTS `viewprosecutionsummary` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`Aggregates` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewprosecutorstrained`
--
CREATE TABLE IF NOT EXISTS `viewprosecutorstrained` (
`indicator` varchar(255)
,`indicator_id` int(10)
,`county_name` varchar(15)
,`county_id` int(2)
,`countyPercentage1` decimal(65,4)
,`survey_id` int(10)
,`countyAggregate` decimal(65,0)
,`countyPercentage` decimal(65,4)
,`nationalProsecutionTotal` decimal(65,0)
,`nationalPercentage` decimal(65,4)
,`nationalPoliceTotal` decimal(65,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewreceivedcases`
--
CREATE TABLE IF NOT EXISTS `viewreceivedcases` (
`indicator` varchar(255)
,`indicator_id` int(10)
,`county_name` varchar(15)
,`countyPercentage1` decimal(65,4)
,`survey_id` int(10)
,`countyAggregate` decimal(65,0)
,`countyPercentage` decimal(65,4)
,`nationalProsecutionTotal` decimal(65,0)
,`nationalPercentage` decimal(65,4)
,`nationalPoliceTotal` decimal(65,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewreceivedcomprehensivecare`
--
CREATE TABLE IF NOT EXISTS `viewreceivedcomprehensivecare` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`county` varchar(15)
,`countyAggregate` int(100)
,`initiatedPEPTotal` decimal(65,0)
,`completedPEPTotal` decimal(65,0)
,`receivedcareTotal` decimal(65,0)
,`casesReportedTotal` decimal(65,0)
,`countycasesReportedPercentage` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewserviceproviderstrained`
--
CREATE TABLE IF NOT EXISTS `viewserviceproviderstrained` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`county` varchar(15)
,`countyAggregate` int(100)
,`initiatedPEPTotal` decimal(65,0)
,`completedPEPTotal` decimal(65,0)
,`receivedcareTotal` decimal(65,0)
,`casesReportedTotal` decimal(65,0)
,`countycasesReportedPercentage` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewsummarytriedcases`
--
CREATE TABLE IF NOT EXISTS `viewsummarytriedcases` (
`indicator` varchar(255)
,`nationalTriedTotal` decimal(65,0)
,`nationalProsecutionTotal` decimal(65,0)
,`IndicatorPercentage` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewtop5casesreported`
--
CREATE TABLE IF NOT EXISTS `viewtop5casesreported` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`county` varchar(15)
,`countyTotal` decimal(65,0)
,`nationalTotal` decimal(65,0)
,`percentage` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewtop5convictedcases`
--
CREATE TABLE IF NOT EXISTS `viewtop5convictedcases` (
`county_name` varchar(15)
,`county_id` int(2)
,`survey_id` int(10)
,`Convicted` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewtop5healthcasesreported`
--
CREATE TABLE IF NOT EXISTS `viewtop5healthcasesreported` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`county` varchar(15)
,`countyAggregate` int(100)
,`initiatedPEPTotal` decimal(65,0)
,`completedPEPTotal` decimal(65,0)
,`receivedcareTotal` decimal(65,0)
,`casesReportedTotal` decimal(65,0)
,`countycasesReportedPercentage` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewtop5judgestrained`
--
CREATE TABLE IF NOT EXISTS `viewtop5judgestrained` (
`county_name` varchar(15)
,`countyAggregate` decimal(65,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewtop5pepcompleted`
--
CREATE TABLE IF NOT EXISTS `viewtop5pepcompleted` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`county` varchar(15)
,`countyAggregate` int(100)
,`initiatedPEPTotal` decimal(65,0)
,`completedPEPTotal` decimal(65,0)
,`receivedcareTotal` decimal(65,0)
,`casesReportedTotal` decimal(65,0)
,`countycasesReportedPercentage` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewtop5pepinitiated`
--
CREATE TABLE IF NOT EXISTS `viewtop5pepinitiated` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`county` varchar(15)
,`countyAggregate` int(100)
,`initiatedPEPTotal` decimal(65,0)
,`completedPEPTotal` decimal(65,0)
,`receivedcareTotal` decimal(65,0)
,`casesReportedTotal` decimal(65,0)
,`countycasesReportedPercentage` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewtop5prosecutedcases`
--
CREATE TABLE IF NOT EXISTS `viewtop5prosecutedcases` (
`county_name` varchar(15)
,`countyPercentage` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewtop5prosecutorstrained`
--
CREATE TABLE IF NOT EXISTS `viewtop5prosecutorstrained` (
`county_name` varchar(15)
,`county_id` int(2)
,`survey_id` int(10)
,`Trained` decimal(65,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewtop5receivedcases`
--
CREATE TABLE IF NOT EXISTS `viewtop5receivedcases` (
`county_name` varchar(15)
,`Aggregate` decimal(65,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewtop5receivedcomprehensivecare`
--
CREATE TABLE IF NOT EXISTS `viewtop5receivedcomprehensivecare` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`county` varchar(15)
,`countyAggregate` int(100)
,`initiatedPEPTotal` decimal(65,0)
,`completedPEPTotal` decimal(65,0)
,`receivedcareTotal` decimal(65,0)
,`casesReportedTotal` decimal(65,0)
,`countycasesReportedPercentage` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewtop5serviceproviderstrained`
--
CREATE TABLE IF NOT EXISTS `viewtop5serviceproviderstrained` (
`indicator` varchar(255)
,`indicator_id` int(11)
,`county` varchar(15)
,`countyAggregate` int(100)
,`initiatedPEPTotal` decimal(65,0)
,`completedPEPTotal` decimal(65,0)
,`receivedcareTotal` decimal(65,0)
,`casesReportedTotal` decimal(65,0)
,`countycasesReportedPercentage` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewtop5withdrawncases`
--
CREATE TABLE IF NOT EXISTS `viewtop5withdrawncases` (
`county_name` varchar(15)
,`county_id` int(2)
,`survey_id` int(10)
,`Withdrawn` decimal(65,4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewtriedcases`
--
CREATE TABLE IF NOT EXISTS `viewtriedcases` (
`indicator` varchar(255)
,`indicator_id` int(10)
,`county_name` varchar(15)
,`county_id` int(2)
,`countyPercentage` decimal(65,4)
,`survey_id` int(10)
,`countyAggregate` decimal(65,0)
,`nationalTriedTotal` decimal(65,0)
,`nationalPercentage` decimal(65,4)
,`nationalProsecutionTotal` decimal(65,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewunresolvedcases`
--
CREATE TABLE IF NOT EXISTS `viewunresolvedcases` (
`survey_id` int(10)
,`nationalTriedTotal` decimal(65,0)
,`nationalProsecutionTotal` decimal(65,0)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viewwithdrawncases`
--
CREATE TABLE IF NOT EXISTS `viewwithdrawncases` (
`indicator` varchar(255)
,`county_name` varchar(15)
,`county_id` int(2)
,`countyPercentage` decimal(65,4)
,`survey_id` int(10)
,`countyAggregate` decimal(65,0)
,`nationalTriedTotal` decimal(65,0)
,`nationalPercentage` decimal(65,4)
,`nationalProsecutionTotal` decimal(65,0)
);
-- --------------------------------------------------------

--
-- Structure for view `v1`
--
DROP TABLE IF EXISTS `v1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v1` AS select `a`.`indicator_id` AS `indicator_id`,`i`.`indicator` AS `indicator`,`a`.`county_id` AS `county_id`,sum(`a`.`aggregate`) AS `countyAggregate`,`i`.`survey_id` AS `survey_id` from (`indicators` `i` join `judiciary_aggregates` `a` on((`i`.`indicator_id` = `a`.`indicator_id`))) group by `i`.`indicator`,`a`.`county_id`;

-- --------------------------------------------------------

--
-- Structure for view `v2`
--
DROP TABLE IF EXISTS `v2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v2` AS select `a`.`survey_id` AS `survey_id`,`c`.`county_id` AS `county_id`,`c`.`county_name` AS `county_name` from (`judiciary_aggregates` `a` join `counties` `c` on((`c`.`county_id` = `a`.`county_id`)));

-- --------------------------------------------------------

--
-- Structure for view `v3`
--
DROP TABLE IF EXISTS `v3`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v3` AS select sum(`h`.`aggregate`) AS `nationalTriedTotal`,`h`.`indicator_id` AS `indicator_id`,`h`.`survey_id` AS `survey_id` from (`judiciary_aggregates` `h` join `surveys` `g` on((`h`.`survey_id` = `g`.`survey_id`))) group by `h`.`indicator_id`;

-- --------------------------------------------------------

--
-- Structure for view `v4`
--
DROP TABLE IF EXISTS `v4`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v4` AS select sum(`p`.`aggregate`) AS `nationalProsecutionTotal`,`p`.`survey_id` AS `survey_id`,`p`.`indicator_id` AS `indicator_id` from (`prosecution_aggregates` `p` join `surveys` `s` on((`p`.`survey_id` = `s`.`survey_id`))) group by `p`.`indicator_id`;

-- --------------------------------------------------------

--
-- Structure for view `v5`
--
DROP TABLE IF EXISTS `v5`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v5` AS select `a`.`indicator_id` AS `indicator_id`,`i`.`indicator` AS `indicator`,`a`.`county_id` AS `county_id`,sum(`a`.`aggregate`) AS `countyAggregate`,`i`.`survey_id` AS `survey_id` from (`indicators` `i` join `prosecution_aggregates` `a` on((`i`.`indicator_id` = `a`.`indicator_id`))) group by `i`.`indicator`,`a`.`county_id`;

-- --------------------------------------------------------

--
-- Structure for view `v6`
--
DROP TABLE IF EXISTS `v6`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v6` AS select `a`.`survey_id` AS `survey_id`,`c`.`county_id` AS `county_id`,`c`.`county_name` AS `county_name` from (`prosecution_aggregates` `a` join `counties` `c` on((`c`.`county_id` = `a`.`county_id`)));

-- --------------------------------------------------------

--
-- Structure for view `v7`
--
DROP TABLE IF EXISTS `v7`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v7` AS select sum(`h`.`aggregate`) AS `nationalProsecutionTotal`,`h`.`indicator_id` AS `indicator_id`,`h`.`survey_id` AS `survey_id` from (`prosecution_aggregates` `h` join `surveys` `g` on((`h`.`survey_id` = `g`.`survey_id`))) group by `h`.`indicator_id`;

-- --------------------------------------------------------

--
-- Structure for view `v8`
--
DROP TABLE IF EXISTS `v8`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v8` AS select sum(`p`.`aggregate`) AS `nationalPoliceTotal`,`p`.`survey_id` AS `survey_id`,`p`.`indicator_id` AS `indicator_id` from (`police_aggregates` `p` join `surveys` `s` on((`p`.`survey_id` = `s`.`survey_id`))) group by `p`.`indicator_id`;

-- --------------------------------------------------------

--
-- Structure for view `v9`
--
DROP TABLE IF EXISTS `v9`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v9` AS select `i`.`indicator` AS `indicator`,`i`.`indicator_id` AS `indicator_id`,`a`.`aggregate` AS `aggregate`,`i`.`survey_id` AS `survey_id`,`a`.`county_id` AS `county_id` from (`indicators` `i` join `police_aggregates` `a` on((`i`.`indicator_id` = `a`.`indicator_id`)));

-- --------------------------------------------------------

--
-- Structure for view `v10`
--
DROP TABLE IF EXISTS `v10`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v10` AS select `a`.`survey_id` AS `survey_id`,`c`.`county_id` AS `county_id`,`c`.`county_name` AS `county_name` from (`police_aggregates` `a` join `counties` `c` on((`c`.`county_id` = `a`.`county_id`)));

-- --------------------------------------------------------

--
-- Structure for view `v11`
--
DROP TABLE IF EXISTS `v11`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v11` AS select sum(`p`.`aggregate`) AS `nationalTotal`,`p`.`survey_id` AS `survey_id` from (`police_aggregates` `p` join `surveys` `s` on((`p`.`survey_id` = `s`.`survey_id`))) group by `p`.`survey_id`;

-- --------------------------------------------------------

--
-- Structure for view `v12`
--
DROP TABLE IF EXISTS `v12`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v12` AS select `i`.`indicator` AS `indicator`,`i`.`indicator_id` AS `indicator_id`,`a`.`aggregate` AS `aggregate`,`i`.`survey_id` AS `survey_id`,`a`.`county_id` AS `county_id` from (`indicators` `i` join `health_aggregates` `a` on((`i`.`indicator_id` = `a`.`indicator_id`)));

-- --------------------------------------------------------

--
-- Structure for view `v13`
--
DROP TABLE IF EXISTS `v13`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v13` AS select `a`.`survey_id` AS `survey_id`,`c`.`county_id` AS `county_id`,`c`.`county_name` AS `county_name` from (`health_aggregates` `a` join `counties` `c` on((`c`.`county_id` = `a`.`county_id`)));

-- --------------------------------------------------------

--
-- Structure for view `v14`
--
DROP TABLE IF EXISTS `v14`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v14` AS select sum(`p`.`aggregate`) AS `casesReportedTotal`,`p`.`survey_id` AS `survey_id` from (`health_aggregates` `p` join `surveys` `s` on((`p`.`survey_id` = `s`.`survey_id`))) where (`p`.`indicator_id` = 3) group by `p`.`survey_id`;

-- --------------------------------------------------------

--
-- Structure for view `v15`
--
DROP TABLE IF EXISTS `v15`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v15` AS select sum(`p`.`aggregate`) AS `initiatedPEPTotal`,`p`.`survey_id` AS `survey_id` from (`health_aggregates` `p` join `surveys` `s` on((`p`.`survey_id` = `s`.`survey_id`))) where (`p`.`indicator_id` = 4) group by `p`.`survey_id`;

-- --------------------------------------------------------

--
-- Structure for view `v16`
--
DROP TABLE IF EXISTS `v16`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v16` AS select sum(`p`.`aggregate`) AS `completedPEPTotal`,`p`.`survey_id` AS `survey_id` from (`health_aggregates` `p` join `surveys` `s` on((`p`.`survey_id` = `s`.`survey_id`))) where (`p`.`indicator_id` = 5) group by `p`.`survey_id`;

-- --------------------------------------------------------

--
-- Structure for view `v17`
--
DROP TABLE IF EXISTS `v17`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v17` AS select sum(`p`.`aggregate`) AS `receivedcareTotal`,`p`.`survey_id` AS `survey_id` from (`health_aggregates` `p` join `surveys` `s` on((`p`.`survey_id` = `s`.`survey_id`))) where (`p`.`indicator_id` = 6) group by `p`.`survey_id`;

-- --------------------------------------------------------

--
-- Structure for view `viewcasesreported`
--
DROP TABLE IF EXISTS `viewcasesreported`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewcasesreported` AS select `viewpoliceaggregates`.`indicator` AS `indicator`,`viewpoliceaggregates`.`indicator_id` AS `indicator_id`,`viewpoliceaggregates`.`county` AS `county`,`viewpoliceaggregates`.`countyTotal` AS `countyTotal`,`viewpoliceaggregates`.`nationalTotal` AS `nationalTotal`,`viewpoliceaggregates`.`percentage` AS `percentage` from `viewpoliceaggregates` where (`viewpoliceaggregates`.`indicator_id` = 13);

-- --------------------------------------------------------

--
-- Structure for view `viewconvictedcases`
--
DROP TABLE IF EXISTS `viewconvictedcases`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewconvictedcases` AS select `viewjudiciaryaggregates`.`indicator` AS `indicator`,`viewjudiciaryaggregates`.`county_name` AS `county_name`,`viewjudiciaryaggregates`.`county_id` AS `county_id`,`viewjudiciaryaggregates`.`survey_id` AS `survey_id`,`viewjudiciaryaggregates`.`countyAggregate` AS `countyAggregate`,`viewjudiciaryaggregates`.`countyPercentage` AS `countyPercentage`,`viewjudiciaryaggregates`.`nationalTriedTotal` AS `nationalAggregate` from `viewjudiciaryaggregates` where (`viewjudiciaryaggregates`.`indicator_id` = 9);

-- --------------------------------------------------------

--
-- Structure for view `viewhealthaggregates`
--
DROP TABLE IF EXISTS `viewhealthaggregates`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewhealthaggregates` AS select `x`.`indicator` AS `indicator`,`x`.`indicator_id` AS `indicator_id`,`y`.`county_name` AS `county`,`x`.`aggregate` AS `countyAggregate`,`j`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`k`.`completedPEPTotal` AS `completedPEPTotal`,`l`.`receivedcareTotal` AS `receivedcareTotal`,`z`.`casesReportedTotal` AS `casesReportedTotal`,((`x`.`aggregate` / `z`.`casesReportedTotal`) * 100) AS `countycasesReportedPercentage` from (((((`v12` `x` join `v13` `y`) join `v14` `z`) join `v15` `j`) join `v16` `k`) join `v17` `l` on(((`x`.`county_id` = `y`.`county_id`) and (`y`.`survey_id` = `z`.`survey_id`) and (`j`.`survey_id` = `z`.`survey_id`) and (`j`.`survey_id` = `k`.`survey_id`) and (`l`.`survey_id` = `k`.`survey_id`)))) group by `x`.`indicator`,`x`.`survey_id`,`y`.`county_name`;

-- --------------------------------------------------------

--
-- Structure for view `viewhealthcasesreported`
--
DROP TABLE IF EXISTS `viewhealthcasesreported`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewhealthcasesreported` AS select `viewhealthaggregates`.`indicator` AS `indicator`,`viewhealthaggregates`.`indicator_id` AS `indicator_id`,`viewhealthaggregates`.`county` AS `county`,`viewhealthaggregates`.`countyAggregate` AS `countyAggregate`,`viewhealthaggregates`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewhealthaggregates`.`completedPEPTotal` AS `completedPEPTotal`,`viewhealthaggregates`.`receivedcareTotal` AS `receivedcareTotal`,`viewhealthaggregates`.`casesReportedTotal` AS `casesReportedTotal`,`viewhealthaggregates`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewhealthaggregates` where (`viewhealthaggregates`.`indicator_id` = 3);

-- --------------------------------------------------------

--
-- Structure for view `viewhealthsummary`
--
DROP TABLE IF EXISTS `viewhealthsummary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewhealthsummary` AS select `viewserviceproviderstrained`.`indicator` AS `indicator`,`viewserviceproviderstrained`.`indicator_id` AS `indicator_id`,sum(`viewserviceproviderstrained`.`countyAggregate`) AS `Aggregates` from `viewserviceproviderstrained` group by `viewserviceproviderstrained`.`indicator` union select `viewhealthcasesreported`.`indicator` AS `indicator`,`viewhealthcasesreported`.`indicator_id` AS `indicator_id`,sum(`viewhealthcasesreported`.`countyAggregate`) AS `Aggregates` from `viewhealthcasesreported` group by `viewhealthcasesreported`.`indicator` union select `viewpepinitiated`.`indicator` AS `indicator`,`viewpepinitiated`.`indicator_id` AS `indicator_id`,sum(`viewpepinitiated`.`countycasesReportedPercentage`) AS `Aggregates` from `viewpepinitiated` group by `viewpepinitiated`.`indicator` union select `viewpepcompleted`.`indicator` AS `indicator`,`viewpepcompleted`.`indicator_id` AS `indicator_id`,sum(`viewpepcompleted`.`countycasesReportedPercentage`) AS `Aggregates` from `viewpepcompleted` group by `viewpepcompleted`.`indicator` union select `viewreceivedcomprehensivecare`.`indicator` AS `indicator`,`viewreceivedcomprehensivecare`.`indicator_id` AS `indicator_id`,sum(`viewreceivedcomprehensivecare`.`countycasesReportedPercentage`) AS `Aggregates` from `viewreceivedcomprehensivecare` group by `viewreceivedcomprehensivecare`.`indicator`;

-- --------------------------------------------------------

--
-- Structure for view `viewjudgestrained`
--
DROP TABLE IF EXISTS `viewjudgestrained`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewjudgestrained` AS select `viewjudiciaryaggregates`.`indicator` AS `indicator`,`viewjudiciaryaggregates`.`indicator_id` AS `indicator_id`,`viewjudiciaryaggregates`.`survey_id` AS `survey_id`,`viewjudiciaryaggregates`.`county_name` AS `county_name`,`viewjudiciaryaggregates`.`countyAggregate` AS `countyAggregate` from `viewjudiciaryaggregates` where (`viewjudiciaryaggregates`.`indicator_id` = 7);

-- --------------------------------------------------------

--
-- Structure for view `viewjudiciaryaggregates`
--
DROP TABLE IF EXISTS `viewjudiciaryaggregates`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewjudiciaryaggregates` AS select `x`.`indicator` AS `indicator`,`x`.`indicator_id` AS `indicator_id`,`y`.`county_name` AS `county_name`,`y`.`county_id` AS `county_id`,((`x`.`countyAggregate` / `z`.`nationalProsecutionTotal`) * 100) AS `countyPercentage`,`y`.`survey_id` AS `survey_id`,`x`.`countyAggregate` AS `countyAggregate`,`j`.`nationalTriedTotal` AS `nationalTriedTotal`,((`j`.`nationalTriedTotal` / `z`.`nationalProsecutionTotal`) * 100) AS `nationalPercentage`,`z`.`nationalProsecutionTotal` AS `nationalProsecutionTotal` from (((`v1` `x` join `v2` `y`) join `v3` `j`) join `v4` `z` on(((`x`.`county_id` = `y`.`county_id`) and (`y`.`survey_id` = `j`.`survey_id`) and (`z`.`survey_id` = `j`.`survey_id`) and (`x`.`indicator_id` = `j`.`indicator_id`)))) group by `x`.`indicator`,`x`.`survey_id`,`y`.`county_id`;

-- --------------------------------------------------------

--
-- Structure for view `viewjudiciarysummary`
--
DROP TABLE IF EXISTS `viewjudiciarysummary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewjudiciarysummary` AS select `viewjudgestrained`.`indicator` AS `indicator`,`viewjudgestrained`.`indicator_id` AS `indicator_id`,sum(`viewjudgestrained`.`countyAggregate`) AS `Aggregates` from `viewjudgestrained` group by `viewjudgestrained`.`indicator` union select `viewtriedcases`.`indicator` AS `indicator`,`viewtriedcases`.`indicator_id` AS `indicator_id`,sum(`viewtriedcases`.`countyPercentage`) AS `Aggregates` from `viewtriedcases` group by `viewtriedcases`.`indicator`;

-- --------------------------------------------------------

--
-- Structure for view `viewpepcompleted`
--
DROP TABLE IF EXISTS `viewpepcompleted`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewpepcompleted` AS select `viewhealthaggregates`.`indicator` AS `indicator`,`viewhealthaggregates`.`indicator_id` AS `indicator_id`,`viewhealthaggregates`.`county` AS `county`,`viewhealthaggregates`.`countyAggregate` AS `countyAggregate`,`viewhealthaggregates`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewhealthaggregates`.`completedPEPTotal` AS `completedPEPTotal`,`viewhealthaggregates`.`receivedcareTotal` AS `receivedcareTotal`,`viewhealthaggregates`.`casesReportedTotal` AS `casesReportedTotal`,`viewhealthaggregates`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewhealthaggregates` where (`viewhealthaggregates`.`indicator_id` = 5);

-- --------------------------------------------------------

--
-- Structure for view `viewpepinitiated`
--
DROP TABLE IF EXISTS `viewpepinitiated`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewpepinitiated` AS select `viewhealthaggregates`.`indicator` AS `indicator`,`viewhealthaggregates`.`indicator_id` AS `indicator_id`,`viewhealthaggregates`.`county` AS `county`,`viewhealthaggregates`.`countyAggregate` AS `countyAggregate`,`viewhealthaggregates`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewhealthaggregates`.`completedPEPTotal` AS `completedPEPTotal`,`viewhealthaggregates`.`receivedcareTotal` AS `receivedcareTotal`,`viewhealthaggregates`.`casesReportedTotal` AS `casesReportedTotal`,`viewhealthaggregates`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewhealthaggregates` where (`viewhealthaggregates`.`indicator_id` = 4);

-- --------------------------------------------------------

--
-- Structure for view `viewpoliceaggregates`
--
DROP TABLE IF EXISTS `viewpoliceaggregates`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewpoliceaggregates` AS select `x`.`indicator` AS `indicator`,`x`.`indicator_id` AS `indicator_id`,`y`.`county_name` AS `county`,sum(`x`.`aggregate`) AS `countyTotal`,`z`.`nationalTotal` AS `nationalTotal`,((sum(`x`.`aggregate`) / `z`.`nationalTotal`) * 100) AS `percentage` from ((`v9` `x` join `v10` `y`) join `v11` `z` on(((`x`.`county_id` = `y`.`county_id`) and (`y`.`survey_id` = `z`.`survey_id`)))) group by `x`.`indicator`,`x`.`survey_id`,`y`.`county_name`;

-- --------------------------------------------------------

--
-- Structure for view `viewpolicesummary`
--
DROP TABLE IF EXISTS `viewpolicesummary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewpolicesummary` AS select `viewcasesreported`.`indicator` AS `indicator`,`viewcasesreported`.`indicator_id` AS `indicator_id`,sum(`viewcasesreported`.`countyTotal`) AS `Aggregates` from `viewcasesreported` group by `viewcasesreported`.`indicator`;

-- --------------------------------------------------------

--
-- Structure for view `viewprosecutedcases`
--
DROP TABLE IF EXISTS `viewprosecutedcases`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewprosecutedcases` AS select `viewprosecutionaggregates`.`indicator` AS `indicator`,`viewprosecutionaggregates`.`indicator_id` AS `indicator_id`,`viewprosecutionaggregates`.`county_name` AS `county_name`,`viewprosecutionaggregates`.`countyPercentage1` AS `countyPercentage1`,`viewprosecutionaggregates`.`survey_id` AS `survey_id`,`viewprosecutionaggregates`.`countyAggregate` AS `countyAggregate`,`viewprosecutionaggregates`.`countyPercentage` AS `countyPercentage`,`viewprosecutionaggregates`.`nationalProsecutionTotal` AS `nationalProsecutionTotal`,`viewprosecutionaggregates`.`nationalPercentage` AS `nationalPercentage`,`viewprosecutionaggregates`.`nationalPoliceTotal` AS `nationalPoliceTotal` from `viewprosecutionaggregates` where (`viewprosecutionaggregates`.`indicator_id` = 17);

-- --------------------------------------------------------

--
-- Structure for view `viewprosecutionaggregates`
--
DROP TABLE IF EXISTS `viewprosecutionaggregates`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewprosecutionaggregates` AS select `x`.`indicator` AS `indicator`,`x`.`indicator_id` AS `indicator_id`,`y`.`county_name` AS `county_name`,`y`.`county_id` AS `county_id`,((`x`.`countyAggregate` / `z`.`nationalPoliceTotal`) * 100) AS `countyPercentage1`,`y`.`survey_id` AS `survey_id`,`x`.`countyAggregate` AS `countyAggregate`,((`x`.`countyAggregate` / `z`.`nationalPoliceTotal`) * 100) AS `countyPercentage`,`j`.`nationalProsecutionTotal` AS `nationalProsecutionTotal`,((`j`.`nationalProsecutionTotal` / `z`.`nationalPoliceTotal`) * 100) AS `nationalPercentage`,`z`.`nationalPoliceTotal` AS `nationalPoliceTotal` from (((`v5` `x` join `v6` `y`) join `v7` `j`) join `v8` `z` on(((`x`.`county_id` = `y`.`county_id`) and (`y`.`survey_id` = `j`.`survey_id`) and (`z`.`survey_id` = `j`.`survey_id`) and (`x`.`indicator_id` = `j`.`indicator_id`)))) group by `x`.`indicator`,`x`.`survey_id`,`y`.`county_id`;

-- --------------------------------------------------------

--
-- Structure for view `viewprosecutionsummary`
--
DROP TABLE IF EXISTS `viewprosecutionsummary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewprosecutionsummary` AS select `viewprosecutorstrained`.`indicator` AS `indicator`,`viewprosecutorstrained`.`indicator_id` AS `indicator_id`,sum(`viewprosecutorstrained`.`countyAggregate`) AS `Aggregates` from `viewprosecutorstrained` group by `viewprosecutorstrained`.`indicator` union select `viewreceivedcases`.`indicator` AS `indicator`,`viewreceivedcases`.`indicator_id` AS `indicator_id`,sum(`viewreceivedcases`.`countyAggregate`) AS `Aggregates` from `viewreceivedcases` group by `viewreceivedcases`.`indicator` union select `viewprosecutedcases`.`indicator` AS `indicator`,`viewprosecutedcases`.`indicator_id` AS `indicator_id`,sum(`viewprosecutedcases`.`countyPercentage`) AS `Aggregates` from `viewprosecutedcases` group by `viewprosecutedcases`.`indicator`;

-- --------------------------------------------------------

--
-- Structure for view `viewprosecutorstrained`
--
DROP TABLE IF EXISTS `viewprosecutorstrained`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewprosecutorstrained` AS select `viewprosecutionaggregates`.`indicator` AS `indicator`,`viewprosecutionaggregates`.`indicator_id` AS `indicator_id`,`viewprosecutionaggregates`.`county_name` AS `county_name`,`viewprosecutionaggregates`.`county_id` AS `county_id`,`viewprosecutionaggregates`.`countyPercentage1` AS `countyPercentage1`,`viewprosecutionaggregates`.`survey_id` AS `survey_id`,`viewprosecutionaggregates`.`countyAggregate` AS `countyAggregate`,`viewprosecutionaggregates`.`countyPercentage` AS `countyPercentage`,`viewprosecutionaggregates`.`nationalProsecutionTotal` AS `nationalProsecutionTotal`,`viewprosecutionaggregates`.`nationalPercentage` AS `nationalPercentage`,`viewprosecutionaggregates`.`nationalPoliceTotal` AS `nationalPoliceTotal` from `viewprosecutionaggregates` where (`viewprosecutionaggregates`.`indicator_id` = 15);

-- --------------------------------------------------------

--
-- Structure for view `viewreceivedcases`
--
DROP TABLE IF EXISTS `viewreceivedcases`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewreceivedcases` AS select `viewprosecutionaggregates`.`indicator` AS `indicator`,`viewprosecutionaggregates`.`indicator_id` AS `indicator_id`,`viewprosecutionaggregates`.`county_name` AS `county_name`,`viewprosecutionaggregates`.`countyPercentage1` AS `countyPercentage1`,`viewprosecutionaggregates`.`survey_id` AS `survey_id`,`viewprosecutionaggregates`.`countyAggregate` AS `countyAggregate`,`viewprosecutionaggregates`.`countyPercentage` AS `countyPercentage`,`viewprosecutionaggregates`.`nationalProsecutionTotal` AS `nationalProsecutionTotal`,`viewprosecutionaggregates`.`nationalPercentage` AS `nationalPercentage`,`viewprosecutionaggregates`.`nationalPoliceTotal` AS `nationalPoliceTotal` from `viewprosecutionaggregates` where (`viewprosecutionaggregates`.`indicator_id` = 16);

-- --------------------------------------------------------

--
-- Structure for view `viewreceivedcomprehensivecare`
--
DROP TABLE IF EXISTS `viewreceivedcomprehensivecare`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewreceivedcomprehensivecare` AS select `viewhealthaggregates`.`indicator` AS `indicator`,`viewhealthaggregates`.`indicator_id` AS `indicator_id`,`viewhealthaggregates`.`county` AS `county`,`viewhealthaggregates`.`countyAggregate` AS `countyAggregate`,`viewhealthaggregates`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewhealthaggregates`.`completedPEPTotal` AS `completedPEPTotal`,`viewhealthaggregates`.`receivedcareTotal` AS `receivedcareTotal`,`viewhealthaggregates`.`casesReportedTotal` AS `casesReportedTotal`,`viewhealthaggregates`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewhealthaggregates` where (`viewhealthaggregates`.`indicator_id` = 6);

-- --------------------------------------------------------

--
-- Structure for view `viewserviceproviderstrained`
--
DROP TABLE IF EXISTS `viewserviceproviderstrained`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewserviceproviderstrained` AS select `viewhealthaggregates`.`indicator` AS `indicator`,`viewhealthaggregates`.`indicator_id` AS `indicator_id`,`viewhealthaggregates`.`county` AS `county`,`viewhealthaggregates`.`countyAggregate` AS `countyAggregate`,`viewhealthaggregates`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewhealthaggregates`.`completedPEPTotal` AS `completedPEPTotal`,`viewhealthaggregates`.`receivedcareTotal` AS `receivedcareTotal`,`viewhealthaggregates`.`casesReportedTotal` AS `casesReportedTotal`,`viewhealthaggregates`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewhealthaggregates` where (`viewhealthaggregates`.`indicator_id` = 2);

-- --------------------------------------------------------

--
-- Structure for view `viewsummarytriedcases`
--
DROP TABLE IF EXISTS `viewsummarytriedcases`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewsummarytriedcases` AS select `viewtriedcases`.`indicator` AS `indicator`,`viewtriedcases`.`nationalTriedTotal` AS `nationalTriedTotal`,`viewtriedcases`.`nationalProsecutionTotal` AS `nationalProsecutionTotal`,sum(`viewtriedcases`.`countyPercentage`) AS `IndicatorPercentage` from `viewtriedcases` group by `viewtriedcases`.`indicator` union select 'number of unresolved cases' AS `Indicator`,sum(`viewunresolvedcases`.`nationalTriedTotal`) AS `nationalTriedTotal`,`viewunresolvedcases`.`nationalProsecutionTotal` AS `nationalProsecutionTotal`,(((`viewunresolvedcases`.`nationalProsecutionTotal` - sum(`viewunresolvedcases`.`nationalTriedTotal`)) / `viewunresolvedcases`.`nationalProsecutionTotal`) * 100) AS `IndicatorPercentage` from `viewunresolvedcases` group by `viewunresolvedcases`.`survey_id`;

-- --------------------------------------------------------

--
-- Structure for view `viewtop5casesreported`
--
DROP TABLE IF EXISTS `viewtop5casesreported`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewtop5casesreported` AS select `viewcasesreported`.`indicator` AS `indicator`,`viewcasesreported`.`indicator_id` AS `indicator_id`,`viewcasesreported`.`county` AS `county`,`viewcasesreported`.`countyTotal` AS `countyTotal`,`viewcasesreported`.`nationalTotal` AS `nationalTotal`,`viewcasesreported`.`percentage` AS `percentage` from `viewcasesreported` order by `viewcasesreported`.`countyTotal` desc limit 5;

-- --------------------------------------------------------

--
-- Structure for view `viewtop5convictedcases`
--
DROP TABLE IF EXISTS `viewtop5convictedcases`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewtop5convictedcases` AS select `viewconvictedcases`.`county_name` AS `county_name`,`viewconvictedcases`.`county_id` AS `county_id`,`viewconvictedcases`.`survey_id` AS `survey_id`,sum(`viewconvictedcases`.`countyPercentage`) AS `Convicted` from `viewconvictedcases` group by `viewconvictedcases`.`survey_id`,`viewconvictedcases`.`county_id` order by sum(`viewconvictedcases`.`countyPercentage`) desc limit 5;

-- --------------------------------------------------------

--
-- Structure for view `viewtop5healthcasesreported`
--
DROP TABLE IF EXISTS `viewtop5healthcasesreported`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewtop5healthcasesreported` AS select `viewhealthcasesreported`.`indicator` AS `indicator`,`viewhealthcasesreported`.`indicator_id` AS `indicator_id`,`viewhealthcasesreported`.`county` AS `county`,`viewhealthcasesreported`.`countyAggregate` AS `countyAggregate`,`viewhealthcasesreported`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewhealthcasesreported`.`completedPEPTotal` AS `completedPEPTotal`,`viewhealthcasesreported`.`receivedcareTotal` AS `receivedcareTotal`,`viewhealthcasesreported`.`casesReportedTotal` AS `casesReportedTotal`,`viewhealthcasesreported`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewhealthcasesreported` order by `viewhealthcasesreported`.`countyAggregate` desc limit 5;

-- --------------------------------------------------------

--
-- Structure for view `viewtop5judgestrained`
--
DROP TABLE IF EXISTS `viewtop5judgestrained`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewtop5judgestrained` AS select `viewjudgestrained`.`county_name` AS `county_name`,`viewjudgestrained`.`countyAggregate` AS `countyAggregate` from `viewjudgestrained` order by `viewjudgestrained`.`countyAggregate` desc limit 5;

-- --------------------------------------------------------

--
-- Structure for view `viewtop5pepcompleted`
--
DROP TABLE IF EXISTS `viewtop5pepcompleted`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewtop5pepcompleted` AS select `viewpepcompleted`.`indicator` AS `indicator`,`viewpepcompleted`.`indicator_id` AS `indicator_id`,`viewpepcompleted`.`county` AS `county`,`viewpepcompleted`.`countyAggregate` AS `countyAggregate`,`viewpepcompleted`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewpepcompleted`.`completedPEPTotal` AS `completedPEPTotal`,`viewpepcompleted`.`receivedcareTotal` AS `receivedcareTotal`,`viewpepcompleted`.`casesReportedTotal` AS `casesReportedTotal`,`viewpepcompleted`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewpepcompleted` order by `viewpepcompleted`.`countycasesReportedPercentage` desc limit 5;

-- --------------------------------------------------------

--
-- Structure for view `viewtop5pepinitiated`
--
DROP TABLE IF EXISTS `viewtop5pepinitiated`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewtop5pepinitiated` AS select `viewpepinitiated`.`indicator` AS `indicator`,`viewpepinitiated`.`indicator_id` AS `indicator_id`,`viewpepinitiated`.`county` AS `county`,`viewpepinitiated`.`countyAggregate` AS `countyAggregate`,`viewpepinitiated`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewpepinitiated`.`completedPEPTotal` AS `completedPEPTotal`,`viewpepinitiated`.`receivedcareTotal` AS `receivedcareTotal`,`viewpepinitiated`.`casesReportedTotal` AS `casesReportedTotal`,`viewpepinitiated`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewpepinitiated` order by `viewpepinitiated`.`countycasesReportedPercentage` desc limit 5;

-- --------------------------------------------------------

--
-- Structure for view `viewtop5prosecutedcases`
--
DROP TABLE IF EXISTS `viewtop5prosecutedcases`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewtop5prosecutedcases` AS select `viewprosecutedcases`.`county_name` AS `county_name`,`viewprosecutedcases`.`countyPercentage` AS `countyPercentage` from `viewprosecutedcases` order by `viewprosecutedcases`.`countyPercentage` desc limit 5;

-- --------------------------------------------------------

--
-- Structure for view `viewtop5prosecutorstrained`
--
DROP TABLE IF EXISTS `viewtop5prosecutorstrained`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewtop5prosecutorstrained` AS select `viewprosecutorstrained`.`county_name` AS `county_name`,`viewprosecutorstrained`.`county_id` AS `county_id`,`viewprosecutorstrained`.`survey_id` AS `survey_id`,sum(`viewprosecutorstrained`.`countyAggregate`) AS `Trained` from `viewprosecutorstrained` group by `viewprosecutorstrained`.`survey_id`,`viewprosecutorstrained`.`county_id` order by sum(`viewprosecutorstrained`.`countyPercentage`) desc limit 5;

-- --------------------------------------------------------

--
-- Structure for view `viewtop5receivedcases`
--
DROP TABLE IF EXISTS `viewtop5receivedcases`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewtop5receivedcases` AS select `viewreceivedcases`.`county_name` AS `county_name`,`viewreceivedcases`.`countyAggregate` AS `Aggregate` from `viewreceivedcases` order by `viewreceivedcases`.`countyAggregate` desc limit 5;

-- --------------------------------------------------------

--
-- Structure for view `viewtop5receivedcomprehensivecare`
--
DROP TABLE IF EXISTS `viewtop5receivedcomprehensivecare`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewtop5receivedcomprehensivecare` AS select `viewreceivedcomprehensivecare`.`indicator` AS `indicator`,`viewreceivedcomprehensivecare`.`indicator_id` AS `indicator_id`,`viewreceivedcomprehensivecare`.`county` AS `county`,`viewreceivedcomprehensivecare`.`countyAggregate` AS `countyAggregate`,`viewreceivedcomprehensivecare`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewreceivedcomprehensivecare`.`completedPEPTotal` AS `completedPEPTotal`,`viewreceivedcomprehensivecare`.`receivedcareTotal` AS `receivedcareTotal`,`viewreceivedcomprehensivecare`.`casesReportedTotal` AS `casesReportedTotal`,`viewreceivedcomprehensivecare`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewreceivedcomprehensivecare` order by `viewreceivedcomprehensivecare`.`countycasesReportedPercentage` desc limit 5;

-- --------------------------------------------------------

--
-- Structure for view `viewtop5serviceproviderstrained`
--
DROP TABLE IF EXISTS `viewtop5serviceproviderstrained`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewtop5serviceproviderstrained` AS select `viewserviceproviderstrained`.`indicator` AS `indicator`,`viewserviceproviderstrained`.`indicator_id` AS `indicator_id`,`viewserviceproviderstrained`.`county` AS `county`,`viewserviceproviderstrained`.`countyAggregate` AS `countyAggregate`,`viewserviceproviderstrained`.`initiatedPEPTotal` AS `initiatedPEPTotal`,`viewserviceproviderstrained`.`completedPEPTotal` AS `completedPEPTotal`,`viewserviceproviderstrained`.`receivedcareTotal` AS `receivedcareTotal`,`viewserviceproviderstrained`.`casesReportedTotal` AS `casesReportedTotal`,`viewserviceproviderstrained`.`countycasesReportedPercentage` AS `countycasesReportedPercentage` from `viewserviceproviderstrained` order by `viewserviceproviderstrained`.`countyAggregate` desc limit 5;

-- --------------------------------------------------------

--
-- Structure for view `viewtop5withdrawncases`
--
DROP TABLE IF EXISTS `viewtop5withdrawncases`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewtop5withdrawncases` AS select `viewwithdrawncases`.`county_name` AS `county_name`,`viewwithdrawncases`.`county_id` AS `county_id`,`viewwithdrawncases`.`survey_id` AS `survey_id`,sum(`viewwithdrawncases`.`countyPercentage`) AS `Withdrawn` from `viewwithdrawncases` group by `viewwithdrawncases`.`survey_id`,`viewwithdrawncases`.`county_id` order by sum(`viewwithdrawncases`.`countyPercentage`) desc limit 5;

-- --------------------------------------------------------

--
-- Structure for view `viewtriedcases`
--
DROP TABLE IF EXISTS `viewtriedcases`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewtriedcases` AS select `viewjudiciaryaggregates`.`indicator` AS `indicator`,`viewjudiciaryaggregates`.`indicator_id` AS `indicator_id`,`viewjudiciaryaggregates`.`county_name` AS `county_name`,`viewjudiciaryaggregates`.`county_id` AS `county_id`,`viewjudiciaryaggregates`.`countyPercentage` AS `countyPercentage`,`viewjudiciaryaggregates`.`survey_id` AS `survey_id`,`viewjudiciaryaggregates`.`countyAggregate` AS `countyAggregate`,`viewjudiciaryaggregates`.`nationalTriedTotal` AS `nationalTriedTotal`,`viewjudiciaryaggregates`.`nationalPercentage` AS `nationalPercentage`,`viewjudiciaryaggregates`.`nationalProsecutionTotal` AS `nationalProsecutionTotal` from `viewjudiciaryaggregates` where ((`viewjudiciaryaggregates`.`indicator_id` = 8) or (`viewjudiciaryaggregates`.`indicator_id` = 9));

-- --------------------------------------------------------

--
-- Structure for view `viewunresolvedcases`
--
DROP TABLE IF EXISTS `viewunresolvedcases`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewunresolvedcases` AS select `viewtriedcases`.`survey_id` AS `survey_id`,`viewtriedcases`.`nationalTriedTotal` AS `nationalTriedTotal`,`viewtriedcases`.`nationalProsecutionTotal` AS `nationalProsecutionTotal` from `viewtriedcases` group by `viewtriedcases`.`indicator`;

-- --------------------------------------------------------

--
-- Structure for view `viewwithdrawncases`
--
DROP TABLE IF EXISTS `viewwithdrawncases`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewwithdrawncases` AS select `viewjudiciaryaggregates`.`indicator` AS `indicator`,`viewjudiciaryaggregates`.`county_name` AS `county_name`,`viewjudiciaryaggregates`.`county_id` AS `county_id`,`viewjudiciaryaggregates`.`countyPercentage` AS `countyPercentage`,`viewjudiciaryaggregates`.`survey_id` AS `survey_id`,`viewjudiciaryaggregates`.`countyAggregate` AS `countyAggregate`,`viewjudiciaryaggregates`.`nationalTriedTotal` AS `nationalTriedTotal`,`viewjudiciaryaggregates`.`nationalPercentage` AS `nationalPercentage`,`viewjudiciaryaggregates`.`nationalProsecutionTotal` AS `nationalProsecutionTotal` from `viewjudiciaryaggregates` where (`viewjudiciaryaggregates`.`indicator_id` = 8);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
