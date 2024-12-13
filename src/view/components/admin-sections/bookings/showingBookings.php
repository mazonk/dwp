<?php
include_once "src/controller/BookingController.php";

if(isset($_GET['selectedShowing']) && is_numeric($_GET['selectedShowing'])) {
    $showingId = intval($_GET['selectedShowing']);
    $bookingController = new BookingController();
    $bookings = $bookingController->getBookingsByShowingId($showingId);

    if (isset($bookings['errorMessage']) && $bookings['errorMessage']) {
        echo $bookings['errorMessage'];
    }
    foreach ($bookings as $booking) {
        echo $booking->getBookingId(). ',';
    }
}