<?php
include "src/model/entity/OpeningHour.php";
include_once "src/model/repositories/OpeningHourRepository.php";
include_once "src/model/services/VenueService.php";

class OpeningHourService {
  private OpeningHourRepository $openingHourRepository;

  public function __construct() {
    $this->openingHourRepository = new OpeningHourRepository();
    $this->venueService = new VenueService();
  }

  public function getOpeningHours(): array {
    try {
      $result = $this->openingHourRepository->getOpeningHours();
      $retArray = [];
      foreach($result as $row) {
        $day = match ($row['day']) {
          'Monday' => Day::Monday,
          'Tuesday' => Day::Tuesday,
          'Wednesday' => Day::Wednesday,
          'Thursday' => Day::Thursday,
          'Friday' => Day::Friday,
          'Saturday' => Day::Saturday,
          'Sunday' => Day::Sunday,
          default => throw new InvalidArgumentException("Invalid day: " . $row['day'])
        };
        // Convert strings to DateTime objects
        $openingTime = new DateTime($row['openingTime']);
        $closingTime = new DateTime($row['closingTime']);

        $retArray[] = new OpeningHour($row['openingHourId'], $day, $openingTime, $closingTime, $row['isCurrent']);
      }
      return $retArray;
    } catch (Exception $e) {
      return ["error"=> true, "message"=> $e->getMessage()];
    }
  }

  public function getCurrentOpeningHours(): array {
    try {
      $result = $this->openingHourRepository->getOpeningHours();
      $retArray = [];
      foreach($result as $row) {
        if ($row['isCurrent'] == 1) {
          $day = match ($row['day']) {
            'Monday' => Day::Monday,
            'Tuesday' => Day::Tuesday,
            'Wednesday' => Day::Wednesday,
            'Thursday' => Day::Thursday,
            'Friday' => Day::Friday,
            'Saturday' => Day::Saturday,
            'Sunday' => Day::Sunday,
            default => throw new InvalidArgumentException("Invalid day: " . $row['day'])
          };
          // Convert strings to DateTime objects
          $openingTime = new DateTime($row['openingTime']);
          $closingTime = new DateTime($row['closingTime']);

          $retArray[] = new OpeningHour($row['openingHourId'], $day, $openingTime, $closingTime, $row['isCurrent']);
        }
      }
      return $retArray;
    } catch (Exception $e) {
      return ["error"=> true, "message"=> $e->getMessage()];
    }
  }

  public function addOpeningHour(array $openingHourData, int $venueId): array {
    $errors = [];
    $isDuplicate = [];

    $this->validateFormInputs($openingHourData, $venueId, $errors, $isDuplicate);

    // If there are no validation errors, add the opening hour
    if (count($errors) == 0) {
      // If the opening hour already exists and is linked to the venue
      if ($isDuplicate['duplicate'] && $isDuplicate['linkedToVenue']) {
        return ['error' => true, 'message' => 'This opening hour already exists and is linked to the venue.'];
      } 
      // If the opening hour already exists but is not linked to the venue
      else if ($isDuplicate['duplicate'] && !$isDuplicate['linkedToVenue']) {
        $openingHourId = $isDuplicate['openingHourId'];

        try {
          $this->openingHourRepository->addOpeningHourToVenue($openingHourId, $venueId);
          return ['success' => true];
        } catch (Exception $e) {
          return ['error' => true, 'message' => $e->getMessage()];
        }
      } 
      // If the opening hour is unique
      else {
        $this->db->beginTransaction();

        try {
          // If the opening hour is set as the current opening hour, set all other opening hours for the same day to inactive
          if ($openingHourData['isCurrent'] == 1) {
            $this->setActiveOpeningHoursToInactive($openingHourData);
          }
          
          $openingHourId = $this->openingHourRepository->addOpeningHour($openingHourData);
          $this->openingHourRepository->addOpeningHourToVenue($openingHourId, $venueId);

          $this->db->commit();
          return ['success' => true];
        } catch (Exception $e) {
          $this->db->rollBack();
          return ['error' => true, 'message' => $e->getMessage()];
        }
      }
    } else {
      // If there are validation errors, return them
      return $errors;
    }
  }

