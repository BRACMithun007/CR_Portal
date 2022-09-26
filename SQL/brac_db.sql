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
  `created_at` timestamp NOT NULL DEFAULT '1970-05-20 02:11:10',
  `created_by` int(20) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '1970-05-20 02:11:10',
  `updated_by` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

/*Data for the table `loan_repay_config` */

insert  into `loan_repay_config`(`id`,`loan_amount_start`,`loan_amount_end`,`interest_rate`,`period_in_month`,`monthly_pay_factor`,`disbursement_no_of_date`,`created_at`,`created_by`,`updated_at`,`updated_by`) values (1,0,499999,24,6,0.179,7,'1970-05-20 02:11:10',NULL,'1970-05-20 02:11:10',NULL),(2,0,499999,24,9,0.123,7,'1970-05-20 02:11:10',NULL,'1970-05-20 02:11:10',NULL),(3,0,499999,24,12,0.095,7,'1970-05-20 02:11:10',NULL,'1970-05-20 02:11:10',NULL),(4,0,499999,24,18,0.068,7,'1970-05-20 02:11:10',NULL,'1970-05-20 02:11:10',NULL),(5,0,499999,24,24,0.053,7,'1970-05-20 02:11:10',NULL,'1970-05-20 02:11:10',NULL),(6,500000,999999,22,6,0.175,7,'1970-05-20 02:11:10',NULL,'1970-05-20 02:11:10',NULL),(7,500000,999999,22,9,0.12,7,'1970-05-20 02:11:10',NULL,'1970-05-20 02:11:10',NULL),(8,500000,999999,22,12,0.094,7,'1970-05-20 02:11:10',NULL,'1970-05-20 02:11:10',NULL),(9,500000,999999,22,18,0.066,7,'1970-05-20 02:11:10',NULL,'1970-05-20 02:11:10',NULL),(10,500000,999999,22,24,0.053,7,'1970-05-20 02:11:10',NULL,'1970-05-20 02:11:10',NULL),(11,1000000,6000000,20,6,0.174,7,'1970-05-20 02:11:10',NULL,'1970-05-20 02:11:10',NULL),(12,1000000,6000000,20,9,0.119,7,'1970-05-20 02:11:10',NULL,'1970-05-20 02:11:10',NULL),(13,1000000,6000000,20,12,0.093,7,'1970-05-20 02:11:10',NULL,'1970-05-20 02:11:10',NULL),(14,1000000,6000000,20,18,0.065,7,'1970-05-20 02:11:10',NULL,'1970-05-20 02:11:10',NULL),(15,1000000,6000000,20,24,0.053,7,'1970-05-20 02:11:10',NULL,'1970-05-20 02:11:10',NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`remember_token`,`type`,`phone`,`status`,`photo`,`country`,`occupation`,`designation`,`otp`,`otp_exp_time`,`created_at`,`updated_at`) values (1,'admin','admin@gmail.com',NULL,'$2y$10$NY4OQEKnLRI24qliTS8k5.A36nBZ.0BMKNxjsHKPE1atzSF5cc6ee',NULL,'SuperAdmin',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,'2022-05-20 02:11:10','2022-05-20 02:11:10'),(4,'Mithun','mujahidur.rahman@brac.net',NULL,'$2y$10$O0VZFX7NSuhm4V9lXNFxG.0oMiJAKsP2i5RH5geJ00h7azmYvNjna','Qzer4xUt0N1ZRvxgRyerSRzv4X23v2iC2qeMOU5bAkSYCbQtlleeIWVIQM6W','General','01624231244',1,NULL,'BD','','DM',NULL,NULL,'2022-08-13 18:02:20','2022-08-13 18:02:20');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
