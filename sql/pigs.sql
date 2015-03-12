-- Drop existing tables
drop table Venue;
drop table Event_atVenue;
drop table SeatingSection_inVenue;
drop table Seat_inSection;
drop table Ticket_ownsSeat;
drop table Customer;
drop table Organizer;
drop table Organizes;
drop table ForAdmissionTo;

-- Create tables with their constraints
CREATE TABLE Venue (venueID INT , name VARCHAR(255), address VARCHAR(255), cityName VARCHAR(255), provName VARCHAR(255), PRIMARY KEY (venueID), UNIQUE (address, cityName, provName));
CREATE TABLE Event_atVenue (venueID INT, eventID INT, basePrice INT, saleOpenDate TIMESTAMP, ticketStatus VARCHAR(255), startTime TIMESTAMP, endTime TIMESTAMP, PRIMARY KEY(eventID), UNIQUE (startTime, endTime, venueID));
ALTER TABLE Event_atVenue ADD FOREIGN KEY (venueID) REFERENCES Venue (venueID) ON DELETE SET NULL ON UPDATE RESTRICT;
CREATE TABLE SeatingSection_inVenue (venueID INT, sectionID INT NOT NULL , additionalPrice INT, seatsAvailable INT NOT NULL, sectionSectionType INT NOT NULL, PRIMARY KEY (sectionID, venueID), FOREIGN KEY(venueID) REFERENCES Venue ON UPDATE ON DELETE CASCADE RESTRICT);
CREATE TABLE Seat_inSection (sectionID INT, venueID INT, seat_row INT, seatNo INT, PRIMARY KEY (sectionID, venueID, seat_row, seatNo), FOREIGN KEY (sectionID, venueID) REFERENCES SeatingSection_inVenue(sectionID, venueID) ON UPDATE RESTRICT ON DELETE CASCADE);
CREATE TABLE Ticket_ownsSeat (ticketID INT, isAvailable BOOL, sectionID INT, venueID INT, seat_row INT, seatNo INT, PRIMARY KEY (ticketID), FOREIGN KEY (sectionID, venueID) REFERENCES SeatingSection_inVenue(sectionID, venueID) ON UPDATE RESTRICT ON DELETE CASCADE, FOREIGN KEY (sectionID, venueID, seat_row, seatNo) REFERENCES Seat_inSection(sectionID, venueID, seat_row, seatNo)ON UPDATE RESTRICT ON DELETE CASCADE);
CREATE TABLE Customer (userID INT, firstName VARCHAR(255), lastName VARCHAR(255), email VARCHAR(255), username VARCHAR(255), password VARCHAR(255), PRIMARY KEY(userID), UNIQUE(email), UNIQUE(username));
CREATE TABLE Organizer (organizerID INT, firstName VARCHAR(255) NOT NULL, lastName VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255), password VARCHAR(255), PRIMARY KEY(organizerID), UNIQUE(username), UNIQUE(email));
CREATE TABLE Organizes (organizerID INT, eventID INT, PRIMARY KEY(organizerID, eventID), FOREIGN KEY(organizerID) REFERENCES Organizer(organizerID) ON UPDATE RESTRICT ON DELETE RESTRICT, FOREIGN KEY(eventID) REFERENCES Event_atVenue(eventID) ON UPDATE RESTRICT) ON DELETE RESTRICT);
CREATE TABLE ForAdmissionTo(eventID INT, ticketID INT, PRIMARY KEY(eventID, ticketID), FOREIGN KEY(eventID) REFERENCES Event_atVenue(eventID) ON UPDATE RESTRICT ON DELETE RESTRICT, FOREIGN KEY(ticketID) REFERENCES Ticket_ownsSeat(ticketID) ON UPDATE CASCADE) ON DELETE CASCADE);

-- Add mock data
COMMIT;
SET TRANSACTION NAME 'mock_data';

INSERT INTO `customer` (`userID`, `firstName`, `lastName`, `email`, `username`, `password`) VALUES
(1, 'Alice', 'Marshall', 'alice@gmail.com', 'alice', 'pswrd'),
(2, 'Kendra', 'Thatcher', 'kendra@gmail.com', 'kendra', 'hello'),
(3, 'Joseph', 'Smith', 'joseph@gmail.coom', 'joseph', 'wow'),
(4, 'Callie', 'McConnell', 'callie@gmail.com', 'callie', 'suchwow'),
(5, 'Jarett', 'Mitchell', 'jarett@gmail.com', 'jarett', 'muchfun');


INSERT INTO `event_atvenue` (`venueID`, `eventID`, `basePrice`, `saleOpenDate`, `ticketStatus`, `startTime`, `endTime`) VALUES
(3, 1, 50, '2014-01-14 11:11:11', 'Open', '2014-04-14 11:11:11', '2014-01-14 23:11:11'),
(3, 2, 50, '2014-03-24 04:13:21', 'Closed', '2014-03-24 04:14:21', '2014-03-24 20:13:21'),
(3, 3, 50, '2016-03-24 04:01:01', 'Closed', '2016-03-24 14:01:01', '2016-03-24 23:01:01'),
(4, 4, 50, '2025-04-01 06:34:13', 'Closed', '2025-04-01 16:34:13', '2025-04-01 23:34:13'),
(5, 5, 50, '2016-03-24 04:01:01', 'Closed', '2016-03-24 07:01:01', '2016-03-24 23:01:01');


