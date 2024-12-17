<?php
include_once "src/model/services/AddressService.php";

class AddressController {
  private AddressService $addressService;

  public function __construct() {
    $this->addressService = new AddressService();
  }

  /* Get all addresses */
  public function getAllAddresses(): array {
    $addresses = $this->addressService->getAllAddresses();
    if (isset($addresses['error']) && $addresses['error']) {
      return ['errorMessage'=> $addresses['message']];
    }
    return $addresses;
  }

  /* Get address by id */
  public function getAddressById(int $addressId): array|Address {
    $address = $this->addressService->getAddressById($addressId);
    if (is_array($address) && isset($address['error']) && $address['error']) {
      return ['errorMessage'=> $address['message']];
    }
    return $address;
  }

  public function doesAddressExist(array $addressFormData): int|array {
    $address = $this->addressService->doesAddressExist($addressFormData);
    if (is_array($address) && isset($address['error']) && $address['error']) {
      return ['errorMessage'=> $address['message']];
    }
    return $address;
  }

  public function createAddress(array $addressFormData): int|array {
    $address = $this->addressService->createAddress($addressFormData);

    // Error while creating the address
    if (is_array($address) && isset($address['error']) && $address['error']) {
      $_SESSION['paymentErrors'] = ['general' => 'An error occurred. ' . $address['message']];
      $_SESSION['addressFormData'] = $addressFormData;
      return ['errorMessage' => true];
    }
    // Validation error
    else if (is_array($address)) {
      $_SESSION['paymentErrors'] = $address;
      $_SESSION['addressFormData'] = $addressFormData;
      return ['validationError' => true];
    }
    return $address; // Return the address ID
  }
}