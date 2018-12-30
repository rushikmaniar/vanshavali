-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 28, 2018 at 07:56 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vanshavali`
--

-- --------------------------------------------------------

--
-- Table structure for table `family_trees`
--

DROP TABLE IF EXISTS `family_trees`;
CREATE TABLE IF NOT EXISTS `family_trees` (
  `family_tree_id` int(11) NOT NULL AUTO_INCREMENT,
  `family_tree_name` varchar(255) NOT NULL,
  `family_tree_admins` text NOT NULL,
  PRIMARY KEY (`family_tree_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Family Tree List table';

-- --------------------------------------------------------

--
-- Table structure for table `users_master`
--

DROP TABLE IF EXISTS `users_master`;
CREATE TABLE IF NOT EXISTS `users_master` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'user unique id',
  `user_parent_id` int(11) NOT NULL COMMENT 'parent user id',
  `user_family_tree_id` int(11) NOT NULL COMMENT 'users in which family tree',
  `user_email_id` varchar(255) NOT NULL COMMENT 'username or email ',
  `user_password` varchar(255) NOT NULL COMMENT 'users password for login',
  `user_gender` varchar(10) NOT NULL COMMENT 'MALE,FEMALE,OTHER',
  `user_DOB` date NOT NULL COMMENT 'user DOB , age from DOB',
  `user_phone_no` bigint(10) NOT NULL COMMENT 'users_phone_no',
  `user_address` text,
  `is_allow_login` tinyint(1) NOT NULL COMMENT 'True=ALLOW LOGIN , FALSE =  NOT ALLOW LOGIN',
  `is_married` tinyint(1) NOT NULL COMMENT 'TRUE=MARRIED,FALSE=UNMARRIED',
  `marriage_date` int(11) DEFAULT NULL COMMENT 'IF MARRIED DATE OF MARRIAGE',
  `user_spouse_id` int(11) NOT NULL COMMENT 'user_spuouse_id',
  `is_dead` tinyint(1) NOT NULL COMMENT 'Is Person Dead',
  `user_DOD` date DEFAULT NULL COMMENT 'If Dead Date Of Death',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_master_email` (`user_email_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='users_master table';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
