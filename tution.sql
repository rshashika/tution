/*
SQLyog Ultimate v13.1.1 (32 bit)
MySQL - 10.4.22-MariaDB : Database - tution
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tution` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `tution`;

/*Table structure for table `admins` */

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_plain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `added` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admins` */

insert  into `admins`(`id`,`username`,`password`,`password_plain`,`type`,`status`,`added`,`created_at`,`updated_at`) values 
(1,'admin','e10adc3949ba59abbe56e057f20f883e','','Admin',1,1,NULL,NULL),
(2,'Subadmin','827ccb0eea8a706c4c34a16891f84e7b','12345','Sub Admin',1,NULL,'2023-04-26 04:25:11','2023-04-26 04:25:11');

/*Table structure for table `attendences` */

DROP TABLE IF EXISTS `attendences`;

CREATE TABLE `attendences` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) unsigned NOT NULL,
  `class` int(11) unsigned NOT NULL,
  `teacher` int(11) unsigned NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `result` tinyint(4) NOT NULL,
  `added` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `attendences` */

insert  into `attendences`(`id`,`student_id`,`class`,`teacher`,`subject`,`date`,`result`,`added`,`created_at`,`updated_at`) values 
(1,1223,1,1,'Maths','2023-04-25',1,1,'2023-04-25 09:16:25','2023-04-25 09:16:25'),
(4,1554,1,1,'Maths','2023-04-26',1,1,'2023-04-26 03:40:41','2023-04-26 03:40:41'),
(5,1223,1,1,'Maths','2023-04-26',1,1,'2023-04-26 12:40:08','2023-04-26 12:40:08'),
(10,1554,2,2,'Science','2023-04-27',1,1,'2023-04-27 08:49:51','2023-04-27 08:49:51'),
(24,1223,1,1,'Maths','2023-05-08',1,1,'2023-05-08 17:15:47','2023-05-08 17:15:47'),
(26,1223,1,1,'Maths','2023-05-09',1,1,'2023-05-09 08:28:51','2023-05-09 08:28:51'),
(31,1223,2,2,'Science','2023-05-10',1,1,'2023-05-10 09:43:04','2023-05-10 09:43:04'),
(32,1554,2,2,'Science','2023-05-10',1,1,'2023-05-10 09:46:31','2023-05-10 09:46:31'),
(33,1223,1,1,'Maths','2023-05-10',1,1,'2023-05-10 10:35:12','2023-05-10 10:35:12');

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

/*Table structure for table `feestemps` */

DROP TABLE IF EXISTS `feestemps`;

CREATE TABLE `feestemps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) unsigned NOT NULL,
  `class` int(11) unsigned NOT NULL,
  `amount` int(11) NOT NULL,
  `month_for` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `added` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `feestemps` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2019_08_19_000000_create_failed_jobs_table',1),
(3,'2023_04_21_093551_create_admins_table',1),
(4,'2023_04_21_093809_create_attendences_table',1),
(5,'2023_04_21_093845_create_feestemps_table',1),
(6,'2023_04_21_093927_create_payment_categories_table',1),
(7,'2023_04_21_093945_create_payments_table',1),
(8,'2023_04_21_094025_create_studentin_classes_table',2),
(9,'2023_04_21_094042_create_students_table',2),
(10,'2023_04_21_094110_create_students_fees_table',2),
(11,'2023_04_21_094145_create_teachers_table',2),
(12,'2023_04_21_094211_create_teacher_attends_table',2),
(13,'2023_04_21_094237_create_tutiondays_table',2),
(14,'2023_04_21_094252_create_tutions_table',2),
(15,'2023_04_25_042306_create_student_fees_manages_table',3),
(16,'2023_05_04_152031_create_student_registration_fees_table',4),
(17,'2023_05_04_153436_create_student_registration_fees_temps_table',5),
(18,'2023_05_09_085025_create_student_tutes_table',6),
(19,'2023_05_09_095835_create_tutes_table',7);

/*Table structure for table `payment_categories` */

DROP TABLE IF EXISTS `payment_categories`;

CREATE TABLE `payment_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `added` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `payment_categories` */

insert  into `payment_categories`(`id`,`title`,`amount`,`description`,`is_deleted`,`added`,`created_at`,`updated_at`) values 
(1,'Student',500.00,NULL,0,1,'2023-04-24 08:57:36','2023-04-24 08:57:36');

/*Table structure for table `payments` */

DROP TABLE IF EXISTS `payments`;

CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `receipt_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` int(11) unsigned NOT NULL,
  `payment_date` date NOT NULL,
  `payment_details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `payment_res` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `added` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `payments` */

