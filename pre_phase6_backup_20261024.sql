-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: lav_sms
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `academic_years`
--

DROP TABLE IF EXISTS `academic_years`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `academic_years` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `year_bs` smallint(5) unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_date_bs` varchar(10) NOT NULL,
  `end_date_bs` varchar(10) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_closed` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `academic_years`
--

LOCK TABLES `academic_years` WRITE;
/*!40000 ALTER TABLE `academic_years` DISABLE KEYS */;
INSERT INTO `academic_years` VALUES (1,'2083/84 BS Updated',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Updated session notes','2026-10-24 12:16:41','2026-10-24 13:54:21'),(2,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 12:16:48','2026-10-24 13:54:05'),(3,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 12:47:01','2026-10-24 13:54:05'),(4,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 12:48:16','2026-10-24 13:54:05'),(5,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 12:58:42','2026-10-24 13:54:05'),(6,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:00:41','2026-10-24 13:54:05'),(7,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:01:08','2026-10-24 13:54:05'),(8,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:02:08','2026-10-24 13:54:05'),(9,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:06:54','2026-10-24 13:54:05'),(10,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:07:22','2026-10-24 13:54:05'),(11,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:07:32','2026-10-24 13:54:05'),(12,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:07:51','2026-10-24 13:54:05'),(13,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:08:15','2026-10-24 13:54:05'),(14,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:10:29','2026-10-24 13:54:05'),(15,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:10:45','2026-10-24 13:54:05'),(16,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:15:44','2026-10-24 13:54:05'),(17,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:15:54','2026-10-24 13:54:05'),(19,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:18:40','2026-10-24 13:54:05'),(20,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:18:50','2026-10-24 13:54:05'),(21,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:36:46','2026-10-24 13:54:05'),(22,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:37:43','2026-10-24 13:54:05'),(23,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:39:13','2026-10-24 13:54:05'),(24,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:49:04','2026-10-24 13:54:05'),(27,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:51:23','2026-10-24 13:54:21'),(32,'2083/84 BS',2083,'2026-04-14','2027-04-13','2083-01-01','2083-12-30',0,0,'Nepali Academic Session 2083/84','2026-10-24 13:54:21','2026-10-24 13:54:21');
/*!40000 ALTER TABLE `academic_years` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance_audit_trails`
--

DROP TABLE IF EXISTS `attendance_audit_trails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendance_audit_trails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attendance_type` varchar(20) NOT NULL,
  `attendance_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `attendance_date` date NOT NULL,
  `attendance_date_bs` varchar(10) NOT NULL,
  `old_status` varchar(20) DEFAULT NULL,
  `new_status` varchar(20) NOT NULL,
  `old_remarks` text DEFAULT NULL,
  `new_remarks` text DEFAULT NULL,
  `action` varchar(30) NOT NULL DEFAULT 'create',
  `modified_by` int(10) unsigned NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attendance_audit_trails_attendance_type_attendance_id_index` (`attendance_type`,`attendance_id`),
  KEY `attendance_audit_trails_attendance_date_index` (`attendance_date`),
  KEY `attendance_audit_trails_user_id_foreign` (`user_id`),
  KEY `attendance_audit_trails_modified_by_foreign` (`modified_by`),
  CONSTRAINT `attendance_audit_trails_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attendance_audit_trails_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance_audit_trails`
--

LOCK TABLES `attendance_audit_trails` WRITE;
/*!40000 ALTER TABLE `attendance_audit_trails` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendance_audit_trails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blood_groups`
--

DROP TABLE IF EXISTS `blood_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blood_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blood_groups`
--

LOCK TABLES `blood_groups` WRITE;
/*!40000 ALTER TABLE `blood_groups` DISABLE KEYS */;
INSERT INTO `blood_groups` VALUES (1,'O-','2026-10-24 05:20:54','2026-10-24 05:20:54'),(2,'O+','2026-10-24 05:20:54','2026-10-24 05:20:54'),(3,'A+','2026-10-24 05:20:54','2026-10-24 05:20:54'),(4,'A-','2026-10-24 05:20:54','2026-10-24 05:20:54'),(5,'B+','2026-10-24 05:20:54','2026-10-24 05:20:54'),(6,'B-','2026-10-24 05:20:54','2026-10-24 05:20:54'),(7,'AB+','2026-10-24 05:20:54','2026-10-24 05:20:54'),(8,'AB-','2026-10-24 05:20:54','2026-10-24 05:20:54');
/*!40000 ALTER TABLE `blood_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_requests`
--

DROP TABLE IF EXISTS `book_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `returned` varchar(255) NOT NULL DEFAULT '0',
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `book_requests_book_id_foreign` (`book_id`),
  KEY `book_requests_user_id_foreign` (`user_id`),
  CONSTRAINT `book_requests_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `book_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_requests`
--

LOCK TABLES `book_requests` WRITE;
/*!40000 ALTER TABLE `book_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `book_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `books` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `my_class_id` int(10) unsigned DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `book_type` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `total_copies` int(11) DEFAULT NULL,
  `issued_copies` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `books_my_class_id_foreign` (`my_class_id`),
  CONSTRAINT `books_my_class_id_foreign` FOREIGN KEY (`my_class_id`) REFERENCES `my_classes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_types`
--

DROP TABLE IF EXISTS `class_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_types`
--

LOCK TABLES `class_types` WRITE;
/*!40000 ALTER TABLE `class_types` DISABLE KEYS */;
INSERT INTO `class_types` VALUES (1,'Creche','C',NULL,NULL),(2,'Pre Nursery','PN',NULL,NULL),(3,'Nursery','N',NULL,NULL),(4,'Primary','P',NULL,NULL),(5,'Junior Secondary','J',NULL,NULL),(6,'Senior Secondary','S',NULL,NULL);
/*!40000 ALTER TABLE `class_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dorms`
--

DROP TABLE IF EXISTS `dorms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dorms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dorms_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dorms`
--

LOCK TABLES `dorms` WRITE;
/*!40000 ALTER TABLE `dorms` DISABLE KEYS */;
INSERT INTO `dorms` VALUES (1,'Faith Hostel',NULL,NULL,NULL),(2,'Peace Hostel',NULL,NULL,NULL),(3,'Grace Hostel',NULL,NULL,NULL),(4,'Success Hostel',NULL,NULL,NULL),(5,'Trust Hostel',NULL,NULL,NULL);
/*!40000 ALTER TABLE `dorms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_records`
--

DROP TABLE IF EXISTS `exam_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `exam_id` int(10) unsigned NOT NULL,
  `student_id` int(10) unsigned NOT NULL,
  `my_class_id` int(10) unsigned NOT NULL,
  `section_id` int(10) unsigned NOT NULL,
  `total` int(11) DEFAULT NULL,
  `ave` varchar(255) DEFAULT NULL,
  `gpa` decimal(3,2) DEFAULT NULL,
  `grade` varchar(5) DEFAULT NULL,
  `result_status` enum('PASS','FAIL','WITHHELD','EXEMPT','PENDING') NOT NULL DEFAULT 'PENDING',
  `attendance_days` smallint(5) unsigned DEFAULT NULL,
  `working_days` smallint(5) unsigned DEFAULT NULL,
  `class_ave` varchar(255) DEFAULT NULL,
  `pos` int(11) DEFAULT NULL,
  `af` varchar(255) DEFAULT NULL,
  `ps` varchar(255) DEFAULT NULL,
  `p_comment` varchar(255) DEFAULT NULL,
  `t_comment` varchar(255) DEFAULT NULL,
  `year` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_records_exam_id_foreign` (`exam_id`),
  KEY `exam_records_my_class_id_foreign` (`my_class_id`),
  KEY `exam_records_student_id_foreign` (`student_id`),
  KEY `exam_records_section_id_foreign` (`section_id`),
  CONSTRAINT `exam_records_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_records_my_class_id_foreign` FOREIGN KEY (`my_class_id`) REFERENCES `my_classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_records_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_records_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_records`
--

LOCK TABLES `exam_records` WRITE;
/*!40000 ALTER TABLE `exam_records` DISABLE KEYS */;
INSERT INTO `exam_records` VALUES (1,1,18,1,1,0,'0',0.00,'NG','FAIL',NULL,NULL,'0',1,NULL,NULL,NULL,NULL,'2018-2019','2026-10-24 12:44:08','2026-10-24 13:54:23');
/*!40000 ALTER TABLE `exam_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exams`
--

DROP TABLE IF EXISTS `exams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `exam_type` varchar(50) NOT NULL DEFAULT 'terminal',
  `term` tinyint(4) NOT NULL,
  `year` varchar(40) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `start_date_bs` varchar(10) DEFAULT NULL,
  `end_date_bs` varchar(10) DEFAULT NULL,
  `status` enum('draft','scheduled','ongoing','completed','published') NOT NULL DEFAULT 'published',
  `description` text DEFAULT NULL,
  `published_by` int(10) unsigned DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `exams_name_year_term_unique` (`name`,`year`,`term`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exams`
--

LOCK TABLES `exams` WRITE;
/*!40000 ALTER TABLE `exams` DISABLE KEYS */;
INSERT INTO `exams` VALUES (1,'first','terminal',1,'2018-2019',NULL,NULL,NULL,NULL,'published',NULL,1,'2026-10-24 13:54:23','2026-10-24 05:36:59','2026-10-24 13:54:23');
/*!40000 ALTER TABLE `exams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `class_type_id` int(10) unsigned DEFAULT NULL,
  `mark_from` tinyint(4) NOT NULL,
  `mark_to` tinyint(4) NOT NULL,
  `grade_point` decimal(3,2) NOT NULL DEFAULT 0.00,
  `remark` varchar(40) DEFAULT NULL,
  `grade_nepali` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `grades_name_class_type_id_remark_unique` (`name`,`class_type_id`,`remark`),
  KEY `grades_class_type_id_foreign` (`class_type_id`),
  CONSTRAINT `grades_class_type_id_foreign` FOREIGN KEY (`class_type_id`) REFERENCES `class_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grades`
--

LOCK TABLES `grades` WRITE;
/*!40000 ALTER TABLE `grades` DISABLE KEYS */;
INSERT INTO `grades` VALUES (1,'A',NULL,70,100,0.00,'Excellent',NULL,NULL,NULL),(2,'B',NULL,60,69,0.00,'Very Good',NULL,NULL,NULL),(3,'C',NULL,50,59,0.00,'Good',NULL,NULL,NULL),(4,'D',NULL,45,49,0.00,'Pass',NULL,NULL,NULL),(5,'E',NULL,40,44,0.00,'Poor',NULL,NULL,NULL),(6,'F',NULL,0,39,0.00,'Fail',NULL,NULL,NULL);
/*!40000 ALTER TABLE `grades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `holidays`
--

DROP TABLE IF EXISTS `holidays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `holidays` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `title_ne` varchar(255) DEFAULT NULL,
  `type` enum('public_holiday','school_holiday','exam_period','academic_event','custom_working_day') NOT NULL DEFAULT 'school_holiday',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_date_bs` varchar(10) NOT NULL,
  `end_date_bs` varchar(10) NOT NULL,
  `is_closure` tinyint(1) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `created_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `holidays`
--

LOCK TABLES `holidays` WRITE;
/*!40000 ALTER TABLE `holidays` DISABLE KEYS */;
INSERT INTO `holidays` VALUES (1,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 12:16:41','2026-10-24 12:16:41'),(2,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 12:16:48','2026-10-24 12:16:48'),(3,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 12:47:01','2026-10-24 12:47:01'),(4,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 12:48:16','2026-10-24 12:48:16'),(5,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 12:58:42','2026-10-24 12:58:42'),(6,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:00:41','2026-10-24 13:00:41'),(7,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:01:08','2026-10-24 13:01:08'),(8,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:02:09','2026-10-24 13:02:09'),(9,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:06:54','2026-10-24 13:06:54'),(10,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:07:22','2026-10-24 13:07:22'),(11,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:07:32','2026-10-24 13:07:32'),(12,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:07:51','2026-10-24 13:07:51'),(13,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:08:15','2026-10-24 13:08:15'),(14,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:10:29','2026-10-24 13:10:29'),(15,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:10:45','2026-10-24 13:10:45'),(16,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:15:45','2026-10-24 13:15:45'),(17,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:15:54','2026-10-24 13:15:54'),(18,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:18:40','2026-10-24 13:18:40'),(19,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:18:50','2026-10-24 13:18:50'),(22,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:36:46','2026-10-24 13:36:46'),(25,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:37:43','2026-10-24 13:37:43'),(27,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:39:13','2026-10-24 13:39:13'),(29,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:49:04','2026-10-24 13:49:04'),(31,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:51:23','2026-10-24 13:51:23'),(33,'Dashain Festival','दशैं पर्व','public_holiday','2026-10-18','2026-11-01','2083-07-01','2083-07-15',1,'Ghatasthapana to Kojagrat Purnima',1,'2026-10-24 13:54:21','2026-10-24 13:54:21');
/*!40000 ALTER TABLE `holidays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lgas`
--

DROP TABLE IF EXISTS `lgas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lgas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `state_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lgas_state_id_foreign` (`state_id`),
  CONSTRAINT `lgas_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=775 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lgas`
--

LOCK TABLES `lgas` WRITE;
/*!40000 ALTER TABLE `lgas` DISABLE KEYS */;
INSERT INTO `lgas` VALUES (1,1,'Aba North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(2,1,'Aba South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(3,1,'Arochukwu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(4,1,'Bende','2026-10-24 05:20:55','2026-10-24 05:20:55'),(5,1,'Ikwuano','2026-10-24 05:20:55','2026-10-24 05:20:55'),(6,1,'Isiala Ngwa North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(7,1,'Isiala Ngwa South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(8,1,'Isuikwuato','2026-10-24 05:20:55','2026-10-24 05:20:55'),(9,1,'Obi Ngwa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(10,1,'Ohafia','2026-10-24 05:20:55','2026-10-24 05:20:55'),(11,1,'Osisioma','2026-10-24 05:20:55','2026-10-24 05:20:55'),(12,1,'Ugwunagbo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(13,1,'Ukwa East','2026-10-24 05:20:55','2026-10-24 05:20:55'),(14,1,'Ukwa West','2026-10-24 05:20:55','2026-10-24 05:20:55'),(15,1,'Umuahia North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(16,1,'Umuahia South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(17,1,'Umu Nneochi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(18,2,'Demsa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(19,2,'Fufure','2026-10-24 05:20:55','2026-10-24 05:20:55'),(20,2,'Ganye','2026-10-24 05:20:55','2026-10-24 05:20:55'),(21,2,'Gayuk','2026-10-24 05:20:55','2026-10-24 05:20:55'),(22,2,'Gombi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(23,2,'Grie','2026-10-24 05:20:55','2026-10-24 05:20:55'),(24,2,'Hong','2026-10-24 05:20:55','2026-10-24 05:20:55'),(25,2,'Jada','2026-10-24 05:20:55','2026-10-24 05:20:55'),(26,2,'Larmurde','2026-10-24 05:20:55','2026-10-24 05:20:55'),(27,2,'Madagali','2026-10-24 05:20:55','2026-10-24 05:20:55'),(28,2,'Maiha','2026-10-24 05:20:55','2026-10-24 05:20:55'),(29,2,'Mayo Belwa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(30,2,'Michika','2026-10-24 05:20:55','2026-10-24 05:20:55'),(31,2,'Mubi North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(32,2,'Mubi South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(33,2,'Numan','2026-10-24 05:20:55','2026-10-24 05:20:55'),(34,2,'Shelleng','2026-10-24 05:20:55','2026-10-24 05:20:55'),(35,2,'Song','2026-10-24 05:20:55','2026-10-24 05:20:55'),(36,2,'Toungo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(37,2,'Yola North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(38,2,'Yola South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(39,3,'Abak','2026-10-24 05:20:55','2026-10-24 05:20:55'),(40,3,'Eastern Obolo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(41,3,'Eket','2026-10-24 05:20:55','2026-10-24 05:20:55'),(42,3,'Esit Eket','2026-10-24 05:20:55','2026-10-24 05:20:55'),(43,3,'Essien Udim','2026-10-24 05:20:55','2026-10-24 05:20:55'),(44,3,'Etim Ekpo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(45,3,'Etinan','2026-10-24 05:20:55','2026-10-24 05:20:55'),(46,3,'Ibeno','2026-10-24 05:20:55','2026-10-24 05:20:55'),(47,3,'Ibesikpo Asutan','2026-10-24 05:20:55','2026-10-24 05:20:55'),(48,3,'Ibiono-Ibom','2026-10-24 05:20:55','2026-10-24 05:20:55'),(49,3,'Ika','2026-10-24 05:20:55','2026-10-24 05:20:55'),(50,3,'Ikono','2026-10-24 05:20:55','2026-10-24 05:20:55'),(51,3,'Ikot Abasi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(52,3,'Ikot Ekpene','2026-10-24 05:20:55','2026-10-24 05:20:55'),(53,3,'Ini','2026-10-24 05:20:55','2026-10-24 05:20:55'),(54,3,'Itu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(55,3,'Mbo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(56,3,'Mkpat-Enin','2026-10-24 05:20:55','2026-10-24 05:20:55'),(57,3,'Nsit-Atai','2026-10-24 05:20:55','2026-10-24 05:20:55'),(58,3,'Nsit-Ibom','2026-10-24 05:20:55','2026-10-24 05:20:55'),(59,3,'Nsit-Ubium','2026-10-24 05:20:55','2026-10-24 05:20:55'),(60,3,'Obot Akara','2026-10-24 05:20:55','2026-10-24 05:20:55'),(61,3,'Okobo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(62,3,'Onna','2026-10-24 05:20:55','2026-10-24 05:20:55'),(63,3,'Oron','2026-10-24 05:20:55','2026-10-24 05:20:55'),(64,3,'Oruk Anam','2026-10-24 05:20:55','2026-10-24 05:20:55'),(65,3,'Udung-Uko','2026-10-24 05:20:55','2026-10-24 05:20:55'),(66,3,'Ukanafun','2026-10-24 05:20:55','2026-10-24 05:20:55'),(67,3,'Uruan','2026-10-24 05:20:55','2026-10-24 05:20:55'),(68,3,'Urue-Offong/Oruko','2026-10-24 05:20:55','2026-10-24 05:20:55'),(69,3,'Uyo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(70,4,'Aguata','2026-10-24 05:20:55','2026-10-24 05:20:55'),(71,4,'Anambra East','2026-10-24 05:20:55','2026-10-24 05:20:55'),(72,4,'Anambra West','2026-10-24 05:20:55','2026-10-24 05:20:55'),(73,4,'Anaocha','2026-10-24 05:20:55','2026-10-24 05:20:55'),(74,4,'Awka North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(75,4,'Awka South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(76,4,'Ayamelum','2026-10-24 05:20:55','2026-10-24 05:20:55'),(77,4,'Dunukofia','2026-10-24 05:20:55','2026-10-24 05:20:55'),(78,4,'Ekwusigo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(79,4,'Idemili North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(80,4,'Idemili South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(81,4,'Ihiala','2026-10-24 05:20:55','2026-10-24 05:20:55'),(82,4,'Njikoka','2026-10-24 05:20:55','2026-10-24 05:20:55'),(83,4,'Nnewi North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(84,4,'Nnewi South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(85,4,'Ogbaru','2026-10-24 05:20:55','2026-10-24 05:20:55'),(86,4,'Onitsha North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(87,4,'Onitsha South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(88,4,'Orumba North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(89,4,'Orumba South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(90,4,'Oyi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(91,5,'Alkaleri','2026-10-24 05:20:55','2026-10-24 05:20:55'),(92,5,'Bauchi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(93,5,'Bogoro','2026-10-24 05:20:55','2026-10-24 05:20:55'),(94,5,'Damban','2026-10-24 05:20:55','2026-10-24 05:20:55'),(95,5,'Darazo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(96,5,'Dass','2026-10-24 05:20:55','2026-10-24 05:20:55'),(97,5,'Gamawa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(98,5,'Ganjuwa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(99,5,'Giade','2026-10-24 05:20:55','2026-10-24 05:20:55'),(100,5,'Itas/Gadau','2026-10-24 05:20:55','2026-10-24 05:20:55'),(101,5,'Jama\'are','2026-10-24 05:20:55','2026-10-24 05:20:55'),(102,5,'Katagum','2026-10-24 05:20:55','2026-10-24 05:20:55'),(103,5,'Kirfi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(104,5,'Misau','2026-10-24 05:20:55','2026-10-24 05:20:55'),(105,5,'Ningi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(106,5,'Shira','2026-10-24 05:20:55','2026-10-24 05:20:55'),(107,5,'Tafawa Balewa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(108,5,'Toro','2026-10-24 05:20:55','2026-10-24 05:20:55'),(109,5,'Warji','2026-10-24 05:20:55','2026-10-24 05:20:55'),(110,5,'Zaki','2026-10-24 05:20:55','2026-10-24 05:20:55'),(111,6,'Brass','2026-10-24 05:20:55','2026-10-24 05:20:55'),(112,6,'Ekeremor','2026-10-24 05:20:55','2026-10-24 05:20:55'),(113,6,'Kolokuma/Opokuma','2026-10-24 05:20:55','2026-10-24 05:20:55'),(114,6,'Nembe','2026-10-24 05:20:55','2026-10-24 05:20:55'),(115,6,'Ogbia','2026-10-24 05:20:55','2026-10-24 05:20:55'),(116,6,'Sagbama','2026-10-24 05:20:55','2026-10-24 05:20:55'),(117,6,'Southern Ijaw','2026-10-24 05:20:55','2026-10-24 05:20:55'),(118,6,'Yenagoa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(119,7,'Agatu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(120,7,'Apa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(121,7,'Ado','2026-10-24 05:20:55','2026-10-24 05:20:55'),(122,7,'Buruku','2026-10-24 05:20:55','2026-10-24 05:20:55'),(123,7,'Gboko','2026-10-24 05:20:55','2026-10-24 05:20:55'),(124,7,'Guma','2026-10-24 05:20:55','2026-10-24 05:20:55'),(125,7,'Gwer East','2026-10-24 05:20:55','2026-10-24 05:20:55'),(126,7,'Gwer West','2026-10-24 05:20:55','2026-10-24 05:20:55'),(127,7,'Katsina-Ala','2026-10-24 05:20:55','2026-10-24 05:20:55'),(128,7,'Konshisha','2026-10-24 05:20:55','2026-10-24 05:20:55'),(129,7,'Kwande','2026-10-24 05:20:55','2026-10-24 05:20:55'),(130,7,'Logo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(131,7,'Makurdi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(132,7,'Obi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(133,7,'Ogbadibo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(134,7,'Ohimini','2026-10-24 05:20:55','2026-10-24 05:20:55'),(135,7,'Oju','2026-10-24 05:20:55','2026-10-24 05:20:55'),(136,7,'Okpokwu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(137,7,'Oturkpo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(138,7,'Tarka','2026-10-24 05:20:55','2026-10-24 05:20:55'),(139,7,'Ukum','2026-10-24 05:20:55','2026-10-24 05:20:55'),(140,7,'Ushongo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(141,7,'Vandeikya','2026-10-24 05:20:55','2026-10-24 05:20:55'),(142,8,'Abadam','2026-10-24 05:20:55','2026-10-24 05:20:55'),(143,8,'Askira/Uba','2026-10-24 05:20:55','2026-10-24 05:20:55'),(144,8,'Bama','2026-10-24 05:20:55','2026-10-24 05:20:55'),(145,8,'Bayo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(146,8,'Biu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(147,8,'Chibok','2026-10-24 05:20:55','2026-10-24 05:20:55'),(148,8,'Damboa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(149,8,'Dikwa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(150,8,'Gubio','2026-10-24 05:20:55','2026-10-24 05:20:55'),(151,8,'Guzamala','2026-10-24 05:20:55','2026-10-24 05:20:55'),(152,8,'Gwoza','2026-10-24 05:20:55','2026-10-24 05:20:55'),(153,8,'Hawul','2026-10-24 05:20:55','2026-10-24 05:20:55'),(154,8,'Jere','2026-10-24 05:20:55','2026-10-24 05:20:55'),(155,8,'Kaga','2026-10-24 05:20:55','2026-10-24 05:20:55'),(156,8,'Kala/Balge','2026-10-24 05:20:55','2026-10-24 05:20:55'),(157,8,'Konduga','2026-10-24 05:20:55','2026-10-24 05:20:55'),(158,8,'Kukawa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(159,8,'Kwaya Kusar','2026-10-24 05:20:55','2026-10-24 05:20:55'),(160,8,'Mafa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(161,8,'Magumeri','2026-10-24 05:20:55','2026-10-24 05:20:55'),(162,8,'Maiduguri','2026-10-24 05:20:55','2026-10-24 05:20:55'),(163,8,'Marte','2026-10-24 05:20:55','2026-10-24 05:20:55'),(164,8,'Mobbar','2026-10-24 05:20:55','2026-10-24 05:20:55'),(165,8,'Monguno','2026-10-24 05:20:55','2026-10-24 05:20:55'),(166,8,'Ngala','2026-10-24 05:20:55','2026-10-24 05:20:55'),(167,8,'Nganzai','2026-10-24 05:20:55','2026-10-24 05:20:55'),(168,8,'Shani','2026-10-24 05:20:55','2026-10-24 05:20:55'),(169,9,'Abi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(170,9,'Akamkpa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(171,9,'Akpabuyo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(172,9,'Bakassi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(173,9,'Bekwarra','2026-10-24 05:20:55','2026-10-24 05:20:55'),(174,9,'Biase','2026-10-24 05:20:55','2026-10-24 05:20:55'),(175,9,'Boki','2026-10-24 05:20:55','2026-10-24 05:20:55'),(176,9,'Calabar Municipal','2026-10-24 05:20:55','2026-10-24 05:20:55'),(177,9,'Calabar South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(178,9,'Etung','2026-10-24 05:20:55','2026-10-24 05:20:55'),(179,9,'Ikom','2026-10-24 05:20:55','2026-10-24 05:20:55'),(180,9,'Obanliku','2026-10-24 05:20:55','2026-10-24 05:20:55'),(181,9,'Obubra','2026-10-24 05:20:55','2026-10-24 05:20:55'),(182,9,'Obudu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(183,9,'Odukpani','2026-10-24 05:20:55','2026-10-24 05:20:55'),(184,9,'Ogoja','2026-10-24 05:20:55','2026-10-24 05:20:55'),(185,9,'Yakuur','2026-10-24 05:20:55','2026-10-24 05:20:55'),(186,9,'Yala','2026-10-24 05:20:55','2026-10-24 05:20:55'),(187,10,'Aniocha North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(188,10,'Aniocha South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(189,10,'Bomadi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(190,10,'Burutu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(191,10,'Ethiope East','2026-10-24 05:20:55','2026-10-24 05:20:55'),(192,10,'Ethiope West','2026-10-24 05:20:55','2026-10-24 05:20:55'),(193,10,'Ika North East','2026-10-24 05:20:55','2026-10-24 05:20:55'),(194,10,'Ika South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(195,10,'Isoko North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(196,10,'Isoko South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(197,10,'Ndokwa East','2026-10-24 05:20:55','2026-10-24 05:20:55'),(198,10,'Ndokwa West','2026-10-24 05:20:55','2026-10-24 05:20:55'),(199,10,'Okpe','2026-10-24 05:20:55','2026-10-24 05:20:55'),(200,10,'Oshimili North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(201,10,'Oshimili South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(202,10,'Patani','2026-10-24 05:20:55','2026-10-24 05:20:55'),(203,10,'Sapele, Delta','2026-10-24 05:20:55','2026-10-24 05:20:55'),(204,10,'Udu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(205,10,'Ughelli North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(206,10,'Ughelli South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(207,10,'Ukwuani','2026-10-24 05:20:55','2026-10-24 05:20:55'),(208,10,'Uvwie','2026-10-24 05:20:55','2026-10-24 05:20:55'),(209,10,'Warri North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(210,10,'Warri South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(211,10,'Warri South West','2026-10-24 05:20:55','2026-10-24 05:20:55'),(212,11,'Abakaliki','2026-10-24 05:20:55','2026-10-24 05:20:55'),(213,11,'Afikpo North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(214,11,'Afikpo South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(215,11,'Ebonyi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(216,11,'Ezza North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(217,11,'Ezza South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(218,11,'Ikwo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(219,11,'Ishielu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(220,11,'Ivo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(221,11,'Izzi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(222,11,'Ohaozara','2026-10-24 05:20:55','2026-10-24 05:20:55'),(223,11,'Ohaukwu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(224,11,'Onicha','2026-10-24 05:20:55','2026-10-24 05:20:55'),(225,12,'Akoko-Edo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(226,12,'Egor','2026-10-24 05:20:55','2026-10-24 05:20:55'),(227,12,'Esan Central','2026-10-24 05:20:55','2026-10-24 05:20:55'),(228,12,'Esan North-East','2026-10-24 05:20:55','2026-10-24 05:20:55'),(229,12,'Esan South-East','2026-10-24 05:20:55','2026-10-24 05:20:55'),(230,12,'Esan West','2026-10-24 05:20:55','2026-10-24 05:20:55'),(231,12,'Etsako Central','2026-10-24 05:20:55','2026-10-24 05:20:55'),(232,12,'Etsako East','2026-10-24 05:20:55','2026-10-24 05:20:55'),(233,12,'Etsako West','2026-10-24 05:20:55','2026-10-24 05:20:55'),(234,12,'Igueben','2026-10-24 05:20:55','2026-10-24 05:20:55'),(235,12,'Ikpoba Okha','2026-10-24 05:20:55','2026-10-24 05:20:55'),(236,12,'Orhionmwon','2026-10-24 05:20:55','2026-10-24 05:20:55'),(237,12,'Oredo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(238,12,'Ovia North-East','2026-10-24 05:20:55','2026-10-24 05:20:55'),(239,12,'Ovia South-West','2026-10-24 05:20:55','2026-10-24 05:20:55'),(240,12,'Owan East','2026-10-24 05:20:55','2026-10-24 05:20:55'),(241,12,'Owan West','2026-10-24 05:20:55','2026-10-24 05:20:55'),(242,12,'Uhunmwonde','2026-10-24 05:20:55','2026-10-24 05:20:55'),(243,13,'Ado Ekiti','2026-10-24 05:20:55','2026-10-24 05:20:55'),(244,13,'Efon','2026-10-24 05:20:55','2026-10-24 05:20:55'),(245,13,'Ekiti East','2026-10-24 05:20:55','2026-10-24 05:20:55'),(246,13,'Ekiti South-West','2026-10-24 05:20:55','2026-10-24 05:20:55'),(247,13,'Ekiti West','2026-10-24 05:20:55','2026-10-24 05:20:55'),(248,13,'Emure','2026-10-24 05:20:55','2026-10-24 05:20:55'),(249,13,'Gbonyin','2026-10-24 05:20:55','2026-10-24 05:20:55'),(250,13,'Ido Osi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(251,13,'Ijero','2026-10-24 05:20:55','2026-10-24 05:20:55'),(252,13,'Ikere','2026-10-24 05:20:55','2026-10-24 05:20:55'),(253,13,'Ikole','2026-10-24 05:20:55','2026-10-24 05:20:55'),(254,13,'Ilejemeje','2026-10-24 05:20:55','2026-10-24 05:20:55'),(255,13,'Irepodun/Ifelodun','2026-10-24 05:20:55','2026-10-24 05:20:55'),(256,13,'Ise/Orun','2026-10-24 05:20:55','2026-10-24 05:20:55'),(257,13,'Moba','2026-10-24 05:20:55','2026-10-24 05:20:55'),(258,13,'Oye','2026-10-24 05:20:55','2026-10-24 05:20:55'),(259,14,'Aninri','2026-10-24 05:20:55','2026-10-24 05:20:55'),(260,14,'Awgu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(261,14,'Enugu East','2026-10-24 05:20:55','2026-10-24 05:20:55'),(262,14,'Enugu North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(263,14,'Enugu South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(264,14,'Ezeagu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(265,14,'Igbo Etiti','2026-10-24 05:20:55','2026-10-24 05:20:55'),(266,14,'Igbo Eze North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(267,14,'Igbo Eze South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(268,14,'Isi Uzo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(269,14,'Nkanu East','2026-10-24 05:20:55','2026-10-24 05:20:55'),(270,14,'Nkanu West','2026-10-24 05:20:55','2026-10-24 05:20:55'),(271,14,'Nsukka','2026-10-24 05:20:55','2026-10-24 05:20:55'),(272,14,'Oji River','2026-10-24 05:20:55','2026-10-24 05:20:55'),(273,14,'Udenu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(274,14,'Udi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(275,14,'Uzo Uwani','2026-10-24 05:20:55','2026-10-24 05:20:55'),(276,15,'Abaji','2026-10-24 05:20:55','2026-10-24 05:20:55'),(277,15,'Bwari','2026-10-24 05:20:55','2026-10-24 05:20:55'),(278,15,'Gwagwalada','2026-10-24 05:20:55','2026-10-24 05:20:55'),(279,15,'Kuje','2026-10-24 05:20:55','2026-10-24 05:20:55'),(280,15,'Kwali','2026-10-24 05:20:55','2026-10-24 05:20:55'),(281,15,'Municipal Area Council','2026-10-24 05:20:55','2026-10-24 05:20:55'),(282,16,'Akko','2026-10-24 05:20:55','2026-10-24 05:20:55'),(283,16,'Balanga','2026-10-24 05:20:55','2026-10-24 05:20:55'),(284,16,'Billiri','2026-10-24 05:20:55','2026-10-24 05:20:55'),(285,16,'Dukku','2026-10-24 05:20:55','2026-10-24 05:20:55'),(286,16,'Funakaye','2026-10-24 05:20:55','2026-10-24 05:20:55'),(287,16,'Gombe','2026-10-24 05:20:55','2026-10-24 05:20:55'),(288,16,'Kaltungo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(289,16,'Kwami','2026-10-24 05:20:55','2026-10-24 05:20:55'),(290,16,'Nafada','2026-10-24 05:20:55','2026-10-24 05:20:55'),(291,16,'Shongom','2026-10-24 05:20:55','2026-10-24 05:20:55'),(292,16,'Yamaltu/Deba','2026-10-24 05:20:55','2026-10-24 05:20:55'),(293,17,'Aboh Mbaise','2026-10-24 05:20:55','2026-10-24 05:20:55'),(294,17,'Ahiazu Mbaise','2026-10-24 05:20:55','2026-10-24 05:20:55'),(295,17,'Ehime Mbano','2026-10-24 05:20:55','2026-10-24 05:20:55'),(296,17,'Ezinihitte','2026-10-24 05:20:55','2026-10-24 05:20:55'),(297,17,'Ideato North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(298,17,'Ideato South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(299,17,'Ihitte/Uboma','2026-10-24 05:20:55','2026-10-24 05:20:55'),(300,17,'Ikeduru','2026-10-24 05:20:55','2026-10-24 05:20:55'),(301,17,'Isiala Mbano','2026-10-24 05:20:55','2026-10-24 05:20:55'),(302,17,'Isu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(303,17,'Mbaitoli','2026-10-24 05:20:55','2026-10-24 05:20:55'),(304,17,'Ngor Okpala','2026-10-24 05:20:55','2026-10-24 05:20:55'),(305,17,'Njaba','2026-10-24 05:20:55','2026-10-24 05:20:55'),(306,17,'Nkwerre','2026-10-24 05:20:55','2026-10-24 05:20:55'),(307,17,'Nwangele','2026-10-24 05:20:55','2026-10-24 05:20:55'),(308,17,'Obowo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(309,17,'Oguta','2026-10-24 05:20:55','2026-10-24 05:20:55'),(310,17,'Ohaji/Egbema','2026-10-24 05:20:55','2026-10-24 05:20:55'),(311,17,'Okigwe','2026-10-24 05:20:55','2026-10-24 05:20:55'),(312,17,'Orlu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(313,17,'Orsu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(314,17,'Oru East','2026-10-24 05:20:55','2026-10-24 05:20:55'),(315,17,'Oru West','2026-10-24 05:20:55','2026-10-24 05:20:55'),(316,17,'Owerri Municipal','2026-10-24 05:20:55','2026-10-24 05:20:55'),(317,17,'Owerri North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(318,17,'Owerri West','2026-10-24 05:20:55','2026-10-24 05:20:55'),(319,17,'Unuimo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(320,18,'Auyo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(321,18,'Babura','2026-10-24 05:20:55','2026-10-24 05:20:55'),(322,18,'Biriniwa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(323,18,'Birnin Kudu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(324,18,'Buji','2026-10-24 05:20:55','2026-10-24 05:20:55'),(325,18,'Dutse','2026-10-24 05:20:55','2026-10-24 05:20:55'),(326,18,'Gagarawa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(327,18,'Garki','2026-10-24 05:20:55','2026-10-24 05:20:55'),(328,18,'Gumel','2026-10-24 05:20:55','2026-10-24 05:20:55'),(329,18,'Guri','2026-10-24 05:20:55','2026-10-24 05:20:55'),(330,18,'Gwaram','2026-10-24 05:20:55','2026-10-24 05:20:55'),(331,18,'Gwiwa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(332,18,'Hadejia','2026-10-24 05:20:55','2026-10-24 05:20:55'),(333,18,'Jahun','2026-10-24 05:20:55','2026-10-24 05:20:55'),(334,18,'Kafin Hausa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(335,18,'Kazaure','2026-10-24 05:20:55','2026-10-24 05:20:55'),(336,18,'Kiri Kasama','2026-10-24 05:20:55','2026-10-24 05:20:55'),(337,18,'Kiyawa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(338,18,'Kaugama','2026-10-24 05:20:55','2026-10-24 05:20:55'),(339,18,'Maigatari','2026-10-24 05:20:55','2026-10-24 05:20:55'),(340,18,'Malam Madori','2026-10-24 05:20:55','2026-10-24 05:20:55'),(341,18,'Miga','2026-10-24 05:20:55','2026-10-24 05:20:55'),(342,18,'Ringim','2026-10-24 05:20:55','2026-10-24 05:20:55'),(343,18,'Roni','2026-10-24 05:20:55','2026-10-24 05:20:55'),(344,18,'Sule Tankarkar','2026-10-24 05:20:55','2026-10-24 05:20:55'),(345,18,'Taura','2026-10-24 05:20:55','2026-10-24 05:20:55'),(346,18,'Yankwashi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(347,19,'Birnin Gwari','2026-10-24 05:20:55','2026-10-24 05:20:55'),(348,19,'Chikun','2026-10-24 05:20:55','2026-10-24 05:20:55'),(349,19,'Giwa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(350,19,'Igabi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(351,19,'Ikara','2026-10-24 05:20:55','2026-10-24 05:20:55'),(352,19,'Jaba','2026-10-24 05:20:55','2026-10-24 05:20:55'),(353,19,'Jema\'a','2026-10-24 05:20:55','2026-10-24 05:20:55'),(354,19,'Kachia','2026-10-24 05:20:55','2026-10-24 05:20:55'),(355,19,'Kaduna North','2026-10-24 05:20:55','2026-10-24 05:20:55'),(356,19,'Kaduna South','2026-10-24 05:20:55','2026-10-24 05:20:55'),(357,19,'Kagarko','2026-10-24 05:20:55','2026-10-24 05:20:55'),(358,19,'Kajuru','2026-10-24 05:20:55','2026-10-24 05:20:55'),(359,19,'Kaura','2026-10-24 05:20:55','2026-10-24 05:20:55'),(360,19,'Kauru','2026-10-24 05:20:55','2026-10-24 05:20:55'),(361,19,'Kubau','2026-10-24 05:20:55','2026-10-24 05:20:55'),(362,19,'Kudan','2026-10-24 05:20:55','2026-10-24 05:20:55'),(363,19,'Lere','2026-10-24 05:20:55','2026-10-24 05:20:55'),(364,19,'Makarfi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(365,19,'Sabon Gari','2026-10-24 05:20:55','2026-10-24 05:20:55'),(366,19,'Sanga','2026-10-24 05:20:55','2026-10-24 05:20:55'),(367,19,'Soba','2026-10-24 05:20:55','2026-10-24 05:20:55'),(368,19,'Zangon Kataf','2026-10-24 05:20:55','2026-10-24 05:20:55'),(369,19,'Zaria','2026-10-24 05:20:55','2026-10-24 05:20:55'),(370,20,'Ajingi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(371,20,'Albasu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(372,20,'Bagwai','2026-10-24 05:20:55','2026-10-24 05:20:55'),(373,20,'Bebeji','2026-10-24 05:20:55','2026-10-24 05:20:55'),(374,20,'Bichi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(375,20,'Bunkure','2026-10-24 05:20:55','2026-10-24 05:20:55'),(376,20,'Dala','2026-10-24 05:20:56','2026-10-24 05:20:56'),(377,20,'Dambatta','2026-10-24 05:20:56','2026-10-24 05:20:56'),(378,20,'Dawakin Kudu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(379,20,'Dawakin Tofa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(380,20,'Doguwa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(381,20,'Fagge','2026-10-24 05:20:56','2026-10-24 05:20:56'),(382,20,'Gabasawa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(383,20,'Garko','2026-10-24 05:20:56','2026-10-24 05:20:56'),(384,20,'Garun Mallam','2026-10-24 05:20:56','2026-10-24 05:20:56'),(385,20,'Gaya','2026-10-24 05:20:56','2026-10-24 05:20:56'),(386,20,'Gezawa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(387,20,'Gwale','2026-10-24 05:20:56','2026-10-24 05:20:56'),(388,20,'Gwarzo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(389,20,'Kabo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(390,20,'Kano Municipal','2026-10-24 05:20:56','2026-10-24 05:20:56'),(391,20,'Karaye','2026-10-24 05:20:56','2026-10-24 05:20:56'),(392,20,'Kibiya','2026-10-24 05:20:56','2026-10-24 05:20:56'),(393,20,'Kiru','2026-10-24 05:20:56','2026-10-24 05:20:56'),(394,20,'Kumbotso','2026-10-24 05:20:56','2026-10-24 05:20:56'),(395,20,'Kunchi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(396,20,'Kura','2026-10-24 05:20:56','2026-10-24 05:20:56'),(397,20,'Madobi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(398,20,'Makoda','2026-10-24 05:20:56','2026-10-24 05:20:56'),(399,20,'Minjibir','2026-10-24 05:20:56','2026-10-24 05:20:56'),(400,20,'Nasarawa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(401,20,'Rano','2026-10-24 05:20:56','2026-10-24 05:20:56'),(402,20,'Rimin Gado','2026-10-24 05:20:56','2026-10-24 05:20:56'),(403,20,'Rogo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(404,20,'Shanono','2026-10-24 05:20:56','2026-10-24 05:20:56'),(405,20,'Sumaila','2026-10-24 05:20:56','2026-10-24 05:20:56'),(406,20,'Takai','2026-10-24 05:20:56','2026-10-24 05:20:56'),(407,20,'Tarauni','2026-10-24 05:20:56','2026-10-24 05:20:56'),(408,20,'Tofa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(409,20,'Tsanyawa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(410,20,'Tudun Wada','2026-10-24 05:20:56','2026-10-24 05:20:56'),(411,20,'Ungogo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(412,20,'Warawa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(413,20,'Wudil','2026-10-24 05:20:56','2026-10-24 05:20:56'),(414,21,'Bakori','2026-10-24 05:20:56','2026-10-24 05:20:56'),(415,21,'Batagarawa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(416,21,'Batsari','2026-10-24 05:20:56','2026-10-24 05:20:56'),(417,21,'Baure','2026-10-24 05:20:56','2026-10-24 05:20:56'),(418,21,'Bindawa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(419,21,'Charanchi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(420,21,'Dandume','2026-10-24 05:20:56','2026-10-24 05:20:56'),(421,21,'Danja','2026-10-24 05:20:56','2026-10-24 05:20:56'),(422,21,'Dan Musa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(423,21,'Daura','2026-10-24 05:20:56','2026-10-24 05:20:56'),(424,21,'Dutsi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(425,21,'Dutsin Ma','2026-10-24 05:20:56','2026-10-24 05:20:56'),(426,21,'Faskari','2026-10-24 05:20:56','2026-10-24 05:20:56'),(427,21,'Funtua','2026-10-24 05:20:56','2026-10-24 05:20:56'),(428,21,'Ingawa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(429,21,'Jibia','2026-10-24 05:20:56','2026-10-24 05:20:56'),(430,21,'Kafur','2026-10-24 05:20:56','2026-10-24 05:20:56'),(431,21,'Kaita','2026-10-24 05:20:56','2026-10-24 05:20:56'),(432,21,'Kankara','2026-10-24 05:20:56','2026-10-24 05:20:56'),(433,21,'Kankia','2026-10-24 05:20:56','2026-10-24 05:20:56'),(434,21,'Katsina','2026-10-24 05:20:56','2026-10-24 05:20:56'),(435,21,'Kurfi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(436,21,'Kusada','2026-10-24 05:20:56','2026-10-24 05:20:56'),(437,21,'Mai\'Adua','2026-10-24 05:20:56','2026-10-24 05:20:56'),(438,21,'Malumfashi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(439,21,'Mani','2026-10-24 05:20:56','2026-10-24 05:20:56'),(440,21,'Mashi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(441,21,'Matazu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(442,21,'Musawa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(443,21,'Rimi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(444,21,'Sabuwa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(445,21,'Safana','2026-10-24 05:20:56','2026-10-24 05:20:56'),(446,21,'Sandamu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(447,21,'Zango','2026-10-24 05:20:56','2026-10-24 05:20:56'),(448,22,'Aleiro','2026-10-24 05:20:56','2026-10-24 05:20:56'),(449,22,'Arewa Dandi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(450,22,'Argungu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(451,22,'Augie','2026-10-24 05:20:56','2026-10-24 05:20:56'),(452,22,'Bagudo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(453,22,'Birnin Kebbi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(454,22,'Bunza','2026-10-24 05:20:56','2026-10-24 05:20:56'),(455,22,'Dandi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(456,22,'Fakai','2026-10-24 05:20:56','2026-10-24 05:20:56'),(457,22,'Gwandu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(458,22,'Jega','2026-10-24 05:20:56','2026-10-24 05:20:56'),(459,22,'Kalgo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(460,22,'Koko/Besse','2026-10-24 05:20:56','2026-10-24 05:20:56'),(461,22,'Maiyama','2026-10-24 05:20:56','2026-10-24 05:20:56'),(462,22,'Ngaski','2026-10-24 05:20:56','2026-10-24 05:20:56'),(463,22,'Sakaba','2026-10-24 05:20:56','2026-10-24 05:20:56'),(464,22,'Shanga','2026-10-24 05:20:56','2026-10-24 05:20:56'),(465,22,'Suru','2026-10-24 05:20:56','2026-10-24 05:20:56'),(466,22,'Wasagu/Danko','2026-10-24 05:20:56','2026-10-24 05:20:56'),(467,22,'Yauri','2026-10-24 05:20:56','2026-10-24 05:20:56'),(468,22,'Zuru','2026-10-24 05:20:56','2026-10-24 05:20:56'),(469,23,'Adavi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(470,23,'Ajaokuta','2026-10-24 05:20:56','2026-10-24 05:20:56'),(471,23,'Ankpa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(472,23,'Bassa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(473,23,'Dekina','2026-10-24 05:20:56','2026-10-24 05:20:56'),(474,23,'Ibaji','2026-10-24 05:20:56','2026-10-24 05:20:56'),(475,23,'Idah','2026-10-24 05:20:56','2026-10-24 05:20:56'),(476,23,'Igalamela Odolu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(477,23,'Ijumu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(478,23,'Kabba/Bunu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(479,23,'Kogi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(480,23,'Lokoja','2026-10-24 05:20:56','2026-10-24 05:20:56'),(481,23,'Mopa Muro','2026-10-24 05:20:56','2026-10-24 05:20:56'),(482,23,'Ofu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(483,23,'Ogori/Magongo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(484,23,'Okehi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(485,23,'Okene','2026-10-24 05:20:56','2026-10-24 05:20:56'),(486,23,'Olamaboro','2026-10-24 05:20:56','2026-10-24 05:20:56'),(487,23,'Omala','2026-10-24 05:20:56','2026-10-24 05:20:56'),(488,23,'Yagba East','2026-10-24 05:20:56','2026-10-24 05:20:56'),(489,23,'Yagba West','2026-10-24 05:20:56','2026-10-24 05:20:56'),(490,24,'Asa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(491,24,'Baruten','2026-10-24 05:20:56','2026-10-24 05:20:56'),(492,24,'Edu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(493,24,'Ekiti, Kwara State','2026-10-24 05:20:56','2026-10-24 05:20:56'),(494,24,'Ifelodun','2026-10-24 05:20:56','2026-10-24 05:20:56'),(495,24,'Ilorin East','2026-10-24 05:20:56','2026-10-24 05:20:56'),(496,24,'Ilorin South','2026-10-24 05:20:56','2026-10-24 05:20:56'),(497,24,'Ilorin West','2026-10-24 05:20:56','2026-10-24 05:20:56'),(498,24,'Irepodun','2026-10-24 05:20:56','2026-10-24 05:20:56'),(499,24,'Isin','2026-10-24 05:20:56','2026-10-24 05:20:56'),(500,24,'Kaiama','2026-10-24 05:20:56','2026-10-24 05:20:56'),(501,24,'Moro','2026-10-24 05:20:56','2026-10-24 05:20:56'),(502,24,'Offa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(503,24,'Oke Ero','2026-10-24 05:20:56','2026-10-24 05:20:56'),(504,24,'Oyun','2026-10-24 05:20:56','2026-10-24 05:20:56'),(505,24,'Pategi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(506,25,'Agege','2026-10-24 05:20:56','2026-10-24 05:20:56'),(507,25,'Ajeromi-Ifelodun','2026-10-24 05:20:56','2026-10-24 05:20:56'),(508,25,'Alimosho','2026-10-24 05:20:56','2026-10-24 05:20:56'),(509,25,'Amuwo-Odofin','2026-10-24 05:20:56','2026-10-24 05:20:56'),(510,25,'Apapa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(511,25,'Badagry','2026-10-24 05:20:56','2026-10-24 05:20:56'),(512,25,'Epe','2026-10-24 05:20:56','2026-10-24 05:20:56'),(513,25,'Eti Osa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(514,25,'Ibeju-Lekki','2026-10-24 05:20:56','2026-10-24 05:20:56'),(515,25,'Ifako-Ijaiye','2026-10-24 05:20:56','2026-10-24 05:20:56'),(516,25,'Ikeja','2026-10-24 05:20:56','2026-10-24 05:20:56'),(517,25,'Ikorodu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(518,25,'Kosofe','2026-10-24 05:20:56','2026-10-24 05:20:56'),(519,25,'Lagos Island','2026-10-24 05:20:56','2026-10-24 05:20:56'),(520,25,'Lagos Mainland','2026-10-24 05:20:56','2026-10-24 05:20:56'),(521,25,'Mushin','2026-10-24 05:20:56','2026-10-24 05:20:56'),(522,25,'Ojo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(523,25,'Oshodi-Isolo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(524,25,'Shomolu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(525,25,'Surulere, Lagos State','2026-10-24 05:20:56','2026-10-24 05:20:56'),(526,26,'Akwanga','2026-10-24 05:20:56','2026-10-24 05:20:56'),(527,26,'Awe','2026-10-24 05:20:56','2026-10-24 05:20:56'),(528,26,'Doma','2026-10-24 05:20:56','2026-10-24 05:20:56'),(529,26,'Karu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(530,26,'Keana','2026-10-24 05:20:56','2026-10-24 05:20:56'),(531,26,'Keffi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(532,26,'Kokona','2026-10-24 05:20:56','2026-10-24 05:20:56'),(533,26,'Lafia','2026-10-24 05:20:56','2026-10-24 05:20:56'),(534,26,'Nasarawa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(535,26,'Nasarawa Egon','2026-10-24 05:20:56','2026-10-24 05:20:56'),(536,26,'Obi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(537,26,'Toto','2026-10-24 05:20:56','2026-10-24 05:20:56'),(538,26,'Wamba','2026-10-24 05:20:56','2026-10-24 05:20:56'),(539,27,'Agaie','2026-10-24 05:20:56','2026-10-24 05:20:56'),(540,27,'Agwara','2026-10-24 05:20:56','2026-10-24 05:20:56'),(541,27,'Bida','2026-10-24 05:20:56','2026-10-24 05:20:56'),(542,27,'Borgu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(543,27,'Bosso','2026-10-24 05:20:56','2026-10-24 05:20:56'),(544,27,'Chanchaga','2026-10-24 05:20:56','2026-10-24 05:20:56'),(545,27,'Edati','2026-10-24 05:20:56','2026-10-24 05:20:56'),(546,27,'Gbako','2026-10-24 05:20:56','2026-10-24 05:20:56'),(547,27,'Gurara','2026-10-24 05:20:56','2026-10-24 05:20:56'),(548,27,'Katcha','2026-10-24 05:20:56','2026-10-24 05:20:56'),(549,27,'Kontagora','2026-10-24 05:20:56','2026-10-24 05:20:56'),(550,27,'Lapai','2026-10-24 05:20:56','2026-10-24 05:20:56'),(551,27,'Lavun','2026-10-24 05:20:56','2026-10-24 05:20:56'),(552,27,'Magama','2026-10-24 05:20:56','2026-10-24 05:20:56'),(553,27,'Mariga','2026-10-24 05:20:56','2026-10-24 05:20:56'),(554,27,'Mashegu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(555,27,'Mokwa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(556,27,'Moya','2026-10-24 05:20:56','2026-10-24 05:20:56'),(557,27,'Paikoro','2026-10-24 05:20:56','2026-10-24 05:20:56'),(558,27,'Rafi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(559,27,'Rijau','2026-10-24 05:20:56','2026-10-24 05:20:56'),(560,27,'Shiroro','2026-10-24 05:20:56','2026-10-24 05:20:56'),(561,27,'Suleja','2026-10-24 05:20:56','2026-10-24 05:20:56'),(562,27,'Tafa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(563,27,'Wushishi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(564,28,'Abeokuta North','2026-10-24 05:20:56','2026-10-24 05:20:56'),(565,28,'Abeokuta South','2026-10-24 05:20:56','2026-10-24 05:20:56'),(566,28,'Ado-Odo/Ota','2026-10-24 05:20:56','2026-10-24 05:20:56'),(567,28,'Egbado North','2026-10-24 05:20:56','2026-10-24 05:20:56'),(568,28,'Egbado South','2026-10-24 05:20:56','2026-10-24 05:20:56'),(569,28,'Ewekoro','2026-10-24 05:20:56','2026-10-24 05:20:56'),(570,28,'Ifo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(571,28,'Ijebu East','2026-10-24 05:20:56','2026-10-24 05:20:56'),(572,28,'Ijebu North','2026-10-24 05:20:56','2026-10-24 05:20:56'),(573,28,'Ijebu North East','2026-10-24 05:20:56','2026-10-24 05:20:56'),(574,28,'Ijebu Ode','2026-10-24 05:20:56','2026-10-24 05:20:56'),(575,28,'Ikenne','2026-10-24 05:20:56','2026-10-24 05:20:56'),(576,28,'Imeko Afon','2026-10-24 05:20:56','2026-10-24 05:20:56'),(577,28,'Ipokia','2026-10-24 05:20:56','2026-10-24 05:20:56'),(578,28,'Obafemi Owode','2026-10-24 05:20:56','2026-10-24 05:20:56'),(579,28,'Odeda','2026-10-24 05:20:56','2026-10-24 05:20:56'),(580,28,'Odogbolu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(581,28,'Ogun Waterside','2026-10-24 05:20:56','2026-10-24 05:20:56'),(582,28,'Remo North','2026-10-24 05:20:56','2026-10-24 05:20:56'),(583,28,'Shagamu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(584,29,'Akoko North-East','2026-10-24 05:20:56','2026-10-24 05:20:56'),(585,29,'Akoko North-West','2026-10-24 05:20:56','2026-10-24 05:20:56'),(586,29,'Akoko South-West','2026-10-24 05:20:56','2026-10-24 05:20:56'),(587,29,'Akoko South-East','2026-10-24 05:20:56','2026-10-24 05:20:56'),(588,29,'Akure North','2026-10-24 05:20:56','2026-10-24 05:20:56'),(589,29,'Akure South','2026-10-24 05:20:56','2026-10-24 05:20:56'),(590,29,'Ese Odo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(591,29,'Idanre','2026-10-24 05:20:56','2026-10-24 05:20:56'),(592,29,'Ifedore','2026-10-24 05:20:56','2026-10-24 05:20:56'),(593,29,'Ilaje','2026-10-24 05:20:56','2026-10-24 05:20:56'),(594,29,'Ile Oluji/Okeigbo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(595,29,'Irele','2026-10-24 05:20:56','2026-10-24 05:20:56'),(596,29,'Odigbo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(597,29,'Okitipupa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(598,29,'Ondo East','2026-10-24 05:20:56','2026-10-24 05:20:56'),(599,29,'Ondo West','2026-10-24 05:20:56','2026-10-24 05:20:56'),(600,29,'Ose','2026-10-24 05:20:56','2026-10-24 05:20:56'),(601,29,'Owo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(602,30,'Atakunmosa East','2026-10-24 05:20:56','2026-10-24 05:20:56'),(603,30,'Atakunmosa West','2026-10-24 05:20:56','2026-10-24 05:20:56'),(604,30,'Aiyedaade','2026-10-24 05:20:56','2026-10-24 05:20:56'),(605,30,'Aiyedire','2026-10-24 05:20:56','2026-10-24 05:20:56'),(606,30,'Boluwaduro','2026-10-24 05:20:56','2026-10-24 05:20:56'),(607,30,'Boripe','2026-10-24 05:20:56','2026-10-24 05:20:56'),(608,30,'Ede North','2026-10-24 05:20:56','2026-10-24 05:20:56'),(609,30,'Ede South','2026-10-24 05:20:56','2026-10-24 05:20:56'),(610,30,'Ife Central','2026-10-24 05:20:56','2026-10-24 05:20:56'),(611,30,'Ife East','2026-10-24 05:20:56','2026-10-24 05:20:56'),(612,30,'Ife North','2026-10-24 05:20:56','2026-10-24 05:20:56'),(613,30,'Ife South','2026-10-24 05:20:56','2026-10-24 05:20:56'),(614,30,'Egbedore','2026-10-24 05:20:56','2026-10-24 05:20:56'),(615,30,'Ejigbo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(616,30,'Ifedayo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(617,30,'Ifelodun','2026-10-24 05:20:56','2026-10-24 05:20:56'),(618,30,'Ila','2026-10-24 05:20:56','2026-10-24 05:20:56'),(619,30,'Ilesa East','2026-10-24 05:20:56','2026-10-24 05:20:56'),(620,30,'Ilesa West','2026-10-24 05:20:56','2026-10-24 05:20:56'),(621,30,'Irepodun','2026-10-24 05:20:56','2026-10-24 05:20:56'),(622,30,'Irewole','2026-10-24 05:20:56','2026-10-24 05:20:56'),(623,30,'Isokan','2026-10-24 05:20:56','2026-10-24 05:20:56'),(624,30,'Iwo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(625,30,'Obokun','2026-10-24 05:20:56','2026-10-24 05:20:56'),(626,30,'Odo Otin','2026-10-24 05:20:56','2026-10-24 05:20:56'),(627,30,'Ola Oluwa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(628,30,'Olorunda','2026-10-24 05:20:56','2026-10-24 05:20:56'),(629,30,'Oriade','2026-10-24 05:20:56','2026-10-24 05:20:56'),(630,30,'Orolu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(631,30,'Osogbo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(632,31,'Afijio','2026-10-24 05:20:56','2026-10-24 05:20:56'),(633,31,'Akinyele','2026-10-24 05:20:56','2026-10-24 05:20:56'),(634,31,'Atiba','2026-10-24 05:20:56','2026-10-24 05:20:56'),(635,31,'Atisbo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(636,31,'Egbeda','2026-10-24 05:20:56','2026-10-24 05:20:56'),(637,31,'Ibadan North','2026-10-24 05:20:56','2026-10-24 05:20:56'),(638,31,'Ibadan North-East','2026-10-24 05:20:56','2026-10-24 05:20:56'),(639,31,'Ibadan North-West','2026-10-24 05:20:56','2026-10-24 05:20:56'),(640,31,'Ibadan South-East','2026-10-24 05:20:56','2026-10-24 05:20:56'),(641,31,'Ibadan South-West','2026-10-24 05:20:56','2026-10-24 05:20:56'),(642,31,'Ibarapa Central','2026-10-24 05:20:56','2026-10-24 05:20:56'),(643,31,'Ibarapa East','2026-10-24 05:20:56','2026-10-24 05:20:56'),(644,31,'Ibarapa North','2026-10-24 05:20:56','2026-10-24 05:20:56'),(645,31,'Ido','2026-10-24 05:20:56','2026-10-24 05:20:56'),(646,31,'Irepo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(647,31,'Iseyin','2026-10-24 05:20:56','2026-10-24 05:20:56'),(648,31,'Itesiwaju','2026-10-24 05:20:56','2026-10-24 05:20:56'),(649,31,'Iwajowa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(650,31,'Kajola','2026-10-24 05:20:56','2026-10-24 05:20:56'),(651,31,'Lagelu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(652,31,'Ogbomosho North','2026-10-24 05:20:56','2026-10-24 05:20:56'),(653,31,'Ogbomosho South','2026-10-24 05:20:56','2026-10-24 05:20:56'),(654,31,'Ogo Oluwa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(655,31,'Olorunsogo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(656,31,'Oluyole','2026-10-24 05:20:56','2026-10-24 05:20:56'),(657,31,'Ona Ara','2026-10-24 05:20:56','2026-10-24 05:20:56'),(658,31,'Orelope','2026-10-24 05:20:56','2026-10-24 05:20:56'),(659,31,'Ori Ire','2026-10-24 05:20:56','2026-10-24 05:20:56'),(660,31,'Oyo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(661,31,'Oyo East','2026-10-24 05:20:56','2026-10-24 05:20:56'),(662,31,'Saki East','2026-10-24 05:20:56','2026-10-24 05:20:56'),(663,31,'Saki West','2026-10-24 05:20:56','2026-10-24 05:20:56'),(664,31,'Surulere, Oyo State','2026-10-24 05:20:56','2026-10-24 05:20:56'),(665,32,'Bokkos','2026-10-24 05:20:56','2026-10-24 05:20:56'),(666,32,'Barkin Ladi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(667,32,'Bassa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(668,32,'Jos East','2026-10-24 05:20:56','2026-10-24 05:20:56'),(669,32,'Jos North','2026-10-24 05:20:56','2026-10-24 05:20:56'),(670,32,'Jos South','2026-10-24 05:20:56','2026-10-24 05:20:56'),(671,32,'Kanam','2026-10-24 05:20:56','2026-10-24 05:20:56'),(672,32,'Kanke','2026-10-24 05:20:56','2026-10-24 05:20:56'),(673,32,'Langtang South','2026-10-24 05:20:56','2026-10-24 05:20:56'),(674,32,'Langtang North','2026-10-24 05:20:56','2026-10-24 05:20:56'),(675,32,'Mangu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(676,32,'Mikang','2026-10-24 05:20:56','2026-10-24 05:20:56'),(677,32,'Pankshin','2026-10-24 05:20:56','2026-10-24 05:20:56'),(678,32,'Qua\'an Pan','2026-10-24 05:20:56','2026-10-24 05:20:56'),(679,32,'Riyom','2026-10-24 05:20:56','2026-10-24 05:20:56'),(680,32,'Shendam','2026-10-24 05:20:56','2026-10-24 05:20:56'),(681,32,'Wase','2026-10-24 05:20:56','2026-10-24 05:20:56'),(682,33,'Abua/Odual','2026-10-24 05:20:56','2026-10-24 05:20:56'),(683,33,'Ahoada East','2026-10-24 05:20:56','2026-10-24 05:20:56'),(684,33,'Ahoada West','2026-10-24 05:20:56','2026-10-24 05:20:56'),(685,33,'Akuku-Toru','2026-10-24 05:20:56','2026-10-24 05:20:56'),(686,33,'Andoni','2026-10-24 05:20:56','2026-10-24 05:20:56'),(687,33,'Asari-Toru','2026-10-24 05:20:56','2026-10-24 05:20:56'),(688,33,'Bonny','2026-10-24 05:20:56','2026-10-24 05:20:56'),(689,33,'Degema','2026-10-24 05:20:56','2026-10-24 05:20:56'),(690,33,'Eleme','2026-10-24 05:20:56','2026-10-24 05:20:56'),(691,33,'Emuoha','2026-10-24 05:20:56','2026-10-24 05:20:56'),(692,33,'Etche','2026-10-24 05:20:56','2026-10-24 05:20:56'),(693,33,'Gokana','2026-10-24 05:20:56','2026-10-24 05:20:56'),(694,33,'Ikwerre','2026-10-24 05:20:56','2026-10-24 05:20:56'),(695,33,'Khana','2026-10-24 05:20:56','2026-10-24 05:20:56'),(696,33,'Obio/Akpor','2026-10-24 05:20:56','2026-10-24 05:20:56'),(697,33,'Ogba/Egbema/Ndoni','2026-10-24 05:20:56','2026-10-24 05:20:56'),(698,33,'Ogu/Bolo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(699,33,'Okrika','2026-10-24 05:20:56','2026-10-24 05:20:56'),(700,33,'Omuma','2026-10-24 05:20:56','2026-10-24 05:20:56'),(701,33,'Opobo/Nkoro','2026-10-24 05:20:56','2026-10-24 05:20:56'),(702,33,'Oyigbo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(703,33,'Port Harcourt','2026-10-24 05:20:56','2026-10-24 05:20:56'),(704,33,'Tai','2026-10-24 05:20:56','2026-10-24 05:20:56'),(705,34,'Binji','2026-10-24 05:20:56','2026-10-24 05:20:56'),(706,34,'Bodinga','2026-10-24 05:20:56','2026-10-24 05:20:56'),(707,34,'Dange Shuni','2026-10-24 05:20:56','2026-10-24 05:20:56'),(708,34,'Gada','2026-10-24 05:20:56','2026-10-24 05:20:56'),(709,34,'Goronyo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(710,34,'Gudu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(711,34,'Gwadabawa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(712,34,'Illela','2026-10-24 05:20:56','2026-10-24 05:20:56'),(713,34,'Isa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(714,34,'Kebbe','2026-10-24 05:20:56','2026-10-24 05:20:56'),(715,34,'Kware','2026-10-24 05:20:56','2026-10-24 05:20:56'),(716,34,'Rabah','2026-10-24 05:20:56','2026-10-24 05:20:56'),(717,34,'Sabon Birni','2026-10-24 05:20:56','2026-10-24 05:20:56'),(718,34,'Shagari','2026-10-24 05:20:56','2026-10-24 05:20:56'),(719,34,'Silame','2026-10-24 05:20:56','2026-10-24 05:20:56'),(720,34,'Sokoto North','2026-10-24 05:20:56','2026-10-24 05:20:56'),(721,34,'Sokoto South','2026-10-24 05:20:56','2026-10-24 05:20:56'),(722,34,'Tambuwal','2026-10-24 05:20:56','2026-10-24 05:20:56'),(723,34,'Tangaza','2026-10-24 05:20:56','2026-10-24 05:20:56'),(724,34,'Tureta','2026-10-24 05:20:56','2026-10-24 05:20:56'),(725,34,'Wamako','2026-10-24 05:20:56','2026-10-24 05:20:56'),(726,34,'Wurno','2026-10-24 05:20:56','2026-10-24 05:20:56'),(727,34,'Yabo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(728,35,'Ardo Kola','2026-10-24 05:20:56','2026-10-24 05:20:56'),(729,35,'Bali','2026-10-24 05:20:56','2026-10-24 05:20:56'),(730,35,'Donga','2026-10-24 05:20:56','2026-10-24 05:20:56'),(731,35,'Gashaka','2026-10-24 05:20:56','2026-10-24 05:20:56'),(732,35,'Gassol','2026-10-24 05:20:56','2026-10-24 05:20:56'),(733,35,'Ibi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(734,35,'Jalingo','2026-10-24 05:20:56','2026-10-24 05:20:56'),(735,35,'Karim Lamido','2026-10-24 05:20:56','2026-10-24 05:20:56'),(736,35,'Kumi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(737,35,'Lau','2026-10-24 05:20:56','2026-10-24 05:20:56'),(738,35,'Sardauna','2026-10-24 05:20:56','2026-10-24 05:20:56'),(739,35,'Takum','2026-10-24 05:20:56','2026-10-24 05:20:56'),(740,35,'Ussa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(741,35,'Wukari','2026-10-24 05:20:56','2026-10-24 05:20:56'),(742,35,'Yorro','2026-10-24 05:20:56','2026-10-24 05:20:56'),(743,35,'Zing','2026-10-24 05:20:56','2026-10-24 05:20:56'),(744,36,'Bade','2026-10-24 05:20:56','2026-10-24 05:20:56'),(745,36,'Bursari','2026-10-24 05:20:56','2026-10-24 05:20:56'),(746,36,'Damaturu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(747,36,'Fika','2026-10-24 05:20:56','2026-10-24 05:20:56'),(748,36,'Fune','2026-10-24 05:20:56','2026-10-24 05:20:56'),(749,36,'Geidam','2026-10-24 05:20:56','2026-10-24 05:20:56'),(750,36,'Gujba','2026-10-24 05:20:56','2026-10-24 05:20:56'),(751,36,'Gulani','2026-10-24 05:20:56','2026-10-24 05:20:56'),(752,36,'Jakusko','2026-10-24 05:20:56','2026-10-24 05:20:56'),(753,36,'Karasuwa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(754,36,'Machina','2026-10-24 05:20:56','2026-10-24 05:20:56'),(755,36,'Nangere','2026-10-24 05:20:56','2026-10-24 05:20:56'),(756,36,'Nguru','2026-10-24 05:20:56','2026-10-24 05:20:56'),(757,36,'Potiskum','2026-10-24 05:20:56','2026-10-24 05:20:56'),(758,36,'Tarmuwa','2026-10-24 05:20:56','2026-10-24 05:20:56'),(759,36,'Yunusari','2026-10-24 05:20:56','2026-10-24 05:20:56'),(760,36,'Yusufari','2026-10-24 05:20:56','2026-10-24 05:20:56'),(761,37,'Anka','2026-10-24 05:20:56','2026-10-24 05:20:56'),(762,37,'Bakura','2026-10-24 05:20:56','2026-10-24 05:20:56'),(763,37,'Birnin Magaji/Kiyaw','2026-10-24 05:20:56','2026-10-24 05:20:56'),(764,37,'Bukkuyum','2026-10-24 05:20:56','2026-10-24 05:20:56'),(765,37,'Bungudu','2026-10-24 05:20:56','2026-10-24 05:20:56'),(766,37,'Gummi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(767,37,'Gusau','2026-10-24 05:20:56','2026-10-24 05:20:56'),(768,37,'Kaura Namoda','2026-10-24 05:20:56','2026-10-24 05:20:56'),(769,37,'Maradun','2026-10-24 05:20:56','2026-10-24 05:20:56'),(770,37,'Maru','2026-10-24 05:20:56','2026-10-24 05:20:56'),(771,37,'Shinkafi','2026-10-24 05:20:56','2026-10-24 05:20:56'),(772,37,'Talata Mafara','2026-10-24 05:20:56','2026-10-24 05:20:56'),(773,37,'Chafe','2026-10-24 05:20:56','2026-10-24 05:20:56'),(774,37,'Zurmi','2026-10-24 05:20:56','2026-10-24 05:20:56');
/*!40000 ALTER TABLE `lgas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mark_audit_trails`
--

DROP TABLE IF EXISTS `mark_audit_trails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mark_audit_trails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mark_id` int(10) unsigned NOT NULL,
  `student_id` int(10) unsigned NOT NULL,
  `subject_id` int(10) unsigned NOT NULL,
  `exam_id` int(10) unsigned NOT NULL,
  `action` varchar(50) NOT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mark_audit_trails_student_id_foreign` (`student_id`),
  KEY `mark_audit_trails_subject_id_foreign` (`subject_id`),
  KEY `mark_audit_trails_exam_id_foreign` (`exam_id`),
  KEY `mark_audit_trails_user_id_foreign` (`user_id`),
  CONSTRAINT `mark_audit_trails_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mark_audit_trails_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mark_audit_trails_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mark_audit_trails_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mark_audit_trails`
--

LOCK TABLES `mark_audit_trails` WRITE;
/*!40000 ALTER TABLE `mark_audit_trails` DISABLE KEYS */;
INSERT INTO `mark_audit_trails` VALUES (1,1,18,1,1,'updated','{\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false}','{\"t1\":20,\"t2\":null,\"tca\":20,\"exm\":60,\"tex1\":80,\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false,\"is_passed\":true,\"remarks\":\"Excellent\",\"updated_by\":1,\"grade_id\":1}',1,'2026-10-24 13:00:42','2026-10-24 13:00:42'),(2,1,18,1,1,'updated','{\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false}','{\"t1\":null,\"t2\":null,\"tca\":null,\"exm\":null,\"tex1\":0,\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false,\"is_passed\":false,\"remarks\":\"Absent\",\"updated_by\":1,\"grade_id\":null}',1,'2026-10-24 13:00:42','2026-10-24 13:00:42'),(3,1,18,1,1,'updated','{\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false}','{\"t1\":20,\"t2\":null,\"tca\":20,\"exm\":60,\"tex1\":80,\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false,\"is_passed\":true,\"remarks\":\"Excellent\",\"updated_by\":1,\"grade_id\":1}',1,'2026-10-24 13:02:09','2026-10-24 13:02:09'),(4,1,18,1,1,'updated','{\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false}','{\"t1\":null,\"t2\":null,\"tca\":null,\"exm\":null,\"tex1\":0,\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false,\"is_passed\":false,\"remarks\":\"Absent\",\"updated_by\":1,\"grade_id\":null}',1,'2026-10-24 13:02:10','2026-10-24 13:02:10'),(5,1,18,1,1,'updated','{\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false}','{\"t1\":20,\"t2\":null,\"tca\":20,\"exm\":60,\"tex1\":80,\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false,\"is_passed\":true,\"remarks\":\"Excellent\",\"updated_by\":1,\"grade_id\":1}',1,'2026-10-24 13:07:33','2026-10-24 13:07:33'),(6,1,18,1,1,'updated','{\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false}','{\"t1\":null,\"t2\":null,\"tca\":null,\"exm\":null,\"tex1\":0,\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false,\"is_passed\":false,\"remarks\":\"Absent\",\"updated_by\":1,\"grade_id\":null}',1,'2026-10-24 13:07:33','2026-10-24 13:07:33'),(7,1,18,1,1,'updated','{\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false}','{\"t1\":20,\"t2\":null,\"tca\":20,\"exm\":60,\"tex1\":80,\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false,\"is_passed\":true,\"remarks\":\"Excellent\",\"updated_by\":1,\"grade_id\":1}',1,'2026-10-24 13:07:52','2026-10-24 13:07:52'),(8,1,18,1,1,'updated','{\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false}','{\"t1\":null,\"t2\":null,\"tca\":null,\"exm\":null,\"tex1\":0,\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false,\"is_passed\":false,\"remarks\":\"Absent\",\"updated_by\":1,\"grade_id\":null}',1,'2026-10-24 13:07:52','2026-10-24 13:07:52'),(9,1,18,1,1,'updated','{\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false}','{\"t1\":20,\"t2\":null,\"tca\":20,\"exm\":60,\"tex1\":80,\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false,\"is_passed\":true,\"remarks\":\"Excellent\",\"updated_by\":1,\"grade_id\":1}',1,'2026-10-24 13:08:17','2026-10-24 13:08:17'),(10,1,18,1,1,'updated','{\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false}','{\"t1\":null,\"t2\":null,\"tca\":null,\"exm\":null,\"tex1\":0,\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false,\"is_passed\":false,\"remarks\":\"Absent\",\"updated_by\":1,\"grade_id\":null}',1,'2026-10-24 13:08:17','2026-10-24 13:08:17'),(11,1,18,1,1,'updated','{\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false}','{\"t1\":20,\"t2\":null,\"tca\":20,\"exm\":60,\"tex1\":80,\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false,\"is_passed\":true,\"remarks\":\"Excellent\",\"updated_by\":1,\"grade_id\":1}',1,'2026-10-24 13:10:36','2026-10-24 13:10:36'),(12,1,18,1,1,'updated','{\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false}','{\"t1\":null,\"t2\":null,\"tca\":null,\"exm\":null,\"tex1\":0,\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false,\"is_passed\":false,\"remarks\":\"Absent\",\"updated_by\":1,\"grade_id\":null}',1,'2026-10-24 13:10:37','2026-10-24 13:10:37'),(13,1,18,1,1,'updated','{\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false}','{\"t1\":20,\"t2\":null,\"tca\":20,\"exm\":60,\"tex1\":80,\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false,\"is_passed\":true,\"remarks\":\"Excellent\",\"updated_by\":1,\"grade_id\":1}',1,'2026-10-24 13:10:46','2026-10-24 13:10:46'),(14,1,18,1,1,'updated','{\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false}','{\"t1\":null,\"t2\":null,\"tca\":null,\"exm\":null,\"tex1\":0,\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false,\"is_passed\":false,\"remarks\":\"Absent\",\"updated_by\":1,\"grade_id\":null}',1,'2026-10-24 13:10:46','2026-10-24 13:10:46'),(15,1,18,1,1,'updated','{\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false}','{\"t1\":20,\"t2\":null,\"tca\":20,\"exm\":60,\"tex1\":80,\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false,\"is_passed\":true,\"remarks\":\"Excellent\",\"updated_by\":1,\"grade_id\":1}',1,'2026-10-24 13:18:41','2026-10-24 13:18:41'),(16,1,18,1,1,'updated','{\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false}','{\"t1\":null,\"t2\":null,\"tca\":null,\"exm\":null,\"tex1\":0,\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false,\"is_passed\":false,\"remarks\":\"Absent\",\"updated_by\":1,\"grade_id\":null}',1,'2026-10-24 13:18:42','2026-10-24 13:18:42'),(17,1,18,1,1,'updated','{\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false}','{\"t1\":20,\"t2\":null,\"tca\":20,\"exm\":60,\"tex1\":80,\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false,\"is_passed\":true,\"remarks\":\"Excellent\",\"updated_by\":1,\"grade_id\":1}',1,'2026-10-24 13:18:51','2026-10-24 13:18:51'),(18,1,18,1,1,'updated','{\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false}','{\"t1\":null,\"t2\":null,\"tca\":null,\"exm\":null,\"tex1\":0,\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false,\"is_passed\":false,\"remarks\":\"Absent\",\"updated_by\":1,\"grade_id\":null}',1,'2026-10-24 13:18:51','2026-10-24 13:18:51'),(19,1,18,1,1,'updated','{\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false}','{\"t1\":20,\"t2\":null,\"tca\":20,\"exm\":60,\"tex1\":80,\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false,\"is_passed\":true,\"remarks\":\"Excellent\",\"updated_by\":1,\"grade_id\":1}',1,'2026-10-24 13:36:48','2026-10-24 13:36:48'),(20,1,18,1,1,'updated','{\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false}','{\"t1\":null,\"t2\":null,\"tca\":null,\"exm\":null,\"tex1\":0,\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false,\"is_passed\":false,\"remarks\":\"Absent\",\"updated_by\":1,\"grade_id\":null}',1,'2026-10-24 13:36:49','2026-10-24 13:36:49'),(21,1,18,1,1,'updated','{\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false}','{\"t1\":20,\"t2\":null,\"tca\":20,\"exm\":60,\"tex1\":80,\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false,\"is_passed\":true,\"remarks\":\"Excellent\",\"updated_by\":1,\"grade_id\":1}',1,'2026-10-24 13:37:45','2026-10-24 13:37:45'),(22,1,18,1,1,'updated','{\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false}','{\"t1\":null,\"t2\":null,\"tca\":null,\"exm\":null,\"tex1\":0,\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false,\"is_passed\":false,\"remarks\":\"Absent\",\"updated_by\":1,\"grade_id\":null}',1,'2026-10-24 13:37:45','2026-10-24 13:37:45'),(23,1,18,1,1,'updated','{\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false}','{\"t1\":20,\"t2\":null,\"tca\":20,\"exm\":60,\"tex1\":80,\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false,\"is_passed\":true,\"remarks\":\"Excellent\",\"updated_by\":1,\"grade_id\":1}',1,'2026-10-24 13:39:15','2026-10-24 13:39:15'),(24,1,18,1,1,'updated','{\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false}','{\"t1\":null,\"t2\":null,\"tca\":null,\"exm\":null,\"tex1\":0,\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false,\"is_passed\":false,\"remarks\":\"Absent\",\"updated_by\":1,\"grade_id\":null}',1,'2026-10-24 13:39:16','2026-10-24 13:39:16'),(25,1,18,1,1,'updated','{\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false}','{\"t1\":20,\"t2\":null,\"tca\":20,\"exm\":60,\"tex1\":80,\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false,\"is_passed\":true,\"remarks\":\"Excellent\",\"updated_by\":1,\"grade_id\":1}',1,'2026-10-24 13:49:07','2026-10-24 13:49:07'),(26,1,18,1,1,'updated','{\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false}','{\"t1\":null,\"t2\":null,\"tca\":null,\"exm\":null,\"tex1\":0,\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false,\"is_passed\":false,\"remarks\":\"Absent\",\"updated_by\":1,\"grade_id\":null}',1,'2026-10-24 13:49:07','2026-10-24 13:49:07'),(27,1,18,1,1,'updated','{\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false}','{\"t1\":20,\"t2\":null,\"tca\":20,\"exm\":60,\"tex1\":80,\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false,\"is_passed\":true,\"remarks\":\"Excellent\",\"updated_by\":1,\"grade_id\":1}',1,'2026-10-24 13:51:25','2026-10-24 13:51:25'),(28,1,18,1,1,'updated','{\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false}','{\"t1\":null,\"t2\":null,\"tca\":null,\"exm\":null,\"tex1\":0,\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false,\"is_passed\":false,\"remarks\":\"Absent\",\"updated_by\":1,\"grade_id\":null}',1,'2026-10-24 13:51:25','2026-10-24 13:51:25'),(29,1,18,1,1,'updated','{\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false}','{\"t1\":20,\"t2\":null,\"tca\":20,\"exm\":60,\"tex1\":80,\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false,\"is_passed\":true,\"remarks\":\"Excellent\",\"updated_by\":1,\"grade_id\":1}',1,'2026-10-24 13:54:23','2026-10-24 13:54:23'),(30,1,18,1,1,'updated','{\"theory_mark\":60,\"practical_mark\":20,\"total_mark\":80,\"gpa_point\":3.6,\"grade_name\":\"A\",\"is_absent\":false,\"is_exempt\":false}','{\"t1\":null,\"t2\":null,\"tca\":null,\"exm\":null,\"tex1\":0,\"theory_mark\":null,\"practical_mark\":null,\"total_mark\":0,\"gpa_point\":0,\"grade_name\":\"ABS\",\"is_absent\":true,\"is_exempt\":false,\"is_passed\":false,\"remarks\":\"Absent\",\"updated_by\":1,\"grade_id\":null}',1,'2026-10-24 13:54:23','2026-10-24 13:54:23');
/*!40000 ALTER TABLE `mark_audit_trails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marks`
--

DROP TABLE IF EXISTS `marks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(10) unsigned NOT NULL,
  `subject_id` int(10) unsigned NOT NULL,
  `my_class_id` int(10) unsigned NOT NULL,
  `section_id` int(10) unsigned NOT NULL,
  `exam_id` int(10) unsigned NOT NULL,
  `t1` int(11) DEFAULT NULL,
  `t2` int(11) DEFAULT NULL,
  `t3` int(11) DEFAULT NULL,
  `t4` int(11) DEFAULT NULL,
  `tca` int(11) DEFAULT NULL,
  `exm` int(11) DEFAULT NULL,
  `theory_mark` decimal(5,2) DEFAULT NULL,
  `practical_mark` decimal(5,2) DEFAULT NULL,
  `total_mark` decimal(5,2) DEFAULT NULL,
  `tex1` int(11) DEFAULT NULL,
  `tex2` int(11) DEFAULT NULL,
  `tex3` int(11) DEFAULT NULL,
  `sub_pos` tinyint(4) DEFAULT NULL,
  `cum` int(11) DEFAULT NULL,
  `cum_ave` varchar(255) DEFAULT NULL,
  `grade_id` int(10) unsigned DEFAULT NULL,
  `gpa_point` decimal(3,2) DEFAULT NULL,
  `grade_name` varchar(5) DEFAULT NULL,
  `is_absent` tinyint(1) NOT NULL DEFAULT 0,
  `is_exempt` tinyint(1) NOT NULL DEFAULT 0,
  `is_passed` tinyint(1) NOT NULL DEFAULT 1,
  `remarks` text DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `year` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_exam_student_subject_year` (`exam_id`,`student_id`,`subject_id`,`year`),
  KEY `marks_student_id_foreign` (`student_id`),
  KEY `marks_my_class_id_foreign` (`my_class_id`),
  KEY `marks_section_id_foreign` (`section_id`),
  KEY `marks_subject_id_foreign` (`subject_id`),
  KEY `marks_grade_id_foreign` (`grade_id`),
  CONSTRAINT `marks_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `marks_grade_id_foreign` FOREIGN KEY (`grade_id`) REFERENCES `grades` (`id`) ON DELETE SET NULL,
  CONSTRAINT `marks_my_class_id_foreign` FOREIGN KEY (`my_class_id`) REFERENCES `my_classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `marks_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `marks_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `marks_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marks`
--

LOCK TABLES `marks` WRITE;
/*!40000 ALTER TABLE `marks` DISABLE KEYS */;
INSERT INTO `marks` VALUES (1,18,1,1,1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0.00,0,NULL,NULL,1,NULL,NULL,NULL,0.00,'ABS',1,0,0,'Absent',1,'2018-2019','2026-10-24 12:32:14','2026-10-24 13:54:23');
/*!40000 ALTER TABLE `marks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2013_09_20_121733_create_blood_groups_table',1),(2,'2013_09_22_124750_create_states_table',1),(3,'2013_09_22_124806_create_lgas_table',1),(4,'2013_09_26_121148_create_nationalities_table',1),(5,'2014_10_12_000000_create_users_table',1),(6,'2014_10_12_100000_create_password_resets_table',1),(7,'2018_09_20_100249_create_user_types_table',1),(8,'2018_09_20_150906_create_class_types_table',1),(9,'2018_09_22_073005_create_my_classes_table',1),(10,'2018_09_22_073526_create_sections_table',1),(11,'2018_09_22_080555_create_settings_table',1),(12,'2018_09_22_081302_create_subjects_table',1),(13,'2018_09_22_151514_create_student_records_table',1),(14,'2018_09_26_124241_create_dorms_table',1),(15,'2018_10_04_224910_create_exams_table',1),(16,'2018_10_06_224846_create_marks_table',1),(17,'2018_10_06_224944_create_grades_table',1),(18,'2018_10_06_225007_create_pins_table',1),(19,'2018_10_18_205550_create_skills_table',1),(20,'2018_10_18_205842_create_exam_records_table',1),(21,'2018_10_31_191358_create_books_table',1),(22,'2018_10_31_192540_create_book_requests_table',1),(23,'2018_11_01_132115_create_staff_records_table',1),(24,'2018_11_03_210758_create_payments_table',1),(25,'2018_11_03_210817_create_payment_records_table',1),(26,'2018_11_06_083707_create_receipts_table',1),(27,'2018_11_27_180401_create_time_tables_table',1),(28,'2019_09_22_142514_create_fks',1),(29,'2019_09_26_132227_create_promotions_table',1),(30,'2026_10_24_180000_add_locale_to_users_table',2),(31,'2026_10_24_190000_create_academic_years_table',3),(32,'2026_10_24_190100_create_holidays_table',3),(34,'2026_10_24_200000_update_exams_and_marks_for_nepal_system',4),(36,'2026_10_24_210000_create_attendance_system_for_nepal',5);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `my_classes`
--

DROP TABLE IF EXISTS `my_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `my_classes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `class_type_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `my_classes_class_type_id_name_unique` (`class_type_id`,`name`),
  CONSTRAINT `my_classes_class_type_id_foreign` FOREIGN KEY (`class_type_id`) REFERENCES `class_types` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `my_classes`
--

LOCK TABLES `my_classes` WRITE;
/*!40000 ALTER TABLE `my_classes` DISABLE KEYS */;
INSERT INTO `my_classes` VALUES (1,'Nursery 1',3,NULL,NULL),(2,'Nursery 2',3,NULL,NULL),(3,'Nursery 3',3,NULL,NULL),(4,'Primary 1',4,NULL,NULL),(5,'Primary 2',4,NULL,NULL),(6,'JSS 2',5,NULL,NULL),(7,'JSS 3',5,NULL,NULL),(8,'SSS 1',6,NULL,NULL),(9,'SSS 2',6,NULL,NULL),(10,'SSS 3',6,NULL,NULL),(11,'Grade 4 Promo',1,'2026-10-24 13:51:12','2026-10-24 13:51:12'),(12,'Grade 5 Promo',1,'2026-10-24 13:51:12','2026-10-24 13:51:12');
/*!40000 ALTER TABLE `my_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nationalities`
--

DROP TABLE IF EXISTS `nationalities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nationalities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nationalities`
--

LOCK TABLES `nationalities` WRITE;
/*!40000 ALTER TABLE `nationalities` DISABLE KEYS */;
INSERT INTO `nationalities` VALUES (1,'Afghan','2026-10-24 05:20:54','2026-10-24 05:20:54'),(2,'Albanian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(3,'Algerian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(4,'American','2026-10-24 05:20:54','2026-10-24 05:20:54'),(5,'Andorran','2026-10-24 05:20:54','2026-10-24 05:20:54'),(6,'Angolan','2026-10-24 05:20:54','2026-10-24 05:20:54'),(7,'Antiguans','2026-10-24 05:20:54','2026-10-24 05:20:54'),(8,'Argentinean','2026-10-24 05:20:54','2026-10-24 05:20:54'),(9,'Armenian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(10,'Australian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(11,'Austrian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(12,'Azerbaijani','2026-10-24 05:20:54','2026-10-24 05:20:54'),(13,'Bahamian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(14,'Bahraini','2026-10-24 05:20:54','2026-10-24 05:20:54'),(15,'Bangladeshi','2026-10-24 05:20:54','2026-10-24 05:20:54'),(16,'Barbadian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(17,'Barbudans','2026-10-24 05:20:54','2026-10-24 05:20:54'),(18,'Batswana','2026-10-24 05:20:54','2026-10-24 05:20:54'),(19,'Belarusian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(20,'Belgian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(21,'Belizean','2026-10-24 05:20:54','2026-10-24 05:20:54'),(22,'Beninese','2026-10-24 05:20:54','2026-10-24 05:20:54'),(23,'Bhutanese','2026-10-24 05:20:54','2026-10-24 05:20:54'),(24,'Bolivian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(25,'Bosnian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(26,'Brazilian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(27,'British','2026-10-24 05:20:54','2026-10-24 05:20:54'),(28,'Bruneian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(29,'Bulgarian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(30,'Burkinabe','2026-10-24 05:20:54','2026-10-24 05:20:54'),(31,'Burmese','2026-10-24 05:20:54','2026-10-24 05:20:54'),(32,'Burundian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(33,'Cambodian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(34,'Cameroonian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(35,'Canadian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(36,'Cape Verdean','2026-10-24 05:20:54','2026-10-24 05:20:54'),(37,'Central African','2026-10-24 05:20:54','2026-10-24 05:20:54'),(38,'Chadian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(39,'Chilean','2026-10-24 05:20:54','2026-10-24 05:20:54'),(40,'Chinese','2026-10-24 05:20:54','2026-10-24 05:20:54'),(41,'Colombian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(42,'Comoran','2026-10-24 05:20:54','2026-10-24 05:20:54'),(43,'Congolese','2026-10-24 05:20:54','2026-10-24 05:20:54'),(44,'Costa Rican','2026-10-24 05:20:54','2026-10-24 05:20:54'),(45,'Croatian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(46,'Cuban','2026-10-24 05:20:54','2026-10-24 05:20:54'),(47,'Cypriot','2026-10-24 05:20:54','2026-10-24 05:20:54'),(48,'Czech','2026-10-24 05:20:54','2026-10-24 05:20:54'),(49,'Danish','2026-10-24 05:20:54','2026-10-24 05:20:54'),(50,'Djibouti','2026-10-24 05:20:54','2026-10-24 05:20:54'),(51,'Dominican','2026-10-24 05:20:54','2026-10-24 05:20:54'),(52,'Dutch','2026-10-24 05:20:54','2026-10-24 05:20:54'),(53,'East Timorese','2026-10-24 05:20:54','2026-10-24 05:20:54'),(54,'Ecuadorean','2026-10-24 05:20:54','2026-10-24 05:20:54'),(55,'Egyptian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(56,'Emirian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(57,'Equatorial Guinean','2026-10-24 05:20:54','2026-10-24 05:20:54'),(58,'Eritrean','2026-10-24 05:20:54','2026-10-24 05:20:54'),(59,'Estonian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(60,'Ethiopian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(61,'Fijian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(62,'Filipino','2026-10-24 05:20:54','2026-10-24 05:20:54'),(63,'Finnish','2026-10-24 05:20:54','2026-10-24 05:20:54'),(64,'French','2026-10-24 05:20:54','2026-10-24 05:20:54'),(65,'Gabonese','2026-10-24 05:20:54','2026-10-24 05:20:54'),(66,'Gambian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(67,'Georgian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(68,'German','2026-10-24 05:20:54','2026-10-24 05:20:54'),(69,'Ghanaian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(70,'Greek','2026-10-24 05:20:54','2026-10-24 05:20:54'),(71,'Grenadian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(72,'Guatemalan','2026-10-24 05:20:54','2026-10-24 05:20:54'),(73,'Guinea-Bissauan','2026-10-24 05:20:54','2026-10-24 05:20:54'),(74,'Guinean','2026-10-24 05:20:54','2026-10-24 05:20:54'),(75,'Guyanese','2026-10-24 05:20:54','2026-10-24 05:20:54'),(76,'Haitian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(77,'Herzegovinian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(78,'Honduran','2026-10-24 05:20:54','2026-10-24 05:20:54'),(79,'Hungarian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(80,'I-Kiribati','2026-10-24 05:20:54','2026-10-24 05:20:54'),(81,'Icelander','2026-10-24 05:20:54','2026-10-24 05:20:54'),(82,'Indian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(83,'Indonesian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(84,'Iranian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(85,'Iraqi','2026-10-24 05:20:54','2026-10-24 05:20:54'),(86,'Irish','2026-10-24 05:20:54','2026-10-24 05:20:54'),(87,'Israeli','2026-10-24 05:20:54','2026-10-24 05:20:54'),(88,'Italian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(89,'Ivorian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(90,'Jamaican','2026-10-24 05:20:54','2026-10-24 05:20:54'),(91,'Japanese','2026-10-24 05:20:54','2026-10-24 05:20:54'),(92,'Jordanian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(93,'Kazakhstani','2026-10-24 05:20:54','2026-10-24 05:20:54'),(94,'Kenyan','2026-10-24 05:20:54','2026-10-24 05:20:54'),(95,'Kittian and Nevisian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(96,'Kuwaiti','2026-10-24 05:20:54','2026-10-24 05:20:54'),(97,'Kyrgyz','2026-10-24 05:20:54','2026-10-24 05:20:54'),(98,'Laotian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(99,'Latvian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(100,'Lebanese','2026-10-24 05:20:54','2026-10-24 05:20:54'),(101,'Liberian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(102,'Libyan','2026-10-24 05:20:54','2026-10-24 05:20:54'),(103,'Liechtensteiner','2026-10-24 05:20:54','2026-10-24 05:20:54'),(104,'Lithuanian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(105,'Luxembourger','2026-10-24 05:20:54','2026-10-24 05:20:54'),(106,'Macedonian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(107,'Malagasy','2026-10-24 05:20:54','2026-10-24 05:20:54'),(108,'Malawian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(109,'Malaysian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(110,'Maldivan','2026-10-24 05:20:54','2026-10-24 05:20:54'),(111,'Malian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(112,'Maltese','2026-10-24 05:20:54','2026-10-24 05:20:54'),(113,'Marshallese','2026-10-24 05:20:54','2026-10-24 05:20:54'),(114,'Mauritanian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(115,'Mauritian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(116,'Mexican','2026-10-24 05:20:54','2026-10-24 05:20:54'),(117,'Micronesian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(118,'Moldovan','2026-10-24 05:20:54','2026-10-24 05:20:54'),(119,'Monacan','2026-10-24 05:20:54','2026-10-24 05:20:54'),(120,'Mongolian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(121,'Moroccan','2026-10-24 05:20:54','2026-10-24 05:20:54'),(122,'Mosotho','2026-10-24 05:20:54','2026-10-24 05:20:54'),(123,'Motswana','2026-10-24 05:20:54','2026-10-24 05:20:54'),(124,'Mozambican','2026-10-24 05:20:54','2026-10-24 05:20:54'),(125,'Namibian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(126,'Nauruan','2026-10-24 05:20:54','2026-10-24 05:20:54'),(127,'Nepalese','2026-10-24 05:20:54','2026-10-24 05:20:54'),(128,'New Zealander','2026-10-24 05:20:54','2026-10-24 05:20:54'),(129,'Nicaraguan','2026-10-24 05:20:54','2026-10-24 05:20:54'),(130,'Nigerian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(131,'Nigerien','2026-10-24 05:20:54','2026-10-24 05:20:54'),(132,'North Korean','2026-10-24 05:20:54','2026-10-24 05:20:54'),(133,'Northern Irish','2026-10-24 05:20:54','2026-10-24 05:20:54'),(134,'Norwegian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(135,'Omani','2026-10-24 05:20:54','2026-10-24 05:20:54'),(136,'Pakistani','2026-10-24 05:20:54','2026-10-24 05:20:54'),(137,'Palauan','2026-10-24 05:20:54','2026-10-24 05:20:54'),(138,'Panamanian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(139,'Papua New Guinean','2026-10-24 05:20:54','2026-10-24 05:20:54'),(140,'Paraguayan','2026-10-24 05:20:54','2026-10-24 05:20:54'),(141,'Peruvian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(142,'Polish','2026-10-24 05:20:54','2026-10-24 05:20:54'),(143,'Portuguese','2026-10-24 05:20:54','2026-10-24 05:20:54'),(144,'Qatari','2026-10-24 05:20:54','2026-10-24 05:20:54'),(145,'Romanian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(146,'Russian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(147,'Rwandan','2026-10-24 05:20:54','2026-10-24 05:20:54'),(148,'Saint Lucian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(149,'Salvadoran','2026-10-24 05:20:54','2026-10-24 05:20:54'),(150,'Samoan','2026-10-24 05:20:54','2026-10-24 05:20:54'),(151,'San Marinese','2026-10-24 05:20:54','2026-10-24 05:20:54'),(152,'Sao Tomean','2026-10-24 05:20:54','2026-10-24 05:20:54'),(153,'Saudi','2026-10-24 05:20:54','2026-10-24 05:20:54'),(154,'Scottish','2026-10-24 05:20:54','2026-10-24 05:20:54'),(155,'Senegalese','2026-10-24 05:20:54','2026-10-24 05:20:54'),(156,'Serbian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(157,'Seychellois','2026-10-24 05:20:54','2026-10-24 05:20:54'),(158,'Sierra Leonean','2026-10-24 05:20:54','2026-10-24 05:20:54'),(159,'Singaporean','2026-10-24 05:20:54','2026-10-24 05:20:54'),(160,'Slovakian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(161,'Slovenian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(162,'Solomon Islander','2026-10-24 05:20:54','2026-10-24 05:20:54'),(163,'Somali','2026-10-24 05:20:54','2026-10-24 05:20:54'),(164,'South African','2026-10-24 05:20:54','2026-10-24 05:20:54'),(165,'South Korean','2026-10-24 05:20:54','2026-10-24 05:20:54'),(166,'Spanish','2026-10-24 05:20:54','2026-10-24 05:20:54'),(167,'Sri Lankan','2026-10-24 05:20:54','2026-10-24 05:20:54'),(168,'Sudanese','2026-10-24 05:20:54','2026-10-24 05:20:54'),(169,'Surinamer','2026-10-24 05:20:54','2026-10-24 05:20:54'),(170,'Swazi','2026-10-24 05:20:54','2026-10-24 05:20:54'),(171,'Swedish','2026-10-24 05:20:54','2026-10-24 05:20:54'),(172,'Swiss','2026-10-24 05:20:54','2026-10-24 05:20:54'),(173,'Syrian','2026-10-24 05:20:54','2026-10-24 05:20:54'),(174,'Taiwanese','2026-10-24 05:20:54','2026-10-24 05:20:54'),(175,'Tajik','2026-10-24 05:20:55','2026-10-24 05:20:55'),(176,'Tanzanian','2026-10-24 05:20:55','2026-10-24 05:20:55'),(177,'Thai','2026-10-24 05:20:55','2026-10-24 05:20:55'),(178,'Togolese','2026-10-24 05:20:55','2026-10-24 05:20:55'),(179,'Tongan','2026-10-24 05:20:55','2026-10-24 05:20:55'),(180,'Trinidadian/Tobagonian','2026-10-24 05:20:55','2026-10-24 05:20:55'),(181,'Tunisian','2026-10-24 05:20:55','2026-10-24 05:20:55'),(182,'Turkish','2026-10-24 05:20:55','2026-10-24 05:20:55'),(183,'Tuvaluan','2026-10-24 05:20:55','2026-10-24 05:20:55'),(184,'Ugandan','2026-10-24 05:20:55','2026-10-24 05:20:55'),(185,'Ukrainian','2026-10-24 05:20:55','2026-10-24 05:20:55'),(186,'Uruguayan','2026-10-24 05:20:55','2026-10-24 05:20:55'),(187,'Uzbekistani','2026-10-24 05:20:55','2026-10-24 05:20:55'),(188,'Venezuelan','2026-10-24 05:20:55','2026-10-24 05:20:55'),(189,'Vietnamese','2026-10-24 05:20:55','2026-10-24 05:20:55'),(190,'Welsh','2026-10-24 05:20:55','2026-10-24 05:20:55'),(191,'Yemenite','2026-10-24 05:20:55','2026-10-24 05:20:55'),(192,'Zambian','2026-10-24 05:20:55','2026-10-24 05:20:55'),(193,'Zimbabwean','2026-10-24 05:20:55','2026-10-24 05:20:55');
/*!40000 ALTER TABLE `nationalities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_records`
--

DROP TABLE IF EXISTS `payment_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` int(10) unsigned NOT NULL,
  `student_id` int(10) unsigned NOT NULL,
  `ref_no` varchar(100) DEFAULT NULL,
  `amt_paid` int(11) DEFAULT NULL,
  `balance` int(11) DEFAULT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT 0,
  `year` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_records_ref_no_unique` (`ref_no`),
  KEY `payment_records_payment_id_foreign` (`payment_id`),
  KEY `payment_records_student_id_foreign` (`student_id`),
  CONSTRAINT `payment_records_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payment_records_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_records`
--

LOCK TABLES `payment_records` WRITE;
/*!40000 ALTER TABLE `payment_records` DISABLE KEYS */;
INSERT INTO `payment_records` VALUES (1,1,46,'51101221',NULL,NULL,0,'2083/84 BS Updated','2026-10-24 13:45:16','2026-10-24 13:45:16'),(2,1,47,'19756541',NULL,NULL,0,'2083/84 BS Updated','2026-10-24 13:45:16','2026-10-24 13:45:16'),(3,1,48,'63373665',NULL,NULL,0,'2083/84 BS Updated','2026-10-24 13:45:16','2026-10-24 13:45:16'),(4,1,55,'32574673',500,24500,0,'2083/84 BS Updated','2026-10-24 13:45:16','2026-10-24 13:45:34');
/*!40000 ALTER TABLE `payment_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `amount` int(11) NOT NULL,
  `ref_no` varchar(100) NOT NULL,
  `method` varchar(100) NOT NULL DEFAULT 'cash',
  `my_class_id` int(10) unsigned DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `year` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_ref_no_unique` (`ref_no`),
  KEY `payments_my_class_id_foreign` (`my_class_id`),
  CONSTRAINT `payments_my_class_id_foreign` FOREIGN KEY (`my_class_id`) REFERENCES `my_classes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,'fee',25000,'2026/142610','cash',8,NULL,'2083/84 BS Updated','2026-10-24 13:44:57','2026-10-24 13:44:57');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pins`
--

DROP TABLE IF EXISTS `pins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(40) NOT NULL,
  `used` varchar(255) NOT NULL DEFAULT '0',
  `times_used` varchar(255) NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned DEFAULT NULL,
  `student_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pins_code_unique` (`code`),
  KEY `pins_user_id_foreign` (`user_id`),
  KEY `pins_student_id_foreign` (`student_id`),
  CONSTRAINT `pins_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pins`
--

LOCK TABLES `pins` WRITE;
/*!40000 ALTER TABLE `pins` DISABLE KEYS */;
/*!40000 ALTER TABLE `pins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promotions`
--

DROP TABLE IF EXISTS `promotions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promotions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(10) unsigned NOT NULL,
  `from_class` int(10) unsigned NOT NULL,
  `from_section` int(10) unsigned NOT NULL,
  `to_class` int(10) unsigned NOT NULL,
  `to_section` int(10) unsigned NOT NULL,
  `grad` tinyint(4) NOT NULL,
  `from_session` varchar(255) NOT NULL,
  `to_session` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `promotions_student_id_foreign` (`student_id`),
  KEY `promotions_from_class_foreign` (`from_class`),
  KEY `promotions_from_section_foreign` (`from_section`),
  KEY `promotions_to_section_foreign` (`to_section`),
  KEY `promotions_to_class_foreign` (`to_class`),
  CONSTRAINT `promotions_from_class_foreign` FOREIGN KEY (`from_class`) REFERENCES `my_classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promotions_from_section_foreign` FOREIGN KEY (`from_section`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promotions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promotions_to_class_foreign` FOREIGN KEY (`to_class`) REFERENCES `my_classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promotions_to_section_foreign` FOREIGN KEY (`to_section`) REFERENCES `sections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promotions`
--

LOCK TABLES `promotions` WRITE;
/*!40000 ALTER TABLE `promotions` DISABLE KEYS */;
/*!40000 ALTER TABLE `promotions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receipts`
--

DROP TABLE IF EXISTS `receipts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `receipts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pr_id` int(10) unsigned NOT NULL,
  `amt_paid` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `year` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `receipts_pr_id_foreign` (`pr_id`),
  CONSTRAINT `receipts_pr_id_foreign` FOREIGN KEY (`pr_id`) REFERENCES `payment_records` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receipts`
--

LOCK TABLES `receipts` WRITE;
/*!40000 ALTER TABLE `receipts` DISABLE KEYS */;
INSERT INTO `receipts` VALUES (1,4,500,24500,'2083/84 BS Updated','2026-10-24 13:45:34','2026-10-24 13:45:34');
/*!40000 ALTER TABLE `receipts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `my_class_id` int(10) unsigned NOT NULL,
  `teacher_id` int(10) unsigned DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sections_name_my_class_id_unique` (`name`,`my_class_id`),
  KEY `sections_my_class_id_foreign` (`my_class_id`),
  KEY `sections_teacher_id_foreign` (`teacher_id`),
  CONSTRAINT `sections_my_class_id_foreign` FOREIGN KEY (`my_class_id`) REFERENCES `my_classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sections_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sections`
--

LOCK TABLES `sections` WRITE;
/*!40000 ALTER TABLE `sections` DISABLE KEYS */;
INSERT INTO `sections` VALUES (1,'Gold',1,NULL,1,NULL,'2026-10-24 13:54:22'),(2,'Diamond',1,NULL,0,NULL,'2026-10-24 13:54:22'),(3,'Silver',2,NULL,1,NULL,NULL),(4,'Lemon',2,NULL,0,NULL,NULL),(5,'Bronze',3,NULL,1,NULL,NULL),(6,'Silver',4,NULL,1,NULL,NULL),(7,'Diamond',5,NULL,1,NULL,NULL),(8,'Blue',6,NULL,1,NULL,NULL),(9,'A',7,NULL,1,NULL,NULL),(10,'A',8,NULL,1,NULL,NULL),(11,'A',9,NULL,1,NULL,NULL),(12,'A',10,NULL,1,NULL,NULL),(13,'A Promo',11,NULL,0,'2026-10-24 13:51:12','2026-10-24 13:51:12'),(14,'A Promo',12,NULL,0,'2026-10-24 13:51:12','2026-10-24 13:51:12');
/*!40000 ALTER TABLE `sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'current_session','2083/84 BS Updated',NULL,'2026-10-24 13:54:21'),(2,'system_title','CJIA',NULL,NULL),(3,'system_name','CJ INSPIRED ACADEMY',NULL,NULL),(4,'term_ends','7/10/2018',NULL,NULL),(5,'term_begins','7/10/2018',NULL,NULL),(6,'phone','0123456789',NULL,NULL),(7,'address','18B North Central Park, Behind Central Square Tourist Center',NULL,NULL),(8,'system_email','cjacademy@cj.com',NULL,NULL),(9,'alt_email','',NULL,NULL),(10,'email_host','',NULL,NULL),(11,'email_pass','',NULL,NULL),(12,'lock_exam','0',NULL,NULL),(13,'logo','',NULL,NULL),(14,'next_term_fees_j','20000',NULL,NULL),(15,'next_term_fees_pn','25000',NULL,NULL),(16,'next_term_fees_p','25000',NULL,NULL),(17,'next_term_fees_n','25600',NULL,NULL),(18,'next_term_fees_s','15600',NULL,NULL),(19,'next_term_fees_c','1600',NULL,NULL);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skills` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `skill_type` varchar(255) NOT NULL,
  `class_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
INSERT INTO `skills` VALUES (1,'PUNCTUALITY','AF',NULL,NULL,NULL),(2,'NEATNESS','AF',NULL,NULL,NULL),(3,'HONESTY','AF',NULL,NULL,NULL),(4,'RELIABILITY','AF',NULL,NULL,NULL),(5,'RELATIONSHIP WITH OTHERS','AF',NULL,NULL,NULL),(6,'POLITENESS','AF',NULL,NULL,NULL),(7,'ALERTNESS','AF',NULL,NULL,NULL),(8,'HANDWRITING','PS',NULL,NULL,NULL),(9,'GAMES & SPORTS','PS',NULL,NULL,NULL),(10,'DRAWING & ARTS','PS',NULL,NULL,NULL),(11,'PAINTING','PS',NULL,NULL,NULL),(12,'CONSTRUCTION','PS',NULL,NULL,NULL),(13,'MUSICAL SKILLS','PS',NULL,NULL,NULL),(14,'FLEXIBILITY','PS',NULL,NULL,NULL);
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_attendances`
--

DROP TABLE IF EXISTS `staff_attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_attendances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `staff_record_id` int(10) unsigned DEFAULT NULL,
  `academic_year_id` int(10) unsigned DEFAULT NULL,
  `session` varchar(50) DEFAULT NULL,
  `attendance_date` date NOT NULL,
  `attendance_date_bs` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'present',
  `remarks` varchar(255) DEFAULT NULL,
  `recorded_by` int(10) unsigned DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_staff_date_att` (`user_id`,`attendance_date`),
  KEY `staff_attendances_attendance_date_index` (`attendance_date`),
  KEY `staff_attendances_attendance_date_bs_index` (`attendance_date_bs`),
  KEY `staff_attendances_recorded_by_foreign` (`recorded_by`),
  KEY `staff_attendances_updated_by_foreign` (`updated_by`),
  CONSTRAINT `staff_attendances_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `staff_attendances_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `staff_attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_attendances`
--

LOCK TABLES `staff_attendances` WRITE;
/*!40000 ALTER TABLE `staff_attendances` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_records`
--

DROP TABLE IF EXISTS `staff_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `emp_date` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `staff_records_code_unique` (`code`),
  KEY `staff_records_user_id_foreign` (`user_id`),
  CONSTRAINT `staff_records_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_records`
--

LOCK TABLES `staff_records` WRITE;
/*!40000 ALTER TABLE `staff_records` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `states` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` VALUES (1,'Abia','2026-10-24 05:20:55','2026-10-24 05:20:55'),(2,'Adamawa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(3,'Akwa Ibom','2026-10-24 05:20:55','2026-10-24 05:20:55'),(4,'Anambra','2026-10-24 05:20:55','2026-10-24 05:20:55'),(5,'Bauchi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(6,'Bayelsa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(7,'Benue','2026-10-24 05:20:55','2026-10-24 05:20:55'),(8,'Borno','2026-10-24 05:20:55','2026-10-24 05:20:55'),(9,'Cross River','2026-10-24 05:20:55','2026-10-24 05:20:55'),(10,'Delta','2026-10-24 05:20:55','2026-10-24 05:20:55'),(11,'Ebonyi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(12,'Edo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(13,'Ekiti','2026-10-24 05:20:55','2026-10-24 05:20:55'),(14,'Enugu','2026-10-24 05:20:55','2026-10-24 05:20:55'),(15,'FCT','2026-10-24 05:20:55','2026-10-24 05:20:55'),(16,'Gombe','2026-10-24 05:20:55','2026-10-24 05:20:55'),(17,'Imo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(18,'Jigawa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(19,'Kaduna','2026-10-24 05:20:55','2026-10-24 05:20:55'),(20,'Kano','2026-10-24 05:20:55','2026-10-24 05:20:55'),(21,'Katsina','2026-10-24 05:20:55','2026-10-24 05:20:55'),(22,'Kebbi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(23,'Kogi','2026-10-24 05:20:55','2026-10-24 05:20:55'),(24,'Kwara','2026-10-24 05:20:55','2026-10-24 05:20:55'),(25,'Lagos','2026-10-24 05:20:55','2026-10-24 05:20:55'),(26,'Nasarawa','2026-10-24 05:20:55','2026-10-24 05:20:55'),(27,'Niger','2026-10-24 05:20:55','2026-10-24 05:20:55'),(28,'Ogun','2026-10-24 05:20:55','2026-10-24 05:20:55'),(29,'Ondo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(30,'Osun','2026-10-24 05:20:55','2026-10-24 05:20:55'),(31,'Oyo','2026-10-24 05:20:55','2026-10-24 05:20:55'),(32,'Plateau','2026-10-24 05:20:55','2026-10-24 05:20:55'),(33,'Rivers','2026-10-24 05:20:55','2026-10-24 05:20:55'),(34,'Sokoto','2026-10-24 05:20:55','2026-10-24 05:20:55'),(35,'Taraba','2026-10-24 05:20:55','2026-10-24 05:20:55'),(36,'Yobe','2026-10-24 05:20:55','2026-10-24 05:20:55'),(37,'Zamfara','2026-10-24 05:20:55','2026-10-24 05:20:55');
/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_attendances`
--

DROP TABLE IF EXISTS `student_attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_attendances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `student_record_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `my_class_id` int(10) unsigned NOT NULL,
  `section_id` int(10) unsigned DEFAULT NULL,
  `academic_year_id` int(10) unsigned DEFAULT NULL,
  `session` varchar(50) DEFAULT NULL,
  `attendance_date` date NOT NULL,
  `attendance_date_bs` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'present',
  `remarks` varchar(255) DEFAULT NULL,
  `recorded_by` int(10) unsigned DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_student_date_att` (`student_record_id`,`attendance_date`),
  KEY `idx_class_sec_date` (`my_class_id`,`section_id`,`attendance_date`),
  KEY `student_attendances_attendance_date_index` (`attendance_date`),
  KEY `student_attendances_attendance_date_bs_index` (`attendance_date_bs`),
  KEY `student_attendances_user_id_foreign` (`user_id`),
  KEY `student_attendances_section_id_foreign` (`section_id`),
  KEY `student_attendances_recorded_by_foreign` (`recorded_by`),
  KEY `student_attendances_updated_by_foreign` (`updated_by`),
  CONSTRAINT `student_attendances_my_class_id_foreign` FOREIGN KEY (`my_class_id`) REFERENCES `my_classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_attendances_recorded_by_foreign` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `student_attendances_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_attendances_student_record_id_foreign` FOREIGN KEY (`student_record_id`) REFERENCES `student_records` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_attendances_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `student_attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_attendances`
--

LOCK TABLES `student_attendances` WRITE;
/*!40000 ALTER TABLE `student_attendances` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_records`
--

DROP TABLE IF EXISTS `student_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `my_class_id` int(10) unsigned NOT NULL,
  `section_id` int(10) unsigned NOT NULL,
  `adm_no` varchar(30) DEFAULT NULL,
  `my_parent_id` int(10) unsigned DEFAULT NULL,
  `dorm_id` int(10) unsigned DEFAULT NULL,
  `dorm_room_no` varchar(255) DEFAULT NULL,
  `session` varchar(255) NOT NULL,
  `house` varchar(255) DEFAULT NULL,
  `age` tinyint(4) DEFAULT NULL,
  `year_admitted` varchar(255) DEFAULT NULL,
  `grad` tinyint(4) NOT NULL DEFAULT 0,
  `grad_date` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_records_adm_no_unique` (`adm_no`),
  KEY `student_records_user_id_foreign` (`user_id`),
  KEY `student_records_my_class_id_foreign` (`my_class_id`),
  KEY `student_records_section_id_foreign` (`section_id`),
  KEY `student_records_my_parent_id_foreign` (`my_parent_id`),
  KEY `student_records_dorm_id_foreign` (`dorm_id`),
  CONSTRAINT `student_records_dorm_id_foreign` FOREIGN KEY (`dorm_id`) REFERENCES `dorms` (`id`) ON DELETE SET NULL,
  CONSTRAINT `student_records_my_class_id_foreign` FOREIGN KEY (`my_class_id`) REFERENCES `my_classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_records_my_parent_id_foreign` FOREIGN KEY (`my_parent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `student_records_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_records_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_records`
--

LOCK TABLES `student_records` WRITE;
/*!40000 ALTER TABLE `student_records` DISABLE KEYS */;
INSERT INTO `student_records` VALUES (1,18,1,1,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:20:58','2026-10-24 05:20:58'),(2,19,1,1,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:20:58','2026-10-24 05:20:58'),(3,20,1,1,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:20:58','2026-10-24 05:20:58'),(4,21,1,1,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:20:58','2026-10-24 05:20:58'),(5,22,1,2,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:20:59','2026-10-24 05:20:59'),(6,23,1,2,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:20:59','2026-10-24 05:20:59'),(7,24,1,2,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:20:59','2026-10-24 05:20:59'),(8,25,2,3,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:20:59','2026-10-24 05:20:59'),(9,26,2,3,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:20:59','2026-10-24 05:20:59'),(10,27,2,3,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:20:59','2026-10-24 05:20:59'),(11,28,2,4,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:20:59','2026-10-24 05:20:59'),(12,29,2,4,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:20:59','2026-10-24 05:20:59'),(13,30,2,4,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:20:59','2026-10-24 05:20:59'),(14,31,3,5,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:00','2026-10-24 05:21:00'),(15,32,3,5,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:00','2026-10-24 05:21:00'),(16,33,3,5,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:00','2026-10-24 05:21:00'),(17,34,4,6,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:00','2026-10-24 05:21:00'),(18,35,4,6,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:00','2026-10-24 05:21:00'),(19,36,4,6,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:00','2026-10-24 05:21:00'),(20,37,5,7,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:01','2026-10-24 05:21:01'),(21,38,5,7,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:01','2026-10-24 05:21:01'),(22,39,5,7,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:01','2026-10-24 05:21:01'),(23,40,6,8,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:01','2026-10-24 05:21:01'),(24,41,6,8,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:01','2026-10-24 05:21:01'),(25,42,6,8,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:01','2026-10-24 05:21:01'),(26,43,7,9,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:01','2026-10-24 05:21:01'),(27,44,7,9,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:02','2026-10-24 05:21:02'),(28,45,7,9,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:02','2026-10-24 05:21:02'),(29,46,8,10,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:02','2026-10-24 05:21:02'),(30,47,8,10,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:02','2026-10-24 05:21:02'),(31,48,8,10,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:02','2026-10-24 05:21:02'),(32,49,9,11,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:02','2026-10-24 05:21:02'),(33,50,9,11,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:02','2026-10-24 05:21:02'),(34,51,9,11,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:02','2026-10-24 05:21:02'),(35,52,10,12,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:03','2026-10-24 05:21:03'),(36,53,10,12,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:03','2026-10-24 05:21:03'),(37,54,10,12,NULL,NULL,NULL,NULL,'2018-2019',NULL,NULL,NULL,0,NULL,'2026-10-24 05:21:03','2026-10-24 05:21:03'),(38,55,8,10,'CJIA/S/2025/47469',9,1,NULL,'2083/84 BS Updated',NULL,NULL,'2025',0,NULL,'2026-10-24 13:30:53','2026-10-24 13:30:53');
/*!40000 ALTER TABLE `student_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `theory_max` smallint(5) unsigned NOT NULL DEFAULT 75,
  `theory_pass` smallint(5) unsigned NOT NULL DEFAULT 27,
  `practical_max` smallint(5) unsigned NOT NULL DEFAULT 25,
  `practical_pass` smallint(5) unsigned NOT NULL DEFAULT 10,
  `total_max` smallint(5) unsigned NOT NULL DEFAULT 100,
  `total_pass` smallint(5) unsigned NOT NULL DEFAULT 35,
  `credit_hour` decimal(4,2) NOT NULL DEFAULT 4.00,
  `has_practical` tinyint(1) NOT NULL DEFAULT 0,
  `my_class_id` int(10) unsigned NOT NULL,
  `teacher_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subjects_my_class_id_name_unique` (`my_class_id`,`name`),
  KEY `subjects_teacher_id_foreign` (`teacher_id`),
  CONSTRAINT `subjects_my_class_id_foreign` FOREIGN KEY (`my_class_id`) REFERENCES `my_classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `subjects_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (1,'English Language','Eng',75,27,25,10,100,35,4.00,1,1,3,NULL,'2026-10-24 12:43:43'),(2,'Mathematics','Math',75,27,25,10,100,35,4.00,0,1,3,NULL,NULL),(3,'English Language','Eng',75,27,25,10,100,35,4.00,0,2,3,NULL,NULL),(4,'Mathematics','Math',75,27,25,10,100,35,4.00,0,2,3,NULL,NULL),(5,'English Language','Eng',75,27,25,10,100,35,4.00,0,3,3,NULL,NULL),(6,'Mathematics','Math',75,27,25,10,100,35,4.00,0,3,3,NULL,NULL),(7,'English Language','Eng',75,27,25,10,100,35,4.00,0,4,3,NULL,NULL),(8,'Mathematics','Math',75,27,25,10,100,35,4.00,0,4,3,NULL,NULL),(9,'English Language','Eng',75,27,25,10,100,35,4.00,0,5,3,NULL,NULL),(10,'Mathematics','Math',75,27,25,10,100,35,4.00,0,5,3,NULL,NULL),(11,'English Language','Eng',75,27,25,10,100,35,4.00,0,6,3,NULL,NULL),(12,'Mathematics','Math',75,27,25,10,100,35,4.00,0,6,3,NULL,NULL),(13,'English Language','Eng',75,27,25,10,100,35,4.00,0,7,3,NULL,NULL),(14,'Mathematics','Math',75,27,25,10,100,35,4.00,0,7,3,NULL,NULL),(15,'English Language','Eng',75,27,25,10,100,35,4.00,0,8,3,NULL,NULL),(16,'Mathematics','Math',75,27,25,10,100,35,4.00,0,8,3,NULL,NULL),(17,'English Language','Eng',75,27,25,10,100,35,4.00,0,9,3,NULL,NULL),(18,'Mathematics','Math',75,27,25,10,100,35,4.00,0,9,3,NULL,NULL),(19,'English Language','Eng',75,27,25,10,100,35,4.00,0,10,3,NULL,NULL),(20,'Mathematics','Math',75,27,25,10,100,35,4.00,0,10,3,NULL,NULL);
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `time_slots`
--

DROP TABLE IF EXISTS `time_slots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `time_slots` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ttr_id` int(10) unsigned NOT NULL,
  `hour_from` tinyint(4) NOT NULL,
  `min_from` varchar(2) NOT NULL,
  `meridian_from` varchar(2) NOT NULL,
  `hour_to` tinyint(4) NOT NULL,
  `min_to` varchar(2) NOT NULL,
  `meridian_to` varchar(2) NOT NULL,
  `time_from` varchar(100) NOT NULL,
  `time_to` varchar(100) NOT NULL,
  `timestamp_from` varchar(50) NOT NULL,
  `timestamp_to` varchar(50) NOT NULL,
  `full` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `time_slots_timestamp_from_timestamp_to_ttr_id_unique` (`timestamp_from`,`timestamp_to`,`ttr_id`),
  KEY `time_slots_ttr_id_foreign` (`ttr_id`),
  CONSTRAINT `time_slots_ttr_id_foreign` FOREIGN KEY (`ttr_id`) REFERENCES `time_table_records` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_slots`
--

LOCK TABLES `time_slots` WRITE;
/*!40000 ALTER TABLE `time_slots` DISABLE KEYS */;
INSERT INTO `time_slots` VALUES (1,1,10,'00','AM',10,'45','AM','10:00 AM','10:45 AM','1792815300','1792818000','10:00 AM - 10:45 AM','2026-10-24 13:28:25','2026-10-24 13:28:25');
/*!40000 ALTER TABLE `time_slots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `time_table_records`
--

DROP TABLE IF EXISTS `time_table_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `time_table_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `my_class_id` int(10) unsigned NOT NULL,
  `exam_id` int(10) unsigned DEFAULT NULL,
  `year` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `time_table_records_name_unique` (`name`),
  UNIQUE KEY `time_table_records_my_class_id_exam_id_year_unique` (`my_class_id`,`exam_id`,`year`),
  KEY `time_table_records_exam_id_foreign` (`exam_id`),
  CONSTRAINT `time_table_records_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `time_table_records_my_class_id_foreign` FOREIGN KEY (`my_class_id`) REFERENCES `my_classes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_table_records`
--

LOCK TABLES `time_table_records` WRITE;
/*!40000 ALTER TABLE `time_table_records` DISABLE KEYS */;
INSERT INTO `time_table_records` VALUES (1,'eca',6,NULL,'2083/84 BS Updated','2026-10-24 13:26:36','2026-10-24 13:26:36');
/*!40000 ALTER TABLE `time_table_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `time_tables`
--

DROP TABLE IF EXISTS `time_tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `time_tables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ttr_id` int(10) unsigned NOT NULL,
  `ts_id` int(10) unsigned NOT NULL,
  `subject_id` int(10) unsigned DEFAULT NULL,
  `exam_date` varchar(50) DEFAULT NULL,
  `timestamp_from` varchar(100) NOT NULL,
  `timestamp_to` varchar(100) NOT NULL,
  `day` varchar(50) DEFAULT NULL,
  `day_num` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `time_tables_ttr_id_ts_id_day_unique` (`ttr_id`,`ts_id`,`day`),
  UNIQUE KEY `time_tables_ttr_id_ts_id_exam_date_unique` (`ttr_id`,`ts_id`,`exam_date`),
  KEY `time_tables_ts_id_foreign` (`ts_id`),
  KEY `time_tables_subject_id_foreign` (`subject_id`),
  CONSTRAINT `time_tables_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `time_tables_ts_id_foreign` FOREIGN KEY (`ts_id`) REFERENCES `time_slots` (`id`) ON DELETE CASCADE,
  CONSTRAINT `time_tables_ttr_id_foreign` FOREIGN KEY (`ttr_id`) REFERENCES `time_table_records` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_tables`
--

LOCK TABLES `time_tables` WRITE;
/*!40000 ALTER TABLE `time_tables` DISABLE KEYS */;
INSERT INTO `time_tables` VALUES (1,1,1,11,NULL,'1792988100','1792990800','Monday',NULL,'2026-10-24 13:29:20','2026-10-24 13:29:20');
/*!40000 ALTER TABLE `time_tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_types`
--

DROP TABLE IF EXISTS `user_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_types`
--

LOCK TABLES `user_types` WRITE;
/*!40000 ALTER TABLE `user_types` DISABLE KEYS */;
INSERT INTO `user_types` VALUES (1,'accountant','Accountant','5',NULL,NULL),(2,'parent','Parent','4',NULL,NULL),(3,'teacher','Teacher','3',NULL,NULL),(4,'admin','Admin','2',NULL,NULL),(5,'super_admin','Super Admin','1',NULL,NULL);
/*!40000 ALTER TABLE `user_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `code` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `user_type` varchar(255) NOT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `photo` varchar(255) NOT NULL DEFAULT 'http://localhost/global_assets/images/user.png',
  `phone` varchar(255) DEFAULT NULL,
  `phone2` varchar(255) DEFAULT NULL,
  `bg_id` int(10) unsigned DEFAULT NULL,
  `state_id` int(10) unsigned DEFAULT NULL,
  `lga_id` int(10) unsigned DEFAULT NULL,
  `nal_id` int(10) unsigned DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `locale` varchar(10) NOT NULL DEFAULT 'ne',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_code_unique` (`code`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`),
  KEY `users_state_id_foreign` (`state_id`),
  KEY `users_lga_id_foreign` (`lga_id`),
  KEY `users_bg_id_foreign` (`bg_id`),
  KEY `users_nal_id_foreign` (`nal_id`),
  CONSTRAINT `users_bg_id_foreign` FOREIGN KEY (`bg_id`) REFERENCES `blood_groups` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_lga_id_foreign` FOREIGN KEY (`lga_id`) REFERENCES `lgas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_nal_id_foreign` FOREIGN KEY (`nal_id`) REFERENCES `nationalities` (`id`) ON DELETE SET NULL,
  CONSTRAINT `users_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'CJ Inspired','cj@cj.com','UQU0QQXXIF','cj','super_admin',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$TUDeLW0os6NirsuWcNsCvO81jKIegxfaK6FxklJXZZPFgiuT7l3y6','2CI98oOKCYt6LoQstVyHtO2G6f8jvxPvT1xhnob7bKy0kERtV4dBKepCbHHb','ne',NULL,'2026-10-24 13:54:21'),(2,'Admin KORA','admin@admin.com','IATPWDBEZS','admin','admin',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$TUDeLW0os6NirsuWcNsCvO81jKIegxfaK6FxklJXZZPFgiuT7l3y6','iQHczyEXTYlsvvTe5NmXZnaBxzFdr806AbwbeyXGHVL2YPnpPvx1fVNOjus9','ne',NULL,NULL),(3,'Teacher Chike','teacher@teacher.com','EFV9J2MIOF','teacher','teacher',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$TUDeLW0os6NirsuWcNsCvO81jKIegxfaK6FxklJXZZPFgiuT7l3y6','eFxQZzp8egLpfPCfziTq8DeAFibAb6FByLpXZl0TmRU9cYbYqnhqAafCgyCj','ne',NULL,NULL),(4,'Parent Kaba','parent@parent.com','8UYT1TJ0BJ','parent','parent',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$TUDeLW0os6NirsuWcNsCvO81jKIegxfaK6FxklJXZZPFgiuT7l3y6','aCjLbHlcZX','ne',NULL,NULL),(5,'Accountant Jeff','accountant@accountant.com','BGC9CVLFD5','accountant','accountant',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$TUDeLW0os6NirsuWcNsCvO81jKIegxfaK6FxklJXZZPFgiuT7l3y6','QgSRTMbCa4','ne',NULL,NULL),(6,'Admin 1','admin1@admin.com','UVPKZFIDMA','admin1','admin',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$zA9Z/8YK/dB/AS.wk1gM6uh6AQlGADBbuXNON2n.mgDakECANGpoy','8rFxmIL831','ne',NULL,NULL),(7,'Teacher 1','teacher1@teacher.com','EFTXMJNTS0','teacher1','teacher',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$ePeP9K7pgVkpkXW0Lmpv..dKdaTY0GJXr8u9uhlx4m5wajDzRQ6E6','K7xk7c6XYr','ne',NULL,NULL),(8,'Accountant 1','accountant1@accountant.com','ZM2P0C8YGW','accountant1','accountant',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$26kjF4zwuB5n4dEN62Xgwu9xBbhdB.04lSr3.4d4VTB9smi1Z2Kn6','ANTOGgaE9z','ne',NULL,NULL),(9,'Parent 1','parent1@parent.com','OQJN4FKZRF','parent1','parent',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$JWC6.6HQluZcgVj0CZVEq.ehqNrJer41vyqm.2t5JwRa8fPufrGoa','w64TMq0sI7','ne',NULL,NULL),(10,'Admin 2','admin2@admin.com','QGBWN2SEUV','admin2','admin',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$wnHP4hxI6Jb41ocCAkAwGOQXmvR2xFUFTFDbgfZ/y5.bcYX1qU1De','4QKoDFVZ74','ne',NULL,NULL),(11,'Teacher 2','teacher2@teacher.com','VSPNYFT4RR','teacher2','teacher',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$kex99AoTXmCaYJb9SlpkGOnZCTfiIZF80weO0mteDH4ljIc4DeAgW','BVoRgxX1FS','ne',NULL,NULL),(12,'Accountant 2','accountant2@accountant.com','GWLPCC4WKG','accountant2','accountant',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$Iw42knO9GYAL4igCvgjqVeNGBeYVLbFscPLieh7VlTEI5hmxEnF9a','SCkSVVUgGW','ne',NULL,NULL),(13,'Parent 2','parent2@parent.com','G1SOTURZB1','parent2','parent',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$7.6bCJLhZKa83iYW5mMSTOYGjGWtok8anCrWvRCtP04BUXRVqmmgG','JtPZpKSzYV','ne',NULL,NULL),(14,'Admin 3','admin3@admin.com','SZLGKZ7XXK','admin3','admin',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$zXivtC7920BkD57ZRydV0eI/eHLY5TUPLZvFWKJ933pD6QE2fJIce','QSUt1sLwIJ','ne',NULL,NULL),(15,'Teacher 3','teacher3@teacher.com','BDHNFSPK1A','teacher3','teacher',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$bSeibThdNmJTuohyafxHjuJNrzeEDAVJ9bl9xsEvuHo/DDp7ArC8e','EeGfzzH5my','ne',NULL,NULL),(16,'Accountant 3','accountant3@accountant.com','6ZLC7JRVXQ','accountant3','accountant',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$FLsquTQUOwR8DtXwOpdcvu7uyA4MBncIq5EWVtfmFG8pMZKsfzDLm','NjR1yyueTE','ne',NULL,NULL),(17,'Parent 3','parent3@parent.com','4ZGOTFUWWV','parent3','parent',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$gFtDhQ1G1nrZK3c1ZmFubO0wObPBHcBbF0l2tObdnNikVJefMlrKG','r5dCJKrQFm','ne',NULL,NULL),(18,'Student CJ','student@student.com','RS5OPCL9DB','student','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$zbUh1IBYSN5R1KkfL7DcJeZlXzjAdU8S0dbb8nwjCmFz6jyQbcm8a','jpxeO4bs6ihu0VdU7idV1rMldSRbgMWU1V8XkSFOTW2425Fvu3aZSLlfbgn9','en','2026-10-24 05:20:58','2026-10-24 13:34:38'),(19,'Sid Denesik','ruby78@example.com','G6GSX3B6V0','kristin.cummings','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$rFekVkz3F/SepMVlyH5n0uZ5iatqCO8/RhlwaxhhV5VahgnI3o5FS','VLyJQpg3Fe','ne','2026-10-24 05:20:58','2026-10-24 05:20:58'),(20,'Monica Hand DVM','friesen.moses@example.org','KBFHSZS5MB','brandi.schuppe','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$rFekVkz3F/SepMVlyH5n0uZ5iatqCO8/RhlwaxhhV5VahgnI3o5FS','mODJiLq3Fk','ne','2026-10-24 05:20:58','2026-10-24 05:20:58'),(21,'Autumn Rohan','rowan26@example.com','UMJSOLJLWZ','tryan','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$rFekVkz3F/SepMVlyH5n0uZ5iatqCO8/RhlwaxhhV5VahgnI3o5FS','kQ6WNqNXGC','ne','2026-10-24 05:20:58','2026-10-24 05:20:58'),(22,'Diamond Jerde','dallas.gibson@example.org','ITFT96BW6Q','jimmy43','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$lpKQJ8hkqf3xBzcJsNvUJuUvDYuYcCzqCIsSn2Au48D0g3J0wDB5u','OOLHmWX71B','ne','2026-10-24 05:20:59','2026-10-24 05:20:59'),(23,'Mr. Odell Gottlieb I','schaefer.frida@example.net','TLGACDTXQS','jeffrey.kris','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$lpKQJ8hkqf3xBzcJsNvUJuUvDYuYcCzqCIsSn2Au48D0g3J0wDB5u','ynq3lWa7tR','ne','2026-10-24 05:20:59','2026-10-24 05:20:59'),(24,'Una Ryan','nweber@example.com','ALAJFKEAAZ','xhartmann','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$lpKQJ8hkqf3xBzcJsNvUJuUvDYuYcCzqCIsSn2Au48D0g3J0wDB5u','RIAG48K9za','ne','2026-10-24 05:20:59','2026-10-24 05:20:59'),(25,'Miss Lavonne Koch Jr.','skylar.wyman@example.com','CVJDYJPLX4','jjacobi','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$cC7p.myKrXwTwh/cCaOTqu3uw46jE3SeITSoFx/4H3IE8NW9w1Z3i','mUR5KFhXZq','ne','2026-10-24 05:20:59','2026-10-24 05:20:59'),(26,'Eula Nikolaus','buckridge.makenna@example.com','3A6KURYQ1H','pferry','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$cC7p.myKrXwTwh/cCaOTqu3uw46jE3SeITSoFx/4H3IE8NW9w1Z3i','d2S2UvlF2G','ne','2026-10-24 05:20:59','2026-10-24 05:20:59'),(27,'Bernardo Pollich','anderson.jed@example.net','RGSIEXLVAE','daryl.hermann','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$cC7p.myKrXwTwh/cCaOTqu3uw46jE3SeITSoFx/4H3IE8NW9w1Z3i','dIlTrtOsk4','ne','2026-10-24 05:20:59','2026-10-24 05:20:59'),(28,'Owen Krajcik','marjory61@example.com','NYDIHVE6AY','tyree14','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$xisy6BWBOXOfz0zrAayNQuhgYCU3ZVpFF40gNEK6yWjIxvhta2B/q','v1eRHEQU2c','ne','2026-10-24 05:20:59','2026-10-24 05:20:59'),(29,'Kris Senger','cory24@example.org','FTIKZA9D68','watsica.cesar','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$xisy6BWBOXOfz0zrAayNQuhgYCU3ZVpFF40gNEK6yWjIxvhta2B/q','1A3ueg70eM','ne','2026-10-24 05:20:59','2026-10-24 05:20:59'),(30,'Mr. Gunner Emmerich IV','sschmidt@example.org','Z5XKGBUDB7','caesar71','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$xisy6BWBOXOfz0zrAayNQuhgYCU3ZVpFF40gNEK6yWjIxvhta2B/q','jrWu34uTqb','ne','2026-10-24 05:20:59','2026-10-24 05:20:59'),(31,'Mrs. Nicolette Kunze Jr.','janessa.walter@example.com','BYAFERKM9U','vhegmann','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$aeaDWQYUNKeqAofUUAf5jewFwF.8CPUrWgfobKTlAV4fz.oLRdS7a','5TsOKMDyTr','ne','2026-10-24 05:21:00','2026-10-24 05:21:00'),(32,'Everardo Hansen','umcdermott@example.net','FUOKGQXGF9','einar.towne','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$aeaDWQYUNKeqAofUUAf5jewFwF.8CPUrWgfobKTlAV4fz.oLRdS7a','whJX51ULrw','ne','2026-10-24 05:21:00','2026-10-24 05:21:00'),(33,'Odie Hauck','kuhlman.pansy@example.org','O1MCMS0WE2','vincent.pollich','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$aeaDWQYUNKeqAofUUAf5jewFwF.8CPUrWgfobKTlAV4fz.oLRdS7a','EWYQawbQQd','ne','2026-10-24 05:21:00','2026-10-24 05:21:00'),(34,'Gerson Legros','pfannerstill.margie@example.net','KIJYH95MEJ','stefan.reichert','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$AAeHKtljOLSLi0dzsfPs6eorLLk.mjzJA03Vex8gQcKZKcrnGLfAC','6hYNIy7RfK','ne','2026-10-24 05:21:00','2026-10-24 05:21:00'),(35,'Lilyan Ledner','dietrich.asha@example.com','RSBAYVFQXF','ubeahan','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$AAeHKtljOLSLi0dzsfPs6eorLLk.mjzJA03Vex8gQcKZKcrnGLfAC','EeXosYeEWM','ne','2026-10-24 05:21:00','2026-10-24 05:21:00'),(36,'Hanna O\'Kon','juliana05@example.com','ZTWEUIQZM8','leanna.breitenberg','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$AAeHKtljOLSLi0dzsfPs6eorLLk.mjzJA03Vex8gQcKZKcrnGLfAC','PXGcwz528J','ne','2026-10-24 05:21:00','2026-10-24 05:21:00'),(37,'Ms. Sophie Douglas','weber.aurelio@example.com','5RCVU87GOI','larson.amelie','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$/7YwDFdIkbWZH8SB1I5VKuxjgKOHq6gbfqfeoUp7W2fwy7d9TMGU2','x4mLid0yt1','ne','2026-10-24 05:21:01','2026-10-24 05:21:01'),(38,'Ms. Magali Turner','margret.ritchie@example.com','QSW7TOSBYJ','reinger.esteban','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$/7YwDFdIkbWZH8SB1I5VKuxjgKOHq6gbfqfeoUp7W2fwy7d9TMGU2','9IIXX8YmIP','ne','2026-10-24 05:21:01','2026-10-24 05:21:01'),(39,'Dr. Margarita White DDS','augusta24@example.com','Y2BWVOMPKV','morris30','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$/7YwDFdIkbWZH8SB1I5VKuxjgKOHq6gbfqfeoUp7W2fwy7d9TMGU2','eY1lYWmzlV','ne','2026-10-24 05:21:01','2026-10-24 05:21:01'),(40,'Prof. Maribel Morissette','pmayer@example.org','FRBR7ZMK54','cortez.strosin','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$88TE24DY8L8WX0T3LoALP.c/pmgULWlPjptrzEWvsZYaIxwRx1Hdm','JmPL6cATqK','ne','2026-10-24 05:21:01','2026-10-24 05:21:01'),(41,'Rocio Senger','hermiston.makenzie@example.net','8ZA4JSS9QR','hegmann.gust','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$88TE24DY8L8WX0T3LoALP.c/pmgULWlPjptrzEWvsZYaIxwRx1Hdm','24PNK8hqQP','ne','2026-10-24 05:21:01','2026-10-24 05:21:01'),(42,'Daija Hill II','blanda.darlene@example.net','YWM6JKFU39','vmedhurst','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$88TE24DY8L8WX0T3LoALP.c/pmgULWlPjptrzEWvsZYaIxwRx1Hdm','gaSHIF4FI4','ne','2026-10-24 05:21:01','2026-10-24 05:21:01'),(43,'Dr. Mariam Abbott IV','kayleigh.medhurst@example.org','BZGXMCU4XR','brice.johnson','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$Ifh7JgzWx44PKnk9gbSLe.eitQbiKEbBaq/lZyQNHoDdGMn8PEAAC','OOoiIbyQPr','ne','2026-10-24 05:21:01','2026-10-24 05:21:01'),(44,'Trevor Sipes','randal.larson@example.org','2OLLYBRDTQ','polly23','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$Ifh7JgzWx44PKnk9gbSLe.eitQbiKEbBaq/lZyQNHoDdGMn8PEAAC','9tV3E6Hw3v','ne','2026-10-24 05:21:01','2026-10-24 05:21:01'),(45,'Connor Bogan','rosalee.cruickshank@example.org','MIZJKGXKCW','ladarius.macejkovic','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$Ifh7JgzWx44PKnk9gbSLe.eitQbiKEbBaq/lZyQNHoDdGMn8PEAAC','7Co8Wfh1ec','ne','2026-10-24 05:21:02','2026-10-24 05:21:02'),(46,'Dr. Nona Smitham','micah.wisozk@example.net','MZ04SENLOG','zechariah.daugherty','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$Ka2s7GT6N67YVYz6ELZYrOeV4tU3aJU.2mkwR2ODyRdT01GkW6gR6','cihH3RWsBM','ne','2026-10-24 05:21:02','2026-10-24 05:21:02'),(47,'Casey O\'Conner','lorenz37@example.net','L95SZLLPDV','kris.whitney','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$Ka2s7GT6N67YVYz6ELZYrOeV4tU3aJU.2mkwR2ODyRdT01GkW6gR6','Qz5Sj4dPuB','ne','2026-10-24 05:21:02','2026-10-24 05:21:02'),(48,'Dr. Lambert Stanton','cmarks@example.org','WHCMEGHJVH','gregorio.rippin','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$Ka2s7GT6N67YVYz6ELZYrOeV4tU3aJU.2mkwR2ODyRdT01GkW6gR6','9EdgKfB8Bm','ne','2026-10-24 05:21:02','2026-10-24 05:21:02'),(49,'Dr. Frederic Balistreri','rwehner@example.net','YJC9HFJ5YX','cremin.brock','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$CAJIzLSckAgO9nxwwXvG7O8ggRlV5kwgAAaF8RyuytL7m.TpCaeJa','TFSFRB42yJ','ne','2026-10-24 05:21:02','2026-10-24 05:21:02'),(50,'Holly Haag','friedrich.kuhlman@example.org','TWVQMCN64J','libby.heidenreich','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$CAJIzLSckAgO9nxwwXvG7O8ggRlV5kwgAAaF8RyuytL7m.TpCaeJa','0NTNzyBjni','ne','2026-10-24 05:21:02','2026-10-24 05:21:02'),(51,'Lennie Gerhold','xhintz@example.net','0LD0DRSTXS','edooley','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$CAJIzLSckAgO9nxwwXvG7O8ggRlV5kwgAAaF8RyuytL7m.TpCaeJa','Fc5AoxtVxk','ne','2026-10-24 05:21:02','2026-10-24 05:21:02'),(52,'Jesse Daniel','rosella73@example.org','OSOLYNILCC','helmer.doyle','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$iY4OC/ho8IoJEPLoPLWxzOc8gmfW7pxxj1ViffcoJooRhPGKFeFq6','aR4w6dMsKe','ne','2026-10-24 05:21:03','2026-10-24 05:21:03'),(53,'Torrance Goyette','mcclure.clint@example.com','OZ0LHPZHRM','ali25','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$iY4OC/ho8IoJEPLoPLWxzOc8gmfW7pxxj1ViffcoJooRhPGKFeFq6','NLR6N7xg19','ne','2026-10-24 05:21:03','2026-10-24 05:21:03'),(54,'Colby Rolfson','elda17@example.net','YU2O5UEJZF','langosh.aylin','student',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$iY4OC/ho8IoJEPLoPLWxzOc8gmfW7pxxj1ViffcoJooRhPGKFeFq6','dXSdqeGC5T','ne','2026-10-24 05:21:03','2026-10-24 05:21:03'),(55,'Mohit Shrestha','mohitstha29@gmail.com','0K8TAXUJWJ','CJIA/S/2025/47469','student','2008-03-19','Male','http://127.0.0.1:8000/storage/uploads/student/0K8TAXUJWJ/photo.jpg','9762948720','9762948720',7,21,414,127,'Bargachi',NULL,'$2y$10$gbtArA1z4KKD7NhFu1g9HeCltGl8erDU1SiRRy7xmCJXldETUzmh.',NULL,'ne','2026-10-24 13:30:53','2026-10-24 13:48:50'),(56,'Promotion Super Admin','admin_promo_test@example.com','3F2DA0E41A','admin_promo_test','super_admin',NULL,NULL,'http://localhost/global_assets/images/user.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$04$.3SCbfvfv7GLZvYKcsHnA.Si778HUbcrQvqawG7yJwkS7CQdqSKs2',NULL,'ne','2026-10-24 13:50:32','2026-10-24 13:50:32');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-24 19:41:47
