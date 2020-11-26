# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.6.38)
# Database: suresy
# Generation Time: 2018-04-23 03:04:16 +0000
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
  `number_of_claims` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`policy_id`),
  KEY `quote_id` (`quote_id`),
  KEY `customer_user_id` (`customer_user_id`),
  KEY `coupon_id` (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `policies` WRITE;
/*!40000 ALTER TABLE `policies` DISABLE KEYS */;

INSERT INTO `policies` (`policy_id`, `customer_user_id`, `quote_id`, `start_date`, `policy_type`, `amount`, `renewal_frequency`, `renewed_date`, `next_due_date`, `number_of_renewals`, `policy_status`, `pdf_url`, `coupon_id`, `number_of_claims`)
VALUES
	(1,1,NULL,NULL,NULL,6,'annual',NULL,NULL,NULL,'paused','',NULL,0),
	(2,2,NULL,NULL,NULL,0,'annual',NULL,NULL,NULL,'paused','',NULL,0),
	(3,3,NULL,NULL,NULL,0,'annual',NULL,NULL,NULL,'paused','',NULL,0),
	(4,3,NULL,NULL,NULL,0,'annual',NULL,NULL,NULL,'paused','',NULL,0),
	(5,3,NULL,NULL,NULL,0,'annual',NULL,NULL,NULL,'paused','',NULL,0);

/*!40000 ALTER TABLE `policies` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table quotes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `quotes`;

CREATE TABLE `quotes` (
  `quote_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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

LOCK TABLES `quotes` WRITE;
/*!40000 ALTER TABLE `quotes` DISABLE KEYS */;

INSERT INTO `quotes` (`quote_id`, `name`, `email`, `startdate`, `amount`, `type`, `created`, `data`, `coupon_input`, `coupon_id`, `user_id`, `policy_id`, `status`, `last_step`)
VALUES
	(68,'travis','travis@dilate.com.au','2018-04-11','13','premium',1523414095,'{\"name\":\"travis\",\"email\":\"travis@dilate.com.au\",\"birthday\":\"1981-11-11\",\"location\":\"false\",\"location_input\":\"136 Central Avenue, Inglewood WA, Australia\",\"postcode\":\"6052\",\"security_alarm\":\"false\",\"security_dog\":\"true\",\"security_housemates\":\"false\",\"cover_household\":\"0\",\"cover_electronics\":\"1000\",\"cover_jewelry\":\"0\",\"cover_sports\":\"0\",\"excess\":\"500\",\"age\":\"37\",\"planType\":\"premium\",\"planPrice\":\"13\",\"start_date\":\"2018-04-11\",\"payment_method\":\"cc\",\"policy_id\":\"5acd744f826bb\"}',NULL,NULL,NULL,NULL,NULL,NULL),
	(69,'Travis','travis@dilate.com.au','2018-04-11','31','premium',1523420671,'{\"name\":\"Travis\",\"email\":\"travis@dilate.com.au\",\"birthday\":\"1981-11-11\",\"location\":\"false\",\"location_input\":\"136 Central Avenue, Inglewood WA, Australia\",\"postcode\":\"6052\",\"security_alarm\":\"false\",\"security_dog\":\"false\",\"security_housemates\":\"true\",\"cover_household\":\"10000\",\"cover_electronics\":\"7000\",\"cover_jewelry\":\"0\",\"cover_sports\":\"1000\",\"excess\":\"500\",\"age\":\"37\",\"planType\":\"premium\",\"planPrice\":\"31\",\"start_date\":\"2018-04-11\",\"payment_method\":\"cc\",\"policy_id\":\"5acd8dff85e70\"}',NULL,NULL,NULL,NULL,NULL,NULL),
	(70,'travis','travis@dilate.com.au','2018-04-11','19','premium',1523422793,'{\"name\":\"travis\",\"email\":\"travis@dilate.com.au\",\"birthday\":\"1981-11-11\",\"location\":\"false\",\"location_input\":\"136 Central Avenue, Inglewood WA, Australia\",\"postcode\":\"6052\",\"security_alarm\":\"false\",\"security_dog\":\"true\",\"security_housemates\":\"false\",\"cover_household\":\"20000\",\"cover_electronics\":\"1500\",\"cover_jewelry\":\"0\",\"cover_sports\":\"0\",\"excess\":\"500\",\"age\":\"37\",\"planType\":\"premium\",\"planPrice\":\"19\",\"start_date\":\"2018-04-11\",\"payment_method\":\"cc\",\"policy_id\":\"5acd96498a419\"}',NULL,NULL,NULL,NULL,NULL,NULL),
	(71,'trw','sdfsdf','2018-04-14','30','premium',1523703959,'{\"name\":\"trw\",\"email\":\"sdfsdf\",\"birthday\":\"\",\"location\":\"false\",\"location_input\":\"136 Flinders Street, Melbourne VIC, Australia\",\"postcode\":\"3000\",\"security_alarm\":\"false\",\"security_dog\":\"true\",\"security_housemates\":\"false\",\"cover_household\":\"20000\",\"cover_electronics\":\"1500\",\"cover_jewelry\":\"0\",\"cover_sports\":\"0\",\"excess\":\"500\",\"age\":\"NaN\",\"planType\":\"premium\",\"planPrice\":\"30\",\"start_date\":\"2018-04-14\",\"payment_method\":\"cc\",\"policy_id\":\"5ad1e09758ac7\"}',NULL,NULL,NULL,NULL,NULL,NULL),
	(72,'','','2018-04-15','21','premium',1523772837,'{\"name\":\"\",\"email\":\"\",\"birthday\":\"\",\"location\":\"false\",\"location_input\":\"136 Flinders Street, Melbourne VIC, Australia\",\"postcode\":\"3000\",\"security_alarm\":\"false\",\"security_dog\":\"true\",\"security_housemates\":\"false\",\"cover_household\":\"0\",\"cover_electronics\":\"1000\",\"cover_jewelry\":\"0\",\"cover_sports\":\"0\",\"excess\":\"500\",\"age\":\"NaN\",\"planType\":\"premium\",\"planPrice\":\"21\",\"start_date\":\"2018-04-15\",\"payment_method\":\"cc\",\"policy_id\":\"5ad2eda54c897\"}',NULL,NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `quotes` ENABLE KEYS */;
UNLOCK TABLES;


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
  `first_time_login` enum('yes','no') NOT NULL DEFAULT 'yes',
  `reset_password_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`user_id`, `role`, `name`, `first_name`, `last_name`, `email`, `password`, `address`, `address2`, `city`, `suburb`, `state`, `country`, `phone`, `phone2`, `last_logged`, `created`, `modified`, `birthdate`, `age`, `status`, `status_change_date`, `last_activity_date`, `first_time_login`, `reset_password_code`)
VALUES
	(1,'admin','Travis','Travis','Weerts','travis@dilate.com.au','81dc9bdb52d04dc20036dbd8313ed055',NULL,NULL,NULL,NULL,NULL,'AU',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'yes',NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
