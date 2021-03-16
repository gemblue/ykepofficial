-- MySQL dump 10.13  Distrib 8.0.23, for Linux (x86_64)
--
-- Host: localhost    Database: vissi
-- ------------------------------------------------------
-- Server version	8.0.23-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accesslog`
--

DROP TABLE IF EXISTS `accesslog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `accesslog` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `object_type` varchar(20) NOT NULL,
  `object_id` int NOT NULL,
  `page_url` varchar(255) DEFAULT NULL,
  `referer_url` varchar(255) DEFAULT NULL,
  `access_type` enum('f','p','m') NOT NULL DEFAULT 'm' COMMENT 'f:free, p:paid, m:membership',
  `date_access` date NOT NULL,
  `viewed` tinyint NOT NULL DEFAULT '1',
  `learned` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accesslog`
--

LOCK TABLES `accesslog` WRITE;
/*!40000 ALTER TABLE `accesslog` DISABLE KEYS */;
/*!40000 ALTER TABLE `accesslog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `affiliate`
--

DROP TABLE IF EXISTS `affiliate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `affiliate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `affiliate_code` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `affiliate`
--

LOCK TABLES `affiliate` WRITE;
/*!40000 ALTER TABLE `affiliate` DISABLE KEYS */;
INSERT INTO `affiliate` VALUES (1,1,'71398502620210226','2021-02-26 09:04:54',NULL);
/*!40000 ALTER TABLE `affiliate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `affiliate_commision`
--

DROP TABLE IF EXISTS `affiliate_commision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `affiliate_commision` (
  `id` int NOT NULL AUTO_INCREMENT,
  `affiliate_id` int NOT NULL,
  `affiliate_target_id` int DEFAULT NULL,
  `amount` int unsigned NOT NULL DEFAULT '0',
  `status` enum('pending','settle','refund') NOT NULL DEFAULT 'pending',
  `order_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `affiliate_commision`
--

LOCK TABLES `affiliate_commision` WRITE;
/*!40000 ALTER TABLE `affiliate_commision` DISABLE KEYS */;
INSERT INTO `affiliate_commision` VALUES (1,1,1,4500,'pending',13,'2021-02-26 09:15:34',NULL),(2,1,1,8700,'pending',14,'2021-02-26 10:15:32',NULL);
/*!40000 ALTER TABLE `affiliate_commision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `affiliate_target`
--

DROP TABLE IF EXISTS `affiliate_target`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `affiliate_target` (
  `id` int NOT NULL AUTO_INCREMENT,
  `affiliate_id` int NOT NULL,
  `target_user_code` varchar(40) NOT NULL,
  `target_user_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `affiliate_target`
--

LOCK TABLES `affiliate_target` WRITE;
/*!40000 ALTER TABLE `affiliate_target` DISABLE KEYS */;
INSERT INTO `affiliate_target` VALUES (1,1,'2d9965ae309e76cf7efb79caa46b286ca8588275',1,'2021-02-26 09:05:02',NULL);
/*!40000 ALTER TABLE `affiliate_target` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `author`
--

DROP TABLE IF EXISTS `author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `author` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `telegram` varchar(255) DEFAULT NULL,
  `revenue` double DEFAULT '0',
  `credit` double DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `author`
--

LOCK TABLES `author` WRITE;
/*!40000 ALTER TABLE `author` DISABLE KEYS */;
INSERT INTO `author` VALUES (1,1,NULL,NULL,NULL,0,0,'2021-02-16 07:36:46',NULL,NULL);
/*!40000 ALTER TABLE `author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bot_telegram_chats`
--

DROP TABLE IF EXISTS `bot_telegram_chats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bot_telegram_chats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tg_user_id` int unsigned DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'private',
  `botname` varchar(100) NOT NULL DEFAULT 'anonymous',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bot_telegram_chats`
--

LOCK TABLES `bot_telegram_chats` WRITE;
/*!40000 ALTER TABLE `bot_telegram_chats` DISABLE KEYS */;
/*!40000 ALTER TABLE `bot_telegram_chats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bot_telegram_messages`
--

DROP TABLE IF EXISTS `bot_telegram_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bot_telegram_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chat_id` int NOT NULL,
  `message_id` int unsigned NOT NULL,
  `date` int unsigned NOT NULL,
  `forward_from` text,
  `reply_to_message` text,
  `message_type` varchar(10) NOT NULL DEFAULT 'text',
  `message_content` text,
  `caption` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bot_telegram_messages`
--

LOCK TABLES `bot_telegram_messages` WRITE;
/*!40000 ALTER TABLE `bot_telegram_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `bot_telegram_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bot_telegram_users`
--

DROP TABLE IF EXISTS `bot_telegram_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bot_telegram_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `botname` varchar(100) NOT NULL DEFAULT 'anonymous',
  `first_name` varchar(100) NOT NULL DEFAULT 'anonymous',
  `last_name` varchar(100) NOT NULL DEFAULT 'anonymous',
  `username` varchar(100) NOT NULL DEFAULT 'anonymous',
  `photo_url` varchar(255) DEFAULT NULL,
  `auth_date` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bot_telegram_users`
--

LOCK TABLES `bot_telegram_users` WRITE;
/*!40000 ALTER TABLE `bot_telegram_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `bot_telegram_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certificate`
--

DROP TABLE IF EXISTS `certificate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `certificate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `template` varchar(255) DEFAULT NULL,
  `cert_title` varchar(255) NOT NULL,
  `cert_type` varchar(255) NOT NULL,
  `cert_thumbnail` varchar(255) DEFAULT NULL,
  `cert_rule` varchar(255) NOT NULL,
  `cert_desc` text,
  `object_id` int NOT NULL,
  `object_type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certificate`
--

LOCK TABLES `certificate` WRITE;
/*!40000 ALTER TABLE `certificate` DISABLE KEYS */;
/*!40000 ALTER TABLE `certificate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certificate_claimer`
--

DROP TABLE IF EXISTS `certificate_claimer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `certificate_claimer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cert_id` int NOT NULL,
  `user_id` int NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certificate_claimer`
--

LOCK TABLES `certificate_claimer` WRITE;
/*!40000 ALTER TABLE `certificate_claimer` DISABLE KEYS */;
/*!40000 ALTER TABLE `certificate_claimer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certificate_log`
--

DROP TABLE IF EXISTS `certificate_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `certificate_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cert_id` int NOT NULL,
  `user_id` int NOT NULL,
  `code` varchar(255) NOT NULL,
  `claimed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certificate_log`
--

LOCK TABLES `certificate_log` WRITE;
/*!40000 ALTER TABLE `certificate_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `certificate_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_author`
--

DROP TABLE IF EXISTS `course_author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_author` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `author_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`,`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_author`
--

LOCK TABLES `course_author` WRITE;
/*!40000 ALTER TABLE `course_author` DISABLE KEYS */;
INSERT INTO `course_author` VALUES (1,1,1);
/*!40000 ALTER TABLE `course_author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_completion`
--

DROP TABLE IF EXISTS `course_completion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_completion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `course_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_completion`
--

LOCK TABLES `course_completion` WRITE;
/*!40000 ALTER TABLE `course_completion` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_completion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_label_pivot`
--

DROP TABLE IF EXISTS `course_label_pivot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_label_pivot` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `label_id` int NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_label_pivot`
--

LOCK TABLES `course_label_pivot` WRITE;
/*!40000 ALTER TABLE `course_label_pivot` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_label_pivot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_lesson_log`
--

DROP TABLE IF EXISTS `course_lesson_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_lesson_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `course_id` int unsigned NOT NULL,
  `lesson_id` int unsigned NOT NULL,
  `durasi_akses` int NOT NULL DEFAULT '0',
  `waktu_paham` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_lesson_log`
--

LOCK TABLES `course_lesson_log` WRITE;
/*!40000 ALTER TABLE `course_lesson_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_lesson_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_lesson_progress`
--

DROP TABLE IF EXISTS `course_lesson_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_lesson_progress` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `lesson_id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_lesson_progress`
--

LOCK TABLES `course_lesson_progress` WRITE;
/*!40000 ALTER TABLE `course_lesson_progress` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_lesson_progress` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_lesson_theory`
--

DROP TABLE IF EXISTS `course_lesson_theory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_lesson_theory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lesson_id` int NOT NULL,
  `theory` longtext NOT NULL,
  `revision` tinyint NOT NULL DEFAULT '0',
  `status` enum('draft','publish') DEFAULT 'draft',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_lesson_theory`
--

LOCK TABLES `course_lesson_theory` WRITE;
/*!40000 ALTER TABLE `course_lesson_theory` DISABLE KEYS */;
INSERT INTO `course_lesson_theory` VALUES (1,1,'Konten Pengenalan',0,'publish'),(2,2,'Lebih dalam',0,'publish');
/*!40000 ALTER TABLE `course_lesson_theory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_lessons`
--

DROP TABLE IF EXISTS `course_lessons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_lessons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `topic_id` int DEFAULT NULL,
  `lesson_title` varchar(255) DEFAULT NULL,
  `lesson_slug` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT 'theory',
  `video` varchar(255) DEFAULT NULL,
  `vdo_id` varchar(100) DEFAULT NULL,
  `duration` varchar(5) DEFAULT NULL,
  `lesson_order` tinyint DEFAULT '0',
  `current_revision` tinyint DEFAULT '0',
  `lesson_uri` text NOT NULL,
  `free` tinyint(1) NOT NULL DEFAULT '0',
  `hash` varchar(255) NOT NULL,
  `checksum` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_lessons`
--

LOCK TABLES `course_lessons` WRITE;
/*!40000 ALTER TABLE `course_lessons` DISABLE KEYS */;
INSERT INTO `course_lessons` VALUES (1,1,1,'Pengenalan','pengenalan','theory','','','',1,0,'',0,'b620924d331b8b904d4605d9199df8b9',NULL,'2021-02-16 07:35:36',NULL,NULL),(2,1,1,'Lebih Dalam','lebih-dalam','theory','','','',2,0,'',0,'8033589aced0131b612a6ae42c3d76d0',NULL,'2021-02-16 07:35:50',NULL,NULL);
/*!40000 ALTER TABLE `course_lessons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_meta`
--

DROP TABLE IF EXISTS `course_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_meta` (
  `id` int NOT NULL AUTO_INCREMENT,
  `seo_description` varchar(255) DEFAULT NULL,
  `dependency` varchar(50) DEFAULT '[]',
  `enable_quiz` tinyint(1) NOT NULL DEFAULT '0',
  `enable_checklist` tinyint(1) NOT NULL DEFAULT '0',
  `enable_finish` tinyint(1) DEFAULT '1',
  `enable_forum` tinyint(1) NOT NULL DEFAULT '1',
  `enable_telegram` tinyint(1) NOT NULL DEFAULT '0',
  `preview_video` varchar(255) DEFAULT NULL,
  `preview_video_cover` varchar(255) DEFAULT NULL,
  `video_screenshots` text,
  `enable_dvd` tinyint(1) DEFAULT NULL,
  `dvd_screenshots` text,
  `sourcecode_url` text,
  `case_study_desc` text,
  `preview_url` text,
  `project_screenshot` text,
  `long_description` text,
  `author` varchar(100) DEFAULT NULL,
  `author_url` varchar(100) DEFAULT NULL,
  `author_contact` varchar(50) DEFAULT NULL,
  `author_whatsapp` text,
  `author_email` varchar(130) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_meta`
--

LOCK TABLES `course_meta` WRITE;
/*!40000 ALTER TABLE `course_meta` DISABLE KEYS */;
INSERT INTO `course_meta` VALUES (1,'','[]',0,0,1,1,0,'','','',0,'','','','','','','',NULL,'',NULL,'','2021-02-16 07:34:57',NULL,NULL);
/*!40000 ALTER TABLE `course_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_path`
--

DROP TABLE IF EXISTS `course_path`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_path` (
  `id` int NOT NULL AUTO_INCREMENT,
  `path_name` varchar(255) NOT NULL,
  `path_slug` varchar(255) NOT NULL,
  `landing_url` varchar(255) NOT NULL,
  `image_url` varchar(200) DEFAULT NULL,
  `description` text NOT NULL,
  `status` enum('draft','publish','deleted') NOT NULL DEFAULT 'publish',
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_path`
--

LOCK TABLES `course_path` WRITE;
/*!40000 ALTER TABLE `course_path` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_path` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_path_pivot`
--

DROP TABLE IF EXISTS `course_path_pivot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_path_pivot` (
  `id` int NOT NULL AUTO_INCREMENT,
  `object_id` int NOT NULL,
  `object_type` varchar(30) NOT NULL DEFAULT 'course',
  `path_id` int NOT NULL,
  `sort` int NOT NULL,
  `status` enum('draft','publish','deleted') NOT NULL DEFAULT 'publish',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_path_pivot`
--

LOCK TABLES `course_path_pivot` WRITE;
/*!40000 ALTER TABLE `course_path_pivot` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_path_pivot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_profit`
--

DROP TABLE IF EXISTS `course_profit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_profit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `sharing_type` enum('m','p') NOT NULL DEFAULT 'm' COMMENT 'm: membership, p: purchase',
  `profit` int NOT NULL DEFAULT '0',
  `qty` int DEFAULT '1',
  `date_share` date DEFAULT NULL COMMENT 'used for filter membership_daily_share too',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_profit`
--

LOCK TABLES `course_profit` WRITE;
/*!40000 ALTER TABLE `course_profit` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_profit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_students`
--

DROP TABLE IF EXISTS `course_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_students` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `course_id` int NOT NULL,
  `progress` tinyint DEFAULT '0',
  `graduate` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_students`
--

LOCK TABLES `course_students` WRITE;
/*!40000 ALTER TABLE `course_students` DISABLE KEYS */;
INSERT INTO `course_students` VALUES (1,1,1,0,0,'2021-02-16 07:35:53',NULL);
/*!40000 ALTER TABLE `course_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_topics`
--

DROP TABLE IF EXISTS `course_topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course_topics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `topic_title` varchar(255) NOT NULL,
  `topic_slug` varchar(255) NOT NULL,
  `topic_order` tinyint NOT NULL DEFAULT '0',
  `free` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_topics`
--

LOCK TABLES `course_topics` WRITE;
/*!40000 ALTER TABLE `course_topics` DISABLE KEYS */;
INSERT INTO `course_topics` VALUES (1,1,'Pendahuluan','Pendahuluan',1,0,'2021-02-16 07:35:17',NULL,NULL);
/*!40000 ALTER TABLE `course_topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `partner_id` int DEFAULT NULL,
  `revenue_sharing` int DEFAULT NULL,
  `label` varchar(255) DEFAULT 'Main',
  `course_title` varchar(255) NOT NULL DEFAULT 'anonymous',
  `slug` varchar(255) NOT NULL DEFAULT 'anonymous',
  `repo_name` text,
  `cover` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `description` text,
  `total_module` int DEFAULT NULL,
  `total_time` int DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL,
  `dependency` varchar(50) DEFAULT '[]',
  `premium` tinyint(1) DEFAULT '0',
  `status` enum('draft','publish','deleted','invisible') NOT NULL DEFAULT 'draft',
  `enable_quiz` tinyint(1) NOT NULL DEFAULT '0',
  `enable_checklist` tinyint(1) NOT NULL DEFAULT '0',
  `enable_forum` tinyint(1) NOT NULL DEFAULT '1',
  `last_update` datetime DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL,
  `scholarship` tinyint(1) NOT NULL DEFAULT '0',
  `scholarship_table` varchar(100) DEFAULT NULL,
  `scholarship_filter` varchar(255) DEFAULT NULL,
  `scholarship_only` tinyint(1) DEFAULT '0',
  `scholarship_url` varchar(255) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `author_url` varchar(100) DEFAULT NULL,
  `author_contact` varchar(50) DEFAULT NULL,
  `author_whatsapp` text,
  `author_email` varchar(130) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `collaborators` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,NULL,0,'Main','Sample Course','sample-course','','','','',0,0,NULL,'[]',0,'publish',0,0,1,'1970-01-01 00:00:00','beginner',0,'','',0,'',NULL,NULL,NULL,NULL,NULL,'2021-02-16 07:34:57',NULL,NULL,'');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `downloadable`
--

DROP TABLE IF EXISTS `downloadable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `downloadable` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `require_login` varchar(255) NOT NULL DEFAULT '1',
  `membership` varchar(255) NOT NULL DEFAULT '0',
  `file` varchar(255) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `downloadable`
--

LOCK TABLES `downloadable` WRITE;
/*!40000 ALTER TABLE `downloadable` DISABLE KEYS */;
INSERT INTO `downloadable` VALUES (1,'coba','coba','1','0','https://vissi.test/uploads/original/1/vissi.png','https://vissi.test/uploads/original/1/iconfinder_ecommerce-08_4707164.png','2021-03-01 08:35:04',NULL,NULL);
/*!40000 ALTER TABLE `downloadable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forum_comment`
--

DROP TABLE IF EXISTS `forum_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forum_comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `object_id` int NOT NULL,
  `object_type` enum('thread','reply') NOT NULL DEFAULT 'thread',
  `user_id` int NOT NULL,
  `comment_content` text NOT NULL,
  `comment_status` enum('draft','publish','deleted') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum_comment`
--

LOCK TABLES `forum_comment` WRITE;
/*!40000 ALTER TABLE `forum_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forum_flag`
--

DROP TABLE IF EXISTS `forum_flag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forum_flag` (
  `id` int NOT NULL AUTO_INCREMENT,
  `issue` varchar(30) DEFAULT NULL,
  `note` tinytext NOT NULL,
  `object_id` int NOT NULL,
  `object_type` varchar(255) NOT NULL,
  `reporter` int NOT NULL,
  `meta` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum_flag`
--

LOCK TABLES `forum_flag` WRITE;
/*!40000 ALTER TABLE `forum_flag` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_flag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forum_reply`
--

DROP TABLE IF EXISTS `forum_reply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forum_reply` (
  `id` int NOT NULL AUTO_INCREMENT,
  `thread_id` int NOT NULL,
  `user_id` int NOT NULL,
  `reply_content` text NOT NULL,
  `reply_status` enum('draft','publish','deleted') NOT NULL DEFAULT 'draft',
  `reply_mode` varchar(20) DEFAULT 'md',
  `reply_mark` enum('choosen') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum_reply`
--

LOCK TABLES `forum_reply` WRITE;
/*!40000 ALTER TABLE `forum_reply` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_reply` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forum_thread`
--

DROP TABLE IF EXISTS `forum_thread`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forum_thread` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `course_id` bigint DEFAULT NULL,
  `lesson_id` bigint DEFAULT NULL,
  `thread_identity` varchar(255) DEFAULT NULL,
  `thread_subject` varchar(255) NOT NULL,
  `thread_slug` varchar(255) NOT NULL,
  `thread_content` text,
  `thread_flag` varchar(20) DEFAULT NULL,
  `total_answer` int DEFAULT '0',
  `has_admin_answer` tinyint DEFAULT '0',
  `has_approved_answer` tinyint(1) DEFAULT '0',
  `thread_status` enum('draft','publish','deleted') NOT NULL DEFAULT 'draft',
  `thread_mode` varchar(20) DEFAULT 'md',
  `thread_mark` enum('closed','solved','opened') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forum_thread`
--

LOCK TABLES `forum_thread` WRITE;
/*!40000 ALTER TABLE `forum_thread` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_thread` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `priority` tinyint(1) NOT NULL DEFAULT '9',
  `type` varchar(45) NOT NULL,
  `payload` text COMMENT 'JSON payload',
  `response` text,
  `status` enum('queued','running','done') NOT NULL DEFAULT 'queued',
  `attempt` tinyint(1) DEFAULT '0',
  `run_time` double DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expired_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lesson_log`
--

DROP TABLE IF EXISTS `lesson_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lesson_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `course_id` int unsigned NOT NULL,
  `lesson_id` int unsigned NOT NULL,
  `durasi_akses` int NOT NULL DEFAULT '0',
  `waktu_paham` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`),
  KEY `lesson_id` (`lesson_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lesson_log`
--

LOCK TABLES `lesson_log` WRITE;
/*!40000 ALTER TABLE `lesson_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `lesson_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lesson_log_tag`
--

DROP TABLE IF EXISTS `lesson_log_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lesson_log_tag` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tag` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lesson_log_tag`
--

LOCK TABLES `lesson_log_tag` WRITE;
/*!40000 ALTER TABLE `lesson_log_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `lesson_log_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lesson_log_tag_pivot`
--

DROP TABLE IF EXISTS `lesson_log_tag_pivot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lesson_log_tag_pivot` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `tag_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lesson_log_tag_pivot`
--

LOCK TABLES `lesson_log_tag_pivot` WRITE;
/*!40000 ALTER TABLE `lesson_log_tag_pivot` DISABLE KEYS */;
/*!40000 ALTER TABLE `lesson_log_tag_pivot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mahasiswa`
--

DROP TABLE IF EXISTS `mahasiswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mahasiswa` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `nim` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mahasiswa`
--

LOCK TABLES `mahasiswa` WRITE;
/*!40000 ALTER TABLE `mahasiswa` DISABLE KEYS */;
INSERT INTO `mahasiswa` VALUES (1,'Igo','110924','2021-03-01 09:14:17','2021-03-01 09:16:04',NULL,'m');
/*!40000 ALTER TABLE `mahasiswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_labels`
--

DROP TABLE IF EXISTS `mein_labels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mein_labels` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `term` varchar(255) NOT NULL,
  `term_slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_labels`
--

LOCK TABLES `mein_labels` WRITE;
/*!40000 ALTER TABLE `mein_labels` DISABLE KEYS */;
/*!40000 ALTER TABLE `mein_labels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_navigation_areas`
--

DROP TABLE IF EXISTS `mein_navigation_areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mein_navigation_areas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `area_name` varchar(100) NOT NULL,
  `area_slug` varchar(100) NOT NULL,
  `status` enum('draft','publish') NOT NULL DEFAULT 'publish',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_navigation_areas`
--

LOCK TABLES `mein_navigation_areas` WRITE;
/*!40000 ALTER TABLE `mein_navigation_areas` DISABLE KEYS */;
/*!40000 ALTER TABLE `mein_navigation_areas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_navigations`
--

DROP TABLE IF EXISTS `mein_navigations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mein_navigations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `area_id` int NOT NULL,
  `caption` varchar(100) NOT NULL,
  `url` text,
  `url_type` enum('uri','external') NOT NULL DEFAULT 'uri',
  `target` enum('_blank','_self','_top','_parent') DEFAULT '_self',
  `status` enum('draft','publish') NOT NULL DEFAULT 'publish',
  `parent` int DEFAULT NULL,
  `nav_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_navigations`
--

LOCK TABLES `mein_navigations` WRITE;
/*!40000 ALTER TABLE `mein_navigations` DISABLE KEYS */;
/*!40000 ALTER TABLE `mein_navigations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_options`
--

DROP TABLE IF EXISTS `mein_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mein_options` (
  `id` int NOT NULL AUTO_INCREMENT,
  `option_group` varchar(30) DEFAULT 'site',
  `option_name` varchar(30) DEFAULT NULL,
  `option_value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1575 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_options`
--

LOCK TABLES `mein_options` WRITE;
/*!40000 ALTER TABLE `mein_options` DISABLE KEYS */;
INSERT INTO `mein_options` VALUES (1525,'site','site_title','VISSI Platform'),(1526,'site','site_desc',''),(1527,'site','site_logo','https://vissi.test/uploads/original/1/vissi1.png'),(1528,'site','site_logo_small','https://vissi.test/uploads/original/1/vissi1.png'),(1529,'site','phone','087813277822'),(1530,'site','address',''),(1531,'emailer','use_mailcatcher','yes'),(1532,'emailer','smtp_host','in-v3.mailjet.com'),(1533,'emailer','smtp_port','587'),(1534,'emailer','smtp_username','8443024b25c98692c6e2647372c7be5f'),(1535,'emailer','smtp_password','16ff075e5918803087bd3eb1d1f21b02'),(1536,'emailer','email_from','contact@viralbisnis.id'),(1537,'emailer','sender_name','ViralBisnis Indonesia'),(1538,'theme','navbar_color','3A4651'),(1539,'theme','navbar_text_color','F0F3F6'),(1540,'theme','link_color','007BFF'),(1541,'theme','btn_primary','007BFF'),(1542,'theme','btn_secondary','6C757D'),(1543,'theme','btn_success','28A745'),(1544,'theme','btn_info','138496'),(1545,'theme','btn_warning','E0A800'),(1546,'theme','btn_danger','DC3545'),(1547,'theme','facebook_pixel_code',''),(1548,'theme','gtag_id',''),(1549,'membership','enable','on'),(1550,'membership','author_percentage_membership','60'),(1551,'user','confirmation_type','link'),(1552,'user','use_single_login','yes'),(1553,'post','posttype_config','page:\r\n    label: Pages\r\n    entry: mein_post_page\r\nevent:\r\n    label: Events\r\n    entry: mein_post_event\r\n'),(1554,'payment','before_order_expired','30'),(1555,'payment','order_expired','120'),(1556,'payment','transfer_fee_operator','neg'),(1557,'payment','transfer_destinations','BCA|6765406777|PT. VIRAL BISNIS INDONESIA'),(1558,'payment','last_unique_number','160'),(1559,'payment','active_payment_gateway','xendit'),(1560,'payment','midtrans_secret_key',''),(1561,'payment','xendit_secret_key',''),(1562,'payment','xendit_callback_token',''),(1563,'wallet','minimum_withdrawal','50000'),(1564,'course','enable','on'),(1565,'affiliate','enable','on'),(1566,'affiliate','commision_percentage','15'),(1567,'affiliate','enable_affiliate_membership','no'),(1568,'product','enable','on'),(1569,'product','remind_expired','3'),(1570,'lessonlog','record_all_user_log','0'),(1571,'dashboard','maintenance_mode','off'),(1572,'downloadable','enable','off'),(1573,'sample','enable','off'),(1574,'sample','title','');
/*!40000 ALTER TABLE `mein_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_posts`
--

DROP TABLE IF EXISTS `mein_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mein_posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author` bigint unsigned NOT NULL DEFAULT '0',
  `content` longtext NOT NULL,
  `content_type` varchar(20) NOT NULL DEFAULT 'markdown',
  `intro` text,
  `featured` datetime DEFAULT NULL,
  `title` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'publish',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `total_seen` int NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'post',
  `template` varchar(30) NOT NULL,
  `featured_image` varchar(200) NOT NULL,
  `embed_video` varchar(255) DEFAULT NULL,
  `published_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `featured` (`featured`,`status`,`type`),
  KEY `author` (`author`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_posts`
--

LOCK TABLES `mein_posts` WRITE;
/*!40000 ALTER TABLE `mein_posts` DISABLE KEYS */;
INSERT INTO `mein_posts` VALUES (3,1,'**yaps Oke**\r\n\r\n*Ready*','markdown',NULL,NULL,'Info Terbaru','publish','info-terbaru',16,'post','default','https://vissi.test/uploads/original/1/miss.png','','2021-02-01 12:42:20','2021-02-01 12:42:16',NULL);
/*!40000 ALTER TABLE `mein_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_role_privileges`
--

DROP TABLE IF EXISTS `mein_role_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mein_role_privileges` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_id` int DEFAULT NULL,
  `module` varchar(50) DEFAULT NULL,
  `privilege` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_role_privileges`
--

LOCK TABLES `mein_role_privileges` WRITE;
/*!40000 ALTER TABLE `mein_role_privileges` DISABLE KEYS */;
INSERT INTO `mein_role_privileges` VALUES (32,4,'post','post',NULL),(33,4,'post','post/index/all/event',NULL),(34,4,'post','post/index/all/webinar',NULL),(35,4,'post','post/index/trash',NULL),(36,4,'post','post/add_type',NULL),(37,4,'post','post/add',NULL),(38,4,'post','post/insert',NULL),(39,4,'post','post/edit',NULL),(40,4,'post','post/update',NULL),(41,4,'post','post/search',NULL),(42,4,'post','post/preview',NULL),(43,4,'post','post/post/draft',NULL),(44,4,'post','post/publish',NULL),(45,4,'post','post/trash',NULL),(46,4,'post','post/restore',NULL),(47,4,'post','post/delete',NULL),(48,4,'post','post/category',NULL),(49,4,'post','post/category/add',NULL),(50,4,'post','post/category/insert',NULL),(51,4,'post','post/category/edit',NULL),(52,4,'post','post/category/update',NULL),(53,4,'post','post/category/search',NULL),(54,4,'post','post/category/delete',NULL),(55,4,'post','post/tags',NULL),(56,4,'post','post/tags/add',NULL),(57,4,'post','post/tags/insert',NULL),(58,4,'post','post/tags/edit',NULL),(59,4,'post','post/tags/update',NULL),(60,4,'post','post/tags/search',NULL),(61,4,'post','post/tags/delete',NULL),(62,4,'post','settings',NULL),(63,4,'dashboard','dashboard',NULL),(64,4,'dashboard','settings',NULL);
/*!40000 ALTER TABLE `mein_role_privileges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_roles`
--

DROP TABLE IF EXISTS `mein_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mein_roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(200) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_roles`
--

LOCK TABLES `mein_roles` WRITE;
/*!40000 ALTER TABLE `mein_roles` DISABLE KEYS */;
INSERT INTO `mein_roles` VALUES (1,'Super','active','2013-05-13 10:32:53',NULL),(2,'Writer','active','2013-05-13 10:32:53',NULL),(3,'Member','active','2013-05-13 10:32:53',NULL),(4,'Admin','active','2020-12-28 11:56:37',NULL);
/*!40000 ALTER TABLE `mein_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_term_relationships`
--

DROP TABLE IF EXISTS `mein_term_relationships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mein_term_relationships` (
  `id` int NOT NULL AUTO_INCREMENT,
  `object_id` bigint unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint unsigned NOT NULL DEFAULT '0',
  `term_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_term_relationships`
--

LOCK TABLES `mein_term_relationships` WRITE;
/*!40000 ALTER TABLE `mein_term_relationships` DISABLE KEYS */;
INSERT INTO `mein_term_relationships` VALUES (7,3,1,0);
/*!40000 ALTER TABLE `mein_term_relationships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_term_taxonomy`
--

DROP TABLE IF EXISTS `mein_term_taxonomy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mein_term_taxonomy` (
  `term_taxonomy_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint unsigned NOT NULL DEFAULT '0',
  `count` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  KEY `term_id` (`term_id`,`taxonomy`,`parent`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_term_taxonomy`
--

LOCK TABLES `mein_term_taxonomy` WRITE;
/*!40000 ALTER TABLE `mein_term_taxonomy` DISABLE KEYS */;
INSERT INTO `mein_term_taxonomy` VALUES (1,1,'post_category','',0,0),(2,2,'event_category','',0,0),(3,3,'post_category','',0,0);
/*!40000 ALTER TABLE `mein_term_taxonomy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_terms`
--

DROP TABLE IF EXISTS `mein_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mein_terms` (
  `term_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`term_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_terms`
--

LOCK TABLES `mein_terms` WRITE;
/*!40000 ALTER TABLE `mein_terms` DISABLE KEYS */;
INSERT INTO `mein_terms` VALUES (1,'Member Updates Yeah','member-updates'),(2,'Event Baru','event-baru'),(3,'Coba','coba');
/*!40000 ALTER TABLE `mein_terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_user_profile`
--

DROP TABLE IF EXISTS `mein_user_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mein_user_profile` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `address` text,
  `birthday` date DEFAULT NULL,
  `interest` text,
  `experience` tinyint DEFAULT NULL,
  `jobs` varchar(255) DEFAULT NULL,
  `profession` varchar(20) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `portfolio_link` text,
  `description` text,
  `newsletter` tinyint(1) DEFAULT '1',
  `ready_to_work` tinyint(1) DEFAULT '0',
  `latest_ip` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `gender` varchar(255) DEFAULT 'l',
  `status_marital` varchar(255) DEFAULT 'single',
  `record_log` varchar(255) DEFAULT '0',
  `akun_ig` varchar(255) DEFAULT NULL,
  `akun_tiktok` varchar(255) DEFAULT NULL,
  `hobi` varchar(255) DEFAULT NULL,
  `nomor_rekening` varchar(255) DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `pemilik_rekening` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_user_profile`
--

LOCK TABLES `mein_user_profile` WRITE;
/*!40000 ALTER TABLE `mein_user_profile` DISABLE KEYS */;
INSERT INTO `mein_user_profile` VALUES (1,1,'08986818789','Jl. Cijeungjing Padalarang Bandung Barat','1970-01-01',NULL,NULL,'',NULL,'',NULL,NULL,1,0,NULL,'2021-01-30 01:48:14','2021-02-26 17:14:17','l','single','0','','','','Toni Haryanto','BTPN','90011320766',NULL),(2,2,'08981234567','Jl. Cijeungjing Padalarang Bandung Barat','1970-01-01',NULL,NULL,'',NULL,'',NULL,NULL,1,0,NULL,'2021-01-30 01:48:14','2021-02-05 01:19:27','l','single','0','','','','','','',NULL),(3,3,'(+62) 740 5800 857','Jln. Kyai Gede No. 875, Palopo 20532, Jambi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,'2021-01-30 01:48:14',NULL,'l','single','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,4,'0549 1365 7804','Jr. Dewi Sartika No. 494, Sibolga 84119, JaBar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,'2021-01-30 01:48:14',NULL,'l','single','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,5,'(+62) 809 2097 431','Psr. Suniaraja No. 224, Blitar 42532, SumUt',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,'2021-01-30 01:48:14',NULL,'l','single','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,6,'(+62) 231 6792 999','Gg. Suryo Pranoto No. 530, Sungai Penuh 73031, SulBar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,'2021-01-30 01:48:14',NULL,'l','single','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,7,'(+62) 519 5617 8957','Kpg. Jambu No. 110, Tarakan 54682, KalBar',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,'2021-01-30 01:48:14',NULL,'l','single','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,8,'(+62) 946 1991 230','Ki. Bambon No. 808, Administrasi Jakarta Selatan 32371, BaBel',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,'2021-01-30 01:48:14',NULL,'l','single','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,9,'(+62) 598 4398 906','Ds. Wahid No. 599, Bitung 85597, Gorontalo',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,'2021-01-30 01:48:14',NULL,'l','single','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,10,'(+62) 765 4743 6504','Dk. Nangka No. 906, Denpasar 60124, Bengkulu',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,'2021-01-30 01:48:14',NULL,'l','single','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,11,'08986818780','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,'2021-02-26 08:30:35',NULL,'l','single','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(12,12,'08986818780','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL,'2021-02-26 08:32:57',NULL,'l','single','0',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `mein_user_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_users`
--

DROP TABLE IF EXISTS `mein_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mein_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) DEFAULT NULL,
  `source_id` varchar(64) DEFAULT NULL,
  `name` varchar(40) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `referral_code` varchar(10) DEFAULT NULL,
  `referrer_id` int DEFAULT NULL,
  `password` tinytext,
  `status` varchar(20) DEFAULT 'inactive',
  `role_id` int DEFAULT '3',
  `token` varchar(150) DEFAULT NULL,
  `cdn_token` text,
  `mail_unsubscribe` tinyint(1) DEFAULT NULL,
  `mail_invalid` tinyint(1) DEFAULT NULL,
  `mail_bounce` tinyint(1) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `source_id` (`source_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_users`
--

LOCK TABLES `mein_users` WRITE;
/*!40000 ALTER TABLE `mein_users` DISABLE KEYS */;
INSERT INTO `mein_users` VALUES (1,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dnZWRfaW4iOnRydWUsInVzZXJfaWQiOiIxIiwiZW1haWwiOiJhZG1pbkBhZG1pbi5jb20iLCJ1c2VybmFtZSI6Im1pbWluIiwiZnVsbG5hbWUiOiJUb0hhIiwicm9sZV9uYW1lIjoiU3VwZXIiLCJyb2xlX2lkIjoiMSIsInRpbWVzdGFtcCI6MTYxNDY3MjQ3MX0.7JttFjNutiehBn',NULL,'ToHa','admin@admin.com','mimin',NULL,'WhatsApp_Image_2021-01-30_at_17_36_59.jpeg',NULL,NULL,NULL,'$P$Bu4rgoaKMHXNe1iEq32UCT6rdfnIV7/','active',1,NULL,NULL,NULL,NULL,NULL,'2021-03-02 15:07:50','2021-01-30 01:48:14',NULL),(2,'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dnZWRfaW4iOnRydWUsInVzZXJfaWQiOiIyIiwiZW1haWwiOiJ0ZXN0QHRlc3QuY29tIiwidXNlcm5hbWUiOiJ0ZXN0IiwiZnVsbG5hbWUiOiJUZXN0IFVzZXIiLCJyb2xlX25hbWUiOiJBZG1pbiIsInJvbGVfaWQiOiI0IiwidGltZXN0YW1wIjoxNjEzNDU3OTc4fQ.zF2F1uD6zdp',NULL,'Test User','test@test.com','test','','','',NULL,NULL,'$P$B9KqAT2O7863sE8uslMFJFqISTOG.R1','active',4,NULL,NULL,NULL,NULL,NULL,'2021-02-05 01:21:16','2021-01-30 01:48:14',NULL),(3,NULL,NULL,'Cengkir Irawan','gada77@usada.name','gaduh12',NULL,NULL,NULL,NULL,NULL,'$P$B9LnVCtrSt4G65r06.LmxM1WVWYHlk.','active',2,NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-30 01:48:14',NULL),(4,NULL,NULL,'Hardi Prayoga Damanik M.Ak','uyainah.bakti@gmail.co.id','mandasari.jati',NULL,NULL,NULL,NULL,NULL,'$P$BGaw/AvPCG6D9cdvOZgz3VfGPaqQOi0','active',2,NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-30 01:48:14',NULL),(5,NULL,NULL,'Rahayu Wastuti','iswahyudi.teddy@sudiati.org','hutasoit.tami',NULL,NULL,NULL,NULL,NULL,'$P$BLWbdD.IgVIo1QVgsbQKAi5r0HGgQo/','active',2,NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-30 01:48:14',NULL),(6,NULL,NULL,'Victoria Yuliarti','kenes28@yahoo.com','vprastuti',NULL,NULL,NULL,NULL,NULL,'$P$B2qlq5rCxcN2zwnzajBlakAWQHGFdv.','active',2,NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-30 01:48:14',NULL),(7,NULL,NULL,'Yunita Suartini','adinata.agustina@santoso.asia','cahyono.safitri',NULL,NULL,NULL,NULL,NULL,'$P$BhcWc3FP26UroEXDaVBjnvoT.9C7bu/','active',2,NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-30 01:48:14',NULL),(8,NULL,NULL,'Julia Samiah Padmasari','lpranowo@yahoo.com','kasusra.lazuardi',NULL,NULL,NULL,NULL,NULL,'$P$B5owFlNkRIn4UsDxLeIuMcs9A/NINm1','active',2,NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-30 01:48:14',NULL),(9,NULL,NULL,'Tri Sirait','wadi73@puspasari.id','padriansyah',NULL,NULL,NULL,NULL,NULL,'$P$BAhU17/6jA1RfisFQW4TzZfemvVKi00','active',2,NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-30 01:48:14',NULL),(10,NULL,NULL,'Siti Mulyani S.IP','qusada@santoso.name','saefullah.karen',NULL,NULL,NULL,NULL,NULL,'$P$BvvHwMbg7GL0cBgTCHpWSVPHvUq7ii1','inactive',2,NULL,NULL,NULL,NULL,NULL,NULL,'2021-01-30 01:48:14',NULL),(11,NULL,NULL,'Siti Mulyani','qusada@santoso.name','qusadasantosoname',NULL,NULL,NULL,NULL,NULL,'$P$BSrbbtAQaPV.12IIi.ZZd.gw2yRL69/','active',3,'eyJ0b2tlbiI6IklucG1lNCIsImVtYWlsIjoicXVzYWRhQHNhbnRvc28ubmFtZSJ9',NULL,NULL,NULL,NULL,NULL,'2021-02-26 08:30:34',NULL),(12,NULL,NULL,'Sri Mulyani','qusada@santoso.name','qusadasantosonameaA2vj',NULL,NULL,NULL,NULL,NULL,'$P$BxL2TXZmseeQTzKGscXC648ZHuA94p.','inactive',3,'eyJ0b2tlbiI6InpPdzkzayIsImVtYWlsIjoicXVzYWRhQHNhbnRvc28ubmFtZSJ9',NULL,NULL,NULL,NULL,NULL,'2021-02-26 08:32:57',NULL),(13,NULL,NULL,'Toni Haryanto','jastip@gmail.com','jastipzX6',NULL,NULL,NULL,NULL,NULL,'$P$Bc2SMBST29SYSpg.f3OpGbqMklQiAX1','inactive',3,'eyJ0b2tlbiI6InVDOFExNCIsImVtYWlsIjoiamFzdGlwQGdtYWlsLmNvbSJ9',NULL,NULL,NULL,NULL,NULL,'2021-02-26 17:53:58',NULL);
/*!40000 ALTER TABLE `mein_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mein_variables`
--

DROP TABLE IF EXISTS `mein_variables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mein_variables` (
  `id` int NOT NULL AUTO_INCREMENT,
  `variable` varchar(100) NOT NULL DEFAULT 'anonymous',
  `value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mein_variables`
--

LOCK TABLES `mein_variables` WRITE;
/*!40000 ALTER TABLE `mein_variables` DISABLE KEYS */;
INSERT INTO `mein_variables` VALUES (1,'harga_membership','99000','2021-02-26 04:51:32',NULL,NULL);
/*!40000 ALTER TABLE `mein_variables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membership_daily_share`
--

DROP TABLE IF EXISTS `membership_daily_share`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membership_daily_share` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_access` date NOT NULL,
  `total_credits` int NOT NULL,
  `total_access` int NOT NULL,
  `fee_per_access` int NOT NULL,
  `content_type` varchar(20) NOT NULL DEFAULT 'course',
  `sharing_percentage` tinyint NOT NULL DEFAULT '60',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membership_daily_share`
--

LOCK TABLES `membership_daily_share` WRITE;
/*!40000 ALTER TABLE `membership_daily_share` DISABLE KEYS */;
/*!40000 ALTER TABLE `membership_daily_share` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `module` varchar(20) NOT NULL,
  `version` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('CI_core',1),('setting',1),('membership',4),('user',1),('certificate',1),('post',1),('navigation',1),('payment',2),('wallet',2),('bot',1),('variable',1),('course',1),('forum',1),('author',1),('affiliate',1),('product',1),('lessonlog',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_coupon`
--

DROP TABLE IF EXISTS `payment_coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_coupon` (
  `id` int NOT NULL AUTO_INCREMENT,
  `coupon_type` varchar(10) DEFAULT NULL,
  `product_id` int NOT NULL,
  `code` varchar(100) NOT NULL,
  `quota` int NOT NULL DEFAULT '1',
  `used_by` int NOT NULL,
  `type` varchar(20) NOT NULL,
  `nominal` int NOT NULL,
  `generated_by` int NOT NULL,
  `expired_at` datetime NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_coupon`
--

LOCK TABLES `payment_coupon` WRITE;
/*!40000 ALTER TABLE `payment_coupon` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_coupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_coupon_log`
--

DROP TABLE IF EXISTS `payment_coupon_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_coupon_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `coupon_id` int NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `status` enum('USED','CANCEL','LIMIT','PREPARED') DEFAULT 'USED',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_coupon_log`
--

LOCK TABLES `payment_coupon_log` WRITE;
/*!40000 ALTER TABLE `payment_coupon_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_coupon_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_followup`
--

DROP TABLE IF EXISTS `payment_followup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_followup` (
  `id` int NOT NULL AUTO_INCREMENT,
  `number` int DEFAULT NULL,
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_followup`
--

LOCK TABLES `payment_followup` WRITE;
/*!40000 ALTER TABLE `payment_followup` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_followup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_followup_template`
--

DROP TABLE IF EXISTS `payment_followup_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_followup_template` (
  `id` int NOT NULL AUTO_INCREMENT,
  `number` int NOT NULL,
  `template` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_followup_template`
--

LOCK TABLES `payment_followup_template` WRITE;
/*!40000 ALTER TABLE `payment_followup_template` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_followup_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_gateway_logs`
--

DROP TABLE IF EXISTS `payment_gateway_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_gateway_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_code` varchar(20) DEFAULT NULL,
  `provider` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'xendit',
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'invoice',
  `data` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_gateway_logs`
--

LOCK TABLES `payment_gateway_logs` WRITE;
/*!40000 ALTER TABLE `payment_gateway_logs` DISABLE KEYS */;
INSERT INTO `payment_gateway_logs` VALUES (1,'1AA02260858','xendit','invoice','{\"id\":\"603855b25efb4640175d529a\",\"external_id\":\"1AA02260858\",\"user_id\":\"6023307e86deed145d1d1564\",\"status\":\"PENDING\",\"merchant_name\":\"Momila\",\"merchant_profile_picture_url\":\"https:\\/\\/xnd-companies.s3.amazonaws.com\\/prod\\/1612919871568_631.png\",\"amount\":50000,\"payer_email\":\"admin@admin.com\",\"description\":\"Pembayaran VISSI Platform\",\"expiry_date\":\"2021-02-27T01:58:10.498Z\",\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/603855b25efb4640175d529a\",\"available_banks\":[{\"bank_code\":\"MANDIRI\",\"collection_type\":\"POOL\",\"bank_account_number\":\"8860810937861\",\"transfer_amount\":50000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"BRI\",\"collection_type\":\"POOL\",\"bank_account_number\":\"2621560152356\",\"transfer_amount\":50000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"BNI\",\"collection_type\":\"POOL\",\"bank_account_number\":\"880819907454\",\"transfer_amount\":50000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"PERMATA\",\"collection_type\":\"POOL\",\"bank_account_number\":\"821456528689\",\"transfer_amount\":50000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"BCA\",\"collection_type\":\"POOL\",\"bank_account_number\":\"1076693602169\",\"transfer_amount\":50000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0}],\"available_retail_outlets\":[{\"retail_outlet_name\":\"ALFAMART\",\"payment_code\":\"TEST154603\",\"transfer_amount\":50000},{\"retail_outlet_name\":\"INDOMARET\",\"payment_code\":\"TEST83862\",\"transfer_amount\":50000}],\"available_ewallets\":[{\"ewallet_type\":\"OVO\"},{\"ewallet_type\":\"DANA\"},{\"ewallet_type\":\"SHOPEEPAY\"},{\"ewallet_type\":\"LINKAJA\"}],\"should_exclude_credit_card\":true,\"should_send_email\":false,\"created\":\"2021-02-26T01:58:10.665Z\",\"updated\":\"2021-02-26T01:58:10.665Z\",\"currency\":\"IDR\"}','2021-02-26 01:58:10',NULL,NULL),(2,'invoice_123124123','xendit','callback','{\n    \"id\": \"579c8d61f23fa4ca35e52da4\",\n    \"external_id\": \"invoice_123124123\",\n    \"user_id\": \"5781d19b2e2385880609791c\",\n    \"is_high\": true,\n    \"payment_method\": \"BANK_TRANSFER\",\n    \"status\": \"PAID\",\n    \"merchant_name\": \"Xendit\",\n    \"amount\": 50000,\n    \"paid_amount\": 50000,\n    \"bank_code\": \"PERMATA\",\n    \"paid_at\": \"2016-10-12T08:15:03.404Z\",\n    \"payer_email\": \"wildan@xendit.co\",\n    \"description\": \"This is a description\",\n    \"adjusted_received_amount\": 47500,\n    \"fees_paid_amount\": 0,\n    \"updated\": \"2016-10-10T08:15:03.404Z\",\n    \"created\": \"2016-10-10T08:15:03.404Z\",\n    \"currency\": \"IDR\",\n    \"payment_channel\": \"PERMATA\",\n    \"payment_destination\": \"888888888888\"\n}','2021-02-26 04:34:26',NULL,NULL),(3,'invoice_123124123','xendit','callback','{\n    \"id\": \"579c8d61f23fa4ca35e52da4\",\n    \"external_id\": \"invoice_123124123\",\n    \"user_id\": \"5781d19b2e2385880609791c\",\n    \"is_high\": true,\n    \"payment_method\": \"BANK_TRANSFER\",\n    \"status\": \"PAID\",\n    \"merchant_name\": \"Xendit\",\n    \"amount\": 50000,\n    \"paid_amount\": 50000,\n    \"bank_code\": \"PERMATA\",\n    \"paid_at\": \"2016-10-12T08:15:03.404Z\",\n    \"payer_email\": \"wildan@xendit.co\",\n    \"description\": \"This is a description\",\n    \"adjusted_received_amount\": 47500,\n    \"fees_paid_amount\": 0,\n    \"updated\": \"2016-10-10T08:15:03.404Z\",\n    \"created\": \"2016-10-10T08:15:03.404Z\",\n    \"currency\": \"IDR\",\n    \"payment_channel\": \"PERMATA\",\n    \"payment_destination\": \"888888888888\"\n}','2021-02-26 04:35:02',NULL,NULL),(4,'1AA02260858','xendit','callback','{\n    \"id\": \"579c8d61f23fa4ca35e52da4\",\n    \"external_id\": \"1AA02260858\",\n    \"user_id\": \"5781d19b2e2385880609791c\",\n    \"is_high\": true,\n    \"payment_method\": \"BANK_TRANSFER\",\n    \"status\": \"EXPIRED\",\n    \"merchant_name\": \"Xendit\",\n    \"amount\": 50000,\n    \"paid_amount\": 50000,\n    \"bank_code\": \"PERMATA\",\n    \"paid_at\": \"2016-10-12T08:15:03.404Z\",\n    \"payer_email\": \"wildan@xendit.co\",\n    \"description\": \"This is a description\",\n    \"adjusted_received_amount\": 47500,\n    \"fees_paid_amount\": 0,\n    \"updated\": \"2016-10-10T08:15:03.404Z\",\n    \"created\": \"2016-10-10T08:15:03.404Z\",\n    \"currency\": \"IDR\",\n    \"payment_channel\": \"PERMATA\",\n    \"payment_destination\": \"888888888888\"\n}','2021-02-26 04:39:57',NULL,NULL),(5,'1ZY02261154','xendit','invoice','{\"id\":\"60387eee5abdc44038091bd9\",\"external_id\":\"1ZY02261154\",\"user_id\":\"6023307e86deed145d1d1564\",\"status\":\"PENDING\",\"merchant_name\":\"Momila\",\"merchant_profile_picture_url\":\"https:\\/\\/xnd-companies.s3.amazonaws.com\\/prod\\/1612919871568_631.png\",\"amount\":99000,\"payer_email\":\"admin@admin.com\",\"description\":\"Pembayaran VISSI Platform\",\"expiry_date\":\"2021-02-27T04:54:06.063Z\",\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/60387eee5abdc44038091bd9\",\"available_banks\":[{\"bank_code\":\"MANDIRI\",\"collection_type\":\"POOL\",\"bank_account_number\":\"8860885235342\",\"transfer_amount\":99000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"BRI\",\"collection_type\":\"POOL\",\"bank_account_number\":\"2621544449837\",\"transfer_amount\":99000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"BNI\",\"collection_type\":\"POOL\",\"bank_account_number\":\"880870767411\",\"transfer_amount\":99000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"PERMATA\",\"collection_type\":\"POOL\",\"bank_account_number\":\"821450669884\",\"transfer_amount\":99000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"BCA\",\"collection_type\":\"POOL\",\"bank_account_number\":\"1076616649618\",\"transfer_amount\":99000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0}],\"available_retail_outlets\":[{\"retail_outlet_name\":\"ALFAMART\",\"payment_code\":\"TEST154667\",\"transfer_amount\":99000},{\"retail_outlet_name\":\"INDOMARET\",\"payment_code\":\"TEST83964\",\"transfer_amount\":99000}],\"available_ewallets\":[{\"ewallet_type\":\"OVO\"},{\"ewallet_type\":\"DANA\"},{\"ewallet_type\":\"SHOPEEPAY\"},{\"ewallet_type\":\"LINKAJA\"}],\"should_exclude_credit_card\":true,\"should_send_email\":false,\"created\":\"2021-02-26T04:54:06.187Z\",\"updated\":\"2021-02-26T04:54:06.187Z\",\"currency\":\"IDR\"}','2021-02-26 04:54:06',NULL,NULL),(6,'1ZY02261154','xendit','callback','{\n    \"id\": \"60387eee5abdc44038091bd9\",\n    \"external_id\": \"1ZY02261154\",\n    \"user_id\": \"6023307e86deed145d1d1564\",\n    \"is_high\": false,\n    \"payment_method\": \"BANK_TRANSFER\",\n    \"status\": \"PAID\",\n    \"merchant_name\": \"Momila\",\n    \"amount\": 99000,\n    \"paid_amount\": 99000,\n    \"bank_code\": \"MANDIRI\",\n    \"paid_at\": \"2021-02-26T04:54:35.120Z\",\n    \"payer_email\": \"admin@admin.com\",\n    \"description\": \"Pembayaran VISSI Platform\",\n    \"adjusted_received_amount\": 94050,\n    \"fees_paid_amount\": 4950,\n    \"created\": \"2021-02-26T04:54:06.187Z\",\n    \"updated\": \"2021-02-26T04:54:35.260Z\",\n    \"currency\": \"IDR\",\n    \"payment_channel\": \"MANDIRI\",\n    \"payment_destination\": \"8860885235342\"\n}','2021-02-26 04:58:33',NULL,NULL),(7,'1JW02261418','xendit','invoice','{\"id\":\"6038a0c0f771bb4016477351\",\"external_id\":\"1JW02261418\",\"user_id\":\"6023307e86deed145d1d1564\",\"status\":\"PENDING\",\"merchant_name\":\"Momila\",\"merchant_profile_picture_url\":\"https:\\/\\/xnd-companies.s3.amazonaws.com\\/prod\\/1612919871568_631.png\",\"amount\":68000,\"payer_email\":\"admin@admin.com\",\"description\":\"Pembayaran VISSI Platform\",\"expiry_date\":\"2021-02-27T07:18:23.773Z\",\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/6038a0c0f771bb4016477351\",\"available_banks\":[{\"bank_code\":\"MANDIRI\",\"collection_type\":\"POOL\",\"bank_account_number\":\"8860850626569\",\"transfer_amount\":68000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"BRI\",\"collection_type\":\"POOL\",\"bank_account_number\":\"2621548044159\",\"transfer_amount\":68000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"BNI\",\"collection_type\":\"POOL\",\"bank_account_number\":\"880865299193\",\"transfer_amount\":68000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"PERMATA\",\"collection_type\":\"POOL\",\"bank_account_number\":\"821454654793\",\"transfer_amount\":68000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"BCA\",\"collection_type\":\"POOL\",\"bank_account_number\":\"1076620243940\",\"transfer_amount\":68000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0}],\"available_retail_outlets\":[{\"retail_outlet_name\":\"ALFAMART\",\"payment_code\":\"TEST154722\",\"transfer_amount\":68000},{\"retail_outlet_name\":\"INDOMARET\",\"payment_code\":\"TEST84035\",\"transfer_amount\":68000}],\"available_ewallets\":[{\"ewallet_type\":\"OVO\"},{\"ewallet_type\":\"DANA\"},{\"ewallet_type\":\"SHOPEEPAY\"},{\"ewallet_type\":\"LINKAJA\"}],\"should_exclude_credit_card\":true,\"should_send_email\":false,\"created\":\"2021-02-26T07:18:24.060Z\",\"updated\":\"2021-02-26T07:18:24.060Z\",\"currency\":\"IDR\"}','2021-02-26 07:18:24',NULL,NULL),(8,'1GJ02261615','xendit','invoice','{\"id\":\"6038bc3747e2004044e36a59\",\"external_id\":\"1GJ02261615\",\"user_id\":\"6023307e86deed145d1d1564\",\"status\":\"PENDING\",\"merchant_name\":\"Momila\",\"merchant_profile_picture_url\":\"https:\\/\\/xnd-companies.s3.amazonaws.com\\/prod\\/1612919871568_631.png\",\"amount\":30000,\"payer_email\":\"admin@admin.com\",\"description\":\"Pembayaran VISSI Platform\",\"expiry_date\":\"2021-02-27T09:15:34.952Z\",\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/6038bc3747e2004044e36a59\",\"available_banks\":[{\"bank_code\":\"MANDIRI\",\"collection_type\":\"POOL\",\"bank_account_number\":\"8860850470795\",\"transfer_amount\":30000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"BRI\",\"collection_type\":\"POOL\",\"bank_account_number\":\"2621533903988\",\"transfer_amount\":30000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"BNI\",\"collection_type\":\"POOL\",\"bank_account_number\":\"880893893387\",\"transfer_amount\":30000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"PERMATA\",\"collection_type\":\"POOL\",\"bank_account_number\":\"821454889606\",\"transfer_amount\":30000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"BCA\",\"collection_type\":\"POOL\",\"bank_account_number\":\"1076677197515\",\"transfer_amount\":30000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0}],\"available_retail_outlets\":[{\"retail_outlet_name\":\"ALFAMART\",\"payment_code\":\"TEST154804\",\"transfer_amount\":30000},{\"retail_outlet_name\":\"INDOMARET\",\"payment_code\":\"TEST84140\",\"transfer_amount\":30000}],\"available_ewallets\":[{\"ewallet_type\":\"OVO\"},{\"ewallet_type\":\"DANA\"},{\"ewallet_type\":\"SHOPEEPAY\"},{\"ewallet_type\":\"LINKAJA\"}],\"should_exclude_credit_card\":true,\"should_send_email\":true,\"success_redirect_url\":\"https:\\/\\/vissi.test\\/payment\\/xen\\/finish\\/1GJ02261615\",\"failure_redirect_url\":\"https:\\/\\/vissi.test\\/payment\\/xen\\/error\\/1GJ02261615\",\"created\":\"2021-02-26T09:15:35.081Z\",\"updated\":\"2021-02-26T09:15:35.081Z\",\"currency\":\"IDR\"}','2021-02-26 09:15:35',NULL,NULL),(9,'1FF02261715','xendit','invoice','{\"id\":\"6038ca44fcaa69407502cc0c\",\"external_id\":\"1FF02261715\",\"user_id\":\"6023307e86deed145d1d1564\",\"status\":\"PENDING\",\"merchant_name\":\"Momila\",\"merchant_profile_picture_url\":\"https:\\/\\/xnd-companies.s3.amazonaws.com\\/prod\\/1612919871568_631.png\",\"amount\":58000,\"payer_email\":\"admin@admin.com\",\"description\":\"Pembayaran VISSI Platform\",\"expiry_date\":\"2021-02-27T10:15:32.689Z\",\"invoice_url\":\"https:\\/\\/checkout-staging.xendit.co\\/web\\/6038ca44fcaa69407502cc0c\",\"available_banks\":[{\"bank_code\":\"MANDIRI\",\"collection_type\":\"POOL\",\"bank_account_number\":\"8860842814829\",\"transfer_amount\":58000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"BRI\",\"collection_type\":\"POOL\",\"bank_account_number\":\"2621535701149\",\"transfer_amount\":58000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"BNI\",\"collection_type\":\"POOL\",\"bank_account_number\":\"880820065532\",\"transfer_amount\":58000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"PERMATA\",\"collection_type\":\"POOL\",\"bank_account_number\":\"821489577418\",\"transfer_amount\":58000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0},{\"bank_code\":\"BCA\",\"collection_type\":\"POOL\",\"bank_account_number\":\"1076655557152\",\"transfer_amount\":58000,\"bank_branch\":\"Virtual Account\",\"account_holder_name\":\"MOMILA\",\"identity_amount\":0}],\"available_retail_outlets\":[{\"retail_outlet_name\":\"ALFAMART\",\"payment_code\":\"TEST154843\",\"transfer_amount\":58000},{\"retail_outlet_name\":\"INDOMARET\",\"payment_code\":\"TEST84194\",\"transfer_amount\":58000}],\"available_ewallets\":[{\"ewallet_type\":\"OVO\"},{\"ewallet_type\":\"DANA\"},{\"ewallet_type\":\"SHOPEEPAY\"},{\"ewallet_type\":\"LINKAJA\"}],\"should_exclude_credit_card\":true,\"should_send_email\":true,\"success_redirect_url\":\"https:\\/\\/vissi.test\\/payment\\/xen\\/finish\\/1FF02261715\",\"failure_redirect_url\":\"https:\\/\\/vissi.test\\/payment\\/xen\\/error\\/1FF02261715\",\"created\":\"2021-02-26T10:15:32.770Z\",\"updated\":\"2021-02-26T10:15:32.770Z\",\"currency\":\"IDR\"}','2021-02-26 10:15:32',NULL,NULL);
/*!40000 ALTER TABLE `payment_gateway_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_midtrans_logs`
--

DROP TABLE IF EXISTS `payment_midtrans_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_midtrans_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_code` varchar(20) DEFAULT NULL,
  `data` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_midtrans_logs`
--

LOCK TABLES `payment_midtrans_logs` WRITE;
/*!40000 ALTER TABLE `payment_midtrans_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_midtrans_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_moota_log`
--

DROP TABLE IF EXISTS `payment_moota_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_moota_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_number` varchar(100) NOT NULL,
  `bank_type` varchar(40) NOT NULL,
  `date` date NOT NULL,
  `amount` int NOT NULL,
  `description` text NOT NULL,
  `type` varchar(100) NOT NULL DEFAULT 'CR',
  `ip` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_moota_log`
--

LOCK TABLES `payment_moota_log` WRITE;
/*!40000 ALTER TABLE `payment_moota_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_moota_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_order`
--

DROP TABLE IF EXISTS `payment_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `airwaybill` varchar(255) DEFAULT NULL,
  `expedition` varchar(255) DEFAULT NULL,
  `order_code` varchar(20) NOT NULL DEFAULT '0',
  `note` text,
  `coupon_code` varchar(20) DEFAULT NULL,
  `gross_amount` float NOT NULL DEFAULT '0',
  `gross_amount_discount` float NOT NULL DEFAULT '0',
  `expedition_province` varchar(255) DEFAULT NULL,
  `expedition_city` varchar(255) DEFAULT NULL,
  `expedition_cost` varchar(255) DEFAULT NULL,
  `product_type` varchar(20) NOT NULL DEFAULT 'default',
  `payment_type` varchar(20) NOT NULL DEFAULT 'transfer',
  `transaction_status` varchar(20) NOT NULL DEFAULT 'pending',
  `followup` tinyint DEFAULT NULL,
  `status_code` varchar(4) DEFAULT '201',
  `ordermeta` text,
  `pdf_url` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expired_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_order`
--

LOCK TABLES `payment_order` WRITE;
/*!40000 ALTER TABLE `payment_order` DISABLE KEYS */;
INSERT INTO `payment_order` VALUES (1,1,NULL,'jne','1UD02011126','',NULL,99000,98840,NULL,NULL,NULL,'membership','transfer','expired',NULL,'201',NULL,NULL,'2021-02-01 04:26:38','2021-02-01 13:26:38',NULL,NULL),(2,1,NULL,'jne','1GE02231338','',NULL,73000,73000,'Jawa Tengah','Kabupaten Magelang','13000','default','xendit','expired',NULL,'201',NULL,NULL,'2021-02-23 06:38:41','2021-02-23 15:38:41',NULL,NULL),(5,1,NULL,'jne','1WC02241509','',NULL,90000,90000,'Jawa Barat','Kota Cirebon','10000','default','xendit','settlement',NULL,'200',NULL,NULL,'2021-02-24 08:09:09','2021-02-24 17:09:09',NULL,'2021-02-24 08:48:40'),(6,1,NULL,'jne','1FS02241550','',NULL,110000,110000,'Jawa Barat','Kota Cirebon','10000','default','xendit','settlement',NULL,'200',NULL,NULL,'2021-02-24 08:50:58','2021-02-24 17:50:58',NULL,'2021-02-24 08:51:21'),(7,1,NULL,'jne','1ZU02241707','',NULL,216000,216000,'Jawa Tengah','Kabupaten Jepara','16000','default','transfer','pending',NULL,'201',NULL,NULL,'2021-02-24 10:07:05','2021-02-24 19:07:05','2021-02-26 11:37:07',NULL),(8,1,NULL,'jne','1AA02260858','',NULL,50000,50000,'Jawa Barat','Kabupaten Cianjur','10000','default','xendit','expired',NULL,'202',NULL,NULL,'2021-02-26 01:58:09','2021-02-26 10:58:09',NULL,'2021-02-26 04:39:57'),(9,1,NULL,'jne','1YF02261152','',NULL,99000,99000,NULL,NULL,NULL,'membership','xendit','pending',NULL,'201',NULL,NULL,'2021-02-26 04:52:05','2021-02-26 13:52:05','2021-02-26 11:54:16',NULL),(10,1,NULL,'jne','1JE02261153','',NULL,99000,99000,NULL,NULL,NULL,'membership','xendit','pending',NULL,'201',NULL,NULL,'2021-02-26 04:53:02','2021-02-26 13:53:02','2021-02-26 11:54:18',NULL),(11,1,NULL,'jne','1ZY02261154','',NULL,99000,99000,NULL,NULL,NULL,'membership','xendit','settlement',NULL,'200',NULL,NULL,'2021-02-26 04:54:05','2021-02-26 13:54:05',NULL,'2021-02-26 04:58:33'),(12,1,NULL,'jne','1JW02261418','',NULL,68000,68000,'Jawa Barat','Kota Cimahi','8000','default','xendit','pending',NULL,'201',NULL,NULL,'2021-02-26 07:18:22','2021-02-26 16:18:22',NULL,NULL),(13,1,NULL,'jne','1GJ02261615','',NULL,30000,30000,'Jawa Barat','Kota Cirebon','10000','default','xendit','pending',NULL,'201',NULL,NULL,'2021-02-26 09:15:34','2021-02-26 18:15:34',NULL,NULL),(14,1,NULL,'jne','1FF02261715','',NULL,58000,58000,'Bangka Belitung','Kabupaten Bangka','38000','default','xendit','pending',NULL,'201',NULL,NULL,'2021-02-26 10:15:32','2021-02-26 19:15:32',NULL,NULL);
/*!40000 ALTER TABLE `payment_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_order_items`
--

DROP TABLE IF EXISTS `payment_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL DEFAULT '0',
  `product_id` varchar(30) NOT NULL DEFAULT '0',
  `item_category` varchar(20) DEFAULT NULL,
  `price` float DEFAULT '0',
  `qty` tinyint DEFAULT '1',
  `subtotal` float DEFAULT '0',
  `options` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_order_items`
--

LOCK TABLES `payment_order_items` WRITE;
/*!40000 ALTER TABLE `payment_order_items` DISABLE KEYS */;
INSERT INTO `payment_order_items` VALUES (1,1,'2','membership',99000,1,99000,'[]','2021-02-01 04:26:38',NULL),(2,2,'1','default',20000,3,60000,'[]','2021-02-23 06:38:41',NULL),(5,5,'1','default',20000,4,80000,'[]','2021-02-24 08:09:09',NULL),(6,6,'1','default',20000,5,100000,'[]','2021-02-24 08:50:58',NULL),(7,7,'1','default',20000,10,200000,'[]','2021-02-24 10:07:05',NULL),(8,8,'1','default',20000,2,40000,'[]','2021-02-26 01:58:09',NULL),(9,9,'2','membership',99000,1,99000,'[]','2021-02-26 04:52:05',NULL),(10,10,'2','membership',99000,1,99000,'[]','2021-02-26 04:53:02',NULL),(11,11,'2','membership',99000,1,99000,'[]','2021-02-26 04:54:05',NULL),(12,12,'1','default',20000,3,60000,'[]','2021-02-26 07:18:22',NULL),(13,13,'1','default',20000,1,20000,'[]','2021-02-26 09:15:34',NULL),(14,14,'1','default',20000,1,20000,'[]','2021-02-26 10:15:32',NULL);
/*!40000 ALTER TABLE `payment_order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_order_log`
--

DROP TABLE IF EXISTS `payment_order_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_order_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `payment_order_id` int NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_order_log`
--

LOCK TABLES `payment_order_log` WRITE;
/*!40000 ALTER TABLE `payment_order_log` DISABLE KEYS */;
INSERT INTO `payment_order_log` VALUES (1,5,'settlement',NULL,'2021-02-24 08:48:40',NULL),(2,6,'settlement',NULL,'2021-02-24 08:51:21',NULL),(3,8,'expired',NULL,'2021-02-26 04:39:57',NULL),(4,11,'settlement',NULL,'2021-02-26 04:58:33',NULL);
/*!40000 ALTER TABLE `payment_order_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_transfer_confirmation`
--

DROP TABLE IF EXISTS `payment_transfer_confirmation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_transfer_confirmation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `account` varchar(40) NOT NULL,
  `bank` varchar(20) DEFAULT NULL,
  `name` varchar(40) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `amount` int NOT NULL,
  `photo` varchar(255) NOT NULL,
  `status` enum('pending','confirmed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_transfer_confirmation`
--

LOCK TABLES `payment_transfer_confirmation` WRITE;
/*!40000 ALTER TABLE `payment_transfer_confirmation` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_transfer_confirmation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_voucher`
--

DROP TABLE IF EXISTS `payment_voucher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_voucher` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tags` varchar(30) DEFAULT NULL,
  `voucher_code` varchar(20) NOT NULL,
  `product_id` int NOT NULL,
  `product_type` varchar(100) NOT NULL,
  `status` enum('draft','publish','deleted') NOT NULL DEFAULT 'publish',
  `expired_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_voucher`
--

LOCK TABLES `payment_voucher` WRITE;
/*!40000 ALTER TABLE `payment_voucher` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_voucher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_voucher_log`
--

DROP TABLE IF EXISTS `payment_voucher_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_voucher_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `voucher_id` int NOT NULL,
  `voucher_code` varchar(20) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `used_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_voucher_log`
--

LOCK TABLES `payment_voucher_log` WRITE;
/*!40000 ALTER TABLE `payment_voucher_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_voucher_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_content`
--

DROP TABLE IF EXISTS `product_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_content` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `product` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `caption` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_content`
--

LOCK TABLES `product_content` WRITE;
/*!40000 ALTER TABLE `product_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL DEFAULT 'Anonymous',
  `product_image` varchar(255) NOT NULL DEFAULT 'http://via.placeholder.com/300x300',
  `product_slug` varchar(255) NOT NULL DEFAULT 'Anonymous',
  `custom_landing_url` varchar(255) DEFAULT NULL,
  `product_desc` text,
  `product_type` varchar(20) NOT NULL DEFAULT 'default',
  `normal_price` bigint DEFAULT NULL,
  `retail_price` bigint NOT NULL DEFAULT '10',
  `count_expedition` tinyint(1) DEFAULT NULL,
  `object_id` bigint DEFAULT NULL,
  `object_type` varchar(50) DEFAULT NULL,
  `custom_data` text,
  `publish` tinyint(1) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'T-Shirt CP','https://via.placeholder.com/300x300','tshirt-cp',NULL,'Contoh produk','default',0,20000,1,NULL,'default','[]',1,1,'2021-01-29 19:32:27','2021-02-23 06:03:41',NULL),(2,'Membership','https://via.placeholder.com/300x300','membership',NULL,'','membership',0,99000,0,NULL,'membership','{\"durasi_akses\":\"99999\"}',1,1,'2021-02-01 04:22:10',NULL,NULL),(3,'Sample Course','','sample-course',NULL,'','course',0,0,NULL,1,'course','{\"object_id\":null,\"durasi_akses\":99999}',1,1,'2021-02-16 07:37:00',NULL,NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscribers`
--

DROP TABLE IF EXISTS `subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscribers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `followup` tinyint DEFAULT NULL,
  `subscribe_status` varchar(255) DEFAULT 'publish',
  `user_id` int NOT NULL,
  `order_id` int NOT NULL,
  `date_expired` date DEFAULT NULL,
  `subscribe_product_id` int DEFAULT NULL,
  `subscribe_object_id` int DEFAULT NULL COMMENT 'course path id',
  `subscribe_object_type` varchar(50) NOT NULL DEFAULT 'path',
  `daily_credit` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscribe_status` (`subscribe_status`,`user_id`,`subscribe_object_type`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscribers`
--

LOCK TABLES `subscribers` WRITE;
/*!40000 ALTER TABLE `subscribers` DISABLE KEYS */;
INSERT INTO `subscribers` VALUES (1,NULL,'publish',1,11,'2294-12-11',2,NULL,'membership',NULL,'2021-02-26 04:58:33',NULL);
/*!40000 ALTER TABLE `subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallet`
--

DROP TABLE IF EXISTS `wallet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallet` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject_id` int NOT NULL,
  `balance` int NOT NULL DEFAULT '0',
  `withdrawal` int NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet`
--

LOCK TABLES `wallet` WRITE;
/*!40000 ALTER TABLE `wallet` DISABLE KEYS */;
/*!40000 ALTER TABLE `wallet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallet_ledger`
--

DROP TABLE IF EXISTS `wallet_ledger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallet_ledger` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject_id` int NOT NULL,
  `transaction_id` int NOT NULL,
  `amount` float NOT NULL,
  `entry` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet_ledger`
--

LOCK TABLES `wallet_ledger` WRITE;
/*!40000 ALTER TABLE `wallet_ledger` DISABLE KEYS */;
/*!40000 ALTER TABLE `wallet_ledger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallet_transaction`
--

DROP TABLE IF EXISTS `wallet_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallet_transaction` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject_id` int NOT NULL,
  `type` varchar(20) NOT NULL,
  `currency` varchar(3) NOT NULL,
  `amount` int NOT NULL,
  `code` varchar(10) NOT NULL,
  `metadata` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet_transaction`
--

LOCK TABLES `wallet_transaction` WRITE;
/*!40000 ALTER TABLE `wallet_transaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `wallet_transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallet_transaction_log`
--

DROP TABLE IF EXISTS `wallet_transaction_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallet_transaction_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NOT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` datetime NOT NULL,
  `expired_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet_transaction_log`
--

LOCK TABLES `wallet_transaction_log` WRITE;
/*!40000 ALTER TABLE `wallet_transaction_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `wallet_transaction_log` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-03-02 15:09:59
