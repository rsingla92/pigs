-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Host: .:8889
-- Generation Time: Mar 07, 2015 at 11:52 AM
-- Server version: 5.5.41-log
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pigs`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `userID` int(11) NOT NULL DEFAULT '0',
  `firstName` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `lastName` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`userID`, `firstName`, `lastName`, `email`, `username`, `password`) VALUES
(1, 'Alice', 'Marshall', 'alice@gmail.com', 'alice', 'pswrd'),
(2, 'Kendra', 'Thatcher', 'kendra@gmail.com', 'kendra', 'hello'),
(3, 'Joseph', 'Smith', 'joseph@gmail.coom', 'joseph', 'wow'),
(4, 'Callie', 'McConnell', 'callie@gmail.com', 'callie', 'suchwow'),
(5, 'Jarett', 'Mitchell', 'jarett@gmail.com', 'jarett', 'muchfun');

-- --------------------------------------------------------

--
-- Table structure for table `event_atvenue`
--

CREATE TABLE IF NOT EXISTS `event_atvenue` (
  `venueID` int(11) DEFAULT NULL,
`eventID` int(11) NOT NULL,
  `basePrice` int(11) DEFAULT NULL,
  `saleOpenDate` datetime DEFAULT NULL,
  `ticketStatus` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `startTime` datetime DEFAULT NULL,
  `endTime` datetime DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `event_atvenue`
--

INSERT INTO `event_atvenue` (`venueID`, `eventID`, `basePrice`, `saleOpenDate`, `ticketStatus`, `startTime`, `endTime`) VALUES
(3, 1, 50, '2014-01-14 11:11:11', 'Open', '2014-04-14 11:11:11', '2014-01-14 23:11:11'),
(3, 2, 50, '2014-03-24 04:13:21', 'Closed', '2014-03-24 04:14:21', '2014-03-24 20:13:21'),
(3, 3, 50, '2016-03-24 04:01:01', 'Closed', '2016-03-24 14:01:01', '2016-03-24 23:01:01'),
(4, 4, 50, '2025-04-01 06:34:13', 'Closed', '2025-04-01 16:34:13', '2025-04-01 23:34:13'),
(5, 5, 50, '2016-03-24 04:01:01', 'Closed', '2016-03-24 07:01:01', '2016-03-24 23:01:01');

-- --------------------------------------------------------

--
-- Table structure for table `foradmissionto`
--

CREATE TABLE IF NOT EXISTS `foradmissionto` (
  `eventID` int(11) NOT NULL DEFAULT '0',
  `ticketID` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `foradmissionto`
--

INSERT INTO `foradmissionto` (`eventID`, `ticketID`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `organizer`
--

CREATE TABLE IF NOT EXISTS `organizer` (
`organizerID` int(11) NOT NULL,
  `firstName` varchar(255) COLLATE utf8_general_mysql500_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8_general_mysql500_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_general_mysql500_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `organizer`
--

INSERT INTO `organizer` (`organizerID`, `firstName`, `lastName`, `email`, `username`, `password`) VALUES
(1, 'Bob', 'Dillion', 'bob@gmail.com', 'bob123', 'woot'),
(2, 'Joe', 'West', 'joe@gmail.com', 'joe123', 'password'),
(3, 'Henry', 'Kane', 'henry@gmail.com', 'henry123', 'pass!'),
(4, 'Alesha', 'Sedin', 'alesha@gmail.com', 'alesha123', '123456'),
(5, 'Kanye', 'Woot', 'kanye@gmail.com', 'kanye123', 'yay');

-- --------------------------------------------------------

--
-- Table structure for table `organizes`
--

CREATE TABLE IF NOT EXISTS `organizes` (
  `organizerID` int(11) NOT NULL DEFAULT '0',
  `eventID` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `organizes`
--

INSERT INTO `organizes` (`organizerID`, `eventID`) VALUES
(5, 1),
(4, 2),
(3, 3),
(2, 4),
(1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `seatingsection_invenue`
--

CREATE TABLE IF NOT EXISTS `seatingsection_invenue` (
  `venueID` int(11) NOT NULL DEFAULT '0',
`sectionID` int(11) NOT NULL,
  `additionalPrice` int(11) DEFAULT NULL,
  `seatsAvailable` int(11) NOT NULL,
  `sectionSectionType` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `seatingsection_invenue`
--

INSERT INTO `seatingsection_invenue` (`venueID`, `sectionID`, `additionalPrice`, `seatsAvailable`, `sectionSectionType`) VALUES
(1, 1, 100, 50, 1),
(2, 1, 100, 50, 1),
(1, 2, 200, 50, 2),
(2, 2, 200, 50, 2),
(1, 3, 300, 50, 3);

-- --------------------------------------------------------

--
-- Table structure for table `seat_insection`
--

CREATE TABLE IF NOT EXISTS `seat_insection` (
  `sectionID` int(11) NOT NULL DEFAULT '0',
  `venueID` int(11) NOT NULL DEFAULT '0',
  `row` int(11) NOT NULL DEFAULT '0',
  `seatNo` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `seat_insection`
--

INSERT INTO `seat_insection` (`sectionID`, `venueID`, `row`, `seatNo`) VALUES
(1, 1, 20, 5),
(2, 1, 20, 5),
(2, 1, 20, 6),
(2, 1, 20, 7),
(3, 1, 20, 5);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_ownsseat`
--

