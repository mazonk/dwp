<?php
class PostalCode {
<<<<<<< HEAD
  private int $postalCodeId;
  private int $postalCode;
  private string $city;

  public function __construct(int $postalCodeId, int $postalCode, string $city) {
    $this->postalCodeId = $postalCodeId;
=======
  private int $postalCode;
  private string $city;

  public function __construct(int $postalCode, string $city) {
>>>>>>> main
    $this->postalCode = $postalCode;
    $this->city = $city;
  }

<<<<<<< HEAD
  public function getPostalCodeId(): int {
    return $this->postalCodeId;
  }

=======
>>>>>>> main
  public function getPostalCode(): int {
    return $this->postalCode;
  }

  public function getCity(): string {
    return $this->city;
  }

<<<<<<< HEAD
  public function setPostalCodeId(int $postalCodeId): void {
    $this->postalCodeId = $postalCodeId;
  }

=======
>>>>>>> main
  public function setPostalCode(int $postalCode): void {
    $this->postalCode = $postalCode;
  }

  public function setCity(string $city): void {
    $this->city = $city;
  }
}
?>