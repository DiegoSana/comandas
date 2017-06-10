CREATE DATABASE  IF NOT EXISTS `comandas` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `comandas`;
-- MySQL dump 10.13  Distrib 5.7.12, for linux-glibc2.5 (x86_64)
--
-- Host: localhost    Database: comandas
-- ------------------------------------------------------
-- Server version	5.7.13-0ubuntu0.16.04.2

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
-- Table structure for table `aplicacion`
--

DROP TABLE IF EXISTS `aplicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aplicacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `subdominio` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mesa_default_id` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_aplicacion_empresa1` (`empresa_id`),
  CONSTRAINT `fk_aplicacion_empresa1` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aplicacion`
--

LOCK TABLES `aplicacion` WRITE;
/*!40000 ALTER TABLE `aplicacion` DISABLE KEYS */;
INSERT INTO `aplicacion` VALUES (1,'Local 1',1,'local1',NULL),(2,'Local 2',1,'local2',NULL),(3,'Local Av Sta Fe',3,'stafe',NULL),(4,'Local Cordoba',3,NULL,NULL),(5,'Local av corrientes',4,NULL,NULL),(6,'local av los incas',4,NULL,NULL),(7,'Paraiso tropical',5,'paraiso1','1');
/*!40000 ALTER TABLE `aplicacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8_unicode_ci,
  `aplicacion_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Bocadillos','Finger Food',7),(2,'Emparedados','',7),(3,'Comidas mexicanas','',7),(4,'Postres','',7),(5,'Batidos de frutas','',7),(6,'Gaseosas','',7),(7,'Bebidas calientes','',7),(8,'Licores','',7),(9,'Vinos','',7),(10,'Cocteles','',7);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (1,'Empresa demo 1'),(2,'Empresa demo 2'),(3,'Empresa demo 3'),(4,'Empresa demo 4'),(5,'Paraiso tropical');
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mesas`
--

DROP TABLE IF EXISTS `mesas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mesas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nro_mesa` int(11) NOT NULL,
  `aplicacion_id` int(11) NOT NULL,
  `posicion` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mesas_aplicacion1` (`aplicacion_id`),
  CONSTRAINT `fk_mesas_aplicacion1` FOREIGN KEY (`aplicacion_id`) REFERENCES `aplicacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mesas`
--

LOCK TABLES `mesas` WRITE;
/*!40000 ALTER TABLE `mesas` DISABLE KEYS */;
INSERT INTO `mesas` VALUES (1,0,7,NULL),(2,2,7,'{\"top\":129,\"left\":31}'),(3,3,7,'{\"top\":79,\"left\":-424}'),(4,4,7,'{\"top\":29,\"left\":-373}'),(5,5,7,'{\"top\":46,\"left\":-494}'),(6,1,1,NULL);
/*!40000 ALTER TABLE `mesas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mesas_id` int(11) NOT NULL,
  `hash` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `pedidos_estados_id` int(11) NOT NULL,
  `qr_image` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `aplicacion_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedidos_mesas1` (`mesas_id`),
  KEY `fk_pedidos_pedidos_estados1` (`pedidos_estados_id`),
  KEY `fk_aplicaciones_1_idx` (`aplicacion_id`),
  CONSTRAINT `fk_aplicaciones_1` FOREIGN KEY (`aplicacion_id`) REFERENCES `aplicacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidos_mesas1` FOREIGN KEY (`mesas_id`) REFERENCES `mesas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidos_pedidos_estados1` FOREIGN KEY (`pedidos_estados_id`) REFERENCES `pedidos_estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES (1,1,'18',4,NULL,7),(3,3,'18',4,NULL,7),(4,3,'18',2,NULL,7),(5,4,'18',3,NULL,7),(6,1,'62',4,NULL,7),(7,1,'62',4,NULL,7),(8,4,'16',2,NULL,7);
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos_estados`
--

DROP TABLE IF EXISTS `pedidos_estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedidos_estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos_estados`
--

LOCK TABLES `pedidos_estados` WRITE;
/*!40000 ALTER TABLE `pedidos_estados` DISABLE KEYS */;
INSERT INTO `pedidos_estados` VALUES (1,'Disponible'),(2,'Activo'),(3,'Cancelado'),(4,'Pagado');
/*!40000 ALTER TABLE `pedidos_estados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos_has_productos`
--

DROP TABLE IF EXISTS `pedidos_has_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedidos_has_productos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pedidos_id` int(11) NOT NULL,
  `productos_id` int(11) NOT NULL,
  `observaciones` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pedidos_has_productos_id` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hora_pedido` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pedidos_has_productos_estados_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedidos_has_productos_productos1` (`productos_id`),
  KEY `fk_pedidos_has_productos_pedidos1` (`pedidos_id`),
  KEY `fk_pedidos_has_productos_pedidos_has_productos1` (`pedidos_has_productos_id`),
  KEY `fk_pedidos_has_productos_pedidos_has_productos` (`pedidos_has_productos_id`),
  KEY `fk_pedidos_has_productos_pedidos_has_productos_estados1` (`pedidos_has_productos_estados_id`),
  CONSTRAINT `fk_pedidos_has_productos_pedidos1` FOREIGN KEY (`pedidos_id`) REFERENCES `pedidos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidos_has_productos_pedidos_has_productos_estados1` FOREIGN KEY (`pedidos_has_productos_estados_id`) REFERENCES `pedidos_has_productos_estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidos_has_productos_productos1` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos_has_productos`
--

LOCK TABLES `pedidos_has_productos` WRITE;
/*!40000 ALTER TABLE `pedidos_has_productos` DISABLE KEYS */;
INSERT INTO `pedidos_has_productos` VALUES (1,1,16,'',NULL,'2016-11-15 23:38:45',2),(2,1,14,'',NULL,'2016-11-15 23:40:26',2),(3,1,15,'',NULL,'2016-11-15 23:42:21',2),(4,1,40,NULL,'3','2016-11-15 23:42:21',2),(5,1,17,'',NULL,'2016-11-16 00:21:31',2),(6,1,20,'',NULL,'2016-11-16 00:27:53',2),(7,3,3,'',NULL,'2016-11-16 00:36:40',2),(8,4,3,'',NULL,'2016-11-16 00:39:51',2),(9,5,3,'',NULL,'2016-11-16 00:40:49',2),(10,6,9,'sin cilantro',NULL,'2016-11-17 03:22:21',2),(11,6,18,'',NULL,'2016-11-17 03:23:15',2),(12,7,11,'',NULL,'2016-11-17 03:28:38',2),(13,8,16,'',NULL,'2016-11-17 21:46:29',2);
/*!40000 ALTER TABLE `pedidos_has_productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos_has_productos_estados`
--

DROP TABLE IF EXISTS `pedidos_has_productos_estados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedidos_has_productos_estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos_has_productos_estados`
--

LOCK TABLES `pedidos_has_productos_estados` WRITE;
/*!40000 ALTER TABLE `pedidos_has_productos_estados` DISABLE KEYS */;
INSERT INTO `pedidos_has_productos_estados` VALUES (1,'Seleccionado'),(2,'Confirmado'),(3,'En preparación'),(4,'Entregado'),(5,'Cancelado');
/*!40000 ALTER TABLE `pedidos_has_productos_estados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8_unicode_ci,
  `precio` float DEFAULT NULL,
  `aplicacion_id` int(11) NOT NULL,
  `mostrable` tinyint(1) NOT NULL DEFAULT '1',
  `preparacion_cocina` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_productos_aplicacion1` (`aplicacion_id`),
  CONSTRAINT `fk_productos_aplicacion1` FOREIGN KEY (`aplicacion_id`) REFERENCES `aplicacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'Haburguesa Especial','(lechuga, tomate, bacon, queso, salsa barbacoa)',5.5,7,1,1),(2,'Nachos de pollo','(con guacamole y salsa picante)',2,7,1,1),(3,'Nachos de carne','(con guacamole y salsa picante)',2.3,7,1,1),(4,'Deditos de pollo','(rebozados y fritos)',2,7,1,1),(5,'Costilla a la barbacoa','(costilla de cerdo con barbacoa)',5.5,7,1,1),(6,'Emparedado de jamón y queso','(pan arabe)',4,7,1,1),(7,'Emparedado de pollo','(pan francés)',3,7,1,1),(8,'Emparedado de res','(pan francés)',4.5,7,1,1),(9,'Nachos pequeños','(para una persona)',2,7,1,1),(10,'Nachos completos','(para dos personas)',3,7,1,1),(11,'Enciladas de poll','(con salsa picante)',3,7,1,1),(12,'Fajitas mexicanas','(con palta)',2,7,1,1),(13,'Quesadillas de pollo','(con chedar, mootzarella y roquefort)',3,7,1,1),(14,'Copa de helado','(frutilla, americana o chocolate)',1,7,1,1),(15,'Ensalada de frutas','(manzana, kiwi, naranja, frutilla y banana)',2,7,1,1),(16,'Sorpresa tropical','',3,7,1,1),(17,'Batido de piña','',2,7,1,0),(18,'Batido de banana','',1,7,1,0),(19,'Batido mixto de frutas','(banana y piña)',2,7,1,0),(20,'Coca cola','(lata 330cc)',2,7,1,0),(21,'7 Up','(lata 330cc)',2,7,1,1),(22,'Paso de los toros pomelo','(lata 330cc)',1,7,1,0),(23,'Cafe con leche','',1,7,1,0),(24,'Te con leche','',1,7,1,0),(25,'Chocolate caliente','',2,7,1,0),(26,'Heineken','(porron 550cc)',3,7,1,0),(27,'Ron','(Vaso de trago)',2,7,1,0),(28,'Vodka','(Vaso de trago)',2,7,1,0),(29,'Wishky','(medida)',2,7,1,0),(30,'Qara Malbec','(Tinto)',3,7,1,0),(31,'Qara Cabernet','(tinto)',3,7,1,0),(32,'Trumpeter malbec','(Tinto)',3,7,1,0),(33,'San felicien chardonay','(Blanco)',2,7,1,0),(34,'Alma mora chardonay','(Blanco)',2,7,1,0),(35,'Tequila sunrise','',3,7,1,0),(36,'Fernet cola','(fernet, coca cola)',3,7,1,0),(37,'Gin tonic','(gin, agua tónica, pepino)',2,7,1,0),(38,'queso chedar','',0.2,7,0,1),(39,'helado','para la ensalada de frutas',0.5,7,0,1),(40,'caramelos','para la ensalada de frutas',0.3,7,0,1);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_has_categorias`
--

DROP TABLE IF EXISTS `productos_has_categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos_has_categorias` (
  `productos_id` int(11) NOT NULL,
  `categorias_id` int(11) NOT NULL,
  PRIMARY KEY (`productos_id`,`categorias_id`),
  KEY `fk_productos_has_categorias_categorias1` (`categorias_id`),
  KEY `fk_productos_has_categorias_productos1` (`productos_id`),
  CONSTRAINT `fk_productos_has_categorias_categorias1` FOREIGN KEY (`categorias_id`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_productos_has_categorias_productos1` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_has_categorias`
--

LOCK TABLES `productos_has_categorias` WRITE;
/*!40000 ALTER TABLE `productos_has_categorias` DISABLE KEYS */;
INSERT INTO `productos_has_categorias` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(38,1),(6,2),(7,2),(8,2),(9,3),(10,3),(11,3),(12,3),(13,3),(14,4),(15,4),(16,4),(39,4),(40,4),(17,5),(18,5),(19,5),(20,6),(21,6),(22,6),(23,7),(24,7),(25,7),(26,8),(27,8),(28,8),(29,8),(30,9),(31,9),(32,9),(33,9),(34,9),(35,10),(36,10),(37,10);
/*!40000 ALTER TABLE `productos_has_categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_has_productos_opciones`
--

DROP TABLE IF EXISTS `productos_has_productos_opciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos_has_productos_opciones` (
  `productos_id` int(11) NOT NULL,
  `productos_opciones_id` int(11) NOT NULL,
  PRIMARY KEY (`productos_id`,`productos_opciones_id`),
  KEY `fk_productos_has_productos_opciones_productos_opciones1` (`productos_opciones_id`),
  KEY `fk_productos_has_productos_opciones_productos1` (`productos_id`),
  CONSTRAINT `fk_productos_has_productos_opciones_productos1` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_productos_has_productos_opciones_productos_opciones1` FOREIGN KEY (`productos_opciones_id`) REFERENCES `productos_opciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_has_productos_opciones`
--

LOCK TABLES `productos_has_productos_opciones` WRITE;
/*!40000 ALTER TABLE `productos_has_productos_opciones` DISABLE KEYS */;
INSERT INTO `productos_has_productos_opciones` VALUES (6,1),(15,3),(15,4);
/*!40000 ALTER TABLE `productos_has_productos_opciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_imagenes`
--

DROP TABLE IF EXISTS `productos_imagenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos_imagenes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `producto_id` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `productos_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`productos_id`),
  KEY `fk_productos_imagenes_productos1` (`productos_id`),
  CONSTRAINT `fk_productos_imagenes_productos1` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_imagenes`
--

LOCK TABLES `productos_imagenes` WRITE;
/*!40000 ALTER TABLE `productos_imagenes` DISABLE KEYS */;
INSERT INTO `productos_imagenes` VALUES (1,'app7/1434829407.jpeg','',1),(2,'app7/1434829408.jpeg','',1),(3,'app7/1434829431.jpeg','',2),(4,'app7/1434829432.jpeg','',2),(5,'app7/1434829447.jpeg','',3),(6,'app7/1434829457.jpeg','',3),(7,'app7/1434829472.jpeg','',4),(8,'app7/1434829473.jpg','',4),(9,'app7/1434829644.jpeg','',5),(10,'app7/1434829645.jpeg','',5),(11,'app7/1434829661.jpeg','',6),(12,'app7/1434829662.jpeg','',6),(13,'app7/1434829680.jpeg','',7),(14,'app7/1434829681.jpeg','',7),(15,'app7/1434829695.jpeg','',8),(16,'app7/1434829696.jpeg','',8),(17,'app7/1434829796.jpeg','',9),(18,'app7/1434829806.jpeg','',9),(19,'app7/1434829831.jpeg','',10),(20,'app7/1434829877.jpeg','',10),(21,'app7/1434830041.jpeg','',11),(22,'app7/1434830042.jpeg','',11),(23,'app7/1434830062.jpeg','',12),(24,'app7/1434830063.jpeg','',12),(25,'app7/1434830085.jpeg','',13),(26,'app7/1434830086.jpeg','',13),(27,'app7/1434830100.jpeg','',14),(28,'app7/1434830109.jpeg','',14),(29,'app7/1434830246.jpeg','',15),(30,'app7/1434830247.jpeg','',15),(31,'app7/1434830267.jpeg','',16),(32,'app7/1434830279.jpeg','',17),(33,'app7/1434830280.jpeg','',17),(34,'app7/1434830294.jpeg','',18),(35,'app7/1434830295.jpeg','',18),(36,'app7/1434830355.jpg','',19),(37,'app7/1434830364.jpg','',19),(38,'app7/1434830405.jpeg','',20),(39,'app7/1434830522.jpeg','',21),(40,'app7/1434830532.jpeg','',22),(41,'app7/1434830676.jpeg','',23),(42,'app7/1434830694.jpeg','',24),(43,'app7/1434830703.jpeg','',25),(44,'app7/1434830711.jpeg','',26),(45,'app7/1434830900.jpg','',27),(46,'app7/1434830908.jpeg','',28),(47,'app7/1434830923.jpeg','',29),(48,'app7/1434830931.jpeg','',30),(49,'app7/1434831031.jpg','',31),(50,'app7/1434831040.jpeg','',32),(51,'app7/1434831052.jpeg','',33),(52,'app7/1434831061.jpeg','',34),(53,'app7/1434831148.jpeg','',35),(54,'app7/1434831149.jpeg','',35),(55,'app7/1434831160.jpg','',36),(56,'app7/1434831170.jpeg','',37),(57,'app7/1434831171.jpeg','',37);
/*!40000 ALTER TABLE `productos_imagenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_opciones`
--

DROP TABLE IF EXISTS `productos_opciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos_opciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_opciones`
--

LOCK TABLES `productos_opciones` WRITE;
/*!40000 ALTER TABLE `productos_opciones` DISABLE KEYS */;
INSERT INTO `productos_opciones` VALUES (1,'adicional de queso'),(3,'adicional2'),(4,'adicional1');
/*!40000 ALTER TABLE `productos_opciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_opciones_has_productos`
--

DROP TABLE IF EXISTS `productos_opciones_has_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos_opciones_has_productos` (
  `productos_opciones_id` int(11) NOT NULL,
  `productos_id` int(11) NOT NULL,
  PRIMARY KEY (`productos_opciones_id`,`productos_id`),
  KEY `fk_productos_opciones_has_productos_productos1` (`productos_id`),
  KEY `fk_productos_opciones_has_productos_productos_opciones1` (`productos_opciones_id`),
  CONSTRAINT `fk_productos_opciones_has_productos_productos1` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_productos_opciones_has_productos_productos_opciones1` FOREIGN KEY (`productos_opciones_id`) REFERENCES `productos_opciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_opciones_has_productos`
--

LOCK TABLES `productos_opciones_has_productos` WRITE;
/*!40000 ALTER TABLE `productos_opciones_has_productos` DISABLE KEYS */;
INSERT INTO `productos_opciones_has_productos` VALUES (1,38),(4,39),(3,40);
/*!40000 ALTER TABLE `productos_opciones_has_productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `orden` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'superadmin',1),(2,'admin',2),(3,'encargado',3),(5,'cocina',4),(6,'camarero',5),(7,'recepcionista',6),(8,'comensal',7),(9,'comensal1',8);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pass` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_usuarios_empresa` (`empresa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'diego','diego','sanabria','diego@diego.com','7da4377e7b6f53149ed5914ae092a733b8dcdf8f',NULL,1),(2,'dperez','Daniel','Perez','dperez@gmail.com','ef0c2c771d8ccd18f81fe2d56622794567ea6a61',1,1),(3,'aperez','Alejandro','Perez','aperez@gmail.com','b6e6507ea007b404a74dfa9faf9666c175608de8',1,1),(4,'jgomez','Joaquin','Gomez','jgomez@gmail.com','7344cec5d08527a6f97d122ede3db9e2998e537f',1,1),(5,'gdominguez','Gabriel','Dominguez','gdominguez@gmail.com','c402ccc5b2f44444491368a534a78804e4a03d7d',1,0),(6,'agomez','Alberto','Gomez','agomez@gmail.com','1ffb673d483ba927d94b2a0de1e8b97cba203d1a',1,0),(13,'jlopez','Juan','Lopez','jlopez@gamil.com','e633a13147abb1c1863ea3943cfdffc90b7890bc',1,1),(14,'dfernandez','Daniel','Fernandez','dfernandez@gmail.com','11c55bf18b33230c17aca1b4778901e45f593af9',1,1),(15,'gfernandez','Gabriel','Fernandez','gfernandez@gmail.com','f7d8589d2d8b097a963d9969ee5941913e139dae',1,1),(16,'dsanchez','Daniel','Sanchez','dsanchez@paraisotropical.com','57ff528626ad71b5b893bbdb8b373a6af96d8536',5,1),(17,'esanchez','Esteban','Sanchez','esanchez@paraisotropical.com','39a318bf83d1935f54cde2f05e03aea0880f72f1',5,1),(18,'asanchez','Alejandro','Sanchez','asanchez@paraisotropical.com','e7b33aaf142e1c45f1e39ba0bf366a316433ebdf',5,1),(19,'1479003182.diego','diego','diego',NULL,'b817713031b893bdf8aeadb25021fb25b1e6a370',5,0),(20,'1479003483.diego','diego','diego',NULL,'7e95ed5c426fd15f6de8f0e7fa73a1e28eddb977',5,1),(21,'1479003531.diego','diego','diego',NULL,'cbb0a5f968637a7417e865c40d65edcd34221596',5,1),(22,'1479005471.Diego','Diego','Diego',NULL,'68b7623b1daca1983ccfc3406ac9494dd61416a5',5,1),(23,'1479005697.dfsgd','dfsgd','dfsgd',NULL,'80d6779b6a63306cf60317428fe32454f0bc2343',5,1),(24,'1479005835.dfsgd','dfsgd','dfsgd',NULL,'f180ec1715b359298e3421e7bf21fbf0a9e4a4b4',5,1),(25,'1479005903.dfsgd','dfsgd','dfsgd',NULL,'210a57b3705a222232b26f7e7da26580e763f479',5,1),(26,'1479005935.afd','afd','afd',NULL,'80f8d2a508ff1a136b8a258f1fa93117adc83c85',5,1),(27,'1479006184.diegohsa','diegohsa','diegohsa',NULL,'31305d2c2be661fa259e554cf19a291a5725acb0',5,1),(28,'1479006282.diegohsa','diegohsa','diegohsa',NULL,'ca1fb291f885c62b6e29d671ff6e4deaba44b6da',5,1),(29,'1479006374.diegohsa','diegohsa','diegohsa',NULL,'501b69e3f83ff8a3bed4fcae04bfa25c39c99132',5,1),(30,'1479076041.dieo','dieo','dieo',NULL,'bdd6c084885bb63a718a230306d1f889b2af23a5',5,1),(31,'1479076261.diegoaso','diegoaso','diegoaso',NULL,'87368a2fada851b72e9ef95e214e2390791e899b',5,1),(32,'1479076614.dieg','dieg','dieg',NULL,'e7cebb69f3642167016747a6781b03fe188d267c',5,1),(33,'1479077056.dieg','dieg','dieg',NULL,'2bd7cef724bcb8c801ce3952bd28fd03a136b7f1',5,1),(34,'1479078475.adsfasdf','adsfasdf','adsfasdf',NULL,'89db0f76e400b3488e7d297a9ef8987478ef2b6c',5,1),(35,'1479079099.ewe','ewe','ewe',NULL,'27ca102eb6c7f47b0bfecb8962bc59e675644c9c',5,1),(36,'1479079231.lkfng','lkfng','lkfng',NULL,'f05ce2fc3f897644ea16157c40ba068a29cf6a07',5,1),(37,'1479079280.ewe','ewe','ewe',NULL,'1a7ca9b011cae912700ec882831604e8a02f3496',5,1),(38,'1479079321.diego','diego','diego',NULL,'62747d14d09fceb02de9da214b331c3d444b7ead',5,1),(39,'1479079924.aaaaaa','aaaaaa','aaaaaa',NULL,'74c1b3c54f137d87e8155c1c2b0e032b01d864e9',5,1),(40,'1479081944.diego','diego','diego',NULL,'d30d2f7d935b4361f24758fb44c789e15554713e',5,1),(41,'1479082036.diego','diego','diego',NULL,'0d92363cdf3fe759e6af90900bff09a57132267c',5,1),(42,'1479083397.Ewelina','Ewelina','Ewelina',NULL,'ca793af7e16a3728de1b9a6a6847cd39d0ad6230',5,1),(43,'1479083542.alguien','alguien','alguien',NULL,'898baa88d5b745e2f06e51f91eff7da264ce1ccd',5,1),(44,'1479083584.yo','yo','yo',NULL,'201879b4eae683ab360e2f5f7e9fae67fabf8449',5,1),(45,'1479083742.dfgd','dfgd','dfgd',NULL,'116395d7a0c317bf299b318cca1b95f4185483bf',5,1),(46,'1479083760.dfgd','dfgd','dfgd',NULL,'35ad24ebd5e8a830cc5dd5f05bafcf5f11f6f43a',5,1),(47,'1479083802.dfgd','dfgd','dfgd',NULL,'191d040a84b80451bec6dec0cd003d07f68f2b8e',5,1),(48,'1479084061.dfgd','dfgd','dfgd',NULL,'acbd3ff6382f65965185c1b37793b3501e06dc80',5,1),(49,'1479084126.sdafsda','sdafsda','sdafsda',NULL,'06f71bd1d68415d822654fb5ec7077e3262edd2e',5,1),(50,'1479084604.dgfsdfg','dgfsdfg','dgfsdfg',NULL,'8bd6f217227f5a0a0b02766d5379ede362a52089',5,1),(51,'1479084615.Ewelina','Ewelina','Ewelina',NULL,'06a589def7ba9a504dd9ce16a6c703f9029354cf',5,1),(52,'1479084705.sdknadkf','sdknadkf','sdknadkf',NULL,'fdf95dc5bf2795fee5c1e2debe237a773321cc36',5,1),(53,'1479084738.l,kñskldmlkfd','l,kñskldmlkfd','l,kñskldmlkfd',NULL,'f603ad9af9b4efa71c8a573b785b9cb083befe32',5,1),(54,'1479084753.lsdnafkda','lsdnafkda','lsdnafkda',NULL,'fd807e33de5a6b1189f965f78e9c6d72c29a11c1',5,1),(55,'1479084769.dsdddd','dsdddd','dsdddd',NULL,'cc43042acb8d742cb4c4ca5f88993a5de6f06e05',5,1),(56,'1479084974.aaaaaaaaaa','aaaaaaaaaa','aaaaaaaaaa',NULL,'62e1f9037f1d8622fe00662ed9c43b07f2504073',5,1),(57,'1479084984.bbbbbb','bbbbbb','bbbbbb',NULL,'924075e3df29cb550ba5557b4976ec6f380ea905',5,1),(58,'1479085518.Diego','Diego','Diego',NULL,'7436a52fa611d75dacb8b747ae62e514af0a9c43',5,1),(59,'1479085732.Pablo','Pablo','Pablo',NULL,'ec394d48b2d015f881ea3fc9a35103f2f51ebeeb',5,1),(60,'1479088461.Ewelina','Ewelina','Ewelina',NULL,'9625c0b2bc064c0e5be431ae29fd3db564f64bbc',5,1),(61,'1479168699.Diego','Diego','Diego',NULL,'886adbd7f8d1effa21b4bfbd1117e378d7db3684',5,1),(62,'1479352916.Diego','Diego','Diego',NULL,'db8c86671ac4a09d92c5297102a960c7e404b32e',5,1),(63,'1479354774.Diego','Diego','Diego',NULL,'eca80213d663a1692210de37da1ca382f4e0375d',5,1),(64,'dgomez','daniel','gomez','dgomes@gmail.com','a4c7cc605820d9eb723f4c4c7fbe5cc8492f1a5f',3,1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_aplicacion`
--

DROP TABLE IF EXISTS `usuarios_aplicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_aplicacion` (
  `usuarios_id` int(11) NOT NULL,
  `aplicacion_id` int(11) NOT NULL,
  PRIMARY KEY (`aplicacion_id`,`usuarios_id`),
  KEY `fk_usuarios_aplicacion_usuarios1` (`usuarios_id`),
  KEY `fk_usuarios_aplicacion_aplicacion1` (`aplicacion_id`),
  CONSTRAINT `fk_usuarios_aplicacion_aplicacion1` FOREIGN KEY (`aplicacion_id`) REFERENCES `aplicacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_aplicacion_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_aplicacion`
--

LOCK TABLES `usuarios_aplicacion` WRITE;
/*!40000 ALTER TABLE `usuarios_aplicacion` DISABLE KEYS */;
INSERT INTO `usuarios_aplicacion` VALUES (2,1),(3,1),(4,1),(13,1),(14,2),(15,2),(16,7),(17,7),(18,7),(19,7),(20,7),(21,7),(22,7),(23,7),(24,7),(25,7),(26,7),(27,7),(28,7),(29,7),(30,7),(31,7),(32,7),(33,7),(34,7),(35,7),(36,7),(37,7),(38,7),(39,7),(40,7),(41,7),(42,7),(43,7),(44,7),(45,7),(46,7),(47,7),(48,7),(49,7),(50,7),(51,7),(52,7),(53,7),(54,7),(55,7),(56,7),(57,7),(58,7),(59,7),(60,7),(61,7),(62,7),(63,7),(64,3);
/*!40000 ALTER TABLE `usuarios_aplicacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_roles`
--

DROP TABLE IF EXISTS `usuarios_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_roles` (
  `usuarios_id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL,
  PRIMARY KEY (`usuarios_id`,`roles_id`),
  KEY `fk_usuarios_roles_usuarios1` (`usuarios_id`),
  KEY `fk_usuarios_roles_roles1` (`roles_id`),
  CONSTRAINT `fk_usuarios_roles_roles1` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_roles_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_roles`
--

LOCK TABLES `usuarios_roles` WRITE;
/*!40000 ALTER TABLE `usuarios_roles` DISABLE KEYS */;
INSERT INTO `usuarios_roles` VALUES (1,1),(2,2),(3,3),(4,6),(13,7),(14,3),(16,2),(17,3),(18,6),(19,8),(20,8),(21,8),(22,8),(23,8),(24,8),(25,8),(26,8),(27,8),(28,8),(29,8),(30,8),(31,8),(32,8),(33,9),(34,9),(35,9),(36,9),(37,9),(38,9),(39,9),(40,9),(41,9),(42,9),(43,9),(44,9),(45,9),(46,9),(47,9),(48,9),(49,9),(50,9),(51,9),(52,9),(53,9),(54,9),(55,9),(56,9),(57,9),(58,9),(59,9),(60,9),(61,9),(62,9),(63,9),(64,2);
/*!40000 ALTER TABLE `usuarios_roles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-17 17:00:14
