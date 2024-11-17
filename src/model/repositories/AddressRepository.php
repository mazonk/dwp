<?php
class AddressRepository {
<<<<<<< HEAD
  private PDO $db;

  public function __construct($dbCon) {
    $this->db = $dbCon;
=======
  private function getdb() {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance(); // singleton
>>>>>>> main
  }

  /* Get all addresses */
  public function getAllAddresses(): array {
<<<<<<< HEAD
    $addressQuery = $this->db->prepare("SELECT *  FROM `Address`");
=======
    $db = $this->getdb();
    $addressQuery = $db->prepare("SELECT *  FROM `Address`");
>>>>>>> main
    // Get all addresses
    try {
      $addressQuery->execute();
      $addressResult = $addressQuery->fetchAll(PDO::FETCH_ASSOC);
      if (empty($addressResult)) {
        throw new Exception("No addresses found");
      }
      else {
<<<<<<< HEAD
        $postalCodeQuery = $this->db->prepare("SELECT * FROM PostalCode");
=======
        $postalCodeQuery = $db->prepare("SELECT * FROM PostalCode");
>>>>>>> main
        // Get all postal codes
        try {
          $postalCodeQuery->execute();
          $postalCodeResult = $postalCodeQuery->fetchAll(PDO::FETCH_ASSOC);
          if (empty($postalCodeResult)) {
            throw new Exception("No postal codes found");
          }
          // Return both address and postal code results in an associative array
          return [
            'addressResult' => $addressResult,
            'postalCodeResult' => $postalCodeResult
          ];
        }
        catch (PDOException $e) {
          throw new Exception("Unable to fetch postal codes");
        }
      }
    } catch (PDOException $e) {
        throw new Exception("Unable to fetch addresses");
    }
  }

  /* Get address by id */
  public function getAddressById(int $addressId): array { 
<<<<<<< HEAD
    $query = $this->db->prepare("SELECT * FROM `Address` WHERE addressId = :addressId");
=======
    $db = $this->getdb();
    $query = $db->prepare("SELECT * FROM `Address` WHERE addressId = :addressId");
>>>>>>> main
    // Get address by id
    try {
      $query->execute(['addressId' => htmlspecialchars($addressId)]);
      $addressResult = $query->fetch(PDO::FETCH_ASSOC);
      if (empty($addressResult)) {
        throw new Exception("Address not found");
      }
      else {
<<<<<<< HEAD
        $postalCodeQuery = $this->db->prepare("SELECT * FROM PostalCode WHERE postalCodeId = :postalCodeId");
        // Get postal code by postal code
        try {
          $postalCodeQuery->execute(['postalCodeId' => htmlspecialchars($addressResult['postalCodeId'])]);
=======
        $postalCodeQuery = $db->prepare("SELECT * FROM PostalCode WHERE postalCode = :postalCode");
        // Get postal code by postal code
        try {
          $postalCodeQuery->execute(['postalCode' => htmlspecialchars($addressResult['postalCode'])]);
>>>>>>> main
          $postalCodeResult = $postalCodeQuery->fetch(PDO::FETCH_ASSOC);
          if (empty($postalCodeResult)) {
            throw new Exception("Postal code not found");
          }
          // Return both address and postal code results in an associative array
          return [
            'addressResult' => $addressResult,
            'postalCodeResult' => $postalCodeResult
          ];
        }
        catch (PDOException $e) {
          throw new Exception("Unable to fetch postal code");
        }
      }
    } catch (PDOException $e) {
      throw new Exception("Unable to fetch address");
    }
  }
<<<<<<< HEAD

  /* Update address */
public function updateAddress(int $addressId, string $street, string $streetNr, int $postalCodeId, int $postalCode, string $city): void {
  try {
    $addressQuery = $this->db->prepare("UPDATE `Address` SET street = :street, streetNr = :streetNr WHERE addressId = :addressId");
    $addressQuery->execute([
      'street' => htmlspecialchars($street),
      'streetNr' => htmlspecialchars($streetNr),
      'addressId' => htmlspecialchars($addressId),
    ]);
    $postalCodeQuery = $this->db->prepare("UPDATE `PostalCode` SET postalCode = :postalCode, city = :city WHERE postalCodeId = :postalCodeId");
    $postalCodeQuery->execute([
      'postalCode' => htmlspecialchars($postalCode),
      'city' => htmlspecialchars($city),
      'postalCodeId' => htmlspecialchars($postalCodeId)
    ]);
  } catch (PDOException $e) {
    throw new PDOException("Unable to update address and postal code!");
  }
}

=======
>>>>>>> main
}