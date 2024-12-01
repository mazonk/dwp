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


    public function createEmptyBooking(int $userId, string $status): Booking|array {
        $insertedBooking = $this->bookingService->createEmptyBooking($userId, $status);
        if (isset($insertedBooking['error']) && $insertedBooking['error']) {
            return ['errorMessage'=> $insertedBooking['message']];
        }
        $_SESSION['activeBooking'] = [
            'id' => $insertedBooking,
            'expiry' => time() + 15 * 60 // 15 minutes
        ];
        return $insertedBooking;
    }
}

