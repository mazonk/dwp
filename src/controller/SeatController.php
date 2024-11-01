<?php
include_once "src/model/repositories/SeatRepository.php";
include_once "src/model/services/SeatService.php";
include_once "src/model/entity/Seat.php";

class SeatController {
    private SeatService $seatService;

    public function __construct() {
        $this->seatService = new SeatService();
    }

    public function getSeatsForShowing(int $showingId, int $selectedVenueId) {
        $seats = $this->seatService->getSeatsForShowing($showingId, $selectedVenueId);
        if (isset($seats['error']) && $seats['error']) {
            return ['errorMessage' => $seats['message']];
        }
        
        return $seats;
    }
}