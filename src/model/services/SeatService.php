<?php
require_once "src/model/entity/Seat.php";
require_once "src/model/entity/Room.php";
require_once "src/model/entity/Movie.php";
require_once "src/model/entity/Showing.php";
require_once "src/model/services/RoomService.php";
require_once "src/model/services/TicketService.php";
require_once "src/model/repositories/SeatRepository.php";

class SeatService {
    private SeatRepository $seatRepository;
    private RoomService $roomService;
    private ?TicketService $ticketService;
    
    public function __construct() {
        $this->seatRepository = New SeatRepository();
        $this->roomService = new RoomService();
        $this->ticketService = null;
    }

    public function setTicketService(TicketService $ticketService) {
        $this->ticketService = $ticketService;
        $this->ticketService->setSeatService($this); //this shouldnt be here, reconsider this logic???
    }

    public function getAllSeatsForShowing(int $showingId, int $selectedVenueId): array
    {
        try {
            $result = $this->seatRepository->getAllSeatsForShowing($showingId, $selectedVenueId);
            $seats = [];
            $room = $this->roomService->getRoomById($result[0]["roomId"]);

            if (is_array($room) && isset($room["error"]) && $room["error"]) {
                return $room; // Return the error if not an instance of Room
            }
            foreach ($result as $seatData) {
                $seats[] = new Seat($seatData["seatId"], $seatData["row"], $seatData["seatNr"], $room);
            }
            return $seats;
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
    
    public function getAvailableSeatsForShowing(int $showingId, int $selectedVenueId): array {
        try {
            $allSeats = $this->getAllSeatsForShowing($showingId, $selectedVenueId);
            $bookedTickets = $this->ticketService->getAllTicketsForShowing($showingId);
            $bookedSeatsIds = [];
            foreach ($bookedTickets as $ticket) {
                $bookedSeatsIds[] = $ticket->getSeat()->getSeatId();
            }
            $availableSeats = [];
            foreach ($allSeats as $seatData) {
                if (!in_array($seatData->getSeatId(), $bookedSeatsIds)) {
                    $availableSeats[] = $seatData;
                }
            }
            return $availableSeats;
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function getSeatById(int $seatId): Seat|array {
        try {
            $result = $this->seatRepository->getSeatById($seatId);
            $room = $this->roomService->getRoomById($result["roomId"]);
            if (is_array($room) && isset($room["error"]) && $room["error"]) {
                return $room;
            }
            $seat = new Seat($result['seatId'], $result['row'], $result['seatNr'], $room);
            return $seat;
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}