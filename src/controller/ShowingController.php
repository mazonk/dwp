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

    public function getShowingsForMovieAdmin(int $movieId): array {
        $showings = $this->showingService->getShowingsForMovieAdmin($movieId);
        // If the service returns an error, pass it to the frontend
        if (isset($showings['error']) && $showings['error']) {
            return ['errorMessage' => $showings['message']];
        }
        
        return $showings;
    }

    public function getUnavailableTimeslotsForMovie(int $venueId, int $movieId, string $showingDate): array {
        $unavailableTimeslots = $this->showingService->getUnavailableTimeslotsForMovie($venueId, $movieId, $showingDate);
        // If the service returns an error, pass it to the frontend
        if (isset($unavailableTimeslots['error']) && $unavailableTimeslots['error']) {
            return ['errorMessage' => $unavailableTimeslots['message']];
        }
        
        return $unavailableTimeslots;
    }

    public function getUnavailableRoomsForAVenueAndDay(int $venueId, string $showingDate): array {
        $unavailableRooms = $this->showingService->getUnavailableRoomsForAVenueAndDay($venueId, $showingDate);
        if (isset($unavailableRooms['error']) && $unavailableRooms['error']) {
            return ['errorMessage' => $unavailableRooms['message']];
        }
        
        return $unavailableRooms;
    }

    public function getRelevantShowingsForMovie(int $movieId): array {
        $showings = $this->showingService->getRelevantShowingsForMovie($movieId);
        if (isset($showings['error']) && $showings['error']) {
            return ['errorMessage' => $showings['message']];
        }
        
        return $showings;
    }

    public function addShowing(array $showingData): array {
        $errors = $this->showingService->addShowing($showingData);

        // Check if there are any validation errors
        if(count($errors) == 0) {
            // Check if there are any errors from adding the showing
            if (isset($errors['error']) && $errors['error']) {
                return ['errorMessage' => $errors['message']];
            }
            return ['success' => true];
        } else {
            return $errors; // Return the validation errors
        }
    }

    public function editShowing(array $showingData): array {
        $errors = $this->showingService->editShowing($showingData);
        
        if(count($errors) == 0) {
            // Check if there are any errors from adding the news
            if (isset($errors['error']) && $errors['error']) {
                return ['errorMessage' => $errors['message']];
            }
            return ['success' => true];
        } else {
            return $errors;
        }
    }

    public function archiveShowing(int $showingId): array {
        $result = $this->showingService->archiveShowing(htmlspecialchars($showingId));
        if (isset($result['error']) && $result['error']) {
            return ['errorMessage' => $result['message']];
        }
        return ['success' => true];
    }

    public function restoreShowing(int $showingId): array {
        $result = $this->showingService->restoreShowing(htmlspecialchars($showingId));
        if (isset($result['error']) && $result['error']) {
            return ['errorMessage' => $result['message']];
        }
        return ['success' => true];
    }
}