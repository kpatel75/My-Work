-- MySQL dump 10.13  Distrib 8.0.22, for Linux (x86_64)
--
-- Host: demolay-db.cxprmuf7didl.us-west-2.rds.amazonaws.com    Database: demolaydb
-- ------------------------------------------------------
-- Server version	8.0.20

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

--
-- Table structure for table `access_roles`
--

DROP TABLE IF EXISTS `access_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `access_roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access_roles`
--

LOCK TABLES `access_roles` WRITE;
/*!40000 ALTER TABLE `access_roles` DISABLE KEYS */;
INSERT INTO `access_roles` VALUES (1,'admin','2020-12-17 02:59:38','2020-12-17 02:59:38'),(2,'secretary','2020-12-17 02:59:38','2020-12-17 02:59:38'),(3,'president','2020-12-17 02:59:39','2020-12-17 02:59:39'),(4,'executive','2020-12-17 02:59:39','2020-12-17 02:59:39'),(5,'Chapter','2020-12-17 02:59:40','2020-12-17 02:59:40');
/*!40000 ALTER TABLE `access_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_categories`
--

DROP TABLE IF EXISTS `activity_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `activity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_categories`
--

LOCK TABLES `activity_categories` WRITE;
/*!40000 ALTER TABLE `activity_categories` DISABLE KEYS */;
INSERT INTO `activity_categories` VALUES (1,'Athletics','2020-12-17 02:59:53','2020-12-17 02:59:53'),(2,'Attendance','2020-12-17 02:59:53','2020-12-17 02:59:53'),(3,'Civic Service','2020-12-17 02:59:54','2020-12-17 02:59:54'),(4,'Conclave','2020-12-17 02:59:54','2020-12-17 02:59:54'),(5,'Correspondence Course','2020-12-17 02:59:55','2020-12-17 02:59:55'),(6,'Fine Arts','2020-12-17 02:59:55','2020-12-17 02:59:55'),(7,'Fund Raising','2020-12-17 02:59:55','2020-12-17 02:59:55'),(8,'Installing','2020-12-17 02:59:56','2020-12-17 02:59:56'),(9,'Journalism','2020-12-17 02:59:56','2020-12-17 02:59:56'),(10,'Masonic Attendance','2020-12-17 02:59:57','2020-12-17 02:59:57'),(11,'Masonic Service','2020-12-17 02:59:57','2020-12-17 02:59:57'),(12,'Merit','2020-12-17 02:59:57','2020-12-17 02:59:57'),(13,'Membership','2020-12-17 02:59:58','2020-12-17 02:59:58'),(14,'Priory','2020-12-17 02:59:58','2020-12-17 02:59:58'),(15,'Religion','2020-12-17 02:59:59','2020-12-17 02:59:59'),(16,'Ritual','2020-12-17 02:59:59','2020-12-17 02:59:59'),(17,'Safe Driver','2020-12-17 02:59:59','2020-12-17 02:59:59'),(18,'Scholastics','2020-12-17 03:00:00','2020-12-17 03:00:00'),(19,'Visitation','2020-12-17 03:00:01','2020-12-17 03:00:01');
/*!40000 ALTER TABLE `activity_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `activity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `affected_member_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `user_first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  KEY `activity_logs_affected_member_id_foreign` (`affected_member_id`),
  CONSTRAINT `activity_logs_affected_member_id_foreign` FOREIGN KEY (`affected_member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chapters`
--

DROP TABLE IF EXISTS `chapters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chapters` (
  `id` bigint unsigned NOT NULL,
  `jurisdiction_id` bigint unsigned NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`jurisdiction_id`),
  KEY `chapters_jurisdiction_id_foreign` (`jurisdiction_id`),
  CONSTRAINT `chapters_jurisdiction_id_foreign` FOREIGN KEY (`jurisdiction_id`) REFERENCES `jurisdictions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chapters`
--

LOCK TABLES `chapters` WRITE;
/*!40000 ALTER TABLE `chapters` DISABLE KEYS */;
/*!40000 ALTER TABLE `chapters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `country_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (9,'Canada','2020-12-17 02:59:32','2020-12-17 02:59:32');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `create_users`
--

DROP TABLE IF EXISTS `create_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `create_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `create_access_role_id` bigint unsigned NOT NULL,
  `user_access_role_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `create_users_create_access_role_id_foreign` (`create_access_role_id`),
  KEY `create_users_user_access_role_id_foreign` (`user_access_role_id`),
  CONSTRAINT `create_users_create_access_role_id_foreign` FOREIGN KEY (`create_access_role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `create_users_user_access_role_id_foreign` FOREIGN KEY (`user_access_role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `create_users`
--

LOCK TABLES `create_users` WRITE;
/*!40000 ALTER TABLE `create_users` DISABLE KEYS */;
INSERT INTO `create_users` VALUES (1,1,1,'2020-12-17 02:59:46','2020-12-17 02:59:46'),(2,2,1,'2020-12-17 02:59:46','2020-12-17 02:59:46'),(3,3,1,'2020-12-17 02:59:47','2020-12-17 02:59:47'),(4,4,1,'2020-12-17 02:59:47','2020-12-17 02:59:47'),(5,5,1,'2020-12-17 02:59:47','2020-12-17 02:59:47'),(6,6,1,'2020-12-17 02:59:48','2020-12-17 02:59:48'),(7,7,1,'2020-12-17 02:59:48','2020-12-17 02:59:48'),(8,8,1,'2020-12-17 02:59:49','2020-12-17 02:59:49'),(9,9,1,'2020-12-17 02:59:49','2020-12-17 02:59:49'),(10,7,3,'2020-12-17 02:59:49','2020-12-17 02:59:49'),(11,8,3,'2020-12-17 02:59:50','2020-12-17 02:59:50'),(12,7,4,'2020-12-17 02:59:50','2020-12-17 02:59:50'),(13,8,4,'2020-12-17 02:59:51','2020-12-17 02:59:51'),(14,7,6,'2020-12-17 02:59:51','2020-12-17 02:59:51'),(15,8,6,'2020-12-17 02:59:51','2020-12-17 02:59:51'),(16,8,7,'2020-12-17 02:59:52','2020-12-17 02:59:52'),(17,9,7,'2020-12-17 02:59:52','2020-12-17 02:59:52'),(18,9,8,'2020-12-17 02:59:53','2020-12-17 02:59:53');
/*!40000 ALTER TABLE `create_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_descriptions`
--

DROP TABLE IF EXISTS `fee_descriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fee_descriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jurisdiction_id` bigint unsigned NOT NULL,
  `chapter_id` bigint unsigned NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fee_descriptions_id_jurisdiction_id_chapter_id_unique` (`id`,`jurisdiction_id`,`chapter_id`),
  KEY `fee_descriptions_jurisdiction_id_foreign` (`jurisdiction_id`),
  KEY `fee_descriptions_chapter_id_foreign` (`chapter_id`),
  CONSTRAINT `fee_descriptions_chapter_id_foreign` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fee_descriptions_jurisdiction_id_foreign` FOREIGN KEY (`jurisdiction_id`) REFERENCES `jurisdictions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_descriptions`
--

LOCK TABLES `fee_descriptions` WRITE;
/*!40000 ALTER TABLE `fee_descriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `fee_descriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fees`
--

DROP TABLE IF EXISTS `fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jurisdiction_id` bigint unsigned NOT NULL,
  `chapter_id` bigint unsigned NOT NULL,
  `amount` double NOT NULL,
  `description_id` bigint unsigned NOT NULL,
  `demolay_contribution` double NOT NULL DEFAULT '0',
  `chapter_contribution` double NOT NULL,
  `added_by` bigint unsigned NOT NULL,
  `edited_by_id` bigint unsigned DEFAULT NULL,
  `edited_by_first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edited_by_last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` year NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fees_id_jurisdiction_id_chapter_id_unique` (`id`,`jurisdiction_id`,`chapter_id`),
  KEY `fees_jurisdiction_id_foreign` (`jurisdiction_id`),
  KEY `fees_chapter_id_foreign` (`chapter_id`),
  KEY `fees_added_by_foreign` (`added_by`),
  KEY `fees_edited_by_id_foreign` (`edited_by_id`),
  KEY `fees_description_id_foreign` (`description_id`),
  CONSTRAINT `fees_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fees_chapter_id_foreign` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fees_description_id_foreign` FOREIGN KEY (`description_id`) REFERENCES `fee_descriptions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fees_edited_by_id_foreign` FOREIGN KEY (`edited_by_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fees_jurisdiction_id_foreign` FOREIGN KEY (`jurisdiction_id`) REFERENCES `jurisdictions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fees`
--

LOCK TABLES `fees` WRITE;
/*!40000 ALTER TABLE `fees` DISABLE KEYS */;
/*!40000 ALTER TABLE `fees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jurisdictions`
--

DROP TABLE IF EXISTS `jurisdictions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jurisdictions` (
  `id` bigint unsigned NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jurisdictions_country_id_foreign` (`country_id`),
  CONSTRAINT `jurisdictions_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jurisdictions`
--

LOCK TABLES `jurisdictions` WRITE;
/*!40000 ALTER TABLE `jurisdictions` DISABLE KEYS */;
INSERT INTO `jurisdictions` VALUES (0,'Canada',9,'2020-12-17 02:59:34','2020-12-17 02:59:34'),(1,'British Columbia',9,'2020-12-17 02:59:34','2020-12-17 02:59:34'),(2,'Alberta',9,'2020-12-17 02:59:35','2020-12-17 02:59:35'),(3,'Saskatchewan',9,'2020-12-17 02:59:35','2020-12-17 02:59:35'),(4,'Manitoba',9,'2020-12-17 02:59:36','2020-12-17 02:59:36'),(5,'Ontario',9,'2020-12-17 02:59:36','2020-12-17 02:59:36'),(6,'Quebec',9,'2020-12-17 02:59:37','2020-12-17 02:59:37'),(7,'Atlantic',9,'2020-12-17 02:59:37','2020-12-17 02:59:37'),(9,'General, Foundations',9,'2020-12-17 02:59:38','2020-12-17 02:59:38');
/*!40000 ALTER TABLE `jurisdictions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_activities`
--

DROP TABLE IF EXISTS `member_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `member_activities` (
  `activityid` bigint unsigned NOT NULL AUTO_INCREMENT,
  `memberid` bigint unsigned NOT NULL,
  `advisorid` bigint unsigned NOT NULL,
  `type_of_activityid` bigint unsigned NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `no_of_hour` int DEFAULT NULL,
  `point` int DEFAULT NULL,
  `mile` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`activityid`),
  KEY `member_activities_memberid_foreign` (`memberid`),
  KEY `member_activities_advisorid_foreign` (`advisorid`),
  KEY `member_activities_type_of_activityid_foreign` (`type_of_activityid`),
  CONSTRAINT `member_activities_advisorid_foreign` FOREIGN KEY (`advisorid`) REFERENCES `users` (`id`),
  CONSTRAINT `member_activities_memberid_foreign` FOREIGN KEY (`memberid`) REFERENCES `members` (`id`),
  CONSTRAINT `member_activities_type_of_activityid_foreign` FOREIGN KEY (`type_of_activityid`) REFERENCES `activity_categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_activities`
--

LOCK TABLES `member_activities` WRITE;
/*!40000 ALTER TABLE `member_activities` DISABLE KEYS */;
/*!40000 ALTER TABLE `member_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preferred_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `home_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdate` date NOT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jurisdiction_id` bigint unsigned NOT NULL,
  `chapter_id` bigint unsigned NOT NULL,
  `initiatory_date` date DEFAULT NULL,
  `senior_demolay_date` date DEFAULT NULL,
  `demolay_degree_date` date DEFAULT NULL,
  `father_senior_status` tinyint(1) NOT NULL DEFAULT '0',
  `father_mason_status` tinyint(1) NOT NULL DEFAULT '0',
  `father_senior_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_mason_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_mason_other` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_one_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_one_senior_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `guardian_one_mason_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `guardian_one_senior_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_one_mason_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_one_mason_other` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_two_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_two_senior_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `guardian_two_mason_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `guardian_two_senior_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_two_mason_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_two_mason_other` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sponsor_id` bigint NOT NULL,
  `sponsor_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Applicant',
  `position_id` bigint unsigned NOT NULL DEFAULT '1',
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `members_jurisdiction_id_foreign` (`jurisdiction_id`),
  KEY `members_chapter_id_jurisdiction_id_foreign` (`chapter_id`,`jurisdiction_id`),
  KEY `members_position_id_foreign` (`position_id`),
  CONSTRAINT `members_chapter_id_jurisdiction_id_foreign` FOREIGN KEY (`chapter_id`, `jurisdiction_id`) REFERENCES `chapters` (`id`, `jurisdiction_id`),
  CONSTRAINT `members_jurisdiction_id_foreign` FOREIGN KEY (`jurisdiction_id`) REFERENCES `jurisdictions` (`id`),
  CONSTRAINT `members_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `merit_bar_records`
--

DROP TABLE IF EXISTS `merit_bar_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `merit_bar_records` (
  `member_id` bigint unsigned NOT NULL,
  `activity_id` bigint unsigned NOT NULL,
  `merit_bar_id` bigint unsigned NOT NULL,
  `date_achieved` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`member_id`,`activity_id`,`merit_bar_id`),
  KEY `merit_bar_records_activity_id_foreign` (`activity_id`),
  KEY `merit_bar_records_merit_bar_id_foreign` (`merit_bar_id`),
  CONSTRAINT `merit_bar_records_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activity_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `merit_bar_records_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  CONSTRAINT `merit_bar_records_merit_bar_id_foreign` FOREIGN KEY (`merit_bar_id`) REFERENCES `merit_bars` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `merit_bar_records`
--

LOCK TABLES `merit_bar_records` WRITE;
/*!40000 ALTER TABLE `merit_bar_records` DISABLE KEYS */;
/*!40000 ALTER TABLE `merit_bar_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `merit_bars`
--

DROP TABLE IF EXISTS `merit_bars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `merit_bars` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `merit_bars`
--

LOCK TABLES `merit_bars` WRITE;
/*!40000 ALTER TABLE `merit_bars` DISABLE KEYS */;
INSERT INTO `merit_bars` VALUES (1,'White','2020-12-17 03:00:01','2020-12-17 03:00:01'),(2,'Red','2020-12-17 03:00:01','2020-12-17 03:00:01'),(3,'Blue','2020-12-17 03:00:02','2020-12-17 03:00:02'),(4,'Purple','2020-12-17 03:00:02','2020-12-17 03:00:02'),(5,'Gold','2020-12-17 03:00:02','2020-12-17 03:00:02');
/*!40000 ALTER TABLE `merit_bars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_100000_create_password_resets_table',1),(2,'2019_08_19_000000_create_failed_jobs_table',1),(3,'2020_10_03_213601_create_role_permissions_table',1),(4,'2020_10_13_162407_create_access__roles_table',1),(5,'2020_10_14_010636_create_roles_table',1),(6,'2020_10_16_223303_create_create_users_table',1),(7,'2020_10_17_061248_create_testimonials_table',1),(8,'2020_10_20_203412_create_positions_table',1),(9,'2020_10_23_201121_create_countries_table',1),(10,'2020_10_23_201404_create_jurisdictions_table',1),(11,'2020_10_23_201505_create_chapters_table',1),(12,'2020_10_23_572022_create_members_table',1),(13,'2020_10_24_000000_create_users_table',1),(14,'2020_10_24_200000_add_two_factor_columns_to_users_table',1),(15,'2020_10_25_010821_create_user_roles_table',1),(16,'2020_11_03_231638_create_contacts_table',1),(17,'2020_11_09_030551_create_activity_categories_table',1),(18,'2020_11_10_033956_create_member_activities_table',1),(19,'2020_11_12_081133_create_fee_descriptions_table',1),(20,'2020_11_13_230209_create_fees_table',1),(21,'2020_11_14_021051_create_payments_table',1),(22,'2020_11_26_004029_create_merit_bars_table',1),(23,'2020_11_26_005321_create_merit_bar_records_table',1),(24,'2020_12_01_225547_create_activity_logs_table',1),(25,'2020_12_05_013613_create_nomination_awards_table',1),(26,'2020_12_06_013201_create_nominations_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nomination_awards`
--

DROP TABLE IF EXISTS `nomination_awards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nomination_awards` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nomination_awards`
--

LOCK TABLES `nomination_awards` WRITE;
/*!40000 ALTER TABLE `nomination_awards` DISABLE KEYS */;
INSERT INTO `nomination_awards` VALUES (1,'Legon of Honour (Active)','2020-12-17 03:00:03','2020-12-17 03:00:03'),(2,'Honourary Legion of Honour','2020-12-17 03:00:03','2020-12-17 03:00:03'),(3,'Cross of Honour','2020-12-17 03:00:03','2020-12-17 03:00:03'),(4,'Chevalier','2020-12-17 03:00:04','2020-12-17 03:00:04');
/*!40000 ALTER TABLE `nomination_awards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nominations`
--

DROP TABLE IF EXISTS `nominations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nominations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date_awarded` date NOT NULL,
  `award_id` bigint unsigned NOT NULL,
  `member_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nominations_member_id_foreign` (`member_id`),
  KEY `nominations_award_id_foreign` (`award_id`),
  CONSTRAINT `nominations_award_id_foreign` FOREIGN KEY (`award_id`) REFERENCES `nomination_awards` (`id`),
  CONSTRAINT `nominations_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nominations`
--

LOCK TABLES `nominations` WRITE;
/*!40000 ALTER TABLE `nominations` DISABLE KEYS */;
/*!40000 ALTER TABLE `nominations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `fee_id` bigint unsigned NOT NULL,
  `amount_paid` double DEFAULT NULL,
  `amount_outstanding` double DEFAULT NULL,
  `member_id` bigint unsigned NOT NULL,
  `advisor_id` bigint unsigned NOT NULL,
  `special_case` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'None',
  `sponsor_id` bigint unsigned DEFAULT NULL,
  `sponsor_first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sponsor_last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_fee_id_foreign` (`fee_id`),
  KEY `payments_member_id_foreign` (`member_id`),
  KEY `payments_advisor_id_foreign` (`advisor_id`),
  KEY `payments_sponsor_id_foreign` (`sponsor_id`),
  CONSTRAINT `payments_advisor_id_foreign` FOREIGN KEY (`advisor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_fee_id_foreign` FOREIGN KEY (`fee_id`) REFERENCES `fees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_sponsor_id_foreign` FOREIGN KEY (`sponsor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `positions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `position_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `positions`
--

LOCK TABLES `positions` WRITE;
/*!40000 ALTER TABLE `positions` DISABLE KEYS */;
INSERT INTO `positions` VALUES (1,'Prospect','2020-12-17 03:00:04','2020-12-17 03:00:04'),(2,'Member','2020-12-17 03:00:04','2020-12-17 03:00:04'),(3,'Steward','2020-12-17 03:00:05','2020-12-17 03:00:05'),(4,'Deacon','2020-12-17 03:00:05','2020-12-17 03:00:05'),(5,'Preceptor','2020-12-17 03:00:05','2020-12-17 03:00:05'),(6,'Chaplain','2020-12-17 03:00:06','2020-12-17 03:00:06'),(7,'Scribe','2020-12-17 03:00:06','2020-12-17 03:00:06'),(8,'Treasurer','2020-12-17 03:00:06','2020-12-17 03:00:06'),(9,'Junior Councillor','2020-12-17 03:00:07','2020-12-17 03:00:07'),(10,'Senior Councillor','2020-12-17 03:00:07','2020-12-17 03:00:07'),(11,'Master Councillor','2020-12-17 03:00:07','2020-12-17 03:00:07'),(12,'Advisor','2020-12-17 03:00:08','2020-12-17 03:00:08'),(13,'Chapter Chairman','2020-12-17 03:00:08','2020-12-17 03:00:08'),(14,'Board Member','2020-12-17 03:00:08','2020-12-17 03:00:08'),(15,'Executive Secretary','2020-12-17 03:00:09','2020-12-17 03:00:09'),(16,'President','2020-12-17 03:00:09','2020-12-17 03:00:09');
/*!40000 ALTER TABLE `positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `member_read` tinyint(1) NOT NULL,
  `member_write` tinyint(1) NOT NULL,
  `jurisdiction_read` tinyint(1) NOT NULL,
  `jurisdiction_write` tinyint(1) NOT NULL,
  `country_read` tinyint(1) NOT NULL,
  `country_write` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_permissions`
--

LOCK TABLES `role_permissions` WRITE;
/*!40000 ALTER TABLE `role_permissions` DISABLE KEYS */;
INSERT INTO `role_permissions` VALUES (1,1,1,1,1,1,1,'2020-12-17 02:59:33','2020-12-17 02:59:33');
/*!40000 ALTER TABLE `role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_users`
--

DROP TABLE IF EXISTS `role_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_users` (
  `role_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `role_users_role_id_foreign` (`role_id`),
  KEY `role_users_user_id_foreign` (`user_id`),
  CONSTRAINT `role_users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `role_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_users`
--

LOCK TABLES `role_users` WRITE;
/*!40000 ALTER TABLE `role_users` DISABLE KEYS */;
INSERT INTO `role_users` VALUES (1,1,NULL,NULL);
/*!40000 ALTER TABLE `role_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_access` bigint unsigned NOT NULL,
  `role_permissions_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_role_access_foreign` (`role_access`),
  KEY `roles_role_permissions_id_foreign` (`role_permissions_id`),
  CONSTRAINT `roles_role_access_foreign` FOREIGN KEY (`role_access`) REFERENCES `access_roles` (`id`),
  CONSTRAINT `roles_role_permissions_id_foreign` FOREIGN KEY (`role_permissions_id`) REFERENCES `role_permissions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin',1,NULL,'2020-12-17 02:59:40','2020-12-17 02:59:40'),(2,'IT Admin',1,1,'2020-12-17 02:59:41','2020-12-17 02:59:41'),(3,'Secretary',2,NULL,'2020-12-17 02:59:41','2020-12-17 02:59:41'),(4,'Director At Large',2,NULL,'2020-12-17 02:59:42','2020-12-17 02:59:42'),(5,'Board Member',3,NULL,'2020-12-17 02:59:42','2020-12-17 02:59:42'),(6,'President',3,NULL,'2020-12-17 02:59:43','2020-12-17 02:59:43'),(7,'Executive Officer',4,NULL,'2020-12-17 02:59:43','2020-12-17 02:59:43'),(8,'Chapter Chairman',5,NULL,'2020-12-17 02:59:44','2020-12-17 02:59:44'),(9,'Chapter Advisor',5,NULL,'2020-12-17 02:59:44','2020-12-17 02:59:44');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `testimonials` (
  `testimonial_Id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_initial` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`testimonial_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonials`
--

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `jurisdiction_id` bigint unsigned DEFAULT NULL,
  `chapter_id` bigint unsigned DEFAULT NULL,
  `member_id` bigint unsigned DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_jurisdiction_id_foreign` (`jurisdiction_id`),
  KEY `users_member_id_foreign` (`member_id`),
  CONSTRAINT `users_jurisdiction_id_foreign` FOREIGN KEY (`jurisdiction_id`) REFERENCES `jurisdictions` (`id`),
  CONSTRAINT `users_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','DeMolay','admin@test.com',NULL,'$2y$10$IIL.gadL12Q.ozQd4P3.XOW6.nD.WfBasdRVeWsucXwcA4anSbAZS',NULL,NULL,0,NULL,NULL,NULL,'2020-12-17 02:59:45','2020-12-17 02:59:45');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-16 20:01:46
