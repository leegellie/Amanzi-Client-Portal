-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Host: db708532307.db.1and1.com
-- Generation Time: Jan 15, 2018 at 12:32 PM
-- Server version: 5.5.58-0+deb7u1-log
-- PHP Version: 5.4.45-0+deb7u11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db708532307`
--

-- --------------------------------------------------------

--
-- Table structure for table `marbgran_comp`
--

CREATE TABLE IF NOT EXISTS `marbgran_comp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `marbgran_comp`
--

INSERT INTO `marbgran_comp` (`id`, `company`) VALUES
(1, 'AllStone'),
(2, 'Bramati'),
(3, 'Cosmos'),
(4, 'Marva'),
(5, 'MSI'),
(6, 'OHM'),
(7, 'Stone Basyx');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
