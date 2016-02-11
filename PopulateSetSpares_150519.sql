-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: Booking
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.14.04.1-log

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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Set_Spares`
--

LOCK TABLES `Set_Spares` WRITE;
/*!40000 ALTER TABLE `Set_Spares` DISABLE KEYS */;
INSERT INTO `Set_Spares` VALUES (1,'CAN-10M','Cannulated Screw10M'),(2,'CAN-12M','Cannulated Screw12M'),(3,'CAN-14M','Cannulated Screw14M'),(4,'CAN-16M','Cannulated Screw16M'),(5,'CAN-18M','Cannulated Screw18M'),(6,'CAN-20M','Cannulated Screw20M'),(7,'NLS-10M','Cortical Non-Lock Screw10M'),(8,'NLS-12M','Cortical Non-Lock Screw12M'),(9,'NLS-14M','Cortical Non-Lock Screw14M'),(10,'NLS-16M','Cortical Non-Lock Screw16M'),(11,'NLS-18M','Cortical Non-Lock Screw18M'),(12,'NLS-20M','Cortical Non-Lock Screw20M'),(13,'LS-10M','Cortical Locking Screw10M'),(14,'LS-12M','Cortical Locking Screw12M'),(15,'LS-14M','Cortical Locking Screw14M'),(16,'LS-16M','Cortical Locking Screw16M'),(17,'LS-18M','Cortical Locking Screw18M'),(18,'LS-20M','Cortical Locking Screw20M'),(19,'LAG-10M','Lag Screw10M'),(20,'LAG-12M','Lag Screw12M'),(21,'LAG-14M','Lag Screw14M'),(22,'LAG-16M','Lag Screw16M'),(23,'LAG-18M','Lag Screw18M'),(24,'LAG-20M','Lag Screw20M'),(25,'PLTLC-1','Plate Locking1'),(26,'PLTLC-2','Plate Locking2'),(27,'PLTLC-3','Plate Locking3'),(28,'PLTLC-4','Plate Locking4'),(29,'PLTLC-5','Plate Locking5'),(30,'PLTLC-6','Plate Locking6'),(31,'PLTNL-1','Plate Non-Locking1'),(32,'PLTNL-2','Plate Non-Locking2'),(33,'PLTNL-3','Plate Non-Locking3'),(34,'PLTNL-4','Plate Non-Locking4'),(35,'PLTNL-5','Plate Non-Locking5'),(36,'PLTNL-6','Plate Non-Locking6'),(37,'KW-1','K-Wire1'),(38,'KW-2','K-Wire2'),(39,'KW-3','K-Wire3'),(40,'KW-4','K-Wire4'),(41,'KW-5','K-Wire5'),(42,'KW-6','K-Wire6'),(43,'D-01','Drill1'),(44,'D-02','Drill2'),(45,'D-03','Drill3'),(46,'D-04','Drill4'),(47,'D-05','Drill5'),(48,'D-06','Drill6'),(49,'CD-01','Cannulated Drill1'),(50,'CD-02','Cannulated Drill2'),(51,'CD-03','Cannulated Drill3'),(52,'CD-04','Cannulated Drill4'),(53,'CD-05','Cannulated Drill5'),(54,'CD-06','Cannulated Drill6'),(55,'ROD-01','Rod1'),(56,'ROD-02','Rod2'),(57,'ROD-03','Rod3'),(58,'ROD-04','Rod4'),(59,'ROD-05','Rod5'),(60,'ROD-06','Rod6');
/*!40000 ALTER TABLE `Set_Spares` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-20  6:42:34
