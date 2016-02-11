CREATE DATABASE  IF NOT EXISTS `Booking` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `Booking`;
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
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Event_Collect`
--

LOCK TABLES `Event_Collect` WRITE;
/*!40000 ALTER TABLE `Event_Collect` DISABLE KEYS */;
INSERT INTO `Event_Collect` VALUES (1,59,11,'2015-04-30 10:45:00','Yes'),(2,65,11,'2015-04-30 17:45:00','Yes'),(3,66,9,'2015-05-07 21:15:00','Yes');
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
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Event_Delivery`
--

LOCK TABLES `Event_Delivery` WRITE;
/*!40000 ALTER TABLE `Event_Delivery` DISABLE KEYS */;
INSERT INTO `Event_Delivery` VALUES (1,41,11,'ek','2015-04-28 21:15:00','1'),(2,59,11,'','2015-04-30 10:45:00','1'),(3,53,10,'','2015-04-30 10:45:00','1'),(4,53,10,'','2015-04-30 10:45:00','1'),(5,65,11,'','2015-04-30 17:45:00','1'),(6,66,9,'Pieter','2015-05-06 14:15:00','9'),(7,70,9,'Reception','2015-04-30 23:30:00','1'),(8,61,9,'person Xxx','2015-05-01 08:45:00','8'),(9,6,9,'person y','2015-05-01 08:45:00','1'),(10,71,11,'asdasd','2015-05-01 09:15:00','1'),(11,72,9,'jjjjjjjjjj','2015-05-01 09:15:00','8');
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
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Event_Patient`
--

LOCK TABLES `Event_Patient` WRITE;
/*!40000 ALTER TABLE `Event_Patient` DISABLE KEYS */;
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
  `Driver_Ack` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Event_Req`
--

LOCK TABLES `Event_Req` WRITE;
/*!40000 ALTER TABLE `Event_Req` DISABLE KEYS */;
INSERT INTO `Event_Req` VALUES (1,11,1,1,'2015-04-27 20:00:00','2015-04-27 17:15:00',1,0,'Yes','sdadasda',NULL),(3,11,1,1,'2015-04-27 00:00:00','2015-04-27 20:45:00',1,0,'Yes','',8),(4,11,4,4,'2015-04-28 00:00:00','2015-04-28 21:30:00',1,0,'Yes','',11),(5,8,2,2,'2015-04-27 00:00:00','2015-04-27 21:45:00',2,0,'No',NULL,NULL),(6,8,3,3,'2015-04-27 00:00:00','2015-04-27 15:45:00',2,0,'No',NULL,9),(7,8,1,1,'2015-04-27 00:00:00','2015-04-27 16:45:00',3,0,'No',NULL,11),(40,8,1,1,'2015-04-28 00:00:00','2015-04-28 13:00:00',1,0,'Yes','',8),(41,11,1,1,'2015-04-28 00:00:00','2015-04-28 09:30:00',1,0,'Yes','',8),(42,11,1,1,'2015-04-28 00:00:00','2015-04-28 09:30:00',1,0,'Yes','',8),(53,11,1,1,'2015-04-28 00:00:00','2015-04-28 10:15:00',1,0,'Yes','',10),(57,11,1,1,'2015-04-28 00:00:00','2015-04-28 14:30:00',1,0,'Yes','',10),(58,11,5,3,'2015-04-28 00:00:00','2015-04-28 18:00:00',14,0,'No','',10),(59,11,4,3,'2015-04-29 00:00:00','2015-04-29 15:00:00',7,0,'Yes','nog n comment asadad asdasd asdalkj l lklkdald alskd alskd alskd laksd laksd laksd laks d',11),(60,9,6,3,'2015-05-03 00:00:00','2015-05-04 10:00:00',9,0,'Yes','None',10),(61,10,1,1,'2015-04-30 00:00:00','2015-04-30 09:15:00',1,0,'Yes','None',9),(62,10,1,1,'2015-04-30 00:00:00','2015-04-30 09:15:00',1,0,'Yes','None',10),(63,9,4,6,'2015-05-01 00:00:00','2015-05-02 13:30:00',9,0,'No','Maak vir my koffie',11),(65,11,1,1,'2015-04-30 00:00:00','2015-04-30 17:45:00',1,0,'Yes','None',11),(66,9,6,6,'2015-05-06 00:00:00','2015-05-07 15:00:00',9,0,'Yes','Bring alcohol',9),(67,9,4,1,'2015-04-30 00:00:00','2015-04-30 02:00:00',16,0,'No','Bring koffie saam',9),(68,9,1,1,'2015-04-30 00:00:00','2015-05-02 07:00:00',1,0,'Yes','bring koffie',NULL),(69,9,1,1,'2015-05-01 00:00:00','2015-04-01 10:00:00',1,0,'Yes','maak koffie',NULL),(70,9,1,1,'2015-05-01 00:00:00','2015-05-01 09:30:00',1,0,'Yes','Maak lekker koffie ',9),(71,11,1,1,'2015-05-01 00:00:00','2015-05-01 11:15:00',1,0,'Yes','None',11),(72,9,5,4,'2015-05-01 00:00:00','2015-05-01 09:15:00',8,1,'No','Gfujn',9);
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
  `Qty` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Event_Usage`
--

LOCK TABLES `Event_Usage` WRITE;
/*!40000 ALTER TABLE `Event_Usage` DISABLE KEYS */;
INSERT INTO `Event_Usage` VALUES (1,1,1,3),(2,65,7,4),(3,65,7,7),(4,65,3,7),(5,66,7,5),(6,66,8,10),(7,67,2,18),(8,67,1,20),(9,68,2,18),(10,68,1,19),(11,70,1,16),(12,70,2,1),(13,70,1,16),(14,1,10,5);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Hospitals`
--

