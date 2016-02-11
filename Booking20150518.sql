-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: Booking
-- ------------------------------------------------------
-- Server version	5.5.43-0ubuntu0.14.04.1

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
-- Table structure for table `Calendar_Events`
--

DROP TABLE IF EXISTS `Calendar_Events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Calendar_Events` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Event_Req_Id` int(11) DEFAULT NULL,
  `Title` varchar(255) NOT NULL,
  `Start_Date` varchar(48) NOT NULL,
  `End_Date` varchar(48) NOT NULL,
  `All_Day_Event` varchar(5) NOT NULL DEFAULT 'false',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Calendar_Events`
--

LOCK TABLES `Calendar_Events` WRITE;
/*!40000 ALTER TABLE `Calendar_Events` DISABLE KEYS */;
/*!40000 ALTER TABLE `Calendar_Events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Company`
--

DROP TABLE IF EXISTS `Company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Company` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Company_Name` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`),
  UNIQUE KEY `Company_Name_UNIQUE` (`Company_Name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Company`
--

LOCK TABLES `Company` WRITE;
/*!40000 ALTER TABLE `Company` DISABLE KEYS */;
INSERT INTO `Company` VALUES (1,'Vectronics'),(2,'Vectronics2');
/*!40000 ALTER TABLE `Company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Company_Notification_Config`
--

DROP TABLE IF EXISTS `Company_Notification_Config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Company_Notification_Config` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Event_Type` varchar(20) NOT NULL,
  `Tweet` tinyint(1) NOT NULL DEFAULT '0',
  `Email` tinyint(1) NOT NULL DEFAULT '0',
  `Push` tinyint(1) NOT NULL DEFAULT '0',
  `Originator` tinyint(1) NOT NULL DEFAULT '0',
  `Driver` tinyint(1) NOT NULL DEFAULT '0',
  `Rep` tinyint(1) NOT NULL DEFAULT '0',
  `Admin` tinyint(1) NOT NULL DEFAULT '0',
  `Manager` tinyint(1) NOT NULL DEFAULT '0',
  `Finances` tinyint(1) NOT NULL DEFAULT '0',
  `Guest` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`),
  UNIQUE KEY `Event_Type_UNIQUE` (`Event_Type`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Company_Notification_Config`
--

LOCK TABLES `Company_Notification_Config` WRITE;
/*!40000 ALTER TABLE `Company_Notification_Config` DISABLE KEYS */;
INSERT INTO `Company_Notification_Config` VALUES (1,'Event_Create',0,0,1,0,1,0,0,1,0,0),(2,'Event_Delete',0,0,1,0,1,0,0,0,0,0),(3,'Event_Update',0,0,1,0,1,0,0,0,0,0),(4,'Event_Acknowledge',0,0,1,1,0,0,0,0,0,0),(5,'Event_Unacknowledge',0,0,1,1,0,0,0,0,0,0),(6,'Event_Delivery',0,0,1,1,0,0,0,0,0,0),(7,'Event_Patient_Update',0,0,1,0,0,0,0,0,0,0),(8,'Event_Usages',0,0,1,0,1,0,0,0,1,0),(9,'Event_Collection',0,0,1,1,0,0,0,1,0,0);
/*!40000 ALTER TABLE `Company_Notification_Config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Doctors`
--

DROP TABLE IF EXISTS `Doctors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Doctors` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Contact` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Doctors`
--

LOCK TABLES `Doctors` WRITE;
/*!40000 ALTER TABLE `Doctors` DISABLE KEYS */;
INSERT INTO `Doctors` VALUES (1,'Dr. S Vermaak','0823827182'),(2,'Dr. H Visser','0823824122'),(3,'Dr. J du Preez','0823827432'),(4,'Dr. M Minny','0834327182'),(5,'Dr. T van As','0824342182'),(6,'Dr. A van der Westhuizen','0823843234');
/*!40000 ALTER TABLE `Doctors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Equipment_Sets`
--

DROP TABLE IF EXISTS `Equipment_Sets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Equipment_Sets` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`),
  UNIQUE KEY `Description_UNIQUE` (`Description`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Equipment_Sets`
--

LOCK TABLES `Equipment_Sets` WRITE;
/*!40000 ALTER TABLE `Equipment_Sets` DISABLE KEYS */;
INSERT INTO `Equipment_Sets` VALUES (1,'Aculoc'),(2,'Aculoc2'),(3,'Acutrak2'),(5,'Acutrak2 elbow'),(4,'Acutrak2 large'),(15,'Ankle plates'),(8,'Anterior/leteral plates'),(7,'Clavicle'),(13,'Fibula rod'),(14,'Forearm plates'),(6,'Hexalobe'),(11,'Hps cannulated screws'),(10,'Hps head'),(12,'Polarus3'),(9,'Radial head replacement'),(16,'Universal set');
/*!40000 ALTER TABLE `Equipment_Sets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Event_Collect`
--

DROP TABLE IF EXISTS `Event_Collect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Event_Collect` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Event_Req_Id` int(11) NOT NULL,
  `Collected_By` int(11) NOT NULL,
  `Timestamp` datetime NOT NULL,
  `Used` varchar(3) NOT NULL,
  `TIMESTAMPREC` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Event_Collect`
--

LOCK TABLES `Event_Collect` WRITE;
/*!40000 ALTER TABLE `Event_Collect` DISABLE KEYS */;
INSERT INTO `Event_Collect` VALUES (23,136,9,'2015-05-15 10:45:00','Yes','2015-05-15 08:36:45'),(24,129,13,'2015-05-15 13:30:00','Yes','2015-05-15 11:20:26'),(25,131,13,'2015-05-15 13:30:00','Yes','2015-05-15 11:20:56'),(26,130,13,'2015-05-15 13:30:00','Yes','2015-05-15 11:21:11'),(27,141,11,'2015-05-18 08:45:00','Yes','2015-05-18 06:36:41'),(28,98,9,'2015-05-18 09:15:00','Yes','2015-05-18 07:08:45'),(29,143,9,'2015-05-18 09:30:00','Yes','2015-05-18 07:22:22'),(30,145,11,'2015-05-18 10:30:00','Yes','2015-05-18 08:18:02');
/*!40000 ALTER TABLE `Event_Collect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Event_Delivery`
--

DROP TABLE IF EXISTS `Event_Delivery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Event_Delivery` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Event_Req_Id` int(11) NOT NULL,
  `Delivered_By` int(11) NOT NULL,
  `CSSD_Name` varchar(255) NOT NULL,
  `Timestamp` datetime NOT NULL,
  `Set_Number` varchar(255) NOT NULL,
  `TIMESTAMPREC` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Event_Delivery`
--

LOCK TABLES `Event_Delivery` WRITE;
/*!40000 ALTER TABLE `Event_Delivery` DISABLE KEYS */;
INSERT INTO `Event_Delivery` VALUES (46,132,15,'Maria','2015-05-15 08:45:00','7','2015-05-15 06:45:48'),(47,134,15,'Katie','2015-05-15 08:50:00','1','2015-05-15 06:47:20'),(48,133,15,'Sidney','2015-05-15 08:50:00','2','2015-05-15 06:49:37'),(49,135,13,'Pieter','2015-05-15 09:30:00','9','2015-05-15 07:27:40'),(50,136,9,'John Doe2','2015-05-15 10:15:00','9','2015-05-15 08:15:45'),(51,138,11,'','2015-05-17 21:20:00','1','2015-05-17 19:18:30'),(52,141,11,'','2015-05-18 08:40:00','1','2015-05-18 06:36:11'),(53,143,9,'John Doe','2015-05-18 04:15:00','14','2015-05-18 07:15:27'),(54,144,9,'Koos Bezuidenhout','2015-05-18 09:25:00','11','2015-05-18 07:25:33'),(55,145,11,'','2015-05-18 10:20:00','1','2015-05-18 08:16:50');
/*!40000 ALTER TABLE `Event_Delivery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Event_Patient`
--

DROP TABLE IF EXISTS `Event_Patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Event_Patient` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Event_Req_Id` int(11) NOT NULL,
  `Patient_Name` varchar(255) NOT NULL,
  `Patient_Nr` varchar(45) DEFAULT NULL,
  `Order_Nr` varchar(45) DEFAULT NULL,
  `TIMESTAMPREC` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Event_Patient`
--

LOCK TABLES `Event_Patient` WRITE;
/*!40000 ALTER TABLE `Event_Patient` DISABLE KEYS */;
INSERT INTO `Event_Patient` VALUES (13,100,'John Doe','100998872','#00102','2015-05-15 08:08:35'),(14,136,'Siek persoon 1','1233321','233422','2015-05-15 08:17:41'),(15,129,'J. Marais','Mar1234','9089778','2015-05-15 10:43:11'),(16,131,'P. Claasen','CLA1836','99891123','2015-05-15 10:44:34'),(17,130,'J. Muller','MUL12980','76098112','2015-05-15 10:45:51'),(18,137,'hhh','8654357','578','2015-05-16 11:35:06'),(19,138,'asda','asdas','asdad','2015-05-17 19:18:50'),(20,139,'yj','jtyj','tyjtj','2015-05-17 20:02:59'),(21,142,'hhtr','hrth','rthrth','2015-05-18 06:35:51'),(22,141,'dfvd','dfvd','dvd','2015-05-18 06:36:29'),(23,143,'Person XYZ','0987','12234','2015-05-18 07:17:55'),(24,144,'Stefan Marais','123','3211','2015-05-18 07:27:17'),(25,145,'fdgd','dfgdf','gdfgdg','2015-05-18 08:17:30');
/*!40000 ALTER TABLE `Event_Patient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Event_Req`
--

DROP TABLE IF EXISTS `Event_Req`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Event_Req` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Organiser` int(11) NOT NULL,
  `Hospital` int(11) NOT NULL,
  `Doctor` int(11) NOT NULL,
  `Delivery_Date` datetime NOT NULL,
  `Operation_Date` datetime NOT NULL,
  `Equipment_Required` int(11) NOT NULL,
  `Consignment` tinyint(1) NOT NULL DEFAULT '0',
  `Rep_Attend` varchar(3) NOT NULL,
  `Comments` varchar(255) DEFAULT NULL,
  `Status` varchar(10) DEFAULT NULL,
  `Driver_Ack` int(11) DEFAULT NULL,
  `TIMESTAMPREC` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Event_Req`
--

LOCK TABLES `Event_Req` WRITE;
/*!40000 ALTER TABLE `Event_Req` DISABLE KEYS */;
INSERT INTO `Event_Req` VALUES (134,11,4,5,'2015-05-14 00:00:00','2015-05-14 23:30:00',1,0,'Yes','None','delivered',15,'2015-05-14 21:29:36'),(135,15,2,5,'2015-05-15 00:00:00','2015-05-16 14:00:00',9,0,'Yes','Please send full ARHR set. ','delivered',13,'2015-05-15 06:57:25'),(136,9,6,1,'2015-05-15 00:00:00','2015-05-15 10:15:00',9,0,'Yes','Maak vir my koffie','closed',9,'2015-05-15 08:11:19'),(137,9,1,5,'2015-05-19 00:00:00','2015-05-20 10:45:00',6,1,'Yes','None','closed',NULL,'2015-05-16 11:34:02'),(138,11,3,4,'2015-05-17 00:00:00','2015-05-17 21:30:00',1,0,'Yes','None','used',11,'2015-05-17 19:18:14'),(139,11,2,4,'2015-05-17 00:00:00','2015-05-17 22:15:00',1,1,'Yes','None','used',NULL,'2015-05-17 20:02:24'),(140,11,1,6,'2015-05-17 00:00:00','2015-05-17 22:15:00',1,0,'Yes','None','created',NULL,'2015-05-17 20:02:39'),(141,11,3,5,'2015-05-18 00:00:00','2015-05-18 08:45:00',1,0,'Yes','None','closed',11,'2015-05-18 06:35:09'),(142,11,4,6,'2015-05-18 00:00:00','2015-05-18 08:45:00',1,1,'Yes','None','closed',NULL,'2015-05-18 06:35:26'),(143,9,6,6,'2015-05-18 00:00:00','2015-05-18 09:15:00',14,0,'Yes','Maak sterk koffie','closed',9,'2015-05-18 07:14:27'),(144,9,64,1,'2015-05-18 00:00:00','2015-05-18 09:30:00',11,0,'No','Geen','used',9,'2015-05-18 07:24:23'),(145,11,3,1,'2015-05-18 00:00:00','2015-05-18 10:30:00',1,0,'Yes','None','closed',11,'2015-05-18 08:16:33');
/*!40000 ALTER TABLE `Event_Req` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Event_Usage`
--

DROP TABLE IF EXISTS `Event_Usage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Event_Usage` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Event_Req_Id` int(11) NOT NULL,
  `Stock_Code` int(11) NOT NULL,
  `Qty_Used` int(11) NOT NULL,
  `Qty_Refilled` int(11) NOT NULL,
  `TIMESTAMPREC` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Event_Usage`
--

LOCK TABLES `Event_Usage` WRITE;
/*!40000 ALTER TABLE `Event_Usage` DISABLE KEYS */;
INSERT INTO `Event_Usage` VALUES (93,100,5,5,8,'2015-05-15 08:08:33'),(94,100,9,6,0,'2015-05-15 08:08:34'),(95,100,3,5,0,'2015-05-15 08:08:35'),(96,136,8,1,0,'2015-05-15 08:17:38'),(97,136,7,1,0,'2015-05-15 08:17:39'),(98,136,6,1,1,'2015-05-15 08:17:39'),(99,136,5,1,8,'2015-05-15 08:17:40'),(100,129,1,3,0,'2015-05-15 10:43:09'),(101,129,2,2,2,'2015-05-15 10:43:10'),(102,131,7,1,0,'2015-05-15 10:44:31'),(103,131,8,3,0,'2015-05-15 10:44:32'),(104,131,9,4,0,'2015-05-15 10:44:33'),(105,130,6,1,1,'2015-05-15 10:45:47'),(106,130,8,2,0,'2015-05-15 10:45:48'),(107,130,9,5,0,'2015-05-15 10:45:49'),(108,130,10,3,6,'2015-05-15 10:45:50'),(109,130,12,2,0,'2015-05-15 10:45:50'),(110,137,10,6,6,'2015-05-16 11:35:03'),(111,137,5,8,8,'2015-05-16 11:35:04'),(112,137,2,2,2,'2015-05-16 11:35:06'),(113,138,4,1,1,'2015-05-17 19:18:49'),(114,138,8,4,0,'2015-05-17 19:18:50'),(115,138,10,3,0,'2015-05-17 19:18:50'),(116,139,5,1,0,'2015-05-17 20:02:58'),(117,139,7,1,0,'2015-05-17 20:02:58'),(118,142,4,1,1,'2015-05-18 06:35:50'),(119,142,6,1,1,'2015-05-18 06:35:51'),(120,141,6,1,1,'2015-05-18 06:36:28'),(121,141,8,1,0,'2015-05-18 06:36:29'),(122,143,1,9,0,'2015-05-18 07:17:54'),(123,143,8,10,0,'2015-05-18 07:17:54'),(124,143,7,11,0,'2015-05-18 07:17:55'),(125,144,1,10,0,'2015-05-18 07:27:15'),(126,144,8,10,0,'2015-05-18 07:27:16'),(127,144,5,10,0,'2015-05-18 07:27:16'),(128,145,4,4,0,'2015-05-18 08:17:29'),(129,145,7,1,0,'2015-05-18 08:17:30');
/*!40000 ALTER TABLE `Event_Usage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Hospitals`
--

DROP TABLE IF EXISTS `Hospitals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Hospitals` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `Contact` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Hospitals`
--

LOCK TABLES `Hospitals` WRITE;
/*!40000 ALTER TABLE `Hospitals` DISABLE KEYS */;
INSERT INTO `Hospitals` VALUES (1,'Abey K Medical Centre','1\r'),(2,'Akasia Private Hospital','1\r'),(3,'Arwyp Clinic','1\r'),(4,'Bedford Gardens Clinic','1\r'),(5,'Bell Street Hospital','1\r'),(6,'Botshelong Empilweni Private Hospital','1\r'),(7,'Carstenhof Clinic','1\r'),(8,'Charlotte Maxeke Johannesburg Academic Hospital','1\r'),(9,'Chris Hani Baragwanath Hospital','1\r'),(10,'Conner Stone Hospital','1\r'),(11,'Coronation Hospital','1\r'),(12,'Denmar Psychiatric Hospital','1\r'),(13,'Denver Hospital','1\r'),(14,'Dr George Mukhari Hospital','1\r'),(15,'East Rand N17 Private Hospital','1\r'),(16,'Eugene Marais Hospital','1\r'),(17,'Faerie Glen Hospital','1\r'),(18,'Far East Rand Hospital','1\r'),(19,'Flora Clinic','1\r'),(20,'Gateway House Psychiatric Residence','1\r'),(21,'Glynnwood Hospital','1\r'),(22,'Helen Joseph Hospital','1\r'),(23,'Jacaranda Hospital','1\r'),(24,'Johannesburg and surrounds','1\r'),(25,'Kalafong Hospital','1\r'),(26,'Kopanong Hospital','1\r'),(27,'Krugersdorp Private Hospital','1\r'),(28,'Lenmed Clinic','1\r'),(29,'Leratong Hospital','1\r'),(30,'Life Blue Cross Hospital','1\r'),(31,'Life Roseacres','1\r'),(32,'Linmed Clinic','1\r'),(33,'Little Company of Mary Hospital','1\r'),(34,'Louis Pasteur Hospital','1\r'),(35,'Mamelodi Hospital','1\r'),(36,'Marymount Hospital','1\r'),(37,'Mediclinic Emfuleni','1\r'),(38,'Mediclinic Gynaecological Hospital','1\r'),(39,'Mediclinic Heart Hospital','1\r'),(40,'Mediclinic Kloof','1\r'),(41,'Mediclinic Medforum','1\r'),(42,'Mediclinic Morningside','1\r'),(43,'Mediclinic Muelmed','1\r'),(44,'Mediclinic Sandton','1\r'),(45,'Mediclinic Vereeniging','1\r'),(46,'Midvaal Hospitaal','1\r'),(47,'Moot General Hospital','1\r'),(48,'Natalspruit Hospital','1\r'),(49,'Netcare Bagleyston Hospital','1\r'),(50,'Netcare Garden City Hospital','1\r'),(51,'Netcare Linksfield Hospital','1\r'),(52,'Netcare Linmed Hospital','1\r'),(53,'Netcare Milpark Hospital','1\r'),(54,'Netcare Montana Hospital','1\r'),(55,'Netcare Mulbarton Hospital','1\r'),(56,'Netcare Olivedale Hospital','1\r'),(57,'Netcare Optiklin Eye Hospital','1\r'),(58,'Netcare Park Lane Hospital','1\r'),(59,'Netcare Rand Hospital','1\r'),(60,'Netcare Rehabilitation Hospital','1\r'),(61,'Netcare Rosebank Hospital','1\r'),(62,'Netcare Rosewood Day Hospital','1\r'),(63,'Netcare Sandton Hospital','1\r'),(64,'Netcare Sunninghill Hospital','1\r'),(65,'Netcare Sunward Park Hospital','1\r'),(66,'Netcare Unitas Hospital','1\r'),(67,'Netcare Waterfall Hospital in partnership with Phelang Benolo','1\r'),(68,'Pholosong Hospital','1\r'),(69,'Pretoria East Private Hospital','1\r'),(70,'Pretoria Eye Institute','1\r'),(71,'Pretoria Urology Hospital','1\r'),(72,'Pretoria West Hospital','1\r'),(73,'Robinson Hospital','1\r'),(74,'Sebokeng Hospital','1\r'),(75,'South Rand Hospital','1\r'),(76,'Springs Parkland Clinic','1\r'),(77,'Steve Biko Hospital','1\r'),(78,'Sunshine Hospital','1\r'),(79,'Sunward Park Hospital','1\r'),(80,'Tara Psychiatric Hospital','1\r'),(81,'Tembisa Hospital','1\r'),(82,'Tropicana Hospital','1\r'),(83,'Tshwane District Hospital','1\r'),(84,'Union Hospital','1\r'),(85,'Vista Psychiatric Hospital','1\r'),(86,'Weskoppies Psychiatric Hospital','1\r'),(87,'Wilgeheuwel Hospital','1\r'),(88,'Wilgers Hospital','1\r'),(89,'Wits University Donald Gordon Medical Centre','1\r'),(90,'Zuid-Afrikaans Hospital','1\r');
/*!40000 ALTER TABLE `Hospitals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Notification_Config`
--

DROP TABLE IF EXISTS `Notification_Config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Notification_Config` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `User_Id` int(11) unsigned NOT NULL,
  `Global_Enable` tinyint(1) NOT NULL DEFAULT '1',
  `Primary_Email` tinyint(1) NOT NULL DEFAULT '1',
  `Geo_Fence` tinyint(1) NOT NULL DEFAULT '1',
  `Speeding` tinyint(1) NOT NULL DEFAULT '1',
  `Stationary_Time` tinyint(1) NOT NULL DEFAULT '1',
  `Excess_Distance` tinyint(1) NOT NULL DEFAULT '1',
  `Excess_Fuel` tinyint(1) NOT NULL DEFAULT '1',
  `Crash` tinyint(1) NOT NULL DEFAULT '1',
  `Soft_Lock` tinyint(1) NOT NULL DEFAULT '1',
  `Driver_Rest` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`),
  UNIQUE KEY `User_Id_UNIQUE` (`User_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Notification_Config`
--

LOCK TABLES `Notification_Config` WRITE;
/*!40000 ALTER TABLE `Notification_Config` DISABLE KEYS */;
INSERT INTO `Notification_Config` VALUES (1,11,1,1,1,1,1,1,1,1,1,1),(2,10,1,1,1,1,1,1,1,1,1,1),(3,9,1,1,1,1,1,1,1,1,1,1);
/*!40000 ALTER TABLE `Notification_Config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Notification_Times`
--

DROP TABLE IF EXISTS `Notification_Times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Notification_Times` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `User_Id` int(11) unsigned NOT NULL,
  `Start_Time` time NOT NULL DEFAULT '00:00:00',
  `End_Time` time NOT NULL DEFAULT '00:00:00',
  `Saturday_Start_Time` time NOT NULL DEFAULT '00:00:00',
  `Saturday_End_Time` time NOT NULL DEFAULT '00:00:00',
  `Sunday_Start_Time` time NOT NULL DEFAULT '00:00:00',
  `Sunday_End_Time` time NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`),
  UNIQUE KEY `User_Id_UNIQUE` (`User_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Notification_Times`
--

LOCK TABLES `Notification_Times` WRITE;
/*!40000 ALTER TABLE `Notification_Times` DISABLE KEYS */;
INSERT INTO `Notification_Times` VALUES (1,11,'08:00:00','23:40:00','08:30:00','16:00:00','10:00:00','15:00:00'),(2,10,'10:00:00','23:40:00','08:30:00','16:00:00','09:00:00','15:00:00'),(3,9,'00:00:00','10:00:00','11:31:00','16:00:00','01:00:00','15:00:00');
/*!40000 ALTER TABLE `Notification_Times` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Set_Spares`
--

DROP TABLE IF EXISTS `Set_Spares`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Set_Spares` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Stock_Code` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Set_Spares`
--

LOCK TABLES `Set_Spares` WRITE;
/*!40000 ALTER TABLE `Set_Spares` DISABLE KEYS */;
INSERT INTO `Set_Spares` VALUES (1,'0001','PartAAAA'),(2,'0002','PartAABB'),(3,'0003','PartABCX'),(4,'0004','PartAZZX'),(5,'0005','PlateXXX'),(6,'0006','PlateXBB'),(7,'0007','PlateXCC'),(8,'0008','ScrewAAA'),(9,'0009','ScrewACC'),(10,'0010','ScrewAXX'),(11,'0011','ScrewZZZ'),(12,'0012','PinAAA'),(13,'0013','PinAZZ'),(14,'0014','PinACC'),(15,'0015','PinABC'),(16,'0016','NeedleAAA'),(17,'0017','NeedleCC'),(18,'0018','NeedleAFF'),(19,'0019','NeedleCOS'),(20,'0020','PinACH');
/*!40000 ALTER TABLE `Set_Spares` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User_Groups`
--

DROP TABLE IF EXISTS `User_Groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User_Groups` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `User_Group` varchar(50) NOT NULL,
  `Permissions` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`),
  UNIQUE KEY `User_Group_UNIQUE` (`User_Group`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User_Groups`
--

LOCK TABLES `User_Groups` WRITE;
/*!40000 ALTER TABLE `User_Groups` DISABLE KEYS */;
INSERT INTO `User_Groups` VALUES (1,'1','{\"Admin\":\"true\",\"CompAdmin\":\"true\",\"Standard\":\"true\",\"Rep\":\"true\",\"Driver\":\"true\"}'),(2,'2','{\"Admin\":\"false\",\"CompAdmin\":\"true\",\"Standard\":\"true\",\"Rep\":\"false\",\"Driver\":\"false\"}'),(3,'3','{\"Admin\":\"false\",\"CompAdmin\":\"false\",\"Standard\":\"true\",\"Rep\":\"false\",\"Driver\":\"false\"}'),(4,'4','{\"Admin\":\"false\",\"CompAdmin\":\"false\",\"Standard\":\"false\",\"Rep\":\"false\",\"Driver\":\"false\"}'),(5,'5','{\"Admin\":\"false\",\"CompAdmin\":\"false\",\"Standard\":\"false\",\"Rep\":\"true\",\"Driver\":\"false\"}'),(6,'6','{\"Admin\":\"false\",\"CompAdmin\":\"false\",\"Standard\":\"false\",\"Rep\":\"false\",\"Driver\":\"true\"}');
/*!40000 ALTER TABLE `User_Groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User_Sessions`
--

DROP TABLE IF EXISTS `User_Sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User_Sessions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `User_Id` int(11) unsigned NOT NULL,
  `Hash` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User_Sessions`
--

LOCK TABLES `User_Sessions` WRITE;
/*!40000 ALTER TABLE `User_Sessions` DISABLE KEYS */;
INSERT INTO `User_Sessions` VALUES (20,10,'30f5aa68557cd6a0900183df1289ba576bda04dbb0c7ba66b0dfe7f2688f2721'),(26,11,'c60e849db4f20486929135ac3d532b1cd33ab94f44131251dd4bd775c313ebb5'),(27,8,'04e898404c71d1d7e4323927ec494c0eee2341cb36df068aacc26673a570c051'),(28,9,'79207f8a2da52d2cc82b4af6e2f069b96e1b4c5456bb6ae95b3f1334defa03a3'),(29,13,'4f5929fa808d8a62a083d8a47a505dc5d8743d2cf5e5433d2ea92e02d8ed3a42'),(30,15,'726e88627ca6d7324cc54542f0ef321fb7881a24c766f2164ec8b684126a1134');
/*!40000 ALTER TABLE `User_Sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) NOT NULL,
  `Full_Name` varchar(100) NOT NULL,
  `User_Group` tinyint(3) NOT NULL,
  `Company_Id` int(11) NOT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Salt` varchar(255) DEFAULT NULL,
  `User_Cellphone` varchar(10) DEFAULT NULL,
  `Push_Id` varchar(45) DEFAULT NULL,
  `User_Verified` tinyint(1) NOT NULL DEFAULT '0',
  `Confirm_Hash` varchar(255) DEFAULT NULL,
  `Old_User` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`),
  UNIQUE KEY `Username_UNIQUE` (`Username`),
  UNIQUE KEY `Push_Id_UNIQUE` (`Push_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (8,'Mariusminny@gmail.com','Marius Minny2',6,2,'bfb288528dd2012eb6cee0e3302ac413a9bbd42c1f32312b283af4eb0908fac4','üÙªx~\"çF„5\\,ûQßû±c²ÿ¤áÌ¸?P5Óþ',NULL,NULL,1,NULL,NULL),(9,'Johan@vectronics.co.za','Johan du Preez',5,1,'fb2c22a9678da6d0d3eef054cc51a55e05e701d462111e26a8cde2baa363919a','úèÖóEª~·qP¾ƒJtÉMxs¯Ž.+‹qA','0822815216','uXCR7oWJJWUQcyziwRYSXFuv2JoL3Q',1,NULL,NULL),(10,'Thomas@vectronics.co.za','Thomas van As',5,1,'5ae1301b56b5660029d1d061a7f584005ca58d1444a29bbab9ab52c367de2939','Iº¥­<Y5®Vd©E²-©³oÈÖ×V×;mûbÕ',NULL,'u8viPdYVwXJcyr5bja5Eo1e59uyYCE',1,NULL,NULL),(11,'marius@vectronics.co.za','Marius Minny',5,1,'454a57382e7450e2ebef5c435875a7b60d674ae9c091d117d7eb1a9035cb007c','gP´¿ŠšÙ^Á´/“Y¬Ÿoû’e-\'ûáädñ','0846588845','urx2HjhSFfhpensycMVsCyugF7dDTF',1,NULL,NULL),(13,'antonievanaardt@gmail.com','Antonie van Aardt',5,1,'f04adfd872ba33ca27aad66767b42894d5405b4892cac8f3df5e6550787be2bb','£ùö×\rãuè­×ö«ÊÀ\ZT´ ÔUU6Îc eh\\¯',NULL,NULL,1,NULL,NULL),(14,'johnny@e-c-p.co.za','Johnny van Aardt',5,1,NULL,NULL,NULL,NULL,0,'2342342342',NULL),(15,'rikus.venter@gmail.com','Rikus Venter',5,1,'311c2d675627faad325ddd1b36bd6289a9c3fab21b7e859a366bbfcef6d9b85a','qXŸr±ê	™Fm¡­3å©A¿Dsýàƒ\"æ3f0¨¿',NULL,NULL,1,NULL,NULL);
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-18 11:47:45
