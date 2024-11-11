INSERT INTO PostalCode (postalCode, city) VALUES
(60606, 'Chicago'),
(90210, 'Beverly Hills'),
(10001, 'New York'),
(94105, 'San Francisco'),
(33101, 'Miami'),
(20001, 'Washington D.C.'),
(75201, 'Dallas'),
(30301, 'Atlanta'),
(98101, 'Seattle'),
(85001, 'Phoenix'),
(60611, 'Chicago'),
(45202, 'Cincinnati'),
(68102, 'Omaha'),
(75219, 'Dallas'),
(94109, 'San Francisco'),
(80202, 'Denver'),
(70112, 'New Orleans'),
(33133, 'Miami'),
(10018, 'New York'),
(90001, 'Los Angeles'),
(98052, 'Redmond'),
(94103, 'San Francisco'),
(95112, 'San Jose'),
(20005, 'Washington D.C.'),
(98109, 'Seattle'),
(95129, 'San Jose'),
(90045, 'Los Angeles'),
(77002, 'Houston'),
(75204, 'Dallas'),
(33130, 'Miami'),
(85251, 'Scottsdale'),
(73301, 'Austin');

INSERT INTO Address (street, streetNr, postalCodeId) VALUES
('Wayne Tower', '100', 1),
('Rodeo Drive', '222', 2),
('Queens Blvd', '15', 3),
('Elizabeth Tower', '200', 5),
('Gotham St', '101', 9),
('Sunset Blvd', '305', 7),
('Central Park Ave', '505', 20),
('Hollywood Dr', '75', 14),
('Lexington Ave', '129', 1),
('Fifth Ave', '222', 2),
('Park Ave', '550', 21),
('Main St', '33', 17),
('Broadway', '45', 1),
('Elm St', '12', 3),
('Madison Ave', '367', 1),
('Beverly Hills Rd', '900', 2),
('King St', '17', 3),
('River Rd', '68', 4),
('Sunset Ridge', '102', 5),
('Pine St', '88', 6),
('Oakwood Dr', '77', 7),
('Lakeshore Blvd', '53', 8),
('Bridge St', '124', 10),
('Maple Ave', '99', 9),
('Mountain View Rd', '67', 11),
('Willow Dr', '150', 11),
('Kingston Ave', '50', 12),
('Redwood Dr', '120', 12),
('Chestnut St', '210', 13),
('Cedar Ave', '330', 13),
('Shady Lane', '75', 21),
('Birchwood Dr', '88', 13),
('Lincoln Rd', '199', 14),
('Ashford Ave', '11', 12),
('Crescent Dr', '144', 14),
('Linden St', '81', 15),
('Highland Ave', '200', 16),
('Ocean Blvd', '59', 16),
('Canyon Rd', '25', 17),
('Harrison St', '90', 18),
('Parkway Dr', '42', 3),
('Rosewood Ln', '33', 19),
('Hickory St', '150', 20),
('Magnolia Ave', '212', 13),
('Thornhill Rd', '77', 17),
('Summit Dr', '129', 18),
('Westfield Blvd', '66', 3),
('Valley Forge Rd', '305', 1),
('Pinehurst Ln', '10', 2),
('Silver Lake Rd', '89', 3),
('Bayview Ave', '77', 1),
('Springfield Dr', '44', 2),
('Lakeview Rd', '150', 15),
('Broadway Ave', '211', 14),
('Beach Dr', '199', 20),
('Willow Springs Rd', '25', 17),
('Cedarwood Blvd', '34', 20),
('Greenhill Rd', '170', 19),
('Seaview Ave', '88', 3),
('Birchwood Rd', '129', 1),
('Sunshine Blvd', '45', 2),
('Brighton Ave', '99', 3),
('Silverstone Rd', '210', 1),
('Westend Ave', '85', 2),
('Oak Grove Rd', '303', 3),
('Diamond St', '20', 1),
('Fireside Ave', '77', 2),
('Goldstone Blvd', '105', 3),
('Clearwater Rd', '65', 1),
('Ironwood Dr', '108', 2),
('Riverside Ave', '140', 3),
('Bayshore Blvd', '213', 1),
('Cypress Dr', '79', 2),
('Shadow Ridge Rd', '60', 3),
('Sequoia Ave', '250', 18),
('Heritage Ln', '120', 2),
('Woodland Dr', '190', 3),
('Alpine Rd', '89', 19),
('Dawn Dr', '22', 21),
('Grandview Ave', '110', 3),
('Royal Ave', '75', 10),
('King’s Rd', '102', 2),
('Parkview Dr', '67', 3),
('Hilltop Ave', '44', 1),
('Willowbrook Rd', '213', 22),
('Acorn Dr', '39', 3),
('Oceanview Rd', '83', 1),
('Forest Rd', '56', 2),
('Hillside Blvd', '78', 3),
('Misty Rd', '101', 1),
('Falcon Ridge Rd', '213', 2),
('Seabreeze Blvd', '34', 3),
('Bluebell Dr', '60', 1),
('Morningstar Rd', '113', 2),
('Sunset Park Ave', '87', 3),
('Fox Run Rd', '99', 27),
('Heron Lane', '129', 28),
('Ponderosa Dr', '53', 29),
('Shoreline Rd', '188', 1),
('Stonegate Blvd', '74', 24),
('White Oak Dr', '35', 23),
('Golden Gate Rd', '300', 1),
('Oasis Blvd', '99', 24),
('Misty Pines Rd', '58', 30),
('Coral Rd', '211', 11),
('Eastview Ave', '66', 25),
('Palisade Dr', '120', 30),
('Sierra Ave', '180', 1),
('Cinnamon Blvd', '212', 25),
('Sunrise Rd', '48', 31),
('Ocean Breeze Rd', '115', 19),
('Riverbend Ave', '77', 26),
('Shadowbrook Rd', '99', 30),
('Autumn Rd', '225', 26),
('Glenwood Blvd', '63', 28),
('Brookstone Rd', '80', 28),
('Cascadia Rd', '95', 10);

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
('Monday', '09:00:00', '21:00:00', FALSE),
('Monday', '11:00:00', '22:00:00', FALSE),
('Tuesday', '09:00:00', '23:00:00', TRUE),
('Tuesday', '10:00:00', '23:00:00', FALSE),
('Tuesday', '12:00:00', '23:30:00', FALSE),
('Wednesday', '10:30:00', '23:30:00', TRUE),
('Wednesday', '10:00:00', '23:00:00', FALSE),
('Wednesday', '11:00:00', '23:30:00', FALSE),
('Thursday', '13:30:00', '22:30:00', TRUE),
('Thursday', '14:00:00', '23:00:00', FALSE),
('Thursday', '11:30:00', '23:30:00', FALSE),
('Friday', '08:00:00', '23:30:00', TRUE),
('Friday', '09:00:00', '23:00:00', FALSE),
('Friday', '10:00:00', '23:30:00', FALSE),
('Saturday', '12:00:00', '23:00:00', TRUE),
('Saturday', '11:00:00', '23:30:00', FALSE),
('Saturday', '13:00:00', '23:00:00', FALSE),
('Sunday', '13:00:00', '23:30:00', TRUE),
('Sunday', '14:00:00', '23:00:00', FALSE),
('Sunday', '11:30:00', '23:30:00', FALSE);

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
('Admin', 'Admin', '2000-01-01', 'admin@admin.com', '$2y$10$Xt53U6KwhZ34mwbsdgVNjetv998rgpvqQ9xMAa4EzwTfH9X2zElK2', 1),
('Bruce', 'Wayne', '1972-02-19', 'bruce@gotham.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Clark', 'Kent', '1980-06-18', 'clark@metropolis.com', '$2y$12$xtMIYcE8psaLxr9Yo57.OB7a1V.RmtuRlTwF2xlcTtBZY0tP1.F2S', 2),
('Diana', 'Prince', '1985-03-20', 'diana@themyscira.com', '$2y$12$Kd8.SOVpFw.T3keqstWh4ujFP4RkADtIkRE7xWTG8U8Uy73mZsmc7', 2),
('Barry', 'Allen', '1992-02-28', 'barry@centralcity.com', '$2y$12$Kd8.SOVpFw.T3keqstWh4ujFP4RkADtIkRE7xWTG8U8Uy73mZsmc7', 2),
('Hal', 'Jordan', '1984-08-05', 'hal@coastcity.com', '$2y$12$Kd8.SOVpFw.T3keqstWh4ujFP4RkADtIkRE7xWTG8U8Uy73mZsmc7', 2),
('Arthur', 'Curry', '1990-07-12', 'arthur@atlantis.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Wally', 'West', '1995-05-22', 'wally@centralcity.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('John', 'Stewart', '1982-11-07', 'john@earth.com', '$2y$12$Kd8.SOVpFw.T3keqstWh4ujFP4RkADtIkRE7xWTG8U8Uy73mZsmc7', 2),
('Oliver', 'Queen', '1978-09-07', 'oliver@starcity.com', '$2b$12$WkUVf.D2Pckd01mjJ2eHe.QC2.s5V8vtoC1P.x5wV8wDWGV8gtXCa', 2),
('Ray', 'Palmer', '1980-10-18', 'ray@nanotech.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Kara', 'Zor-El', '1993-01-15', 'kara@kryptonian.com', '$2b$12$ihn71cIZV85A.nlh8T/7POb1gJ/tBRQW1S2F1kcVsZ4El4X9XYtym', 2),
('Kate', 'Kane', '1985-03-01', 'kate@batwoman.com', '$2y$12$Kd8.SOVpFw.T3keqstWh4ujFP4RkADtIkRE7xWTG8U8Uy73mZsmc7', 2),
('Barbara', 'Gordon', '1992-06-23', 'barbara@gotham.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Jason', 'Todd', '1990-08-10', 'jason@gotham.com', '$2b$12$ihn71cIZV85A.nlh8T/7POb1gJ/tBRQW1S2F1kcVsZ4El4X9XYtym', 2),
('Tim', 'Drake', '1995-04-12', 'tim@gotham.com', '$2b$12$ihn71cIZV85A.nlh8T/7POb1gJ/tBRQW1S2F1kcVsZ4El4X9XYtym', 2),
('Dick', 'Grayson', '1980-03-20', 'dick@bludhaven.com', '$2b$12$ihn71cIZV85A.nlh8T/7POb1gJ/tBRQW1S2F1kcVsZ4El4X9XYtym', 2),
('Zatanna', 'Zatara', '1985-06-11', 'zatanna@magic.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Vixen', 'Mari McCabe', '1988-11-12', 'vixen@earth.com', '$2b$12$ihn71cIZV85A.nlh8T/7POb1gJ/tBRQW1S2F1kcVsZ4El4X9XYtym', 2),
('Black', 'Adam', '1985-12-05', 'adam@kahndaq.com', '$2b$12$ihn71cIZV85A.nlh8T/7POb1gJ/tBRQW1S2F1kcVsZ4El4X9XYtym', 2),
('Hawkgirl', 'Shiera Hall', '1990-03-22', 'hawkgirl@thanagar.com', '$2b$12$ihn71cIZV85A.nlh8T/7POb1gJ/tBRQW1S2F1kcVsZ4El4X9XYtym', 2),
('Green', 'Lantern', '1990-02-14', 'lantern@earth.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Caitlin', 'Snow', '1992-09-04', 'caitlin@centralcity.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Cisco', 'Ramon', '1991-08-15', 'cisco@centralcity.com', '$2y$12$Kd8.SOVpFw.T3keqstWh4ujFP4RkADtIkRE7xWTG8U8Uy73mZsmc7', 2),
('Harrison', 'Wells', '1975-05-17', 'harrison@centralcity.com', '$2b$12$ihn71cIZV85A.nlh8T/7POb1gJ/tBRQW1S2F1kcVsZ4El4X9XYtym', 2),
('Jesse', 'Quick', '1993-12-29', 'jesse@centralcity.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Terry', 'McGinnis', '2000-06-28', 'terry@gotham.com', '$2b$12$ihn71cIZV85A.nlh8T/7POb1gJ/tBRQW1S2F1kcVsZ4El4X9XYtym', 2),
('Jean', 'Grey', '1990-11-12', 'jean@xmen.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Cyclops', 'Scott Summers', '1985-06-20', 'scott@xmen.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Beast', 'Henry McCoy', '1988-05-03', 'henry@xmen.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Wolverine', 'Logan', '1973-01-02', 'logan@xmen.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Storm', 'Ororo Munroe', '1982-11-17', 'ororo@xmen.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Rogue', 'Anna Marie', '1990-01-12', 'anna@xmen.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Gambit', 'Remy LeBeau', '1987-10-15', 'remy@xmen.com', '$2y$12$Kd8.SOVpFw.T3keqstWh4ujFP4RkADtIkRE7xWTG8U8Uy73mZsmc7', 2),
('Professor', 'Charles Xavier', '1972-05-10', 'charles@xmen.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Nightcrawler', 'Kurt Wagner', '1993-03-01', 'kurt@xmen.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Emma', 'Frost', '1985-03-02', 'emma@xmen.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Mystique', 'Raven Darkhölme', '1983-08-04', 'raven@xmen.com', '$2b$12$ihn71cIZV85A.nlh8T/7POb1gJ/tBRQW1S2F1kcVsZ4El4X9XYtym ', 2),
('Magneto', 'Erik Lensherr', '1975-12-16', 'erik@xmen.com', '$2y$12$Kd8.SOVpFw.T3keqstWh4ujFP4RkADtIkRE7xWTG8U8Uy73mZsmc7', 2),
('Deadpool', 'Wade Wilson', '1988-07-15', 'wade@xmen.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('X-23', 'Laura Kinney', '2005-02-12', 'laura@xmen.com', '$2b$12$ihn71cIZV85A.nlh8T/7POb1gJ/tBRQW1S2F1kcVsZ4El4X9XYtym ', 2),
('Silver', 'Sam Guthrie', '1989-05-07', 'sam@xmen.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Bishop', 'Lucas Bishop', '1985-12-31', 'lucas@xmen.com', '$2b$12$ihn71cIZV85A.nlh8T/7POb1gJ/tBRQW1S2F1kcVsZ4El4X9XYtym ', 2),
('Cable', 'Nathan Summers', '1990-01-01', 'nathan@xmen.com', '$2b$12$ihn71cIZV85A.nlh8T/7POb1gJ/tBRQW1S2F1kcVsZ4El4X9XYtym', 2),
('Maggie', 'Sawyer', '1983-06-30', 'maggie@supergirl.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('Lena', 'Luthor', '1992-11-28', 'lena@supergirl.com', '$2b$12$ihn71cIZV85A.nlh8T/7POb1gJ/tBRQW1S2F1kcVsZ4El4X9XYtym ', 2),
('Supergirl', 'Kara Zor-El', '1995-05-15', 'kara@supergirl.com', '$2b$12$ihn71cIZV85A.nlh8T/7POb1gJ/tBRQW1S2F1kcVsZ4El4X9XYtym ', 2),
('Alex', 'Danvers', '1990-12-06', 'alex@supergirl.com', '$2b$12$ihn71cIZV85A.nlh8T/7POb1gJ/tBRQW1S2F1kcVsZ4El4X9XYtym ', 2),
('Jonn', 'Jonzz', '1965-08-23', 'jon@supergirl.com', '$2y$12$Kd8.SOVpFw.T3keqstWh4ujFP4RkADtIkRE7xWTG8U8Uy73mZsmc7', 2),
('Win', 'Schott', '1988-04-04', 'win@supergirl.com', '$2y$12$Fv/Jfv0Ih5hgDb9cB9EJkRsd5w8CZWxvxgD8yxFdOTxjMOjFbr5u', 2),
('James', 'Olsen', '1991-11-19', 'james@supergirl.com', '$2b$12$ihn71cIZV85A.nlh8T/7POb1gJ/tBRQW1S2F1kcVsZ4El4X9XYtym ', 2),
('Mantis', 'Empath', '1990-11-15', 'mantis@guardians.com', NULL, 2),
('Korg', 'The Kronan', '1995-09-23', 'korg@asgard.com', NULL, 2),
('Valkyrie', 'Asgardian', '1983-10-10', 'valkyrie@asgard.com', NULL, 2),
('Shang', 'Chi', '1995-03-10', 'shang@chi.com', NULL, 2),
('Wong', 'Doctor', '1980-10-02', 'wong@doctorstrange.com', NULL, 2),
('Doctor', 'Strange', '1980-11-18', 'doctor@strange.com', NULL, 2),
('Black', 'Widow', '1984-11-22', 'blackwidow@avengers.com', NULL, 2),
('Captain', 'Marvel', '1986-09-17', 'captainmarvel@marvel.com', NULL, 2),
('Ant', 'Man', '1982-09-14', 'antman@marvel.com', NULL, 2),
('The', 'Wasps', '1985-04-13', 'thewasp@marvel.com', NULL, 2),
('Hank', 'Pym', '1950-06-25', 'hank@pym.com', NULL, 2),
('Janet', 'Van Dyne', '1952-10-20', 'janet@vandynes.com', NULL, 2),
('Kate', 'Parker', '1991-06-04', 'kate@parker.com', NULL, 2),
('Miles', 'Morales', '2000-12-22', 'miles@morales.com', NULL, 2),
('Ben', 'Parker', '1965-06-04', 'ben@parker.com', NULL, 2),
('Mary', 'Jane', '1990-03-13', 'mary@jane.com', NULL, 2),
('J. Jonah', 'Jameson', '1950-04-15', 'jonah@dailybugle.com', NULL, 2),
('Norman', 'Osborn', '1954-12-25', 'norman@osbornindustries.com', NULL, 2),
('Harry', 'Osborn', '1980-08-22', 'harry@osbornindustries.com', NULL, 2),
('Otto', 'Octavius', '1965-11-06', 'otto@octavius.com', NULL, 2),
('Max', 'Dillon', '1970-04-23', 'max@dillon.com', NULL, 2),
('Electro', 'Electro', '1971-02-14', 'electro@villain.com', NULL, 2),
('Flint', 'Marko', '1981-06-10', 'flint@villain.com', NULL, 2),
('Green', 'Goblin', '1954-12-25', 'green@villain.com', NULL, 2),
('Venom', 'Symbiote', '1990-11-23', 'venom@symbiote.com', NULL, 2),
('Carnage', 'Carnage', '1991-09-16', 'carnage@villain.com', NULL, 2),
('Rhino', 'Rhino', '1977-02-16', 'rhino@villain.com', NULL, 2),
('Sand', 'Man', '1967-03-19', 'sandman@villain.com', NULL, 2),
('Mysterio', 'Mysterio', '1985-07-11', 'mysterio@villain.com', NULL, 2),
('Kraven', 'The Hunter', '1988-09-10', 'kraven@hunter.com', NULL, 2),
('Vulture', 'Vulture', '1960-06-30', 'vulture@villain.com', NULL, 2),
('Doctor', 'Doom', '1971-10-14', 'doom@latveria.com', NULL, 2),
('Magneto', 'Magneto', '1935-06-10', 'magneto@xmen.com', NULL, 2),
('Professor', 'X', '1930-02-22', 'professorx@xmen.com', NULL, 2),
('Cyclops', 'Scott Summers', '1980-05-16', 'cyclops@xmen.com', NULL, 2),
('Wolverine', 'Logan', '1925-10-25', 'wolverine@xmen.com', NULL, 2),
('Storm', 'Ororo Munroe', '1982-08-07', 'storm@xmen.com', NULL, 2),
('Beast', 'Henry McCoy', '1970-12-15', 'beast@xmen.com', NULL, 2),
('Jean', 'Grey', '1982-11-07', 'jeangrey@xmen.com', NULL, 2),
('Rogue', 'Anna Marie', '1983-01-15', 'rogue@xmen.com', NULL, 2),
('Gambit', 'Remy LeBeau', '1986-03-09', 'gambit@xmen.com', NULL, 2),
('Iceman', 'Bobby Drake', '1984-02-10', 'iceman@xmen.com', NULL, 2),
('Colossus', 'Piotr Rasputin', '1984-11-18', 'colossus@xmen.com', NULL, 2),
('Nightcrawler', 'Kurt Wagner', '1990-03-19', 'nightcrawler@xmen.com', NULL, 2),
('Kitty', 'Pryde', '1989-12-25', 'kitty@xmen.com', NULL, 2),
('Emma', 'Frost', '1980-04-21', 'emma@frost.com', NULL, 2),
('Mystique', 'Raven Darkhölme', '1975-11-05', 'mystique@xmen.com', NULL, 2),
('Silver', 'Samurai', '1993-05-02', 'silver@samurai.com', NULL, 2),
('Deadpool', 'Wade Wilson', '1984-02-25', 'deadpool@xmen.com', NULL, 2),
('Clark', 'Kent', '1980-02-29', 'clark@dailyplanet.com', '$2a$12$6RivwA1dH6Yh0RpA4tXFuW4GoFdFlFbmkAgPXYi5yTwgM8ZFbvm.a', 3),
('Admin', 'Admin', '1980-01-01', 'adminadmin@example.com', '$2a$12$yA3fjKkOWv9nZT7u6reRa.WQKYFw6fH5uPtYq4ahmQkdF4JdFkgda', 1);

INSERT INTO Movie (title, description, duration, language, releaseDate, posterURL, promoURL, trailerURL, rating) VALUES
('The Dark Knight', 'Batman faces the Joker in Gotham City.', 152, 'English', '2008-07-18', 'poster_dark_knight.jpg', 'promo_dark_knight.mp4', 'EXeTwQWrcwY', 9.00),
('Spider-Man: No Way Home', 'Peter Parker deals with multiverse villains.', 148, 'English', '2021-12-17', 'poster_spiderman.jpg', 'promo_spiderman.mp4', 'JfVOs4VSpmA', 8.50),
('Iron Man', 'Tony Stark becomes the armored superhero.', 126, 'English', '2008-05-02', 'poster_ironman.jpg', 'promo_ironman.mp4', '8ugaeA-nMTc', 8.70),
('Interstellar', 'A team of explorers travel through a wormhole in space to ensure humanity’s survival.', 169, 'English', '2014-11-07', 'poster_interstellar.jpg', 'promo_interstellar.mp4', 'zSWdZVtXT7E', 8.60),
('Andre Rieu', 'The renowned violinist and conductor captivates audiences with his classical music performances.', 120, 'English', '2020-10-10', 'poster_andrerieu.jpg', 'promo_andrerieu.mp4', 'el7JKURuIZI', 8.30),
('En Panda i Afrika', 'An animated adventure about a panda\'s journey to Africa, filled with humor and life lessons.', 95, 'Danish', '2023-02-14', 'poster_enpandaiafrika.jpg', 'promo_enpandaiafrika.mp4', '_VJ2A1iFnGk', 7.20),
('The Apprentice', 'A young woman navigates the challenges of her apprenticeship in a competitive business environment.', 110, 'English', '2018-06-25', 'poster_apprentice.jpg', 'promo_apprentice.mp4', 'Y3jeNId-b48', 7.80),
('Deadpool', 'A mercenary with accelerated healing powers seeks revenge while delivering sarcastic humor.', 108, 'English', '2016-02-12', 'poster_deadpool.jpg', 'promo_deadpool.mp4', 'Idh8n5XuYIA', 8.00),
('It Ends with Us', 'A gripping love story, where difficult decisions must be made in the face of adversity.', 120, 'English', '2024-03-08', 'poster_itendswithus.jpg', 'promo_itendswithus.mp4', 'DLET_u31M4M', 6.50),
('Robot', 'In a futuristic world, a humanoid robot learns about human emotions and identity.', 135, 'Hindi', '2010-10-01', 'poster_robot.jpg', 'promo_robot.mp4', 'njPNg0A9VpY', 7.10),
('Joker', 'A gritty character study of Arthur Fleck, a man disregarded by society who becomes the infamous Joker.', 122, 'English', '2019-10-04', 'poster_joker.jpg', 'promo_joker.mp4', '_OKAwz2MsJs', 8.50),
('Føreren og Forføreren', 'A biographical account of Nazi propaganda chief Joseph Goebbels and his role in the Third Reich.', 110, 'Danish', '2022-10-15', 'poster_foreren_forforeren.jpg', 'promo_foreren_forforeren.mp4', 'Yy9-qbz8Bfc', 7.5),
('Despicable me 4', 'The story of the yellow Minions as they search for a new evil master to serve.', 91, 'English', '2015-07-10', 'poster_minions.jpg', 'promo_minions.mp4', 'JnynPtxEY5M', 6.40),
('Star Wars: Episode V - The Empire Strikes Back', 'Luke Skywalker and the Rebel Alliance face the Empire\'s wrath as they plan their next move against Darth Vader.', 124, 'English', '1980-05-21', 'poster_starwars5.jpg', 'promo_starwars5.mp4', 'JnynPtxEY5M', 8.70),
('Star Wars: Episode VI - Return of the Jedi', 'The Rebel Alliance makes a final stand to defeat the Galactic Empire and save the galaxy.', 131, 'English', '1983-05-25', 'poster_starwars6.jpg', 'promo_starwars6.mp4', 'p4vIFhk621Q', 8.30),
('Guardians of the Multiverse', 'A group of unlikely heroes band together to save multiple realities from collapse.', 140, 'English', '2025-06-15', 'poster_guardians_multiverse.jpg', 'promo_guardians_multiverse.mp4', 'u3V5KDHRQvk', 8.90),
('Space Explorers: The Next Journey', 'A new generation of astronauts embarks on a mission to colonize distant planets.', 135, 'English', '2024-12-20', 'poster_space_explorers.jpg', 'promo_space_explorers.mp4', 'UMoyGKgdeo0', 8.70),
('The Time Jumper', 'A man gains the ability to travel through time, but must decide how much to alter his past.', 118, 'English', '2025-03-15', 'poster_time_jumper.jpg', 'promo_time_jumper.mp4', 'QIsjg1Sb538', 8.40),
('AI: Awakening', 'An advanced AI system becomes self-aware, leading humanity to confront new ethical dilemmas.', 128, 'English', '2024-11-05', 'poster_ai_awakening.jpg', 'promo_ai_awakening.mp4', '3CCGg6RjssE', 7.90),
('Rise of the Phoenix', 'A fallen warrior seeks redemption in a war-torn kingdom ruled by a corrupt regime.', 150, 'English', '2024-09-30', 'poster_rise_phoenix.jpg', 'promo_rise_phoenix.mp4', 'DyAsfo6rEz0', 8.50);

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

-- Actors for 'The Dark Knight' (movieId 1)
INSERT INTO Actor (firstName, lastName, `character`) VALUES
('Christian', 'Bale', 'Bruce Wayne/Batman'),
('Heath', 'Ledger', 'Joker'),
('Aaron', 'Eckhart', 'Harvey Dent/Two-Face'),
('Michael', 'Caine', 'Alfred Pennyworth'),
('Gary', 'Oldman', 'James Gordon'),
('Maggie', 'Gyllenhaal', 'Rachel Dawes'),
('Morgan', 'Freeman', 'Lucius Fox'),
('Eric', 'Roberts', 'Sal Maroni'),
('Anthony', 'Michael Hall', 'Mike Engel'),
('Nestor', 'Carbonell', 'Mayor Garcia');

-- Actors for 'Spider-Man: No Way Home' (movieId 2)
INSERT INTO Actor (firstName, lastName, `character`) VALUES
('Tom', 'Holland', 'Peter Parker/Spider-Man'),
('Zendaya', 'Coleman', 'MJ'),
('Benedict', 'Cumberbatch', 'Doctor Strange'),
('Jacob', 'Batalon', 'Ned Leeds'),
('Marisa', 'Tomei', 'May Parker'),
('Willem', 'Dafoe', 'Green Goblin/Norman Osborn'),
('Alfred', 'Molina', 'Doctor Octopus/Otto Octavius'),
('Jamie', 'Foxx', 'Electro/Max Dillon'),
('Benedict', 'Wong', 'Wong'),
('Andrew', 'Garfield', 'Peter Parker/Spider-Man (Alt)');

-- Actors for 'Iron Man' (movieId 3)
INSERT INTO Actor (firstName, lastName, `character`) VALUES
('Robert', 'Downey Jr.', 'Tony Stark/Iron Man'),
('Gwyneth', 'Paltrow', 'Pepper Potts'),
('Jeff', 'Bridges', 'Obadiah Stane/Iron Monger'),
('Terrence', 'Howard', 'James Rhodes'),
('Shaun', 'Toub', 'Yinsen'),
('Paul', 'Bettany', 'JARVIS (voice)'),
('Faran', 'Tahir', 'Raza'),
('Leslie', 'Bibb', 'Christine Everhart'),
('Clark', 'Gregg', 'Agent Phil Coulson'),
('Jon', 'Favreau', 'Happy Hogan');

INSERT IGNORE INTO Actor (firstName, lastName, `character`) VALUES
-- Interstellar (movieId 4)
('Jessica', 'Chastain', 'Murphy Cooper'),
('Casey', 'Affleck', 'Tom Cooper'),
('Mackenzie', 'Foy', 'Young Murphy'),
('Michael', 'Caine', 'Professor Brand'),
('David', 'Gyasi', 'Romilly'),

-- Andre Rieu (movieId 5)
('Sarah', 'Brightman', 'Guest Performer'),
('Richard', 'Clayderman', 'Pianist'),
('Stefanie', 'Jones', 'Violinist'),
('Klaus', 'Müller', 'Cellist'),
('Linda', 'Mason', 'Singer'),

-- En Panda i Afrika (movieId 6)
('Sofie', 'Gråbøl', 'Mama Panda'),
('Casper', 'Christensen', 'Leo the Lion'),
('Birgitte', 'Hjort Sørensen', 'Narrator'),
('Ulrich', 'Thomsen', 'Hunter'),
('Nikolaj', 'Lie Kaas', 'Guide'),

-- The Apprentice (movieId 7)
('Emma', 'Stone', 'Sarah Andrews'),
('Bradley', 'Cooper', 'Mentor Johnson'),
('Laura', 'Harrier', 'Clara White'),
('Jake', 'Johnson', 'Alex Smith'),
('Zoe', 'Kravitz', 'Assistant Manager'),

-- Deadpool (movieId 8)
('T.J.', 'Miller', 'Weasel'),
('Ed', 'Skrein', 'Ajax'),
('Stefan', 'Kapičić', 'Colossus'),
('Brianna', 'Hildebrand', 'Negasonic Teenage Warhead'),
('Leslie', 'Uggams', 'Blind Al'); 

-- Additional actors for "It Ends with Us" (movieId: 9)
INSERT INTO Actor (firstName, lastName, `character`) VALUES
('Blake', 'Lively', 'Lily Bloom'),
('Justin', 'Baldoni', 'Ryle Kincaid'),
('Brandon', 'Sklenar', 'Atlas Corrigan'),
('Scarlett', 'Johansson', 'Ally Johnson'),
('Chris', 'Evans', 'Marshall Scott'),
('Jennifer', 'Lawrence', 'Megan Rivers'),
('Henry', 'Golding', 'Dr. Lewis'),
('Emma', 'Stone', 'Samantha Porter'),
('Zac', 'Efron', 'Carter James'),
('Elizabeth', 'Olsen', 'Daphne Michaels');

-- Additional actors for "Robot" (movieId: 10)
INSERT INTO Actor (firstName, lastName, `character`) VALUES
('Rajinikanth', ' ', 'Chitti/Dr. Vaseegaran'),
('Aishwarya', 'Rai', 'Sana'),
('Danny', 'Denzongpa', 'Dr. Bohra'),
('Amy', 'Jackson', 'Nila'),
('Akshay', 'Kumar', 'Pakshi Rajan'),
('Sudhanshu', 'Pandey', 'Dr. Sebastian'),
('Robo', 'Shankar', 'Comic Relief Robot'),
('Rakul', 'Preet', 'Research Assistant'),
('Vivek', 'Oberoi', 'Professor Ashok'),
('Shruti', 'Haasan', 'AI Specialist');

-- Additional actors for "Joker" (movieId: 11)
INSERT INTO Actor (firstName, lastName, `character`) VALUES
('Joaquin', 'Phoenix', 'Arthur Fleck/Joker'),
('Robert', 'De Niro', 'Murray Franklin'),
('Zazie', 'Beetz', 'Sophie Dumond'),
('Frances', 'Conroy', 'Penny Fleck'),
('Marc', 'Maron', 'Ted Marco'),
('Brian', 'Tyree Henry', 'Clerk'),
('Brett', 'Cullen', 'Thomas Wayne'),
('Douglas', 'Hodge', 'Alfred Pennyworth'),
('Shea', 'Whigham', 'Detective Burke'),
('Bill', 'Camp', 'Detective Garrity');

-- Additional actors for "Føreren og Forføreren" (movieId: 12)
INSERT INTO Actor (firstName, lastName, `character`) VALUES
('Ulrich', 'Thomsen', 'Joseph Goebbels'),
('Trine', 'Dyrholm', 'Magda Goebbels'),
('Lars', 'Mikkelsen', 'Adolf Hitler'),
('Nikolaj', 'Lie Kaas', 'Albert Speer'),
('Birgitte', 'Hjort Sørensen', 'Eva Braun'),
('Mads', 'Mikkelsen', 'Fritz Todt'),
('Søren', 'Malling', 'Heinrich Himmler'),
('Sidse', 'Babett Knudsen', 'Elsa Kluge'),
('Nikolaj', 'Coster-Waldau', 'Propaganda Minister'),
('Pilou', 'Asbæk', 'Hans Fritzsche');

-- Additional actors for "Minions" (movieId: 13)
INSERT INTO Actor (firstName, lastName, `character`) VALUES
('Pierre', 'Coffin', 'Kevin/Stuart/Bob (voices)'),
('Sandra', 'Bullock', 'Scarlet Overkill (voice)'),
('Jon', 'Hamm', 'Herb Overkill (voice)'),
('Michael', 'Keaton', 'Walter Nelson (voice)'),
('Allison', 'Janney', 'Madge Nelson (voice)'),
('Steve', 'Carell', 'Young Gru (voice)'),
('Julie', 'Andrews', 'Gru’s Mom (voice)'),
('Jennifer', 'Saunders', 'Queen Elizabeth II (voice)'),
('Geoffrey', 'Rush', 'Narrator (voice)'),
('Chris', 'Renaud', 'Additional Minions (voice)');

-- Additional actors for "Star Wars: Episode V - The Empire Strikes Back" (movieId: 14)
INSERT INTO Actor (firstName, lastName, `character`) VALUES
('Mark', 'Hamill', 'Luke Skywalker'),
('Harrison', 'Ford', 'Han Solo'),
('Carrie', 'Fisher', 'Leia Organa'),
('Billy Dee', 'Williams', 'Lando Calrissian'),
('Anthony', 'Daniels', 'C-3PO'),
('David', 'Prowse', 'Darth Vader'),
('Frank', 'Oz', 'Yoda (voice)'),
('Alec', 'Guinness', 'Obi-Wan Kenobi'),
('Jeremy', 'Bulloch', 'Boba Fett'),
('Peter', 'Mayhew', 'Chewbacca');

-- Additional actors for "Star Wars: Episode VI - Return of the Jedi" (movieId: 15)
INSERT INTO Actor (firstName, lastName, `character`) VALUES
('Mark', 'Hamill', 'Luke Skywalker'),
('Harrison', 'Ford', 'Han Solo'),
('Carrie', 'Fisher', 'Leia Organa'),
('Ian', 'McDiarmid', 'Emperor Palpatine'),
('Billy Dee', 'Williams', 'Lando Calrissian'),
('Anthony', 'Daniels', 'C-3PO'),
('Frank', 'Oz', 'Yoda (voice)'),
('Sebastian', 'Shaw', 'Anakin Skywalker'),
('Peter', 'Mayhew', 'Chewbacca'),
('Warwick', 'Davis', 'Wicket W. Warrick');

-- Additional actors for "Guardians of the Multiverse" (movieId: 16)
INSERT INTO Actor (firstName, lastName, `character`) VALUES
('Chris', 'Pratt', 'Star-Lord'),
('Zoe', 'Saldana', 'Gamora'),
('Dave', 'Bautista', 'Drax'),
('Karen', 'Gillan', 'Nebula'),
('Bradley', 'Cooper', 'Rocket (voice)'),
('Vin', 'Diesel', 'Groot (voice)'),
('Elizabeth', 'Debicki', 'Ayesha'),
('Pom', 'Klementieff', 'Mantis'),
('Sylvester', 'Stallone', 'Stakar Ogord'),
('Tessa', 'Thompson', 'Valkyrie');

-- Additional actors for "Space Explorers: The Next Journey" (movieId: 17)
INSERT INTO Actor (firstName, lastName, `character`) VALUES
('Chris', 'Hemsworth', 'Captain Lewis'),
('Jessica', 'Chastain', 'Dr. Elena Carter'),
('Tom', 'Holland', 'Junior Engineer Martin'),
('Natalie', 'Portman', 'Navigator Reese'),
('Mahershala', 'Ali', 'Mission Commander Grant'),
('Anne', 'Hathaway', 'Biologist Taylor'),
('Idris', 'Elba', 'Security Officer Cole'),
('Florence', 'Pugh', 'Communications Specialist Anna'),
('Timothée', 'Chalamet', 'Technician Miles'),
('Viola', 'Davis', 'Mission Control Director');

-- Additional actors for "The Time Jumper" (movieId: 18)
INSERT INTO Actor (firstName, lastName, `character`) VALUES
('Jake', 'Gyllenhaal', 'Thomas Kline'),
('Emily', 'Blunt', 'Laura Knight'),
('Oscar', 'Isaac', 'Dr. Elias Morgan'),
('Michael', 'Fassbender', 'Time Hunter'),
('Jodie', 'Comer', 'Clara Rose'),
('Paul', 'Dano', 'Young Thomas'),
('Toby', 'Jones', 'The Timekeeper'),
('Ben', 'Kingsley', 'Historian Anwar'),
('Rami', 'Malek', 'Chrono Agent Lee'),
('Gugu', 'Mbatha-Raw', 'Analyst Harper');

-- Additional actors for "AI: Awakening" (movieId: 19)
INSERT INTO Actor (firstName, lastName, `character`) VALUES
('Keanu', 'Reeves', 'Dr. Marcus Hill'),
('Scarlett', 'Johansson', 'AI Unit EVE (voice)'),
('Robert', 'Downey Jr.', 'Tech CEO Jordan Cross'),
('Margot', 'Robbie', 'Programmer Vivian Kessler'),
('Bryan', 'Cranston', 'General Stanton'),
('Gemma', 'Chan', 'AI Liaison Lin'),
('Tom', 'Hiddleston', 'Cyber Investigator Adam Frost'),
('Zendaya', ' ', 'Hacker Luna'),
('Riz', 'Ahmed', 'Analyst Raj Malik'),
('Hugh', 'Laurie', 'Senator Bartholomew');

-- Additional actors for "Rise of the Phoenix" (movieId: 20)
INSERT INTO Actor (firstName, lastName, `character`) VALUES
('Henry', 'Cavill', 'General Tiberius'),
('Charlize', 'Theron', 'Queen Valeria'),
('Jason', 'Momoa', 'Commander Rhea'),
('Gal', 'Gadot', 'Princess Amara'),
('Daniel', 'Kaluuya', 'Rebel Leader Kato'),
('Anya', 'Taylor-Joy', 'Oracle Nyssa'),
('Mads', 'Mikkelsen', 'Warlord Kael'),
('Taron', 'Egerton', 'Scout Tobias'),
('Naomi', 'Scott', 'Healer Lyra'),
('Javier', 'Bardem', 'The Tyrant King');

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
(3, 3, 3, 3);

INSERT INTO PaymentMethod (name) VALUES
('Credit Card'),
('PayPal'),
('Cash');

INSERT INTO Payment (paymentDate, paymentTime, totalPrice, userId, addressId, bookingId, methodId) VALUES
('2024-10-15', '18:30:00', 10.00, 1, 1, 1, 1),
('2024-10-16', '19:45:00', 20.00, 2, 2, 2, 2),
('2024-10-17', '20:30:00', 8.00, 3, 3, 3, 3),
('2024-10-18', '14:00:00', 15.00, 1, 1, 1, 1),
('2024-10-19', '16:15:00', 25.00, 2, 2, 2, 2),
('2024-10-20', '17:30:00', 12.00, 3, 3, 3, 3),
('2024-10-21', '15:00:00', 30.00, 1, 1, 1, 1),
('2024-10-22', '18:45:00', 22.50, 2, 2, 2, 2),
('2024-10-23', '20:00:00', 10.50, 3, 3, 1, 3),
('2024-10-24', '14:30:00', 28.00, 1, 1, 1, 1),
('2024-10-25', '16:00:00', 18.75, 2, 2, 1, 2),
('2024-10-26', '19:15:00', 9.99, 3, 3, 2, 3),
('2024-10-27', '21:00:00', 14.99, 1, 1, 3, 1);

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
-- The Dark Knight
(1, 1),  -- Christian Bale
(1, 2),  -- Heath Ledger
(1, 3),  -- Aaron Eckhart
(1, 4),  -- Maggie Gyllenhaal
(1, 5),  -- Gary Oldman
(1, 6),  -- Michael Caine
(1, 7),  -- Morgan Freeman
(1, 8),  -- Cillian Murphy
(1, 9),  -- Michael Jai White
(1, 10), -- Nestor Carbonell
-- Spider-Man: No Way Home
(2, 11),  -- Tom Holland
(2, 12),  -- Zendaya
(2, 13),  -- Benedict Cumberbatch
(2, 14),  -- Jacob Batalon
(2, 15),  -- Marisa Tomei
(2, 16),  -- Jamie Foxx
(2, 17),  -- Alfred Molina
(2, 18),  -- Willem Dafoe
(2, 19),  -- Tobey Maguire
(2, 20), -- Andrew Garfield
-- Joker
(3, 21),  -- Joaquin Phoenix
(3, 22),  -- Robert De Niro
(3, 23),  -- Zazie Beetz
(3, 24),  -- Frances Conroy
(3, 25),  -- Brett Cullen
(3, 26),  -- Shea Whigham
(3, 27),  -- Bill Camp
(3, 28),  -- Marc Maron
(3, 29),  -- Douglas Hodge
(3, 30), -- Brian Tyree Henry
-- Føreren og Forføreren
(4, 31),  -- Ulrich Noethen
(4, 32),  -- Liv Lisa Fries
(4, 33),  -- Johannes Krisch
(4, 34),  -- Stefan Kurt
(4, 35),  -- Florian Panzner
(4, 36),  -- Clemens Schick
(4, 37),  -- Volker Bruch
(4, 38),  -- Franziska Weisz
(4, 39),  -- Ursina Lardi
(4, 40),  -- Kirsten Block
-- Minions
(5, 41),  -- Pierre Coffin
(5, 42),  -- Steve Carell
(5, 43),  -- Kristen Wiig
(5, 44),  -- Trey Parker
(5, 45),  -- Miranda Cosgrove
(5, 46),  -- Al Pacino
(5, 47),  -- Jon Hamm
(5, 48),  -- Michael Keaton
(5, 49),  -- Sandra Bullock
(5, 50),  -- Steve Coogan
-- Star Wars: Episode V - The Empire Strikes Back
(6, 51),  -- Mark Hamill
(6, 52),  -- Harrison Ford
(6, 53),  -- Carrie Fisher
(6, 54),  -- Billy Dee Williams
(6, 55),  -- Peter Cushing
(6, 56),  -- Anthony Daniels
(6, 57),  -- David Prowse
(6, 58),  -- Kenneth Colley
(6, 59),  -- Julian Glover
(6, 60),  -- Jeremy Bulloch
-- Star Wars: Episode VI - Return of the Jedi
(7, 51),  -- Mark Hamill
(7, 52),  -- Harrison Ford
(7, 53),  -- Carrie Fisher
(7, 54),  -- Billy Dee Williams
(7, 55),  -- Peter Cushing
(7, 56),  -- Anthony Daniels
(7, 57),  -- David Prowse
(7, 61),  -- Ian McDiarmid
(7, 62),  -- Frank Oz
(7, 63),  -- Michael Carter
-- Guardians of the Multiverse
(8, 64),  -- Chris Pratt
(8, 65),  -- Zoe Saldana
(8, 66),  -- Dave Bautista
(8, 67),  -- Vin Diesel
(8, 68),  -- Bradley Cooper
(8, 69),  -- Karen Gillan
(8, 70),  -- Pom Klementieff
(8, 71),  -- Tom Hiddleston
(8, 72),  -- Chris Hemsworth
(8, 73),  -- Samuel L. Jackson
-- Space Explorers: The Next Journey
(9, 64),  -- Chris Pratt
(9, 74),  -- Emma Stone
(9, 75),  -- Oscar Isaac
(9, 76),  -- Jessica Chastain
(9, 77),  -- David Oyelowo
(9, 78),  -- John Boyega
(9, 12),  -- Zendaya
(9, 11),  -- Tom Holland
(9, 79),  -- John C. Reilly
(9, 52),  -- Harrison Ford
-- The Time Jumper
(9, 80),  -- Ethan Hawke
(9, 81),  -- Tessa Thompson
(9, 82),  -- Gugu Mbatha-Raw
(9, 83),  -- Willem Dafoe
(9, 84),  -- Rachel McAdams
(9, 85),  -- Vincent D'Onofrio
(9, 71),  -- Tom Hiddleston
(9, 72),  -- Chris Hemsworth
(9, 86),  -- Jeff Goldblum
(9, 87),  -- Jeremy Renner
-- AI: Awakening
(10, 88),  -- Scarlett Johansson
(10, 89),  -- Idris Elba
(10, 90),  -- Michael B. Jordan
(10, 91),  -- Jared Leto
(10, 92),  -- Benedict Cumberbatch
(10, 81),  -- Tessa Thompson
(10, 71),  -- Tom Hiddleston
(10, 76),  -- Jessica Chastain
(10, 75),  -- Oscar Isaac
(10, 93),  -- Mark Ruffalo
-- Rise of the Phoenix
(11, 94),  -- Henry Cavill
(11, 95),  -- Sophie Turner
(11, 96),  -- Jason Momoa
(11, 97),  -- Emily Blunt
(11, 98),  -- Matt Damon
(11, 99),  -- Alicia Vikander
(11, 100), -- Tom Hardy
(11, 76),  -- Jessica Chastain
(11, 89),  -- Idris Elba
(11, 75),  -- Oscar Isaac
-- The Avengers: Infinity War
(12, 101), -- Robert Downey Jr.
(12, 72),  -- Chris Hemsworth
(12, 93),  -- Mark Ruffalo
(12, 102), -- Chris Evans
(12, 88),  -- Scarlett Johansson
(12, 87),  -- Jeremy Renner
(12, 71),  -- Tom Hiddleston
(12, 11),  -- Tom Holland
(12, 103), -- Don Cheadle
(12, 92),  -- Benedict Cumberbatch
-- Guardians of the Galaxy Vol. 3
(13, 64),  -- Chris Pratt
(13, 65),  -- Zoe Saldana
(13, 66),  -- Dave Bautista
(13, 67),  -- Vin Diesel
(13, 68),  -- Bradley Cooper
(13, 69),  -- Karen Gillan
(13, 70),  -- Pom Klementieff
(13, 104), -- Will Poulter
(13, 105), -- Chukwudi Iwuji
(13, 106), -- Maria Bakalova
-- Star Wars: The Rise of Skywalker
(14, 107), -- Daisy Ridley
(14, 78),  -- John Boyega
(14, 75),  -- Oscar Isaac
(14, 108), -- Adam Driver
(14, 53),  -- Carrie Fisher
(14, 51),  -- Mark Hamill
(14, 54),  -- Billy Dee Williams
(14, 109), -- Domhnall Gleeson
(14, 110), -- Lupita Nyong'o
(14, 56),  -- Anthony Daniels
-- Mission: Impossible - Fallout
(15, 111), -- Tom Cruise
(15, 94),  -- Henry Cavill
(15, 112), -- Simon Pegg
(15, 113), -- Rebecca Ferguson
(15, 114), -- Ving Rhames
(15, 115), -- Sean Harris
(15, 116), -- Angela Bassett
(15, 117), -- Vanessa Kirby
(15, 118), -- Michelle Monaghan
(15, 119), -- Alec Baldwin
-- Fast & Furious 9
(16, 67),  -- Vin Diesel
(16, 120), -- Paul Walker
(16, 121), -- Dwayne Johnson
(16, 122), -- Michelle Rodriguez
(16, 123), -- Jordana Brewster
(16, 124), -- Tyrese Gibson
(16, 125), -- Ludacris
(16, 126), -- John Cena
(16, 127), -- Nathalie Emmanuel
(16, 128), -- Helen Mirren
-- Jurassic World: Dominion
(17, 64),  -- Chris Pratt
(17, 129), -- Bryce Dallas Howard
(17, 86),  -- Jeff Goldblum
(17, 130), -- Sam Neill
(17, 131), -- Laura Dern
(17, 132), -- BD Wong
(17, 133), -- DeWanda Wise
(17, 134), -- Mamoudou Athie
(17, 135), -- Campbell Scott
(17, 136), -- Isabella Sermon
-- Avatar: The Way of Water
(18, 137), -- Sam Worthington
(18, 65),  -- Zoe Saldana
(18, 138), -- Sigourney Weaver
(18, 139), -- Kate Winslet
(18, 140), -- Stephen Lang
(18, 141), -- Giovanni Ribisi
(18, 142), -- Cliff Curtis
(18, 143), -- CCH Pounder
(18, 144), -- Michelle Yeoh
(18, 145), -- Matt Gerald
-- The Flash
(19, 146), -- Ezra Miller
(19, 147), -- Michael Keaton
(19, 148), -- Ben Affleck
(19, 149), -- Sasha Calle
(19, 150), -- Michael Shannon
(19, 151), -- Kiersey Clemons
(19, 152), -- Ron Livingston
(19, 153), -- Maribel Verdú
(19, 154), -- Billy Crudup
(19, 155), -- Ian Loh
-- The Marvels
(20, 156), -- Brie Larson
(20, 157), -- Teyonah Parris
(20, 158), -- Iman Vellani
(20, 159), -- Park Seo-jun
(20, 160), -- Zawe Ashton
(20, 161), -- Rashida Jones
(20, 72),  -- Chris Hemsworth
(20, 162), -- Samuel L. Jackson
(20, 103), -- Don Cheadle
(20, 163); -- Benedict Wong

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
(1, 98);  -- Venue ID 1 -> Showing ID 98

INSERT INTO VenueOpeningHour (venueId, openingHourId) VALUES
(1, 1),  -- Gotham Cinema -> Monday's opening hours
(2, 2),  -- Hollywood Stars Cinema -> Tuesday's opening hours
(3, 3);  -- Empire Cinema -> Wednesday's opening hours
