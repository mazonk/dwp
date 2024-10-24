<?php
include_once "src/model/services/AddressService.php";

class AddressController {
  private AddressService $addressService;

  public function __construct() {
    $this->addressRepository = new AddressRepository();
  }

  /* Get all addresses */
  /* public function getAllAddresses(): array {
    try {
      return $this->addressRepository->getAllAddresses();
    } catch (Exception $e) {
      return [];
    }
  } */

  /* Get address by id */
  public function getAddressById(int $addressId): Address {
    try {
      return $this->addressRepository->getAddressById($addressId);
    } catch (Exception $e) {
      throw new Exception("Address not found");
    }
  }
}