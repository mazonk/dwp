<?php
include_once "src/model/repositories/AddressRepository.php";
include_once "src/model/entity/Address.php";
include_once "src/model/entity/PostalCode.php";

class AddressService {
  private AddressRepository $addressRepository;

  public function __construct() {
    $this->addressRepository = new AddressRepository();
  }

  /* Get all addresses */
  public function getAllAddresses(): array {
    $result = $this->addressRepository->getAllAddresses();
    if (!empty($result)) {
      $addressArray = [];
      // Create an array of Address objects with the corresponding PostalCode object
      foreach($result['addressResult'] as $addressRow) {
        foreach($result['postalCodeResult'] as $postalCodeRow) {
          if ($addressRow['postalCode'] == $postalCodeRow['postalCode']) {
            $addressArray[] = new Address($addressRow['addressId'], $addressRow['street'], $addressRow['streetNr'], new PostalCode($postalCodeRow['postalCode'], $postalCodeRow['city']));
            break;
          }
        }
      }
      return $addressArray;
    }
    else {
      throw new Exception("No addresses found");
    }
  }

  /* Get address by id */
  public function getAddressById(int $addressId): Address {
    $result = $this->addressRepository->getAddressById($addressId);
    if (!empty($result)) {     
      // Create and return an Address object with the corresponding PostalCode object
      return new Address($result['addressResult']['addressId'], $result['addressResult']['street'], $result['addressResult']['streetNr'], new PostalCode($result['postalCodeResult']['postalCode'], $result['postalCodeResult']['city']));
    }
    else {
      throw new Exception("Address not found");
    }
  }
}