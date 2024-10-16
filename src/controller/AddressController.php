<?php
include_once "src/model/repositories/AddressRepository.php";

class AddressController {
  private AddressRepository $addressRepository;

  public function __construct() {
    $this->addressRepository = new AddressRepository();
  }

  public function getAllAddresses(): array {
    try {
      return $this->addressRepository->getAllAddresses();
    } catch (Exception $e) {
      return [];
    }
  }

  public function getAddressById(int $addressId) {
    try {
      return $this->addressRepository->getAddressById($addressId);
    } catch (Exception $e) {
      return [];
    }
  }
}