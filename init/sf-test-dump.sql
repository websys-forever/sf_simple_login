-- MySQL dump 10.13  Distrib 8.0.17, for Linux (x86_64)
--
-- Host: localhost    Database: sf-test
-- ------------------------------------------------------
-- Server version	8.0.17

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
-- Table structure for table `anonym_user`
--

DROP TABLE IF EXISTS `anonym_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `anonym_user` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:guid)',
  `session_id` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anonym_user`
--

LOCK TABLES `anonym_user` WRITE;
/*!40000 ALTER TABLE `anonym_user` DISABLE KEYS */;
INSERT INTO `anonym_user` VALUES ('1959985b-dfa0-11e9-92d1-123456781234','af6466fe485dfadded85f80f17287868','Session Author 1','2019-09-25 14:23:52','2019-09-25 14:23:52');
/*!40000 ALTER TABLE `anonym_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `article` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:guid)',
  `author_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:guid)',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_23A0E66F675F31B` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` VALUES ('15c0c00b-df9f-11e9-92d1-0242c0a8d002','0261ffdc-dc72-11e9-a73d-0242c0a8d002','Article 1','Content 1','2019-09-25 14:16:36','2019-09-25 14:16:36'),('1ae77e6a-df9f-11e9-92d1-0242c0a8d002','0261ffdc-dc72-11e9-a73d-0242c0a8d002','Article 2','Content 2','2019-09-25 14:16:45','2019-09-25 14:16:45'),('1e381480-df9f-11e9-92d1-0242c0a8d002','0261ffdc-dc72-11e9-a73d-0242c0a8d002','Article 3','Content 3','2019-09-25 14:16:51','2019-09-25 14:16:51'),('29d782eb-df9f-11e9-92d1-0242c0a8d002','0261ffdc-dc72-11e9-a73d-0242c0a8d002','Article 4','Content 4','2019-09-25 14:17:10','2019-09-25 14:17:10'),('304240ed-df9f-11e9-92d1-0242c0a8d002','0261ffdc-dc72-11e9-a73d-0242c0a8d002','Article 5','Content 5','2019-09-25 14:17:21','2019-09-25 14:17:21'),('33d432fd-df9f-11e9-92d1-0242c0a8d002','0261ffdc-dc72-11e9-a73d-0242c0a8d002','Article 6','Content 6','2019-09-25 14:17:27','2019-09-25 14:17:27'),('37b9a465-df9f-11e9-92d1-0242c0a8d002','0261ffdc-dc72-11e9-a73d-0242c0a8d002','Article 7','Content 7','2019-09-25 14:17:33','2019-09-25 14:17:33'),('3b8558fc-df9f-11e9-92d1-0242c0a8d002','0261ffdc-dc72-11e9-a73d-0242c0a8d002','Article 8','Content 8','2019-09-25 14:17:40','2019-09-25 14:17:40'),('3f40bf10-df9f-11e9-92d1-0242c0a8d002','0261ffdc-dc72-11e9-a73d-0242c0a8d002','Article 9','Content 9','2019-09-25 14:17:46','2019-09-25 14:17:46'),('444c5be2-df9f-11e9-92d1-0242c0a8d002','0261ffdc-dc72-11e9-a73d-0242c0a8d002','Article 10','Content 10','2019-09-25 14:17:55','2019-09-25 14:17:55'),('48f364d7-df9f-11e9-92d1-0242c0a8d002','0261ffdc-dc72-11e9-a73d-0242c0a8d002','Article 11','Content 11','2019-09-25 14:18:02','2019-09-25 14:18:02'),('4cee5a5c-df9f-11e9-92d1-0242c0a8d002','0261ffdc-dc72-11e9-a73d-0242c0a8d002','Article 12','Content 12','2019-09-25 14:18:09','2019-09-25 14:18:09'),('b406ca40-df9f-11e9-92d1-0242c0a8d002','bd8b3001-de31-11e9-8cc5-03a5d31c9b20','Article 13','Article 13','2019-09-25 14:21:02','2019-09-25 14:21:02'),('b7e6251c-df9f-11e9-92d1-0242c0a8d002','bd8b3001-de31-11e9-8cc5-03a5d31c9b20','Article 14','Article 14','2019-09-25 14:21:08','2019-09-25 14:21:08'),('bc0afc10-df9f-11e9-92d1-0242c0a8d002','bd8b3001-de31-11e9-8cc5-03a5d31c9b20','Article 15','Article 15','2019-09-25 14:21:15','2019-09-25 14:21:15'),('c0f593da-df9f-11e9-92d1-0242c0a8d002','bd8b3001-de31-11e9-8cc5-03a5d31c9b20','Article 16','Article 16','2019-09-25 14:21:24','2019-09-25 14:21:24'),('c49f88ab-df9f-11e9-92d1-0242c0a8d002','bd8b3001-de31-11e9-8cc5-03a5d31c9b20','Article 17','Article 17','2019-09-25 14:21:30','2019-09-25 14:21:30'),('c81467a3-df9f-11e9-92d1-0242c0a8d002','bd8b3001-de31-11e9-8cc5-03a5d31c9b20','Article 18','Article 18','2019-09-25 14:21:36','2019-09-25 14:21:36'),('cbe7ee1f-df9f-11e9-92d1-0242c0a8d002','bd8b3001-de31-11e9-8cc5-03a5d31c9b20','Article 19','Article 19','2019-09-25 14:21:42','2019-09-25 14:21:42'),('d150fbf1-df9f-11e9-92d1-0242c0a8d002','bd8b3001-de31-11e9-8cc5-03a5d31c9b20','Article 20','Article 20','2019-09-25 14:21:51','2019-09-25 14:21:51'),('d5c08ce8-df9f-11e9-92d1-0242c0a8d002','bd8b3001-de31-11e9-8cc5-03a5d31c9b20','Article 21','Article 21','2019-09-25 14:21:59','2019-09-25 14:21:59'),('d8830457-df9f-11e9-92d1-0242c0a8d002','bd8b3001-de31-11e9-8cc5-03a5d31c9b20','Article 22','Article 22','2019-09-25 14:22:03','2019-09-25 14:22:03'),('db3039c0-df9f-11e9-92d1-0242c0a8d002','bd8b3001-de31-11e9-8cc5-03a5d31c9b20','Article 23','Article 23','2019-09-25 14:22:08','2019-09-25 14:22:08'),('dedf206d-df9f-11e9-92d1-0242c0a8d002','bd8b3001-de31-11e9-8cc5-03a5d31c9b20','Article 24','Article 24','2019-09-25 14:22:14','2019-09-25 14:22:14'),('e3141e2a-df9f-11e9-92d1-0242c0a8d002','bd8b3001-de31-11e9-8cc5-03a5d31c9b20','Article 25','Article 25','2019-09-25 14:22:21','2019-09-25 14:22:21'),('e6b723b2-df9f-11e9-92d1-0242c0a8d002','bd8b3001-de31-11e9-8cc5-03a5d31c9b20','Article 26','Article 26','2019-09-25 14:22:27','2019-09-25 14:22:27'),('efc86fd9-df9f-11e9-92d1-0242c0a8d002','bd8b3001-de31-11e9-8cc5-03a5d31c9b20','Article 27','Article 27','2019-09-25 14:22:42','2019-09-25 14:22:42'),('f3b3988e-df9f-11e9-92d1-0242c0a8d002','bd8b3001-de31-11e9-8cc5-03a5d31c9b20','Article 28','Article 28','2019-09-25 14:22:49','2019-09-25 14:22:49'),('f712252f-df9f-11e9-92d1-0242c0a8d002','bd8b3001-de31-11e9-8cc5-03a5d31c9b20','Article 29','Article 29','2019-09-25 14:22:54','2019-09-25 14:22:54'),('fbae4672-df9f-11e9-92d1-0242c0a8d002','bd8b3001-de31-11e9-8cc5-03a5d31c9b20','Article 30','Article 30','2019-09-25 14:23:02','2019-09-25 14:23:02');
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20190903094144','2019-09-03 11:11:14'),('20190906115515','2019-09-06 11:57:22'),('20190906152412','2019-09-06 15:28:10'),('20190907183057','2019-09-07 18:31:22'),('20190913101232','2019-09-13 10:14:25'),('20190920054651','2019-09-20 05:49:21'),('20190921124448','2019-09-21 12:50:52');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session_article`
--

DROP TABLE IF EXISTS `session_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `session_article` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:guid)',
  `author_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:guid)',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_10E28C3CF675F31B` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session_article`
--

LOCK TABLES `session_article` WRITE;
/*!40000 ALTER TABLE `session_article` DISABLE KEYS */;
INSERT INTO `session_article` VALUES ('195a0d46-dfa0-11e9-92d1-0242c0a8d002','1959985b-dfa0-11e9-92d1-123456781234','Session Article 1','Session Article Content 1','2019-09-25 14:23:52','2019-09-25 14:23:52'),('24cdc034-dfa0-11e9-92d1-0242c0a8d002','1959985b-dfa0-11e9-92d1-123456781234','Session Article 2','Session Article Content 2','2019-09-25 14:24:11','2019-09-25 14:24:11'),('28384ede-dfa0-11e9-92d1-0242c0a8d002','1959985b-dfa0-11e9-92d1-123456781234','Session Article 3','Session Article Content 3','2019-09-25 14:24:17','2019-09-25 14:24:17'),('2d7dfb0c-dfa0-11e9-92d1-0242c0a8d002','1959985b-dfa0-11e9-92d1-123456781234','Session Article 4','Session Article Content 4','2019-09-25 14:24:26','2019-09-25 14:24:26'),('3192342c-dfa0-11e9-92d1-0242c0a8d002','1959985b-dfa0-11e9-92d1-123456781234','Session Article 5','Session Article Content 5','2019-09-25 14:24:33','2019-09-25 14:24:33');
/*!40000 ALTER TABLE `session_article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `sess_id` varchar(128) COLLATE utf8mb4_bin NOT NULL,
  `sess_data` blob NOT NULL,
  `sess_time` int(10) unsigned NOT NULL,
  `sess_lifetime` mediumint(9) NOT NULL,
  PRIMARY KEY (`sess_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('974c44a4b5e57da2bf8f65463372ba5e',_binary '_sf2_attributes|a:4:{s:29:\"_csrf/new_article_anonym_form\";s:43:\"ioEMMkRgJJrptWWKGqdb-v4uLG_9XdAVjMvPvlaoFW8\";s:18:\"_csrf/authenticate\";s:43:\"XMqB31h3Gk5vvQGF6s63ovDbrwu3PpJu4Sb865spwEk\";s:23:\"_security.last_username\";s:10:\"u3@h.local\";s:14:\"_security_main\";s:1214:\"C:67:\"Symfony\\Component\\Security\\Guard\\Token\\PostAuthenticationGuardToken\":1132:{a:2:{i:0;s:4:\"main\";i:1;a:5:{i:0;O:15:\"App\\Entity\\User\":8:{s:19:\"\0App\\Entity\\User\0id\";s:36:\"bd8b3001-de31-11e9-8cc5-03a5d31c9b20\";s:22:\"\0App\\Entity\\User\0email\";s:10:\"u3@h.local\";s:22:\"\0App\\Entity\\User\0roles\";a:0:{}s:25:\"\0App\\Entity\\User\0password\";s:96:\"$argon2i$v=19$m=65536,t=4,p=1$Z0dKYWZlcDZkanYuQlE2Ug$NnoyP7Y7GduPNNOs4H/Pi9Gy7CiKQ8rcWvJbG0Tdw3Y\";s:25:\"\0App\\Entity\\User\0articles\";O:33:\"Doctrine\\ORM\\PersistentCollection\":2:{s:13:\"\0*\0collection\";O:43:\"Doctrine\\Common\\Collections\\ArrayCollection\":1:{s:53:\"\0Doctrine\\Common\\Collections\\ArrayCollection\0elements\";a:0:{}}s:14:\"\0*\0initialized\";b:0;}s:28:\"\0App\\Entity\\User\0author_name\";s:4:\"sa24\";s:27:\"\0App\\Entity\\User\0created_at\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2019-09-23 18:41:21.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}s:27:\"\0App\\Entity\\User\0updated_at\";O:8:\"DateTime\":3:{s:4:\"date\";s:26:\"2019-09-23 18:41:21.000000\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";}}i:1;b:1;i:2;a:1:{i:0;O:41:\"Symfony\\Component\\Security\\Core\\Role\\Role\":1:{s:47:\"\0Symfony\\Component\\Security\\Core\\Role\\Role\0role\";s:9:\"ROLE_USER\";}}i:3;a:0:{}i:4;a:1:{i:0;s:9:\"ROLE_USER\";}}}}\";}_sf2_meta|a:3:{s:1:\"u\";i:1569421812;s:1:\"c\";i:1569421650;s:1:\"l\";s:1:\"0\";}',1569421812,1440);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:guid)',
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('0261ffdc-dc72-11e9-a73d-0242c0a8d002','u1@h.local','[]','$argon2i$v=19$m=65536,t=4,p=1$MUtEdlc5TFpZN0cubDhFUg$Jrc34caoPFTb7zYSuhqWjPkrMIwyd+R7fdL71obCRXk','ua1','2019-09-21 13:16:23','2019-09-21 13:16:23'),('6c8582e1-dea6-11e9-83b4-0242c0a8d002','a6@h.local','[]','$argon2i$v=19$m=65536,t=4,p=1$QnhwUEZvMHIzRk1GMjRpUg$vegcWvUJEdWULJNi+P8WSfR6vRU41Uw6kuSZ2F6w6xw','a6','2019-09-24 08:36:36','2019-09-24 08:36:36'),('bd8b3001-de31-11e9-8cc5-03a5d31c9b20','u3@h.local','[]','$argon2i$v=19$m=65536,t=4,p=1$Z0dKYWZlcDZkanYuQlE2Ug$NnoyP7Y7GduPNNOs4H/Pi9Gy7CiKQ8rcWvJbG0Tdw3Y','sa24','2019-09-23 18:41:21','2019-09-23 18:41:21');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-09-25 14:34:43
