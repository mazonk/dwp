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

    //TODO: public function getAllSeatsForShowing
}