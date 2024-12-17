<?php
include_once "src/model/repositories/AddressRepository.php";
include_once "src/model/services/PostalCodeService.php";
include_once "src/model/entity/Address.php";
include_once "src/model/entity/PostalCode.php";

class AddressService {
  private AddressRepository $addressRepository;
  private PostalCodeService $postalCodeService;
  private PDO $db;

  public function __construct() {
    $this->db = $this->getdb();
    $this->addressRepository = new AddressRepository($this->db);
    $this->postalCodeService = new PostalCodeService();
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
          if ($addressRow['postalCodeId'] == $postalCodeRow['postalCodeId']) {
            $addressArray[] = new Address($addressRow['addressId'], $addressRow['street'], $addressRow['streetNr'], new PostalCode($postalCodeRow['postalCodeId'], $postalCodeRow['postalCode'], $postalCodeRow['city']));
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
      return new Address($result['addressResult']['addressId'], $result['addressResult']['street'], $result['addressResult']['streetNr'], new PostalCode($result['postalCodeResult']['postalCodeId'], $result['postalCodeResult']['postalCode'], $result['postalCodeResult']['city']));
    } catch (Exception $e) {
      return ["error"=> true, "message"=> $e->getMessage()];
    }
  }

  public function editAddress(int $addressId, Address $newAddress): array|Address {
    try {
      $this->addressRepository->updateAddress($addressId, $newAddress->getStreet(), $newAddress->getStreetNr(),
      $newAddress->getPostalCode()->getPostalCodeId(), $newAddress->getPostalCode()->getPostalCode(), $newAddress->getPostalCode()->getCity());
      return $this->getAddressById($addressId);
    } catch (Exception $e) {
      return ["error"=> true, "message"=> $e->getMessage()];
    }
  }

  public function doesAddressExist(array $addressFormData): int|array {
    try {
      $postalCodeId = $this->postalCodeService->doesPostalCodeExist($addressFormData['postalCode']);
      if (is_array($postalCodeId) && isset($postalCodeId['error']) && $postalCodeId['error']) {
        return $postalCodeId;
      }
      return $this->addressRepository->doesAddressExist($addressFormData, $postalCodeId);
    } catch (Exception $e) {
      return ["error"=> true, "message"=> $e->getMessage()];
    }
  }

  public function createAddress(array $addressFormData): int|array {
    $errors = [];
    $this->validateAddressInputs($addressFormData, $errors);

    if (count($errors) == 0) {
      $postalCodeId = $this->postalCodeService->doesPostalCodeExist($addressFormData['postalCode']);

      if (is_array($postalCodeId) && isset($postalCodeId['error']) && $postalCodeId['error']) {
        return $postalCodeId;
      }
      // Postal code exists
      else if ($postalCodeId > 0) {
        try {
          return $this->addressRepository->createAddress($addressFormData, $postalCodeId);
        } catch (Exception $e) {
          return ["error"=> true, "message"=> $e->getMessage()];
        }
      }
      // Postal code does not exist
      else if ($postalCodeId == 0) {
        try {
          $this->db->beginTransaction();
          $newPostalCodeId = $this->postalCodeService->createPostalCode($addressFormData);
          $newAddressId = $this->addressRepository->createAddress($addressFormData, $newPostalCodeId);
          $this->db->commit();

          return $newAddressId;
        } catch (Exception $e) {
          $this->db->rollBack();
          return ["error"=> true, "message"=> $e->getMessage()];
        }
      }
    }
    return $errors;
  }

  private function validateAddressInputs(array $addressFormData, array &$errors): void {
    // Define regexes for validation
    $textRegex = "/^[a-zA-ZáéíóöúüűæøåÆØÅ\s\-']+$/";
    $numberRegex = "/^[0-9]+[a-zA-Z]*$/";

    // Perform checks
    if (empty($addressFormData['street']) || empty($addressFormData['streetNr']) || empty($addressFormData['postalCode']) || empty($addressFormData['city'])) {
      $errors['addressGeneral'] = 'All fields are required';
    }
    if (!preg_match($textRegex, $addressFormData['street'])) {
      $errors['street'] = 'Street must contain only letters, spaces, and hyphens';
    }
    if (strlen($addressFormData['street']) < 2 || strlen($addressFormData['street']) > 100) {
      $errors['street'] = 'Street must be between 2 and 100 characters';
    }
    if (!preg_match($numberRegex, $addressFormData['streetNr'])) {
      $errors['streetNr'] = 'Street number must contain only numbers and letters ex. 471, 12A';
    }
    if (strlen($addressFormData['streetNr']) < 1 || strlen($addressFormData['streetNr']) > 10) {
      $errors['streetNr'] = 'Street number must be between 1 and 10 characters';
    }
    if (strlen($addressFormData['postalCode']) < 4 || strlen($addressFormData['postalCode']) > 11) {
      $errors['postalCode'] = 'Postal code must be between 4 and 11 characters';
    }
    if (!preg_match($textRegex, $addressFormData['city'])) {
      $errors['city'] = 'City must contain only letters, spaces, and hyphens';
    }
    if (strlen($addressFormData['city']) < 2 || strlen($addressFormData['city']) > 50) {
      $errors['city'] = 'City must be between 2 and 50 characters';
    }
  }
}