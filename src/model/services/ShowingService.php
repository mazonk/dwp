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

    public function getShowingById(int $showingId): Showing {
        $showingData = $this->showingRepository->getShowingById($showingId);
        if ($showingData) {
            return new Showing(
                $showingData['showingId'],
                $this->movieRepository->getMovieById($showingData['movieId']),
                $this->roomRepository->getRoomById($showingData['roomId']),
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
            $showings[] = $this->getShowingById($showingId);
        }
    }
        return $showings;
    }
}
