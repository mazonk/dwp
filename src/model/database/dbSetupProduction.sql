-- Disable foreign key checks (so tables can be dropped)
SET FOREIGN_KEY_CHECKS = 0;

-- Drop all tables
DROP TABLE IF EXISTS VenueShowing;
DROP TABLE IF EXISTS Ticket;
DROP TABLE IF EXISTS Payment;
DROP TABLE IF EXISTS Booking;
DROP TABLE IF EXISTS Showing;
DROP TABLE IF EXISTS Seat;
DROP TABLE IF EXISTS Room;
DROP TABLE IF EXISTS Venue;
DROP TABLE IF EXISTS CompanyInfo;
DROP TABLE IF EXISTS Address;
DROP TABLE IF EXISTS PostalCode;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS UserRole;
DROP TABLE IF EXISTS TicketType;
DROP TABLE IF EXISTS MovieActor;
DROP TABLE IF EXISTS MovieDirector;
DROP TABLE IF EXISTS MovieGenre;
DROP TABLE IF EXISTS Genre;
DROP TABLE IF EXISTS Director;
DROP TABLE IF EXISTS Actor;
DROP TABLE IF EXISTS Movie;
DROP TABLE IF EXISTS News;
DROP TABLE IF EXISTS OpeningHour;

-- Enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE PostalCode (
    postalCodeId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    postalCode int NOT NULL,
    city VARCHAR(50) NOT NULL
);

CREATE TABLE Address (
    addressId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    street VARCHAR(100) NOT NULL,
    streetNr VARCHAR(10) NOT NULL,
    postalCodeId INT NOT NULL,
    FOREIGN KEY (postalCodeId) REFERENCES PostalCode(postalCodeId)
);

CREATE TABLE CompanyInfo (
    companyInfoId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    companyName VARCHAR(100) NOT NULL,
    companyDescription TEXT NOT NULL,
    logoUrl VARCHAR(255) NOT NULL,
    addressId INT NOT NULL,
    FOREIGN KEY (addressId) REFERENCES Address(addressId)
);

CREATE TABLE Venue (
    venueId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name VARCHAR(100) NOT NULL,
    phoneNr VARCHAR(20) NOT NULL,
    contactEmail VARCHAR(100) NOT NULL,
    addressId INT NOT NULL,
    FOREIGN KEY (addressId) REFERENCES Address(addressId)
);

CREATE TABLE OpeningHour (
    openingHourId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    day ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), -- should we rly use enum here?
    openingTime TIME NOT NULL,
    closingTime TIME NOT NULL,
    isCurrent BOOLEAN NOT NULL
);

CREATE TABLE Room (
    roomId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    roomNumber INT NOT NULL,
    -- noOfSeats INT NULL, -- calculated 
    venueId INT NOT NULL,
    FOREIGN KEY (venueId) REFERENCES Venue(venueId)
);

CREATE TABLE Seat (
    seatId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `row` INT NOT NULL,
    seatNr INT NOT NULL,
    roomId INT NOT NULL,
    FOREIGN KEY (roomId) REFERENCES Room(roomId)
);

CREATE TABLE UserRole (
    roleId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    type VARCHAR(50) NOT NULL
);

CREATE TABLE User (
    userId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    DoB DATE NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    passwordHash VARCHAR(1000) NULL, -- null for anonymous users | Is this a good idea?
    roleId INT NOT NULL,
    FOREIGN KEY (roleId) REFERENCES UserRole(roleId)
);

CREATE TABLE Movie (
    movieId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    archived BOOLEAN NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NULL,
    duration INT NULL,
    language VARCHAR(50) NULL,
    releaseDate DATE NULL,
    posterURL VARCHAR(255) NULL,
    promoURL VARCHAR(255) NULL,
    trailerURL VARCHAR(255) NULL,
    rating DECIMAL(3, 1) NULL
);

