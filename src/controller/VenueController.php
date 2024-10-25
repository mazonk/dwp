<?php
include_once "src/model/services/VenueService.php";

class VenueController {
  private VenueService $venueService;

  public function __construct() {
    $this->venueService = new VenueService();
  }

  /* Get all venues */
  public function getAllVenues(): array {
    try {
      return $this->venueService->getAllVenues();
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }

  /* Get a venue by venueId */
  public function getVenue(int $venueId): Venue {
    try {
      return $this->venueService->getVenue($venueId);
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
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