insert  into `payments`(`id`,`receipt_no`,`student_id`,`payment_date`,`payment_details`,`total`,`payment_res`,`is_deleted`,`added`,`created_at`,`updated_at`) values 
(2,'1682403004',1554,'2023-04-25','[{\"id\":7,\"student_id\":1554,\"class\":1,\"amount\":500,\"month_for\":\"2023-04\",\"added\":1,\"created_at\":\"2023-04-25T06:09:49.000000Z\",\"updated_at\":\"2023-04-25T06:09:49.000000Z\"}]',500.00,'Register',0,1,'2023-04-25 06:10:04','2023-04-25 06:10:04'),
(3,'1682573758',1223,'2023-04-27','[{\"id\":13,\"student_id\":1223,\"class\":2,\"amount\":1500,\"month_for\":\"2023-04\",\"added\":1,\"created_at\":\"2023-04-27T05:35:48.000000Z\",\"updated_at\":\"2023-04-27T05:35:48.000000Z\"}]',1500.00,'Monthly',0,1,'2023-04-27 11:05:58','2023-04-27 11:05:58'),
(4,'1682578232',1544,'2023-04-27','[{\"id\":14,\"student_id\":1544,\"class\":1,\"amount\":500,\"month_for\":\"2023-04\",\"added\":1,\"created_at\":\"2023-04-27T06:47:34.000000Z\",\"updated_at\":\"2023-04-27T06:47:34.000000Z\"}]',500.00,'Register',0,1,'2023-04-27 12:20:32','2023-04-27 12:20:32'),
(5,'1682676731',1554,'2023-04-28','[{\"id\":15,\"student_id\":1554,\"class\":1,\"amount\":1500,\"month_for\":\"2023-04\",\"added\":1,\"created_at\":\"2023-04-28T10:11:55.000000Z\",\"updated_at\":\"2023-04-28T10:11:55.000000Z\"},{\"id\":16,\"student_id\":1554,\"class\":2,\"amount\":1500,\"month_for\":\"2023-04\",\"added\":1,\"created_at\":\"2023-04-28T10:12:05.000000Z\",\"updated_at\":\"2023-04-28T10:12:05.000000Z\"}]',3000.00,'Monthly',0,1,'2023-04-28 15:42:11','2023-04-28 15:42:11'),
(8,'1682677038',1544,'2023-04-28','[{\"id\":17,\"student_id\":1544,\"class\":1,\"amount\":1500,\"month_for\":\"2023-04\",\"added\":1,\"created_at\":\"2023-04-28T10:15:28.000000Z\",\"updated_at\":\"2023-04-28T10:15:28.000000Z\"}]',1500.00,'Monthly',0,1,'2023-04-28 15:47:18','2023-04-28 15:47:18'),
(9,'1682677071',1544,'2023-04-28','[{\"id\":17,\"student_id\":1544,\"class\":1,\"amount\":1500,\"month_for\":\"2023-04\",\"added\":1,\"created_at\":\"2023-04-28T10:15:28.000000Z\",\"updated_at\":\"2023-04-28T10:15:28.000000Z\"},{\"id\":18,\"student_id\":1544,\"class\":2,\"amount\":1500,\"month_for\":\"2023-04\",\"added\":1,\"created_at\":\"2023-04-28T10:17:44.000000Z\",\"updated_at\":\"2023-04-28T10:17:44.000000Z\"}]',3000.00,'Monthly',0,1,'2023-04-28 15:47:51','2023-04-28 15:47:51'),
(13,'1683516222',15445,'2023-05-08','[{\"id\":1,\"student_id\":15445,\"payment_cat\":1,\"amount\":500,\"added\":1,\"created_at\":\"2023-05-08T03:19:15.000000Z\",\"updated_at\":\"2023-05-08T03:19:15.000000Z\"}]',500.00,'Register',0,1,'2023-05-08 08:53:42','2023-05-08 08:53:42');

/*Table structure for table `student_fees_manages` */

DROP TABLE IF EXISTS `student_fees_manages`;

CREATE TABLE `student_fees_manages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) unsigned NOT NULL,
  `class` int(11) unsigned NOT NULL,
  `amount` int(11) NOT NULL,
  `month_for` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fees_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint(4) DEFAULT 0,
  `added` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `student_fees_manages` */

insert  into `student_fees_manages`(`id`,`student_id`,`class`,`amount`,`month_for`,`fees_type`,`is_deleted`,`added`,`created_at`,`updated_at`) values 
(1,1223,1,0,'2023-04','FREE_CARD',0,1,'2023-04-25 05:19:59','2023-04-25 08:06:41'),
(2,1223,1,0,'2023-05','FREE_CARD',0,1,'2023-05-09 08:35:33','2023-05-09 08:35:33');

/*Table structure for table `student_registration_fees` */

DROP TABLE IF EXISTS `student_registration_fees`;

CREATE TABLE `student_registration_fees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) unsigned NOT NULL,
  `payment_cat` int(11) unsigned NOT NULL,
  `amount` int(11) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `added` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `student_registration_fees` */

