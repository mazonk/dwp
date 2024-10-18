<?php
include_once "src/model/repositories/OpeningHourRepository.php";

class OpeningHourController {
  private OpeningHourRepository $openingHourRepository;

  public function __construct() {
    $this->openingHourRepository = new OpeningHourRepository();
  }

  /* Get opening hours by venueId */
  public function getOpeningHoursById(int $venueId): ?array {
    try {
      return $this->openingHourRepository->getOpeningHoursById($venueId);
    } catch (Exception $e) {
        echo $e->getMessage();
        return null;
    }
  }
}