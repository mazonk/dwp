<?php
include_once "src/model/repositories/SeatRepository.php";
include_once "src/model/repositories/BookingRepository.php";
include_once "src/model/services/SeatService.php";
include_once "src/model/entity/Seat.php";
include_once "src/controller/BookingController.php";

class SeatController {
    private SeatService $seatService;
    private BookingRepository $bookingRepository;

    public function __construct() {
        $this->seatService = new SeatService();
    }

    public function getAllSeatsForShowing(int $showingId, int $selectedVenueId) {
        $seats = $this->seatService->getAllSeatsForShowing($showingId, $selectedVenueId);
        if (isset($seats['error']) && $seats['error']) {
            return ['errorMessage' => $seats['message']];
        }
        return $seats;
    }
    public function getAvailableSeatsForShowing(int $showingId, int $selectedVenueId) {
        $availableSeats = $this->seatService->getAvailableSeatsForShowing($showingId, $selectedVenueId);
        if (isset($availableSeats['error']) && $availableSeats['error']) {
            return ['errorMessage' => $availableSeats['message']];
        }
        return $availableSeats;
    }
    public function bookSeat(int $seatId, int $showingId, int $userId) {
        $success = $this->bookingRepository->bookSeat($seatId, $showingId, $userId);
        if ($success) {
            return ['success' => true, 'message' => 'Seat booked successfully!'];
        } else {
            return ['success' => false, 'message' => 'Seat is already booked.'];
        }
    }
}