CREATE TABLE Genre (
    genreId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE Director (
    directorId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL
);

CREATE TABLE Actor (
    actorId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    `character` VARCHAR(50) NULL
);

CREATE TABLE Showing (
    showingId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    showingDate DATE NOT NULL,
    showingTime TIME NOT NULL,
    movieId INT NOT NULL,
    roomId INT NOT NULL,
    archived BOOLEAN NOT NULL,
    FOREIGN KEY (movieId) REFERENCES Movie(movieId),
    FOREIGN KEY (roomId) REFERENCES Room(roomId)
);

CREATE TABLE TicketType (
    ticketTypeId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name VARCHAR(50) NOT NULL,
    price DECIMAL(5, 2) NOT NULL, -- 5 digits and 2 digits after the decimal point 0.00 - 999.99
    description TEXT NULL
);

CREATE TABLE Booking (
    bookingId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    userId INT NULL, -- null so not logged in users can create a temporary booking object, until they are not on the users table
    status ENUM('pending', 'confirmed', 'failed') NOT NULL, -- enum?
    FOREIGN KEY (userId) REFERENCES User(userId)
);

CREATE TABLE Ticket (
    ticketId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    seatId INT NOT NULL,
    ticketTypeId INT NOT NULL,
    showingId INT NOT NULL,
    bookingId INT NOT NULL,
    FOREIGN KEY (seatId) REFERENCES Seat(seatId),
    FOREIGN KEY (ticketTypeId) REFERENCES TicketType(ticketTypeId),
    FOREIGN KEY (showingId) REFERENCES Showing(showingId),
    FOREIGN KEY (bookingId) REFERENCES Booking(bookingId)
);

CREATE TABLE Payment (
    paymentId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    paymentDate DATE NOT NULL,
    paymentTime TIME NOT NULL,
    totalPrice DECIMAL(8, 2) NOT NULL, -- 8 digits and 2 digits after the decimal point 0.00 - 999999.99
    currency VARCHAR(3) NOT NULL,
    paymentMethod VARCHAR(50) NOT NULL,
    checkoutSessionId VARCHAR(100) NOT NULL,
    paymentStatus ENUM('pending', 'confirmed', 'failed') NOT NULL,
    addressId INT NOT NULL,
    bookingId INT NOT NULL,
    FOREIGN KEY (addressId) REFERENCES Address(addressId),
    FOREIGN KEY (bookingId) REFERENCES Booking(bookingId)
);

CREATE TABLE News (
    newsId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    imageURL VARCHAR(255) NOT NULL, -- blob?
    header VARCHAR(255) NOT NULL,
    content TEXT NOT NULL
);

-- Junction Tables

-- Movie to Genre (many-to-many)
CREATE TABLE MovieGenre (
    movieId INT NOT NULL,
    genreId INT NOT NULL,
    PRIMARY KEY (movieId, genreId),
    FOREIGN KEY (movieId) REFERENCES Movie(movieId),
    FOREIGN KEY (genreId) REFERENCES Genre(genreId)
);

-- Movie to Director (many-to-many)
CREATE TABLE MovieDirector (
    movieId INT NOT NULL,
    directorId INT NOT NULL,
    PRIMARY KEY (movieId, directorId),
    FOREIGN KEY (movieId) REFERENCES Movie(movieId),
    FOREIGN KEY (directorId) REFERENCES Director(directorId)
);

-- Movie to Actor (many-to-many)
CREATE TABLE MovieActor (
    movieId INT NOT NULL,
    actorId INT NOT NULL,
    PRIMARY KEY (movieId, actorId),
    FOREIGN KEY (movieId) REFERENCES Movie(movieId),
    FOREIGN KEY (actorId) REFERENCES Actor(actorId)
);

-- Venue to Showing (many-to-many)
CREATE TABLE VenueShowing (
    venueId INT NOT NULL,
    showingId INT NOT NULL,
    PRIMARY KEY (venueId, showingId),
    FOREIGN KEY (venueId) REFERENCES Venue(venueId),
    FOREIGN KEY (showingId) REFERENCES Showing(showingId)
);

-- Views

CREATE OR REPLACE VIEW MoviesWithShowings AS
SELECT 
    m.movieId,
    m.title,
    COUNT(s.showingId) AS numberOfShowings
FROM Movie m
LEFT JOIN Showing s ON m.movieId = s.movieId
GROUP BY m.movieId, m.title;

CREATE OR REPLACE VIEW ShowingsWithDetails AS
SELECT 
    s.showingId,
    s.showingDate,
    s.showingTime,
    m.title,
    m.movieId,
    r.roomNumber,
    vs.venueId,
    COUNT(DISTINCT b.bookingId) AS bookings, -- Total number of bookings
    COUNT(t.ticketId) AS tickets             -- Total number of tickets
FROM Showing s
JOIN Movie m ON s.movieId = m.movieId
JOIN Room r ON s.roomId = r.roomId
JOIN VenueShowing vs ON s.showingId = vs.showingId
LEFT JOIN Ticket t ON s.showingId = t.showingId
LEFT JOIN Booking b ON t.bookingId = b.bookingId
GROUP BY 
    s.showingId, 
    s.showingDate, 
    s.showingTime, 
    m.title,
    m.movieId,
    r.roomNumber,
    vs.venueId;

-- Triggers

DELIMITER //

CREATE TRIGGER validate_rating
BEFORE INSERT ON Movie
FOR EACH ROW
BEGIN
    IF NEW.rating < 0 OR NEW.rating > 10 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Rating must be between 0.0 and 10.0';
    END IF;
END;
//


DELIMITER //

CREATE TRIGGER validate_totalprice
BEFORE INSERT ON Payment
FOR EACH ROW
BEGIN
    IF NEW.totalPrice < 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Total price of payment cannot be less than 0.00';
    END IF;
END;
//

DELIMITER //

CREATE TRIGGER validate_price
BEFORE INSERT ON TicketType
FOR EACH ROW
BEGIN
    IF NEW.price < 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ticket price cannot be less than 0.00';
    END IF;
END;
//