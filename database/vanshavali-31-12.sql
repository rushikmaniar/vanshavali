-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 31, 2018 at 08:23 AM
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
-- Table structure for table `family_access_table`
--

DROP TABLE IF EXISTS `family_access_table`;
CREATE TABLE IF NOT EXISTS `family_access_table` (
  `user_id` int(11) NOT NULL,
  `family_id` int(11) NOT NULL,
  `can_view` int(1) NOT NULL DEFAULT '0',
  `can_insert` int(1) NOT NULL DEFAULT '0',
  `can_update` int(1) NOT NULL DEFAULT '0',
  `ca_delete` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='table for user and family relation . decides user access fam';

-- --------------------------------------------------------

--
-- Table structure for table `family_trees`
--

DROP TABLE IF EXISTS `family_trees`;
CREATE TABLE IF NOT EXISTS `family_trees` (
  `family_tree_id` int(11) NOT NULL AUTO_INCREMENT,
  `family_tree_name` varchar(255) NOT NULL,
  `family_tree_ownerid` int(11) NOT NULL COMMENT 'owner_id who created family',
  PRIMARY KEY (`family_tree_id`),
  UNIQUE KEY `family_name` (`family_tree_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Family Tree List table';

-- --------------------------------------------------------

--
-- Table structure for table `member_list`
--

DROP TABLE IF EXISTS `member_list`;
CREATE TABLE IF NOT EXISTS `member_list` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'users password for login',
  `member_parent_id` int(11) NOT NULL COMMENT 'parent user id',
  `member_family_tree_id` int(11) NOT NULL COMMENT 'member in which family tree',
  `user_id` int(11) NOT NULL COMMENT 'member unique id',
  `member_email_id` varchar(255) NOT NULL COMMENT 'member email ',
  `member_gender` varchar(10) NOT NULL COMMENT 'MALE,FEMALE,OTHER',
  `memeber_DOB` date NOT NULL COMMENT 'member DOB , age from DOB',
  `member_phone_no` bigint(10) NOT NULL COMMENT 'member_phone_no',
  `member_address` text,
  `is_allow_login` tinyint(1) NOT NULL COMMENT 'True=ALLOW LOGIN , FALSE =  NOT ALLOW LOGIN',
  `is_married` tinyint(1) NOT NULL COMMENT 'TRUE=MARRIED,FALSE=UNMARRIED',
  `marriage_date` int(11) DEFAULT NULL COMMENT 'IF MARRIED DATE OF MARRIAGE',
  `member_spouse_id` int(11) NOT NULL COMMENT 'member_spuouse_id',
  `is_dead` tinyint(1) NOT NULL COMMENT 'Is Person Dead',
  `member_DOD` date DEFAULT NULL COMMENT 'If Dead Date Of Death',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='member_list table';

-- --------------------------------------------------------

--
-- Table structure for table `users_master`
--

DROP TABLE IF EXISTS `users_master`;
CREATE TABLE IF NOT EXISTS `users_master` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `verfication_code` varchar(255) DEFAULT NULL COMMENT 'random code',
  `user_type_id` int(11) NOT NULL COMMENT 'user type id from user_type',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='user master table for login';

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

DROP TABLE IF EXISTS `user_type`;
CREATE TABLE IF NOT EXISTS `user_type` (
  `user_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`user_type_id`),
  UNIQUE KEY `user_type_name` (`user_type_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='user type';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
