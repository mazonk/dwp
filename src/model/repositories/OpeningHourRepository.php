<?php
class OpeningHourRepository {
  private function getdb() {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance(); // singleton
  }

  /* Get opening hours by venueId */
  public function getOpeningHoursById(int $venueId): array {
    $db = $this->getdb();
    $query = $db->prepare("SELECT * FROM OpeningHour WHERE venueId = :venueId");
    try {
      $query->execute(['venueId' => htmlspecialchars($venueId)]);
      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      if (empty($result)) {
        throw new Exception("No opening hours found");
      }
      return $result;
    } catch (PDOException $e) {
      throw new Exception("Unable to fetch opening hours");
    }
  }
}