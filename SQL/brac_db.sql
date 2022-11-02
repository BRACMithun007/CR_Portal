/*
SQLyog Ultimate v10.42 
MySQL - 5.5.5-10.4.18-MariaDB : Database - brac_calc
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`brac_calc` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `brac_calc`;

/*Table structure for table `change_request_master` */

CREATE TABLE `change_request_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cr_title` varchar(255) DEFAULT NULL,
  `cr_details` varchar(800) DEFAULT NULL,
  `cr_doc_link` varchar(255) DEFAULT NULL,
  `jira_code` varchar(255) DEFAULT NULL,
  `jira_created` date DEFAULT NULL,
  `initial_requirement_shared_from_mf` date DEFAULT NULL,
  `approved_billable_effort` varchar(300) DEFAULT NULL,
  `team_name` varchar(150) DEFAULT NULL,
  `category` varchar(150) DEFAULT NULL,
  `cr_locked_by_vendor` date DEFAULT NULL,
  `vendor_name` varchar(200) DEFAULT NULL,
  `mf_expect_timeline` date DEFAULT NULL,
  `vendor_proposed_timeline` date DEFAULT NULL,
  `requester_team` varchar(255) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `cr_type` varchar(100) DEFAULT NULL,
  `cr_status` varchar(100) DEFAULT NULL,
  `completed_on` date DEFAULT NULL,
  `business_analyst` varchar(200) DEFAULT NULL,
  `assigned_from_brac` varchar(200) DEFAULT NULL,
  `uat_instance` varchar(500) DEFAULT NULL,
  `uat_credential` varchar(500) DEFAULT NULL,
  `summary` varchar(500) DEFAULT NULL,
  `satisfactory_level` varchar(100) DEFAULT NULL,
  `is_archived` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

/*Data for the table `change_request_master` */

