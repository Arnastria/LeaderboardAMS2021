-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2019 at 07:32 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `anamedsos`
--

-- --------------------------------------------------------

--
-- Table structure for table `origin_result`
--

CREATE TABLE `origin_result` (
  `ID` int(5) DEFAULT NULL,
  `Uploadkey` varchar(11) DEFAULT NULL,
  `Groupname` varchar(20) DEFAULT NULL,
  `Tester Accuracy` double(5,2) DEFAULT NULL,
  `Tester Precision` double(5,2) DEFAULT NULL,
  `Tester Recall` double(5,2) DEFAULT NULL,
  `Tester F1-Score` double(5,2) DEFAULT NULL,
  `Complete Set Accuracy` double(5,2) DEFAULT NULL,
  `Complete Set Precision` double(5,2) DEFAULT NULL,
  `Complete Set Recall` double(5,2) DEFAULT NULL,
  `Complete Set F1-Score` double(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `origin_result`
--

INSERT INTO `origin_result` (`ID`, `Uploadkey`, `Groupname`, `Tester Accuracy`, `Tester Precision`, `Tester Recall`, `Tester F1-Score`, `Complete Set Accuracy`, `Complete Set Precision`, `Complete Set Recall`, `Complete Set F1-Score`) VALUES
(1, '70388', 'sabeb', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(2, '18964', 'NaiveBayes', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(3, '81883', 'CrazyHungryAsians', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(4, '26395', 'Ikan Lele', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(5, '98805', 'Pengen Lulus', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(6, '76442', 'Bosan di Rumah', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(7, '39099', 'Bebas', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(8, '24963', 'terserah~', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(9, '98268', 'Renae Alcock', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(10, '76126', 'AN', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(11, '24671', 'Isomer', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(12, '54891', 'Tester', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
