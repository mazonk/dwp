DROP DATABASE IF EXISTS Cinema;
CREATE DATABASE Cinema;
USE Cinema;

CREATE TABLE Address (
    addressId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    street VARCHAR(100) NOT NULL,
    streetNr VARCHAR(10) NOT NULL,
    city VARCHAR(50) NOT NULL,
    postalCode VARCHAR(20) NOT NULL
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
    isCurrent BOOLEAN NOT NULL,
    venueId INT NOT NULL,
    FOREIGN KEY (venueId) REFERENCES Venue(venueId)
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
    row INT NOT NULL,
    seatNr INT NOT NULL,
    roomId INT NOT NULL,
    FOREIGN KEY (roomId) REFERENCES Room(roomId)
);

CREATE TABLE User (
    userId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    DoB DATE NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    passwordHash VARCHAR(1000) NULL, -- null for anonymous users | Is this a good idea?
    role ENUM('customer', 'admin') DEFAULT 'customer' NOT NULL -- enum?
);

CREATE TABLE Movie (
    movieId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NULL,
    duration INT NULL,
    language VARCHAR(50) NULL,
    releaseDate DATE NULL,
    posterURL VARCHAR(255) NULL,
    rating DECIMAL(2, 2) NULL, -- 2 digits and 2 digits after the decimal point
    trailerURL VARCHAR(255) NULL
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
    FOREIGN KEY (movieId) REFERENCES Movie(movieId),
    FOREIGN KEY (roomId) REFERENCES Room(roomId)
);

CREATE TABLE TicketType (
    ticketTypeId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name VARCHAR(50) NOT NULL,
    price DECIMAL(5, 2) NOT NULL, -- 5 digits and 2 digits after the decimal point
    description VARCHAR(255) NULL
);

CREATE TABLE Reservation (
    reservationId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    userId INT NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled') NOT NULL,
    FOREIGN KEY (userId) REFERENCES User(userId)
);

CREATE TABLE Ticket (
    ticketId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    seatId INT NOT NULL,
    ticketTypeId INT NOT NULL,
    showingId INT NOT NULL,
    reservationId INT NOT NULL,
    FOREIGN KEY (seatId) REFERENCES Seat(seatId),
    FOREIGN KEY (ticketTypeId) REFERENCES TicketType(ticketTypeId),
    FOREIGN KEY (showingId) REFERENCES Showing(showingId),
    FOREIGN KEY (reservationId) REFERENCES Reservation(reservationId)
);

CREATE TABLE Payment (
    paymentId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    method ENUM('credit_card', 'paypal', 'mobile_payu') NOT NULL,
    `date` DATE NOT NULL,
    totalPrice DECIMAL(8, 2) NOT NULL, -- 8 digits and 2 digits after the decimal point
    userId INT NOT NULL,
    addressId INT NOT NULL,
    reservationId INT NOT NULL,
    FOREIGN KEY (userId) REFERENCES User(userId),
    FOREIGN KEY (addressId) REFERENCES Address(addressId),
    FOREIGN KEY (reservationId) REFERENCES Reservation(reservationId)
);

CREATE TABLE News (
    newsId INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
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

-- Venue to OpeningHour (many-to-many)
CREATE TABLE VenueOpeningHour (
    venueId INT NOT NULL,
    openingHourId INT NOT NULL,
    PRIMARY KEY (venueId, openingHourId),
    FOREIGN KEY (venueId) REFERENCES Venue(venueId),
    FOREIGN KEY (openingHourId) REFERENCES OpeningHour(openingHourId)
);