insert  into `change_request_master`(`id`,`cr_title`,`cr_details`,`cr_doc_link`,`jira_code`,`jira_created`,`initial_requirement_shared_from_mf`,`approved_billable_effort`,`team_name`,`category`,`cr_locked_by_vendor`,`vendor_name`,`mf_expect_timeline`,`vendor_proposed_timeline`,`requester_team`,`priority`,`cr_type`,`cr_status`,`completed_on`,`business_analyst`,`assigned_from_brac`,`uat_instance`,`uat_credential`,`summary`,`satisfactory_level`,`is_archived`,`created_at`,`created_by`,`updated_at`,`updated_by`) values (4,'Shadhin Loan Excess Frequency','It\'s one time CR. Remove some period of frequency for specific product',NULL,'BEM-41955','2022-08-03','2022-08-24',NULL,'FAP','Loan',NULL,'BRAC IT',NULL,NULL,'Product Team',1,'CR','Ongoing',NULL,NULL,'Mithun',NULL,NULL,NULL,NULL,0,'2022-09-04 07:59:32',4,'2022-09-10 15:52:54',4),(5,'Dabi Age Limit Increase','Age',NULL,'BEM-41883',NULL,'2022-08-18',NULL,'FAP','Savings',NULL,'BRAC IT',NULL,NULL,'Product team',1,'CR','Ongoing',NULL,NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-04 09:19:37',4,'2022-09-04 09:55:05',4),(6,'Crop Insurance Data Correction (Shibgonj and Jamurhat)','Financial mismatch for two branches',NULL,'BEM-41776',NULL,NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'Crop insurance team',1,'Data Correction','Ongoing',NULL,NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-04 09:22:38',4,'2022-09-05 21:25:54',4),(7,'Incident Setup_Reason of Incident - Add \"Others\" Option in Dropdown List','Introduce others option in reason of incident',NULL,'BEM-41446','2022-09-05','2022-08-17',NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'MI',1,'CR','Ongoing',NULL,NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-04 09:37:35',4,'2022-09-05 21:26:25',4),(8,'GBB Update API Validation for Non-working Days & Holidays, Cause of Death & Rejection List Update in ERP','Need to incorporate validation',NULL,'BEM-41346',NULL,NULL,NULL,'EA','EA_B2B',NULL,'BRAC IT',NULL,NULL,'MI',1,'CR','Ongoing',NULL,NULL,'Rakebul',NULL,NULL,NULL,NULL,0,'2022-09-04 09:45:32',4,'2022-09-05 21:26:51',4),(9,'DCS (Dabi, Progoti) - Phase 4_Pre-validations of ERP API','DCS',NULL,'BEM-40789',NULL,NULL,NULL,'EA','EA_B2C',NULL,'Q Soft',NULL,NULL,'Product',1,'CR','Ongoing',NULL,NULL,'Tanvir',NULL,NULL,NULL,NULL,0,'2022-09-04 09:53:11',4,'2022-09-05 21:27:12',4),(10,'DCS (Dabi, Progoti) - Phase 3_NID Deduplication API','DCS',NULL,'BEM-40788',NULL,NULL,NULL,'EA','EA_B2C',NULL,'Q Soft',NULL,NULL,'Product',1,'CR','Ongoing',NULL,NULL,'Tanvir',NULL,NULL,NULL,NULL,0,'2022-09-04 20:43:26',4,'2022-09-05 21:27:36',4),(11,'18 Months Dabi Loan','Loan',NULL,'BEM-40167',NULL,NULL,NULL,'FAP','Loan',NULL,'BRAC IT',NULL,NULL,'Product',1,'CR','Ongoing',NULL,NULL,'Lamia',NULL,NULL,NULL,NULL,0,'2022-09-04 20:45:26',4,'2022-09-05 21:28:00',4),(12,'Redesign of Lien Loan Product','Redesign',NULL,'BEM-39748',NULL,NULL,NULL,'FAP','Loan',NULL,'BRAC IT',NULL,NULL,'Product',1,'CR','Ongoing',NULL,NULL,'Lamia',NULL,NULL,NULL,NULL,0,'2022-09-04 20:47:18',4,'2022-09-05 21:28:20',4),(13,'Alternative Payment Method for Loan Disbursement, Loan & Savings Collection - Phase 3','Alternative Payment Method',NULL,'BEM-39288',NULL,NULL,NULL,'FAP','Loan',NULL,'BRAC IT',NULL,NULL,'Product',1,'CR','Ongoing',NULL,NULL,'Lamia',NULL,NULL,NULL,NULL,0,'2022-09-04 22:10:04',4,'2022-09-05 21:28:39',4),(14,'Change in DCS Consent Paper','DCS',NULL,'BEM-38118',NULL,NULL,NULL,'EA','EA_B2C',NULL,'Q Soft',NULL,NULL,'Product',1,'CR','Ongoing',NULL,NULL,'Tanvir',NULL,NULL,NULL,NULL,0,'2022-09-04 22:11:22',4,'2022-09-05 21:29:02',4),(15,'CSI - Claim Settlement Timeline within 120 Days','CSI',NULL,'BEM-37541',NULL,NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'MI',1,'CR','Ongoing',NULL,NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-04 22:12:48',4,'2022-09-05 21:29:45',4),(16,'DPS Collection in TAB Application','DPS',NULL,'BEM-37538',NULL,NULL,NULL,'EA','EA_B2C',NULL,'Q Soft',NULL,NULL,'Product',1,'CR','Ongoing',NULL,NULL,'Tanvir',NULL,NULL,NULL,NULL,0,'2022-09-04 22:13:51',4,'2022-09-05 21:30:13',4),(17,'Adding \"Rocket\" Payment Method in ERP','Rocket',NULL,'BEM-37537','2022-09-01',NULL,NULL,'FAP','Loan',NULL,'BRAC IT',NULL,NULL,'Product',1,'CR','Ongoing',NULL,NULL,'Lamia',NULL,NULL,NULL,NULL,0,'2022-09-04 22:15:16',4,'2022-09-05 21:30:35',4),(18,'Collection Amount Field Validation','Collection Amount Field Validation',NULL,'BEM-27932',NULL,NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'MI',1,'CR','Ongoing',NULL,NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-04 22:20:37',4,'2022-09-05 21:31:00',4),(19,'New API for Shadhin Loan','New API for Shadhin Loan',NULL,'BEM-22659',NULL,NULL,NULL,'EA','EA_B2B',NULL,'BRAC IT',NULL,NULL,'Product',1,'CR','Ongoing',NULL,NULL,'Rakebul',NULL,NULL,NULL,NULL,0,'2022-09-04 22:22:17',4,'2022-09-05 21:31:39',4),(20,'bKash Unique ID (UID) based Payment System Integration','bKash Unique ID',NULL,'BEM-557',NULL,NULL,NULL,'EA','EA_B2B',NULL,'BRAC IT',NULL,NULL,'Product',1,'CR','Ongoing',NULL,NULL,'Rakebul',NULL,NULL,NULL,NULL,0,'2022-09-04 22:27:14',4,'2022-09-05 21:31:58',4),(21,'Nirbhorota Rin Changes','Nirbhorota Rin Changes',NULL,'BEM-40129',NULL,NULL,NULL,'FAP','Loan',NULL,'BRAC IT',NULL,NULL,'Product',2,'CR','Ongoing',NULL,NULL,'Lamia',NULL,NULL,NULL,NULL,0,'2022-09-04 22:28:45',4,'2022-09-05 21:32:18',4),(22,'DPS Insurance Product','DPS Insurance Product',NULL,'BEM-55700',NULL,NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'MI',2,'CR','Ongoing',NULL,NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-04 22:29:46',4,'2022-09-09 13:32:34',1),(23,'MF Performance Dashboard Upgradation','MF Performance Dashboard Up-gradation',NULL,'BEM-33918',NULL,NULL,NULL,'FAP','Others',NULL,'BRAC IT',NULL,NULL,'Loan',2,'Non-CR','Ongoing',NULL,NULL,'Lamia',NULL,NULL,NULL,NULL,0,'2022-09-04 22:32:06',4,'2022-09-05 21:33:01',4),(24,'CSI - Addition of 4 Reports','CSI - Addition of 4 Reports',NULL,'BEM-40391',NULL,NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'MI',3,'CR','Ongoing',NULL,NULL,'Mithun',NULL,NULL,NULL,NULL,0,'2022-09-04 22:33:23',4,'2022-09-05 21:33:26',4),(25,'Member-wise Loan Collection/Adjustment','Member-wise Loan Collection/Adjustment',NULL,'BEM-39853',NULL,NULL,NULL,'FAP','Loan',NULL,'BRAC IT',NULL,NULL,'Product',3,'CR','Ongoing',NULL,NULL,'Lamia',NULL,NULL,NULL,NULL,0,'2022-09-04 22:37:22',4,'2022-09-05 21:33:54',4),(26,'Generate Branch-wise MRA Summary Half-yearly Reports through ERP','Generate Branch-wise MRA Summary Half-yearly Reports through ERP',NULL,'BEM-39657',NULL,NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'MI',3,'CR','Ongoing',NULL,NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-05 21:13:01',4,'2022-09-05 21:34:18',4),(27,'Crop Insurance - Change in Enrollment UI | Settlement Form Report | Data Mismatch in PDF Format of Crop Insurance Enrollment Report | Premium Modification/Cancellation in Account Code-wise Ledger Report','Crop Insurance',NULL,'BEM-38123',NULL,NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'MI',3,'CR','Ongoing',NULL,NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-05 21:14:36',4,'2022-09-05 21:34:56',4),(28,'Access of CRUD (Create, Read, Update, Delete) for Demarcations to be Modified/Renamed','Access of CRUD',NULL,'BEM-38109',NULL,NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'MI',3,'CR','Ongoing',NULL,NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-05 21:16:05',4,'2022-09-05 21:35:32',4),(29,'Demarcation-wise Management Report Enhancement (Collection, Disbursement & Target Achievement)','Demarcation-wise Management Report',NULL,'BEM-27237',NULL,NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'MI',3,'CR','Ongoing',NULL,NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-05 21:17:22',4,'2022-09-05 21:35:53',4),(30,'Microinsurance (MI) Portal','MI Portal',NULL,'BEM-729',NULL,'2020-04-16',NULL,'FAP','Insurance','2021-12-15','BRAC IT','2022-10-01',NULL,'MI',3,'CR','Ongoing',NULL,'Fahmida Rahman','Mithun',NULL,NULL,NULL,NULL,0,'2022-09-05 21:23:14',4,'2022-09-05 21:58:52',4);

