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
-- Table structure for table `dwh_d_bios_release_date`
--

DROP TABLE IF EXISTS `dwh_d_bios_release_date`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_d_bios_release_date` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `release_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_d_bios_release_date`
--

LOCK TABLES `dwh_d_bios_release_date` WRITE;
/*!40000 ALTER TABLE `dwh_d_bios_release_date` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_d_bios_release_date` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_d_bios_vendor`
--

DROP TABLE IF EXISTS `dwh_d_bios_vendor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_d_bios_vendor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_d_bios_vendor`
--

LOCK TABLES `dwh_d_bios_vendor` WRITE;
/*!40000 ALTER TABLE `dwh_d_bios_vendor` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_d_bios_vendor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_d_bios_version`
--

DROP TABLE IF EXISTS `dwh_d_bios_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_d_bios_version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=261 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_d_bios_version`
--

LOCK TABLES `dwh_d_bios_version` WRITE;
/*!40000 ALTER TABLE `dwh_d_bios_version` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_d_bios_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_d_env`
--

DROP TABLE IF EXISTS `dwh_d_env`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_d_env` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `env` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_d_env`
--

LOCK TABLES `dwh_d_env` WRITE;
/*!40000 ALTER TABLE `dwh_d_env` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_d_env` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_d_host`
--

DROP TABLE IF EXISTS `dwh_d_host`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_d_host` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeecole` varchar(255) NOT NULL,
  `ecole` varchar(255) NOT NULL,
  `certname` varchar(255) NOT NULL,
  `ipaddress_eth0` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22197 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_d_host`
--

LOCK TABLES `dwh_d_host` WRITE;
/*!40000 ALTER TABLE `dwh_d_host` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_d_host` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_d_ifspeed_eth0`
--

DROP TABLE IF EXISTS `dwh_d_ifspeed_eth0`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_d_ifspeed_eth0` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `speed` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_d_ifspeed_eth0`
--

LOCK TABLES `dwh_d_ifspeed_eth0` WRITE;
/*!40000 ALTER TABLE `dwh_d_ifspeed_eth0` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_d_ifspeed_eth0` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_d_manufacturer_screen1`
--

DROP TABLE IF EXISTS `dwh_d_manufacturer_screen1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_d_manufacturer_screen1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1947 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_d_manufacturer_screen1`
--

LOCK TABLES `dwh_d_manufacturer_screen1` WRITE;
/*!40000 ALTER TABLE `dwh_d_manufacturer_screen1` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_d_manufacturer_screen1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_d_osfamily`
--

DROP TABLE IF EXISTS `dwh_d_osfamily`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_d_osfamily` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `osfamily` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_d_osfamily`
--

LOCK TABLES `dwh_d_osfamily` WRITE;
/*!40000 ALTER TABLE `dwh_d_osfamily` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_d_osfamily` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_d_product`
--

DROP TABLE IF EXISTS `dwh_d_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_d_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_d_product`
--

LOCK TABLES `dwh_d_product` WRITE;
/*!40000 ALTER TABLE `dwh_d_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_d_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_d_regroupement`
--

DROP TABLE IF EXISTS `dwh_d_regroupement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_d_regroupement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `regroupement` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2025 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_d_regroupement`
--

LOCK TABLES `dwh_d_regroupement` WRITE;
/*!40000 ALTER TABLE `dwh_d_regroupement` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_d_regroupement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_d_router`
--

DROP TABLE IF EXISTS `dwh_d_router`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_d_router` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `router` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1571 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_d_router`
--

LOCK TABLES `dwh_d_router` WRITE;
/*!40000 ALTER TABLE `dwh_d_router` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_d_router` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_d_screens`
--

DROP TABLE IF EXISTS `dwh_d_screens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_d_screens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `screens` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_d_screens`
--

LOCK TABLES `dwh_d_screens` WRITE;
/*!40000 ALTER TABLE `dwh_d_screens` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_d_screens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_d_semconfigversions`
--

DROP TABLE IF EXISTS `dwh_d_semconfigversions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_d_semconfigversions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `majeure` varchar(255) NOT NULL,
  `mineure` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_d_semconfigversions`
--

LOCK TABLES `dwh_d_semconfigversions` WRITE;
/*!40000 ALTER TABLE `dwh_d_semconfigversions` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_d_semconfigversions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_f_memoire`
--

DROP TABLE IF EXISTS `dwh_f_memoire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_f_memoire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poste_id` int(11) DEFAULT NULL,
  `memoire` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `dwh_f_memoire_fk_poste_1` (`poste_id`),
  CONSTRAINT `dwh_f_memoire_fk_poste_1` FOREIGN KEY (`poste_id`) REFERENCES `poste` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_f_memoire`
--

LOCK TABLES `dwh_f_memoire` WRITE;
/*!40000 ALTER TABLE `dwh_f_memoire` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_f_memoire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_f_node`
--

DROP TABLE IF EXISTS `dwh_f_node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_f_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host_id` int(11) DEFAULT NULL,
  `router_id` int(11) DEFAULT NULL,
  `bios_vendor_id` int(11) DEFAULT NULL,
  `bios_release_date_id` int(11) DEFAULT NULL,
  `bios_version_id` int(11) DEFAULT NULL,
  `ifspeed_eth0_id` int(11) DEFAULT NULL,
  `manufacturer_screen1_id` int(11) DEFAULT NULL,
  `env_id` int(11) DEFAULT NULL,
  `osfamily_id` int(11) DEFAULT NULL,
  `screens_id` int(11) DEFAULT NULL,
  `regroupement_id` int(11) DEFAULT NULL,
  `semconfigversions_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `memorysize` int(11) DEFAULT '0',
  `uptime` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `dwh_f_node_fk_host_1` (`host_id`),
  KEY `dwh_f_node_fk_router_1` (`router_id`),
  KEY `dwh_f_node_fk_bios_vendor_1` (`bios_vendor_id`),
  KEY `dwh_f_node_fk_bios_release_date_1` (`bios_release_date_id`),
  KEY `dwh_f_node_fk_bios_version_1` (`bios_version_id`),
  KEY `dwh_f_node_fk_ifspeed_eth0_1` (`ifspeed_eth0_id`),
  KEY `dwh_f_node_fk_manufacturer_screen1_1` (`manufacturer_screen1_id`),
  KEY `dwh_f_node_fk_env_1` (`env_id`),
  KEY `dwh_f_node_fk_osfamily_1` (`osfamily_id`),
  KEY `dwh_f_node_fk_screens_1` (`screens_id`),
  KEY `dwh_f_node_fk_regroupement_1` (`regroupement_id`),
  KEY `dwh_f_node_fk_semconfigversions_1` (`semconfigversions_id`),
  KEY `dwh_f_node_fk_product_1` (`product_id`),
  CONSTRAINT `dwh_f_node_fk_host_1` FOREIGN KEY (`host_id`) REFERENCES `dwh_d_host` (`id`),
  CONSTRAINT `dwh_f_node_fk_router_1` FOREIGN KEY (`router_id`) REFERENCES `dwh_d_router` (`id`),
  CONSTRAINT `dwh_f_node_fk_bios_vendor_1` FOREIGN KEY (`bios_vendor_id`) REFERENCES `dwh_d_bios_vendor` (`id`),
  CONSTRAINT `dwh_f_node_fk_bios_release_date_1` FOREIGN KEY (`bios_release_date_id`) REFERENCES `dwh_d_bios_release_date` (`id`),
  CONSTRAINT `dwh_f_node_fk_bios_version_1` FOREIGN KEY (`bios_version_id`) REFERENCES `dwh_d_bios_version` (`id`),
  CONSTRAINT `dwh_f_node_fk_ifspeed_eth0_1` FOREIGN KEY (`ifspeed_eth0_id`) REFERENCES `dwh_d_ifspeed_eth0` (`id`),
  CONSTRAINT `dwh_f_node_fk_manufacturer_screen1_1` FOREIGN KEY (`manufacturer_screen1_id`) REFERENCES `dwh_d_manufacturer_screen1` (`id`),
  CONSTRAINT `dwh_f_node_fk_env_1` FOREIGN KEY (`env_id`) REFERENCES `dwh_d_env` (`id`),
  CONSTRAINT `dwh_f_node_fk_osfamily_1` FOREIGN KEY (`osfamily_id`) REFERENCES `dwh_d_osfamily` (`id`),
  CONSTRAINT `dwh_f_node_fk_screens_1` FOREIGN KEY (`screens_id`) REFERENCES `dwh_d_screens` (`id`),
  CONSTRAINT `dwh_f_node_fk_regroupement_1` FOREIGN KEY (`regroupement_id`) REFERENCES `dwh_d_regroupement` (`id`),
  CONSTRAINT `dwh_f_node_fk_semconfigversions_1` FOREIGN KEY (`semconfigversions_id`) REFERENCES `dwh_d_semconfigversions` (`id`),
  CONSTRAINT `dwh_f_node_fk_product_1` FOREIGN KEY (`product_id`) REFERENCES `dwh_d_product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22197 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_f_node`
--

LOCK TABLES `dwh_f_node` WRITE;
/*!40000 ALTER TABLE `dwh_f_node` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_f_node` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_d_printername`
--

DROP TABLE IF EXISTS `dwh_d_printername`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_d_printername` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `printername` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`printername`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_d_printername`
--

LOCK TABLES `dwh_d_printername` WRITE;
/*!40000 ALTER TABLE `dwh_d_printername` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_d_printername` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_d_printerdriver`
--

DROP TABLE IF EXISTS `dwh_d_printerdriver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_d_printerdriver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `printerdriver` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`printerdriver`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_d_printerdriver`
--

LOCK TABLES `dwh_d_printerdriver` WRITE;
/*!40000 ALTER TABLE `dwh_d_printerdriver` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_d_printerdriver` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_d_printerlocation`
--

DROP TABLE IF EXISTS `dwh_d_printerlocation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_d_printerlocation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `printerlocation` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`printerlocation`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_d_printerlocation`
--

LOCK TABLES `dwh_d_printerlocation` WRITE;
/*!40000 ALTER TABLE `dwh_d_printerlocation` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_d_printerlocation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_f_printer`
--

DROP TABLE IF EXISTS `dwh_f_printer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_f_printer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host_id` int(11) DEFAULT NULL,
  `printername_id` int(11) DEFAULT NULL,
  `printerdriver_id` int(11) DEFAULT NULL,
  `printerlocation_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dwh_f_printer_fk_host_1` (`host_id`),
  KEY `dwh_f_printer_fk_printername_1` (`printername_id`),
  KEY `dwh_f_printer_fk_printerdriver_1` (`printerdriver_id`),
  KEY `dwh_f_printer_fk_printerlocation_1` (`printerlocation_id`),
  CONSTRAINT `dwh_f_printer_fk_host_1` FOREIGN KEY (`host_id`) REFERENCES `dwh_d_host` (`id`),
  CONSTRAINT `dwh_f_printer_fk_printername_1` FOREIGN KEY (`printername_id`) REFERENCES `dwh_d_printername` (`id`),
  CONSTRAINT `dwh_f_printer_fk_printerdriver_1` FOREIGN KEY (`printerdriver_id`) REFERENCES `dwh_d_printerdriver` (`id`),
  CONSTRAINT `dwh_f_printer_fk_printerlocation_1` FOREIGN KEY (`printerlocation_id`) REFERENCES `dwh_d_printerlocation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22197 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_f_printer`
--

LOCK TABLES `dwh_f_printer` WRITE;
/*!40000 ALTER TABLE `dwh_f_printer` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_f_printer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dwh_f_uptime`
--

DROP TABLE IF EXISTS `dwh_f_uptime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dwh_f_uptime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poste_id` int(11) DEFAULT NULL,
  `uptime` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `dwh_f_uptime_fk_poste_1` (`poste_id`),
  CONSTRAINT `dwh_f_uptime_fk_poste_1` FOREIGN KEY (`poste_id`) REFERENCES `poste` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dwh_f_uptime`
--

LOCK TABLES `dwh_f_uptime` WRITE;
/*!40000 ALTER TABLE `dwh_f_uptime` DISABLE KEYS */;
/*!40000 ALTER TABLE `dwh_f_uptime` ENABLE KEYS */;
UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
