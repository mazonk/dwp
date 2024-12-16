<?php
include_once "src/model/database/dbcon/DatabaseConnection.php";

class PostalCodeRepository {
  private function getdb(): PDO {
    return DatabaseConnection::getInstance(); // singleton
  }

  public function doesPostalCodeExist(int $postalCode): int {
    $db = $this->getdb();
    $query = $db->prepare("SELECT postalCodeId FROM `PostalCode` WHERE postalCode = :postalCode");
    try {
      $query->execute(array('postalCode' => $postalCode));
      $result = $query->fetchColumn();
      if ($result === false) {
          return 0;
      } else {
          return $result;
      }
    } catch (PDOException $e) {
      throw new PDOException("Unable to check if postal code exists!");
    }
  }

  public function createPostalCode(array $addressFormData): int {
    $db = $this->getdb();
    $query = $db->prepare("INSERT INTO `PostalCode` (postalCode, city) VALUES (:postalCode, :city)");
    try {
      $query->execute(array(
        'postalCode' => $addressFormData['postalCode'],
        'city' => $addressFormData['city']
      ));
      return $db->lastInsertId();
    } catch (PDOException $e) {
      throw new PDOException("Unable to create postal code!");
    }
  }
} 