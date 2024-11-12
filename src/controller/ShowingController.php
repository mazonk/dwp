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

    public function getAllShowingsForMovie(int $movieId): array {
        $showings = $this->showingService->getAllShowingsForMovie($movieId, $_SESSION['selectedVenueId']);
        // If the service returns an error, pass it to the frontend
        if (isset($showings['error']) && $showings['error']) {
            return ['errorMessage' => $showings['message']];
        }
        
        return $showings;
    }

    public function getMoviesPlayingToday(int $venueId): array{
        $showing = $this->showingService->getMoviesPlayingToday(htmlspecialchars($venueId));

        // If the service returns an error, pass it to the frontend
        if (isset($showing['error']) && $showing['error']) {
            return ['errorMessage' => $showing['message']];
        }
        
        return $showing;
    }
    
    public function getShowingById(int $showingId, int $venueId): Showing|array {
        $showing = $this->showingService->getShowingById($showingId, $venueId);

        // If the service returns an error, pass it to the frontend
        if (is_array($showing) && isset($showing['error']) && $showing['error']) {
            return ['errorMessage' => $showing['message']];
        }
        
        return $showing;
    }
}