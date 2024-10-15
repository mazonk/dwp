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
('Iron Man', 'Tony Stark becomes the armored superhero.', 126, 'English', '2008-05-02', 'poster_ironman.jpg', 'promo_ironman.mp4', 'trailer_ironman.mp4', 8.70),
('Interstellar', 'A team of explorers travel through a wormhole in space to ensure humanity’s survival.', 169, 'English', '2014-11-07', 'poster_interstellar.jpg', 'promo_interstellar.mp4', 'trailer_interstellar.mp4', 8.60),
('Andre Rieu', 'The renowned violinist and conductor captivates audiences with his classical music performances.', 120, 'English', '2020-10-10', 'poster_andrerieu.jpg', 'promo_andrerieu.mp4', 'trailer_andrerieu.mp4', 8.30),
('En Panda i Afrika', 'An animated adventure about a panda\'s journey to Africa, filled with humor and life lessons.', 95, 'Danish', '2023-02-14', 'poster_enpandaiafrika.jpg', 'promo_enpandaiafrika.mp4', 'trailer_enpandaiafrika.mp4', 7.20),
('The Apprentice', 'A young woman navigates the challenges of her apprenticeship in a competitive business environment.', 110, 'English', '2018-06-25', 'poster_apprentice.jpg', 'promo_apprentice.mp4', 'trailer_apprentice.mp4', 7.80),
('Deadpool', 'A mercenary with accelerated healing powers seeks revenge while delivering sarcastic humor.', 108, 'English', '2016-02-12', 'poster_deadpool.jpg', 'promo_deadpool.mp4', 'trailer_deadpool.mp4', 8.00),
('It Ends with Us', 'A gripping love story, where difficult decisions must be made in the face of adversity.', 120, 'English', '2024-03-08', 'poster_itendswithus.jpg', 'promo_itendswithus.mp4', 'trailer_itendswithus.mp4', 6.50),
('Robot', 'In a futuristic world, a humanoid robot learns about human emotions and identity.', 135, 'Hindi', '2010-10-01', 'poster_robot.jpg', 'promo_robot.mp4', 'trailer_robot.mp4', 7.10),
('Joker', 'A gritty character study of Arthur Fleck, a man disregarded by society who becomes the infamous Joker.', 122, 'English', '2019-10-04', 'poster_joker.jpg', 'promo_joker.mp4', 'trailer_joker.mp4', 8.50),
('Føreren og Forføreren', 'A biographical account of Nazi propaganda chief Joseph Goebbels and his role in the Third Reich.', 110, 'Danish', '2022-10-15', 'poster_foreren_forforeren.jpg', 'promo_foreren_forforeren.mp4', 'trailer_foreren_forforeren.mp4', 7.5),
('Minions', 'The story of the yellow Minions as they search for a new evil master to serve.', 91, 'English', '2015-07-10', 'poster_minions.jpg', 'promo_minions.mp4', 'trailer_minions.mp4', 6.40),
('Star Wars: Episode V - The Empire Strikes Back', 'Luke Skywalker and the Rebel Alliance face the Empire\'s wrath as they plan their next move against Darth Vader.', 124, 'English', '1980-05-21', 'poster_starwars5.jpg', 'promo_starwars5.mp4', 'trailer_starwars5.mp4', 8.70),
('Star Wars: Episode VI - Return of the Jedi', 'The Rebel Alliance makes a final stand to defeat the Galactic Empire and save the galaxy.', 131, 'English', '1983-05-25', 'poster_starwars6.jpg', 'promo_starwars6.mp4', 'trailer_starwars6.mp4', 8.30),
('Guardians of the Multiverse', 'A group of unlikely heroes band together to save multiple realities from collapse.', 140, 'English', '2025-06-15', 'poster_guardians_multiverse.jpg', 'promo_guardians_multiverse.mp4', 'trailer_guardians_multiverse.mp4', 8.90),
('Space Explorers: The Next Journey', 'A new generation of astronauts embarks on a mission to colonize distant planets.', 135, 'English', '2024-12-20', 'poster_space_explorers.jpg', 'promo_space_explorers.mp4', 'trailer_space_explorers.mp4', 8.70),
('The Time Jumper', 'A man gains the ability to travel through time, but must decide how much to alter his past.', 118, 'English', '2025-03-15', 'poster_time_jumper.jpg', 'promo_time_jumper.mp4', 'trailer_time_jumper.mp4', 8.40),
('AI: Awakening', 'An advanced AI system becomes self-aware, leading humanity to confront new ethical dilemmas.', 128, 'English', '2024-11-05', 'poster_ai_awakening.jpg', 'promo_ai_awakening.mp4', 'trailer_ai_awakening.mp4', 7.90),
('Rise of the Phoenix', 'A fallen warrior seeks redemption in a war-torn kingdom ruled by a corrupt regime.', 150, 'English', '2024-09-30', 'poster_rise_phoenix.jpg', 'promo_rise_phoenix.mp4', 'trailer_rise_phoenix.mp4', 8.50);

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

INSERT INTO MovieGenre (movieId, genreId) VALUES
(1, 1),  -- The Dark Knight -> Action
(1, 2),  -- The Dark Knight -> Drama
(2, 1),  -- Spider-Man: No Way Home -> Action
(2, 3),  -- Spider-Man: No Way Home -> Sci-Fi
(3, 1),  -- Iron Man -> Action
(3, 3);  -- Iron Man -> Sci-Fi

INSERT INTO MovieDirector (movieId, directorId) VALUES
(1, 1),  -- The Dark Knight -> Christopher Nolan
(2, 2),  -- Spider-Man: No Way Home -> Jon Watts
(3, 3);  -- Iron Man -> Jon Favreau

INSERT INTO MovieActor (movieId, actorId) VALUES
(1, 1),  -- The Dark Knight -> Christian Bale
(2, 2),  -- Spider-Man: No Way Home -> Tom Holland
(3, 3);  -- Iron Man -> Robert Downey Jr.

INSERT INTO VenueShowing (venueId, showingId) VALUES
(1, 1),  -- Gotham Cinema -> Showing of The Dark Knight
(2, 2),  -- Hollywood Stars Cinema -> Showing of Spider-Man: No Way Home
(3, 3);  -- Empire Cinema -> Showing of Iron Man

INSERT INTO VenueOpeningHour (venueId, openingHourId) VALUES
(1, 1),  -- Gotham Cinema -> Monday's opening hours
(2, 2),  -- Hollywood Stars Cinema -> Tuesday's opening hours
(3, 3);  -- Empire Cinema -> Wednesday's opening hours
