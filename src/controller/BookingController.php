<?php
include_once "src/model/entity/Reservation.php";

class BookingController {

    public function __construct() {
    }
    
    public function getBookingDetails($userId) {
        // Logic to retrieve bookings for the user
        // This could return an array of bookings
        return []; // Replace with actual data retrieval logic
    }


    public function cancelBooking($bookingId) {
        // Logic to cancel the booking in the database
       
    }
}

