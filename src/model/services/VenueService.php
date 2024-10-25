<?php
include_once "src/model/repositories/VenueRepository.php";
include_once "src/model/services/AddressService.php";
include_once "src/model/entity/Venue.php";

class VenueService {
  private VenueRepository $venueRepository;
  private AddressService $addressService;

  public function __construct() {
    $this->venueRepository = new VenueRepository();
    $this->addressService = new AddressService();
  }

  /* Get all venues */
  public function getAllVenues(): array {
    $result = $this->venueRepository->getAllVenues();
    try {
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
        throw new Exception(e->getMessage());
      }
    } catch (Exception $e) {
      throw new Exception(e->getMessage());
    }
  }

  /* Get venue by id */
  public function getVenue(int $venueId): Venue {
    $result = $this->venueRepository->getVenue($venueId);
    try {
      try {
        $address = $this->addressService->getAddressById($result['addressId']);
        // Create and return a Venue object with the corresponding Address object
        return new Venue($result['venueId'], $result['name'], $result['phoneNr'], $result['contactEmail'], $address);
      } catch (Exception $e) {
        throw new Exception(e->getMessage());
      }
    } catch (Exception $e) {
      throw new Exception(e->getMessage());
    }
  }
}