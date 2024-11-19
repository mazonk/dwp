<?php
class OpeningHourRepository {

  private function getdb(): PDO {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance();
  }

  public function getOpeningHours(): array {
    $db = $this->getdb();
    $query = $db->prepare("SELECT * FROM OpeningHour");

    try {
      $query->execute();
      $result = $query->fetchAll(PDO::FETCH_ASSOC);

      if (empty($result)) {
        throw new Exception("No opening hours found.");
      }
      return $result;
    } catch (PDOException $e) {
      throw new PDOException("Unable to fetch all opening hours.");
    }
  }

  public function getCurrentOpeningHoursIdByDay(array $openingHourData): array {
    $db = $this->getdb();
    $query = $db->prepare("SELECT openingHourId FROM OpeningHour WHERE day = :day AND isCurrent = 1");

    try {
      $query->execute(array('day' => $openingHourData['day']));
      $result = $query->fetchAll(PDO::FETCH_COLUMN);
      
      return $result;
    } catch (PDOException $e) {
      throw new PDOException("Unable to fetch current opening hours Ids by day.");
    }
  }
  
  public function addOpeningHour(array $openingHourData): void {
    $db = $this->getdb();
    $query = $db->prepare("INSERT INTO OpeningHour (day, openingTime, closingTime, isCurrent) VALUES (:day, :openingTime, :closingTime, :isCurrent)");

    try {
      $query->execute(array(
        'day' => $openingHourData['day'],
        'openingTime' => $openingHourData['openingTime'],
        'closingTime' => $openingHourData['closingTime'],
        'isCurrent' => $openingHourData['isCurrent']
      ));
    } catch (PDOException $e) {
      throw new PDOException('Failed to add opening hour.');
    }
  }

  public function isOpeningHourDuplicate(array $openingHourData): array {
    $db = $this->getdb();
    $query = $db->prepare("SELECT openingHourId FROM OpeningHour WHERE day = :day AND openingTime = :openingTime AND closingTime = :closingTime");

    try {
      $query->execute(array('day' => $openingHourData['day'], 'openingTime' => $openingHourData['openingTime'], 'closingTime' => $openingHourData['closingTime']));
      $openingHourId = $query->fetchColumn();

      // If no openingHourId is found, it means this opening hour is unique
      if (!$openingHourId) {
        return ["isDuplicate" => false];
      } else {
        return ["isDuplicate" => true];
      }
    } catch (PDOException $e) {
      throw new PDOException('Failed to check for duplicate opening hour.');
    }
  }

  public function updateIsCurrentById(int $openingHourId, bool $setToStatus): void {
    $db = $this->getdb();
    $query = $db->prepare("UPDATE OpeningHour SET isCurrent = :isCurrent WHERE openingHourId = :openingHourId");

    try {
      $query->execute(array('isCurrent' => $setToStatus, 'openingHourId' => $openingHourId));
    } catch (PDOException $e) {
      throw new PDOException('Failed to update isCurrent status.');
    }
  }

  public function deleteOpeningHour(int $openingHourId): void {
    $db = $this->getdb();
    $query = $db->prepare("DELETE FROM OpeningHour WHERE openingHourId = :openingHourId");

    try {
      $query->execute(array('openingHourId' => $openingHourId));
    } catch (PDOException $e) {
      throw new PDOException('Failed to delete opening hour.');
    }
  }
}