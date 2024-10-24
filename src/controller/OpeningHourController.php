<?php
include_once "src/model/services/OpeningHourService.php";

class OpeningHourController {
  private OpeningHourService $openingHourService;

  public function __construct() {
    $this->openingHourService = new OpeningHourService();
  }

  /* Get opening hours by venueId */
  public function getOpeningHoursById(int $venueId): ?array {
    try {
      return $this->openingHourService->getOpeningHoursById($venueId);
    } catch (Exception $e) {
        echo $e->getMessage();
        return null;
    }
  }
}