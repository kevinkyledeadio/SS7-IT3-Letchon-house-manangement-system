-- MySQL dump 10.19  Distrib 10.3.39-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: mariadb
-- ------------------------------------------------------
-- Server version	10.3.39-MariaDB-0ubuntu0.20.04.2

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
-- Table structure for table `additional_items`
--

DROP TABLE IF EXISTS `additional_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `additional_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `additional_items`
--

LOCK TABLES `additional_items` WRITE;
/*!40000 ALTER TABLE `additional_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `additional_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (2,'kevinkyle22','kyle@gmail.com','$2y$10$gNcWwhANPSsRTtMkH9WhVuKyk.E4YWL56rsEGC.7VRwmRTox0AFXm'),(3,'dragoncabol','cabol@gmail.com','$2y$10$KSiOnmguzhykFBwDL6tfuekCtPeuLfcVldjbZb9G.gwzWjVSSe5Yy'),(4,'dragonball','guko@gmail.com','$2y$10$KY5NMqa1tmOXSbVycSSgJO5lCSPPCNw14a.5zcxv6V7nGZRJdNhOK'),(5,'davecait','cait@gmail.cmo','$2y$10$R.csNM/xv7StQJWLD3fHNOnZYVkX/nXbbm7Re33z06jyCZ7aaFyjK'),(6,'testadmin','testadmin@gmail.com','$2y$10$Q4jIBC0bQCMA/yKDFTcgNOW8IJKcFygq5I6FgvBJSQ01kvn6UiFCO'),(7,'testnamee','testnamee@gmail.com','$2y$10$N.FqwU7.KYIFnefkBVGC2eKVYHQ2Z5SnOB3O058YaXUwCq8TzD1dq');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (3,'Cochinillo'),(2,'Lechon Belly'),(4,'Packages'),(1,'Whole Lechon');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (5,'kevinkyle22','$2y$10$/VJPiKvT2JZXIkxVkWAyCOH2q9MA552yn6rnSZWdNLDc8k6DyaP8e','kyle22@gmail.com',NULL,NULL),(6,'jhonlionel cabol','$2y$10$N8/4hJDy/A0cUUP6uVRIfed8WGj/w0xccYcBjcvUqah11HbyTLu22','cabol@gmail.com',NULL,NULL),(7,'john andrew lumbra','$2y$10$taA.chEjRBiMEDZ1T3GKIexjsPYC1DvDgN0.U6Ho8wub3OYpPqrMa','lumbra@gmail.com',NULL,NULL),(8,'ivony kandt','$2y$10$FeGNI564DkYsuBmRYDESBu/cpd7q1TOYDP./ux4h5s5p5QMzQ29K.','ivony@gmail.com',NULL,NULL),(10,'tesdtcustomer','$2y$10$4koz0EIbgs8Uy5lpjiZqLemoizAHI9zAxWercS9huuDk8dUAyhd5q','tesdtcustomer@gmail.com','tesdtcustomer address','091313132323232'),(11,'monkey D luffy','$2y$10$.YG4bPV/PbBcR5mw2GWDjOo3e/avOB94NmZh9me4P2RWTcZEcvnda','Luffy@gmail.com','Buru-un iligan city ','09923536556');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(50) NOT NULL,
  `image_url` text NOT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES (3,'50 kg.Whole Lechon','Lechon Baboy is a Filipino delicacy of whole roasted pig, known for its crispy skin and juicy, flavorful meat, often served at celebrations.',15000.00,'Whole Lechon','https://i.pinimg.com/736x/f6/a1/fb/f6a1fbe03fe68441302a2410d59eba24.jpg',0),(4,'26-29 kg.Whole Lechon','Lechon Baboy is a Filipino delicacy of whole roasted pig, known for its crispy skin and juicy, flavorful meat, often served at celebrations.',8500.00,'Whole Lechon','https://i.pinimg.com/736x/1f/8d/f1/1f8df1f71b11a7cea08d8f8defdf7ec3.jpg',0),(5,'5 kg.Lechon Belly','Boneless, herb-infused roasted pork belly.',3500.00,'lechon-belly','https://i.pinimg.com/736x/13/60/00/136000c3736b313c8cc4f1f2dd4dccd5.jpg',0),(6,'15-18 kg. Cochinillo','Spanish-style roasted suckling pig.',7500.00,'cochinillo','https://i.pinimg.com/736x/b6/d2/08/b6d2081a6b682837e9a48722bced52f5.jpg',0),(7,'PACKAGE 1','Whole lechon (20 kg.)\r\n1 M. Tray Paklay\r\n1 L. Tray Pancit Bihon Guisado\r\n1 L. Tray Pork Menudo\r\n1 L. Tray Pork Lumpia\r\n2 M. Trays Cheesy Maja Blanca\r\n1 Tier Customized Cake',11500.00,'packages','https://scontent.fmnl9-1.fna.fbcdn.net/v/t39.30808-6/476677562_611669125168909_7455862184778166647_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=f727a1&_nc_eui2=AeFjzkv-hpwSShz7SSYgAesR4PCiEEHg18Dg8KIQQeDXwON2j4Tcv786PUR0ekL9-eX0RSI5Z4JR1NBMAnT0emt6&_nc_ohc=CiA4V4IUu4YQ7kNvgFH7xzn&_nc_oc=AdlzPvNWEcLBNDHYXDSnYnTDRfX-pRmWL2g6ifeBt74Br7GFV9xMhVWC387-L353fJ0&_nc_zt=23&_nc_ht=scontent.fmnl9-1.fna&_nc_gid=96U1GXXMm_ao6VQmB6vMwg&oh=00_AYGBYT1JPwv_9CxDwaW9LJcIk8DKF0IS3kr3eXa6eWT2Bg&oe=67E2A80A',0),(8,'35-36 kg. Whole Lechon ','Lechon Baboy is a Filipino delicacy of whole roasted pig, known for its crispy skin and juicy, flavorful meat, often served at celebrations.',10000.00,'Whole Lechon','https://i.pinimg.com/736x/98/8d/31/988d314cad0263b3be6b596126df5608.jpg',0),(10,'PACKAGE 2','1 Whole Lechon (23 kg.)\r\n1 M. Tray Paklay\r\n1 L. Tray Pancit Bihon Guisado\r\n1 L. Tray Pork Menudo\r\n1 L. Tray Pork Lumpia\r\n1 L. Tray Chicken Fillet\r\n2 M. Trays Cheesy Maja Blanca\r\n1 Tier Customized Cake',12500.00,'packages','https://scontent.fmnl9-5.fna.fbcdn.net/v/t39.30808-6/481765522_614713751531113_77703246075465716_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=f727a1&_nc_eui2=AeGphntox5Rm9XIFmG2xF5a8z1yn9EW_BP3PXKf0Rb8E_dDjh3vrkD7FNjd0TPZtsX9RUjep-plPbdlS5bs01uOG&_nc_ohc=TM1xHmNI1jEQ7kNvgErCptc&_nc_oc=AdlxoodKSLo6RG0k_pW4sfHA85lpPPa2lwWqd4Gsfw5TqD9iWVN0_MF9r2eDlTLFsi8&_nc_zt=23&_nc_ht=scontent.fmnl9-5.fna&_nc_gid=IjqHqRTQl-SPtAvKfhduaA&oh=00_AYEbHpOa0Rorm8AeFk_0Zssw9LUnN6AagvXDRUc1O0G1Gg&oe=67E2AB42',0),(11,'PACKAGE 3','1 Whole Lechon (25 kg.)\r\n1 M. Tray Paklay\r\n1 L. Tray Pancit Bihon Guisado\r\n1 L. Tray Pork Menudo\r\n1 L. Tray Pork Lumpia\r\n1 L. Tray Chicken Fillet\r\n1 L. Tray Garlic Butter Shrimp\r\n2 M. Trays Cheesy Maja Blanca\r\n1 Tier Customized Cake',13500.00,'packages','https://scontent.fmnl9-5.fna.fbcdn.net/v/t39.30808-6/482807649_617590224576799_3198591216097905569_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=f727a1&_nc_eui2=AeH3zhEnO-tpZo5f70XrdLbAo435HO9l5hejjfkc72XmF-vRmeGpAA40sg5IWav-M7q7QMuaVPtxVYj2XEvy9hoH&_nc_ohc=WOQNF1vmwL0Q7kNvgG7Xuok&_nc_oc=Adl3GSKW5tJx4GfDCa2Fi4mFwuxpHjk8H7XwQsjRapbJyaUsmh-vWYoBwKbTpZKAdbU&_nc_zt=23&_nc_ht=scontent.fmnl9-5.fna&_nc_gid=daEqyCjZRUVQXxcdxixh6w&oh=00_AYE12vCSLCZcTMKxmKeFppaAiK64WtoRcvcl9uIf1nJ64Q&oe=67E2C7E9',0),(12,'PACKAGE 4','1 Whole Lechon (25 kg.)\r\n1 M. Tray Paklay\r\n1 L. Tray Pancit Bihon Guisado\r\n1 L. Tray Pork Menudo\r\n1 L. Tray Pork Lumpia\r\n1 L. Tray Chicken Fillet\r\n1 L. Tray Garlic Butter Shrimp\r\n1 L. Tray Buffalo Wings\r\n2 M. Trays Cheesy Maja Blanca\r\n1 Tier Customized Cake',14500.00,'packages','https://scontent.fmnl9-5.fna.fbcdn.net/v/t39.30808-6/481083188_616280481374440_3704015785303914366_n.jpg?_nc_cat=109&ccb=1-7&_nc_sid=f727a1&_nc_eui2=AeGSeLLPSg6Z8N3eNI7vTyvVS2iVQeiG_8hLaJVB6Ib_yDSd_-2ztj_PCS-uKVEbm7Ak5M87a70gUq3Dhh6S2No0&_nc_ohc=iXJ3INga0AoQ7kNvgErgYjD&_nc_oc=AdnoP6pUIuLm61LVyXGgcy0DVoNUmyWn4eSWqZMwLZ4SZRJoYO_OO2ADXJyTrTsEg5w&_nc_zt=23&_nc_ht=scontent.fmnl9-5.fna&_nc_gid=b01e6e4RQtlTKGftHfZkqQ&oh=00_AYGdIZnkfaQtyqw9NiOg_cFiC6FCH-w020RttDDWqJI7_g&oe=67E2C072',0),(13,'40-45 kg. Whole Lechon ','Lechon Baboy is a Filipino delicacy of whole roasted pig, known for its crispy skin and juicy, flavorful meat, often served at celebrations.',12000.00,'Whole Lechon','https://i.pinimg.com/736x/89/02/bb/8902bb5f5418e30b509db5abbc36dac5.jpg',0);
/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (10,38,'26-29 kg.Whole Lechon',2,8500.00);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_list`
--

DROP TABLE IF EXISTS `order_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `address` text NOT NULL,
  `Phone_number` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_list_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_list`
--

LOCK TABLES `order_list` WRITE;
/*!40000 ALTER TABLE `order_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `delivery_option` varchar(50) NOT NULL,
  `delivery_datetime` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `address` text NOT NULL,
  `Phone_number` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (38,10,17000.00,'2025-03-22 05:25:23','pickup','2025-03-22 06:00:00','Pending','tefsadfsad','926232323232');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-22  5:29:37
