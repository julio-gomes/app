-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: blinknet
-- ------------------------------------------------------
-- Server version	5.7.19

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
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zip_code` varchar(8) NOT NULL,
  `street` varchar(255) NOT NULL,
  ` neighborhood` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `complement` varchar(45) DEFAULT NULL,
  `state_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `zip_code_UNIQUE` (`zip_code`),
  KEY `fk_address_states1_idx` (`state_id`),
  KEY `city_UNIQUE` (`city`),
  CONSTRAINT `fk_address_states1` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'yo');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buyers`
--

DROP TABLE IF EXISTS `buyers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buyers` (
  `person_id` int(11) NOT NULL,
  `branch_of_activities` varchar(45) NOT NULL,
  PRIMARY KEY (`person_id`),
  KEY `fk_buyers_persons1_idx` (`person_id`),
  KEY `branch_of_activities_UNIQUE` (`branch_of_activities`),
  CONSTRAINT `fk_buyers_persons1` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buyers`
--

LOCK TABLES `buyers` WRITE;
/*!40000 ALTER TABLE `buyers` DISABLE KEYS */;
/*!40000 ALTER TABLE `buyers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persons`
--

DROP TABLE IF EXISTS `persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(45) DEFAULT NULL,
  `cnpj` varchar(45) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `house_number` varchar(45) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_persons_addresses1_idx` (`address_id`),
  CONSTRAINT `fk_persons_addresses1` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persons`
--

LOCK TABLES `persons` WRITE;
/*!40000 ALTER TABLE `persons` DISABLE KEYS */;
INSERT INTO `persons` VALUES (8,'123','123','123','123',NULL);
/*!40000 ALTER TABLE `persons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_categories`
--

DROP TABLE IF EXISTS `product_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_categories`
--

LOCK TABLES `product_categories` WRITE;
/*!40000 ALTER TABLE `product_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rest_api_phinxlog`
--

DROP TABLE IF EXISTS `rest_api_phinxlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rest_api_phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rest_api_phinxlog`
--

LOCK TABLES `rest_api_phinxlog` WRITE;
/*!40000 ALTER TABLE `rest_api_phinxlog` DISABLE KEYS */;
INSERT INTO `rest_api_phinxlog` VALUES (20161214105414,'CreateApiRequests','2018-07-16 17:37:06','2018-07-16 17:37:06',0),(20170221103057,'AddResponseTypeToApiRequests','2018-07-16 17:37:06','2018-07-16 17:37:06',0);
/*!40000 ALTER TABLE `rest_api_phinxlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sellers`
--

DROP TABLE IF EXISTS `sellers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sellers` (
  `id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sellers_persons1_idx` (`id`),
  CONSTRAINT `fk_sellers_persons1` FOREIGN KEY (`id`) REFERENCES `persons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sellers`
--

LOCK TABLES `sellers` WRITE;
/*!40000 ALTER TABLE `sellers` DISABLE KEYS */;
INSERT INTO `sellers` VALUES (8);
/*!40000 ALTER TABLE `sellers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sellers_brands`
--

DROP TABLE IF EXISTS `sellers_brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sellers_brands` (
  `brand_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  PRIMARY KEY (`brand_id`,`seller_id`),
  KEY `fk_sellers_has_brands_brands1_idx` (`brand_id`),
  KEY `fk_sellers_brands_sellers1_idx` (`seller_id`),
  CONSTRAINT `fk_sellers_brands_sellers1` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sellers_has_brands_brands1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sellers_brands`
--

LOCK TABLES `sellers_brands` WRITE;
/*!40000 ALTER TABLE `sellers_brands` DISABLE KEYS */;
/*!40000 ALTER TABLE `sellers_brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sellers_product_categories`
--

DROP TABLE IF EXISTS `sellers_product_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sellers_product_categories` (
  `product_category_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  PRIMARY KEY (`product_category_id`,`seller_id`),
  KEY `fk_sellers_has_product_categories_product_categories1_idx` (`product_category_id`),
  KEY `fk_sellers_product_categories_sellers1_idx` (`seller_id`),
  CONSTRAINT `fk_sellers_has_product_categories_product_categories1` FOREIGN KEY (`product_category_id`) REFERENCES `product_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sellers_product_categories_sellers1` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sellers_product_categories`
--

LOCK TABLES `sellers_product_categories` WRITE;
/*!40000 ALTER TABLE `sellers_product_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `sellers_product_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `initials` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name_UNIQUE` (`name`),
  KEY `initials_UNIQUE` (`initials`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` VALUES (1,'Acre','AC'),(2,'AL','Alagoas'),(3,'AM','Amazonas');
/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cellphone` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'Gustavo Carvalho','seller@clicksoft.com.br','$2y$10$nC86ebX2SKyidoOF7gjByu8LyTrkO3Hn7LIPypJZkGtRt9mXLVY..','123123123123'),(5,'John Doe','seller@clicksof.com.br','$2y$10$nC86ebX2SKyidoOF7gjByu8LyTrkO3Hn7LIPypJZkGtRt9mXLVY..','123123123123'),(6,'Gabriella Toledo','seller@clickft.com.br','$2y$10$nC86ebX2SKyidoOF7gjByu8LyTrkO3Hn7LIPypJZkGtRt9mXLVY..','123123123123'),(7,'Zanamum Avada!','seler@clickft.com.r','$2y$10$nC86ebX2SKyidoOF7gjByu8LyTrkO3Hn7LIPypJZkGtRt9mXLVY..','123123123123'),(8,'Rede Vip Pullos','seler@clickft.cm.br','$2y$10$nC86ebX2SKyidoOF7gjByu8LyTrkO3Hn7LIPypJZkGtRt9mXLVY..','123123123123'),(9,'GH Rictusempra','seler@clickft.om.b','$2y$10$nC86ebX2SKyidoOF7gjByu8LyTrkO3Hn7LIPypJZkGtRt9mXLVY..','123123123123');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_has_users`
--

DROP TABLE IF EXISTS `users_has_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_has_users` (
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '2' COMMENT '0 = recusado\n1 = aceito\n2 = pendente',
  PRIMARY KEY (`user_id`,`friend_id`),
  KEY `fk_users_has_users_users2_idx` (`friend_id`),
  KEY `fk_users_has_users_users1_idx` (`user_id`),
  CONSTRAINT `fk_users_has_users_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_users_users2` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_has_users`
--

LOCK TABLES `users_has_users` WRITE;
/*!40000 ALTER TABLE `users_has_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_has_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-12 12:09:44