LOCK TABLES `Hospitals` WRITE;
/*!40000 ALTER TABLE `Hospitals` DISABLE KEYS */;
INSERT INTO `Hospitals` VALUES (1,'Steve Biko Academic','0823827182'),(2,'Zuid Afrikaans','0823824122'),(3,'Eugene Marais','0823827432'),(4,'Wilgers','0834327182'),(5,'Pretoria-East','0824342182'),(6,'Montana','0823843234');
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User_Sessions`
--

LOCK TABLES `User_Sessions` WRITE;
/*!40000 ALTER TABLE `User_Sessions` DISABLE KEYS */;
INSERT INTO `User_Sessions` VALUES (20,10,'30f5aa68557cd6a0900183df1289ba576bda04dbb0c7ba66b0dfe7f2688f2721'),(22,11,'1bafdb5b0d3dba0bc9fca08efe5f25f1f072391afd39a245cbd7f7f0885c0ea3'),(23,9,'7fc1abebd1081dd0288dae6b05c6735e2b8e4728043c491f7371f6a58435039b');
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
  `User_Verified` tinyint(1) NOT NULL DEFAULT '0',
  `Confirm_Hash` varchar(255) DEFAULT NULL,
  `Old_User` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id_UNIQUE` (`Id`),
  UNIQUE KEY `Username_UNIQUE` (`Username`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (8,'Marius','Marius Minny2',5,2,'bfb288528dd2012eb6cee0e3302ac413a9bbd42c1f32312b283af4eb0908fac4','üÙªx~\"çF„5\\,ûQßû±c²ÿ¤áÌ¸?P5Óþ',NULL,1,NULL,NULL),(9,'Johan@vectronics.co.za','Johan du Preez',6,1,'fb2c22a9678da6d0d3eef054cc51a55e05e701d462111e26a8cde2baa363919a','úèÖóEª~·qP¾ƒJtÉMxs¯Ž.+‹qA','0822815216',0,'123456789',NULL),(10,'Thomas@vectronics.co.za','Thomas van As',6,1,'5ae1301b56b5660029d1d061a7f584005ca58d1444a29bbab9ab52c367de2939','Iº¥­<Y5®Vd©E²-©³oÈÖ×V×;mûbÕ',NULL,1,NULL,NULL),(11,'marius@vectronics.co.za','Marius Minny',5,1,'454a57382e7450e2ebef5c435875a7b60d674ae9c091d117d7eb1a9035cb007c','gP´¿ŠšÙ^Á´/“Y¬Ÿoû’e-\'ûáädñ','0846588845',1,NULL,NULL);
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

-- Dump completed on 2015-05-01 12:18:17
