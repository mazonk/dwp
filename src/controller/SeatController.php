<?php
require_once "src/model/services/SeatService.php";
require_once "src/model/services/TicketService.php";

class SeatController {
    private SeatService $seatService;

    public function __construct() {
        $ticketService = new TicketService();
        $this->seatService = new SeatService();
        $this->seatService->setTicketService($ticketService);
    }

    public function getSeatById(int $id): Seat|array {
        $seat = $this->seatService->getSeatById($id);
        if (isset($seat['error']) && $seat['error']) {
            return ['errorMessage' => $seat['message']];
        }
        return $seat;
    }

    public function getAllSeatsForShowing(int $showingId, int $selectedVenueId): array {
        $seats = $this->seatService->getAllSeatsForShowing($showingId, $selectedVenueId);
        if (isset($seats['error']) && $seats['error']) {
            return ['errorMessage' => $seats['message']];
        }
        return $seats;
    }
    public function getAvailableSeatsForShowing(int $showingId, int $selectedVenueId): array {
        $availableSeats = $this->seatService->getAvailableSeatsForShowing($showingId, $selectedVenueId);
        if (isset($availableSeats['error']) && $availableSeats['error']) {
            return ['errorMessage' => $availableSeats['message']];
        }
        return $availableSeats;
    }
}