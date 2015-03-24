SET SQLBLANKLINES ON;
select object_name, s.sid, s.serial#  from v$locked_object l, dba_objects o, v$session s, v$process p where l.object_id = o.object_id and l.session_id = s.sid and s.paddr = p.addr;
alter system kill session 'sid,serial#';--sid` and `serial#` get from step 1

alter session set ddl_lock_timeout = 600;

-- Drop existing tables
drop table Venue CASCADE CONSTRAINTS;
drop table Event_atVenue CASCADE CONSTRAINTS;
drop table SeatingSection_inVenue CASCADE CONSTRAINTS;
drop table Seat_inSection CASCADE CONSTRAINTS;
drop table Ticket_ownsSeat_WithCustomer CASCADE CONSTRAINTS;
drop table Customer CASCADE CONSTRAINTS;
drop table Organizer CASCADE CONSTRAINTS;
drop table ForAdmissionTo CASCADE CONSTRAINTS;

drop SEQUENCE SEQ_VENUE;
drop SEQUENCE SEQ_EVENT;
drop SEQUENCE SEQ_SECTION;
drop SEQUENCE SEQ_SEAT;
drop SEQUENCE SEQ_CUSTOMER;
drop SEQUENCE SEQ_TICKET;
drop SEQUENCE SEQ_ORGANIZER;

-- Create tables with their constraints
CREATE TABLE Venue (venueID INT , name VARCHAR(255), address VARCHAR(255), cityName VARCHAR(255), provName VARCHAR(255), oranizerID INT, PRIMARY KEY (venueID), UNIQUE (address, cityName, provName));
CREATE SEQUENCE SEQ_VENUE START WITH 10 INCREMENT BY 1;

CREATE TABLE Event_atVenue (venueID INT, eventID INT, eventName VARCHAR(255), basePrice INT, saleOpenDate TIMESTAMP, ticketStatus VARCHAR(255), startTime TIMESTAMP, endTime TIMESTAMP, organizerID INT, PRIMARY KEY(eventID), UNIQUE (startTime, endTime, venueID), CONSTRAINT eavC CHECK (basePrice >= 0));
--ALTER TABLE Event_atVenue ADD CONSTRAINT fkv FOREIGN KEY (venueID) REFERENCES Venue (venueID) ON DELETE SET NULL;
CREATE SEQUENCE SEQ_EVENT START WITH 10 INCREMENT BY 1;

CREATE TABLE SeatingSection_inVenue (venueID INT, sectionID INT NOT NULL , additionalPrice INT, seatsAvailable INT NOT NULL, seatingSectionType INT NOT NULL, PRIMARY KEY (sectionID, venueID), CONSTRAINT ssivC1 CHECK (additionalPrice >= 0), CONSTRAINT ssivC2 CHECK (seatsAvailable >= 0));
CREATE SEQUENCE SEQ_SECTION START WITH 10 INCREMENT BY 1;

CREATE TABLE Seat_inSection (sectionID INT, venueID INT, seat_row INT, seatNo INT, PRIMARY KEY (sectionID, venueID, seat_row, seatNo), CONSTRAINT sisC1 CHECK (seat_row >= 0), CONSTRAINT sisC2 CHECK (seatNo >= 0));
CREATE SEQUENCE SEQ_SEAT START WITH 10 INCREMENT BY 1;

CREATE TABLE Customer (userID INT, firstName VARCHAR(255), lastName VARCHAR(255), email VARCHAR(255), username VARCHAR(255), password VARCHAR(255), PRIMARY KEY(userID), UNIQUE(email), UNIQUE(username));
CREATE SEQUENCE SEQ_CUSTOMER START WITH 10 INCREMENT BY 1;

CREATE TABLE Ticket_ownsSeat_WithCustomer(ticketID INT, userID INT, isAvailable CHAR, sectionID INT, venueID INT, seat_row INT, seatNo INT, PRIMARY KEY (ticketID), CONSTRAINT toswcC1 CHECK (seat_row >= 0), CONSTRAINT toswcC2 CHECK (seatNo >= 0));
--ALTER TABLE Ticket_ownsSeat_WithCustomer ADD CONSTRAINT ticket_ownsseat_ibfk_3 FOREIGN KEY (userID) REFERENCES Customer(userID) ON DELETE SET NULL;
CREATE SEQUENCE SEQ_TICKET START WITH 20 INCREMENT BY 1;

