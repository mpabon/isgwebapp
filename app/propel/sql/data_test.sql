-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2013 at 06:57 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `mjpgcomv_isg`
--

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `status`, `description`, `valid_from`, `valid_until`, `created_by`, `created_on`, `modified_by`, `modified_on`) VALUES
(1, 'Active', 'System Administrator', '2013-02-09 00:00:00', '2013-05-16 00:00:00', 1, '2013-02-09 00:00:00', NULL, NULL),
(2, 'Active', 'Project Module Leader', '2013-02-09 00:00:00', '2013-05-16 00:00:00', 1, '2013-02-09 00:00:00', NULL, NULL),
(3, 'Active', 'Supervisor', '2013-02-09 00:00:00', '2013-05-16 00:00:00', 1, '2013-02-09 00:00:00', NULL, NULL),
(4, 'Active', 'Admin Staff', '2013-02-09 00:00:00', '2013-05-16 00:00:00', 1, '2013-02-09 00:00:00', NULL, NULL),
(5, 'Active', 'External Examiner', '2013-02-09 00:00:00', '2013-05-16 00:00:00', 1, '2013-02-09 00:00:00', NULL, NULL),
(6, 'Active', 'Student', '2013-02-09 00:00:00', '2013-05-16 00:00:00', 1, '2013-02-09 00:00:00', NULL, NULL);

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_email`, `user_firstname`, `user_lastname`, `password`, `salt`, `supervisor_quota_1`, `role_id`, `status`, `project_year`, `department`, `created_by`, `created_on`, `modified_by`, `modified_on`, `supervisor_quota_2`, `quota_used_1`, `quota_used_2`) VALUES
(1, 'mat.pabon@gmail.com', 'Matthew', 'Pabon', '6dc22d6c6fe985d53643fc8c10d8ca9e', 1234, NULL, 1, 'Active', '2013', 'Mathrematics', NULL, '2013-02-09 00:00:00', NULL, NULL, 0, 0, 0),
(2, 'student@rhul.ac.uk', 'Student', 'User', '2ddbd05acce1d3ffeb322e3a8ae65b23', 1234, 0, 6, 'Active', '2013', 'Mathematics', 1, '2013-02-10 05:22:36', NULL, NULL, 0, 0, 0),
(3, 'supervisor@rhul.ac.uk', 'Supervisor', 'User', 'fd79de2bbcbe08d99e66fdb3a0dee2c9', 1234, 0, 3, 'Active', '2013', 'Mathematics', 1, '2013-02-11 00:00:00', NULL, NULL, 0, 0, 0);
