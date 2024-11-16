<?php
class OpeningHourRepository {
  private PDO $db;

  public function __construct($dbCon) {
    $this->db = $dbCon;
  }

  public function getOpeningHoursById(int $venueId): array {
    $query = $this->db->prepare("SELECT o.*
            FROM OpeningHour o
            JOIN VenueOpeningHour vo ON o.openingHourId = vo.openingHourId
            WHERE vo.venueId = :venueId");
    try {
      $query->execute(['venueId' => htmlspecialchars($venueId)]);
      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      if (empty($result)) {
        throw new Exception("No opening hours found");
      }
      return $result;
    } catch (PDOException $e) {
      throw new PDOException("Unable to fetch opening hours");
    }
  }
  
  public function addOpeningHour(array $openingHourData): int {
    $query = $this->db->prepare("INSERT INTO OpeningHour (day, openingTime, closingTime, isCurrent) VALUES (:day, :openingTime, :closingTime, :isCurrent)");

    try {
      $query->execute([
        'day' => $openingHourData['day'],
        'openingTime' => $openingHourData['openingTime'],
        'closingTime' => $openingHourData['closingTime'],
        'isCurrent' => $openingHourData['isCurrent']
      ]);

      return $this->db->lastInsertId();
    } catch (PDOException $e) {
      throw new PDOException('Failed to add opening hour');
    }
  }

  public function addOpeningHourToVenue(int $openingHourId, int $venueId): void {
    $query = $this->db->prepare("INSERT INTO VenueOpeningHour (venueId, openingHourId) VALUES (:venueId, :openingHourId)");
    
    try {
      $query->execute([
        'venueId' => $venueId,
        'openingHourId' => $openingHourId
      ]);
    } catch (PDOException $e) {
      throw new PDOException('Failed to add opening hour to venue');
    }
  }

  public function isDuplicateOpeningHour(array $openingHourData, int $venueId): array {
    $openingHourQuery = $this->db->prepare("SELECT openingHourId FROM OpeningHour WHERE day = :day AND openingTime = :openingTime AND closingTime = :closingTime");

    try {
      $openingHourQuery->execute([
        'day' => $openingHourData['day'],
        'openingTime' => $openingHourData['openingTime'],
        'closingTime' => $openingHourData['closingTime']
      ]);
      $openingHourId = $openingHourQuery->fetchColumn();

      // If no openingHourId is found, it means this opening hour is unique
      if (!$openingHourId) {
        return ["isDuplicate" => false];
      }

      // If an openingHourId is found, check if it's linked to the selected venue
      $openingHourToVenueQuery = $this->db->prepare("SELECT COUNT(*) FROM VenueOpeningHour WHERE venueId = :venueId AND openingHourId = :openingHourId");

      try {
        $openingHourToVenueQuery->execute([
          'venueId' => $venueId,
          'openingHourId' => $openingHourId
        ]);
        $openingHourToVenueResult = $openingHourToVenueQuery->fetchColumn();

        if ($openingHourToVenueResult > 0) {
          // If the opening hour is linked to the selected venue
          return ["isDuplicate" => true, "linkedToVenue" => true];
        } else {
          // If the opening hour is not linked to the selected venue
          return ["isDuplicate" => true, "linkedToVenue" => false, "openingHourId" => $openingHourId];
        }
      } catch (PDOException $e) {
        throw new PDOException('Failed to check for duplicate opening hour to venue.');
      }
    } catch (PDOException $e) {
      throw new PDOException('Failed to check for duplicate opening hour.');
    }
  }
}