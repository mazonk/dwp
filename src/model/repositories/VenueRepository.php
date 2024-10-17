<?php
include "src/model/entity/Venue.php";
include_once "src/controller/AddressController.php";

class VenueRepository {
  private function getdb(): PDO {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance(); // singleton
  }

  /* Get all venues */
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
      }
    }
    return $retArray;
  }

  /* Get the venue by venueId */
  public function getVenue(int $venueId): ?Venue {
    $db = $this->getdb();
    $query = $db->prepare("SELECT * FROM Venue WHERE venueId = :venueId");
    $query->bindParam(":venueId", $venueId);

    try {
      $query->execute();
      $result = $query->fetch(PDO::FETCH_ASSOC);

      if ($result) {
        $addressController = new AddressController();
        $allAddresses = $addressController->getAllAddresses();

        foreach($allAddresses as $address) {
          if ($result['addressId'] == $address->getAddressId()) {
            return new Venue($result['venueId'], $result['name'], $result['phoneNr'], $result['contactEmail'], $address);
          }
        }
      } else {
        return null;
      }

    } catch (PDOException $e) {
      return null;
    }
  }
}