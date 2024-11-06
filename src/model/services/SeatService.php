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
                // Call getRoomById and check if it returned an error array
                $room = $this->roomService->getRoomById($result[0]["roomId"]);
                
                // Verify if $room is an instance of Room, otherwise return the error
                if (!$room instanceof Room) {
                    return $room; // This will return the error array
                }
                
                // Iterate through each seat
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
