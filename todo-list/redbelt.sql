-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Aug 03, 2014 at 03:35 AM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `redbelt`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) DEFAULT NULL,
  `d` varchar(80) DEFAULT NULL,
  `time` bigint(20) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `created_at` bigint(20) DEFAULT NULL,
  `updated_at` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idx` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `email`, `d`, `time`, `status`, `created_at`, `updated_at`) VALUES
(5, 'david@brazil.com', 'work in financial industry', 1900020710, 'pending', 1407020710, 1407020710),
(6, 'david@brazil.com', 'todays activity', 1407026183, 'pending', 1407020710, 1407020710),
(7, 'david@brazil.com', 'be brazilian', 7, '', 1407026507, 1407026507),
(8, 'david@brazil.com', 'be brazilian', 7, 'pending', 1407026575, 1407026575),
(9, 'david@brazil.com', 'say hi to mom', 1900020710, 'not started', 1407026667, 1407026667),
(10, 'david@brazil.com', 'eat arbys', 1407026183, 'not started', 1407026687, 1407026687),
(11, 'david@brazil.com', 'piece of paper', 1406991600, 'sorry', 1407027114, 1407027114),
(12, 'curtis@chin.com', 'eat a chinese food', 1407006000, 'not started', 1407027802, 1407027802),
(13, 'curtis@chin.com', 'eat again chinese', 1407092400, 'not started', 1407027819, 1407027819),
(16, 'curtis@chin.com', '3', 1409238000, '3', 1407029626, 1407029626);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `created_at` bigint(20) DEFAULT NULL,
  `updated_at` bigint(20) DEFAULT NULL,
  `dob` varchar(44) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `password`, `created_at`, `updated_at`, `dob`) VALUES
(4, 'david', 'brazilian', 'david@brazil.com', 'asdfasdf', 1407020710, 1407020710, '1/1/1975'),
(5, 'curtis', 'chin', 'curtis@chin.com', 'asdfasdf', 1407025007, 1407025007, '0.000900090009000900');
