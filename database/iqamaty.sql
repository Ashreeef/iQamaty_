-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 28 nov. 2024 à 17:45
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `iqamaty`
--

-- --------------------------------------------------------

-- Create `user` table
CREATE TABLE `user` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `Email` text NOT NULL,
  `Password` text NOT NULL,
  `PhoneNumber` int(10) NOT NULL,
  `Role` enum('super_admin','staff','student') NOT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `uq_usr_email` (`Email`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create `student` table
CREATE TABLE `student` (
  `StudentID` BIGINT NOT NULL,
  `UserID` int(11) NOT NULL,
  `School` text NOT NULL,
  `Room` text NOT NULL,
  `Wilaya` text NOT NULL,
  PRIMARY KEY (`StudentID`),
  KEY `fk_student` (`UserID`),
  CONSTRAINT `fk_student` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create `admin` table
CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`AdminID`),
  KEY `fk_admin` (`UserID`),
  CONSTRAINT `fk_admin` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create `staff` table
CREATE TABLE `staff` (
  `StaffID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `Function` text NOT NULL,
  PRIMARY KEY (`StaffID`),
  KEY `fk_staff` (`UserID`),
  CONSTRAINT `fk_staff` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create `event` table
CREATE TABLE `event` (
  `EventID` int(11) NOT NULL AUTO_INCREMENT,
  `EventName` text NOT NULL,
  `EventDate` date NOT NULL,
  `EventLocation` int(11) NOT NULL,
  `EventDetails` int(11) NOT NULL,
  `EventPicture` text NOT NULL,
  `isRegister` tinyint(1) NOT NULL,
  PRIMARY KEY (`EventID`),
  KEY `fk_eventname` (`EventName`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create `eventuser` table
CREATE TABLE `eventuser` (
  `UserID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  PRIMARY KEY (`UserID`, `EventID`),
  KEY `fk_eventusr` (`EventID`),
  CONSTRAINT `fk_eventusr` FOREIGN KEY (`EventID`) REFERENCES `event` (`EventID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_evtuser` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Create `booking` table
CREATE TABLE `booking` (
  `BookingID` int(11) NOT NULL AUTO_INCREMENT,
  `StudentID` BIGINT NOT NULL,
  `TimeSlot` time NOT NULL,
  `Date` date NOT NULL,
  PRIMARY KEY (`BookingID`),
  KEY `fk_booking` (`StudentID`),
  CONSTRAINT `fk_booking` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create `booking_student` table (composite key)
CREATE TABLE `booking_student` (
  `BookingID` int(11) NOT NULL,
  `StudentID` BIGINT NOT NULL,
  PRIMARY KEY (`BookingID`, `StudentID`),
  KEY `fk_bkstudent` (`StudentID`),
  CONSTRAINT `fk_bookingstd` FOREIGN KEY (`BookingID`) REFERENCES `booking` (`BookingID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_bkstudent` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create `dishes` table
CREATE TABLE `dishes` (
  `DishID` int(11) NOT NULL AUTO_INCREMENT,
  `DName` text NOT NULL,
  PRIMARY KEY (`DishID`),
  KEY `fk_dishname` (`DName`(255))  -- Specify length for DName
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create `meal_report` table (composite key)
CREATE TABLE `meal_report` (
  `ReportID` int(11) NOT NULL,
  `DishID` int(11) NOT NULL,
  `StudentID` BIGINT NOT NULL,
  `MRDescription` int(11) NOT NULL,
  `Attachment` text DEFAULT NULL,
  `MRDate` date NOT NULL,
  `MRTime` time NOT NULL,
  PRIMARY KEY (`ReportID`, `DishID`, `StudentID`),
  KEY `fk_dishrs` (`DishID`),
  KEY `fk_drstudent` (`StudentID`),
  CONSTRAINT `fk_dishrs` FOREIGN KEY (`DishID`) REFERENCES `dishes` (`DishID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_drstudent` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create `menu` table
CREATE TABLE `menu` (
  `MenuID` int(11) NOT NULL AUTO_INCREMENT,
  `DishID` int(11) NOT NULL,
  `MType` text NOT NULL,
  PRIMARY KEY (`MenuID`),
  KEY `fk_meal` (`DishID`),
  CONSTRAINT `fk_meal` FOREIGN KEY (`DishID`) REFERENCES `dishes` (`DishID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create `special` table
CREATE TABLE `special` (
  `SpecialID` int(11) NOT NULL AUTO_INCREMENT,
  `MenuID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `SDate` date NOT NULL,
  PRIMARY KEY (`SpecialID`),
  KEY `fk_eventmu` (`EventID`),
  KEY `fk_etmenu` (`MenuID`),
  CONSTRAINT `fk_eventmu` FOREIGN KEY (`EventID`) REFERENCES `event` (`EventID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_etmenu` FOREIGN KEY (`MenuID`) REFERENCES `menu` (`MenuID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create `sport` table
CREATE TABLE `sport` (
  `SportID` int(11) NOT NULL AUTO_INCREMENT,
  `SName` text NOT NULL,
  `SDescription` text NOT NULL,
  `isRegister` tinyint(1) NOT NULL,
  PRIMARY KEY (`SportID`),
  KEY `fk_sportname` (`SName`(255)),
  KEY `fk_sportdesc` (`SDescription`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create `sport_team` table
CREATE TABLE `sport_team` (
  `TeamID` int(11) NOT NULL AUTO_INCREMENT,
  `SportID` int(11) NOT NULL,
  `TName` text NOT NULL,
  PRIMARY KEY (`TeamID`),
  KEY `fk_sportteam` (`SportID`),
  KEY `fk_teamname` (`TName`(255)),  -- Specify length for TName
  CONSTRAINT `fk_sportteam` FOREIGN KEY (`SportID`) REFERENCES `sport` (`SportID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create `team_members` table (composite key)
CREATE TABLE `team_members` (
  `TeamID` int(11) NOT NULL,
  `StudentID` BIGINT NOT NULL,
  `TMDate` date NOT NULL,
  PRIMARY KEY (`TeamID`, `StudentID`),
  KEY `fk_tmstudent` (`StudentID`),
  CONSTRAINT `fk_tmstudent` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `training_sessions` (
  `TeamID` int(11) NOT NULL,
  `SportID` int(11) NOT NULL,
  `TSDate` date NOT NULL,
  `TSTime` time NOT NULL,
  `CoachName` text DEFAULT NULL,
  PRIMARY KEY (`TeamID`, `SportID`),
  KEY `fk_sporttm` (`SportID`),
  CONSTRAINT `fk_sporttm` FOREIGN KEY (`SportID`) REFERENCES `sport` (`SportID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create `special_report` table
CREATE TABLE `special_report` (
  `ReportID` int(11) NOT NULL AUTO_INCREMENT,
  `SpecialID` int(11) NOT NULL,
  `ReportDetails` text NOT NULL,
  PRIMARY KEY (`ReportID`),
  KEY `fk_sreport` (`SpecialID`),
  CONSTRAINT `fk_sreport` FOREIGN KEY (`SpecialID`) REFERENCES `special` (`SpecialID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Creating the 'lost_found' table
CREATE TABLE lost_found (
    LFID INT PRIMARY KEY,
    LFName VARCHAR(100),
    LFDescription TEXT,
    LFDate DATE,
    LFLocation VARCHAR(100),
    LFStatus VARCHAR(50)
);



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
