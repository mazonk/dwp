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

    public function updateBookingUser(int $bookingId, int $userId): array {
        $updatedBooking = $this->bookingService->updateBookingUser($bookingId, $userId);
        if (isset($updatedBooking['error']) && $updatedBooking['error']) {
            return ['errorMessage'=> $updatedBooking['message']];
        }
        return $updatedBooking;
    }

    public function createEmptyBooking($userId, string $status): int|array {
        if (!isset($_SESSION['activeBooking'])) {
            $insertedBooking = $this->bookingService->createEmptyBooking($userId, $status);
            if (is_array($insertedBooking) && isset($insertedBooking['error']) && $insertedBooking['error']) {
                return ['errorMessage'=> $insertedBooking['message']];
            }
            $_SESSION['activeBooking'] = [
                'id' => $insertedBooking,
                'expiry' => time() + 15 * 60, // 15 minutes from now
            ];
            return $insertedBooking;
        } else {
            return $_SESSION['activeBooking']['id'];
        }
    }

    public function rollBackBooking(int $bookingId, array $ticketIds): bool {
        $wasRolledBack = $this->bookingService->rollBackBooking($bookingId, $ticketIds);
        unset($_SESSION['activeBooking']);
        return $wasRolledBack;
    }
}

