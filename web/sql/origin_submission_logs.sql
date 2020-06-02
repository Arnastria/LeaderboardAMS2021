-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2019 at 04:56 PM
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
-- Table structure for table `origin_submission_logs`
--

CREATE TABLE `origin_submission_logs` (
  `UploadKey` varchar(11) DEFAULT NULL,
  `GroupName` varchar(20) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `mime` varchar(50) DEFAULT NULL,
  `size` bigint(20) UNSIGNED DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `data` longblob NOT NULL,
  `TesterAccuracy` double(5,2) NOT NULL,
  `TesterPrecision` double(5,2) NOT NULL,
  `TesterRecall` double(5,2) NOT NULL,
  `TesterF1Score` double(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;