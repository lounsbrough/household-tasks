CREATE DATABASE  IF NOT EXISTS `householdtasks` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */;
USE `householdtasks`;
-- MySQL dump 10.13  Distrib 8.0.13, for Win64 (x86_64)
--
-- Host: localhost    Database: householdtasks
-- ------------------------------------------------------
-- Server version	8.0.13

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `assignedtasks`
--

DROP TABLE IF EXISTS `assignedtasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `assignedtasks` (
  `AssignmentKey` int(11) NOT NULL AUTO_INCREMENT,
  `TaskKey` int(11) NOT NULL,
  `PersonKey` int(11) NOT NULL,
  `AssignmentTMS` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`AssignmentKey`),
  KEY `taskassignment_TaskKey_idx` (`TaskKey`),
  KEY `taskassignment_PersonKey_idx` (`PersonKey`),
  CONSTRAINT `assignedtasks_PersonKey` FOREIGN KEY (`PersonKey`) REFERENCES `persons` (`personkey`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `assignedtasks_TaskKey` FOREIGN KEY (`TaskKey`) REFERENCES `definedtasks` (`taskkey`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `completedtasks`
--

DROP TABLE IF EXISTS `completedtasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `completedtasks` (
  `CompletionKey` int(11) NOT NULL AUTO_INCREMENT,
  `TaskKey` int(11) DEFAULT NULL,
  `PersonKey` int(11) DEFAULT NULL,
  `CompletedTMS` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`CompletionKey`),
  KEY `TaskKey_idx` (`TaskKey`),
  KEY `completedtasks_PersonKey_idx` (`PersonKey`),
  CONSTRAINT `completedtasks_PersonKey` FOREIGN KEY (`PersonKey`) REFERENCES `persons` (`personkey`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `completedtasks_TaskKey` FOREIGN KEY (`TaskKey`) REFERENCES `definedtasks` (`taskkey`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `definedtasks`
--

DROP TABLE IF EXISTS `definedtasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `definedtasks` (
  `TaskKey` int(11) NOT NULL AUTO_INCREMENT,
  `TaskName` varchar(50) DEFAULT NULL,
  `DurationMinutes` int(11) DEFAULT NULL,
  `NextOccurrenceTMS` timestamp NULL DEFAULT NULL,
  `Snoozed` tinyint(4) DEFAULT NULL,
  `LastNotificationTMS` timestamp NULL DEFAULT NULL,
  `WeekDay` varchar(9) DEFAULT NULL,
  `MonthDay` int(11) DEFAULT NULL,
  `SpecificTime` tinyint(4) DEFAULT NULL,
  `TimeOfDay` varchar(8) DEFAULT NULL,
  `RecurrenceAmount` int(11) DEFAULT NULL,
  `RecurrenceType` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`TaskKey`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `persons`
--

DROP TABLE IF EXISTS `persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `persons` (
  `PersonKey` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`PersonKey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pushbulletdevices`
--

DROP TABLE IF EXISTS `pushbulletdevices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `pushbulletdevices` (
  `DeviceKey` int(11) NOT NULL AUTO_INCREMENT,
  `PersonKey` int(11) NOT NULL,
  `DeviceName` varchar(50) DEFAULT NULL,
  `ReceiveDefaultNotifications` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`DeviceKey`),
  KEY `pushbulletdevices_PersonKey_idx` (`PersonKey`),
  CONSTRAINT `pushbulletdevices_PersonKey` FOREIGN KEY (`PersonKey`) REFERENCES `persons` (`personkey`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-12 20:16:35
