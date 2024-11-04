<?php
include_once "src/model/entity/Seat.php";
include_once "src/model/repositories/SeatRepository.php";
include_once "src/model/entity/Room.php";
include_once "src/model/repositories/RoomRepository.php";
include_once "src/model/services/RoomService.php";
include_once "src/model/entity/Movie.php";
include_once "src/model/repositories/MovieRepository.php";
include_once "src/model/services/MovieService.php";
include_once "src/model/entity/Showing.php";

class SeatService {
    private SeatRepository $seatRepository;
    private RoomService $roomService;
    private MovieService $movieService;
    
    public function __construct() {
        $this->seatRepository = new SeatRepository();
        $this->roomService = new RoomService();
        $this->movieService = new MovieService();
    }

    //TODO: public function getSeatById
    
    public function getAllSeatsForShowing(int $showingId, int $selectedVenueId): array {
        try {
            $result = $this->seatRepository->getAllSeatsForShowing($showingId, $selectedVenueId);
            $seats = [];
            $room = $this->roomService->getRoomById($result["roomId"]);
            if(isset($room["error"]) && $room["error"]) {
                return $room;
            }
            foreach ($result as $seat) {
                $seats[] = new Seat($result["seatId"], $result["row"], $result["seatNr"], $room);
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
    public function getSeatById(int $seatId): array|Seat {
        try {
            $result = $this->seatRepository->getSeatById($seatId);
            $room = $this->roomService->getRoomById($result["roomId"]);
            if(isset($room["error"]) && $room["error"]) {
                return $room;
            }
            return new Seat($result["seatId"], $result["row"], $result["seatNr"], $room);
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}