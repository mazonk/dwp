<?php
include_once "src/model/repositories/ShowingRepository.php";
include_once "src/model/services/MovieService.php";
include_once "src/model/services/RoomService.php";
include_once "src/model/services/VenueService.php";
include_once "src/model/entity/Showing.php";
include_once "src/model/entity/Movie.php";
include_once "src/model/entity/Room.php";
include_once "src/model/entity/Venue.php";

class ShowingService {
    private PDO $db;
    private ShowingRepository $showingRepository;
    private MovieService $movieService;
    private RoomService $roomService;

    public function __construct() {
        $this->db = $this->getdb();
        $this->showingRepository = new ShowingRepository($this->db);
        $this->movieService = new MovieService();
        $this->roomService = new RoomService();
    }

    private function getdb() {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
    }

    public function getShowingById(int $showingId): array|Showing {
        try {
            $showingData = $this->showingRepository->getShowingById($showingId);
            $room = $this->roomService->getRoomById($showingData['roomId']);
            if (is_array($room) && isset($room['error']) && $room['error']) {
                return $room; //return the errors if there are any
            }
            $movie = $this->movieService->getMovieById($showingData['movieId']);
            if (is_array($movie) && isset($movie['error']) && $movie['error']) {
                return $movie; //return the errors if there are any
            }
            return new Showing(
                $showingData['showingId'],
                $movie,
                $room,
                new DateTime($showingData['showingDate']),
                new DateTime($showingData['showingTime'])
            );
        } catch (Exception $e) {
            return ['error' => true,'message' => $e->getMessage()];
        }
    }

    public function getUnavailableTimeslotsForMovie(int $venueId, int $movieId, string $showingDate): array {
        try {
            $result = $this->showingRepository->getUnavailableTimeslotsForMovie($venueId, $movieId, $showingDate);
            $unavailableTimeslots = [];
            foreach ($result as $showing) {
                $unavailableTimeslots[] = [
                    'showingTime' => $showing['showingTime']
                ];
            }
            return $unavailableTimeslots;
        } catch (Exception $e) {
            return ['error' => true,'message' => $e->getMessage()];
        }
    }

    public function getUnavailableRoomsForAVenueAndDay(int $venueId, string $showingDate): array {
        try {
            $result = $this->showingRepository->getUnavailableRoomsForAVenueAndDay($venueId, $showingDate);
            $unavailableRooms = [];
            foreach ($result as $room) {
                $unavailableRooms[] = [
                    'roomId' => $room['roomId'],
                    'showingTime' => $room['showingTime'],
                    'duration' => $room['duration'],
                ];
            }
            return $unavailableRooms;
        } catch (Exception $e) {
            return ['error' => true,'message' => $e->getMessage()];
        }
    }

    public function getAllShowingsForMovie(int $movieId, int $selectedVenueId): array {
        try {
            $result = $this->showingRepository->getShowingsForMovie($movieId, $selectedVenueId);
            $showings = [];
            foreach ($result as $showing) {
                $result = $this->getShowingById($showing["showingId"]);
                if (is_array($result) && isset($result['error']) && $result['error']) {
                    continue;
                } else {
                    $showings[] = $result;
                }
            }

            return $showings;
        } catch (Exception $e) {
            return ['error' => true,'message' => $e->getMessage()];
        }
    }
    
    public function getMoviesPlayingToday(int $venueId): array {
        try {
            $moviesPlayingToday = [];
            $queryResult = $this->showingRepository->getMoviesPlayingToday($venueId);
            foreach ($queryResult as $result) {
                $movie = $this->movieService->getMovieById($result['movieId']);
                if (is_array($movie) && isset($movie['error']) && $movie['error']) {
                    continue;
                } else {
                    $moviesPlayingToday[] = $movie;
                }
            }
            return $moviesPlayingToday;
        } catch (Exception $e) {
            return ['error' => true,'message' => $e->getMessage()];
        }
    }

    public function getShowingsForMovieAdmin(int $movieId): array {
        try {
            $result = $this->showingRepository->getShowingsForMovieAdmin($movieId);
            $showings = [];
            foreach ($result as $showing) {
                $showings[] = [
                    'showingId' => $showing['showingId'],
                    'showingDate' => $showing['showingDate'],
                    'showingTime' => $showing['showingTime'],
                    'title' => $showing['title'],
                    'movieId' => $showing['movieId'],
                    'roomNumber' => $showing['roomNumber'],
                    'venueId' => $showing['venueId'],
                    'bookings' => $showing['bookings'],
                    'tickets' => $showing['tickets']
                ];
            }
            return $showings;
        } catch (Exception $e) {
            return ['error' => true,'message' => $e->getMessage()];
        }
    }

    public function getRelevantShowingsForMovie(int $movieId): array {
        try {
            $result = $this->showingRepository->getRelevantShowingsForMovie($movieId);
            $showings = [];
            foreach ($result as $showing) {
                $showings[] = [
                    'showingId' => $showing['showingId'],
                    'showingDate' => $showing['showingDate'],
                    'showingTime' => $showing['showingTime'],
                    'movieId' => $showing['movieId'],
                    'roomId' => $showing['roomId'],
                    'roomNumber' => $showing['roomNumber'],
                    'venueId' => $showing['venueId']
                ];
            }
            return $showings;
        } catch (Exception $e) {
            return ['error' => true,'message' => $e->getMessage()];
        }
    }

    public function addShowing(array $showingData): array {
        $errors = [];
        $this->validateShowingFormInputs($showingData, $errors);

        if (count($errors) == 0) { // If there are no validation errors, add the showing
            try {
                $this->showingRepository->addShowing($showingData);
                return ['success' => true];
            } catch (Exception $e) {
                return ['error' => true, 'message' => $e->getMessage()];
            }
        } else {
            return $errors; // If there are validation errors, return them
        }
    }

    public function editShowing(array $showingData): array {
        $errors = [];
        $this->validateShowingFormInputs($showingData, $errors);

        if (count($errors) == 0) { // If there are no validation errors, add the showing
            try {
                $this->showingRepository->editShowing($showingData);
                return ['success' => true];
            } catch (Exception $e) {
                return ['error' => true, 'message' => $e->getMessage()];
            }
        } else {
            return $errors; // If there are validation errors, return them
        }
    }

    public function archiveShowing(int $showingId): array {
        try {
            $this->showingRepository->archiveShowing($showingId);
            return ['success' => true];
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        } 
    }

    public function restoreShowing (int $showingId): array {
        try {
            $this->showingRepository->restoreShowing($showingId);
            return ['success' => true];
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    private function validateShowingFormInputs(array $showingData, array &$errors): void {
        // Define regexes for validation
        $dateRegex = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
        $timeRegex = "/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/";

        if (empty($showingData['venueId']) ||
            empty($showingData['showingDate']) ||
            empty($showingData['showingTime'])||
            empty($showingData['movieId']) ||
            empty($showingData['roomId'])) {
            $errors['general'] = "All fields are required.";
        }
        if (!preg_match($dateRegex, $showingData['showingDate'])) {
            $errors['showingDate'] = "Invalid date format. Please use the format YYYY-MM-DD.";
        }
        if (!preg_match($timeRegex, $showingData['showingTime'])) {
            $errors['showingTime'] = "Invalid time format. Please use the format HH:MM.";
        }
    }
}