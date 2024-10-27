<?php
include_once "src/model/services/VenueService.php";

class VenueController {
  private VenueService $venueService;

  public function __construct() {
    $this->venueService = new VenueService();
  }

  /* Get all venues */
  public function getAllVenues(): array {
    $venues = $this->venueService->getAllVenues();
    if (isset($venues['error']) && $venues['error']) {
      return ['errorMessage'=> $venues['message']];
    }
    return $venues;
  }

  /* Get a venue by venueId */
  public function getVenueById(int $venueId): array|Venue {
    $venue = $this->venueService->getVenueById($venueId);
    if (is_array($venue) && isset($venue['error']) && $venue['error']) {
      return ['errorMessage'=> $venue['message']];
    }
    return $venue;
  }

  /* Store the selected venue's venueId and name in the session */
  public function selectVenue(Venue $venue): Venue {
    $_SESSION['selectedVenueId'] = $venue->getVenueId();
    $_SESSION['selectedVenueName'] = $venue->getName();
    return $venue;
  }
}
?>