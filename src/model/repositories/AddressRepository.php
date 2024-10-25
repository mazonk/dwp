<?php
class AddressRepository {
  private function getdb() {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance(); // singleton
  }

  /* Get all addresses */
  public function getAllAddresses(): array {
    $db = $this->getdb();
    $addressQuery = $db->prepare("SELECT *  FROM `Addresss`");
    // Get all addresses
    try {
      $addressQuery->execute();
      $addressResult = $addressQuery->fetchAll(PDO::FETCH_ASSOC);
      if (empty($addressResult)) {
        throw new Exception("No addresses found");
      }
      else {
        $postalCodeQuery = $db->prepare("SELECT * FROM PostalCode");
        // Get all postal codes
        try {
          $postalCodeQuery->execute();
          $postalCodeResult = $postalCodeQuery->fetchAll(PDO::FETCH_ASSOC);
          if (empty($postalCodeResult)) {
            throw new Exception("No postal codes found");
          }
          // Return both address and postal code results in an associative array
          return [
            'addressResult' => $addressResult,
            'postalCodeResult' => $postalCodeResult
          ];
        }
        catch (PDOException $e) {
          throw new Exception("Unable to fetch postal codes");
        }
      }
    } catch (PDOException $e) {
        throw new Exception("Unable to fetch addresses");
    }
  }

  /* Get address by id */
  public function getAddressById(int $addressId): array { 
    $db = $this->getdb();
    $query = $db->prepare("SELECT * FROM `Address` WHERE addressId = :addressId");
    // Get address by id
    try {
      $query->execute(['addressId' => htmlspecialchars($addressId)]);
      $addressResult = $query->fetch(PDO::FETCH_ASSOC);
      if (empty($addressResult)) {
        throw new Exception("Address not found");
      }
      else {
        $postalCodeQuery = $db->prepare("SELECT * FROM PostalCode WHERE postalCode = :postalCode");
        // Get postal code by postal code
        try {
          $postalCodeQuery->execute(['postalCode' => htmlspecialchars($addressResult['postalCode'])]);
          $postalCodeResult = $postalCodeQuery->fetch(PDO::FETCH_ASSOC);
          if (empty($postalCodeResult)) {
            throw new Exception("Postal code not found");
          }
          // Return both address and postal code results in an associative array
          return [
            'addressResult' => $addressResult,
            'postalCodeResult' => $postalCodeResult
          ];
        }
        catch (PDOException $e) {
          throw new Exception("Unable to fetch postal code");
        }
      }
    } catch (PDOException $e) {
      throw new Exception("Unable to fetch address");
    }
  }
}