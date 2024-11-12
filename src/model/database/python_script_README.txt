Documentation: 
Database Script for Generating Mock Data
This script populates a MySQL database with mock data for a cinema booking system. 
It uses the mysql-connector-python package to connect to the database and faker to generate realistic data. 
The data generation includes rooms, seats, showings, bookings, and tickets for a set of venues and movies.

Prerequisites
Python 3.7+
Required Python packages: Install the following using pip:

pip install mysql-connector-python python-dotenv faker

MySQL Database: Ensure you have a MySQL server running, and the tables Room, Seat, Showing, VenueShowing, Booking, and Ticket are already created in the database.

Environment Setup:
Create a .env file: 

Store your database credentials in a file named .env within a folder named dbcon (relative to this script). The file should have the following variables:

DB_USER=your_db_username
DB_PASS=your_db_password
DB_PORT=your_db_port (if you are using XAMP, baseport is 3306)
DB_HOST=your_db_host
DB_NAME=your_db_name

Verify Database Structure: Ensure the database contains the required tables with appropriate columns.
The table structure expected by this script is as follows (simplified for reference):

Room: roomId, roomNumber, venueId
Seat: seatId, row, seatNr, roomId
Showing: showingId, showingDate, showingTime, movieId, roomId
VenueShowing: venueId, showingId
Booking: bookingId, userId, status
Ticket: ticketId, seatId, ticketTypeId, showingId, bookingId

Running the Script

Load Environment Variables: The script uses dotenv to load environment variables (database credentials).
Run the Script: Execute the script by running (you have to be in the same folder as the script itself):

python mockScript.py

This will automatically populate the database with data by calling functions in the following order:

Functions Overview:
generate_rooms(): Populates the Room table with 6 rooms for each of the 3 venues.
generate_seats(): Creates seats based on room type (big or small) for each room in each venue. Seat numbers and layouts vary by room type.
generate_showings(): Generates 21 days of movie showings (5 per movie, per day), linked to rooms and venues.
generate_bookings(): Inserts 400 mock bookings with random statuses (confirmed, pending, or cancelled).
generate_tickets(): Generates tickets associated with bookings and showings, ensuring unique seating arrangements per showing.

Notes:
Foreign Key Checks: The script disables foreign key checks temporarily while truncating tables to ensure data integrity during cleanup and re-population.
Execution Order: The script automatically calls each function in a predefined sequence when run, but individual functions can be executed independently if needed.
Print Statements: Each function prints confirmation messages after successful data insertion.
Example Output
Upon successful execution, the console output will indicate the successful population of each table, for example:

Rooms for each venue have been inserted.
Seats for each room have been inserted.
Showings for each movie have been inserted for 21 days, with 5 showings per movie each day, and associated records in VenueShowing.
400 bookings have been generated.
500 tickets have been inserted.

This script provides an efficient way to seed your database with realistic test data for development and testing purposes.