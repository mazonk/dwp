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


    public function createEmptyBooking($userId, string $status, string $expiry): int|array {
        if (!isset($_SESSION['activeBooking'])) {
            $insertedBooking = $this->bookingService->createEmptyBooking($userId, $status);
            if (is_array($insertedBooking) && isset($insertedBooking['error']) && $insertedBooking['error']) {
                return ['errorMessage'=> $insertedBooking['message']];
            }
            $_SESSION['activeBooking'] = [
                'id' => $insertedBooking,
                'expiry' => $expiry
            ];
            return $insertedBooking;
        } else {
            return $_SESSION['activeBooking']['id'];
        }
    }

    public function rollBackBooking($bookingId): bool {
        $wasRolledBack = $this->bookingService->rollBackBooking($bookingId);
        unset($_SESSION['activeBooking']);
        return $wasRolledBack;
    }
}

