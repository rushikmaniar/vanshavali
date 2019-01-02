-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 02, 2019 at 05:10 PM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `family_id` int(11) NOT NULL,
  `can_view` int(1) NOT NULL DEFAULT '0',
  `can_insert` int(1) NOT NULL DEFAULT '0',
  `can_update` int(1) NOT NULL DEFAULT '0',
  `can_delete` int(1) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_master_family_access` (`user_id`),
  KEY `family_tree_family_access` (`family_id`)
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
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
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
  `member_parent_id` int(11) DEFAULT NULL COMMENT 'parent user id',
  `member_family_tree_id` int(11) NOT NULL COMMENT 'member in which family tree',
  `user_id` int(11) NOT NULL COMMENT 'user_id from user_master',
  `member_email_id` varchar(255) DEFAULT NULL COMMENT 'member email ',
  `member_gender` varchar(10) NOT NULL DEFAULT '1' COMMENT 'MALE=1,FEMALE=2',
  `memeber_DOB` date DEFAULT NULL COMMENT 'member DOB , age from DOB',
  `member_phone_no` bigint(10) DEFAULT NULL COMMENT 'member_phone_no',
  `member_address` text,
  `is_married` tinyint(1) NOT NULL COMMENT 'TRUE=MARRIED,FALSE=UNMARRIED',
  `marriage_date` date DEFAULT NULL COMMENT 'IF MARRIED DATE OF MARRIAGE',
  `member_spouse_id` int(11) DEFAULT NULL COMMENT 'member_spuouse_id',
  `is_dead` tinyint(1) NOT NULL COMMENT 'alive = 0 Dead=1',
  `member_DOD` date DEFAULT NULL COMMENT 'If Dead Date Of Death',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `member_family_tree_id` (`member_family_tree_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='member_list table';

-- --------------------------------------------------------

--
-- Table structure for table `pending_request`
--

DROP TABLE IF EXISTS `pending_request`;
CREATE TABLE IF NOT EXISTS `pending_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_from_user_id` int(11) NOT NULL,
  `request_to_user_id` int(11) NOT NULL,
  `request_for_family_id` int(11) NOT NULL,
  `is_viewed` int(11) NOT NULL,
  `is_accepted` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `request_from_user_id` (`request_from_user_id`,`request_to_user_id`),
  KEY `request_to_user_master` (`request_to_user_id`),
  KEY `request_for_family_id` (`request_for_family_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='table maintains user request';

-- --------------------------------------------------------

--
-- Table structure for table `users_master`
--

DROP TABLE IF EXISTS `users_master`;
CREATE TABLE IF NOT EXISTS `users_master` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `user_type_id` int(11) NOT NULL COMMENT 'user type id from user_type',
  `is_verified` tinyint(1) DEFAULT '0',
  `verfication_code` varchar(255) DEFAULT NULL COMMENT 'random code',
  `random_code` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `users_type_user_master_link` (`user_type_id`)
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='user type';

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`user_type_id`, `user_type_name`) VALUES
(3, 'FAMILY_ADMIN'),
(2, 'FAMILY_CREATOR'),
(4, 'SIMPLE_MEMBER'),
(1, 'SUPER_ADMIN');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `family_access_table`
--
ALTER TABLE `family_access_table`
  ADD CONSTRAINT `family_tree_family_access` FOREIGN KEY (`family_id`) REFERENCES `family_trees` (`family_tree_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_master_family_access` FOREIGN KEY (`user_id`) REFERENCES `users_master` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `member_list`
--
ALTER TABLE `member_list`
  ADD CONSTRAINT `member_family_id_family_tree` FOREIGN KEY (`member_family_tree_id`) REFERENCES `family_trees` (`family_tree_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pending_request`
--
ALTER TABLE `pending_request`
  ADD CONSTRAINT `request_for_family_id` FOREIGN KEY (`request_for_family_id`) REFERENCES `family_trees` (`family_tree_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `request_to_user_master` FOREIGN KEY (`request_to_user_id`) REFERENCES `users_master` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reuest_from_user_master` FOREIGN KEY (`request_from_user_id`) REFERENCES `users_master` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_master`
--
ALTER TABLE `users_master`
  ADD CONSTRAINT `users_type_user_master_link` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`user_type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
