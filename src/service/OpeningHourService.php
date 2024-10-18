<?php
include "src/model/entity/OpeningHour.php";
include_once "src/model/repositories/OpeningHourRepository.php";
include_once "src/model/repositories/VenueRepository.php";

class OpeningHourService {
  private OpeningHourRepository $openingHourRepository;

  public function __construct() {
    $this->openingHourRepository = new OpeningHourRepository();
  }

  public function getOpeningHoursById(int $venueId): array {
    $retArray = [];

    try {
      $result = $this->openingHourRepository->getOpeningHoursById($venueId);

      if ($result) {
        $venueRepository = new VenueRepository();
        $venue = $venueRepository->getVenue($venueId);
        
        foreach($result as $row) {
          if ($row['isCurrent'] == 1) {
            // Map string from DB to Day enum
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

            $retArray[] = new OpeningHour($row['openingHourId'], $day, $openingTime, $closingTime, $row['isCurrent'], $venue);
          }
        }
        return $retArray;
      }
      else {
        return $retArray;
      }
    } catch (Exception $e) {
        echo $e->getMessage();
        return $retArray;
    }
  }
}