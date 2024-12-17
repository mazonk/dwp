<?php
require_once "src/model/repositories/PostalCodeRepository.php";

class PostalCodeService {
  private PostalCodeRepository $postalCodeRepository;

  public function __construct() {
    $this->postalCodeRepository = new PostalCodeRepository();
  }

  public function doesPostalCodeExist(int $postalCode): int|array {
    try {
      return $this->postalCodeRepository->doesPostalCodeExist($postalCode);
    } catch (Exception $e) {
      return ["error"=> true, "message"=> $e->getMessage()];
    }
  }

  public function createPostalCode(array $addressFormData): int|array {
    try {
      return $this->postalCodeRepository->createPostalCode($addressFormData);
    } catch (Exception $e) {
      return ["error"=> true, "message"=> $e->getMessage()];
    }
  }
}