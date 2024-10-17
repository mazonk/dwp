<?php
include_once "src/model/repositories/VenueRepository.php";

class VenueController {
  private VenueRepository $venueRepository;

  public function __construct() {
    $this->venueRepository = new VenueRepository();
  }

  /* Get all venues */
  public function getAllVenues(): array {
    return $this->venueRepository->getAllVenues();
  }

  /* Get a specific venue by venueId */
  public function getVenue(int $venueId): ?Venue {
    try {
      return $this->venueRepository->getVenue($venueId);
    } catch (Exception $e) {
        echo $e->getMessage();
        return null;
    }
  }

  /* Store the selected venue's venueId and name in the session */
  public function selectVenue(Venue $venue): void {
    $_SESSION['selectedVenueId'] = $venue->getVenueId();
    $_SESSION['selectedVenueName'] = $venue->getName();
  }
}
?>