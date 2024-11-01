<?php
include_once "src/model/repositories/AddressRepository.php";
include_once "src/model/entity/Address.php";
include_once "src/model/entity/PostalCode.php";

class AddressService {
  private AddressRepository $addressRepository;

  public function __construct() {
    $dbCon = $this->getdb();
    $this->addressRepository = new AddressRepository($dbCon);
  }

  private function getdb() {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance(); // singleton
  }

  /* Get all addresses */
  public function getAllAddresses(): array {
    try {
      $result = $this->addressRepository->getAllAddresses();
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
    } catch (Exception $e) {
      return ["error"=> true, "message"=> $e->getMessage()];
    }
  }

  /* Get address by id */
  public function getAddressById(int $addressId): array|Address {
    try {
      $result = $this->addressRepository->getAddressById($addressId);
      // Create and return an Address object with the corresponding PostalCode object
      return new Address($result['addressResult']['addressId'], $result['addressResult']['street'], $result['addressResult']['streetNr'], new PostalCode($result['postalCodeResult']['postalCode'], $result['postalCodeResult']['city']));
    } catch (Exception $e) {
      return ["error"=> true, "message"=> $e->getMessage()];
    }
  }
}