  private function isDuplicateOpeningHour(array $openingHourData, int $venueId): array {
    try {
      return $this->openingHourRepository->isDuplicateOpeningHour($openingHourData, $venueId);
    } catch (Exception $e) {
      return ["error"=> true, "message"=> $e->getMessage()];
    }
  }

  private function setActiveOpeningHoursToInactive(array $openingHourData): array {
    try {
      $result = $this->openingHourRepository->getActiveOpeningHoursByDay($openingHourData);

      if (!empty($result)) {
        foreach($result as $openingHourId) {
          try {
            $this->openingHourRepository->updateIsCurrent($openingHourId, 0);
          } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
          }
        }
      }
      return ['success' => true];
    } catch (Exception $e) {
      return ['error' => true, 'message' => $e->getMessage()];
    }
  }

  private function validateFormInputs(array $openingHourData, int $venueId, array &$errors, array &$isDuplicate): void {
    // Define regex
    $hourRegex = "/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/";

    // Perform checks
    if (empty($openingHourData['day']) || empty($openingHourData['openingTime']) || empty($openingHourData['closingTime']) || $openingHourData['isCurrent'] === null) {
      $errors['general'] = 'All fields are required.';
    }

    if (!in_array($openingHourData['day'], ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])) {
      $errors['day'] = 'Invalid day.';
    }

    if (!preg_match($hourRegex, $openingHourData['openingTime'])) {
      $errors['openingTime'] = 'Invalid opening time.';
    }

    if (!preg_match($hourRegex, $openingHourData['closingTime'])) {
      $errors['closingTime'] = 'Invalid closing time.';
    }

    // Check if closing time is later than opening time
    if (strtotime($openingHourData['openingTime']) >= strtotime($openingHourData['closingTime'])) {
      // If there's already an error for 'closingTime', append the new error message
      $errors['closingTime'] = isset($errors['closingTime']) ? $errors['closingTime'] . ' ' . 'Closing time must be later than opening time.' : 'Closing time must be later than opening time.';
    }

    // Check if venueId exists
    $doesVenueExist = $this->venueService->doesVenueExist($venueId);
    if (isset($doesVenueExist['error']) && $doesVenueExist['error']) {
      $errors['general'] = $doesVenueExist['message'];
    } else if (!$doesVenueExist) {
      $errors['general'] = 'Invalid venue ID.';
    }

    // Check for duplicate opening hour for the same day in the same time range
    $isDuplicate = $this->isDuplicateOpeningHour($openingHourData, $venueId);
    if (isset($isDuplicate['error']) && $isDuplicate['error']) {
      // If there's an error
      $errors['general'] = $isDuplicate['message'];
    } else if (isset($isDuplicate['isDuplicate']) && $isDuplicate['isDuplicate'] && isset($isDuplicate['linkedToVenue']) && $isDuplicate['linkedToVenue']) {
      // If the opening hour already exists and is linked to the venue
      $isDuplicate['duplicate'] = true;
      $isDuplicate['linkedToVenue'] = true;
      $errors['general'] = 'This opening hour already exists and is linked to the venue.';
    } else if (isset($isDuplicate['isDuplicate']) && $isDuplicate['isDuplicate'] && isset($isDuplicate['linkedToVenue']) && !$isDuplicate['linkedToVenue']) {
      // If the opening hour already exists but is not linked to the venue
      $isDuplicate['duplicate'] = true;
      $isDuplicate['linkedToVenue'] = false;
      $isDuplicate['openingHourId'] = $isDuplicate['openingHourId'];
    } else {
      // If the opening hour is unique
      $isDuplicate['duplicate'] = false;
    }

    if (!in_array($openingHourData['isCurrent'], [0, 1])) {
      $errors['isCurrent'] = 'Invalid current value.';
    }
  }
}