# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.6.38)
# Database: suresy
# Generation Time: 2018-04-19 09:27:44 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table activity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `activity`;

CREATE TABLE `activity` (
  `activity_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `activity_description` text,
  `data` text,
  `date` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table billinghistory
# ------------------------------------------------------------

DROP TABLE IF EXISTS `billinghistory`;

CREATE TABLE `billinghistory` (
  `billinghistory_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_type` enum('invoice','refund','claim_payment') NOT NULL DEFAULT 'invoice',
  `amount` float DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `claim_id` int(11) DEFAULT NULL,
  `policy_id` int(11) DEFAULT NULL,
  `user_billing_id` int(11) DEFAULT NULL,
  `status` enum('paid','declined','unpaid') NOT NULL DEFAULT 'unpaid',
  `decline_attempts` int(2) NOT NULL DEFAULT '0',
  `response_data` text,
  PRIMARY KEY (`billinghistory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table claim_contacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `claim_contacts`;

CREATE TABLE `claim_contacts` (
  `claim_contact_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `claim_id` int(11) DEFAULT NULL,
  `contact_type` varchar(255) DEFAULT NULL,
  `contact_user_id` int(11) DEFAULT NULL,
  `police_incident_report_number` varchar(255) DEFAULT NULL,
  `police_report_date` datetime DEFAULT NULL,
  PRIMARY KEY (`claim_contact_id`),
  KEY `claim_id` (`claim_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table claim_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `claim_items`;

CREATE TABLE `claim_items` (
  `claim_item_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `claim_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `item_price` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`claim_item_id`),
  KEY `claim_id` (`claim_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table claim_messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `claim_messages`;

CREATE TABLE `claim_messages` (
  `claim_message_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `claim_id` int(11) DEFAULT NULL,
  `message_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`claim_message_id`),
  KEY `claim_id` (`claim_id`),
  KEY `message_id` (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table claims
# ------------------------------------------------------------

DROP TABLE IF EXISTS `claims`;

CREATE TABLE `claims` (
  `claim_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_user_id` int(11) NOT NULL,
  `policy_id` int(11) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime NOT NULL,
  `claim_details` text NOT NULL,
  `claim_type` enum('T','FT','FTD') NOT NULL DEFAULT 'T',
  `claim_status` enum('open','investigating','unpaid','paid','declined','closed') NOT NULL DEFAULT 'open',
  `claim_total` float NOT NULL,
  PRIMARY KEY (`claim_id`),
  KEY `customer_user_id` (`customer_user_id`),
  KEY `policy_id` (`policy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table coupons
# ------------------------------------------------------------

DROP TABLE IF EXISTS `coupons`;

CREATE TABLE `coupons` (
  `coupon_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('fixed','percent') NOT NULL DEFAULT 'fixed',
  `coupon_frequency` enum('onetime','multiple') NOT NULL DEFAULT 'onetime',
  `coupon_discount` float NOT NULL DEFAULT '0',
  `expiration_date` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `coupon_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `message_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author_user_id` int(11) DEFAULT NULL,
  `message` text,
  `date` datetime DEFAULT NULL,
  `status` enum('unread','read','deleted') DEFAULT NULL,
  `admin_private` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table policies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `policies`;

CREATE TABLE `policies` (
  `policy_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_user_id` int(11) DEFAULT NULL,
  `quote_id` int(11) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `policy_type` varchar(255) DEFAULT NULL,
  `amount` float NOT NULL DEFAULT '0',
  `renewal_frequency` enum('fortnight','monthly','biannual','annual') NOT NULL DEFAULT 'annual',
  `renewed_date` datetime DEFAULT NULL,
  `next_due_date` datetime DEFAULT NULL,
  `number_of_renewals` int(11) DEFAULT NULL,
  `policy_status` enum('active','paused','cancelled','payment declined','deleted') NOT NULL DEFAULT 'paused',
  `pdf_url` varchar(255) NOT NULL DEFAULT '',
  `coupon_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`policy_id`),
  KEY `quote_id` (`quote_id`),
  KEY `customer_user_id` (`customer_user_id`),
  KEY `coupon_id` (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table quotes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `quotes`;

CREATE TABLE `quotes` (
  `quote_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `policyid` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `startdate` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `data` text,
  `coupon_input` varchar(255) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `policy_id` int(11) DEFAULT NULL,
  `status` enum('quote','policy') DEFAULT NULL,
  `last_step` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`quote_id`),
  KEY `coupon_id` (`coupon_id`),
  KEY `user_id` (`user_id`),
  KEY `policy_id` (`policy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_billing
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_billing`;

CREATE TABLE `user_billing` (
  `user_billing_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `policy_id` int(11) DEFAULT NULL,
  `cc_num` varchar(255) DEFAULT NULL,
  `cc_exp_mon` int(11) DEFAULT NULL,
  `cc_exp_yr` int(11) DEFAULT NULL,
  `cc_cvv` int(6) DEFAULT NULL,
  `cc_name` varchar(255) DEFAULT NULL,
  `cc_type` varchar(255) DEFAULT NULL,
  `cc_address` varchar(255) DEFAULT NULL,
  `cc_address2` varchar(255) DEFAULT NULL,
  `cc_suburb` varchar(255) DEFAULT NULL,
  `cc_state` varchar(2) DEFAULT NULL,
  `cc_postcode` varchar(20) DEFAULT NULL,
  `cc_country` varchar(2) DEFAULT NULL,
  `payment_type` enum('paypal','card') NOT NULL DEFAULT 'card',
  `paypal_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_billing_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role` enum('admin','customer','contact') NOT NULL DEFAULT 'customer',
  `name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `suburb` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(2) NOT NULL DEFAULT 'AU',
  `phone` varchar(255) DEFAULT NULL,
  `phone2` varchar(255) DEFAULT NULL,
  `last_logged` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `birthdate` datetime DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `status` enum('active','cancelled','deactivated') DEFAULT NULL,
  `status_change_date` datetime DEFAULT NULL,
  `last_activity_date` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
