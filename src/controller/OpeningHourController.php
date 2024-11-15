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

  public function addOpeningHour(array $openingHourData, int $venueId): array {
    $errors = $this->openingHourService->addOpeningHour($openingHourData, $venueId);

    // Check if there are any validation errors
    if (count($errors) == 0) {
      // Check if there are any errors from adding the opening hour
      if (isset($errors['error']) && $errors['error']) {
        return ['errorMessage' => $errors['message']];
      }
      return ['success' => true];
    } else {
      return $errors;
    }
  }
}