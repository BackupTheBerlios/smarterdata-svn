-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Sep 12, 2005 at 07:27 PM
-- Server version: 4.1.13
-- PHP Version: 5.0.5
-- 
-- Database: `test`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `usergroups`
-- 

DROP TABLE IF EXISTS `usergroups`;
CREATE TABLE IF NOT EXISTS `usergroups` (
  `user_group_id` bigint(20) NOT NULL auto_increment,
  `user_type_id` bigint(20) NOT NULL default '0',
  `user_group_name` char(255) collate latin1_general_ci NOT NULL default '',
  UNIQUE KEY `user_group_id` (`user_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `usergroups`
-- 

INSERT INTO `usergroups` (`user_group_id`, `user_type_id`, `user_group_name`) VALUES (1, 99, 'Admistrator'),
(2, 1, 'Benutzer'),
(3, 0, 'Unbekannt');

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) NOT NULL auto_increment,
  `user_group_id` bigint(20) NOT NULL default '0',
  `user_type_id` bigint(20) NOT NULL default '0',
  `user_name` varchar(255) collate latin1_general_ci NOT NULL default '',
  `user_email` varchar(255) collate latin1_general_ci NOT NULL default '',
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` (`user_id`, `user_group_id`, `user_type_id`, `user_name`, `user_email`) VALUES (1, 1, 99, 'root', 'root@localhost');

-- --------------------------------------------------------

-- 
-- Table structure for table `usertypes`
-- 

DROP TABLE IF EXISTS `usertypes`;
CREATE TABLE IF NOT EXISTS `usertypes` (
  `user_type_id` bigint(20) NOT NULL auto_increment,
  `user_type_name` char(255) collate latin1_general_ci NOT NULL default '',
  UNIQUE KEY `user_type_id` (`user_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `usertypes`
-- 