CREATE TABLE IF NOT EXISTS `ticket_ownsseat` (
`ticketID` int(11) NOT NULL,
  `isAvailable` tinyint(1) DEFAULT NULL,
  `sectionID` int(11) DEFAULT NULL,
  `venueID` int(11) DEFAULT NULL,
  `row` int(11) DEFAULT NULL,
  `seatNo` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ticket_ownsseat`
--

INSERT INTO `ticket_ownsseat` (`ticketID`, `isAvailable`, `sectionID`, `venueID`, `row`, `seatNo`) VALUES
(1, 1, 1, 1, 20, 5),
(2, 1, 2, 1, 20, 5),
(3, 1, 2, 1, 20, 6),
(4, 1, 2, 1, 20, 7),
(5, 1, 3, 1, 20, 5);

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

CREATE TABLE IF NOT EXISTS `venue` (
`venueID` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `cityName` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `provName` varchar(255) COLLATE utf8_general_mysql500_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `venue`
--

INSERT INTO `venue` (`venueID`, `name`, `address`, `cityName`, `provName`) VALUES
(1, 'General Motors Place', '123 Fake Road', 'Vancouver', 'BC'),
(2, 'Rogers Arena', '321 Cool Street', 'Vancouver', 'BC'),
(3, 'Saddledome', '456 Awesome Court', 'Calgary', 'AB'),
(4, 'BC Place', '789 Sweet Road', 'Vancouver', 'BC'),
(5, 'Maple Leaf Garden Center', '905 Chill Place', 'Toronto', 'ON');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
 ADD PRIMARY KEY (`userID`), ADD UNIQUE KEY `email` (`email`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `event_atvenue`
--
ALTER TABLE `event_atvenue`
 ADD PRIMARY KEY (`eventID`), ADD UNIQUE KEY `startTime` (`startTime`,`endTime`,`venueID`), ADD KEY `venueID` (`venueID`);

--
-- Indexes for table `foradmissionto`
--
ALTER TABLE `foradmissionto`
 ADD PRIMARY KEY (`eventID`,`ticketID`), ADD KEY `ticketID` (`ticketID`);

--
-- Indexes for table `organizer`
--
ALTER TABLE `organizer`
 ADD PRIMARY KEY (`organizerID`), ADD UNIQUE KEY `email` (`email`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `organizes`
--
ALTER TABLE `organizes`
 ADD PRIMARY KEY (`organizerID`,`eventID`), ADD KEY `eventID` (`eventID`);

--
-- Indexes for table `seatingsection_invenue`
--
ALTER TABLE `seatingsection_invenue`
 ADD PRIMARY KEY (`sectionID`,`venueID`), ADD KEY `venueID` (`venueID`);

--
-- Indexes for table `seat_insection`
--
ALTER TABLE `seat_insection`
 ADD PRIMARY KEY (`sectionID`,`venueID`,`row`,`seatNo`);

--
-- Indexes for table `ticket_ownsseat`
--
ALTER TABLE `ticket_ownsseat`
 ADD PRIMARY KEY (`ticketID`), ADD KEY `sectionID` (`sectionID`,`venueID`,`row`,`seatNo`);

--
-- Indexes for table `venue`
--
ALTER TABLE `venue`
 ADD PRIMARY KEY (`venueID`), ADD UNIQUE KEY `address` (`address`,`cityName`,`provName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event_atvenue`
--
ALTER TABLE `event_atvenue`
MODIFY `eventID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `organizer`
--
ALTER TABLE `organizer`
MODIFY `organizerID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `seatingsection_invenue`
--
ALTER TABLE `seatingsection_invenue`
MODIFY `sectionID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ticket_ownsseat`
--
ALTER TABLE `ticket_ownsseat`
MODIFY `ticketID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `venue`
--
ALTER TABLE `venue`
MODIFY `venueID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_atvenue`
--
ALTER TABLE `event_atvenue`
ADD CONSTRAINT `event_atvenue_ibfk_1` FOREIGN KEY (`venueID`) REFERENCES `venue` (`venueID`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `foradmissionto`
--
ALTER TABLE `foradmissionto`
ADD CONSTRAINT `foradmissionto_ibfk_1` FOREIGN KEY (`eventID`) REFERENCES `event_atvenue` (`eventID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `foradmissionto_ibfk_2` FOREIGN KEY (`ticketID`) REFERENCES `ticket_ownsseat` (`ticketID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `organizes`
--
ALTER TABLE `organizes`
ADD CONSTRAINT `organizes_ibfk_1` FOREIGN KEY (`organizerID`) REFERENCES `organizer` (`organizerID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `organizes_ibfk_2` FOREIGN KEY (`eventID`) REFERENCES `event_atvenue` (`eventID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `seatingsection_invenue`
--
ALTER TABLE `seatingsection_invenue`
ADD CONSTRAINT `seatingsection_invenue_ibfk_1` FOREIGN KEY (`venueID`) REFERENCES `venue` (`venueID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `seat_insection`
--
ALTER TABLE `seat_insection`
ADD CONSTRAINT `seat_insection_ibfk_1` FOREIGN KEY (`sectionID`, `venueID`) REFERENCES `seatingsection_invenue` (`sectionID`, `venueID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ticket_ownsseat`
--
ALTER TABLE `ticket_ownsseat`
ADD CONSTRAINT `ticket_ownsseat_ibfk_1` FOREIGN KEY (`sectionID`, `venueID`) REFERENCES `seatingsection_invenue` (`sectionID`, `venueID`) ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT `ticket_ownsseat_ibfk_2` FOREIGN KEY (`sectionID`, `venueID`, `row`, `seatNo`) REFERENCES `seat_insection` (`sectionID`, `venueID`, `row`, `seatNo`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
