-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: Booking
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.14.04.1

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (8,'Marius','Marius Minny2',5,2,'bfb288528dd2012eb6cee0e3302ac413a9bbd42c1f32312b283af4eb0908fac4','üÙªx~\"çF„5\\,ûQßû±c²ÿ¤áÌ¸?P5Óþ',NULL,1,NULL,NULL),(9,'Johan@vectronics.co.za','Johan du Preez',5,1,'fb2c22a9678da6d0d3eef054cc51a55e05e701d462111e26a8cde2baa363919a','úèÖóEª~·qP¾ƒJtÉMxs¯Ž.+‹qA','0822815216',0,'123456789',NULL),(10,'Thomas@vectronics.co.za','Thomas van As',5,1,'5ae1301b56b5660029d1d061a7f584005ca58d1444a29bbab9ab52c367de2939','Iº¥­<Y5®Vd©E²-©³oÈÖ×V×;mûbÕ',NULL,1,NULL,NULL),(11,'marius@vectronics.co.za','Marius Minny',5,1,'454a57382e7450e2ebef5c435875a7b60d674ae9c091d117d7eb1a9035cb007c','gP´¿ŠšÙ^Á´/“Y¬Ÿoû’e-\'ûáädñ','0846588845',1,NULL,NULL);
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

-- Dump completed on 2015-04-29 12:26:06
