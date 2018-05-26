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
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `class` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `group` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `price_1` varchar(11) COLLATE latin1_general_ci NOT NULL,
  `price_2` varchar(11) COLLATE latin1_general_ci NOT NULL,
  `price_3` varchar(11) COLLATE latin1_general_ci NOT NULL,
  `notes` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `discount_1` int(11) NOT NULL,
  `discount_2` int(11) NOT NULL,
  `discount_3` int(11) NOT NULL,
  `discount_all` int(11) NOT NULL,
  `logo` varchar(100) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=44 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `brand`, `class`, `group`, `price_1`, `price_2`, `price_3`, `notes`, `discount_1`, `discount_2`, `discount_3`, `discount_all`, `logo`) VALUES
(1, 'Cosmos', 'Standard', 'S', '', '', '', '', 0, 0, 0, 0, ''),
(2, 'Caesarstone', 'Classico', 'A', 'NA', '22', '24', '', 0, 0, 0, 0, ''),
(3, 'Caesarstone', 'Classico', 'B', 'NA', '25', '27', '', 0, 0, 0, 0, ''),
(4, 'Caesarstone', 'Classico', 'C', 'NA', '35', '38', '', 0, 0, 0, 0, ''),
(5, 'Caesarstone', 'Classico', 'D', 'NA', '38', '40', '', 0, 0, 0, 0, ''),
(6, 'Caesarstone', 'Classico', 'E', 'NA', '43', '49', '', 0, 0, 0, 0, ''),
(7, 'Caesarstone', 'Jumbo', 'A', 'NA', '23', '25', '', 0, 0, 0, 0, ''),
(8, 'Caesarstone', 'Jumbo', 'B', 'NA', '25', '27', '', 0, 0, 0, 0, ''),
(9, 'Caesarstone', 'Jumbo', 'C', 'NA', '36', '38', '', 0, 0, 0, 0, ''),
(10, 'Caesarstone', 'Jumbo', 'D', 'NA', '40', '42', '', 0, 0, 0, 0, ''),
(11, 'Caesarstone', 'Motivo', 'M', '', '', '', '', 0, 0, 0, 0, ''),
(12, 'Caesarstone', 'Concetto', 'C', '', '', '', '', 0, 0, 0, 0, ''),
(13, 'MSI', 'Standard', '1', 'NA', '9', '10', '', 0, 0, 0, 0, ''),
(14, 'MSI', 'Standard', '2', 'NA', '10', '12', '', 0, 0, 0, 0, ''),
(15, 'MSI', 'Standard', '3', 'NA', '13', '15', '', 0, 0, 0, 0, ''),
(16, 'MSI', 'Standard', '4', 'NA', '14', '17', '', 0, 0, 0, 0, ''),
(17, 'MSI', 'Standard', '5', 'NA', '18', '18', '', 0, 0, 0, 0, ''),
(18, 'MSI', 'Standard', '6', 'NA', '20', '23', '', 0, 0, 0, 0, ''),
(19, 'MSI', 'Concrete', 'C', '', '', '', '', 0, 0, 0, 0, ''),
(20, 'Cambria', 'Standard', 'S', '27', '27', '28', '', 0, 0, 0, 0, ''),
(21, 'Cambria', 'Jumbo', 'J', '27', '27', '28', '', 0, 0, 0, 0, ''),
(22, 'Cambria', 'Luxury', 'L', '37', '39', '39', '', 0, 0, 0, 0, ''),
(23, 'Silestone', 'Standard', '1', '13', '16', '21', '', 0, 0, 0, 0, ''),
(24, 'Silestone', 'Standard', '2', '15', '20', '25', '', 0, 0, 0, 0, ''),
(25, 'Silestone', 'Standard', '3', '18', '21', '27', '', 0, 0, 0, 0, ''),
(26, 'Silestone', 'Standard', '4', '18', '26', '34', '', 0, 0, 0, 0, ''),
(27, 'Silestone', 'Standard', '5', '19', '28', '36', '', 0, 0, 0, 0, ''),
(28, 'Silestone', 'Standard', '6', '26', '35', '41', '', 0, 0, 0, 0, ''),
(29, 'Silestone', 'Jumbo', '1', '13', '16', '21', '', 0, 0, 0, 0, ''),
(30, 'Silestone', 'Jumbo', '2', '15', '20', '25', '', 0, 0, 0, 0, ''),
(31, 'Silestone', 'Jumbo', '3', '18', '21', '27', '', 0, 0, 0, 0, ''),
(32, 'Silestone', 'Jumbo', '4', '18', '26', '34', '', 0, 0, 0, 0, ''),
(33, 'Silestone', 'Jumbo', '5', '19', '28', '36', '', 0, 0, 0, 0, ''),
(34, 'Silestone', 'Jumbo', '6', '25', '35', '41', '', 0, 0, 0, 0, ''),
(35, 'Silestone', 'Suede', '1', '14', '18', '23', '', 0, 0, 0, 0, ''),
(36, 'Silestone', 'Suede', '2', '17', '22', '28', '', 0, 0, 0, 0, ''),
(37, 'Silestone', 'Suede', '3', '20', '24', '30', '', 0, 0, 0, 0, ''),
(38, 'Silestone', 'Suede', '4', '20', '29', '38', '', 0, 0, 0, 0, ''),
(39, 'Silestone', 'Suede - Jumbo', '1', '14', '18', '23', '', 0, 0, 0, 0, ''),
(40, 'Silestone', 'Suede - Jumbo', '2', '14', '22', '28', '', 0, 0, 0, 0, ''),
(41, 'Silestone', 'Suede - Jumbo', '3', '20', '24', '30', '', 0, 0, 0, 0, ''),
(42, 'Silestone', 'Suede - Jumbo', '4', '20', '29', '38', '', 0, 0, 0, 0, ''),
(43, 'Silestone', 'Suede - Jumbo', '5', '21', '31', '40', '', 0, 0, 0, 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
