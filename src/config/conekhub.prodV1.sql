-- MySQL dump 10.16  Distrib 10.2.14-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: conekhub_test
-- ------------------------------------------------------
-- Server version	10.2.14-MariaDB

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
-- Table structure for table `carreras`
--

DROP TABLE IF EXISTS `carreras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carreras` (
  `id_carrera` int(11) NOT NULL AUTO_INCREMENT,
  `carrera` varchar(100) NOT NULL,
  `id_escuela` int(11) NOT NULL,
  PRIMARY KEY (`id_carrera`),
  KEY `id_escuela` (`id_escuela`),
  CONSTRAINT `carreras_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carreras`
--

LOCK TABLES `carreras` WRITE;
/*!40000 ALTER TABLE `carreras` DISABLE KEYS */;
INSERT INTO `carreras` VALUES (1,'Contaduría Pública',1),(2,'Licenciatura en Administración',1),(3,'Licenciatura en Gastronomía',2),(4,'Licenciatura en Negocios Internacionales',2),(5,'Ingeniería en Mantenimiento Industrial',3),(6,'Ingeniería Financiera y Fiscal',3),(7,'Ingeniería en Sistemas Computacionales',1);
/*!40000 ALTER TABLE `carreras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `escuelas`
--

DROP TABLE IF EXISTS `escuelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `escuelas` (
  `id_escuela` int(11) NOT NULL AUTO_INCREMENT,
  `escuela` varchar(100) NOT NULL,
  `matricula` int(11) NOT NULL,
  PRIMARY KEY (`id_escuela`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escuelas`
--

LOCK TABLES `escuelas` WRITE;
/*!40000 ALTER TABLE `escuelas` DISABLE KEYS */;
INSERT INTO `escuelas` VALUES (1,'Instituto Tecnológico de Cancún ',1),(2,'Universidad del Caribe ',2),(3,'Universidad Tecnológica de Cancún ',3);
/*!40000 ALTER TABLE `escuelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friendlist`
--

DROP TABLE IF EXISTS `friendlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friendlist` (
  `id_usuario` int(11) NOT NULL,
  `id_usuario_FK` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_usuario_FK`),
  KEY `id_usuario_FK` (`id_usuario_FK`),
  CONSTRAINT `friendlist_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  CONSTRAINT `friendlist_ibfk_2` FOREIGN KEY (`id_usuario_FK`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friendlist`
--

LOCK TABLES `friendlist` WRITE;
/*!40000 ALTER TABLE `friendlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `friendlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grados_escolares`
--

DROP TABLE IF EXISTS `grados_escolares`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grados_escolares` (
  `id_grado` int(11) NOT NULL,
  `grado` varchar(20) NOT NULL,
  PRIMARY KEY (`id_grado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grados_escolares`
--

LOCK TABLES `grados_escolares` WRITE;
/*!40000 ALTER TABLE `grados_escolares` DISABLE KEYS */;
INSERT INTO `grados_escolares` VALUES (1,'1er Semestre'),(2,'2do Semestre'),(3,'3er Semestre'),(4,'4to Semestre'),(5,'5to Semestre'),(6,'6to Semestre');
/*!40000 ALTER TABLE `grados_escolares` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `habilidades`
--

DROP TABLE IF EXISTS `habilidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `habilidades` (
  `id_habilidad` int(11) NOT NULL AUTO_INCREMENT,
  `habilidad` varchar(100) NOT NULL,
  PRIMARY KEY (`id_habilidad`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `habilidades`
--

LOCK TABLES `habilidades` WRITE;
/*!40000 ALTER TABLE `habilidades` DISABLE KEYS */;
INSERT INTO `habilidades` VALUES (1,'UX'),(2,'UI'),(3,'HTML'),(4,'CSS'),(5,'SQL'),(6,'GIT'),(7,'Matematicas'),(8,'Ventas'),(9,'Trato con personas'),(10,'Contabilidad');
/*!40000 ALTER TABLE `habilidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_has_habilidades`
--

DROP TABLE IF EXISTS `usuario_has_habilidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_has_habilidades` (
  `id_usuario` int(11) DEFAULT NULL,
  `id_habilidad` int(11) DEFAULT NULL,
  KEY `id_usuario` (`id_usuario`),
  KEY `id_habilidad` (`id_habilidad`),
  CONSTRAINT `usuario_has_habilidades_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  CONSTRAINT `usuario_has_habilidades_ibfk_2` FOREIGN KEY (`id_habilidad`) REFERENCES `habilidades` (`id_habilidad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_has_habilidades`
--

LOCK TABLES `usuario_has_habilidades` WRITE;
/*!40000 ALTER TABLE `usuario_has_habilidades` DISABLE KEYS */;
INSERT INTO `usuario_has_habilidades` VALUES (27,1),(27,2),(28,5),(28,7);
/*!40000 ALTER TABLE `usuario_has_habilidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `correo` varchar(55) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `id_escuela` int(11) DEFAULT NULL,
  `id_carrera` int(11) DEFAULT NULL,
  `id_grado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `id_escuela` (`id_escuela`),
  KEY `id_carrera` (`id_carrera`),
  KEY `id_grado` (`id_grado`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`),
  CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id_carrera`),
  CONSTRAINT `usuarios_ibfk_3` FOREIGN KEY (`id_grado`) REFERENCES `grados_escolares` (`id_grado`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (25,'Josue ','Alonso Sanchez','alonsotec@itcancun.com','123456',1,7,5),(26,'Arturo','Medina Rios','artur@rios.com','12345@2018',1,1,1),(27,'Henrry','Ramirez','hramirez@itcancun.com','admin123',1,7,6),(28,'Gameba ','Esteves Ceballos','gesteves@gmail.com','123456',1,7,5),(30,'Antonio','Hoil Gamboa','ahoil@itcancun.com','123456',2,3,1),(31,'Cristian','Gomez','henramirez@itcancun.com','12222',1,2,2),(33,'admin','admin','admin@admin.com','admin123',1,7,6),(34,'Jose','Estrada','jestrada@gmail.com','123456',2,3,3),(35,'Luis','Escobedo Trenado','escobedotrenado@hotmail.com','1234',1,7,6),(36,'hola','¿aaa','pitytezum@zaqutevedihotuq.com','Pa$$w0rd!',2,3,4),(37,'josue','sanchez','josuesanchez1224@gmail.com','12345',1,7,6),(38,'ghh','NBVN','kapowomyr@tunuhaxamykocub.com','Pa$$w0rd!',2,4,6),(40,'BBBH','BBB','xativele@fevytytoru.com','Pa$$w0rd!',2,4,4);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-26  1:07:04
