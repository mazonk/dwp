<?php
class PostalCode {
  private int $postalCode;
  private string $city;

  public function __construct(int $postalCode, string $city) {
    $this->postalCode = $postalCode;
    $this->city = $city;
  }

  public function getPostalCode(): int {
    return $this->postalCode;
  }

  public function getCity(): string {
    return $this->city;
  }

  public function setPostalCode(int $postalCode): void {
    $this->postalCode = $postalCode;
  }

  public function setCity(string $city): void {
    $this->city = $city;
  }
}
?>