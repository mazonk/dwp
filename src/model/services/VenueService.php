<?php
include_once "src/model/repositories/VenueRepository.php";
include_once "src/model/services/AddressService.php";
include_once "src/model/entity/Venue.php";

class VenueService {
  private VenueRepository $venueRepository;
  private AddressService $addressService;
  private PDO $db;

  public function __construct() {
    $this->db = $this->getdb();
    $this->venueRepository = new VenueRepository($this->db);
    $this->addressService = new AddressService();
  }

  private function getdb(): PDO {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance(); // singleton
  }

  /* Get all venues */
  public function getAllVenues(): array {
    try {
      $result = $this->venueRepository->getAllVenues();
      $retArray = [];
      try {
        $allAddresses = $this->addressService->getAllAddresses();
        // Create an array of Venue objects with the corresponding Address object
        foreach($result as $venueRow) {
          foreach($allAddresses as $address) {
            if ($venueRow['addressId'] == $address->getAddressId()) {
              $retArray[] = new Venue($venueRow['venueId'], $venueRow['name'], $venueRow['phoneNr'], $venueRow['contactEmail'], $address);
              break;
            }
          }
        }
        return $retArray;
      } catch (Exception $e) {
        return ["error"=> true, "message"=> $e->getMessage()];
      }
    } catch (Exception $e) {
      return ["error"=> true, "message"=> $e->getMessage()];
    }
  }

  /* Get venue by id */
  public function getVenueById(int $venueId): array|Venue {
    try {
      $result = $this->venueRepository->getVenueById($venueId);
      try {
        $address = $this->addressService->getAddressById($result['addressId']);
        // Create and return a Venue object with the corresponding Address object
        return new Venue($result['venueId'], $result['name'], $result['phoneNr'], $result['contactEmail'], $address);
      } catch (Exception $e) {
        return ["error"=> true, "message"=> $e->getMessage()];
      }
    } catch (Exception $e) {
      return ["error"=> true, "message"=> $e->getMessage()];
    }
  }

  public function editVenue(int $venueId, array $newVenueData): array|Venue {
    $this->db->beginTransaction();
    try {
        $newAddress = new Address($newVenueData['addressId'], $newVenueData['street'], $newVenueData['streetNr'], 
        new PostalCode($newVenueData['postalCodeId'], $newVenueData['postalCode'], $newVenueData['city']));
        $this->addressService->editAddress($newVenueData['addressId'], $newAddress);
        $this->venueRepository->editVenue($venueId, $newVenueData['name'], $newVenueData['phoneNr'], $newVenueData['email']);
      $this->db->commit();
      return $this->getVenueById($venueId);
    } catch (Exception $e) {
      $this->db->rollBack();
      return ["error"=> true, "message"=> $e->getMessage()];
    }
  }
}