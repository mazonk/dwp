# __Cinema Booking Management System__ #
### A web-based system for booking tickets and reserving seats in a cinema. ###

### __Features__ ###
- Ticket Booking: Browse available movies and book tickets.<br>
- Seat Reservation: Select and reserve seats.<br>
- User Management: Manage customer accounts and bookings.

### __Installation__ ###
1. Clone the repository: *git clone https://github.com/mazonk/dwp.git*
2. Move files to your WAMP/XAMPP directory:
    - For WAMP, move the project folder to C:/wamp64/www/.
    - For XAMPP, move the project folder to C:/xampp/htdocs/.
3. Start WAMP/XAMPP:
    - Launch WAMP or XAMPP and ensure Apache and MySQL services are running.
4. Create a database:
    - Open phpMyAdmin *(http://localhost/phpmyadmin)*.
    - Create a new database (e.g., cinema_booking).
    - Import the provided SQL file (if available) to set up tables.
5. Configure the database connection:
    - In the project, find the PHP file handling database connection (e.g., config.php or db.php)
    - Update the database credentials to match your local setup:
      $host = 'localhost';
      $db = 'cinema_booking';
      $user = 'root';
      $pass = ''; // (Leave empty if using XAMPP/WAMP default)
6. Access the application:
    - In your browser, go to *http://localhost/your-project-folder/*.
    - The system should now be accessible, allowing ticket bookings and seat reservations.

Admin login credentials:
username: admin@admin.com
password: Password1

Stripe test card details:
card number: 4242 4242 4242 4242
expiry: any future date
cvc: any 3-digit code