CREATE TABLE Organizer (organizerID INT, firstName VARCHAR(255) NOT NULL, lastName VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255), password VARCHAR(255), PRIMARY KEY(organizerID), UNIQUE(username), UNIQUE(email));
CREATE SEQUENCE SEQ_ORGANIZER START WITH 10 INCREMENT BY 1;

CREATE TABLE ForAdmissionTo(eventID INT, ticketID INT, PRIMARY KEY(eventID, ticketID));


-- Add mock data
COMMIT;
SET TRANSACTION NAME 'mock_data';

INSERT INTO venue (venueID, name, address, cityName, provName) VALUES -
(1, 'Queen Elizabeth Theatre', '649 Cambie Street', 'Vancouver', 'BC');
INSERT INTO venue (venueID, name, address, cityName, provName) VALUES -
(2, 'Rogers Arena', '800 Griffiths Way', 'Vancouver', 'BC');
INSERT INTO venue (venueID, name, address, cityName, provName) VALUES -
(3, 'Saddledome', '555 Saddledome Rise SE', 'Calgary', 'AB');
INSERT INTO venue (venueID, name, address, cityName, provName) VALUES -
(4, 'BC Place', '777 Pacific Boulevard', 'Vancouver', 'BC');
INSERT INTO venue (venueID, name, address, cityName, provName) VALUES -
(5, 'Air Canada Centre', '40 Bay Street', 'Toronto', 'ON');

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


INSERT INTO event_atvenue (venueID, eventID, eventName, basePrice, saleOpenDate, ticketStatus, startTime, endTime) VALUES -
(1, 1, 'Alexisonfire', 30, '2014-04-14 00:00:01', 'Open', '2014-05-14 19:00:00', '2014-05-14 23:59:00');
INSERT INTO event_atvenue (venueID, eventID,  eventName, basePrice, saleOpenDate, ticketStatus, startTime, endTime) VALUES -
(2, 2, 'Pink Floyd', 80, '2014-04-10 00:00:01', 'Closed', '2014-04-24 19:00:00', '2014-04-25 19:00:00');
INSERT INTO event_atvenue (venueID, eventID,  eventName, basePrice, saleOpenDate, ticketStatus, startTime, endTime) VALUES -
(3, 3, 'CPSC 304: Back to the Database', 5, '2015-05-01 08:00:00', 'Closed', '2015-06-06 09:00:00', '2015-06-06 11:00:00');
INSERT INTO event_atvenue (venueID, eventID,  eventName, basePrice, saleOpenDate, ticketStatus, startTime, endTime) VALUES -
(4, 4, 'Comic Con 39', 150, '2015-04-01 00:00:00', 'Closed', '2015-07-20 09:00:00', '2015-07-27 23:00:00');
INSERT INTO event_atvenue (venueID, eventID, eventName,  basePrice, saleOpenDate, ticketStatus, startTime, endTime) VALUES -
(5, 5, '53rd Annual Gala', 25, '2015-02-01 00:00:01', 'Closed', '2015-04-13 18:30:00', '2015-04-15 21:00:00');


INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(1, 1);
INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(1, 2);
INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(1, 3);


INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(2, 4);
INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(2, 5);
INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(2, 6);


INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(3, 7);
INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(3, 8);
INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(3, 9);

INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(4, 10);
INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(4, 11);
INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(4, 12);

INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(5, 13);
INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(5, 14);
INSERT INTO foradmissionto (eventID, ticketID) VALUES -
(5, 15);


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




INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, seatingSectionType) VALUES -
(1, 1, 10, 50, 1);
INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, seatingSectionType) VALUES -
(1, 2, 20, 50, 2);
INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, seatingSectionType) VALUES -
(1, 3, 30, 50, 3);

INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, seatingSectionType) VALUES -
(2, 1, 10, 50, 1);
INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, seatingSectionType) VALUES -
(2, 2, 20, 50, 2);
INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, seatingSectionType) VALUES -
(2, 3, 30, 50, 3);

INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, seatingSectionType) VALUES -
(3, 1, 10, 50, 1);
INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, seatingSectionType) VALUES -
(3, 2, 20, 50, 2);
INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, seatingSectionType) VALUES -
(3, 3, 30, 50, 3);

INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, seatingSectionType) VALUES -
(4, 1, 10, 50, 1);
INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, seatingSectionType) VALUES -
(4, 2, 20, 50, 2);
INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, seatingSectionType) VALUES -
(4, 3, 30, 50, 3);

INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, seatingSectionType) VALUES -
(5, 1, 10, 50, 1);
INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, seatingSectionType) VALUES -
(5, 2, 20, 50, 2);
INSERT INTO seatingsection_invenue (venueID, sectionID, additionalPrice, seatsAvailable, seatingSectionType) VALUES -
(5, 3, 30, 50, 3);

INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(1, 1, 20, 5);
INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(2, 1, 20, 5);
INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(3, 1, 20, 5);

INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(1, 2, 20, 5);
INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(2, 2, 20, 5);
INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(3, 2, 20, 5);

INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(1, 3, 20, 5);
INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(2, 3, 20, 5);
INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(3, 3, 20, 5);

INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(1, 4, 20, 5);
INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(2, 4, 20, 5);
INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(3, 4, 20, 5);

INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(1, 5, 20, 5);
INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(2, 5, 20, 5);
INSERT INTO seat_insection (sectionID, venueID, seat_row, seatNo) VALUES -
(3, 5, 20, 5);


INSERT INTO Ticket_ownsSeat_WithCustomer (ticketID, userID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES - 
(1,1,'F',1,1, 20, 5);
INSERT INTO Ticket_ownsSeat_WithCustomer (ticketID, userID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES - 
(2,1,'F',2,1, 20, 5);
INSERT INTO Ticket_ownsSeat_WithCustomer (ticketID, userID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES - 
(3,1,'F',3,1, 20, 5);
INSERT INTO Ticket_ownsSeat_WithCustomer (ticketID, userID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES - 
(4,1,'F',1,2, 20, 5);
INSERT INTO Ticket_ownsSeat_WithCustomer (ticketID, userID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES - 
(5,2,'F',2,2, 20, 5);
INSERT INTO Ticket_ownsSeat_WithCustomer (ticketID, userID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES - 
(6,2,'F',3,2, 20, 5);
INSERT INTO Ticket_ownsSeat_WithCustomer (ticketID, userID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES - 
(7,2,'F',1,3, 20, 5);
INSERT INTO Ticket_ownsSeat_WithCustomer (ticketID, userID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES - 
(8,2,'F',2,3, 20, 5);
INSERT INTO Ticket_ownsSeat_WithCustomer (ticketID, userID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES - 
(9,3,'F',3,3, 20, 5);
INSERT INTO Ticket_ownsSeat_WithCustomer (ticketID, userID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES - 
(10,3,'F',1,4, 20, 5);
INSERT INTO Ticket_ownsSeat_WithCustomer (ticketID, userID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES - 
(11,3,'F',2,4, 20, 5);
INSERT INTO Ticket_ownsSeat_WithCustomer (ticketID, userID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES - 
(12,4,'F',3,4, 20, 5);
INSERT INTO Ticket_ownsSeat_WithCustomer (ticketID, userID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES - 
(13,4,'F',1,5, 20, 5);
INSERT INTO Ticket_ownsSeat_WithCustomer (ticketID, userID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES - 
(14,5,'F',2,5, 20, 5);
INSERT INTO Ticket_ownsSeat_WithCustomer (ticketID, userID, isAvailable, sectionID, venueID, seat_row, seatNo) VALUES - 
(15,5,'F',3,5, 20, 5);


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
ADD CONSTRAINT foradmissionto_ibfk_2 FOREIGN KEY (ticketID) REFERENCES Ticket_ownsSeat_WithCustomer (ticketID) ON DELETE CASCADE;

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
-- Constraints for table Ticket_ownsSeat_WithCustomer
--
ALTER TABLE Ticket_ownsSeat_WithCustomer -
ADD CONSTRAINT ticket_ownsseat_ibfk_1 FOREIGN KEY (sectionID, venueID) REFERENCES seatingsection_invenue (sectionID, venueID) ON DELETE CASCADE;
ALTER TABLE Ticket_ownsSeat_WithCustomer -
ADD CONSTRAINT ticket_ownsseat_ibfk_2 FOREIGN KEY (sectionID, venueID, seat_row, seatNo) REFERENCES seat_insection (sectionID, venueID, seat_row, seatNo) ON DELETE CASCADE;
