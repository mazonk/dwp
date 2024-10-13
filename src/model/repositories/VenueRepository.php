<?php
include "src/model/entity/Venue.php";
include_once "src/controller/AddressController.php";

class VenueRepository {
  private function getdb() {
    include_once "src/model/database/dbcon/dbcon.php";
    return $db;
  }

  public function getAllVenues(): array {
    $db = $this->getdb();
    $query = $db->prepare("SELECT * FROM Venue");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $retArray = [];

    $addressController = new AddressController();
    $allAddresses = $addressController->getAllAddresses();

    foreach($result as $row) {
      /* Find the address object that matches the addressId of the venue */
      foreach($allAddresses as $address) {
        if ($row['addressId'] == $address->getAddressId()) {
          $retArray[] = new Venue($row['venueId'], $row['name'], $row['phoneNr'], $row['contactEmail'], $address);
        }

        break;
      }
    }
    return $retArray;
  }
}