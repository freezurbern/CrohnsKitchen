-- phpMyAdmin SQL Dump
-- version 4.3.3
-- http://www.phpmyadmin.net
--
-- Host: ckitchen.db
-- Generation Time: Feb 04, 2016 at 05:17 PM
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
  `fid` int(11) NOT NULL,
  `fname` varchar(254) NOT NULL,
  `fgroup` varchar(24) NOT NULL,
  `addby` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE IF NOT EXISTS `ratings` (
  `rid` int(11) NOT NULL,
  `score` char(1) DEFAULT '0',
  `foodid` int(11) NOT NULL,
  `rateby` int(11) NOT NULL,
  `dateconsume` datetime 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL,
  `email` varchar(190) NOT NULL UNIQUE,
  `passhash` varchar(254) NOT NULL,
  `regdate` datetime ,
  `verifykey` char(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`fid`), ADD KEY `FK_foods_addby` (`addby`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rid`), ADD KEY `FK_ratings_rateby` (`rateby`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `foods`
--
ALTER TABLE `foods`
ADD CONSTRAINT `FK_foods_addby` FOREIGN KEY (`addby`) REFERENCES `users` (`uid`);

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
ADD CONSTRAINT `FK_ratings_rateby` FOREIGN KEY (`rateby`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;


INSERT INTO `users` (`uid`, `email`, `passhash`, `regdate`, `verifykey`) VALUES
(0, 'admin@freezurbern.com', '0', '2016-02-08 00:00:00', '000');

INSERT INTO `foods` (`fid`, `fname`, `fgroup`, `addby`) VALUES
(0, 'None', 'None', 0),
(1, 'Pizza', 'Oil', 0),
(2, 'Pepperoni', 'Oil', 0),
(3, 'Milk Shake', 'Dairy', 0),
(4, 'French Fries', 'Oil', 0),
(5, 'Toast', 'Grain', 0),
(6, 'Garlic Bread', 'Grain', 0),
(7, 'Apple Juice', 'Fruit', 0),
(8, 'Water', 'Liquid', 0),
(9, 'CocaCola', 'Soda', 0),
(10, 'Mtn Dew', 'Soda', 0),
(14, 'Pasta Sauce', 'Oil', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;