/*Table structure for table `change_request_updates` */

CREATE TABLE `change_request_updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cr_master_id` int(11) DEFAULT NULL,
  `cr_update` varchar(500) DEFAULT NULL,
  `note_type` varchar(200) DEFAULT NULL,
  `cr_notes` varchar(500) DEFAULT NULL,
  `note_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4;

/*Data for the table `change_request_updates` */

insert  into `change_request_updates`(`id`,`cr_master_id`,`cr_update`,`note_type`,`cr_notes`,`note_date`,`created_at`,`created_by`,`updated_at`,`updated_by`) values (7,5,NULL,'General','Analysis ongoing.','2022-08-30','2022-09-04 09:40:54',4,'2022-09-04 09:55:05',4),(8,4,NULL,'General','Still, no business analyst is assigned.','2022-09-05','2022-09-05 21:24:45',4,'2022-09-05 21:24:45',4),(9,6,NULL,'General','Analysis ongoing','2022-09-01','2022-09-05 21:25:54',4,'2022-09-05 21:25:54',4),(10,7,NULL,'General','Analysis is done. Waiting for CR doc.','2022-09-05','2022-09-05 21:26:25',4,'2022-09-05 21:26:25',4),(11,8,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:26:51',4,'2022-09-05 21:26:51',4),(12,9,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:27:12',4,'2022-09-05 21:27:12',4),(13,10,NULL,'General','UAT is ongoing','2022-09-05','2022-09-05 21:27:36',4,'2022-09-05 21:27:36',4),(14,11,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:28:00',4,'2022-09-05 21:28:00',4),(15,12,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:28:20',4,'2022-09-05 21:28:20',4),(16,13,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:28:39',4,'2022-09-05 21:28:39',4),(17,14,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:29:02',4,'2022-09-05 21:29:02',4),(18,15,NULL,'General','Analysis ongoing. Will get CR doc from BRAC IT','2022-09-05','2022-09-05 21:29:45',4,'2022-09-05 21:29:45',4),(19,16,NULL,'General','Waiting for timeline from BRAC IT','2022-09-05','2022-09-05 21:30:13',4,'2022-09-05 21:30:13',4),(20,17,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:30:35',4,'2022-09-05 21:30:35',4),(21,18,NULL,'General','Release timeline is required.','2022-09-05','2022-09-05 21:31:00',4,'2022-09-05 21:31:00',4),(22,19,NULL,'General','UAT ongoing','2022-09-05','2022-09-05 21:31:39',4,'2022-09-05 21:31:39',4),(23,20,NULL,'General','CR review ongoing','2022-09-05','2022-09-05 21:31:58',4,'2022-09-05 21:31:58',4),(24,21,NULL,'General','Still, no business analyst is assigned.','2022-09-05','2022-09-05 21:32:18',4,'2022-09-05 21:32:18',4),(25,22,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:32:37',4,'2022-09-05 21:32:37',4),(26,23,NULL,'General','Release timeline is required.','2022-09-05','2022-09-05 21:33:01',4,'2022-09-05 21:33:01',4),(27,24,NULL,'General','Currently on halt based on other CR priority','2022-09-05','2022-09-05 21:33:26',4,'2022-09-05 21:33:26',4),(28,25,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:33:54',4,'2022-09-05 21:33:54',4),(29,26,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:34:18',4,'2022-09-05 21:34:18',4),(30,27,NULL,'General','CR doc is approved. Release timeline is required.','2022-09-05','2022-09-05 21:34:56',4,'2022-09-05 21:34:56',4),(31,28,NULL,'General','Previous Jira is (BEF-10641) and Initiated on 20th Feb 2022.Still, no business analyst is assigned.','2022-09-05','2022-09-05 21:35:32',4,'2022-09-05 21:35:32',4),(32,29,NULL,'General','Testing done, LIVE deployment pending.','2022-09-05','2022-09-05 21:35:53',4,'2022-09-05 21:35:53',4),(33,30,NULL,'General','Development on going','2022-09-05','2022-09-05 21:38:59',4,'2022-09-05 21:38:59',4),(34,30,NULL,'General','Development on going . Need user_email related analysis from BRAC IT','2022-08-30','2022-09-05 21:58:52',4,'2022-09-05 21:58:52',4);

/*Table structure for table `failed_jobs` */

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `loan_repay_config` */

CREATE TABLE `loan_repay_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loan_amount_start` int(50) DEFAULT NULL,
  `loan_amount_end` int(50) DEFAULT NULL,
  `interest_rate` int(20) DEFAULT NULL,
  `period_in_month` int(20) DEFAULT NULL,
  `monthly_pay_factor` double DEFAULT NULL,
  `disbursement_no_of_date` int(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '1970-05-20 12:11:10',
  `created_by` int(20) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '1970-05-20 12:11:10',
  `updated_by` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Data for the table `loan_repay_config` */

insert  into `loan_repay_config`(`id`,`loan_amount_start`,`loan_amount_end`,`interest_rate`,`period_in_month`,`monthly_pay_factor`,`disbursement_no_of_date`,`created_at`,`created_by`,`updated_at`,`updated_by`) values (1,0,499999,24,6,0.179,7,'1970-05-20 12:11:10',NULL,'1970-05-20 12:11:10',NULL),(2,0,499999,24,9,0.123,7,'1970-05-20 12:11:10',NULL,'1970-05-20 12:11:10',NULL),(3,0,499999,24,12,0.095,7,'1970-05-20 12:11:10',NULL,'1970-05-20 12:11:10',NULL),(4,0,499999,24,18,0.068,7,'1970-05-20 12:11:10',NULL,'1970-05-20 12:11:10',NULL),(5,0,499999,24,24,0.053,7,'1970-05-20 12:11:10',NULL,'1970-05-20 12:11:10',NULL),(6,500000,999999,22,6,0.175,7,'1970-05-20 12:11:10',NULL,'1970-05-20 12:11:10',NULL),(7,500000,999999,22,9,0.12,7,'1970-05-20 12:11:10',NULL,'1970-05-20 12:11:10',NULL),(8,500000,999999,22,12,0.094,7,'1970-05-20 12:11:10',NULL,'1970-05-20 12:11:10',NULL),(9,500000,999999,22,18,0.066,7,'1970-05-20 12:11:10',NULL,'1970-05-20 12:11:10',NULL),(10,500000,999999,22,24,0.053,7,'1970-05-20 12:11:10',NULL,'1970-05-20 12:11:10',NULL),(11,1000000,6000000,20,6,0.174,7,'1970-05-20 12:11:10',NULL,'1970-05-20 12:11:10',NULL),(12,1000000,6000000,20,9,0.119,7,'1970-05-20 12:11:10',NULL,'1970-05-20 12:11:10',NULL),(13,1000000,6000000,20,12,0.093,7,'1970-05-20 12:11:10',NULL,'1970-05-20 12:11:10',NULL),(14,1000000,6000000,20,18,0.065,7,'1970-05-20 12:11:10',NULL,'1970-05-20 12:11:10',NULL),(15,1000000,6000000,20,24,0.053,7,'1970-05-20 12:11:10',NULL,'1970-05-20 12:11:10',NULL);

/*Table structure for table `migrations` */

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1);

/*Table structure for table `password_resets` */

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `users` */

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `user_permission` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '[]',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_exp_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`type`,`phone`,`status`,`user_permission`,`photo`,`country`,`occupation`,`designation`,`otp`,`otp_exp_time`,`created_at`,`updated_at`) values (1,'admin','admin@gmail.com',NULL,'$2y$10$NY4OQEKnLRI24qliTS8k5.A36nBZ.0BMKNxjsHKPE1atzSF5cc6ee',NULL,'SuperAdmin',NULL,1,'[\"user_read\",\"user_write\",\"mf_cr_read\",\"mf_cr_write\"]',NULL,NULL,NULL,NULL,NULL,NULL,'2022-05-20 12:11:10','2022-05-20 12:11:10'),(4,'Mithun','mujahidur.rahman@brac.net',NULL,'$2y$10$O0VZFX7NSuhm4V9lXNFxG.0oMiJAKsP2i5RH5geJ00h7azmYvNjna','cNAFro9VE834QgPvUGZoJ1X0J0sSd8OFB2Mh8zx3TrybO0ZI8Z90W17tm1XE','Admin','01624231244',1,'[\"user_read\",\"user_write\",\"mf_cr_write\"]',NULL,'BD','','DM',NULL,NULL,'2022-08-14 04:02:20','2022-09-09 18:01:26'),(5,'Shafiqul Islam','shafiqul.lm@brac.net',NULL,'$2y$10$Wo/ZQqz7rnH.mkPWkAQKq.FqvZPrTlPnpSFs6CM.RwCqLYs5QM0Te','KflXBPN8a91FYsqd1ZP6ZiA8zvH8SGqp0p3MoVGeWLNzdu8bYlojq8JgmzHE','Admin','01700000000',1,'[]',NULL,'BD','','DM',NULL,NULL,'2022-08-23 03:00:11','2022-08-23 03:00:11'),(6,'Lamia Islam','lamia.islam@brac.net',NULL,'$2y$10$.ZFRsrW9P9e.xYH1YB3TJOoUA3KPMSAuttaBAucKTrWM6zRJjO/Ha','N1S5QoipoyiNgqVny2HFNWVdqOtfTJrFqlu81capeTK3ThRqCQ4ERuabhGre','Admin','01700000000',1,'[]',NULL,'BD','','DM',NULL,NULL,'2022-08-23 03:01:09','2022-08-23 03:01:09'),(7,'Sochindra Nath','sochindra.nd@brac.net',NULL,'$2y$10$.xVekawqSYgx7spZ1VBOZuRQYJqXCfEjSrNPOJRHXkaMpSI9SKgJa',NULL,'Admin','01700000000',1,'[]',NULL,'BD','','SM',NULL,NULL,'2022-08-23 03:02:25','2022-08-23 03:25:01'),(8,'Tanvir Alam Sifat','tanvir.sifat@brac.net',NULL,'$2y$10$wMR4x50mdcwX9CjGR5kQNuH7H0q0F7nwy6BIaRVuKbfcvxZzvpJAe',NULL,'Admin','0170000000',1,'[\"user_read\",\"mf_cr_read\"]',NULL,'BD','','DM',NULL,NULL,'2022-08-23 03:03:21','2022-08-23 03:24:43'),(9,'Rakebul Hasan','rakebul.hasan@brac.net',NULL,'$2y$10$5jeGbYVsFgTJPu/oJH81XOdPp/aQWCdJngtRY0qkG56RgMBQJRk4K',NULL,'Admin','01700000000',1,'[]',NULL,'BD','','DM',NULL,NULL,'2022-08-23 03:04:38','2022-08-23 03:24:31'),(10,'Pramit Ganguly','pramit.ganguly@brac.net',NULL,'$2y$10$n7R8QnmnLry5I2B0mrPraOfiSzQIx4GCBI78tuHA87xNjQ6Fr1VCC',NULL,'Admin','01700000000',1,'[]',NULL,'BD','','DM',NULL,NULL,'2022-08-23 03:05:59','2022-08-23 03:24:19'),(11,'Anirban Saha','anirban.ananda@brac.net',NULL,'$2y$10$K2ZdMGQ.UA4ckqzz38BiIuNEAhfcdQazYuk8XTNUMMwKuOJzpCIui',NULL,'Admin','01700000000',1,'[]',NULL,'BD','','SM',NULL,NULL,'2022-08-23 03:06:49','2022-08-23 03:24:05');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
