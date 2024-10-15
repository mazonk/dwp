<?php
include "src/model/entity/Address.php";
include "src/model/entity/PostalCode.php";

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
            }
          }
        }
        return $addressArray;
      }
    } catch (PDOException $e) {
      return null;
    }
  }
}