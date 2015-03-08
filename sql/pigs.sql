drop table Venue;
drop table Event_atVenue;
drop table SeatingSection_inVenue;
drop table Seat_inSection;
drop table Ticket_ownsSeat;
drop table Customer;
drop table Organizer;
drop table Organizes;
drop table ForAdmissionTo;

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
