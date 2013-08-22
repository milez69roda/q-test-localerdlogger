/*
SQLyog Enterprise - MySQL GUI v8.05 RC 
MySQL - 5.5.8-log : Database - erd_logger_db_final
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `centers` */

DROP TABLE IF EXISTS `centers`;

CREATE TABLE `centers` (
  `center_id` int(11) NOT NULL AUTO_INCREMENT,
  `center_desc` varchar(100) DEFAULT NULL,
  `center_address` varchar(255) DEFAULT NULL,
  `center_disabled` tinyint(4) DEFAULT '0',
  `center_acronym` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`center_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Table structure for table `ci_sessions` */

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_desc` text,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `erd_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `fk_comment_user_id` (`user_id`),
  KEY `fk_comment_erd_id` (`erd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=870408 DEFAULT CHARSET=latin1;

/*Table structure for table `drp_department` */

DROP TABLE IF EXISTS `drp_department`;

CREATE TABLE `drp_department` (
  `dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_desc` varchar(100) DEFAULT NULL,
  `dept_active` smallint(6) DEFAULT '0' COMMENT '0:active 1:inactive',
  PRIMARY KEY (`dept_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `drp_escalated` */

DROP TABLE IF EXISTS `drp_escalated`;

CREATE TABLE `drp_escalated` (
  `esc_id` int(11) NOT NULL AUTO_INCREMENT,
  `esc_name` varchar(60) DEFAULT NULL,
  `esc_active` smallint(6) DEFAULT '0' COMMENT '0:active 1:inactive',
  PRIMARY KEY (`esc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Table structure for table `drp_issue` */

DROP TABLE IF EXISTS `drp_issue`;

CREATE TABLE `drp_issue` (
  `issue_id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_desc` varchar(100) DEFAULT NULL,
  `issue_active` smallint(6) DEFAULT '0' COMMENT '0:active 1:inactive',
  `miamionly` int(11) DEFAULT '0' COMMENT '0: no 1:yes',
  PRIMARY KEY (`issue_id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

/*Table structure for table `drp_issuesub` */

DROP TABLE IF EXISTS `drp_issuesub`;

CREATE TABLE `drp_issuesub` (
  `issuesub_id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) DEFAULT NULL,
  `issuesub_desc` varchar(100) DEFAULT NULL,
  `issuesub_active` smallint(6) DEFAULT '0',
  PRIMARY KEY (`issuesub_id`)
) ENGINE=MyISAM AUTO_INCREMENT=197 DEFAULT CHARSET=latin1;

/*Table structure for table `drp_organization` */

DROP TABLE IF EXISTS `drp_organization`;

CREATE TABLE `drp_organization` (
  `org_id` int(11) NOT NULL AUTO_INCREMENT,
  `org_name` varchar(100) DEFAULT NULL,
  `org_active` smallint(6) DEFAULT '0' COMMENT '0:active 1:inactive',
  PRIMARY KEY (`org_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `drp_source` */

DROP TABLE IF EXISTS `drp_source`;

CREATE TABLE `drp_source` (
  `src_id` int(11) NOT NULL AUTO_INCREMENT,
  `src_name` varchar(100) DEFAULT NULL,
  `src_active` smallint(6) DEFAULT '0' COMMENT '0:active 1:inactive',
  PRIMARY KEY (`src_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Table structure for table `drp_status` */

DROP TABLE IF EXISTS `drp_status`;

CREATE TABLE `drp_status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_desc` varchar(60) DEFAULT NULL,
  `status_active` smallint(6) DEFAULT '0' COMMENT '0:active 1:Inactive',
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `erdlogs` */

DROP TABLE IF EXISTS `erdlogs`;

CREATE TABLE `erdlogs` (
  `erd_id` int(11) NOT NULL AUTO_INCREMENT,
  `date_opened` datetime DEFAULT NULL,
  `date_closed` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `cust_name` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'owner',
  `erd_dept` int(11) DEFAULT NULL,
  `erd_issue_desc` varchar(200) DEFAULT NULL,
  `isother` smallint(6) DEFAULT '0' COMMENT '0:no 1:yes ref issue description',
  `status_id` int(11) DEFAULT NULL,
  `imei` varchar(60) DEFAULT NULL,
  `erd_ipaddress` varchar(20) DEFAULT NULL,
  `needcallback` smallint(6) DEFAULT '0' COMMENT '0:no callback 1:need a callback',
  `callback_date` datetime DEFAULT NULL,
  `erd_deleted` smallint(6) DEFAULT '0' COMMENT '0:active 1:deleted',
  `erd_del_date` datetime DEFAULT NULL,
  `erd_note` text,
  `case_no` varchar(60) DEFAULT NULL,
  `phone_no` varchar(60) DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `emailaddress` varchar(150) DEFAULT NULL,
  `organization` varchar(100) DEFAULT NULL,
  `minno` varchar(150) DEFAULT NULL,
  `reference_id` varchar(10) DEFAULT NULL COMMENT 'reference as a erd_id',
  `comments` text COMMENT 'not in use',
  `comment_by` int(11) DEFAULT NULL COMMENT 'not in use',
  `comment_date` date DEFAULT NULL COMMENT 'not in use',
  `escalatedto` varchar(60) DEFAULT NULL COMMENT 'department where to be escalated',
  `reassigned` smallint(6) DEFAULT NULL COMMENT '0:not 1: yes',
  `reassignedto` int(11) DEFAULT NULL,
  `reassigned_erd_id` int(11) DEFAULT NULL,
  `reassigned_by` int(11) DEFAULT NULL,
  `reassigned_flag` smallint(6) DEFAULT '0',
  `reassigned_datetime` datetime DEFAULT NULL COMMENT '0:not read 1:read',
  `erd_issuesub_desc` varchar(150) DEFAULT NULL,
  `callback_type` smallint(6) DEFAULT '0' COMMENT '0: NONE 1: Follow-up 2: Courtesy CALL',
  PRIMARY KEY (`erd_id`),
  KEY `fk_user` (`user_id`),
  KEY `fk_department` (`erd_dept`),
  KEY `fk_status` (`status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12893 DEFAULT CHARSET=latin1;

/*Table structure for table `login_attempts` */

DROP TABLE IF EXISTS `login_attempts`;

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44326 DEFAULT CHARSET=latin1;

/*Table structure for table `notes` */

DROP TABLE IF EXISTS `notes`;

CREATE TABLE `notes` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `erd_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `note_text` text,
  `note_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`note_id`),
  KEY `fk_notes_erd_id` (`erd_id`),
  KEY `fk_notes_user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=528440 DEFAULT CHARSET=latin1;

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `fk_perm_role_id` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `user_autologin` */

DROP TABLE IF EXISTS `user_autologin`;

CREATE TABLE `user_autologin` (
  `key_id` char(32) NOT NULL,
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) NOT NULL,
  `last_ip` varchar(40) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`),
  KEY `fk_autlogin_user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `user_profile` */

DROP TABLE IF EXISTS `user_profile`;

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_profile_user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `user_temp` */

DROP TABLE IF EXISTS `user_temp`;

CREATE TABLE `user_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(34) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `center_id` int(11) DEFAULT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `avaya` varchar(50) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `activation_key` varchar(50) NOT NULL,
  `last_ip` varchar(40) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT '1',
  `username` varchar(25) NOT NULL,
  `password` varchar(34) NOT NULL,
  `email` varchar(100) NOT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) DEFAULT NULL,
  `newpass` varchar(34) DEFAULT NULL,
  `newpass_key` varchar(32) DEFAULT NULL,
  `newpass_time` datetime DEFAULT NULL,
  `last_ip` varchar(40) NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `dept_id` int(11) DEFAULT NULL,
  `center_id` int(11) DEFAULT NULL,
  `fname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `avaya` varchar(50) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `updatedby` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_center` (`center_id`),
  KEY `fk_user_department` (`dept_id`),
  KEY `fk_supervisor` (`supervisor_id`),
  KEY `fk_user_role_id` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3620 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;