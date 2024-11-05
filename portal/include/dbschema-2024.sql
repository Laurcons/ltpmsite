-- Adminer 4.8.1 MySQL 9.1.0 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `ltpmdb`;
CREATE DATABASE `ltpmdb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `ltpmdb`;

DROP TABLE IF EXISTS `absente`;
CREATE TABLE `absente` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `IdElev` int NOT NULL,
  `IdMaterie` int NOT NULL,
  `IdClasa` int NOT NULL,
  `Semestru` enum('1','2') NOT NULL,
  `Ziua` int NOT NULL,
  `Luna` int NOT NULL,
  `Motivata` tinyint NOT NULL DEFAULT '0',
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Unique` (`IdElev`,`IdMaterie`,`Ziua`,`Luna`),
  KEY `IdElev` (`IdElev`),
  KEY `IdMaterie` (`IdMaterie`),
  KEY `IdClasa` (`IdClasa`),
  CONSTRAINT `Absente_IDClasa` FOREIGN KEY (`IdClasa`) REFERENCES `clase` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Absente_IDElev` FOREIGN KEY (`IdElev`) REFERENCES `utilizatori` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Absente_IDMaterie` FOREIGN KEY (`IdMaterie`) REFERENCES `materii` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `activitate`;
CREATE TABLE `activitate` (
  `Id` int NOT NULL,
  `IdElev` int NOT NULL,
  `IdMaterie` int NOT NULL,
  `Plusuri` int NOT NULL,
  `Minusuri` int NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `IdElev` (`IdElev`),
  KEY `IdMaterie` (`IdMaterie`),
  CONSTRAINT `Activitate_IDElev` FOREIGN KEY (`IdElev`) REFERENCES `utilizatori` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `Activitate_IDMaterie` FOREIGN KEY (`IdMaterie`) REFERENCES `materii` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `citate`;
CREATE TABLE `citate` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Text` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `Autor` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `IdUser` int DEFAULT NULL,
  `Comentariu` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `Status` enum('propus','acceptat','respins') CHARACTER SET utf8mb3 COLLATE utf8mb3_romanian_ci NOT NULL,
  `Ziua` date DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `IdUser` (`IdUser`),
  CONSTRAINT `Citate_IDUser` FOREIGN KEY (`IdUser`) REFERENCES `utilizatori` (`Id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_romanian_ci;

INSERT INTO `citate` (`Id`, `Text`, `Autor`, `IdUser`, `Comentariu`, `Status`, `Ziua`) VALUES
(13,	'din tava',	'badu',	24,	'din tava',	'acceptat',	'2024-11-04');

DROP TABLE IF EXISTS `clase`;
CREATE TABLE `clase` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Nivel` int NOT NULL,
  `Sufix` text NOT NULL,
  `IdDiriginte` int NOT NULL,
  `AnScolar` int NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `IdDiriginte` (`IdDiriginte`),
  CONSTRAINT `Clase_IDDiriginte` FOREIGN KEY (`IdDiriginte`) REFERENCES `utilizatori` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO `clase` (`Id`, `Nivel`, `Sufix`, `IdDiriginte`, `AnScolar`) VALUES
(6,	10,	'A',	25,	2024);

DROP TABLE IF EXISTS `game1_scores`;
CREATE TABLE `game1_scores` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `UserId` int DEFAULT NULL,
  `Score` int NOT NULL,
  `Timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `Id` int NOT NULL,
  `Type` text NOT NULL,
  `Username` int NOT NULL,
  `Text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `materii`;
CREATE TABLE `materii` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Nume` text NOT NULL,
  `IdClasa` int NOT NULL,
  `IdProfesor` int NOT NULL,
  `TipTeza` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `materii` (`Id`, `Nume`, `IdClasa`, `IdProfesor`, `TipTeza`) VALUES
(6,	'asdf',	6,	25,	'nu');

DROP TABLE IF EXISTS `note`;
CREATE TABLE `note` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `IdElev` int NOT NULL,
  `IdMaterie` int NOT NULL,
  `IdClasa` int DEFAULT NULL COMMENT 'Necesar pentru ca "PrevClase" sa mearga',
  `IdProfesor` int DEFAULT NULL,
  `Semestru` enum('1','2') NOT NULL,
  `Nota` int NOT NULL,
  `Ziua` int NOT NULL,
  `Luna` int NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Teza` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `Tip` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Unique` (`Luna`,`IdElev`,`IdMaterie`,`IdClasa`,`Semestru`,`Ziua`) USING BTREE,
  KEY `IdElev` (`IdElev`),
  KEY `IdMaterie` (`IdMaterie`),
  KEY `IdClasa` (`IdClasa`),
  KEY `IdProfesor` (`IdProfesor`),
  CONSTRAINT `Note_IDClasa` FOREIGN KEY (`IdClasa`) REFERENCES `clase` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Note_IDElev` FOREIGN KEY (`IdElev`) REFERENCES `utilizatori` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Note_IDMaterie` FOREIGN KEY (`IdMaterie`) REFERENCES `materii` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Note_IDProfesor` FOREIGN KEY (`IdProfesor`) REFERENCES `utilizatori` (`Id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `note` (`Id`, `IdElev`, `IdMaterie`, `IdClasa`, `IdProfesor`, `Semestru`, `Nota`, `Ziua`, `Luna`, `Timestamp`, `Teza`, `Tip`) VALUES
(1,	26,	6,	NULL,	25,	'1',	10,	7,	8,	'2024-11-04 13:59:37',	NULL,	'test');

DROP TABLE IF EXISTS `noutati`;
CREATE TABLE `noutati` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Titlu` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `Continut` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL COMMENT 'Accepta HTML!',
  `Autor` text CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;


DROP TABLE IF EXISTS `predari`;
CREATE TABLE `predari` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `IdProfesor` int NOT NULL,
  `IdMaterie` int NOT NULL,
  `IdClasa` int NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Predari_UNIQUE` (`IdClasa`,`IdProfesor`,`IdMaterie`),
  KEY `Predari_IDProfesor` (`IdProfesor`),
  KEY `Predari_IDMaterie` (`IdMaterie`),
  KEY `IdClasa` (`IdClasa`),
  CONSTRAINT `Predari_IDClasa` FOREIGN KEY (`IdClasa`) REFERENCES `clase` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Predari_IDMaterie` FOREIGN KEY (`IdMaterie`) REFERENCES `materii` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Predari_IDProfesor` FOREIGN KEY (`IdProfesor`) REFERENCES `utilizatori` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `resurse`;
CREATE TABLE `resurse` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Titlu` text NOT NULL,
  `IdProfesor` int NOT NULL,
  `Nivel` int DEFAULT NULL,
  `Meta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `ContinutHtml` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `Adaugat` timestamp NULL DEFAULT NULL,
  `Modificat` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `resurse` (`Id`, `Titlu`, `IdProfesor`, `Nivel`, `Meta`, `ContinutHtml`, `Adaugat`, `Modificat`) VALUES
(1,	'nou_laur',	24,	NULL,	NULL,	'',	NULL,	NULL);

DROP TABLE IF EXISTS `utilizatori`;
CREATE TABLE `utilizatori` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `Parola` varchar(255) NOT NULL,
  `Email` text NOT NULL,
  `CodInregistrare` text,
  `Autoritate` text NOT NULL,
  `Functie` text NOT NULL,
  `NrMatricol` text,
  `IdClasa` int DEFAULT NULL,
  `PrevClase` text,
  `Nume` text NOT NULL,
  `Prenume` text NOT NULL,
  `Creat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Activat` datetime DEFAULT NULL,
  `UltimaLogare` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `username` (`Username`),
  KEY `IdClasa` (`IdClasa`),
  CONSTRAINT `Utilizatori_IDClasa` FOREIGN KEY (`IdClasa`) REFERENCES `clase` (`Id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `utilizatori` (`Id`, `Username`, `Parola`, `Email`, `CodInregistrare`, `Autoritate`, `Functie`, `NrMatricol`, `IdClasa`, `PrevClase`, `Nume`, `Prenume`, `Creat`, `Activat`, `UltimaLogare`) VALUES
(24,	'laur',	'$2y$10$3uGqZh3almN3PsT0Jc1ZuuYs/Us6EVWWfsm4900z8l9smxWUHKNtW',	'laur@laur.laur',	NULL,	'admin',	'neatribuit',	'1234',	NULL,	NULL,	'Dev',	'eloper',	'2024-11-04 13:03:13',	'2024-11-04 13:03:13',	'2024-11-04 21:06:10'),
(25,	'iacob',	'$2y$10$VenvA/LXcT58OC5J2H5XjefiwcB2IjzZaMRhmPgUuaX/BWkdv/LLe',	'iak@iakob.com',	NULL,	'normal',	'profesor',	NULL,	NULL,	NULL,	'Iakab',	'Edward',	'2024-11-04 13:50:38',	'2024-11-04 13:56:19',	'2024-11-04 13:57:23'),
(26,	'elev1',	'$2y$10$Vc.IyeEmpK8KsuLL6YLYvOL1FlK3DABEGG1J/y.hwR8y1DZrCZ7Xi',	'elev1@ltpm.ro',	NULL,	'normal',	'elev',	NULL,	6,	NULL,	'El',	'ev',	'2024-11-04 13:56:57',	'2024-11-04 14:00:19',	'2024-11-04 14:00:22');

-- 2024-11-05 08:24:22