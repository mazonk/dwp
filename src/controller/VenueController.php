<?php
include_one "src/model/repositories/VenueRepository.php";

class VenueController {
  private VenueRepository $venueRepository;

  public function __construct() {
    $this->venueRepository = new VenueRepository();
  }

  public function getAllVenues(): array {
    return $this->venueRepository->getAllVenues();
  }
}