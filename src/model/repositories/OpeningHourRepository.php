<?php
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
      return $result = $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
      return null;
    }
  }
}