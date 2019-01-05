-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 05, 2019 at 01:35 PM
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
-- Table structure for table `error_codes`
--

DROP TABLE IF EXISTS `error_codes`;
CREATE TABLE IF NOT EXISTS `error_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COMMENT='table for reference of error codes used in site';

--
-- Dumping data for table `error_codes`
--

INSERT INTO `error_codes` (`id`, `code`, `description`) VALUES
(1, 200, '200 OK\r\n    Standard response for successful HTTP requests. The actual response will depend on the request method used. In a GET request, the response will contain an entity corresponding to the requested resource. In a POST request, the response will contain an entity describing or containing the result of the action'),
(2, 401, '401 Unauthorized (RFC 7235)\r\n    Similar to 403 Forbidden, but specifically for use when authentication is required and has failed or has not yet been provided. The response must include a WWW-Authenticate header field containing a challenge applicable to the requested resource. See Basic access authentication and Digest access authentication.[34] 401 semantically means \"unauthenticated\",[35] i.e. the user does not have the necessary credentials.\r\n    Note: Some sites incorrectly issue HTTP 401 when an IP address is banned from the website (usually the website domain) and that specific address is refused permission to access a website.'),
(3, 403, '403 Forbidden\r\n    The request was valid, but the server is refusing action. The user might not have the necessary permissions for a resource, or may need an account of some sort.'),
(4, 500, '500 Internal Server Error\r\n    A generic error message, given when an unexpected condition was encountered and no more specific message is suitable'),
(5, 503, '503 Service Unavailable\r\n    The server is currently unavailable (because it is overloaded or down for maintenance). Generally, this is a temporary state'),
(6, 404, '404 Not Found\r\n    The requested resource could not be found but may be available in the future. Subsequent requests by the client are permissible.'),
(7, 409, '409 Conflict\r\n    Indicates that the request could not be processed because of conflict in the current state of the resource, such as an edit conflict between multiple simultaneous updates.'),
(8, 400, '400 Bad Request\r\n    The server cannot or will not process the request due to an apparent client error (e.g., malformed request syntax, size too large, invalid request message framing, or deceptive request routing).'),
(9, 204, '204 No Content\r\n    The server successfully processed the request and is not returning any content');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Family Tree List table';

--
-- Dumping data for table `family_trees`
--

INSERT INTO `family_trees` (`family_tree_id`, `family_tree_name`, `family_tree_ownerid`, `created_at`, `updated_at`) VALUES
(1, 'Myfamily', 1, NULL, NULL);

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
  `is_viewed` int(11) NOT NULL DEFAULT '0',
  `is_accepted` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='user master table for login';

--
-- Dumping data for table `users_master`
--

INSERT INTO `users_master` (`user_id`, `user_email`, `user_pass`, `user_type_id`, `is_verified`, `verfication_code`, `random_code`, `created_at`, `updated_at`) VALUES
(1, 'rush', '698d51a19d8a121ce581499d7b701668', 2, 1, NULL, NULL, NULL, NULL);

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
