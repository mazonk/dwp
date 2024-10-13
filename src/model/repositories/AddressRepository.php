<?php
include "src/model/entity/Address.php";
include "src/model/entity/PostalCode.php";

class AddressRepository {
  private function getdb() {
    include "src/model/database/dbcon/dbcon.php";
    return $db;
  }

  public function getAllAddresses(): array {
    $db = $this->getdb();
    /* Get postal codes */
    $postalCodeQuery = $db->prepare("SELECT * FROM PostalCode");
    $postalCodeQuery->execute();
    $postalCodeResult = $postalCodeQuery->fetchAll(PDO::FETCH_ASSOC);
    $postalCodeArray = [];

    /* Get addresses */
    $addressQuery = $db->prepare("SELECT *  FROM `Address`");
    $addressQuery->execute();
    $addressResult = $addressQuery->fetchAll(PDO::FETCH_ASSOC);
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
}