insert  into `student_registration_fees`(`id`,`student_id`,`payment_cat`,`amount`,`is_deleted`,`added`,`created_at`,`updated_at`,`payment_id`) values 
(1,15445,1,500,0,1,'2023-05-08 08:56:31','2023-05-08 08:56:31',15);

/*Table structure for table `student_registration_fees_temps` */

DROP TABLE IF EXISTS `student_registration_fees_temps`;

CREATE TABLE `student_registration_fees_temps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) unsigned NOT NULL,
  `payment_cat` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `added` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `student_registration_fees_temps` */

/*Table structure for table `student_tutes` */

DROP TABLE IF EXISTS `student_tutes`;

CREATE TABLE `student_tutes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `institute_id` int(10) unsigned NOT NULL,
  `tute_id` int(10) unsigned DEFAULT NULL,
  `student_id` int(10) unsigned NOT NULL,
  `tution_id` int(10) unsigned NOT NULL,
  `month_for` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` int(11) DEFAULT NULL,
  `is_issued` tinyint(4) NOT NULL DEFAULT 0,
  `added` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `student_tutes` */

insert  into `student_tutes`(`id`,`institute_id`,`tute_id`,`student_id`,`tution_id`,`month_for`,`rate`,`is_issued`,`added`,`created_at`,`updated_at`) values 
(1,0,6,1223,1,'2023-05',NULL,0,1,'2023-05-09 12:10:18','2023-05-09 12:10:18'),
(2,0,6,1554,1,'2023-05',100,0,1,'2023-05-09 12:13:15','2023-05-09 12:13:15'),
(3,0,9,1544,1,'2023-05',0,1,1,'2023-05-09 16:09:36','2023-05-09 16:09:36'),
(6,0,1,1223,2,'2023-05',100,1,1,'2023-05-10 09:43:04','2023-05-10 09:43:04'),
(7,0,1,1554,2,'2023-05',100,1,1,'2023-05-10 09:46:32','2023-05-10 09:46:32'),
(8,0,2,1554,1,'2023-05',NULL,1,1,'2023-05-10 15:40:50','2023-05-10 15:40:50'),
(9,0,1,1544,2,'2023-05',100,1,1,'2023-05-11 09:05:50','2023-05-11 09:05:50');

/*Table structure for table `studentin_classes` */

DROP TABLE IF EXISTS `studentin_classes`;

CREATE TABLE `studentin_classes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) unsigned NOT NULL,
  `class` int(11) unsigned NOT NULL,
  `fees_type` enum('FREE_CARD','HALF_CARD','CHARGE') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `join_date` date NOT NULL,
  `added` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `studentin_classes` */

insert  into `studentin_classes`(`id`,`student_id`,`class`,`fees_type`,`join_date`,`added`,`created_at`,`updated_at`) values 
(1,1223,1,'FREE_CARD','2023-04-24',1,'2023-04-24 08:54:45','2023-04-24 08:54:45'),
(2,1554,1,'CHARGE','2023-04-25',1,'2023-04-25 06:09:16','2023-04-25 06:09:16'),
(3,1223,2,'CHARGE','2023-04-25',1,'2023-04-25 07:44:24','2023-04-25 07:44:24'),
(4,1554,2,NULL,'2023-04-27',1,'2023-04-27 08:31:57','2023-04-27 08:31:57'),
(5,1544,1,NULL,'2023-04-27',1,'2023-04-27 12:04:04','2023-04-27 12:04:04'),
(6,1544,2,NULL,'2023-04-27',1,'2023-04-27 12:05:09','2023-04-27 12:05:09'),
(7,14544,1,NULL,'2023-05-04',1,'2023-05-04 15:14:30','2023-05-04 15:14:30');

/*Table structure for table `students` */

DROP TABLE IF EXISTS `students`;

CREATE TABLE `students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admission_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth` date NOT NULL,
  `grade` int(11) NOT NULL DEFAULT 0,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsapp` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_mobile` int(11) DEFAULT NULL,
  `image` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `is_active_sms` tinyint(1) DEFAULT 0,
  `added` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `students` */

