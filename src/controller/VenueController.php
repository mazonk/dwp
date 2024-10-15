<?php
include_once "src/model/repositories/VenueRepository.php";

class VenueController {
  private VenueRepository $venueRepository;

  public function __construct() {
    $this->venueRepository = new VenueRepository();
  }

  public function getAllVenues(): array {
    try {
      return $this->venueRepository->getAllVenues();
    } catch (Exception $e) {
      return [];
    }
  }
}
?>