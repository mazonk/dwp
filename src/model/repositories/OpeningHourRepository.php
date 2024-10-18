<?php
include "src/model/entity/OpeningHour.php";
include_once "src/controller/VenueController.php";

class OpeningHourRepository {
  private function getdb() {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance(); // singleton
  }

  /* Get opening hours by venueId */
  public function getOpeningHoursById(int $venueId): ?array {
    $db = $this->getdb();
    $query = $db->prepare("SELECT * FROM OpeningHour WHERE venueId = :venueId");
    $query->bindParam(':venueId', $venueId);

    try {
      $query->execute();
      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      $retArray = [];

      if ($result) {
        $venueController = new VenueController();
        $venue = $venueController->getVenue($venueId);

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
        return null;
      }
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
      return null;
    }
  }
}