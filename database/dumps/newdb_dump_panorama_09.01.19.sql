-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: localhost    Database: panorama
-- ------------------------------------------------------
-- Server version	5.7.24-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `article_author`
--

DROP TABLE IF EXISTS `article_author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_author` (
  `article_id` int(10) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`article_id`,`author_id`),
  KEY `article_author_author_id_foreign` (`author_id`),
  CONSTRAINT `article_author_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  CONSTRAINT `article_author_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_author`
--

LOCK TABLES `article_author` WRITE;
/*!40000 ALTER TABLE `article_author` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_category`
--

DROP TABLE IF EXISTS `article_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_category` (
  `article_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`article_id`,`category_id`),
  KEY `article_category_category_id_foreign` (`category_id`),
  CONSTRAINT `article_category_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  CONSTRAINT `article_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_category`
--

LOCK TABLES `article_category` WRITE;
/*!40000 ALTER TABLE `article_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_translations`
--

DROP TABLE IF EXISTS `article_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Just tags',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `preview_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview_description` text COLLATE utf8mb4_unicode_ci,
  `bibliography` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `article_translations_article_id_locale_unique` (`article_id`,`locale`),
  KEY `article_translations_locale_index` (`locale`),
  CONSTRAINT `article_translations_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_translations`
--

LOCK TABLES `article_translations` WRITE;
/*!40000 ALTER TABLE `article_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `active_date` datetime DEFAULT NULL,
  `active_end_date` datetime DEFAULT NULL,
  `publication_date` date DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `release_id` int(10) unsigned DEFAULT NULL,
  `pin` tinyint(1) NOT NULL DEFAULT '0',
  `content_restriction` enum('no','register','pay/subscribe') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `UDC` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Universal Decimal Classification',
  `price` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `articles_release_id_foreign` (`release_id`),
  CONSTRAINT `articles_release_id_foreign` FOREIGN KEY (`release_id`) REFERENCES `releases` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `author_translations`
--

DROP TABLE IF EXISTS `author_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `author_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `author_translations_author_id_locale_unique` (`author_id`,`locale`),
  KEY `author_translations_locale_index` (`locale`),
  CONSTRAINT `author_translations_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `author_translations`
--

LOCK TABLES `author_translations` WRITE;
/*!40000 ALTER TABLE `author_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `author_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `authors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author_language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authors`
--

LOCK TABLES `authors` WRITE;
/*!40000 ALTER TABLE `authors` DISABLE KEYS */;
/*!40000 ALTER TABLE `authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_translations`
--

DROP TABLE IF EXISTS `category_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_translations_category_id_locale_unique` (`category_id`,`locale`),
  KEY `category_translations_locale_index` (`locale`),
  CONSTRAINT `category_translations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_translations`
--

LOCK TABLES `category_translations` WRITE;
/*!40000 ALTER TABLE `category_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `category_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jby_promo`
--

DROP TABLE IF EXISTS `jby_promo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jby_promo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `promo_user_id` int(10) unsigned NOT NULL,
  `promocode_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jby_promo_promo_user_id_foreign` (`promo_user_id`),
  KEY `jby_promo_promocode_id_foreign` (`promocode_id`),
  CONSTRAINT `jby_promo_promo_user_id_foreign` FOREIGN KEY (`promo_user_id`) REFERENCES `promo_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jby_promo_promocode_id_foreign` FOREIGN KEY (`promocode_id`) REFERENCES `promocodes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jby_promo`
--

LOCK TABLES `jby_promo` WRITE;
/*!40000 ALTER TABLE `jby_promo` DISABLE KEYS */;
/*!40000 ALTER TABLE `jby_promo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jby_promo_journal`
--

DROP TABLE IF EXISTS `jby_promo_journal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jby_promo_journal` (
  `jby_promo_id` int(10) unsigned NOT NULL,
  `journal_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`jby_promo_id`,`journal_id`),
  KEY `jby_promo_journal_journal_id_foreign` (`journal_id`),
  CONSTRAINT `jby_promo_journal_jby_promo_id_foreign` FOREIGN KEY (`jby_promo_id`) REFERENCES `jby_promo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jby_promo_journal_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jby_promo_journal`
--

LOCK TABLES `jby_promo_journal` WRITE;
/*!40000 ALTER TABLE `jby_promo_journal` DISABLE KEYS */;
/*!40000 ALTER TABLE `jby_promo_journal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_category`
--

DROP TABLE IF EXISTS `journal_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_category` (
  `journal_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`journal_id`,`category_id`),
  KEY `journal_category_category_id_foreign` (`category_id`),
  CONSTRAINT `journal_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `journal_category_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_category`
--

LOCK TABLES `journal_category` WRITE;
/*!40000 ALTER TABLE `journal_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `journal_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_publishing`
--

DROP TABLE IF EXISTS `journal_publishing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_publishing` (
  `journal_id` int(10) unsigned NOT NULL,
  `publishing_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`journal_id`,`publishing_id`),
  KEY `journal_publishing_publishing_id_foreign` (`publishing_id`),
  CONSTRAINT `journal_publishing_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`),
  CONSTRAINT `journal_publishing_publishing_id_foreign` FOREIGN KEY (`publishing_id`) REFERENCES `publishings` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_publishing`
--

LOCK TABLES `journal_publishing` WRITE;
/*!40000 ALTER TABLE `journal_publishing` DISABLE KEYS */;
/*!40000 ALTER TABLE `journal_publishing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_translations`
--

DROP TABLE IF EXISTS `journal_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `journal_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `in_HAC_list` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `preview_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview_description` text COLLATE utf8mb4_unicode_ci,
  `format` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `volume` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `periodicity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `editorial_board` text COLLATE utf8mb4_unicode_ci,
  `article_index` text COLLATE utf8mb4_unicode_ci,
  `rubrics` text COLLATE utf8mb4_unicode_ci,
  `review_procedure` text COLLATE utf8mb4_unicode_ci,
  `article_submission_rules` text COLLATE utf8mb4_unicode_ci,
  `chief_editor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_editor` text COLLATE utf8mb4_unicode_ci,
  `contacts` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `journal_translations_journal_id_locale_unique` (`journal_id`,`locale`),
  KEY `journal_translations_locale_index` (`locale`),
  CONSTRAINT `journal_translations_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_translations`
--

LOCK TABLES `journal_translations` WRITE;
/*!40000 ALTER TABLE `journal_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `journal_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journals`
--

DROP TABLE IF EXISTS `journals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ru',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `active_date` datetime DEFAULT NULL,
  `ISSN` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journals`
--

LOCK TABLES `journals` WRITE;
/*!40000 ALTER TABLE `journals` DISABLE KEYS */;
/*!40000 ALTER TABLE `journals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2018_11_20_093408_create_subscription_table',1),(4,'2018_11_20_111144_create_partner_table',1),(5,'2018_11_20_111334_create_quota_table',1),(6,'2018_11_20_112058_create_partner_user_table',1),(7,'2018_11_20_113457_create_promocode_table',1),(8,'2018_11_20_121504_create_promo_user_table',1),(9,'2018_12_05_075451_create_paysystems_table',1),(10,'2018_12_05_075633_create_order_phys_users_table',1),(11,'2018_12_05_075653_create_order_enity_users_table',1),(12,'2018_12_05_075708_create_orders_table',1),(13,'2018_12_06_122444_create_order_story_table',1),(14,'2018_12_13_131156_create_paysystem_data_table',1),(15,'2018_12_22_092351_create_user_search_table',1),(16,'2018_12_22_092435_create_user_favorites_table',1),(17,'2018_12_27_134524_update_users_table_add_last_name_column',2),(18,'2019_01_09_084037_create_clear_database',2),(19,'2019_01_09_085916_create_translation_tables',2),(20,'2019_01_09_092223_set_foreign_keys',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `publishing_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_publishing`
--

DROP TABLE IF EXISTS `news_publishing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_publishing` (
  `news_id` int(10) unsigned NOT NULL,
  `publishing_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`news_id`,`publishing_id`),
  KEY `news_publishing_publishing_id_foreign` (`publishing_id`),
  CONSTRAINT `news_publishing_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`),
  CONSTRAINT `news_publishing_publishing_id_foreign` FOREIGN KEY (`publishing_id`) REFERENCES `publishings` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_publishing`
--

LOCK TABLES `news_publishing` WRITE;
/*!40000 ALTER TABLE `news_publishing` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_publishing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_translations`
--

DROP TABLE IF EXISTS `news_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview` text COLLATE utf8mb4_unicode_ci,
  `preview_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `news_translations_news_id_locale_unique` (`news_id`,`locale`),
  KEY `news_translations_locale_index` (`locale`),
  CONSTRAINT `news_translations_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_translations`
--

LOCK TABLES `news_translations` WRITE;
/*!40000 ALTER TABLE `news_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_legal_users`
--

DROP TABLE IF EXISTS `order_legal_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_legal_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `org_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `legal_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `INN` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'ИНН',
  `KPP` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'КПП',
  `l_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l_surname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l_patronymic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l_delivery_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `l_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_legal_users`
--

LOCK TABLES `order_legal_users` WRITE;
/*!40000 ALTER TABLE `order_legal_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_legal_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_phys_users`
--

DROP TABLE IF EXISTS `order_phys_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_phys_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `patronymic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_phys_users`
--

LOCK TABLES `order_phys_users` WRITE;
/*!40000 ALTER TABLE `order_phys_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_phys_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_story`
--

DROP TABLE IF EXISTS `order_story`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_story` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `operation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_story`
--

LOCK TABLES `order_story` WRITE;
/*!40000 ALTER TABLE `order_story` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_story` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phys_user_id` int(10) unsigned DEFAULT NULL,
  `legal_user_id` int(10) unsigned DEFAULT NULL,
  `paysystem_id` int(10) unsigned NOT NULL,
  `status` enum('wait','payed','cancelled','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'wait',
  `orderList` json NOT NULL,
  `totalPrice` int(11) NOT NULL,
  `payed` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `left_to_pay` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_paysystem_id_foreign` (`paysystem_id`),
  CONSTRAINT `orders_paysystem_id_foreign` FOREIGN KEY (`paysystem_id`) REFERENCES `paysystems` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partner_user_quota`
--

DROP TABLE IF EXISTS `partner_user_quota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partner_user_quota` (
  `p_user_id` int(10) unsigned NOT NULL,
  `quota_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`p_user_id`,`quota_id`),
  KEY `partner_user_quota_quota_id_foreign` (`quota_id`),
  CONSTRAINT `partner_user_quota_p_user_id_foreign` FOREIGN KEY (`p_user_id`) REFERENCES `partner_users` (`id`),
  CONSTRAINT `partner_user_quota_quota_id_foreign` FOREIGN KEY (`quota_id`) REFERENCES `quotas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partner_user_quota`
--

LOCK TABLES `partner_user_quota` WRITE;
/*!40000 ALTER TABLE `partner_user_quota` DISABLE KEYS */;
/*!40000 ALTER TABLE `partner_user_quota` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partner_user_release`
--

DROP TABLE IF EXISTS `partner_user_release`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partner_user_release` (
  `p_user_id` int(10) unsigned NOT NULL,
  `release_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`p_user_id`,`release_id`),
  KEY `partner_user_release_release_id_foreign` (`release_id`),
  CONSTRAINT `partner_user_release_p_user_id_foreign` FOREIGN KEY (`p_user_id`) REFERENCES `partner_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `partner_user_release_release_id_foreign` FOREIGN KEY (`release_id`) REFERENCES `releases` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partner_user_release`
--

LOCK TABLES `partner_user_release` WRITE;
/*!40000 ALTER TABLE `partner_user_release` DISABLE KEYS */;
/*!40000 ALTER TABLE `partner_user_release` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partner_users`
--

DROP TABLE IF EXISTS `partner_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partner_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `partner_id` int(10) unsigned NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `partner_users_user_id_unique` (`user_id`),
  KEY `partner_users_partner_id_foreign` (`partner_id`),
  CONSTRAINT `partner_users_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partner_users`
--

LOCK TABLES `partner_users` WRITE;
/*!40000 ALTER TABLE `partner_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `partner_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partners`
--

DROP TABLE IF EXISTS `partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `secret_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partners`
--

LOCK TABLES `partners` WRITE;
/*!40000 ALTER TABLE `partners` DISABLE KEYS */;
/*!40000 ALTER TABLE `partners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
-- Table structure for table `paysystem_data`
--

DROP TABLE IF EXISTS `paysystem_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paysystem_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` enum('string','file') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string',
  `paysystem_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paysystem_data`
--

LOCK TABLES `paysystem_data` WRITE;
/*!40000 ALTER TABLE `paysystem_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `paysystem_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paysystems`
--

DROP TABLE IF EXISTS `paysystems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paysystems` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paysystems`
--

LOCK TABLES `paysystems` WRITE;
/*!40000 ALTER TABLE `paysystems` DISABLE KEYS */;
/*!40000 ALTER TABLE `paysystems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promo_user_promocode`
--

DROP TABLE IF EXISTS `promo_user_promocode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promo_user_promocode` (
  `promo_user_id` int(10) unsigned NOT NULL,
  `promocode_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`promo_user_id`,`promocode_id`),
  KEY `promo_user_promocode_promocode_id_foreign` (`promocode_id`),
  CONSTRAINT `promo_user_promocode_promo_user_id_foreign` FOREIGN KEY (`promo_user_id`) REFERENCES `promo_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promo_user_promocode_promocode_id_foreign` FOREIGN KEY (`promocode_id`) REFERENCES `promocodes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promo_user_promocode`
--

LOCK TABLES `promo_user_promocode` WRITE;
/*!40000 ALTER TABLE `promo_user_promocode` DISABLE KEYS */;
/*!40000 ALTER TABLE `promo_user_promocode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promo_user_publishing`
--

DROP TABLE IF EXISTS `promo_user_publishing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promo_user_publishing` (
  `promo_user_id` int(10) unsigned NOT NULL,
  `publishing_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`promo_user_id`,`publishing_id`),
  KEY `promo_user_publishing_publishing_id_foreign` (`publishing_id`),
  CONSTRAINT `promo_user_publishing_promo_user_id_foreign` FOREIGN KEY (`promo_user_id`) REFERENCES `promo_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promo_user_publishing_publishing_id_foreign` FOREIGN KEY (`publishing_id`) REFERENCES `publishings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promo_user_publishing`
--

LOCK TABLES `promo_user_publishing` WRITE;
/*!40000 ALTER TABLE `promo_user_publishing` DISABLE KEYS */;
/*!40000 ALTER TABLE `promo_user_publishing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promo_user_release`
--

DROP TABLE IF EXISTS `promo_user_release`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promo_user_release` (
  `promo_user_id` int(10) unsigned NOT NULL,
  `release_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`promo_user_id`,`release_id`),
  KEY `promo_user_release_release_id_foreign` (`release_id`),
  CONSTRAINT `promo_user_release_promo_user_id_foreign` FOREIGN KEY (`promo_user_id`) REFERENCES `promo_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promo_user_release_release_id_foreign` FOREIGN KEY (`release_id`) REFERENCES `releases` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promo_user_release`
--

LOCK TABLES `promo_user_release` WRITE;
/*!40000 ALTER TABLE `promo_user_release` DISABLE KEYS */;
/*!40000 ALTER TABLE `promo_user_release` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promo_users`
--

DROP TABLE IF EXISTS `promo_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promo_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `promo_users_user_id_foreign` (`user_id`),
  CONSTRAINT `promo_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promo_users`
--

LOCK TABLES `promo_users` WRITE;
/*!40000 ALTER TABLE `promo_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `promo_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promocode_journal`
--

DROP TABLE IF EXISTS `promocode_journal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promocode_journal` (
  `promocode_id` int(10) unsigned NOT NULL,
  `journal_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`promocode_id`,`journal_id`),
  KEY `promocode_journal_journal_id_foreign` (`journal_id`),
  CONSTRAINT `promocode_journal_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promocode_journal_promocode_id_foreign` FOREIGN KEY (`promocode_id`) REFERENCES `promocodes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promocode_journal`
--

LOCK TABLES `promocode_journal` WRITE;
/*!40000 ALTER TABLE `promocode_journal` DISABLE KEYS */;
/*!40000 ALTER TABLE `promocode_journal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promocode_publishing`
--

DROP TABLE IF EXISTS `promocode_publishing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promocode_publishing` (
  `promocode_id` int(10) unsigned NOT NULL,
  `publishing_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`promocode_id`,`publishing_id`),
  KEY `promocode_publishing_publishing_id_foreign` (`publishing_id`),
  CONSTRAINT `promocode_publishing_promocode_id_foreign` FOREIGN KEY (`promocode_id`) REFERENCES `promocodes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promocode_publishing_publishing_id_foreign` FOREIGN KEY (`publishing_id`) REFERENCES `publishings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promocode_publishing`
--

LOCK TABLES `promocode_publishing` WRITE;
/*!40000 ALTER TABLE `promocode_publishing` DISABLE KEYS */;
/*!40000 ALTER TABLE `promocode_publishing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promocode_release`
--

DROP TABLE IF EXISTS `promocode_release`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promocode_release` (
  `promocode_id` int(10) unsigned NOT NULL,
  `release_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`promocode_id`,`release_id`),
  KEY `promocode_release_release_id_foreign` (`release_id`),
  CONSTRAINT `promocode_release_promocode_id_foreign` FOREIGN KEY (`promocode_id`) REFERENCES `promocodes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promocode_release_release_id_foreign` FOREIGN KEY (`release_id`) REFERENCES `releases` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promocode_release`
--

LOCK TABLES `promocode_release` WRITE;
/*!40000 ALTER TABLE `promocode_release` DISABLE KEYS */;
/*!40000 ALTER TABLE `promocode_release` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promocodes`
--

DROP TABLE IF EXISTS `promocodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promocodes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `promocode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `type` enum('common','on_journal','on_publishing','on_release','publishing+release','custom') COLLATE utf8mb4_unicode_ci NOT NULL,
  `journal_id` int(10) unsigned DEFAULT NULL,
  `limit` int(10) unsigned DEFAULT NULL,
  `used` int(10) unsigned DEFAULT NULL,
  `journal_for_releases_id` int(10) unsigned DEFAULT NULL,
  `release_begin` datetime DEFAULT NULL,
  `release_end` datetime DEFAULT NULL,
  `release_limit` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `promocodes_promocode_unique` (`promocode`),
  KEY `promocodes_journal_id_foreign` (`journal_id`),
  KEY `promocodes_journal_for_releases_id_foreign` (`journal_for_releases_id`),
  CONSTRAINT `promocodes_journal_for_releases_id_foreign` FOREIGN KEY (`journal_for_releases_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promocodes_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promocodes`
--

LOCK TABLES `promocodes` WRITE;
/*!40000 ALTER TABLE `promocodes` DISABLE KEYS */;
/*!40000 ALTER TABLE `promocodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publishing_translations`
--

DROP TABLE IF EXISTS `publishing_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publishing_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `publishing_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `publishing_translations_publishing_id_locale_unique` (`publishing_id`,`locale`),
  KEY `publishing_translations_locale_index` (`locale`),
  CONSTRAINT `publishing_translations_publishing_id_foreign` FOREIGN KEY (`publishing_id`) REFERENCES `publishings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publishing_translations`
--

LOCK TABLES `publishing_translations` WRITE;
/*!40000 ALTER TABLE `publishing_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `publishing_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publishings`
--

DROP TABLE IF EXISTS `publishings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publishings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publishings`
--

LOCK TABLES `publishings` WRITE;
/*!40000 ALTER TABLE `publishings` DISABLE KEYS */;
/*!40000 ALTER TABLE `publishings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quotas`
--

DROP TABLE IF EXISTS `quotas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `partner_id` int(10) unsigned NOT NULL,
  `journal_id` int(10) unsigned DEFAULT NULL,
  `release_id` int(10) unsigned DEFAULT NULL,
  `release_begin` datetime DEFAULT NULL COMMENT 'Access to releases from this date',
  `release_end` datetime DEFAULT NULL COMMENT 'Access to releases to this date',
  `quota_size` int(10) unsigned DEFAULT NULL,
  `used` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quotas_partner_id_foreign` (`partner_id`),
  KEY `quotas_journal_id_foreign` (`journal_id`),
  KEY `quotas_release_id_foreign` (`release_id`),
  CONSTRAINT `quotas_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE,
  CONSTRAINT `quotas_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE,
  CONSTRAINT `quotas_release_id_foreign` FOREIGN KEY (`release_id`) REFERENCES `releases` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quotas`
--

LOCK TABLES `quotas` WRITE;
/*!40000 ALTER TABLE `quotas` DISABLE KEYS */;
/*!40000 ALTER TABLE `quotas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `release_translations`
--

DROP TABLE IF EXISTS `release_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `release_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `release_id` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `preview_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview_description` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `release_translations_release_id_locale_unique` (`release_id`,`locale`),
  KEY `release_translations_locale_index` (`locale`),
  CONSTRAINT `release_translations_release_id_foreign` FOREIGN KEY (`release_id`) REFERENCES `releases` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `release_translations`
--

LOCK TABLES `release_translations` WRITE;
/*!40000 ALTER TABLE `release_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `release_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `releases`
--

DROP TABLE IF EXISTS `releases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `releases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `active_date` datetime DEFAULT NULL,
  `journal_id` int(10) unsigned NOT NULL,
  `price_for_printed` int(11) DEFAULT NULL,
  `price_for_electronic` int(11) DEFAULT NULL,
  `promo` tinyint(1) DEFAULT NULL COMMENT 'Is release available for free',
  `price_for_articles` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `releases_journal_id_foreign` (`journal_id`),
  CONSTRAINT `releases_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `releases`
--

LOCK TABLES `releases` WRITE;
/*!40000 ALTER TABLE `releases` DISABLE KEYS */;
/*!40000 ALTER TABLE `releases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscriptions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `journal_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `type` enum('printed','electronic') COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` year(4) NOT NULL,
  `half_year` enum('first','second') COLLATE utf8mb4_unicode_ci NOT NULL,
  `period` enum('twice_at_month','once_at_month','once_at_2_months','once_at_3_months','once_at_half_year') COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_for_release` int(11) NOT NULL,
  `price_for_half_year` int(11) DEFAULT NULL,
  `price_for_year` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_locale_index` (`locale`),
  KEY `subscriptions_journal_id_foreign` (`journal_id`),
  CONSTRAINT `subscriptions_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_favorites`
--

DROP TABLE IF EXISTS `user_favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_favorites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `type` enum('journal','release','article') COLLATE utf8mb4_unicode_ci NOT NULL,
  `element_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_favorites`
--

LOCK TABLES `user_favorites` WRITE;
/*!40000 ALTER TABLE `user_favorites` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_search`
--

DROP TABLE IF EXISTS `user_search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_search` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `search_params` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_search`
--

LOCK TABLES `user_search` WRITE;
/*!40000 ALTER TABLE `user_search` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_search` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `private` tinyint(4) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_unique` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2019-01-09  5:10:19
