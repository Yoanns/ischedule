-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 14, 2012 at 01:24 PM
-- Server version: 5.5.22
-- PHP Version: 5.4.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shiftscheduler`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `IdAddr` int(11) NOT NULL AUTO_INCREMENT,
  `Street` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `City` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `State` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ZipCode` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`IdAddr`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `IdPers` int(11) NOT NULL,
  `Login` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Pwd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`IdPers`),
  KEY `IdPers` (`IdPers`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_spr`
--

CREATE TABLE IF NOT EXISTS `admin_spr` (
  `IdPers` int(11) NOT NULL,
  `Login` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Pwd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`IdPers`),
  KEY `IdPers` (`IdPers`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `IdDept` int(11) NOT NULL AUTO_INCREMENT,
  `NameDept` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Kitchen, Dining Room, ...',
  `IdLoc` int(11) NOT NULL COMMENT 'NLI, Penn Stater, ...',
  PRIMARY KEY (`IdDept`),
  UNIQUE KEY `IdDept` (`IdDept`,`IdLoc`),
  UNIQUE KEY `IdDept_2` (`IdDept`,`NameDept`,`IdLoc`),
  KEY `IdLoc` (`IdLoc`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `IdPers` int(11) NOT NULL,
  `Login` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Pwd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`IdPers`),
  KEY `IdPers` (`IdPers`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `IdEvt` int(11) NOT NULL AUTO_INCREMENT,
  `NameEvt` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `GuestEvt` int(6) NOT NULL,
  `DescEvt` text COLLATE utf8mb4_unicode_ci,
  `DayEvt` date NOT NULL,
  `BegEvt` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EndEvt` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdLoc` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdEvt`),
  KEY `IdLoc` (`IdLoc`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friday`
--

CREATE TABLE IF NOT EXISTS `friday` (
  `IdFri` int(11) NOT NULL AUTO_INCREMENT,
  `IdPers` int(11) NOT NULL,
  `BegFri` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EndFri` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`IdFri`,`IdPers`),
  KEY `IdAvb` (`IdPers`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `IdLoc` int(11) NOT NULL AUTO_INCREMENT,
  `NameLoc` varchar(80) NOT NULL,
  `IdAddr` int(11) NOT NULL,
  PRIMARY KEY (`IdLoc`),
  KEY `IdAddr` (`IdAddr`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `IdMsg` int(11) NOT NULL AUTO_INCREMENT,
  `ToEmp` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FromEmp` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Subject` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Read` tinyint(1) NOT NULL,
  `Deleted` tinyint(1) NOT NULL,
  `DateSent` datetime NOT NULL,
  PRIMARY KEY (`IdMsg`),
  KEY `ToEmp` (`ToEmp`,`FromEmp`),
  KEY `FromEmp` (`FromEmp`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `monday`
--

CREATE TABLE IF NOT EXISTS `monday` (
  `IdMon` int(11) NOT NULL AUTO_INCREMENT,
  `IdPers` int(11) NOT NULL,
  `BegMon` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EndMon` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`IdMon`,`IdPers`),
  KEY `IdAvb` (`IdPers`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `IdPers` int(11) NOT NULL,
  `Email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FirstName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LastName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DOB` date NOT NULL,
  `Phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FirstDay` date NOT NULL,
  `Avatar` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `WorkHrs` int(3) NOT NULL,
  `IdPost` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdPers`),
  KEY `IdPost` (`IdPost`),
  KEY `IdPost_2` (`IdPost`),
  KEY `IdAvt` (`Avatar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `IdPost` int(11) NOT NULL AUTO_INCREMENT,
  `LabPost` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdDept` int(11) NOT NULL,
  PRIMARY KEY (`IdPost`),
  UNIQUE KEY `LabPost` (`LabPost`),
  KEY `IdDept` (`IdDept`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE IF NOT EXISTS `request` (
  `IdPers` int(11) NOT NULL,
  `TypeReq` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DayReq` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `BegReq` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `EndReq` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `TimeReqSub` datetime NOT NULL,
  `Status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Pending, Approved, Denied',
  PRIMARY KEY (`IdPers`,`DayReq`),
  KEY `IdPers` (`IdPers`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `saturday`
--

CREATE TABLE IF NOT EXISTS `saturday` (
  `IdSat` int(11) NOT NULL AUTO_INCREMENT,
  `IdPers` int(11) NOT NULL,
  `BegSat` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EndSat` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`IdSat`,`IdPers`),
  KEY `IdAvb` (`IdPers`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE IF NOT EXISTS `schedules` (
  `IdPers` int(11) NOT NULL,
  `Day` date NOT NULL,
  `BegShift` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EndShift` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`IdPers`,`Day`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE IF NOT EXISTS `skills` (
  `IdPers` int(11) NOT NULL,
  `Skill` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`IdPers`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sunday`
--

CREATE TABLE IF NOT EXISTS `sunday` (
  `IdSun` int(11) NOT NULL AUTO_INCREMENT,
  `IdPers` int(11) NOT NULL,
  `BegSun` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EndSun` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`IdSun`,`IdPers`),
  KEY `IdPers` (`IdPers`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thursday`
--

CREATE TABLE IF NOT EXISTS `thursday` (
  `IdThurs` int(11) NOT NULL AUTO_INCREMENT,
  `IdPers` int(11) NOT NULL,
  `BegThurs` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EndThurs` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`IdThurs`,`IdPers`),
  KEY `IdAvb` (`IdPers`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tuesday`
--

CREATE TABLE IF NOT EXISTS `tuesday` (
  `IdTues` int(11) NOT NULL AUTO_INCREMENT,
  `IdPers` int(11) NOT NULL,
  `BegTues` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EndTues` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`IdTues`,`IdPers`),
  KEY `IdAvb` (`IdPers`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wednesday`
--

CREATE TABLE IF NOT EXISTS `wednesday` (
  `IdWed` int(11) NOT NULL AUTO_INCREMENT,
  `IdPers` int(11) NOT NULL,
  `BegWed` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EndWed` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`IdWed`,`IdPers`),
  KEY `IdAvb` (`IdPers`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_2` FOREIGN KEY (`IdPers`) REFERENCES `person` (`IdPers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `admin_spr`
--
ALTER TABLE `admin_spr`
  ADD CONSTRAINT `admin_spr_ibfk_2` FOREIGN KEY (`IdPers`) REFERENCES `person` (`IdPers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_2` FOREIGN KEY (`IdLoc`) REFERENCES `location` (`IdLoc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`IdPers`) REFERENCES `person` (`IdPers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`IdLoc`) REFERENCES `location` (`IdLoc`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `friday`
--
ALTER TABLE `friday`
  ADD CONSTRAINT `friday_ibfk_2` FOREIGN KEY (`IdPers`) REFERENCES `person` (`IdPers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `location_ibfk_4` FOREIGN KEY (`IdAddr`) REFERENCES `address` (`IdAddr`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `monday`
--
ALTER TABLE `monday`
  ADD CONSTRAINT `monday_ibfk_2` FOREIGN KEY (`IdPers`) REFERENCES `person` (`IdPers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `person_ibfk_2` FOREIGN KEY (`IdPost`) REFERENCES `post` (`IdPost`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`IdDept`) REFERENCES `department` (`IdDept`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`IdPers`) REFERENCES `person` (`IdPers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `saturday`
--
ALTER TABLE `saturday`
  ADD CONSTRAINT `saturday_ibfk_2` FOREIGN KEY (`IdPers`) REFERENCES `person` (`IdPers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_2` FOREIGN KEY (`IdPers`) REFERENCES `person` (`IdPers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_ibfk_2` FOREIGN KEY (`IdPers`) REFERENCES `person` (`IdPers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sunday`
--
ALTER TABLE `sunday`
  ADD CONSTRAINT `sunday_ibfk_2` FOREIGN KEY (`IdPers`) REFERENCES `person` (`IdPers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `thursday`
--
ALTER TABLE `thursday`
  ADD CONSTRAINT `thursday_ibfk_2` FOREIGN KEY (`IdPers`) REFERENCES `person` (`IdPers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tuesday`
--
ALTER TABLE `tuesday`
  ADD CONSTRAINT `tuesday_ibfk_2` FOREIGN KEY (`IdPers`) REFERENCES `person` (`IdPers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wednesday`
--
ALTER TABLE `wednesday`
  ADD CONSTRAINT `wednesday_ibfk_2` FOREIGN KEY (`IdPers`) REFERENCES `person` (`IdPers`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
