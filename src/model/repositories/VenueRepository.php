<?php
include_once "src/model/entity/Venue.php";
include_once "src/controller/AddressController.php";

class VenueRepository {
  private function getdb(): PDO {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance(); // singleton
  }

  public function getAllVenues(): array {
    $db = $this->getdb();
    $query = $db->prepare("SELECT * FROM Venue");
    try {
      $query->execute();
      $result = $query->fetchAll(PDO::FETCH_ASSOC);

      if (empty($result)) {
        return null;
      }
      else {
        $retArray = [];

        $addressController = new AddressController();
        $allAddresses = $addressController->getAllAddresses();

        foreach($result as $row) {
          /* Find the address object that matches the addressId of the venue */
          foreach($allAddresses as $address) {
            if ($row['addressId'] == $address->getAddressId()) {
              $retArray[] = new Venue($row['venueId'], $row['name'], $row['phoneNr'], $row['contactEmail'], $address);
              break;
            }
          }
        }
        return $retArray;
      }
    } catch (PDOException $e) {
      return null;
    }
  }

  public function getVenueById(int $venueId): ?Venue {
    $db = $this->getdb();
    $query = $db->prepare("SELECT * FROM Venue as v WHERE v.venueId = ?");
    try {
      $query->execute([$venueId]);
      $result = $query->fetch(PDO::FETCH_ASSOC);
      if (empty($result)) {
        return null;
      }
      else {
        $addressController = new AddressController();
        $address = $addressController->getAddressById($result['addressId']);
        return new Venue($result['venueId'], $result['name'], $result['phoneNr'], $result['contactEmail'], $address);
      }
    } catch (PDOException $e) {
      return null;
    }
  }
}