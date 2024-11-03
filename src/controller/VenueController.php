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

  public function editVenue(int $venueId, array $newVenueData): array|Venue {
    // Validate input data
    $validationErrors = $this->validateInputs($newVenueData);
    if (!empty($validationErrors)) {
        return ['errorMessage' => implode(', ', $validationErrors)];
    }

    // Proceed with the service call if validation passes
    $venue = $this->venueService->editVenue($venueId, $newVenueData);
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

  private function validateInputs(array $data): array {
    $errors = [];

    if (empty($data['name'] || empty($data['phone']) || empty($data['email']) || empty($data['street']) || empty($data['streetNr']) || empty($data['postalCode']) || empty($data['city']))) {
      $errors[] = 'All fields are required.';
    }

    
    if (strlen($data['name']) > 100) {
        $errors[] = 'Venue name must not be longer than 100 characters.';
    }

    if (strlen($data['phoneNr']) > 20) {
        $errors[] = 'Phone number must not be longer than 20 characters.';
    }

    if (strlen($data['email']) > 100) {
        $errors[] = 'Contact email must not be longer than 100 characters.';
    }

    if (strlen($data['street']) > 100) {
        $errors[] = 'Street must not be longer than 100 characters.';
    }

    if (strlen($data['streetNr']) > 10) {
        $errors[] = 'Street number must not be longer than 10 characters.';
    }
    
    if (strlen($data['city']) > 50) {
        $errors[] = 'City must not be longer than 50 characters.';
    }

    if (empty($data['name']) || strlen($data['name']) < 2) {
        $errors[] = 'Venue name must be at least 2 characters long.';
    }

    if (empty($data['phoneNr']) || !preg_match('/^\+?[0-9\s\-]+$/', $data['phoneNr'])) {
        $errors[] = 'Invalid phone number format.';
    }

    if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $data['email'])) {
      $errors['email'] = "Invalid email format.";
    }

    if (empty($data['street']) || strlen($data['street']) < 2) {
        $errors[] = 'Street must be at least 2 characters long.';
    }

    if (empty($data['streetNr']) || !is_numeric($data['streetNr'])) {
        $errors[] = 'Street number must be a valid number.';
    }

    if (empty($data['postalCode']) || !is_numeric($data['postalCode']) || strlen((string)$data['postalCode']) < 4) {
        $errors[] = 'Postal code must be a valid number with at least 4 digits.';
    }

    if (empty($data['city']) || strlen($data['city']) < 2) {
        $errors[] = 'City must be at least 2 characters long.';
    }

    return $errors;
  }

}
?>