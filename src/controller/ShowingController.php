<?php
include_once "src/model/repositories/ShowingRepository.php";
include_once "src/model/entity/Movie.php";
include_once "src/model/entity/Room.php";
include_once "src/model/entity/Showing.php";
include_once "src/model/entity/Venue.php";
include_once "src/model/services/ShowingService.php";

class ShowingController {
    private ShowingService $showingService;


    public function __construct() {
        $this->showingService = new ShowingService();
    }

    public function getAllShowingsForVenue(int $venueId): array {
        return $this->showingService->getAllShowingsForVenue($venueId);
    }

    public function getAllShowingsForMovie(int $movieId, array $showings): array {
        return $this->showingService->getAllShowingsForMovie($movieId, $showings);
    }

    public function getMoviesPlayingToday(int $venueId){
        return $this->showingService->getMoviesPlayingToday($venueId);
    }
    
}