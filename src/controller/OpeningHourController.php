<?php
include_once "src/model/services/OpeningHourService.php";

class OpeningHourController {
  private OpeningHourService $openingHourService;

  public function __construct() {
    $this->openingHourService = new OpeningHourService();
  }

  /* Get current opening hours by venueId */
  public function getCurrentOpeningHoursById(int $venueId): array {
    $openingHours = $this->openingHourService->getCurrentOpeningHoursById($venueId);
    if (isset($openingHours['error']) && $openingHours['error']) {
      return ['errorMessage'=> $openingHours['message']];
    }
    return $openingHours;
  }

  /* Get opening hours by venueId */
  public function getOpeningHoursById(int $venueId): array {
    $openingHours = $this->openingHourService->getOpeningHoursById($venueId);
    if (isset($openingHours['error']) && $openingHours['error']) {
      return ['errorMessage'=> $openingHours['message']];
    }
    return $openingHours;
  }
}