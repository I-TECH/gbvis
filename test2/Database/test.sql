-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2015 at 01:18 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`name`, `email`) VALUES
('helloworld', 'helloworld@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `health_facilities`
--

CREATE TABLE IF NOT EXISTS `health_facilities` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `FacilityCode` int(10) NOT NULL,
  `FacilityName` varchar(100) NOT NULL,
  `County` varchar(100) NOT NULL,
  `SubCounty` varchar(100) NOT NULL,
  `Division` varchar(100) NOT NULL,
  `TypeOfFacility` varchar(100) NOT NULL,
  `Owner` varchar(100) NOT NULL,
  `Location` varchar(100) NOT NULL,
  `SubLocation` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `health_facilities`
--

INSERT INTO `health_facilities` (`ID`, `FacilityCode`, `FacilityName`, `County`, `SubCounty`, `Division`, `TypeOfFacility`, `Owner`, `Location`, `SubLocation`) VALUES
(1, 11289, 'Coast Province General Hospital', 'Mombasa', 'Mvita', 'Island', 'Provincial General Hospital', 'Ministry of Health', 'Tononoka', 'Tononoka'),
(2, 11522, 'Likoni District Hospital', 'Mombasa', 'Likoni', 'Likoni', 'District Hospital', 'Ministry of Health', 'Likoni', 'Likoni'),
(3, 11592, 'Mbuta Model Health Centre', 'Mombasa', 'Likoni', 'Longo', 'Dispensary', 'Ministry of Health', 'Mtongwe', 'Mbuta'),
(4, 18431, 'Marimani CDF Dispensary', 'Mombasa', 'Kisauni', 'Kisauni', 'Dispensary', 'Ministry of Health', 'Mwakirunge', 'Mwakirunge'),
(5, 11620, 'Miritini CDF Dispensary', 'Mombasa', 'Changamwe', 'Jomvu', 'Dispensary', 'Ministry of Health', 'Miritini', 'Miritini'),
(6, 18347, 'Kmtc Mombasa Students Clinic', 'Mombasa', 'Mvita', 'Island', 'Medical Clinic', 'Ministry of Health', 'Tononoka', 'Tononoka'),
(7, 18210, 'Mlaleo Health Centre (MOH)', 'Mombasa', 'Kisauni', 'Kisauni', 'Health Centre', 'Ministry of Health', 'Kisauni', 'Mlaleo'),
(8, 11640, 'Moi Airport Dispensary', 'Mombasa', 'Changamwe', 'Changamwe', 'Dispensary', 'Ministry of Health', 'Portreitz', 'Portreitz'),
(9, 19606, 'Mrima CDF Health Cenre', 'Mombasa', 'Likoni', 'Likoni', 'Health Centre', 'Ministry of Health', 'Likoni', 'Likoni'),
(10, 11510, 'Lady Grigg Maternity Hospital (CPGH)', 'Mombasa', 'Mvita', 'Island', 'Other Hospital', 'Ministry of Health', 'Tononoka', 'Tononoka'),
(11, 11303, 'King''orani Prison Dispensary', 'Mombasa', 'Mvita', 'Island', 'Dispensary', 'Ministry of Health', 'Majengo', 'King''Orani'),
(12, 11436, 'Jomvu Model Health Centre', 'Mombasa', 'Changamwe', 'Changamwe', 'Health Centre', 'Ministry of Health', 'Miritini', 'Kwa Jomvu'),
(13, 20491, 'Junda Dispensary', 'Mombasa', 'Kisauni', 'Kisauni', 'Dispensary', 'Ministry of Health', 'Kisauni', 'Magogoni'),
(14, 17233, 'Maweni CDF Dispensary (Kongowea)', 'Mombasa', 'Kisauni', 'Kisauni', 'Dispensary', 'Ministry of Health', 'Kongowea', 'Maweni'),
(15, 11254, 'Bokole CDF Dispensary', 'Mombasa', 'Changamwe', 'Changamwe', 'Dispensary', 'Ministry of Health', 'Airport', 'Bokole'),
(16, 11723, 'Nys Dispensary (Kilindini)', 'Mombasa', 'Likoni', 'Longo', 'Dispensary', 'Ministry of Health', 'Mtongwe', 'Mtongwe'),
(17, 11740, 'Port Reitz District Hospital', 'Mombasa', 'Changamwe', 'Changamwe', 'District Hospital', 'Ministry of Health', 'Portreitz', 'Portreitz'),
(18, 18211, 'Railway Dispensary', 'Mombasa', 'Mvita', 'Mvita', 'Dispensary', 'Ministry of Health', 'Shimanzi', 'Shimanzi'),
(19, 11397, 'Shimo Borstal Dispensary (GK Prison)', 'Mombasa', 'Kisauni', 'Kisauni', 'Dispensary', 'Ministry of Health', 'Bamburi', 'Shanzu'),
(20, 11393, 'Shimo La Tewa Annex Dispensary (GK Prison)', 'Mombasa', 'Kisauni', 'Kisauni', 'Dispensary', 'Ministry of Health', 'Bamburi', 'Utange'),
(21, 11395, 'Shimo-La Tewa Health Centre (GK Prison)', 'Mombasa', 'Kisauni', 'Kisauni', 'Health Centre', 'Ministry of Health', 'Bamburi', 'Shanzu'),
(22, 11831, 'State House Dispensary (Mombasa)', 'Mombasa', 'Mvita', 'Island', 'Dispensary', 'Ministry of Health', 'Ganjoni', 'Kizingo'),
(23, 11861, 'Tudor District Hospital (Mombasa)', 'Mombasa', 'Mvita', 'Island', 'Health Centre', 'Ministry of Health', 'Tudor', 'Tudor Estate');

-- --------------------------------------------------------

--
-- Table structure for table `judiciary_count`
--

CREATE TABLE IF NOT EXISTS `judiciary_count` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Indicator` varchar(100) NOT NULL,
  `County` varchar(100) NOT NULL,
  `subCounty` varchar(100) NOT NULL,
  `tally` int(10) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `judiciary_count`
--

INSERT INTO `judiciary_count` (`id`, `Indicator`, `County`, `subCounty`, `tally`, `date`) VALUES
(1, 'Number of SGBV cases', 'Nairobi', 'westlands', 5000, '2002-11-15'),
(2, 'Proportion of prosecuted cases that were withdrawn', 'Nairobi', 'westlands', 5000, '2002-11-15'),
(3, 'Proportion of cases that were convicted', 'Nairobi', 'westlands', 5000, '2002-11-15'),
(4, 'Average time to conclude cases', 'Nairobi', 'westlands', 5000, '2002-11-15');

-- --------------------------------------------------------

--
-- Table structure for table `mytable`
--

CREATE TABLE IF NOT EXISTS `mytable` (
  `name` varchar(100) NOT NULL,
  `extension` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mytable`
--

INSERT INTO `mytable` (`name`, `extension`, `email`) VALUES
('Jon Smith ', '2001', 'jsmith@domain.com'),
('Clint Jones', '2002', 'cjones@domain.com'),
('Frank Peterson', '2003', 'fpeterson@domain.com');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(8,5) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
