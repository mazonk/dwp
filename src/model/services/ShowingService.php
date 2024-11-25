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
    private ShowingRepository $showingRepository;
    private MovieService $movieService;
    private RoomService $roomService;
    private VenueService $venueService;

    public function __construct() {
        $this->showingRepository = new ShowingRepository();
        $this->movieService = new MovieService();
        $this->roomService = new RoomService();
        $this->venueService = new VenueService();
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
}
