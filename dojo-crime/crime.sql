-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jul 20, 2014 at 02:18 AM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `crime`
--

-- --------------------------------------------------------

--
-- Table structure for table `incidents`
--

CREATE TABLE `incidents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `description` varchar(415) DEFAULT NULL,
  `user_id` varchar(45) DEFAULT NULL,
  `created_at` bigint(20) DEFAULT NULL,
  `updated_at` bigint(20) DEFAULT NULL,
  `happened` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `incidents`
--

INSERT INTO `incidents` (`id`, `title`, `description`, `user_id`, `created_at`, `updated_at`, `happened`) VALUES
(33, 'bone stolen', 'someone took my bone. i was going to chew on that one for a few hours actually. this is a disaster.', 'winston@gmail.com', 1405815380, 1405815380, 1405720800),
(34, 'matt stephenson razor attack', 'An extremely high Matthew Stephenson attacks an innocent Brazilian man with a sharp razor at around 2AM.', 'tv@codingdojo.com', 1405815428, 1405815428, 1405548000),
(35, 'binder clip explosion', 'someone flexed a binder clip and let it fly. the tension caused it to violently contract and chomp down on a stack of innocent papers.', 'jason@gmail.com', 1405815491, 1405815491, 1405202400);

-- --------------------------------------------------------

--
-- Table structure for table `sitings`
--

CREATE TABLE `sitings` (
  `users_id` varchar(45) NOT NULL,
  `incidents_id` int(11) NOT NULL,
  `created_at` bigint(20) DEFAULT NULL,
  `updated_at` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`users_id`,`incidents_id`),
  KEY `fk_users_has_incidents_incidents1_idx` (`incidents_id`),
  KEY `fk_users_has_incidents_users_idx` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sitings`
--

INSERT INTO `sitings` (`users_id`, `incidents_id`, `created_at`, `updated_at`) VALUES
('jason@gmail.com', 35, 1405815491, 1405815491),
('tv@codingdojo.com', 33, 1405815438, 1405815438),
('tv@codingdojo.com', 34, 1405815428, 1405815428),
('winston@gmail.com', 33, 1405815380, 1405815380);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `created_at` bigint(20) DEFAULT NULL,
  `updated_at` bigint(20) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `created_at`, `updated_at`, `password`, `email`) VALUES
(7, 'winston', 'lincoln', 1405815351, 1405815351, 'password', 'winston@gmail.com'),
(8, 'trey', 'villafane', 1405815415, 1405815415, 'password', 'tv@codingdojo.com'),
(9, 'jason', 'li', 1405815463, 1405815463, 'password', 'jason@gmail.com');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sitings`
--
ALTER TABLE `sitings`
  ADD CONSTRAINT `fk_users_has_incidents_incidents1` FOREIGN KEY (`incidents_id`) REFERENCES `incidents` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;