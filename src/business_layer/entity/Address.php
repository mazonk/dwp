<?php
class  Address {
  private int $addressId;
  private string $street;
  private string $streetNr;
  private PostalCode $postalCode;

  public function __construct(int $addressId, string $street, string $streetNr, PostalCode $postalCode) {
    $this->addressId = $addressId;
    $this->street = $street;
    $this->streetNr = $streetNr;
    $this->postalCode = $postalCode;
  }

  public function getAddressId(): int {
    return $this->addressId;
  }

  public function getStreet(): string {
    return $this->street;
  }

  public function getStreetNr(): string {
    return $this->streetNr;
  }

  public function getPostalCode(): PostalCode {
    return $this->postalCode;
  }

  public function setAddressId(int $addressId): void {
    $this->addressId = $addressId;
  }

  public function setStreet(string $street): void {
    $this->street = $street;
  }

  public function setStreetNr(string $streetNr): void {
    $this->streetNr = $streetNr;
  }
}

?>