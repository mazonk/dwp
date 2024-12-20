<?php
require_once "src/model/entity/OpeningHour.php";
require_once "src/model/repositories/OpeningHourRepository.php";
require_once "src/model/services/VenueService.php";

class OpeningHourService {
  private OpeningHourRepository $openingHourRepository;

  public function __construct() {
    $this->openingHourRepository = new OpeningHourRepository();
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
      // Define the order of the days of the week
      $dayOrder = [
        'Monday' => 0,
        'Tuesday' => 1,
        'Wednesday' => 2,
        'Thursday' => 3,
        'Friday' => 4,
        'Saturday' => 5,
        'Sunday' => 6
      ];

      // Sort the array by day in ascending order
      usort($retArray, function($a, $b) use($dayOrder) {
        return $dayOrder[$a->getDay()] <=> $dayOrder[$b->getDay()];
      });

      return $retArray;
    } catch (Exception $e) {
      return ["error"=> true, "message"=> $e->getMessage()];
    }
  }

  public function getCurrentOpeningHourByDay(string $day): array|OpeningHour {
    try {
      $result = $this->openingHourRepository->getCurrentOpeningHourByDay($day);
      $day = match ($result['day']) {
        'Monday' => Day::Monday,
        'Tuesday' => Day::Tuesday,
        'Wednesday' => Day::Wednesday,
        'Thursday' => Day::Thursday,
        'Friday' => Day::Friday,
        'Saturday' => Day::Saturday,
        'Sunday' => Day::Sunday,
        default => throw new InvalidArgumentException("Invalid day: " . $result['day'])
      };
      // Convert strings to DateTime objects
      $openingTime = new DateTime($result['openingTime']);
      $closingTime = new DateTime($result['closingTime']);

      return new OpeningHour($result['openingHourId'], $day, $openingTime, $closingTime, $result['isCurrent']);
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
      // Define the order of the days of the week
      $dayOrder = [
        'Monday' => 0,
        'Tuesday' => 1,
        'Wednesday' => 2,
        'Thursday' => 3,
        'Friday' => 4,
        'Saturday' => 5,
        'Sunday' => 6
      ];

      // Sort the array by day in ascending order
      usort($retArray, function($a, $b) use($dayOrder) {
        return $dayOrder[$a->getDay()] <=> $dayOrder[$b->getDay()];
      });

      return $retArray;
    } catch (Exception $e) {
      return ["error"=> true, "message"=> $e->getMessage()];
    }
  }

  public function addOpeningHour(array $openingHourData): array {
    $errors = [];

    $this->validateFormInputs($openingHourData, $errors);

    // If there are no validation errors, add the opening hour
    if (count($errors) == 0) {
      // If the opening hour is set as the current opening hour, set all other opening hours for the same day to inactive
      if ($openingHourData['isCurrent'] == 1) {
        $result = $this->setCurrentOpeningHoursToInactive($openingHourData);

        if (isset($result['error']) && $result['error']) {
          return ['error' => true, 'message' => $result['message']];
        }
      }
      
      try {
        $this->openingHourRepository->addOpeningHour($openingHourData);
        return ['success' => true];
      } catch (Exception $e) {
        return ['error' => true, 'message' => $e->getMessage()];
      } 
    } else {
      // If there are validation errors, return them
      return $errors;
    }
  }

  public function editOpeningHour(array $openingHourData): array {
    $errors = [];

    $this->validateFormInputs($openingHourData, $errors);

    // If there are no validation errors, edit the opening hour
    if (count($errors) == 0) {
      // If the opening hour is set as the current opening hour, set all the other opening hours for the same day to inactive
      if ($openingHourData['isCurrent'] == 1) {
        $result = $this->setCurrentOpeningHoursToInactive($openingHourData);

        if (isset($result['error']) && $result['error']) {
          return ['error' => true, 'message' => $result['message']];
        }
      }

      try {
        $this->openingHourRepository->editOpeningHour($openingHourData);
        return ['success' => true];
      } catch (Exception $e) {
        return ['error' => true, 'message' => $e->getMessage()];
      }
    } else {
      // If there are validation errors, return them
      return $errors;
    }
  }

  public function deleteOpeningHour(int $openingHourId): array {
    try {
      $this->openingHourRepository->deleteOpeningHour($openingHourId);
      return ['success' => true];
    } catch (Exception $e) {
      return ['error' => true, 'message' => $e->getMessage()];
    }
  }

  private function isOpeningHourDuplicate(array $openingHourData): array {
    try {
      return $this->openingHourRepository->isOpeningHourDuplicate($openingHourData);
    } catch (Exception $e) {
      return ["error"=> true, "message"=> $e->getMessage()];
    }
  }

  private function setCurrentOpeningHoursToInactive(array $openingHourData): array {
    try {
      $result = $this->openingHourRepository->getCurrentOpeningHoursIdByDay($openingHourData);

      if (!empty($result)) {
        foreach($result as $openingHourId) {
          try {
            $this->openingHourRepository->updateIsCurrentById($openingHourId, false);
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

  private function validateFormInputs(array $openingHourData, array &$errors): void {
    // Define regex
    $hourRegex = "/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/";

    // Perform checks
    if (empty($openingHourData['day']) || empty($openingHourData['openingTime']) || empty($openingHourData['closingTime']) || $openingHourData['isCurrent'] === null || $openingHourData['isCurrent'] === '') {
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

    // Check for duplicate opening hour for the same day at the same time range
    $result = $this->isOpeningHourDuplicate($openingHourData);
    
    if (isset($result['error']) && $result['error']) {
      $errors['general'] = $result['message'];
    } else if (isset($result['isDuplicate']) && $result['isDuplicate']) {
      $errors['general'] = 'This opening hour already exists.';
    } 

    if (!in_array($openingHourData['isCurrent'], [0, 1])) {
      $errors['isCurrent'] = 'Invalid current value.';
    }
  }
}