insert  into `students`(`id`,`admission_num`,`first_name`,`last_name`,`birth`,`grade`,`address`,`email`,`contact`,`whatsapp`,`parent_name`,`parent_mobile`,`image`,`barcode`,`is_deleted`,`is_active_sms`,`added`,`created_at`,`updated_at`) values 
(1,'1223','sadun','sudaraka','1998-11-15',0,'testt , gdfgdg , fthfhh',NULL,'74757415','754214454','test parent',784451555,'1223.png','1223.svg',0,1,1,'2023-04-24 08:52:05','2023-05-08 16:45:02'),
(2,'1554','Asiri','Sandaruwan','2005-12-05',0,'selfseren , fleblhbffkebfew',NULL,'754514444','754514444','test parent',784451555,'1554.png','1554.svg',0,0,1,'2023-04-25 06:08:14','2023-05-12 16:39:47'),
(3,'1544','Viraj','Bandra','2006-05-01',0,'teft ,trt ,ertryt',NULL,'077548842','0455884555','test parent',784451555,'1544.jpg','1544.svg',0,0,1,'2023-04-27 12:03:05','2023-05-10 11:29:45'),
(4,'14544','rtrt','trtrt','2023-05-04',0,'yuiu','developer@sumithtyre.com','0424424275','0752752772','test parent',784451555,'14544.png','14544.svg',0,0,1,'2023-05-04 15:14:25','2023-05-12 16:39:58'),
(5,'15445','tthh','test','2023-05-08',0,'hfghgfh',NULL,'0424424275','0752752772','test parent',784451555,'15445.png','15445.svg',0,0,1,'2023-05-08 08:26:07','2023-05-12 16:40:07'),
(6,'4544','prasd','dgg','2023-05-26',0,'ththh',NULL,'0595595995',NULL,'test parent',784451555,'text','4544.png',0,0,1,'2023-05-11 11:18:22','2023-05-11 11:18:22');

/*Table structure for table `students_fees` */

DROP TABLE IF EXISTS `students_fees`;

