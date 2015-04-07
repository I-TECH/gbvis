-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 16, 2015 at 12:26 PM
-- Server version: 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gbvis`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `devolved_structure2`()
BEGIN

select a.county_code,a.county_name,b.district_code,b.district_name,c.division_code,c.division_name,d.location_code,d.location_name,e.sub_location_code,e.sub_location_name from  counties a
left join districts b on a.county_id=b.county_id
left join divisions c on b.district_id=c.district_id
left join locations d on c.division_id=d.division_id
left join sub_locations e on d.location_id= e.location_id
order by a.county_id;

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
  `date` date NOT NULL,
  PRIMARY KEY (`county_id`,`survey_id`,`indicator_id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `community_aggregates`
--

INSERT INTO `community_aggregates` (`id`, `county_id`, `survey_id`, `indicator_id`, `aggregate`, `date`) VALUES
(2, 1, 1, 7, 86, '2015-03-10'),
(1, 1, 1, 8, 1009, '2015-03-10'),
(10, 1, 2, 6, 345, '2015-03-10'),
(18, 4, 2, 13, 234, '0000-00-00'),
(22, 5, 1, 7, 566, '0000-00-00'),
(14, 8, 2, 4, 123, '2015-03-10'),
(20, 9, 2, 2, 678, '0000-00-00'),
(12, 10, 1, 1, 455, '2015-03-10'),
(19, 11, 1, 13, 10000, '0000-00-00'),
(5, 11, 2, 11, 450, '2015-03-10');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `fname` varchar(100) NOT NULL,
  `age` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`fname`, `age`) VALUES
('test', 100),
('test1', 100);

-- --------------------------------------------------------

--
-- Table structure for table `counties`
--

