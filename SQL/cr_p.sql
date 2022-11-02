/*
SQLyog Enterprise v10.42 
MySQL - 5.5.5-10.4.22-MariaDB : Database - brac_calc
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`brac_calc` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `cr_portal`;

/*Table structure for table `approvals` */

DROP TABLE IF EXISTS `approvals`;

CREATE TABLE `approvals` (
  `id` int(11) NOT NULL,
  `approval_type` varchar(200) DEFAULT NULL,
  `master_id` int(11) DEFAULT NULL,
  `categoty` varchar(200) DEFAULT NULL,
  `title` varchar(500) DEFAULT NULL,
  `details` varchar(1000) DEFAULT NULL,
  `document` varchar(150) DEFAULT NULL,
  `status` int(4) DEFAULT NULL,
  `approve_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '2022-09-04 22:11:22',
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '2022-09-04 22:11:22',
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `approvals` */

/*Table structure for table `change_request_comments` */

DROP TABLE IF EXISTS `change_request_comments`;

CREATE TABLE `change_request_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cr_master_id` int(11) DEFAULT NULL,
  `comment_type` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment_date` date DEFAULT NULL,
  `comment_by` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '2022-09-23 08:26:36',
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

/*Data for the table `change_request_comments` */

insert  into `change_request_comments`(`id`,`cr_master_id`,`comment_type`,`comment`,`comment_date`,`comment_by`,`status`,`created_at`,`created_by`,`updated_at`,`updated_by`) values (3,12,'Management','test comm','2022-10-07','Arinjoy Dhar',1,'2022-10-07 14:04:45',12,'2022-10-07 14:04:45',12),(4,11,'Management','test 18 m2','2022-10-07','Arinjoy Dhar',1,'2022-10-07 20:43:59',12,'2022-10-07 14:43:59',12);

/*Table structure for table `change_request_master` */

DROP TABLE IF EXISTS `change_request_master`;

CREATE TABLE `change_request_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cr_title` varchar(255) DEFAULT NULL,
  `cr_details` varchar(800) DEFAULT NULL,
  `cr_doc_link` varchar(255) DEFAULT NULL,
  `circular_doc` varchar(255) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4;

/*Data for the table `change_request_master` */

insert  into `change_request_master`(`id`,`cr_title`,`cr_details`,`cr_doc_link`,`circular_doc`,`jira_code`,`jira_created`,`initial_requirement_shared_from_mf`,`approved_billable_effort`,`team_name`,`category`,`cr_locked_by_vendor`,`vendor_name`,`mf_expect_timeline`,`vendor_proposed_timeline`,`requester_team`,`priority`,`cr_type`,`cr_status`,`completed_on`,`business_analyst`,`assigned_from_brac`,`uat_instance`,`uat_credential`,`summary`,`satisfactory_level`,`is_archived`,`created_at`,`created_by`,`updated_at`,`updated_by`) values (4,'Shadhin Loan Excess Frequency','It\'s one time CR. Remove some period of frequency for specific product',NULL,NULL,'BEM-41955','2022-08-31','2022-08-24',NULL,'FAP','Loan',NULL,'BRAC IT',NULL,NULL,'ERP Team',1,'CR','Abandoned',NULL,NULL,'Mithun',NULL,NULL,NULL,NULL,0,'2022-09-04 07:59:32',4,'2022-09-26 20:21:17',4),(5,'Age limit increases (Group lending project)','Age',NULL,NULL,'BEM-41883','2022-08-31','2022-08-18',NULL,'FAP','Savings',NULL,'BRAC IT',NULL,'2022-10-30','CSI team',1,'CR','Ongoing',NULL,NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-04 09:19:37',4,'2022-10-26 08:59:18',1),(6,'Crop Insurance Data Correction (Shibgonj and Jamurhat)','Financial mismatch for two branches',NULL,NULL,'BEM-41776','2022-08-29','2022-08-30',NULL,'FAP','Insurance',NULL,'BRAC IT','2022-09-05','2022-09-07','Crop insurance team',1,'Configurable','Deployed','2022-01-07','Mehbuba Rahman','Shafiqul',NULL,NULL,NULL,'Good',0,'2022-09-04 09:22:38',4,'2022-09-11 06:01:20',4),(7,'Incident Setup_Reason of Incident - Add \"Others\" Option in Dropdown List','Introduce others option in reason of incident',NULL,NULL,'BEM-41446','2022-08-24','2022-08-17',NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'CSI Team',1,'Integration','Deployed','2022-01-14',NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-04 09:37:35',4,'2022-09-19 22:53:38',7),(8,'GBB Update API Validation for Non-working Days & Holidays, Cause of Death & Rejection List Update in ERP','Need to incorporate validation',NULL,NULL,'BEM-41346','2022-08-24',NULL,NULL,'EA','EA_B2B',NULL,'BRAC IT',NULL,NULL,'CSI Team',1,'CR','Deployed',NULL,NULL,'Rakebul',NULL,NULL,NULL,NULL,0,'2022-09-04 09:45:32',4,'2022-09-11 05:20:15',4),(9,'DCS (Dabi, Progoti) - Phase 4_Pre-validations of ERP API','DCS',NULL,NULL,'BEM-40789','2022-08-10',NULL,NULL,'EA','EA_B2C',NULL,'Q Soft',NULL,'2022-10-22','Product Team',1,'CR','Deployed',NULL,NULL,'Tanvir',NULL,NULL,NULL,NULL,0,'2022-09-04 09:53:11',4,'2022-09-11 05:21:59',4),(10,'DCS (Dabi, Progoti) - Phase 3_NID Deduplication API','DCS',NULL,NULL,'BEM-40788','2022-08-10',NULL,NULL,'EA','EA_B2C',NULL,'Q Soft',NULL,'2022-10-22','Product Team',1,'Integration','Deployed','2022-03-10',NULL,'Tanvir',NULL,NULL,NULL,NULL,0,'2022-09-04 20:43:26',4,'2022-09-11 05:24:12',4),(11,'18 Months Dabi Loan','Loan',NULL,NULL,'BEM-40167','2022-07-28',NULL,NULL,'FAP','Loan',NULL,'BRAC IT',NULL,'2022-09-22','Product Team',1,'CR','Ongoing',NULL,NULL,'Lamia',NULL,NULL,NULL,NULL,0,'2022-09-04 20:45:26',4,'2022-09-12 01:45:17',4),(12,'Lien Loan Redesigning','Redesign',NULL,NULL,'BEM-39748','2022-07-25',NULL,NULL,'FAP','Loan',NULL,'BRAC IT',NULL,'2022-10-09','Product Team',1,'CR','Ongoing',NULL,NULL,'Lamia',NULL,NULL,NULL,NULL,0,'2022-09-04 20:47:18',4,'2022-09-12 01:49:20',4),(13,'Alternative Payment Method for Loan Disbursement, Loan & Savings Collection - Phase 3','Alternative Payment Method',NULL,NULL,'BEM-39288','2022-07-14',NULL,NULL,'FAP','Loan',NULL,'BRAC IT',NULL,'2022-09-15','Product Team',1,'Core_Business','Ongoing',NULL,NULL,'Lamia',NULL,NULL,NULL,NULL,0,'2022-09-04 22:10:04',4,'2022-09-12 01:48:01',4),(14,'Change in DCS Consent Paper','DCS',NULL,NULL,'BEM-38118','2022-06-21',NULL,NULL,'EA','EA_B2C',NULL,'Q Soft',NULL,'2022-10-15','Product',1,'CR','Backlog',NULL,NULL,'Tanvir',NULL,NULL,NULL,NULL,0,'2022-09-04 22:11:22',4,'2022-09-11 05:30:20',4),(15,'CSI - Claim Settlement Timeline within 120 Days','CSI',NULL,NULL,'BEM-37541','2022-06-13',NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,'2022-09-30','CSI Team',1,'CR','Backlog',NULL,NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-04 22:12:48',4,'2022-09-12 01:19:41',4),(16,'DPS Collection in TAB Application','DPS',NULL,NULL,'BEM-37538','2022-06-12',NULL,NULL,'EA','EA_B2C',NULL,'Q Soft',NULL,'2022-09-30','Product Team',1,'CR','Ongoing',NULL,NULL,'Tanvir',NULL,NULL,NULL,NULL,0,'2022-09-04 22:13:51',4,'2022-09-11 05:32:35',4),(17,'Adding \"Rocket\" Payment Method in ERP','Rocket',NULL,NULL,'BEM-37537','2022-06-12',NULL,NULL,'FAP','Loan',NULL,'BRAC IT',NULL,'2022-09-11','Digital Cluster Team',1,'CR','Ongoing',NULL,NULL,'Lamia',NULL,NULL,NULL,NULL,0,'2022-09-04 22:15:16',4,'2022-09-11 05:33:46',4),(18,'Collection Amount Field Validation','Collection Amount Field Validation',NULL,NULL,'BEM-27932','2021-11-08',NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'ERP Team',1,'CR','Ongoing',NULL,'Sumaiya Binta Hasan','Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-04 22:20:37',4,'2022-09-20 22:43:23',7),(19,'New API for Shadhin Loan','New API for Shadhin Loan',NULL,NULL,'BEM-22659','2021-08-09',NULL,NULL,'EA','EA_B2B',NULL,'BRAC IT',NULL,NULL,'Product Team',1,'Configurable','Deployed','2022-01-28',NULL,'Rakebul',NULL,NULL,NULL,NULL,0,'2022-09-04 22:22:17',4,'2022-09-14 06:36:39',4),(20,'bKash Unique ID (UID) based Payment System Integration','bKash Unique ID',NULL,NULL,'BEM-557','2020-02-10',NULL,NULL,'EA','EA_B2B',NULL,'BRAC IT',NULL,NULL,'Digital Cluster Team',1,'CR','Ongoing',NULL,NULL,'Rakebul',NULL,NULL,NULL,NULL,0,'2022-09-04 22:27:14',4,'2022-09-11 05:39:32',4),(21,'Nirbhorota Rin Changes','Nirbhorota Rin Changes',NULL,NULL,'BEM-40129','2022-07-28',NULL,NULL,'FAP','Loan',NULL,'BRAC IT',NULL,'2022-10-01','Product Team',2,'CR','Ongoing',NULL,NULL,'Lamia',NULL,NULL,NULL,NULL,0,'2022-09-04 22:28:45',4,'2022-09-11 05:41:03',4),(22,'DPS Insurance Product','DPS Insurance Product',NULL,NULL,'BEM-36334','2022-05-24',NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,'2022-10-01','CSI Team',2,'CR','Ongoing',NULL,NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-04 22:29:46',4,'2022-09-12 01:48:43',4),(23,'MF Performance Dashboard Upgradation','MF Performance Dashboard Up-gradation',NULL,NULL,'BEM-33918','2022-03-29',NULL,NULL,'FAP','Others',NULL,'BRAC IT',NULL,NULL,'ERP Team',2,'Non-CR','Ongoing',NULL,NULL,'Lamia',NULL,NULL,NULL,NULL,0,'2022-09-04 22:32:06',4,'2022-09-12 01:46:00',4),(24,'CSI - Addition of 4 Reports','CSI - Addition of 4 Reports',NULL,NULL,'BEM-40391','2022-08-01',NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'CSI Team',3,'CR','Ongoing',NULL,NULL,'Mithun',NULL,NULL,NULL,NULL,0,'2022-09-04 22:33:23',4,'2022-09-11 05:45:57',4),(25,'Member-wise Loan Collection/Adjustment','Member-wise Loan Collection/Adjustment',NULL,NULL,'BEM-39853','2022-07-26',NULL,NULL,'FAP','Loan',NULL,'BRAC IT',NULL,NULL,'ERP Team',3,'CR','Ongoing',NULL,NULL,'Lamia',NULL,NULL,NULL,NULL,0,'2022-09-04 22:37:22',4,'2022-09-12 01:49:56',4),(26,'Generate Branch-wise MRA Summary Half-yearly Reports through ERP','Generate Branch-wise MRA Summary Half-yearly Reports through ERP',NULL,NULL,'BEM-39657','2022-07-24',NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'ERP Team',3,'CR','Ongoing',NULL,NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-05 21:13:01',4,'2022-09-11 05:48:24',4),(27,'Crop Insurance - Change in Enrollment UI | Settlement Form Report | Data Mismatch in PDF Format of Crop Insurance Enrollment Report | Premium Modification/Cancellation in Account Code-wise Ledger Report','Crop Insurance',NULL,NULL,'BEM-38123','2022-06-21',NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'Crop Insurance Team',3,'CR','Ongoing',NULL,NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-05 21:14:36',4,'2022-09-12 01:46:49',4),(28,'Access of CRUD (Create, Read, Update, Delete) for Demarcations to be Modified/Renamed','Access of CRUD',NULL,NULL,'BEM-38109','2022-06-21',NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'ERP team',3,'CR','Ongoing',NULL,NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-05 21:16:05',4,'2022-09-11 05:50:10',4),(29,'Demarcation-wise Management Report Enhancement (Collection, Disbursement & Target Achievement)','Demarcation-wise Management Report',NULL,NULL,'BEM-27237','2021-10-26',NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,'2022-09-10','ERP Team',3,'CR','Deployed','2022-09-11','Sadia Afrin Snigdha','Shafiqul',NULL,NULL,NULL,'Good',0,'2022-09-05 21:17:22',4,'2022-09-14 06:27:17',4),(30,'Microinsurance (MI) Portal','MI Portal',NULL,NULL,'BEM-729','2020-04-23','2020-04-16',NULL,'FAP','Insurance','2021-12-15','BRAC IT','2022-10-01','2022-10-15','CSI Team',3,'CR','Ongoing',NULL,'Fahmida Rahman','Mithun',NULL,NULL,NULL,NULL,0,'2022-09-05 21:23:14',4,'2022-09-12 01:52:54',4),(31,'Addition of Progoti+ADP Option in 6 Branch-wise Reports','Addition of Progoti+ADP Option in 6 Branch-wise Reports',NULL,NULL,'BEM-33241','2022-03-06',NULL,NULL,'FAP','Insurance',NULL,'BRAC IT','2022-09-05',NULL,'Crop Insurance Team',99,'Data Correction','Deployed','2022-08-24','Arju Akter','Lamia',NULL,NULL,NULL,NULL,0,'2022-09-14 06:39:31',4,'2022-09-14 06:39:31',4),(32,'Crop Insurance Product - Phase 3','Crop Insurance Product - Phase 3',NULL,NULL,'BEM-31137','2022-01-06',NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'Crop Insurance Team',1,'CR','Deployed','2022-08-24','Mehbuba Rahman','Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-14 06:42:32',4,'2022-09-14 06:42:32',4),(33,'DCS (Dabi, Progoti) - Phase 2','DCS (Dabi, Progoti) - Phase 2',NULL,NULL,'BEM-27909','2021-11-07',NULL,NULL,'EA','EA_B2C',NULL,'Q Soft',NULL,NULL,'Client Service',1,'CR','Deployed','2022-08-24',NULL,'Tanvir',NULL,NULL,NULL,NULL,0,'2022-09-14 07:05:32',4,'2022-09-14 07:05:32',4),(34,'DCS (Dabi, Progoti) & CIP Integration - Phase 1','DCS (Dabi, Progoti) & CIP Integration - Phase 1',NULL,NULL,'BEM-1874','2020-06-28',NULL,NULL,'EA','EA_B2C',NULL,'Q Soft',NULL,NULL,'Client Service',1,'CR','Halt','2022-08-24',NULL,'Tanvir',NULL,NULL,NULL,NULL,0,'2022-09-14 07:07:52',4,'2022-09-14 07:07:52',4),(35,'CSI - Maximum Coverage Amount Limit Increase','CSI - Maximum Coverage Amount Limit Increase',NULL,NULL,'BEM-35764','2020-05-26',NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'CSI Team',1,'CR','Halt','2022-08-03',NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-14 07:15:22',4,'2022-09-14 07:15:22',4),(36,'Changing the Report Navigation to New Report Menu titled Others','Changing the Report Navigation to New Report Menu titled Others',NULL,NULL,'BEM-36595','2022-05-29',NULL,NULL,'FAP','Others',NULL,'BRAC IT',NULL,NULL,'Product Team',1,'CR','Deployed','2022-07-30',NULL,'Mithun',NULL,NULL,NULL,NULL,0,'2022-09-14 07:18:36',4,'2022-09-14 07:18:36',4),(37,'ERP - GBB (Guardian BRAC Bima) API Update','ERP - GBB (Guardian BRAC Bima) API Update',NULL,NULL,'BEM-10319','2020-11-12',NULL,NULL,'EA','EA_B2B',NULL,'BRAC IT',NULL,NULL,'CSI Team',1,'CR','Deployed','2022-07-04','Abdullah Al Noman','Rakebul',NULL,NULL,NULL,NULL,0,'2022-09-14 07:21:29',4,'2022-09-14 07:21:29',4),(38,'Alternative Payment Method for Loan Disbursement, Loan & Savings Collection - Phase 1 & 2','Alternative Payment Method for Loan Disbursement, Loan & Savings Collection - Phase 1 & 2',NULL,NULL,'BEM-31504','2022-01-19',NULL,NULL,'FAP','Loan',NULL,'BRAC IT',NULL,NULL,'Digital Cluster Team',1,'CR','Deployed','2022-06-28','Mehbuba Rahman','Lamia',NULL,NULL,NULL,NULL,0,'2022-09-14 07:24:55',4,'2022-09-14 07:24:55',4),(39,'Special Savings Collection Summary Report Logic Change','Special Savings Collection Summary Report Logic Change',NULL,NULL,'BEM-32127','2022-02-06',NULL,NULL,'FAP','Savings',NULL,'BRAC IT',NULL,NULL,'Product Team',1,'CR','Deployed','2022-06-07',NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-14 07:26:59',4,'2022-09-14 07:26:59',4),(40,'CSI - Annexure of 2nd Insurer to 2nd Insurer NID Validation Withdrawal in the ERP CSI Policy','CSI - Annexure of 2nd Insurer to 2nd Insurer NID Validation Withdrawal in the ERP CSI Policy',NULL,NULL,'BEM-36858','2022-05-31',NULL,NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'CSI Team',1,'CR','Deployed','2022-05-31','Fahmida Rahman','Shafiqul',NULL,NULL,NULL,NULL,0,'2022-09-14 07:29:25',4,'2022-09-14 07:29:25',4),(41,'All Loans Interest Provision during Day-close Activities to run at Month-end','All Loans Interest Provision during Day-close Activities to run at Month-end',NULL,NULL,'BEM-33919','2022-05-29',NULL,NULL,'FAP','Loan',NULL,'BRAC IT',NULL,NULL,'Product Team',1,'CR','Deployed','2022-05-26',NULL,'Lamia',NULL,NULL,NULL,NULL,0,'2022-09-14 07:31:49',4,'2022-09-14 07:31:49',4),(42,'Change Requests on bKash Webhook API','Change Requests on bKash Webhook API',NULL,NULL,'BEM-33242','2022-03-06',NULL,NULL,'EA','EA_B2C',NULL,'Q Soft',NULL,NULL,'Client Service Team',1,'CR','Deployed','2022-05-26','Abdullah Al Noman','Tanvir',NULL,NULL,NULL,NULL,0,'2022-09-14 07:35:55',4,'2022-09-14 07:35:55',4),(45,'Final 1','Desc','','Final-1101603490431.pdf',NULL,NULL,'2022-10-16',NULL,'FAP','Insurance',NULL,'BRAC IT',NULL,NULL,'Product Team',99,'Core_Business','Backlog',NULL,NULL,'Mithun',NULL,NULL,NULL,NULL,0,'2022-10-16 04:31:42',1,'2022-10-16 04:31:42',1),(46,'Test Test','dsgdfg','','Test-Test101608324385.pdf',NULL,NULL,'2022-10-16',NULL,'FAO','Loan',NULL,'BRAC IT','2022-10-30',NULL,'Product Team',99,'Support_CR','Backlog',NULL,NULL,'Shafiqul',NULL,NULL,NULL,NULL,0,'2022-10-16 08:43:29',1,'2022-10-16 08:43:29',1),(48,'CR Portal','Det','','CR-Portal101708245314.pdf',NULL,NULL,'2022-10-17',NULL,'FAO','Loan',NULL,'BRAC IT','2022-10-31',NULL,'Product Team',99,'Configurable_Item','Backlog',NULL,NULL,'Lamia',NULL,NULL,NULL,NULL,0,'2022-10-17 08:25:36',1,'2022-10-17 08:25:36',1),(49,'test update','det update','','test-updat102105220769.pdf','4545454 update',NULL,'2022-10-21',NULL,'FAP','Savings','2022-10-22','BRAC IT','2025-08-13',NULL,'Product Team update',99,'Data_Correction','Backlog',NULL,NULL,'Lamia',NULL,NULL,NULL,NULL,0,'2022-10-22 08:30:02',1,'2022-10-22 08:30:02',1);

/*Table structure for table `change_request_updates` */

DROP TABLE IF EXISTS `change_request_updates`;

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
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4;

/*Data for the table `change_request_updates` */

insert  into `change_request_updates`(`id`,`cr_master_id`,`cr_update`,`note_type`,`cr_notes`,`note_date`,`created_at`,`created_by`,`updated_at`,`updated_by`) values (7,5,NULL,'General','Analysis ongoing.','2022-08-30','2022-09-04 09:40:54',4,'2022-09-04 09:55:05',4),(8,4,NULL,'General','Still, no business analyst is assigned.','2022-09-05','2022-09-05 21:24:45',4,'2022-09-05 21:24:45',4),(9,6,NULL,'General','Analysis ongoing','2022-09-01','2022-09-05 21:25:54',4,'2022-09-05 21:25:54',4),(10,7,NULL,'General','Analysis is done. Waiting for CR doc.','2022-09-05','2022-09-05 21:26:25',4,'2022-09-05 21:26:25',4),(11,8,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:26:51',4,'2022-09-05 21:26:51',4),(12,9,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:27:12',4,'2022-09-05 21:27:12',4),(13,10,NULL,'General','UAT is ongoing','2022-09-05','2022-09-05 21:27:36',4,'2022-09-05 21:27:36',4),(14,11,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:28:00',4,'2022-09-05 21:28:00',4),(15,12,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:28:20',4,'2022-09-05 21:28:20',4),(16,13,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:28:39',4,'2022-09-05 21:28:39',4),(17,14,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:29:02',4,'2022-09-05 21:29:02',4),(18,15,NULL,'General','Analysis ongoing. Will get CR doc from BRAC IT','2022-09-05','2022-09-05 21:29:45',4,'2022-09-05 21:29:45',4),(19,16,NULL,'General','Waiting for timeline from BRAC IT','2022-09-05','2022-09-05 21:30:13',4,'2022-09-05 21:30:13',4),(20,17,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:30:35',4,'2022-09-05 21:30:35',4),(21,18,NULL,'General','Release timeline is required.','2022-09-05','2022-09-05 21:31:00',4,'2022-09-05 21:31:00',4),(22,19,NULL,'General','UAT ongoing','2022-09-05','2022-09-05 21:31:39',4,'2022-09-05 21:31:39',4),(23,20,NULL,'General','CR review ongoing','2022-09-05','2022-09-05 21:31:58',4,'2022-09-05 21:31:58',4),(24,21,NULL,'General','Still, no business analyst is assigned.','2022-09-05','2022-09-05 21:32:18',4,'2022-09-05 21:32:18',4),(25,22,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:32:37',4,'2022-09-05 21:32:37',4),(26,23,NULL,'General','Release timeline is required.','2022-09-05','2022-09-05 21:33:01',4,'2022-09-05 21:33:01',4),(27,24,NULL,'General','Currently on halt based on other CR priority','2022-09-05','2022-09-05 21:33:26',4,'2022-09-05 21:33:26',4),(28,25,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:33:54',4,'2022-09-05 21:33:54',4),(29,26,NULL,'General','Analysis ongoing','2022-09-05','2022-09-05 21:34:18',4,'2022-09-05 21:34:18',4),(30,27,NULL,'General','CR doc is approved. Release timeline is required.','2022-09-05','2022-09-05 21:34:56',4,'2022-09-05 21:34:56',4),(31,28,NULL,'General','Previous Jira is (BEF-10641) and Initiated on 20th Feb 2022.Still, no business analyst is assigned.','2022-09-05','2022-09-05 21:35:32',4,'2022-09-05 21:35:32',4),(32,29,NULL,'General','Testing done, LIVE deployment pending.','2022-09-05','2022-09-05 21:35:53',4,'2022-09-05 21:35:53',4),(33,30,NULL,'General','Development on going. Need API sharing timeline from GLIL and BRAC IT','2022-09-05','2022-09-05 21:38:59',4,'2022-09-11 05:58:55',4),(34,30,NULL,'General','Development on going . Need user_email related analysis from BRAC IT','2022-08-30','2022-09-05 21:58:52',4,'2022-09-05 21:58:52',4),(35,30,NULL,'General','Development on going . GLIL will share API by 25th Sep 2022. BRAC IT will share timeline for API.','2022-09-07','2022-09-11 05:55:05',4,'2022-09-11 05:55:05',4),(36,6,NULL,'General','Deployed in live successfully','2022-09-07','2022-09-11 06:01:20',4,'2022-09-11 06:01:20',4),(37,15,NULL,'General','Need the final CR doc. BRAC IT is agreed to share the UAT instance by 30th Sep 2022','2022-09-11','2022-09-12 01:19:41',4,'2022-09-12 01:19:41',4),(38,29,NULL,'General','Release/deploy this CR in LIVE on 11th Sept 22. Need to shift 2 reports to another JIRA','2022-09-11','2022-09-12 01:41:00',4,'2022-09-12 01:41:00',4),(39,11,NULL,'General','BRAC IT is agreed to share the UAT instance by 20th Sep 2022','2022-09-11','2022-09-12 01:45:17',4,'2022-09-12 01:45:17',4),(40,23,NULL,'General','Our expectation is within 30th Sept 2022. Need the release timeline.','2022-09-11','2022-09-12 01:46:00',4,'2022-09-12 01:46:00',4),(41,27,NULL,'General','Development ongoing. Our expectation is within 25th Sept 2022. Need to update CR doc and UAT release timeline.','2022-09-11','2022-09-12 01:46:49',4,'2022-09-12 01:46:49',4),(42,13,NULL,'General','Analysis ongoing.  Need an operational decision.','2022-09-11','2022-09-12 01:48:01',4,'2022-09-12 01:48:01',4),(43,22,NULL,'General','BRAC IT is agreed to share the UAT instance by 1st Oct 2022. Need API discussion with BRAC IT and EA team.','2022-09-11','2022-09-12 01:48:43',4,'2022-09-12 01:48:43',4),(44,12,NULL,'General','BRAC IT is agreed to share the UAT instance by 9th Oct 2022.','2022-09-11','2022-09-12 01:49:20',4,'2022-09-12 01:49:20',4),(45,25,NULL,'General','Need to review the CR with BRAC IT. Our expectation is to have UAT instance by 10th Oct 2022','2022-09-11','2022-09-12 01:49:56',4,'2022-09-12 01:49:56',4),(46,4,NULL,'General','Analysis is done. A approval is pending on Sochin dada.','2022-09-11','2022-09-12 01:50:43',4,'2022-09-12 01:50:43',4),(47,5,NULL,'General','Need the CR draft doc.  BRAC IT is agreed to share the UAT instance by 30th Oct 2022.','2022-09-11','2022-09-12 01:51:22',4,'2022-09-12 01:51:22',4),(48,30,NULL,'General','Development on going . GLIL will share API by 25th Sep 2022. BRAC IT will share timeline for API.','2022-09-11','2022-09-12 01:52:54',4,'2022-09-12 01:52:54',4),(49,7,NULL,'General','test','2022-09-19','2022-09-19 22:53:38',7,'2022-09-19 22:53:38',7),(50,18,NULL,'General','UAT CASES\n\nUAT RESULT\n\n1. Individual Savings collection UI maximum 5 digits. Passed\n\n2. Individual Loan Collection UI maximum 6 digits. Passed\n\n3. Member Loan Collection (Progoti) UI maximum 6 digits. Also, will be applicable for all projects UI if needed (Progoti, ADP, Dabi, BCUP, CDP). Passed\n\n4. NIBL2/ BAD Loan Collection UI maximum 6 digits. Passed\n\n5. Loan and Savings Collection Reconciliation. Passed\n\n6. Rectify Loan and Savings Collection Reconciliation. Passed\n\n7. Savings Collection/With','2022-09-20','2022-09-20 22:36:31',7,'2022-09-20 22:43:23',7),(51,4,NULL,'General','Already created different JIRA for same task and continuing on that JIRA. That\'s why it become closed.','2022-09-26','2022-09-26 20:21:17',4,'2022-09-26 20:21:17',4),(52,5,NULL,'General','xyz','2022-10-19','2022-10-19 09:00:07',1,'2022-10-19 09:00:07',1),(53,5,NULL,'General','Mithun','2022-10-26','2022-10-26 08:59:18',1,'2022-10-26 08:59:18',1);

/*Table structure for table `circular_master` */

DROP TABLE IF EXISTS `circular_master`;

CREATE TABLE `circular_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cr_master_id` int(11) DEFAULT NULL,
  `title` varchar(500) DEFAULT NULL,
  `details` varchar(500) DEFAULT NULL,
  `category` varchar(200) DEFAULT NULL COMMENT 'loan,special savings,general savings,insurance',
  `circular_number` varchar(255) DEFAULT NULL,
  `sign_date` date DEFAULT NULL,
  `circular_type` varchar(200) DEFAULT NULL,
  `effective_date` date DEFAULT NULL,
  `jira_code` varchar(200) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `status_changed_by_id` int(11) DEFAULT NULL,
  `status_changed_by_name` varchar(200) DEFAULT NULL,
  `requester_team` varchar(200) DEFAULT NULL,
  `request_by` varchar(255) DEFAULT NULL,
  `mf_expect_timeline` date DEFAULT NULL,
  `request_on` date DEFAULT NULL,
  `circular_doc` varchar(200) DEFAULT NULL,
  `remarks` varchar(500) DEFAULT NULL,
  `is_archived` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT '2022-09-04 09:45:32',
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '2022-09-04 09:45:32',
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

/*Data for the table `circular_master` */

insert  into `circular_master`(`id`,`cr_master_id`,`title`,`details`,`category`,`circular_number`,`sign_date`,`circular_type`,`effective_date`,`jira_code`,`status`,`status_changed_by_id`,`status_changed_by_name`,`requester_team`,`request_by`,`mf_expect_timeline`,`request_on`,`circular_doc`,`remarks`,`is_archived`,`created_at`,`created_by`,`updated_at`,`updated_by`) values (2,NULL,'werwer','ewrwerwe','loan',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'admin',NULL,NULL,'werwer101103485448.pdf',NULL,0,'2022-10-11 03:48:54',1,'2022-10-11 03:48:54',1),(3,45,'Final 1','Desc','loan',NULL,NULL,NULL,NULL,NULL,'Backlog',1,'admin',NULL,'admin','2022-10-26','2022-10-16','Final-1101603490431.pdf',NULL,0,'2022-10-16 03:49:04',1,'2022-10-16 04:31:42',1),(6,48,'CR Portal','Det','loan',NULL,NULL,NULL,NULL,NULL,'Backlog',1,'admin',NULL,'admin','2022-10-31','2022-10-17','CR-Portal101708245314.pdf',NULL,0,'2022-10-17 08:24:53',1,'2022-10-17 08:25:36',1),(7,NULL,'xyz','xyz','general_savings','4343434 update',NULL,NULL,NULL,NULL,'Submitted',NULL,NULL,'Product Team update','admin','2022-10-20','2022-10-22','xyz101909043922.pdf',NULL,0,'2022-10-19 09:04:39',1,'2022-10-22 08:56:49',1),(8,49,'test update','det update','loan','4343434 update','2025-09-25','Data_Correction','2025-09-26','4545454 update','Backlog',1,'admin','Product Team update','admin','2025-08-13','2022-10-21','test-updat102105220769.pdf',NULL,0,'2022-10-20 08:51:53',1,'2022-10-22 08:30:02',1);

/*Table structure for table `config_loan_premium_calc` */

DROP TABLE IF EXISTS `config_loan_premium_calc`;

CREATE TABLE `config_loan_premium_calc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rate_in_thousand_borrower_less_65` int(5) DEFAULT NULL,
  `rate_in_thousand_borrower_above_65` int(5) DEFAULT NULL,
  `rate_in_thousand_second_less_65` int(5) DEFAULT NULL,
  `rate_in_thousand_second_above_65` int(5) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT '2022-10-20 08:51:53',
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '2022-10-20 08:51:53',
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `config_loan_premium_calc` */

insert  into `config_loan_premium_calc`(`id`,`rate_in_thousand_borrower_less_65`,`rate_in_thousand_borrower_above_65`,`rate_in_thousand_second_less_65`,`rate_in_thousand_second_above_65`,`status`,`created_at`,`created_by`,`updated_at`,`updated_by`) values (1,3,10,3,10,1,'2022-10-20 08:51:53',NULL,'2022-10-20 08:51:53',NULL);

/*Table structure for table `cr_requests` */

DROP TABLE IF EXISTS `cr_requests`;

CREATE TABLE `cr_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cr_title` varchar(255) DEFAULT NULL,
  `cr_details` varchar(800) DEFAULT NULL,
  `cr_doc_link` varchar(255) DEFAULT NULL,
  `jira_code` varchar(255) DEFAULT NULL,
  `jira_created` date DEFAULT NULL,
  `initial_requirement_shared_from_mf` date DEFAULT NULL,
  `team_name` varchar(150) DEFAULT NULL,
  `category` varchar(150) DEFAULT NULL,
  `mf_expect_timeline` date DEFAULT NULL,
  `summary` varchar(500) DEFAULT NULL,
  `is_archived` int(11) DEFAULT 0,
  `cr_status` varchar(255) DEFAULT 'Submitted',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `cr_requests` */

insert  into `cr_requests`(`id`,`cr_title`,`cr_details`,`cr_doc_link`,`jira_code`,`jira_created`,`initial_requirement_shared_from_mf`,`team_name`,`category`,`mf_expect_timeline`,`summary`,`is_archived`,`cr_status`,`created_at`,`created_by`,`updated_at`,`updated_by`) values (1,'fdgffg','ghffh','',NULL,'2022-10-13','2022-10-05','Product Team','Insurance','2022-10-25',NULL,0,'Submitted','2022-10-31 15:51:00',1,'2022-10-31 15:51:00',1);

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

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

DROP TABLE IF EXISTS `loan_repay_config`;

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

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`type`,`phone`,`status`,`user_permission`,`photo`,`country`,`occupation`,`designation`,`otp`,`otp_exp_time`,`created_at`,`updated_at`) values (1,'admin','admin@gmail.com',NULL,'$2y$10$NY4OQEKnLRI24qliTS8k5.A36nBZ.0BMKNxjsHKPE1atzSF5cc6ee',NULL,'SuperAdmin',NULL,1,'[\"calculators\",\"user_read\",\"user_write\",\"mf_cr_read\",\"mf_cr_write\",\"circular_read\",\"circular_write\",\"req_cr_read\",\"req_cr_write\"]',NULL,NULL,NULL,NULL,NULL,NULL,'2022-05-20 12:11:10','2022-05-20 12:11:10'),(4,'Mithun','mujahidur.rahman@brac.net',NULL,'$2y$10$O0VZFX7NSuhm4V9lXNFxG.0oMiJAKsP2i5RH5geJ00h7azmYvNjna','7vMOJORGFXGiWNU8RPcUFnzWRWPmQRkW3Rk3LDQTVP4SPFIJm1Tdu4qukd17','Admin','01624231244',1,'[\"calculators\",\"user_read\",\"user_write\",\"mf_cr_read\",\"mf_cr_write\"]',NULL,'BD','','DM',NULL,NULL,'2022-08-14 04:02:20','2022-09-13 10:15:38'),(5,'Shafiqul Islam','shafiqul.lm@brac.net',NULL,'$2y$10$Wo/ZQqz7rnH.mkPWkAQKq.FqvZPrTlPnpSFs6CM.RwCqLYs5QM0Te','KwZFdrhNBadQhhv41yHIfmpk33s0tUH3wfbV94Ccj1ahNXkC2FTkIR7M9IUL','Admin','01700000000',1,'[\"calculators\",\"user_read\",\"user_write\",\"mf_cr_read\",\"mf_cr_write\",\"circular_read\",\"circular_write\",\"req_cr_read\",\"req_cr_write\"]',NULL,'BD','','DM',NULL,NULL,'2022-08-23 03:00:11','2022-11-02 04:47:12'),(6,'Lamia Islam','lamia.islam@brac.net',NULL,'$2y$10$.ZFRsrW9P9e.xYH1YB3TJOoUA3KPMSAuttaBAucKTrWM6zRJjO/Ha','N1S5QoipoyiNgqVny2HFNWVdqOtfTJrFqlu81capeTK3ThRqCQ4ERuabhGre','Admin','01700000000',1,'[\"calculators\",\"user_read\",\"user_write\",\"mf_cr_read\",\"mf_cr_write\",\"circular_read\",\"circular_write\",\"req_cr_read\",\"req_cr_write\"]',NULL,'BD','','DM',NULL,NULL,'2022-08-23 03:01:09','2022-11-02 04:47:41'),(7,'Sochindra Nath','sochindra.nd@brac.net',NULL,'$2y$10$.xVekawqSYgx7spZ1VBOZuRQYJqXCfEjSrNPOJRHXkaMpSI9SKgJa','2780xwfEwNe5rriNkkgdVOmmowqmBXFxM6elMApwZUbgfstZRu9qZHSr9BpX','Admin','01700000000',1,'[\"calculators\",\"user_read\",\"user_write\",\"mf_cr_read\",\"mf_cr_write\"]',NULL,'BD','','SM',NULL,NULL,'2022-08-23 03:02:25','2022-09-13 10:14:54'),(8,'Tanvir Alam Sifat','tanvir.sifat@brac.net',NULL,'$2y$10$wMR4x50mdcwX9CjGR5kQNuH7H0q0F7nwy6BIaRVuKbfcvxZzvpJAe','bbcKsEtOpgtND5l1gQHhi3ta5EWWqRQd3kBBB6B9bZr1TGl2obj5MuozVODi','Admin','0170000000',1,'[\"calculators\",\"mf_cr_read\",\"mf_cr_write\"]',NULL,'BD','','DM',NULL,NULL,'2022-08-23 03:03:21','2022-09-13 10:14:42'),(9,'Rakebul Hasan','rakebul.hasan@brac.net',NULL,'$2y$10$5jeGbYVsFgTJPu/oJH81XOdPp/aQWCdJngtRY0qkG56RgMBQJRk4K',NULL,'Admin','01700000000',1,'[\"mf_cr_read\",\"mf_cr_write\"]',NULL,'BD','','DM',NULL,NULL,'2022-08-23 03:04:38','2022-09-14 06:25:04'),(10,'Pramit Ganguly','pramit.ganguly@brac.net',NULL,'$2y$10$n7R8QnmnLry5I2B0mrPraOfiSzQIx4GCBI78tuHA87xNjQ6Fr1VCC',NULL,'Admin','01700000000',1,'[\"mf_cr_read\"]',NULL,'BD','','DM',NULL,NULL,'2022-08-23 03:05:59','2022-09-14 06:24:50'),(11,'Anirban Saha','anirban.ananda@brac.net',NULL,'$2y$10$K2ZdMGQ.UA4ckqzz38BiIuNEAhfcdQazYuk8XTNUMMwKuOJzpCIui',NULL,'Admin','01700000000',1,'[\"calculators\",\"user_read\",\"user_write\",\"mf_cr_read\",\"mf_cr_write\"]',NULL,'BD','','SM',NULL,NULL,'2022-08-23 03:06:49','2022-09-13 10:14:03'),(12,'Arinjoy Dhar','arinjoy.dhar@brac.net',NULL,'$2y$10$NY4OQEKnLRI24qliTS8k5.A36nBZ.0BMKNxjsHKPE1atzSF5cc6ee',NULL,'Management','01700000000',1,'[\"calculators\",\"user_read\",\"user_write\",\"mf_cr_read\",\"mf_cr_write\"]',NULL,'BD','','Senior Director',NULL,NULL,'2022-09-22 10:07:09','2022-10-07 13:49:14'),(13,'Md Belayet Hossan','belayet.h@brac.net',NULL,'$2y$10$SQVj8CCAQX7g5UQ7/EaZQ.mM0cOPyQtIKwq8mpIqvsyzNjN0a0UQe',NULL,'Admin','017000000000',1,'[\"calculators\",\"user_read\",\"user_write\",\"mf_cr_read\",\"mf_cr_write\"]',NULL,'BD','','Senior Programme Manager',NULL,NULL,'2022-09-22 10:09:04','2022-09-22 10:09:04'),(14,'Amit Kanti Sarker','amit.ks@brac.net',NULL,'$2y$10$BSfoLK9gYBkGucqOj.ixBO68MS1AoSI286nudIHy0culpdV8HcBgi',NULL,'Admin','01700000000',1,'[\"calculators\",\"user_read\",\"user_write\",\"mf_cr_read\",\"mf_cr_write\"]',NULL,'BD','','Senior Programme Manager',NULL,NULL,'2022-09-22 10:13:38','2022-09-22 10:13:38'),(15,'Sharifa Shermin','sharifa.shermin@brac.net',NULL,'$2y$10$94cCyFb.9dGmvuKZjScFFO7z3pGJLo7SJnmRRhzm.7fqTBWqYdSYu',NULL,'Admin','01700000000',1,'[\"calculators\",\"mf_cr_read\"]',NULL,'BD','','Senior Manager',NULL,NULL,'2022-09-22 10:15:40','2022-09-22 10:15:40');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
