<?php
include_once "src/model/repositories/AddressRepository.php";

class AddressController {
  private AddressRepository $addressRepository;

  public function __construct() {
    $this->addressRepository = new AddressRepository();
  }

  public function getAllAddresses(): array {
    return $this->addressRepository->getAllAddresses();
  }
}