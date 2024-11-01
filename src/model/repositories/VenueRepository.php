<?php
class VenueRepository {
  private PDO $db;
  public function __construct($dbCon) {
    $this->db = $dbCon;
  }
  /* Get all venues */
  public function getAllVenues(): array {
    $query = $this->db->prepare("SELECT * FROM Venue");
    // Get all venues
    try {
      $query->execute();
      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      if (empty($result)) {
        throw new Exception("No venues found");
      } 
      return $result;
    } catch (PDOException $e) {
      throw new Exception("Unable to fetch venues");
    }
  }

  /* Get the venue by venueId */
  public function getVenueById(int $venueId): array {
    $query = $this->db->prepare("SELECT * FROM Venue WHERE venueId = :venueId");
    // Get venue by venueId
    try {
      $query->execute(['venueId' => htmlspecialchars($venueId)]);
      $result = $query->fetch(PDO::FETCH_ASSOC);
      if (empty($result)) {
        throw new Exception("Venue not found");
      }
      return $result;
    } catch (PDOException $e) {
      throw new Exception("Unable to fetch venue");
    }
  }
}