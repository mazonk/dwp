<?php
class PostalCode {
  private int $postalCodeId;
  private string $city;

  public function __construct(int $postalCodeId, string $city) {
    $this->postalCodeId = $postalCodeId;
    $this->city = $city;
  }

  public function getPostalCodeId(): int {
    return $this->postalCodeId;
  }

  public function getCity(): string {
    return $this->city;
  }

  public function setPostalCodeId(int $postalCodeId): void {
    $this->postalCodeId = $postalCodeId;
  }

  public function setCity(string $city): void {
    $this->city = $city;
  }
}
?>