<?php
include_once "src/model/services/OpeningHourService.php";

class OpeningHourController {
  private OpeningHourService $openingHourService;

  public function __construct() {
    $this->openingHourService = new OpeningHourService();
  }

  /* Get the opening hours */
  public function getOpeningHours(): array {
    $openingHours = $this->openingHourService->getOpeningHours();
    if (isset($openingHours['error']) && $openingHours['error']) {
      return ['errorMessage'=> $openingHours['message']];
    }
    return $openingHours;
  }

  /* Get current opening hours */
  public function getCurrentOpeningHours(): array {
    $openingHours = $this->openingHourService->getCurrentOpeningHours();
    if (isset($openingHours['error']) && $openingHours['error']) {
      return ['errorMessage'=> $openingHours['message']];
    }
    return $openingHours;
  }

  public function addOpeningHour(array $openingHourData): array {
    $errors = $this->openingHourService->addOpeningHour($openingHourData);

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

  public function deleteOpeningHour(int $openingHourId): array {
    $result = $this->openingHourService->deleteOpeningHour($openingHourId);

    if (isset($result['error']) && $result['error']) {
      return ['errorMessage' => $result['message']];
    }
    return ['success' => true];
  }
}