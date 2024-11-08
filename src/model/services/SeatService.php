<?php
include_once "src/model/entity/Seat.php";
include_once "src/model/entity/Room.php";
include_once "src/model/entity/Movie.php";
include_once "src/model/entity/Showing.php";

class SeatService {
    private SeatRepository $seatRepository;
    private RoomService $roomService;
    private MovieService $movieService;
    private TicketService $ticketService;
    
    // Dependency injection in the constructor
    public function __construct(
        SeatRepository $seatRepository,
        RoomService $roomService,
        MovieService $movieService,
        TicketService $ticketService
    ) {
        $this->seatRepository = $seatRepository;
        $this->roomService = $roomService;
        $this->movieService = $movieService;
        $this->ticketService = $ticketService;
    }
    
    public function getAllSeatsForShowing(int $showingId, int $selectedVenueId): array {
        try {
            $result = $this->seatRepository->getAllSeatsForShowing($showingId, $selectedVenueId);
            $seats = [];

            if (!empty($result)) {
                $room = $this->roomService->getRoomById($result[0]["roomId"]);
                
                if (!$room instanceof Room) {
                    return $room; // Return the error if not an instance of Room
                }
                
                foreach ($result as $seatData) {
                    $seats[] = new Seat($seatData["seatId"], $seatData["row"], $seatData["seatNr"], $room);
                }
            }
            return $seats; 
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
    
    public function getAvailableSeatsForShowing(int $showingId, int $selectedVenueId): array {
        try {
            $allSeats = $this->getAllSeatsForShowing($showingId, $selectedVenueId);
            $bookedTickets = $this->ticketService->getAllTicketsForShowing($showingId, $selectedVenueId);
            $bookedSeatsIds = [];
            foreach ($bookedTickets as $ticket) {
                $bookedSeatsIds[] = $ticket['seatId'];
            }
            $availableSeats = [];
            $room = $this->roomService->getRoomById($allSeats[0]["roomId"]);
            if (isset($room["error"]) && $room["error"]) {
                return $room;
            }
            foreach ($allSeats as $seatData) {
                if (!in_array($seatData['seatId'], $bookedSeatsIds)) {
                    $availableSeats[] = new Seat($seatData['seatId'], $seatData['row'], $seatData['seatNr'], $room);
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
            $room = $this->roomService->getRoomById($result[0]["roomId"]);
            if (isset($room["error"]) && $room["error"]) {
                return $room;
            }
            $seat = new Seat($result['seatId'], $result['row'], $result['seatNr'], $room);
            return $seat;
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function selectSeat(int $seatId): array {
        try {
            $result = $this->seatRepository->selectSeat($seatId);
            return $result;
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}
