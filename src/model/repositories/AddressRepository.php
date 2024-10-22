<?php
include_once "src/model/entity/Address.php";
include_once "src/model/entity/PostalCode.php";

class AddressRepository {
  private function getdb() {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance(); // singleton
  }

  public function getAllAddresses(): array {
    $db = $this->getdb();
    /* Get postal codes */
    $postalCodeQuery = $db->prepare("SELECT * FROM PostalCode");
    /* Get addresses */
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
          /* Find the postal code object that matches the postal code of the address */
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

  
  public function getAddressById(int $addressId): ?Address {
    $db = $this->getdb();
    $query = $db->prepare("SELECT * FROM `Address` WHERE addressId = :addressId");
    try {
      $query->execute(['addressId' => htmlspecialchars($addressId)]);
      $result = $query->fetch(PDO::FETCH_ASSOC);
      if ($result === false) {
        return null;
      }
      else {
        $postalCodeQuery = $db->prepare("SELECT * FROM PostalCode WHERE postalCode = :postalCode");
        $postalCodeQuery->execute(['postalCode' => $result['postalCode']]);
        $postalCodeResult = $postalCodeQuery->fetch(PDO::FETCH_ASSOC);
        if ($postalCodeResult === false) {
          return null;
        }
        else {
          return new Address($result['addressId'], $result['street'], $result['streetNr'], new PostalCode($postalCodeResult['postalCode'], $postalCodeResult['city']));
        }
      }
    } catch (PDOException $e) {
      return null;
    }
  }
}