<?php
include_once "src/model/entity/Address.php";
include_once "src/model/entity/PostalCode.php";

class AddressRepository {
  private function getdb() {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance(); // singleton
  }

  /* Get all addresses */
  public function getAllAddresses(): array {
    $db = $this->getdb();
    // Get postal codes
    $postalCodeQuery = $db->prepare("SELECT * FROM PostalCode");
    // Get addresses
    $addressQuery = $db->prepare("SELECT *  FROM `Address`");
    try {
      $postalCodeQuery->execute();
      $postalCodeResult = $postalCodeQuery->fetchAll(PDO::FETCH_ASSOC);
      $addressQuery->execute();
      $addressResult = $addressQuery->fetchAll(PDO::FETCH_ASSOC);

      if (empty($postalCodeResult) || empty($addressResult)) {
        return null;
      }
      else {
        $postalCodeArray = [];
        $addressArray = [];

        foreach($postalCodeResult as $row) {
          $postalCodeArray[] = new PostalCode($row['postalCode'], $row['city']);
        }
    
        foreach($addressResult as $addressRow) {
          // Find the postal code object that matches the postal code of the address
          foreach($postalCodeArray as $postalCodeRow) {
            if ($addressRow['postalCode'] == $postalCodeRow->getPostalCode()) {
              $addressArray[] = new Address($addressRow['addressId'], $addressRow['street'], $addressRow['streetNr'], $postalCodeRow);

              break;
            }
          }
        }
        return $addressArray;
      }
    } catch (PDOException $e) {
      return null;
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