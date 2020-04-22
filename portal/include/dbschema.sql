-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 13, 2020 at 11:03 PM
-- Server version: 5.7.29-0ubuntu0.16.04.1
-- PHP Version: 7.2.28-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ltpmdb`
--
CREATE DATABASE IF NOT EXISTS `ltpmdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `ltpmdb`;

-- --------------------------------------------------------

--
-- Table structure for table `absente`
--

CREATE TABLE `absente` (
  `Id` int(11) NOT NULL,
  `IdElev` int(11) NOT NULL,
  `IdMaterie` int(11) NOT NULL,
  `IdClasa` int(11) NOT NULL,
  `Semestru` enum('1','2') NOT NULL,
  `Ziua` int(11) NOT NULL,
  `Luna` int(11) NOT NULL,
  `Motivata` tinyint(4) NOT NULL DEFAULT '0',
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `activitate`
--

CREATE TABLE `activitate` (
  `Id` int(11) NOT NULL,
  `IdElev` int(11) NOT NULL,
  `IdMaterie` int(11) NOT NULL,
  `Plusuri` int(11) NOT NULL,
  `Minusuri` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `citate`
--

CREATE TABLE `citate` (
  `Id` int(11) NOT NULL,
  `Text` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Autor` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `IdUser` int(11) DEFAULT NULL,
  `Comentariu` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `Status` enum('propus','acceptat','respins') COLLATE utf8_romanian_ci NOT NULL,
  `Ziua` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_romanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clase`
--

CREATE TABLE `clase` (
  `Id` int(11) NOT NULL,
  `Nivel` int(11) NOT NULL,
  `Sufix` text NOT NULL,
  `IdDiriginte` int(11) NOT NULL,
  `AnScolar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `game1_scores`
--

CREATE TABLE `game1_scores` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) DEFAULT NULL,
  `Score` int(11) NOT NULL,
  `Timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `Id` int(11) NOT NULL,
  `Type` text NOT NULL,
  `Username` int(11) NOT NULL,
  `Text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `materii`
--

CREATE TABLE `materii` (
  `Id` int(11) NOT NULL,
  `Nume` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `Id` int(11) NOT NULL,
  `IdElev` int(11) NOT NULL,
  `IdMaterie` int(11) NOT NULL,
  `IdClasa` int(11) NOT NULL COMMENT 'Necesar pentru ca "PrevClase" sa mearga',
  `IdProfesor` int(11) DEFAULT NULL,
  `Semestru` enum('1','2') NOT NULL,
  `Nota` int(11) NOT NULL,
  `Ziua` int(11) NOT NULL,
  `Luna` int(11) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `noutati`
--

CREATE TABLE `noutati` (
  `Id` int(11) NOT NULL,
  `Titlu` text COLLATE utf8_bin NOT NULL,
  `Continut` text COLLATE utf8_bin NOT NULL COMMENT 'Accepta HTML!',
  `Autor` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `predari`
--

CREATE TABLE `predari` (
  `Id` int(11) NOT NULL,
  `IdProfesor` int(11) NOT NULL,
  `IdMaterie` int(11) NOT NULL,
  `IdClasa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `utilizatori`
--

CREATE TABLE `utilizatori` (
  `Id` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Parola` varchar(255) NOT NULL,
  `Email` text NOT NULL,
  `CodInregistrare` text,
  `Autoritate` text NOT NULL,
  `Functie` text NOT NULL,
  `NrMatricol` text,
  `IdClasa` int(11) DEFAULT NULL,
  `PrevClase` text,
  `Nume` text NOT NULL,
  `Prenume` text NOT NULL,
  `Creat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Activat` datetime DEFAULT NULL,
  `UltimaLogare` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absente`
--
ALTER TABLE `absente`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Unique` (`IdElev`,`IdMaterie`,`Ziua`,`Luna`),
  ADD KEY `IdElev` (`IdElev`),
  ADD KEY `IdMaterie` (`IdMaterie`),
  ADD KEY `IdClasa` (`IdClasa`);

--
-- Indexes for table `activitate`
--
ALTER TABLE `activitate`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdElev` (`IdElev`),
  ADD KEY `IdMaterie` (`IdMaterie`);

--
-- Indexes for table `citate`
--
ALTER TABLE `citate`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdUser` (`IdUser`);

--
-- Indexes for table `clase`
--
ALTER TABLE `clase`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdDiriginte` (`IdDiriginte`);

--
-- Indexes for table `game1_scores`
--
ALTER TABLE `game1_scores`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `materii`
--
ALTER TABLE `materii`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Unique` (`Luna`,`IdElev`,`IdMaterie`,`IdClasa`,`Semestru`,`Ziua`) USING BTREE,
  ADD KEY `IdElev` (`IdElev`),
  ADD KEY `IdMaterie` (`IdMaterie`),
  ADD KEY `IdClasa` (`IdClasa`),
  ADD KEY `IdProfesor` (`IdProfesor`);

--
-- Indexes for table `noutati`
--
ALTER TABLE `noutati`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `predari`
--
ALTER TABLE `predari`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Predari_UNIQUE` (`IdClasa`,`IdProfesor`,`IdMaterie`),
  ADD KEY `Predari_IDProfesor` (`IdProfesor`),
  ADD KEY `Predari_IDMaterie` (`IdMaterie`),
  ADD KEY `IdClasa` (`IdClasa`);

--
-- Indexes for table `utilizatori`
--
ALTER TABLE `utilizatori`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `username` (`Username`),
  ADD KEY `IdClasa` (`IdClasa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absente`
--
ALTER TABLE `absente`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `citate`
--
ALTER TABLE `citate`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `clase`
--
ALTER TABLE `clase`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `game1_scores`
--
ALTER TABLE `game1_scores`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `materii`
--
ALTER TABLE `materii`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `noutati`
--
ALTER TABLE `noutati`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `predari`
--
ALTER TABLE `predari`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `utilizatori`
--
ALTER TABLE `utilizatori`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `absente`
--
ALTER TABLE `absente`
  ADD CONSTRAINT `Absente_IDClasa` FOREIGN KEY (`IdClasa`) REFERENCES `clase` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Absente_IDElev` FOREIGN KEY (`IdElev`) REFERENCES `utilizatori` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Absente_IDMaterie` FOREIGN KEY (`IdMaterie`) REFERENCES `materii` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `activitate`
--
ALTER TABLE `activitate`
  ADD CONSTRAINT `Activitate_IDElev` FOREIGN KEY (`IdElev`) REFERENCES `utilizatori` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Activitate_IDMaterie` FOREIGN KEY (`IdMaterie`) REFERENCES `materii` (`Id`) ON UPDATE CASCADE;

--
-- Constraints for table `citate`
--
ALTER TABLE `citate`
  ADD CONSTRAINT `Citate_IDUser` FOREIGN KEY (`IdUser`) REFERENCES `utilizatori` (`Id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `clase`
--
ALTER TABLE `clase`
  ADD CONSTRAINT `Clase_IDDiriginte` FOREIGN KEY (`IdDiriginte`) REFERENCES `utilizatori` (`Id`) ON UPDATE CASCADE;

--
-- Constraints for table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `Note_IDClasa` FOREIGN KEY (`IdClasa`) REFERENCES `clase` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Note_IDElev` FOREIGN KEY (`IdElev`) REFERENCES `utilizatori` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Note_IDMaterie` FOREIGN KEY (`IdMaterie`) REFERENCES `materii` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Note_IDProfesor` FOREIGN KEY (`IdProfesor`) REFERENCES `utilizatori` (`Id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `predari`
--
ALTER TABLE `predari`
  ADD CONSTRAINT `Predari_IDClasa` FOREIGN KEY (`IdClasa`) REFERENCES `clase` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Predari_IDMaterie` FOREIGN KEY (`IdMaterie`) REFERENCES `materii` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Predari_IDProfesor` FOREIGN KEY (`IdProfesor`) REFERENCES `utilizatori` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `utilizatori`
--
ALTER TABLE `utilizatori`
  ADD CONSTRAINT `Utilizatori_IDClasa` FOREIGN KEY (`IdClasa`) REFERENCES `clase` (`Id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
