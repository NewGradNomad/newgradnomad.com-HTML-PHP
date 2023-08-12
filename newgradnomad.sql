-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2023 at 08:10 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newgradnomad`
--
CREATE DATABASE IF NOT EXISTS `newgradnomad` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `newgradnomad`;

-- --------------------------------------------------------
GRANT SELECT, INSERT, DELETE, UPDATE ON newgradnomad.* TO ngn@localhost IDENTIFIED BY 'password';

--
-- Table structure for table `joblistings`
--

CREATE TABLE IF NOT EXISTS `joblistings` (
  `listingID` char(10) NOT NULL,
  `companyName` varchar(256) NOT NULL,
  `positionName` varchar(256) NOT NULL,
  `positionType` varchar(256) NOT NULL,
  `primaryTag` varchar(256) NOT NULL,
  `keywords` varchar(512) NOT NULL,
  `24hrSupport` tinyint(1) NOT NULL,
  `highlightOrange` tinyint(1) NOT NULL,
  `pin24Hours` tinyint(1) NOT NULL,
  `pin1week` tinyint(1) NOT NULL,
  `pin1month` tinyint(1) NOT NULL,
  `url` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `jobDescription` varchar(1028) NOT NULL,
  `postedDate` datetime NOT NULL,
  PRIMARY KEY (`listingID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
