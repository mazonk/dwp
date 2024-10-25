<?php
include_once "src/model/services/AddressService.php";

class AddressController {
  private AddressService $addressService;

  public function __construct() {
    $this->addressService = new AddressService();
  }

  /* Get all addresses */
  public function getAllAddresses(): array {
    try {
      return $this->addressService->getAllAddresses();
    } catch (Exception $e) {
      throw new Exception(e->getMessage());
    }
  }

  /* Get address by id */
  public function getAddressById(int $addressId): Address {
    try {
      return $this->addressService->getAddressById($addressId);
    } catch (Exception $e) {
      throw new Exception(e->getMessage());
    }
  }
}