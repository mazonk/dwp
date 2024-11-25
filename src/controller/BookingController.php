<?php
include_once "src/model/entity/Booking.php";
include_once "src/model/services/BookingService.php";

class BookingController {
    private BookingService $bookingService;

    public function __construct() {
        $this->bookingService = new BookingService();
    }

    public function getBookingsByUserId(int $userId): array {
        $bookings = $this->bookingService->getBookingsByUserId($userId);
        if (isset($bookings['error']) && $bookings['error']) {
            return ['errorMessage'=> $bookings['message']];
        }
        return $bookings;
    }

    public function createBooking(int $userId, string $status) {
        $insertedBooking = $this->bookingService->createBooking($userId, $status);
        if (isset($insertedBooking['error']) && $insertedBooking['error']) {
            return ['errorMessage'=> $insertedBooking['message']];
        }
        return $insertedBooking;
    }
}

