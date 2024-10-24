<?php
include_once "src/model/repositories/AddressRepository.php";
include_once "src/model/entity/Address.php";
include_once "src/model/entity/PostalCode.php";

class AddressService {
  private AddressRepository $addressRepository;

  public function __construct() {
    $this->addressRepository = new AddressRepository();
  }

  public function getAdrressById(int $addressId): Address {
    $result = $this->addressRepository->getAddressById($addressId);
    if ($result) {
      $postalCodeQuery = $db->prepare("SELECT * FROM PostalCode WHERE postalCode = :postalCode");
      
      new Address($result['addressResult']['addressId'], $result['addressResult']['street'], $result['addressResult']['streetNr'], new PostalCode($result['postalCodeResult']['postalCode'], $result['postalCodeResult']['city']));
    }
    else {
      throw new Exception("Address not found");
    }
  }
}