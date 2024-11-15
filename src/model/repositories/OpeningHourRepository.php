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
}