<?php
include_once "src/model/repositories/ShowingRepository.php";
include_once "src/model/repositories/MovieRepository.php";
include_once "src/model/repositories/RoomRepository.php";
include_once "src/model/repositories/VenueRepository.php";
include_once "src/model/entity/Showing.php";
include_once "src/model/entity/Movie.php";
include_once "src/model/entity/Room.php";
include_once "src/model/entity/Venue.php";

class ShowingService {
    private ShowingRepository $showingRepository;
    private MovieRepository $movieRepository;
    private RoomRepository $roomRepository;
    private VenueRepository $venueRepository;

    public function __construct() {
        $this->showingRepository = new ShowingRepository();
        $this->movieRepository = new MovieRepository();
        $this->roomRepository = new RoomRepository();
        $this->venueRepository = new VenueRepository();
    }

    public function getShowingById(int $showingId, int $venueId): ?Showing {
        $showingData = $this->showingRepository->getShowingById($showingId);
        if ($showingData) {
            $venue = $this->venueRepository->getVenueById($venueId);
            $roomData = $this->roomRepository->getRoomById($showingData['roomId']);
            $room = new Room($roomData["roomId"], $roomData["roomNumber"], $venue);
            $rawMovie = $this->movieRepository->getMovieById($showingData['movieId']);
            $movie = $this->mapMovie($rawMovie);
            return new Showing(
                $showingData['showingId'],
                $movie,
                $room,
                new DateTime($showingData['showingDate']),
                new DateTime($showingData['showingTime'])
            );
        }
        return null; //nothing was found
    }

    public function getAllShowingsForVenue(int $venueId): array {
        $showingIds = $this->showingRepository->getShowingIdsForVenue($venueId);
        $showings = []; 
        if (!$showingIds) {
            return [];
        }
        else {
        foreach ($showingIds as $showingId) {
            $showings[] = $this->getShowingById($showingId["showingId"], $showingId["venueId"]);
        }
    }
        return $showings;
    }

    public function getAllShowingsForMovie(int $movieId, int $selectedVenueId): array {
        $result = $this->showingRepository->getShowingForMovie($movieId, $selectedVenueId);
        $showings = [];
        if (!$result) {
            return [];
        }
        else {
        foreach ($result as $showing) {
            $showings[] = $this->getShowingById($showing["showingId"], $showing["venueId"]);
        }
    }
        return $showings;
    }
    
    public function getMoviesPlayingToday(int $venueId): array {
        $moviesPlayingToday = [];
        $queryResult = $this->showingRepository->getMoviesPlayingToday($venueId);
        foreach ($queryResult as $result) {
            $rawMovie = $this->movieRepository->getMovieById($result['movieId']);
            if ($rawMovie) {  // If movie exists in the database, add it to the list.
            $moviesPlayingToday[] = $this->mapMovie($rawMovie);
            }
        }
        return $moviesPlayingToday;
    }

    private function mapMovie($row) {
        $movieId = $row['movieId'] ?? null;
        $actors = [];
        $directors = [];
        $rawActors = $this->movieRepository->getActorsByMovieId($movieId);
        foreach ($rawActors as $actorRow) {
            $actors[] = new Actor($actorRow['actorId'], $actorRow['firstName'], $actorRow['lastName'], $actorRow['character']);
        }
        $rawDirectors = $this->movieRepository->getDirectorsByMovieId($movieId);
        foreach ($rawDirectors as $directorRow) {
            $directors[] = new Director($directorRow['directorId'], $directorRow['firstName'], $directorRow['lastName']);
        }
        return new Movie(
            $movieId,
            $row['title'] ?? '',
            $row['description'] ?? '',
            $row['duration'] ?? '',
            $row['language'] ?? '',
            $row['releaseDate'] ?? '',
            $row['posterURL'] ?? '',
            $row['promoURL'] ?? '',
            $row['rating'] ?? '',
            $row['trailerURL'] ?? '',
            $actors,
            $directors
        );
    }
}
