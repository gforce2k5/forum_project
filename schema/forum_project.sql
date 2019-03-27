-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
<<<<<<< HEAD
-- Host: localhost
-- Generation Time: Mar 27, 2019 at 11:19 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2
=======
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 26, 2019 at 07:21 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14
>>>>>>> 16dded6e5ffe5d7e9202225a285b57466ddaac65

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forum_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

<<<<<<< HEAD
CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `cat_order` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL
=======
DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `cat_order` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
>>>>>>> 16dded6e5ffe5d7e9202225a285b57466ddaac65
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

<<<<<<< HEAD
CREATE TABLE `forums` (
  `id` int(10) UNSIGNED NOT NULL,
=======
DROP TABLE IF EXISTS `forums`;
CREATE TABLE IF NOT EXISTS `forums` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
>>>>>>> 16dded6e5ffe5d7e9202225a285b57466ddaac65
  `topic` text NOT NULL,
  `description` text NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cat_order` int(11) NOT NULL,
  `cat_id` int(10) UNSIGNED NOT NULL,
<<<<<<< HEAD
  `active` tinyint(1) NOT NULL
=======
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
>>>>>>> 16dded6e5ffe5d7e9202225a285b57466ddaac65
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `forum_managers`
--

CREATE TABLE `forum_managers` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
<<<<<<< HEAD
  `forum_id` int(11) NOT NULL
=======
  `forum_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
>>>>>>> 16dded6e5ffe5d7e9202225a285b57466ddaac65
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

<<<<<<< HEAD
CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
=======
DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
>>>>>>> 16dded6e5ffe5d7e9202225a285b57466ddaac65
  `title` text NOT NULL,
  `content` mediumtext NOT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_id` int(10) UNSIGNED NOT NULL,
  `edit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `forum_id` int(10) UNSIGNED DEFAULT NULL,
  `post_id` int(10) UNSIGNED DEFAULT NULL,
  `is_pinned` tinyint(1) NOT NULL,
<<<<<<< HEAD
  `is_locked` tinyint(1) NOT NULL
=======
  `is_locked` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
>>>>>>> 16dded6e5ffe5d7e9202225a285b57466ddaac65
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
<<<<<<< HEAD
  `username` tinytext NOT NULL,
=======
>>>>>>> 16dded6e5ffe5d7e9202225a285b57466ddaac65
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `password` varchar(64) NOT NULL,
  `avatar` blob NOT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_entry` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_admin` tinyint(1) NOT NULL,
  `signature` mediumtext NOT NULL,
  `email` text NOT NULL,
  `hash` varchar(64) DEFAULT NULL,
<<<<<<< HEAD
  `is_verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_managers`
--
ALTER TABLE `forum_managers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forums`
--
ALTER TABLE `forums`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum_managers`
--
ALTER TABLE `forum_managers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
=======
  `is_verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
>>>>>>> 16dded6e5ffe5d7e9202225a285b57466ddaac65
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
