<?php
include_once "src/model/entity/Seat.php";
include_once "src/model/entity/Room.php";
include_once "src/model/entity/Movie.php";
include_once "src/model/entity/Showing.php";
include_once "src/model/services/RoomService.php";
include_once "src/model/services/MovieService.php";
include_once "src/model/repositories/SeatRepository.php";
include_once "src/model/repositories/MovieRepository.php";
include_once "src/model/repositories/RoomRepository.php";

class SeatService {
    private SeatRepository $seatRepository;
    private RoomService $roomService;
    private MovieService $movieService;
    
    public function __construct() {
        $this->seatRepository = new SeatRepository();
        $this->roomService = new RoomService();
        $this->movieService = new MovieService();
    }
    
    public function getAllSeatsForShowing(int $showingId, int $selectedVenueId): array {
        try {
            $result = $this->seatRepository->getAllSeatsForShowing($showingId, $selectedVenueId);
            $seats = [];
    
            // Check if result is not empty and fetch room based on the first seat
            if (!empty($result)) {
                // Assuming getRoomById returns a Room object
                $room = $this->roomService->getRoomById($result[0]["roomId"]);
                if (isset($room["error"]) && $room["error"]) {
                    return $room; // Return error if room fetching fails
                }
                
                // Iterate through each seat
                foreach ($result as $seatData) {
                    // Ensure $seatData is being used properly
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
            $result = $this->seatRepository->getAvailableSeatsForShowing($showingId, $selectedVenueId);
            return $result;
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function getSeatById(int $seatId): Seat|array {
        try {
            $result = $this->seatRepository->getSeatById($seatId);
            // If getSeatById returns an object
            if ($result instanceof Seat) {
                // Access the room information from the Seat object
                $room = $this->roomService->getRoomById($result->getRoomId());
                if (isset($room["error"]) && $room["error"]) {
                    return $room;
                }
                return $result; // Return the Seat object if no error
            } else {
                return ['error' => true, 'message' => 'Seat not found.'];
            }
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