INSERT INTO `foradmissionto` (`eventID`, `ticketID`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5);


INSERT INTO `organizer` (`organizerID`, `firstName`, `lastName`, `email`, `username`, `password`) VALUES
(1, 'Bob', 'Dillion', 'bob@gmail.com', 'bob123', 'woot'),
(2, 'Joe', 'West', 'joe@gmail.com', 'joe123', 'password'),
(3, 'Henry', 'Kane', 'henry@gmail.com', 'henry123', 'pass!'),
(4, 'Alesha', 'Sedin', 'alesha@gmail.com', 'alesha123', '123456'),
(5, 'Kanye', 'Woot', 'kanye@gmail.com', 'kanye123', 'yay');


INSERT INTO `organizes` (`organizerID`, `eventID`) VALUES
(5, 1),
(4, 2),
(3, 3),
(2, 4),
(1, 5);


INSERT INTO `seatingsection_invenue` (`venueID`, `sectionID`, `additionalPrice`, `seatsAvailable`, `sectionSectionType`) VALUES
(1, 1, 100, 50, 1),
(2, 1, 100, 50, 1),
(1, 2, 200, 50, 2),
(2, 2, 200, 50, 2),
(1, 3, 300, 50, 3);


INSERT INTO `seat_insection` (`sectionID`, `venueID`, `row`, `seatNo`) VALUES
(1, 1, 20, 5),
(2, 1, 20, 5),
(2, 1, 20, 6),
(2, 1, 20, 7),
(3, 1, 20, 5);


INSERT INTO `ticket_ownsseat` (`ticketID`, `isAvailable`, `sectionID`, `venueID`, `row`, `seatNo`) VALUES
(1, 1, 1, 1, 20, 5),
(2, 1, 2, 1, 20, 5),
(3, 1, 2, 1, 20, 6),
(4, 1, 2, 1, 20, 7),
(5, 1, 3, 1, 20, 5);


INSERT INTO `venue` (`venueID`, `name`, `address`, `cityName`, `provName`) VALUES
(1, 'General Motors Place', '123 Fake Road', 'Vancouver', 'BC'),
(2, 'Rogers Arena', '321 Cool Street', 'Vancouver', 'BC'),
(3, 'Saddledome', '456 Awesome Court', 'Calgary', 'AB'),
(4, 'BC Place', '789 Sweet Road', 'Vancouver', 'BC'),
(5, 'Maple Leaf Garden Center', '905 Chill Place', 'Toronto', 'ON');

COMMIT;

-- --
-- -- Constraints for dumped tables
-- --
--
-- --
-- -- Constraints for table `event_atvenue`
-- --
-- ALTER TABLE `event_atvenue`
-- ADD CONSTRAINT `event_atvenue_ibfk_1` FOREIGN KEY (`venueID`) REFERENCES `venue` (`venueID`) ON DELETE SET NULL ON UPDATE NO ACTION;
--
-- --
-- -- Constraints for table `foradmissionto`
-- --
-- ALTER TABLE `foradmissionto`
-- ADD CONSTRAINT `foradmissionto_ibfk_1` FOREIGN KEY (`eventID`) REFERENCES `event_atvenue` (`eventID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
-- ADD CONSTRAINT `foradmissionto_ibfk_2` FOREIGN KEY (`ticketID`) REFERENCES `ticket_ownsseat` (`ticketID`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- --
-- -- Constraints for table `organizes`
-- --
-- ALTER TABLE `organizes`
-- ADD CONSTRAINT `organizes_ibfk_1` FOREIGN KEY (`organizerID`) REFERENCES `organizer` (`organizerID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
-- ADD CONSTRAINT `organizes_ibfk_2` FOREIGN KEY (`eventID`) REFERENCES `event_atvenue` (`eventID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
--
-- --
-- -- Constraints for table `seatingsection_invenue`
-- --
-- ALTER TABLE `seatingsection_invenue`
-- ADD CONSTRAINT `seatingsection_invenue_ibfk_1` FOREIGN KEY (`venueID`) REFERENCES `venue` (`venueID`) ON DELETE CASCADE ON UPDATE NO ACTION;
--
-- --
-- -- Constraints for table `seat_insection`
-- --
-- ALTER TABLE `seat_insection`
-- ADD CONSTRAINT `seat_insection_ibfk_1` FOREIGN KEY (`sectionID`, `venueID`) REFERENCES `seatingsection_invenue` (`sectionID`, `venueID`) ON DELETE CASCADE ON UPDATE NO ACTION;
--
-- --
-- -- Constraints for table `ticket_ownsseat`
-- --
-- ALTER TABLE `ticket_ownsseat`
-- ADD CONSTRAINT `ticket_ownsseat_ibfk_1` FOREIGN KEY (`sectionID`, `venueID`) REFERENCES `seatingsection_invenue` (`sectionID`, `venueID`) ON DELETE CASCADE ON UPDATE NO ACTION,
-- ADD CONSTRAINT `ticket_ownsseat_ibfk_2` FOREIGN KEY (`sectionID`, `venueID`, `row`, `seatNo`) REFERENCES `seat_insection` (`sectionID`, `venueID`, `row`, `seatNo`) ON DELETE CASCADE ON UPDATE NO ACTION;