CREATE TABLE `students_fees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) unsigned NOT NULL,
  `tution_id` int(11) unsigned NOT NULL,
  `month_for_pay` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_date` date NOT NULL,
  `fees` decimal(8,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` bigint(11) unsigned DEFAULT NULL,
  `added` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `students_fees` */

insert  into `students_fees`(`id`,`student_id`,`tution_id`,`month_for_pay`,`payment_date`,`fees`,`status`,`payment_id`,`added`,`created_at`,`updated_at`) values 
(1,1223,2,'2023-04','2023-04-27',1500.00,'',NULL,1,'2023-04-27 11:05:58','2023-04-27 11:05:58'),
(2,1554,1,'2023-04','2023-04-28',1500.00,'',5,1,'2023-04-28 15:42:11','2023-04-28 15:42:11'),
(3,1554,2,'2023-04','2023-04-28',1500.00,'',5,1,'2023-04-28 15:42:11','2023-04-28 15:42:11'),
(4,1544,1,'2023-04','2023-04-28',1500.00,'',8,1,'2023-04-28 15:47:18','2023-04-28 15:47:18'),
(5,1544,1,'2023-04','2023-04-28',1500.00,'',9,1,'2023-04-28 15:47:51','2023-04-28 15:47:51'),
(6,1544,2,'2023-04','2023-04-28',1500.00,'',9,1,'2023-04-28 15:47:51','2023-04-28 15:47:51'),
(8,14544,1,'2023-05','2023-05-04',500.00,'',12,0,'2023-05-04 15:15:39','2023-05-04 15:15:39');

/*Table structure for table `teacher_attends` */

DROP TABLE IF EXISTS `teacher_attends`;

CREATE TABLE `teacher_attends` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) unsigned NOT NULL,
  `date` date NOT NULL,
  `result` tinyint(4) NOT NULL,
  `added` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `teacher_attends` */

/*Table structure for table `teachers` */

DROP TABLE IF EXISTS `teachers`;

CREATE TABLE `teachers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth` date NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` int(11) NOT NULL,
  `whatsapp` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `added` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `teachers` */

insert  into `teachers`(`id`,`first_name`,`last_name`,`birth`,`address`,`email`,`contact`,`whatsapp`,`image`,`barcode`,`is_deleted`,`added`,`created_at`,`updated_at`) values 
(1,'asiri','lakruwan','2023-04-24','hhytry , tytytyt',NULL,75412545,NULL,NULL,NULL,0,1,'2023-04-24 08:53:47','2023-04-24 08:53:47'),
(2,'Samantha','Peries','1975-10-24','ghggjhj',NULL,754224151,NULL,NULL,NULL,0,1,'2023-04-25 07:43:18','2023-04-25 07:43:18'),
(3,'Kavishka','Rathnyakae','2023-04-13','tetett',NULL,775445655,NULL,NULL,NULL,0,1,'2023-04-27 12:22:25','2023-04-27 12:22:25');

/*Table structure for table `tutes` */

DROP TABLE IF EXISTS `tutes`;

CREATE TABLE `tutes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `institute_id` int(10) unsigned NOT NULL,
  `tution_id` int(10) unsigned NOT NULL,
  `month_for` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_free` tinyint(1) DEFAULT NULL,
  `price` int(10) unsigned DEFAULT 0,
  `tute_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `added` int(11) NOT NULL,
  `issue_date` date DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tutes` */

insert  into `tutes`(`id`,`institute_id`,`tution_id`,`month_for`,`is_free`,`price`,`tute_name`,`added`,`issue_date`,`is_deleted`,`created_at`,`updated_at`) values 
(1,0,2,'2023-05',0,100,'blog',1,'2023-05-10',0,'2023-05-10 08:21:47','2023-05-10 08:21:47'),
(2,0,1,'2023-05',1,NULL,'tetet',1,'2023-05-10',0,'2023-05-10 12:10:45','2023-05-10 12:10:45'),
(3,0,1,'2023-05',1,NULL,'tetet',1,'2023-05-10',0,'2023-05-10 12:11:16','2023-05-10 12:11:16'),
(4,0,3,'2023-05',1,NULL,'engli99',1,'2023-05-10',0,'2023-05-10 14:51:48','2023-05-10 14:51:48');

/*Table structure for table `tutiondays` */

DROP TABLE IF EXISTS `tutiondays`;

CREATE TABLE `tutiondays` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tution_id` int(11) unsigned NOT NULL,
  `tution_date` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  `added` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tutiondays` */

insert  into `tutiondays`(`id`,`tution_id`,`tution_date`,`status`,`added`,`created_at`,`updated_at`) values 
(1,1,'2023-04-25',1,1,'2023-04-25 03:16:13','2023-04-25 03:16:13'),
(2,1,'2023-04-26',1,1,'2023-04-26 03:22:20','2023-04-26 03:22:20'),
(3,1,'2023-04-25',1,1,'2023-04-25 03:16:13','2023-04-25 03:16:13'),
(5,2,'2023-04-27',1,1,'2023-04-27 08:54:41','2023-04-27 08:54:41'),
(6,1,'2023-05-08',1,1,'2023-05-08 16:48:42','2023-05-08 16:48:42'),
(7,2,'2023-05-08',1,1,'2023-05-08 16:48:42','2023-05-08 16:48:42'),
(8,3,'2023-05-08',1,1,'2023-05-08 16:48:42','2023-05-08 16:48:42'),
(9,1,'2023-05-09',1,1,'2023-05-09 08:26:35','2023-05-09 08:26:35'),
(10,2,'2023-05-09',1,1,'2023-05-09 08:26:35','2023-05-09 08:26:35'),
(11,3,'2023-05-09',1,1,'2023-05-09 08:26:35','2023-05-09 08:26:35'),
(12,1,'2023-05-10',1,1,'2023-05-10 08:15:41','2023-05-10 08:15:41'),
(13,2,'2023-05-10',1,1,'2023-05-10 08:15:41','2023-05-10 08:15:41'),
(14,3,'2023-05-10',1,1,'2023-05-10 08:15:41','2023-05-10 08:15:41');

/*Table structure for table `tutions` */

DROP TABLE IF EXISTS `tutions`;

CREATE TABLE `tutions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `grade` int(11) NOT NULL,
  `teacher` int(11) unsigned NOT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fees` decimal(8,2) NOT NULL,
  `days` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `added` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tutions` */

insert  into `tutions`(`id`,`grade`,`teacher`,`time`,`subject`,`fees`,`days`,`is_deleted`,`added`,`created_at`,`updated_at`) values 
(1,10,1,'8.00-10.00','Maths',1500.00,'monday,tuesday,wednesday,thursday,friday,saturday,sunday',0,1,'2023-04-24 08:54:18','2023-04-25 03:13:55'),
(2,11,2,'10.00-12.00','Science',1500.00,'thursday,friday',0,1,'2023-04-25 07:43:57','2023-04-25 07:43:57'),
(3,10,3,'3.00-5.00','English',1500.00,'friday',0,1,'2023-04-27 12:23:10','2023-04-27 12:23:10');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
