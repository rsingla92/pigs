SET SQLBLANKLINES ON

-- Drop existing tables
drop table Venue CASCADE CONSTRAINTS;
drop table Event_atVenue CASCADE CONSTRAINTS;
drop table SeatingSection_inVenue CASCADE CONSTRAINTS;
drop table Seat_inSection CASCADE CONSTRAINTS;
drop table Ticket_ownsSeat CASCADE CONSTRAINTS;
drop table Customer CASCADE CONSTRAINTS;
drop table Organizer CASCADE CONSTRAINTS;
drop table Organizes CASCADE CONSTRAINTS;
drop table ForAdmissionTo CASCADE CONSTRAINTS;

-- Create tables with their constraints
CREATE TABLE Venue (venueID INT , name VARCHAR(255), address VARCHAR(255), cityName VARCHAR(255), provName VARCHAR(255), PRIMARY KEY (venueID), UNIQUE (address, cityName, provName));
CREATE TABLE Event_atVenue (venueID INT, eventID INT, basePrice INT, saleOpenDate TIMESTAMP, ticketStatus VARCHAR(255), startTime TIMESTAMP, endTime TIMESTAMP, PRIMARY KEY(eventID), UNIQUE (startTime, endTime, venueID));
--ALTER TABLE Event_atVenue ADD CONSTRAINT fkv FOREIGN KEY (venueID) REFERENCES Venue (venueID) ON DELETE SET NULL;
CREATE TABLE SeatingSection_inVenue (venueID INT, sectionID INT NOT NULL , additionalPrice INT, seatsAvailable INT NOT NULL, sectionSectionType INT NOT NULL, PRIMARY KEY (sectionID, venueID));
CREATE TABLE Seat_inSection (sectionID INT, venueID INT, seat_row INT, seatNo INT, PRIMARY KEY (sectionID, venueID, seat_row, seatNo));
CREATE TABLE Ticket_ownsSeat (ticketID INT, isAvailable CHAR, sectionID INT, venueID INT, seat_row INT, seatNo INT, PRIMARY KEY (ticketID));
CREATE TABLE Customer (userID INT, firstName VARCHAR(255), lastName VARCHAR(255), email VARCHAR(255), username VARCHAR(255), password VARCHAR(255), PRIMARY KEY(userID), UNIQUE(email), UNIQUE(username));
CREATE TABLE Organizer (organizerID INT, firstName VARCHAR(255) NOT NULL, lastName VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255), password VARCHAR(255), PRIMARY KEY(organizerID), UNIQUE(username), UNIQUE(email));
CREATE TABLE Organizes (organizerID INT, eventID INT, PRIMARY KEY(organizerID, eventID));
CREATE TABLE ForAdmissionTo(eventID INT, ticketID INT, PRIMARY KEY(eventID, ticketID));

-- Add mock data
COMMIT;
SET TRANSACTION NAME 'mock_data';

INSERT INTO venue (venueID, name, address, cityName, provName) VALUES -
(1, 'General Motors Place', '123 Fake Road', 'Vancouver', 'BC');
INSERT INTO venue (venueID, name, address, cityName, provName) VALUES -
(2, 'Rogers Arena', '321 Cool Street', 'Vancouver', 'BC');
INSERT INTO venue (venueID, name, address, cityName, provName) VALUES -
(3, 'Saddledome', '456 Awesome Court', 'Calgary', 'AB');
INSERT INTO venue (venueID, name, address, cityName, provName) VALUES -
(4, 'BC Place', '789 Sweet Road', 'Vancouver', 'BC');
INSERT INTO venue (venueID, name, address, cityName, provName) VALUES -
(5, 'Maple Leaf Garden Center', '905 Chill Place', 'Toronto', 'ON');

INSERT INTO customer (userID, firstName, lastName, email, username, password) VALUES -
(1, 'Alice', 'Marshall', 'alice@gmail.com', 'alice', 'pswrd');
INSERT INTO customer (userID, firstName, lastName, email, username, password) VALUES -
(2, 'Kendra', 'Thatcher', 'kendra@gmail.com', 'kendra', 'hello');
INSERT INTO customer (userID, firstName, lastName, email, username, password) VALUES -
(3, 'Joseph', 'Smith', 'joseph@gmail.coom', 'joseph', 'wow');
INSERT INTO customer (userID, firstName, lastName, email, username, password) VALUES -
(4, 'Callie', 'McConnell', 'callie@gmail.com', 'callie', 'suchwow');
INSERT INTO customer (userID, firstName, lastName, email, username, password) VALUES -
(5, 'Jarett', 'Mitchell', 'jarett@gmail.com', 'jarett', 'muchfun');


INSERT INTO event_atvenue (venueID, eventID, basePrice, saleOpenDate, ticketStatus, startTime, endTime) VALUES -
(3, 1, 50, '2014-01-14 11:11:11', 'Open', '2014-04-14 11:11:11', '2014-01-14 23:11:11');
INSERT INTO event_atvenue (venueID, eventID, basePrice, saleOpenDate, ticketStatus, startTime, endTime) VALUES -
(3, 2, 50, '2014-03-24 04:13:21', 'Closed', '2014-03-24 04:14:21', '2014-03-24 20:13:21');
INSERT INTO event_atvenue (venueID, eventID, basePrice, saleOpenDate, ticketStatus, startTime, endTime) VALUES -
(3, 3, 50, '2016-03-24 04:01:01', 'Closed', '2016-03-24 14:01:01', '2016-03-24 23:01:01');
INSERT INTO event_atvenue (venueID, eventID, basePrice, saleOpenDate, ticketStatus, startTime, endTime) VALUES -
(4, 4, 50, '2025-04-01 06:34:13', 'Closed', '2025-04-01 16:34:13', '2025-04-01 23:34:13');
INSERT INTO event_atvenue (venueID, eventID, basePrice, saleOpenDate, ticketStatus, startTime, endTime) VALUES -
(5, 5, 50, '2016-03-24 04:01:01', 'Closed', '2016-03-24 07:01:01', '2016-03-24 23:01:01');


INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(1, 1);
INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(1, 2);
INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(1, 3);
INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(1, 4);
INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(1, 5);


INSERT INTO organizer (organizerID, firstName, lastName, email, username, password) VALUES -
(1, 'Bob', 'Dillion', 'bob@gmail.com', 'bob123', 'woot');
INSERT INTO organizer (organizerID, firstName, lastName, email, username, password) VALUES -
(2, 'Joe', 'West', 'joe@gmail.com', 'joe123', 'password');
INSERT INTO organizer (organizerID, firstName, lastName, email, username, password) VALUES -
(3, 'Henry', 'Kane', 'henry@gmail.com', 'henry123', 'pass!');
INSERT INTO organizer (organizerID, firstName, lastName, email, username, password) VALUES -
(4, 'Alesha', 'Sedin', 'alesha@gmail.com', 'alesha123', '123456');
INSERT INTO organizer (organizerID, firstName, lastName, email, username, password) VALUES -
(5, 'Kanye', 'Woot', 'kanye@gmail.com', 'kanye123', 'yay');


INSERT INTO organizes (organizerID, eventID) VALUES -
(5, 1);
INSERT INTO organizes (organizerID, eventID) VALUES -
(4, 2);
INSERT INTO organizes (organizerID, eventID) VALUES -
(3, 3);
INSERT INTO organizes (organizerID, eventID) VALUES -
(2, 4);
INSERT INTO organizes (organizerID, eventID) VALUES -
(1, 5);


INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, sectionSectionType) VALUES -
(1, 1, 100, 50, 1);
INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, sectionSectionType) VALUES -
(2, 1, 100, 50, 1);
INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, sectionSectionType) VALUES -
(1, 2, 200, 50, 2);
INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, sectionSectionType) VALUES -
(2, 2, 200, 50, 2);
INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, sectionSectionType) VALUES -
(1, 3, 300, 50, 3);


INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(1, 1, 20, 5);
INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(2, 1, 20, 5);
INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(2, 1, 20, 6);
INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(2, 1, 20, 7);
INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(3, 1, 20, 5);


INSERT INTO ticket_ownsseat (ticketID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES
(1, 1, 1, 1, 20, 5);
INSERT INTO ticket_ownsseat (ticketID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES -
(2, 1, 2, 1, 20, 5);
INSERT INTO ticket_ownsseat (ticketID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES -
(3, 1, 2, 1, 20, 6);
INSERT INTO ticket_ownsseat (ticketID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES -
(4, 1, 2, 1, 20, 7);
INSERT INTO ticket_ownsseat (ticketID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES -
(5, 1, 3, 1, 20, 5);

COMMIT;
END;

--
-- Constraints for dumped tables
--

--
-- Constraints for table event_atvenue
--
ALTER TABLE event_atvenue -
ADD CONSTRAINT event_atvenue_ibfk_1 FOREIGN KEY (venueID) REFERENCES venue (venueID) ON DELETE SET NULL;

--
-- Constraints for table foradmissionto
--
ALTER TABLE foradmissionto -
ADD CONSTRAINT foradmissionto_ibfk_1 FOREIGN KEY (eventID) REFERENCES event_atvenue (eventID);
ALTER TABLE foradmissionto -
ADD CONSTRAINT foradmissionto_ibfk_2 FOREIGN KEY (ticketID) REFERENCES ticket_ownsseat (ticketID) ON DELETE CASCADE;

--
-- Constraints for table organizes
--
ALTER TABLE organizes -
ADD CONSTRAINT organizes_ibfk_1 FOREIGN KEY (organizerID) REFERENCES organizer (organizerID);
ALTER TABLE organizes -
ADD CONSTRAINT organizes_ibfk_2 FOREIGN KEY (eventID) REFERENCES event_atvenue (eventID);

--
-- Constraints for table seatingsection_invenue
--
ALTER TABLE seatingsection_invenue -
ADD CONSTRAINT seatingsection_invenue_ibfk_1 FOREIGN KEY (venueID) REFERENCES venue (venueID) ON DELETE CASCADE;

--
-- Constraints for table seat_insection
--
ALTER TABLE seat_insection -
ADD CONSTRAINT seat_insection_ibfk_1 FOREIGN KEY (sectionID, venueID) REFERENCES seatingsection_invenue (sectionID, venueID) ON DELETE CASCADE;

--
-- Constraints for table ticket_ownsseat
--
ALTER TABLE ticket_ownsseat -
ADD CONSTRAINT ticket_ownsseat_ibfk_1 FOREIGN KEY (sectionID, venueID) REFERENCES seatingsection_invenue (sectionID, venueID) ON DELETE CASCADE;
ALTER TABLE ticket_ownsseat -
ADD CONSTRAINT ticket_ownsseat_ibfk_2 FOREIGN KEY (sectionID, venueID, seat_row, seatNo) REFERENCES seat_insection (sectionID, venueID, seat_row, seatNo) ON DELETE CASCADE;
