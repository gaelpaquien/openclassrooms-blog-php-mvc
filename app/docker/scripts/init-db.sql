CREATE DATABASE IF NOT EXISTS `blogphpmvc` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `blogphpmvc`;

-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: blogphpmvc
-- ------------------------------------------------------
-- Server version	5.7.43

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
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `slug` varchar(45) NOT NULL,
  `caption` tinytext NOT NULL,
  `content` longtext NOT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `image` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`),
  UNIQUE KEY `slug_UNIQUE` (`slug`),
  KEY `fk_article_user_idx` (`author_id`),
  CONSTRAINT `fk_article_user` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (64,'Mon premier article','mon-premier-article','Ceci est la description courte de mon premier article.','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',29,'2022-11-01 00:55:23','2022-11-01 00:55:23','01default.jpg'),(65,'Mon deuxième article','mon-deuxieme-article','Ceci est la description courte de mon deuxième article','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',29,'2022-11-02 00:56:56','2022-11-02 00:56:56','01default.jpg'),(66,'Mon troisième article modifié','mon-troisieme-article-modifie','Ceci est la description courte modifiée de mon troisième article.','Edit : Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',29,'2022-11-03 00:57:30','2022-11-09 21:20:24','mon-troisieme-article.jpeg'),(67,'Mon quatrième article modifié','mon-quatrieme-article-modifie','Ceci est la description courte de mon quatrième article','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',29,'2022-11-04 00:57:58','2022-11-09 21:20:41','01default.jpg'),(68,'Mon cinquième article','mon-cinquieme-article','Ceci est la description courte de mon cinquième article.','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',29,'2022-11-05 00:58:26','2022-11-05 00:58:26','mon-cinquieme-article.jpeg'),(69,'Mon sixième article','mon-sixieme-article','Ceci est la description courte de mon sixième article.','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',29,'2022-11-06 00:58:55','2022-11-06 00:58:55','mon-sixieme-article.jpeg'),(70,'Mon septième article','mon-septieme-article','Ceci est la description courte de mon septième article.','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',29,'2022-11-07 00:59:21','2022-11-07 00:59:21','01default.jpg'),(71,'Mon huitième article','mon-huitieme-article','Ceci est la description courte de mon huitième article','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',29,'2022-11-08 00:59:50','2022-11-08 00:59:50','01default.jpg'),(72,'Mon neuvième article','mon-neuvieme-article','Ceci est la description courte de mon neuvième article','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s',29,'2022-11-09 01:00:21','2022-11-09 01:00:21','mon-neuvieme-article.jpeg');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `validate` tinyint(4) NOT NULL DEFAULT '0',
  `validate_by` int(11) DEFAULT NULL,
  `article_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_comment_author1_idx` (`author_id`),
  KEY `fk_comment_article1_idx` (`article_id`),
  KEY `fk_comment_user1_idx` (`validate_by`),
  CONSTRAINT `fk_comment_article1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  CONSTRAINT `fk_comment_user1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_comment_user2` FOREIGN KEY (`validate_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (165,31,'Jolie photo !',1,29,66,'2022-11-07 01:05:49'),(166,31,'Super article !',1,29,71,'2022-11-08 01:06:00'),(167,31,'Le titre est bien choisi :)',1,29,69,'2022-11-09 01:06:24'),(168,30,'Commentaire de test',1,29,68,'2022-11-09 01:12:32'),(169,30,'Commentaire de test',1,29,68,'2022-11-09 01:12:42'),(171,30,'Commentaire de test',0,NULL,68,'2022-11-09 01:12:53'),(172,30,'Commentaire de test',0,NULL,68,'2022-11-09 01:12:58'),(173,30,'Commentaire de test ',0,NULL,68,'2022-11-09 01:13:05'),(174,30,'Commentaire de test',0,NULL,68,'2022-11-09 01:13:11'),(175,30,'Commentaire de test',0,NULL,68,'2022-11-09 01:13:17'),(176,30,'Commentaire de test ',0,NULL,68,'2022-11-09 01:13:26'),(177,30,'Commentaire de test',0,NULL,68,'2022-11-09 01:13:31'),(178,30,'Commentaire de test',0,NULL,68,'2022-11-09 01:13:38'),(179,30,'Commentaire de test\r\n',0,NULL,68,'2022-11-09 01:15:39'),(180,30,'Commentaire de test',0,NULL,68,'2022-11-09 01:15:45'),(181,30,'Commentaire de test',0,NULL,68,'2022-11-09 01:15:52'),(182,30,'Commentaire de test',0,NULL,68,'2022-11-09 01:15:57'),(183,30,'Commentaire de test',0,NULL,68,'2022-11-09 01:16:04'),(184,30,'Commentaire de test',0,NULL,68,'2022-11-09 01:16:09'),(185,30,'Commentaire de test',0,NULL,68,'2022-11-09 01:16:15'),(186,30,'Super article !',1,29,66,'2022-11-08 01:16:30');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(70) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `subject` varchar(45) NOT NULL,
  `message` longtext NOT NULL,
  `sent_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
INSERT INTO `contact_messages` VALUES (12,'john.doe@email.com','John','Doe','Sujet du mail de test','John Doe (john.doe@email.com)\r\nContenu du mail de test....','2022-11-09 21:37:43');
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(70) NOT NULL,
  `password` varchar(70) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (29,'contact@gaelpaquien.com','$2y$13$FqWLOM19DYi7bypUp.t5SOxU0KggQnDLVQe3LlV6Nu8ss9S9Ie8B6','Gael','Paquien',1,'2022-11-01 00:53:51'),(30,'john.doe@email.com','$2y$13$FqWLOM19DYi7bypUp.t5SOxU0KggQnDLVQe3LlV6Nu8ss9S9Ie8B6','John','Doe',0,'2022-11-02 01:05:15'),(31,'sarah.frison@email.com','$2y$13$FqWLOM19DYi7bypUp.t5SOxU0KggQnDLVQe3LlV6Nu8ss9S9Ie8B6','Sarah','Frison',0,'2022-11-03 01:05:15');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'blogphpmvc'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-26  0:07:28
