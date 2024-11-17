<?php
class VenueRepository {
<<<<<<< HEAD
  private PDO $db;
  public function __construct($dbCon) {
    $this->db = $dbCon;
  }
  /* Get all venues */
  public function getAllVenues(): array {
    $query = $this->db->prepare("SELECT * FROM Venue");
=======
  private function getdb(): PDO {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance(); // singleton
  }

  /* Get all venues */
  public function getAllVenues(): array {
    $db = $this->getdb();
    $query = $db->prepare("SELECT * FROM Venue");
>>>>>>> main
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
<<<<<<< HEAD
    $query = $this->db->prepare("SELECT * FROM Venue WHERE venueId = :venueId");
=======
    $db = $this->getdb();
    $query = $db->prepare("SELECT * FROM Venue WHERE venueId = :venueId");
>>>>>>> main
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
<<<<<<< HEAD

  public function editVenue(int $venueId, string $name, string $phoneNr, string $contactEmail): void {
    $query = $this->db->prepare("UPDATE Venue SET name = :name, phoneNr = :phoneNr, contactEmail = :contactEmail WHERE venueId = :venueId");
    try {
      $query->execute([
        'name' => htmlspecialchars($name),
        'phoneNr' => htmlspecialchars($phoneNr),
        'contactEmail' => htmlspecialchars($contactEmail),
        'venueId' => $venueId,
      ]);
    } catch (PDOException $e) {
      throw new Exception("Unable to update venue");
    }
  }
=======
>>>>>>> main
}