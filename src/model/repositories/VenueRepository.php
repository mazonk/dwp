<?php
class VenueRepository {
  private function getdb(): PDO {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance(); // singleton
  }

  /* Get all venues */
  public function getAllVenues(): array {
    $db = $this->getdb();
    $query = $db->prepare("SELECT * FROM Venue");
    // Get all venues
    try {
      $query->execute();
      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      if (empty($result)) {
        throw new Exception("No venues found");
      } 
      return $result;
    } catch (PDOException $e) {
      throw new Exception("Unable to fetch venues: ". $e);
    }
  }

  /* Get the venue by venueId */
  public function getVenue(int $venueId): array {
    $db = $this->getdb();
    $query = $db->prepare("SELECT * FROM Venue WHERE venueId = :venueId");
    // Get venue by venueId
    try {
      $query->execute(['venueId' => htmlspecialchars($venueId)]);
      $result = $query->fetch(PDO::FETCH_ASSOC);
      if (empty($result)) {
        throw new Exception("Venue not found");
      }
      return $result;
    } catch (PDOException $e) {
      throw new Exception("Unable to fetch venue: ". $e);
    }
  }
}