-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: localhost    Database: panorama
-- ------------------------------------------------------
-- Server version	5.7.24

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
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `active_date` datetime DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `release_id` int(10) unsigned DEFAULT NULL,
  `pin` tinyint(1) NOT NULL DEFAULT '0',
  `content_restriction` enum('no','register','pay/subscribe') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `UDC` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Universal Decimal Classification',
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Just tags',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `preview_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview_description` text COLLATE utf8mb4_unicode_ci,
  `bibliography` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active_end_date` date DEFAULT NULL,
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
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `authors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author_language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
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
-- Table structure for table `data_rows`
--

DROP TABLE IF EXISTS `data_rows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_rows` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data_type_id` int(10) unsigned NOT NULL,
  `field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `browse` tinyint(1) NOT NULL DEFAULT '1',
  `read` tinyint(1) NOT NULL DEFAULT '1',
  `edit` tinyint(1) NOT NULL DEFAULT '1',
  `add` tinyint(1) NOT NULL DEFAULT '1',
  `delete` tinyint(1) NOT NULL DEFAULT '1',
  `details` text COLLATE utf8mb4_unicode_ci,
  `order` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `data_rows_data_type_id_foreign` (`data_type_id`),
  CONSTRAINT `data_rows_data_type_id_foreign` FOREIGN KEY (`data_type_id`) REFERENCES `data_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=264 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_rows`
--

