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

    public function getAllShowingsForMovie(int $movieId): array {
        //return $this->showingService->getAllShowingsForMovie($movieId,$_SESSION["selectedVenueId"] );
        return $this->showingService->getAllShowingsForMovie($movieId,1); //$_SESSION["1"] );
    }

    public function getMoviesPlayingToday(int $venueId){
        return $this->showingService->getMoviesPlayingToday($venueId);
    }
    
}