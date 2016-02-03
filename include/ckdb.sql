-- phpMyAdmin SQL Dump
-- version 4.3.3
-- http://www.phpmyadmin.net
--
-- Host: ckitchen.db
-- Generation Time: Feb 03, 2016 at 06:31 PM
-- Server version: 10.0.21-MariaDB-1~trusty
-- PHP Version: 5.6.16-nfsn1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ckdb`
--
CREATE DATABASE IF NOT EXISTS `ckdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ckdb`;

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

DROP TABLE IF EXISTS `foods`;
CREATE TABLE IF NOT EXISTS `foods` (
  `fID` int(11) NOT NULL,
  `fname` varchar(254) NOT NULL,
  `fgroup` varchar(24) NOT NULL,
  `addby` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `foods`
--

TRUNCATE TABLE `foods`;
-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE IF NOT EXISTS `ratings` (
  `rID` int(11) NOT NULL,
  `score` char(1) DEFAULT '0',
  `foodID` int(11) NOT NULL,
  `rateby` int(11) NOT NULL,
  `dateconsume` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `ratings`
--

TRUNCATE TABLE `ratings`;
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `uID` int(11) NOT NULL,
  `email` varchar(254) NOT NULL,
  `passhash` varchar(254) NOT NULL,
  `regdate` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Truncate table before insert `users`
--

TRUNCATE TABLE `users`;
--
-- Indexes for dumped tables
--

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`fID`), ADD KEY `FK_foods_addby` (`addby`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rID`), ADD KEY `FK_ratings_rateby` (`rateby`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `fID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uID` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `foods`
--
ALTER TABLE `foods`
ADD CONSTRAINT `FK_foods_addby` FOREIGN KEY (`addby`) REFERENCES `users` (`uID`);

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
ADD CONSTRAINT `FK_ratings_rateby` FOREIGN KEY (`rateby`) REFERENCES `users` (`uID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
