<?php
class AddressRepository {
  private function getdb() {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance(); // singleton
  }

  /* Get all addresses */
  public function getAllAddresses(): array {
    $db = $this->getdb();
    $addressQuery = $db->prepare("SELECT *  FROM `Address`");

    try {
      $addressQuery->execute();
      $addressResult = $addressQuery->fetchAll(PDO::FETCH_ASSOC);

      if (empty($addressResult)) {
        throw new Exception("No addresses found");
      }
      else {
        $postalCodeQuery = $db->prepare("SELECT * FROM PostalCode");

        try {
          $postalCodeQuery->execute();
          $postalCodeResult = $postalCodeQuery->fetchAll(PDO::FETCH_ASSOC);

          if (empty($postalCodeResult)) {
            throw new Exception("No postal codes found");
          }
          return [
            'addressResult' => $addressResult,
            'postalCodeResult' => $postalCodeResult
          ];
        }
        catch (PDOException $e) {
          throw new Exception("Unable to fetch postal codes: ". $e);
        }
      }
    } catch (PDOException $e) {
        throw new Exception("Unable to fetch addresses: ". $e);
    }
  }

  
  public function getAddressById(int $addressId): array { 
    $db = $this->getdb();
    $query = $db->prepare("SELECT * FROM `Address` WHERE addressId = :addressId");

    try {
      $query->execute(['addressId' => htmlspecialchars($addressId)]);
      $addressResult = $query->fetch(PDO::FETCH_ASSOC);

      if (empty($addressResult)) {
        throw new Exception("Address not found");
      }
      else {
        $postalCodeQuery = $db->prepare("SELECT * FROM PostalCode WHERE postalCode = :postalCode");
        
        try {
          $postalCodeQuery->execute(['postalCode' => htmlspecialchars($addressResult['postalCode'])]);
          $postalCodeResult = $postalCodeQuery->fetch(PDO::FETCH_ASSOC);

          if (empty($postalCodeResult)) {
            throw new Exception("Postal code not found");
          }
          return [
            'addressResult' => $addressResult,
            'postalCodeResult' => $postalCodeResult
          ];
        }
        catch (PDOException $e) {
          throw new Exception("Unable to fetch postal code: ". $e);
        }
      }

    } catch (PDOException $e) {
      throw new Exception("Unable to fetch address by id: ". $e);
    }
  }
}