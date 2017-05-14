# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.46-0ubuntu0.14.04.2)
# Database: strangemetricsorg
# Generation Time: 2017-05-14 22:43:52 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table accounts
# ------------------------------------------------------------

CREATE TABLE `accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table analysis
# ------------------------------------------------------------

CREATE TABLE `analysis` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `tracking_platform_settings_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  `last_run` datetime DEFAULT NULL,
  `run_every_hours` int(4) DEFAULT NULL,
  `status` enum('on','off') NOT NULL DEFAULT 'on',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table cases
# ------------------------------------------------------------

CREATE TABLE `cases` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `tracking_platform_advertiser_id` int(11) DEFAULT NULL,
  `tracking_platform_offer_id` int(11) DEFAULT NULL,
  `tracking_platform_source_id` int(11) DEFAULT NULL,
  `analysis_id` int(11) NOT NULL,
  `status` enum('open','settled') NOT NULL DEFAULT 'open',
  `offer_lifetime_data_at` datetime DEFAULT NULL,
  `offer_impressions` int(11) DEFAULT NULL,
  `offer_clicks` int(11) DEFAULT NULL,
  `offer_conversions` int(11) DEFAULT NULL,
  `offer_revenue` int(11) DEFAULT NULL,
  `offer_cost` int(11) DEFAULT NULL,
  `case_impressions` int(11) DEFAULT NULL,
  `case_clicks` int(11) DEFAULT NULL,
  `case_conversions` int(11) DEFAULT NULL,
  `case_revenue` float DEFAULT NULL,
  `case_cost` float DEFAULT NULL,
  `settled_date` date DEFAULT NULL,
  `settled_impressions` int(11) DEFAULT NULL,
  `settled_clicks` int(11) DEFAULT NULL,
  `settled_conversions` int(11) DEFAULT NULL,
  `settled_revenue` float DEFAULT NULL,
  `settled_cost` float DEFAULT NULL,
  `synced_conversions` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table settings
# ------------------------------------------------------------

CREATE TABLE `settings` (
  `account_id` int(11) NOT NULL,
  `object` varchar(100) NOT NULL DEFAULT '',
  `entity_id` varchar(100) NOT NULL DEFAULT '',
  `key` varchar(100) NOT NULL DEFAULT '',
  `value` text,
  PRIMARY KEY (`account_id`,`object`,`entity_id`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table static_reports
# ------------------------------------------------------------

CREATE TABLE `static_reports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `analysis_id` int(11) NOT NULL,
  `data_path` varchar(255) NOT NULL DEFAULT '',
  `analysis_settings_path` varchar(255) DEFAULT NULL,
  `analysed` datetime DEFAULT NULL,
  `has_flags` tinyint(1) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tracking_platforms
# ------------------------------------------------------------

CREATE TABLE `tracking_platforms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `platform` enum('hasoffers','affise','cake') NOT NULL DEFAULT 'hasoffers',
  `name` varchar(100) NOT NULL DEFAULT '',
  `status` enum('on','off') NOT NULL DEFAULT 'on',
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users
# ------------------------------------------------------------

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('on','off') NOT NULL DEFAULT 'on',
  `is_account_owner` tinyint(1) DEFAULT NULL,
  `email_is_verified` tinyint(1) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_login_ip` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
