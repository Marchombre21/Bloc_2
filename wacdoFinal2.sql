/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.7.2-MariaDB, for Win64 (AMD64)
--
-- Host: mysql-wacdo.alwaysdata.net    Database: wacdo_name
-- ------------------------------------------------------
-- Server version	10.11.13-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES
(1,'menus','/categories/menus.png','Un sandwich, ou une salade et une boisson.'),
(2,'boissons','/categories/boissons.png','Une petite soif, sucrée, légère et rafraîchissante!'),
(3,'burgers','/categories/burgers.png','Un délicieux problème de cholestérol enrobé de sauces très sucrées pour que les enfants en mangent.'),
(4,'frites','/categories/frites.png','Croustillantes si elles n\'avaient pas été tellement baignées dans l\'huile qu\'elles en gouttent encore.'),
(5,'encas','/categories/encas.png','Pour ceux qui ont faim mais pas trop.'),
(6,'wraps','/categories/wraps.png','Laissez-vous wrapper!'),
(7,'salades','/categories/salades.png','Aller au Wacdo pour une salade c\'est comme aller dans une maison close pour un calin.'),
(8,'desserts','/categories/desserts.png','Encore un peu de sucre?'),
(9,'sauces','/categories/sauces.png','Au cas où il n\'y en ait pas assez.');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` int(11) DEFAULT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `xxl` tinyint(1) DEFAULT 0,
  `quantity` int(11) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `order_items_ibfk_1` (`order_number`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_number`) REFERENCES `orders` (`order_number`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=343 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES
(290,80,'Big Tasty Bacon',0,2),
(291,80,'Grande Frite',0,1),
(292,80,'Grande Potatoes',0,1),
(293,80,'Eau 50Cl',0,3),
(294,80,'Ice Tea Citron 30Cl',0,2),
(295,80,'Big Tasty',0,1),
(296,80,'Salade',0,1),
(297,80,'Eau',0,1),
(298,1,'Moyenne Frite',0,1),
(299,1,'Grande Frite',0,2),
(300,1,'Big Tasty Bacon',0,2),
(301,1,'Eau 50Cl',0,3),
(302,1,'CBO',0,1),
(303,1,'Frites',0,1),
(304,1,'Fanta Orange',0,1),
(305,1,'Big Tasty',1,1),
(306,1,'Salade',1,1),
(307,1,'Fanta Orange',1,1),
(308,8,'Big Tasty',0,5),
(309,8,'Big Tasty Bacon',0,1),
(310,8,'CBO',0,1),
(311,8,'Ice Tea Pêche 50Cl',0,3),
(312,8,'Big Tasty Bacon',0,1),
(313,8,'Salade',0,1),
(314,8,'Eau',0,1),
(315,9,'Big Tasty Bacon',0,2),
(316,9,'Grande Frite',0,2),
(317,9,'CBO',0,1),
(318,9,'Potatoes',0,1),
(319,9,'Eau',0,1),
(320,10,'Coca Sans Sucres 50Cl',0,3),
(321,10,'Eau 50Cl',0,3),
(322,10,'Big Tasty Bacon',0,2),
(323,10,'Nuggets x4',0,1),
(324,10,'Big Mac',0,1),
(325,10,'Potatoes',0,1),
(326,10,'Fanta Orange',0,1),
(327,1,'Coca Sans Sucres 50Cl',0,3),
(328,1,'Big Tasty',0,2),
(329,1,'Moyenne Frite',0,1),
(330,1,'MC Wrap Poulet Bacon',0,1),
(331,1,'Classic Moutarde',0,1),
(332,1,'Le 280',1,1),
(333,1,'Potatoes',1,1),
(334,1,'Eau',1,1),
(335,4,'Coca Sans Sucres 50Cl',0,3),
(336,4,'Coca Cola 30Cl',0,3),
(337,4,'Big Tasty',0,1),
(338,4,'Le 280',0,1),
(339,4,'Salade',0,1),
(340,4,'Coca Cola',0,1),
(341,4,'Salade',0,1),
(342,4,'Coca Sans Sucres',0,1);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` int(11) DEFAULT NULL,
  `order_price` decimal(6,2) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `isCompleted` tinyint(1) DEFAULT 0,
  `tableTent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_number` (`order_number`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES
(55,80,43.60,'2025-06-11 15:43:00',1,158),
(56,1,55.55,'2025-06-25 10:51:00',1,458),
(57,8,78.90,'2025-06-25 15:17:33',1,851),
(58,9,35.70,'2025-06-25 15:44:31',1,458),
(59,10,41.40,'2025-06-25 15:48:54',0,456),
(61,4,40.60,'2025-06-25 17:11:30',0,853);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(70) DEFAULT NULL,
  `price` decimal(4,2) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `available` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES
(1,'Menu Le 280',8.80,'/burgers/280.png',1,1),
(2,'Menu Big Tasty',10.60,'/burgers/BIG_TASTY_1_VIANDE.png',1,1),
(3,'Menu Big Tasty Bacon',10.90,'/burgers/BIG_TASTY_BACON_1_VIANDE.png',1,1),
(4,'Menu Big Mac',8.00,'/burgers/BIGMAC.png',1,1),
(5,'Menu CBO',10.90,'/burgers/CBO.png',1,1),
(6,'Menu MC Chicken',9.30,'/burgers/MCCHICKEN.png',1,1),
(7,'Menu MC Crispy',7.20,'/burgers/MCCRISPY.png',1,1),
(8,'Menu MC Fish',7.20,'/burgers/MCFISH.png',1,1),
(9,'Menu Royal Bacon',7.05,'/burgers/ROYALBACON.png',1,1),
(10,'Menu Royal Cheese',6.40,'/burgers/ROYALCHEESE.png',1,1),
(11,'Menu Royal Deluxe',7.40,'/burgers/ROYALDELUXE.png',1,1),
(12,'Menu Signature BBQ Beef 2 viandes',13.50,'/burgers/SIGNATURE_BBQ_BEEF_(2_VIANDES).png',1,1),
(13,'Menu Signature Beef BBQ',11.90,'/burgers/SIGNATURE_BEEF_BBQ_BURGER_(1_VIANDE).png',1,1),
(14,'Le 280',6.80,'/burgers/682d8652874c6-280.png',3,1),
(15,'Big Tasty',8.60,'/burgers/BIG_TASTY_1_VIANDE.png',3,1),
(16,'Big Tasty Bacon',8.90,'/burgers/BIG_TASTY_BACON_1_VIANDE.png',3,1),
(17,'Big Mac',6.00,'/burgers/BIGMAC.png',3,1),
(18,'CBO',8.90,'/burgers/CBO.png',3,1),
(19,'MC Chicken',7.30,'/burgers/MCCHICKEN.png',3,1),
(20,'MC Crispy',5.30,'/burgers/MCCRISPY.png',3,1),
(21,'MC Fish',4.85,'/burgers/MCFISH.png',3,1),
(22,'Royal Bacon',5.10,'/burgers/ROYALBACON.png',3,1),
(23,'Royal Cheese',4.40,'/burgers/ROYALCHEESE.png',3,1),
(24,'Royal Deluxe',5.40,'/burgers/ROYALDELUXE.png',3,1),
(25,'Signature BBQ Beef 2 viandes',11.40,'/burgers/SIGNATURE_BBQ_BEEF_(2_VIANDES).png',3,1),
(26,'Signature Beef BBQ',10.30,'/burgers/SIGNATURE_BEEF_BBQ_BURGER_(1_VIANDE).png',3,1),
(27,'Coca Cola',1.90,'/boissons/coca-cola.png',2,1),
(28,'Coca Sans Sucres',1.80,'/boissons/coca-sans-sucres.png',2,1),
(29,'Eau',1.00,'/boissons/eau.png',2,1),
(30,'Fanta Orange',1.90,'/boissons/fanta.png',2,1),
(31,'Ice Tea Pêche',1.90,'/boissons/ice-tea-peche.png',2,1),
(32,'Ice Tea Citron',1.90,'/boissons/the-vert-citron-sans-sucres.png',2,1),
(33,'Jus d\'Orange',2.10,'/boissons/jus-orange.png',2,1),
(34,'Jus de Pommes Bio',2.30,'/boissons/jus-pomme-bio.png',2,1),
(35,'Petite Frite',1.45,'/frites/PETITE_FRITE.png',4,1),
(36,'Moyenne Frite',2.75,'/frites/685bbfb878859-frites-flamandes.webp',4,1),
(37,'Grande Frite',3.50,'/frites/GRANDE_FRITE.png',4,1),
(38,'Potatoes',2.15,'/frites/POTATOES.png',4,1),
(39,'Grande Potatoes',3.40,'/frites/GRANDE_POTATOES.png',4,1),
(40,'Cheeseburger',2.60,'/encas/cheeseburger.png.png',5,1),
(41,'Croc MCdo',3.20,'/encas/croc-mc-do.png',5,1),
(42,'Nuggets x4',4.20,'/encas/nuggets_4.png',5,1),
(43,'Nuggets x20',13.00,'/encas/nuggets_20.png',5,1),
(44,'Brownie',2.60,'/desserts/brownies.png',8,1),
(45,'Cheesecake chocolat M&M\'S',3.10,'/desserts/cheesecake_choconuts_M&M_s.png',8,1),
(46,'Cheesecake Fraise',3.10,'/desserts/cheesecake_fraise.png',8,1),
(47,'Cookie',3.20,'/desserts/cookie.png',8,1),
(48,'Donut',2.60,'/desserts/doghnut.png',8,1),
(49,'Macarons',2.70,'/desserts/macarons.png',8,1),
(50,'MC Fleury',4.40,'/desserts/MCFleury.png',8,1),
(51,'Muffin',3.60,'/desserts/muffin.png',8,1),
(52,'Sunday',1.00,'/desserts/sunday.png',8,1),
(53,'Classic Barbecue',0.70,'/sauces/classic-barbecue.png',9,1),
(54,'Classic Moutarde',0.70,'/sauces/classic-moutarde.png',9,1),
(55,'Creamy Deluxe',0.70,'/sauces/cremy-deluxe.png',9,1),
(56,'Ketchup',0.70,'/sauces/ketchup.png',9,1),
(57,'Chinoise',0.70,'/sauces/sauce-chinoise.png',9,1),
(58,'Curry',0.70,'/sauces/sauce-curry.png',9,1),
(59,'Pommes Frites',0.70,'/sauces/sauce-pommes-frite.png',9,1),
(60,'Petite Salade',3.30,'/salades/PETITE-SALADE.png',7,1),
(61,'Cesar Classic',8.80,'/salades/SALADE_CLASSIC_CAESAR.png',7,1),
(62,'Italienne Mozza',8.80,'/salades/SALADE_ITALIAN_MOZZA.png',7,1),
(63,'MC Wrap chevre',3.10,'/wraps/mcwrap-chevre.png',6,1),
(64,'MC Wrap Poulet Bacon',3.30,'/wraps/MCWRAP-POULET-BACON.png',6,1),
(65,'Ptit Wrap Chevre',2.60,'/wraps/PTIT_WRAP_CHEVRE.png',6,1),
(66,'Ptit Wrap Ranch',2.60,'/wraps/PTIT_WRAP_RANCH.png',6,1),
(68,'Encore Nouveau burger',10.80,'/burgers/6863a8354bb0b-burger.webp',3,1);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reset_password`
--

DROP TABLE IF EXISTS `reset_password`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `reset_password` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reset_password`
--

LOCK TABLES `reset_password` WRITE;
/*!40000 ALTER TABLE `reset_password` DISABLE KEYS */;
INSERT INTO `reset_password` VALUES
(22,'de@sfr.fr','2336b2ac001b395faa069fd1f9acc9999b70b2e70f972c01593d70595ebd0e0aa193bd50a247fdd9178973fe4139cf48824e','2025-06-25 13:31:51');
/*!40000 ALTER TABLE `reset_password` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(30) DEFAULT NULL,
  `lastname` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `function` varchar(15) DEFAULT NULL,
  `isConnected` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Bruno','FITTE','bruno.fitte@sfr.fr','$2y$10$Y3uipPgh25P0sS9ts3pvZeRH.HChpAX0YHTGG69zWl5oK.MRNlSUm','ADMIN',1),
(2,'Doudou','Dupond','db@sfr.fr','$2y$10$tIHCAOqcJb61zQF4Jk13EecaZDSvocUtzM8tKzCYSgWITkJL0D5tS','ACC',1),
(3,'Dédé','Huen','frd@sfr.fr','$2y$10$fF1HwiSEChWEm4fhj7vYSuiOVtq32bonBe/L7JfyxoFFVkTxUHC.i','PREP',1),
(5,'Bob','sde','dc@sfr.fr','$2y$10$PtRc.D4fYPata.5ocsRtLeJ7kgaouZpkT0vrRM9CCW4I.IcZNAuDG','PREP',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'wacdo_name'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-07-04 14:03:46