LOCK TABLES `data_rows` WRITE;
/*!40000 ALTER TABLE `data_rows` DISABLE KEYS */;
INSERT INTO `data_rows` VALUES (1,1,'id','number','ID',1,0,0,0,0,0,NULL,1),(2,1,'name','text','Name',1,1,1,1,1,1,NULL,2),(3,1,'email','text','Email',1,1,1,1,1,1,NULL,3),(4,1,'password','password','Password',1,0,0,1,1,0,NULL,4),(5,1,'remember_token','text','Remember Token',0,0,0,0,0,0,NULL,5),(6,1,'created_at','timestamp','Created At',0,1,1,0,0,0,NULL,6),(7,1,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,7),(8,1,'avatar','image','Avatar',0,1,1,1,1,1,NULL,8),(9,1,'user_belongsto_role_relationship','relationship','Role',0,1,1,1,1,0,'{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsTo\",\"column\":\"role_id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"roles\",\"pivot\":0}',10),(10,1,'user_belongstomany_role_relationship','relationship','Roles',0,1,1,1,1,0,'{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"user_roles\",\"pivot\":\"1\",\"taggable\":\"0\"}',11),(11,1,'locale','text','Locale',0,1,1,1,1,0,NULL,12),(12,1,'settings','hidden','Settings',0,0,0,0,0,0,NULL,12),(13,2,'id','number','ID',1,0,0,0,0,0,NULL,1),(14,2,'name','text','Name',1,1,1,1,1,1,NULL,2),(15,2,'created_at','timestamp','Created At',0,0,0,0,0,0,NULL,3),(16,2,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,4),(17,3,'id','number','ID',1,0,0,0,0,0,NULL,1),(18,3,'name','text','Name',1,1,1,1,1,1,NULL,2),(19,3,'created_at','timestamp','Created At',0,0,0,0,0,0,NULL,3),(20,3,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,4),(21,3,'display_name','text','Display Name',1,1,1,1,1,1,NULL,5),(22,1,'role_id','text','Role',1,1,1,1,1,1,NULL,9),(23,4,'id','text','Id',1,0,0,0,0,0,'{}',1),(24,4,'name','text','Название',1,1,1,1,1,1,'{}',3),(25,4,'code','text','Символьный код',1,1,1,1,1,1,'{}',4),(26,4,'active','checkbox','Активность',1,1,1,1,1,1,'{}',5),(27,4,'active_date','date','Дата начала активности',0,1,1,1,1,1,'{}',6),(28,4,'sort','number','Сортировка',0,1,1,1,1,1,'{}',7),(29,4,'release_id','text','Release Id',0,1,1,1,1,1,'{}',2),(30,4,'pin','checkbox','Закрепить',1,1,1,1,1,1,'{}',8),(31,4,'content_restriction','select_dropdown','Ограничение контента',1,1,1,1,1,1,'{\"default\":\"no\",\"options\":{\"no\":\"\\u041d\\u0435\\u0442\",\"register\":\"\\u0420\\u0435\\u0433\\u0438\\u0441\\u0442\\u0440\\u0430\\u0446\\u0438\\u044f\",\"pay\\/subscribe\":\"\\u041f\\u043e\\u043a\\u0443\\u043f\\u043a\\u0430\\/\\u041f\\u043e\\u0434\\u043f\\u0438\\u0441\\u043a\\u0430\"}}',9),(32,4,'UDC','text','УДК',0,1,1,1,1,1,'{}',14),(33,4,'price','text','Цена',0,1,1,1,1,1,'{}',15),(34,4,'keywords','text','Ключевые слова',0,1,1,1,1,1,'{}',10),(35,4,'image','image','Картинка',0,1,1,1,1,1,'{}',16),(36,4,'description','markdown_editor','Описание',0,1,1,1,1,1,'{}',17),(37,4,'preview_image','image','Картинка для анонса',0,1,1,1,1,1,'{}',18),(38,4,'preview_description','markdown_editor','Описание для анонса',0,1,1,1,1,1,'{}',19),(39,4,'bibliography','markdown_editor','Список литературы',0,1,1,1,1,1,'{}',20),(40,4,'created_at','timestamp','Создано',0,1,1,1,0,1,'{}',21),(41,4,'updated_at','timestamp','Обновлено',0,0,0,0,0,0,'{}',22),(42,5,'id','text','Id',1,0,0,0,0,0,'{}',1),(43,5,'author_language','select_multiple','Язык автора',1,1,1,1,1,1,'{\"default\":\"ru\",\"options\":{\"en\":\"\\u0410\\u043d\\u0433\\u043b\\u0438\\u0439\\u0441\\u043a\\u0438\\u0439\",\"ru\":\"\\u0420\\u0443\\u0441\\u0441\\u043a\\u0438\\u0439\"}}',2),(44,5,'name','text','Имя',1,1,1,1,1,1,'{}',3),(45,5,'created_at','timestamp','Создано',0,1,1,1,0,1,'{}',4),(46,5,'updated_at','timestamp','Обновлено',0,0,0,0,0,0,'{}',5),(47,6,'id','text','Id',1,0,0,0,0,0,'{}',1),(48,6,'name','text','Название',1,1,1,1,1,1,'{}',2),(49,6,'code','text','Символьный код',1,1,1,1,1,1,'{}',3),(50,6,'active','checkbox','Активность',1,1,1,1,1,1,'{}',4),(51,6,'sort','number','Сортировка',0,1,1,1,1,1,'{}',5),(52,6,'image','image','Картинка',0,1,1,1,1,1,'{}',6),(53,6,'description','markdown_editor','Описание',0,1,1,1,1,1,'{}',7),(54,6,'created_at','timestamp','Создано',0,1,1,1,0,1,'{}',8),(55,6,'updated_at','timestamp','Обновлено',0,0,0,0,0,0,'{}',9),(56,7,'id','text','Id',1,0,0,0,0,0,'{}',1),(57,7,'promo_user_id','text','Promo User Id',1,1,1,1,1,1,'{}',2),(58,7,'promocode_id','text','Promocode Id',1,1,1,1,1,1,'{}',3),(59,7,'created_at','timestamp','Создано',0,1,1,1,0,1,'{}',4),(60,7,'updated_at','timestamp','Обновлено',0,0,0,0,0,0,'{}',5),(61,8,'id','text','Id',1,0,0,0,0,0,'{}',1),(62,8,'name','text','Название',1,1,1,1,1,1,'{}',3),(63,8,'code','text','Символьный код',1,1,1,1,1,1,'{}',6),(64,8,'locale','select_dropdown','Локализация',1,1,1,1,1,1,'{\"default\":\"ru\",\"options\":{\"ru\":\"\\u0420\\u0443\\u0441\\u0441\\u043a\\u0438\\u0439\",\"en\":\"\\u0410\\u043d\\u0433\\u043b\\u0438\\u0439\\u0441\\u043a\\u0438\\u0439\"}}',10),(65,8,'active','checkbox','Активность',1,1,1,1,1,1,'{}',4),(66,8,'active_date','date','Дата начала активности',0,1,1,1,1,1,'{}',5),(67,8,'ISSN','text','ISSN',0,1,1,1,1,1,'{}',9),(68,8,'journal_contact_id','text','Journal Contact Id',0,1,1,1,1,1,'{}',2),(69,8,'in_HAC_list','markdown_editor','Входит в перечень ВАК',0,1,1,1,1,1,'{}',11),(70,8,'image','image','Картинка',0,1,1,1,1,1,'{}',12),(71,8,'description','markdown_editor','Описание',0,1,1,1,1,1,'{}',13),(72,8,'preview_image','image','Картинка для анонса',0,1,1,1,1,1,'{}',14),(73,8,'preview_description','markdown_editor','Описание для анонса',0,1,1,1,1,1,'{}',15),(74,8,'format','text','Формат',0,1,1,1,1,1,'{}',16),(75,8,'volume','text','Объем',0,1,1,1,1,1,'{}',17),(76,8,'periodicity','text','Периодичность',0,1,1,1,1,1,'{}',18),(77,8,'editorial_board','markdown_editor','Редсовет',0,1,1,1,1,1,'{}',19),(78,8,'article_index','markdown_editor','Указатель статей',0,1,1,1,1,1,'{}',20),(79,8,'rubrics','markdown_editor','Рубрики',0,1,1,1,1,1,'{}',21),(80,8,'review_procedure','markdown_editor','Порядок рецензирования',0,1,1,1,1,1,'{}',22),(81,8,'article_submission_rules','markdown_editor','Правила предоставления статей',0,1,1,1,1,1,'{}',23),(82,8,'created_at','timestamp','Создано',0,1,1,1,0,1,'{}',24),(83,8,'updated_at','timestamp','Обновлено',0,0,0,0,0,0,'{}',25),(84,9,'id','text','Id',1,0,0,0,0,0,'{}',1),(85,9,'name','text','Название',1,1,1,1,1,1,'{}',2),(86,9,'code','text','Символьный код',1,1,1,1,1,1,'{}',3),(87,9,'active','checkbox','Активность',1,1,1,1,1,1,'{}',4),(88,9,'publishing_date','date','Дата публикации',0,1,1,1,1,1,'{}',5),(89,9,'description','markdown_editor','Описание',0,1,1,1,1,1,'{}',6),(90,9,'image','image','Картинка',0,1,1,1,1,1,'{}',7),(91,9,'preview','markdown_editor','Анонс',0,1,1,1,1,1,'{}',8),(92,9,'preview_image','image','Картинка для анонса',0,1,1,1,1,1,'{}',9),(93,9,'created_at','timestamp','Создано',0,1,1,1,0,1,'{}',10),(94,9,'updated_at','timestamp','Обновлено',0,0,0,0,0,0,'{}',11),(95,10,'id','text','Id',1,0,0,0,0,0,'{}',1),(96,10,'user_id','text','User Id',1,1,1,1,1,1,'{}',3),(97,10,'active','checkbox','Активность',1,1,1,1,1,1,'{}',4),(98,10,'partner_id','text','Partner Id',1,1,1,1,1,1,'{}',2),(99,10,'email','text','Email',0,1,1,1,1,1,'{}',5),(100,10,'created_at','timestamp','Создано',0,1,1,1,0,1,'{}',6),(101,10,'updated_at','timestamp','Обновлено',0,0,0,0,0,0,'{}',7),(102,11,'id','text','Id',1,0,0,0,0,0,'{}',1),(103,11,'secret_key','text','Код',1,1,1,1,1,1,'{}',2),(104,11,'active','checkbox','Активность',1,1,1,1,1,1,'{}',3),(105,11,'created_at','timestamp','Создано',0,1,1,1,0,1,'{}',4),(106,11,'updated_at','timestamp','Обновлено',0,0,0,0,0,0,'{}',5),(107,12,'id','text','Id',1,0,0,0,0,0,'{}',1),(108,12,'name','text','Имя',1,1,1,1,1,1,'{}',3),(109,12,'user_id','text','User Id',1,1,1,1,1,1,'{}',2),(110,12,'phone','text','Телефон',0,1,1,1,1,1,'{}',4),(111,12,'created_at','timestamp','Создано',0,1,1,1,0,1,'{}',5),(112,12,'updated_at','timestamp','Обновлено',0,0,0,0,0,0,'{}',6),(113,13,'id','text','Id',1,0,0,0,0,0,'{}',1),(114,13,'promocode','text','Промокод',1,1,1,1,1,1,'{}',4),(115,13,'active','checkbox','Активность',1,1,1,1,1,1,'{}',5),(116,13,'type','select_dropdown','Вид',1,1,1,1,1,1,'{\"default\":\"common\",\"options\":{\"common\":\"\\u041e\\u0431\\u0449\\u0438\\u0439\",\"on_journal\":\"\\u041d\\u0430 \\u0436\\u0443\\u0440\\u043d\\u0430\\u043b\",\"on_publishing\":\"\\u041d\\u0430 \\u0438\\u0437\\u0434\\u0430\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u043e\",\"on_release\":\"\\u041d\\u0430 \\u0432\\u044b\\u043f\\u0443\\u0441\\u043a\",\"publishing+release\":\"\\u0418\\u0437\\u0434\\u0430\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u043e+\\u0412\\u044b\\u043f\\u0443\\u0441\\u043a\",\"custom\":\"\\u0412\\u044b\\u0431\\u043e\\u0440\\u043e\\u0447\\u043d\\u044b\\u0439\"}}',6),(117,13,'journal_id','text','Journal Id',0,1,1,1,1,1,'{}',2),(118,13,'limit','number','Лимит использований',0,1,1,1,1,1,'{}',7),(119,13,'used','number','Использовано',0,1,1,1,1,1,'{}',8),(120,13,'journal_for_releases_id','text','Journal For Releases Id',0,1,1,1,1,1,'{}',3),(121,13,'release_begin','date','Дата начала выпусков',0,1,1,1,1,1,'{}',9),(122,13,'release_end','date','Дата конца выпусков',0,1,1,1,1,1,'{}',10),(123,13,'release_limit','number','Сколько можно выбрать',0,1,1,1,1,1,'{}',11),(124,13,'created_at','timestamp','Создано',0,1,1,1,0,1,'{}',12),(125,13,'updated_at','timestamp','Обновлено',0,0,0,0,0,0,'{}',13),(126,14,'id','text','Id',1,0,0,0,0,0,'{}',1),(127,14,'name','text','Название',1,1,1,1,1,1,'{}',2),(128,14,'code','text','Символьный код',1,1,1,1,1,1,'{}',3),(129,14,'active','checkbox','Активность',1,1,1,1,1,1,'{}',4),(130,14,'sort','number','Сортировка',0,1,1,1,1,1,'{}',5),(131,14,'image','image','Картинка',0,1,1,1,1,1,'{}',6),(132,14,'description','markdown_editor','Описание',0,1,1,1,1,1,'{}',7),(133,14,'created_at','timestamp','Создано',0,1,1,1,0,1,'{}',8),(134,14,'updated_at','timestamp','Обновлено',0,0,0,0,0,0,'{}',9),(135,15,'id','text','Id',1,0,0,0,0,0,'{}',1),(136,15,'active','checkbox','Активность',1,1,1,1,1,1,'{}',5),(137,15,'partner_id','text','Partner Id',1,1,1,1,1,1,'{}',2),(138,15,'journal_id','text','Journal Id',0,1,1,1,1,1,'{}',3),(139,15,'release_id','text','Release Id',0,1,1,1,1,1,'{}',4),(140,15,'release_begin','date','Дата начала выпусков',0,1,1,1,1,1,'{}',6),(141,15,'release_end','date','Дата конца выпусков',0,1,1,1,1,1,'{}',7),(142,15,'quota_size','number','Размер квоты',0,1,1,1,1,1,'{}',8),(143,15,'used','number','Использовано',0,1,1,1,1,1,'{}',9),(144,15,'created_at','timestamp','Создано',0,1,1,1,0,1,'{}',10),(145,15,'updated_at','timestamp','Обновлено',0,0,0,0,0,0,'{}',11),(146,17,'id','text','Id',1,0,0,0,0,0,'{}',1),(147,17,'name','text','Название',1,1,1,1,1,1,'{}',3),(148,17,'code','text','Символьный код',1,1,1,1,1,1,'{}',4),(149,17,'active','checkbox','Активность',1,1,1,1,1,1,'{}',5),(150,17,'active_date','date','Дата начала активности',0,1,1,1,1,1,'{}',6),(151,17,'journal_id','text','Journal Id',1,1,1,1,1,1,'{}',2),(152,17,'number','text','Номер',0,1,1,1,1,1,'{}',8),(153,17,'price_for_printed','text','Цена на печатную версию',0,1,1,1,1,1,'{}',9),(154,17,'price_for_electronic','text','Цена на электронную версию',0,1,1,1,1,1,'{}',10),(155,17,'promo','checkbox','Промо',0,1,1,1,1,1,'{}',11),(156,17,'price_for_articles','text','Цена статей',0,1,1,1,1,1,'{}',12),(157,17,'image','image','Картинка',0,1,1,1,1,1,'{}',13),(158,17,'description','markdown_editor','Описание',0,1,1,1,1,1,'{}',14),(159,17,'preview_image','image','Картинка для анонса',0,1,1,1,1,1,'{}',15),(160,17,'preview_description','markdown_editor','Описание для анонса',0,1,1,1,1,1,'{}',16),(161,17,'created_at','timestamp','Создано',0,1,1,1,0,1,'{}',17),(162,17,'updated_at','timestamp','Обновлено',0,0,0,0,0,0,'{}',18),(163,18,'id','text','Id',1,0,0,0,0,0,'{}',1),(164,18,'locale','select_dropdown','Локализация',1,1,1,1,1,1,'{\"default\":\"ru\",\"options\":{\"ru\":\"\\u0420\\u0443\\u0441\\u0441\\u043a\\u0438\\u0439\",\"en\":\"\\u0410\\u043d\\u0433\\u043b\\u0438\\u0439\\u0441\\u043a\\u0438\\u0439\"}}',3),(165,18,'journal_id','text','Journal Id',1,1,1,1,1,1,'{}',2),(166,18,'active','checkbox','Активность',1,1,1,1,1,1,'{}',4),(167,18,'type','select_dropdown','Тип',1,1,1,1,1,1,'{\"default\":\"printed\",\"options\":{\"printed\":\"\\u041f\\u0435\\u0447\\u0430\\u0442\\u043d\\u0430\\u044f\",\"electronic\":\"\\u042d\\u043b\\u0435\\u043a\\u0442\\u0440\\u043e\\u043d\\u043d\\u0430\\u044f\"}}',5),(168,18,'year','text','Год',1,1,1,1,1,1,'{}',6),(169,18,'half_year','select_dropdown','Полугодие',1,1,1,1,1,1,'{\"default\":\"first\",\"options\":{\"first\":\"\\u041f\\u0435\\u0440\\u0432\\u043e\\u0435\",\"second\":\"\\u0412\\u0442\\u043e\\u0440\\u043e\\u0435\"}}',7),(170,18,'period','select_dropdown','Периодичность',1,1,1,1,1,1,'{\"default\":\"twice_at_month\",\"options\":{\"twice_at_month\":\"\\u0414\\u0432\\u0430\\u0436\\u0434\\u044b \\u0432 \\u043c\\u0435\\u0441\\u044f\\u0446\",\"once_at_month\":\"\\u041e\\u0434\\u0438\\u043d \\u0440\\u0430\\u0437 \\u0432 \\u043c\\u0435\\u0441\\u044f\\u0446\",\"once_at_2_months\":\"\\u0420\\u0430\\u0437 \\u0432 \\u0434\\u0432\\u0430 \\u043c\\u0435\\u0441\\u044f\\u0446\\u0430\",\"once_at_3_months\":\"\\u0420\\u0430\\u0437 \\u0432 \\u0442\\u0440\\u0438 \\u043c\\u0435\\u0441\\u044f\\u0446\\u0430\",\"once_at_half_year\":\"\\u0420\\u0430\\u0437 \\u0432 \\u043f\\u043e\\u043b\\u0433\\u043e\\u0434\\u0430\"}}',8),(171,18,'price_for_release','text','Цена за выпуск',1,1,1,1,1,1,'{}',9),(172,18,'price_for_half_year','text','Цена за полугодие',0,1,1,1,1,1,'{}',10),(173,18,'price_for_year','text','Цена за год',0,1,1,1,1,1,'{}',11),(174,18,'created_at','timestamp','Создано',0,1,1,1,0,1,'{}',12),(175,18,'updated_at','timestamp','Обновлено',0,0,0,0,0,0,'{}',13),(176,4,'article_belongsto_release_relationship','relationship','Выпуск',0,1,1,1,1,1,'{\"model\":\"App\\\\Release\",\"table\":\"releases\",\"type\":\"belongsTo\",\"column\":\"release_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"article_author\",\"pivot\":\"0\",\"taggable\":\"0\"}',11),(177,4,'article_belongstomany_author_relationship','relationship','Авторы',0,1,1,1,1,1,'{\"model\":\"App\\\\Author\",\"table\":\"authors\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"article_author\",\"pivot\":\"1\",\"taggable\":\"0\"}',12),(178,4,'article_belongstomany_category_relationship','relationship','Категории',0,1,1,1,1,1,'{\"model\":\"App\\\\Category\",\"table\":\"categories\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"article_category\",\"pivot\":\"1\",\"taggable\":\"0\"}',13),(179,7,'jby_promo_belongsto_promo_user_relationship','relationship','Промо-участник',0,1,1,1,1,1,'{\"model\":\"App\\\\PromoUser\",\"table\":\"promo_users\",\"type\":\"belongsTo\",\"column\":\"promo_user_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"article_author\",\"pivot\":\"0\",\"taggable\":\"0\"}',6),(180,7,'jby_promo_belongsto_promocode_relationship','relationship','Промокод',0,1,1,1,1,1,'{\"model\":\"App\\\\Promocode\",\"table\":\"promocodes\",\"type\":\"belongsTo\",\"column\":\"promocode_id\",\"key\":\"id\",\"label\":\"promocode\",\"pivot_table\":\"article_author\",\"pivot\":\"0\",\"taggable\":\"0\"}',7),(181,7,'jby_promo_belongstomany_journal_relationship','relationship','Журналы',0,1,1,1,1,1,'{\"model\":\"App\\\\Journal\",\"table\":\"journals\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"jby_promo_journal\",\"pivot\":\"1\",\"taggable\":\"0\"}',8),(182,8,'journal_belongstomany_category_relationship','relationship','Категории',0,1,1,1,1,1,'{\"model\":\"App\\\\Category\",\"table\":\"categories\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"journal_category\",\"pivot\":\"1\",\"taggable\":\"0\"}',8),(183,8,'journal_belongstomany_publishing_relationship','relationship','Издательства',0,1,1,1,1,1,'{\"model\":\"App\\\\Publishing\",\"table\":\"publishings\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"journal_publishing\",\"pivot\":\"1\",\"taggable\":\"0\"}',7),(184,8,'journal_belongsto_journal_contact_relationship','relationship','Контакты',0,1,1,1,1,1,'{\"model\":\"App\\\\JournalContact\",\"table\":\"journal_contacts\",\"type\":\"belongsTo\",\"column\":\"journal_contact_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"article_author\",\"pivot\":\"0\",\"taggable\":\"0\"}',26),(185,9,'news_belongstomany_publishing_relationship','relationship','Издательства',0,1,1,1,1,1,'{\"model\":\"App\\\\Publishing\",\"table\":\"publishings\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"news_publishing\",\"pivot\":\"1\",\"taggable\":\"0\"}',12),(186,10,'partner_user_belongsto_partner_relationship','relationship','Партнёр',0,1,1,1,1,1,'{\"model\":\"App\\\\Partner\",\"table\":\"partners\",\"type\":\"belongsTo\",\"column\":\"partner_id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"article_author\",\"pivot\":\"0\",\"taggable\":\"0\"}',8),(187,10,'partner_user_belongstomany_quota_relationship','relationship','Использованные квоты',0,1,1,1,1,1,'{\"model\":\"App\\\\Quota\",\"table\":\"quotas\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"partner_user_quota\",\"pivot\":\"1\",\"taggable\":\"0\"}',9),(188,10,'partner_user_belongstomany_release_relationship','relationship','Доступные выпуски',0,1,1,1,1,1,'{\"model\":\"App\\\\Release\",\"table\":\"releases\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"partner_user_release\",\"pivot\":\"1\",\"taggable\":\"0\"}',10),(189,13,'promocode_belongstomany_publishing_relationship','relationship','Издательства',0,1,1,1,1,1,'{\"model\":\"App\\\\Publishing\",\"table\":\"publishings\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"promocode_publishing\",\"pivot\":\"1\",\"taggable\":\"0\"}',14),(190,13,'promocode_belongsto_journal_relationship','relationship','Журнал',0,1,1,1,1,1,'{\"model\":\"App\\\\Journal\",\"table\":\"journals\",\"type\":\"belongsTo\",\"column\":\"journal_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"article_author\",\"pivot\":\"0\",\"taggable\":\"0\"}',15),(191,13,'promocode_belongstomany_release_relationship','relationship','Выпуски',0,1,1,1,1,1,'{\"model\":\"App\\\\Release\",\"table\":\"releases\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"promocode_release\",\"pivot\":\"1\",\"taggable\":\"0\"}',16),(192,13,'promocode_belongsto_journal_relationship_1','relationship','Журнал для выпусков',0,1,1,1,1,1,'{\"model\":\"App\\\\Journal\",\"table\":\"journals\",\"type\":\"belongsTo\",\"column\":\"journal_for_releases_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"article_author\",\"pivot\":\"0\",\"taggable\":\"0\"}',17),(193,13,'promocode_belongstomany_journal_relationship','relationship','Журналы для выбора',0,1,1,1,1,1,'{\"model\":\"App\\\\Journal\",\"table\":\"journals\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"promocode_journal\",\"pivot\":\"1\",\"taggable\":\"0\"}',18),(194,12,'promo_user_belongsto_user_relationship','relationship','Пользователь',0,1,1,1,1,1,'{\"model\":\"App\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"email\",\"pivot_table\":\"article_author\",\"pivot\":\"0\",\"taggable\":\"0\"}',7),(195,12,'promo_user_belongstomany_promocode_relationship','relationship','Использованные промокоды',0,1,1,1,1,1,'{\"model\":\"App\\\\Promocode\",\"table\":\"promocodes\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"promocode\",\"pivot_table\":\"promo_user_promocode\",\"pivot\":\"1\",\"taggable\":\"0\"}',8),(196,12,'promo_user_belongstomany_publishing_relationship','relationship','Издательства',0,1,1,1,1,1,'{\"model\":\"App\\\\Publishing\",\"table\":\"publishings\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"promo_user_publishing\",\"pivot\":\"1\",\"taggable\":\"0\"}',9),(197,12,'promo_user_belongstomany_release_relationship','relationship','Выпуски',0,1,1,1,1,1,'{\"model\":\"App\\\\Release\",\"table\":\"releases\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"promo_user_release\",\"pivot\":\"1\",\"taggable\":\"0\"}',10),(198,17,'release_belongsto_journal_relationship','relationship','Журнал',0,1,1,1,1,1,'{\"model\":\"App\\\\Journal\",\"table\":\"journals\",\"type\":\"belongsTo\",\"column\":\"journal_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"article_author\",\"pivot\":\"0\",\"taggable\":\"0\"}',7),(199,19,'id','text','Id',1,0,0,0,0,0,'{}',1),(200,19,'chief_editor','text','Главный редактор',0,1,1,1,1,1,'{}',2),(201,19,'phone','text','Телефон',0,1,1,1,1,1,'{}',3),(202,19,'email','text','Email',0,1,1,1,1,1,'{}',4),(203,19,'site','text','Сайт',0,1,1,1,1,1,'{}',5),(204,19,'about_editor','markdown_editor','О редакторе',0,1,1,1,1,1,'{}',6),(205,19,'contacts','markdown_editor','Контакты',0,1,1,1,1,1,'{}',7),(206,19,'created_at','timestamp','Создано',0,1,1,1,0,1,'{}',8),(207,19,'updated_at','timestamp','Обновлено',0,0,0,0,0,0,'{}',9),(208,20,'id','text','Id',1,0,0,0,0,0,'{}',1),(209,20,'phys_user_id','text','Phys User Id',0,1,1,1,1,1,'{}',3),(210,20,'legal_user_id','text','Legal User Id',0,1,1,1,1,1,'{}',4),(211,20,'paysystem_id','text','Paysystem Id',1,1,1,1,1,1,'{}',2),(212,20,'created_at','timestamp','Created At',0,1,1,1,0,1,'{}',5),(213,20,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'{}',6),(214,20,'status','select_dropdown','Статус заказа',1,1,1,1,1,1,'{\"default\":\"wait\",\"options\":{\"wait\":\"\\u041e\\u0436\\u0438\\u0434\\u0430\\u0435\\u0442 \\u043e\\u043f\\u043b\\u0430\\u0442\\u044b\",\"payed\":\"\\u041e\\u043f\\u043b\\u0430\\u0447\\u0435\\u043d\",\"cancelled\":\"\\u041e\\u0442\\u043c\\u0435\\u043d\\u0435\\u043d\",\"completed\":\"\\u0412\\u044b\\u043f\\u043e\\u043b\\u043d\\u0435\\u043d\"}}',7),(215,20,'totalPrice','text','К оплате',0,1,1,1,1,1,'{}',8),(216,20,'orderList','text','Состав заказа',0,0,1,0,0,0,'{}',9),(217,20,'payed','text','Оплачено',0,1,1,1,1,1,'{}',10),(218,20,'left_to_pay','text','Осталось оплатить',0,1,1,1,1,1,'{}',11),(219,20,'order_hasmany_order_story_relationship','relationship','История заказa',0,0,1,1,1,1,'{\"model\":\"App\\\\OrderStory\",\"table\":\"order_story\",\"type\":\"hasMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"id\",\"pivot_table\":\"article_author\",\"pivot\":\"0\",\"taggable\":\"0\"}',12),(220,20,'order_belongsto_order_legal_user_relationship','relationship','Физическое лицо',0,0,1,1,1,1,'{\"model\":\"App\\\\OrderPhysUser\",\"table\":\"order_phys_users\",\"type\":\"belongsTo\",\"column\":\"phys_user_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"article_author\",\"pivot\":\"0\",\"taggable\":\"0\"}',13),(221,20,'order_belongsto_order_phys_user_relationship','relationship','Юридическое лицо',0,0,1,1,1,1,'{\"model\":\"App\\\\OrderLegalUser\",\"table\":\"order_legal_users\",\"type\":\"belongsTo\",\"column\":\"legal_user_id\",\"key\":\"id\",\"label\":\"org_name\",\"pivot_table\":\"article_author\",\"pivot\":\"0\",\"taggable\":\"0\"}',14),(222,20,'order_belongsto_paysystem_relationship','relationship','Платежная система',0,0,1,1,1,1,'{\"model\":\"App\\\\Paysystem\",\"table\":\"paysystems\",\"type\":\"belongsTo\",\"column\":\"paysystem_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"article_author\",\"pivot\":\"0\",\"taggable\":\"0\"}',15),(223,21,'id','text','Id',1,0,0,0,0,0,'{}',1),(224,21,'org_name','text','Название организации',1,1,1,1,1,1,'{}',2),(225,21,'legal_address','text','Физический адрес',0,1,1,1,1,1,'{}',3),(226,21,'INN','text','ИНН',0,1,1,1,1,1,'{}',4),(227,21,'KPP','text','КПП',0,1,1,1,1,1,'{}',5),(228,21,'l_name','text','Имя ответственного лица',0,1,1,1,1,1,'{}',6),(229,21,'l_surname','text','Фамилия ответственного лица',0,1,1,1,1,1,'{}',7),(230,21,'l_patronymic','text','Отчество ответственного лица',0,1,1,1,1,1,'{}',8),(231,21,'l_email','text','Email',0,1,1,1,1,1,'{}',9),(232,21,'l_delivery_address','text','Адрес доставки',0,1,1,1,1,1,'{}',11),(233,21,'user_id','text','User Id',0,1,1,1,1,1,'{}',12),(234,21,'created_at','timestamp','Создано',0,1,1,1,0,1,'{}',13),(235,21,'updated_at','timestamp','Обновлено',0,0,0,0,0,0,'{}',14),(236,23,'id','text','Id',1,0,0,0,0,0,'{}',1),(237,23,'name','text','Имя',1,1,1,1,1,1,'{}',2),(238,23,'surname','text','Фамилия',0,1,1,1,1,1,'{}',3),(239,23,'patronymic','text','Отчество',0,1,1,1,1,1,'{}',4),(240,23,'phone','text','Телефон',0,1,1,1,1,1,'{}',5),(241,23,'email','text','Email',0,1,1,1,1,1,'{}',6),(242,23,'delivery_address','text','Адрес доставки',0,1,1,1,1,1,'{}',7),(243,23,'user_id','text','User Id',0,1,1,1,1,1,'{}',8),(244,23,'created_at','timestamp','Создано',0,1,1,1,0,1,'{}',9),(245,23,'updated_at','timestamp','Обновлено',0,0,0,0,0,0,'{}',10),(246,21,'l_phone','text','Телефон',0,1,1,1,1,1,'{}',10),(247,24,'id','text','Id',1,0,0,0,0,0,'{}',1),(248,24,'name','text','Название',1,1,1,1,1,1,'{}',2),(249,24,'code','text','Символьный код',1,1,1,1,1,1,'{}',3),(250,24,'created_at','timestamp','Создано',0,0,0,0,0,0,'{}',4),(251,24,'updated_at','timestamp','Обновлено',0,0,0,0,0,0,'{}',5),(255,25,'id','text','Id',1,0,0,0,0,0,'{}',1),(256,25,'name','text','Название',1,1,1,1,1,1,'{}',2),(257,25,'value','text','Значение',0,1,1,1,1,1,'{}',3),(258,25,'paysystem_id','text','Paysystem Id',1,1,1,1,1,1,'{}',4),(259,25,'created_at','timestamp','Created At',0,1,1,1,0,1,'{}',5),(260,25,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'{}',6),(261,24,'paysystem_hasmany_paysystem_datum_relationship','relationship','paysystem_data',0,1,1,1,1,1,'{\"model\":\"App\\\\PaysystemData\",\"table\":\"paysystem_data\",\"type\":\"hasMany\",\"column\":\"paysystem_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"article_author\",\"pivot\":\"0\",\"taggable\":null}',6),(262,25,'code','text','Code',1,1,1,0,1,0,'{}',3),(263,25,'type','text','Type',1,1,1,1,1,1,'{}',5);
/*!40000 ALTER TABLE `data_rows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_types`
--

DROP TABLE IF EXISTS `data_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_singular` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_plural` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generate_permissions` tinyint(1) NOT NULL DEFAULT '0',
  `server_side` tinyint(4) NOT NULL DEFAULT '0',
  `details` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `data_types_name_unique` (`name`),
  UNIQUE KEY `data_types_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_types`
--

LOCK TABLES `data_types` WRITE;
/*!40000 ALTER TABLE `data_types` DISABLE KEYS */;
INSERT INTO `data_types` VALUES (1,'users','users','User','Users','voyager-person','TCG\\Voyager\\Models\\User','TCG\\Voyager\\Policies\\UserPolicy','','',1,0,NULL,'2018-11-23 10:46:12','2018-11-23 10:46:12'),(2,'menus','menus','Menu','Menus','voyager-list','TCG\\Voyager\\Models\\Menu',NULL,'','',1,0,NULL,'2018-11-23 10:46:12','2018-11-23 10:46:12'),(3,'roles','roles','Role','Roles','voyager-lock','TCG\\Voyager\\Models\\Role',NULL,'','',1,0,NULL,'2018-11-23 10:46:12','2018-11-23 10:46:12'),(4,'articles','articles','Статья','Статьи','voyager-character','App\\Article','App\\Policies\\ReviewPolicy',NULL,NULL,0,1,'{\"order_column\":null,\"order_display_column\":null}','2018-11-27 02:09:20','2018-11-27 05:45:14'),(5,'authors','authors','Автор','Авторы','voyager-people','App\\Author','App\\Policies\\ReviewPolicy',NULL,NULL,0,1,'{\"order_column\":null,\"order_display_column\":null}','2018-11-27 02:11:14','2018-11-27 05:51:55'),(6,'categories','categories','Категория','Категории','voyager-categories','App\\Category','App\\Policies\\ReviewPolicy',NULL,NULL,0,1,'{\"order_column\":null,\"order_display_column\":null}','2018-11-27 02:12:10','2018-11-27 05:52:10'),(7,'jby_promo','jby-promo','Выбранный журнал по промокоду','Выбранные журналы по промокоду','voyager-logbook','App\\JbyPromo','App\\Policies\\ReviewPolicy',NULL,NULL,0,0,'{\"order_column\":null,\"order_display_column\":null}','2018-11-27 02:13:59','2018-11-27 03:04:17'),(8,'journals','journals','Журнал','Журналы','voyager-logbook','App\\Journal','App\\Policies\\ReviewPolicy',NULL,NULL,0,1,'{\"order_column\":null,\"order_display_column\":null}','2018-11-27 02:18:41','2018-11-27 05:52:42'),(9,'news','news','Новость','Новости','voyager-news','App\\News','App\\Policies\\ReviewPolicy',NULL,NULL,0,1,'{\"order_column\":null,\"order_display_column\":null}','2018-11-27 02:20:45','2018-11-27 05:52:54'),(10,'partner_users','partner-users','Пользователь (партнёра)','Пользователи (партнёров)','voyager-people','App\\PartnerUser','App\\Policies\\ReviewPolicy',NULL,NULL,0,0,'{\"order_column\":null,\"order_display_column\":null}','2018-11-27 02:22:11','2018-11-27 03:22:32'),(11,'partners','partners','Партнер','Партнеры','voyager-thumbs-up','App\\Partner','App\\Policies\\ReviewPolicy',NULL,NULL,0,0,'{\"order_column\":null,\"order_display_column\":null}','2018-11-27 02:23:22','2018-11-27 02:23:22'),(12,'promo_users','promo-users','Промо-участник','Промо-участники','voyager-ship','App\\PromoUser','App\\Policies\\ReviewPolicy',NULL,NULL,0,0,'{\"order_column\":null,\"order_display_column\":null}','2018-11-27 02:24:40','2018-11-27 03:45:21'),(13,'promocodes','promocodes','Промокод','Промокоды','voyager-key','App\\Promocode','App\\Policies\\ReviewPolicy',NULL,NULL,0,0,'{\"order_column\":null,\"order_display_column\":null}','2018-11-27 02:35:31','2018-11-27 03:28:08'),(14,'publishings','publishings','Publishing','Publishings','voyager-shop','App\\Publishing','App\\Policies\\ReviewPolicy',NULL,NULL,0,1,'{\"order_column\":null,\"order_display_column\":null}','2018-11-27 02:38:04','2018-11-27 05:53:13'),(15,'quotas','quotas','Квота','Квоты',NULL,'App\\Quota','App\\Policies\\ReviewPolicy',NULL,NULL,0,0,'{\"order_column\":null,\"order_display_column\":null}','2018-11-27 02:39:28','2018-11-27 02:39:28'),(17,'releases','releases','Выпуск','Выпуски','voyager-list-add','App\\Release','App\\Policies\\ReviewPolicy',NULL,NULL,0,1,'{\"order_column\":null,\"order_display_column\":null}','2018-11-27 02:42:55','2018-11-27 05:53:24'),(18,'subscriptions','subscriptions','Подписка','Подписки','voyager-thumb-tack','App\\Subscription','App\\Policies\\ReviewPolicy',NULL,NULL,0,0,'{\"order_column\":null,\"order_display_column\":null}','2018-11-27 02:49:58','2018-11-27 02:49:58'),(19,'journal_contacts','journal-contacts','Контакты журнала','Контакты журналов','voyager-megaphone','App\\JournalContact','App\\Policies\\ReviewPolicy',NULL,NULL,0,1,'{\"order_column\":null,\"order_display_column\":null}','2018-11-27 03:58:49','2018-11-27 05:52:26'),(20,'orders','orders','Заказ','Заказы','voyager-trophy','App\\Order','App\\Policies\\ReviewPolicy','\\App\\Http\\Controllers\\Admin\\VoyagerOrdersController',NULL,0,0,'{\"order_column\":null,\"order_display_column\":null}','2018-12-06 08:38:09','2018-12-07 06:34:31'),(21,'order_legal_users','order-legal-users','Юридическое лицо','Юридические лица','voyager-people','App\\OrderLegalUser','App\\Policies\\ReviewPolicy',NULL,NULL,0,0,'{\"order_column\":null,\"order_display_column\":null}','2018-12-07 02:55:57','2018-12-07 03:05:36'),(23,'order_phys_users','order-phys-users','Физическое лицо','Физические лица','voyager-people','App\\OrderPhysUser','App\\Policies\\ReviewPolicy',NULL,NULL,0,0,'{\"order_column\":null,\"order_display_column\":null}','2018-12-07 02:58:36','2018-12-07 02:58:36'),(24,'paysystems','paysystems','Платёжная система','Платёжные системы','voyager-buy','App\\Paysystem','App\\Policies\\ReviewPolicy','\\App\\Http\\Controllers\\Admin\\VoyagerPaysystemsController',NULL,0,0,'{\"order_column\":null,\"order_display_column\":null}','2018-12-07 03:12:13','2018-12-13 10:37:00'),(25,'paysystem_data','paysystem-data','Данные платёжной системы','Данные платёжных систем',NULL,'App\\PaysystemData','App\\Policies\\ReviewPolicy',NULL,NULL,0,0,'{\"order_column\":null,\"order_display_column\":null}','2018-12-13 10:43:12','2018-12-17 07:22:19');
/*!40000 ALTER TABLE `data_types` ENABLE KEYS */;
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
  CONSTRAINT `jby_promo_promo_user_id_foreign` FOREIGN KEY (`promo_user_id`) REFERENCES `promo_users` (`id`),
  CONSTRAINT `jby_promo_promocode_id_foreign` FOREIGN KEY (`promocode_id`) REFERENCES `promocodes` (`id`)
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
  CONSTRAINT `jby_promo_journal_jby_promo_id_foreign` FOREIGN KEY (`jby_promo_id`) REFERENCES `jby_promo` (`id`),
  CONSTRAINT `jby_promo_journal_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`)
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
-- Table structure for table `journal_contacts`
--

