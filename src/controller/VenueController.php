<?php
include_once "src/model/repositories/VenueRepository.php";

class VenueController {
  private VenueRepository $venueRepository;

  public function __construct() {
    $this->venueRepository = new VenueRepository();
  }

  public function getAllVenues(): array {
    return $this->venueRepository->getAllVenues();
  }

  public function getVenue(int $venueId): ?Venue {
    try {
      return $this->venueRepository->getVenue($venueId);
    } catch (Exception $e) {
        echo $e->getMessage();
        return null;
    }
  }
}
?>