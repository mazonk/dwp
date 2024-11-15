<?php
include "src/model/entity/OpeningHour.php";
include_once "src/model/repositories/OpeningHourRepository.php";

class OpeningHourService {
  private OpeningHourRepository $openingHourRepository;
  private PDO $db;

  public function __construct() {
    $this->db = $this->getdb();
    $this->openingHourRepository = new OpeningHourRepository($this->db);
  }

  private function getdb(): PDO {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance(); // singleton
  }

  public function getCurrentOpeningHoursById(int $venueId): array {
    try {
      $result = $this->openingHourRepository->getOpeningHoursById($venueId);
      $retArray = [];
      try {
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
    } catch (Exception $e) {
      return ["error"=> true, "message"=> $e->getMessage()];
    }
  }

  public function getOpeningHoursById(int $venueId): array {
    try {
      $result = $this->openingHourRepository->getOpeningHoursById($venueId);
      $retArray = [];
      try {
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
    } catch (Exception $e) {
      return ["error"=> true, "message"=> $e->getMessage()];
    }
  }

  public function addOpeningHour(array $openingHourData, int $venueId): array {
    $errors = [];

    // Validate the form data inputs
    $this->validateFormInputs($openingHourData, $errors);

    // If there are no errors, add the opening hour
    if (count($errors) == 0) {
      $this->db->beginTransaction();
      try {
        $openingHourId = $this->openingHourRepository->addOpeningHour($openingHourData);
        $this->openingHourRepository->addOpeningHourToVenue($openingHourId, $venueId);

        $this->db->commit();
        return ['success' => true];
      } catch (Exception $e) {
        $this->db->rollBack();
        return ['error' => true, 'message' => $e->getMessage()];
      }
    } else {
      // If there are validation errors, return them
      return $errors;
    }
  }

  private function validateFormInputs(array $openingHourData, array &$errors): void {
    // Define regex
    $hourRegex = "/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/";

    // Perform checks
    if (empty($openingHourData['day']) || empty($openingHourData['openingTime']) || empty($openingHourData['closingTime']) || empty($openingHourData['isCurrent'])) {
      $errors['general'] = 'All fields are required.';
    }

    if (!in_array($openingHourData['day'], ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])) {
      $errors['day'] = 'Invalid day.';
    }

    if (!preg_match($regex, $openingHourData['openingTime'])) {
      $errors['openingTime'] = 'Invalid opening time.';
    }

    if (!preg_match($regex, $openingHourData['closingTime'])) {
      $errors['closingTime'] = 'Invalid closing time.';
    }

    if (!in_array($openingHourData['isCurrent'], [0, 1])) {
      $errors['isCurrent'] = 'Invalid current value.';
    }
  }
}