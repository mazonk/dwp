<?php
include "src/model/entity/OpeningHour.php";
include_once "src/model/repositories/OpeningHourRepository.php";
<<<<<<< HEAD

class OpeningHourService {
  private OpeningHourRepository $openingHourRepository;

  public function __construct() {
    $this->openingHourRepository = new OpeningHourRepository();
=======
include_once "src/model/services/VenueService.php";

class OpeningHourService {
  private OpeningHourRepository $openingHourRepository;
  private VenueService $venueService;

  public function __construct() {
    $this->openingHourRepository = new OpeningHourRepository();
    $this->venueService = new VenueService();
>>>>>>> main
  }

  public function getOpeningHoursById(int $venueId): array {
    try {
      $result = $this->openingHourRepository->getOpeningHoursById($venueId);
      $retArray = [];
      try {
<<<<<<< HEAD
=======
        $venue = $this->venueService->getVenueById($venueId);
>>>>>>> main
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

<<<<<<< HEAD
            $retArray[] = new OpeningHour($row['openingHourId'], $day, $openingTime, $closingTime, $row['isCurrent']);
=======
            $retArray[] = new OpeningHour($row['openingHourId'], $day, $openingTime, $closingTime, $row['isCurrent'], $venue);
>>>>>>> main
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
}