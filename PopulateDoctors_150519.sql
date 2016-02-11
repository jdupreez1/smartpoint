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
) ENGINE=InnoDB AUTO_INCREMENT=809 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Doctors`
--

LOCK TABLES `Doctors` WRITE;
/*!40000 ALTER TABLE `Doctors` DISABLE KEYS */;
INSERT INTO `Doctors` VALUES (1,'ABNER J','1'),(2,'ACCONE Q','1'),(3,'ADEN AA','1'),(4,'AGBAZUE CD','1'),(5,'AGHENDO N','1'),(6,'AHMED H','1'),(7,'AHMIT J','1'),(8,'AKINJOLIRE A','1'),(9,'AKRAM F','1'),(10,'ALBERTSE HJ','1'),(11,'ALLIE D','1'),(12,'ALLISON M','1'),(13,'ANIM IM','1'),(14,'ANTWI E','1'),(15,'ARANDA A','1'),(16,'ARENDT J','1'),(17,'ARNOLD J','1'),(18,'ARONDA A','1'),(19,'ASHBERG L','1'),(20,'ASHWIN R','1'),(21,'ASLAM M','1'),(22,'ATTENBOROUGH SP','1'),(23,'ATWARU R','1'),(24,'AUCAMP PLS','1'),(25,'AUDLEY C','1'),(26,'AUGUSTYN J','1'),(27,'BAARTMAN M','1'),(28,'BABUMBA F','1'),(29,'BADENHORST D','1'),(30,'BAKER A','1'),(31,'BALKISSON I','1'),(32,'BAM T','1'),(33,'BARNARD B','1'),(34,'BARNES D','1'),(35,'BARRETT T','1'),(36,'BARROW AD','1'),(37,'BARROW BH','1'),(38,'BARROW MS','1'),(39,'BARROW RB','1'),(40,'BARTMAN M','1'),(41,'BASSON A','1'),(42,'BASSON H','1'),(43,'BAYES G','1'),(44,'BEEKARUN D','1'),(45,'BERNSTEIN B','1'),(46,'BERTIE J','1'),(47,'BESTER H','1'),(48,'BESUIDENHOUT C','1'),(49,'BHAGA R','1'),(50,'BHAGWADEEN S','1'),(51,'BHAGWAN NP','1'),(52,'BHAT S','1'),(53,'BHATTA A','1'),(54,'BHAWANI R','1'),(55,'BHUTT A','1'),(56,'BHUTT AD','1'),(57,'BIDDULPH H','1'),(58,'BIDDULPH LG','1'),(59,'BIDDULPH S','1'),(60,'BIRKHOLTZ F','1'),(61,'BISMILLA N','1'),(62,'BITHREY J','1'),(63,'BLAKE C','1'),(64,'BLOEM L','1'),(65,'BLOK J','1'),(66,'BOEYENS MC','1'),(67,'BOFFARD K','1'),(68,'BOGATSU T','1'),(69,'BOGATSU TS','1'),(70,'BOMELA L','1'),(71,'BOREMANN V','1'),(72,'BOSCH HB','1'),(73,'BOTES DW','1'),(74,'BOTES P','1'),(75,'BOTHA A','1'),(76,'BOTHA J','1'),(77,'BOTHA L','1'),(78,'BOTHA T','1'),(79,'BOTHMA JS','1'),(80,'BOTOULAS CN','1'),(81,'BOWES D','1'),(82,'BOYCE B','1'),(83,'BRECKON CJW','1'),(84,'BREMER L','1'),(85,'BREYTENBACH J','1'),(86,'BRINK J','1'),(87,'BRINK JSF','1'),(88,'BROWN DL','1'),(89,'BRUWER S','1'),(90,'BUATRE A','1'),(91,'BUGWANDIN S','1'),(92,'BUKARA E','1'),(93,'BURGER D','1'),(94,'BURGER F','1'),(95,'BURGER I','1'),(96,'BURGER M','1'),(97,'BUURMAN E','1'),(98,'BVUMA T','1'),(99,'CABLE NI','1'),(100,'CAKIC JN','1'),(101,'CAPPAERT G','1'),(102,'CARIDES M','1'),(103,'CARTER SL','1'),(104,'CHAGWIZA T','1'),(105,'CHARILAOU J','1'),(106,'CHAUKE F','1'),(107,'CHAUKE N','1'),(108,'CHETTY','1'),(109,'CHIVERS D','1'),(110,'CLOETE AAM','1'),(111,'COCCIUTI NS','1'),(112,'COCHRANE I','1'),(113,'COERTZE P','1'),(114,'COETZEE F','1'),(115,'COETZEE J','1'),(116,'COLEMAN M','1'),(117,'COLLINS D','1'),(118,'COLYN S','1'),(119,'CONRADIE G','1'),(120,'CRANE JL','1'),(121,'CRONJE','1'),(122,'CRONJE D','1'),(123,'CROWTHER M','1'),(124,'CUNNINGHAM S','1'),(125,'DACSH R','1'),(126,'D\'ALTON','1'),(127,'DANIELS K','1'),(128,'DAVIDSON M','1'),(129,'DAVIDSON MB','1'),(130,'DE BEER J','1'),(131,'DE BEER T','1'),(132,'DE BRUIN J','1'),(133,'DE BRUIN P','1'),(134,'DE GRAAD M','1'),(135,'DE JAGER C','1'),(136,'DE JONG H','1'),(137,'DE JONGH D','1'),(138,'DE JONGH H','1'),(139,'DE KLERK JA','1'),(140,'De Kock','1'),(141,'DE LANGE L','1'),(142,'DE LANGE P','1'),(143,'DE MUNNIK A','1'),(144,'DE SAWRDT S','1'),(145,'DE SWARDT R','1'),(146,'DE VILLIERS L','1'),(147,'DE VILLIERS P','1'),(148,'DE VILLIERS R','1'),(149,'DE VILLIERS S','1'),(150,'DE VLIEG A','1'),(151,'DE VOS A','1'),(152,'DE VOS J','1'),(153,'DE WET J','1'),(154,'DE WILDE I','1'),(155,'Delaires','1'),(156,'DEMBLON A','1'),(157,'DENG A','1'),(158,'DICKASON G','1'),(159,'DIKOBE A','1'),(160,'DILLON EM','1'),(161,'DILOS S','1'),(162,'DIX-PEEK S','1'),(163,'DREWS W','1'),(164,'DRIVER-JOWITZ J','1'),(165,'DU PLESSIS F','1'),(166,'DU PLESSIS FP','1'),(167,'DU PLESSIS G','1'),(168,'DU PLESSIS PG','1'),(169,'DU PLESSIS RJ','1'),(170,'DU PREEZ G','1'),(171,'DU PREEZ MG','1'),(172,'DU TIOT H','1'),(173,'DU TOIT AB','1'),(174,'DU TOIT D','1'),(175,'DU TOIT J','1'),(176,'DU TOIT RG','1'),(177,'DUBE D','1'),(178,'DUBE Z','1'),(179,'DURRANS M','1'),(180,'DURRANS MJ','1'),(181,'DUZE D','1'),(182,'DUZE Z','1'),(183,'DYBALA A','1'),(184,'DYBALA AJ','1'),(185,'EAST S','1'),(186,'EDENBURG RD','1'),(187,'EGBUNIKE I','1'),(188,'EHLERS P','1'),(189,'ELGHIWAIL Y','1'),(190,'ELLIS J','1'),(191,'ELTRINGHAM JM','1'),(192,'ENGELA DW','1'),(193,'ENGELBRECHT DJ','1'),(194,'ENGELBRECHT P','1'),(195,'ERASMUS PB','1'),(196,'FERGUSON MC','1'),(197,'FERRAO PNF','1'),(198,'FERRIERA N','1'),(199,'FINN RG','1'),(200,'FIRER P','1'),(201,'FIRTH GB','1'),(202,'FISCHER P','1'),(203,'FISHER P','1'),(204,'FOURIE F','1'),(205,'FOURIE JJ','1'),(206,'FRANK R','1'),(207,'FRANKEN T','1'),(208,'FRANTZEN D','1'),(209,'FRASER RK','1'),(210,'FREED N','1'),(211,'FRIELINGSDORF K','1'),(212,'FROELING F','1'),(213,'GAJJAR VP','1'),(214,'GARRETT B','1'),(215,'GATHIRAM CV','1'),(216,'GELBART BR','1'),(217,'GERICKE WA','1'),(218,'GIBSON N','1'),(219,'GIOGIVANONI R','1'),(220,'GOLDSTEIN N','1'),(221,'GOLELE S','1'),(222,'GOLLER R','1'),(223,'GOMEZ M','1'),(224,'GONCALVES R','1'),(225,'GONGAL P','1'),(226,'GONGAL PN','1'),(227,'GONZALLES P','1'),(228,'GOOSEN C','1'),(229,'GOOSEN J','1'),(230,'GRABE J','1'),(231,'GREEF E','1'),(232,'GREEF G','1'),(233,'GREEFF E','1'),(234,'GREEFF R','1'),(235,'GREY B','1'),(236,'GREYLING J','1'),(237,'GREYLING P','1'),(238,'GRIESEL LD','1'),(239,'GROOTBOOM M','1'),(240,'GUNTER G','1'),(241,'HAMMOND G','1'),(242,'HAMOTTY S','1'),(243,'HANCK T','1'),(244,'HARVEY R','1'),(245,'HASSAN Y','1'),(246,'HASTINGS C','1'),(247,'HATFIELD P','1'),(248,'HATTINGH S','1'),(249,'HAYNES W','1'),(250,'HEFER E','1'),(251,'HERBST C ','1'),(252,'HERBST HJ','1'),(253,'HEYMANS J','1'),(254,'HEYNS A','1'),(255,'HIDDEMA W','1'),(256,'HIJAZI B','1'),(257,'HILTON T','1'),(258,'HLOPE V','1'),(259,'HO F','1'),(260,'HOFFMAN D','1'),(261,'HORN A','1'),(262,'HOSKING K','1'),(263,'HUGO D','1'),(264,'HUMAN A','1'),(265,'HUMAN MC','1'),(266,'HUMAN P','1'),(267,'HURTER W','1'),(268,'IKRAM A','1'),(269,'ISLAM R','1'),(270,'ISMAIL E','1'),(271,'IVANHOF V','1'),(272,'JACOBS A','1'),(273,'JACOBS H','1'),(274,'JACOBS R','1'),(275,'JAFFE S','1'),(276,'JAFFE SI','1'),(277,'JANSEN VAN RENSBURG N','1'),(278,'JOHANNES S','1'),(279,'JOHNSON P','1'),(280,'JONKER CJ','1'),(281,'JORDAAN P','1'),(282,'JOUBERT E','1'),(283,'Julyan','1'),(284,'JULYAN A','1'),(285,'KALAGOBE J','1'),(286,'KANA PN','1'),(287,'KANE P','1'),(288,'KANJI K','1'),(289,'KAPUTU M','1'),(290,'KARERA M','1'),(291,'KASCHULA A','1'),(292,'KASIPERSAD V','1'),(293,'KASTANOS K','1'),(294,'KAUTA J','1'),(295,'KGANAKGA TMW','1'),(296,'KGOEDI N','1'),(297,'KHADEMI A','1'),(298,'KHALAFALLA H','1'),(299,'KHAN A','1'),(300,'KHAN I','1'),(301,'KHAN S','1'),(302,'KHOZA M','1'),(303,'KHUMALO D','1'),(304,'KILIAN C','1'),(305,'KILLIAN C','1'),(306,'KIMANI M','1'),(307,'KING R','1'),(308,'KIRSTEN S','1'),(309,'KISCAL S','1'),(310,'KISTENSAMY P','1'),(311,'KLUEVER F','1'),(312,'KNIPE E','1'),(313,'KOCH A','1'),(314,'KODI D','1'),(315,'KOEKEMOER D','1'),(316,'KOGH O','1'),(317,'KOLLER I','1'),(318,'KOUSOK K','1'),(319,'KRIEK G','1'),(320,'KRIEK J','1'),(321,'KROON MUTASA E','1'),(322,'KRUGER P','1'),(323,'KRUGER T','1'),(324,'KUHN A','1'),(325,'KUMAR P','1'),(326,'KUMAR S','1'),(327,'KUMASAMBA JN','1'),(328,'KYTE RD','1'),(329,'LAKSHMANAN D','1'),(330,'LARIC M','1'),(331,'LAUBSCHER EF','1'),(332,'LE ROUX J','1'),(333,'LE ROUX T','1'),(334,'LEDIMO L','1'),(335,'LEDWABA LA','1'),(336,'LERATONG','1'),(337,'LICHTENBERG M','1'),(338,'LIEBENBERG E','1'),(339,'LINDA Z','1'),(340,'LISENDA L','1'),(341,'LOMBAARD J','1'),(342,'LOOTS S','1'),(343,'LOUBSER M','1'),(344,'LOURENS CPJ','1'),(345,'LOURENS D','1'),(346,'LOURENS L','1'),(347,'LOUW F','1'),(348,'LOUW P','1'),(349,'LUAMBA K','1'),(350,'MABUNDA N','1'),(351,'MAFEELANE S','1'),(352,'MAGAMPA R','1'),(353,'MAGAN A','1'),(354,'MAGOBOTHA SK','1'),(355,'MAHOMED N','1'),(356,'MAINA A','1'),(357,'MAINE M','1'),(358,'MAKINTA T','1'),(359,'MAKOBELA T','1'),(360,'MAKOKGA PT','1'),(361,'MAKU M','1'),(362,'MALAN D','1'),(363,'MALAN M','1'),(364,'MALEPO A','1'),(365,'MALEPO H','1'),(366,'MALUMANE OK','1'),(367,'MAMATELA M','1'),(368,'MANDABA MB','1'),(369,'MANDUNA N','1'),(370,'MANGELAWE P','1'),(371,'MANJRA MAHOMED','1'),(372,'MANQUNGO S','1'),(373,'MAPHEKULU B','1'),(374,'MAQUAGO S','1'),(375,'MAQUNGO S','1'),(376,'MARAIS C','1'),(377,'MARAIS H','1'),(378,'MARAIS JF','1'),(379,'MARAIS K','1'),(380,'MARAIS L','1'),(381,'MARAIS N','1'),(382,'MARE D','1'),(383,'MARE E','1'),(384,'MARE PD','1'),(385,'MARIN JP','1'),(386,'MARITZ E','1'),(387,'MARITZ M','1'),(388,'MARTIN NV','1'),(389,'MARULE M','1'),(390,'MASONDO TX','1'),(391,'MATAMBAK','1'),(392,'MATEKANE K','1'),(393,'MATHEE W','1'),(394,'MATSEBULA L','1'),(395,'MATSEBULA T','1'),(396,'MATSHIDZE S','1'),(397,'MATSHIDZE T','1'),(398,'MATSIDZE S','1'),(399,'MATTHEE W','1'),(400,'MATUKANE D','1'),(401,'MATUKANE P','1'),(402,'MAYET Z','1'),(403,'MAZIBUKO D','1'),(404,'MAZIBUKO S','1'),(405,'MC ALLISTER J','1'),(406,'MC COLLUM G','1'),(407,'MC DONALD MCE','1'),(408,'MCCALL J','1'),(409,'MCCREADY DAC','1'),(410,'MCINA J','1'),(411,'MCQUIRE D','1'),(412,'MENNEN E','1'),(413,'MESHIR S','1'),(414,'MHLONGO N','1'),(415,'MJUZA E','1'),(416,'MKHIZE I','1'),(417,'MKHIZE S','1'),(418,'MOAGI T','1'),(419,'MOHAMMED H','1'),(420,'MOHIDEEN M','1'),(421,'MOKETE L','1'),(422,'MOKOENA OM','1'),(423,'MOLOTO HL','1'),(424,'MONNI T','1'),(425,'MOODLEY L','1'),(426,'MOODLEY SA','1'),(427,'MOOLMAN A','1'),(428,'MOOLMAN C','1'),(429,'MOOLMAN J','1'),(430,'MOONDA Z','1'),(431,'MOOSA N','1'),(432,'MORKEL DF','1'),(433,'MORRIS I','1'),(434,'MORRISH A','1'),(435,'MORULA R.A.','1'),(436,'MOSTERT P','1'),(437,'MOTHIBA R','1'),(438,'MOTSITSI N','1'),(439,'MOUTON NJ','1'),(440,'MUDAU O','1'),(441,'MUGWERU P','1'),(442,'MUHAMMAD N','1'),(443,'MUJAKACHI C','1'),(444,'MUJAKATCHI C','1'),(445,'MULAMBA LN','1'),(446,'MULDER M','1'),(447,'MULLER E','1'),(448,'MULLER EW','1'),(449,'MULLER H','1'),(450,'MULLER JM','1'),(451,'MULLER W','1'),(452,'MULUMBA D','1'),(453,'MUNTING T','1'),(454,'Murdoch','1'),(455,'MUSHABE C','1'),(456,'MUSHAKE R','1'),(457,'MVELASE S','1'),(458,'MYBURGH H','1'),(459,'MYBURGH J','1'),(460,'NADA B','1'),(461,'NADAR V','1'),(462,'NAICKER D','1'),(463,'NAIDOO A','1'),(464,'NAIDOO J','1'),(465,'NAIDOO J ','1'),(466,'NAIDOO K','1'),(467,'NAIDOO N','1'),(468,'NAIDOO S','1'),(469,'NAIDOO SM','1'),(470,'NAIDOO T','1'),(471,'NAIK K','1'),(472,'NARROWMORE C','1'),(473,'NAUDE D','1'),(474,'NAUDE J','1'),(475,'NEL DJ','1'),(476,'NEL G','1'),(477,'NEL J','1'),(478,'NGCUBE S','1'),(479,'NGOBENI R','1'),(480,'NGOBENI S','1'),(481,'NHLAPO B','1'),(482,'NIAZA D','1'),(483,'NIAZI J','1'),(484,'NIAZI WAK','1'),(485,'NICHOLSON R','1'),(486,'NICOLAOU N','1'),(487,'NIEMOLLER H','1'),(488,'NIEWOUD L','1'),(489,'NIKOLIC N','1'),(490,'NJOLOMOLE E','1'),(491,'NKOMO W','1'),(492,'NORJIE M','1'),(493,'NORTH D','1'),(494,'NORTJE D','1'),(495,'NORTJE J','1'),(496,'NORTJE N','1'),(497,'NORTJE T','1'),(498,'NUNES D','1'),(499,'NWOKEYI K','1'),(500,'NXIWENI C','1'),(501,'NXIWENI L','1'),(502,'O\'BRIEN G','1'),(503,'ODENDAAL D','1'),(504,'ODUAH G','1'),(505,'OELOFSE L','1'),(506,'OJWANG P','1'),(507,'OLIVIER J','1'),(508,'OOSTHUIZEN CH','1'),(509,'OOSTHUIZEN J','1'),(510,'OOSTHUIZEN P','1'),(511,'OSMAN S','1'),(512,'P Mackerdhuj','1'),(513,'PAPAGAIOU H','1'),(514,'PAPAGAPIOU H','1'),(515,'PARBOO A','1'),(516,'PARKER TW','1'),(517,'PATEL A','1'),(518,'PATTERSON A','1'),(519,'PAULSEN P','1'),(520,'PEACH A','1'),(521,'PEER Z','1'),(522,'PEER ZAA','1'),(523,'PELSER C','1'),(524,'PELSER E','1'),(525,'PELSER P','1'),(526,'PELSER PC','1'),(527,'PERRY B','1'),(528,'PETERS A','1'),(529,'PETERS F','1'),(530,'PETERSEN I','1'),(531,'PHIRI D','1'),(532,'PIENAAR G','1'),(533,'PIENAAR J','1'),(534,'PIENAAR T','1'),(535,'PIETERSE B','1'),(536,'PIETZAK Y','1'),(537,'PIKOR TD','1'),(538,'PILLAY J','1'),(539,'PIRJOL G','1'),(540,'POLDERMAN P','1'),(541,'POLLOCK D','1'),(542,'POTGIETER D','1'),(543,'POTGIETER M','1'),(544,'PREDDY J','1'),(545,'PRETORIUS C','1'),(546,'PRETORIUS H','1'),(547,'PRETORIUS S','1'),(548,'PRINS J','1'),(549,'PRINSLOO C','1'),(550,'PRINSLOO W','1'),(551,'RABIN BS','1'),(552,'RACZ G','1'),(553,'RADZIEJOWSKI MJ','1'),(554,'RADZILANI M','1'),(555,'RAGOO S','1'),(556,'RAJAH L','1'),(557,'RAJOO R','1'),(558,'RAMAKGOPA TS','1'),(559,'RAMALAKAN R','1'),(560,'RAMASUHVA B','1'),(561,'RAMGUTHY Y','1'),(562,'RAMLAKAN R','1'),(563,'RAMNARIAN A','1'),(564,'RAMOKGOPA MT','1'),(565,'RAMOKGOPA T','1'),(566,'RAMOKGOPA TS','1'),(567,'RANGONGO R','1'),(568,'RASHEED E','1'),(569,'RASHEED M','1'),(570,'RAUF A','1'),(571,'RAWL W','1'),(572,'RAWOOT A','1'),(573,'READ GO','1'),(574,'REARDON T','1'),(575,'REDDY L','1'),(576,'REDELINGHUIS J','1'),(577,'REID C','1'),(578,'RETTER J','1'),(579,'REVELAS A','1'),(580,'REVELAS AP','1'),(581,'RHOMA M ','1'),(582,'RISKO Z','1'),(583,'ROCHE S','1'),(584,'ROCHER A','1'),(585,'RODSETH D','1'),(586,'ROGERS N','1'),(587,'ROMAN S','1'),(588,'ROODT H','1'),(589,'ROOI R','1'),(590,'ROOI T','1'),(591,'ROSSOT M ','1'),(592,'ROSSOUT M','1'),(593,'ROSSOUW N','1'),(594,'ROWE M','1'),(595,'RYNDINE V','1'),(596,'SAGOR J','1'),(597,'SALEH E','1'),(598,'SALIE R','1'),(599,'SALKINDER R','1'),(600,'SANCHEZ P','1'),(601,'SANDER G','1'),(602,'SANJANI MR','1'),(603,'SARAGAS NP','1'),(604,'SATHEKGA C','1'),(605,'SATHYAPAL S','1'),(606,'SCHNAID E','1'),(607,'SCHOEMAN  A','1'),(608,'SCHUTTE B','1'),(609,'SCOTT I','1'),(610,'SCOTT K','1'),(611,'SEEDAT Z','1'),(612,'SEEVSAGATH S','1'),(613,'SEFEANE T','1'),(614,'SEFEANE TI','1'),(615,'SENSKE H','1'),(616,'SETUMO MJ','1'),(617,'SEYISI G','1'),(618,'SEYISI GA','1'),(619,'SHANDUKANI R','1'),(620,'SHITHULENI S','1'),(621,'SHONIWA P','1'),(622,'SHONIWA TA','1'),(623,'SIKHAULI L','1'),(624,'SITHEBE H','1'),(625,'SIVENICI V','1'),(626,'SKINNER A','1'),(627,'SLUIS T','1'),(628,'SMIT A','1'),(629,'SMITH P','1'),(630,'SMITH R','1'),(631,'SMITH S','1'),(632,'SNYCKERS C','1'),(633,'SNYCKERS H','1'),(634,'SNYDERS N','1'),(635,'SNYMAN FPJ','1'),(636,'SOCHISWE V','1'),(637,'SOHAN K','1'),(638,'SOLOMONS M','1'),(639,'SOMBILI S','1'),(640,'SONJANI S','1'),(641,'SPIES P','1'),(642,'SPRONG F','1'),(643,'STANDER H','1'),(644,'STANGER-PEE O','1'),(645,'STANTON J','1'),(646,'STATHOULIS B','1'),(647,'STEAD I','1'),(648,'STECK H','1'),(649,'STEECK H','1'),(650,'STEYN C','1'),(651,'STEYN D','1'),(652,'STEYN K','1'),(653,'STEYN R','1'),(654,'STEYTLER M','1'),(655,'STHITULENI S','1'),(656,'STOFFBERG T','1'),(657,'STORM M','1'),(658,'STRAUB M','1'),(659,'STRAUSS K','1'),(660,'STREET M','1'),(661,'STROBOS PJJ','1'),(662,'STRYDOM WS','1'),(663,'STUART WB','1'),(664,'SULAIMAN T','1'),(665,'SULIMAN E','1'),(666,'SULIMAN I','1'),(667,'SULIMAN S','1'),(668,'SURFONTEIN C','1'),(669,'SWAN A','1'),(670,'SWANEPOEL S','1'),(671,'SWART H','1'),(672,'SWART M','1'),(673,'SZABO A','1'),(674,'TAUTER D','1'),(675,'TER HAAR','1'),(676,'TERBLANCHE N','1'),(677,'THERON F','1'),(678,'THEUNISSEN B','1'),(679,'THIART B','1'),(680,'THIART G','1'),(681,'THIART M','1'),(682,'THLABANE S','1'),(683,'THOMAS AF','1'),(684,'THOMAS D','1'),(685,'TIETZ W','1'),(686,'TINAMAU L','1'),(687,'TOLLIG W','1'),(688,'TREDOUX H','1'),(689,'TROISI K','1'),(690,'TROMP D','1'),(691,'TROSKE A','1'),(692,'TRUDA C','1'),(693,'TSAMA','1'),(694,'TSAMA M','1'),(695,'TSHDIBI D','1'),(696,'TSHDIBI K','1'),(697,'TSHIDIBI D','1'),(698,'TSHIDIBI K','1'),(699,'TSHITAKE T','1'),(700,'TURINO L','1'),(701,'TWALA M','1'),(702,'TZVETANOV PN','1'),(703,'UKUNDA UF','1'),(704,'UYS H','1'),(705,'UYS K','1'),(706,'V NIEKERK A','1'),(707,'V ROOYEN J','1'),(708,'VALASKATZIS E','1'),(709,'VALASKATZIS EP','1'),(710,'VALENTINE R','1'),(711,'VAN BORMAN R','1'),(712,'VAN CASTRICUM OQS','1'),(713,'VAN DEN BERG CC','1'),(714,'VAN DEN BERG D','1'),(715,'VAN DEN BERG JL','1'),(716,'VAN DER BERG D','1'),(717,'VAN DER BOUT H','1'),(718,'VAN DER BYL N','1'),(719,'VAN DER HORST A','1'),(720,'VAN DER KAAG M','1'),(721,'VAN DER MERWE D','1'),(722,'VAN DER MERWE JF','1'),(723,'VAN DER MERWE L','1'),(724,'VAN DER PLANK RH','1'),(725,'VAN DER SPUY D','1'),(726,'VAN DER WALT N','1'),(727,'VAN DER WESTHUIZEN B','1'),(728,'VAN DER WESTHUIZEN CA','1'),(729,'VAN DER WESTHUIZEN F','1'),(730,'VAN DER WESTHUIZEN FD','1'),(731,'VAN DER WESTHUIZEN J','1'),(732,'VAN DER WESTHUIZEN M','1'),(733,'VAN DEVENTER S','1'),(734,'VAN DYK B','1'),(735,'VAN DYK J','1'),(736,'VAN EEDEN N','1'),(737,'VAN GRAAN W','1'),(738,'Van Niekerk','1'),(739,'VAN NIEKERK A','1'),(740,'VAN NIEKERK JC','1'),(741,'VAN NIEKERK JJ','1'),(742,'VAN NIEKERK M','1'),(743,'VAN NIEKERK P','1'),(744,'VAN OSCH G','1'),(745,'VAN REENEN J','1'),(746,'VAN ROOYEN J','1'),(747,'VAN SITTERT P','1'),(748,'VAN STADEN G','1'),(749,'VAN STADEN J','1'),(750,'VAN STADEN JM','1'),(751,'VAN WYK A','1'),(752,'VAN WYK L','1'),(753,'VAN WYK M','1'),(754,'VAN ZYL D','1'),(755,'VAN ZYL G','1'),(756,'VEERASAMY C','1'),(757,'VEERASMY C','1'),(758,'VEERSAMY A','1'),(759,'VEERSAMY C','1'),(760,'VENTER J','1'),(761,'VENTER JCM','1'),(762,'VENTER R','1'),(763,'VENTER W','1'),(764,'VERMAAK D','1'),(765,'VERMAAK S','1'),(766,'VERMEULEN AM','1'),(767,'VERRIER M','1'),(768,'VERSFELD G','1'),(769,'VILJOEN E','1'),(770,'VILJOEN J','1'),(771,'VISSER E','1'),(772,'VISSER H','1'),(773,'VISSER JH','1'),(774,'VISSER M','1'),(775,'VIVIERS JJ','1'),(776,'VIVIERS W','1'),(777,'VLOK FE','1'),(778,'VOLKERSZ HH','1'),(779,'WAHL F','1'),(780,'WAIT K','1'),(781,'WALEED B','1'),(782,'watt','1'),(783,'WATT J','1'),(784,'WATT K','1'),(785,'WATT V','1'),(786,'WEBSTER PI','1'),(787,'WELLS M','1'),(788,'WESSELS J','1'),(789,'WEYERS CF','1'),(790,'WHITE C','1'),(791,'WHITEHEAD A','1'),(792,'WIESNER F','1'),(793,'WILLERS J','1'),(794,'WILLIAMS H','1'),(795,'WILLIAMS WE','1'),(796,'WILSON JG','1'),(797,'WIUM M','1'),(798,'WOOD G','1'),(799,'WORKMAN M','1'),(800,'WORMSBAECHER J','1'),(801,'WOUTERS SG','1'),(802,'YACHAD R','1'),(803,'YERO V','1'),(804,'YOUNIS H','1'),(805,'YOUNUS A','1'),(806,'ZONDA S','1'),(807,'ZONDACH I','1'),(808,'ZONDAGH I','1');
/*!40000 ALTER TABLE `Doctors` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-20  6:41:54
