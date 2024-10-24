<?php
include_once "src/model/repositories/AddressRepository.php";
include_once "src/model/entity/Address.php";
include_once "src/model/entity/PostalCode.php";

class AddressService {
  private AddressRepository $addressRepository;

  public function __construct() {
    $this->addressRepository = new AddressRepository();
  }

  public function getAllAddresses(): array {
    $result = $this->addressRepository->getAllAddresses();

    if ($result) {
      $addressArray = [];

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

  public function getAdrressById(int $addressId): Address {
    $result = $this->addressRepository->getAddressById($addressId);

    if ($result) {      
      return new Address($result['addressResult']['addressId'], $result['addressResult']['street'], $result['addressResult']['streetNr'], new PostalCode($result['postalCodeResult']['postalCode'], $result['postalCodeResult']['city']));
    }
    else {
      throw new Exception("Address not found");
    }
  }
}