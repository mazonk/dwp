INSERT INTO PostalCode (postalCode, city) VALUES
(60606, 'Chicago'),
(90210, 'Beverly Hills'),
(10001, 'New York');

INSERT INTO Address (street, streetNr, postalCodeId) VALUES
('Wayne Tower', '100', 1),
('Rodeo Drive', '222', 2),
('Queens Blvd', '15', 3),
('Elizabeth Tower', '200', 1);

INSERT INTO CompanyInfo (companyName, companyDescription, logoUrl, addressId) VALUES
('Spicy Pisces', 'Spicy Pisces is a renowned movie theater chain in Chicago, offering an exceptional cinematic experience with state-of-the-art technology. 
Our theaters feature comfortable seating, top-notch sound systems, and a diverse range of film screenings, catering to audiences of all ages and preferences, 
ensuring an unforgettable entertainment journey for every visitor.', 'logo.jpg', 4);

INSERT INTO Venue (name, phoneNr, contactEmail, addressId) VALUES
('Gotham Cinema', '312-555-1234', 'info@gothamcinema.com', 1),
('Hollywood Stars Cinema', '310-555-5678', 'contact@hollywoodcinema.com', 2),
('Empire Cinema', '212-555-9010', 'support@empirecinema.com', 3);

INSERT INTO OpeningHour (day, openingTime, closingTime, isCurrent) VALUES
('Monday', '10:00:00', '22:00:00', TRUE),
('Tuesday', '09:00:00', '23:00:00', TRUE),
('Wednesday', '10:30:00', '21:30:00', TRUE);

INSERT INTO Room (roomNumber, venueId) VALUES
(101, 1),
(202, 2),
(303, 3),
(404, 1),
(505, 2),
(606, 3);

INSERT INTO Seat (`row`, seatNr, roomId) VALUES
(1, 1, 1), (1, 2, 1), (1, 3, 1), (1, 4, 1), (1, 5, 1), (1, 6, 1), (1, 7, 1), (1, 8, 1), (1, 9, 1), (1, 10, 1), (1, 11, 1), (1, 12, 1), (1, 13, 1), (1, 14, 1),
(2, 1, 1), (2, 2, 1), (2, 3, 1), (2, 4, 1), (2, 5, 1), (2, 6, 1), (2, 7, 1), (2, 8, 1), (2, 9, 1), (2, 10, 1), (2, 11, 1), (2, 12, 1), (2, 13, 1), (2, 14, 1),
(3, 1, 1), (3, 2, 1), (3, 3, 1), (3, 4, 1), (3, 5, 1), (3, 6, 1), (3, 7, 1), (3, 8, 1), (3, 9, 1), (3, 10, 1), (3, 11, 1), (3, 12, 1), (3, 13, 1), (3, 14, 1),
(4, 1, 1), (4, 2, 1), (4, 3, 1), (4, 4, 1), (4, 5, 1), (4, 6, 1), (4, 7, 1), (4, 8, 1),
(5, 1, 1), (5, 2, 1), (5, 3, 1), (5, 4, 1), (5, 5, 1), (5, 6, 1), (5, 7, 1), (5, 8, 1),
(6, 1, 1), (6, 2, 1), (6, 3, 1), (6, 4, 1), (6, 5, 1), (6, 6, 1), (6, 7, 1), (6, 8, 1),
(7, 1, 1), (7, 2, 1), (7, 3, 1), (7, 4, 1), (7, 5, 1), (7, 6, 1), (7, 7, 1), (7, 8, 1),
(8, 1, 1), (8, 2, 1), (8, 3, 1), (8, 4, 1), (8, 5, 1), (8, 6, 1), (8, 7, 1), (8, 8, 1),
(9, 1, 1), (9, 2, 1), (9, 3, 1), (9, 4, 1), (9, 5, 1), (9, 6, 1), (9, 7, 1), (9, 8, 1),
(10, 1, 1), (10, 2, 1), (10, 3, 1), (10, 4, 1), (10, 5, 1), (10, 6, 1), (10, 7, 1), (10, 8, 1),
(1, 1, 2), (1, 2, 2), (1, 3, 2), (1, 4, 2), (1, 5, 2), (1, 6, 2), (1, 7, 2), (1, 8, 2), (1, 9, 2), (1, 10, 2), (1, 11, 2), (1, 12, 2), (1, 13, 2), (1, 14, 2),
(2, 1, 2), (2, 2, 2), (2, 3, 2), (2, 4, 2), (2, 5, 2), (2, 6, 2), (2, 7, 2), (2, 8, 2), (2, 9, 2), (2, 10, 2), (2, 11, 2), (2, 12, 2), (2, 13, 2), (2, 14, 2),
(3, 1, 2), (3, 2, 2), (3, 3, 2), (3, 4, 2), (3, 5, 2), (3, 6, 2), (3, 7, 2), (3, 8, 2), (3, 9, 2), (3, 10, 2), (3, 11, 2), (3, 12, 2), (3, 13, 2), (3, 14, 2),
(4, 1, 2), (4, 2, 2), (4, 3, 2), (4, 4, 2), (4, 5, 2), (4, 6, 2), (4, 7, 2), (4, 8, 2),
(5, 1, 2), (5, 2, 2), (5, 3, 2), (5, 4, 2), (5, 5, 2), (5, 6, 2), (5, 7, 2), (5, 8, 2),
(6, 1, 2), (6, 2, 2), (6, 3, 2), (6, 4, 2), (6, 5, 2), (6, 6, 2), (6, 7, 2), (6, 8, 2),
(7, 1, 2), (7, 2, 2), (7, 3, 2), (7, 4, 2), (7, 5, 2), (7, 6, 2), (7, 7, 2), (7, 8, 2),
(8, 1, 2), (8, 2, 2), (8, 3, 2), (8, 4, 2), (8, 5, 2), (8, 6, 2), (8, 7, 2), (8, 8, 2),
(9, 1, 2), (9, 2, 2), (9, 3, 2), (9, 4, 2), (9, 5, 2), (9, 6, 2), (9, 7, 2), (9, 8, 2),
(10, 1, 2), (10, 2, 2), (10, 3, 2), (10, 4, 2), (10, 5, 2), (10, 6, 2), (10, 7, 2), (10, 8, 2),
(1, 1, 3), (1, 2, 3), (1, 3, 3), (1, 4, 3), (1, 5, 3), (1, 6, 3), (1, 7, 3), (1, 8, 3), (1, 9, 3), (1, 10, 3), (1, 11, 3), (1, 12, 3), (1, 13, 3), (1, 14, 3),
(2, 1, 3), (2, 2, 3), (2, 3, 3), (2, 4, 3), (2, 5, 3), (2, 6, 3), (2, 7, 3), (2, 8, 3), (2, 9, 3), (2, 10, 3), (2, 11, 3), (2, 12, 3), (2, 13, 3), (2, 14, 3),
(3, 1, 3), (3, 2, 3), (3, 3, 3), (3, 4, 3), (3, 5, 3), (3, 6, 3), (3, 7, 3), (3, 8, 3), (3, 9, 3), (3, 10, 3), (3, 11, 3), (3, 12, 3), (3, 13, 3), (3, 14, 3),
(4, 1, 3), (4, 2, 3), (4, 3, 3), (4, 4, 3), (4, 5, 3), (4, 6, 3), (4, 7, 3), (4, 8, 3),
(5, 1, 3), (5, 2, 3), (5, 3, 3), (5, 4, 3), (5, 5, 3), (5, 6, 3), (5, 7, 3), (5, 8, 3),
(6, 1, 3), (6, 2, 3), (6, 3, 3), (6, 4, 3), (6, 5, 3), (6, 6, 3), (6, 7, 3), (6, 8, 3),
(7, 1, 3), (7, 2, 3), (7, 3, 3), (7, 4, 3), (7, 5, 3), (7, 6, 3), (7, 7, 3), (7, 8, 3),
(8, 1, 3), (8, 2, 3), (8, 3, 3), (8, 4, 3), (8, 5, 3), (8, 6, 3), (8, 7, 3), (8, 8, 3),
(9, 1, 3), (9, 2, 3), (9, 3, 3), (9, 4, 3), (9, 5, 3), (9, 6, 3), (9, 7, 3), (9, 8, 3),
(10, 1, 3), (10, 2, 3), (10, 3, 3), (10, 4, 3), (10, 5, 3), (10, 6, 3), (10, 7, 3), (10, 8, 3),
(1, 1, 4), (1, 2, 4), (1, 3, 4), (1, 4, 4), (1, 5, 4), (1, 6, 4), (1, 7, 4), (1, 8, 4), (1, 9, 4), (1, 10, 4), (1, 11, 4), (1, 12, 4), (1, 13, 4), (1, 14, 4), (1, 15, 4), (1, 16, 4),
(2, 1, 4), (2, 2, 4), (2, 3, 4), (2, 4, 4), (2, 5, 4), (2, 6, 4), (2, 7, 4), (2, 8, 4), (2, 9, 4), (2, 10, 4), (2, 11, 4), (2, 12, 4), (2, 13, 4), (2, 14, 4),
(3, 1, 4), (3, 2, 4), (3, 3, 4), (3, 4, 4), (3, 5, 4), (3, 6, 4), (3, 7, 4), (3, 8, 4), (3, 9, 4), (3, 10, 4), (3, 11, 4), (3, 12, 4), (3, 13, 4), (3, 14, 4),
(4, 1, 4), (4, 2, 4), (4, 3, 4), (4, 4, 4), (4, 5, 4), (4, 6, 4), (4, 7, 4), (4, 8, 4),
(5, 1, 4), (5, 2, 4), (5, 3, 4), (5, 4, 4), (5, 5, 4), (5, 6, 4), (5, 7, 4), (5, 8, 4),
(1, 1, 5), (1, 2, 5), (1, 3, 5), (1, 4, 5), (1, 5, 5), (1, 6, 5), (1, 7, 5), (1, 8, 5), (1, 9, 5), (1, 10, 5), (1, 11, 5), (1, 12, 5), (1, 13, 5), (1, 14, 5), (1, 15, 5), (1, 16, 5),
(2, 1, 5), (2, 2, 5), (2, 3, 5), (2, 4, 5), (2, 5, 5), (2, 6, 5), (2, 7, 5), (2, 8, 5), (2, 9, 5), (2, 10, 5), (2, 11, 5), (2, 12, 5), (2, 13, 5), (2, 14, 5),
(3, 1, 5), (3, 2, 5), (3, 3, 5), (3, 4, 5), (3, 5, 5), (3, 6, 5), (3, 7, 5), (3, 8, 5), (3, 9, 5), (3, 10, 5), (3, 11, 5), (3, 12, 5), (3, 13, 5), (3, 14, 5),
(4, 1, 5), (4, 2, 5), (4, 3, 5), (4, 4, 5), (4, 5, 5), (4, 6, 5), (4, 7, 5), (4, 8, 5),
(5, 1, 5), (5, 2, 5), (5, 3, 5), (5, 4, 5), (5, 5, 5), (5, 6, 5), (5, 7, 5), (5, 8, 5),
(1, 1, 6), (1, 2, 6), (1, 3, 6), (1, 4, 6), (1, 5, 6), (1, 6, 6), (1, 7, 6), (1, 8, 6), (1, 9, 6), (1, 10, 6), (1, 11, 6), (1, 12, 6), (1, 13, 6), (1, 14, 6), (1, 15, 6), (1, 16, 6),
(2, 1, 6), (2, 2, 6), (2, 3, 6), (2, 4, 6), (2, 5, 6), (2, 6, 6), (2, 7, 6), (2, 8, 6), (2, 9, 6), (2, 10, 6), (2, 11, 6), (2, 12, 6), (2, 13, 6), (2, 14, 6),
(3, 1, 6), (3, 2, 6), (3, 3, 6), (3, 4, 6), (3, 5, 6), (3, 6, 6), (3, 7, 6), (3, 8, 6), (3, 9, 6), (3, 10, 6), (3, 11, 6), (3, 12, 6), (3, 13, 6), (3, 14, 6),
(4, 1, 6), (4, 2, 6), (4, 3, 6), (4, 4, 6), (4, 5, 6), (4, 6, 6), (4, 7, 6), (4, 8, 6),
(5, 1, 6), (5, 2, 6), (5, 3, 6), (5, 4, 6), (5, 5, 6), (5, 6, 6), (5, 7, 6), (5, 8, 6);

INSERT INTO UserRole (type) VALUES
('Admin'), 
('Customer'),
('Staff');

INSERT INTO User (firstName, lastName, DoB, email, passwordHash, roleId) VALUES
('Admin', 'Admin', '2000-01-01', 'admin@admin.com', '$2y$10$Xt53U6KwhZ34mwbsdgVNjetv998rgpvqQ9xMAa4EzwTfH9X2zElK2', 1);

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
('Sci-Fi'),
('Comedy'),
('Horror'),
('Fantasy'),
('Thriller'),
('Animation'),
('Mystery'),
('Romance'),
('Adventure'),
('Documentary'),
('Musical');

INSERT INTO Director (firstName, lastName) VALUES
('Christopher', 'Nolan'),
('Jon', 'Watts'),
('Jon', 'Favreau'),
('Christopher', 'Nolan'),
('Jon', 'Watts'),
('Jon', 'Favreau'),
('Michael', 'Williams'),
('Emil', 'Johnsen'),
('Alex', 'Garland'),
('Tim', 'Miller'),
('Justin', 'Baldoni'),
('Michael', 'Bay'),
('Todd', 'Phillips'),
('Søren', 'Kragh-Jacobsen'),
('Pierre', 'Coffin'),
('Irvin', 'Kershner'),
('Richard', 'Marquand'),
('James', 'Gunn'),
('Denis', 'Villeneuve'),
('Zack', 'Snyder');

INSERT INTO Actor (firstName, lastName, `character`) VALUES
('Christian', 'Bale', 'Bruce Wayne/Batman'),
('Tom', 'Holland', 'Peter Parker/Spider-Man'),
('Robert', 'Downey Jr.', 'Tony Stark/Iron Man'),
('Christian', 'Bale', 'Bruce Wayne/Batman'),
('Tom', 'Holland', 'Peter Parker/Spider-Man'),
('Robert', 'Downey Jr.', 'Tony Stark/Iron Man'),
('Matthew', 'McConaughey', 'Joseph Cooper'),
('Andre', 'Rieu', 'Andre Rieu'),
('Johan', 'Carlsson', 'Panda'),
('Anya', 'Taylor-Joy', 'Emily Smith'),
('Ryan', 'Reynolds', 'Wade Wilson/Deadpool'),
('Blake', 'Lively', 'Lily Bloom'),
('Shia', 'LaBeouf', 'Sam Witwicky'),
('Joaquin', 'Phoenix', 'Arthur Fleck/Joker'),
('Ulrich', 'Thomsen', 'Mads'),
('Pierre', 'Coffin', 'Minions'),
('Mark', 'Hamill', 'Luke Skywalker'),
('Chris', 'Pratt', 'Peter Quill/Star-Lord'),
('Zendaya', 'Mary', 'Jane Watson'),
('Jake', 'Gyllenhaal', 'David Rhodes'),
('Oscar', 'Isaac', 'Nathan Bateman'),
('Henry', 'Cavill', 'John Wick');

INSERT INTO Showing (showingDate, showingTime, movieId, roomId) VALUES
('2024-10-15', '19:00:00', 1, 1),
('2024-10-16', '20:00:00', 2, 2),
('2024-10-17', '21:00:00', 3, 3),
('2024-10-15', '19:00:00', 1, 1),
('2024-10-16', '20:00:00', 1, 2),
('2024-10-18', '21:30:00', 1, 3),
('2024-10-20', '18:00:00', 2, 1),
('2024-10-22', '20:15:00', 2, 2),
('2024-10-25', '22:00:00', 2, 3),
('2024-10-17', '19:30:00', 3, 2),
('2024-10-19', '18:15:00', 3, 1),
('2024-10-24', '20:00:00', 3, 2),
('2024-10-28', '22:45:00', 4, 3),
('2024-10-30', '21:00:00', 4, 1),
('2024-11-01', '17:30:00', 4, 1),
('2024-10-15', '16:45:00', 5, 2),
('2024-10-21', '19:00:00', 5, 3),
('2024-10-26', '21:15:00', 5, 1),
('2024-10-23', '18:30:00', 6, 1),
('2024-10-27', '20:00:00', 6, 2),
('2024-11-02', '22:30:00', 6, 3),
('2024-10-16', '15:00:00', 7, 3),
('2024-10-18', '19:00:00', 7, 1),
('2024-10-20', '21:30:00', 7, 2),
('2024-10-22', '17:45:00', 8, 3),
('2024-10-29', '19:30:00', 8, 3),
('2024-10-31', '22:15:00', 8, 1),
('2024-10-17', '20:45:00', 9, 2),
('2024-10-25', '21:30:00', 9, 3),
('2024-11-01', '19:15:00', 9, 2),
('2024-10-18', '16:30:00', 10, 1),
('2024-10-22', '20:00:00', 10, 2),
('2024-10-28', '22:00:00', 10, 3),
('2024-10-15', '14:00:00', 1, 1),
('2024-10-23', '18:00:00', 2, 1),
('2024-10-29', '19:45:00', 3, 2),
('2024-10-24', '21:00:00', 4, 3),
('2024-10-30', '17:15:00', 5, 2),
('2024-10-27', '18:30:00', 6, 1),
('2024-10-31', '20:45:00', 7, 2),
('2024-11-02', '22:15:00', 8, 3),
('2024-10-19', '19:00:00', 9, 2),
('2024-10-20', '16:30:00', 10, 1),
('2024-10-25', '20:15:00', 1, 2),
('2024-10-26', '21:45:00', 2, 3),
('2024-10-28', '17:30:00', 3, 1),
('2024-10-18', '19:15:00', 4, 1),
('2024-10-21', '20:30:00', 5, 2),
('2024-11-01', '21:45:00', 6, 3),
('2024-11-02', '17:00:00', 7, 3),
('2024-10-23', '19:00:00', 8, 1),
('2024-10-27', '20:30:00', 9, 2),
('2024-10-29', '22:00:00', 10, 3),
('2024-11-05', '10:00:00', 1, 1),
('2024-11-05', '13:00:00', 1, 2),
('2024-11-05', '16:00:00', 1, 3),
('2024-11-05', '19:00:00', 1, 4),
('2024-11-05', '21:30:00', 1, 5),
('2024-11-05', '10:00:00', 2, 1),
('2024-11-05', '13:00:00', 2, 2),
('2024-11-05', '16:00:00', 2, 3),
('2024-11-05', '19:00:00', 2, 4),
('2024-11-05', '21:30:00', 2, 5),
('2024-11-06', '10:00:00', 1, 1),
('2024-11-06', '13:00:00', 1, 2),
('2024-11-06', '16:00:00', 1, 3),
('2024-11-06', '19:00:00', 1, 4),
('2024-11-06', '21:30:00', 1, 5),
('2024-11-06', '10:00:00', 2, 1),
('2024-11-06', '13:00:00', 2, 2),
('2024-11-06', '16:00:00', 2, 3),
('2024-11-06', '19:00:00', 2, 4),
('2024-11-06', '21:30:00', 2, 5),
('2024-11-07', '10:00:00', 1, 1),
('2024-11-07', '13:00:00', 1, 2),
('2024-11-07', '16:00:00', 1, 3),
('2024-11-07', '19:00:00', 1, 4),
('2024-11-07', '21:30:00', 1, 5),
('2024-11-07', '10:00:00', 2, 1),
('2024-11-07', '13:00:00', 2, 2),
('2024-11-07', '16:00:00', 2, 3),
('2024-11-07', '19:00:00', 2, 4),
('2024-11-07', '21:30:00', 2, 5),
('2024-11-08', '10:00:00', 1, 1),
('2024-11-08', '13:00:00', 1, 2),
('2024-11-08', '16:00:00', 1, 3),
('2024-11-08', '19:00:00', 1, 4),
('2024-11-08', '21:30:00', 1, 5),
('2024-11-09', '10:00:00', 1, 1),
('2024-11-09', '13:00:00', 1, 2),
('2024-11-09', '16:00:00', 1, 3),
('2024-11-09', '19:00:00', 1, 4),
('2024-11-09', '21:30:00', 1, 5),
('2024-11-10', '10:00:00', 1, 1),
('2024-11-10', '13:00:00', 1, 2),
('2024-11-10', '16:00:00', 1, 3),
('2024-11-10', '19:00:00', 1, 4),
('2024-11-10', '21:30:00', 1, 5);


INSERT INTO TicketType (name, price, description) VALUES
('Standard', 10.00, 'Regular seating ticket'),
('VIP', 20.00, 'Access to premium seating'),
('Student', 8.00, 'Discount for students');

INSERT INTO Booking (userId, status) VALUES
(1, 'confirmed'),
(1, 'pending'),
(1, 'cancelled');

INSERT INTO Ticket (seatId, ticketTypeId, showingId, bookingId) VALUES
(1, 1, 1, 1),
(2, 2, 2, 2),
(3, 3, 3, 3),
(1, 1, 15, 1),
(2, 1, 15, 2),
(3, 2, 15, 3),
(4, 2, 15, 4),
(5, 3, 15, 5),
(6, 3, 15, 6),
(7, 1, 15, 7),
(8, 1, 15, 8),
(9, 2, 15, 9),
(10, 2, 15, 10),
(11, 3, 15, 11),
(12, 3, 15, 12),
(13, 1, 15, 13),
(14, 1, 15, 14),
(15, 2, 15, 15),
(16, 2, 15, 16),
(17, 3, 15, 17),
(18, 3, 15, 18),
(19, 1, 15, 19),
(20, 1, 15, 20),
(1, 1, 50, 21),
(2, 2, 50, 22),
(3, 3, 50, 23),
(4, 1, 50, 24),
(5, 2, 50, 25),
(6, 1, 50, 26),
(7, 3, 50, 27),
(8, 2, 50, 28),
(9, 1, 50, 29),
(10, 3, 50, 30),
(11, 1, 50, 31),
(12, 2, 50, 32),
(13, 1, 50, 33),
(14, 3, 50, 34),
(15, 2, 50, 35),
(16, 1, 50, 36),
(17, 3, 50, 37),
(18, 2, 50, 38),
(19, 1, 50, 39),
(20, 3, 50, 40);

INSERT INTO PaymentMethod (name) VALUES
('Credit Card'),
('PayPal'),
('Cash');

INSERT INTO Payment (paymentDate, paymentTime, totalPrice, userId, addressId, bookingId, methodId) VALUES
('2024-10-15', '18:30:00', 10.00, 1, 1, 1, 1),
('2024-10-16', '19:45:00', 20.00, 2, 2, 2, 2),
('2024-10-17', '20:30:00', 8.00, 3, 3, 3, 3),
('2024-10-18', '14:00:00', 15.00, 1, 1, 4, 1),
('2024-10-19', '16:15:00', 25.00, 2, 2, 5, 2),
('2024-10-20', '17:30:00', 12.00, 3, 3, 6, 3),
('2024-10-21', '15:00:00', 30.00, 1, 1, 7, 1),
('2024-10-22', '18:45:00', 22.50, 2, 2, 8, 2),
('2024-10-23', '20:00:00', 10.50, 3, 3, 9, 3),
('2024-10-24', '14:30:00', 28.00, 1, 1, 10, 1),
('2024-10-25', '16:00:00', 18.75, 2, 2, 11, 2),
('2024-10-26', '19:15:00', 9.99, 3, 3, 12, 3),
('2024-10-27', '21:00:00', 14.99, 1, 1, 13, 1);

INSERT INTO News (imageURL, header, content) VALUES
('gotham_news.jpg', 'New Batman Movie Showing', 'Join us for the latest Batman movie screening at Gotham Cinema!'),
('hollywood_news.jpg', 'Spider-Man Marathon', 'Enjoy a Spider-Man marathon at Hollywood Stars Cinema this weekend.'),
('empire_news.jpg', 'Iron Man Reboot', 'Catch the Iron Man reboot at Empire Cinema with new special effects.'),
('horror_fest_news.jpg', 'Halloween Horror Fest', 'Join us for the Halloween Horror Fest featuring classic and new horror films all month long!'),
('animation_news.jpg', 'Animation Showcase', 'Don’t miss our Animation Showcase next week featuring beloved animated films and shorts!'),
('poster_starWars6.jpg', 'Star Wars Day Celebration', 'Celebrate Star Wars Day with special screenings, trivia, and themed events at our cinema!'),
('comedy_night_news.jpg', 'Comedy Night with Top Comedians', 'Join us for a night of laughs with top comedians performing live at the cinema next Saturday!'),
('documentary_news.jpg', 'New Documentary Series', 'Check out our new documentary series exploring the world’s most fascinating cultures!');

INSERT INTO MovieGenre (movieId, genreId) VALUES
(1, 1),  -- The Dark Knight -> Action
(1, 2),  -- The Dark Knight -> Drama
(2, 1),  -- Spider-Man: No Way Home -> Action
(2, 3),  -- Spider-Man: No Way Home -> Sci-Fi
(3, 1),  -- Iron Man -> Action
(3, 3),  -- Iron Man -> Sci-Fi
(4, 3),  -- Interstellar -> Sci-Fi
(4, 2),  -- Interstellar -> Drama
(5, 5),  -- Andre Rieu -> Music
(5, 6),  -- Andre Rieu -> Documentary
(6, 4),  -- En Panda i Afrika -> Animation
(6, 7),  -- En Panda i Afrika -> Family
(7, 2),  -- The Apprentice -> Drama
(8, 1),  -- Deadpool -> Action
(8, 8),  -- Deadpool -> Comedy
(9, 2),  -- It Ends with Us -> Drama
(9, 9),  -- It Ends with Us -> Romance
(10, 3),  -- Robot -> Sci-Fi
(10, 1),  -- Robot -> Action
(11, 2),  -- Joker -> Drama
(11, 10),  -- Joker -> Thriller
(12, 11),  -- Føreren og Forføreren -> Biography
(12, 12),  -- Føreren og Forføreren -> History
(13, 4),  -- Minions -> Animation
(13, 7),  -- Minions -> Family
(14, 3),  -- Star Wars: Episode V -> Sci-Fi
(14, 1),  -- Star Wars: Episode V -> Action
(15, 3),  -- Star Wars: Episode VI -> Sci-Fi
(15, 1),  -- Star Wars: Episode VI -> Action
(16, 3),  -- Guardians of the Multiverse -> Sci-Fi
(16, 1),  -- Guardians of the Multiverse -> Action
(17, 3),  -- Space Explorers -> Sci-Fi
(17, 13),  -- Space Explorers -> Adventure
(18, 3),  -- The Time Jumper -> Sci-Fi
(18, 2),  -- The Time Jumper -> Drama
(19, 3),  -- AI: Awakening -> Sci-Fi
(19, 10),  -- AI: Awakening -> Thriller
(20, 1),  -- Rise of the Phoenix -> Action
(20, 13);  -- Rise of the Phoenix -> Fantasy


INSERT INTO MovieDirector (movieId, directorId) VALUES
(1, 1),  -- The Dark Knight -> Christopher Nolan
(2, 2),  -- Spider-Man: No Way Home -> Jon Watts
(3, 3),  -- Iron Man -> Jon Favreau
(4, 1),  -- Interstellar -> Christopher Nolan
(5, 4),  -- Andre Rieu -> Michael Williams
(6, 5),  -- En Panda i Afrika -> Emil Johnsen
(7, 6),  -- The Apprentice -> Alex Garland
(8, 7),  -- Deadpool -> Tim Miller
(9, 8),  -- It Ends with Us -> Justin Baldoni
(10, 9),  -- Robot -> Michael Bay
(11, 10),  -- Joker -> Todd Phillips
(12, 11), -- Føreren og Forføreren -> Søren Kragh-Jacobsen
(13, 12),  -- Minions -> Pierre Coffin
(14, 13),  -- Star Wars: Episode V -> Irvin Kershner
(15, 14),  -- Star Wars: Episode VI -> Richard Marquand
(16, 15),  -- Guardians of the Multiverse -> James Gunn
(17, 16),  -- Space Explorers: The Next Journey -> Denis Villeneuve
(18, 1),  -- The Time Jumper -> Christopher Nolan
(19, 6),  -- AI: Awakening -> Alex Garland
(20, 17);  -- Rise of the Phoenix -> Zack Snyder

INSERT INTO MovieActor (movieId, actorId) VALUES
(1, 1),  -- The Dark Knight -> Christian Bale
(2, 2),  -- Spider-Man: No Way Home -> Tom Holland
(3, 3),  -- Iron Man -> Robert Downey Jr.
(4, 4),  -- Interstellar -> Matthew McConaughey
(5, 5),  -- Andre Rieu -> Andre Rieu
(6, 6),  -- En Panda i Afrika -> Johan Carlsson
(7, 7),  -- The Apprentice -> Anya Taylor-Joy
(8, 8),  -- Deadpool -> Ryan Reynolds
(9, 9),  -- It Ends with Us -> Blake Lively
(10, 10),  -- Robot -> Shia LaBeouf
(11, 11),  -- Joker -> Joaquin Phoenix
(12, 12),  -- Føreren og Forføreren -> Ulrich Thomsen
(13, 12),  -- Minions -> Pierre Coffin
(14, 13),  -- Star Wars: Episode V -> Mark Hamill
(15, 13),  -- Star Wars: Episode VI -> Mark Hamill
(16, 14),  -- Guardians of the Multiverse -> Chris Pratt
(17, 15),  -- Space Explorers: The Next Journey -> Zendaya
(18, 16),  -- The Time Jumper -> Jake Gyllenhaal
(19, 17),  -- AI: Awakening -> Oscar Isaac
(20, 18);  -- Rise of the Phoenix -> Henry Cavill

INSERT INTO VenueShowing (venueId, showingId) VALUES
(1, 1),  -- Gotham Cinema -> Showing of The Dark Knight
(1, 2),  -- Gotham Cinema -> Showing of Spider-Man: No Way Home
(1, 3),  -- Gotham Cinema -> Showing of Iron Man
(2, 4),  -- Hollywood Stars Cinema -> Showing of Inception
(2, 5),  -- Hollywood Stars Cinema -> Showing of The Matrix
(2, 6),  -- Hollywood Stars Cinema -> Showing of John Wick
(3, 7),  -- Empire Cinema -> Showing of Avengers: Endgame
(3, 8),  -- Empire Cinema -> Showing of Black Panther
(3, 9),  -- Empire Cinema -> Showing of Doctor Strange
(1, 10), -- Regal Cinema -> Showing of Interstellar
(1, 11), -- Regal Cinema -> Showing of Dunkirk
(1, 12), -- Regal Cinema -> Showing of Tenet
(2, 13), -- Cineplex -> Showing of The Lord of the Rings
(2, 14), -- Cineplex -> Showing of The Hobbit
(2, 15), -- Cineplex -> Showing of Harry Potter and the Sorcerer's Stone
(3, 16), -- Paramount Theatre -> Showing of The Lion King
(3, 17), -- Paramount Theatre -> Showing of Frozen
(3, 18), -- Paramount Theatre -> Showing of Beauty and the Beast
(1, 19), -- IMAX Theatre -> Showing of Avatar
(1, 20), -- IMAX Theatre -> Showing of Dune
(1, 21), -- IMAX Theatre -> Showing of Star Wars: The Force Awakens
(2, 22), -- Odeon -> Showing of Jurassic Park
(2, 23), -- Odeon -> Showing of Jurassic World
(2, 24), -- Odeon -> Showing of Pacific Rim
(3, 25), -- AMC Cinemas -> Showing of The Batman
(3, 26), -- AMC Cinemas -> Showing of Joker
(3, 27), -- AMC Cinemas -> Showing of Venom
(1, 28), -- Alamo Drafthouse -> Showing of Mad Max: Fury Road
(1, 29), -- Alamo Drafthouse -> Showing of The Revenant
(1, 30), -- Alamo Drafthouse -> Showing of The Hateful Eight
(2, 31),  -- Gotham Cinema -> Showing of Deadpool
(2, 32),  -- Hollywood Stars Cinema -> Showing of Logan
(2, 33),  -- Empire Cinema -> Showing of The Wolverine
(3, 34),  -- Regal Cinema -> Showing of Fantastic Beasts
(3, 35),  -- Cineplex -> Showing of Wonder Woman
(3, 36),  -- Paramount Theatre -> Showing of Aquaman
(1, 37),  -- IMAX Theatre -> Showing of The Suicide Squad
(1, 38),  -- Odeon -> Showing of Guardians of the Galaxy
(1, 39),  -- AMC Cinemas -> Showing of Thor: Ragnarok
(2, 40), -- Alamo Drafthouse -> Showing of The Irishman
(2, 41),  -- Gotham Cinema -> Showing of The Godfather
(2, 42),  -- Hollywood Stars Cinema -> Showing of Pulp Fiction
(3, 43),  -- Empire Cinema -> Showing of Fight Club
(3, 44),  -- Regal Cinema -> Showing of Goodfellas
(3, 45),  -- Cineplex -> Showing of The Shawshank Redemption
(1, 46),  -- Paramount Theatre -> Showing of Schindler's List
(1, 47),  -- IMAX Theatre -> Showing of Blade Runner 2049
(1, 48),  -- Odeon -> Showing of The Fifth Element
(2, 49),  -- AMC Cinemas -> Showing of The Prestige
(2, 50), -- Alamo Drafthouse -> Showing of The Departed
(1, 84),  -- Venue ID 1 -> Showing ID 84
(1, 85),  -- Venue ID 1 -> Showing ID 85
(2, 86),  -- Venue ID 2 -> Showing ID 86
(2, 87),  -- Venue ID 2 -> Showing ID 87
(1, 88),  -- Venue ID 1 -> Showing ID 88
(2, 89),  -- Venue ID 2 -> Showing ID 89
(1, 90),  -- Venue ID 1 -> Showing ID 90
(2, 91),  -- Venue ID 2 -> Showing ID 91
(1, 92),  -- Venue ID 1 -> Showing ID 92
(2, 93),  -- Venue ID 2 -> Showing ID 93

(1, 94),  -- Venue ID 1 -> Showing ID 94
(1, 95),  -- Venue ID 1 -> Showing ID 95
(2, 96),  -- Venue ID 2 -> Showing ID 96
(2, 97),  -- Venue ID 2 -> Showing ID 97
(1, 98),  -- Venue ID 1 -> Showing ID 98
(2, 99),  -- Venue ID 2 -> Showing ID 99
(1, 100), -- Venue ID 1 -> Showing ID 100
(2, 101), -- Venue ID 2 -> Showing ID 101
(1, 102), -- Venue ID 1 -> Showing ID 102
(2, 103), -- Venue ID 2 -> Showing ID 103

(1, 104), -- Venue ID 1 -> Showing ID 104
(1, 105), -- Venue ID 1 -> Showing ID 105
(2, 106), -- Venue ID 2 -> Showing ID 106
(2, 107), -- Venue ID 2 -> Showing ID 107
(1, 108), -- Venue ID 1 -> Showing ID 108
(2, 109), -- Venue ID 2 -> Showing ID 109
(1, 110), -- Venue ID 1 -> Showing ID 110
(2, 111), -- Venue ID 2 -> Showing ID 111
(1, 112), -- Venue ID 1 -> Showing ID 112
(2, 113), -- Venue ID 2 -> Showing ID 113

(1, 114), -- Venue ID 1 -> Showing ID 114
(1, 115), -- Venue ID 1 -> Showing ID 115
(2, 116), -- Venue ID 2 -> Showing ID 116
(2, 117), -- Venue ID 2 -> Showing ID 117
(1, 118), -- Venue ID 1 -> Showing ID 118
(2, 119), -- Venue ID 2 -> Showing ID 119
(3, 120), -- Venue ID 3 -> Showing ID 120
(3, 121), -- Venue ID 3 -> Showing ID 121
(3, 122), -- Venue ID 3 -> Showing ID 122
(3, 123), -- Venue ID 3 -> Showing ID 123

(3, 124), -- Venue ID 3 -> Showing ID 124
(3, 125), -- Venue ID 3 -> Showing ID 125
(3, 126), -- Venue ID 3 -> Showing ID 126
(3, 127), -- Venue ID 3 -> Showing ID 127
(3, 128); -- Venue ID 3 -> Showing ID 128


INSERT INTO VenueOpeningHour (venueId, openingHourId) VALUES
(1, 1),  -- Gotham Cinema -> Monday's opening hours
(2, 2),  -- Hollywood Stars Cinema -> Tuesday's opening hours
(3, 3);  -- Empire Cinema -> Wednesday's opening hours
