INSERT INTO PostalCode (postalCode, city) VALUES
(60606, 'Chicago'),
(90210, 'Beverly Hills'),
(10001, 'New York');

INSERT INTO Address (street, streetNr, postalCode) VALUES
('Wayne Tower', '100', 60606),
('Rodeo Drive', '222', 90210),
('Queens Blvd', '15', 10001);

INSERT INTO Venue (name, phoneNr, contactEmail, addressId) VALUES
('Gotham Cinema', '312-555-1234', 'info@gothamcinema.com', 1),
('Hollywood Stars Cinema', '310-555-5678', 'contact@hollywoodcinema.com', 2),
('Empire Cinema', '212-555-9010', 'support@empirecinema.com', 3);

INSERT INTO OpeningHour (day, openingTime, closingTime, isCurrent, venueId) VALUES
('Monday', '10:00:00', '22:00:00', TRUE, 1),
('Tuesday', '09:00:00', '23:00:00', TRUE, 2),
('Wednesday', '10:30:00', '21:30:00', TRUE, 3);

INSERT INTO Room (roomNumber, venueId) VALUES
(101, 1),
(202, 2),
(303, 3);

INSERT INTO Seat (`row`, seatNr, roomId) VALUES
(1, 5, 1),
(2, 8, 2),
(3, 10, 3);

INSERT INTO UserRole (type) VALUES
('Admin'), 
('Customer'),
('Staff');

INSERT INTO User (firstName, lastName, DoB, email, passwordHash, roleId) VALUES
('Bruce', 'Wayne', '1972-02-19', 'bruce@gotham.com', 'hashedpassword1', 1),
('Peter', 'Parker', '1995-08-10', 'peter@spiderman.com', 'hashedpassword2', 2),
('Tony', 'Stark', '1970-05-29', 'tony@starkindustries.com', 'hashedpassword3', 3);

INSERT INTO Movie (title, description, duration, language, releaseDate, posterURL, promoURL, trailerURL, rating) VALUES
('The Dark Knight', 'Batman faces the Joker in Gotham City.', 152, 'English', '2008-07-18', 'poster_dark_knight.jpg', 'promo_dark_knight.mp4', 'trailer_dark_knight.mp4', 9.00),
('Spider-Man: No Way Home', 'Peter Parker deals with multiverse villains.', 148, 'English', '2021-12-17', 'poster_spiderman.jpg', 'promo_spiderman.mp4', 'trailer_spiderman.mp4', 8.50),
('Iron Man', 'Tony Stark becomes the armored superhero.', 126, 'English', '2008-05-02', 'poster_ironman.jpg', 'promo_ironman.mp4', 'trailer_ironman.mp4', 8.70);

INSERT INTO Genre (name) VALUES
('Action'),
('Drama'),
('Sci-Fi');

INSERT INTO Director (firstName, lastName) VALUES
('Christopher', 'Nolan'),
('Jon', 'Watts'),
('Jon', 'Favreau');

INSERT INTO Actor (firstName, lastName, `character`) VALUES
('Christian', 'Bale', 'Bruce Wayne/Batman'),
('Tom', 'Holland', 'Peter Parker/Spider-Man'),
('Robert', 'Downey Jr.', 'Tony Stark/Iron Man');

INSERT INTO Showing (showingDate, showingTime, movieId, roomId) VALUES
('2024-10-15', '19:00:00', 1, 1),
('2024-10-16', '20:00:00', 2, 2),
('2024-10-17', '21:00:00', 3, 3);

INSERT INTO TicketType (name, price, description) VALUES
('Standard', 10.00, 'Regular seating ticket'),
('VIP', 20.00, 'Access to premium seating'),
('Student', 8.00, 'Discount for students');

INSERT INTO Reservation (userId, status) VALUES
(1, 'confirmed'),
(2, 'pending'),
(3, 'cancelled');

INSERT INTO Ticket (seatId, ticketTypeId, showingId, reservationId) VALUES
(1, 1, 1, 1),
(2, 2, 2, 2),
(3, 3, 3, 3);

INSERT INTO PaymentMethod (name) VALUES
('Credit Card'),
('PayPal'),
('Cash');

INSERT INTO Payment (paymentDate, paymentTime, totalPrice, userId, addressId, reservationId, methodId) VALUES
('2024-10-15', '18:30:00', 10.00, 1, 1, 1, 1),
('2024-10-16', '19:45:00', 20.00, 2, 2, 2, 2),
('2024-10-17', '20:30:00', 8.00, 3, 3, 3, 3);

INSERT INTO News (imageURL, header, content) VALUES
('gotham_news.jpg', 'New Batman Movie Showing', 'Join us for the latest Batman movie screening at Gotham Cinema!'),
('hollywood_news.jpg', 'Spider-Man Marathon', 'Enjoy a Spider-Man marathon at Hollywood Stars Cinema this weekend.'),
('empire_news.jpg', 'Iron Man Reboot', 'Catch the Iron Man reboot at Empire Cinema with new special effects.');