DROP TABLE IF EXISTS `journal_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chief_editor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about_editor` text COLLATE utf8mb4_unicode_ci,
  `contacts` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_contacts`
--

LOCK TABLES `journal_contacts` WRITE;
/*!40000 ALTER TABLE `journal_contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `journal_contacts` ENABLE KEYS */;
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
-- Table structure for table `journals`
--

DROP TABLE IF EXISTS `journals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ru',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `active_date` datetime DEFAULT NULL,
  `ISSN` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `journal_contact_id` int(10) unsigned DEFAULT NULL,
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `journals_journal_contact_id_foreign` (`journal_contact_id`),
  CONSTRAINT `journals_journal_contact_id_foreign` FOREIGN KEY (`journal_contact_id`) REFERENCES `journal_contacts` (`id`)
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
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `menu_items_menu_id_foreign` (`menu_id`),
  CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES (1,1,'Dashboard','','_self','voyager-boat',NULL,NULL,1,'2018-11-23 10:46:13','2018-11-23 10:46:13','voyager.dashboard',NULL),(2,1,'Media','','_self','voyager-images',NULL,NULL,9,'2018-11-23 10:46:13','2018-12-06 10:17:38','voyager.media.index',NULL),(3,1,'Users','','_self','voyager-person',NULL,NULL,8,'2018-11-23 10:46:13','2018-12-06 10:17:38','voyager.users.index',NULL),(4,1,'Roles','','_self','voyager-lock',NULL,NULL,7,'2018-11-23 10:46:13','2018-12-06 10:17:38','voyager.roles.index',NULL),(5,1,'Tools','','_self','voyager-tools',NULL,NULL,10,'2018-11-23 10:46:13','2018-12-06 10:17:38',NULL,NULL),(6,1,'Menu Builder','','_self','voyager-list',NULL,5,1,'2018-11-23 10:46:13','2018-11-27 03:55:52','voyager.menus.index',NULL),(7,1,'Database','','_self','voyager-data',NULL,5,2,'2018-11-23 10:46:13','2018-11-27 03:55:52','voyager.database.index',NULL),(8,1,'Compass','','_self','voyager-compass',NULL,5,3,'2018-11-23 10:46:13','2018-11-27 04:07:23','voyager.compass.index',NULL),(9,1,'BREAD','','_self','voyager-bread',NULL,5,4,'2018-11-23 10:46:13','2018-11-27 04:07:23','voyager.bread.index',NULL),(10,1,'Settings','','_self','voyager-settings',NULL,NULL,11,'2018-11-23 10:46:13','2018-12-06 10:17:39','voyager.settings.index',NULL),(11,1,'Hooks','','_self','voyager-hook',NULL,5,5,'2018-11-23 10:46:17','2018-11-27 04:07:23','voyager.hooks',NULL),(12,1,'Статьи','','_self','voyager-character',NULL,26,7,'2018-11-27 02:09:21','2018-12-06 10:17:38','voyager.articles.index',NULL),(13,1,'Авторы','','_self','voyager-people',NULL,26,3,'2018-11-27 02:11:15','2018-12-06 10:17:38','voyager.authors.index',NULL),(14,1,'Категории','','_self','voyager-categories',NULL,26,1,'2018-11-27 02:12:10','2018-11-27 03:59:06','voyager.categories.index',NULL),(15,1,'Выбранные журналы по промокоду','','_self','voyager-logbook',NULL,28,3,'2018-11-27 02:14:00','2018-12-06 10:17:34','voyager.jby-promo.index',NULL),(16,1,'Журналы','','_self','voyager-logbook',NULL,26,4,'2018-11-27 02:18:42','2018-12-06 10:17:38','voyager.journals.index',NULL),(17,1,'Новости','','_self','voyager-news',NULL,26,8,'2018-11-27 02:20:45','2018-12-06 10:17:38','voyager.news.index',NULL),(18,1,'Пользователи (партнёров)','','_self','voyager-people',NULL,29,3,'2018-11-27 02:22:11','2018-12-06 10:17:33','voyager.partner-users.index',NULL),(19,1,'Партнеры','','_self','voyager-thumbs-up',NULL,29,1,'2018-11-27 02:23:22','2018-12-06 10:17:32','voyager.partners.index',NULL),(20,1,'Промо-участники','','_self','voyager-ship',NULL,28,2,'2018-11-27 02:24:40','2018-12-06 10:17:34','voyager.promo-users.index',NULL),(21,1,'Промокоды','','_self','voyager-key',NULL,28,1,'2018-11-27 02:35:32','2018-11-27 04:04:36','voyager.promocodes.index',NULL),(22,1,'Издательства','','_self','voyager-shop','#000000',26,2,'2018-11-27 02:38:04','2018-11-27 04:01:28','voyager.publishings.index','null'),(23,1,'Квоты','','_self',NULL,NULL,29,2,'2018-11-27 02:39:28','2018-12-06 10:17:33','voyager.quotas.index',NULL),(24,1,'Выпуски','','_self','voyager-list-add',NULL,26,6,'2018-11-27 02:42:55','2018-12-06 10:17:38','voyager.releases.index',NULL),(25,1,'Подписки','','_self','voyager-thumb-tack',NULL,NULL,4,'2018-11-27 02:49:58','2018-12-06 10:17:38','voyager.subscriptions.index',NULL),(26,1,'Контент','','_self','voyager-treasure','#000000',NULL,3,'2018-11-27 03:55:44','2018-12-06 10:17:38',NULL,''),(27,1,'Контакты журналов','','_self','voyager-megaphone',NULL,26,5,'2018-11-27 03:58:49','2018-12-06 10:17:38','voyager.journal-contacts.index',NULL),(28,1,'Промокоды','','_self','voyager-key','#000000',NULL,5,'2018-11-27 04:04:24','2018-12-06 10:17:38',NULL,''),(29,1,'Партнёрка','','_self','voyager-ship','#000000',NULL,6,'2018-11-27 04:06:04','2018-12-06 10:17:38',NULL,''),(30,1,'Заказы','','_self','voyager-trophy','#000000',NULL,2,'2018-12-06 08:38:09','2018-12-06 10:17:38','voyager.orders.index','null'),(31,1,'Платежные системы','','_self','voyager-dollar','#000000',NULL,12,'2018-12-13 05:45:49','2018-12-13 05:45:49','voyager.paysystems.index',NULL),(32,1,'Данные платёжных систем','','_self',NULL,NULL,NULL,13,'2018-12-13 10:43:13','2018-12-13 10:43:13','voyager.paysystem-data.index',NULL);
/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menus_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,'admin','2018-11-23 10:46:13','2018-11-23 10:46:13');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2016_01_01_000000_add_voyager_user_fields',1),(4,'2016_01_01_000000_create_data_types_table',1),(5,'2016_05_19_173453_create_menu_table',1),(6,'2016_10_21_190000_create_roles_table',1),(7,'2016_10_21_190000_create_settings_table',1),(8,'2016_11_30_135954_create_permission_table',1),(9,'2016_11_30_141208_create_permission_role_table',1),(10,'2016_12_26_201236_data_types__add__server_side',1),(11,'2017_01_13_000000_add_route_to_menu_items_table',1),(12,'2017_01_14_005015_create_translations_table',1),(13,'2017_01_15_000000_make_table_name_nullable_in_permissions_table',1),(14,'2017_03_06_000000_add_controller_to_data_types_table',1),(15,'2017_04_21_000000_add_order_to_data_rows_table',1),(16,'2017_07_05_210000_add_policyname_to_data_types_table',1),(17,'2017_08_05_000000_add_group_to_settings_table',1),(18,'2017_11_26_013050_add_user_role_relationship',1),(19,'2017_11_26_015000_create_user_roles_table',1),(20,'2018_03_11_000000_add_user_settings',1),(21,'2018_03_14_000000_add_details_to_data_types_table',1),(22,'2018_03_16_000000_make_settings_value_nullable',1),(23,'2018_11_20_052159_create_journal_table',1),(24,'2018_11_20_062249_create_journal_contact_table',1),(25,'2018_11_20_065428_create_category_table',1),(26,'2018_11_20_070043_create_publishing_table',1),(27,'2018_11_20_072012_add_foreign_keys_to_tables',1),(28,'2018_11_20_074136_create_author_table',1),(29,'2018_11_20_075409_create_release_table',1),(30,'2018_11_20_082717_create_article_table',1),(31,'2018_11_20_093408_create_subscription_table',1),(32,'2018_11_20_111144_create_partner_table',1),(33,'2018_11_20_111334_create_quota_table',1),(34,'2018_11_20_112058_create_partner_user_table',1),(35,'2018_11_20_113457_create_promocode_table',1),(36,'2018_11_20_121504_create_promo_user_table',1),(37,'2018_11_20_122122_create_journals_by_promo_table',1),(38,'2018_11_20_122803_create_news_table',1),(39,'2018_12_05_075451_create_paysystems_table',2),(40,'2018_12_05_075633_create_order_phys_users_table',2),(41,'2018_12_05_075653_create_order_enity_users_table',2),(42,'2018_12_05_075708_create_orders_table',2),(43,'2018_12_06_122444_create_order_story_table',3),(50,'2018_12_13_131156_create_paysystem_data_table',4),(51,'2018_12_14_083626_add_logo_field_to_paysystems_table',5),(52,'2018_12_14_103022_add_description_field_to_paysystems_table',6),(53,'2018_12_19_094112_add_publication_date_field_to_articles_table',7),(54,'2018_12_20_075936_rename_publication_date_articles_table',8);
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `publishing_date` datetime DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview` text COLLATE utf8mb4_unicode_ci,
  `preview_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `user_id` int(10) unsigned DEFAULT NULL,
  `l_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('wait','payed','cancelled','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'wait',
  `totalPrice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orderList` json DEFAULT NULL,
  `payed` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `left_to_pay` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  CONSTRAINT `partner_user_release_p_user_id_foreign` FOREIGN KEY (`p_user_id`) REFERENCES `partner_users` (`id`),
  CONSTRAINT `partner_user_release_release_id_foreign` FOREIGN KEY (`release_id`) REFERENCES `releases` (`id`)
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paysystem_data`
--

LOCK TABLES `paysystem_data` WRITE;
/*!40000 ALTER TABLE `paysystem_data` DISABLE KEYS */;
INSERT INTO `paysystem_data` VALUES (1,'Логин магазина','shop_login','panoramademo','string',1,NULL,NULL),(2,'Пароль магазина','shop_pass','RA8ro6ZM5BII0Xd0ZKPx','string',1,NULL,NULL),(3,'Пароль магазина №2','shop_pass2','IPjKSlY1cUnkhw0y96l8','string',1,NULL,NULL),(4,'Банковские реквизиты','requisites','044525593','string',2,NULL,NULL),(5,'Номер кор./сч. банка получателя платежа','invoice_bank_num','30101810200000000593','string',2,NULL,NULL),(6,'Наименование банка','bank_name','АО \"АЛЬФА-БАНК\" Г. МОСКВА','string',2,NULL,NULL),(7,'Номер счета получателя платежа','invoice_num','40702810601600002598','string',2,NULL,NULL),(8,'КПП получателя платежа','KPP','772901001','string',2,NULL,NULL),(9,'ИНН получателя платежа','INN','7729601370','string',2,NULL,NULL),(10,'Наименование получателя платежа','uname','ООО Издательский Дом \"ПАНОРАМА\"','string',2,NULL,NULL),(11,'Подпись генерального директора','CEO_signature','/storage/paysystem_invoice/ceo_sign.png','file',3,NULL,NULL),(12,'Должность бухгалтера','accountant_position','Главный бухгалтер','string',3,NULL,NULL),(13,'Корреспондентский счет','correspondent_account','30101810200000000593','string',3,NULL,NULL),(14,'БИК компании-поставщика','BIC','044525593','string',3,NULL,NULL),(15,'Должность руководителя','manager_position','Генеральный директор','string',3,NULL,NULL),(16,'Печать','stamp','/storage/paysystem_invoice/stamp.png','file',3,NULL,NULL),(17,'Подпись главного бухгалтера','chief_accountant_sign','/storage/paysystem_invoice/chief_accountant_sign.png','file',3,NULL,NULL),(18,'Город банка','bank_city','г. Москва','string',3,NULL,NULL),(19,'ФИО руководителя','manager_full_name','Москаленко К.А.','string',3,NULL,NULL),(20,'ФИО бухгалтера','accountant_full_name','Москаленко Л.В.','string',3,NULL,NULL),(21,'Телефон компании-поставщика','phone','(495) 664-27-09','string',3,NULL,NULL),(22,'Комментарий к счету 1','comment1','В случае непоступления средств на расчетный счет продавца в течение пяти банковских дней со дня выписки счета, продавец оставляет за собой право пересмотреть отпускную цену товара в рублях пропорционально изменению курса доллара и выставить счет на доплату. В платежном поручении обязательно указать номер и дату выставления счета. Получение товара только после прихода денег на расчетный счет компании.','string',3,NULL,NULL),(23,'КПП компании-поставщика','KPP','772901001','string',3,NULL,NULL),(24,'ИНН компании-поставщика','INN','7729601370','string',3,NULL,NULL),(25,'Банк поставщика','supplier_bank','АО \"АЛЬФА-БАНК\"','string',3,NULL,NULL),(26,'Адрес компании-поставщика','supplier_address','119602, Москва г, Академика Анохина ул, дом № 34, корпус 2, кв.366','string',3,NULL,NULL),(27,'Название компании-поставщика','supplier_name','Общество с ограниченной ответственностью Издательский Дом \"ПАНОРАМА\"','string',3,NULL,NULL),(28,'Расчетный счет компании-поставщика','supplier_current_account','40702810601600002598','string',3,NULL,NULL);
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
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paysystems`
--

LOCK TABLES `paysystems` WRITE;
/*!40000 ALTER TABLE `paysystems` DISABLE KEYS */;
INSERT INTO `paysystems` VALUES (1,'Электронный перевод (ROBOKASSA)','robokassa','/storage/paysystem_logo/robokassa.jpg',NULL,NULL,'2018-12-14 05:53:53'),(2,'Через Сбербанк','sberbank','/storage/paysystem_logo/sberbank.jpg',NULL,NULL,'2018-12-14 05:53:53'),(3,'Счет','invoice','/storage/paysystem_logo/invoice.png',NULL,NULL,'2018-12-14 05:53:53');
/*!40000 ALTER TABLE `paysystems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_permission_id_index` (`permission_id`),
  KEY `permission_role_role_id_index` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permissions_key_index` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'browse_admin',NULL,'2018-11-23 10:46:14','2018-11-23 10:46:14'),(2,'browse_bread',NULL,'2018-11-23 10:46:14','2018-11-23 10:46:14'),(3,'browse_database',NULL,'2018-11-23 10:46:14','2018-11-23 10:46:14'),(4,'browse_media',NULL,'2018-11-23 10:46:14','2018-11-23 10:46:14'),(5,'browse_compass',NULL,'2018-11-23 10:46:14','2018-11-23 10:46:14'),(6,'browse_menus','menus','2018-11-23 10:46:14','2018-11-23 10:46:14'),(7,'read_menus','menus','2018-11-23 10:46:14','2018-11-23 10:46:14'),(8,'edit_menus','menus','2018-11-23 10:46:14','2018-11-23 10:46:14'),(9,'add_menus','menus','2018-11-23 10:46:14','2018-11-23 10:46:14'),(10,'delete_menus','menus','2018-11-23 10:46:14','2018-11-23 10:46:14'),(11,'browse_roles','roles','2018-11-23 10:46:14','2018-11-23 10:46:14'),(12,'read_roles','roles','2018-11-23 10:46:14','2018-11-23 10:46:14'),(13,'edit_roles','roles','2018-11-23 10:46:14','2018-11-23 10:46:14'),(14,'add_roles','roles','2018-11-23 10:46:14','2018-11-23 10:46:14'),(15,'delete_roles','roles','2018-11-23 10:46:15','2018-11-23 10:46:15'),(16,'browse_users','users','2018-11-23 10:46:15','2018-11-23 10:46:15'),(17,'read_users','users','2018-11-23 10:46:15','2018-11-23 10:46:15'),(18,'edit_users','users','2018-11-23 10:46:15','2018-11-23 10:46:15'),(19,'add_users','users','2018-11-23 10:46:15','2018-11-23 10:46:15'),(20,'delete_users','users','2018-11-23 10:46:15','2018-11-23 10:46:15'),(21,'browse_settings','settings','2018-11-23 10:46:15','2018-11-23 10:46:15'),(22,'read_settings','settings','2018-11-23 10:46:15','2018-11-23 10:46:15'),(23,'edit_settings','settings','2018-11-23 10:46:15','2018-11-23 10:46:15'),(24,'add_settings','settings','2018-11-23 10:46:15','2018-11-23 10:46:15'),(25,'delete_settings','settings','2018-11-23 10:46:15','2018-11-23 10:46:15'),(26,'browse_hooks',NULL,'2018-11-23 10:46:18','2018-11-23 10:46:18');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
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
  CONSTRAINT `promo_user_promocode_promo_user_id_foreign` FOREIGN KEY (`promo_user_id`) REFERENCES `promo_users` (`id`),
  CONSTRAINT `promo_user_promocode_promocode_id_foreign` FOREIGN KEY (`promocode_id`) REFERENCES `promocodes` (`id`)
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
  CONSTRAINT `promo_user_publishing_promo_user_id_foreign` FOREIGN KEY (`promo_user_id`) REFERENCES `promo_users` (`id`),
  CONSTRAINT `promo_user_publishing_publishing_id_foreign` FOREIGN KEY (`publishing_id`) REFERENCES `publishings` (`id`)
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
  CONSTRAINT `promo_user_release_promo_user_id_foreign` FOREIGN KEY (`promo_user_id`) REFERENCES `promo_users` (`id`),
  CONSTRAINT `promo_user_release_release_id_foreign` FOREIGN KEY (`release_id`) REFERENCES `releases` (`id`)
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
  CONSTRAINT `promocode_journal_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`),
  CONSTRAINT `promocode_journal_promocode_id_foreign` FOREIGN KEY (`promocode_id`) REFERENCES `promocodes` (`id`)
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
  CONSTRAINT `promocode_publishing_promocode_id_foreign` FOREIGN KEY (`promocode_id`) REFERENCES `promocodes` (`id`),
  CONSTRAINT `promocode_publishing_publishing_id_foreign` FOREIGN KEY (`publishing_id`) REFERENCES `publishings` (`id`)
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
  CONSTRAINT `promocode_release_promocode_id_foreign` FOREIGN KEY (`promocode_id`) REFERENCES `promocodes` (`id`),
  CONSTRAINT `promocode_release_release_id_foreign` FOREIGN KEY (`release_id`) REFERENCES `releases` (`id`)
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
  CONSTRAINT `promocodes_journal_for_releases_id_foreign` FOREIGN KEY (`journal_for_releases_id`) REFERENCES `journals` (`id`),
  CONSTRAINT `promocodes_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`)
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
-- Table structure for table `publishings`
--

DROP TABLE IF EXISTS `publishings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publishings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
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
  CONSTRAINT `quotas_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`),
  CONSTRAINT `quotas_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`),
  CONSTRAINT `quotas_release_id_foreign` FOREIGN KEY (`release_id`) REFERENCES `releases` (`id`)
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
-- Table structure for table `releases`
--

DROP TABLE IF EXISTS `releases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `releases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `active_date` datetime DEFAULT NULL,
  `journal_id` int(10) unsigned NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_for_printed` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_for_electronic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `promo` tinyint(1) DEFAULT NULL COMMENT 'Is release available for free',
  `price_for_articles` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `preview_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview_description` text COLLATE utf8mb4_unicode_ci,
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
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','Administrator','2018-11-23 10:45:30','2018-11-23 10:45:30'),(2,'user','Normal User','2018-11-23 10:46:13','2018-11-23 10:46:13');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `details` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'site.title','Site Title','Site Title','','text',1,'Site'),(2,'site.description','Site Description','Site Description','','text',2,'Site'),(3,'site.logo','Site Logo','','','image',3,'Site'),(4,'site.google_analytics_tracking_id','Google Analytics Tracking ID','','','text',4,'Site'),(5,'admin.bg_image','Admin Background Image','','','image',5,'Admin'),(6,'admin.title','Admin Title','Voyager','','text',1,'Admin'),(7,'admin.description','Admin Description','Welcome to Voyager. The Missing Admin for Laravel','','text',2,'Admin'),(8,'admin.loader','Admin Loader','','','image',3,'Admin'),(9,'admin.icon_image','Admin Icon Image','','','image',4,'Admin'),(10,'admin.google_analytics_client_id','Google Analytics Client ID (used for admin dashboard)','','','text',1,'Admin');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
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
  `price_for_release` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_for_half_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_for_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_journal_id_foreign` (`journal_id`),
  KEY `subscriptions_locale_index` (`locale`),
  CONSTRAINT `subscriptions_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`)
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
-- Table structure for table `translations`
--

DROP TABLE IF EXISTS `translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_key` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `translations_table_name_column_name_foreign_key_locale_unique` (`table_name`,`column_name`,`foreign_key`,`locale`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translations`
--

LOCK TABLES `translations` WRITE;
/*!40000 ALTER TABLE `translations` DISABLE KEYS */;
INSERT INTO `translations` VALUES (1,'data_types','display_name_singular',4,'en','Статья','2018-11-27 03:00:01','2018-11-27 03:00:01'),(2,'data_types','display_name_plural',4,'en','Статьи','2018-11-27 03:00:01','2018-11-27 03:00:01'),(3,'data_types','display_name_singular',7,'en','Выбранный журнал по промокоду','2018-11-27 03:04:17','2018-11-27 03:04:17'),(4,'data_types','display_name_plural',7,'en','Выбранные журналы по промокоду','2018-11-27 03:04:17','2018-11-27 03:04:17'),(5,'data_types','display_name_singular',8,'en','Журнал','2018-11-27 03:17:26','2018-11-27 03:17:26'),(6,'data_types','display_name_plural',8,'en','Журналы','2018-11-27 03:17:26','2018-11-27 03:17:26'),(7,'data_types','display_name_singular',9,'en','Новость','2018-11-27 03:18:46','2018-11-27 03:18:46'),(8,'data_types','display_name_plural',9,'en','Новости','2018-11-27 03:18:46','2018-11-27 03:18:46'),(9,'data_types','display_name_singular',10,'en','Пользователь (партнёра)','2018-11-27 03:22:32','2018-11-27 03:22:32'),(10,'data_types','display_name_plural',10,'en','Пользователи (партнёров)','2018-11-27 03:22:33','2018-11-27 03:22:33'),(11,'data_types','display_name_singular',13,'en','Промокод','2018-11-27 03:28:08','2018-11-27 03:28:08'),(12,'data_types','display_name_plural',13,'en','Промокоды','2018-11-27 03:28:08','2018-11-27 03:28:08'),(13,'data_types','display_name_singular',12,'en','Промо-участник','2018-11-27 03:45:21','2018-11-27 03:45:21'),(14,'data_types','display_name_plural',12,'en','Промо-участники','2018-11-27 03:45:21','2018-11-27 03:45:21'),(15,'data_types','display_name_singular',17,'en','Выпуск','2018-11-27 03:54:48','2018-11-27 03:54:48'),(16,'data_types','display_name_plural',17,'en','Выпуски','2018-11-27 03:54:48','2018-11-27 03:54:48'),(17,'menu_items','title',26,'en','Контент','2018-11-27 03:55:45','2018-11-27 04:03:15'),(18,'menu_items','title',22,'en','Издательства','2018-11-27 03:59:21','2018-11-27 03:59:21'),(19,'menu_items','title',28,'en','Промокоды','2018-11-27 04:04:24','2018-11-27 04:04:24'),(20,'menu_items','title',29,'en','Партнёрка','2018-11-27 04:06:04','2018-11-27 04:06:04'),(21,'data_types','display_name_singular',5,'en','Автор','2018-11-27 05:51:55','2018-11-27 05:51:55'),(22,'data_types','display_name_plural',5,'en','Авторы','2018-11-27 05:51:55','2018-11-27 05:51:55'),(23,'data_types','display_name_singular',6,'en','Категория','2018-11-27 05:52:10','2018-11-27 05:52:10'),(24,'data_types','display_name_plural',6,'en','Категории','2018-11-27 05:52:10','2018-11-27 05:52:10'),(25,'data_types','display_name_singular',19,'en','Контакты журнала','2018-11-27 05:52:26','2018-11-27 05:52:26'),(26,'data_types','display_name_plural',19,'en','Контакты журналов','2018-11-27 05:52:26','2018-11-27 05:52:26'),(27,'data_types','display_name_singular',14,'en','Publishing','2018-11-27 05:53:13','2018-11-27 05:53:13'),(28,'data_types','display_name_plural',14,'en','Publishings','2018-11-27 05:53:13','2018-11-27 05:53:13'),(29,'articles','name',492,'en','Velit odio saepe.234324','2018-12-03 06:39:27','2018-12-10 02:10:55'),(30,'articles','code',492,'en','sint-ab-dolorem','2018-12-03 06:39:27','2018-12-03 06:39:27'),(31,'articles','keywords',492,'en','','2018-12-03 06:39:27','2018-12-03 06:39:27'),(32,'articles','description',492,'en','description in english','2018-12-03 06:39:27','2018-12-03 09:00:43'),(33,'articles','preview_description',492,'en','','2018-12-03 06:39:27','2018-12-03 06:39:27'),(34,'articles','bibliography',492,'en','','2018-12-03 06:39:27','2018-12-03 06:39:27'),(35,'data_types','display_name_singular',20,'en','Order','2018-12-06 08:38:44','2018-12-06 08:38:44'),(36,'data_types','display_name_plural',20,'en','Orders','2018-12-06 08:38:44','2018-12-06 08:38:44'),(37,'menu_items','title',30,'en','Заказы','2018-12-06 10:17:14','2018-12-06 10:17:14'),(38,'data_types','display_name_singular',21,'en','Физическое лицо','2018-12-07 02:57:27','2018-12-07 02:57:27'),(39,'data_types','display_name_plural',21,'en','Физические лица','2018-12-07 02:57:27','2018-12-07 02:57:27'),(40,'releases','name',491,'en','Dolore omnis molestiae.777','2018-12-10 02:01:54','2018-12-10 02:01:54'),(41,'releases','code',491,'en','cumque-quidem','2018-12-10 02:01:54','2018-12-10 02:01:54'),(42,'releases','description',491,'en','','2018-12-10 02:01:54','2018-12-10 02:01:54'),(43,'releases','preview_description',491,'en','','2018-12-10 02:01:54','2018-12-10 02:01:54'),(44,'releases','name',492,'en','Ipsa iusto dolores ut.2222','2018-12-10 02:04:38','2018-12-10 02:04:38'),(45,'releases','code',492,'en','excepturi-ut-distinctio','2018-12-10 02:04:38','2018-12-10 02:04:38'),(46,'releases','description',492,'en','','2018-12-10 02:04:38','2018-12-10 02:04:38'),(47,'releases','preview_description',492,'en','','2018-12-10 02:04:38','2018-12-10 02:04:38'),(48,'releases','name',493,'en','Est et veritatis repellat.ENG','2018-12-10 06:38:57','2018-12-10 12:24:55'),(49,'releases','code',493,'en','recusandae-non','2018-12-10 06:38:58','2018-12-10 06:38:58'),(50,'releases','description',493,'en','','2018-12-10 06:38:58','2018-12-10 06:38:58'),(51,'releases','preview_description',493,'en','','2018-12-10 06:38:58','2018-12-10 06:38:58'),(52,'releases','image',493,'en','releases/December2018/kPDnN9l93tsYTa9x3hLq.png','2018-12-10 08:42:26','2018-12-10 08:42:26'),(53,'releases','preview_image',493,'en','','2018-12-10 08:42:26','2018-12-10 08:42:26'),(54,'releases','name',494,'en','Quia aliquid animi doloremque.','2018-12-11 04:06:55','2018-12-11 04:06:55'),(55,'releases','code',494,'en','velit-consequatur-id-iste','2018-12-11 04:06:55','2018-12-11 04:06:55'),(56,'releases','description',494,'en','','2018-12-11 04:06:55','2018-12-11 04:06:55'),(57,'releases','preview_description',494,'en','','2018-12-11 04:06:55','2018-12-11 04:06:55'),(58,'releases','image',494,'en','releases/December2018/KP40RvW6qhiLE5xogi5p.jpg','2018-12-11 04:09:40','2018-12-11 04:09:40'),(59,'releases','name',495,'en','Velit commodi eius delectus.','2018-12-12 03:39:53','2018-12-12 03:39:53'),(60,'releases','code',495,'en','et-recusandae-vero','2018-12-12 03:39:53','2018-12-12 03:39:53'),(61,'releases','description',495,'en','','2018-12-12 03:39:53','2018-12-12 03:39:53'),(62,'releases','preview_description',495,'en','','2018-12-12 03:39:53','2018-12-12 03:39:53'),(63,'releases','image',495,'en','releases/December2018/75PBhgjS3oSl1XAWuAZq.jpg','2018-12-12 03:41:40','2018-12-12 09:23:09'),(64,'releases','preview_image',495,'en','','2018-12-12 09:17:39','2018-12-12 09:17:39'),(65,'releases','name',496,'en','Libero maiores.','2018-12-12 09:23:42','2018-12-12 09:23:42'),(66,'releases','code',496,'en','blanditiis-accusantium-consectetur-soluta','2018-12-12 09:23:42','2018-12-12 09:23:42'),(67,'releases','description',496,'en','','2018-12-12 09:23:42','2018-12-12 09:23:42'),(68,'releases','preview_description',496,'en','','2018-12-12 09:23:42','2018-12-12 09:23:42'),(69,'releases','image',496,'en','releases/December2018/wJPS7i2I6EbJWpY9AMop.png','2018-12-12 09:23:58','2018-12-12 09:23:58'),(70,'releases','name',497,'en','Autem incidunt consectetur.','2018-12-12 09:24:29','2018-12-12 09:24:29'),(71,'releases','code',497,'en','cupiditate-voluptatem-omnis-et','2018-12-12 09:24:29','2018-12-12 09:24:29'),(72,'releases','description',497,'en','','2018-12-12 09:24:30','2018-12-12 09:24:30'),(73,'releases','preview_description',497,'en','','2018-12-12 09:24:30','2018-12-12 09:24:30'),(74,'releases','image',497,'en','releases/December2018/tVuj6c5WUWLcaIqOc1lC.jpg','2018-12-12 09:24:44','2018-12-12 09:24:44'),(75,'releases','name',498,'en','Ex aut est.','2018-12-12 09:25:10','2018-12-12 09:25:10'),(76,'releases','code',498,'en','rerum-provident-rem-quas','2018-12-12 09:25:10','2018-12-12 09:25:10'),(77,'releases','image',498,'en','releases/December2018/fzps72fHkSr89NSLl4u0.jpg','2018-12-12 09:25:11','2018-12-12 09:25:11'),(78,'releases','description',498,'en','','2018-12-12 09:25:11','2018-12-12 09:25:11'),(79,'releases','preview_description',498,'en','','2018-12-12 09:25:11','2018-12-12 09:25:11'),(80,'releases','name',499,'en','Consequatur consequuntur aliquam.','2018-12-12 10:26:08','2018-12-12 10:26:08'),(81,'releases','code',499,'en','in-itaque-officiis-soluta','2018-12-12 10:26:08','2018-12-12 10:26:08'),(82,'releases','description',499,'en','','2018-12-12 10:26:08','2018-12-12 10:26:08'),(83,'releases','preview_image',499,'en','releases/December2018/ForXNWi4YepgUIX9hiMc.png','2018-12-12 10:26:09','2018-12-12 10:26:09'),(84,'releases','preview_description',499,'en','','2018-12-12 10:26:09','2018-12-12 10:26:09'),(85,'data_types','display_name_singular',24,'en','Платёжная система','2018-12-13 05:44:08','2018-12-13 05:44:08'),(86,'data_types','display_name_plural',24,'en','Платёжные системы','2018-12-13 05:44:09','2018-12-13 05:44:09'),(87,'menu_items','title',31,'en','Платежные системы','2018-12-13 05:45:49','2018-12-13 05:45:49'),(88,'data_types','display_name_singular',25,'en','Данные платёжной системы','2018-12-17 07:22:19','2018-12-17 07:22:19'),(89,'data_types','display_name_plural',25,'en','Данные платёжных систем','2018-12-17 07:22:19','2018-12-17 07:22:19');
/*!40000 ALTER TABLE `translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_roles` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `user_roles_user_id_index` (`user_id`),
  KEY `user_roles_role_id_index` (`role_id`),
  CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'users/default.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'Master','admin@panorama.loc','users/default.png',NULL,'$2y$10$H5lz41Z2I7D1T4PH/M8KkuCBAMgG5xUkDcCCP3c5rCAPOLhQC6LMK',NULL,NULL,'2018-11-23 10:45:30','2018-11-23 10:45:31');
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

-- Dump completed on 2018-12-20 11:02:44
