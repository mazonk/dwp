<?php
class PostalCode {
  private int $postalCodeId;
  private int $postalCode;
  private string $city;

  public function __construct(int $postalCodeId, int $postalCode, string $city) {
    $this->postalCodeId = $postalCodeId;
    $this->postalCode = $postalCode;
    $this->city = $city;
  }

  public function getPostalCodeId(): int {
    return $this->postalCodeId;
  }

  public function getPostalCode(): int {
    return $this->postalCode;
  }

  public function getCity(): string {
    return $this->city;
  }

  public function setPostalCodeId(int $postalCodeId): void {
    $this->postalCodeId = $postalCodeId;
  }

  public function setPostalCode(int $postalCode): void {
    $this->postalCode = $postalCode;
  }

  public function setCity(string $city): void {
    $this->city = $city;
  }
}
?>