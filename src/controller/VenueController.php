<?php
include_once "src/model/repositories/VenueRepository.php";

class VenueController {
  private VenueRepository $venueRepository;

  public function __construct() {
    $this->venueRepository = new VenueRepository();
  }

  public function getVenueById(int $venueId): ?Venue {
    try {
      return $this->venueRepository->getVenue($venueId);
    } catch (Exception $e) {
      return null;
    }
  }
  /* Get all venues */
  public function getAllVenues(): array {
    try {
      return $this->venueRepository->getAllVenues();
    } catch (Exception $e) {
      return [];
    }
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
  public function selectVenue(Venue $venue): Venue {
    $_SESSION['selectedVenueId'] = $venue->getVenueId();
    $_SESSION['selectedVenueName'] = $venue->getName();
    return $venue;
  }
}
?>