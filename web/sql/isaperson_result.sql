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
-- Table structure for table `isaperson_result`
--

CREATE TABLE `isaperson_result` (
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
-- Dumping data for table `isaperson_result`
--

INSERT INTO `isaperson_result` (`ID`, `Uploadkey`, `Groupname`, `Tester Accuracy`, `Tester Precision`, `Tester Recall`, `Tester F1-Score`, `Complete Set Accuracy`, `Complete Set Precision`, `Complete Set Recall`, `Complete Set F1-Score`) VALUES
(1, '70388', 'Kelompok 1', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(2, '18964', 'Kelompok 2', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(3, '81883', 'Kelompok 3', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(4, '26395', 'Kelompok 4', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(5, '98805', 'Kelompok 5', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(6, '76442', 'Kelompok 6', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(7, '39099', 'Kelompok 7', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(8, '24963', 'Kelompok 8', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(9, '54891', 'Kelompok 9', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;