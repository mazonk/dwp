<?php
include_once "src/model/entity/Booking.php";
include_once "src/model/repositories/BookingRepository.php";

class BookingService {
    private BookingRepository $bookingRepository;
    public function __construct() {
        $this->bookingRepository = new BookingRepository();
    }

    public function getBookingById(int $bookingId): array {
        try {
            $result = $this->bookingRepository->getBookingById($bookingId);
            return $result;
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}