CREATE TABLE IF NOT EXISTS `counties` (
  `county_id` int(11) NOT NULL AUTO_INCREMENT,
  `county_name` varchar(100) NOT NULL,
  PRIMARY KEY (`county_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `counties`
--

INSERT INTO `counties` (`county_id`, `county_name`) VALUES
(1, 'MOMBASA  '),
(2, 'KWALE '),
(3, 'KILIFI '),
(4, 'TANA RIVER '),
(5, 'LAMU '),
(6, 'TAITA TAVETA'),
(7, 'GARISSA'),
(8, 'WAJIR '),
(9, 'MANDERA'),
(10, 'MARSABIT '),
(11, 'ISIOLO'),
(12, 'MERU'),
(13, 'THARAKA NITHI '),
(14, 'EMBU'),
(15, 'KITUI'),
(16, 'MACHAKOS'),
(17, 'MAKUENI'),
(18, 'NYANDARUA'),
(19, 'NYERI'),
(20, 'KIRINYAGA'),
(21, 'MURANG''A'),
(22, 'KIAMBU'),
(23, 'TURKANA'),
(24, 'WEST POKOT'),
(25, 'SAMBURU'),
(26, 'TRANS NZOIA'),
(27, 'UASIN GISHU'),
(28, 'ELGEYO MARAKWET'),
(29, 'NANDI '),
(30, 'BARINGO'),
(31, 'LAIKIPIA '),
(32, 'NAKURU'),
(33, 'NAROK'),
(34, 'KAJIADO'),
(35, 'KERICHO'),
(36, 'BOMET'),
(37, 'KAKAMEGA'),
(38, 'VIHIGA '),
(39, 'BUNGOMA'),
(40, 'BUSIA'),
(41, 'SIAYA'),
(42, 'KISUMU'),
(43, 'HOMA BAY'),
(44, 'MIGORI'),
(45, 'KISII'),
(46, 'NYAMIRA'),
(47, 'NAIROBI ');

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
  `date` date NOT NULL,
  PRIMARY KEY (`county_id`,`survey_id`,`indicator_id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `file_uploads`
--

INSERT INTO `file_uploads` (`id`, `name`, `type`, `size`, `path`, `status`, `description`, `uploadedby`, `sector`, `useremail`, `date`) VALUES
(1, 'police_aggregates_database_format.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '8697', '../../Uploaded_files/police_aggregates_database_format.xlsx', 'Not Apoproved', '', 'police', 'Police', 'police@gmail.com', '2015-03-16 08:25:15'),
(2, 'police_aggregates_database_format.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '8697', '../../Uploaded_files/police_aggregates_database_format.xlsx', 'Not Apoproved', '', 'police', 'Police', 'police@gmail.com', '2015-03-16 08:25:24');

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
  `date` date NOT NULL,
  PRIMARY KEY (`county_id`,`survey_id`,`indicator_id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

--
-- Dumping data for table `health_aggregates`
--

INSERT INTO `health_aggregates` (`id`, `county_id`, `survey_id`, `indicator_id`, `aggregate`, `date`) VALUES
(1, 0, 1, 1, 1200, '0000-00-00'),
(2, 0, 1, 2, 500, '0000-00-00'),
(3, 0, 1, 3, 1500, '0000-00-00'),
(4, 0, 1, 4, 400, '0000-00-00'),
(5, 0, 1, 5, 800, '0000-00-00'),
(6, 0, 1, 6, 2000, '0000-00-00'),
(11, 0, 1, 13, 12, '0000-00-00'),
(85, 1, 0, 0, 188, '0000-00-00'),
(10, 1, 1, 10, 120, '0000-00-00'),
(41, 1, 1, 13, 188, '0000-00-00'),
(87, 2, 0, 0, 137, '0000-00-00'),
(43, 2, 1, 13, 137, '0000-00-00'),
(86, 3, 0, 0, 270, '0000-00-00'),
(9, 3, 1, 9, 78, '0000-00-00'),
(42, 3, 1, 13, 270, '0000-00-00'),
(90, 4, 0, 0, 66, '0000-00-00'),
(46, 4, 1, 13, 66, '0000-00-00'),
(88, 5, 0, 0, 25, '0000-00-00'),
(44, 5, 1, 13, 25, '0000-00-00'),
(89, 6, 0, 0, 126, '0000-00-00'),
(45, 6, 1, 13, 126, '0000-00-00'),
(97, 7, 0, 0, 64, '0000-00-00'),
(53, 7, 1, 13, 64, '0000-00-00'),
(98, 8, 0, 0, 27, '0000-00-00'),
(54, 8, 1, 13, 27, '0000-00-00'),
(99, 9, 0, 0, 12, '0000-00-00'),
(55, 9, 1, 13, 12, '0000-00-00'),
(56, 10, 0, 0, 12, '0000-00-00'),
(12, 10, 1, 13, 12, '0000-00-00'),
(57, 11, 0, 0, 8, '0000-00-00'),
(13, 11, 1, 13, 8, '0000-00-00'),
(58, 12, 0, 0, 40, '0000-00-00'),
(14, 12, 1, 13, 40, '0000-00-00'),
(59, 14, 0, 0, 49, '0000-00-00'),
(15, 14, 1, 13, 49, '0000-00-00'),
(60, 15, 0, 0, 55, '0000-00-00'),
(16, 15, 1, 13, 55, '0000-00-00'),
(61, 16, 0, 0, 26, '0000-00-00'),
(8, 16, 1, 8, 370, '0000-00-00'),
(17, 16, 1, 13, 26, '0000-00-00'),
(62, 17, 0, 0, 40, '0000-00-00'),
(18, 17, 1, 13, 40, '0000-00-00'),
(63, 18, 0, 0, 139, '0000-00-00'),
(19, 18, 1, 13, 139, '0000-00-00'),
(64, 19, 0, 0, 92, '0000-00-00'),
(20, 19, 1, 13, 92, '0000-00-00'),
(65, 20, 0, 0, 102, '0000-00-00'),
(21, 20, 1, 13, 102, '0000-00-00'),
(66, 22, 0, 0, 211, '0000-00-00'),
(22, 22, 1, 13, 211, '0000-00-00'),
(83, 23, 0, 0, 56, '0000-00-00'),
(39, 23, 1, 13, 56, '0000-00-00'),
(84, 24, 0, 0, 55, '0000-00-00'),
(40, 24, 1, 13, 55, '0000-00-00'),
(82, 25, 0, 0, 27, '0000-00-00'),
(38, 25, 1, 13, 27, '0000-00-00'),
(74, 27, 0, 0, 187, '0000-00-00'),
(7, 27, 1, 7, 700, '0000-00-00'),
(30, 27, 1, 13, 187, '0000-00-00'),
(76, 28, 0, 0, 93, '0000-00-00'),
(32, 28, 1, 13, 93, '0000-00-00'),
(80, 29, 0, 0, 88, '0000-00-00'),
(36, 29, 1, 13, 88, '0000-00-00'),
(72, 30, 0, 0, 68, '0000-00-00'),
(28, 30, 1, 13, 68, '0000-00-00'),
(78, 31, 0, 0, 61, '0000-00-00'),
(34, 31, 1, 13, 61, '0000-00-00'),
(79, 32, 0, 0, 378, '0000-00-00'),
(35, 32, 1, 13, 378, '0000-00-00'),
(81, 33, 0, 0, 153, '0000-00-00'),
(37, 33, 1, 13, 153, '0000-00-00'),
(75, 34, 0, 0, 92, '0000-00-00'),
(31, 34, 1, 13, 92, '0000-00-00'),
(77, 35, 0, 0, 128, '0000-00-00'),
(33, 35, 1, 13, 128, '0000-00-00'),
(73, 36, 0, 0, 95, '0000-00-00'),
(29, 36, 1, 13, 95, '0000-00-00'),
(68, 37, 0, 0, 185, '0000-00-00'),
(24, 37, 1, 13, 185, '0000-00-00'),
(70, 38, 0, 0, 63, '0000-00-00'),
(26, 38, 1, 13, 63, '0000-00-00'),
(67, 39, 0, 0, 210, '0000-00-00'),
(23, 39, 1, 13, 210, '0000-00-00'),
(69, 40, 0, 0, 123, '0000-00-00'),
(25, 40, 1, 13, 123, '0000-00-00'),
(92, 41, 0, 0, 138, '0000-00-00'),
(48, 41, 1, 13, 138, '0000-00-00'),
(91, 42, 0, 0, 195, '0000-00-00'),
(47, 42, 1, 13, 195, '0000-00-00'),
(93, 43, 0, 0, 105, '0000-00-00'),
(49, 43, 1, 13, 105, '0000-00-00'),
(94, 44, 0, 0, 72, '0000-00-00'),
(50, 44, 1, 13, 72, '0000-00-00'),
(95, 45, 0, 0, 157, '0000-00-00'),
(51, 45, 1, 13, 157, '0000-00-00'),
(96, 46, 0, 0, 72, '0000-00-00'),
(52, 46, 1, 13, 72, '0000-00-00'),
(71, 47, 0, 0, 296, '0000-00-00'),
(27, 47, 1, 13, 296, '0000-00-00');

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
  PRIMARY KEY (`survey_id`,`sector_id`,`indicator_id`),
  UNIQUE KEY `indicator` (`indicator`),
  UNIQUE KEY `indicator_2` (`indicator`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `indicators`
--

INSERT INTO `indicators` (`survey_id`, `sector_id`, `indicator_id`, `indicator`, `date_recorded`, `date_modified`) VALUES
(1, 1, 7, 'number of judges trained', '0000-00-00', '0000-00-00'),
(1, 1, 8, 'proportion of prosecuted withdrawn cases', '0000-00-00', '0000-00-00'),
(1, 1, 9, 'proportion of prosecuted convicted cases', '0000-00-00', '0000-00-00'),
(1, 1, 10, 'average time to conclude cases', '0000-00-00', '0000-00-00'),
(1, 2, 1, 'proportion of health facilities providing services for survivors', '0000-00-00', '0000-00-00'),
(1, 2, 2, 'number of service  providers trained', '0000-00-00', '0000-00-00'),
(1, 2, 3, 'number of rape survivors', '0000-00-00', '0000-00-00'),
(1, 2, 4, 'proportion of survivors initiated on pep', '0000-00-00', '0000-00-00'),
(1, 2, 5, 'proportion of  survivors completed pep', '0000-00-00', '0000-00-00'),
(1, 2, 6, 'proportion of  survivors received comprehensive care', '0000-00-00', '0000-00-00'),
(1, 3, 11, 'proportion of police stations with functional gender desk', '0000-00-00', '0000-00-00'),
(1, 3, 12, 'number of police trained', '0000-00-00', '0000-00-00'),
(1, 3, 13, 'number of cases reported', '0000-00-00', '0000-00-00'),
(1, 3, 14, 'proportion of prosecuted cases', '0000-00-00', '0000-00-00'),
(1, 4, 15, 'number of prosecutors trained', '0000-00-00', '0000-00-00'),
(1, 4, 16, 'number of cases received', '0000-00-00', '0000-00-00'),
(1, 4, 17, 'proportion of cases prosecuted', '0000-00-00', '0000-00-00');

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
  `date` date NOT NULL,
  PRIMARY KEY (`county_id`,`survey_id`,`indicator_id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=89 ;

--
-- Dumping data for table `judiciary_aggregates`
--

INSERT INTO `judiciary_aggregates` (`id`, `county_id`, `survey_id`, `indicator_id`, `aggregate`, `date`) VALUES
(74, 1, 0, 0, 188, '0000-00-00'),
(30, 1, 1, 13, 188, '0000-00-00'),
(76, 2, 0, 0, 137, '0000-00-00'),
(32, 2, 1, 13, 137, '0000-00-00'),
(75, 3, 0, 0, 270, '0000-00-00'),
(31, 3, 1, 13, 270, '0000-00-00'),
(79, 4, 0, 0, 66, '0000-00-00'),
(35, 4, 1, 13, 66, '0000-00-00'),
(77, 5, 0, 0, 25, '0000-00-00'),
(33, 5, 1, 13, 25, '0000-00-00'),
(78, 6, 0, 0, 126, '0000-00-00'),
(34, 6, 1, 13, 126, '0000-00-00'),
(86, 7, 0, 0, 64, '0000-00-00'),
(42, 7, 1, 13, 64, '0000-00-00'),
(87, 8, 0, 0, 27, '0000-00-00'),
(43, 8, 1, 13, 27, '0000-00-00'),
(88, 9, 0, 0, 12, '0000-00-00'),
(44, 9, 1, 13, 12, '0000-00-00'),
(45, 10, 0, 0, 12, '0000-00-00'),
(1, 10, 1, 13, 12, '0000-00-00'),
(46, 11, 0, 0, 8, '0000-00-00'),
(2, 11, 1, 13, 8, '0000-00-00'),
(47, 12, 0, 0, 40, '0000-00-00'),
(3, 12, 1, 13, 40, '0000-00-00'),
(48, 14, 0, 0, 49, '0000-00-00'),
(4, 14, 1, 13, 49, '0000-00-00'),
(49, 15, 0, 0, 55, '0000-00-00'),
(5, 15, 1, 13, 55, '0000-00-00'),
(50, 16, 0, 0, 26, '0000-00-00'),
(6, 16, 1, 13, 26, '0000-00-00'),
(51, 17, 0, 0, 40, '0000-00-00'),
(7, 17, 1, 13, 40, '0000-00-00'),
(52, 18, 0, 0, 139, '0000-00-00'),
(8, 18, 1, 13, 139, '0000-00-00'),
(53, 19, 0, 0, 92, '0000-00-00'),
(9, 19, 1, 13, 92, '0000-00-00'),
(54, 20, 0, 0, 102, '0000-00-00'),
(10, 20, 1, 13, 102, '0000-00-00'),
(55, 22, 0, 0, 211, '0000-00-00'),
(11, 22, 1, 13, 211, '0000-00-00'),
(72, 23, 0, 0, 56, '0000-00-00'),
(28, 23, 1, 13, 56, '0000-00-00'),
(73, 24, 0, 0, 55, '0000-00-00'),
(29, 24, 1, 13, 55, '0000-00-00'),
(71, 25, 0, 0, 27, '0000-00-00'),
(27, 25, 1, 13, 27, '0000-00-00'),
(63, 27, 0, 0, 187, '0000-00-00'),
(19, 27, 1, 13, 187, '0000-00-00'),
(65, 28, 0, 0, 93, '0000-00-00'),
(21, 28, 1, 13, 93, '0000-00-00'),
(69, 29, 0, 0, 88, '0000-00-00'),
(25, 29, 1, 13, 88, '0000-00-00'),
(61, 30, 0, 0, 68, '0000-00-00'),
(17, 30, 1, 13, 68, '0000-00-00'),
(67, 31, 0, 0, 61, '0000-00-00'),
(23, 31, 1, 13, 61, '0000-00-00'),
(68, 32, 0, 0, 378, '0000-00-00'),
(24, 32, 1, 13, 378, '0000-00-00'),
(70, 33, 0, 0, 153, '0000-00-00'),
(26, 33, 1, 13, 153, '0000-00-00'),
(64, 34, 0, 0, 92, '0000-00-00'),
(20, 34, 1, 13, 92, '0000-00-00'),
(66, 35, 0, 0, 128, '0000-00-00'),
(22, 35, 1, 13, 128, '0000-00-00'),
(62, 36, 0, 0, 95, '0000-00-00'),
(18, 36, 1, 13, 95, '0000-00-00'),
(57, 37, 0, 0, 185, '0000-00-00'),
(13, 37, 1, 13, 185, '0000-00-00'),
(59, 38, 0, 0, 63, '0000-00-00'),
(15, 38, 1, 13, 63, '0000-00-00'),
(56, 39, 0, 0, 210, '0000-00-00'),
(12, 39, 1, 13, 210, '0000-00-00'),
(58, 40, 0, 0, 123, '0000-00-00'),
(14, 40, 1, 13, 123, '0000-00-00'),
(81, 41, 0, 0, 138, '0000-00-00'),
(37, 41, 1, 13, 138, '0000-00-00'),
(80, 42, 0, 0, 195, '0000-00-00'),
(36, 42, 1, 13, 195, '0000-00-00'),
(82, 43, 0, 0, 105, '0000-00-00'),
(38, 43, 1, 13, 105, '0000-00-00'),
(83, 44, 0, 0, 72, '0000-00-00'),
(39, 44, 1, 13, 72, '0000-00-00'),
(84, 45, 0, 0, 157, '0000-00-00'),
(40, 45, 1, 13, 157, '0000-00-00'),
(85, 46, 0, 0, 72, '0000-00-00'),
(41, 46, 1, 13, 72, '0000-00-00'),
(60, 47, 0, 0, 296, '0000-00-00'),
(16, 47, 1, 13, 296, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `judiciary_count`
--

CREATE TABLE IF NOT EXISTS `judiciary_count` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Indicator` varchar(100) NOT NULL,
  `County` varchar(100) NOT NULL,
  `survey_period` varchar(100) NOT NULL,
  `aggregates` int(10) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `judiciary_count`
--

INSERT INTO `judiciary_count` (`id`, `Indicator`, `County`, `survey_period`, `aggregates`, `date`) VALUES
(1, 'Number of SGBV cases', 'Nairobi', '1', 5000, '2002-11-15'),
(2, 'Number of SGBV cases reported', 'Mombasa', '1', 2000, '2002-11-14'),
(3, 'Number of SGBV cases reported', 'Mombasa', '1', 400, '2002-11-14'),
(4, 'Number of SGBV cases reported', 'Mombasa', '1', 220, '2002-11-14'),
(5, 'Number of SGBV cases reported', 'Mombasa', '1', 700, '2002-11-14'),
(22, 'Average to conclude a SGBV case', '1', '2', 200, '2015-02-20'),
(23, 'Released convicted individuals', '2', '2', 500, '2015-02-20'),
(24, 'No of SGBV judges trained', '', '', 0, '0000-00-00'),
(25, 'No of SGBV prosecuted cases', '', '', 0, '0000-00-00'),
(26, 'No of SGBV cases logded', '', '', 0, '0000-00-00'),
(27, '13', 'number of cases reported', 'Jan to March', 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `piechart_drilldown`
--

CREATE TABLE IF NOT EXISTS `piechart_drilldown` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(100) NOT NULL,
  `county` varchar(100) NOT NULL,
  `percentage` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `piechart_drilldown`
--

INSERT INTO `piechart_drilldown` (`id`, `brand`, `county`, `percentage`) VALUES
(1, 'withdrawn cases', 'KITUI', '20.00%'),
(2, 'withdrawn cases', 'MOMBASA', '20.00%'),
(3, 'convicted cases', 'MERU', '10.00%'),
(4, 'convicted cases', 'EMBU', '15.00%'),
(5, 'unresolved cases', 'THARAKANITHI', '7.5.00%'),
(6, 'withdrawn cases', 'NYAMIRA', '20.00%'),
(7, 'unresolved cases', 'KWALE', '7.5%');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `date` date NOT NULL,
  PRIMARY KEY (`county_id`,`survey_id`,`indicator_id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sectors`
--

CREATE TABLE IF NOT EXISTS `sectors` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sector` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `status` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `date_modified` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `sectors`
--

INSERT INTO `sectors` (`id`, `sector`, `description`, `status`, `date`, `date_modified`) VALUES
(1, 'NGEC', 'NGEC Full access  to the system', 'Approved', '2015-02-11', '0000-00-00'),
(2, 'Health', 'health services', 'Approved', '2015-02-11', '0000-00-00'),
(3, 'Police', 'police service', 'Approved', '2015-02-11', '0000-00-00'),
(4, 'Judiciary', 'Judiciary sector ', 'Approved', '2015-02-11', '0000-00-00'),
(5, 'Prosecution', 'prrosecution service', 'Approved', '2015-02-11', '0000-00-00'),
(6, 'Education', 'Education sector', 'Approved', '2015-02-11', '0000-00-00'),
(7, 'Community', 'Community and social services', 'Approved', '2015-02-11', '0000-00-00'),
(8, 'Default ', 'Default', 'Approved', '2015-02-11', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `socialservices_aggregates`
--

CREATE TABLE IF NOT EXISTS `socialservices_aggregates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `county_id` int(10) NOT NULL,
  `survey_id` int(10) NOT NULL,
  `indicator_id` int(10) NOT NULL,
  `aggregate` int(100) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`county_id`,`survey_id`,`indicator_id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE IF NOT EXISTS `surveys` (
  `survey_id` int(10) NOT NULL AUTO_INCREMENT,
  `survey_period` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`survey_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`survey_id`, `survey_period`, `description`, `date`) VALUES
(1, 'Jan to March', '', '0000-00-00'),
(2, 'July to Aug', '', '0000-00-00');

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
(3, 'Guest', 'user', '', '8', 'guest', '62ef34f4e7b271b4ccdb5cbeb1546fd5', 'mainasteve@gmail.com', 3, '2015-02-03 08:31:59'),
(12, 'Judiciary', 'Admin', '', '4', 'admin', '62ef34f4e7b271b4ccdb5cbeb1546fd5', 'info@ardech.co.ke', 2, '2015-02-20 14:27:41'),
(11, 'super', 'Admin', '', '1', 'superadmin', '62ef34f4e7b271b4ccdb5cbeb1546fd5', 'data@example.com', 1, '2015-02-19 11:54:31'),
(14, 'test ', 'user', '', '4', 'judiciary', '62ef34f4e7b271b4ccdb5cbeb1546fd5', 'benardkkoech@gmail.com', 2, '2015-01-29 14:29:29'),
(15, 'test ', 'user', '', '5', 'prosecution', '62ef34f4e7b271b4ccdb5cbeb1546fd5', 'info@ardech.co.ke', 2, '2015-02-20 14:27:41'),
(20, '', 'Admin', '', '3', 'police', '62ef34f4e7b271b4ccdb5cbeb1546fd5', 'police@gmail.com', 2, '2015-03-13 11:15:27'),
(19, '', 'Ngetich', '', '2', 'martin', '62ef34f4e7b271b4ccdb5cbeb1546fd5', 'martinge@gmail.com', 2, '2015-03-12 14:34:23');

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
(1, 'Super Admin', 'general access', '2015-01-23 00:00:00'),
(2, 'Admin', 'only reports aceess of sector 2', '2015-02-03 00:00:00'),
(3, 'Guest', 'Normal user', '2015-01-23 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
