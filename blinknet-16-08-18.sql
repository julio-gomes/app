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
-- Table structure for table `branch_of_activities`
--

DROP TABLE IF EXISTS `branch_of_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `branch_of_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branch_of_activities`
--

LOCK TABLES `branch_of_activities` WRITE;
/*!40000 ALTER TABLE `branch_of_activities` DISABLE KEYS */;
INSERT INTO `branch_of_activities` VALUES (60,'Academia'),(48,'Autopeças'),(44,'Bar ou Lanchonete'),(51,'Barbearia'),(66,'Brinquedos'),(65,'Calçados'),(55,'Casa de Festas'),(57,'Celulares'),(56,'Cesta Básica'),(61,'Clínica médica'),(64,'Decoração'),(41,'Delicatessen'),(45,'Distribuidor de bebidas'),(53,'Distribuidor de medicamentos'),(69,'Eletrônicos Áudio e Video'),(49,'Escola'),(52,'Farmácia ou Drogaria'),(68,'Games'),(59,'Gráfica'),(67,'Hobbies'),(54,'Informática'),(70,'Instrumentos Musicais'),(74,'Lavanderia'),(40,'Loja de carnes'),(73,'Loja de Conveniência'),(46,'Material de Construção'),(58,'Material Esportivo'),(38,'Mercado ou Mercearia'),(47,'Oficina Mecânica'),(39,'Padaria'),(42,'Papelaria'),(71,'Pet Shop'),(75,'Posto de combustível'),(43,'Restaurante'),(62,'Roupas Femininas'),(63,'Roupas Masculinas'),(50,'Salão de Beleza'),(37,'Supermercado'),(72,'Veterinária');
/*!40000 ALTER TABLE `branch_of_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `branch_of_activities_buyers`
--

DROP TABLE IF EXISTS `branch_of_activities_buyers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `branch_of_activities_buyers` (
  `branch_of_activity_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  PRIMARY KEY (`buyer_id`,`branch_of_activity_id`),
  KEY `bracnh_of_activity_id` (`branch_of_activity_id`),
  KEY `buyer_id` (`buyer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branch_of_activities_buyers`
--

LOCK TABLES `branch_of_activities_buyers` WRITE;
/*!40000 ALTER TABLE `branch_of_activities_buyers` DISABLE KEYS */;
/*!40000 ALTER TABLE `branch_of_activities_buyers` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'Coca'),(5,'Guarana'),(2,'Nestle'),(4,'Ninho'),(3,'Pepsi');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buyers`
--

DROP TABLE IF EXISTS `buyers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buyers` (
  `id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_buyers_persons1_idx` (`id`),
  CONSTRAINT `fk_buyers_persons1` FOREIGN KEY (`id`) REFERENCES `persons` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buyers`
--

LOCK TABLES `buyers` WRITE;
/*!40000 ALTER TABLE `buyers` DISABLE KEYS */;
INSERT INTO `buyers` VALUES (5);
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persons`
--

LOCK TABLES `persons` WRITE;
/*!40000 ALTER TABLE `persons` DISABLE KEYS */;
INSERT INTO `persons` VALUES (5,NULL,NULL,NULL,NULL,NULL),(8,'123','123.123.12-311','123','123',NULL),(10,'123','123.123.12-3112','12341234',NULL,NULL),(11,'123','123.121.22-12213','12341234',NULL,NULL),(12,'123','123.121.22-12213','12341234',NULL,NULL);
/*!40000 ALTER TABLE `persons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phinxlog`
--

DROP TABLE IF EXISTS `phinxlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phinxlog`
--

LOCK TABLES `phinxlog` WRITE;
/*!40000 ALTER TABLE `phinxlog` DISABLE KEYS */;
INSERT INTO `phinxlog` VALUES (20180814174345,'Initial','2018-08-14 20:43:47','2018-08-14 20:43:47',0),(20180815180623,'AddBranchOfActivities','2018-08-16 00:26:01','2018-08-16 00:26:01',0);
/*!40000 ALTER TABLE `phinxlog` ENABLE KEYS */;
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
INSERT INTO `sellers` VALUES (8),(12);
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
INSERT INTO `sellers_brands` VALUES (2,12),(4,8);
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
INSERT INTO `states` VALUES (1,'Acre','AC'),(2,'Alagoas',''),(3,'Amapá',''),(4,'Amazonas',''),(5,'Bahia',''),(6,'Ceará',''),(7,'Distrito Federal',''),(8,'Espírito Santo',''),(9,'Goiás',''),(10,'Maranhão',''),(11,'Mato Grosso',''),(12,'Mato Grosso do Sul',''),(13,'Minas Gerais',''),(14,'Pará',''),(15,'Paraíba',''),(16,'Paraná',''),(17,'Pernambuco',''),(18,'Piauí',''),(19,'Rio de Janeiro',''),(20,'Rio Grande do Norte',''),(21,'Rio Grande do Sul',''),(22,'Rondônia',''),(23,'Roraima',''),(24,'Santa Catarina',''),(25,'São Paulo',''),(26,'Sergipe',''),(27,'Tocantins','');
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
  `avatar_base64` varchar(2500) DEFAULT NULL,
  `avatar_mime_type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'Gustavo Carvalho','seller@clicksoft.com.br','$2y$10$nC86ebX2SKyidoOF7gjByu8LyTrkO3Hn7LIPypJZkGtRt9mXLVY..','123123123123',NULL,NULL),(5,'John Doe','seller@clicksof.com.br','$2y$10$nC86ebX2SKyidoOF7gjByu8LyTrkO3Hn7LIPypJZkGtRt9mXLVY..','123123123123',NULL,NULL),(6,'Gabriella Toledo','seller@clickft.com.br','$2y$10$nC86ebX2SKyidoOF7gjByu8LyTrkO3Hn7LIPypJZkGtRt9mXLVY..','123123123123',NULL,NULL),(7,'Zanamum Avada!','seler@clickft.com.r','$2y$10$nC86ebX2SKyidoOF7gjByu8LyTrkO3Hn7LIPypJZkGtRt9mXLVY..','123123123123',NULL,NULL),(8,'ALTEREI','seler@clickft.cm.br','$2y$10$XUj015kyLj1d120D/wtk5.Vxwk1esGvb9lYww0i.qyPmYwVeYu.nG','123',NULL,NULL),(9,'GH Rictusempra','seler@clickft.om.b','$2y$10$nC86ebX2SKyidoOF7gjByu8LyTrkO3Hn7LIPypJZkGtRt9mXLVY..','123123123123',NULL,NULL),(10,'12345','123@1.com','$2y$10$XUj015kyLj1d120D/wtk5.Vxwk1esGvb9lYww0i.qyPmYwVeYu.nG','12341234',NULL,NULL),(12,'1234','lalal@gmai.com','$2y$10$XUj015kyLj1d120D/wtk5.Vxwk1esGvb9lYww0i.qyPmYwVeYu.nG','12341234',NULL,NULL);
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
INSERT INTO `users_has_users` VALUES (4,8,1),(8,4,1),(8,8,1),(12,4,1),(12,5,1),(12,8,1),(12,10,1);
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

-- Dump completed on 2018-08-16  1:56:50
